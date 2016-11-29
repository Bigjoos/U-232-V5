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
    //=== Clean free
    $res = sql_query("SELECT id, free FROM torrents WHERE free > 1 AND free < " . TIME_NOW) or sqlerr(__FILE__, __LINE__);
    $Free_buffer = array();
    if (mysqli_num_rows($res) > 0) {
        while ($arr = mysqli_fetch_assoc($res)) {
            $Free_buffer[] = '(' . $arr['id'] . ', \'0\')';
            $mc1->begin_transaction('torrent_details_' . $arr['id']);
            $mc1->update_row(false, array(
                'free' => 0
            ));
            $mc1->commit_transaction($INSTALLER09['expires']['torrent_details']);
        }
        $count = count($Free_buffer);
        if ($count > 0) {
            sql_query("INSERT INTO torrents (id, free) VALUES " . implode(', ', $Free_buffer) . " ON DUPLICATE key UPDATE free=values(free)") or sqlerr(__FILE__, __LINE__);
            write_log("Cleanup - Removed Free from " . $count . " torrents");
        }
        unset($Free_buffer, $count);
    }
    //==End
    if ($queries > 0) write_log("Free clean-------------------- Free Torrents cleanup Complete using $queries queries --------------------");
    if (false !== mysqli_affected_rows($GLOBALS["___mysqli_ston"])) {
        $data['clean_desc'] = mysqli_affected_rows($GLOBALS["___mysqli_ston"]) . " items updated";
    }
    if ($data['clean_log']) {
        cleanup_log($data);
    }
}
?>
