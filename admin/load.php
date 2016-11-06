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
require_once (INCL_DIR . 'user_functions.php');
require_once (CLASS_DIR . 'class_check.php');
$class = get_access(basename($_SERVER['REQUEST_URI']));
class_check($class);
$lang = array_merge($lang, load_language('ad_index'));
$HTMLOUT = '';
define("INTERVAL_1_MIN", 0); // load average for last 1 minute
define("INTERVAL_5_MIN", 1); // load average for last 5 minute
define("INTERVAL_15_MIN", 2); //  load average for last 15 minute
define("DEFAULT_AVG", INTERVAL_15_MIN); // selects which load average to return by default if no parameters are passed
function is_s($n)
{
	global $lang;
    if ($n == 1) {
        return "";
    } else {
        return $lang['index_load_s'];
    }
}
function uptime()
{
	global $lang;
    $res = "";
    $filename = "/proc/uptime";
    $fd = fopen($filename, "r");
    if ($fd === false) {
        $res = $lang['index_load_uptime'];
    } else {
        $uptime = fgets($fd, 64);
        fclose($fd);
        $mults = array(
            4 => $lang['index_load_month'],
            7 => $lang['index_load_week'],
            24 => $lang['index_load_day'],
            60 => $lang['index_load_hour'],
            1 => $lang['index_load_minute']
        );
        $n = 2419200;
        $periods = array();
        $shown = false;
        $uptime = substr($uptime, 0, strpos($uptime, " "));
        $res = "";
        while (list($k, $v) = each($mults)) {
            $nmbr = floor($uptime / $n);
            $uptime-= ($nmbr * $n);
            $n = $n / $k;
            if ($nmbr) {
                if ($shown) $res.= ", ";
                $res.= "$nmbr $v" . is_s($nmbr);
                $shown = true;
            }
        }
        if (!$shown) {
            $res.= "less than one minute";
        }
    }
    return $res;
}
function loadavg($return_all = false)
{
	global $lang;
    $res = "";
    $filename = "/proc/loadavg";
    $fd = fopen($filename, "r");
    if ($fd === false) {
        $res = $lang['index_load_average'];
    } else {
        $loadavg = fgets($fd, 64);
        fclose($fd);
        $loadavg = explode(" ", $loadavg);
        if ($return_all) {
            $res["last1"] = $loadavg[INTERVAL_1_MIN];
            $res["last5"] = $loadavg[INTERVAL_5_MIN];
            $res["last15"] = $loadavg[INTERVAL_15_MIN];
            $active = explode("/", $loadavg[3]);
            $res["tasks"] = $active[0];
            $res["processes"] = $active[1];
            $res["lastpid"] = $loadavg[4];
        } else {
            $res = $loadavg[DEFAULT_AVG];
        }
    }
    return $res;
}
/*
    //==Windows Server Load
    $HTMLOUT .="
    <div class='row'><div class='col-md-12'><h2>{$lang['index_serverload']}</h2>
    <br />
    <table class='table table-bordered'>
		<tr><td align='center'>
		<table class='table table-bordered'>
    <tr><td style='padding: 0px; background-image: url({$INSTALLER09['pic_base_url']}loadbarbg.gif); background-repeat: repeat-x'>";
    $perc = get_server_load();
    $percent = min(100, $perc);
    if ($percent <= 70) $pic = "loadbargreen.gif";
    elseif ($percent <= 90) $pic = "loadbaryellow.gif";
    else $pic = "loadbarred.gif";
    $width = $percent * 4;
    $HTMLOUT .="<img height='15' width='$width' src=\"{$INSTALLER09['pic_base_url']}{$pic}\" alt='$percent&#37;' /><br />{$lang['index_load_curr']}{$percent}{$lang['index_load_cpu']}<br /></td></tr></table></td></tr></table></div><br />";
    //==End
*/
//==Server Load linux
$HTMLOUT.= "
     <div class='row'><div class='col-md-12'><h2>{$lang['index_serverload']}</h2>
    <br />
    <table class='table table-bordered'>
			<tr><td align='center'>
		    <table class='table table-bordered'>
    			<tr><td style='padding: 0px; background-image: url({$INSTALLER09['pic_base_url']}loadbarbg.gif); background-repeat: repeat-x'>";
$percent = min(100, round(exec('ps ax | grep -c apache') / 256 * 100));
if ($percent <= 70) $pic = "loadbargreen.gif";
elseif ($percent <= 90) $pic = "loadbaryellow.gif";
else $pic = "loadbarred.gif";
$width = $percent * 4;
$HTMLOUT.= "<img height='15' width='$width' src=\"{$INSTALLER09['pic_base_url']}{$pic}\" alt='$percent&#37;' /><br />{$lang['index_load_curr']}{$percent}{$lang['index_load_cpu']}<br />";
//==End graphic
$HTMLOUT.= "{$lang['index_load_uptime1']}" . uptime() . "";
$loadinfo = loadavg(true);
$HTMLOUT.= "<br />
    {$lang['index_load_pastmin']}" . $loadinfo["last1"] . "<br />
    {$lang['index_load_pastmin5']}" . $loadinfo["last5"] . "<br />
    {$lang['index_load_pastmin15']}" . $loadinfo["last15"] . "<br />
    {$lang['index_load_numtsk']}" . $loadinfo["tasks"] . "<br />
    {$lang['index_load_numproc']}" . $loadinfo["processes"] . "<br />
   {$lang['index_load_pid']}" . $loadinfo["lastpid"] . "<br />
    </td></tr></table></td></tr></table></div></div><br />";
//==End

echo stdhead($lang['index_serverload']) . $HTMLOUT . stdfoot();
?>
