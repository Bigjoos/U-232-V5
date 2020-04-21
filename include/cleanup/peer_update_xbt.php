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
 * @param mixed $data
 */
/** sync torrent counts - pdq **/
function docleanup($data)
{
    global $INSTALLER09, $queries, $cache;
    set_time_limit(0);
    ignore_user_abort(1);
    $torrent_seeds = $torrent_leeches = [];
    $deadtime = TIME_NOW - floor($INSTALLER09['announce_interval'] * 1.3);
    $dead_peers = sql_query('SELECT fid, uid, peer_id, `left`, `active` FROM xbt_files_users WHERE mtime < ' . $deadtime);
    while ($dead_peer = mysqli_fetch_assoc($dead_peers)) {
        $torrentid = (int) $dead_peer['fid'];
        $userid = (int) $dead_peer['uid'];
        $seed = $dead_peer['left'] === 0;
        sql_query('DELETE FROM xbt_files_users WHERE fid = ' . sqlesc($torrentid) . ' AND peer_id = ' . sqlesc($dead_peer['peer_id']) . ' AND `active` = "0" AND uploaded="0" AND downloaded="0"');
        if (!isset($torrent_seeds[$torrentid])) {
            $torrent_seeds[$torrentid] = $torrent_leeches[$torrentid] = 0;
        }
        if ($seed) {
            $torrent_seeds[$torrentid]++;
        } else {
            $torrent_leeches[$torrentid]++;
        }
    }
    foreach (array_keys($torrent_seeds) as $tid) {
        $update = [];
        if ($torrent_seeds[$tid]) {
            $update[] = 'seeders = (seeders - ' . $torrent_seeds[$tid] . ')';
        }
        if ($torrent_leeches[$tid]) {
            $update[] = 'leechers = (leechers - ' . $torrent_leeches[$tid] . ')';
        }
        sql_query('UPDATE torrents SET ' . implode(', ', $update) . ' WHERE id = ' . sqlesc($tid));
    }
    if ($queries > 0) {
        write_log("XBT Peers clean-------------------- XBT Peer cleanup Complete using $queries queries --------------------");
    }
    if (mysqli_affected_rows($GLOBALS["___mysqli_ston"]) !== false) {
        $data['clean_desc'] = mysqli_affected_rows($GLOBALS["___mysqli_ston"]) . " items deleted/updated";
    }
    if ($data['clean_log']) {
        cleanup_log($data);
    }
}
