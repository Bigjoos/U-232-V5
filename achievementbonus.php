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
// Achievements mod by MelvinMeow
require_once (__DIR__ . DIRECTORY_SEPARATOR . 'include' . DIRECTORY_SEPARATOR . 'bittorrent.php');
require_once (INCL_DIR . 'user_functions.php');
require_once (INCL_DIR . 'bbcode_functions.php');
require_once (CLASS_DIR . 'page_verify.php');
dbconn(false);
loggedinorreturn();
$newpage = new page_verify();
$newpage->check('takecounts');
if ($INSTALLER09['achieve_sys_on'] == false) {
stderr($lang['achbon_err'], $lang['achbon_off']);
exit();
}
$lang = array_merge(load_language('global'), load_language('achievementbonus'));
$id = (int)$CURUSER['id'];
$min = 1;
$max = 32;
$rand = (int) mt_rand((int)$min, (int)$max);
$res = sql_query("SELECT achpoints FROM usersachiev WHERE id =" . sqlesc($id) . " AND achpoints >= '1'") or sqlerr(__FILE__, __LINE__);
$row = mysqli_fetch_row($res);
$count = $row['0'];
if (!$count) {
    header("Refresh: 3; url=achievementhistory.php?id=$id");
    stderr($lang['achbon_no_ach_bon_pnts'], $lang['achbon_no_ach_bon_pnts_msg']);
    exit();
}
$HTMLOUT = '';
$get_bonus = sql_query("SELECT * FROM ach_bonus WHERE bonus_id =" . sqlesc($rand)) or sqlerr(__FILE__, __LINE__);
$bonus = mysqli_fetch_assoc($get_bonus);
$bonus_desc = htmlsafechars($bonus['bonus_desc']);
$bonus_type = htmlsafechars($bonus['bonus_type']);
$bonus_do = htmlsafechars($bonus['bonus_do']);
$get_d = sql_query("SELECT * FROM users WHERE id =" . sqlesc($id)) or sqlerr(__FILE__, __LINE__);
$dn = mysqli_fetch_assoc($get_d);
$down = (float)$dn['downloaded'];
$up = (float)$dn['uploaded'];
$invite = (int)$dn['invites'];
$karma = (float)$dn['seedbonus'];
if ($bonus_type == 1) {
    if ($down >= $bonus_do) {
        $msg = "{$lang['achbon_congratulations']}, {$lang['achbon_you_hv_just_won']} $bonus_desc";
        sql_query("UPDATE usersachiev SET achpoints = achpoints-1, spentpoints = spentpoints+1 WHERE id =" . sqlesc($id)) or sqlerr(__FILE__, __LINE__);
        $mc1->delete_value('user_achievement_points_' . $id);
        $sql = "UPDATE users SET downloaded = downloaded - " . sqlesc($bonus_do) . " WHERE id = " . sqlesc($id);
        sql_query($sql) or sqlerr(__FILE__, __LINE__);
        $mc1->begin_transaction('userstats_' . $id);
        $mc1->update_row(false, array(
            'downloaded' => $down - $bonus_do
        ));
        $mc1->commit_transaction($INSTALLER09['expires']['u_stats']);
        $mc1->begin_transaction('user_stats_' . $id);
        $mc1->update_row(false, array(
            'downloaded' => $down - $bonus_do
        ));
        $mc1->commit_transaction($INSTALLER09['expires']['user_stats']);
    }
    if ($down < $bonus_do) {
        $msg = "{$lang['achbon_congratulations']}, {$lang['achbon_your_dl_been_reset_0']}";
        sql_query("UPDATE usersachiev SET achpoints = achpoints-1, spentpoints = spentpoints+1 WHERE id =" . sqlesc($id)) or sqlerr(__FILE__, __LINE__);
        $mc1->delete_value('user_achievement_points_' . $id);
        $sql = "UPDATE users SET downloaded = '0' WHERE id =" . sqlesc($id);
        sql_query($sql) or sqlerr(__FILE__, __LINE__);
        $mc1->begin_transaction('userstats_' . $id);
        $mc1->update_row(false, array(
            'downloaded' => 0
        ));
        $mc1->commit_transaction($INSTALLER09['expires']['u_stats']);
        $mc1->begin_transaction('user_stats_' . $id);
        $mc1->update_row(false, array(
            'downloaded' => 0
        ));
        $mc1->commit_transaction($INSTALLER09['expires']['user_stats']);
    }
}
if ($bonus_type == 2) {
    $msg = "{$lang['achbon_congratulations']}, {$lang['achbon_you_hv_just_won']} $bonus_desc";
    sql_query("UPDATE usersachiev SET achpoints = achpoints-1, spentpoints = spentpoints+1 WHERE id = " . sqlesc($id)) or sqlerr(__FILE__, __LINE__);
    $mc1->delete_value('user_achievement_points_' . $id);
    $sql = "UPDATE users SET uploaded = uploaded + " . sqlesc($bonus_do) . " WHERE id =" . sqlesc($id);
    sql_query($sql) or sqlerr(__FILE__, __LINE__);
    $mc1->begin_transaction('userstats_' . $id);
    $mc1->update_row(false, array(
        'uploaded' => $up + $bonus_do
    ));
    $mc1->commit_transaction($INSTALLER09['expires']['u_stats']);
    $mc1->begin_transaction('user_stats_' . $id);
    $mc1->update_row(false, array(
        'uploaded' => $up + $bonus_do
    ));
    $mc1->commit_transaction($INSTALLER09['expires']['user_stats']);
}
if ($bonus_type == 3) {
    $msg = "{$lang['achbon_congratulations']}, {$lang['achbon_you_hv_just_won']} $bonus_desc";
    sql_query("UPDATE usersachiev SET achpoints = achpoints-1, spentpoints = spentpoints+1 WHERE id = " . sqlesc($id)) or sqlerr(__FILE__, __LINE__);
    $mc1->delete_value('user_achievement_points_' . $id);
    $sql = "UPDATE users SET invites = invites + " . sqlesc($bonus_do) . " WHERE id =" . sqlesc($id);
    sql_query($sql) or sqlerr(__FILE__, __LINE__);
    $mc1->begin_transaction('user' . $id);
    $mc1->update_row(false, array(
        'invites' => $invite + $bonus_do
    ));
    $mc1->commit_transaction($INSTALLER09['expires']['user_cache']);
    $mc1->begin_transaction('MyUser_' . $id);
    $mc1->update_row(false, array(
        'invites' => $invite + $bonus_do
    ));
    $mc1->commit_transaction($INSTALLER09['expires']['curuser']);
}
if ($bonus_type == 4) {
    $msg = "{$lang['achbon_congratulations']}, {$lang['achbon_you_hv_just_won']} $bonus_desc";
    sql_query("UPDATE usersachiev SET achpoints = achpoints-1, spentpoints = spentpoints+1 WHERE id =" . sqlesc($id)) or sqlerr(__FILE__, __LINE__);
    $mc1->delete_value('user_achievement_points_' . $id);
    $sql = "UPDATE users SET seedbonus = seedbonus + " . sqlesc($bonus_do) . " WHERE id =" . sqlesc($id);
    sql_query($sql) or sqlerr(__FILE__, __LINE__);
    $mc1->begin_transaction('userstats_' . $id);
    $mc1->update_row(false, array(
        'seedbonus' => $karma + $bonus_do
    ));
    $mc1->commit_transaction($INSTALLER09['expires']['u_stats']);
    $mc1->begin_transaction('user_stats_' . $id);
    $mc1->update_row(false, array(
        'seedbonus' => $karma + $bonus_do
    ));
    $mc1->commit_transaction($INSTALLER09['expires']['user_stats']);
}
if ($bonus_type == 5) {
    $rand_fail = rand(1, 5);
    if ($rand_fail == 1) {
        $msg = "{$lang['gl_sorry']}, {$lang['achbon_failed_msg1']}";
        sql_query("UPDATE usersachiev SET achpoints = achpoints-1, spentpoints = spentpoints+1 WHERE id =" . sqlesc($id)) or sqlerr(__FILE__, __LINE__);
        $mc1->delete_value('user_achievement_points_' . $id);
    }
    if ($rand_fail == 2) {
        $msg = "{$lang['gl_sorry']}, {$lang['achbon_failed_msg2']}";
        sql_query("UPDATE usersachiev SET achpoints = achpoints-1, spentpoints = spentpoints+1 WHERE id =" . sqlesc($id)) or sqlerr(__FILE__, __LINE__);
        $mc1->delete_value('user_achievement_points_' . $id);
    }
    if ($rand_fail == 3) {
        $msg = "{$lang['gl_sorry']}, {$lang['achbon_failed_msg3']}";
        sql_query("UPDATE usersachiev SET achpoints = achpoints-1, spentpoints = spentpoints+1 WHERE id =" . sqlesc($id)) or sqlerr(__FILE__, __LINE__);
        $mc1->delete_value('user_achievement_points_' . $id);
    }
    if ($rand_fail == 4) {
        $msg = "{$lang['gl_sorry']}, {$lang['achbon_failed_msg4']}";
        sql_query("UPDATE usersachiev SET achpoints = achpoints-1, spentpoints = spentpoints+1 WHERE id =" . sqlesc($id)) or sqlerr(__FILE__, __LINE__);
        $mc1->delete_value('user_achievement_points_' . $id);
    }
    if ($rand_fail == 5) {
        $msg = "{$lang['gl_sorry']}, {$lang['achbon_failed_msg5']}";
        sql_query("UPDATE usersachiev SET achpoints = achpoints-1, spentpoints = spentpoints+1 WHERE id =" . sqlesc($id)) or sqlerr(__FILE__, __LINE__);
        $mc1->delete_value('user_achievement_points_' . $id);
    }
}
header("Refresh: 3; url=achievementhistory.php?id=$id");
stderr($lang['achbon_random_achievement_bonus'], "$msg");
echo stdhead($lang['achbon_std_head']) . $HTMLOUT . stdfoot();
?>
