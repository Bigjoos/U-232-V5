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
if (!defined('IN_INSTALLER09_ADMIN')) {
    $HTMLOUT = '';
    $HTMLOUT.= "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\"
		\"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">
		<html xmlns='http://www.w3.org/1999/xhtml'>
		<head>
		<title>Error!</title>
		</head>
		<body>
	<div style='font-size:33px;color:white;background-color:red;text-align:center;'>Incorrect access<br />You cannot access this file directly.</div>
	</body></html>";
    echo $HTMLOUT;
    exit();
}
require_once (INCL_DIR . 'user_functions.php');
require_once (INCL_DIR . 'password_functions.php');
require_once (CLASS_DIR . 'class_check.php');
$class = get_access(basename($_SERVER['REQUEST_URI']));
class_check($class);
$lang = array_merge($lang, load_language('ad_reset'));
//== Reset Lost Password
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim(htmlsafechars($_POST['username']));
    $uid = (int)$_POST["uid"];
    $secret = mksecret();
    $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $newpassword = "";
    for ($i = 0; $i < 10; $i++) $newpassword.= $chars[mt_rand(0, strlen($chars) - 1) ];
    $passhash = make_passhash($secret, md5($newpassword));
    $postkey = PostKey(array(
        $uid,
        $CURUSER['id']
    ));
    $res = sql_query('UPDATE users SET secret=' . sqlesc($secret) . ', passhash=' . sqlesc($passhash) . ' WHERE username=' . sqlesc($username) . ' AND id=' . sqlesc($uid) . ' AND class<' . $CURUSER['class']) or sqlerr(__file__, __line__);
    $mc1->begin_transaction('MyUser_' . $uid);
    $mc1->update_row(false, array(
        'secret' => $secret,
        'passhash' => $passhash
    ));
    $mc1->commit_transaction($INSTALLER09['expires']['curuser']);
    $mc1->begin_transaction('user' . $uid);
    $mc1->update_row(false, array(
        'secret' => $secret,
        'passhash' => $passhash
    ));
    $mc1->commit_transaction($INSTALLER09['expires']['user_cache']);
    if (mysqli_affected_rows($GLOBALS["___mysqli_ston"]) != 1) stderr($lang['reset_stderr'], $lang['reset_stderr1']);
    if (CheckPostKey(array(
        $uid,
        $CURUSER['id']
    ) , $postkey) == false) stderr($lang['reset_stderr2'], $lang['reset_stderr3']);
    write_log($lang['reset_pwreset'], $lang['reset_pw_log1'] . htmlsafechars($username) . $lang['reset_pw_log2'] . htmlsafechars($CURUSER['username']));
    stderr($lang['reset_pw_success'], '' . $lang['reset_pw_success1'] . ' <b>' . htmlsafechars($username) . '</b>' . $lang['reset_pw_success2'] . '<b>' . htmlsafechars($newpassword) . '</b>.');
}
$HTMLOUT = "";
$HTMLOUT.= "<div class='row'><div class='col-md-12'><h1>{$lang['reset_title']}</h1>
<form method='post' action='staffpanel.php?tool=reset&amp;action=reset'>
<table class='table table-bordered'>
<tr>
<td class='rowhead'>{$lang['reset_id']}</td><td>
<input type='text' name='uid' size='10' /></td></tr>
<tr>
<td class='rowhead'>{$lang['reset_username']}</td><td>
<input size='40' name='username' /></td></tr>
<tr>
<td colspan='2'>
<input type='submit' class='btn' value='reset' />
</td>
</tr>
</table></form></div></div>";
echo stdhead($lang['reset_stdhead']) . $HTMLOUT . stdfoot();
?>
