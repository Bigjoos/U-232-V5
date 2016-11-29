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
function docleanup($data)
{
    global $INSTALLER09, $queries, $mc1;
    set_time_limit(0);
    ignore_user_abort(1);
    do {
        $res = sql_query("SELECT id FROM torrents");
        $ar = array();
        while ($row = mysqli_fetch_array($res, MYSQLI_NUM)) {
            $id = $row[0];
            $ar[$id] = 1;
        }
        if (!count($ar)) break;

        $dp = opendir($INSTALLER09['torrent_dir']);
        if (!$dp) break;

        $ar2 = array();
        while (($file = readdir($dp)) !== false) {
            if (!preg_match('/^(\d+)\.torrent$/', $file, $m)) continue;
            $id = $m[1];
            $ar2[$id] = 1;
            if (isset($ar[$id]) && $ar[$id]) continue;
            $ff = $INSTALLER09['torrent_dir'] . "/$file";
            unlink($ff);
        }
        closedir($dp);
        if (!count($ar2)) break;

        $delids = array();
        foreach (array_keys($ar) as $k) {
            if (isset($ar2[$k]) && $ar2[$k]) continue;
            $delids[] = $k;
            unset($ar[$k]);
        }
        if (count($delids)) {
            $ids = join(",", $delids);
            sql_query("DELETE torrents t, peers p, files f FROM torrents t
                  left join files f on f.torrent=t.id
                  left join peers p on p.torrent=t.id
                  WHERE f.torrent IN ($ids) 
                  OR p.torrent IN ($ids) 
                  OR t.id IN ($ids)");
        }
    }
    while (0);
    if ($queries > 0) write_log("Normalize clean-------------------- Normalize cleanup Complete using $queries queries --------------------");
    if (false !== mysqli_affected_rows($GLOBALS["___mysqli_ston"])) {
        $data['clean_desc'] = mysqli_affected_rows($GLOBALS["___mysqli_ston"]) . " items deleted/updated";
    }
    if ($data['clean_log']) {
        cleanup_log($data);
    }
}
?>
