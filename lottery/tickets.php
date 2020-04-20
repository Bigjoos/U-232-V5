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
if (!defined('IN_LOTTERY')) {
    die('You can\'t access this file directly!');
}
//get config from database
$lconf = sql_query('SELECT * FROM lottery_config') or sqlerr(__FILE__, __LINE__);
while ($ac = mysqli_fetch_assoc($lconf)) {
    $lottery_config[$ac['name']] = $ac['value'];
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $tickets = isset($_POST['tickets']) ? 0 + $_POST['tickets'] : '';
    if (!$tickets) {
        stderr('Hmm', 'How many tickets you wanna buy?');
    }
    $user_tickets = get_row_count('tickets', 'where user=' . $CURUSER['id']);
    if ($user_tickets + $tickets > $lottery_config['user_tickets']) {
        stderr('Hmmm', 'You reached your limit max is ' . $lottery_config['user_tickets'] . ' ticket(s)');
    }
    if ($CURUSER['seedbonus'] < $tickets * $lottery_config['ticket_amount']) {
        stderr('Hmmmm', 'You need more points to buy the amount of tickets you want');
    }
    for ($i = 1; $i <= $tickets; $i++) {
        $t[] = '(' . $CURUSER['id'] . ')';
    }
    if (sql_query('INSERT INTO tickets(user) VALUES ' . join(', ', $t))) {
        sql_query('UPDATE users SET seedbonus = seedbonus - ' . ($tickets * $lottery_config['ticket_amount']) . ' WHERE id = ' . $CURUSER['id']);
        $seedbonus_new = $CURUSER['seedbonus'] - ($tickets * $lottery_config['ticket_amount']);
        $What_Cache = (XBT_TRACKER == true ? 'userstats_xbt_' : 'userstats_');
        $What_Expire = (XBT_TRACKER == true ? $INSTALLER09['expires']['u_stats_xbt'] : $INSTALLER09['expires']['u_stats']);
        $mc1->begin_transaction($What_Cache . $CURUSER['id']);
        $mc1->update_row(false, [
            'seedbonus' => $seedbonus_new
        ]);
        $mc1->commit_transaction($What_Expire);
        $What_Cache = (XBT_TRACKER == true ? 'user_stats_xbt_' : 'user_stats_');
        $What_Expire = (XBT_TRACKER == true ? $INSTALLER09['expires']['user_stats_xbt'] : $INSTALLER09['expires']['user_stats']);
        $mc1->begin_transaction($What_Cache . $CURUSER['id']);
        $mc1->update_row(false, [
            'seedbonus' => $seedbonus_new
        ]);
        $mc1->commit_transaction($What_Expire);
        stderr('Success', 'You bought <b>' . $tickets . '</b>, your new amount is <b>' . ($tickets + $user_tickets) . '</b>');
    } else {
        stderr('Errr', 'There was an error with the update query, mysql error: ' . ((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
    }
    exit;
}
$classes_allowed = (strpos($lottery_config['class_allowed'], '|') ? explode('|', $lottery_config['class_allowed']) : $lottery_config['class_allowed']);
if (!(is_array($classes_allowed) ? in_array($CURUSER['class'], $classes_allowed) : $CURUSER['class'] == $classes_allowed)) {
    stderr('Error', 'Your class is not allowed to play in this lottery');
}
//some default values
$lottery['total_pot'] = 0;
$lottery['current_user'] = [];
$lottery['current_user']['tickets'] = [];
$lottery['total_tickets'] = 0;
//select the total amount of tickets
$qt = sql_query('SELECT id,user FROM tickets ORDER BY id ASC ') or sqlerr(__FILE__, __LINE__);
while ($at = mysqli_fetch_assoc($qt)) {
    $lottery['total_tickets']+= 1;
    if ($at['user'] == $CURUSER['id']) {
        $lottery['current_user']['tickets'][] = $at['id'];
    }
}
//set the current user total tickets amount
$lottery['current_user']['total_tickets'] = count($lottery['current_user']['tickets']);
//check if the prize setting is set to calculate the totat pot
if ($lottery_config['use_prize_fund']) {
    $lottery['total_pot'] = $lottery_config['prize_fund'];
} else {
    $lottery['total_pot'] = $lottery_config['ticket_amount'] * $lottery['total_tickets'];
}
//how much the winner gets
$lottery['per_user'] = round($lottery['total_pot'] / $lottery_config['total_winners'], 2);
//how many tickets could the user buy
$lottery['current_user']['could_buy'] = $lottery['current_user']['can_buy'] = $lottery_config['user_tickets'] - $lottery['current_user']['total_tickets'];
//if he has less bonus points calculate how many tickets can he buy with what he has
if ($CURUSER['seedbonus'] < ($lottery['current_user']['could_buy'] * $lottery_config['ticket_amount'])) {
    for ($lottery['current_user']['can_buy']; $CURUSER['seedbonus'] < ($lottery_config['ticket_amount'] * $lottery['current_user']['can_buy']); --$lottery['current_user']['can_buy']);
}
//check if the lottery ended if the lottery ended don't allow the user to buy more tickets or if he has already bought the max tickets
if (time() > $lottery_config['end_date'] || $lottery_config['user_tickets'] <= $lottery['current_user']['total_tickets']) {
    $lottery['current_user']['can_buy'] = 0;
}
//print('<pre>'.print_r($lottery,1));
$html ='';
$html = "<div class='row'><div class='col-md-12'><h2>Lottery</h2>";
$html.= "<ul style='text-align:left;'>
    <li>Tickets are non-refundable</li>
    <li>Each ticket costs <b>" . $lottery_config['ticket_amount'] . "</b> which is taken from your seedbonus amount</li>
    <li>Purchaseable shows how many tickets you can afford</li>
    <li>You can only buy up to your purchaseable amount.</li>
    <li>The competiton will end: <b>" . get_date($lottery_config['end_date'], 'LONG') . "</b></li>
    <li>There will be <b>" . $lottery_config['total_winners'] . "</b> winners who will be picked at random</li>
    <li>Winner(s) will get <b>" . $lottery['per_user'] . "</b> added to their seedbonus amount</li>
    <li>The Winners will be announced once the lottery has closed and posted on the home page.</li>";
if (!$lottery_config['use_prize_fund']) {
    $html.= "<li>The more tickets that are sold the bigger the pot will be !</li>";
}
if (count($lottery['current_user']['tickets'])) {
    $html.= "<li>You own ticket numbers : <b>" . join('</b>, <b>', $lottery['current_user']['tickets']) . "</b></li>";
}
$html.= "</ul><hr/>
   <table class='table table-bordered'>
    <tr>
      <td>Total Pot</td>
      <td  align='right'>" . $lottery['total_pot'] . "</td>
    </tr>
    <tr>
      <td>Total Tickets Purchased</td>
      <td  align='right'>" . $lottery['total_tickets'] . " Tickets</td>
    </tr>
    <tr>
      <td>Tickets Purchased by You</td>
      <td  align='right'>" . $lottery['current_user']['total_tickets'] . " Tickets</td>
    </tr>
    <tr>
      <td>Purchaseable</td>
      <td  align='right'>" . ($lottery['current_user']['could_buy'] > $lottery['current_user']['can_buy'] ? 'you have points for <b>' . $lottery['current_user']['can_buy'] . '</b> ticket(s) but you can buy another <b>' . ($lottery['current_user']['could_buy'] - $lottery['current_user']['can_buy']) . '</b> ticket(s) if you get more bonus points' : $lottery['current_user']['can_buy']) . "</td>
    </tr>";
if ($lottery['current_user']['can_buy'] > 0) {
    $html.= "
      <tr>
        <td>Amount to Purchase</td>
        <td align='center'> 
          <form action='lottery.php?do=tickets' method='post'>
              <input type='text' class='form-control' size='2' name='tickets' /><input class='btn btn-default' type='submit' value='Buy tickets' />
          </form>
        </td>
      </tr>";
}
$html.= "</table>";
$html.= "</div></div><br>";
echo(stdhead('Buy tickets for lottery') . $html . stdfoot());
