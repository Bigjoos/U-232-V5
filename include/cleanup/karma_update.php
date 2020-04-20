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
    global $INSTALLER09, $queries, $mc1;
    set_time_limit(0);
    ignore_user_abort(1);
    //=== Update karma seeding bonus... made nicer by devinkray :D
    //==   Updated and optimized by pdq :)
    //=== Using this option will work for multiple torrents UP TO 5!... change the 5 to whatever... 1 to give the karma for only 1 torrent at a time, or 100 to make it unlimited (almost) your choice :P /*if ($arr['tcount'] >= 5) $arr['tcount'] = 1;*/
    ///====== Seeding bonus per torrent
    if ($INSTALLER09['seedbonus_on'] == 1) {
        $What_id = (XBT_TRACKER == true ? 'fid' : 'torrent');
        $What_user_id = (XBT_TRACKER == true ? 'uid' : 'userid');
        $What_Table = (XBT_TRACKER == true ? 'xbt_files_users' : 'peers');
        $What_Where = (XBT_TRACKER == true ? "`left` = 0 AND `active` = 1" : "seeder = 'yes' AND connectable = 'yes'");
        $res = sql_query('SELECT COUNT(' . $What_id . ') As tcount, ' . $What_user_id . ', seedbonus, users.id As users_id FROM ' . $What_Table . ' LEFT JOIN users ON users.id = ' . $What_user_id . ' WHERE ' . $What_Where . ' GROUP BY ' . $What_user_id) or sqlerr(__FILE__, __LINE__);
        if (mysqli_num_rows($res) > 0) {
            while ($arr = mysqli_fetch_assoc($res)) {
                /*if ($arr['tcount'] >= 5) $arr['tcount'] = 1;*/
                $Buffer_User = (XBT_TRACKER == true ? $arr['uid'] : $arr['userid']);
                if ($arr['users_id']== $Buffer_User && $arr['users_id'] != null) {
                    $users_buffer[] = '(' . $Buffer_User . ', ' . $INSTALLER09['bonus_per_duration'] . ' * ' . $arr['tcount'] . ')';
                    $update['seedbonus'] = ($arr['seedbonus'] + $INSTALLER09['bonus_per_duration'] * $arr['tcount']);
                    $mc1->begin_transaction('userstats_' . $Buffer_User);
                    $mc1->update_row(false, [
                        'seedbonus' => $update['seedbonus']
                    ]);
                    $mc1->commit_transaction($INSTALLER09['expires']['u_stats']);
                    $mc1->begin_transaction('user_stats_' . $Buffer_User);
                    $mc1->update_row(false, [
                        'seedbonus' => $update['seedbonus']
                    ]);
                    $mc1->commit_transaction($INSTALLER09['expires']['user_stats']);
                }
            }
            $count = count($users_buffer);
            if ($count > 0) {
                sql_query("INSERT INTO users (id,seedbonus) VALUES " . implode(', ', $users_buffer) . " ON DUPLICATE key UPDATE seedbonus=seedbonus+values(seedbonus)") or sqlerr(__FILE__, __LINE__);
                write_log("Cleanup - " . $count . " users received seedbonus");
            }
            unset($users_buffer, $update, $count);
        }
    }
    //== End
    if ($queries > 0) {
        write_log("Karma clean-------------------- Karma cleanup Complete using $queries queries --------------------");
    }
    if (mysqli_affected_rows($GLOBALS["___mysqli_ston"]) !== false) {
        $data['clean_desc'] = mysqli_affected_rows($GLOBALS["___mysqli_ston"]) . " items updated";
    }
    if ($data['clean_log']) {
        cleanup_log($data);
    }
}
