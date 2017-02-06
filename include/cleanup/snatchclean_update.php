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
    //== Delete snatched
    $dt = (TIME_NOW - (30 * 86400));
    sql_query("DELETE FROM snatched WHERE complete_date < ".sqlesc($dt)) or sqlerr(__FILE__, __LINE__);
    if (false !== mysqli_affected_rows($GLOBALS["___mysqli_ston"])) {
        $data['clean_desc'] = mysqli_affected_rows($GLOBALS["___mysqli_ston"]) . " items deleted/updated";
    }

    $snatchedcounts = array();
    $snatchedres = sql_query("SELECT torrentid, COUNT(*) AS count FROM snatched WHERE complete_date > 0 GROUP BY torrentid");
    while ($row = mysqli_fetch_assoc($snatchedres)) {
        $snatchedcounts[$row['torrentid']] = (int)$row['count'];
    }
    $tcompletedres = sql_query("SELECT id, times_completed FROM torrents");
    while ($row2 = mysqli_fetch_assoc($tcompletedres)) {
        if(array_key_exists($row2['id'], $snatchedcounts) && $row2['times_completed'] != $snatchedcounts[$row2['id']]) {
            sql_query("UPDATE torrents SET times_completed = ".$snatchedcounts[$row2['id']] . " WHERE id = " . $row2['id']);
        }
    }

    if ($queries > 0) write_log("Snatch list clean-------------------- Removed snatches not seeded for 99 days. Cleanup Complete using $queries queries --------------------");
    
    if ($data['clean_log']) {
        cleanup_log($data);
    }
}
?>
