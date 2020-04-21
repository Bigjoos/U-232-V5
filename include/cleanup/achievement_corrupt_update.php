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
function docleanup($data)
{
    global $INSTALLER09, $queries, $cache;
    set_time_limit(0);
    ignore_user_abort(1);
    // Updated Corruption Counts
    $res = sql_query("SELECT users.id, users.corrupt, usersachiev.corrupt FROM users LEFT JOIN usersachiev ON users.id = usersachiev.id WHERE enabled = 'yes' AND users.corrupt >= '1' AND usersachiev.corrupt = '0'") or sqlerr(__FILE__, __LINE__);
    $msg_buffer = $usersachiev_buffer = $achievements_buffer = [];
    if (mysqli_num_rows($res) > 0) {
        $subject = sqlesc("New Achievement Earned!");
        $msg = sqlesc("Congratulations, you have just earned the [b]Corruption Counts[/b] achievement. :) [img]" . $INSTALLER09['baseurl'] . "/pic/achievements/corrupt.png[/img]");
        while ($arr = mysqli_fetch_assoc($res)) {
            $dt = TIME_NOW;
            $points = rand(1, 3);
            $msgs_buffer[] = '(0,' . $arr['id'] . ',' . TIME_NOW . ', ' . sqlesc($msg) . ', ' . sqlesc($subject) . ')';
            $achievements_buffer[] = '(' . $arr['id'] . ', ' . TIME_NOW . ', \'Corruption Counts\', \'corrupt.png\' , \'Transferred at least 1 byte of incoming corrupt data.\')';
            $usersachiev_buffer[] = '(' . $arr['id'] . ',1, ' . $points . ')';
            $cache->delete('inbox_new_' . $arr['id']);
            $cache->delete('inbox_new_sb_' . $arr['id']);
            $cache->delete('user_achievement_points_' . $arr['id']);
        }
        $count = count($achievements_buffer);
        if ($count > 0) {
            sql_query("INSERT INTO messages (sender,receiver,added,msg,subject) VALUES " . implode(', ', $msgs_buffer)) or sqlerr(__FILE__, __LINE__);
            sql_query("INSERT INTO achievements (userid, date, achievement, icon, description) VALUES " . implode(', ', $achievements_buffer) . " ON DUPLICATE key UPDATE date=values(date),achievement=values(achievement),icon=values(icon),description=values(description)") or sqlerr(__FILE__, __LINE__);
            sql_query("INSERT INTO usersachiev (id, corrupt, achpoints) VALUES " . implode(', ', $usersachiev_buffer) . " ON DUPLICATE key UPDATE corrupt=values(corrupt), achpoints=achpoints+values(achpoints)") or sqlerr(__FILE__, __LINE__);
            if ($queries > 0) {
                write_log("Achievements Cleanup:  Achievements Corruption Completed using $queries queries. Client Corruption Achievements awarded to - " . $count . " Member(s)");
            }
        }
        unset($usersachiev_buffer, $achievement_buffer, $msgs_buffer, $count);
    }
    if (mysqli_affected_rows($GLOBALS["___mysqli_ston"]) !== false) {
        $data['clean_desc'] = mysqli_affected_rows($GLOBALS["___mysqli_ston"]) . " items updated";
    }
    if ($data['clean_log']) {
        cleanup_log($data);
    }
}
