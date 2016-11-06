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
if (!defined('IN_LOTTERY')) die('You can\'t access this file directly!');
if ($CURUSER['class'] < UC_MODERATOR) stderr('Err', 'What you doing here dude?');
//get the config from db
$lconf = sql_query('SELECT * FROM lottery_config') or sqlerr(__FILE__, __LINE__);
while ($ac = mysqli_fetch_assoc($lconf)) $lottery_config[$ac['name']] = $ac['value'];
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    //can't be 0
    foreach (array(
        'ticket_amount' => 0,
        'class_allowed' => 1,
        'user_tickets' => 0,
        'end_date' => 0
    ) as $key => $type) {
        if (isset($_POST[$key]) && ($type == 0 && $_POST[$key] == 0 || $type == 1 && count($_POST[$key]) == 0)) stderr('Err', 'You forgot to fill some data');
    }
    foreach ($lottery_config as $c_name => $c_value) if (isset($_POST[$c_name]) && $_POST[$c_name] != $c_value) $update[] = '(' . sqlesc($c_name) . ',' . sqlesc(is_array($_POST[$c_name]) ? join('|', $_POST[$c_name]) : $_POST[$c_name]) . ')';
    if (sql_query('INSERT INTO lottery_config(name,value) VALUES ' . join(',', $update) . ' ON DUPLICATE KEY update value=values(value)')) stderr('Success', 'Lottery configuration was saved! Click <a href=\'lottery.php?do=config\'>here to get back</a>');
    else stderr('Error', 'There was an error while executing the update query. Mysql error: ' . ((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
    exit;
}
$html ='';
$html.= "<div class='row'><div class='col-md-12'>";
if ($lottery_config['enable']) {
    $classes = join(', ', array_map('get_user_class_name', explode('|', $lottery_config['class_allowed'])));
  $html.= "<div class='row'><div class='col-md-12'><h2>Lottery configuration closed. Classes playing in this lottery are : <b>$classes</b></h2><br>";
} else {
    $html.= "<div class='row'><div class='col-md-12'><h2>Lottery configuration</h2>";
    $html.= "<form action='lottery.php?do=config' method='post'>
  <table class='table table-bordered'>
	<tr>
    <td width='50%' align='left'>Enable The Lottery</td>
    <td align='left'>Yes <input type='radio' name='enable' value='1' " . ($lottery_config['enable'] ? 'checked=\'checked\'' : '') . " /> No <input type='radio' name='enable' value='0' " . (!$lottery_config['enable'] ? 'checked=\'checked\'' : '') . " />
    </td>
  </tr>
	<tr>
    <td width='50%' align='left'>Use Prize Fund (No, uses default pot of all users)</td><td align='left'>Yes <input type='radio' name='use_prize_fund' value='1' " . ($lottery_config['use_prize_fund'] ? 'checked=\'checked\'' : '') . " /> No <input type='radio' name='use_prize_fund' value='0' " . (!$lottery_config['use_prize_fund'] ? 'checked=\'checked\'' : '') . " /></td>
  </tr>
	<tr>
   <td width='50%' align='left'>Prize Fund</td>
   <td align='left'><input type='text' class='form-control' name='prize_fund' value='{$lottery_config['prize_fund']}' /></td>
  </tr>
	<tr>
   <td width='50%' align='left'>Ticket Amount</td>
   <td align='left'><input type='text' class='form-control' name='ticket_amount' value='{$lottery_config['ticket_amount']}' /></td>
  </tr>
	<tr>
    <td width='50%' align='left'>Ticket Amount Type</td>
    <td align='left'><select class='form-control' name='ticket_amount_type'><option value='seedbonus' selected='selected'>seedbonus</option></select></td>
  </tr>
	<tr><td width='50%' align='left'>Amount Of Tickets Allowed</td><td align='left'><input type='text' class='form-control' name='user_tickets' value='{$lottery_config['user_tickets']}' /></td>
  </tr>
	<tr><td width='50%' align='left' valign='top'>Classes Allowed</td><td align='left'>";
    for ($i = UC_USER; $i <= UC_SYSOP; $i++) $html.= "<label for='c{$i}'><input type='checkbox' value='{$i}' id='c{$i}' name='class_allowed[]'/> " . get_user_class_name($i) . "</label><br/>";
    $html.= "</td></tr>";
    $html.= "
   <tr>
    <td width='50%' align='left'>Total Winners</td>
    <td align='left'><input type='text' class='form-control' name='total_winners' value='{$lottery_config['total_winners']}' /></td>
  </tr>
	<tr>
    <td width='50%' align='left'>Start Date</td>
    <td align='left'>
      <select class='form-control' name='start_date'><option value='" . TIME_NOW . "'>Now</option>";
    for ($i = 2; $i <= 24; $i+= 2) $html.= "<option value='" . (TIME_NOW + (3600 * $i)) . "' >" . $i . " hours</option>";
    $html.= "</select></td>
    </tr>
    <tr>
      <td width='50%' align='left'>End Date</td><td align='left'><select class='form-control' name='end_date'>
        <option value='0'>------</option>";
    for ($i = 1; $i <= 7; $i++) $html.= "<option value='" . (TIME_NOW + (84600 * $i)) . "'>{$i} days</option>";
    $html.= "</select></td>
    </tr>
    <tr>
      <td colspan='2' align='center'><input class='btn btn-default' type='submit' value='Apply changes' /></td>
    </tr>";
    $html.= "</table></form>";
$html.= "</div></div>";   
}
$html.= "</div></div>";
echo (stdhead('Lottery configuration') . $html . stdfoot());
?>
