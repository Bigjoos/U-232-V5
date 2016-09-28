<?php
/**
 |--------------------------------------------------------------------------|
 |   https://github.com/Bigjoos/                			    |
 |--------------------------------------------------------------------------|
 |   Licence Info: GPL			                                    |
 |--------------------------------------------------------------------------|
 |   Copyright (C) 2010 U-232 V5					    |
 |--------------------------------------------------------------------------|
 |   A bittorrent tracker source based on TBDev.net/tbsource/bytemonsoon.   |
 |--------------------------------------------------------------------------|
 |   Project Leaders: Mindless, Autotron, whocares, Swizzles.					    |
 |--------------------------------------------------------------------------|
  _   _   _   _   _     _   _   _   _   _   _     _   _   _   _
 / \ / \ / \ / \ / \   / \ / \ / \ / \ / \ / \   / \ / \ / \ / \
( U | - | 2 | 3 | 2 )-( S | o | u | r | c | e )-( C | o | d | e )
 \_/ \_/ \_/ \_/ \_/   \_/ \_/ \_/ \_/ \_/ \_/   \_/ \_/ \_/ \_/
 */
function linkcolor($num)
{
    if (!$num) return "red";
    return "pink";
}
function readMore($text, $char, $link)
{
    return (strlen($text) > $char ? substr(htmlsafechars($text) , 0, $char - 1) . "...<br /><a href='$link'>Read more...</a>" : htmlsafechars($text));
}
function torrenttable($res, $variant = "index")
{
    global $INSTALLER09, $CURUSER, $lang, $free, $mc1;
    require_once (INCL_DIR . 'bbcode_functions.php');
    require_once (CLASS_DIR . 'class_user_options_2.php');
    $htmlout = $prevdate = $nuked = $free_slot = $freetorrent = $free_color = $slots_check = $double_slot = $private = $newgenre = $oldlink = $char = $description = $type = $sort = $row = $youtube = '';
    $count_get = $wait = 0;
    if ($CURUSER["class"] < UC_VIP && $INSTALLER09['wait_times'] == 1)
    {
      $gigs = $CURUSER["uploaded"] / (1024*1024*1024);
      $ratio = (($CURUSER["downloaded"] > 0) ? ($CURUSER["uploaded"] / $CURUSER["downloaded"]) : 0);
      if ($ratio < 0.5 || $gigs < 5) $wait = 48;
      elseif ($ratio < 0.65 || $gigs < 6.5) $wait = 24;
      elseif ($ratio < 0.8 || $gigs < 8) $wait = 12;
      elseif ($ratio < 0.95 || $gigs < 9.5) $wait = 6;
      else $wait = 0;
    }

    /** ALL FREE/DOUBLE **/
    foreach ($free as $fl) {
        switch ($fl['modifier']) {
        case 1:
            $free_display = '[Free]';
            break;
        case 2:
            $free_display = '[Double]';
            break;
        case 3:
            $free_display = '[Free and Double]';
            break;
        case 4:
            $free_display = '[Silver]';
            break;
        }
        $slot = make_freeslots($CURUSER['id'], 'fllslot_');
        $book = make_bookmarks($CURUSER['id'], 'bookmm_');
        $all_free_tag = ($fl['modifier'] != 0 && ($fl['expires'] > TIME_NOW || $fl['expires'] == 1) ? ' <a class="info" href="#">
            <b>' . $free_display . '</b> 
            <span>' . ($fl['expires'] != 1 ? '
            Expires: ' . get_date($fl['expires'], 'DATE') . '<br />
            (' . mkprettytime($fl['expires'] - TIME_NOW) . ' to go)</span></a><br />' : 'Unlimited</span></a><br />') : '');
    }
    $oldlink = array();
    foreach ($_GET as $key => $var) {
        if (in_array($key, array(
            'sort',
            'type'
        ))) continue;
        if (is_array($var)) {
            foreach ($var as $s_var) $oldlink[] = sprintf('%s=%s', urlencode($key) . '%5B%5D', urlencode($s_var));
        } else
            $oldlink[] = sprintf('%s=%s', urlencode($key), urlencode($var));
    }
    $oldlink = !empty($oldlink) ? join('&amp;', array_map('htmlsafechars', $oldlink)) .'&amp;' : '';   
    $links = array(
        'link1',
        'link2',
        'link3',
        'link4',
        'link5',
        'link6',
        'link7',
        'link8',
        'link9',
	'link10'
    );
    $i = 1;
    foreach ($links as $link) {
        if (isset($_GET['sort']) && $_GET['sort'] == $i) $$link = (isset($_GET['type']) && $_GET['type'] == 'desc') ? 'asc' : 'desc';
        else $$link = 'desc';
        $i++;
    }
    $htmlout.= "<div class'table-responsive'>
   <table class='table table-bordered'>
   <tr>
   <td class='text-center'>{$lang["torrenttable_type"]}</td>
   <td class='text-left'><a href='{$_SERVER["PHP_SELF"]}?{$oldlink}sort=1&amp;type={$link1}'>{$lang["torrenttable_name"]}</a></td>
   <td class='text-left'><img src='{$INSTALLER09['pic_base_url']}zip.gif' border='0' alt='Download' title='Download' /></td>";
    $htmlout.= ($variant == 'index' ? "<td class='colhead' align='center'><a href='{$INSTALLER09['baseurl']}/bookmarks.php'><img src='{$INSTALLER09['pic_base_url']}bookmarks.png'  border='0' alt='Bookmark' title='Go To My Bookmarks' /></a></td>" : '');
    if ($variant == "mytorrents") {
        $htmlout.= "<td class='text-center'>{$lang["torrenttable_edit"]}</td>\n";
        $htmlout.= "<td class='text-center'>{$lang["torrenttable_visible"]}</td>\n";
    }
    $htmlout.= "<td class='text-right'><a href='{$_SERVER["PHP_SELF"]}?{$oldlink}sort=2&amp;type={$link2}'>{$lang["torrenttable_files"]}</a></td>
   <td class='text-center'><a href='{$_SERVER["PHP_SELF"]}?{$oldlink}sort=3&amp;type={$link3}'>{$lang["torrenttable_comments"]}</a></td>
   <td class='text-center'><a href='{$_SERVER["PHP_SELF"]}?{$oldlink}sort=4&amp;type={$link4}'>{$lang["torrenttable_added"]}</a></td>
   ".($INSTALLER09['wait_times'] == 1 ? "<td class='text-center'>{$lang["torrenttable_ttl"]}</td>" : "")."
   <td class='text-center'><a href='{$_SERVER["PHP_SELF"]}?{$oldlink}sort=5&amp;type={$link5}'>{$lang["torrenttable_size"]}</a></td>
   <td class='text-center'><a href='{$_SERVER["PHP_SELF"]}?{$oldlink}sort=6&amp;type={$link6}'>{$lang["torrenttable_snatched"]}</a></td>
   <td class='text-center'><a href='{$_SERVER["PHP_SELF"]}?{$oldlink}sort=7&amp;type={$link7}'>{$lang["torrenttable_seeders"]}</a></td>
   <td class='text-center'><a href='{$_SERVER["PHP_SELF"]}?{$oldlink}sort=8&amp;type={$link8}'>{$lang["torrenttable_leechers"]}</a></td>";
    if ($variant == 'index') $htmlout.= "<td class='colhead' align='center'><a href='{$_SERVER["PHP_SELF"]}?{$oldlink}sort=9&amp;type={$link9}'>{$lang["torrenttable_uppedby"]}</a></td>\n";
    if ($CURUSER['class'] >= UC_STAFF)  {
    $htmlout .= "<td class='text-center'>Tools</td>\n";
    }
    $htmlout.= "
<td class='text-center'><a href='{$_SERVER["PHP_SELF"]}?{$oldlink}sort=10&amp;type={$link10}'>Health</a></td></tr>\n";
    $categories = genrelist();
    foreach ($categories as $key => $value) $change[$value['id']] = array(
        'id' => $value['id'],
        'name' => $value['name'],
        'image' => $value['image'],
        'min_class' => $value['min_class']
    );
    while ($row = mysqli_fetch_assoc($res)) {
    //==
        if ($CURUSER['opt2'] & user_options_2::SPLIT) {
            if (get_date($row['added'], 'DATE') == $prevdate) $cleandate = '';
            else $htmlout.= "<tr><td class='text-left'><b>{$lang['torrenttable_upped']} ".get_date($row['added'], 'DATE')."</b></td></tr>";
            $prevdate = get_date($row['added'], 'DATE');
        }
        $row['cat_name'] = htmlsafechars($change[$row['category']]['name']);
        $row['cat_pic'] = htmlsafechars($change[$row['category']]['image']);
        $row['min_class'] = htmlsafechars($change[$row['category']]['min_class']);
        /** Freeslot/doubleslot in Use **/
        $id = (int)$row["id"];
        foreach ($slot as $sl) $slots_check = ($sl['torrentid'] == $id && $sl['free'] == 'yes' OR $sl['doubleup'] == 'yes');
        if ($row["sticky"] == "yes") $htmlout.= "<tr class='highlight'>\n";
        else $htmlout.= '<tr class="' . (($free_color && $all_free_tag != '') || ($row['free'] != 0) || $slots_check ? 'freeleech_color' : 'browse_color') . '">';
        $htmlout.= "<td class='text-center'>";
        if (isset($row["cat_name"])) {
            $htmlout.= "<a href='browse.php?cat=" . (int)$row['category'] . "'>";
            if (isset($row["cat_pic"]) && $row["cat_pic"] != "") $htmlout.= "<img border='0' src='{$INSTALLER09['pic_base_url']}caticons/{$CURUSER['categorie_icon']}/{$row['cat_pic']}' alt='{$row['cat_name']}' />";
            else {
                $htmlout.= htmlsafechars($row["cat_name"]);
            }
            $htmlout.= "</a>";
        } else {
            $htmlout.= "-";
        }
        $htmlout.= "</td>\n";
        $dispname = htmlsafechars($row["name"]);
        $smalldescr = (!empty($row['description']) ? "<i>[" . htmlsafechars($row['description']) . "]</i>" : "");
        $checked = ((!empty($row['checked_by']) && $CURUSER['class'] >= UC_USER) ? "&nbsp;<img src='{$INSTALLER09['pic_base_url']}mod.gif' width='15' border='0' alt='Checked - by " . htmlsafechars($row['checked_by']) . "' title='Checked - by " . htmlsafechars($row['checked_by']) . "' />" : "");
        $poster = empty($row["poster"]) ? "<img src=\'{$INSTALLER09['pic_base_url']}noposter.png\' width=\'150\' height=\'220\' border=\'0\' alt=\'Poster\' title=\'poster\' />" : "<img src=\'" . htmlsafechars($row['poster']) . "\' width=\'150\' height=\'220\' border=\'0\' alt=\'Poster\' title=\'poster\' />";
        //$rating = empty($row["rating"]) ? "No votes yet":"".ratingpic($row["rating"])."";
        $youtube = (!empty($row['youtube']) ? "<a href='" . htmlsafechars($row['youtube']) . "' target='_blank'><img src='{$INSTALLER09['pic_base_url']}youtube.png' width='14' height='14' border='0' alt='Youtube Trailer' title='Youtube Trailer' /></a>" : "");
        if (isset($row["descr"])) $descr = str_replace("\"", "&quot;", readMore($row["descr"], 350, "details.php?id=" . (int)$row["id"] . "&amp;hit=1"));
        $descr = str_replace('&', '&amp;', $descr);
        $htmlout.= "<td align='left'><a href='details.php?";
        if ($variant == "mytorrents") $htmlout.= "returnto=" . urlencode($_SERVER["REQUEST_URI"]) . "&amp;";
        $htmlout.= "id=$id";
        if ($variant == "index") $htmlout.= "&amp;hit=1";
        $newgenre = '';
        if (!empty($row['newgenre'])) {
            $newgenre = array();
            $row['newgenre'] = explode(',', $row['newgenre']);
            foreach ($row['newgenre'] as $foo) $newgenre[] = '<a href="browse.php?search=' . trim(strtolower($foo)) . '&amp;searchin=genre">' . $foo . '</a>';
            $newgenre = '<i>' . join(', ', $newgenre) . '</i>';
        }
        $sticky = ($row['sticky'] == "yes" ? "<img src='{$INSTALLER09['pic_base_url']}sticky.gif' style='border:none' alt='Sticky' title='Sticky !' />" : "");
        $nuked = ($row["nuked"] == "yes" ? "<img src='{$INSTALLER09['pic_base_url']}nuked.gif' style='border:none' alt='Nuked'  align='right' title='Reason :" . htmlsafechars($row["nukereason"]) . "' />" : "");
        $release_group = ($row['release_group'] == "scene" ? "&nbsp;<img src='{$INSTALLER09['pic_base_url']}scene.gif' title='Scene' alt='Scene' style='border:none' />" : ($row['release_group'] == "p2p" ? "&nbsp;<img src='{$INSTALLER09['pic_base_url']}p2p.gif' title='P2P' alt='P2P' />" : ""));
        $viponly = ($row["vip"] == 1 ? "<img src='{$INSTALLER09['pic_base_url']}star.png' border='0' alt='Vip Torrent' title='Vip Torrent' />" : "");
        $freetorrent = (XBT_TRACKER == true && $row["freetorrent"] >= 1 ? "<img src='{$INSTALLER09['pic_base_url']}freedownload.gif' border='0' alt='Free Torrent' title='Free Torrent' />" : "");
        $bump = ($row['bump'] == "yes" ? "<img src='{$INSTALLER09['pic_base_url']}up.gif' width='12px' alt='Re-Animated torrent' title='This torrent was ReAnimated!' />" : "");
        /** FREE Torrent **/
        $free_tag = ($row['free'] != 0 ? ' <a class="info" href="#"><b>[FREE]</b> <span>' . ($row['free'] > 1 ? 'Expires: ' . get_date($row['free'], 'DATE') . '<br />(' . mkprettytime($row['free'] - TIME_NOW) . ' to go)<br />' : 'Unlimited<br />') . '</span></a>' : $all_free_tag);
        /** Silver Torrent **/
        $silver_tag = ($row['silver'] != 0 ? ' <a class="info" href="#"><b>[SILVER]</b> <span>' . ($row['silver'] > 1 ? 'Expires: ' . get_date($row['silver'], 'DATE') . '<br />(' . mkprettytime($row['silver'] - TIME_NOW) . ' to go)<br />' : 'Unlimited<br />') . '</span></a>' : '');
        if (!empty($slot)) foreach ($slot as $sl) {
            if ($sl['torrentid'] == $id && $sl['free'] == 'yes') $free_slot = 1;
            if ($sl['torrentid'] == $id && $sl['doubleup'] == 'yes') $double_slot = 1;
            if ($free_slot && $double_slot) break;
        }
        $free_slot = ($free_slot == 1 ? '&nbsp;<img src="' . $INSTALLER09['pic_base_url'] . 'freedownload.gif" width="12px" alt="Free Slot" title="Free Slot in Use" />&nbsp;<small>Free Slot</small>' : '');
        $double_slot = ($double_slot == 1 ? '&nbsp;<img src="' . $INSTALLER09['pic_base_url'] . 'doubleseed.gif" width="12px" alt="Double Upload Slot" title="Double Upload Slot in Use" />&nbsp;<small>Double Slot</small><br />' : '');
        $nuked = ($row['nuked'] != 'no' && $row['nuked'] != '' ? '&nbsp;<span title="Nuked ' . htmlsafechars($row['nuked']) . '" class="browse-icons-nuked"></span>' : '');
        //==
        $Subs = '';
        if (in_array($row["category"], $INSTALLER09['movie_cats']) && !empty($row["subs"])) {
            $subs_array = explode(",", $row["subs"]);
            foreach ($subs_array as $k => $sid) {
            require_once (CACHE_DIR . 'subs.php');
                foreach ($subs as $sub) {
                    if ($sub["id"] == $sid) $Subs = "<img border='0' width='16px' style='padding:3px;' src='".htmlsafechars($sub["pic"])."' alt='".htmlsafechars($sub["name"])."' title='".htmlsafechars($sub["name"])."' />";
                }
            }
        } else $Subs = "---";
        $htmlout.= "' onmouseover=\"Tip('<b>" . CutName($dispname, 80) . "</b><br /><b>Added:&nbsp;" . get_date($row['added'], 'DATE', 0, 1) . "</b><br /><b>Size:&nbsp;" . mksize(htmlsafechars($row["size"])) . "</b><br /><b>Subtitle:&nbsp;{$Subs}</b><br /><b>Seeders:&nbsp;" . htmlsafechars($row["seeders"]) . "</b><br /><b>Leechers:&nbsp;" . htmlsafechars($row["leechers"]) . "</b><br />$poster');\" onmouseout=\"UnTip();\"><b>" . CutName($dispname, 45) . "</b></a>&nbsp;&nbsp;<a href=\"javascript:klappe_descr('descr" . (int)$row["id"] . "');\" ><img src=\"{$INSTALLER09['pic_base_url']}plus.png\" border=\"0\" alt=\"Show torrent info in this page\" title=\"Show torrent info in this page\" /></a>&nbsp;&nbsp;$youtube&nbsp;$viponly&nbsp;$release_group&nbsp;$sticky&nbsp;" . ($row['added'] >= $CURUSER['last_browse'] ? " <img src='{$INSTALLER09['pic_base_url']}newb.png' border='0' alt='New !' title='New !' />" : "") . "&nbsp;$checked&nbsp;$freetorrent&nbsp;$free_tag&nbsp;$silver_tag<br />$free_slot&nbsp;$double_slot&nbsp;$nuked&nbsp;$newgenre&nbsp;$bump&nbsp;$smalldescr</td>\n";
        if ($variant == "mytorrents") $htmlout.= "<td class='text-center'><a href=\"download.php?torrent={$id}" . ($CURUSER['ssluse'] == 3 ? "&amp;ssl=1" : "") . "\"><img src='{$INSTALLER09['pic_base_url']}zip.gif' border='0' alt='Download This Torrent!' title='Download This Torrent!' /></a></td>\n";
        if ($variant == "mytorrents") $htmlout.= "<td class='text-center'><a href='edit.php?id=" . (int)$row['id'] . "amp;returnto=" . urlencode($_SERVER["REQUEST_URI"]) . "'>{$lang["torrenttable_edit"]}</a></td>\n";
        $htmlout.= ($variant == "index" ? "<td class='text-center'><a href=\"download.php?torrent={$id}" . ($CURUSER['ssluse'] == 3 ? "&amp;ssl=1" : "") . "\"><img src='{$INSTALLER09['pic_base_url']}zip.gif' border='0' alt='Download This Torrent!' title='Download This Torrent!' /></a></td>" : "");
        if ($variant == "mytorrents") {
            $htmlout.= "<td class='text-right'>";
            if ($row["visible"] == "no") $htmlout.= "<b>{$lang["torrenttable_not_visible"]}</b>";
            else $htmlout.= "{$lang["torrenttable_visible"]}";
            $htmlout.= "</td>\n";
        }
        /** pdq bookmarks **/
        $booked = '';
        if (!empty($book)) foreach ($book as $bk) {
            if ($bk['torrentid'] == $id) $booked = 1;
        }
        $rm_status = (!$booked ? ' style="display:none;"' : ' style="display:inline;"');
        $bm_status = ($booked ? ' style="display:none;"' : ' style="display:inline;"');
        $bookmark = '<span id="bookmark' . $id . '"' . $bm_status . '>
                    <a href="bookmark.php?torrent=' . $id . '&amp;action=add" class="bookmark" name="' . $id . '">
                    <span title="Bookmark it!" class="add_bookmark_b">
                    <img src="' . $INSTALLER09['pic_base_url'] . 'aff_tick.gif" align="top" width="14px" alt="Bookmark it!" title="Bookmark it!" />
                    </span>
                    </a>
                    </span>
                    <span id="remove' . $id . '"' . $rm_status . '>
                    <a href="bookmark.php?torrent=' . $id . '&amp;action=delete" class="remove" name="' . $id . '">
                    <span class="remove_bookmark_b">
                    <img src="' . $INSTALLER09['pic_base_url'] . 'aff_cross.gif" align="top" width="14px" alt="Delete Bookmark!" title="Delete Bookmark!" />
                    </span>
                    </a>
                    </span>';
        if ($variant == "index") $htmlout.= "<td align='right'>{$bookmark}</td>";
        if ($row["type"] == "single") {
            $htmlout.= "<td class='text-right'>" . (int)$row["numfiles"] . "</td>\n";
        } else {
            if ($variant == "index") {
                $htmlout.= "<td class='text-right'><b><a href='filelist.php?id=$id'>" . (int)$row["numfiles"] . "</a></b></td>\n";
            } else {
                $htmlout.= "<td class='text-right'><b><a href='filelist.php?id=$id'>" . (int)$row["numfiles"] . "</a></b></td>\n";
            }
        }
        if (!$row["comments"]) {
            $htmlout.= "<td class='text-right'>" . (int)$row["comments"] . "</td>\n";
        } else {
            if ($variant == "index") {
                $htmlout.= "<td class='text-right'><b><a href='details.php?id=$id&amp;hit=1&amp;tocomm=1'>" . (int)$row["comments"] . "</a></b></td>\n";
            } else {
                $htmlout.= "<td class='text-right'><b><a href='details.php?id=$id&amp;page=0#startcomments'>" . (int)$row["comments"] . "</a></b></td>\n";
            }
        }
        $htmlout.= "<td class='text-center'><span style='white-space: nowrap;'>" . str_replace(",", "<br />", get_date($row['added'], '')) . "</span></td>\n";
          $ttl = (28*24) - floor((TIME_NOW - $row["added"]) / 3600);
          if ($ttl == 1) 
                 $ttl .= "<br />".$lang["torrenttable_hour_singular"]; 
              else 
                 $ttl .= "<br />".$lang["torrenttable_hour_plural"];
        $htmlout .= ($INSTALLER09['wait_times'] == 1 ? "<td class='text-center'>$ttl</td>\n" : "");
        $htmlout.= "<td class='text-center'>" . str_replace(" ", "<br />", mksize($row["size"])) . "</td>\n";
        if ($row["times_completed"] != 1) $_s = "" . $lang["torrenttable_time_plural"];
        else $_s = "" . $lang["torrenttable_time_singular"];
        $What_Script_S = (XBT_TRACKER == true ? 'snatches_xbt.php?id=' : 'snatches.php?id=' );
        $htmlout.= "<td class='text-center'><a href='$What_Script_S"."$id'>" . number_format($row["times_completed"]) . "<br />$_s</a></td>\n";
        if ($row["seeders"]) {
            if ($variant == "index") {
                if ($row["leechers"]) $ratio = $row["seeders"] / $row["leechers"];
                else $ratio = 1;
                $What_Script_P = (XBT_TRACKER == true ? 'peerlist_xbt.php?id=' : 'peerlist.php?id=' );
                $htmlout.= "<td class='text-right'><b><a href='$What_Script_P"."$id#seeders'><font color='" . get_slr_color($ratio) . "'>" . (int)$row["seeders"] . "</font></a></b></td>\n";
            } else {
                $What_Script_P = (XBT_TRACKER == true ? 'peerlist_xbt.php?id=' : 'peerlist.php?id=' );
                $htmlout.= "<td class='text-right'><b><a class='" . linkcolor($row["seeders"]) . "' href='$What_Script_P"."$id#seeders'>" . (int)$row["seeders"] . "</a></b></td>\n";
            }
        } else {
            $htmlout.= "<td class='text-right'><span class='" . linkcolor($row["seeders"]) . "'>" . (int)$row["seeders"] . "</span></td>\n";
        }
        if ($row["leechers"]) {
            $What_Script_P = (XBT_TRACKER == true ? 'peerlist_xbt.php?id=' : 'peerlist.php?id=' );
            if ($variant == "index") $htmlout.= "<td class='text-right'><b><a href='$What_Script_P"."$id#leechers'>" . number_format($row["leechers"]) . "</a></b></td>\n";
            else $htmlout.= "<td class='text-right'><b><a class='" . linkcolor($row["leechers"]) . "' href='$What_Script_P"."$id#leechers'>" . (int)$row["leechers"] . "</a></b></td>\n";
        } else $htmlout.= "<td class='text-right'>0</td>\n";
        if ($variant == "index") {
            $htmlout.= "<td class='text-center'>" . (isset($row["username"]) ? (($row["anonymous"] == "yes" && $CURUSER['class'] < UC_STAFF && $row['owner'] != $CURUSER['id']) ? "<i>" . $lang['torrenttable_anon'] . "</i>" : "<a href='userdetails.php?id=" . (int)$row["owner"] . "'><b>" . htmlsafechars($row["username"]) . "</b></a>") : "<i>(" . $lang["torrenttable_unknown_uploader"] . ")</i>") . "</td>\n";
        } 
        if ($CURUSER['class'] >= UC_STAFF)  {
                $url = "edit.php?id=" .(int)$row["id"];
        if (isset($_GET["returnto"])) {
            $addthis = "&amp;returnto=" . urlencode($_GET["returnto"]);
            $url .= $addthis;
        }

        $editlink = "a href=\"$url\" class=\"sublink\"";
        $del_link = ($CURUSER['class'] === UC_MAX ? "<a href='fastdelete.php?id=".(int)$row['id']."'>&nbsp;<img src='{$INSTALLER09['pic_base_url']}button_delete2.gif' alt='Fast Delete' title='Fast Delete' /></a>" : "");
        $htmlout .= "<td class='text-center'><$editlink><img src='{$INSTALLER09['pic_base_url']}button_edit2.gif' alt='Fast Edit' title='Fast Edit' /></a>{$del_link}</td>\n";
        }
if (!function_exists('health')) {
    function health($leechers, $seeders)
    {
        global $INSTALLER09;
        if ($leechers > 0 && $seeders > 0) $ratio = $seeders / $leechers * 100;
        if ($leechers == 1 && $seeders == 1) $ratio = $seeders / $leechers * 1;
        if (($leechers == 0 && $seeders == 0) || ($leechers > 0 && $seeders == 0)) return "<img src=' " . $INSTALLER09['baseurl'] . "/images/health/health_0.gif' alt='Torrent Dead' title='Torrent Dead' />";
        elseif ($seeders > $leechers) return "<img src=' " . $INSTALLER09['baseurl'] . "/images/health/health_10.gif' alt='Torrent health' title='Torrent health' />";
        switch ($ratio) {
        case $ratio > 0 && $ratio < 15:
            return "<img src=' " . $INSTALLER09['baseurl'] . "/images/health/health_1.gif' alt='Torrent health' title='Torrent health' />";
            break;
         case $ratio >= 15 && $ratio < 25:
            return "<img src=' " . $INSTALLER09['baseurl'] . "/images/health/health_2.gif' alt='Torrent health' title='Torrent health' />";
            break;
         case $ratio >= 25 && $ratio < 35:
            return "<img src=' " . $INSTALLER09['baseurl'] . "/images/health/health_3.gif' alt='Torrent health' title='Torrent health' />";
            break;
         case $ratio >= 35 && $ratio < 45:
            return "<img src=' " . $INSTALLER09['baseurl'] . "/images/health/health_4.gif' alt='Torrent health' title='Torrent health' />";
            break;
         case $ratio >= 45 && $ratio < 55:
            return "<img src=' " . $INSTALLER09['baseurl'] . "/images/health/health_5.gif' alt='Torrent health' title='Torrent health' />";
            break;
         case $ratio >= 55 && $ratio < 65:
            return "<img src=' " . $INSTALLER09['baseurl'] . "/images/health/health_6.gif' alt='Torrent health' title='Torrent health' />";
            break;
         case $ratio >= 65 && $ratio < 75:
            return "<img src=' " . $INSTALLER09['baseurl'] . "/images/health/health_7.gif' alt='Torrent health' title='Torrent health' />";
            break;
         case $ratio >= 75 && $ratio < 85:
            return "<img src=' " . $INSTALLER09['baseurl'] . "/images/health/health_8.gif' alt='Torrent health' title='Torrent health' />";
            break;
         case $ratio >= 85 && $ratio < 95:
            return "<img src=' " . $INSTALLER09['baseurl'] . "/images/health/health_9.gif' alt='Torrent health' title='Torrent health' />";
            break;
        }
    }
}
$htmlout.= "<td class='text-center'><span>" . health($row["leechers"], $row["seeders"]) . "</td>";
        $htmlout.= "</tr>\n";
        $htmlout.= "<tr id=\"kdescr" . (int)$row["id"] . "\" style=\"display:none;\"><td width=\"100%\" colspan=\"14\">" . format_comment($descr, false) . "</td></tr>\n";
    }
    $htmlout.= "</table></div>\n";
    return $htmlout;
}
?>
