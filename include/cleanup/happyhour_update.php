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
function docleanup($data)
{
    global $INSTALLER09, $queries, $mc1;
    set_time_limit(0);
    ignore_user_abort(1);
    require_once (INCL_DIR . 'function_happyhour.php');
    //==Putyns HappyHour
    $f = $INSTALLER09['happyhour'];
    $happy = unserialize(file_get_contents($f));
    $happyHour = strtotime($happy["time"]);
    $curDate = TIME_NOW;
    $happyEnd = $happyHour + 3600;
    if ($happy["status"] == 0 && $INSTALLER09['happy_hour'] == true) {
        write_log("Happy hour was @ " . get_date($happyHour, 'LONG', 1, 0) . " and Catid " . $happy["catid"] . " ");
        happyFile("set");
    } elseif (($curDate > $happyEnd) && $happy["status"] == 1) happyFile("reset");
    //== End
    if ($queries > 0) write_log("Happyhour Clean -------------------- Happyhour cleanup Complete using $queries queries --------------------");
    if (false !== mysqli_affected_rows($GLOBALS["___mysqli_ston"])) {
        $data['clean_desc'] = mysqli_affected_rows($GLOBALS["___mysqli_ston"]) . " items deleted/updated";
    }
    if ($data['clean_log']) {
        cleanup_log($data);
    }
}
?>
