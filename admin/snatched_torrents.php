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
require_once (INCL_DIR . 'user_functions.php');
require_once (INCL_DIR . 'html_functions.php');
require_once INCL_DIR . 'pager_functions.php';
require_once (CLASS_DIR . 'class_check.php');
$class = get_access(basename($_SERVER['REQUEST_URI']));
class_check($class);
$lang = array_merge($lang, load_language('ad_snatched_torrents'));
$HTMLOUT = "";
function get_snatched_color($st)
{
    global $lang;
    $secs = $st;
    $mins = floor($st / 60);
    $hours = floor($mins / 60);
    $days = floor($hours / 24);
    $week = floor($days / 7);
    $month = floor($week / 4);
    if ($month > 0) {
        $week_elapsed = floor(($st - ($month * 4 * 7 * 24 * 60 * 60)) / (7 * 24 * 60 * 60));
        $days_elapsed = floor(($st - ($week * 7 * 24 * 60 * 60)) / (24 * 60 * 60));
        $hours_elapsed = floor(($st - ($days * 24 * 60 * 60)) / (60 * 60));
        $mins_elapsed = floor(($st - ($hours * 60 * 60)) / 60);
        $secs_elapsed = floor($st - $mins * 60);
        return "<font color='lime'><b>$month months.<br />$week_elapsed W. $days_elapsed D.</b></font>";
    }
    if ($week > 0) {
        $days_elapsed = floor(($st - ($week * 7 * 24 * 60 * 60)) / (24 * 60 * 60));
        $hours_elapsed = floor(($st - ($days * 24 * 60 * 60)) / (60 * 60));
        $mins_elapsed = floor(($st - ($hours * 60 * 60)) / 60);
        $secs_elapsed = floor($st - $mins * 60);
        return "<font color='lime'><b>$week W. $days_elapsed D.<br />$hours_elapsed:$mins_elapsed:$secs_elapsed</b></font>";
    }
    if ($days > 2) {
        $hours_elapsed = floor(($st - ($days * 24 * 60 * 60)) / (60 * 60));
        $mins_elapsed = floor(($st - ($hours * 60 * 60)) / 60);
        $secs_elapsed = floor($st - $mins * 60);
        return "<font color='lime'><b>$days D.<br />$hours_elapsed:$mins_elapsed:$secs_elapsed</b></font>";
    }
    if ($days > 1) {
        $hours_elapsed = floor(($st - ($days * 24 * 60 * 60)) / (60 * 60));
        $mins_elapsed = floor(($st - ($hours * 60 * 60)) / 60);
        $secs_elapsed = floor($st - $mins * 60);
        return "<font color='green'><b>$days D.<br />$hours_elapsed:$mins_elapsed:$secs_elapsed</b></font>";
    }
    if ($days > 0) {
        $hours_elapsed = floor(($st - ($days * 24 * 60 * 60)) / (60 * 60));
        $mins_elapsed = floor(($st - ($hours * 60 * 60)) / 60);
        $secs_elapsed = floor($st - $mins * 60);
        return "<font color='#CCFFCC'><b>$days D.<br />$hours_elapsed:$mins_elapsed:$secs_elapsed</b></font>";
    }
    if ($hours > 12) {
        $mins_elapsed = floor(($st - ($hours * 60 * 60)) / 60);
        $secs_elapsed = floor($st - $mins * 60);
        return "<font color='yellow'><b>$hours:$mins_elapsed:$secs_elapsed</b></font>";
    }
    if ($hours > 0) {
        $mins_elapsed = floor(($st - ($hours * 60 * 60)) / 60);
        $secs_elapsed = floor($st - $mins * 60);
        return "<font color='red'><b>$hours:$mins_elapsed:$secs_elapsed</b></font>";
    }
    if ($mins > 0) {
        $secs_elapsed = floor($st - $mins * 60);
        return "<font color='red'><b>0:$mins:$secs_elapsed</b></font>";
    }
    if ($secs > 0) {
        return "<font color='red'><b>0:0:$secs</b></font>";
    }
    return "<font color='red'><b>{$lang['ad_snatched_torrents_none']}<br />{$lang['ad_snatched_torrents_reported']}</b></font>";
}
$What_Table = (XBT_TRACKER == true ? 'xbt_peers' : 'snatched');
$What_Value = (XBT_TRACKER == true ? 'WHERE completedtime != "0"' : 'WHERE complete_date != "0"');
$count = number_format(get_row_count($What_Table, $What_Value));
$HTMLOUT.= "<h2 align='center'>{$lang['ad_snatched_torrents_allsnatched']}</h2>
<font class='small'>{$lang['ad_snatched_torrents_currently']}&nbsp;" . htmlsafechars($count) . "&nbsp;{$lang['ad_snatched_torrents_snatchedtor']}</font>";
$HTMLOUT .="<div class='row'><div class='col-md-12'>";
$Which_ID = (XBT_TRACKER == true ? 'tid' : 'id');
$Which_Table = (XBT_TRACKER == true ? 'xbt_peers' : 'snatched');
$res = sql_query("SELECT COUNT($Which_ID) FROM $Which_Table") or sqlerr(__FILE__, __LINE__);
$row = mysqli_fetch_row($res);
$count = $row[0];
$snatchedperpage = 15;
$pager = pager($snatchedperpage, $count, "staffpanel.php?tool=snatched_torrents&amp;action=snatched_torrents&amp;");
if ($count > $snatchedperpage) $HTMLOUT.= $pager['pagertop'];
if (XBT_TRACKER == true) {
    $sql = "SELECT x.uid, x.tid, x.announced, x.completedtime, x.leechtime, x.seedtime, x.uploaded, x.downloaded, x.started, u.username, t.seeders, t.name " . "FROM xbt_peers AS x " . "LEFT JOIN users AS u ON u.id=x.uid " . "LEFT JOIN torrents AS t ON t.id=x.tid WHERE completedtime != '0'" . " ORDER BY x.completedtime DESC " . $pager['limit'];
} else {
    $sql = "SELECT sn.userid, sn.id, sn.torrentid, sn.timesann, sn.hit_and_run, sn.mark_of_cain, sn.uploaded, sn.downloaded, sn.start_date, sn.complete_date, sn.seeder, sn.leechtime, sn.seedtime, u.username, t.name " . "FROM snatched AS sn " . "LEFT JOIN users AS u ON u.id=sn.userid " . "LEFT JOIN torrents AS t ON t.id=sn.torrentid WHERE complete_date != '0'" . "ORDER BY sn.complete_date DESC " . $pager['limit'];
}
$result = sql_query($sql) or sqlerr(__FILE__, __LINE__);
if (mysqli_num_rows($result) != 0) {
    if (XBT_TRACKER == true) {
        $HTMLOUT.= "<table class='table table-bordered'>
<tr>
<td class='colhead' align='center' width='1%'>{$lang['ad_snatched_torrents_name']}</td>
<td class='colhead' align='center' width='1%'>{$lang['ad_snatched_torrents_torname']}</td>
<td class='colhead' align='center' width='1%'>{$lang['ad_snatched_torrents_announced']}</td>
<td class='colhead' align='center' width='1%'>{$lang['ad_snatched_torrents_upload']}</td>
" . ($INSTALLER09['ratio_free'] ? "" : "<td class='colhead' align='center' width='1%'>{$lang['ad_snatched_torrents_download']}</td>") . "
<td class='colhead' align='center' width='1%'>{$lang['ad_snatched_torrents_seedtime']}</td>
<td class='colhead' align='center' width='1%'>{$lang['ad_snatched_torrents_leechtime']}</td>
<td class='colhead' align='center' width='1%'>{$lang['ad_snatched_torrents_startdate']}</td>
<td class='colhead' align='center' width='1%'>{$lang['ad_snatched_torrents_enddate']}</td>
<td class='colhead' align='center' width='1%'>{$lang['ad_snatched_torrents_seeding']}</td>
</tr>";
    } else {
        $HTMLOUT.= "<table class='table table-bordered'>
<tr>
<td class='colhead' align='center' width='1%'>{$lang['ad_snatched_torrents_name']}</td>
<td class='colhead' align='center' width='1%'>{$lang['ad_snatched_torrents_torname']}</td>
<td class='colhead' align='center' width='1%'>{$lang['ad_snatched_torrents_hnr']}</td>
<td class='colhead' align='center' width='1%'>{$lang['ad_snatched_torrents_marked']}</td>
<td class='colhead' align='center' width='1%'>{$lang['ad_snatched_torrents_announced']}</td>
<td class='colhead' align='center' width='1%'>{$lang['ad_snatched_torrents_upload']}</td>
" . ($INSTALLER09['ratio_free'] ? "" : "<td class='colhead' align='center' width='1%'>{$lang['ad_snatched_torrents_download']}</td>") . "
<td class='colhead' align='center' width='1%'>{$lang['ad_snatched_torrents_seedtime']}</td>
<td class='colhead' align='center' width='1%'>{$lang['ad_snatched_torrents_leechtime']}</td>
<td class='colhead' align='center' width='1%'>{$lang['ad_snatched_torrents_startdate']}</td>
<td class='colhead' align='center' width='1%'>{$lang['ad_snatched_torrents_enddate']}</td>
<td class='colhead' align='center' width='1%'>{$lang['ad_snatched_torrents_seeding']}</td>
</tr>";
    }
    while ($row = mysqli_fetch_assoc($result)) {
        $smallname = substr(htmlsafechars($row["name"]) , 0, 25);
        if ($smallname != htmlsafechars($row["name"])) {
            $smallname.= '...';
        }
        if (XBT_TRACKER == true) {
            $HTMLOUT.= "<tr><td><a href='/userdetails.php?id=" . (int)$row['uid'] . "'><b>" . htmlsafechars($row['username']) . "</b></a></td>
<td align='center'><a href='/details.php?id=" . (int)$row['tid'] . "'><b>" . $smallname . "</b></a></td>
<td align='center'><b>" . htmlsafechars($row['announced']) . "</b></td>
<td align='center'><b>" . mksize($row['uploaded']) . "</b></td>
" . ($INSTALLER09['ratio_free'] ? "" : "<td align='center'><b>" . mksize($row['downloaded']) . "</b></td>") . "
<td align='center'><b>" . get_snatched_color($row["seedtime"]) . "</b></td>
<td align='center'><b>" . mkprettytime($row["leechtime"]) . "</b></td><td align='center'><b>" . get_date($row['started'], 'LONG', 0, 1) . "</b></td>";
            if ($row['completedtime'] > 0) $HTMLOUT.= "<td align='center'><b>" . get_date($row['completedtime'], 'LONG', 0, 1) . "</b></td>";
            else $HTMLOUT.= "<td align='center'><b><font color='red'>{$lang['ad_snatched_torrents_ncomplete']}</font></b></td>";
            $HTMLOUT.= "<td align='center'>" . ($row['seeders'] >= 1 ? "<img src='" . $INSTALLER09['pic_base_url'] . "aff_tick.gif' alt='{$lang['ad_snatched_torrents_yes']}' title='{$lang['ad_snatched_torrents_yes']}' />" : "<img src='" . $INSTALLER09['pic_base_url'] . "aff_cross.gif' alt='{$lang['ad_snatched_torrents_no']}' title='{$lang['ad_snatched_torrents_no']}' />") . "</td></tr>";
        } else {
            $HTMLOUT.= "<tr><td><a href='/userdetails.php?id=" . (int)$row['userid'] . "'><b>" . htmlsafechars($row['username']) . "</b></a></td>
<td align='center'><a href='/details.php?id=" . (int)$row['torrentid'] . "'><b>" . $smallname . "</b></a></td>
<td align='center'><b>" . get_date($row['hit_and_run'], 'LONG', 0, 1) . "</b></td>
<td align='center'><b>" . htmlsafechars($row['mark_of_cain']) . "</b></td>
<td align='center'><b>" . htmlsafechars($row['timesann']) . "</b></td>
<td align='center'><b>" . mksize($row['uploaded']) . "</b></td>
" . ($INSTALLER09['ratio_free'] ? "" : "<td align='center'><b>" . mksize($row['downloaded']) . "</b></td>") . "
<td align='center'><b>" . get_snatched_color($row["seedtime"]) . "</b></td>
<td align='center'><b>" . mkprettytime($row["leechtime"]) . "</b></td>
<td align='center'><b>" . get_date($row['start_date'], 'LONG', 0, 1) . "</b></td>";
            if ($row['complete_date'] > 0) $HTMLOUT.= "<td align='center'><b>" . get_date($row['complete_date'], 'LONG', 0, 1) . "</b></td>";
            else $HTMLOUT.= "<td align='center'><b><font color='red'>{$lang['ad_snatched_torrents_ncomplete']}</font></b></td></tr>";
            $HTMLOUT.= "<td align='center'><b>" . ($row['seeder'] == 'yes' ? "<img src='" . $INSTALLER09['pic_base_url'] . "aff_tick.gif' alt='{$lang['ad_snatched_torrents_yes']}' title='{$lang['ad_snatched_torrents_yes']}' />" : "<img src='" . $INSTALLER09['pic_base_url'] . "aff_cross.gif' alt='{$lang['ad_snatched_torrents_no']}' title='{$lang['ad_snatched_torrents_no']}' />") . "</b></td></tr>";
        }
    }
    $HTMLOUT.= "</table>";
} else $HTMLOUT.= "{$lang['ad_snatched_torrents_nothing']}";
if ($count > $snatchedperpage) $HTMLOUT.= $pager['pagerbottom']."<br>";
$HTMLOUT.= "</div></div><br>";
echo stdhead($lang['ad_snatched_torrents_stdhead']) . $HTMLOUT . stdfoot();
die;
?>
