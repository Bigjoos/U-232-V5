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
+------------------------------------------------
|   $Memcached shoutbox
|   $Author$ Bigjoos, pdq, putyn, snuggs
+------------------------------------------------
*/
require_once (__DIR__ . DIRECTORY_SEPARATOR . 'include' . DIRECTORY_SEPARATOR . 'bittorrent.php');
require_once (INCL_DIR . 'user_functions.php');
require_once (INCL_DIR . 'bbcode_functions.php');
require_once (CLASS_DIR . 'class_user_options.php');
dbconn(false);
loggedinorreturn();
global $lang;
$HTMLOUT = $query = $dellall = $dtcolor = $fontcolor = $bg = $pm = $reply = $Beeper = $ignore = '';
$lang = load_language('shoutbox');
$setbits = $clrbits = 0;
header('Content-Type: text/html; charset=' . charset());
// === added turn on / off shoutbox - snuggs/ updates by stillapunk
if ((isset($_GET['show_shout'])) && (($show_shout = $_GET['show']))) {
    $setbits = $clrbits = 0;
    if ($show_shout == 'yes' && !($CURUSER['opt1'] & user_options::SHOW_SHOUT)) {
        $setbits|= user_options::SHOW_SHOUT; // shout on

    } elseif ($show_shout == 'no' && ($CURUSER['opt1'] & user_options::SHOW_SHOUT)) {
        $clrbits|= user_options::SHOW_SHOUT; // shout off

    }
    if ($setbits || $clrbits) sql_query('UPDATE users SET opt1 = ((opt1 | ' . $setbits . ') & ~' . $clrbits . ')
                 WHERE id = ' . sqlesc($CURUSER['id'])) or sqlerr(__file__, __line__);
    $res = sql_query('SELECT id, username, opt1 FROM users
                     WHERE id = ' . sqlesc($CURUSER['id']) . ' LIMIT 1') or sqlerr(__file__, __line__);
    $row = mysqli_fetch_assoc($res);
    $row['opt1'] = (int)$row['opt1'];
    // update caches
    $mc1->begin_transaction('MyUser_' . $CURUSER['id']);
    $mc1->update_row(false, array(
        'opt1' => $row['opt1']
    ));
    $mc1->commit_transaction($INSTALLER09['expires']['user_cache']);
    $mc1->begin_transaction('user_' . $CURUSER['id']);
    $mc1->update_row(false, array(
        'opt1' => $row['opt1']
    ));
    $mc1->commit_transaction($INSTALLER09['expires']['user_cache']);
    header("Location:".$_SERVER['HTTP_REFERER']);
}

// Delete single shout
if (isset($_GET['del']) && $CURUSER['class'] >= UC_STAFF && is_valid_id($_GET['del'])) {
    sql_query("DELETE FROM shoutbox WHERE id=" . sqlesc($_GET['del'])) or sqlerr(__FILE__, __LINE__);
    $mc1->delete_value('shoutbox_');
    //$mc1->delete_value('staff_shoutbox_');

}
// Empty shout - sysop
if (isset($_GET['delall']) && $CURUSER['class'] === UC_MAX) {
    sql_query("TRUNCATE TABLE shoutbox") or sqlerr(__FILE__, __LINE__);
    $mc1->delete_value('shoutbox_');
    //$mc1->delete_value('staff_shoutbox_');

}
// Staff edit
if (isset($_GET['edit']) && $CURUSER['class'] >= UC_STAFF && is_valid_id($_GET['edit'])) {
    $sql = sql_query('SELECT id, text FROM shoutbox WHERE id=' . sqlesc($_GET['edit'])) or sqlerr(__FILE__, __LINE__);
    $res = mysqli_fetch_assoc($sql);
    unset($sql);
    $HTMLOUT.= "<!DOCTYPE html>
<head>
<script type='text/javascript' src='./scripts/shout.js'></script>
<style type='text/css'>
#specialbox{
border: 1px solid gray;
width: 600px;
background: #FBFCFA;
font: 11px verdana, sans-serif;
color: #000000;
padding: 3px;    outline: none;
}
#specialbox:focus{
border: 1px solid black;
}
#btn {
cursor:pointer;
border:outset 1px #ccc;
background:#999;
color:#666;
font-weight:bold;
padding: 1px 2px;
background: #000000 repeat-x left top;
}
</style>
</head>
<body bgcolor='#F5F4EA' class='date'>
<form method='post' action='./shoutbox.php'>
<input type='hidden' name='id' value='" . (int)$res['id'] . "' />
<textarea name='text' rows='3' id='specialbox'>" . htmlsafechars($res['text']) . "</textarea>
<input type='submit' name='save' value='{$lang['shoutbox_edit_save']}' class='btn' />
</form></body></html>";
    echo $HTMLOUT;
    die;
}
// Power Users+ can edit anyones single shouts //== pdq
if (isset($_GET['edit']) && ($_GET['user'] == $CURUSER['id']) && ($CURUSER['class'] >= UC_POWER_USER && $CURUSER['class'] <= UC_STAFF) && is_valid_id($_GET['edit'])) {
    $sql = sql_query('SELECT id, text, userid FROM shoutbox WHERE userid =' . sqlesc($_GET['user']) . ' AND id=' . sqlesc($_GET['edit'])) or sqlerr(__FILE__, __LINE__);
    $res = mysqli_fetch_assoc($sql);
    $HTMLOUT.= "<!DOCTYPE html>
<head>
<script type='text/javascript' src='./scripts/shout.js'></script>
<style type='text/css'>
#specialbox{
border: 1px solid gray;
width: 600px;
background: #FBFCFA;
font: 11px verdana, sans-serif;
color: #000000;
padding: 3px;    outline: none;
}
#specialbox:focus{
border: 1px solid black;
}
#btn {
cursor:pointer;
border:outset 1px #ccc;
background:#999;
color:#666;
font-weight:bold;
padding: 1px 2px;
background: #000000 repeat-x left top;
}
</style>
</head>
<body bgcolor='#F5F4EA' class='date'>
<form method='post' action='./shoutbox.php'>
<input type='hidden' name='id' value='" . (int)$res['id'] . "' />
<input type='hidden' name='user' value='" . (int)$res['userid'] . "' />
<textarea name='text' rows='3' id='specialbox'>" . htmlsafechars($res['text']) . "</textarea>
<input type='submit' name='save' value='{$lang['shoutbox_edit_save']}' class='btn' />
</form></body></html>";
    echo $HTMLOUT;
    die;
}
// Staff shout edit
if (isset($_POST['text']) && $CURUSER['class'] >= UC_STAFF && is_valid_id($_POST['id'])) {
    require_once (INCL_DIR . 'bbcode_functions.php');
    $text = trim($_POST['text']);
    $text_parsed = format_comment($text);
    sql_query('UPDATE shoutbox SET text = ' . sqlesc($text) . ', text_parsed = ' . sqlesc($text_parsed) . ' WHERE id=' . sqlesc($_POST['id'])) or sqlerr(__FILE__, __LINE__);
    $mc1->delete_value('shoutbox_');
    //$mc1->delete_value('staff_shoutbox_');
    unset($text, $text_parsed);
}
// Power User+ shout edit by pdq
if (isset($_POST['text']) && (isset($_POST['user']) == $CURUSER['id']) && ($CURUSER['class'] >= UC_POWER_USER && $CURUSER['class'] < UC_STAFF) && is_valid_id($_POST['id'])) {
    require_once (INCL_DIR . 'bbcode_functions.php');
    $text = trim($_POST['text']);
    $text_parsed = format_comment($text);
    sql_query('UPDATE shoutbox SET text = ' . sqlesc($text) . ', text_parsed = ' . sqlesc($text_parsed) . ' WHERE userid=' . sqlesc($_POST['user']) . ' AND id=' . sqlesc($_POST['id'])) or sqlerr(__FILE__, __LINE__);
    $mc1->delete_value('shoutbox_');
    //$mc1->delete_value('staff_shoutbox_');
    unset($text, $text_parsed);
}
//== begin main output
$HTMLOUT.= "<!DOCTYPE html>
<head>
<title>ShoutBox</title>
<meta http-equiv='refresh' content='60; url=./shoutbox.php' />
<script type='text/javascript' src='./scripts/shout.js'></script>
<style type='text/css'>
A {color: #356AA0; font-weight: bold; font-size: 9pt; }
A:hover {color: #FF0000;}
.small {color: #ff0000; font-size: 9pt; font-family: arial; }
.date {color: #ff0000; font-size: 9pt;}
.error {
 color: #990000;
 background-color: #FFF0F0;
 padding: 7px;
 margin-top: 5px;
 margin-bottom: 10px;
 border: 1px dashed #990000;
}
A {color: #FFFFFF; font-weight: bold; }
A:hover {color: #FFFFFF;}
.small {font-size: 10pt; font-family: arial; }
.date {font-size: 8pt;}
span.size1 { font-size:0.75em; }
span.size2 { font-size:1em; }
span.size3 { font-size:1.25em; }
span.size4 { font-size:1.5em; }
span.size5 { font-size:1.75em; }
span.size6 { font-size:2em; }
span.size7 { font-size:2.25em; }
</style>";
//==Background colours begin
//== White
if ($CURUSER['shoutboxbg'] == 1) {
    $HTMLOUT.= "<style type='text/css'>
A {color: #000000; font-weight: bold;  }
A:hover {color: #FF273D;}
.small {font-size: 10pt; font-family: arial; }
.date {font-size: 8pt;}
</style>";
    $bg = '#ffffff';
    $fontcolor = '#000000';
    $dtcolor = '#356AA0';
}
// == Grey
if ($CURUSER['shoutboxbg'] == 2) {
    $HTMLOUT.= "<style type='text/css'>
A {color: #ffffff; font-weight: bold;  }
A:hover {color: #FF273D;}
.small {font-size: 10pt; font-family: arial; }
.date {font-size: 8pt;}
</style>";
    $bg = '#777777';
    $fontcolor = '#000000';
    $dtcolor = '#FFFFFF';
}
// == Black
if ($CURUSER['shoutboxbg'] == 3) {
    $HTMLOUT.= "<style type='text/css'>
A {color: #FFFFFF; font-weight: bold; ; }
A:hover {color: #FFFFFF;}
.small {font-size: 10pt; font-family: arial; }
.date {font-size: 8pt;}
</style>";
    //$bg = '#1f1f1f';
    $bg = '#000000';
    $fontcolor = '#FFFFFF';
    $dtcolor = '#FFFFFF';
}
$HTMLOUT.= "</head><body>";
//== Banned from shout ??
if ($CURUSER['chatpost'] == 0 || $CURUSER['chatpost'] > 1) {
    $HTMLOUT.= "<div class='error' align='center'><br /><font color='red'>{$lang['shoutbox_banned']}</font>  (<a href=\"./rules.php\" target=\"_blank\"><font color='red'>{$lang['shoutbox_banned_why']}</font></a>)<br /><br /></div></body></html>";
    echo $HTMLOUT;
    exit;
}
//=End
if (isset($_GET['sent']) && ($_GET['sent'] == "yes")) {
    require_once (INCL_DIR . 'bbcode_functions.php');
    $limit = 5;
    $userid = $CURUSER["id"];
    $date = TIME_NOW;
    $text = (trim($_GET["shbox_text"]));
    $text_parsed = format_comment($text);
    $system_pattern = '/(^\/system)\s([\w\W\s]+)/is';
    if (preg_match($system_pattern, $text, $out) && $CURUSER["class"] >= UC_STAFF) {
        $userid = $INSTALLER09['bot_id'];
        $text = $out[2];
        $text_parsed = format_comment($text);
    }
    // ///////////////////////shoutbox command system by putyn /////////////////////////////
    $commands = array(
        "\/EMPTY",
        "\/GAG",
        "\/UNGAG",
        "\/WARN",
        "\/UNWARN",
        "\/DISABLE",
        "\/ENABLE"
    ); // this / was replaced with \/ to work with the regex
    $pattern = "/(" . implode("|", $commands) . "\w+)\s([a-zA-Z0-9_:\s(?i)]+)/";
    //== private mode by putyn
    $private_pattern = "/(^\/private)\s([a-zA-Z0-9]+)\s([\w\W\s]+)/i";
    if (preg_match($pattern, $text, $vars) && $CURUSER["class"] >= UC_STAFF) {
        $command = $vars[1];
        $user = $vars[2];
        $c = sql_query("SELECT id, class, modcomment FROM users where username=" . sqlesc($user)) or sqlerr(__FILE__, __LINE__);
        $a = mysqli_fetch_row($c);
        if (mysqli_num_rows($c) == 1 && $CURUSER["class"] > $a[1]) {
            switch ($command) {
            case "/EMPTY":
                $what = $lang['shoutbox_empty_all'];
                $msg = "[b]" . htmlsafechars($user) . "{$lang['shoutbox_empty_s']}[/b]{$lang['shoutbox_empty_have']}";
                $query = "DELETE FROM shoutbox where userid = " . sqlesc($a[0]);
                $mc1->delete_value('shoutbox_');
                //$mc1->delete_value('staff_shoutbox_');
                break;

            case "/GAG":
                $what = $lang['shoutbox_gag'];
                $modcomment = get_date(TIME_NOW, 'DATE', 1) . "{$lang['shoutbox_gag_modcomment']}" . $CURUSER["username"] . "\n" . $a[2];
                $msg = "[b]" . htmlsafechars($user) . "[/b]{$lang['shoutbox_gag_by']}" . $CURUSER["username"];
                $query = "UPDATE users SET chatpost='0', modcomment = concat(" . sqlesc($modcomment) . ", modcomment) WHERE id = " . sqlesc($a[0]);
                $mc1->begin_transaction('MyUser_' . $a[0]);
                $mc1->update_row(false, array(
                    'chatpost' => 0
                ));
                $mc1->commit_transaction($INSTALLER09['expires']['curuser']);
                $mc1->begin_transaction('user' . $a[0]);
                $mc1->update_row(false, array(
                    'chatpost' => 0
                ));
                $mc1->commit_transaction($INSTALLER09['expires']['user_cache']);
                $mc1->begin_transaction('user_stats_' . $a[0]);
                $mc1->update_row(false, array(
                    'modcomment' => $modcomment
                ));
                $mc1->commit_transaction($INSTALLER09['expires']['user_stats']);
                break;

            case "/UNGAG":
                $what = $lang['shoutbox_ungag'];
                $modcomment = get_date(TIME_NOW, 'DATE', 1) . "{$lang['shoutbox_ungag_modcomment']}" . $CURUSER["username"] . "\n" . $a[2];
                $msg = "[b]" . htmlsafechars($user) . "[/b]{$lang['shoutbox_ungag_by']}" . $CURUSER["username"];
                $query = "UPDATE users SET chatpost='1', modcomment = concat(" . sqlesc($modcomment) . ", modcomment) WHERE id = " . sqlesc($a[0]);
                $mc1->begin_transaction('MyUser_' . $a[0]);
                $mc1->update_row(false, array(
                    'chatpost' => 1
                ));
                $mc1->commit_transaction($INSTALLER09['expires']['curuser']);
                $mc1->begin_transaction('user' . $a[0]);
                $mc1->update_row(false, array(
                    'chatpost' => 1
                ));
                $mc1->commit_transaction($INSTALLER09['expires']['user_cache']);
                $mc1->begin_transaction('user_stats_' . $a[0]);
                $mc1->update_row(false, array(
                    'modcomment' => $modcomment
                ));
                $mc1->commit_transaction($INSTALLER09['expires']['user_stats']);
                break;

            case "/WARN":
                $what = $lang['shoutbox_warn'];
                $modcomment = get_date(TIME_NOW, 'DATE', 1) . "{$lang['shoutbox_warn_modcomment']}" . $CURUSER["username"] . "\n" . $a[2];
                $msg = "[b]" . htmlsafechars($user) . "[/b]{$lang['shoutbox_warn_by']}" . $CURUSER["username"];
                $query = "UPDATE users SET warned='1', modcomment = concat(" . sqlesc($modcomment) . ", modcomment) WHERE id = " . sqlesc($a[0]);
                $mc1->begin_transaction('MyUser_' . $a[0]);
                $mc1->update_row(false, array(
                    'warned' => 1
                ));
                $mc1->commit_transaction($INSTALLER09['expires']['curuser']);
                $mc1->begin_transaction('user' . $a[0]);
                $mc1->update_row(false, array(
                    'warned' => 1
                ));
                $mc1->commit_transaction($INSTALLER09['expires']['user_cache']);
                $mc1->begin_transaction('user_stats_' . $a[0]);
                $mc1->update_row(false, array(
                    'modcomment' => $modcomment
                ));
                $mc1->commit_transaction($INSTALLER09['expires']['user_stats']);
                break;

            case "/UNWARN":
                $what = $lang['shoutbox_unwarn'];
                $modcomment = get_date(TIME_NOW, 'DATE', 1) . "{$lang['shoutbox_unwarn_modcomment']}" . $CURUSER["username"] . "\n" . $a[2];
                $msg = "[b]" . htmlsafechars($user) . "[/b]{$lang['shoutbox_unwarn_by']}" . $CURUSER["username"];
                $query = "UPDATE users SET warned='0', modcomment = concat(" . sqlesc($modcomment) . ", modcomment) WHERE id = " . sqlesc($a[0]);
                $mc1->begin_transaction('MyUser_' . $a[0]);
                $mc1->update_row(false, array(
                    'warned' => 0
                ));
                $mc1->commit_transaction($INSTALLER09['expires']['curuser']);
                $mc1->begin_transaction('user' . $a[0]);
                $mc1->update_row(false, array(
                    'warned' => 0
                ));
                $mc1->commit_transaction($INSTALLER09['expires']['user_cache']);
                $mc1->begin_transaction('user_stats_' . $a[0]);
                $mc1->update_row(false, array(
                    'modcomment' => $modcomment
                ));
                $mc1->commit_transaction($INSTALLER09['expires']['user_stats']);
                break;

            case "/DISABLE":
                $what = $lang['shoutbox_disable'];
                $modcomment = get_date(TIME_NOW, 'DATE', 1) . "{$lang['shoutbox_disable_modcomment']}" . $CURUSER["username"] . "\n" . $a[2];
                $msg = "[b]" . htmlsafechars($user) . "[/b]{$lang['shoutbox_disable_by']}" . $CURUSER["username"];
                $query = "UPDATE users SET enabled='no', modcomment = concat(" . sqlesc($modcomment) . ", modcomment) WHERE id = " . sqlesc($a[0]);
                $mc1->begin_transaction('MyUser_' . $a[0]);
                $mc1->update_row(false, array(
                    'enabled' => 'no'
                ));
                $mc1->commit_transaction($INSTALLER09['expires']['curuser']);
                $mc1->begin_transaction('user' . $a[0]);
                $mc1->update_row(false, array(
                    'enabled' => 'no'
                ));
                $mc1->commit_transaction($INSTALLER09['expires']['user_cache']);
                $mc1->begin_transaction('user_stats_' . $a[0]);
                $mc1->update_row(false, array(
                    'modcomment' => $modcomment
                ));
                $mc1->commit_transaction($INSTALLER09['expires']['user_stats']);
                break;

            case "/ENABLE":
                $what = $lang['shoutbox_enable'];
                $modcomment = get_date(TIME_NOW, 'DATE', 1) . "{$lang['shoutbox_enable_modcomment']}" . $CURUSER["username"] . "\n" . $a[2];
                $msg = "[b]" . htmlsafechars($user) . "[/b]{$lang['shoutbox_enable_by']}" . $CURUSER["username"];
                $query = "UPDATE users SET enabled='yes', modcomment = concat(" . sqlesc($modcomment) . ", modcomment) WHERE id = " . sqlesc($a[0]);
                $mc1->begin_transaction('MyUser_' . $a[0]);
                $mc1->update_row(false, array(
                    'enabled' => 'yes'
                ));
                $mc1->commit_transaction($INSTALLER09['expires']['curuser']);
                $mc1->begin_transaction('user' . $a[0]);
                $mc1->update_row(false, array(
                    'enabled' => 'yes'
                ));
                $mc1->commit_transaction($INSTALLER09['expires']['user_cache']);
                $mc1->begin_transaction('user_stats_' . $a[0]);
                $mc1->update_row(false, array(
                    'modcomment' => $modcomment
                ));
                $mc1->commit_transaction($INSTALLER09['expires']['user_stats']);
                break;
            }
            if (sql_query($query)) autoshout($msg);
            $mc1->delete_value('shoutbox_');
            //$mc1->delete_value('staff_shoutbox_');
            $HTMLOUT.= "<script type=\"text/javascript\">parent.document.forms[0].shbox_text.value='';</script>";
            write_log($lang['shoutbox_wlog_user'] . $user . $lang['shoutbox_wlog_been'] . $what . $lang['shoutbox_wlog_by'] . $CURUSER["username"]);
            unset($text, $text_parsed, $query, $date, $modcomment, $what, $msg, $commands);
        }
    } elseif (preg_match($private_pattern, $text, $vars)) {
        $to_user = 0;
        $p_res = sql_query(sprintf('SELECT id FROM users WHERE username = %s', sqlesc($vars[2]))) or exit(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
        if (mysqli_num_rows($p_res) == 1) {
            $p_arr = mysqli_fetch_row($p_res);
            $to_user = (int)$p_arr[0];
        }
        if ($to_user != 0 && $to_user != $CURUSER['id']) {
            $text = $vars[2] . " - " . $vars[3];
            $text_parsed = format_comment($text);
            sql_query("INSERT INTO shoutbox (userid, date, text, text_parsed, to_user, staff_shout) VALUES (" . sqlesc($userid) . ", $date, " . sqlesc($text) . "," . sqlesc($text_parsed) . "," . sqlesc($to_user) . ", 'no')") or sqlerr(__FILE__, __LINE__);
            sql_query("UPDATE usersachiev SET dailyshouts=dailyshouts+1, weeklyshouts = weeklyshouts+1, monthlyshouts = monthlyshouts+1, totalshouts = totalshouts+1 WHERE id= " . sqlesc($userid)) or sqlerr(__FILE__, __LINE__);
            $mc1->delete_value('shoutbox_');
            //$mc1->delete_value('staff_shoutbox_');

        }
        $HTMLOUT.= "<script type=\"text/javascript\">parent.document.forms[0].shbox_text.value='';</script>";
    } else {
        $a = mysqli_fetch_row(sql_query("SELECT userid, date FROM shoutbox WHERE staff_shout='no' ORDER by id DESC LIMIT 1")) or print ("First shout or an error :)");
        if (empty($text) || strlen($text) == 1) $HTMLOUT.= "<font class=\"small\" color=\"red\">Shout can't be empty</font>";
        elseif ($a[0] == $userid && (TIME_NOW - $a[1]) < $limit && $CURUSER['class'] < UC_STAFF) $HTMLOUT.= "<font class=\"small\" color=\"red\">$limit{$lang['shoutbox_sec_between']}<font class=\"small\">{$lang['shoutbox_sec_remaining']}(" . ($limit - (TIME_NOW - $a[1])) . ")</font></font>";
        else {
            $dailyshouts = 1;
            sql_query("INSERT INTO shoutbox (userid, date, text, text_parsed, staff_shout) VALUES (" . sqlesc($userid) . ", $date, " . sqlesc($text) . "," . sqlesc($text_parsed) . ", 'no')") or sqlerr(__FILE__, __LINE__);
            sql_query("UPDATE usersachiev SET dailyshouts=dailyshouts+1, weeklyshouts = weeklyshouts+1, monthlyshouts = monthlyshouts+1, totalshouts = totalshouts+1 WHERE id= " . sqlesc($userid)) or sqlerr(__FILE__, __LINE__);
            $mc1->delete_value('shoutbox_');
            //$mc1->delete_value('staff_shoutbox_');
            $HTMLOUT.= "<script type=\"text/javascript\">parent.document.forms[0].shbox_text.value='';</script>";
            $trigger_words = array(
               $lang['shoutbox_words1'] => array(
                    $lang['shoutbox_words1_1'],
                    $lang['shoutbox_words1_2']
                ) ,
                $lang['shoutbox_words2']=> array(
                    $lang['shoutbox_words2_1'],
                    $lang['shoutbox_words2_2'] . $CURUSER['username'],
                    $lang['shoutbox_words2_3']
                ) ,
                $lang['shoutbox_words3'] => array(
                    $lang['shoutbox_words3_1']
                ) ,
                $lang['shoutbox_words4'] => array(
                    $lang['shoutbox_words4_1'],
                    $lang['shoutbox_words4_2'],
                    $lang['shoutbox_words4_3'],
                    $lang['shoutbox_words4_4']
                ) ,
                $lang['shoutbox_words5'] => array(
                    $lang['shoutbox_words5_1'],
                    $lang['shoutbox_words5_2'],
                    $lang['shoutbox_words5_3']
                ) /*,
                 ':finger:'=>array(':finger:') */
            );
            if (preg_match('/(' . join('|', array_keys($trigger_words)) . ')/iU', $text, $trigger_key) && isset($trigger_words[$trigger_key[0]])) {
                shuffle($trigger_words[$trigger_key[0]]);
                $message = $trigger_words[$trigger_key[0]][0];
                sleep(1);
                autoshout($message);
                $mc1->delete_value('shoutbox_');
                //$mc1->delete_value('staff_shoutbox_');

            }
        }
    }
}
//== cache the data
if (($shouts = $mc1->get_value('shoutbox_')) === false) {
    $res = sql_query("SELECT s.id, s.userid, s.date, s.text, s.to_user, s.staff_shout, s.autoshout, u.username, u.pirate, u.perms, u.king, u.class, u.donor, u.warned, u.leechwarn, u.enabled, u.chatpost FROM shoutbox AS s LEFT JOIN users AS u ON s.userid=u.id WHERE s.staff_shout ='no' AND s.autoshout='no' ORDER BY s.id DESC LIMIT 150") or sqlerr(__FILE__, __LINE__);
    while ($shout = mysqli_fetch_assoc($res)) $shouts[] = $shout;
    $mc1->cache_value('shoutbox_', $shouts, $INSTALLER09['expires']['shoutbox']);
}
if (count($shouts) > 0) {
    $HTMLOUT.= "<table class='small text-left' style='clear:both; border-collapse:collapse; width:100%;'>\n";
    $shout_pm_alert = mysqli_fetch_assoc(sql_query(" SELECT count(id) AS pms FROM messages WHERE receiver = " . sqlesc($CURUSER['id']) . " AND unread = 'yes' AND location = '1'")) or sqlerr(__FILE__, __LINE__);
    $gotpm = 0;
    if ($shout_pm_alert['pms'] > 0 && $gotpm == 0) {
        $HTMLOUT.= '<tr><td class=\'text-center\'><a href=\'' . $INSTALLER09['baseurl'] . '/pm_system.php\' target=\'_parent\'><span style=\'color:red;\'>' . sprintf($lang['shoutbox_msg'], $shout_pm_alert['pms']) . ($shout_pm_alert['pms'] > 1 ? $lang['shoutbox_msg_s'] : "") .  '</span></a></td></tr>';
        $gotpm++;
    }
    if ($shouts) {
        if ($CURUSER['perms'] & bt_options::NOFKNBEEP) {
            if (preg_match(sprintf("/%s/iU", $CURUSER['username']) , $shouts[0]['text']) && ($shouts[0]['date'] - TIME_NOW) < 60) $HTMLOUT.= "<audio autoplay=\"autoplay\"><source src=\"templates/{$CURUSER['stylesheet']}/beep.mp3\" type=\"audio/mp3\" /><source src=\"templates/{$CURUSER['stylesheet']}/beep.ogg\" type=\"audio/ogg\" /></audio>";
        }
        $i = 0;
        foreach ($shouts as $arr) {
            if (($arr['to_user'] != $CURUSER['id'] && $arr['to_user'] != 0) && $arr['userid'] != $CURUSER['id']) continue;
            if ($INSTALLER09['shouts_to_show'] == $i) break;
            $private = '';
            if ($arr['to_user'] == $CURUSER['id'] && $arr['to_user'] > 0) $private = "<a href=\"javascript:window.top.private_reply('" . htmlsafechars($arr['username']) . "','shbox','shbox_text')\"><img src=\"{$INSTALLER09['pic_base_url']}private-shout.png\" alt=\"Private shout\" title=\"Private shout! click to reply to " . htmlsafechars($arr['username']) . "\" width=\"16\" style=\"padding-left:2px;padding-right:2px;\" border=\"0\" /></a>";
            $edit = ($CURUSER['class'] >= UC_STAFF || ($arr['userid'] == $CURUSER['id']) && ($CURUSER['class'] >= UC_POWER_USER && $CURUSER['class'] <= UC_STAFF) ? "<a href='{$INSTALLER09['baseurl']}/shoutbox.php?edit=" . (int)$arr['id'] . "&amp;user=" . (int)$arr['userid'] . "'><img src='{$INSTALLER09['pic_base_url']}button_edit2.gif' alt=\"Edit Shout\"  title=\"Edit Shout\" /></a> " : "");
            $del = ($CURUSER['class'] >= UC_STAFF ? "<a href='./shoutbox.php?del=" . (int)$arr['id'] . "'><img src='{$INSTALLER09['pic_base_url']}button_delete2.gif' alt=\"Delete Single Shout\" title=\"Delete Single Shout\" /></a> " : "");
            $delall = ($CURUSER['class'] == UC_MAX ? "<a href='./shoutbox.php?delall' onclick=\"confirm_delete(); return false;\"><img src='{$INSTALLER09['pic_base_url']}del.png' alt=\"Empty Shout\" title=\"Empty Shout\" /></a> " : "");
            //$delall
            $pm = ($CURUSER['id'] != $arr['userid'] ? "<span class='date' style=\"color:$dtcolor\"><a target='_blank' href='./pm_system.php?action=send_message&amp;receiver=" . (int)$arr['userid'] . "'><img src='{$INSTALLER09['pic_base_url']}button_pm2.gif' alt=\"Pm User\" title=\"Pm User\" /></a></span>\n" : "");
            $date = get_date($arr["date"], 0, 1);
            $reply = ($CURUSER['id'] != $arr['userid'] ? "<a href=\"javascript:window.top.SmileIT('[b][i]=>&nbsp;[color=#" . get_user_class_color($arr['class']) . "]" . ($arr['perms'] & bt_options::PERMS_STEALTH ? "UnKnown" : htmlsafechars($arr['username'])) . "[/color]&nbsp;-[/i][/b]','shbox','shbox_text')\"><img height='10' src='{$INSTALLER09['pic_base_url']}reply.gif' title='Reply' alt='Reply' style='border:none;' /></a>" : "");
            $user_stuff = $arr;
            $user_stuff['id'] = ($arr['perms'] & bt_options::PERMS_STEALTH ? "" . $user_stuff['id'] = $INSTALLER09['bot_id'] . "" : "" . $user_stuff['id'] = (int)$arr['userid'] . "");
            $user_stuff['username'] = ($arr['perms'] & bt_options::PERMS_STEALTH ? "" . $user_stuff['username'] = 'UnKn0wn' . "" : "" . $user_stuff['username'] = htmlsafechars($arr['username']) . "");
            $HTMLOUT.= "<tr style='background-color:$bg;'><td><span class='size1' style='color:$fontcolor;'>[$date]</span>\n$del$edit$pm$reply$private " . format_username($user_stuff, true) . "<span class='size2' style='color:$fontcolor;'>" . format_comment($arr["text"]) . "\n</span></td></tr>\n";
            $i++;
        } 
        $HTMLOUT.= "</table>";
    } else {
        //== If there are no shouts
        if (empty($shouts)) $HTMLOUT.= "<tr style='background-color:$bg;'><td><span class='size1' style='color:$fontcolor;'>{$lang['shoutbox_no_shouts']}</span></td></tr>\n";
        $HTMLOUT.= "</table>";
    }
}
$HTMLOUT.= "</body></html>";
echo $HTMLOUT;
?>
