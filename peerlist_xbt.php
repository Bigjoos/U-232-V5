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
require_once (INCL_DIR . 'bt_client_functions.php');
require_once (INCL_DIR . 'html_functions.php');
dbconn(false);
loggedinorreturn();
$lang = array_merge(load_language('global') , load_language('peerlist'));
$id = (int)$_GET['id'];
if (!isset($id) || !is_valid_id($id)) stderr($lang['peerslist_user_error'], $lang['peerslist_invalid_id']);
$HTMLOUT = '';
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
function dltable($name, $arr, $torrent)
{
    global $CURUSER, $lang, $INSTALLER09;
    $htmlout = '';
    if (!count($arr)) return $htmlout = "<div align='left'><b>{$lang['peerslist_no']} $name {$lang['peerslist_data_available']}</b></div>\n";
    $htmlout = "\n";
    $htmlout.= "<table class='table table-bordered'>\n";
    $htmlout.= "<tr><td colspan='11' class='colhead'>" . count($arr) . " $name</td></tr>" . "<tr><td class='colhead'>{$lang['peerslist_user_ip']}</td>" . "<td class='colhead' align='right'>{$lang['peerslist_uploaded']}</td>" . "<td class='colhead' align='right'>{$lang['peerslist_rate']}</td>" . "" . ($INSTALLER09['ratio_free'] ? "" : "<td class='colhead' align='right'>{$lang['peerslist_downloaded']}</td>") . "" . "" . ($INSTALLER09['ratio_free'] ? "" : "<td class='colhead' align='right'>{$lang['peerslist_rate']}</td>") . "" . "<td class='colhead' align='right'>{$lang['peerslist_ratio']}</td>" . "<td class='colhead' align='right'>{$lang['peerslist_complete']}</td>" . "<td class='colhead' align='right'>{$lang['peerslist_idle']}</td>" . "<td class='colhead' align='left'>{$lang['peerslist_client']}</td></tr>\n";
    $now = TIME_NOW;
    $mod = $CURUSER['class'] >= UC_STAFF;
    foreach ($arr as $e) {
        $htmlout.= "<tr>\n";
        $upspeed = ($e["upspeed"] > 0 ? mksize($e["upspeed"]) : ($e["seedtime"] > 0 ? mksize($e["uploaded"] / ($e["seedtime"] + $e["leechtime"])) : mksize(0)));
        $downspeed = ($e["downspeed"] > 0 ? mksize($e["downspeed"]) : ($e["leechtime"] > 0 ? mksize($e["downloaded"] / $e["leechtime"]) : mksize(0)));
        if ($e['username']) {
            if (($e['tanonymous'] == 'yes' && $e['owner'] == $e['uid'] || $e['anonymous'] == 'yes' OR $e['paranoia'] >= 2 && $CURUSER['id'] != $e['uid']) && $CURUSER['class'] < UC_STAFF) $htmlout.= "<td><b>Kezer Soze</b></td>\n";
            else $htmlout.= "<td><a href='userdetails.php?id=" . (int)$e['uid'] . "'><b>" . htmlsafechars($e['username']) . "</b></a></td>\n";
        } else $htmlout.= "<td>" . ($mod ? XBT_IP_CONVERT($e["ipa"]) : preg_replace('/\.\d+$/', ".xxx", XBT_IP_CONVERT($e["ipa"]))) . "</td>\n";
        $htmlout.= "<td align='right'>" . mksize($e["uploaded"]) . "</td>\n";
        $htmlout.= "<td align='right'><span style=\"white-space: nowrap;\">" . htmlsafechars($upspeed) . "/s</span></td>\n";
        $htmlout.= "" . ($INSTALLER09['ratio_free'] ? "" : "<td align='right'>" . mksize($e["downloaded"]) . "</td>") . "\n";
        $htmlout.= "" . ($INSTALLER09['ratio_free'] ? "" : "<td align='right'><span style=\"white-space: nowrap;\">" . htmlsafechars($downspeed) . "/s</span></td>") . "\n";
        $htmlout.= "<td align=\"right\">" . member_ratio($e['uploaded'], $INSTALLER09['ratio_free'] ? "0" : $e['downloaded']) . "</td>\n";
        $htmlout.= "<td align='right'>" . sprintf("%.2f%%", 100 * (1 - ($e["left"] / $torrent["size"]))) . "</td>\n";
        $htmlout.= "<td align='right'>" . mkprettytime($now - $e["la"]) . "</td>\n";
        $htmlout.= "<td align='left'>" . htmlsafechars(getagent($e["peer_id"], $e['peer_id'])) . "</td>\n";
        $htmlout.= "</tr>\n";
    }
    $htmlout.= "</table>\n";
    return $htmlout;
}
$res = sql_query("SELECT * FROM torrents WHERE id = " . sqlesc($id)) or sqlerr(__FILE__, __LINE__);
if (mysqli_num_rows($res) == 0) stderr("{$lang['peerslist_error']}", "{$lang['peerslist_nothing']}");
$row = mysqli_fetch_assoc($res);
$downloaders = array();
$seeders = array();
$subres = sql_query("SELECT u.username, u.anonymous, u.paranoia, t.owner, t.anonymous as tanonymous, t.seeders, t.leechers, x.fid, x.uploaded, x.downloaded, x.left, x.active, x.mtime AS la, x.uid, x.leechtime, x.seedtime, x.peer_id, x.upspeed, x.downspeed, x.ipa
    FROM xbt_files_users x
    LEFT JOIN users u ON x.uid = u.id
	LEFT JOIN torrents as t on t.id = x.fid
    WHERE active='1' AND x.fid = " . sqlesc($id)) or sqlerr(__FILE__, __LINE__);
if (mysqli_num_rows($subres) == 0) stderr("{$lang['peerslist_warning']}", "{$lang['peerslist_no_data']}");
while ($subrow = mysqli_fetch_assoc($subres)) {
    if ($subrow["left"] == 0) $seeders[] = $subrow;
    else $downloaders[] = $subrow;
}
function leech_sort($a, $b)
{
    if (isset($_GET["usort"])) return seed_sort($a, $b);
    $x = $a["left"];
    $y = $b["left"];
    if ($x == $y) return 0;
    if ($x < $y) return -1;
    return 1;
}
function seed_sort($a, $b)
{
    $x = $a["uploaded"];
    $y = $b["uploaded"];
    if ($x == $y) return 0;
    if ($x < $y) return 1;
    return -1;
}
usort($seeders, "seed_sort");
usort($downloaders, "leech_sort");
$HTMLOUT.= "<h1>Peerlist for <a href='{$INSTALLER09['baseurl']}/details.php?id=$id'>" . htmlsafechars($row['name']) . "</a></h1>";
$HTMLOUT.= dltable("{$lang['peerslist_seeders']}<a name='seeders'></a>", $seeders, $row);
$HTMLOUT.= '<br>' . dltable("{$lang['peerslist_leechers']}<a name='leechers'></a>", $downloaders, $row).'<br>';
echo stdhead("{$lang['peerslist_stdhead']}") . $HTMLOUT . stdfoot();
?>
