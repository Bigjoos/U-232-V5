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
 */
//=== start snatched
$count_snatched_staff = 0;
function snatchtable_staff($res)
{
    global $INSTALLER09, $lang, $CURUSER, $id;
    $htmlout_snatch = '';
    $count2 = 0;
//    $htmlout_snatch .= "<tr><td class='one' align='right' valign='top'><b>{$lang['userdetails_snatched']}</b></td><td class='one'>";
    $htmlout_snatch .= "<table border='1' cellspacing='0' cellpadding='5' align='center'><tr><td class='colhead' align='center'>{$lang['userdetails_s_cat']}</td><td class='colhead' align='left'>{$lang['userdetails_s_torr']}</td>" . "<td class='colhead' align='center'>{$lang['userdetails_s_sl']}</td><td class='colhead' align='center'>{$lang['userdetails_s_up']}" . ($INSTALLER09['ratio_free'] ? "" : "{$lang['userdetails_s_down']}") . "</td><td class='colhead' align='center'>{$lang['userdetails_s_tsize']}</td>" . "<td class='colhead' align='center'>{$lang['userdetails_ratio']}</td><td class='colhead' align='center'>{$lang['userdetails_client']}</td></tr>";
    while ($arr = mysqli_fetch_assoc($res)) {
        //=======change colors
        $count2 = (++$count2) % 2;
        $class = ($count2 == 0 ? 'one' : 'two');
        //=== speed color red fast green slow ;)
        if ($arr["upspeed"] > 0) {
            $ul_speed = ($arr["upspeed"] > 0 ? mksize($arr["upspeed"]) : ($arr["seedtime"] > 0 ? mksize($arr["uploaded"] / ($arr["seedtime"] + $arr["leechtime"])) : mksize(0)));
        } else {
            $ul_speed = mksize(($arr["uploaded"] / ($arr['l_a'] - $arr['s'] + 1)));
        }
        if ($arr["downspeed"] > 0) {
            $dl_speed = ($arr["downspeed"] > 0 ? mksize($arr["downspeed"]) : ($arr["leechtime"] > 0 ? mksize($arr["downloaded"] / $arr["leechtime"]) : mksize(0)));
        } else {
            $dl_speed = mksize(($arr["downloaded"] / ($arr['c'] - $arr['s'] + 1)));
        }
        switch (true) {
            case ($dl_speed > 600):
                $dlc = 'red';
                break;

            case ($dl_speed > 300):
                $dlc = 'orange';
                break;

            case ($dl_speed > 200):
                $dlc = 'yellow';
                break;

            case ($dl_speed < 100):
                $dlc = 'Chartreuse';
                break;
        }
        if ($arr["downloaded"] > 0) {
            $ratio = number_format($arr["uploaded"] / $arr["downloaded"], 3);
            $ratio = "<font color='" . get_ratio_color($ratio) . "'><b>{$lang['userdetails_s_ratio']}</b><br />$ratio</font>";
        } elseif ($arr["uploaded"] > 0) {
            $ratio = $lang['userdetails_inf'];
        } else {
            $ratio = "N/A";
        }
        if (XBT_TRACKER === false) {
            $htmlout_snatch .= "<tr><td class='$class' align='center'>" . ($arr['owner'] == $id ? "<b><font color='orange'>{$lang['userdetails_s_towner']}</font></b><br />" : "" . ($arr['complete_date'] != '0' ? "<b><font color='lightgreen'>{$lang['userdetails_s_fin']}</font></b><br />" : "<b><font color='red'>{$lang['userdetails_s_nofin']}</font></b><br />") . "") . "<img src='{$INSTALLER09['pic_base_url']}caticons/{$CURUSER['categorie_icon']}/" . htmlsafechars($arr['image']) . "' alt='" . htmlsafechars($arr['name']) . "' title='" . htmlsafechars($arr['name']) . "' /></td>" . "
    <td class='$class'><a class='altlink' href='{$INSTALLER09['baseurl']}/details.php?id=" . (int) $arr['torrentid'] . "'><b>" . htmlsafechars($arr['torrent_name']) . "</b></a>" . ($arr['complete_date'] != '0' ? "<br /><font color='yellow'>{$lang['userdetails_s_started']}" . get_date($arr['start_date'], 0, 1) . "</font><br />" : "<font color='yellow'>{$lang['userdetails_s_started']}" . get_date($arr['start_date'], 0, 1) . "</font><br /><font color='orange'>{$lang['userdetails_s_laction']}" . get_date($arr['last_action'], 0, 1) . "</font>" . get_date($arr['complete_date'], 0, 1) . " " . ($arr['complete_date'] == '0' ? "" . ($arr['owner'] == $id ? "" : "[ " . mksize($arr["size"] - $arr["downloaded"]) . "{$lang['userdetails_s_still']}]") . "" : "") . "") . $lang['userdetails_s_finished'] . get_date($arr['complete_date'], 0, 1) . "" . ($arr['complete_date'] != '0' ? "<br /><font color='silver'>{$lang['userdetails_s_ttod']}" . ($arr['leechtime'] != '0' ? mkprettytime($arr['leechtime']) : mkprettytime($arr['c'] - $arr['s']) . "") . "</font> <font color='$dlc'>[ {$lang['userdetails_s_dled']} $dl_speed ]</font><br />" : "<br />") . "<font color='lightblue'>" . ($arr['seedtime'] != '0' ? $lang['userdetails_s_tseed'] . mkprettytime($arr['seedtime']) . " </font><font color='$dlc'> " : $lang['userdetails_s_tseedn']) . "</font><font color='lightgreen'> [ {$lang['userdetails_s_uspeed']} " . $ul_speed . " ] </font>" . ($arr['complete_date'] == '0' ? "<br /><font color='$dlc'>{$lang['userdetails_s_dspeed']}$dl_speed</font>" : "") . "</td>" . "
    <td align='center' class='$class'>{$lang['userdetails_s_seed']}" . (int) $arr['seeders'] . "<br />{$lang['userdetails_s_leech']}" . (int) $arr['leechers'] . "</td><td align='center' class='$class'><font color='lightgreen'>{$lang['userdetails_s_upld']}<br /><b>" . mksize($arr["uploaded"]) . "</b></font>" . ($INSTALLER09['ratio_free'] ? "" : "<br /><font color='orange'>{$lang['userdetails_s_dld']}<br /><b>" . mksize($arr["downloaded"]) . "</b></font>") . "</td><td align='center' class='$class'>" . mksize($arr["size"]) . "" . ($INSTALLER09['ratio_free'] ? "" : "<br />{$lang['userdetails_s_diff']}<br /><font color='orange'><b>" . mksize($arr['size'] - $arr["downloaded"]) . "</b></font>") . "</td><td align='center' class='$class'>" . $ratio . "<br />" . ($arr['seeder'] == 'yes' ? "<font color='lightgreen'><b>{$lang['userdetails_s_seeding']}</b></font>" : "<font color='red'><b>{$lang['userdetails_s_nseeding']}</b></font>") . "</td><td align='center' class='$class'>" . htmlsafechars($arr["agent"]) . "<br />{$lang['userdetails_s_port']}" . (int) $arr["port"] . "<br />" . ($arr["connectable"] == 'yes' ? "<b>{$lang['userdetails_s_conn']}</b> <font color='lightgreen'>{$lang['userdetails_yes']}</font>" : "<b>{$lang['userdetails_s_conn']}</b> <font color='red'><b>{$lang['userdetails_no']}</b></font>") . "</td></tr>\n";
        } else {
            $htmlout_snatch .= "<tr><td class='$class' align='center'>" . ($arr['owner'] == $id ? "<b><font color='orange'>{$lang['userdetails_s_towner']}</font></b><br />" : "" . ($arr['completedtime'] != '0' ? "<b><font color='lightgreen'>{$lang['userdetails_s_fin']}</font></b><br />" : "<b><font color='red'>{$lang['userdetails_s_nofin']}</font></b><br />") . "") . "<img src='{$INSTALLER09['pic_base_url']}caticons/{$CURUSER['categorie_icon']}/" . htmlsafechars($arr['image']) . "' alt='" . htmlsafechars($arr['name']) . "' title='" . htmlsafechars($arr['name']) . "' /></td>" . "
    <td class='$class'><a class='altlink' href='{$INSTALLER09['baseurl']}/details.php?id=" . (int) $arr['fid'] . "'><b>" . htmlsafechars($arr['torrent_name']) . "</b></a>" . ($arr['completedtime'] != '0' ? "<br /><font color='yellow'>{$lang['userdetails_s_started']}" . get_date($arr['started'], 0, 1) . "</font><br />" : "<font color='yellow'>started:" . get_date($arr['started'], 0, 1) . "</font><br /><font color='orange'>{$lang['userdetails_s_laction']}" . get_date($arr['mtime'], 0, 1) . "</font>" . get_date($arr['completedtime'], 0, 1) . " " . ($arr['completedtime'] == '0' ? "" . ($arr['owner'] == $id ? "" : "[ " . mksize($arr["size"] - $arr["downloaded"]) . "{$lang['userdetails_s_still']}]") . "" : "") . "") . "{$lang['userdetails_s_finished']}" . get_date($arr['completedtime'], 0, 1) . "" . ($arr['completedtime'] != '0' ? "<br /><font color='silver'>{$lang['userdetails_s_ttod']}" . ($arr['leechtime'] != '0' ? mkprettytime($arr['leechtime']) : mkprettytime($arr['c'] - $arr['s']) . "") . "</font> <font color='$dlc'>[ {$lang['userdetails_s_dled']} $dl_speed ]</font><br />" : "<br />") . "<font color='lightblue'>" . ($arr['seedtime'] != '0' ? "{$lang['userdetails_s_tseed']}" . mkprettytime($arr['seedtime']) . " </font><font color='$dlc'> " : "{$lang['userdetails_s_tseedn']}") . "</font><font color='lightgreen'> [{$lang['userdetails_s_uspeed']}" . $ul_speed . " ] </font>" . ($arr['completedtime'] == '0' ? "<br /><font color='$dlc'>{$lang['userdetails_s_dspeed']} $dl_speed</font>" : "") . "</td>" . "
    <td align='center' class='$class'>{$lang['userdetails_s_seed']}" . (int) $arr['seeders'] . "<br />{$lang['userdetails_s_leech']}" . (int) $arr['leechers'] . "</td><td align='center' class='$class'><font color='lightgreen'>{$lang['userdetails_s_upld']}<br /><b>" . mksize($arr["uploaded"]) . "</b></font>" . ($INSTALLER09['ratio_free'] ? "" : "<br /><font color='orange'>{$lang['userdetails_s_dld']}<br /><b>" . mksize($arr["downloaded"]) . "</b></font>") . "</td><td align='center' class='$class'>" . mksize($arr["size"]) . "" . ($INSTALLER09['ratio_free'] ? "" : "<br />{$lang['userdetails_s_diff']}<br /><font color='orange'><b>" . mksize($arr['size'] - $arr["downloaded"]) . "</b></font>") . "</td><td align='center' class='$class'>" . $ratio . "<br />" . ($arr['active'] == 1 ? "<font color='lightgreen'><b>{$lang['userdetails_s_seeding']}</b></font>" : "<font color='red'><b>{$lang['userdetails_s_nseeding']}</b></font>") . "</td><td align='center' class='$class'>" . htmlsafechars($arr["peer_id"]) . "<br />" . ($arr["connectable"] == 1 ? "<b>{$lang['userdetails_s_conn']}</b> <font color='lightgreen'>{$lang['userdetails_yes']}</font>" : "<b>{$lang['userdetails_s_conn']}</b> <font color='red'><b>{$lang['userdetails_no']}</b></font>") . "</td></tr>\n";
        }
    }
    $htmlout_snatch .= "</table>\n";
    return $htmlout_snatch;
}
if ($CURUSER['class'] >= UC_STAFF) {
    if (XBT_TRACKER === false) {
        $res = sql_query("SELECT sn.start_date AS s, sn.complete_date AS c, sn.last_action AS l_a, sn.seedtime AS s_t, sn.seedtime, sn.leechtime AS l_t, sn.leechtime, sn.downspeed, sn.upspeed, sn.uploaded, sn.downloaded, sn.torrentid, sn.start_date, sn.complete_date, sn.seeder, sn.last_action, sn.connectable, sn.agent, sn.seedtime, sn.port, cat.name, cat.image, t.size, t.seeders, t.leechers, t.owner, t.name AS torrent_name " . "FROM snatched AS sn " . "LEFT JOIN torrents AS t ON t.id = sn.torrentid " . "LEFT JOIN categories AS cat ON cat.id = t.category " . "WHERE sn.userid=" . sqlesc($id) . " AND sn.torrentid IN (SELECT id FROM torrents) ORDER BY sn.start_date DESC") or sqlerr(__FILE__, __LINE__);
    } else {
        $res = sql_query("SELECT x.started AS s, x.completedtime AS c, x.mtime AS l_a, x.seedtime AS s_t, x.seedtime, x.leechtime AS l_t, x.leechtime, x.downspeed, x.upspeed, x.uploaded, x.downloaded, x.fid, x.started, x.completedtime, x.active, x.mtime, x.connectable, x.peer_id, cat.name, cat.image, t.size, t.seeders, t.leechers, t.owner, t.name AS torrent_name " . "FROM xbt_files_users AS x " . "LEFT JOIN torrents AS t ON t.id = x.fid " . "LEFT JOIN categories AS cat ON cat.id = t.category " . "WHERE x.uid=" . sqlesc($id) . " AND x.fid IN (SELECT id FROM torrents) ORDER BY x.started DESC") or sqlerr(__FILE__, __LINE__);
    }
    $count_snatched_staff = mysqli_num_rows($res);
    if (mysqli_num_rows($res) > 0) {
        $user_snatches_data_staff = snatchtable_staff($res);
    } else {
        $user_snatches_data_staff = $lang['userdetails_s_nothing'];
    }
    if (isset($user_snatches_data_staff)) {
        $HTMLOUT .= "<tr valign=\"top\"><td class=\"rowhead\" width=\"10%\">{$lang['userdetails_snatched']} of {$count_snatched_staff}<br /><font color='red'><b>{$lang['userdetails_s_staff']}</b></font> </td><td align=\"left\" width=\"90%\"><a href=\"javascript: klappe_news('a4')\"><img border=\"0\" src=\"pic/plus.png\" id=\"pica4\" alt=\"Show/Hide\" /></a><div id=\"ka4\" style=\"display: none;\">$user_snatches_data_staff</div></td></tr>\n";
    }
}

//=== end snatched
// End Class
// End File
