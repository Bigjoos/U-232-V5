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
$lang = array_merge($lang, load_language('ad_viewpeers'));
$HTMLOUT = $count = '';
function my_inet_ntop($ip)
{
    if (strlen($ip) == 4) {
        // ipv4
        list(, $ip) = unpack('N', $ip);
        $ip = long2ip($ip);
    } elseif (strlen($ip) == 16) {
        // ipv6
        $ip = bin2hex($ip);
        $ip = substr(chunk_split($ip, 4, ':') , 0, -1);
        $ip = explode(':', $ip);
        $res = '';
        foreach ($ip as $seg) {
            while ($seg{0} == '0') $seg = substr($seg, 1);
            if ($seg != '') {
                $res.= ($res == '' ? '' : ':') . $seg;
            } else {
                if (strpos($res, '::') === false) {
                    if (substr($res, -1) == ':') continue;
                    $res.= ':';
                    continue;
                }
                $res.= ($res == '' ? '' : ':') . '0';
            }
        }
        $ip = $res;
    }
    return $ip;
}
function XBT_IP_CONVERT($a)
{
    $b = array(
        0,
        0,
        0,
        0
    );
    $c = 16777216.0;
    $a+= 0.0;
    for ($i = 0; $i < 4; $i++) {
        $k = (int)($a / $c);
        $a-= $c * $k;
        $b[$i] = $k;
        $c/= 256.0;
    };
    $d = join('.', $b);
    return ($d);
}
$Which_ID = (XBT_TRACKER == true ? 'tid' : 'id');
$Which_Table = (XBT_TRACKER == true ? 'xbt_peers' : 'peers');
$res = sql_query("SELECT COUNT($Which_ID) FROM $Which_Table") or sqlerr(__FILE__, __LINE__);
$row = mysqli_fetch_row($res);
$count = $row[0];
$peersperpage = 15;
$HTMLOUT.= "<h2 align='center'>{$lang['wpeers_h2']}</h2>
<font class='small'>{$lang['wpeers_there']}" . htmlsafechars($count) . "{$lang['wpeers_peer']}" . ($count > 1 ? $lang['wpeers_ps'] : "") . "{$lang['wpeers_curr']}</font>";
//$HTMLOUT.= begin_main_frame();
$HTMLOUT .= "<div class='row'><div class='col-md-12'>";
$pager = pager($peersperpage, $count, "staffpanel.php?tool=view_peers&amp;action=view_peers&amp;");
if ($count > $peersperpage) $HTMLOUT.= $pager['pagertop'];
if (XBT_TRACKER == true) {
    $sql = "SELECT x.tid, x.uid, x.left, x.active, x.peer_id, x.ipa, x.uploaded, x.downloaded, x.leechtime, x.seedtime, x.upspeed, x.downspeed, x.mtime, x.completedtime, u.torrent_pass, u.username, t.seeders, t.leechers, t.name FROM `xbt_peers` AS x LEFT JOIN users AS u ON u.id=x.uid LEFT JOIN torrents AS t ON t.id=x.tid WHERE `left` >= 0 AND t.leechers >= 0 ORDER BY tid DESC {$pager['limit']}";
} else {
    $sql = "SELECT p.id, p.userid, p.torrent, p.torrent_pass, p.peer_id, p.ip, p.port, p.uploaded, p.downloaded, p.to_go, p.seeder, p.started, p.last_action, p.connectable, p.agent, p.finishedat, p.downloadoffset, p.uploadoffset, u.username, t.name " . "FROM peers AS p " . "LEFT JOIN users AS u ON u.id=p.userid " . "LEFT JOIN torrents AS t ON t.id=p.torrent WHERE started != '0'" . "ORDER BY p.started DESC {$pager['limit']}";
}
$result = sql_query($sql) or sqlerr(__FILE__, __LINE__);
if (mysqli_num_rows($result) != 0) {
    if (XBT_TRACKER == true) {
        $HTMLOUT.= "<table class='table table-bordered'>
<tr>
<td class='colhead' align='center' width='1%'>{$lang['wpeers_user']}</td>
<td class='colhead' align='center' width='1%'>{$lang['wpeers_torrent']}</td>
<td class='colhead' align='center' width='1%'>{$lang['wpeers_ip']}</td>
<td class='colhead' align='center' width='1%'>{$lang['wpeers_up']}</td>
" . ($INSTALLER09['ratio_free'] == true ? "" : "<td class='colhead' align='center' width='1%'>{$lang['wpeers_dn']}</td>") . "
<td class='colhead' align='center' width='1%'>{$lang['wpeers_pssky']}</td>
<td class='colhead' align='center' width='1%'>{$lang['wpeers_seed']}</td>
<td class='colhead' align='center' width='1%'>{$lang['wpeers_last']}</td>
<td class='colhead' align='center' width='1%'>{$lang['wpeers_uspeed']}</td>
" . ($INSTALLER09['ratio_free']  == true ? "" : "<td class='colhead' align='center' width='1%'>{$lang['wpeers_dspeed']}</td>") . "
<td class='colhead' align='center' width='1%'>{$lang['wpeers_togo']}</td>
</tr>";
    } else {
        $HTMLOUT.= "<table class='table table-bordered'>
<tr>
<td class='colhead' align='center' width='1%'>{$lang['wpeers_user']}</td>
<td class='colhead' align='center' width='1%'>{$lang['wpeers_torrent']}</td>
<td class='colhead' align='center' width='1%'>{$lang['wpeers_ip']}</td>
<td class='colhead' align='center' width='1%'>{$lang['wpeers_port']}</td>
<td class='colhead' align='center' width='1%'>{$lang['wpeers_up']}</td>
" . ($INSTALLER09['ratio_free'] == true ? "" : "<td class='colhead' align='center' width='1%'>{$lang['wpeers_dn']}</td>") . "
<td class='colhead' align='center' width='1%'>{$lang['wpeers_pssky']}</td>
<td class='colhead' align='center' width='1%'>{$lang['wpeers_con']}</td>
<td class='colhead' align='center' width='1%'>{$lang['wpeers_seed']}</td>
<td class='colhead' align='center' width='1%'>{$lang['wpeers_start']}</td>
<td class='colhead' align='center' width='1%'>{$lang['wpeers_last']}</td>
<td class='colhead' align='center' width='1%'>{$lang['wpeers_upoff']}</td>
" . ($INSTALLER09['ratio_free'] == true ? "" : "<td class='colhead' align='center' width='1%'>{$lang['wpeers_dnoff']}</td>") . "
<td class='colhead' align='center' width='1%'>{$lang['wpeers_togo']}</td>
</tr>";
    }
    while ($row = mysqli_fetch_assoc($result)) {
        $smallname = substr(htmlsafechars($row["name"]) , 0, 25);
        if ($smallname != htmlsafechars($row["name"])) {
            $smallname.= '...';
        }
        if (XBT_TRACKER == true) {
        $upspeed = ($row["upspeed"] > 0 ? mksize($row["upspeed"]) : ($row["seedtime"] > 0 ? mksize($row["uploaded"] / ($row["seedtime"] + $row["leechtime"])) : mksize(0)));
        $downspeed = ($row["downspeed"] > 0 ? mksize($row["downspeed"]) : ($row["leechtime"] > 0 ? mksize($row["downloaded"] / $row["leechtime"]) : mksize(0)));
        }
        if (XBT_TRACKER == true) {
            $HTMLOUT.= '<tr>
<td><a href="userdetails.php?id=' . (int)($row['uid']) . '">' . htmlsafechars($row['username']) . '</a></td>
<td><a href="details.php?id=' . (int)($row['tid']) . '">' . $smallname . '</a></td>
<td align="center">' . htmlsafechars(XBT_IP_CONVERT($row['ipa'])) . '</td>
<td align="center">' . htmlsafechars(mksize($row['uploaded'])) . '</td>
' . ($INSTALLER09['ratio_free'] == true ? '' : '<td align="center">' . htmlsafechars(mksize($row['downloaded'])) . '</td>') . '
<td align="center">' . htmlsafechars($row['torrent_pass']) . '</td>
<td align="center">' . ($row['seeders'] >= 1 ? "<img src='" . $INSTALLER09['pic_base_url'] . "aff_tick.gif' alt='{$lang['wpeers_yes']}' title='{$lang['wpeers_yes']}' />" : "<img src='" . $INSTALLER09['pic_base_url'] . "aff_cross.gif' alt='{$lang['wpeers_no']}' title='{$lang['wpeers_no']}' />") . '</td>
<td align="center">' . get_date($row['mtime'], 'DATE', 0, 1) . '</td>
<td align="center">' . htmlsafechars(mksize($row['upspeed'])) . '/s</td>
' . ($INSTALLER09['ratio_free'] == true ? '' : '<td align="center">' . htmlsafechars(mksize($row['downspeed'])) . '/s</td>') . '
<td align="center">' . htmlsafechars(mksize($row['left'])) . '</td>
</tr>';
        } else {
            $HTMLOUT.= '<tr>
<td><a href="userdetails.php?id=' . (int)($row['userid']) . '">' . htmlsafechars($row['username']) . '</a></td>
<td><a href="details.php?id=' . (int)($row['torrent']) . '">' . $smallname . '</a></td>
<td align="center">' . htmlsafechars($row['ip']) . '</td>
<td align="center">' . htmlsafechars($row['port']) . '</td>
<td align="center">' . htmlsafechars(mksize($row['uploaded'])) . '</td>
' . ($INSTALLER09['ratio_free'] == true ? '' : '<td align="center">' . htmlsafechars(mksize($row['downloaded'])) . '</td>') . '
<td align="center">' . htmlsafechars($row['torrent_pass']) . '</td>
<td align="center">' . ($row['connectable'] == 'yes' ? "<img src='" . $INSTALLER09['pic_base_url'] . "aff_tick.gif' alt='{$lang['wpeers_yes']}' title='{$lang['wpeers_yes']}' />" : "<img src='" . $INSTALLER09['pic_base_url'] . "aff_cross.gif' alt='{$lang['wpeers_no']}' title='{$lang['wpeers_no']}' />") . '</td>
<td align="center">' . ($row['seeder'] == 'yes' ? "<img src='" . $INSTALLER09['pic_base_url'] . "aff_tick.gif' alt='{$lang['wpeers_yes']}' title='{$lang['wpeers_yes']}' />" : "<img src='" . $INSTALLER09['pic_base_url'] . "aff_cross.gif' alt='{$lang['wpeers_no']}' title='{$lang['wpeers_no']}' />") . '</td>
<td align="center">' . get_date($row['started'], 'DATE') . '</td>
<td align="center">' . get_date($row['last_action'], 'DATE', 0, 1) . '</td>
<td align="center">' . htmlsafechars(mksize($row['uploadoffset'])) . '</td>
' . ($INSTALLER09['ratio_free'] == true ? '' : '<td align="center">' . htmlsafechars(mksize($row['downloadoffset'])) . '</td>') . '
<td align="center">' . htmlsafechars(mksize($row['to_go'])) . '</td>
</tr>';
        }
    }
    $HTMLOUT.= "</table>";
} else $HTMLOUT.= $lang['wpeers_notfound'];
if ($count > $peersperpage) $HTMLOUT.= $pager['pagerbottom'] ."<br>";
$HTMLOUT.= "</div></div><br>";
echo stdhead($lang['wpeers_peerover']) . $HTMLOUT . stdfoot();
die;
?>
