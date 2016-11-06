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
require_once (INCL_DIR . 'bbcode_functions.php');
require_once (INCL_DIR . 'html_functions.php');
require_once (CACHE_DIR . 'paypal_settings.php');
dbconn(false);
loggedinorreturn();
$lang = array_merge(load_language('global'));
$nick = ($CURUSER ? $CURUSER["username"] : ("Guest" . rand(1000, 9999)));
$form_template = <<<PAYPAL
<form action='https://www.{$INSTALLER09['paypal_config']['sandbox']}paypal.com/cgi-bin/webscr' method='post'>
<input type='hidden' name='business' value='{$INSTALLER09['paypal_config']['email']}' />
<input type='hidden' name='cmd' value='_xclick' />
<input type='hidden' name='amount' value='#amount' />
<input type='hidden' name='item_name' value='#item_name' />
<input type='hidden' name='item_number' value='#item_number' />
<input type='hidden' name='currency_code' value='{$INSTALLER09['paypal_config']['currency']}' />
<input type='hidden' name='no_shipping' value='1' />
<input type='hidden' name='notify_url' value='{$INSTALLER09['baseurl']}/donatecheck.php' />
<input type='hidden' name='rm' value='2' />
<input type='hidden' name='custom' value='#id' />
<input type='hidden' name='return' value='{$INSTALLER09['baseurl']}/donate.php?done=1' />
<input type='submit' value='Donate #amount {$INSTALLER09['paypal_config']['currency']}' />
</form>
PAYPAL;
//this shows what they get
$donate = array(
    $INSTALLER09['paypal_config']['gb_donated_1'] => array(
        'ViP '.$INSTALLER09['paypal_config']['vip_dur_1'].' week',
        'Donor '.$INSTALLER09['paypal_config']['donor_dur_1'].' week',
        'Freeleech '.$INSTALLER09['paypal_config']['free_dur_1'].' wk',
        ''.$INSTALLER09['paypal_config']['up_amt_1'].'G upload',
        ''.$INSTALLER09['paypal_config']['kp_amt_1'].' bonus points',
        ''.$INSTALLER09['paypal_config']['inv_amt_1'].' invite',
        'Donor star '.$INSTALLER09['paypal_config']['duntil_dur_1'].' week',
        'Imunnity '.$INSTALLER09['paypal_config']['imm_dur_1'].' week'
    ) ,
    $INSTALLER09['paypal_config']['gb_donated_2'] => array(
        'ViP '.$INSTALLER09['paypal_config']['vip_dur_2'].' weeks',
        'Donor '.$INSTALLER09['paypal_config']['donor_dur_2'].' weeks',
        'Freeleech '.$INSTALLER09['paypal_config']['free_dur_2'].' wks',
        ''.$INSTALLER09['paypal_config']['up_amt_2'].'G upload',
        ''.$INSTALLER09['paypal_config']['kp_amt_2'].' bonus points',
        ''.$INSTALLER09['paypal_config']['inv_amt_2'].' invites',
        'Donor star '.$INSTALLER09['paypal_config']['duntil_dur_2'].' weeks',
        'Imunnity '.$INSTALLER09['paypal_config']['imm_dur_2'].' weeks'
    ) ,
    $INSTALLER09['paypal_config']['gb_donated_3'] => array(
        'ViP '.$INSTALLER09['paypal_config']['vip_dur_3'].' weeks',
        'Donor '.$INSTALLER09['paypal_config']['donor_dur_3'].' weeks',
        'Freeleech '.$INSTALLER09['paypal_config']['free_dur_3'].' wks',
        ''.$INSTALLER09['paypal_config']['up_amt_3'].'G upload',
        ''.$INSTALLER09['paypal_config']['kp_amt_3'].' bonus points',
        ''.$INSTALLER09['paypal_config']['inv_amt_3'].' invites',
        'Donor star '.$INSTALLER09['paypal_config']['duntil_dur_3'].' weeks',
        'Imunnity '.$INSTALLER09['paypal_config']['imm_dur_3'].' weeks'
    ) ,
    $INSTALLER09['paypal_config']['gb_donated_4'] => array(
        'ViP '.$INSTALLER09['paypal_config']['vip_dur_4'].' weeks',
        'Donor '.$INSTALLER09['paypal_config']['donor_dur_4'].' weeks',
        'Freeleech '.$INSTALLER09['paypal_config']['free_dur_4'].' wks',
        ''.$INSTALLER09['paypal_config']['up_amt_4'].'G upload',
        ''.$INSTALLER09['paypal_config']['kp_amt_4'].' bonus points',
        ''.$INSTALLER09['paypal_config']['inv_amt_4'].' invites',
        'Donor star '.$INSTALLER09['paypal_config']['duntil_dur_4'].' weeks',
        'Imunnity '.$INSTALLER09['paypal_config']['imm_dur_4'].' weeks'
    ) ,
    $INSTALLER09['paypal_config']['gb_donated_5'] => array(
        'ViP '.$INSTALLER09['paypal_config']['vip_dur_5'].' weeks',
        'Donor '.$INSTALLER09['paypal_config']['donor_dur_5'].' weeks',
        'Freeleech '.$INSTALLER09['paypal_config']['free_dur_5'].' wks',
        ''.$INSTALLER09['paypal_config']['up_amt_5'].'G upload',
        ''.$INSTALLER09['paypal_config']['kp_amt_5'].' bonus points',
        ''.$INSTALLER09['paypal_config']['inv_amt_5'].' invites',
        'Donor star '.$INSTALLER09['paypal_config']['duntil_dur_5'].' weeks',
        'Imunnity '.$INSTALLER09['paypal_config']['imm_dur_5'].' weeks'
    ) ,
    $INSTALLER09['paypal_config']['gb_donated_6'] => array(
        'ViP '.$INSTALLER09['paypal_config']['vip_dur_6'].' weeks',
        'Donor '.$INSTALLER09['paypal_config']['donor_dur_6'].' weeks',
        'Freeleech '.$INSTALLER09['paypal_config']['free_dur_6'].' wks',
        ''.$INSTALLER09['paypal_config']['up_amt_6'].'G upload',
        ''.$INSTALLER09['paypal_config']['kp_amt_6'].' bonus points',
        ''.$INSTALLER09['paypal_config']['inv_amt_6'].' invites',
        'Donor star '.$INSTALLER09['paypal_config']['duntil_dur_6'].' weeks',
        'Imunnity '.$INSTALLER09['paypal_config']['imm_dur_6'].' weeks'
    ) ,
);
$done = isset($_GET['done']) && $_GET['done'] == 1 ? true : false;
if ($INSTALLER09['paypal_config']['enable'] == 0 ) {
$out = stdmsg('Sorry','Donation system is currently offline.')."<br>";
} else {
$out = "<div class='row'><div class='col-md-12'>". ($done ? stdmsg('Success', 'Your donations was sent to paypal wait for processing, this should be immediately! If any errors appear youll be contacted by someone from staff') : '') . "<div class='row'><div class='col-md-12'><h2>Donate</h2>" . '<table class="table table-bordered"><tr>';
foreach ($donate as $amount => $ops) {
    $out.= '<td ><table class="table table-bordered">
			  <tr><td>Donate ' . $amount . ' ' . $INSTALLER09['paypal_config']['currency'] . '</td></tr>
			  <tr><td><ul style=\'margin-left: 0px;padding-left:15px\'>';
    foreach ($ops as $op) $out.= '<li>' . $op . '</li>';
    $out.= '</ul></td></tr><tr><td>' . str_replace(array(
        '#amount',
        '#item_name',
        '#item_number',
        '#id'
    ) , array(
        $amount,
        $nick,
        $amount,
        $CURUSER['id']
    ) , $form_template);
    $out.= '</td></tr></table></td>';
}
$out.= '</tr></table>' . "</div></div><div class='row'><div class='col-md-12'><h2>Note</h2>If you want to say something to " . $INSTALLER09['site_name'] . " staff, click on <b>Add special instructions to seller</b> link as soon as you are on paypal.com page. Please note donating will reset Hit and Runs, any warnings and download bans</div></div></div></div><br>";
}
echo (stdhead('Donate') . $out . stdfoot());
?>
