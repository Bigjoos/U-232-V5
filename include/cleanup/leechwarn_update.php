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
    set_time_limit(1200);
    ignore_user_abort(1);
    //== 09 Auto leech warn by Bigjoos/pdq
    //== Updated/modified autoleech warning script
    $minratio = 0.3; // ratio < 0.4
    $base_ratio = 0.0;
    $downloaded = 10 * 1024 * 1024 * 1024; // + 10 GB
    $length = 3 * 7; // Give 3 weeks to let them sort there shit
    $res = sql_query("SELECT id, modcomment FROM users WHERE enabled='yes' AND class = " . UC_USER . " AND leechwarn = '0' AND uploaded / downloaded < $minratio AND uploaded / downloaded > $base_ratio AND downloaded >= $downloaded AND immunity = '0'") or sqlerr(__FILE__, __LINE__);
    $msgs_buffer = $users_buffer = array();
    if (mysqli_num_rows($res) > 0) {
        $dt = sqlesc(TIME_NOW);
        $subject = "Auto leech warned";
        $msg = "You have been warned and your download rights have been removed due to your low ratio. You need to get a ratio of 0.5 within the next 3 weeks or your Account will be disabled.";
        $leechwarn = TIME_NOW + ($length * 86400);
        while ($arr = mysqli_fetch_assoc($res)) {
            $modcomment = $arr['modcomment'];
            $modcomment = get_date(TIME_NOW, 'DATE', 1) . " - Automatically Leech warned and downloads disabled By System.\n" . $modcomment;
            $modcom = sqlesc($modcomment);
            $msgs_buffer[] = '(0,' . $arr['id'] . ', ' . TIME_NOW . ', ' . sqlesc($msg) . ', ' . sqlesc($subject) . ')';
            $users_buffer[] = '(' . $arr['id'] . ',' . $leechwarn . ',\'0\', ' . $modcom . ')';
            $update['leechwarn'] = ($leechwarn);
            $mc1->begin_transaction('user' . $arr['id']);
            $mc1->update_row(false, array(
                'leechwarn' => $update['leechwarn'],
                'downloadpos' => 0
            ));
            $mc1->commit_transaction($INSTALLER09['expires']['user_cache']);
            $mc1->begin_transaction('MyUser_' . $arr['id']);
            $mc1->update_row(false, array(
                'leechwarn' => $update['leechwarn'],
                'downloadpos' => 0
            ));
            $mc1->commit_transaction($INSTALLER09['expires']['curuser']);
            $mc1->begin_transaction('user_stats_' . $arr['id']);
            $mc1->update_row(false, array(
                'modcomment' => $modcomment
            ));
            $mc1->commit_transaction($INSTALLER09['expires']['user_stats']);
            $mc1->delete_value('inbox_new_' . $arr['id']);
            $mc1->delete_value('inbox_new_sb_' . $arr['id']);
        }
        $count = count($users_buffer);
        if ($count > 0) {
            sql_query("INSERT INTO messages (sender,receiver,added,msg,subject) VALUES " . implode(', ', $msgs_buffer)) or sqlerr(__FILE__, __LINE__);
            sql_query("INSERT INTO users (id, leechwarn, downloadpos, modcomment) VALUES " . implode(', ', $users_buffer) . " ON DUPLICATE key UPDATE leechwarn=values(leechwarn),downloadpos=values(downloadpos),modcomment=values(modcomment)") or sqlerr(__FILE__, __LINE__);
            write_log("Cleanup: System applied auto leech Warning(s) to  " . $count . " Member(s)");
        }
        unset($users_buffer, $msgs_buffer, $update, $count);
    }
    //End
    //== 09 Auto leech warn by Bigjoos/pdq
    //== Updated/Modified autoleech warn system - Remove warning and enable downloads
    $minratio = 0.5; // ratio > 0.5
    $res = sql_query("SELECT id, modcomment FROM users WHERE downloadpos = '0' AND leechwarn > '1' AND uploaded / downloaded >= $minratio") or sqlerr(__FILE__, __LINE__);
    $msgs_buffer = $users_buffer = array();
    if (mysqli_num_rows($res) > 0) {
        $subject = "Auto leech warning removed";
        $msg = "Your warning for a low ratio has been removed and your downloads enabled. We highly recommend you to keep your ratio positive to avoid being automatically warned again.\n";
        while ($arr = mysqli_fetch_assoc($res)) {
            $modcomment = $arr['modcomment'];
            $modcomment = get_date(TIME_NOW, 'DATE', 1) . " - Leech warn removed and download enabled By System.\n" . $modcomment;
            $modcom = sqlesc($modcomment);
            $msgs_buffer[] = '(0,' . $arr['id'] . ',' . TIME_NOW . ', ' . sqlesc($msg) . ',  ' . sqlesc($subject) . ')';
            $users_buffer[] = '(' . $arr['id'] . ', \'0\', \'1\', ' . $modcom . ')';
            $mc1->begin_transaction('user' . $arr['id']);
            $mc1->update_row(false, array(
                'leechwarn' => 0,
                'downloadpos' => 1
            ));
            $mc1->commit_transaction($INSTALLER09['expires']['user_cache']);
            $mc1->begin_transaction('MyUser_' . $arr['id']);
            $mc1->update_row(false, array(
                'leechwarn' => 0,
                'downloadpos' => 1
            ));
            $mc1->commit_transaction($INSTALLER09['expires']['curuser']);
            $mc1->begin_transaction('user_stats_' . $arr['id']);
            $mc1->update_row(false, array(
                'modcomment' => $modcomment
            ));
            $mc1->commit_transaction($INSTALLER09['expires']['user_stats']);
            $mc1->delete_value('inbox_new_' . $arr['id']);
            $mc1->delete_value('inbox_new_sb_' . $arr['id']);
        }
        $count = count($users_buffer);
        if ($count > 0) {
            sql_query("INSERT INTO messages (sender,receiver,added,msg,subject) VALUES " . implode(', ', $msgs_buffer)) or sqlerr(__FILE__, __LINE__);
            sql_query("INSERT INTO users (id, leechwarn, downloadpos, modcomment) VALUES " . implode(', ', $users_buffer) . " ON DUPLICATE key UPDATE leechwarn=values(leechwarn),downloadpos=values(downloadpos),modcomment=values(modcomment)") or sqlerr(__FILE__, __LINE__);
            write_log("Cleanup: System removed auto leech Warning(s) and renabled download(s) - " . $count . " Member(s)");
        }
        unset($users_buffer, $msgs_buffer, $count);
    }
    //==End
    //== 09 Auto leech warn by Bigjoos/pdq
    //== Disabled expired leechwarns
    $res = sql_query("SELECT id, modcomment FROM users WHERE leechwarn > '1' AND leechwarn < " . TIME_NOW . " AND leechwarn <> '0' ") or sqlerr(__FILE__, __LINE__);
    $users_buffer = array();
    if (mysqli_num_rows($res) > 0) {
        while ($arr = mysqli_fetch_assoc($res)) {
            $modcomment = $arr['modcomment'];
            $modcomment = get_date(TIME_NOW, 'DATE', 1) . " - User disabled - Low ratio.\n" . $modcomment;
            $modcom = sqlesc($modcomment);
            $users_buffer[] = '(' . $arr['id'] . ' , \'0\', \'no\', ' . $modcom . ')';
            $mc1->begin_transaction('user' . $arr['id']);
            $mc1->update_row(false, array(
                'leechwarn' => 0,
                'enabled' => 'no'
            ));
            $mc1->commit_transaction($INSTALLER09['expires']['user_cache']);
            $mc1->begin_transaction('user_stats_' . $arr['id']);
            $mc1->update_row(false, array(
                'modcomment' => $modcomment
            ));
            $mc1->commit_transaction($INSTALLER09['expires']['user_stats']);
            $mc1->begin_transaction('MyUser_' . $arr['id']);
            $mc1->update_row(false, array(
                'leechwarn' => 0,
                'enabled' => 'no'
            ));
            $mc1->commit_transaction($INSTALLER09['expires']['curuser']);
        }
        $count = count($users_buffer);
        if ($count > 0) {
            sql_query("INSERT INTO users (id, leechwarn, enabled, modcomment) VALUES " . implode(', ', $users_buffer) . " ON DUPLICATE key UPDATE class=values(class),leechwarn=values(leechwarn),enabled=values(enabled),modcomment=values(modcomment)") or sqlerr(__FILE__, __LINE__);
            write_log("Cleanup: Disabled " . $count . " Member(s) - Leechwarns expired");
        }
        unset($users_buffer, $count);
    }
    //==End
    if ($queries > 0) write_log("Leechwarn Clean -------------------- Leechwarn cleanup Complete using $queries queries --------------------");
    if (false !== mysqli_affected_rows($GLOBALS["___mysqli_ston"])) {
        $data['clean_desc'] = mysqli_affected_rows($GLOBALS["___mysqli_ston"]) . " items deleted/updated";
    }
    if ($data['clean_log']) {
        cleanup_log($data);
    }
}
?>
