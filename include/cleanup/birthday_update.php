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
    //== Pm birthday users
    $current_date = getdate();
    $res = sql_query("SELECT id, username, class, donor, title, warned, enabled, chatpost, leechwarn, pirate, king, uploaded, birthday FROM users WHERE MONTH(birthday) = " . sqlesc($current_date['mon']) . " AND DAYOFMONTH(birthday) = " . sqlesc($current_date['mday']) . " ORDER BY username ASC") or sqlerr(__FILE__, __LINE__);
    $msgs_buffer = $users_buffer = array();
    if (mysqli_num_rows($res) > 0) {
        while ($arr = mysqli_fetch_assoc($res)) {
            $msg = "Hey there  " . htmlsafechars($arr['username']) . " happy birthday, hope you have a good day we awarded you 10 gig...Njoi.\n";
            $subject = "Its your birthday!!";
            $msgs_buffer[] = '(0,' . $arr['id'] . ', ' . TIME_NOW . ', ' . sqlesc($msg) . ', ' . sqlesc($subject) . ')';
            $users_buffer[] = '(' . $arr['id'] . ', 10737418240)';
            $update['uploaded'] = ($arr['uploaded'] + 10737418240);
            $mc1->begin_transaction('userstats_' . $arr['id']);
            $mc1->update_row(false, array(
                'uploaded' => $update['uploaded']
            ));
            $mc1->commit_transaction($INSTALLER09['expires']['u_stats']);
            $mc1->begin_transaction('user_stats_' . $arr['id']);
            $mc1->update_row(false, array(
                'uploaded' => $update['uploaded']
            ));
            $mc1->commit_transaction($INSTALLER09['expires']['user_stats']);
        }
        $count = count($users_buffer);
        if ($count > 0) {
            sql_query("INSERT INTO messages (sender,receiver,added,msg,subject) VALUES " . implode(', ', $msgs_buffer)) or sqlerr(__FILE__, __LINE__);
            sql_query("INSERT INTO users (id, uploaded) VALUES " . implode(', ', $users_buffer) . " ON DUPLICATE key UPDATE uploaded=uploaded+values(uploaded)") or sqlerr(__FILE__, __LINE__);
            write_log("Cleanup: Pm'd' " . $count . " member(s) and awarded a birthday prize");
        }
        unset($users_buffer, $msgs_buffer, $count);
    }
    //==End
    if (false !== mysqli_affected_rows($GLOBALS["___mysqli_ston"])) {
        $data['clean_desc'] = mysqli_affected_rows($GLOBALS["___mysqli_ston"]) . " items deleted/updated";
    }
    if ($data['clean_log']) {
        cleanup_log($data);
    }
}
?>
