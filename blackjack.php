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
$lang = array_merge(load_language('global'), load_language('blackjack'));
$HTMLOUT = '';
if ($CURUSER["game_access"] == 0 || $CURUSER["game_access"] > 1 || $CURUSER['suspended'] == 'yes') {
    stderr($lang['bj_error'], $lang['bj_gaming_rights_disabled']);
    exit();
}
if ($CURUSER['class'] < UC_POWER_USER)
    stderr($lang['bj_sorry'], $lang['bj_you_must_be_pu']);
$mb = 1024 * 1024 * 1024;
$now = TIME_NOW;
$game = isset($_POST["game"]) ? htmlsafechars($_POST["game"]) : '';
$start_ = isset($_POST["start_"]) ? htmlsafechars($_POST["start_"]) : '';
if ($game) {
    function cheater_check($arg)
    {
        if ($arg) {
            header('Location: ' . $_SERVER['PHP_SELF']);
            exit;
        }
    }
    $cardcount = 52;
    $points = $showcards = $aces = '';
    $sql = sql_query('SELECT uploaded, downloaded, bjwins, bjlosses ' . 'FROM users ' . 'WHERE id = ' . sqlesc($CURUSER['id'])) or sqlerr(__FILE__, __LINE__);
    $User = mysqli_fetch_assoc($sql);
    $User['uploaded'] = $User['uploaded'];
    $User['downloaded'] = $User['downloaded'];
    $User['bjwins'] = (int) $User['bjwins'];
    $User['bjlosses'] = (int) $User['bjlosses'];
    if ($start_ != 'yes') {
        $playeres = sql_query("SELECT * FROM blackjack WHERE userid = " . sqlesc($CURUSER['id']));
        $playerarr = mysqli_fetch_assoc($playeres);
        if ($game == 'hit')
            $points = $aces = 0;
        $gameover = ($playerarr['gameover'] == 'yes' ? true : false);
        cheater_check($gameover && ($game == 'hit' ^ $game == 'stop'));
        $cards = $playerarr["cards"];
        $usedcards = explode(" ", $cards);
        $arr = array();
        foreach ($usedcards as $array_list)
            $arr[] = $array_list;
        foreach ($arr as $card_id) {
            $used_card = sql_query("SELECT * FROM cards WHERE id=" . sqlesc($card_id));
            $used_cards = mysqli_fetch_assoc($used_card);
            $showcards .= "<img src='{$INSTALLER09['pic_base_url']}cards/" . htmlsafechars($used_cards["pic"]) . "' width='71' height='96' border='0' alt='{$lang['bj_cards']}' title='{$lang['bj_cards']}' />";
            if ($used_cards["points"] > 1)
                $points += $used_cards['points'];
            else
                $aces++;
        }
    }
    if ($_POST["game"] == 'hit') {
        if ($start_ == 'yes') {
            if ($CURUSER["uploaded"] < $mb)
                stderr("{$lang['bj_sorry2']} " . $CURUSER["username"], "{$lang['bj_you_have_not_uploaded']} " . mksize($mb) . " yet.");
            $required_ratio = 0.3;
            if ($CURUSER["downloaded"] > 0)
                $ratio = number_format($CURUSER["uploaded"] / $CURUSER["downloaded"], 3);
            elseif ($CURUSER["uploaded"] > 0)
                $ratio = 999;
            else
                $ratio = 0;
            if ($INSTALLER09['ratio_free'] === false && $ratio < $required_ratio)
                stderr("{$lang['bj_sorry2']} " . $CURUSER["username"], "{$lang['bj_your_ratio_is_lower_req']} " . $required_ratio . "%.");
            $res = sql_query("SELECT status, gameover FROM blackjack WHERE userid = " . sqlesc($CURUSER['id']));
            $arr = mysqli_fetch_assoc($res);
            if ($arr['status'] == 'waiting')
                stderr($lang['bj_sorry'], $lang['bj_you_will_have_to_wait_til_complete']);
            elseif ($arr['status'] == 'playing')
                stderr($lang['bj_sorry'], "{$lang['bj_you_most_finish_current']}<div class='col-sm-4 col-sm-offset-4'><form method='post' action='" . $_SERVER['PHP_SELF'] . "'><input type='hidden' name='game' value='hit' readonly='readonly' /><input type='hidden' name='continue' value='yes' readonly='readonly' /><input class='form-control btn btn-default' type='submit' value='{$lang['bj_continue_old_game']}' /></form></div>");
            cheater_check($arr['gameover'] == 'yes');
            $cardids = array();
            for ($i = 0; $i <= 1; $i++)
                $cardids[] = mt_rand(1, $cardcount);
            foreach ($cardids as $cardid) {
                while (in_array($cardid, $cardids))
                    $cardid = mt_rand(1, $cardcount);
                $cardres = sql_query("SELECT points, pic FROM cards WHERE id='$cardid'");
                $cardarr = mysqli_fetch_assoc($cardres);
                if ($cardarr["points"] > 1)
                    $points += $cardarr["points"];
                else
                    $aces++;
                $showcards .= "<img src='{$INSTALLER09['pic_base_url']}cards/" . htmlsafechars($cardarr['pic']) . "' width='71' height='96' border='0' alt='{$lang['bj_cards']}' title='{$lang['bj_cards']}' />";
                $cardids2[] = $cardid;
            }
            for ($i = 0; $i < $aces; $i++)
                $points += ($points < 11 && $aces - $i == 1 ? 11 : 1);
            sql_query("INSERT INTO blackjack (userid, points, cards, date) VALUES(" . sqlesc($CURUSER['id']) . ", '$points', '" . join(" ", $cardids2) . "', $now)");
            if ($points < 21) {
                $HTMLOUT .= "<h1>{$lang['bj_welcome']}, {$CURUSER['username']}!</h1>
                <div class='row'><div class='col-sm-6 col-sm-offset-3'><table class='table'>
                <tr><td colspan='2'>
                <table class='message table'>
                <tr><td align='center'>" . trim($showcards) . "</td></tr>
                <tr><td align='center'><b>{$lang['bj_points']} = {$points}</b></td></tr>
                <tr><td align='center'>
                <div class='col-sm-4 col-sm-offset-4'><form class='form-horizontal' method='post' action='" . $_SERVER['PHP_SELF'] . "'><input type='hidden' name='game' value='hit' readonly='readonly' /><input class='form-control btn btn-default' type='submit' value='Hitme' /></form></div>
                </td></tr>";
                if ($points >= 10) {
                    $HTMLOUT .= "<tr><td align='center'>
                <div class='col-sm-4 col-sm-offset-4'><form class='form-horizontal' method='post' action='" . $_SERVER['PHP_SELF'] . "'><input type='hidden' name='game' value='stop' readonly='readonly' /><input class='form-control btn btn-default' type='submit' value='{$lang['bj_stay']}' /></form></div>
                </td></tr>";
                }
                $HTMLOUT .= "</table></td></tr></table></div></div>";
                echo stdhead($lang['bj_title']) . $HTMLOUT . stdfoot();
                die();
            }
        } elseif (($start_ != 'yes' && isset($_POST['continue']) != 'yes') && !$gameover) {
            cheater_check(empty($playerarr));
            $cardid = mt_rand(1, $cardcount);
            while (in_array($cardid, $arr))
                $cardid = mt_rand(1, $cardcount);
            $cardres = sql_query("SELECT points, pic FROM cards WHERE id='$cardid'");
            $cardarr = mysqli_fetch_assoc($cardres);
            $showcards .= "<img src='{$INSTALLER09['pic_base_url']}cards/" . $cardarr['pic'] . "' width='71' height='96' border='0' alt='{$lang['bj_cards']}' title='{$lang['bj_cards']}' />";
            if ($cardarr["points"] > 1)
                $points += $cardarr["points"];
            else
                $aces++;
            for ($i = 0; $i < $aces; $i++)
                $points += ($points < 11 && $aces - $i == 1 ? 11 : 1);
            sql_query("UPDATE blackjack SET points='$points', cards='" . $cards . " " . $cardid . "' WHERE userid=" . sqlesc($CURUSER['id']));
        }
        if ($points == 21 || $points > 21) {
            $waitres = sql_query("SELECT COUNT(userid) AS c FROM blackjack WHERE status = 'waiting' AND userid != " . sqlesc($CURUSER['id']));
            $waitarr = mysqli_fetch_assoc($waitres);
            $HTMLOUT .= "<h1>{$lang['bj_game_over']}</h1>
<div class='row'><div class='col-sm-6 col-sm-offset-3'>
            <table class='table'>
            <tr><td colspan='2'>
            <table class='table'>
            <tr><td align='center'>" . trim($showcards) . "</td></tr>
            <tr><td align='center'><b>{$lang['bj_points']} = {$points}</b></td></tr>";
        }
        if ($points == 21) {
            if ($waitarr['c'] > 0) {
                $r = sql_query("SELECT bj.*, u.username FROM blackjack AS bj LEFT JOIN users AS u ON u.id=bj.userid WHERE bj.status='waiting' AND bj.userid != " . sqlesc($CURUSER['id']) . " ORDER BY bj.date ASC LIMIT 1");
                $a = mysqli_fetch_assoc($r);
                if ($a["points"] != 21) {
                    $winorlose = "{$lang['bj_you_won']} " . mksize($mb);
                    sql_query("UPDATE users SET uploaded = uploaded + $mb, bjwins = bjwins + 1 WHERE id=" . sqlesc($CURUSER['id']));
                    sql_query("UPDATE users SET uploaded = uploaded - $mb, bjlosses = bjlosses + 1 WHERE id=" . sqlesc($a['userid']));
                    $update['uploaded'] = ($User['uploaded'] + $mb);
                    $update['uploaded_loser'] = ($a['uploaded'] - $mb);
                    $update['bjwins'] = ($User['bjwins'] + 1);
                    $update['bjlosses'] = ($a['bjlosses'] + 1);
                    //==stats
                    $mc1->begin_transaction('userstats_' . $CURUSER['id']);
                    $mc1->update_row(false, array(
                        'uploaded' => $update['uploaded']
                    ));
                    $mc1->commit_transaction($INSTALLER09['expires']['u_stats']);
                    $mc1->begin_transaction('user_stats_' . $CURUSER['id']);
                    $mc1->update_row(false, array(
                        'uploaded' => $update['uploaded']
                    ));
                    $mc1->commit_transaction($INSTALLER09['expires']['user_stats']);
                    $mc1->begin_transaction('userstats_' . $a['userid']);
                    $mc1->update_row(false, array(
                        'uploaded' => $update['uploaded_loser']
                    ));
                    $mc1->commit_transaction($INSTALLER09['expires']['u_stats']);
                    $mc1->begin_transaction('user_stats_' . $a['userid']);
                    $mc1->update_row(false, array(
                        'uploaded' => $update['uploaded_loser']
                    ));
                    $mc1->commit_transaction($INSTALLER09['expires']['user_stats']);
                    //== curuser values
                    $mc1->begin_transaction('MyUser' . $CURUSER['id']);
                    $mc1->update_row(false, array(
                        'bjwins' => $update['bjwins']
                    ));
                    $mc1->commit_transaction($INSTALLER09['expires']['curuser']);
                    $mc1->begin_transaction('user' . $CURUSER['id']);
                    $mc1->update_row(false, array(
                        'bjwins' => $update['bjwins']
                    ));
                    $mc1->commit_transaction($INSTALLER09['expires']['user_cache']);
                    $mc1->begin_transaction('MyUser' . $a['userid']);
                    $mc1->update_row(false, array(
                        'bjlosses' => $update['bjlosses']
                    ));
                    $mc1->commit_transaction($INSTALLER09['expires']['curuser']);
                    $mc1->begin_transaction('user' . $a['userid']);
                    $mc1->update_row(false, array(
                        'bjlosses' => $update['bjlosses']
                    ));
                    $mc1->commit_transaction($INSTALLER09['expires']['user_cache']);
                    $msg = sqlesc("{$lang['bj_you_loss_to']} " . $CURUSER['username'] . " ({$lang['bj_you_had']} " . $a['points'] . " {$lang['bj_points2']}, " . $CURUSER['username'] . " {$lang['bj_had_21_points']}).\n\n");
                } else {
                    $subject = sqlesc($lang['bj_blackjack_results']);
                    $winorlose = $lang['bj_nobody_won'];
                    $msg = sqlesc("{$lang['bj_you_tied_with']} " . $CURUSER['username'] . " ({$lang['bj_you_both_had']} " . $a['points'] . " points).\n\n");
                }
                sql_query("INSERT INTO messages (sender, receiver, added, msg, subject) VALUES(0, " . sqlesc($a['userid']) . ", $now, $msg, $subject)");
                $mc1->delete_value('inbox_new_' . $a['userid']);
                $mc1->delete_value('inbox_new_sb_' . $a['userid']);
                sql_query("DELETE FROM blackjack WHERE userid IN (" . sqlesc($CURUSER['id']) . ", " . sqlesc($a['userid']) . ")");
                $HTMLOUT .= "<tr><td align='center'>{$lang['bj_your_opp_was']} " . htmlsafechars($a["username"]) . ", {$lang['bj_he_she_had']} " . htmlsafechars($a['points']) . " {$lang['bj_points2']}, $winorlose.<br /><br /><b><a href='/blackjack.php'>{$lang['bj_play_again']}</a></b></td></tr>";
            } else {
                sql_query("UPDATE blackjack SET status = 'waiting', date=" . $now . ", gameover = 'yes' WHERE userid = " . sqlesc($CURUSER['id']));
                $HTMLOUT .= "<tr><td align='center'>{$lang['bj_there_are_no_other_players']}<br /><br /><b><a href='/blackjack.php'>{$lang['bj_back']}</a></b><br /></td></tr>";
            }
            $HTMLOUT .= "</table></td></tr></table></div></div><br />";
            echo stdhead($lang['bj_title']) . $HTMLOUT . stdfoot();
        } elseif ($points > 21) {
            if ($waitarr['c'] > 0) {
                $r = sql_query("SELECT bj.*, u.username, u.uploaded, u.downloaded, u.bjwins, u.bjlosses FROM blackjack AS bj LEFT JOIN users AS u ON u.id=bj.userid WHERE bj.status='waiting' AND bj.userid != " . sqlesc($CURUSER['id']) . " ORDER BY bj.date ASC LIMIT 1");
                $a = mysqli_fetch_assoc($r);
                if ($a["points"] > 21) {
                    $subject = sqlesc($lang['bj_blackjack_results']);
                    $winorlose = $lang['bj_nobody_won'];
                    $msg = sqlesc("{$lang['bj_your_opp_was']} " . $CURUSER['username'] . ", nobody won.\n\n");
                } else {
                    $subject = sqlesc($lang['bj_blackjack_results']);
                    $winorlose = "{$lang['bj_you_lost']} " . mksize($mb);
                    sql_query("UPDATE users SET uploaded = uploaded + $mb, bjwins = bjwins + 1 WHERE id=" . sqlesc($a['userid']));
                    sql_query("UPDATE users SET uploaded = uploaded - $mb, bjlosses = bjlosses + 1 WHERE id=" . sqlesc($CURUSER['id']));
                    $update['uploaded'] = ($a['uploaded'] + $mb);
                    $update['uploaded_loser'] = ($User['uploaded'] - $mb);
                    $update['bjwins'] = ($a['bjwins'] + 1);
                    $update['bjlosses'] = ($User['bjlosses'] + 1);
                    //==stats
                    $mc1->begin_transaction('userstats_' . $a['userid']);
                    $mc1->update_row(false, array(
                        'uploaded' => $update['uploaded']
                    ));
                    $mc1->commit_transaction($INSTALLER09['expires']['u_stats']);
                    $mc1->begin_transaction('user_stats_' . $a['userid']);
                    $mc1->update_row(false, array(
                        'uploaded' => $update['uploaded']
                    ));
                    $mc1->commit_transaction($INSTALLER09['expires']['user_stats']);
                    $mc1->begin_transaction('userstats_' . $CURUSER['id']);
                    $mc1->update_row(false, array(
                        'uploaded' => $update['uploaded_loser']
                    ));
                    $mc1->commit_transaction($INSTALLER09['expires']['u_stats']);
                    $mc1->begin_transaction('user_stats_' . $CURUSER['id']);
                    $mc1->update_row(false, array(
                        'uploaded' => $update['uploaded_loser']
                    ));
                    $mc1->commit_transaction($INSTALLER09['expires']['user_stats']);
                    //== curuser values
                    $mc1->begin_transaction('MyUser' . $a['userid']);
                    $mc1->update_row(false, array(
                        'bjwins' => $update['bjwins']
                    ));
                    $mc1->commit_transaction($INSTALLER09['expires']['curuser']);
                    $mc1->begin_transaction('user' . $a['userid']);
                    $mc1->update_row(false, array(
                        'bjwins' => $update['bjwins']
                    ));
                    $mc1->commit_transaction($INSTALLER09['expires']['user_cache']);
                    $mc1->begin_transaction('MyUser' . $CURUSER['id']);
                    $mc1->update_row(false, array(
                        'bjlosses' => $update['bjlosses']
                    ));
                    $mc1->commit_transaction($INSTALLER09['expires']['curuser']);
                    $mc1->begin_transaction('user' . $CURUSER['id']);
                    $mc1->update_row(false, array(
                        'bjlosses' => $update['bjlosses']
                    ));
                    $mc1->commit_transaction($INSTALLER09['expires']['user_cache']);
                    $msg = sqlesc("{$lang['bj_you_beat']} " . $CURUSER['username'] . " ({$lang['bj_you_had']} " . $a['points'] . " {$lang['bj_points2']}, " . $CURUSER['username'] . " had $points points).\n\n");
                }
                sql_query("INSERT INTO messages (sender, receiver, added, msg, subject) VALUES(0, " . $a['userid'] . ", $now, $msg, $subject)");
                $mc1->delete_value('inbox_new_' . $a['userid']);
                $mc1->delete_value('inbox_new_sb_' . $a['userid']);
                sql_query("DELETE FROM blackjack WHERE userid IN (" . sqlesc($CURUSER['id']) . ", " . sqlesc($a['userid']) . ")");
                $HTMLOUT .= "<tr><td align='center'>{$lang['bj_your_opp_was']} " . htmlsafechars($a["username"]) . ", {$lang['bj_he_she_had']} " . htmlsafechars($a['points']) . " {$lang['bj_points2']}, $winorlose.<br /><br /><b><a href='blackjack.php'>{$lang['bj_play_again']}</a></b></td></tr>";
            } else {
                sql_query("UPDATE blackjack SET status = 'waiting', date=" . $now . ", gameover='yes' WHERE userid = " . sqlesc($CURUSER['id']));
                $HTMLOUT .= "<tr><td align='center'>{$lang['bj_there_are_no_other_players']}<br /><br /><b><a href='/blackjack.php'>{$lang['bj_back']}</a></b><br /></td></tr>";
            }
            $HTMLOUT .= "</table></td></tr></table></div></div><br />";
            echo stdhead($lang['bj_title']) . $HTMLOUT . stdfoot();
        } else {
            cheater_check(empty($playerarr));
            $HTMLOUT .= "<h1>{$lang['bj_welcome']}, {$CURUSER['username']}!</h1>
            <div class='row'><div class='col-sm-6 col-sm-offset-3'><table class=table'>
            <tr><td colspan='2'>
            <table class='message' width='100%' cellspacing='0' cellpadding='5' bgcolor='white'>
            <tr><td align='center'>{$showcards}</td></tr>
            <tr><td align='center'><b>{$lang['bj_points']} = {$points}</b></td></tr>";
            $HTMLOUT .= "<tr>
      <td align='center'>
<div class='col-sm-4 col-sm-offset-4'><form class='form-horizontal' method='post' action='" . $_SERVER['PHP_SELF'] . "'><input type='hidden' name='game' value='hit' readonly='readonly' /><input class='form-control' type='submit' value='{$lang['bj_hitme']}' /></form></div></td>
      </tr>";
            $HTMLOUT .= "<tr>
      <td align='center'>
<div class='col-sm-4 col-sm-offset-4'><form class='form-horizontal'  method='post' action='" . $_SERVER['PHP_SELF'] . "'><input type='hidden' name='game' value='stop' readonly='readonly' /><input class='form-control'  type='submit' value='{$lang['bj_stay']}' /></form></div></td>
      </tr>";
            $HTMLOUT .= "</table></td></tr></table></div></div><br />";
            echo stdhead($lang['bj_title']) . $HTMLOUT . stdfoot();
        }
    } elseif ($_POST["game"] == 'stop') {
        cheater_check(empty($playerarr));
        $waitres = sql_query("SELECT COUNT(userid) AS c FROM blackjack WHERE status='waiting' AND userid != " . sqlesc($CURUSER['id']));
        $waitarr = mysqli_fetch_assoc($waitres);
        $HTMLOUT .= "<h1>{$lang['bj_game_over']}</h1>
        <div class='row'><div class='col-sm-6 col-sm-offset-3'><table class='table'>
        <tr><td colspan='2'>
        <table class='message table'>
        <tr><td align='center'>{$showcards}</td></tr>
        <tr><td align='center'><b>{$lang['bj_points']} = " . htmlsafechars($playerarr['points']) . "</b></td></tr>";
        if ($waitarr['c'] > 0) {
            $r = sql_query("SELECT bj.*, u.username, u.uploaded, u.downloaded, u.bjwins, u.bjlosses FROM blackjack AS bj LEFT JOIN users AS u ON u.id=bj.userid WHERE bj.status='waiting' AND bj.userid != " . sqlesc($CURUSER['id']) . " ORDER BY bj.date ASC LIMIT 1");
            $a = mysqli_fetch_assoc($r);
            if ($a["points"] == $playerarr['points']) {
                $subject = sqlesc($lang['bj_blackjack_results']);
                $winorlose = $lang['bj_nobody_won'];
                $msg = sqlesc("{$lang['bj_your_opp_was']} " . $CURUSER['username'] . ", you both had " . htmlsafechars($a['points']) . " points - it was a tie.\n\n");
            } else {
                if (($a["points"] < $playerarr['points'] && $a['points'] < 21) || ($a["points"] > $playerarr['points'] && $a['points'] > 21)) {
                    $subject = sqlesc($lang['bj_blackjack_results']);
                    $msg = sqlesc("{$lang['bj_you_loss_to']} " . $CURUSER['username'] . " ({$lang['bj_you_had']} " . htmlsafechars($a['points']) . " {$lang['bj_points2']}, " . $CURUSER['username'] . " had " . htmlsafechars($playerarr['points']) . " points).\n\n");
                    $winorlose = "{$lang['bj_you_won']} " . mksize($mb);
                    $st_query = "+ " . $mb . ", bjwins = bjwins +";
                    $nd_query = "- " . $mb . ", bjlosses = bjlosses +";
                } elseif (($a["points"] > $playerarr['points'] && $a['points'] < 21) || $a["points"] == 21 || ($a["points"] < $playerarr['points'] && $a['points'] > 21)) {
                    $subject = sqlesc($lang['bj_blackjack_results']);
                    $msg = sqlesc("{$lang['bj_you_beat']} " . $CURUSER['username'] . " ({$lang['bj_you_had']} " . htmlsafechars($a['points']) . " {$lang['bj_points2']}, " . $CURUSER['username'] . " had " . htmlsafechars($playerarr['points']) . " points).\n\n");
                    $winorlose = "{$lang['bj_you_lost']} " . mksize($mb);
                    $st_query = "- " . $mb . ", bjlosses = bjlosses +";
                    $nd_query = "+ " . $mb . ", bjwins = bjwins +";
                }
                sql_query("UPDATE users SET uploaded = uploaded " . $st_query . " 1 WHERE id=" . sqlesc($CURUSER['id']));
                sql_query("UPDATE users SET uploaded = uploaded " . $nd_query . " 1 WHERE id=" . sqlesc($a['userid']));
                $update['uploaded'] = ($a['uploaded'] + $mb);
                $update['uploaded_loser'] = ($User['uploaded'] - $mb);
                $update['bjwins'] = ($a['bjwins'] + 1);
                $update['bjlosses'] = ($User['bjlosses'] + 1);
                //==stats
                $mc1->begin_transaction('userstats_' . $a['userid']);
                $mc1->update_row(false, array(
                    'uploaded' => $update['uploaded']
                ));
                $mc1->commit_transaction($INSTALLER09['expires']['u_stats']);
                $mc1->begin_transaction('user_stats_' . $a['userid']);
                $mc1->update_row(false, array(
                    'uploaded' => $update['uploaded']
                ));
                $mc1->commit_transaction($INSTALLER09['expires']['user_stats']);
                $mc1->begin_transaction('userstats_' . $CURUSER['id']);
                $mc1->update_row(false, array(
                    'uploaded' => $update['uploaded_loser']
                ));
                $mc1->commit_transaction($INSTALLER09['expires']['u_stats']);
                $mc1->begin_transaction('user_stats_' . $CURUSER['id']);
                $mc1->update_row(false, array(
                    'uploaded' => $update['uploaded_loser']
                ));
                $mc1->commit_transaction($INSTALLER09['expires']['user_stats']);
                //== curuser values
                $mc1->begin_transaction('MyUser' . $a['userid']);
                $mc1->update_row(false, array(
                    'bjwins' => $update['bjwins']
                ));
                $mc1->commit_transaction($INSTALLER09['expires']['curuser']);
                $mc1->begin_transaction('user' . $a['userid']);
                $mc1->update_row(false, array(
                    'bjwins' => $update['bjwins']
                ));
                $mc1->commit_transaction($INSTALLER09['expires']['user_cache']);
                $mc1->begin_transaction('MyUser' . $CURUSER['id']);
                $mc1->update_row(false, array(
                    'bjlosses' => $update['bjlosses']
                ));
                $mc1->commit_transaction($INSTALLER09['expires']['curuser']);
                $mc1->begin_transaction('user' . $CURUSER['id']);
                $mc1->update_row(false, array(
                    'bjlosses' => $update['bjlosses']
                ));
                $mc1->commit_transaction($INSTALLER09['expires']['user_cache']);
            }
            sql_query("INSERT INTO messages (sender, receiver, added, msg, subject) VALUES(0, " . $a['userid'] . ", $now, $msg, $subject)");
            $mc1->delete_value('inbox_new_' . $a['userid']);
            $mc1->delete_value('inbox_new_sb_' . $a['userid']);
            sql_query("DELETE FROM blackjack WHERE userid IN (" . sqlesc($CURUSER['id']) . ", " . sqlesc($a['userid']) . ")");
            $HTMLOUT .= "<tr><td align='center'>{$lang['bj_your_opp_was']} " . htmlsafechars($a["username"]) . ", {$lang['bj_he_she_had']} " . htmlsafechars($a['points']) . " {$lang['bj_points2']}, $winorlose.<br /><br /><b><a href='/blackjack.php'>{$lang['bj_play_again']}</a></b></td></tr>";
        } else {
            sql_query("UPDATE blackjack SET status = 'waiting', date=" . $now . ", gameover='yes' WHERE userid = " . sqlesc($CURUSER['id']));
            $HTMLOUT .= "<tr><td align='center'>{$lang['bj_there_are_no_other_players']}<br /><br /><b><a href='/blackjack.php'>{$lang['bj_back']}</a></b><br /></td></tr>";
        }
        $HTMLOUT .= "</table></td></tr></table></div></div><br />";
        echo stdhead($lang['bj_title']) . $HTMLOUT . stdfoot();
    }
} else {
    $sql = sql_query('SELECT bjwins, bjlosses ' . 'FROM users ' . 'WHERE id = ' . sqlesc($CURUSER['id'])) or sqlerr(__FILE__, __LINE__);
    $User = mysqli_fetch_assoc($sql);
    $User['bjwins'] = (int) $User['bjwins'];
    $User['bjlosses'] = (int) $User['bjlosses'];
    $tot_wins = (int) $User['bjwins'];
    $tot_losses = (int) $User['bjlosses'];
    $tot_games = $tot_wins + $tot_losses;
    $win_perc = ($tot_losses == 0 ? ($tot_wins == 0 ? "---" : "100%") : ($tot_wins == 0 ? "0" : number_format(($tot_wins / $tot_games) * 100, 1)) . '%');
    $plus_minus = ($tot_wins - $tot_losses < 0 ? '-' : '') . mksize((($tot_wins - $tot_losses >= 0 ? ($tot_wins - $tot_losses) : ($tot_losses - $tot_wins))) * $mb);
    $HTMLOUT .= "<h1 align='center'>{$INSTALLER09['site_name']} {$lang['bj_title']}</h1>
    <div class='row'><div class='col-sm-6 col-sm-offset-3'><table class='table'>
    <tr><td colspan='2' align='center'>
    <table class='message table'>
    <tr><td align='center'><img src='{$INSTALLER09['pic_base_url']}cards/tp.bmp' width='71' height='96' border='0' alt='' />&nbsp;<img src='{$INSTALLER09['pic_base_url']}cards/vp.bmp' width='71' height='96' border='0' alt='' /></td></tr>
    <tr><td align='left'>{$lang['bj_you_most_collect_21']}<br /><br />
    <b>{$lang['bj_note']}</b> " . $lang['bj_bj_note_cost'] . mksize($mb) . $lang['bj_bj_note_cost2'] . "</td></tr>
    <tr><td align='center'>
    <div class='col-sm-2 col-sm-offset-5'><form class='form-horizontal' method='post' action='" . $_SERVER['PHP_SELF'] . "'><input type='hidden' name='game' value='hit' readonly='readonly' /><input type='hidden' name='start_' value='yes' readonly='readonly' /><input class='form-control btn btn-default input-small'type='submit' value='Start!' /></form></div>
    </td></tr></table>
    </td></tr></table></div></div>
    <br /><br /><br />
  <div class='row'><div class='col-sm-6 col-sm-offset-3'><table class='table'>
    <tr><td colspan='2' align='center'>
    <h1>{$lang['bj_personal_stats']}</h1></td></tr>
    <tr><td align='left'><b>{$lang['bj_wins']}</b></td><td align='center'><b>" . htmlsafechars($tot_wins) . "</b></td></tr>
    <tr><td align='left'><b>{$lang['bj_losses']}</b></td><td align='center'><b>" . htmlsafechars($tot_losses) . "</b></td></tr>
    <tr><td align='left'><b>{$lang['bj_games_played']}</b></td><td align='center'><b>" . htmlsafechars($tot_games) . "</b></td></tr>
    <tr><td align='left'><b>{$lang['bj_win']} {$lang['bj_percentage']}</b></td><td align='center'><b>" . htmlsafechars($win_perc) . "</b></td></tr>
    <tr><td align='left'><b>+/-</b></td><td align='center'><b>" . htmlsafechars($plus_minus) . "</b></td></tr>
    </table></div></div>";
    echo stdhead($lang['bj_title']) . $HTMLOUT . stdfoot();
}
?>
