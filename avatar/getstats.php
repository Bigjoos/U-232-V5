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
require_once ($_SERVER["DOCUMENT_ROOT"] . "/include/bittorrent.php");
require_once ($_SERVER["DOCUMENT_ROOT"] . "/cache/country.php");
dbconn();
$_settings = $_SERVER["DOCUMENT_ROOT"] . "/avatar/settings/";
function calctime($val)
{
    $days = intval($val / 86400);
    $val-= $days * 86400;
    $hours = intval($val / 3600);
    $val-= $hours * 3600;
    $mins = intval($val / 60);
    $secs = $val - ($mins * 60);
    return "$days days,$hours hrs,$mins minutes";
}
function time_return($stamp)
{
    $ysecs = 365 * 24 * 60 * 60;
    $mosecs = 31 * 24 * 60 * 60;
    $wsecs = 7 * 24 * 60 * 60;
    $dsecs = 24 * 60 * 60;
    $hsecs = 60 * 60;
    $msecs = 60;
    $years = floor($stamp / $ysecs);
    $stamp%= $ysecs;
    $months = floor($stamp / $mosecs);
    $stamp%= $mosecs;
    $weeks = floor($stamp / $wsecs);
    $stamp%= $wsecs;
    $days = floor($stamp / $dsecs);
    $stamp%= $dsecs;
    $hours = floor($stamp / $hsecs);
    $stamp%= $hsecs;
    $minutes = floor($stamp / $msecs);
    $stamp%= $msecs;
    $seconds = $stamp;
    if ($years == 1) {
        $nicetime['years'] = "1 Year";
    } elseif ($years > 1) {
        $nicetime['years'] = $years . " Years";
    }
    if ($months == 1) {
        $nicetime['months'] = "1 Month";
    } elseif ($months > 1) {
        $nicetime['months'] = $months . " Months";
    }
    if ($weeks == 1) {
        $nicetime['weeks'] = "1 Week";
    } elseif ($weeks > 1) {
        $nicetime['weeks'] = $weeks . " Weeks";
    }
    if ($days == 1) {
        $nicetime['days'] = "1 Day";
    } elseif ($days > 1) {
        $nicetime['days'] = $days . " Day";
    }
    if ($hours == 1) {
        $nicetime['hours'] = "1 Hour";
    } elseif ($hours > 1) {
        $nicetime['hours'] = $hours . " Hours";
    }
    if ($minutes == 1) {
        $nicetime['minutes'] = "1 minute";
    } elseif ($minutes > 1) {
        $nicetime['minutes'] = $minutes . " Minutes";
    }
    if ($seconds == 1) {
        $nicetime['seconds'] = "1 second";
    } elseif ($seconds > 1) {
        $nicetime['seconds'] = $seconds . " Seconds";
    } elseif ($seconds == 0) {
        $nicetime['seconds'] = "No online time recorded";
    }
    if (is_array($nicetime)) {
        return implode(", ", $nicetime);
    }
}
function getStats($user, $forced = false)
{
    global $_settings, $countries;
    if (!file_exists($_settings . $user . ".set") || !is_array($var = unserialize(file_get_contents($_settings . $user . ".set")))) return false;
    $query = sql_query("SELECT u.id, u.irctotal, u.last_login, u.onlinetime, u.reputation, u.hits, u.uploaded, u.downloaded, u.country, u.browser, count(p.id) as posts ,count(c.id) as comments FROM users as u LEFT JOIN posts as p ON u.id = p.user_id LEFT JOIN comments as c ON c.user = u.id WHERE u.username = " . sqlesc($user) . " GROUP BY u.id") or sqlerr(__FILE__, __LINE__); //or die('Error Error Error! 1');
    if (mysqli_num_rows($query) != 1) die('Error Error Error! 2');
    $a = mysqli_fetch_assoc($query);
    $ops = array(
        $var['line1']['value'],
        $var['line2']['value'],
        $var['line3']['value']
    );
    $i = 1;
    foreach ($ops as $op) {
        switch ($op) {
        case 1:
            $var['line' . $i]['value_p'] = $a['posts'] . " post" . ($a['posts'] > 1 ? "s" : "");
            break;

        case 2:
            //$var['line'.$i]['value_p'] = mksize($a['downloaded']) . " - " . mksize($a['uploaded']);
            $var['line' . $i]['value_p'] = mksize($a['downloaded']) . " - " . mksize($a['uploaded']);
            break;

        case 3:
            list($days, $hours, $mins) = explode(",", calctime($a['irctotal']));
            $var['line' . $i]['value_p'] = "$days - $hours";
            //$var['line'.$i]['value_p'] = "not yet";
            break;

        case 4:
            $var['line' . $i]['value_p'] = $a['reputation'] . " point" . ($a['reputation'] > 1 ? "s" : "");
            break;

        case 5:
            foreach ($countries as $c) if ($c['id'] == $a['country']) $var['line' . $i]['value_p'] = $c;
            break;

        case 6:
            $var['line' . $i]['value_p'] = $a['comments'] . " comment" . ($a['comments'] > 1 ? "s" : "");
            break;

        case 7:
            $var['line' . $i]['value_p'] = $a['browser'];
            break;

        case 8:
            $var['line' . $i]['value_p'] = $a['hits'] . " hit" . ($a['hits'] > 1 ? "s" : "");
            break;
            /*
                  case 9:
                      $lapsetime = ((($lapsetime = time() - sql_timestamp_to_unix_timestamp($a["last_login"])) / 3600) % 24) . ' h ' . (($lapsetime / 60) % 60) . ' min ' . ($lapsetime % 60) . ' s';
                      $var['line'.$i]['value_p'] = $lapsetime;
                      break;
            */
        case 9:
            $var['line' . $i]['value_p'] = time_return($a['onlinetime']);
            break;
        }
        $i++;
    }
    if (is_writable($_settings . $user . ".set")) file_put_contents($_settings . $user . ".set", serialize($var));
    else exit("Can't write user setting");
    if (file_exists($_settings . $user . ".png")) unlink($_settings . $user . ".png");
    return $var;
}
?>
