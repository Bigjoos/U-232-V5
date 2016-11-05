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
$lang = array_merge($lang, load_language('ad_adduser'));
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $insert = array(
        'username' => '',
        'email' => '',
        'secret' => '',
        'passhash' => '',
        'status' => 'confirmed',
        'added' => TIME_NOW,
        'last_access' => TIME_NOW
    );
    if (isset($_POST['username']) && strlen($_POST['username']) >= 5) $insert['username'] = $_POST['username'];
    else stderr($lang['std_err'], $lang['err_username']);
    if (isset($_POST['password']) && isset($_POST['password2']) && strlen($_POST['password']) > 6 && $_POST['password'] == $_POST['password2']) {
        $insert['secret'] = mksecret();
        $insert['passhash'] = make_passhash($insert['secret'], md5($_POST['password']));
    } else stderr($lang['std_err'], $lang['err_password']);
    if (isset($_POST['email']) && validemail($_POST['email'])) $insert['email'] = htmlsafechars($_POST['email']);
    else stderr($lang['std_err'], $lang['err_email']);
    if (sql_query(sprintf('INSERT INTO users (username, email, secret, passhash, status, added, last_access) VALUES (%s)', join(', ', array_map('sqlesc', $insert))))) {
        $user_id = ((is_null($___mysqli_res = mysqli_insert_id($GLOBALS["___mysqli_ston"]))) ? false : $___mysqli_res);
        stderr($lang['std_success'], sprintf($lang['text_user_added'], $user_id));
    } else {
        if (((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_errno($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_errno()) ? $___mysqli_res : false)) == 1062) {
            $res = sql_query(sprintf('SELECT id FROM users WHERE username = %s', sqlesc($insert['username']))) or sqlerr(__FILE__, __LINE__);
            if (mysqli_num_rows($res)) {
                $arr = mysqli_fetch_assoc($res);
                header(sprintf('refresh:3; url=userdetails.php?id=%d', (int)$arr['id']));
            }
            stderr($lang['std_err'], $lang['err_already_exists']);
        }
        stderr($lang['std_err'], sprintf($lang['err_mysql_err'], ((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false))));
    }
    die;
}
$HTMLOUT = '<div class="row"><div class="col-md-12">
  <h1>' . $lang['std_adduser'] . '</h1><br />
  <form method="post" action="staffpanel.php?tool=adduser&amp;action=adduser">
  <table class="table table-bordered">
  <tr><td class="rowhead">' . $lang['text_username'] . '</td><td><input type="text" name="username" size="40" /></td></tr>
  <tr><td class="rowhead">' . $lang['text_password'] . '</td><td><input type="password" name="password" size="40" /></td></tr>
  <tr><td class="rowhead">' . $lang['text_password2'] . '</td><td><input type="password" name="password2" size="40" /></td></tr>
  <tr><td class="rowhead">' . $lang['text_email'] . '</td><td><input type="text" name="email" size="40" /></td></tr>
  <tr><td colspan="2" align="center"><input type="submit" value="' . $lang['btn_okay'] . '" class="btn" /></td></tr>
  </table>
  </form></div></div>';
echo stdhead($lang['std_adduser']) . $HTMLOUT . stdfoot();
?>
