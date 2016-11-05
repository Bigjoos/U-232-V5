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
require_once(__DIR__ . DIRECTORY_SEPARATOR . 'include' . DIRECTORY_SEPARATOR . 'bittorrent.php');
require_once(INCL_DIR . 'user_functions.php');
require_once(INCL_DIR . 'html_functions.php');
require_once(INCL_DIR . 'pager_functions.php');
dbconn();
loggedinorreturn();
$lang = array_merge(load_language('global'), load_language('hitandruns'));

$HTMLOUT = "";

$id = intval($_GET["id"]);

if (($CURUSER["class"] < UC_STAFF) && ($id != $CURUSER["id"])) {
    stderr("Error", "It appears that you do not have access to this page.");
}

if (!is_valid_id($id))
    stderr("Error", "It appears that you have entered an invalid id.");

$res = sql_query("SELECT * FROM users WHERE id = " . sqlesc($id)) or sqlerr(__FILE__, __LINE__);
$arr = mysqli_fetch_assoc($res);

if (!$arr)
    stderr("Error", "It appears that there is no user with that id.");

$res = sql_query("SELECT COUNT(*) FROM snatched WHERE userid =" . sqlesc($id) . " AND hit_and_run != '0'") or sqlerr(__FILE__, __LINE__);
$row     = mysqli_fetch_row($res);
$count   = $row[0];
$perpage = 25;

$pager = pager($perpage, $count, "?id=$id&amp");

if (!$count)
    stderr("No Hit And Runs", "<font class='statusbartext'>It appears that <a class='altlink_default' href='userdetails.php?id=" . intval($arr['id']) . "'>" . htmlsafechars($arr['username']) . "</a> currently has no hit and runs.</font>");

$r = sql_query("SELECT torrents.name,torrents.added AS torrent_added, snatched.start_date AS s, snatched.complete_date AS c, snatched.downspeed, snatched.seedtime, snatched.seeder, snatched.torrentid as tid, snatched.id, categories.id as category, categories.image, categories.name as catname, users.class, users.id, snatched.uploaded, snatched.downloaded, snatched.hit_and_run, snatched.mark_of_cain, snatched.complete_date, snatched.last_action, torrents.seeders, torrents.leechers, torrents.owner, snatched.start_date AS st, snatched.start_date FROM snatched JOIN users ON users.id = snatched.userid JOIN torrents ON torrents.id = snatched.torrentid JOIN categories ON categories.id = torrents.category WHERE snatched.finished='yes' AND userid=" . sqlesc($id) . " AND snatched.hit_and_run != '0' AND torrents.owner != " . sqlesc($id) . " ORDER BY snatched.id DESC {$pager['limit']}") or sqlerr(__FILE__, __LINE__);
if (mysqli_num_rows($r) > 0) {
    
    $HTMLOUT .= "<div class='disclaimer'>
        <div style='background:#0C0C0C;height:25px;'>
        <table class='clear' width='100%' border='0'>
        <tr>
        <td width='100%' class='clear2'>
       <font class='statusbartext' size='2'>Hit and Runs for user: <a class='altlink' href='{$INSTALLER09['baseurl']}/userdetails.php?id=" . intval($arr['id']) . "'>" . htmlsafechars($arr['username']) . "</a></font></td>
      </tr>
    </table>
    </div>
    <div style='text-align:left;width:99%;border:1px solid #B4B4B4;background:#4F4F4F;'>\n";
    if ($count > $perpage)
        $HTMLOUT .= $pager['pagertop'];
    $HTMLOUT .= "<table width='100%' border='0'>
      <tr>
        <td class='colhead'>{$lang['hnr_type']}</td>
        <td class='colhead'>{$lang['hnr_name']}</td>
        <td class='colhead' align='center'>{$lang['hnr_ul']}</td>
        <td class='colhead' align='center'>{$lang['hnr_dl']}</td>
        <td class='colhead' align='center'>{$lang['hnr_ratio']}</td>
        <td class='colhead' align='center'>{$lang['hnr_seeded']}</td>
        <td class='colhead' align='center'>{$lang['hnr_wcompleted']}</td>
    </tr>\n";
    
    while ($a = mysqli_fetch_assoc($r)) {
        $S_date                   = (XBT_TRACKER === true ? $a['started'] : $a['start_date']);
        $torrent_needed_seed_time = $a['seedtime'];
        //=== get times per class
        switch (true) {
            case ($a['class'] < UC_POWER_USER):
                $days_3       = 3 * 86400; //== 3 days
                $days_14      = 2 * 86400; //== 2 days
                $days_over_14 = 86400; //== 1 day
                break;
            
            case ($a['class'] < UC_STAFF):
                $days_3       = 2 * 86400; //== 2 days
                $days_14      = 129600; //== 36 hours
                $days_over_14 = 64800; //== 18 hours
                break;
            
            case ($a['class'] >= UC_STAFF):
                $days_3       = 86400; //== 24 hours
                $days_14      = 43200; //== 12 hours
                $days_over_14 = 21600; //== 6 hours
                break;
        }
        switch (true) {
            case (($S_date - $a['torrent_added']) < 7 * 86400):
                $minus_ratio = ($days_3 - $torrent_needed_seed_time);
                // or using ratio
                //$minus_ratio = ($days_3 - $torrent_needed_seed_time) - ($hit_and_run_arr['uload'] / $hit_and_run_arr['dload'] * 3 * 86400);
                break;
            
            case (($S_date - $a['torrent_added']) < 21 * 86400):
                $minus_ratio = ($days_14 - $torrent_needed_seed_time);
                // or using ratio
                //$minus_ratio = ($days_14 - $torrent_needed_seed_time) - ($hit_and_run_arr['uload'] / $hit_and_run_arr['dload'] * 2 * 86400);
                break;
            
            case (($S_date - $a['torrent_added']) >= 21 * 86400):
                $minus_ratio = ($days_over_14 - $torrent_needed_seed_time);
                // or using ratio
                //$minus_ratio = ($days_over_14 - $torrent_needed_seed_time) - ($hit_and_run_arr['uload'] / $hit_and_run_arr['dload'] * 86400);
                break;
        }
        $minus_ratio         = (preg_match("/-/i", $minus_ratio) ? 0 : $minus_ratio);
        $color               = ($minus_ratio > 0 ? get_ratio_color($minus_ratio) : 'limegreen');
        //=== mark of cain / hit and run
        $checkbox_for_delete = ($CURUSER['class'] >= UC_STAFF ? " [<a class='altlink' href='" . $INSTALLER09['baseurl'] . "/hnr.php?id=" . $id . "&amp;delete_hit_and_run=" . intval($a['id']) . "'>Remove</a>]" : '');
        $mark_of_cain        = ($a['mark_of_cain'] == 'yes' ? "<img src='{$INSTALLER09['pic_base_url']}moc.gif' width='40px' alt='Mark Of Cain' title='the mark of Cain!' />" : '');
        $hit_n_run           = ($a['hit_and_run'] > 0 ? "<img src='{$INSTALLER09['pic_base_url']}hnr.gif' width='40px' alt='hit and run' title='hit and run!' />" : '');
        
        $HTMLOUT .= "<tr>
      <td style='padding: 0px'><img src='{$INSTALLER09['pic_base_url']}caticons/{$CURUSER['categorie_icon']}/" . htmlsafechars($a['image']) . "' alt='" . htmlsafechars($a['name']) . "' title='" . htmlsafechars($a['name']) . "' /></td>
        <td><a class='altlink' href='{$INSTALLER09['baseurl']}/details.php?id=" . $a['tid'] . "&amp;hit=1'><b>" . CutName($a['name'], 25) . "</b></a></td>
        <td align='center'>" . mksize($a['uploaded']) . "</td>
        <td align='center'>" . mksize($a['downloaded']) . "</td>
        <td align='center'>" . ($a['downloaded'] > 0 ? "<font color='" . get_ratio_color(number_format($a['uploaded'] / $a['downloaded'], 3)) . "'>" . number_format($a['uploaded'] / $a['downloaded'], 3) . "</font>" : ($a['uploaded'] > 0 ? 'Inf.' : '---')) . "<br /></td>
        <td align='center'>  " . (($CURUSER['class'] >= UC_MODERATOR || $arr['id'] == $CURUSER['id']) ? "" . mkprettytime($a['seedtime']) . (($minus_ratio != '0:00' && $a['uploaded'] < $a['downloaded']) ? "<br /><b>Remaining:</b><br />" . mkprettytime($minus_ratio) . "&nbsp;&nbsp;" : '') . ($a['seeder'] == 'yes' ? "<br /><font color='green'>[<b>seeding</b>]</font>" : $hit_n_run . "&nbsp;" . $mark_of_cain) : '') . "</td>
        <td align='center'>" . get_date($a['complete_date'], 'DATE') . "<br /><b>Last Action:</b><br />" . get_date($a['last_action'], 'DATE') . "</td></tr>\n";
    }
    $HTMLOUT .= "</table>\n";
    if ($count > $perpage)
        $HTMLOUT .= $pager['pagerbottom'];
    $HTMLOUT .= "</div></div>\n";
}

echo stdhead('Hit And Runs') . $HTMLOUT . stdfoot();
die;
?> 
