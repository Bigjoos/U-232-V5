<?php
/**
 |--------------------------------------------------------------------------|
 |   https://github.com/Bigjoos/                                            |
 |--------------------------------------------------------------------------|
 |   Licence Info: WTFPL                                                    |
 |--------------------------------------------------------------------------|
 |   Copyright (C) 2010 U-232 V5                                            |
 |--------------------------------------------------------------------------|
 |   A bittorrent tracker source based on TBDev.net/tbsource/bytemonsoon.   |
 |--------------------------------------------------------------------------|
 |   Project Leaders: Mindless, Autotron, whocares, Swizzles.               |
 |--------------------------------------------------------------------------|
  _   _   _   _   _     _   _   _   _   _   _     _   _   _   _
 / \ / \ / \ / \ / \   / \ / \ / \ / \ / \ / \   / \ / \ / \ / \
( U | - | 2 | 3 | 2 )-( S | o | u | r | c | e )-( C | o | d | e )
 \_/ \_/ \_/ \_/ \_/   \_/ \_/ \_/ \_/ \_/ \_/   \_/ \_/ \_/ \_/
 */
require_once (__DIR__ . DIRECTORY_SEPARATOR . 'include' . DIRECTORY_SEPARATOR . 'bittorrent.php');
require_once (INCL_DIR . 'user_functions.php');
require_once (INCL_DIR . 'password_functions.php');
dbconn();
global $CURUSER;
if ($CURUSER) {
    header("Location: {$INSTALLER09['baseurl']}/index.php");
    exit;
}
ini_set('session.use_trans_sid', '0');
session_start();
get_template();
$lang = array_merge(load_language('global') , load_language('passhint'));
$stdfoot = '';
if ($INSTALLER09['captcha_on'] === true)
$stdfoot = array(
    /** include js **/
    'js' => array(
           'captcha', 'jquery.simpleCaptcha-0.2'
    )
);

$HTMLOUT = '';
$step = (isset($_GET["step"]) ? (int)$_GET["step"] : (isset($_POST["step"]) ? (int)$_POST["step"] : ''));
if ($step == '1') {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (!mkglobal('email' . ($INSTALLER09['captcha_on'] ? ":captchaSelection" : "") . '')) stderr("Oops", "Missing form data - You must fill all fields");
        if ($INSTALLER09['captcha_on']) {
            if (empty($captchaSelection) || $_SESSION['simpleCaptchaAnswer'] != $captchaSelection) {
                stderr("{$lang['stderr_errorhead']}", "{$lang['stderr_error2']}");
                exit();
            }
        }
        if (!validemail($email)) stderr($lang['stderr_errorhead'], $lang['stderr_invalidemail1']);
        $check = sql_query('SELECT id, status, passhint, hintanswer FROM users WHERE email = ' . sqlesc($email)) or sqlerr(__FILE__, __LINE__);
        $assoc = mysqli_fetch_assoc($check) or stderr("{$lang['stderr_errorhead']}", "{$lang['stderr_notfound']}");
        if (empty($assoc['passhint']) || empty($assoc['hintanswer'])) {
            stderr("{$lang['stderr_errorhead']}", "{$lang['stderr_error3']}");
        }
        if ($assoc['status'] != 'confirmed') {
            stderr("{$lang['stderr_errorhead']}", "{$lang['stderr_error4']}");
        } else {
            $HTMLOUT.= "<div class='modal-dialog'><div class='modal-content'>
						<form class='form-horizontal panel inverse' role='form' title='reset_step1' method='post' action='" . $_SERVER['PHP_SELF'] . "?step=2'>
						<div class='modal-header'><h2 class='modal-title text-center text-info' id='myModalLabel'><span style='font-weight: bold;'>{$lang['main_question']}</span></h2></div>";
            $id[1] = '/1/';
            $id[2] = '/2/';
            $id[3] = '/3/';
            $id[4] = '/4/';
            $id[5] = '/5/';
            $id[6] = '/6/';
            $question[1] = "{$lang['main_question1']}";
            $question[2] = "{$lang['main_question2']}";
            $question[3] = "{$lang['main_question3']}";
            $question[4] = "{$lang['main_question4']}";
            $question[5] = "{$lang['main_question5']}";
            $question[6] = "{$lang['main_question6']}";
            $passhint = preg_replace($id, $question, (int)$assoc['passhint']);
            $HTMLOUT.= "<div class='modal-content text-center'><span class='text-warning' style='font-weight: bold;'>{$passhint} ?</span><input class='form-control' type='hidden' name='id' value='" . (int)$assoc['id'] . "' /></div><br />
<div class='form-group'><div class='col-sm-10 col-sm-offset-1'><input type='text' placeholder='{$lang['main_sec_answer']}' class='form-control' name='answer'></div></div>
<div class='form-group'><div class='col-sm-10 col-sm-offset-5'><input type='submit' value='{$lang['main_next']}' class='btn btn-primary'></div></div>
</form></div></div>";
            echo stdhead($lang['main_header']) . $HTMLOUT . stdfoot();
        }
    }
} elseif ($step == '2') {
    if (!mkglobal('id:answer')) die();
    $select = sql_query('SELECT id, username, hintanswer FROM users WHERE id = ' . sqlesc($id)) or sqlerr(__FILE__, __LINE__);
    $fetch = mysqli_fetch_assoc($select);
    if (!$fetch) stderr("{$lang['stderr_errorhead']}", "{$lang['stderr_error5']}");
    if (empty($answer)) stderr("{$lang['stderr_errorhead']}", "{$lang['stderr_error6']}");
    if ($fetch['hintanswer'] != md5($answer)) {
        $ip = getip();
        $useragent = $_SERVER['HTTP_USER_AGENT'];
        $msg = "" . htmlsafechars($fetch['username']) . ", on " . get_date(TIME_NOW, '', 1, 0) . ", {$lang['main_message']}" . "\n\n{$lang['main_message1']} " . $ip . " (" . @gethostbyaddr($ip) . ")" . "\n {$lang['main_message2']} " . $useragent . "\n\n {$lang['main_message3']}\n {$lang['main_message4']}\n";
        $subject = "Failed password reset";
        sql_query('INSERT INTO messages (receiver, msg, subject, added) VALUES (' . sqlesc((int)$fetch['id']) . ', ' . sqlesc($msg) . ', ' . sqlesc($subject) . ', ' . TIME_NOW . ')') or sqlerr(__FILE__, __LINE__);
        stderr("{$lang['stderr_errorhead']}", "{$lang['stderr_error7']}");
    }     else {
                    $sec = mksecret();
                    $sechash =  md5($sec.$fetch['id'].$fetch['hintanswer']);
                    sql_query("UPDATE users SET editsecret = ".sqlesc($sec)." WHERE id = ".sqlesc($id));
                    $mc1->begin_transaction('MyUser_'.$fetch["id"]);
                    $mc1->update_row(false, array('editsecret' => $sec));
                    $mc1->commit_transaction($INSTALLER09['expires']['curuser']);
                    $mc1->begin_transaction('user'.$fetch["id"]);
                    $mc1->update_row(false, array('editsecret' => $sec));
                    $mc1->commit_transaction($INSTALLER09['expires']['user_cache']);
                    $HTMLOUT .= "<div class='modal-dialog'><div class='modal-content'>
<form class='form-horizontal panel inverse' role='form' title='reset_step2' method='post' action='?step=3'>
	<div class='modal-header'><h2 class='modal-title text-center text-info' id='myModalLabel'><span style='font-weight: bold;'>{$lang['main_changepass']}</span></h2></div>
    <div class='form-group'><div class='col-sm-10 col-sm-offset-1'><input type='password' class='form-control' placeholder='{$lang['main_new_pass']}' name='newpass' /></div></div>
    <div class='form-group'><div class='col-sm-10 col-sm-offset-1'><input type='password' class='form-control' placeholder='{$lang['main_new_pass_confirm']}' name='newpassagain' /></div></div>
    <div class='form-group'><div class='col-sm-10 col-sm-offset-5'><input type='submit' value='{$lang['main_changeit']}' class='btn btn-primary'></div></div>
    <input type='hidden' name='id' value='".(int)$fetch['id']."'>
    <input type='hidden' name='hash' value='". $sechash ."'></form></div></div>";

                    echo stdhead($lang['main_header']).$HTMLOUT.stdfoot();
        }
} elseif ($step == '3') {
    if (!mkglobal('id:newpass:newpassagain:hash')) die();
    if (strlen($hash) != 32 || !ctype_xdigit($hash))
    die('access denied');
    $select = sql_query('SELECT id, editsecret, hintanswer FROM users WHERE id = ' . sqlesc($id)) or sqlerr(__FILE__, __LINE__);
    $fetch = mysqli_fetch_assoc($select) or stderr("{$lang['stderr_errorhead']}", "{$lang['stderr_error8']}");
    if (empty($newpass)) stderr("{$lang['stderr_errorhead']}", "{$lang['stderr_error9']}");
    if ($newpass != $newpassagain) stderr("{$lang['stderr_errorhead']}", "{$lang['stderr_error10']}");
    if (strlen($newpass) < 6) stderr("{$lang['stderr_errorhead']}", "{$lang['stderr_error11']}");
    if (strlen($newpass) > 40) stderr("{$lang['stderr_errorhead']}", "{$lang['stderr_error12']}");
    if ($hash != md5($fetch['editsecret'].$fetch['id'].$fetch['hintanswer']))
        die('invalid hash');
    $secret = mksecret();
    $newpassword = make_passhash($secret, md5($newpass));
    sql_query('UPDATE users SET secret = ' . sqlesc($secret) . ', editsecret = "", passhash=' . sqlesc($newpassword) . ' WHERE id = ' . sqlesc($id) . ' AND editsecret = ' . sqlesc($fetch["editsecret"]));
    $mc1->begin_transaction('MyUser_' . $id);
    $mc1->update_row(false, array(
        'secret' => $secret,
        'editsecret' => '',
        'passhash' => $newpassword
    ));
    $mc1->commit_transaction($INSTALLER09['expires']['curuser']);
    $mc1->begin_transaction('user' . $id);
    $mc1->update_row(false, array(
        'secret' => $secret,
        'editsecret' => '',
        'passhash' => $newpassword
    ));
    $mc1->commit_transaction($INSTALLER09['expires']['user_cache']);
    if (!mysqli_affected_rows($GLOBALS["___mysqli_ston"])) stderr("{$lang['stderr_errorhead']}", "{$lang['stderr_error13']}");
    else { 
	header("Refresh:3; url={$INSTALLER09['baseurl']}/login.php");
	stderr("{$lang['stderr_successhead']}", "{$lang['stderr_error14']} <a href='{$INSTALLER09['baseurl']}/login.php' class='altlink'><b>{$lang['stderr_error15']}</b></a> {$lang['stderr_error16']}", FALSE);
	} 
}
	else {
    $HTMLOUT.= "".($INSTALLER09['captcha_on'] ? "<script type='text/javascript'>
	  /*<![CDATA[*/
	  $(document).ready(function () {
	  $('#captchareset').simpleCaptcha();
    });
    /*]]>*/
    </script>" : "")."
<div class='modal-dialog'><div class='modal-content'>
<form class='form-horizontal panel inverse' title='restpw' role='form' method='post' action='" . $_SERVER['PHP_SELF'] . "?step=1'>
<div class='modal-header'><h2 class='modal-title text-center text-info' id='myModalLabel'><span style='font-weight: bold;'>{$lang['main_header']}</span></h2></div>
<div class='form-group'><div class='col-sm-10 col-sm-offset-1'><span class='text-warning' style='font-weight: bold;'>{$lang['main_body']}</span></div></div>
<div class='form-group'><div class='col-sm-10 col-sm-offset-1'><input class='form-control' type='text' placeholder='{$lang['main_email_add']}' name='email'></div></div>
" . ($INSTALLER09['captcha_on'] ? "<div class='form-group'><div class='col-sm-10 col-sm-offset-1' id='captchareset'></div></div>" : "") . "
<div class='form-group'><div class='col-sm-10 col-sm-offset-5'><input type='submit' value='{$lang['main_recover']}' class='btn btn-primary'></div></div>
</form></div></div>";
    echo stdhead($lang['main_header']) . $HTMLOUT . stdfoot($stdfoot);
}
?>

