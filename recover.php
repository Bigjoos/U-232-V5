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
// Begin the session
ini_set('session.use_trans_sid', '0');
session_start();
global $CURUSER;
if (!$CURUSER) {
    get_template();
}
$lang = array_merge(load_language('global') , load_language('recover'));
$stdhead = array(
    /** include js **/
    'js' => array(
        'jquery',
        'jquery.simpleCaptcha-0.2'
    )
);
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!mkglobal('email' . ($INSTALLER09['captcha_on'] ? ":captchaSelection" : "") . '')) stderr("Oops", "Missing form data - You must fill all fields");
    if ($INSTALLER09['captcha_on']) {
        if (empty($captchaSelection) || $_SESSION['simpleCaptchaAnswer'] != $captchaSelection) {
            header('Location: recover.php');
            exit();
        }
    }
    $email = trim($_POST["email"]);
    if (!validemail($email)) stderr("{$lang['stderr_errorhead']}", "{$lang['stderr_invalidemail']}");
    $res = sql_query("SELECT * FROM users WHERE email=" . sqlesc($email) . " LIMIT 1") or sqlerr(__FILE__, __LINE__);
    $arr = mysqli_fetch_assoc($res) or stderr("{$lang['stderr_errorhead']}", "{$lang['stderr_notfound']}");
    $sec = mksecret();
    sql_query("UPDATE users SET editsecret=" . sqlesc($sec) . " WHERE id=" . sqlesc($arr["id"])) or sqlerr(__FILE__, __LINE__);
    $mc1->begin_transaction('MyUser_' . $arr["id"]);
    $mc1->update_row(false, array(
        'editsecret' => $sec
    ));
    $mc1->commit_transaction($INSTALLER09['expires']['curuser']);
    $mc1->begin_transaction('user' . $arr["id"]);
    $mc1->update_row(false, array(
        'editsecret' => $sec
    ));
    $mc1->commit_transaction($INSTALLER09['expires']['user_cache']);
    if (!mysqli_affected_rows($GLOBALS["___mysqli_ston"])) stderr("{$lang['stderr_errorhead']}", "{$lang['stderr_dberror']}");
    $hash = md5($sec . $email . $arr["passhash"] . $sec);
    $body = sprintf($lang['email_request'], $email, $_SERVER["REMOTE_ADDR"], $INSTALLER09['baseurl'], $arr["id"], $hash) . $INSTALLER09['site_name'];
    @mail($arr["email"], "{$INSTALLER09['site_name']} {$lang['email_subjreset']}", $body, "From: {$INSTALLER09['site_email']}") or stderr("{$lang['stderr_errorhead']}", "{$lang['stderr_nomail']}");
    stderr($lang['stderr_successhead'], $lang['stderr_confmailsent']);
} elseif ($_GET) {
    $id = 0 + $_GET["id"];
    $md5 = $_GET["secret"];
    if (!$id) die();
    $res = sql_query("SELECT username, email, passhash, editsecret FROM users WHERE id = " . sqlesc($id));
    $arr = mysqli_fetch_assoc($res);
    $email = $arr["email"];
    $sec = $arr['editsecret'];
    if ($md5 != md5($sec . $email . $arr["passhash"] . $sec)) die();
    $newpassword = make_password();
    $sec = mksecret();
    $newpasshash = make_passhash($sec, md5($newpassword));
    sql_query("UPDATE users SET secret=" . sqlesc($sec) . ", editsecret='', passhash=" . sqlesc($newpasshash) . " WHERE id=" . sqlesc($id) . " AND editsecret=" . sqlesc($arr["editsecret"])) or sqlerr(__FILE__, __LINE__);
    $mc1->begin_transaction('MyUser_' . $id);
    $mc1->update_row(false, array(
        'secret' => $sec,
        'editsecret' => '',
        'passhash' => $newpasshash
    ));
    $mc1->commit_transaction($INSTALLER09['expires']['curuser']);
    $mc1->begin_transaction('user' . $id);
    $mc1->update_row(false, array(
        'secret' => $secret,
        'editsecret' => '',
        'passhash' => $newpasshash
    ));
    $mc1->commit_transaction($INSTALLER09['expires']['user_cache']);
    if (!mysqli_affected_rows($GLOBALS["___mysqli_ston"])) stderr("{$lang['stderr_errorhead']}", "{$lang['stderr_noupdate']}");
    $body = sprintf($lang['email_newpass'], $arr["username"], $newpassword, $INSTALLER09['baseurl']) . $INSTALLER09['site_name'];
    @mail($email, "{$INSTALLER09['site_name']} {$lang['email_subject']}", $body, "From: {$INSTALLER09['site_email']}") or stderr($lang['stderr_errorhead'], $lang['stderr_nomail']);
    stderr($lang['stderr_successhead'], sprintf($lang['stderr_mailed'], $email));
} else {
    $HTMLOUT = '';
    $HTMLOUT.= "<script type='text/javascript'>
	  /*<![CDATA[*/
	  $(document).ready(function () {
	  $('#captcharec').simpleCaptcha();
    });
    /*]]>*/
      </script>
<div style='margin-left:24%;width:45%'>
<form class='form-horizontal  panel inverse' role='form' method='post' action='{$_SERVER['PHP_SELF']}'>
<h2>{$lang['recover_unamepass']}</h2>
<p>{$lang['recover_form']}</p>
<div class='form-group'><div class='col-sm-10 col-sm-offset-1'>" . ($INSTALLER09['captcha_on'] ? "</div></div>
<div class='form-group'><div class='col-sm-10 col-sm-offset-1' id='captcharec'></div></div>" : "") . "
<div class='form-group'><div class='col-sm-10 col-sm-offset-1'><input class='form-control' type='text' placeholder='{$lang['recover_regdemail']}' name='email'></div></div>
<div class='form-group'><div class='col-sm-10 col-sm-offset-5'><input type='submit' value='{$lang['recover_btn']}' class='btn btn-default active'></div></div>
</form></div>";
echo stdhead($lang['head_recover'], true, $stdhead) . $HTMLOUT . stdfoot();
}
?>
