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
//== usercomments.php - by pdq - based on comments.php, duh :P
require_once (__DIR__ . DIRECTORY_SEPARATOR . 'include' . DIRECTORY_SEPARATOR . 'bittorrent.php');
require_once (INCL_DIR . 'user_functions.php');
require_once (INCL_DIR . 'bbcode_functions.php');
require_once (INCL_DIR . 'pager_functions.php');
require_once (INCL_DIR . 'html_functions.php');
dbconn(false);
loggedinorreturn();
$lang = array_merge(load_language('global'),load_language('usercomment'));
$HTMLOUT = $user = '';
$action = isset($_GET["action"]) ? htmlsafechars(trim($_GET["action"])) : '';
$stdhead = array(
    /** include css **/
    'css' => array(
        'style',
        'style2',
        'bbcode'
    )
);

if ($action == "add") {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        //print_r($_POST);
        //print_r($_GET);
        //die();
        $userid = 0 + $_POST["userid"];
        if (!is_valid_id($userid)) stderr($lang['gl_error'], $lang['gl_invalid_id']);
        $res = sql_query("SELECT username FROM users WHERE id =" . sqlesc($userid)) or sqlerr(__FILE__, __LINE__);
        $arr = mysqli_fetch_array($res, MYSQLI_NUM);
        if (!$arr) stderr($lang['gl_error'], $lang['usercomment_no_user_with_that_id']);
        $body = isset($_POST['body']) ? htmlsafechars($_POST['body']) : '';
        if (!$body) stderr($lang['gl_error'], $lang['usercomment_comment_body_cannot_be_empty']);
        sql_query("INSERT INTO usercomments (user, userid, added, text, ori_text) VALUES (" . sqlesc($CURUSER['id']) . ", " . sqlesc($userid) . ", '" . TIME_NOW . "', " . sqlesc($body) . "," . sqlesc($body) . ")");
        $newid = ((is_null($___mysqli_res = mysqli_insert_id($GLOBALS["___mysqli_ston"]))) ? false : $___mysqli_res);
        sql_query("UPDATE users SET comments = comments + 1 WHERE id =" . sqlesc($userid));
        header("Refresh: 0; url=userdetails.php?id=$userid&viewcomm=$newid#comm$newid");
        die;
    }
    $userid = 0 + $_GET["userid"];
    if (!is_valid_id($userid)) stderr($lang['gl_error'], $lang['gl_invalid_id']);
    $res = sql_query("SELECT username FROM users WHERE id = " . sqlesc($userid)) or sqlerr(__FILE__, __LINE__);
    $arr = mysqli_fetch_assoc($res);
    if (!$arr) stderr($lang['gl_error'], $lang['usercomment_no_user_with_that_id']);
    $HTMLOUT.= "<h1>{$lang['usercomment_add_a_comment_for']} '" . htmlsafechars($arr["username"]) . "'</h1>
    <form method='post' action='usercomment.php?action=add'>
    <input type='hidden' name='userid' value='$userid' />
    <div>". textbbcode('usercomment', 'body')."</div>
    <br /><br />
    <input type='submit' class='btn' value='{$lang['usercomment_do_it']}' /></form>\n";
    $res = sql_query("SELECT usercomments.id, usercomments.text, usercomments.editedby, usercomments.editedat, usercomments.added, usercomments.edit_name, username, users.id as user, users.avatar, users.title, users.anonymous, users.class, users.donor, users.warned, users.leechwarn, users.chatpost FROM usercomments LEFT JOIN users ON usercomments.user = users.id WHERE user = " . sqlesc($userid) . " ORDER BY usercomments.id DESC LIMIT 5");
    $allrows = array();
    while ($row = mysqli_fetch_assoc($res)) $allrows[] = $row;
    if (count($allrows)) {
        $HTMLOUT.= "<h2>{$lang['usercomment_most_recent_comments_in_reverse_order']}</h2>\n";
        $HTMLOUT.= usercommenttable($allrows);
    }
    echo stdhead("{$lang['usercomment_add_a_comment_for']} \"" . htmlsafechars($arr["username"]) . "\"", true, $stdhead) . $HTMLOUT . stdfoot();
    die;
} elseif ($action == "edit") {
    $commentid = 0 + $_GET["cid"];
    if (!is_valid_id($commentid)) stderr($lang['gl_error'], $lang['gl_invalid_id']);
    $res = sql_query("SELECT c.*, u.username, u.id FROM usercomments AS c LEFT JOIN users AS u ON c.userid = u.id WHERE c.id=" . sqlesc($commentid)) or sqlerr(__FILE__, __LINE__);
    $arr = mysqli_fetch_assoc($res);
    if (!$arr) stderr($lang['gl_error'], $lang['gl_invalid_id']);
    if ($arr["user"] != $CURUSER["id"] && $CURUSER['class'] < UC_STAFF) stderr($lang['gl_error'], "{$lang['usercomment_permission_denied']}");
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $body = htmlsafechars($_POST["body"]);
        $returnto = htmlsafechars($_POST["returnto"]);
        if ($body == "") stderr($lang['gl_error'], $lang['usercomment_comment_body_cannot_be_empty']);
        $editedat = sqlesc(TIME_NOW);
        sql_query("UPDATE usercomments SET text=" . sqlesc($body) . ", editedat={$editedat}, edit_name=".sqlesc($CURUSER['username']).", editedby=" . sqlesc($CURUSER['id']) . " WHERE id=" . sqlesc($commentid)) or sqlerr(__FILE__, __LINE__);
        if ($returnto) header("Location: $returnto");
        else header("Location: {$INSTALLER09['baseurl']}/userdetails.php?id={$userid}");
        die;
    }
    $HTMLOUT.= "<h1>Edit comment for \"" . htmlsafechars($arr["username"]) . "\"</h1>
    <form method='post' action='usercomment.php?action=edit&amp;cid={$commentid}'>
    <input type='hidden' name='returnto' value='{$_SERVER["HTTP_REFERER"]}' />
    <input type=\"hidden\" name=\"cid\" value='" . (int)$commentid . "' />
    ".textbbcode('usercomment', 'body', $arr["text"])."
    <input type='submit' class='btn' value='{$lang['usercomment_do_it']}' /></form>";
    echo stdhead("Edit comment for \"" . htmlsafechars($arr["username"]) . "\"", true, $stdhead) . $HTMLOUT . stdfoot();
    stdfoot();
    die;
} elseif ($action == "delete") {
    $commentid = 0 + $_GET["cid"];
    if (!is_valid_id($commentid)) stderr($lang['gl_error'], $lang['gl_invalid_id']);
    $sure = isset($_GET["sure"]) ? (int)$_GET["sure"] : false;
    if (!$sure) {
        $referer = $_SERVER["HTTP_REFERER"];
        stderr($lang['usercomment_delete_comment'], "{$lang['usercomment_you_are_about_to_delete_a_comment_click']}\n" . "<a href='usercomment.php?action=delete&amp;cid=$commentid&amp;sure=1" . ($referer ? "&amp;returnto=" . urlencode($referer) : "") . "'>{$lang['gl_stdfoot_here']}</a> {$lang['gl_if_you_are_sure']}.");
        //stderr($lang['usercomment_delete_comment'], "{$lang['usercomment_you_are_about_to_delete_a_comment_click']}\n" . "<a href='usercomment.php?action=delete&amp;cid={$commentid}&amp;sure=1&amp;returnto=".urlencode($_SERVER['PHP_SELF'])."'>{$lang['gl_stdfoot_here']}</a> {$lang['gl_if_you_are_sure']}.");
        
    }
    $res = sql_query("SELECT id, userid FROM usercomments WHERE id=" . sqlesc($commentid)) or sqlerr(__FILE__, __LINE__);
    $arr = mysqli_fetch_assoc($res);
    if ($arr['id'] != $CURUSER['id']) {
        if ($CURUSER['class'] < UC_STAFF) stderr($lang['gl_error'], "{$lang['usercomment_permission_denied']}");
    }
    if ($arr) $userid = (int)$arr["userid"];
    sql_query("DELETE FROM usercomments WHERE id=" . sqlesc($commentid)) or sqlerr(__FILE__, __LINE__);
    if ($userid && mysqli_affected_rows($GLOBALS["___mysqli_ston"]) > 0) sql_query("UPDATE users SET comments = comments - 1 WHERE id = " . sqlesc($userid));
    $returnto = htmlsafechars($_GET["returnto"]);
    if ($returnto) header("Location: $returnto");
    else header("Location: {$INSTALLER09['baseurl']}/userdetails.php?id={$userid}");
    die;
} elseif ($action == "vieworiginal") {
    if ($CURUSER['class'] < UC_STAFF) stderr($lang['gl_error'], "{$lang['usercomment_permission_denied']}");
    $commentid = 0 + $_GET["cid"];
    if (!is_valid_id($commentid)) stderr($lang['gl_error'], $lang['gl_invalid_id']);
    $res = sql_query("SELECT c.*, u.username FROM usercomments AS c LEFT JOIN users AS u ON c.userid = u.id WHERE c.id=" . sqlesc($commentid)) or sqlerr(__FILE__, __LINE__);
    $arr = mysqli_fetch_assoc($res);
    if (!$arr) stderr($lang['gl_error'], $lang['gl_invalid_id']);
    $HTMLOUT.= "<h1>Original contents of comment #{$commentid}</h1>
    <table width='500' border='1' cellspacing='0' cellpadding='5'>
    <tr><td class='comment'>\n";
    $HTMLOUT.= " " . htmlsafechars($arr["ori_text"]);
    $HTMLOUT.= "</td></tr></table>\n";
    $returnto = htmlsafechars($_SERVER["HTTP_REFERER"]);
    if ($returnto) $HTMLOUT.= "<font size='small'>(<a href='{$returnto}'>back</a>)</font>\n";
    echo stdhead($lang['usercomment_user_comments']) . $HTMLOUT . stdfoot();
    die;
} else stderr($lang['gl_error'], "{$lang['usercomment_unknown_action']}");
die;
?>
