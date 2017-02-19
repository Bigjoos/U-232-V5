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
    set_time_limit(1200);
    ignore_user_abort(1);
    //== delete torrents - ????
    $days = 30;
    $dt = (TIME_NOW - ($days * 86400));
    sql_query("UPDATE torrents SET flags='1' WHERE mtime < $dt AND seeders='0' AND leechers='0'") or sqlerr(__FILE__, __LINE__);
    $res = sql_query("SELECT id, name FROM torrents WHERE mtime < $dt AND seeders='0' AND leechers='0' AND flags='1'") or sqlerr(__FILE__, __LINE__);
    while ($arr = mysqli_fetch_assoc($res)) {
        sql_query("DELETE files.*, comments.*, thankyou.*, thanks.*, thumbsup.*, bookmarks.*, coins.*, rating.*, xbt_files_users.* FROM xbt_files_users
                                 LEFT JOIN files ON files.torrent = xbt_files_users.fid
                                 LEFT JOIN comments ON comments.torrent = xbt_files_users.fid
                                 LEFT JOIN thankyou ON thankyou.torid = xbt_files_users.fid
                                 LEFT JOIN thanks ON thanks.torrentid = xbt_files_users.fid
                                 LEFT JOIN bookmarks ON bookmarks.torrentid = xbt_files_users.fid
                                 LEFT JOIN coins ON coins.torrentid = xbt_files_users.fid
                                 LEFT JOIN rating ON rating.torrent = xbt_files_users.fid
                                 LEFT JOIN thumbsup ON thumbsup.torrentid = xbt_files_users.fid
                                 WHERE xbt_files_users.fid =" . sqlesc($arr['id'])) or sqlerr(__FILE__, __LINE__);
        
        @unlink("{$INSTALLER09['torrent_dir']}/{$arr['id']}.torrent");
        write_log("Torrent ".(int)$arr['id']." (".htmlsafechars($arr['name']).") was deleted by system (older than $days days and no seeders)");
    }
    if ($queries > 0) write_log("Delete Old Torrents XBT Clean -------------------- Delete Old XBT Torrents cleanup Complete using $queries queries --------------------");
    if (false !== mysqli_affected_rows($GLOBALS["___mysqli_ston"])) {
        $data['clean_desc'] = mysqli_affected_rows($GLOBALS["___mysqli_ston"]) . " items deleted/updated";
    }
    if ($data['clean_log']) {
        cleanup_log($data);
    }
}
?>
