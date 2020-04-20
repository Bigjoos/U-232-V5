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
    set_time_limit(1200);
    ignore_user_abort(1);
    //=== Updated remove custom smilies by Bigjoos/pdq:)
    $res = sql_query("SELECT id, modcomment FROM users WHERE smile_until < " . TIME_NOW . " AND smile_until <> '0'") or sqlerr(__FILE__, __LINE__);
    $msgs_buffer = $users_buffer = [];
    if (mysqli_num_rows($res) > 0) {
        $subject = "Custom smilies expired.";
        $msg = "Your Custom smilies have timed out and has been auto-removed by the system. If you would like to have them again, exchange some Karma Bonus Points again. Cheers!\n";
        while ($arr = mysqli_fetch_assoc($res)) {
            $modcomment = $arr['modcomment'];
            $modcomment = get_date(TIME_NOW, 'DATE', 1) . " - Custom smilies Automatically Removed By System.\n" . $modcomment;
            $modcom = sqlesc($modcomment);
            $msgs_buffer[] = '(0,' . $arr['id'] . ',' . TIME_NOW . ', ' . sqlesc($msg) . ', ' . sqlesc($subject) . ' )';
            $users_buffer[] = '(' . $arr['id'] . ', \'0\', ' . $modcom . ')';
            $cache->update_row('user' . $arr['id'], [
                'smile_until' => 0
            ], $INSTALLER09['expires']['user_cache']);
            $cache->update_row('user_stats_' . $arr['id'], [
                'modcomment' => $modcomment
            ], $INSTALLER09['expires']['user_stats']);
            $cache->update_row('MyUser_' . $arr['id'], [
                'smile_until' => 0
            ], $INSTALLER09['expires']['curuser']);
            $cache->delete('inbox_new_' . $arr['id']);
            $cache->delete('inbox_new_sb_' . $arr['id']);
        }
        $count = count($users_buffer);
        if ($count > 0) {
            sql_query("INSERT INTO messages (sender,receiver,added,msg,subject) VALUES " . implode(', ', $msgs_buffer)) or sqlerr(__FILE__, __LINE__);
            sql_query("INSERT INTO users (id, smile_until, modcomment) VALUES " . implode(', ', $users_buffer) . " ON DUPLICATE key UPDATE smile_until=values(smile_until),modcomment=values(modcomment)") or sqlerr(__FILE__, __LINE__);
            write_log("Cleanup - Removed Custom smilies from " . $count . " members");
        }
        unset($users_buffer, $msgs_buffer, $count);
    }
    //==
    if ($queries > 0) {
        write_log("Custom Smilie Clean -------------------- Custom Smilie cleanup Complete using $queries queries --------------------");
    }
    if (mysqli_affected_rows($GLOBALS["___mysqli_ston"]) !== false) {
        $data['clean_desc'] = mysqli_affected_rows($GLOBALS["___mysqli_ston"]) . " items deleted/updated";
    }
    if ($data['clean_log']) {
        cleanup_log($data);
    }
}
