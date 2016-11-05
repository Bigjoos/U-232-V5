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
    global $INSTALLER09, $queries;
    set_time_limit(1200);
    ignore_user_abort(1);
    $sql = sql_query("SHOW TABLE STATUS FROM {$INSTALLER09['mysql_db']}");
    $oht = '';
    while ($row = mysqli_fetch_assoc($sql)) {
        if ($row['Data_free'] > 100) {
            $oht.= $row['Data_free'] . ',';
        }
    }
    $oht = rtrim($oht, ',');
    if ($oht != '') {
        $sql = sql_query("OPTIMIZE TABLE {$oht}");
    }
    if ($queries > 0) write_log("Auto-optimizedb--------------------Auto Optimization Complete using $queries queries --------------------");
    if ($oht != '') {
        $data['clean_desc'] = "MySQLCleanup optimized {$oht} table(s)";
    }
    if ($data['clean_log']) {
        cleanup_log($data);
    }
}
?>
