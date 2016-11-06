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
require_once(__DIR__ . DIRECTORY_SEPARATOR . 'include' . DIRECTORY_SEPARATOR . 'bittorrent.php');
require_once(INCL_DIR . 'user_functions.php');
dbconn();
loggedinorreturn();
$lang = array_merge(load_language('global'), load_language('coins'));

// / Mod by dokty - tbdev.net
$id = (int) $_GET["id"];
$points = (int) $_GET["points"];
if (!is_valid_id($id) || !is_valid_id($points))
    die();
$pointscangive = array(
    "10",
    "20",
    "50",
    "100",
    "200",
    "500",
    "1000"
);
if (!in_array($points, $pointscangive))
    stderr($lang['gl_error'], $lang['coins_you_cant_give_that_amount_of_points']);
$sdsa = sql_query("SELECT 1 FROM coins WHERE torrentid=" . sqlesc($id) . " AND userid =" . sqlesc($CURUSER["id"])) or sqlerr(__FILE__, __LINE__);
$asdd = mysqli_fetch_assoc($sdsa);
if ($asdd)
    stderr($lang['gl_error'], $lang['coins_you_already_gave_points_to_this_torrent']);
$res = sql_query("SELECT owner,name,points FROM torrents WHERE id = " . sqlesc($id)) or sqlerr(__FILE__, __LINE__);
$row = mysqli_fetch_assoc($res) or stderr($lang['gl_error'], $lang['coins_torrent_was_not_found']);
$userid = (int) $row["owner"];
if ($userid == $CURUSER["id"])
    stderr($lang['gl_error'], $lang['coins_you_cant_give_your_self_points']);
if ($CURUSER["seedbonus"] < $points)
    stderr($lang['gl_error'], $lang['coins_you_dont_have_enough_points']);
$sql = sql_query('SELECT seedbonus ' . 'FROM users ' . 'WHERE id = ' . sqlesc($userid)) or sqlerr(__FILE__, __LINE__);
$User = mysqli_fetch_assoc($sql);
sql_query("INSERT INTO coins (userid, torrentid, points) VALUES (" . sqlesc($CURUSER["id"]) . ", " . sqlesc($id) . ", " . sqlesc($points) . ")") or sqlerr(__FILE__, __LINE__);
sql_query("UPDATE users SET seedbonus=seedbonus+" . sqlesc($points) . " WHERE id=" . sqlesc($userid)) or sqlerr(__FILE__, __LINE__);
sql_query("UPDATE users SET seedbonus=seedbonus-" . sqlesc($points) . " WHERE id=" . sqlesc($CURUSER["id"])) or sqlerr(__FILE__, __LINE__);
sql_query("UPDATE torrents SET points=points+" . sqlesc($points) . " WHERE id=" . sqlesc($id)) or sqlerr(__FILE__, __LINE__);
$msg = sqlesc("{$lang['coins_you_have_been_given']} " . htmlsafechars($points) . " {$lang['coins_points_by']} " . $CURUSER["username"] . " {$lang['coins_for_torrent']} [url=" . $INSTALLER09['baseurl'] . "/details.php?id=" . $id . "]" . htmlsafechars($row["name"]) . "[/url].");
$subject = sqlesc($lang['coins_you_have_been_given_a_gift']);
sql_query("INSERT INTO messages (sender, receiver, msg, added, subject) VALUES({$INSTALLER09['bot_id']}, " . sqlesc($userid) . ", $msg, " . TIME_NOW . ", $subject)") or sqlerr(__FILE__, __LINE__);
$update['points'] = ($row['points'] + $points);
$update['seedbonus_uploader'] = ($User['seedbonus'] + $points);
$update['seedbonus_donator'] = ($CURUSER['seedbonus'] - $points);
//==The torrent
$mc1->begin_transaction('torrent_details_' . $id);
$mc1->update_row(false, array(
    'points' => $update['points']
));
$mc1->commit_transaction($INSTALLER09['expires']['torrent_details']);
//==The uploader
$mc1->begin_transaction('userstats_' . $userid);
$mc1->update_row(false, array(
    'seedbonus' => $update['seedbonus_uploader']
));
$mc1->commit_transaction($INSTALLER09['expires']['u_stats']);
$mc1->begin_transaction('user_stats_' . $userid);
$mc1->update_row(false, array(
    'seedbonus' => $update['seedbonus_uploader']
));
$mc1->commit_transaction($INSTALLER09['expires']['user_stats']);
//==The donator
$mc1->begin_transaction('userstats_' . $CURUSER["id"]);
$mc1->update_row(false, array(
    'seedbonus' => $update['seedbonus_donator']
));
$mc1->commit_transaction($INSTALLER09['expires']['u_stats']);
$mc1->begin_transaction('user_stats_' . $CURUSER["id"]);
$mc1->update_row(false, array(
    'seedbonus' => $update['seedbonus_donator']
));
$mc1->commit_transaction($INSTALLER09['expires']['user_stats']);
//== delete the pm keys
$mc1->delete_value('inbox_new_' . $userid);
$mc1->delete_value('inbox_new_sb_' . $userid);
$mc1->delete_value('coin_points_' . $id);
header("Refresh: 3; url=details.php?id=$id");
stderr($lang['coins_done'], $lang['coins_successfully_gave_points_to_this_torrent']);
?>
