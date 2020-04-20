<?php
/**
 * |--------------------------------------------------------------------------|
 * |   https://github.com/Bigjoos/                                            |
 * |--------------------------------------------------------------------------|
 * |   Licence Info: WTFPL                                                    |
 * |--------------------------------------------------------------------------|
 * |   Copyright (C) 2010 U-232 V5                                            |
 * |--------------------------------------------------------------------------|
 * |   A bittorrent tracker source based on TBDev.net/tbsource/bytemonsoon.   |
 * |--------------------------------------------------------------------------|
 * |   Project Leaders: Mindless, Autotron, whocares, Swizzles.               |
 * |--------------------------------------------------------------------------|
 * _   _   _   _   _     _   _   _   _   _   _     _   _   _   _
 * / \ / \ / \ / \ / \   / \ / \ / \ / \ / \ / \   / \ / \ / \ / \
 * ( U | - | 2 | 3 | 2 )-( S | o | u | r | c | e )-( C | o | d | e )
 * \_/ \_/ \_/ \_/ \_/   \_/ \_/ \_/ \_/ \_/ \_/   \_/ \_/ \_/ \_/
 *
 * @param mixed $num
 */
function linkcolor($num)
{
    if (!$num) {
        return "red";
    }
    return "pink";
}
function readMore($text, $char, $link)
{
    return (strlen($text) > $char ? substr(htmlsafechars($text), 0, $char - 1) . "...<br /><a href='$link'>Read more...</a>" : htmlsafechars($text));
}
function torrenttable($res, $variant = "index")
{
    global $INSTALLER09, $CURUSER, $lang, $free, $cache;
    require_once(INCL_DIR . 'bbcode_functions.php');
    require_once(CLASS_DIR . 'class_user_options_2.php');
    $htmlout = $prevdate = $nuked = $free_slot = $freetorrent = $free_color = $slots_check = $double_slot = $private = $newgenre = $oldlink = $char = $description = $type = $sort = $row = $youtube = '';
    $count_get = 0;
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
            Expires: ' . get_date($fl['expires'], 'DATE') . '<br />            (' . mkprettytime($fl['expires'] - TIME_NOW) . ' to go)</span></a><br />' : 'Unlimited</span></a><br />') : '');
    }
    $oldlink = [];
    foreach ($_GET as $key => $var) {
        if (in_array($key, [
            'sort',
            'type'
        ])) {
            continue;
        }
        if (is_array($var)) {
            foreach ($var as $s_var) {
                $oldlink[] = sprintf('%s=%s', urlencode($key) . '%5B%5D', urlencode($s_var));
            }
        } else {
            $oldlink[] = sprintf('%s=%s', urlencode($key), urlencode($var));
        }
    }
    $oldlink = !empty($oldlink) ? join('&amp;', array_map('htmlsafechars', $oldlink)) . '&amp;' : '';
    $links = [
        'link1',
        'link2',
        'link3',
        'link4',
        'link5',
        'link6',
        'link7',
        'link8',
        'link9'
    ];
    $i = 1;
    foreach ($links as $link) {
        if (isset($_GET['sort']) && $_GET['sort'] == $i) {
            $$link = (isset($_GET['type']) && $_GET['type'] == 'desc') ? 'asc' : 'desc';
        } else {
            $$link = 'desc';
        }
        $i++;
    }
    while ($row = mysqli_fetch_assoc($res)) {
        //==
        if ($CURUSER['opt2'] & user_options_2::SPLIT) {
            if (get_date($row['added'], 'DATE') == $prevdate) {
                $cleandate = '';
            } else {
                $htmlout.= "<!--<b>{$lang['torrenttable_upped']} " . get_date($row['added'], 'DATE') . "</b>-->";
            }
            $prevdate = get_date($row['added'], 'DATE');
        }
        $imdb = "<b>IMDB:&nbsp;" . (preg_match('/imdb.com.*tt\d{2,}/i', $row['url']) ? "<a href='{$row['url']}' target='_blank'>Click Here</a>" : "None listed") . "</b><br />";
        $htmlout .= "<div class='container'><div class='row'>
<div class='col-sm-3 col-sm-offset-0 panel panel-default browsep'>";
        $htmlout.="<br /><table class='table table-bordered' >";
        $id = (int) $row["id"];
        foreach ($slot as $sl) {
            $slots_check = ($sl['torrentid'] == $id && $sl['free'] == 'yes' or $sl['doubleup'] == 'yes');
        }
        if ($row["sticky"] == "yes") {
            $htmlout.= "<tr class='highlight'>\n";
        } else {
            $htmlout.= '<tr class="' . (($free_color && $all_free_tag != '') || ($row['free'] != 0) || $slots_check ? 'freeleech_color' : 'browse_color') . '">';
        }
        $htmlout.= "";
        $dispname = htmlsafechars($row["name"]);
        $htmlout .="<div style='display:block; height:5px;'></div>
<a href='details.php?id=$id'><div class='text-center squashp browsed'>$dispname</a></div><div style='display:block; height:5px;'></div>";
        $categories = genrelist();
        foreach ($categories as $key => $value) {
            $change[$value['id']] = [
                'id' => $value['id'],
                'name' => $value['name'],
                'image' => $value['image'],
                'min_class' => $value['min_class']
            ];
        }
        $row['cat_name'] = htmlsafechars($change[$row['category']]['name']);
        $row['cat_pic'] = htmlsafechars($change[$row['category']]['image']);
        $row['min_class'] = htmlsafechars($change[$row['category']]['min_class']);
        $htmlout .="<div style='display:block; height:5px;'></div><a href='details.php?id=$id'><div class='text-center browsepd'>";
        if (!empty($row["poster"]) && isset($row["cat_pic"]) && $row["cat_pic"] != "") {
            $htmlout.= "<img src='{$INSTALLER09['pic_base_url']}caticons/{$CURUSER['categorie_icon']}/{$row['cat_pic']}' alt='{$row['cat_name']}' class='overlay'><img src='" . htmlsafechars($row["poster"]) . "' alt='Poster' title='Poster' class='tt''>";
        }
        if (empty($row["poster"]) && isset($row["cat_pic"]) && $row["cat_pic"] != "") {
            $htmlout.= "<img src='{$INSTALLER09['pic_base_url']}caticons/{$CURUSER['categorie_icon']}/{$row['cat_pic']}' alt='{$row['cat_name']}' class='overlaynp'><img src='{$INSTALLER09['pic_base_url']}noposter.png' class='tt'><br />";
        }
        $htmlout .="</div></a><div style='display:block; height:5px;'></div>";
        $htmlout .="<div class='text-center browsepd'>";
        if ($variant == "mytorrents") {
            $htmlout.= "<a class='btn btn-primary' href=\"download.php?torrent={$id}" . ($CURUSER['ssluse'] == 3 ? "&amp;ssl=1" : "") . "\"><img src='{$INSTALLER09['pic_base_url']}zip.gif' border='0' alt='Download This Torrent!' title='Download This Torrent!' /></a>\n";
        }
        if ($variant == "mytorrents") {
            $htmlout.= "<button class='btn btn-primary'><a href='edit.php?id=" . (int) $row['id'] . "amp;returnto=" . urlencode($_SERVER["REQUEST_URI"]) . "'>{$lang["torrenttable_edit"]}</a></button>\n";
        }
        $htmlout.= ($variant == "index" ? "DOWNLOAD&nbsp;<a class='btn btn-primary' href=\"download.php?torrent={$id}" . ($CURUSER['ssluse'] == 3 ? "&amp;ssl=1" : "") . "\"><img src='{$INSTALLER09['pic_base_url']}zip.gif' border='0' alt='Download This Torrent!' title='Download This Torrent!' /></a></button>" : "");
        if ($variant == "mytorrents") {
            $htmlout.= "test";
            if ($row["visible"] == "no") {
                $htmlout.= "<b>{$lang["torrenttable_not_visible"]}</b>";
            } else {
                $htmlout.= "{$lang["torrenttable_visible"]}";
            }
            $htmlout.= "<!--<br />-->";
        }
        $htmlout .="</div>";
        $booked = '';
        if (!empty($book)) {
            foreach ($book as $bk) {
                if ($bk['torrentid'] == $id) {
                    $booked = 1;
                }
            }
        }
        $rm_status = (!$booked ? ' style="display:none;"' : ' style="display:inline;"');
        $bm_status = ($booked ? ' style="display:none;"' : ' style="display:inline;"');
        $bookmark = '<div style="display:block; height:5px;"></div><div class="browsemp">
<b>Bookmark This:</b>&nbsp;<span id="bookmark' . $id . '"' . $bm_status . '><a href="bookmark.php?torrent=' . $id . '&amp;action=add" class="bookmark" name="' . $id . '"><span title="Bookmark it!" class="add_bookmark_b">
                    <img src="' . $INSTALLER09['pic_base_url'] . 'aff_tick.gif" align="top" width="14px" alt="Bookmark it!" title="Bookmark it!" />
                    </span>
                    </a>
                    </span>
                    <span id="remove' . $id . '"' . $rm_status . '>
                    <a href="bookmark.php?torrent=' . $id . '&amp;action=delete" class="remove" name="' . $id . '">
                    <span class="remove_bookmark_b"><img src="' . $INSTALLER09['pic_base_url'] . 'aff_cross.gif" align="top" width="14px" alt="Delete Bookmark!" title="Delete Bookmark!" />
                    </span>
                    </a>
                    </span><br />';
        if ($variant == "index") {
            $htmlout.= "{$bookmark}";
        }
        $Subs = '';
        if (in_array($row["category"], $INSTALLER09['movie_cats']) && !empty($row["subs"])) {
            $subs_array = explode(",", $row["subs"]);
            require_once(CACHE_DIR . 'subs.php');
            foreach ($subs_array as $k => $sid) {
                foreach ($subs as $sub) {
                    if ($sub["id"] == $sid) {
                        $Subs = "<img border='0' width='16px' style='padding:3px;' src='" . htmlsafechars($sub["pic"]) . "' alt='" . htmlsafechars($sub["name"]) . "' title='" . htmlsafechars($sub["name"]) . "' />";
                    }
                }
            }
        } else {
            $Subs = "---";
        }
        if ($row["type"] == "single") {
            $htmlout.= "<b>Files:</b>" . (int) $row["numfiles"] . "<br />";
        } else {
            if ($variant == "index") {
                $htmlout.= "<b>Files:&nbsp;<a href='filelist.php?id=$id'>" . (int) $row["numfiles"] . "</a></b><br />";
            } else {
                $htmlout.= "<b>Files:&nbsp;<a href='filelist.php?id=$id'>" . (int) $row["numfiles"] . "</a></b><br />";
            }
        }
        $htmlout.= "Size:&nbsp;" . str_replace(" ", " ", mksize($row["size"])) . "\n";
        if ($row["times_completed"] != 1) {
            $_s = "" . $lang["torrenttable_time_plural"] . "";
        } else {
            $_s = "" . $lang["torrenttable_time_singular"] . "";
        }
        $What_Script_S = (XBT_TRACKER == true ? 'snatches_xbt.php?id=' : 'snatches.php?id=');
        $htmlout.= "<br />Snatches:<a href='$What_Script_S" . "$id'>$_s&nbsp;<b>downloaded</b>&nbsp;" . number_format($row["times_completed"]) . "</a>\n";
        if ($row["seeders"]) {
            if ($variant == "index") {
                if ($row["leechers"]) {
                    $ratio = $row["seeders"] / $row["leechers"];
                } else {
                    $ratio = 1;
                }
                $What_Script_P = (XBT_TRACKER == true ? 'peerlist_xbt.php?id=' : 'peerlist.php?id=');
                $htmlout.= "<br /><b>Seeders:</b>&nbsp;<b><a href='$What_Script_P" . "$id#seeders'><font color='" . get_slr_color($ratio) . "'>" . (int) $row["seeders"] . "</font></a></b>&nbsp;\n";
            } else {
                $What_Script_P = (XBT_TRACKER == true ? 'peerlist_xbt.php?id=' : 'peerlist.php?id=');
                $htmlout.= "<br /><b>Seeders:</b>&nbsp;<b><a class='" . linkcolor($row["seeders"]) . "' href='$What_Script_P" . "$id#seeders'>" . (int) $row["seeders"] . "</a></b>&nbsp;\n";
            }
        } else {
            $htmlout.= "<br /><b>Seeders:</b>&nbsp;<span class='" . linkcolor($row["seeders"]) . "'>" . (int) $row["seeders"] . "</span>\n";
        }
        if ($row["leechers"]) {
            $What_Script_P = (XBT_TRACKER == true ? 'peerlist_xbt.php?id=' : 'peerlist.php?id=');
            if ($variant == "index") {
                $htmlout.= "<b><a href='$What_Script_P" . "$id#leechers'>" . number_format($row["leechers"]) . "</a></b>\n";
            } else {
                $htmlout.= "<b><a class='" . linkcolor($row["leechers"]) . "' href='$What_Script_P" . "$id#leechers'>" . (int) $row["leechers"] . "</a></b>\n";
            }
        } else {
            $htmlout.= "<b>Leechers:</b>&nbsp;0\n";
        }
        if ($variant == "index") {
            $htmlout.= "<br /><b>Upped By:</b>&nbsp;" . (isset($row["username"]) ? (($row["anonymous"] == "yes" && $CURUSER['class'] < UC_STAFF && $row['owner'] != $CURUSER['id']) ? "<i>" . $lang['torrenttable_anon'] . "</i>" : "<a href='userdetails.php?id=" . (int) $row["owner"] . "'><b>" . htmlsafechars($row["username"]) . "</b></a>") : "<i>(" . $lang["torrenttable_unknown_uploader"] . ")</i>") . "\n";
        }
        if ($CURUSER['class'] >= UC_STAFF) {
            $url = "edit.php?id=" . (int) $row["id"];
            if (isset($_GET["returnto"])) {
                $addthis = "&amp;returnto=" . urlencode($_GET["returnto"]);
                $url .= $addthis;
            }
            $editlink = "a href=\"$url\" class=\"sublink\"";
            $del_link = ($CURUSER['class'] === UC_MAX ? "<a href='fastdelete.php?id=" . (int) $row['id'] . "'>&nbsp;<img src='pic/button_delete2.gif' alt='Fast Delete' title='Fast Delete' /></a>" : "");
            $htmlout.="<br />
<b>Added:&nbsp;" . get_date($row['added'], 'DATE') . "</b><br />" . $imdb . "<b>Subtitle:&nbsp;{$Subs}</b><br />";
            if (!$row["comments"]) {
                $htmlout.= "<b>Comments:</b>&nbsp;" . (int) $row["comments"] . "\n";
            } else {
                if ($variant == "index") {
                    $htmlout.= "<b>Comments:</b>&nbsp;<b><a href='details.php?id=$id&amp;hit=1&amp;tocomm=1'>" . (int) $row["comments"] . "</a></b>\n";
                } else {
                    $htmlout.= "<b>Comments:</b>&nbsp;<b><a href='details.php?id=$id&amp;page=0#startcomments'>" . (int) $row["comments"] . "</a></b>\n";
                }
            }
            if ($CURUSER['class'] >= UC_STAFF) {
                $htmlout .= "<br /><b>Tools:</b>&nbsp;";
            }
            $htmlout .= "<$editlink><img src='pic/button_edit2.gif' alt='Fast Edit' title='Fast Edit' /></a>{$del_link}";
        }
        $htmlout .= "</div></table><br /></div><div style='display:block;width:5px;'></div>";
    }
    $htmlout.= "</div></div>\n";
    return $htmlout;
}
