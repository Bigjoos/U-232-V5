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
 */
//made by putyn @ tbade.net Monday morning :]
require_once(__DIR__ . DIRECTORY_SEPARATOR . 'include' . DIRECTORY_SEPARATOR . 'bittorrent.php');
require_once(INCL_DIR . 'user_functions.php');
dbconn();
$lang = array_merge(load_language('global'));
$id = isset($_GET["id"]) ? 0 + $_GET["id"] : 0;
$rate = isset($_GET["rate"]) ? 0 + $_GET["rate"] : 0;
$uid = $CURUSER["id"];
$ajax = isset($_GET["ajax"]) && $_GET["ajax"] == 1 ? true : false;
$what = isset($_GET["what"]) && $_GET["what"] == "torrent" ? "torrent" : "topic";
$ref = isset($_GET["ref"]) ? $_GET["ref"] : ($what == "torrent" ? "details.php" : "forums/view.php");
    $completeres = sql_query("SELECT * FROM " . (XBT_TRACKER == true ? "xbt_files_users" : "snatched") . " WHERE " . (XBT_TRACKER == true ? "completedtime !=0" : "complete_date !=0") . " AND " . (XBT_TRACKER == true ? "uid" : "userid") . " = " . $CURUSER['id'] . " AND " . (XBT_TRACKER == true ? "fid" : "torrentid") . " = " . $id);
    $completecount = mysqli_num_rows($completeres);
    if ($what == 'torrent' && $completecount == 0) {
        stderr("Failed", "You must have downloaded this torrent in order to rate it. ");
    }
if ($id > 0 && $rate >= 1 && $rate <= 5) {
    if (sql_query("INSERT INTO rating(" . $what . ",rating,user) VALUES (" . sqlesc($id) . "," . sqlesc($rate) . "," . sqlesc($uid) . ")")) {
        $table = ($what == "torrent" ? "torrents" : "topics");
        sql_query("UPDATE " . $table . " SET num_ratings = num_ratings + 1, rating_sum = rating_sum+" . sqlesc($rate) . " WHERE id = " . sqlesc($id));
        $mc1->delete_value('rating_' . $what . '_' . $id . '_' . $CURUSER['id']);
        if ($what == "torrent") {
            $f_r = sql_query("SELECT num_ratings, rating_sum FROM torrents WHERE id = " . sqlesc($id)) or sqlerr(__FILE__, __LINE__);
            $r_f = mysqli_fetch_assoc($f_r);
            $update['num_ratings'] = ($r_f['num_ratings'] + 1);
            $update['rating_sum'] = ($r_f['rating_sum'] + $rate);
            $mc1->begin_transaction('torrent_details_' . $id);
            $mc1->update_row(false, [
                'num_ratings' => $update['num_ratings'],
                'rating_sum' => $update['rating_sum']
            ]);
            $mc1->commit_transaction($INSTALLER09['expires']['torrent_details']);
        }
        if ($INSTALLER09['seedbonus_on'] == 1) {
            //===add karma
            $amount = ($what == 'torrent' ? $INSTALLER09['bonus_per_rating'] : $INSTALLER09['bonus_per_topic']);
            sql_query("UPDATE users SET seedbonus = seedbonus+" . sqlesc($amount) . " WHERE id = " . sqlesc($CURUSER['id'])) or sqlerr(__FILE__, __LINE__);
            $update['seedbonus'] = ($CURUSER['seedbonus'] + $amount);
            $mc1->begin_transaction('userstats_' . $CURUSER["id"]);
            $mc1->update_row(false, [
                'seedbonus' => $update['seedbonus']
            ]);
            $mc1->commit_transaction($INSTALLER09['expires']['u_stats']);
            $mc1->begin_transaction('user_stats_' . $CURUSER["id"]);
            $mc1->update_row(false, [
                'seedbonus' => $update['seedbonus']
            ]);
            $mc1->commit_transaction($INSTALLER09['expires']['user_stats']);
            //===end
        }
        if ($ajax) {
            $qy = sql_query("SELECT sum(r.rating) as sum, count(r.rating) as count, r2.rating as rate FROM rating as r LEFT JOIN rating AS r2 ON (r2." . $what . " = " . sqlesc($id) . " AND r2.user = " . sqlesc($uid) . ") WHERE r." . $what . " = " . sqlesc($id) . " GROUP BY r." . sqlesc($what)) or sqlerr(__FILE__, __LINE__);
            $a = mysqli_fetch_assoc($qy);
            echo "<ul class=\"star-rating\" title=\"Your rated this " . $what . " " . htmlsafechars($a["rate"]) . " star" . (htmlsafechars($a["rate"]) > 1 ? "s" : "") . "\"  ><li style=\"width: " . (round((($a["sum"] / $a["count"]) * 20), 2)) . "%;\" class=\"current-rating\" />.</ul>";
        } else {
            header("Refresh: 2; url=" . $ref);
            stderr("Success", "Your rate has been added, wait while redirecting! ");
        }
    } else {
        if (((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_errno($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_errno()) ? $___mysqli_res : false)) == 1062 && $ajax) {
            echo "You already rated this " . $what . "";
        } elseif (((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)) && $ajax) {
            print("You cant rate twice, Err - " . ((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
        } else {
            stderr("Err", "You cant rate twice, Err - " . ((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
        }
    }
}
