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
    //===Reset Xmas gifts Bigjoos/pdq:)
    $res = sql_query("SELECT id, modcomment FROM users WHERE gotgift='yes'") or sqlerr(__FILE__, __LINE__);
    $users_buffer = array();
    if (mysqli_num_rows($res) > 0) {
        while ($arr = mysqli_fetch_assoc($res)) {
            $users_buffer[] = '(' . $arr['id'] . ', \'no\')';
            $mc1->begin_transaction('user' . $arr['id']);
            $mc1->update_row(false, array(
                'gotgift' => 'no'
            ));
            $mc1->commit_transaction($INSTALLER09['expires']['user_cache']);
            $mc1->begin_transaction('MyUser_' . $arr['id']);
            $mc1->update_row(false, array(
                'gotgift' => 'no'
            ));
            $mc1->commit_transaction($INSTALLER09['expires']['curuser']);
        }
        $count = count($users_buffer);
        if ($count > 0) {
            sql_query("INSERT INTO users (id, gotgift) VALUES " . implode(', ', $users_buffer) . " ON DUPLICATE key UPDATE gotgift=values(gotgift)") or sqlerr(__FILE__, __LINE__);
            write_log("Cleanup - Reset " . $count . " members Xmas gift");
        }
        unset($users_buffer, $count);
    }
    //==End
    if ($queries > 0) write_log("Xmas gift reset Clean -------------------- Xmas gift reset cleanup Complete using $queries queries --------------------");
    if (false !== mysqli_affected_rows($GLOBALS["___mysqli_ston"])) {
        $data['clean_desc'] = mysqli_affected_rows($GLOBALS["___mysqli_ston"]) . " items deleted/updated";
    }
    if ($data['clean_log']) {
        cleanup_log($data);
    }
}
?>
