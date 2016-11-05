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
require_once INCL_DIR . 'pager_functions.php';
require_once INCL_DIR . 'torrenttable_functions.php';
require_once INCL_DIR . 'html_functions.php';
dbconn(false);
loggedinorreturn();
$lang = array_merge(load_language('global') , load_language('mytorrents') , load_language('torrenttable_functions'));
$stdfoot = array(
    /** include js **/
    'js' => array(
        'java_klappe',
        'wz_tooltip'
    )
);
$HTMLOUT = '';
if (isset($_GET['sort']) && isset($_GET['type'])) {
    $column = '';
    $ascdesc = '';
    $_valid_sort = array(
        'id',
        'name',
        'numfiles',
        'comments',
        'added',
        'size',
        'times_completed',
        'seeders',
        'leechers',
        'owner'
    );
    $column = isset($_GET['sort']) && isset($_valid_sort[(int)$_GET['sort']]) ? $_valid_sort[(int)$_GET['sort']] : $_valid_sort[0];
    switch (htmlsafechars($_GET['type'])) {
    case 'asc':
        $ascdesc = "ASC";
        $linkascdesc = "asc";
        break;

    case 'desc':
        $ascdesc = "DESC";
        $linkascdesc = "desc";
        break;

    default:
        $ascdesc = "DESC";
        $linkascdesc = "desc";
        break;
    }
    $orderby = "ORDER BY torrents." . $column . " " . $ascdesc;
    $pagerlink = "sort=" . intval($_GET['sort']) . "&amp;type=" . $linkascdesc . "&amp;";
} else {
    $orderby = "ORDER BY torrents.sticky ASC, torrents.id DESC";
    $pagerlink = "";
}
$where = "WHERE owner = ".sqlesc($CURUSER["id"])." AND banned != 'yes'";
$res = sql_query("SELECT COUNT(id) FROM torrents $where");
$row = mysqli_fetch_array($res, MYSQLI_NUM);
$count = $row[0];
if (!$count) {
    $HTMLOUT.= "{$lang['mytorrents_no_torrents']}";
    $HTMLOUT.= "{$lang['mytorrents_no_uploads']}";
} else {
    $pager = pager(20, $count, "mytorrents.php?{$pagerlink}");
    $res = sql_query("SELECT type, sticky, vip, descr, nuked, bump, nukereason, release_group, free, silver, comments, leechers, seeders, owner, IF(num_ratings < {$INSTALLER09['minvotes']}, NULL, ROUND(rating_sum / num_ratings, 1)) AS rating, id, name, save_as, numfiles, added, size, views, visible, hits, times_completed, category, description, username FROM torrents $where $orderby " . $pager['limit']);
    $HTMLOUT.= $pager['pagertop'];
    $HTMLOUT.= "<br />";
    $HTMLOUT.= torrenttable($res, "mytorrents");
    $HTMLOUT.= $pager['pagerbottom'];
}
echo stdhead($CURUSER["username"] . "'s torrents") . $HTMLOUT . stdfoot($stdfoot);
?>
