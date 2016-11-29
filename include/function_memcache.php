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
// removetorrentfromhash djGrrr <3
function remove_torrent($infohash)
{
    global $mc1;
    if (strlen($infohash) != 20 || !bin2hex($infohash)) return false;
    $key = 'torrent::hash:::' . md5($infohash);
    $torrent = $mc1->get_value($key);
    if ($torrent === false) return false;
    $mc1->delete_value($key);
    if (is_array($torrent)) remove_torrent_peers($torrent['id']);
    return true;
}
function remove_torrent_peers($id)
{
    global $mc1;
    if (!is_int($id) || $id < 1) return false;
    $delete = 0;
    $seed_key = 'torrents::seeds:::' . $id;
    $leech_key = 'torrents::leechs:::' . $id;
    $comp_key = 'torrents::comps:::' . $id;
    $delete+= $mc1->delete_value($seed_key);
    $delete+= $mc1->delete_value($leech_key);
    $delete+= $mc1->delete_value($comp_key);
    return (bool)$delete;
}
?>
