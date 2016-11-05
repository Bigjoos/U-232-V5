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
//== Sharemarks.php - by pdq
require_once (__DIR__ . DIRECTORY_SEPARATOR . 'include' . DIRECTORY_SEPARATOR . 'bittorrent.php');
require_once (INCL_DIR . 'user_functions.php');
require_once (INCL_DIR . 'torrenttable_functions.php');
require_once (INCL_DIR . 'pager_functions.php');
require_once (INCL_DIR . 'html_functions.php');
dbconn(false);
loggedinorreturn();
$lang = array_merge(load_language('global') , load_language('torrenttable_functions'));
$htmlout = '';
function sharetable($res, $variant = "index")
{
    global $INSTALLER09, $CURUSER, $lang;
    $htmlout = '';
    $htmlout.= "
<span>Icon Legend :
<img src='{$INSTALLER09['pic_base_url']}aff_cross.gif' alt='Delete Bookmark' border='none' /> = Delete Bookmark |
<img src='{$INSTALLER09['pic_base_url']}zip.gif' alt='Download Bookmark' border='none' /> = Download Torrent |
<img alt='Bookmark is Private' src='{$INSTALLER09['pic_base_url']}key.gif' border='none'  /> = Bookmark is Private |
<img src='{$INSTALLER09['pic_base_url']}public.gif' alt='Bookmark is Public' border='none'  /> = Bookmark is Public</span>
<table border='1' cellspacing='0' cellpadding='5'>
<tr>
<td class='colhead' align='center'>Type</td>
<td class='colhead' align='left'>Name</td>";
    $userid = (int)$_GET['id'];
    if ($CURUSER['id'] == $userid) $htmlout.= ($variant == 'index' ? '<td class="colhead" align="center">Download</td><td class="colhead" align="right">' : '') . 'Delete</td>';
    else $htmlout.= ($variant == 'index' ? '<td class="colhead" align="center">Download</td><td class="colhead" align="right">' : '') . 'Bookmark</td>';
    if ($variant == "mytorrents") {
        $htmlout.= "<td class='colhead' align='center'>{$lang["torrenttable_edit"]}</td>\n";
        $htmlout.= "<td class='colhead' align='center'>{$lang["torrenttable_visible"]}</td>\n";
    }
    $htmlout.= "<td class='colhead' align='right'>{$lang["torrenttable_files"]}</td>
   <td class='colhead' align='right'>{$lang["torrenttable_comments"]}</td>
   <td class='colhead' align='center'>{$lang["torrenttable_added"]}</td>
   <td class='colhead' align='center'>{$lang["torrenttable_size"]}</td>
   <td class='colhead' align='center'>{$lang["torrenttable_snatched"]}</td>
   <td class='colhead' align='right'>{$lang["torrenttable_seeders"]}</td>
   <td class='colhead' align='right'>{$lang["torrenttable_leechers"]}</td>";
    if ($variant == 'index') $htmlout.= "<td class='colhead' align='center'>{$lang["torrenttable_uppedby"]}</td>\n";
    $htmlout.= "</tr>\n";
    $categories = genrelist();
    foreach ($categories as $key => $value) $change[$value['id']] = array(
        'id' => $value['id'],
        'name' => $value['name'],
        'image' => $value['image']
    );
    while ($row = mysqli_fetch_assoc($res)) {
        $row['cat_name'] = htmlsafechars($change[$row['category']]['name']);
        $row['cat_pic'] = htmlsafechars($change[$row['category']]['image']);
        $id = (int)$row["id"];
        $htmlout.= "<tr>\n";
        $htmlout.= "<td align='center' style='padding: 0px'>";
        if (isset($row["cat_name"])) {
            $htmlout.= "<a href='browse.php?cat=" . (int)$row['category'] . "'>";
            if (isset($row["cat_pic"]) && $row["cat_pic"] != "") $htmlout.= "<img border='0' src='{$INSTALLER09['pic_base_url']}caticons/{$CURUSER['categorie_icon']}/{$row['cat_pic']}' alt='{$row['cat_name']}' />";
            else {
                $htmlout.= $row["cat_name"];
            }
            $htmlout.= "</a>";
        } else {
            $htmlout.= "-";
        }
        $htmlout.= "</td>\n";
        $dispname = htmlsafechars($row["name"]);
        $htmlout.= "<td align='left'><a href='details.php?";
        if ($variant == "mytorrents") $htmlout.= "returnto=" . urlencode($_SERVER["REQUEST_URI"]) . "&amp;";
        $htmlout.= "id=$id";
        if ($variant == "index") $htmlout.= "&amp;hit=1";
        $htmlout.= "'><b>$dispname</b></a>&nbsp;</td>";
        $htmlout.= ($variant == "index" ? "<td align='center'><a href=\"download.php?torrent={$id}\"><img src='{$INSTALLER09['pic_base_url']}zip.gif' border='0' alt='Download Bookmark!' title='Download Bookmark!' /></a></td>" : "");
        $bm = sql_query("SELECT * FROM bookmarks WHERE torrentid=" . sqlesc($id) . " AND userid=" . sqlesc($CURUSER['id']));
        $bms = mysqli_fetch_assoc($bm);
        $bookmarked = (empty($bms) ? '<a href=\'bookmark.php?torrent=' . $id . '&amp;action=add\'><img src=\'' . $INSTALLER09['pic_base_url'] . 'bookmark.gif\' border=\'0\' alt=\'Bookmark it!\' title=\'Bookmark it!\'></a>' : '<a href="bookmark.php?torrent=' . $id . '&amp;action=delete"><img src=\'' . $INSTALLER09['pic_base_url'] . 'aff_cross.gif\' border=\'0\' alt=\'Delete Bookmark!\' title=\'Delete Bookmark!\' /></a>');
        $htmlout.= ($variant == "index" ? "<td align='center'>{$bookmarked}</td>" : "");
        if ($variant == "mytorrents") $htmlout.= "</td><td align='center'><a href='edit.php?returnto=" . urlencode($_SERVER["REQUEST_URI"]) . "&amp;id=" . (int)$row['id'] . "'>{$lang["torrenttable_edit"]}</a>\n";
        if ($variant == "mytorrents") {
            $htmlout.= "<td align='right'>";
            if ($row["visible"] == "no") $htmlout.= "<b>{$lang["torrenttable_not_visible"]}</b>";
            else $htmlout.= "{$lang["torrenttable_visible"]}";
            $htmlout.= "</td>\n";
        }
        if ($row["type"] == "single") {
            $htmlout.= "<td align='right'>" . (int)$row["numfiles"] . "</td>\n";
        } else {
            if ($variant == "index") {
                $htmlout.= "<td align='right'><b><a href='filelist.php?id=$id'>" . (int)$row["numfiles"] . "</a></b></td>\n";
            } else {
                $htmlout.= "<td align='right'><b><a href='filelist.php?id=$id'>" . (int)$row["numfiles"] . "</a></b></td>\n";
            }
        }
        if (!$row["comments"]) {
            $htmlout.= "<td align='right'>" . (int)$row["comments"] . "</td>\n";
        } else {
            if ($variant == "index") {
                $htmlout.= "<td align='right'><b><a href='details.php?id=$id&amp;hit=1&amp;tocomm=1'>" . (int)$row["comments"] . "</a></b></td>\n";
            } else {
                $htmlout.= "<td align='right'><b><a href='details.php?id=$id&amp;page=0#startcomments'>" . (int)$row["comments"] . "</a></b></td>\n";
            }
        }
        $htmlout.= "<td align='center'><span style='white-space: nowrap;'>" . str_replace(",", "<br />", get_date($row['added'], '')) . "</span></td>\n";
        $htmlout.= "
    <td align='center'>" . str_replace(" ", "<br />", mksize($row["size"])) . "</td>\n";
        if ($row["times_completed"] != 1) $_s = "" . $lang["torrenttable_time_plural"] . "";
        else $_s = "" . $lang["torrenttable_time_singular"] . "";
        $htmlout.= "<td align='center'><a href='snatches.php?id=$id'>" . number_format($row["times_completed"]) . "<br />$_s</a></td>\n";
        if ($row["seeders"]) {
            if ($variant == "index") {
                if ($row["leechers"]) $ratio = $row["seeders"] / $row["leechers"];
                else $ratio = 1;
                $htmlout.= "<td align='right'><b><a href='peerlist.php?id=$id#seeders'>
               <font color='" . get_slr_color($ratio) . "'>" . (int)$row["seeders"] . "</font></a></b></td>\n";
            } else {
                $htmlout.= "<td align='right'><b><a class='" . linkcolor($row["seeders"]) . "' href='peerlist.php?id=$id#seeders'>" . (int)$row["seeders"] . "</a></b></td>\n";
            }
        } else {
            $htmlout.= "<td align='right'><span class='" . linkcolor($row["seeders"]) . "'>" . (int)$row["seeders"] . "</span></td>\n";
        }
        if ($row["leechers"]) {
            if ($variant == "index") $htmlout.= "<td align='right'><b><a href='peerlist.php?id=$id#leechers'>" . number_format($row["leechers"]) . "</a></b></td>\n";
            else $htmlout.= "<td align='right'><b><a class='" . linkcolor($row["leechers"]) . "' href='peerlist.php?id=$id#leechers'>" . (int)$row["leechers"] . "</a></b></td>\n";
        } else $htmlout.= "<td align='right'>0</td>\n";
        if ($variant == "index") $htmlout.= "<td align='center'>" . (isset($row["username"]) ? ("<a href='userdetails.php?id=" . (int)$row["owner"] . "'><b>" . htmlsafechars($row["username"]) . "</b></a>") : "<i>(" . $lang["torrenttable_unknown_uploader"] . ")</i>") . "</td>\n";
        $htmlout.= "</tr>\n";
    }
    $htmlout.= "</table>\n";
    return $htmlout;
}
//==Sharemarks
$userid = isset($_GET['id']) ? (int)$_GET['id'] : '';
if (!is_valid_id($userid)) stderr("Error", "Invalid ID.");
$res = sql_query("SELECT id, username FROM users WHERE id = " . sqlesc($userid)) or sqlerr(__FILE__, __LINE__);
$arr = mysqli_fetch_array($res);
$htmlout.= "<h1>Sharemarks for <a href=\"userdetails.php?id=" . $userid . "\">" . htmlsafechars($arr['username']) . "</a></h1>";
$htmlout.= "<b><a href=\"bookmarks.php\">My Bookmarks</a></b>";
$res = sql_query("SELECT COUNT(id) FROM bookmarks WHERE userid = " . sqlesc($userid)) or sqlerr(__FILE__, __LINE__);
$row = mysqli_fetch_array($res);
$count = $row[0];
$torrentsperpage = $CURUSER["torrentsperpage"];
if (!$torrentsperpage) $torrentsperpage = 25;
if ($count) {
    $pager = pager($torrentsperpage, $count, "sharemarks.php?&amp;");
    $query1 = "SELECT bookmarks.id as bookmarkid, torrents.username, torrents.owner, torrents.id, torrents.name, torrents.type, torrents.comments, torrents.leechers, torrents.seeders, torrents.save_as, torrents.numfiles, torrents.added, torrents.filename, torrents.size, torrents.views, torrents.visible, torrents.hits, torrents.times_completed, torrents.category FROM bookmarks LEFT JOIN torrents ON bookmarks.torrentid = torrents.id WHERE bookmarks.userid = " . sqlesc($userid) . " AND bookmarks.private = 'no' ORDER BY id DESC {$pager['limit']}";
    $res = sql_query($query1) or sqlerr(__FILE__, __LINE__);
}
if ($count) {
    $htmlout.= $pager['pagertop'];
    $htmlout.= sharetable($res, "index", TRUE);
    $htmlout.= $pager['pagerbottom'];
}
echo stdhead("Sharemarks for " . htmlsafechars($arr['username'])) . $htmlout . stdfoot();
?>
