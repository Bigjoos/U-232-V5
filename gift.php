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
$lang = array_merge(load_language('global'));
$xmasday = mktime(0, 0, 0, 12, 25, date("Y"));
$today = mktime(date("G") , date("i") , date("s") , date("m") , date("d") , date("Y"));
$gifts = array(
    "upload",
    "bonus",
    "invites",
    "bonus2"
);
$randgift = array_rand($gifts);
$gift = $gifts[$randgift];
$userid = 0 + $CURUSER["id"];
if (!is_valid_id($userid)) stderr("Error", "Invalid ID");
$open = (isset($_GET['open']) ? intval($_GET['open']) : 0);
if ($open != 1) {
    stderr("Error", "Invalid url");
}
$sql = sql_query('SELECT seedbonus, invites, freeslots, uploaded ' . 'FROM users ' . 'WHERE id = ' . sqlesc($userid)) or sqlerr(__FILE__, __LINE__);
$User = mysqli_fetch_assoc($sql);
if (isset($open) && $open == 1) {
    if ($today >= $xmasday) {
        //if (!($CURUSER["opt1"] & user_options::GOTGIFT)) {
            if ($CURUSER["gotgift"] == 'no') {
            if ($gift == "upload") {
                sql_query("UPDATE users SET invites=invites+1, uploaded=uploaded+1024*1024*1024*10, freeslots=freeslots+1, gotgift='yes' WHERE id=" . sqlesc($userid)) or sqlerr(__FILE__, __LINE__);
                $update['invites'] = ($User['invites'] + 1);
                $update['uploaded'] = ($User['uploaded'] + 1024 * 1024 * 1024 * 10);
                $update['freeslots'] = ($User['freeslots'] + 1);
                $mc1->begin_transaction('userstats_' . $userid);
                $mc1->update_row(false, array(
                    'uploaded' => $update['uploaded']
                ));
                $mc1->commit_transaction($INSTALLER09['expires']['u_stats']);
                $mc1->begin_transaction('user_stats_' . $userid);
                $mc1->update_row(false, array(
                    'uploaded' => $update['uploaded']
                ));
                $mc1->commit_transaction($INSTALLER09['expires']['user_stats']);
                $mc1->begin_transaction('user' . $userid);
                $mc1->update_row(false, array(
                    'invites' => $update['invites'],
                    'freeslots' => $update['freeslots'],
                    'gotgift' => 'yes'
                ));
                $mc1->commit_transaction($INSTALLER09['expires']['user_cache']);
                $mc1->begin_transaction('MyUser_' . $userid);
                $mc1->update_row(false, array(
                    'invites' => $update['invites'],
                    'freeslots' => $update['freeslots'],
                    'gotgift' => 'yes'
                ));
                $mc1->commit_transaction($INSTALLER09['expires']['curuser']);
                header('Refresh: 5; url=' . $INSTALLER09['baseurl'] . '/index.php');
                stderr("Congratulations!", "<img src=\"{$INSTALLER09['pic_base_url']}gift.png\" style=\"float: left; padding-right:10px;\" alt=\"Xmas Gift\" title=\"Xmas Gift\" /> <h2> You just got  1 invite 10 GB upload and bonus 1 freeslot !</h2>
Thanks for your support and sharing through year " . date('Y') . " ! <br /> Merry Christmas and a happy New Year from {$INSTALLER09['site_name']}  Crew ! Redirecting in 5..4..3..2..1");
            }
            if ($gift == "bonus") {
                sql_query("UPDATE users SET invites=invites+3,  seedbonus = seedbonus + 1750, gotgift='yes' WHERE id=" . sqlesc($userid)) or sqlerr(__FILE__, __LINE__);
                $update['invites'] = ($User['invites'] + 3);
                $update['seedbonus'] = ($User['seedbonus'] + 1750);
                $mc1->begin_transaction('userstats_' . $userid);
                $mc1->update_row(false, array(
                    'seedbonus' => $update['seedbonus']
                ));
                $mc1->commit_transaction($INSTALLER09['expires']['u_stats']);
                $mc1->begin_transaction('user_stats_' . $userid);
                $mc1->update_row(false, array(
                    'seedbonus' => $update['seedbonus']
                ));
                $mc1->commit_transaction($INSTALLER09['expires']['user_stats']);
                $mc1->begin_transaction('user' . $userid);
                $mc1->update_row(false, array(
                    'invites' => $update['invites'],
                    'gotgift' => 'yes'
                ));
                $mc1->commit_transaction($INSTALLER09['expires']['user_cache']);
                $mc1->begin_transaction('MyUser_' . $userid);
                $mc1->update_row(false, array(
                    'invites' => $update['invites'],
                    'gotgift' => 'yes'
                ));
                $mc1->commit_transaction($INSTALLER09['expires']['curuser']);
                header('Refresh: 5; url=' . $INSTALLER09['baseurl'] . '/index.php');
                stderr("Congratulations!", "<img src=\"{$INSTALLER09['pic_base_url']}gift.png\" style=\"float: left; padding-right:10px;\" alt=\"Xmas Gift\" title=\"Xmas Gift\" /> <h2> You just got 3 invites 1750 karma bonus points !</h2>
Thanks for your support and sharing through year " . date('Y') . " ! <br /> Merry Christmas and a happy New Year from {$INSTALLER09['site_name']}  Crew ! Redirecting in 5..4..3..2..1");
            }
            if ($gift == "invites") {
                sql_query("UPDATE users SET invites=invites+2, seedbonus = seedbonus + 2000, freeslots=freeslots+3, gotgift='yes' WHERE id=" . sqlesc($userid)) or sqlerr(__FILE__, __LINE__);
                $update['invites'] = ($User['invites'] + 2);
                $update['seedbonus'] = ($User['seedbonus'] + 2000);
                $update['freeslots'] = ($User['freeslots'] + 3);
                $mc1->begin_transaction('userstats_' . $userid);
                $mc1->update_row(false, array(
                    'seedbonus' => $update['seedbonus']
                ));
                $mc1->commit_transaction($INSTALLER09['expires']['u_stats']);
                $mc1->begin_transaction('user_stats_' . $userid);
                $mc1->update_row(false, array(
                    'seedbonus' => $update['seedbonus']
                ));
                $mc1->commit_transaction($INSTALLER09['expires']['user_stats']);
                $mc1->begin_transaction('user' . $userid);
                $mc1->update_row(false, array(
                    'invites' => $update['invites'],
                    'freeslots' => $update['freeslots'],
                    'gotgift' => 'yes'
                ));
                $mc1->commit_transaction($INSTALLER09['expires']['user_cache']);
                $mc1->begin_transaction('MyUser_' . $userid);
                $mc1->update_row(false, array(
                    'invites' => $update['invites'],
                    'freeslots' => $update['freeslots'],
                    'gotgift' => 'yes'
                ));
                $mc1->commit_transaction($INSTALLER09['expires']['curuser']);
                header('Refresh: 5; url=' . $INSTALLER09['baseurl'] . '/index.php');
                stderr("Congratulations!", "<img src=\"{$INSTALLER09['pic_base_url']}gift.png\" style=\"float: left; padding-right:10px;\" alt=\"Xmas Gift\" title=\"Xmas Gift\" /> <h2> You just got 2 invites and 2000 bonus points and a bonus 3 freeslots !</h2>
Thanks for your support and sharing through year " . date('Y') . " ! <br /> Merry Christmas and a happy New Year from {$INSTALLER09['site_name']} Crew ! Redirecting in 5..4..3..2..1");
            }
            if ($gift == "bonus2") {
                sql_query("UPDATE users SET invites=invites+3, uploaded=uploaded+1024*1024*1024*20, seedbonus = seedbonus + 2500, freeslots=freeslots+5, gotgift='yes' WHERE id=" . sqlesc($userid)) or sqlerr(__FILE__, __LINE__);
                $update['invites'] = ($User['invites'] + 3);
                $update['seedbonus'] = ($User['seedbonus'] + 2500);
                $update['freeslots'] = ($User['freeslots'] + 5);
                $update['uploaded'] = ($User['uploaded'] + 1024 * 1024 * 1024 * 20);
                $mc1->begin_transaction('userstats_' . $userid);
                $mc1->update_row(false, array(
                    'seedbonus' => $update['seedbonus'],
                    'uploaded' => $update['uploaded']
                ));
                $mc1->commit_transaction($INSTALLER09['expires']['u_stats']);
                $mc1->begin_transaction('user_stats_' . $userid);
                $mc1->update_row(false, array(
                    'seedbonus' => $update['seedbonus'],
                    'uploaded' => $update['uploaded']
                ));
                $mc1->commit_transaction($INSTALLER09['expires']['user_stats']);
                $mc1->begin_transaction('user' . $userid);
                $mc1->update_row(false, array(
                    'invites' => $update['invites'],
                    'freeslots' => $update['freeslots'],
                    'gotgift' => 'yes'
                ));
                $mc1->commit_transaction($INSTALLER09['expires']['user_cache']);
                $mc1->begin_transaction('MyUser_' . $userid);
                $mc1->update_row(false, array(
                    'invites' => $update['invites'],
                    'freeslots' => $update['freeslots'],
                    'gotgift' => 'yes'
                ));
                $mc1->commit_transaction($INSTALLER09['expires']['curuser']);
                header('Refresh: 5; url=' . $INSTALLER09['baseurl'] . '/index.php');
                stderr("Congratulations!", "<img src=\"{$INSTALLER09['pic_base_url']}gift.png\" style=\"float: left; padding-right:10px;\" alt=\"Xmas Gift\" title=\"Xmas Gift\" /> <h2> You just got 3 invites 1750 karma bonus points !</h2>
Thanks for your support and sharing through year " . date('Y') . " ! <br /> Merry Christmas and a happy New Year from {$INSTALLER09['site_name']} Crew ! Redirecting in 5..4..3..2..1");
            }
        } else {
            stderr("Sorry...", "You already got your gift !");
        }
    } else {
        stderr("Doh...", "Be patient!  You can't open your present until Christmas day ! <b>" . date("z", ($xmasday - $today)) . "</b> day(s) to go. <br /> Today : <b><span style='color:red'>" . date('l dS \of F Y h:i:s A', $today) . "</span></b><br />Christmas day : <b><span style='color:green'>" . date('l dS \of F Y h:i:s A', $xmasday) . "</span></b>");
    }
}
?>
