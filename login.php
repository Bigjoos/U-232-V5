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
require_once (CLASS_DIR . 'page_verify.php');
dbconn();
global $CURUSER;
if (!$CURUSER) {
    get_template();
}
ini_set('session.use_trans_sid', '0');
$stdfoot = '';
if ($INSTALLER09['captcha_on'] === true)
$stdfoot = array(
    /** include js **/
    'js' => array(
           'captcha', 'jquery.simpleCaptcha-0.2'
    )
);

$lang = array_merge(load_language('global') , load_language('login'));
$newpage = new page_verify();
$newpage->create('takelogin');
$left = $total = '';
//== 09 failed logins
function left()
{
    global $INSTALLER09;
    $total = 0;
    $ip = getip();
    $fail = sql_query("SELECT SUM(attempts) FROM failedlogins WHERE ip=" . sqlesc($ip)) or sqlerr(__FILE__, __LINE__);
    list($total) = mysqli_fetch_row($fail);
    $left = $INSTALLER09['failedlogins'] - $total;
    if ($left <= 2) $left = "<span style='color:red'>{$left}</span>";
    else $left = "<span style='color:green'>{$left}</span>";
    return $left;
}
//== End Failed logins
$HTMLOUT ="";
		$HTMLOUT.= "<div class='modal-dialog'><div class='modal-content'>";
	unset($returnto);
if (!empty($_GET["returnto"])) {
    $returnto = htmlsafechars($_GET["returnto"]);
        $HTMLOUT.= "<div class='modal-header'><h2 class='modal-title text-center text-info' id='myModalLabel'><b>{$lang['login_not_logged_in']}</b></h2></div>";
        $HTMLOUT.= "<div class='modal-content text-center'><span class='text-warning'>{$lang['login_error']}</span></div>";
}
        $HTMLOUT.= "<div class='modal-body'>{$lang['login_cookies']}<br />{$lang['login_cookies1']}<br />
		<span class='badge btn btn-default disabled' style='color:#fff'>{$INSTALLER09['failedlogins']}</span>&nbsp;{$lang['login_failed']}<br />{$lang['login_failed_1']}&nbsp;<span class='badge btn btn-default disabled'>".left()."</span>{$lang['login_failed_2']}".(left()>1?"":"s")."&nbsp;{$lang['login_remain']}</div>";
$got_ssl = isset($_SERVER['HTTPS']) && (bool)$_SERVER['HTTPS'] == true ? true : false;
//== click X by Retro
$value = array(
    '...',
    '...',
    '...',
    '...',
    '...',
    '...'
);
$value[rand(1, count($value) - 1) ] = 'X';
$HTMLOUT.= "".($INSTALLER09['captcha_on'] ? "<script>
	  /*<![CDATA[*/
	  $(document).ready(function () {
	  $('#captchalogin').simpleCaptcha();
    });
    /*]]>*/
    </script>" : "")."
    <form class='form-horizontal' role='form' method='post' title='login' action='takelogin.php'>
<div class='input-group input-group-md text-center'><span class='input-group-addon'><i class='fa fa-user'></i></span><input type='text' class='form-control' name='username' placeholder='Username'></div><br />
<div class='input-group input-group-md text-center'><span class='input-group-addon'><i class='fa fa-lock'></i></span><input type='password' class='form-control' name='password' placeholder='Password'></div>
<div class='form-group text-center'><div class='col-sm-10 col-sm-offset-1'><u class='text-success'><b>{$lang['login_use_ssl']}</b></u><br />
<label>{$lang['login_ssl1']}&nbsp;<input type='checkbox' name='use_ssl' " . ($got_ssl ? "checked='checked'" : "disabled='disabled' title='SSL connection not available'") . " value='1' id='ssl'/></label><br />
<label class='text-left' for='ssl2'>{$lang['login_ssl2']}&nbsp;<input type='checkbox' name='perm_ssl' " . ($got_ssl ? "" : "disabled='disabled' title='SSL connection not available'") . " value='1' id='ssl2'/></label>
</div></div>".($INSTALLER09['captcha_on'] ? "<div class='form-group text-center'><div class='col-sm-10 col-sm-offset-1' id='captchalogin'></div></div>" : "") . "
<div class='form-group text-center'><div class='col-sm-10 col-sm-offset-1'>{$lang['login_click']}&nbsp;<strong>{$lang['login_x']}</strong>&nbsp;</div></div>
<div class='form-group text-center'><div class='col-sm-10 col-sm-offset-1'>";
for ($i = 0; $i < count($value); $i++) {
    $HTMLOUT.= "<span>&nbsp;<input name=\"submitme\" type=\"submit\" value=\"{$value[$i]}\" class=\"btn btn-small btn-primary\">&nbsp;</span>";
}
if (isset($returnto)) $HTMLOUT.= "<input type='hidden' name='returnto' value='" . htmlsafechars($returnto) . "'>\n";
$HTMLOUT.= "</div></div>
<div class='form-group text-center'>
<div class='col-sm-10  col-sm-offset-1'>
<a href='signup.php'><span class='btn btn-primary text-center'>{$lang['login_signup']}</span></a>&nbsp;&nbsp;
<a href='resetpw.php'><span class='btn btn-primary text-center'>{$lang['login_forgot']}</span></a>&nbsp;&nbsp;
<a href='recover.php'><span class='btn btn-primary text-center'>{$lang['login_forgot_1']}</span></a>
</div></div></form>";
$HTMLOUT.="</div></div>
 ";
echo stdhead("{$lang['login_login_btn']}", true) . $HTMLOUT . stdfoot($stdfoot);
?>
