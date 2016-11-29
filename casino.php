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
require_once INCL_DIR . 'html_functions.php';
require_once INCL_DIR . 'function_ircbot.php';
//== Updated casino.php by Bigjoos
dbconn(false);
loggedinorreturn();
$lang = array_merge(load_language('global'), load_language('casino'));
//== Config
$amnt = $nobits = $abcdefgh = 0;
$dummy = '';
$player = UC_USER;
$mb_basic = 1024 * 1024;
$max_download_user = $mb_basic * 1024 * 1024; //= 255 Gb
$max_download_global = $mb_basic * $mb_basic * 1; //== 10.0 Tb
$required_ratio = 0.5; //== Min ratio
$user_everytimewin_mb = $mb_basic * 20; //== Means users that wins under 70 mb get a cheat_value of 0 -> win every time
$cheat_value = 8; //== Higher value -> less winner
$cheat_breakpoint = 10; //== Very important value -> if (win MB > max_download_global/cheat_breakpoint)
$cheat_value_max = 2; //== Then cheat_value = cheat_value_max -->> i hope you know what i mean. ps: must be higher as cheat_value.
$cheat_ratio_user = .4; //== If casino_ratio_user > cheat_ratio_user -> $cheat_value = rand($cheat_value,$cheat_value_max)
$cheat_ratio_global = .4; //== Same as user just global
$win_amount = 3; //== How much do the player win in the first game eg. bet 300, win_amount=3 ---->>> 300*3= 900 win
$win_amount_on_number = 6; //== Same as win_amount for the number game
$show_real_chance = false; //== Shows the user the real chance true or false
$bet_value1 = 1024 * 1024 * 200; //== This is in MB but you can also choose gb or tb
$bet_value2 = 1024 * 1024 * 500;
$bet_value3 = 1024 * 1024 * 1020;
$bet_value4 = 1024 * 1024 * 2560;
$bet_value5 = 1024 * 1024 * 5120;
$bet_value6 = 1024 * 1024 * 10240;
$bet_value7 = 1024 * 1024 * 20480;
$minclass = $player; //== Lowest class allowed to play
$maxusrbet = 4; //==Amount of bets to allow per person
$maxtotbet = 30; //== Amount of total open bets allowed
$alwdebt = 0; //== Allow users to get into debt
$writelog = 1; //== Writes results to log
$delold = 1; //== Clear bets once finished
$sendfrom = 2; //== The id of the user which notification PM's are noted as sent from
$casino = 'casino.php'; //== Name of file
//== End of Config
if ($CURUSER["game_access"] == 0 || $CURUSER["game_access"] > 1 || $CURUSER['suspended'] == 'yes') {
    stderr($lang['gl_error'], $lang['casino_your_gaming_rights_have_been_disabled']);
    exit();
}
$sql = sql_query('SELECT uploaded, downloaded ' . 'FROM users ' . 'WHERE id = ' . sqlesc($CURUSER['id'])) or sqlerr(__FILE__, __LINE__);
$User = mysqli_fetch_assoc($sql);
$User['uploaded'] = $User['uploaded'];
$User['downloaded'] = $User['downloaded'];
//== Reset user gamble stats!
$hours = 2; //== Hours to wait after using all tries, until they will be restarted
$dt = TIME_NOW - $hours * 3600;
$res = sql_query("SELECT userid, trys, date, enableplay FROM casino WHERE date < $dt AND trys >= '51' AND enableplay = 'yes'");
while ($arr = mysqli_fetch_assoc($res)) {
    sql_query("UPDATE casino SET trys='0' WHERE userid=" . sqlesc($arr['userid'])) or sqlerr(__FILE__, __LINE__);
}
if ($CURUSER['class'] < $player)
    stderr($lang['gl_sorry'], "" . htmlsafechars($CURUSER["username"]) . " {$lang['casino_the_moderators_do_not_allow_your_class']} " . get_user_class_name($player) . " {$lang['casino_to_play_casino']}");
$query = "SELECT * from casino where userid = " . sqlesc($CURUSER['id']) . "";
$result = sql_query($query) or sqlerr(__FILE__, __LINE__);
if (mysqli_affected_rows($GLOBALS["___mysqli_ston"]) != 1) {
    sql_query("INSERT INTO casino (userid, win, lost, trys, date, started) VALUES(" . sqlesc($CURUSER["id"]) . ", 0, 0, 0," . TIME_NOW . ",1)") or ((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false));
    $result = sql_query($query) or sqlerr(__FILE__, __LINE__);
}
$row = mysqli_fetch_assoc($result);
$user_win = $row["win"];
$user_lost = $row["lost"];
$user_trys = (int) $row["trys"];
$user_date = (int) $row["date"];
$user_deposit = $row["deposit"];
$user_enableplay = htmlsafechars($row["enableplay"]);
if ($user_enableplay == "no")
    stderr($lang['gl_sorry'], "" . htmlsafechars($CURUSER["username"]) . " {$lang['casino_your_banned_from_casino']}");
if (($user_win - $user_lost) > $max_download_user)
    stderr($lang['gl_sorry'], "" . htmlsafechars($CURUSER["username"]) . " {$lang['casino_you_have_reached_the_max_dl_for_a_single_user']}");
if ($CURUSER["downloaded"] > 0)
    $ratio = number_format($CURUSER["uploaded"] / $CURUSER["downloaded"], 2);
else if ($CURUSER["uploaded"] > 0)
    $ratio = 999;
else
    $ratio = 0;
if ($INSTALLER09['ratio_free'] === false && $ratio < $required_ratio)
    stderr($lang['gl_sorry'], "" . htmlsafechars($CURUSER["username"]) . " {$lang['casino_your_ratio_is_under']} {$required_ratio}");
$global_down2 = sql_query("SELECT (sum(win)-sum(lost)) AS globaldown,(sum(deposit)) AS globaldeposit, sum(win) AS win, sum(lost) AS lost FROM casino") or sqlerr(__FILE__, __LINE__);
$row = mysqli_fetch_assoc($global_down2);
$global_down = $row["globaldown"];
$global_win = $row["win"];
$global_lost = $row["lost"];
$global_deposit = $row["globaldeposit"];
if ($user_win > 0)
    $casino_ratio_user = number_format($user_lost / $user_win, 2);
else if ($user_lost > 0)
    $casino_ratio_user = 999;
else
    $casino_ratio_user = 0.00;
if ($global_win > 0)
    $casino_ratio_global = number_format($global_lost / $global_win, 2);
else if ($global_lost > 0)
    $casino_ratio_global = 999;
else
    $casino_ratio_global = 0.00;
if ($user_win < $user_everytimewin_mb)
    $cheat_value = 8;
else {
    if ($global_down > ($max_download_global / $cheat_breakpoint))
        $cheat_value = $cheat_value_max;
    if ($casino_ratio_global < $cheat_ratio_global)
        $cheat_value = rand($cheat_value, $cheat_value_max);
    if (($user_win - $user_lost) > ($max_download_user / $cheat_breakpoint))
        $cheat_value = $cheat_value_max;
    if ($casino_ratio_user < $cheat_ratio_user)
        $cheat_value = rand($cheat_value, $cheat_value_max);
}
if ($global_down > $max_download_global)
    stderr($lang['gl_sorry'], "" . htmlsafechars($CURUSER["username"]) . " {$lang['casino_but_global_max_win_is_above']} " . htmlsafechars(mksize($max_download_global)));
//== Updated post color/number by pdq
$goback = "<a href='$casino'>{$lang['casino_go_back']}</a>";
$color_options = array(
    'red' => 1,
    'black' => 2
);
$number_options = array(
    1 => 1,
    2 => 1,
    3 => 1,
    4 => 1,
    5 => 1,
    6 => 1
);
$betmb_options = array(
    $bet_value1 => 1,
    $bet_value2 => 1,
    $bet_value3 => 1,
    $bet_value4 => 1,
    $bet_value5 => 1,
    $bet_value6 => 1,
    $bet_value7 => 1
);
$post_color = (isset($_POST['color']) ? $_POST['color'] : '');
$post_number = (isset($_POST['number']) ? $_POST['number'] : '');
$post_betmb = (isset($_POST['betmb']) ? $_POST['betmb'] : '');
if (isset($color_options[$post_color]) && isset($number_options[$post_number]) || isset($betmb_options[$post_betmb])) {
    $betmb = $_POST["betmb"];
    if (isset($_POST["number"])) {
        $win_amount = $win_amount_on_number;
        $cheat_value = $cheat_value + 5;
        $winner_was = (int) $_POST["number"];
    } else
        $winner_was = htmlsafechars($_POST["color"]);
    $win = $win_amount * $betmb;
    if ($CURUSER["uploaded"] < $betmb)
        stderr($lang['gl_sorry'], "" . htmlsafechars($CURUSER["username"]) . " {$lang['casino_but_you_have_not_uploaded']} " . htmlsafechars(mksize($betmb)));
    if (rand(0, $cheat_value) == $cheat_value) {
        sql_query("UPDATE users SET uploaded = uploaded + " . sqlesc($win) . " WHERE id=" . sqlesc($CURUSER["id"])) or sqlerr(__FILE__, __LINE__);
        sql_query("UPDATE casino SET date = '" . TIME_NOW . "', trys = trys + 1, win = win + " . sqlesc($win) . "  WHERE userid=" . sqlesc($CURUSER["id"])) or sqlerr(__FILE__, __LINE__);
        $update['uploaded'] = ($User['uploaded'] + $win);
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
        stderr($lang['casino_yes'], "" . htmlsafechars($winner_was) . " {$lang['casino_is_the_result']} " . htmlsafechars($CURUSER["username"]) . " {$lang['casino_you_got_it_and_win']} " . htmlsafechars(mksize($win)) . "&nbsp;&nbsp;&nbsp;$goback");
    } else {
        if (isset($_POST["number"])) {
            do {
                $fake_winner = rand(1, 6);
            } while ($_POST["number"] == $fake_winner);
        } else {
            if ($_POST["color"] == "black")
                $fake_winner = "red";
            else
                $fake_winner = "black";
        }
        sql_query("UPDATE users SET uploaded = uploaded - " . sqlesc($betmb) . " WHERE id=" . sqlesc($CURUSER["id"])) or sqlerr(__FILE__, __LINE__);
        sql_query("UPDATE casino SET date = " . TIME_NOW . ", trys = trys + 1 ,lost = lost + " . sqlesc($betmb) . " WHERE userid=" . sqlesc($CURUSER["id"])) or sqlerr(__FILE__, __LINE__);
        $update['uploaded_loser'] = ($User['uploaded'] - $betmb);
        //==stats
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
        stderr($lang['gl_sorry'], "" . htmlsafechars($fake_winner) . " {$lang['casino_is_the_winner_and_not']} " . htmlsafechars($winner_was) . ", " . htmlsafechars($CURUSER["username"]) . " {$lang['casino_you_lost']} " . htmlsafechars(mksize($betmb)) . "&nbsp;&nbsp;&nbsp;$goback");
    }
} else {
    //== Get user stats
    $betsp = sql_query("SELECT challenged FROM casino_bets WHERE proposed =" . sqlesc($CURUSER['username']));
    $openbet = 0;
    while ($tbet2 = mysqli_fetch_assoc($betsp)) {
        if ($tbet2['challenged'] == 'empty')
            $openbet++;
    }
    //== Convert bet amount into bits
    if (isset($_POST['unit'])) {
        if (0 + $_POST["unit"] == 1)
            $nobits = $amnt * $mb_basic;
        else
            $nobits = $amnt * $mb_basic * 1024;
    }
    if ($CURUSER['uploaded'] == 0 || $CURUSER['downloaded'] == 0)
        $ratio = '0';
    else
        $ratio = number_format(($CURUSER['uploaded'] - $nobits) / $CURUSER['downloaded'], 2);
    $time = TIME_NOW;
    //== Take Bet
    if (isset($_GET["takebet"])) {
        $betid = 0 + $_GET["takebet"];
        $random = rand(0, 1);
        $loc = sql_query("SELECT * FROM casino_bets WHERE id = " . sqlesc($betid));
        $tbet = mysqli_fetch_assoc($loc);
        $nogb = mksize($tbet['amount']);
        if ($CURUSER['id'] == $tbet['userid'])
            stderr($lang['gl_sorry'], "{$lang['casino_you_want_to_bet_against_yourself_lol']} ?&nbsp;&nbsp;&nbsp;$goback");
        elseif ($tbet['challenged'] != "empty")
            stderr($lang['gl_sorry'], "{$lang['casino_someone_has_already_taken_that_bet']}!&nbsp;&nbsp;&nbsp;$goback");
        if ($CURUSER['uploaded'] < $tbet['amount']) {
            $debt = $tbet['amount'] - $CURUSER['uploaded'];
            $newup = $CURUSER['uploaded'] - $debt;
        }
        if (isset($debt) && $alwdebt != 1)
            stderr($lang['gl_sorry'], "<h2>{$lang['casino_you_are']} " . htmlsafechars(mksize($nobits-$CURUSER['uploaded'])) . " {$lang['casino_short_of_making_that_bet']} !</h2>&nbsp;&nbsp;&nbsp;$goback");
        if ($random == 1) {
            sql_query("UPDATE users SET uploaded = uploaded+" . sqlesc($tbet['amount']) . " WHERE id = " . sqlesc($CURUSER['id'])) or sqlerr(__FILE__, __LINE__);
            sql_query("UPDATE casino SET deposit = deposit-" . sqlesc($tbet['amount']) . " WHERE userid = " . sqlesc($tbet['userid'])) or sqlerr(__FILE__, __LINE__);
            $update['uploaded'] = ($User['uploaded'] + $tbet['amount']);
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
            if (mysqli_affected_rows($GLOBALS["___mysqli_ston"]) == 0)
                sql_query("INSERT INTO casino (userid, date, deposit) VALUES (" . sqlesc($tbet['userid']) . ", $time, -" . sqlesc($tbet['amount']) . ")") or sqlerr(__FILE__, __LINE__);
            sql_query("UPDATE casino_bets SET challenged = " . sqlesc($CURUSER['username']) . ", winner = " . sqlesc($CURUSER['username']) . " WHERE id =" . sqlesc($betid)) or sqlerr(__FILE__, __LINE__);
            $subject = sqlesc($lang['casino_casino_results']);
            $msg = sqlesc("You lost a bet ! " . htmlsafechars($CURUSER['username']) . " just won " . htmlsafechars($nogb) . " of your upload credit !");
            sql_query("INSERT INTO messages (subject, sender, receiver, added, msg, unread, poster) VALUES ($subject, $sendfrom, " . sqlesc($tbet['userid']) . ", $time, $msg, 'yes', $sendfrom)") or sqlerr(__FILE__, __LINE__);
            $mc1->delete_value('inbox_new_' . $tbet['userid']);
            $mc1->delete_value('inbox_new_sb_' . $tbet['userid']);
            if ($writelog == 1)
                write_log($CURUSER['username'] . " won $nogb {$lang['casino_of_upload_credit_off']} " . htmlsafechars($tbet['proposed']));
            if ($delold == 1)
                sql_query("DELETE FROM casino_bets WHERE id =" . sqlesc($tbet['id'])) or sqlerr(__FILE__, __LINE__);
            stderr($lang['casino_you_got_it'], "<h2>{$lang['casino_you_won_the_bet']}, " . htmlsafechars($nogb) . " {$lang['casino_has_been_credited_to_your_account']}, at <a href='userdetails.php?id=" . (int) $tbet['userid'] . "'>" . htmlsafechars($tbet['proposed']) . "'s</a> {$lang['casino_expense']} !</h2>&nbsp;&nbsp;&nbsp;$goback");
            exit();
        } else {
            if (empty($newup))
                $newup = $User['uploaded'] - $tbet['amount'];
            $newup2 = $tbet['amount'] * 2;
            sql_query("UPDATE users SET uploaded = " . sqlesc($newup) . " WHERE id =" . sqlesc($CURUSER['id'])) or sqlerr(__FILE__, __LINE__);
            sql_query("UPDATE users SET uploaded = uploaded + " . sqlesc($newup2) . " WHERE id = " . sqlesc($tbet['userid'])) or sqlerr(__FILE__, __LINE__);
            sql_query("UPDATE casino SET deposit = deposit-" . sqlesc($tbet['amount']) . " WHERE userid = " . sqlesc($tbet['userid']));
            $update['uploaded'] = ($newup);
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
            $update['uploaded_2'] = ($User['uploaded'] + $newup2);
            //==stats
            $mc1->begin_transaction('userstats_' . $tbet['userid']);
            $mc1->update_row(false, array(
                'uploaded' => $update['uploaded_2']
            ));
            $mc1->commit_transaction($INSTALLER09['expires']['u_stats']);
            $mc1->begin_transaction('user_stats_' . $tbet['userid']);
            $mc1->update_row(false, array(
                'uploaded' => $update['uploaded_2']
            ));
            $mc1->commit_transaction($INSTALLER09['expires']['user_stats']);
            if (mysqli_affected_rows($GLOBALS["___mysqli_ston"]) == 0)
                sql_query("INSERT INTO casino (userid, date, deposit) VALUES (" . sqlesc($tbet['userid']) . ", $time, -" . sqlesc($tbet['amount']) . ")") or sqlerr(__FILE__, __LINE__);
            sql_query("UPDATE casino_bets SET challenged = " . sqlesc($CURUSER['username']) . ", winner = " . sqlesc($tbet['proposed']) . " WHERE id = " . sqlesc($betid)) or sqlerr(__FILE__, __LINE__);
            $subject = sqlesc($lang['casino_casino_results']);
            $msg = sqlesc("{$lang['casino_you_just_won']} " . htmlsafechars($nogb) . " {$lang['casino_of_upload_credit_from']} " . $CURUSER['username'] . " !");
            sql_query("INSERT INTO messages (subject, sender, receiver, added, msg, unread, poster) VALUES ($subject, $sendfrom, " . sqlesc($tbet['userid']) . ", $time, $msg, 'yes', $sendfrom)") or sqlerr(__FILE__, __LINE__);
            $mc1->delete_value('inbox_new_' . $tbet['userid']);
            $mc1->delete_value('inbox_new_sb_' . $tbet['userid']);
            if ($writelog == 1)
                write_log("" . htmlsafechars($tbet['proposed']) . " won $nogb {$lang['casino_of_upload_credit_off']} " . $CURUSER['username']);
            if ($delold == 1)
                sql_query("DELETE FROM casino_bets WHERE id =" . sqlesc($tbet['id'])) or sqlerr(__FILE__, __LINE__);
            stderr($lang['casino_damn_it'], "<h2>{$lang['casino_you_lost_the_bet']} <a href='userdetails.php?id=" . (int) $tbet['userid'] . "'>" . htmlsafechars($tbet['proposed']) . "</a> {$lang['casino_has_won']} " . htmlsafechars($nogb) . " {$lang['casino_of_your_hard_earnt_upload_credit']} !</h2> &nbsp;&nbsp;&nbsp;$goback");
        }
        exit();
    }
    //== Add a new bet
    $loca = sql_query("SELECT * FROM casino_bets WHERE challenged ='empty'") or sqlerr(__FILE__, __LINE__);
    $totbets = mysqli_num_rows($loca);
    if (isset($_POST['unit'])) {
        if (0 + $_POST["unit"] == '1')
            $nobits = 0 + $_POST["amnt"] * $mb_basic;
        else
            $nobits = 0 + $_POST["amnt"] * $mb_basic * 1024;
    }
    if (isset($_POST["unit"])) {
        if ($openbet >= $maxusrbet)
            stderr($lang['gl_sorry'], "{$lang['casino_there_are_already']} " . htmlsafechars($openbet) . " {$lang['casino_bets_open_take_an_open_bet']} !");
        if ($nobits <= 0)
            stderr($lang['gl_sorry'], " {$lang['casino_this_wont_work_enter_a_pos_val']}?");
        if ($nobits == ".")
            stderr($lang['gl_sorry'], " {$lang['casino_this_wont_work_enter_without_a_dec']}?");
        $newups = $CURUSER['uploaded'] - $nobits;
        $debt = $nobits - $CURUSER['uploaded'];
        if ($CURUSER['uploaded'] < $nobits) {
            if ($alwdebt != 1)
                stderr($lang['gl_sorry'], "<h2>{$lang['casino_thats']} " . htmlsafechars(mksize($debt)) . " {$lang['casino_more_than_you_got']}!</h2>$goback");
        }
        $betsp = sql_query("SELECT id, amount FROM casino_bets WHERE userid = " . sqlesc($CURUSER['id']) . " ORDER BY time ASC") or sqlerr(__FILE__, __LINE__);
        $tbet2 = mysqli_fetch_row($betsp);
        $dummy = "<h2>{$lang['casino_bet_added_you_will_receive_a_pm_notify']}</h2>";
        $user = $CURUSER['username'];
        $bet = mksize($nobits);
        $message = "[color=green][b]{$user}[/b][/color] {$lang['casino_has_just_placed_a']} [color=red][b]{$bet}[/b][/color] {$lang['casino_bet_in_the_casino']}";
        $messages = "{$user} {$lang['casino_has_just_placed_a']} {$bet} {$lang['casino_bet_in_the_casino']}";
        sql_query("INSERT INTO casino_bets ( userid, proposed, challenged, amount, time) VALUES (" . sqlesc($CURUSER['id']) . "," . sqlesc($CURUSER['username']) . ", 'empty', $nobits, $time)") or sqlerr(__FILE__, __LINE__);
        sql_query("UPDATE users SET uploaded = " . sqlesc($newups) . " WHERE id = " . sqlesc($CURUSER['id'])) or sqlerr(__FILE__, __LINE__);
        sql_query("UPDATE casino SET deposit = deposit + " . sqlesc($nobits) . " WHERE userid = " . sqlesc($CURUSER['id'])) or sqlerr(__FILE__, __LINE__);
        $update['uploaded'] = ($newups);
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
        if ($INSTALLER09['autoshout_on'] == 1 || $INSTALLER09['irc_autoshout_on'] == 1) {
        autoshout($message);
        ircbot($messages);
        $mc1->delete_value('shoutbox_');
        }
        if (mysqli_affected_rows($GLOBALS["___mysqli_ston"]) == 0)
            sql_query("INSERT INTO casino (userid, date, deposit) VALUES (" . sqlesc($CURUSER['id']) . ", $time, " . sqlesc($nobits) . ")") or sqlerr(__FILE__, __LINE__);
    }
    $loca = sql_query("SELECT * FROM casino_bets WHERE challenged ='empty'");
    $totbets = mysqli_num_rows($loca);
    

//== Output html begin
    $HTMLOUT = '';
    $HTMLOUT .= "<table class='table table-bordered'>
            <tr>
            <td align='center'>";
    $HTMLOUT = $dummy;
    

//== Place bet table
    if ($openbet < $maxusrbet) {
        if ($totbets >= $maxtotbet)
            $HTMLOUT .= "<br />{$lang['casino_there_are_already']} " . htmlsafechars($maxtotbet) . " {$lang['casino_bets_open_take_an_open_bet']} !<br />";
        else {
            $HTMLOUT .= "<br />
            <form class=\"form-horizontal\" name=\"p2p\" method=\"post\" action=\"casino.php\">
        <div class='panel panel-default'>
	<div class='panel-heading'>
	<h1 class='col-sm-offset-3'>{$INSTALLER09['site_name']} {$lang['casino_stdhead']} - {$lang['casino_bet_p2p_with_other_users']}:</h1></div>
	<div class='panel-body'>
	
            <div class='row'><div class='col-sm-6 col-sm-offset-3'><div class='panel'><table class='table'>";
            $HTMLOUT .= "<tr><td align=\"center\" colspan=\"2\" class=\"colhead\">{$lang['casino_place_bet']}</td></tr>";
            $HTMLOUT .= "<tr><td align=\"center\"><b>{$lang['casino_amount_to_bet']}</b>

            <div class='row'><div class='col-sm-3 col-sm-offset-3'><input class=\"form-control input-small\" type=\"text\" name=\"amnt\" size=\"5\" value=\"1\" /></div>
            <div class='col-sm-3'><select class=\"form-control\" name=\"unit\">

            <option value=\"1\">MB</option>
            <option value=\"2\">GB</option>
            </select></div></div></td></tr>";
            $HTMLOUT .= "<tr><td align=\"center\" colspan=\"2\"><input class='btn btn-default' type=\"submit\" value=\"{$lang['casino_gamble']}!\" />";
            $HTMLOUT .= "</td></tr></table></div></form></div></div></div></div><br />";
        }
    } else
        $HTMLOUT .= "<b>{$lang['casino_you_already_have']} " . htmlsafechars($maxusrbet) . " {$lang['casino_open_bets_wait_until_they_are_comp']}.</b><br /><br />";
 //== Open Bets table
    $HTMLOUT .= "<div class='panel panel-default'>	
	<table class='table table-bordered'>";
    $HTMLOUT .= "<tr><td align=\"center\" class=\"colhead\" colspan=\"4\">{$lang['casino_open_bets']}</td></tr></div>";
    $HTMLOUT .= "<tr>
            <td align=\"center\" width=\"15%\"><b>{$lang['casino_name']}</b></td><td width=\"15%\" align=\"center\"><b>{$lang['casino_amount']}</b></td>
            <td width=\"45%\" align=\"center\"><b>{$lang['casino_time']}</b></td><td align=\"center\"><b>{$lang['casino_take_bet']}</b></td>
            </tr>";
    while ($res = mysqli_fetch_assoc($loca)) {
        $HTMLOUT .= "<tr>
            <td align=\"center\">" . htmlsafechars($res['proposed']) . "</td>
            <td align=\"center\">" . htmlsafechars(mksize($res['amount'])) . "</td>
            <td align=\"center\">" . get_date($res['time'], 'LONG', 0, 1) . "</td>
            <td align=\"center\"><b><a href='{$casino}?takebet=" . (int) $res['id'] . "'>{$lang['casino_this']}</a></b></td>
            </tr>";
        $abcdefgh = 1;
    }
    if ($abcdefgh == false)
        $HTMLOUT .= "<tr><td align='center' colspan='4'>{$lang['casino_sorry_no_bets_currently']}.</td></tr>";
    $HTMLOUT .= "</table></div><br />";  

//== Bet on color table
$HTMLOUT.="<div class='row'>
<div class='col-sm-6'>";
    $HTMLOUT .= "<div class='panel panel-default'>
		<form class=\"form-horizontal\" name=\"casino\" method=\"post\" action=\"casino.php\">
            <table class=\"message table table-bordered\" cellspacing=\"0\">\n";
    $HTMLOUT .= "<tr><td align=\"center\" class=\"colhead\" colspan=\"2\">{$lang['casino_bet_on_a_colour']}</td></tr>";
    $HTMLOUT .= tr($lang['casino_black'], "<input name=\"color\" type=\"radio\" checked=\"checked\" value=\"black\" />", 1);
    $HTMLOUT .= tr($lang['casino_red'], "<input name=\"color\" type=\"radio\" checked=\"checked\" value=\"red\" />", 1);
    $HTMLOUT .= tr($lang['casino_how_much'], "
            <select class-\"form-control\" name=\"betmb\">
            <option value=\"{$bet_value1}\">" . mksize($bet_value1) . "</option>
            <option value=\"{$bet_value2}\">" . mksize($bet_value2) . "</option>
            <option value=\"{$bet_value3}\">" . mksize($bet_value3) . "</option>
            <option value=\"{$bet_value4}\">" . mksize($bet_value4) . "</option>
            <option value=\"{$bet_value5}\">" . mksize($bet_value5) . "</option>
            <option value=\"{$bet_value6}\">" . mksize($bet_value6) . "</option>
            <option value=\"{$bet_value7}\">" . mksize($bet_value7) . "</option>
            </select>", 1);
    if ($show_real_chance)
        $real_chance = $cheat_value + 1;
    else
        $real_chance = 2;
    $HTMLOUT .= tr($lang['casino_your_chance'], "1 : " . $real_chance, 1);
    $HTMLOUT .= tr($lang['casino_you_can_win'], $win_amount . " * stake", 1);
    $HTMLOUT .= tr($lang['casino_bet_on_color'], "<input class='btn btn-default'  type=\"submit\" value=\"{$lang['casino_do_it']}!\" />", 1);
    $HTMLOUT .= "</table></form></div></div>";
 //== Bet on number table
$HTMLOUT.="<div class='col-sm-6'>";
    $HTMLOUT .= "<div class='panel panel-default'>
	<form class=\"form-horizontal\" name=\"casino\" method=\"post\" action=\"casino.php\">
            <table class=\"message table table-bordered\"  cellspacing=\"0\">\n";
    $HTMLOUT .= "<tr><td align=\"center\" class=\"colhead\" colspan=\"2\">{$lang['casino_bet_on_a_number']}</td></tr>";
    $HTMLOUT .= tr($lang['casino_number'], '<input name="number" type="radio" checked="checked" value="1" />1&nbsp;&nbsp;<input name="number" type="radio" value="2" />2&nbsp;&nbsp;<input name="number" type="radio" value="3" />3', 1);
    $HTMLOUT .= tr("", '<input name="number" type="radio" value="4" />4&nbsp;&nbsp;<input name="number" type="radio" value="5" />5&nbsp;&nbsp;<input name="number" type="radio" value="6" />6', 1);
    $HTMLOUT .= tr($lang['casino_how_much'], "
            <select class=\"form-control\" name=\"betmb\">
            <option value=\"{$bet_value1}\">" . mksize($bet_value1) . "</option>
            <option value=\"{$bet_value2}\">" . mksize($bet_value2) . "</option>
            <option value=\"{$bet_value3}\">" . mksize($bet_value3) . "</option>
            <option value=\"{$bet_value4}\">" . mksize($bet_value4) . "</option>
            <option value=\"{$bet_value5}\">" . mksize($bet_value5) . "</option>
            <option value=\"{$bet_value6}\">" . mksize($bet_value6) . "</option>
            <option value=\"{$bet_value7}\">" . mksize($bet_value7) . "</option>
            </select>", 1);
    if ($show_real_chance)
        $real_chance = $cheat_value + 5;
    else
        $real_chance = 6;
    $HTMLOUT .= tr($lang['casino_your_chance'], "1 : " . $real_chance, 1);
    $HTMLOUT .= tr($lang['casino_you_can_win'], $win_amount_on_number . " * stake", 1);
    $HTMLOUT .= tr($lang['casino_bet_on_a_number'], "<input class='btn btn-default'  type=\"submit\" value=\"{$lang['casino_do_it']}!\" />", 1);
    $HTMLOUT .= "</table></form></div></div></div>";
 //== User stats table
    $HTMLOUT .= "<div class='panel panel-default'><table class='table table-bordered'>";
    $HTMLOUT .= "<tr><td align=\"center\" class=\"colhead\" colspan=\"3\">{$CURUSER['username']}'s {$lang['casino_details']}</td></tr>
            <tr><td align='center'>
            <h1>User @ {$INSTALLER09['site_name']} {$lang['casino_stdhead']}</h1>
            <table class='message table table-bordered' cellspacing='0'>";
    $HTMLOUT .= tr($lang['casino_you_can_win'], mksize($max_download_user), 1);
    $HTMLOUT .= tr($lang['casino_won'], mksize($user_win), 1);
    $HTMLOUT .= tr($lang['casino_lost'], mksize($user_lost), 1);
    $HTMLOUT .= tr($lang['casino_ratio'], $casino_ratio_user, 1);
    $HTMLOUT .= tr($lang['casino_deposit_on_p2p'], mksize($user_deposit + $nobits));
    $HTMLOUT .= "</table>
            </td><td align='center'>
            <h1>{$lang['casino_global_stats']}</h1>
            <table class='message table table-bordered' cellspacing='0'>";
    $HTMLOUT .= tr($lang['casino_users_can_win'], mksize($max_download_global), 1);
    $HTMLOUT .= tr($lang['casino_won'], mksize($global_win), 1);
    $HTMLOUT .= tr($lang['casino_lost'], mksize($global_lost), 1);
    $HTMLOUT .= tr($lang['casino_ratio'], $casino_ratio_global, 1);
    $HTMLOUT .= tr($lang['casino_deposit'], mksize($global_deposit));
    $HTMLOUT .= "</table>";
    $HTMLOUT .= "</td><td align='center'>
            <h1>{$lang['casino_user_stats']}</h1>
            <table class='message table table-bordered' cellspacing='0'>";
    $HTMLOUT .= tr($lang['casino_uploaded'], mksize($User['uploaded'] - $nobits));
    $HTMLOUT .= tr($lang['casino_downloaded'], mksize($User['downloaded']));
    $HTMLOUT .= tr($lang['casino_ratio'], $ratio);
    $HTMLOUT .= "</table></td></tr></table></div>";
}
echo stdhead("{$INSTALLER09['site_name']} {$lang['casino_stdhead']}") . $HTMLOUT . stdfoot();
?>
