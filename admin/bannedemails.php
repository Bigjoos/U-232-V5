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
require_once (INCL_DIR . 'html_functions.php');
require_once (INCL_DIR . 'pager_functions.php');
require_once (CLASS_DIR . 'class_check.php');
$class = get_access(basename($_SERVER['REQUEST_URI']));
class_check($class);
$lang = array_merge($lang, load_language('ad_banemail'));
/* Ban emails by x0r @tbdev.net */
$HTMLOUT = '';
$remove = isset($_GET['remove']) ? (int)$_GET['remove'] : 0;
if (is_valid_id($remove)) {
    sql_query("DELETE FROM bannedemails WHERE id = " . sqlesc($remove)) or sqlerr(__FILE__, __LINE__);
    write_log("{$lang['ad_banemail_log1']} $remove {$lang['ad_banemail_log2']} {$CURUSER['username']}");
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = htmlsafechars(trim($_POST["email"]));
    $comment = htmlsafechars(trim($_POST["comment"]));
    if (!$email || !$comment) stderr("{$lang['ad_banemail_error']}", "{$lang['ad_banemail_missing']}");
    sql_query("INSERT INTO bannedemails (added, addedby, comment, email) VALUES(" . TIME_NOW . ", " . sqlesc($CURUSER['id']) . ", " . sqlesc($comment) . ", " . sqlesc($email) . ")") or sqlerr(__FILE__, __LINE__);
    header("Location: staffpanel.php?tool=bannedemails");
    die;
}
//$HTMLOUT.= begin_frame("{$lang['ad_banemail_add']}", true);

$HTMLOUT.= "<div class='row'><div class='col-md-12'>";

$HTMLOUT.= "<div class='row'><div class='col-md-12 col-push-3'>
<form method=\"post\" action=\"staffpanel.php?tool=bannedemails\">
<table class='table table-bordered'>
<tr><td class='rowhead'>{$lang['ad_banemail_email']}</td>
<td><input type=\"text\" name=\"email\" size=\"40\"/></td></tr>
<tr><td class='rowhead'align='left'>{$lang['ad_banemail_comment']}</td>
<td><input type=\"text\" name=\"comment\" size=\"40\"/></td></tr>
<tr><td colspan='2'>{$lang['ad_banemail_info']}</td></tr>
<tr><td colspan='2' align='center'>
<input type=\"submit\" value=\"{$lang['ad_banemail_ok']}\" class=\"btn\"/></td></tr>
</table></form>\n";
//$HTMLOUT.= end_frame();
$HTMLOUT.= "</div></div>";


$count1 = get_row_count('bannedemails');
$perpage = 15;
$pager = pager($perpage, $count1, 'staffpanel.php?tool=bannedemails&amp;');
$res = sql_query("SELECT b.id, b.added, b.addedby, b.comment, b.email, u.username FROM bannedemails AS b LEFT JOIN users AS u ON b.addedby=u.id ORDER BY added DESC " . $pager['limit']) or sqlerr(__FILE__, __LINE__);

$HTMLOUT.= begin_frame("{$lang['ad_banemail_current']}", true);
//$HTMLOUT.= "<div class='col-md-3>{$lang["ad_banemail_current"]}";

if ($count1 > $perpage) $HTMLOUT.= $pager['pagertop'];
if (mysqli_num_rows($res) == 0) $HTMLOUT.= "<p align='center'><b>{$lang['ad_banemail_nothing']}</b></p>\n";
else {
    $HTMLOUT.= "<table class='table table-bordered'>\n";
    $HTMLOUT.= "<tr><td class='colhead'>{$lang['ad_banemail_add1']}</td><td class='colhead' align='left'>{$lang['ad_banemail_email']}</td>" . "<td class='colhead' align='left'>{$lang['ad_banemail_by']}</td><td class='colhead' align='left'>{$lang['ad_banemail_comment']}</td><td class='colhead'>{$lang['ad_banemail_remove']}</td></tr>\n";
    while ($arr = mysqli_fetch_assoc($res)) {
        $HTMLOUT.= "<tr><td align='left'>" . get_date($arr['added'], '') . "</td>
            <td align='left'>" . htmlsafechars($arr['email']) . "</td>
            <td align='left'><a href='{$INSTALLER09['baseurl']}/userdetails.php?id=" . (int)$arr['addedby'] . "'>" . htmlsafechars($arr['username']) . "</a></td>
            <td align='left'>" . htmlsafechars($arr['comment']) . "</td>
            <td align='left'><a href='staffpanel.php?tool=bannedemails&amp;remove=" . (int)$arr['id'] . "'>{$lang['ad_banemail_remove1']}</a></td></tr>\n";
    }
    $HTMLOUT.= "</table>\n";
}
if ($count1 > $perpage) $HTMLOUT.= $pager['pagerbottom'];
$HTMLOUT.= end_frame();

$HTMLOUT.="</div></div><br>";



echo stdhead("{$lang['ad_banemail_head']}") . $HTMLOUT . stdfoot();
?>
