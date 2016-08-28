<?php
/**
 |--------------------------------------------------------------------------|
 |   https://github.com/Bigjoos/                			    |
 |--------------------------------------------------------------------------|
 |   Licence Info: GPL			                                    |
 |--------------------------------------------------------------------------|
 |   Copyright (C) 2010 U-232 V5					    |
 |--------------------------------------------------------------------------|
 |   A bittorrent tracker source based on TBDev.net/tbsource/bytemonsoon.   |
 |--------------------------------------------------------------------------|
 |   Project Leaders: Mindless, Autotron, whocares, Swizzles.					    |
 |--------------------------------------------------------------------------|
  _   _   _   _   _     _   _   _   _   _   _     _   _   _   _
 / \ / \ / \ / \ / \   / \ / \ / \ / \ / \ / \   / \ / \ / \ / \
( U | - | 2 | 3 | 2 )-( S | o | u | r | c | e )-( C | o | d | e )
 \_/ \_/ \_/ \_/ \_/   \_/ \_/ \_/ \_/ \_/ \_/   \_/ \_/ \_/ \_/
 */
require_once (__DIR__ . DIRECTORY_SEPARATOR . 'include' . DIRECTORY_SEPARATOR . 'bittorrent.php');
require_once (INCL_DIR . 'user_functions.php');
require_once (CACHE_DIR . 'timezones.php');
require_once (CLASS_DIR . 'page_verify.php');
dbconn();
global $CURUSER;
if (!$CURUSER) {
    get_template();
}
$stdfoot = array(
    /** include js **/
    'js' => array(
        'check',
        'jquery.pstrength-min.1.2',
        'jquery.simpleCaptcha-0.2'
    )
);
$lang = array_merge(load_language('global') , load_language('signup'));
$newpage = new page_verifys();
$newpage->create('tkIs');
$res = sql_query("SELECT COUNT(*) FROM users") or sqlerr(__FILE__, __LINE__);
$arr = mysqli_fetch_row($res);
if ($arr[0] >= $INSTALLER09['invites']) stderr("Sorry", "The current user account limit (" . number_format($INSTALLER09['invites']) . ") has been reached. Inactive accounts are pruned all the time, please check back again later...");
if (!$INSTALLER09['openreg_invites']) stderr('Sorry', 'Invite Signups are closed presently');
//==timezone select
$offset = (string)$INSTALLER09['time_offset'];
$time_select = "<div class='form-group'><div class='col-sm-10 col-sm-offset-1'><select class='form-control' name='user_timezone'>";
foreach ($TZ as $off => $words) {
    if (preg_match("/^time_(-?[\d\.]+)$/", $off, $match)) {
        $time_select.= $match[1] == $offset ? "<option value='{$match[1]}' selected='selected'>$words</option>\n" : "<option value='{$match[1]}'>$words</option>\n";
    }
}
$time_select.= "</select></div></div>";
$HTMLOUT = $year = $month = $day = '';
$HTMLOUT.= "
    <script type='text/javascript'>
    /*<![CDATA[*/
    $(function() {
    $('.password').pstrength();
    });
    /*]]>*/
    </script>";
// Normal Entry Point...
//== click X by Retro
$value = array(
    '...',
    '...',
    '...',
    '...',
    '...',
    '...'
);
$value[rand(1, count($value) - 1) ] = 'X';
$HTMLOUT.= "<script type='text/javascript'>
	  /*<![CDATA[*/
	  $(document).ready(function () {
	  $('#captchasignup').simpleCaptcha();
    });
    /*]]>*/
    </script>
<div style='width:75%; margin-left:12%;'>
    <form class='form-horizontal well' role='form' method='post' title='signup' action='{$INSTALLER09['baseurl']}/take_invite_signup.php'>
<div class='form-group'><div class='col-sm-10 col-sm-offset-1'><input  type='text' class='form-control'  placeholder='{$lang['signup_uname']}' name='wantusername' id='wantusername' onblur='checkit();'></div></div>
<div class='form-group'><div id='namecheck' class='col-sm-10 col-sm-offset-1'></div></div>
<div class='form-group'><div class='col-sm-10 col-sm-offset-1'><input class='form-control' type='password' placeholder='{$lang['signup_pass']}' name='wantpassword'></div></div>
<div class='form-group'><div class='col-sm-10 col-sm-offset-1'><input type='password' class='form-control' placeholder='{$lang['signup_passa']}' name='passagain'></div></div>
<div class='form-group'><div class='col-sm-10 col-sm-offset-1'><input type='text' class='form-control' placeholder='{$lang['signup_invcode']}' name='invite'></div></div>
<div class='form-group'><div class='col-sm-10 col-sm-offset-1'><input type='text' class='form-control' placeholder='{$lang['signup_email']}' name='email'></div></div>
<div class='form-group'><div class='col-sm-10 col-sm-offset-1'><span style='font-size: 1em;'>{$lang['signup_valemail']}</span></div></div>
<div class='form-group'><div class='col-sm-10 col-sm-offset-1'><label>{$lang['signup_timez']}</label></div></div>
<div class='form-group'><div class='col-sm-12'>{$time_select}</div></div>";
//==09 Birthday mod
$year.= "<div class='col-sm-3'><select class='form-control' id='sel1' name=\"year\">";
$year.= "<option value=\"0000\">{$lang['signup_year']}</option>";
$i = "2020";
while ($i >= 1950) {
    $year.= "<option value=\"" . $i . "\">" . $i . "</option>";
    $i--;
}
$year.= "</select></div>";
$month.= "<div class='col-sm-3'><select class='form-control' id='sel2' name=\"month\">
    <option value=\"00\">{$lang['signup_month']}</option>
    <option value=\"01\">{$lang['signup_jan']}</option>
    <option value=\"02\">{$lang['signup_feb']}</option>
    <option value=\"03\">{$lang['signup_mar']}</option>
    <option value=\"04\">{$lang['signup_apr']}</option>
    <option value=\"05\">{$lang['signup_may']}</option>
    <option value=\"06\">{$lang['signup_jun']}</option>
    <option value=\"07\">{$lang['signup_jul']}</option>
    <option value=\"08\">{$lang['signup_aug']}</option>
    <option value=\"09\">{$lang['signup_sep']}</option>
    <option value=\"10\">{$lang['signup_oct']}</option>
    <option value=\"11\">{$lang['signup_nov']}</option>
    <option value=\"12\">{$lang['signup_dec']}</option>
    </select></div>";
$day.= "<div class='col-sm-3'><select class='form-control' id='sel3' name=\"day\">";
$day.= "<option value=\"00\">{$lang['signup_day']}</option>";
$i = 1;
while ($i <= 31) {
    if ($i < 10) {
        $day.= "<option value=\"0" . $i . "\">0" . $i . "</option>";
    } else {
        $day.= "<option value=\"" . $i . "\">" . $i . "</option>";
    }
    $i++;
}
$day.= "</select></div>";
$HTMLOUT.= "<div class='form-group'><div class='col-sm-10 col-sm-offset-1'>{$lang['signup_birth']}<span style='color:red'>*</span></div></div><div class='row'><div class='form-group'><div class='col-sm-12 col-sm-offset-1'>" . $year . $month . $day . "</div></div></div>";
//==End
//==Passhint
$passhint = "";
$questions = array(
    array(
        "id" => "1",
        "question" => "{$lang['signup_q1']}"
    ) ,
    array(
        "id" => "2",
        "question" => "{$lang['signup_q2']}"
    ) ,
    array(
        "id" => "3",
        "question" => "{$lang['signup_q3']}"
    ) ,
    array(
        "id" => "4",
        "question" => "{$lang['signup_q4']}"
    ) ,
    array(
        "id" => "5",
        "question" => "{$lang['signup_q5']}"
    ) ,
    array(
        "id" => "6",
        "question" => "{$lang['signup_q6']}"
    )
);
foreach ($questions as $sph) {
    $passhint.= "<option value='" . $sph['id'] . "'>" . $sph['question'] . "</option>\n";
}
$HTMLOUT.= "
<div class='form-group'><div class='col-sm-10 col-sm-offset-1'>{$lang['signup_select']}</div></div>
<div class='form-group'><div class='col-sm-10 col-sm-offset-1'><select class='form-control' name='passhint'>\n$passhint\n</select></div></div>
<div class='form-group'><div class='col-sm-10 col-sm-offset-1'><input type='text' class='form-control' placeholder='Enter&nbsp;Your&nbsp;Hint&nbsp;Answer&nbsp;Here.{$lang['signup_this_answer']}{$lang['signup_this_answer1']}' name='hintanswer'></div></div>
<div class='form-group'><div class='col-sm-10 col-sm-offset-4'>    
<div class='checkbox'><label><input type='checkbox' name='rulesverify' value='yes'> {$lang['signup_rules']}</label></div>
<div class='checkbox'><label><input type='checkbox' name='faqverify' value='yes'> {$lang['signup_faq']}</label></div>
<div class='checkbox'><label><input type='checkbox' name='ageverify' value='yes'> {$lang['signup_age']}</label></div>
</div></div>" . ($INSTALLER09['captcha_on'] ? "<div class='form-group'><div class='col-sm-10 col-sm-offset-1' id='captchasignup'></div></div>" : "") . "
<div class='form-group'><div class='col-sm-10 col-sm-offset-4'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$lang['signup_click']}<strong>{$lang['signup_x']}</strong>{$lang['signup_click1']}<br>";
for ($i = 0; $i < count($value); $i++) {
    $HTMLOUT.= "<div style='display:inline-block;width:15px;'></div><span><input name=\"submitme\" type=\"submit\" value=\"" . $value[$i] . "\" class=\"btn\"></span>";
}
$HTMLOUT.= "</div></div></form></div>";
echo stdhead('Invites') . $HTMLOUT . stdfoot($stdfoot);
?>
