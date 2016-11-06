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
require_once (__DIR__ . DIRECTORY_SEPARATOR . 'include' . DIRECTORY_SEPARATOR . 'bittorrent.php');
require_once (INCL_DIR . 'user_functions.php');
dbconn();
loggedinorreturn();
$lang = array_merge(load_language('global'), load_language('createlink'));
if ($CURUSER['class'] < UC_STAFF) stderr($lang['createlink_no_permision'], $lang['createlink_system_file']);
$id = (isset($_GET['id']) ? (int) $_GET['id'] : (isset($_POST['id']) ? (int) $_POST['id'] : NULL));
 if (!$id || !is_valid_id($id)) stderr("{$lang['gl_error']}", "{$lang['gl_bad_id']}");

$action = isset($_GET['action']) ? htmlsafechars($_GET['action']) : '';
$res = sql_query("SELECT hash1, username, passhash FROM users WHERE id = " . sqlesc($id) . " AND class >= " . UC_STAFF) or sqlerr(__FILE__, __LINE__);
$arr = mysqli_fetch_assoc($res);
$hash1 = md5($arr['username'] . TIME_NOW . $arr['passhash']);
$hash2 = md5($hash1 . TIME_NOW . $arr['username']);
$hash3 = md5($hash1 . $hash2 . $arr['passhash']);
$hash1.= $hash2 . $hash3;
if ($action == 'reset') {
    $sure = isset($_GET['sure']) ? (int)($_GET['sure']) : 0;
    if ($sure != '1') stderr($lang['createlink_sanity_check'], "{$lang['createlink_you_are_about_to_reset_your_login_link']} <a href='createlink.php?action=reset&amp;id=$id&amp;sure=1'>{$lang['createlink_here']}</a> {$lang['createlink_if_you_are_sure']}.");
    sql_query("UPDATE users SET hash1 = " . sqlesc($hash1) . " WHERE id = " . sqlesc($id)) or sqlerr(__FILE__, __LINE__);
    $mc1->begin_transaction('user' . $id);
    $mc1->update_row(false, array(
        'hash1' => $hash1
    ));
    $mc1->commit_transaction($INSTALLER09['expires']['user_cache']);
    $mc1->begin_transaction('MyUser_' . $id);
    $mc1->update_row(false, array(
        'hash1' => $hash1
    ));
    $mc1->commit_transaction($INSTALLER09['expires']['curuser']);
    $mc1->begin_transaction('hash1_' . $id);
    $mc1->update_row(false, array(
        'hash1' => $hash1
    ));
    $mc1->commit_transaction($INSTALLER09['expires']['user_hash']);
    header("Refresh: 1; url={$INSTALLER09['baseurl']}/userdetails.php?id=$id");
    stderr($lang['createlink_success'], $lang['createlink_your_login_link_was_reset_successfully']);
} else {
    if ($arr['hash1'] === NULL || $arr['hash1'] === '') {
        sql_query("UPDATE users SET hash1 = " . sqlesc($hash1) . " WHERE id = " . sqlesc($id)) or sqlerr(__FILE__, __LINE__);
        header("Refresh: 2; url={$INSTALLER09['baseurl']}/userdetails.php?id=$id");
        $mc1->begin_transaction('user' . $id);
        $mc1->update_row(false, array(
            'hash1' => $hash1
        ));
        $mc1->commit_transaction($INSTALLER09['expires']['user_cache']);
        $mc1->begin_transaction('MyUser_' . $id);
        $mc1->update_row(false, array(
            'hash1' => $hash1
        ));
        $mc1->commit_transaction($INSTALLER09['expires']['curuser']);
        $mc1->begin_transaction('hash1_' . $id);
        $mc1->update_row(false, array(
            'hash1' => $hash1
        ));
        $mc1->commit_transaction($INSTALLER09['expires']['user_hash']);
        stderr('Success', $lang['createlink_your_login_link_was_created_successfully']);
    } else {
        header("Refresh: 2; url={$INSTALLER09['baseurl']}/userdetails.php?id=$id");
        stderr($lang['gl_error'], $lang['createlink_you_have_already_created_your_login_link']);
    }
}
?>
