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
/*******************************
totally automatic hit and run script for TBDev 2011(ish)
~ snuggs
*********************************/
if (!defined('IN_INSTALLER09_ADMIN')) {
    $HTMLOUT = '';
    $HTMLOUT.= "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\"
		\"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">
		<html xmlns='http://www.w3.org/1999/xhtml'>
		<head>
		<title>Error!</title>
		</head>
		<body>
	<div style='font-size:33px;color:white;background-color:red;text-align:center;'>Incorrect access<br />You cannot access this file directly.</div>
	</body></html>";
    echo $HTMLOUT;
    exit();
}
require_once INCL_DIR . 'user_functions.php';
require_once INCL_DIR . 'bbcode_functions.php';
require_once INCL_DIR . 'pager_new.php';
require_once INCL_DIR . 'html_functions.php';
require_once (CLASS_DIR . 'class_check.php');
$class = get_access(basename($_SERVER['REQUEST_URI']));
class_check($class);
$lang = array_merge($lang, load_language('ad_hit_and_run'));
if(XBT_TRACKER === false) {
$query = (isset($_GET['really_bad']) ? 'SELECT COUNT(*) FROM snatched LEFT JOIN users ON users.id = snatched.userid WHERE snatched.finished = \'yes\' AND snatched.hit_and_run > 0 AND users.hit_and_run_total > 2' : 'SELECT COUNT(*) FROM `snatched` WHERE `finished` = \'yes\' AND `hit_and_run` > 0');
} else {
$query = (isset($_GET['really_bad']) ? 'SELECT COUNT(*) FROM xbt_files_users LEFT JOIN users ON users.id = xbt_files_users.uid WHERE xbt_files_users.completed >= \'1\' AND xbt_files_users.hit_and_run > 0 AND users.hit_and_run_total > 2' : 'SELECT COUNT(*) FROM `xbt_files_users` WHERE `completed` >= \'1\' AND `hit_and_run` > 0');
}
$HTMLOUT = '';
//=== get stuff for the pager
$page = isset($_GET['page']) ? (int)$_GET['page'] : 0;
$perpage = isset($_GET['perpage']) ? (int)$_GET['perpage'] : 15;
$res_count = sql_query($query) or sqlerr(__FILE__, __LINE__);
$arr_count = mysqli_fetch_row($res_count);
$count = ($arr_count[0] > 0 ? $arr_count[0] : 0);
list($menu, $LIMIT) = pager_new($count, $perpage, $page, 'staffpanel.php?tool=hit_and_run');
if(XBT_TRACKER === false) {
$query_2 = (isset($_GET['really_bad']) ? 'SELECT s.torrentid, s.userid, s.hit_and_run, s.downloaded AS dload, s.uploaded AS uload, s.seedtime, s.start_date, s.complete_date, p.id, p.torrent, p.seeder, u.id, u.avatar, u.username, u.uploaded AS up, u.downloaded AS down, u.class, u.hit_and_run_total, u.donor, u.warned, u.enabled, u.leechwarn, u.chatpost, u.pirate, u.king, u.suspended, t.owner, t.name, t.added AS torrent_added, t.seeders AS numseeding, t.leechers AS numleeching FROM snatched AS s LEFT JOIN users AS u ON u.id = s.userid LEFT JOIN peers AS p ON p.torrent=s.torrentid AND p.userid=s.userid LEFT JOIN torrents AS t ON t.id=s.torrentid WHERE finished = \'yes\' AND hit_and_run > 0 AND u.hit_and_run_total > 2 ORDER BY userid ' . $LIMIT : 'SELECT s.torrentid, s.userid, s.hit_and_run, s.downloaded AS dload, s.uploaded AS uload, s.seedtime, s.start_date, s.complete_date, p.id, p.torrent, p.seeder, u.id, u.avatar, u.username, u.uploaded AS up, u.downloaded AS down, u.class, u.hit_and_run_total, u.donor, u.warned, u.enabled, u.leechwarn, u.chatpost, u.pirate, u.king, u.suspended, t.owner, t.name, t.added AS torrent_added, t.seeders AS numseeding, t.leechers AS numleeching FROM snatched AS s LEFT JOIN users AS u ON u.id = s.userid LEFT JOIN peers AS p ON p.torrent=s.torrentid AND p.userid=s.userid LEFT JOIN torrents AS t ON t.id=s.torrentid WHERE `finished` = \'yes\' AND `hit_and_run` > 0 ORDER BY `userid` ' . $LIMIT);
} else {
$query_2 = (isset($_GET['really_bad']) ? 'SELECT x.fid, x.uid, x.hit_and_run, x.downloaded AS dload, x.uploaded AS uload, x.seedtime, x.started, x.completedtime, x.active, u.id, u.avatar, u.username, u.uploaded AS up, u.downloaded AS down, u.class, u.hit_and_run_total, u.donor, u.warned, u.enabled, u.leechwarn, u.chatpost, u.pirate, u.king, u.suspended, t.owner, t.name, t.added AS torrent_added, t.seeders AS numseeding, t.leechers AS numleeching FROM xbt_files_users AS x LEFT JOIN users AS u ON u.id = x.uid LEFT JOIN torrents AS t ON t.id=x.fid WHERE completed >= \'1\' AND hit_and_run > 0 AND u.hit_and_run_total > 2 ORDER BY uid ' . $LIMIT : 'SELECT x.fid, x.uid, x.hit_and_run, x.downloaded AS dload, x.uploaded AS uload, x.seedtime, x.started, x.completedtime, x.active, u.id, u.avatar, u.username, u.uploaded AS up, u.downloaded AS down, u.class, u.hit_and_run_total, u.donor, u.warned, u.enabled, u.leechwarn, u.chatpost, u.pirate, u.king, u.suspended, t.owner, t.name, t.added AS torrent_added, t.seeders AS numseeding, t.leechers AS numleeching FROM xbt_files_users AS x LEFT JOIN users AS u ON u.id = x.uid LEFT JOIN torrents AS t ON t.id=x.fid WHERE `completed` >= \'1\' AND `hit_and_run` > 0 ORDER BY `uid` ' . $LIMIT);
}
$hit_and_run_rez = sql_query($query_2) or sqlerr(__FILE__, __LINE__);
$HTMLOUT.= '<div class="row"><div class="col-md-12"><h2>' . (!isset($_GET['really_bad']) ? $lang['hitnrun_chance'] : $lang['hitnrun_nochance']) . '</h2><br /> 
		<a class="altlink" href="staffpanel.php?tool=hit_and_run">' . $lang['hitnrun_show_current'] . '</a> || <a class="altlink" href="staffpanel.php?tool=hit_and_run&amp;really_bad=show_them">' . $lang['hitnrun_show_disabled'] . '</a><br /><br />
		' . ($arr_count[0] > $perpage ? '<p>' . $menu . '</p>' : '') . '
		<table class="table table-bordered">' . (mysqli_num_rows($hit_and_run_rez) > 0 ? '<tr><td  class="colhead">' . $lang['hitnrun_avatar'] . '</td>
		<td  class="colhead"><b>' . $lang['hitnrun_member'] . '</b></td>
		<td class="colhead"><b>' . $lang['hitnrun_torrent'] . '</b></td>
		<td class="colhead"><b>' . $lang['hitnrun_times'] . '</b></td>
		<td class="colhead"><b>' . $lang['hitnrun_stats'] . '</b></td>
		<td class="colhead">' . $lang['hitnrun_actions'] . '</td>' : '<tr><td>' . $lang['hitnrun_none'] . '</td>') . '</tr>';
while ($hit_and_run_arr = mysqli_fetch_assoc($hit_and_run_rez)) {
    //=== Xbt Tracker or Default Announce
        $Xbt_Seed = (XBT_TRACKER === true ? $hit_and_run_arr['active'] !== 1 : $hit_and_run_arr['seeder'] !== 'yes');
        $Uid_ID = (XBT_TRACKER === true ? $hit_and_run_arr['uid'] : $hit_and_run_arr['userid']);
        $S_date =(XBT_TRACKER === true ? $hit_and_run_arr['started'] : $hit_and_run_arr['start_date']);
        $T_ID = (XBT_TRACKER === true ? $hit_and_run_arr['fid'] : $hit_and_run_arr['torrentid']);
        $C_Date = (XBT_TRACKER === true ? $hit_and_run_arr['completedtime'] : $hit_and_run_arr['complete_date']);
    //=== if really seeding list them
    if ($Xbt_Seed) {
        if ($Uid_ID !== $hit_and_run_arr['owner']) {
            $ratio_site = member_ratio($hit_and_run_arr['up'], $INSTALLER09['ratio_free'] ? '0' : $hit_and_run_arr['down']);
            $ratio_torrent = member_ratio($hit_and_run_arr['uload'], $INSTALLER09['ratio_free'] ? '0' : $hit_and_run_arr['dload']);
            $avatar = ($CURUSER['avatars'] == 'yes' ? ($hit_and_run_arr['avatar'] == '' ? '<img src="pic/default_avatar.gif"  width="40" alt="default avatar" />' : '<img src="' . htmlsafechars($hit_and_run_arr['avatar']) . '" alt="avatar"  width="40" />') : '');
            $torrent_needed_seed_time = $hit_and_run_arr['seedtime'];
            //=== get times per class
            switch (true) {
            case ($hit_and_run_arr['class'] < UC_POWER_USER):
                $days_3 = 3 * 86400; //== 3 days
                $days_14 = 2 * 86400; //== 2 days
                $days_over_14 = 86400; //== 1 day
                break;

            case ($hit_and_run_arr['class'] < UC_STAFF):
                $days_3 = 2 * 86400; //== 2 days
                $days_14 = 129600; //== 36 hours
                $days_over_14 = 64800; //== 18 hours
                break;

            case ($hit_and_run_arr['class'] >= UC_STAFF):
                $days_3 = 86400; //== 24 hours
                $days_14 = 43200; //== 12 hours
                $days_over_14 = 21600; //== 6 hours
                break;
            }
            switch (true) {
            case (($S_date - $hit_and_run_arr['torrent_added']) < 7 * 86400):
                $minus_ratio = ($days_3 - $torrent_needed_seed_time);
                // or using ratio
                //$minus_ratio = ($days_3 - $torrent_needed_seed_time) - ($hit_and_run_arr['uload'] / $hit_and_run_arr['dload'] * 3 * 86400);
                break;

            case (($S_date - $hit_and_run_arr['torrent_added']) < 21 * 86400):
                $minus_ratio = ($days_14 - $torrent_needed_seed_time);
                // or using ratio
                //$minus_ratio = ($days_14 - $torrent_needed_seed_time) - ($hit_and_run_arr['uload'] / $hit_and_run_arr['dload'] * 2 * 86400);
                break;

            case (($S_date - $hit_and_run_arr['torrent_added']) >= 21 * 86400):
                $minus_ratio = ($days_over_14 - $torrent_needed_seed_time);
                // or using ratio
                //$minus_ratio = ($days_over_14 - $torrent_needed_seed_time) - ($hit_and_run_arr['uload'] / $hit_and_run_arr['dload'] * 86400);
                break;
            }
            $minus_ratio = (preg_match("/-/i", $minus_ratio) ? 0 : $minus_ratio);
            $color = ($minus_ratio > 0 ? get_ratio_color($minus_ratio) : 'limegreen');
            $users = $hit_and_run_arr;
            $users['id'] = (int)$Uid_ID;
            $HTMLOUT.= '<tr><td align="left">' . $avatar . '</td>
			<td align="left"><a class="altlink" href="userdetails.php?id=' . (int)$Uid_ID . '&amp;completed=1#completed">' . format_username($users) . '</a>  [ ' . get_user_class_name($hit_and_run_arr['class']) . ' ]
</td>
			<td align="left"><a class="altlink" href="details.php?id=' . (int)$T_ID . '&amp;hit=1">' . htmlsafechars($hit_and_run_arr['name']) . '</a><br />
			' . $lang['hitnrun_leechers'] . '' . (int)$hit_and_run_arr['numleeching'] . '<br />
			' . $lang['hitnrun_seeders'] . ' ' . (int)$hit_and_run_arr['numseeding'] . '
         </td>
			<td align="left">' . $lang['hitnrun_finished'] . ' ' . get_date($C_Date, '') . '<br />
			' . $lang['hitnrun_stopped'] . ' ' . get_date($hit_and_run_arr['hit_and_run'], '') . '<br />
			' . $lang['hitnrun_seeded'] . '' . mkprettytime($hit_and_run_arr['seedtime']) . '<br />
			**' . $lang['hitnrun_still'] . ' ' . mkprettytime($minus_ratio) . '</td>
			<td align="left">' . $lang['hitnrun_uploaded'] . '' . mksize($hit_and_run_arr['uload']) . '<br />
			' . ($INSTALLER09['ratio_free'] ? '' : '' . $lang['hitnrun_downloaded'] . '' . mksize($hit_and_run_arr['dload']) . '<br />') . '
			' . $lang['hitnrun_ratio'] . '<font color="' . get_ratio_color($ratio_torrent) . '">' . $ratio_torrent . '</font><br />
			' . $lang['hitnrun_site_ratio'] . '<font color="' . get_ratio_color($ratio_site) . '" title="' . $lang['hitnrun_includes'] . '">' . $ratio_site . '</font></td>
			<td align="center"><a href="pm_system.php?action=send_message&amp;receiver=' . (int)$Uid_ID . '"><img src="pic/pm.gif" border="0" alt="PM" title="' . $lang['hitnrun_send'] . '" /></a><br />
			<a class="altlink" href="staffpanel.php?tool=shit_list&amp;action2=new&amp;shit_list_id=' . (int)$Uid_ID . '&amp;return_to=staffpanel.php?tool=hit_and_run" ><img src="pic/smilies/shit.gif" border="0" alt="Shit" title="' . $lang['hitnrun_shit'] . '" /></a></td></tr>';
        } //=== end if not owner
        
    } //=== if not seeding list them
    
} //=== end of while loop
$HTMLOUT.= '</table>' . ($arr_count[0] > $perpage ? '<p>' . $menu . '</p>' : '').'</div></div>';
echo stdhead($lang['hitnrun_stdhead']) . $HTMLOUT . stdfoot();
?>
