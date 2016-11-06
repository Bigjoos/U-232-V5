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
    //==Irc idle mod - pdq
    $res = sql_query("SELECT id, seedbonus, irctotal FROM users WHERE onirc = 'yes'") or sqlerr(__FILE__, __LINE__);
    if (mysqli_num_rows($res) > 0) {
        while ($arr = mysqli_fetch_assoc($res)) {
            $users_buffer[] = '(' . $arr['id'] . ',0.225,' . $INSTALLER09['autoclean_interval'] . ')'; // .250 karma
            //$users_buffer[] = '('.$arr['id'].',15728640,'.$INSTALLER09['autoclean_interval'].')'; // 15 mb
            $update['seedbonus'] = ($arr['seedbonus'] + 0.225);
            $update['irctotal'] = ($arr['irctotal'] + $INSTALLER09['autoclean_interval']);
            $mc1->begin_transaction('user' . $arr['id']);
            $mc1->update_row(false, array(
                'irctotal' => $update['irctotal']
            ));
            $mc1->commit_transaction($INSTALLER09['expires']['user_cache']);
            $mc1->begin_transaction('user_stats' . $arr['id']);
            $mc1->update_row(false, array(
                'seedbonus' => $update['seedbonus']
            ));
            $mc1->commit_transaction($INSTALLER09['expires']['user_stats']);
            $mc1->begin_transaction('userstats_' . $arr['id']);
            $mc1->update_row(false, array(
                'seedbonus' => $update['seedbonus']
            ));
            $mc1->commit_transaction($INSTALLER09['expires']['u_stats']);
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
    if ($queries > 0) write_log("Irc clean-------------------- Irc cleanup Complete using $queries queries --------------------");
    if (false !== mysqli_affected_rows($GLOBALS["___mysqli_ston"])) {
        $data['clean_desc'] = mysqli_affected_rows($GLOBALS["___mysqli_ston"]) . " Users updated";
    }
    if ($data['clean_log']) {
        cleanup_log($data);
    }
}
?>
