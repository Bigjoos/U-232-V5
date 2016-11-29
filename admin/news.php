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
require_once (INCL_DIR . 'bbcode_functions.php');
require_once (CLASS_DIR . 'class_check.php');
$class = get_access(basename($_SERVER['REQUEST_URI']));
class_check($class);
$HTMLOUT = '';
$stdhead = array(
    /** include css **/
    'css' => array(
        'forums',
        'style',
        'style2'
    )
);
$stdfoot = array(
    /** include js **/
    'js' => array(
        'shout',
        'check_selected'
    )
);
$lang = array_merge($lang, load_language('ad_news'));
$possible_modes = array(
    'add',
    'delete',
    'edit',
    'news'
);
$mode = (isset($_GET['mode']) ? htmlsafechars($_GET['mode']) : '');
if (!in_array($mode, $possible_modes)) stderr($lang['news_error'], $lang['news_error_ruffian']);
//==Delete news
if ($mode == 'delete') {
    $newsid = (int)$_GET['newsid'];
    if (!is_valid_id($newsid)) stderr($lang['news_error'], $lang['news_del_invalid']);
    $hash = md5('the@@saltto66??' . $newsid . 'add' . '@##mu55y==');
    $sure = '';
    $sure = (isset($_GET['sure']) ? intval($_GET['sure']) : '');
    if (!$sure) stderr($lang['news_del_confirm'], $lang['news_del_click'] . "<a href='staffpanel.php?tool=news&amp;mode=delete&amp;sure=1&amp;h=$hash&amp;newsid=$newsid'>{$lang['news_del_here']}</a> {$lang['news_del_if']}", false);
    if ($_GET['h'] != $hash) stderr($lang['news_error'], $lang['news_del_what']);
    function deletenewsid($newsid)
    {
        global $CURUSER, $mc1;
        sql_query("DELETE FROM news WHERE id = " . sqlesc($newsid) . " AND userid = " . sqlesc($CURUSER['id'])) or sqlerr(__FILE__, __LINE__);
        $mc1->delete_value('latest_news_');
    }
    $HTMLOUT.= deletenewsid($newsid);
    header("Refresh: 3; url=staffpanel.php?tool=news&mode=news");
    stderr($lang['news_success'], "<h2>{$lang['news_del_redir']}</h2>");
    echo stdhead($lang['news_del_stdhead'], true, $stdhead) . $HTMLOUT . stdfoot();
    die;
}
//==Add news
if ($mode == 'add') {
    $body = isset($_POST['body']) ? htmlsafechars($_POST['body']) : '';
    $sticky = isset($_POST['sticky']) ? htmlsafechars($_POST['sticky']) : 'yes';
    $anonymous = isset($_POST['anonymous']) ? htmlsafechars($_POST['anonymous']) : 'no';
    if (!$body) stderr($lang['news_error'], $lang['news_add_item']);
    $title = htmlsafechars($_POST['title']);
    if (!$title) stderr($lang['news_error'], $lang['news_add_title']);
    $added = isset($_POST["added"]) ? $_POST["added"] : '';
    if (!$added) $added = TIME_NOW;
    sql_query("INSERT INTO news (userid, added, body, title, sticky, anonymous) VALUES (" . sqlesc($CURUSER['id']) . "," . sqlesc($added) . ", " . sqlesc($body) . ", " . sqlesc($title) . ", " . sqlesc($sticky) . ", " . sqlesc($anonymous) . ")") or sqlerr(__FILE__, __LINE__);
    $mc1->delete_value('latest_news_');
    header("Refresh: 3; url=staffpanel.php?tool=news&mode=news");
    mysqli_affected_rows($GLOBALS["___mysqli_ston"]) == 1 ? stderr($lang['news_success'], $lang['news_add_success']) : stderr($lang['news_add_oopss'], $lang['news_add_something']);
}
//==Edit/change news
if ($mode == 'edit') {
    $newsid = (int)$_GET["newsid"];
    if (!is_valid_id($newsid)) stderr($lang['news_error'], $lang['news_edit_invalid']);
    $res = sql_query("SELECT id, body, title, userid, added, anonymous, sticky FROM news WHERE id=" . sqlesc($newsid)) or sqlerr(__FILE__, __LINE__);
    if (mysqli_num_rows($res) != 1) stderr($lang['news_error'], $lang['news_edit_nonews']);
    $arr = mysqli_fetch_assoc($res);
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $body = isset($_POST['body']) ? htmlsafechars($_POST['body']) : '';
        $sticky = isset($_POST['sticky']) ? htmlsafechars($_POST['sticky']) : 'yes';
        $anonymous = isset($_POST['anonymous']) ? htmlsafechars($_POST['anonymous']) : 'no';
        if ($body == "") stderr($lang['news_error'], $lang['news_edit_body']);
        $title = htmlsafechars($_POST['title']);
        if ($title == "") stderr($lang['news_error'], $lang['news_edit_title']);
        sql_query("UPDATE news SET body=" . sqlesc($body) . ", sticky=" . sqlesc($sticky) . ", anonymous=" . sqlesc($anonymous) . ", title=" . sqlesc($title) . " WHERE id=" . sqlesc($newsid)) or sqlerr(__FILE__, __LINE__);
        $mc1->delete_value('latest_news_');
        header("Refresh: 3; url=staffpanel.php?tool=news&mode=news");
        stderr($lang['news_success'], $lang['news_edit_success']);
    } else {
        $HTMLOUT.= "<div class='container'><h1>{$lang['news_edit_item']}</h1>
        <form method='post' name='compose' action='staffpanel.php?tool=news&amp;mode=edit&amp;newsid=$newsid'>
        <table class='table table-bordered table striped'>
        <tr><td><input type='text' name='title' value='" . htmlsafechars($arr['title']) . "' /></td></tr>
        <tr><td align='left' style='padding: 0px'>
        ".textbbcode("compose", "body", htmlsafechars($arr["body"])) . "
        </td></tr>
        <tr><td colspan='2' class='rowhead'>{$lang['news_sticky']}<input type='radio' " . ($arr["sticky"] == "yes" ? " checked='checked'" : "") . " name='sticky' value='yes' />{$lang['news_yes']}<input name='sticky' type='radio' value='no' " . ($arr["sticky"] == "no" ? " checked='checked'" : "") . " />{$lang['news_no']}</td></tr>
        <tr><td colspan='2' class='rowhead'>{$lang['news_anonymous']}<input type='radio' " . ($arr["anonymous"] == "yes" ? " checked='checked'" : "") . " name='anonymous' value='yes' />{$lang['news_yes']}<input name='anonymous' type='radio' value='no' " . ($arr["anonymous"] == "no" ? " checked='checked'" : "") . " />{$lang['news_no']}</td></tr>
        <tr><td colspan='2' align='center'><input type='submit' value='{$lang['news_okay']}' class='btn' /></td></tr>
        </table>
        </form></div>\n";
        echo stdhead($lang['news_stdhead'], true, $stdhead) . $HTMLOUT . stdfoot($stdfoot);
        die;
    }
}
//==Final Actions
if ($mode == 'news') {
    $res = sql_query("SELECT n.id AS newsid, n.body, n.title, n.userid, n.added, n.anonymous, u.id, u.username, u.class, u.warned, u.chatpost, u.pirate, u.king, u.leechwarn, u.enabled, u.donor FROM news AS n LEFT JOIN users AS u ON u.id=n.userid ORDER BY sticky, added DESC") or sqlerr(__FILE__, __LINE__);
    $HTMLOUT.= begin_main_frame();
    $HTMLOUT.= begin_frame();
    $HTMLOUT.= "<div class='container' ><form method='post' name='compose' action='staffpanel.php?tool=news&amp;mode=add'>
    <h1>{$lang['news_submit_new']}</h1><table class='table table-bordered table striped'>
    <tr><td><input type='text' name='title' value='' /></td></tr>\n";
    $HTMLOUT.= "<tr>
    <td align='left' style='padding: 0px'>".textbbcode("compose", "body")."</td></tr>";
    $HTMLOUT.= "<tr><td colspan='2' class='rowhead'>{$lang['news_sticky']}<input type='radio' checked='checked' name='sticky' value='yes' />{$lang['news_yes']}<input name='sticky' type='radio' value='no' />{$lang['news_no']}</td></tr><tr><td colspan='2' class='rowhead'>{$lang['news_anonymous']}<input type='radio' checked='checked' name='anonymous' value='yes' />{$lang['news_yes']}<input name='anonymous' type='radio' value='no' />{$lang['news_no']}</td></tr>\n
    <tr><td colspan='2' class='rowhead'><input type='submit' value='{$lang['news_okay']}' class='btn' /></td></tr>\n
    </table></form></div><br /><br />\n";
    while ($arr = mysqli_fetch_assoc($res)) {
        $newsid = (int)$arr["newsid"];
        $body = $arr["body"];
        $title = $arr["title"];
        $added = get_date($arr["added"], 'LONG', 0, 1);
        $by = "<b>" . format_username($arr) . "</b>";
        $hash = md5('the@@saltto66??' . $newsid . 'add' . '@##mu55y==');
        $HTMLOUT.= "<table border='0' cellspacing='0' cellpadding='0'><tr><td class='embedded'>
        $added{$lang['news_created_by']}{$by}
        - [<a href='staffpanel.php?tool=news&amp;mode=edit&amp;newsid=$newsid'><b>{$lang['news_edit']}</b></a>]
        - [<a href='staffpanel.php?tool=news&amp;mode=delete&amp;newsid=$newsid&amp;sure=1&amp;h=$hash'><b>{$lang['news_delete']}</b></a>]
        </td></tr></table>\n";
        $HTMLOUT.= begin_table(true);
        $HTMLOUT.= "<tr valign='top'><td class='comment'><b>" . htmlsafechars($title) . "</b><br />" . format_comment($body) . "</td></tr>\n";
        $HTMLOUT.= end_table();
        $HTMLOUT.= "<br />";
    }
    $HTMLOUT.= end_frame();
    $HTMLOUT.= end_main_frame();
}
echo stdhead($lang['news_stdhead'], true, $stdhead) . $HTMLOUT . stdfoot($stdfoot);
die;
?>
