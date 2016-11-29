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
//==bookmark.php - by pdq
require_once (__DIR__ . DIRECTORY_SEPARATOR . 'include' . DIRECTORY_SEPARATOR . 'bittorrent.php');
require_once (INCL_DIR . 'user_functions.php');
dbconn();
loggedinorreturn();
$lang = array_merge(load_language('global'), load_language('bookmark'));
$HTMLOUT = '';
if (!mkglobal("torrent")) stderr($lang['bookmark_err'], $lang['bookmark_missing']);
$userid = (int)$CURUSER['id'];
if (!is_valid_id($userid)) stderr($lang['bookmark_err'], $lang['bookmark_invalidid']);
if ($userid != $CURUSER["id"]) stderr($lang['bookmark_err'], $lang['bookmark_denied']);
$torrentid = 0 + $_GET["torrent"];
if (!is_valid_id($torrentid)) die();
if (!isset($torrentid)) stderr($lang['bookmark_err'], $lang['bookmark_failtorr']);
$possible_actions = array(
    'add',
    'delete',
    'public',
    'private'
);
$action = (isset($_GET['action']) ? htmlsafechars($_GET['action']) : '');
if (!in_array($action, $possible_actions)) stderr($lang['bookmark_err'], $lang['bookmark_aruffian']);
if ($action == 'add') {
    $torrentid = (int)$_GET['torrent'];
    $sure = isset($_GET['sure']) ? 0 + $_GET['sure'] : '';
    if (!is_valid_id($torrentid)) stderr($lang['bookmark_err'], $lang['bookmark_invalidid']);
    $hash = md5('s5l6t0mu55yt4hwa7e5' . $torrentid . 'add' . 's5l6t0mu55yt4hwa7e5');
    if (!$sure) stderr($lang['bookmark_add'],$lang['bookmark_add_click'] . "<a href='?torrent=$torrentid&amp;action=add&amp;sure=1&amp;h=$hash'>{$lang['bookmark_here']}</a>{$lang['bookmark_sure']}", FALSE);
    if ($_GET['h'] != $hash) stderr($lang['bookmark_err'], $lang['bookmark_waydoing']);
    function addbookmark($torrentid)
    {
        global $CURUSER, $mc1, $INSTALLER09, $lang;
        if ((get_row_count("bookmarks", "WHERE userid=" . sqlesc($CURUSER['id']) . " AND torrentid = " . sqlesc($torrentid))) > 0) stderr($lang['bookmark_err'], $lang['bookmark_already']);
        sql_query("INSERT INTO bookmarks (userid, torrentid) VALUES (" . sqlesc($CURUSER['id']) . ", " . sqlesc($torrentid) . ")") or sqlerr(__FILE__, __LINE__);
        $mc1->delete_value('bookmm_' . $CURUSER['id']);
        make_bookmarks($CURUSER['id'], 'bookmm_');
    }
    $HTMLOUT.= addbookmark($torrentid);
    $HTMLOUT.= "<h2>{$lang['bookmark_added']}</h2>";
}
if ($action == 'delete') {
    $torrentid = (int)$_GET['torrent'];
    $sure = isset($_GET['sure']) ? 0 + $_GET['sure'] : '';
    if (!is_valid_id($torrentid)) stderr($lang['bookmark_err'], $lang['bookmark_invalidid']);
    $hash = md5('s5l6t0mu55yt4hwa7e5' . $torrentid . 'delete' . 's5l6t0mu55yt4hwa7e5');
    if (!$sure) stderr($lang['bookmark_delete'], $lang['bookmark_del_click'] . "<a href='?torrent=$torrentid&amp;action=delete&amp;sure=1&amp;h=$hash'>{$lang['bookmark_here']}</a>{$lang['bookmark_sure']}", FALSE);
    if ($_GET['h'] != $hash) stderr($lang['bookmark_err'], $lang['bookmark_waydoing']);
    function deletebookmark($torrentid)
    {
        global $CURUSER, $mc1, $INSTALLER09;
        sql_query("DELETE FROM bookmarks WHERE torrentid = " . sqlesc($torrentid) . " AND userid = " . sqlesc($CURUSER['id']));
        $mc1->delete_value('bookmm_' . $CURUSER['id']);
        make_bookmarks($CURUSER['id'], 'bookmm_');
    }
    $HTMLOUT.= deletebookmark($torrentid);
    $HTMLOUT.= "<h2>{$lang['bookmark_deleted']}</h2>";
} elseif ($action == 'public') {
    $torrentid = (int)$_GET['torrent'];
    $sure = isset($_GET['sure']) ? 0 + $_GET['sure'] : '';
    if (!is_valid_id($torrentid)) stderr("Error", "Invalid ID.");
    $hash = md5('s5l6t0mu55yt4hwa7e5' . $torrentid . 'public' . 's5l6t0mu55yt4hwa7e5');
    if (!$sure) stderr($lang['bookmark_share'], $lang['bookmark_share_click'] . "<a href='?torrent=$torrentid&amp;action=public&amp;sure=1&amp;h=$hash'>{$lang['bookmark_here']}</a>{$lang['bookmark_sure']}", FALSE);
    if ($_GET['h'] != $hash) stderr($lang['bookmark_err'], $lang['bookmark_waydoing']);
    function publickbookmark($torrentid)
    {
        global $CURUSER, $mc1, $INSTALLER09;
        sql_query("UPDATE bookmarks SET private = 'no' WHERE private = 'yes' AND torrentid = " . sqlesc($torrentid) . " AND userid = " . sqlesc($CURUSER['id']));
        $mc1->delete_value('bookmm_' . $CURUSER['id']);
        make_bookmarks($CURUSER['id'], 'bookmm_');
    }
    $HTMLOUT.= publickbookmark($torrentid);
    $HTMLOUT.= "<h2>{$lang['bookmark_public']}</h2>";
} elseif ($action == 'private') {
    $torrentid = (int)$_GET['torrent'];
    $sure = isset($_GET['sure']) ? 0 + $_GET['sure'] : '';
    if (!is_valid_id($torrentid)) stderr($lang['bookmark_err'], $lang['bookmark_invalidid']);
    $hash = md5('s5l6t0mu55yt4hwa7e5' . $torrentid . 'private' . 's5l6t0mu55yt4hwa7e5');
    if (!$sure) stderr($lang['bookmark_make_private'], $lang['bookmark_click_private'] . "<a href='?torrent=$torrentid&amp;action=private&amp;sure=1&amp;h=$hash'>{$lang['bookmark_here']}</a>{$lang['bookmark_sure']}", FALSE);
    if ($_GET['h'] != $hash) stderr($lang['bookmark_err'], $lang['bookmark_waydoing']);
    if (!is_valid_id($torrentid)) stderr($lang['bookmark_err'], $lang['bookmark_invalidid']);
    function privatebookmark($torrentid)
    {
        global $CURUSER, $mc1, $INSTALLER09;
        sql_query("UPDATE bookmarks SET private = 'yes' WHERE private = 'no' AND torrentid = " . sqlesc($torrentid) . " AND userid = " . sqlesc($CURUSER['id']));
        $mc1->delete_value('bookmm_' . $CURUSER['id']);
        make_bookmarks($CURUSER['id'], 'bookmm_');
    }
    $HTMLOUT.= privatebookmark($torrentid);
    $HTMLOUT.= "<h2>{$lang['bookmark_private']}</h2>";
}
if (isset($_POST["returnto"])) $ret = "<a href=\"" . htmlsafechars($_POST["returnto"]) . "\">{$lang['bookmark_goback']}</a>";
else $ret = "<a href=\"bookmarks.php\">{$lang['bookmark_goto']}</a><br /><br />
<a href=\"browse.php\">{$lang['bookmark_goto_browse']}</a>";
$HTMLOUT.= $ret;
echo stdhead($lang['bookmark_stdhead']) . $HTMLOUT . stdfoot();
?>
