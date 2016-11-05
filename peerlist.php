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
function dltable($name, $arr, $torrent)
{
    global $CURUSER, $lang, $INSTALLER09;
    $htmlout = '';
    if (!count($arr)) return $htmlout = "<div align='left'><b>{$lang['peerslist_no']} $name {$lang['peerslist_data_available']}</b></div>\n";
    $htmlout = "\n";
    $htmlout.= "<table class='table table-bordered'>\n";
    $htmlout.= "<tr><td colspan='11' class='colhead'>" . count($arr) . " $name</td></tr>" . "<tr><td class='colhead'>{$lang['peerslist_user_ip']}</td>" . "<td class='colhead' align='center'>{$lang['peerslist_connectable']}</td>" . "<td class='colhead' align='right'>{$lang['peerslist_uploaded']}</td>" . "<td class='colhead' align='right'>{$lang['peerslist_rate']}</td>" . "" . ($INSTALLER09['ratio_free'] ? "" : "<td class='colhead' align='right'>{$lang['peerslist_downloaded']}</td>") . "" . "" . ($INSTALLER09['ratio_free'] ? "" : "<td class='colhead' align='right'>{$lang['peerslist_rate']}</td>") . "" . "<td class='colhead' align='right'>{$lang['peerslist_ratio']}</td>" . "<td class='colhead' align='right'>{$lang['peerslist_complete']}</td>" . "<td class='colhead' align='right'>{$lang['peerslist_connected']}</td>" . "<td class='colhead' align='right'>{$lang['peerslist_idle']}</td>" . "<td class='colhead' align='left'>{$lang['peerslist_client']}</td></tr>\n";
    $now = TIME_NOW;
    $mod = $CURUSER['class'] >= UC_STAFF;
    foreach ($arr as $e) {
        $htmlout.= "<tr>\n";
        if ($e['username']) {
            if (($e['tanonymous'] == 'yes' && $e['owner'] == $e['userid'] || $e['anonymous'] == 'yes' OR $e['paranoia'] >= 2 && $CURUSER['id'] != $e['userid']) && $CURUSER['class'] < UC_STAFF) $htmlout.= "<td><b>Kezer Soze</b></td>\n";
            else $htmlout.= "<td><a href='userdetails.php?id=" . (int)$e['userid'] . "'><b>" . htmlsafechars($e['username']) . "</b></a></td>\n";
        } else $htmlout.= "<td>" . ($mod ? $e["ip"] : preg_replace('/\.\d+$/', ".xxx", $e["ip"])) . "</td>\n";
        $secs = max(1, ($now - $e["st"]) - ($now - $e["la"]));
        $htmlout.= "<td align='center'>" . ($e['connectable'] == "yes" ? "{$lang['peerslist_yes']}" : "<font color='red'>{$lang['peerslist_no']}</font>") . "</td>\n";
        $htmlout.= "<td align='right'>" . mksize($e["uploaded"]) . "</td>\n";
        $htmlout.= "<td align='right'><span style=\"white-space: nowrap;\">" . mksize(($e["uploaded"] - $e["uploadoffset"]) / $secs) . "/s</span></td>\n";
        $htmlout.= "" . ($INSTALLER09['ratio_free'] ? "" : "<td align='right'>" . mksize($e["downloaded"]) . "</td>") . "\n";
        if ($e["seeder"] == "no") $htmlout.= "" . ($INSTALLER09['ratio_free'] ? "" : "<td align='right'><span style=\"white-space: nowrap;\">" . mksize(($e["downloaded"] - $e["downloadoffset"]) / $secs) . "/s</span></td>") . "\n";
        else $htmlout.= "" . ($INSTALLER09['ratio_free'] ? "" : "<td align='right'><span style=\"white-space: nowrap;\">" . mksize(($e["downloaded"] - $e["downloadoffset"]) / max(1, $e["finishedat"] - $e['st'])) . "/s</span></td>") . "\n";
        $htmlout.= "<td align=\"right\">" . member_ratio($e['uploaded'], $INSTALLER09['ratio_free'] ? "0" : $e['downloaded']) . "</td>\n";
        $htmlout.= "<td align='right'>" . sprintf("%.2f%%", 100 * (1 - ($e["to_go"] / $torrent["size"]))) . "</td>\n";
        $htmlout.= "<td align='right'>" . mkprettytime($now - $e["st"]) . "</td>\n";
        $htmlout.= "<td align='right'>" . mkprettytime($now - $e["la"]) . "</td>\n";
        $htmlout.= "<td align='left'>".htmlsafechars(getagent($e["agent"], $e['peer_id']))."</td>\n";
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
$subres = sql_query("SELECT u.username, u.anonymous, u.paranoia, t.owner, t.anonymous as tanonymous, p.seeder, p.finishedat, p.downloadoffset, p.uploadoffset, p.ip, p.port, p.uploaded, p.downloaded, p.to_go, p.started AS st, p.connectable, p.agent, p.last_action AS la, p.userid, p.peer_id
    FROM peers p
    LEFT JOIN users u ON p.userid = u.id
	LEFT JOIN torrents as t on t.id = p.torrent
    WHERE p.torrent = " . sqlesc($id)) or sqlerr(__FILE__, __LINE__);
if (mysqli_num_rows($subres) == 0) stderr("{$lang['peerslist_warning']}", "{$lang['peerslist_no_data']}");
while ($subrow = mysqli_fetch_assoc($subres)) {
    if ($subrow["seeder"] == "yes") $seeders[] = $subrow;
    else $downloaders[] = $subrow;
}
function leech_sort($a, $b)
{
    if (isset($_GET["usort"])) return seed_sort($a, $b);
    $x = $a["to_go"];
    $y = $b["to_go"];
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
$HTMLOUT.= '<br>' . dltable("{$lang['peerslist_leechers']}<a name='leechers'></a>", $downloaders, $row) .'<br>';
echo stdhead("{$lang['peerslist_stdhead']}") . $HTMLOUT . stdfoot();
?>
