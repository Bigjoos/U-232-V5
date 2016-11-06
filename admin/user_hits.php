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
require_once INCL_DIR . 'user_functions.php';
require_once INCL_DIR . 'pager_functions.php';
require_once (CLASS_DIR . 'class_check.php');
$class = get_access(basename($_SERVER['REQUEST_URI']));
class_check($class);
$lang = array_merge($lang, load_language('ad_userhits'));
$HTMLOUT = '';
$id = 0 + $_GET["id"];
if (!is_valid_id($id) || $CURUSER['id'] <> $id && $CURUSER['class'] < UC_STAFF) $id = $CURUSER['id'];
$res = sql_query("SELECT COUNT(id) FROM userhits WHERE hitid = " . sqlesc($id)) or sqlerr(__FILE__, __LINE__);
$row = mysqli_fetch_row($res);
$count = $row[0];
$perpage = 15;
$pager = pager($perpage, $count, "staffpanel.php?tool=user_hits&amp;id=$id&amp;");
if (!$count) stderr($lang['userhits_stderr'], $lang['userhits_stderr1']);
$res = sql_query("SELECT username FROM users WHERE id = " . sqlesc($id)) or sqlerr(__FILE__, __LINE__);
$user = mysqli_fetch_assoc($res);
$HTMLOUT.= "<h1>{$lang['userhits_profile']}<a href=\"userdetails.php?id=" . $id . "\">" . htmlsafechars($user['username']) . "</a></h1>
<h2>{$lang['userhits_total']}" . htmlsafechars($count) . "{$lang['userhits_views']}</h2>";
if ($count > $perpage) $HTMLOUT.= $pager['pagertop'];
$HTMLOUT.= "
<table border='0' cellspacing='0' cellpadding='5'>
<tr>
<td class='colhead'>{$lang['userhits_nr']}</td>
<td class='colhead'>{$lang['userhits_username']}</td>
<td class='colhead'>{$lang['userhits_viewed']}</td>
</tr>\n";
$res = sql_query("SELECT uh.*, username, users.id as uid FROM userhits uh LEFT JOIN users ON uh.userid = users.id WHERE hitid =" . sqlesc($id) . " ORDER BY uh.id DESC " . $pager['limit']) or sqlerr(__FILE__, __LINE__);
while ($arr = mysqli_fetch_assoc($res)) {
    $HTMLOUT.= "
<tr><td>" . number_format($arr['number']) . "</td>
<td><b><a href=\"userdetails.php?id=" . (int)$arr['uid'] . "\">" . htmlsafechars($arr['username']) . "</a></b></td>
<td>" . get_date($arr['added'], 'DATE', 0, 1) . "</td>
</tr>\n";
}
$HTMLOUT.= "</table>";
if ($count > $perpage) $HTMLOUT.= $pager['pagerbottom'];
echo stdhead($lang['userhits_profile'] . htmlsafechars($user['username']) . '') . $HTMLOUT . stdfoot();
die();
?>
