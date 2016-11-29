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
require_once (INCL_DIR.'user_functions.php');
require_once (CLASS_DIR.'class_check.php');
class_check(UC_STAFF);
$lang = array_merge($lang, load_language('ad_addpre'));
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tid = trim(htmlsafechars($_POST["id"]));
    $time = trim(htmlsafechars($_POST["time"]));
    if (!$tid || !$time) stderr("{$lang['text_error']}", "{$lang['text_please']}");
    $res = sql_query("SELECT * FROM torrents WHERE id=".sqlesc($tid)) or sqlerr(__FILE__, __LINE__);
    if (mysqli_num_rows($res) != 1) stderr("{$lang['text_error']}", "{$lang['text_bad']}");
    $arr = mysqli_fetch_assoc($res);
    $name = $arr['name'];
    $res = sql_query("INSERT INTO releases (releasename, time, releasetime, section) VALUES (".sqlesc($name).", ".sqlesc($time).", ".sqlesc($time).", 'Site add')") or sqlerr(__FILE__, __LINE__);
    
    $mc1->delete_value('torrent_pretime_'.$tid);
    if (mysqli_affected_rows($GLOBALS["___mysqli_ston"]) != 1) stderr("{$lang['text_error']}", "{$lang['text_unable']}");
    stderr("{$lang['stderr_success']}", "{$lang['text_success']}");
}
$HTMLOUT = "
    <h1>{$lang['text_addpre']}</h1>
    <form method='post' action='staffpanel.php?tool=addpre&amp;action=addpre'>
    <table border='1' cellspacing='0' cellpadding='5'>
      <tr>
        <td class='rowhead'>{$lang['table_torrentid']}</td>
        <td><input size='40' name='id' /></td>
      </tr>
      <tr>
        <td class='rowhead'>{$lang['table_pretime']}</td>
        <td><input size='40' name='time' /></td>
      </tr>
      <tr>
        <td colspan='2'><input type='submit' class='btn' value='{$lang['btn_add']}' /></td>
      </tr>
    </table>
    </form>";
echo stdhead("{$lang['stdhead_addpre']}").$HTMLOUT.stdfoot();
?>
?>
