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
$lang = array_merge(load_language('global') , load_language('takerate'));
if (!mkglobal("id")) die();
$id = (int) $id;
if (!is_valid_id($id)) stderr("Error", "Bad Id");
if (!isset($CURUSER)) stderr("Error", "Your not logged in");
$res = sql_query("SELECT 1, thanks, comments FROM torrents WHERE id = " . sqlesc($id)) or sqlerr(__FILE__, __LINE__);
$arr = mysqli_fetch_assoc($res);
if (!$arr) stderr("Error", "Torrent not found");
$res1 = sql_query("SELECT 1 FROM thankyou WHERE torid=" . sqlesc($id) . " AND uid =" . sqlesc($CURUSER["id"])) or sqlerr(__FILE__, __LINE__);
$row = mysqli_fetch_assoc($res1);
if ($row) stderr("Error", "You already thanked.");
$text = ":thankyou:";
$newid = ((is_null($___mysqli_res = mysqli_insert_id($GLOBALS["___mysqli_ston"]))) ? false : $___mysqli_res);
sql_query("INSERT INTO thankyou (uid, torid, thank_date) VALUES (" . sqlesc($CURUSER["id"]) . ", " . sqlesc($id) . ", '" . TIME_NOW . "')") or sqlerr(__FILE__, __LINE__);
sql_query("INSERT INTO comments (user, torrent, added, text, ori_text) VALUES (" . sqlesc($CURUSER["id"]) . ", " . sqlesc($id) . ", '" . TIME_NOW . "', " . sqlesc($text) . "," . sqlesc($text) . ")") or sqlerr(__FILE__, __LINE__);
sql_query("UPDATE torrents SET thanks = thanks + 1, comments = comments + 1 WHERE id = " . sqlesc($id)) or sqlerr(__FILE__, __LINE__);
$update['thanks'] = ($arr['thanks'] + 1);
$update['comments'] = ($arr['comments'] + 1);
$mc1->begin_transaction('torrent_details_' . $id);
$mc1->update_row(false, array(
    'thanks' => $update['thanks'],
    'comments' => $update['comments']
));
$mc1->commit_transaction($INSTALLER09['expires']['torrent_details']);
if ($INSTALLER09['seedbonus_on'] == 1) {
    //===add karma
    sql_query("UPDATE users SET seedbonus = seedbonus+5.0 WHERE id = " . sqlesc($CURUSER['id'])) or sqlerr(__FILE__, __LINE__);
    $update['seedbonus'] = ($CURUSER['seedbonus'] + 5);
    $mc1->begin_transaction('userstats_' . $CURUSER["id"]);
    $mc1->update_row(false, array(
        'seedbonus' => $update['seedbonus']
    ));
    $mc1->commit_transaction($INSTALLER09['expires']['u_stats']);
    $mc1->begin_transaction('user_stats_' . $CURUSER["id"]);
    $mc1->update_row(false, array(
        'seedbonus' => $update['seedbonus']
    ));
    $mc1->commit_transaction($INSTALLER09['expires']['user_stats']);
    //===end
    
}
header("Refresh: 0; url=details.php?id=$id");
?>
