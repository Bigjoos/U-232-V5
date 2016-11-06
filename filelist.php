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
require_once (INCL_DIR . 'html_functions.php');
require_once INCL_DIR . 'pager_functions.php';
dbconn(false);
loggedinorreturn();
$lang = array_merge(load_language('global') , load_language('filelist'));
$id = isset($_GET["id"]) ? (int)$_GET["id"] : 0;
if (!is_valid_id($id)) stderr('USER ERROR', 'Bad id');
$res = sql_query("SELECT COUNT(id) FROM files WHERE torrent =" . sqlesc($id)) or sqlerr(__FILE__, __LINE__);
$row = mysqli_fetch_row($res);
$count = $row[0];
$perpage = 100;
$pager = pager($perpage, $count, "filelist.php?id=$id&amp;");
$HTMLOUT = '';
if ($count > $perpage) $HTMLOUT.= $pager['pagertop'];
$HTMLOUT.= "<a name='top'></a><table class='table table-bordered'>\n";
$subres = sql_query("SELECT * FROM files WHERE torrent = " . sqlesc($id) . " ORDER BY id " . $pager['limit']);
$HTMLOUT.= "<tr><td class='colhead'>{$lang["filelist_type"]}</td><td class='colhead'>{$lang["filelist_path"]}</td><td class='colhead' align='right'>{$lang["filelist_size"]}</td></tr>\n";
$counter = 0;
while ($subrow = mysqli_fetch_assoc($subres)) {
    $ext = 'Unknown';
    if (preg_match('/\\.([A-Za-z0-9]+)$/', $subrow["filename"], $ext)) $ext = strtolower($ext[1]);
    if (!file_exists("pic/icons/" . $ext . ".png")) $ext = "Unknown";
    if ($counter !== 0 && $counter % 10 == 0) $HTMLOUT.= "<tr><td colspan='2' align='right'><a href='#top'><img src='{$INSTALLER09['pic_base_url']}/top.gif' alt='' /></a></td></tr>";
    $HTMLOUT.= "<tr><td><img src='pic/icons/" . htmlsafechars($ext) . ".png' alt='" . htmlsafechars($ext) . " file' title='" . htmlsafechars($ext) . " file' /></td><td>" . htmlsafechars($subrow["filename"]) . "</td><td align='right'>" . mksize($subrow["size"]) . "</td></tr>\n";
    $counter++;
}
$HTMLOUT.= "</table>\n";
if ($count > $perpage) $HTMLOUT.= $pager['pagerbottom'];
echo stdhead($lang["filelist_header"]) . $HTMLOUT . stdfoot();
?>
