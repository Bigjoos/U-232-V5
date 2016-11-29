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
//==bookmarks.php - by pdq
require_once (__DIR__ . DIRECTORY_SEPARATOR . 'include' . DIRECTORY_SEPARATOR . 'bittorrent.php');
require_once (INCL_DIR . 'user_functions.php');
require_once (INCL_DIR . 'torrenttable_functions.php');
require_once (INCL_DIR . 'pager_functions.php');
dbconn(false);
loggedinorreturn();
$lang = array_merge(load_language('global') , load_language('torrenttable_functions'), load_language('bookmark'));
$htmlout = '';
function bookmarktable($res, $variant = "index")
{
    global $INSTALLER09, $CURUSER, $lang;
    $htmlout = '';
    $htmlout.= "
   <span>{$lang['bookmarks_icon']}
   <img src='{$INSTALLER09['pic_base_url']}aff_cross.gif' alt='{$lang['bookmarks_del']}' border='none' />{$lang['bookmarks_del1']}
   <img src='{$INSTALLER09['pic_base_url']}zip.gif' alt='{$lang['bookmarks_down']}' border='none' />{$lang['bookmarks_down1']}
   <img alt='{$lang['bookmarks_private']}' src='{$INSTALLER09['pic_base_url']}key.gif' border='none'  /> {$lang['bookmarks_private1']}
   <img src='{$INSTALLER09['pic_base_url']}public.gif' alt='{$lang['bookmarks_public']}' border='none'  />{$lang['bookmarks_public1']}</span>
   <table class='table table-bordered'>
   <tr>
   <td class='colhead' align='center'>{$lang["torrenttable_type"]}</td>
   <td class='colhead' align='left'>{$lang["torrenttable_name"]}</td>";
    $htmlout.= ($variant == 'index' ? '<td class="colhead" align="center">' . $lang['bookmarks_del2'] . '</td><td class="colhead" align="right">' : '') . '' . $lang['bookmarks_down2'] . '</td><td class="colhead" align="right">' . $lang['bookmarks_share'] . '</td>';
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
            $htmlout.= '<a href="browse.php?cat=' . (int)$row['category'] . '">';
            if (isset($row["cat_pic"]) && $row["cat_pic"] != "") $htmlout.= "<img border='0' src='{$INSTALLER09['pic_base_url']}caticons/{$CURUSER['categorie_icon']}/" . htmlsafechars($row['cat_pic']) . "' alt='" . htmlsafechars($row['cat_name']) . "' />";
            else {
                $htmlout.= htmlsafechars($row["cat_name"]);
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
        $htmlout.= "'><b>$dispname</b></a>&nbsp;</td>\n";
        $htmlout.= ($variant == "index" ? "<td align='center'><a href='bookmark.php?torrent={$id}&amp;action=delete'><img src='{$INSTALLER09['pic_base_url']}aff_cross.gif' border='0' alt='{$lang['bookmarks_del3']}' title='{$lang['bookmarks_del3']}' /></a></td>" : "");
        $htmlout.= ($variant == "index" ? "<td align='center'><a href='download.php?torrent={$id}'><img src='{$INSTALLER09['pic_base_url']}zip.gif' border='0' alt='{$lang['bookmarks_down3']}' title='{$lang['bookmarks_down3']}' /></a></td>" : "");
        $bm = sql_query("SELECT * FROM bookmarks WHERE torrentid=" . sqlesc($id) . " && userid=" . sqlesc($CURUSER['id']));
        $bms = mysqli_fetch_assoc($bm);
        if ($bms['private'] == 'yes' && $bms['userid'] == $CURUSER['id']) {
            $makepriv = "<a href='bookmark.php?torrent={$id}&amp;action=public'><img src='{$INSTALLER09['pic_base_url']}key.gif' border='0' alt='{$lang['bookmarks_public2']}' title='{$lang['bookmarks_public2']}' /></a>";
            $htmlout.= "" . ($variant == "index" ? "<td align='center'>{$makepriv}</td>" : "");
        } elseif ($bms['private'] == 'no' && $bms['userid'] == $CURUSER['id']) {
            $makepriv = "<a href='bookmark.php?torrent=" . $id . "&amp;action=private'><img src='{$INSTALLER09['pic_base_url']}public.gif' border='0' alt='{$lang['bookmarks_private2']}' title='{$lang['bookmarks_private2']}' /></a>";
            $htmlout.= "" . ($variant == "index" ? "<td align='center'>{$makepriv}</td>" : "");
        }
        if ($variant == "mytorrents") $htmlout.= "</td><td align='center'><a href='edit.php?returnto=" . urlencode($_SERVER["REQUEST_URI"]) . "&amp;id=" . (int)$row["id"] . "'>{$lang["torrenttable_edit"]}</a>\n";
        if ($variant == "mytorrents") {
            $htmlout.= "<td align='right'>";
            if ($row["visible"] == "no") $htmlout.= "<b>" . $lang["torrenttable_not_visible"] . "</b>";
            else $htmlout.= "" . $lang["torrenttable_visible"] . "";
            $htmlout.= "</td>\n";
        }
        if ($row["type"] == "single") {
            $htmlout.= "<td align='right'>" . (int)$row['numfiles'] . "</td>\n";
        } else {
            if ($variant == "index") {
                $htmlout.= "<td align='right'><b><a href='filelist.php?id=$id'>" . (int)$row['numfiles'] . "</a></b></td>\n";
            } else {
                $htmlout.= "<td align='right'><b><a href='filelist.php?id=$id'>" . (int)$row['numfiles'] . "</a></b></td>\n";
            }
        }
        if (!$row["comments"]) {
            $htmlout.= "<td align='right'>" . (int)$row['comments'] . "</td>\n";
        } else {
            if ($variant == "index") {
                $htmlout.= "<td align='right'><b><a href='details.php?id=$id&amp;hit=1&amp;tocomm=1'>" . (int)$row['comments'] . "</a></b></td>\n";
            } else {
                $htmlout.= "<td align='right'><b><a href='details.php?id=$id&amp;page=0#startcomments'>" . (int)$row['comments'] . "</a></b></td>\n";
            }
        }
        $htmlout.= "<td align='center'><span style='white-space: nowrap;'>" . str_replace(",", "<br />", get_date($row['added'], '')) . "</span></td>\n";
        $htmlout.= "<td align='center'>" . str_replace(" ", "<br />", mksize($row["size"])) . "</td>\n";
        if ($row["times_completed"] != 1) $_s = "" . $lang["torrenttable_time_plural"] . "";
        else $_s = "" . $lang["torrenttable_time_singular"] . "";
        $htmlout.= "<td align='center'><a href='snatches.php?id=$id'>" . number_format($row["times_completed"]) . "<br />$_s</a></td>\n";
        if ((int)$row["seeders"]) {
            if ($variant == "index") {
                if ($row["leechers"]) $ratio = (int)$row["seeders"] / (int)$row["leechers"];
                else $ratio = 1;
                $htmlout.= "<td align='right'><b><a href='peerlist.php?id=$id#seeders'><font color='" . get_slr_color($ratio) . "'>" . (int)$row['seeders'] . "</font></a></b></td>\n";
            } else {
                $htmlout.= "<td align='right'><b><a class='" . linkcolor($row["seeders"]) . "' href='peerlist.php?id=$id#seeders'>" . (int)$row['seeders'] . "</a></b></td>\n";
            }
        } else {
            $htmlout.= "<td align='right'><span class='" . linkcolor($row["seeders"]) . "'>" . (int)$row['seeders'] . "</span></td>\n";
        }
        if ((int)$row["leechers"]) {
            if ($variant == "index") $htmlout.= "<td align='right'><b><a href='peerlist.php?id=$id#leechers'>" . number_format($row["leechers"]) . "</a></b></td>\n";
            else $htmlout.= "<td align='right'><b><a class='" . linkcolor($row["leechers"]) . "' href='peerlist.php?id=$id#leechers'>" . (int)$row['leechers'] . "</a></b></td>\n";
        } else $htmlout.= "<td align='right'>0</td>\n";
        if ($variant == "index") $htmlout.= "<td align='center'>" . (isset($row["username"]) ? ("<a href='userdetails.php?id=" . (int)$row['owner'] . "'><b>" . htmlsafechars($row["username"]) . "</b></a>") : "<i>(" . $lang["torrenttable_unknown_uploader"] . ")</i>") . "</td>\n";
        $htmlout.= "</tr>\n";
    }
    $htmlout.= "</table>\n";
    return $htmlout;
}
//==Bookmarks
$userid = isset($_GET['id']) ? (int)$_GET['id'] : $CURUSER['id'];
if (!is_valid_id($userid)) stderr($lang['bookmarks_err'], $lang['bookmark_invalidid']);
if ($userid != $CURUSER["id"]) stderr($lang['bookmarks_err'], "{$lang['bookmarks_denied']}<a href=\"sharemarks.php?id=" . $userid . "\">{$lang['bookmarks_here']}</a>");
$res = sql_query("SELECT id, username FROM users WHERE id = " . sqlesc($userid)) or sqlerr(__FILE__, __LINE__);
$arr = mysqli_fetch_array($res);
$htmlout.= "<h1>{$lang['bookmarks_my']}</h1>";
$htmlout.= "<b><a href='sharemarks.php?id=" . $CURUSER['id'] . "'>{$lang['bookmarks_my_share']}</a></b>";
$res = sql_query("SELECT COUNT(id) FROM bookmarks WHERE userid = " . sqlesc($userid)) or sqlerr(__FILE__, __LINE__);
$row = mysqli_fetch_array($res);
$count = $row[0];
$torrentsperpage = $CURUSER["torrentsperpage"];
if (!$torrentsperpage) $torrentsperpage = 25;
if ($count) {
    $pager = pager($torrentsperpage, $count, "bookmarks.php?&amp;");
    $query1 = "SELECT bookmarks.id as bookmarkid, torrents.username, torrents.owner, torrents.id, torrents.name, torrents.type, torrents.comments, torrents.leechers, torrents.seeders, torrents.save_as, torrents.numfiles, torrents.added, torrents.filename, torrents.size, torrents.views, torrents.visible, torrents.hits, torrents.times_completed, torrents.category FROM bookmarks LEFT JOIN torrents ON bookmarks.torrentid = torrents.id WHERE bookmarks.userid =" . sqlesc($userid) . " ORDER BY torrents.id DESC {$pager['limit']}" or sqlerr(__FILE__, __LINE__);
    $res = sql_query($query1) or sqlerr(__FILE__, __LINE__);
}
if ($count) {
    $htmlout.= $pager['pagertop'];
    $htmlout.= bookmarktable($res, "index", TRUE);
    $htmlout.= $pager['pagerbottom'];
}
echo stdhead($lang['bookmarks_stdhead']) . $htmlout . stdfoot();
?>
