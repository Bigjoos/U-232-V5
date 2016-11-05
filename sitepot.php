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
/** sitepot.php by pdq for tbdev.net **/
require_once (__DIR__ . DIRECTORY_SEPARATOR . 'include' . DIRECTORY_SEPARATOR . 'bittorrent.php');
require_once (INCL_DIR . 'user_functions.php');
dbconn();
loggedinorreturn();
$lang = array_merge(load_language('global'));
/** Size of Pot**/
$potsize = 50000;
/** Site Pot **/
$Pot_query = sql_query("SELECT value_s, value_i, value_u FROM avps WHERE arg = 'sitepot'") or sqlerr(__file__, __line__);
$SitePot = mysqli_fetch_assoc($Pot_query) or stderr('ERROR', 'db error.');
if ($SitePot['value_u'] < TIME_NOW && $SitePot['value_s'] == '1') {
    sql_query("UPDATE avps SET value_i = 0, value_s = '0' WHERE arg = 'sitepot'") or sqlerr(__file__, __line__);
    header('Location: sitepot.php');
    die();
}

//=== site pot-o-meter (.) (.) == set the target amount for free leech
//=== get total points
    if(($site_pot_counter = $mc1->get_value('site_pot_counter')) === false) {
    $total = sql_query('SELECT value_i FROM avps WHERE avps.arg = "sitepot"');
    $total_row = mysqli_fetch_assoc($total);
    $percent = number_format($total_row['value_i'] / $potsize * 100, 2);
    $mc1->cache_value('site_pot_counter', $percent);
    } else
    $percent = $site_pot_counter;
        
			switch ($percent)
			{
	   			case $percent >= 100:
			$image_to_use = '<img src="/pic/bar_12.png" alt="'.$percent.'% so far!" title="Site Pot-0-Meter '.$percent.'% full!!!" align="middle" />';
				break; 
				   case $percent >= 80:
			$image_to_use = '<img src="/pic/bar_10.png" alt="'.$percent.'% so far!" title="Site Pot-0-Meter '.$percent.'% full!!!" align="middle" />';
				break;
				   case $percent >= 70:
			$image_to_use = '<img src="/pic/bar_8.png" alt="'.$percent.'% so far!" title="Site Pot-0-Meter '.$percent.'% full!!!" align="middle" />';
				break;
				   case $percent >= 50:
			$image_to_use = '<img src="/pic/bar_6.png" alt="'.$percent.'% so far!" title="Site Pot-0-Meter '.$percent.'% full!!!" align="middle" />';
				break;
				   case $percent >= 40:
			$image_to_use = '<img src="/pic/bar_5.png" alt="'.$percent.'% so far!" title="Site Pot-0-Meter '.$percent.'% full!!!" align="middle" />';
				break;
				   case $percent >= 30:
			$image_to_use = '<img src="/pic/bar_4.png" alt="'.$percent.'% so far!" title="Site Pot-0-Meter '.$percent.'% full!!!" align="middle" />';
				break;
				   case $percent >= 20:
			$image_to_use = '<img src="/pic/bar_3.png" alt="'.$percent.'% so far!" title="Site Pot-0-Meter '.$percent.'% full!!!" align="middle" />';
				break;				
				   case $percent < 20:
			$image_to_use = '<img src="/pic/bar_2.png" alt="'.$percent.'% so far!" title="Site Pot-0-Meter '.$percent.'% full!!!" align="middle" />';
				break;
			}

if ($SitePot['value_i'] == $potsize) stderr('Site Pot is Full', 'Freeleech ends at: ' . get_date($SitePot['value_u'], 'DATE') . ' (' . mkprettytime($SitePot['value_u'] - TIME_NOW) . ' to go).');
$want_pot = (isset($_POST['want_pot']) ? (int)$_POST['want_pot'] : '');
/** Valid amounts can give **/
$pot_options = array(
    1 => 1,
    5 => 5,
    10 => 10,
    25 => 25,
    50 => 50,
    100 => 100,
    500 => 500,
    1000 => 1000,
    2500 => 2500,
    5000 => 5000,
    10000 => 10000,
    50000 => 50000
);
if ($want_pot && (isset($pot_options[$want_pot]))) {
    if ($CURUSER['seedbonus'] < $want_pot) stderr('Error', 'Not enough karma.');
    $give = ($SitePot['value_i'] + $want_pot);
    if ($give > $potsize) $want_pot = ($potsize - $SitePot['value_i']);
    if (($SitePot['value_i'] + $want_pot) != $potsize) {
        $Remaining = $potsize - $give;
        sql_query("UPDATE users SET seedbonus = seedbonus - " . sqlesc($want_pot) . " 
                     WHERE id = " . sqlesc($CURUSER['id'])) or sqlerr(__file__, __line__);
        $update['seedbonus_donator'] = ($CURUSER['seedbonus'] - $want_pot);
        //====Update the caches
        $mc1->begin_transaction('userstats_' . $CURUSER['id']);
        $mc1->update_row(false, array(
            'seedbonus' => $update['seedbonus_donator']
        ));
        $mc1->commit_transaction($INSTALLER09['expires']['u_stats']);
        $mc1->begin_transaction('user_stats_' . $CURUSER['id']);
        $mc1->update_row(false, array(
            'seedbonus' => $update['seedbonus_donator']
        ));
        $mc1->commit_transaction($INSTALLER09['expires']['curuser']);
        $mc1->delete_value('Sitepot_');
        write_log("Site Pot " . $CURUSER['username'] . " has donated " . $want_pot . " karma points to the site pot. {$Remaining} karma points remaining.");
        sql_query("UPDATE avps SET value_i = value_i + " . sqlesc($want_pot) . " 
                     WHERE arg = 'sitepot'") or sqlerr(__file__, __line__);
        $mc1->delete_value('site_pot_counter');
        /** shoutbox announce **/
        require_once (INCL_DIR . 'bbcode_functions.php');
        $msg = $CURUSER['username'] . " put " . $want_pot . " karma point" . ($want_pot > 1 ? 's' : '') . " into the site pot! * Only [b]" . $Remaining . "[/b] more karma point" . ($Remaining > 1 ? 's' : '') . " to go! * [color=green][b]Site Pot:[/b][/color] [url={$INSTALLER09['baseurl']}/sitepot.php]" . $give . "/" . $potsize . '[/url]';
        $mc1->delete_value('shoutbox_');
        autoshout($msg);
        header('Location: sitepot.php');
        die();
    } elseif (($SitePot['value_i'] + $want_pot) == $potsize) {
        //$bonuscomment = gmdate("Y-m-d") . " - User has donated ".$want_pot." to the site pot.\n" . $CURUSER["modcomment"];
        //sql_query("UPDATE users SET seedbonus = seedbonus - ".sqlesc($want_pot).", bonuscomment = concat(".sqlesc($bonuscomment).", bonuscomment) WHERE id = ".sqlesc($CURUSER['id'])."") or sqlerr(__FILE__, __LINE__);
        sql_query("UPDATE users SET seedbonus = seedbonus - " . sqlesc($want_pot) . " 
                     WHERE id = " . sqlesc($CURUSER['id']) . "") or sqlerr(__file__, __line__);
        $update['seedbonus_donator'] = ($CURUSER['seedbonus'] - $want_pot);
        //====Update the caches
        $mc1->begin_transaction('userstats_' . $CURUSER['id']);
        $mc1->update_row(false, array(
            'seedbonus' => $update['seedbonus_donator']
        ));
        $mc1->commit_transaction($INSTALLER09['expires']['u_stats']);
        $mc1->begin_transaction('user_stats_' . $CURUSER['id']);
        $mc1->update_row(false, array(
            'seedbonus' => $update['seedbonus_donator']
        ));
        $mc1->commit_transaction($INSTALLER09['expires']['curuser']);
        $mc1->delete_value('Sitepot_');
        
        write_log("Site Pot " . $CURUSER['username'] . " has donated " . $want_pot . " karma points to the site pot.");
        sql_query("UPDATE avps SET value_i = value_i + " . sqlesc($want_pot) . ", 
                     value_u = '" . (86400 + TIME_NOW) . "', 
                     value_s = '1' WHERE arg = 'sitepot'") or sqlerr(__file__, __line__);
        $mc1->delete_value('site_pot_counter');
        write_log("24 HR FREELEECH is now active! It was started on " . get_date(TIME_NOW, 'DATE') . ".");
        /** shoutbox announce **/
        require_once (INCL_DIR . 'bbcode_functions.php');
        $res = sql_query("SELECT value_u FROM avps WHERE arg = 'sitepot'") or sqlerr(__file__, __line__);
        $arr = mysqli_fetch_array($res);
        $msg = " [color=green][b]24 HR FREELEECH[/b][/color] is now active! It will end at " . get_date($arr['value_u'], 'DATE') . ".";
        $mc1->delete_value('shoutbox_');
        autoshout($msg);
        header('Location: sitepot.php');
        die();
    } else stderr('Error', 'Something strange happened, reload the page and try again.');
}
$HTMLOUT = '';
$HTMLOUT.= "<table class='table table-bordered'>

    
 <tr><td align='center' colspan='3'><br />
      {$image_to_use}<br /></td></tr>
      <tr><td align='center' colspan='3'>Once the Site Pot has <b>" . $potsize . "</b> karma points, 
      Freeleech will be turned on for everybody for 24 hours. 
      <p align='center'><font size='+1'>
      <b>Site Pot: " . $SitePot['value_i'] . "/" . $potsize . "</b>
      </font></p>You have <b>" . round($CURUSER['seedbonus'], 1) . "</b> karma points.<br />
      </td></tr>";
$HTMLOUT.= '<tr><td><b>Description</b></td><td><b>Amount</b></td><td><b>Exchange</b></td></tr>';
foreach ($pot_options as $Pot_option) {
    if (($CURUSER['seedbonus'] < $Pot_option)) {
        $disabled = 'true';
    } else {
        $disabled = 'false';
    }
    $HTMLOUT.= "<tr><td><b>Contribute " . $Pot_option . " Karma Points</b><br /></td>
          <td><strong>" . $Pot_option . "</strong></td>
          <td>
          <form action='' method='post'>
    
   	      <div class=\"buttons\">
	      <input name='want_pot' type='hidden' value='" . $Pot_option . "' />
          <button value='Exchange!' " . ($disabled == 'true' ? "disabled='disabled'" : '') . " type=\"submit\" class=\"positive\">
          <img src=\"pic/aff_tick.gif\" alt=\"\" /> Exchange!
          </button>
          </div>

          </form>
          </td>
          </tr>";
}
$HTMLOUT.= '</table>';
echo stdhead('Site Pot') . $HTMLOUT . stdfoot();
?>
