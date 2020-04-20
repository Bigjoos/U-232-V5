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
require_once(__DIR__ . DIRECTORY_SEPARATOR . 'include' . DIRECTORY_SEPARATOR . 'bittorrent.php');
require_once(INCL_DIR . 'user_functions.php');
require_once(INCL_DIR . 'function_happyhour.php');
require_once(CLASS_DIR . 'class.bencdec.php');
dbconn();
$lang = array_merge(load_language('global'), load_language('download'));
$T_Pass = isset($_GET['torrent_pass']) && strlen($_GET['torrent_pass']) == 32 ? $_GET['torrent_pass'] : '';
if (!empty($T_Pass)) {
    $q0 = sql_query("SELECT * FROM users where torrent_pass = " . sqlesc($T_Pass)) or sqlerr(__FILE__, __LINE__);
    if (mysqli_num_rows($q0) == 0) {
        die($lang['download_passkey']);
    } else {
        $CURUSER = mysqli_fetch_assoc($q0);
    }
} else {
    loggedinorreturn();
}
if (function_exists('parked')) {
    parked();
}
$id = isset($_GET['torrent']) ? (int) $_GET['torrent'] : 0;
$ssluse = isset($_GET['ssl']) && $_GET['ssl'] == 1 || $CURUSER['ssluse'] == 3 ? 1 : 0;
$zipuse = isset($_GET['zip']) && $_GET['zip'] == 1 ? true : false;
$text = isset($_GET['text']) && $_GET['text'] == 1 ? true : false;
if (!is_valid_id($id)) {
    stderr($lang['download_user_error'], $lang['download_no_id']);
}
$res = sql_query('SELECT name, owner, vip, category, filename, info_hash FROM torrents WHERE id = ' . sqlesc($id)) or sqlerr(__FILE__, __LINE__);
$row = mysqli_fetch_assoc($res);

$cres = sql_query('SELECT min_class FROM categories WHERE id = ' . sqlesc($row['category'])) or sqlerr(__FILE__, __LINE__);
$crow = mysqli_fetch_assoc($cres);
if ($crow['min_class'] > $CURUSER['class']) {
    stderr($lang['download_user_error'], $lang['download_no_id']);
}
$fn = $INSTALLER09['torrent_dir'] . '/' . $id . '.torrent';
if (!$row || !is_file($fn) || !is_readable($fn)) {
    stderr('Err', 'There was an error with the file or with the query, please contact staff');
}
if (happyHour('check') && happyCheck('checkid', $row['category']) && XBT_TRACKER == false && $INSTALLER09['happy_hour'] == true) {
    $multiplier = happyHour('multiplier');
    happyLog($CURUSER['id'], $id, $multiplier);
    sql_query('INSERT INTO happyhour (userid, torrentid, multiplier ) VALUES (' . sqlesc($CURUSER['id']) . ',' . sqlesc($id) . ',' . sqlesc($multiplier) . ')') or sqlerr(__FILE__, __LINE__);
    $cache->delete($CURUSER['id'] . '_happy');
}

if (($CURUSER['seedbonus'] === 0 || $CURUSER['seedbonus'] < $INSTALLER09['bonus_per_download'])) {
    stderr("Error", "Your dont have enough credit to download, trying seeding back some torrents =]");
}

if ($INSTALLER09['seedbonus_on'] == 1 && $row['owner'] != $CURUSER['id']) {
    //===remove karma
    sql_query("UPDATE users SET seedbonus = seedbonus-" . sqlesc($INSTALLER09['bonus_per_download']) . " WHERE id = " . sqlesc($CURUSER["id"])) or sqlerr(__FILE__, __LINE__);
    $update['seedbonus'] = ($CURUSER['seedbonus'] - $INSTALLER09['bonus_per_download']);
    $cache->update_row('userstats_' . $CURUSER['id'],  [
        'seedbonus' => $update['seedbonus']
    ], $INSTALLER09['expires']['u_stats']);
    $cache->update_row('user_stats_' . $CURUSER['id'],  [
        'seedbonus' => $update['seedbonus']
    ], $INSTALLER09['expires']['user_stats']);
    //===end
}
if (($CURUSER['downloadpos'] == 0 || $CURUSER['can_leech'] == 0 || $CURUSER['downloadpos'] > 1 || $CURUSER['suspended'] == 'yes') && !($CURUSER['id'] == $row['owner'])) {
    stderr("Error", "Your download rights have been disabled.");
}

if ($row['vip'] == 1 && $CURUSER['class'] < UC_VIP) {
    stderr('VIP Access Required', 'You must be a VIP In order to view details or download this torrent! You may become a Vip By Donating to our site. Donating ensures we stay online to provide you more Vip-Only Torrents!');
}
sql_query("UPDATE torrents SET hits = hits + 1 WHERE id = " . sqlesc($id));
/** free mod by pdq **/
/** freeslots/doubleseed by pdq **/
if (isset($_GET['slot'])) {
    $added = (TIME_NOW + 14 * 86400);
    $slots_sql = sql_query('SELECT * FROM freeslots WHERE torrentid = ' . sqlesc($id) . ' AND userid = ' . sqlesc($CURUSER['id']));
    $slot = mysqli_fetch_assoc($slots_sql);
    $used_slot = $slot['torrentid'] == $id && $slot['userid'] == $CURUSER['id'];
    /** freeslot **/
    if ($_GET['slot'] == 'free') {
        if ($used_slot && $slot['free'] == 'yes') {
            stderr('Doh!', 'Freeleech slot already in use.');
        }
        if ($CURUSER['freeslots'] < 1) {
            stderr('Doh!', 'No Slots.');
        }
        $CURUSER['freeslots'] = ($CURUSER['freeslots'] - 1);
        sql_query('UPDATE users SET freeslots = freeslots - 1 WHERE id = ' . sqlesc($CURUSER['id']) . ' LIMIT 1') or sqlerr(__FILE__, __LINE__);
        if ($used_slot && $slot['doubleup'] == 'yes') {
            sql_query('UPDATE freeslots SET free = "yes", addedfree = ' . $added . ' WHERE torrentid = ' . $id . ' AND userid = ' . $CURUSER['id'] . ' AND doubleup = "yes"') or sqlerr(__FILE__, __LINE__);
        } elseif ($used_slot && $slot['doubleup'] == 'no') {
            sql_query('INSERT INTO freeslots (torrentid, userid, free, addedfree) VALUES (' . sqlesc($id) . ', ' . sqlesc($CURUSER['id']) . ', "yes", ' . $added . ')') or sqlerr(__FILE__, __LINE__);
        } else {
            sql_query('INSERT INTO freeslots (torrentid, userid, free, addedfree) VALUES (' . sqlesc($id) . ', ' . sqlesc($CURUSER['id']) . ', "yes", ' . $added . ')') or sqlerr(__FILE__, __LINE__);
        }
    }
    /** doubleslot **/
    elseif ($_GET['slot'] == 'double') {
        if ($used_slot && $slot['doubleup'] == 'yes') {
            stderr('Doh!', 'Doubleseed slot already in use.');
        }
        if ($CURUSER['freeslots'] < 1) {
            stderr('Doh!', 'No Slots.');
        }
        $CURUSER['freeslots'] = ($CURUSER['freeslots'] - 1);
        sql_query('UPDATE users SET freeslots = freeslots - 1 WHERE id = ' . sqlesc($CURUSER['id']) . ' LIMIT 1') or sqlerr(__FILE__, __LINE__);
        if ($used_slot && $slot['free'] == 'yes') {
            sql_query('UPDATE freeslots SET doubleup = "yes", addedup = ' . $added . ' WHERE torrentid = ' . sqlesc($id) . ' AND userid = ' . sqlesc($CURUSER['id']) . ' AND free = "yes"') or sqlerr(__FILE__, __LINE__);
        } elseif ($used_slot && $slot['free'] == 'no') {
            sql_query('INSERT INTO freeslots (torrentid, userid, doubleup, addedup) VALUES (' . sqlesc($id) . ', ' . sqlesc($CURUSER['id']) . ', "yes", ' . $added . ')') or sqlerr(__FILE__, __LINE__);
        } else {
            sql_query('INSERT INTO freeslots (torrentid, userid, doubleup, addedup) VALUES (' . sqlesc($id) . ', ' . sqlesc($CURUSER['id']) . ', "yes", ' . $added . ')') or sqlerr(__FILE__, __LINE__);
        }
    } else {
        stderr('ERROR', 'What\'s up doc?');
    }
    $cache->delete('fllslot_' . $CURUSER['id']);
    make_freeslots($CURUSER['id'], 'fllslot_');
    $user['freeslots'] = ($CURUSER['freeslots'] - 1);
    $cache->update_row('MyUser_' . $CURUSER['id'],  [
        'freeslots' => $CURUSER['freeslots']
    ], $INSTALLER09['expires']['curuser']);
    $cache->update_row('user' . $CURUSER['id'],  [
        'freeslots' => $user['freeslots']
    ], $INSTALLER09['expires']['user_cache']);
}
/** end **/
$cache->delete('MyPeers_' . $CURUSER['id']);
$cache->delete('top5_tor_');
$cache->delete('last5_tor_');
$cache->delete('scroll_tor_');
if (!isset($CURUSER['torrent_pass']) || strlen($CURUSER['torrent_pass']) != 32) {
    $xbt_config = mysqli_fetch_row(sql_query("SELECT value FROM xbt_config WHERE name='torrent_pass_private_key'")) or sqlerr(__FILE__, __LINE__);
    $site_key = $xbt_config['0']; // the value of torrent_pass_private_key that is stored in the xbt_config table
    $info_hash = $row['info_hash']; // the torrent info_hash
    $torrent_pass_version = $CURUSER['torrent_pass_version']; // the torrent_pass_version that is stored in the users table for the user in question
    $uid = $CURUSER['id']; // the uid (userid) in the users table for the user in question
    $passkey = sprintf('%08x%s', $uid, substr(sha1(sprintf('%s %d %d %s', $site_key, $torrent_pass_version, $uid, $info_hash)), 0, 24));
    $CURUSER['torrent_pass'] = $passkey;
    sql_query('UPDATE users SET torrent_pass=' . sqlesc($CURUSER['torrent_pass']) . 'WHERE id=' . sqlesc($CURUSER['id'])) or sqlerr(__FILE__, __LINE__);
    $cache->update_row('MyUser_' . $CURUSER['id'],  [
        'torrent_pass' => $CURUSER['torrent_pass']
    ], $INSTALLER09['expires']['curuser']);
    $cache->update_row('user' . $CURUSER['id'],  [
        'torrent_pass' => $CURUSER['torrent_pass']
    ], $INSTALLER09['expires']['user_cache']);
}
$dict = bencdec::decode_file($fn, $INSTALLER09['max_torrent_size']);
if (XBT_TRACKER == true) {
    $dict['announce'] = $INSTALLER09['xbt_prefix'] . $CURUSER['torrent_pass'] . $INSTALLER09['xbt_suffix'];
} else {
    $dict['announce'] = $INSTALLER09['announce_urls'][$ssluse] . '?torrent_pass=' . $CURUSER['torrent_pass'];
}
$dict['uid'] = (int) $CURUSER['id'];
$tor = bencdec::encode($dict);
if ($zipuse) {
    require_once(INCL_DIR . 'phpzip.php');
    $row['name'] = str_replace([
        ' ',
        '.',
        '-'
    ], '_', $row['name']);
    $file_name = $INSTALLER09['torrent_dir'] . '/' . $row['name'] . '.torrent';
    if (file_put_contents($file_name, $tor)) {
        $zip = new PHPZip();
        $files = [
            $file_name
        ];
        $file_name = $INSTALLER09['torrent_dir'] . '/' . substr(md5(rawurlencode($row['name'])), 0, 6) . '.zip';
        $zip->Zip($files, $file_name);
        $zip->forceDownload($file_name);
        unlink($INSTALLER09['torrent_dir'] . '/' . $row['name'] . '.torrent');
        unlink($INSTALLER09['torrent_dir'] . '/' . $row['name'] . '.zip');
    } else {
        stderr('Error', 'Can\'t create the new file, please contatct staff');
    }
} else {
    if ($text) {
        header('Content-Disposition: attachment; filename="[' . $INSTALLER09['site_name'] . ']' . $row['name'] . '.txt"');
        header("Content-Type: text/plain");
        echo($tor);
    } else {
        header('Content-Disposition: attachment; filename="[' . $INSTALLER09['site_name'] . ']' . $row['filename'] . '"');
        header("Content-Type: application/x-bittorrent");
        echo($tor);
    }
}
