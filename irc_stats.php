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
$hash = "YXBwemZhbg";
$_hash = isset($_GET["hash"]) ? $_GET["hash"] : "";
$_user = isset($_GET["u"]) ? htmlspecialchars($_GET["u"]) : "";
$valid_do = array(
    "stats",
    "torrents",
    "fls",
    "irc",
    "top_idle",
    "top_uploaders",
    "top_posters",
    "top_torrents"
);
$_do = isset($_GET["do"]) && in_array($_GET["do"], $valid_do) ? $_GET["do"] : "";
function calctime($val)
{
    $days = intval($val / 86400);
    $val-= $days * 86400;
    $hours = intval($val / 3600);
    $val-= $hours * 3600;
    $mins = intval($val / 60);
    $secs = $val - ($mins * 60);
    return "$days days, $hours hrs, $mins minutes";
}
if (substr($_do, 0, 3) == "top") {
    $_type = end(explode("_", $_do));
    $_do = "top";
}
//$_hash = "YXBwemZhbg";
if ($_hash === $hash) {
    require_once (__DIR__ . DIRECTORY_SEPARATOR . 'include' . DIRECTORY_SEPARATOR . 'bittorrent.php');
    dbconn(false, false);
    if (empty($_user) && ($_do == "stats" || $_do == "torrents" || $_do == "irc")) exit("Can't find the username");
    if ($_do == "stats") {
        $q = sql_query("SELECT id, username, last_access, downloaded, uploaded, added, status, warned, disable_reason, warn_reason FROM users WHERE username = " . sqlesc($_user)) or exit(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
        if (mysqli_num_rows($q) == 1) {
            $a = mysqli_fetch_assoc($q);
            $txt = $a["username"] . " is " . ((TIME_NOW - $a["last_access"]) < 300 ? "online" : "offline") . "\nJoined - " . get_date($a["added"], 'LONG', 0, 1) . "\nLast seen - " . get_date($a["last_access"], 'DATE', 0, 1) . "\nDownloaded - " . mksize($a["downloaded"]) . "\nUploaded - " . mksize($a["uploaded"]) . "\n";
            if ($a["status"] == "disabled") $txt.= "This user is disabled. Reason " . $a["disable_reason"] . "\n";
            if ($a["warned"] == "yes") $txt.= "This user is warned. Reason " . $a["warn_reason"] . "\n";
            $txt.= $INSTALLER09['baseurl'] . "/userdetails.php?id=" . $a["id"];
            echo ($txt);
        } else exit("User \"" . $_user . "\" not found!");
        unset($txt);
        unset($a);
        unset($q);
    } elseif ($_do == "torrents") {
        $q = sql_query("SELECT count(p.id) as count, p.seeder,p.agent,p.port,p.connectable, u.username FROM peers as p LEFT JOIN users as u ON u.id = p.userid WHERE u.username=" . sqlesc($_user) . " GROUP BY p.seeder") or exit(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
        if (mysqli_num_rows($q) == 0) exit("User \"" . $_user . "\"  has no torrent active");
        $act['seed'] = $act['leech'] = 0;
        while ($a = mysqli_fetch_assoc($q)) {
            $key = ($a["seeder"] == "yes" ? "seed" : "leech");
            $act[$key] = $a["count"];
            $agent = $a["agent"];
            $port = $a["port"];
            $con = $a["connectable"];
            $user = $a["username"];
        }
        $txt = $user . " is " . ($con == "yes" ? "connectable" : "not connectable") . "\nActive torrents\n seeding - " . number_format($act["seed"]) . " | leeching - " . number_format($act["leech"]) . "\nAgent - " . $agent . " | Port - " . $port;
        echo ($txt);
        unset($txt);
        unset($a);
        unset($q);
    } elseif ($_do == "fls") {
        $q = sql_query("SELECT id,username,last_access ,supportfor FROM users WHERE support = 'yes' ORDER BY added desc") or exit(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
        $txt = "";
        while ($a = mysqli_fetch_assoc($q)) {
            $txt.= $a["username"] . " - status " . ((TIME_NOW - $a["last_access"]) < 300 ? "online" : "offline") . " | Support for " . $a["supportfor"] . "\n";
            unset($support);
        }
        echo ($txt);
        unset($_fls);
        unset($a);
        unset($q);
        unset($txt);
    } elseif ($_do == "irc") {
        $q = sql_query("SELECT onirc, irctotal,username FROM users WHERE username = " . sqlesc($_user)) or exit(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
        if (mysqli_num_rows($q) == 0) exit("User \"" . $_user . "\" not found!");
        $a = mysqli_fetch_assoc($q);
        $txt = $a["username"] . " " . ($a["irctotal"] == 0 ? "never been on irc" : "has idled on irc " . calctime($a["irctotal"])) . "\nAnd now he " . ($a["onirc"] == "yes" ? "is" : "isn't") . " on irc";
        echo ($txt);
        unset($a);
        unset($q);
        unset($txt);
    } elseif ($_do == "top") {
        switch ($_type) {
        case "idle":
            $_q = "select username,irctotal FROM users ORDER BY irctotal DESC LIMIT 10";
            $txt = "Top 10 idle\n";
            break;

        case "uploaders":
            $_q = "select username, uploaded FROM users WHERE status = 'confirmed' ORDER BY uploaded DESC LIMIT 10";
            $txt = "Best uploaders (selected after uploaded amount)\n";
            break;

        case "torrents":
            $_q = "select count(t.id) as c, u.username FROM torrents as t LEFT JOIN users as u ON t.owner = u.id WHERE u.username <> '' GROUP  BY u.id ORDER BY c DESC LIMIT 10";
            $txt = "Best uploaders (selected after the torrents uploaded)\n";
            break;

        case "posters":
            $_q = "select count(p.id) as c, u.username FROM posts as p LEFT JOIN users as u ON p.user_id = u.id WHERE u.username <> '' GROUP  BY u.id ORDER BY c DESC LIMIT 10";
            $txt = "Best posters (selected after number of posts)\n";
            break;
        }
        $i = 1;
        $q = sql_query($_q) or exit(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
        while ($a = mysqli_fetch_assoc($q)) {
            $txt.= $i . " - " . $a["username"] . " with " . ($_type == "idle" ? calctime($a["irctotal"]) . " idle" : ($_type == "uploaders" ? mksize($a["uploaded"]) . " uploaded" : ($_type == "torrents" ? $a["c"] . " torrents" : $a["c"] . " posts"))) . "\n";
            $i++;
        }
        echo $txt;
        unset($a);
        unset($q);
        unset($txt);
    }
}
?>
