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
require_once (INCL_DIR . 'html_functions.php');
dbconn();
loggedinorreturn();
$lang = array_merge(load_language('global'));
define('IN_LOTTERY', 'yeah');
$lottery_root = ROOT_DIR . 'lottery' . DIRECTORY_SEPARATOR;
$valid = array(
    'config' => array(
        'minclass' => UC_STAFF,
        'file' => $lottery_root . 'config.php'
    ) ,
    'viewtickets' => array(
        'minclass' => UC_STAFF,
        'file' => $lottery_root . 'viewtickets.php'
    ) ,
    'tickets' => array(
        'minclass' => UC_USER,
        'file' => $lottery_root . 'tickets.php'
    ) ,
);
$do = isset($_GET['do']) && in_array($_GET['do'], array_keys($valid)) ? $_GET['do'] : '';
if ($CURUSER["game_access"] == 0 || $CURUSER["game_access"] > 1 || $CURUSER['suspended'] == 'yes') {
    stderr("Error", "Your gaming rights have been disabled.");
    exit();
}
switch (true) {
case $do == 'config' && $CURUSER['class'] >= $valid['config']['minclass']:
    require_once ($valid['config']['file']);
    break;

case $do == 'viewtickets' && $CURUSER['class'] >= $valid['viewtickets']['minclass']:
    require_once ($valid['viewtickets']['file']);
    break;

case $do == 'tickets' && $CURUSER['class'] >= $valid['tickets']['minclass']:
    require_once ($valid['tickets']['file']);
    break;

default:
    $html = '';
$html .= "<div class='row'><div class='col-md-12'>";
    //get config from database
    $lconf = sql_query('SELECT * FROM lottery_config') or sqlerr(__FILE__, __LINE__);
    while ($ac = mysqli_fetch_assoc($lconf)) $lottery_config[$ac['name']] = $ac['value'];    
if (!$lottery_config['enable']) $html.= "<div class='row'><div class='col-md-12'><h2>Sorry, the lottery is closed at the moment</h2>";    
if ($lottery_config['end_date'] > TIME_NOW) 
$html.= "<div class='row'><div class='col-md-12'><h2>Lottery in progress. Lottery started on <b>" . get_date($lottery_config['start_date'], 'LONG') . "</b> and ends on <b>" . get_date($lottery_config['end_date'], 'LONG') . "</b> remaining <span style='color:#ff0000;'>" . mkprettytime($lottery_config['end_date'] - TIME_NOW) . "</span><br />
       <p style='text-align:center'>" . ($CURUSER['class'] >= $valid['viewtickets']['minclass'] ? "<a href='lottery.php?do=viewtickets'>[View bought tickets]</a>&nbsp;&nbsp;" : "") . "<a href='lottery.php?do=tickets'>[Buy tickets]</a></p></h2>";
  
//get last lottery data
    if (!empty($lottery_config['lottery_winners'])) {
        $html.= stdmsg('Last lottery', '' . get_date($lottery_config['lottery_winners_time'], 'LONG') . '');
        $uids = (strpos($lottery_config['lottery_winners'], '|') ? explode('|', $lottery_config['lottery_winners']) : $lottery_config['lottery_winners']);
        $last_winners = array();
        $qus = sql_query('SELECT id,username FROM users WHERE id ' . (is_array($uids) ? 'IN (' . join(',', $uids) . ')' : '=' . $uids)) or sqlerr(__FILE__, __LINE__);
        while ($aus = mysqli_fetch_assoc($qus)) $last_winners[] = "<a href='userdetails.php?id=" . (int)$aus['id'] . "'>" . htmlsafechars($aus['username']) . "</a>";
        
        $html.= stdmsg("Lottery Winners Info", "<ul style='text-align:left;'><li>Last winners: " . join(', ', $last_winners) . "</li><li>Amount won	(each): " . $lottery_config['lottery_winners_amount'] . "</li></ul><br />
        <p style='text-align:center'>" . ($CURUSER['class'] >= $valid['config']['minclass'] ? "<a href='lottery.php?do=config'>[Lottery configuration]</a>&nbsp;&nbsp;" : "Nothing Configured Atm Sorry") . "</p>");
 } else {      
      $html .= "<div class='row'><div class='col-md-12'>";  
	$html.= "<ul><li> Nobody has won, because nobody has played yet : )</li></ul>";
        $html.= "<p style='text-align:center'>" . ($CURUSER['class'] >= $valid['config']['minclass'] ? "<a href='lottery.php?do=config'>[Lottery configuration]</a>&nbsp;&nbsp;" : "Nothing Configured Atm Sorry") . "</p>";
     $html .= "</div></div>";   
	    }
$html .= "</div></div>";
    echo (stdhead('Lottery') . $html . stdfoot());
}
?>
