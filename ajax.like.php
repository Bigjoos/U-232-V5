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
require_once(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'include' . DIRECTORY_SEPARATOR . 'bittorrent.php');
require_once(INCL_DIR . 'user_functions.php');
require_once(INCL_DIR . 'add_functions.php');
dbconn(false);
loggedinorreturn();
$lang = array_merge(load_language('global'), load_language('ajax_like'));
$banned_users = array(
    0
); // Please insert single or nultiple user id's with a comma  EG: 1,50,114,556   etc
$check = isset($_POST['type']) ? htmlsafechars($_POST['type']) : '';
$disabled_time = (isset($_POST['time']) && isset($check)) ? (int) $_POST['time'] : 0;
if ($check == 'disabled') {
    $res = sql_query("INSERT INTO manage_likes (user_id,disabled_time) VALUES (" . $CURUSER['id'] . "," . TIME_NOW . "+$disabled_time) ON DUPLICATE KEY UPDATE disabled_time=" . TIME_NOW . "") or sqlerr(__FILE__, __LINE__);
    die();
}
$tb_fields = array(
    'comment' => 'comments', // name-supplied by js => user table to alter
    'user_comm' => 'usercomments',
    'forum' => 'posts',
    'details' => 'torrents'
);
$agent = isset($_POST['agent']) ? htmlsafechars($_POST['agent']) : die('hell no');
//$ip =                isset($_POST['i']) ? md5(getips()) == $_POST['i'] ? getips() : die('No Proper data') : die('hell no');
$user_ag_chk = isset($_POST['ua']) ? md5($agent) == $_POST['ua'] ? true : die('Wrong User Agent') : die('No User Agent');
$the_id = isset($_POST['one']) ? (int) $_POST['one'] : die('false');
$type = isset($_POST['two']) ? (array_key_exists($_POST['two'][0], $tb_fields) && isset($_POST['two'][1])) ? $_POST['two'] : die('Data Missing') : die('Missing Data');

comment_like_unlike();
function comment_like_unlike()
{
    global $CURUSER, $type, $tb_fields, $the_id, $banned_users, $disabled_time, $lang, $mc1;
    $userip = $_SERVER['REMOTE_ADDR'];
    $res = sql_query("SELECT user_likes,disabled_time FROM " . $tb_fields[$type[0]] . " LEFT OUTER JOIN manage_likes ON manage_likes.user_id = " . sqlesc($CURUSER['id']) . " WHERE " . $tb_fields[$type[0]] . ".id = " . sqlesc($the_id)) or sqlerr(__FILE__, __LINE__);
    $data = mysqli_fetch_row($res);
    if ($data[1] + $disabled_time > TIME_NOW) {
        die($lang['ajlike_you_been_disabled']);
    } elseif (in_array($CURUSER['id'], $banned_users)) {
        die($lang['ajlike_you_been_banned']);
    }
    $exp = explode(',', $data[0]);
    if ($res && $type[1] == 'like' && array_key_exists($type[0], $tb_fields)) {
        if (!(in_array($CURUSER['id'], $exp))) {
            $res2 = sql_query("UPDATE " . $tb_fields[$type[0]] . " SET user_likes = IF(LENGTH(user_likes),CONCAT(user_likes,','," . sqlesc((string) $CURUSER['id']) . ")," . sqlesc((string) $CURUSER['id']) . ") WHERE id = " . sqlesc($the_id)) or sqlerr(__FILE__, __LINE__);
        if ($type['0'] == 'details') {
            $mc1->delete_value('torrent_details_' . $the_id);
        }
        } else {
            die($lang['ajlike_you_already_liked']);
        }
    } elseif ($res && $type[1] == 'unlike' && array_key_exists($type[0], $tb_fields)) {
        if (in_array($CURUSER['id'], $exp)) {
            $key = array_search($CURUSER['id'], $exp);
            unset($exp[$key]);
            $exp = implode(",", $exp);
            $res2 = sql_query("UPDATE " . $tb_fields[$type[0]] . " SET user_likes = " . sqlesc($exp) . "WHERE id = " . sqlesc($the_id)) or sqlerr(__FILE__, __LINE__);
        if ($type['0'] == 'details') {
            $mc1->delete_value('torrent_details_' . $the_id);
        }
        } else {
            die($lang['ajlike_you_already_unliked']);
        }
    } else {
        die($lang['ajlike_get_lost']);
    }
}
?>
