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
    //==Irc idle mod - pdq
    $res = sql_query("SELECT id, seedbonus, irctotal FROM users WHERE onirc = 'yes'") or sqlerr(__FILE__, __LINE__);
    if (mysqli_num_rows($res) > 0) {
        while ($arr = mysqli_fetch_assoc($res)) {
            $users_buffer[] = '(' . $arr['id'] . ',0.225,' . $INSTALLER09['autoclean_interval'] . ')'; // .250 karma
            //$users_buffer[] = '('.$arr['id'].',15728640,'.$INSTALLER09['autoclean_interval'].')'; // 15 mb
            $update['seedbonus'] = ($arr['seedbonus'] + 0.225);
            $update['irctotal'] = ($arr['irctotal'] + $INSTALLER09['autoclean_interval']);
            $cache->update_row('user' . $arr['id'],  [
                'irctotal' => $update['irctotal']
            ], $INSTALLER09['expires']['user_cache']);
            $cache->update_row('user_stats' . $arr['id'],  [
                'seedbonus' => $update['seedbonus']
            ], $INSTALLER09['expires']['user_stats']);
            $cache->update_row('userstats_' . $arr['id'],  [
                'seedbonus' => $update['seedbonus']
            ], $INSTALLER09['expires']['u_stats']);
        }
        $count = count($users_buffer);
        if ($count > 0) {
            sql_query("INSERT INTO users (id,seedbonus,irctotal) VALUES " . implode(', ', $users_buffer) . " ON DUPLICATE key UPDATE seedbonus=seedbonus+values(seedbonus),irctotal=irctotal+values(irctotal)") or sqlerr(__FILE__, __LINE__);
            //sql_query("INSERT INTO users (id,uploaded,irctotal) VALUES ".implode(', ',$users_buffer)." ON DUPLICATE key UPDATE uploaded=uploaded+values(uploaded),irctotal=irctotal+values(irctotal)") or sqlerr(__FILE__,__LINE__);
            write_log("Cleanup " . $count . " users idling on IRC");
        }
        unset($users_buffer, $update, $count);
    }
    //== End
    if ($queries > 0) {
        write_log("Irc clean-------------------- Irc cleanup Complete using $queries queries --------------------");
    }
    if (mysqli_affected_rows($GLOBALS["___mysqli_ston"]) !== false) {
        $data['clean_desc'] = mysqli_affected_rows($GLOBALS["___mysqli_ston"]) . " Users updated";
    }
    if ($data['clean_log']) {
        cleanup_log($data);
    }
}
