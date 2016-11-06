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
if (!defined('IN_INSTALLER09_ADMIN')) {
    $HTMLOUT = '';
    $HTMLOUT.= "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\"
\"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">
<html xmlns='http://www.w3.org/1999/xhtml'>
<head>
<title>Error!</title>
</head>
<body>
<div style='font-size:33px;color:white;background-color:red;text-align:center;'>Incorrect access<br />You cannot access this file directly.</div>
</body></html>";
    echo $HTMLOUT;
    exit();
}
require_once (CLASS_DIR . 'class_check.php');
class_check(UC_MAX);
/* add your ids to this check*/
/*
$allowed_ids = array(1);
if (!in_array($CURUSER['id'], $allowed_ids))
    stderr($lang['sitesettings_stderr'], $lang['sitesettings_stderr1']);
*/
$lang = array_merge($lang, load_language('ad_sitesettings'));
//$update = '';
//get the config from db
$pconf = sql_query('SELECT * FROM site_config') or sqlerr(__FILE__, __LINE__);
while ($ac = mysqli_fetch_assoc($pconf)) $site_settings[$ac['name']] = $ac['value'];
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $update = array();
    //can't be 0
    /*
    foreach(array('site_online'>0,'autoshout_on'>0,'seedbonus_on'>0,'forums_online'>0,'maxusers'>0,'invites'>0,'failedlogins'>0, 'totalneeded'>0) as $key=>$type) {
     if(isset($_POST[$key]) && ($type == 0 && $_POST[$key] == 0 || $type == 0 && count($_POST[$key]) == 0))
     stderr($lang['sitesettings_stderr'], $lang['sitesettings_stderr2']);
    }
    */
    foreach ($site_settings as $c_name => $c_value) if (isset($_POST[$c_name]) && $_POST[$c_name] != $c_value) $update[] = '(' . sqlesc($c_name) . ',' . sqlesc(is_array($_POST[$c_name]) ? join('|', $_POST[$c_name]) : $_POST[$c_name]) . ')';
    if (sql_query('INSERT INTO site_config(name,value) VALUES ' . join(',', $update) . ' ON DUPLICATE KEY update value=values(value)')) {
        $t = '$INSTALLER09';
        $configfile = "<" . "?php\n/**\n{$lang['sitesettings_file']}" . date('M d Y H:i:s') . ".\n{$lang['sitesettings_cfg']}\n**/\n";
        $res = sql_query("SELECT * from site_config ");
        while ($arr = mysqli_fetch_assoc($res)) {
            $configfile.= "" . $t . "['$arr[name]'] = $arr[value];\n";
        }
        $configfile.= "?" . ">";
        $filenum = fopen('./cache/site_settings.php', 'w');
        ftruncate($filenum, 0);
        fwrite($filenum, $configfile);
        fclose($filenum);
        stderr($lang['sitesettings_success'], $lang['sitesettings_success1']);
    } else stderr($lang['sitesettings_stderr'], $lang['sitesettings_stderr3']);
    exit;
}
$HTMLOUT.= "<div class='row'><div class='col-md-12'>";
$HTMLOUT.= "<h3>{$lang['sitesettings_sitehead']}</h3>
<form action='staffpanel.php?tool=site_settings' method='post'>
<table class='table table-bordered'>";
if ($CURUSER['id'] === 1) 
$HTMLOUT.= "<tr><td width='50%'>{$lang['sitesettings_online']}</td><td>{$lang['sitesettings_yes']}<input type='radio' name='site_online' value='1' " . ($site_settings['site_online'] ? 'checked=\'checked\'' : '') . " />{$lang['sitesettings_no']}<input type='radio' name='site_online' value='0' " . (!$site_settings['site_online'] ? 'checked=\'checked\'' : '') . " /></td></tr>";
$HTMLOUT.= "
<tr><td width='50%'>{$lang['sitesettings_autoshout']}</td><td>{$lang['sitesettings_yes']}<input type='radio' name='autoshout_on' value='1' " . ($site_settings['autoshout_on'] ? 'checked=\'checked\'' : '') . " />{$lang['sitesettings_no']}<input type='radio' name='autoshout_on' value='0' " . (!$site_settings['autoshout_on'] ? 'checked=\'checked\'' : '') . " /></td></tr>
<tr><td width='50%'>{$lang['sitesettings_seedbonus']}</td><td>{$lang['sitesettings_yes']}<input type='radio' name='seedbonus_on' value='1' " . ($site_settings['seedbonus_on'] ? 'checked=\'checked\'' : '') . " />{$lang['sitesettings_no']}<input type='radio' name='seedbonus_on' value='0' " . (!$site_settings['seedbonus_on'] ? 'checked=\'checked\'' : '') . " /></td></tr>
<tr><td width='50%'>{$lang['sitesettings_bpdur']}</td><td><input type='text' class='form-control' name='bonus_per_duration' size='3' value='" . htmlsafechars($site_settings['bonus_per_duration']) . "' /></td></tr>
<tr><td width='50%'>{$lang['sitesettings_bpdload']}</td><td><input type='text' class='form-control' name='bonus_per_download' size='3' value='" . htmlsafechars($site_settings['bonus_per_download']) . "' /></td></tr>
<tr><td width='50%'>{$lang['sitesettings_bpcomm']}</td><td><input type='text' class='form-control' name='bonus_per_comment' size='3' value='" . htmlsafechars($site_settings['bonus_per_comment']) . "' /></td></tr>
<tr><td width='50%'>{$lang['sitesettings_bpupload']}</td><td><input type='text' class='form-control' name='bonus_per_upload' size='3' value='" . htmlsafechars($site_settings['bonus_per_upload']) . "' /></td></tr>
<tr><td width='50%'>{$lang['sitesettings_bprate']}</td><td><input type='text' class='form-control' name='bonus_per_rating' size='3' value='" . htmlsafechars($site_settings['bonus_per_rating']) . "' /></td></tr>
<tr><td width='50%'>{$lang['sitesettings_bptopic']}</td><td><input type='text' class='form-control' name='bonus_per_topic' size='3' value='" . htmlsafechars($site_settings['bonus_per_topic']) . "' /></td></tr>
<tr><td width='50%'>{$lang['sitesettings_bppost']}</td><td><input type='text' class='form-control' name='bonus_per_post' size='3' value='" . htmlsafechars($site_settings['bonus_per_post']) . "' /></td></tr>
<tr><td width='50%'>{$lang['sitesettings_bpdel']}</td><td><input type='text' class='form-control' name='bonus_per_delete' size='3' value='" . htmlsafechars($site_settings['bonus_per_delete']) . "' /></td></tr>
<tr><td width='50%'>{$lang['sitesettings_bptnk']}</td><td><input type='text' class='form-control' name='bonus_per_thanks' size='3' value='" . htmlsafechars($site_settings['bonus_per_thanks']) . "' /></td></tr>
<tr><td width='50%'>{$lang['sitesettings_bprsd']}</td><td><input type='text' class='form-control' name='bonus_per_reseed' size='3' value='" . htmlsafechars($site_settings['bonus_per_reseed']) . "' /></td></tr>
<tr><td width='50%'>{$lang['sitesettings_forums']}</td><td>{$lang['sitesettings_yes']}<input type='radio' name='forums_online' value='1' " . ($site_settings['forums_online'] ? 'checked=\'checked\'' : '') . " />{$lang['sitesettings_no']}<input type='radio' name='forums_online' value='0' " . (!$site_settings['forums_online'] ? 'checked=\'checked\'' : '') . " /></td></tr>
<tr><td width='50%'>{$lang['sitesettings_openreg']}</td><td><input type='text' class='form-control' name='openreg' size='2' value='" . htmlsafechars($site_settings['openreg']) . "' /></td></tr>
<tr><td width='50%'>{$lang['sitesettings_openinvite']}</td><td><input type='text' class='form-control' name='openreg_invites' size='2' value='" . htmlsafechars($site_settings['openreg_invites']) . "' /></td></tr>
<tr><td width='50%'>{$lang['sitesettings_maxusers']}</td><td><input type='text' class='form-control' name='maxusers' size='2' value='" . htmlsafechars($site_settings['maxusers']) . "' /></td></tr>
<tr><td width='50%'>{$lang['sitesettings_maxinvite']}</td><td><input type='text' class='form-control' name='invites' size='2' value='" . htmlsafechars($site_settings['invites']) . "' /></td></tr>
<tr><td width='50%'>{$lang['sitesettings_maxlogins']}</td><td><input type='text' class='form-control' name='failedlogins' size='2' value='" . htmlsafechars($site_settings['failedlogins']) . "' /></td></tr>
<tr><td width='50%'>{$lang['sitesettings_ratio']}</td><td><input type='text' class='form-control' name='ratio_free' size='2' value='" . htmlsafechars($site_settings['ratio_free']) . "' /></td></tr>
<tr><td width='50%'>{$lang['sitesettings_captcha']}</td><td><input type='text' class='form-control' name='captcha_on' size='2' value='" . htmlsafechars($site_settings['captcha_on']) . "' /></td></tr>
<tr><td width='50%'>{$lang['sitesettings_dupe']}</td><td><input type='text' class='form-control' name='dupeip_check_on' size='2' value='" . htmlsafechars($site_settings['dupeip_check_on']) . "' /></td></tr>
<tr><td width='50%'>{$lang['sitesettings_donation']}</td><td><input type='text' class='form-control' name='totalneeded' size='2' value='" . htmlsafechars($site_settings['totalneeded']) . "' /></td></tr>
<tr><td colspan='2' class='table' align='center'><input class='btn btn-default' type='submit' value='{$lang['sitesettings_apply']}' /></td></tr>
</table></form>";
$HTMLOUT.= "</div></div>";
echo stdhead($lang['sitesettings_stdhead']) . $HTMLOUT . stdfoot();
?>
