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
//made by putyn @tbdev 06.11.2008
//==09 Edits
function happyHour($action)
{
    global $INSTALLER09;
    //generate happy hour
    if ($action == "generate") {
        $nextDay = date("Y-m-d", TIME_NOW + 86400);
        $nextHoura = mt_rand(0, 2);
        if ($nextHoura == 2) $nextHourb = mt_rand(0, 3);
        else $nextHourb = mt_rand(0, 9);
        $nextHour = $nextHoura . $nextHourb;
        $nextMina = mt_rand(0, 5);
        $nextMinb = mt_rand(0, 9);
        $nextMin = $nextMina . $nextMinb;
        $happyHour = $nextDay . " " . $nextHour . ":" . $nextMin . "";
        return $happyHour;
    }
    $file = $INSTALLER09['happyhour'];
    $happy = unserialize(file_get_contents($file));
    $happyHour = strtotime($happy["time"]);
    $happyDate = $happyHour;
    $curDate = TIME_NOW;
    $nextDate = $happyHour + 3600;
    //action check
    if ($action == "check") {
        if ($happyDate < $curDate && $nextDate >= $curDate) return true;
    }
    //action time left
    if ($action == "time") {
        $timeLeft = mkprettytime(($happyHour + 3600) - TIME_NOW);
        $timeLeft = explode(":", $timeLeft);
        $time = ($timeLeft[0] . " min : " . $timeLeft[1] . " sec");
        return $time;
    }
    //this will set all torrent free or just one category
    if ($action == "todo") {
        $act = rand(1, 2);
        if ($act == 1) $todo = 255; // this will mean that all the torrent are free
        elseif ($act == 2) $todo = rand(1, 14); // only one cat will be free || remember to change the number of categories i have 14 but you may have more
        return $todo;
    }
    //this will generate the multiplier so every torrent downloaded in the happy hour will have upload multiplied but this
    if ($action == "multiplier") {
        $multiplier = rand(11, 55) / 10; //max value of the multiplier will be 5,5 || you could change it to a higher or a lower value
        return $multiplier;
    }
}
function happyCheck($action, $id = NUll)
{
    global $INSTALLER09;
    $file = $INSTALLER09['happyhour'];
    $happy = unserialize(file_get_contents($file));
    $happycheck = $happy["catid"];
    if ($action == "check") return $happycheck;
    if ($action == "checkid" && (($happycheck == "255") || $happycheck == $id)) return true;
}
function happyFile($act)
{
    global $INSTALLER09;
    $file = $INSTALLER09['happyhour'];
    $happy = unserialize(file_get_contents($file));
    if ($act == "set") {
        $array_happy = array(
            'time' => happyHour("generate") ,
            'status' => '1',
            'catid' => happyHour("todo")
        );
    } elseif ($act == "reset") {
        $array_happy = array(
            'time' => $happy["time"],
            'status' => '0',
            'catid' => $happy["catid"]
        );
    }
    $array_happy = serialize($array_happy);
    $file = $INSTALLER09['happyhour'];
    $file = fopen($file, 'w');
    ftruncate($file, 0);
    fwrite($file, $array_happy);
    fclose($file);
}
function happyLog($userid, $torrentid, $multi)
{
    $time = sqlesc(TIME_NOW);
    sql_query("INSERT INTO happylog (userid, torrentid,multi, date) VALUES(".sqlesc($userid).", ".sqlesc($torrentid).", ".sqlesc($multi).", $time)") or sqlerr(__FILE__, __LINE__);
}
?>