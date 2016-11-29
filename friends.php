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
//== Manage friends by pdq
require_once (__DIR__ . DIRECTORY_SEPARATOR . 'include' . DIRECTORY_SEPARATOR . 'bittorrent.php');
require_once (INCL_DIR . 'user_functions.php');
dbconn(false);
loggedinorreturn();
$lang = array_merge(load_language('global') , load_language('friends'));
$userid = isset($_GET['id']) ? (int)$_GET['id'] : $CURUSER['id'];
$action = isset($_GET['action']) ? htmlsafechars($_GET['action']) : '';
if (!is_valid_id($userid)) stderr($lang['friends_error'], $lang['friends_invalid_id']);
if ($userid != $CURUSER["id"]) stderr($lang['friends_error'], $lang['friends_no_access']);
//== action == add
if ($action == 'add') {
    $targetid = (int)$_GET['targetid'];
    $type = $_GET['type'];
    if (!is_valid_id($targetid)) stderr("Error", "Invalid ID.");
    if ($CURUSER['id'] == $targetid) {
        stderr("Error", "Ye cant add yerself nugget.");
    }
    if ($type == 'friend') {
        $table_is = $frag = 'friends';
        $field_is = 'friendid';
        $confirmed = 'confirmed';
    } elseif ($type == 'block') {
        $table_is = $frag = 'blocks';
        $field_is = 'blockid';
    } else stderr("Error", "Unknown type.");
    if ($type == 'friend') {
        $r = sql_query("SELECT id, confirmed FROM $table_is WHERE userid=" . sqlesc($userid) . " AND $field_is=" . sqlesc($targetid)) or sqlerr(__FILE__, __LINE__);
        $q = mysqli_fetch_assoc($r);
        $subject = sqlesc("New Friend Request!");
        $body = sqlesc("[url={$INSTALLER09['baseurl']}/userdetails.php?id=$userid][b]This person[/b][/url] has added you to their Friends List. See all Friend Requests [url={$INSTALLER09['baseurl']}/friends.php#pending][b]Here[/b][/url]\n ");
        sql_query("INSERT INTO messages (sender, receiver, added, subject, msg) VALUES (0, " . sqlesc($targetid) . ", '" . TIME_NOW . "', $subject, $body)") or sqlerr(__FILE__, __LINE__);
        $mc1->delete_value('inbox_new_' . $targetid);
        $mc1->delete_value('inbox_new_sb_' . $targetid);
        if (mysqli_num_rows($r) == 1) stderr("Error", "User ID is already in your " . htmlsafechars($table_is) . " list.");
        sql_query("INSERT INTO $table_is VALUES (0, " . sqlesc($userid) . ", " . sqlesc($targetid) . ", 'no')") or sqlerr(__FILE__, __LINE__);
        stderr("Request Added!", "The user will be informed of your Friend Request, you will be informed via PM upon confirmation.<br /><br /><a href='friends.php?id=$userid#$frag'><b>Go to your Friends List</b></a>", FALSE);
        die;
    }
    if ($type == 'block') {
        $r = sql_query("SELECT id FROM $table_is WHERE userid=" . sqlesc($userid) . " AND $field_is=" . sqlesc($targetid)) or sqlerr(__FILE__, __LINE__);
        if (mysqli_num_rows($r) == 1) stderr("Error", "User ID is already in your " . htmlsafechars($table_is) . " list.");
        sql_query("INSERT INTO $table_is VALUES (0, " . sqlesc($userid) . ", " . sqlesc($targetid) . ")") or sqlerr(__FILE__, __LINE__);
        $mc1->delete_value('Blocks_' . $userid);
        $mc1->delete_value('Friends_' . $userid);
        $mc1->delete_value('Blocks_' . $targetid);
        $mc1->delete_value('Friends_' . $targetid);
        $mc1->delete_value('user_friends_' . $targetid);
        $mc1->delete_value('user_friends_' . $userid);
        header("Location: {$INSTALLER09['baseurl']}/friends.php?id=$userid#$frag");
        die;
    }
}
//== action == confirm
if ($action == 'confirm') {
    $targetid = (int)$_GET['targetid'];
    $sure = isset($_GET['sure']) ? intval($_GET['sure']) : false;
    $type = isset($_GET['type']) ? ($_GET['type'] == 'friend' ? 'friend' : 'block') : stderr($lang['friends_error'], 'LoL');
    if (!is_valid_id($targetid)) stderr("Error", "Invalid ID.");
    $hash = md5('c@@me' . $CURUSER['id'] . $targetid . $type . 'confirm' . 'sa7t');
    if (!$sure) stderr("Confirm Friend", "Do you really want to confirm this person? Click\n<a href='?id=$userid&amp;action=confirm&amp;type=$type&amp;targetid=$targetid&amp;sure=1&amp;h=$hash'><b>here</b></a> if you are sure.", FALSE);
    if ($_GET['h'] != $hash) stderr('Error', 'what are you doing?');
    if ($type == 'friend') {
        sql_query("INSERT INTO friends VALUES (0, " . sqlesc($userid) . ", " . sqlesc($targetid) . ", 'yes') ON DUPLICATE KEY UPDATE userid=" . sqlesc($userid)) or sqlerr(__FILE__, __LINE__);
        sql_query("UPDATE friends SET confirmed = 'yes' WHERE userid=" . sqlesc($targetid) . " AND friendid=" . sqlesc($CURUSER['id'])) or sqlerr(__FILE__, __LINE__);
        $mc1->delete_value('Blocks_' . $userid);
        $mc1->delete_value('Friends_' . $userid);
        $mc1->delete_value('Blocks_' . $targetid);
        $mc1->delete_value('Friends_' . $targetid);
        $mc1->delete_value('user_friends_' . $targetid);
        $mc1->delete_value('user_friends_' . $userid);
        $subject = sqlesc("You have a new friend!");
        $body = sqlesc("[url={$INSTALLER09['baseurl']}/userdetails.php?id=$userid][b]This person[/b][/url] has just confirmed your Friendship Request. See your Friends  [url={$INSTALLER09['baseurl']}/friends.php][b]Here[/b][/url]\n ");
        sql_query("INSERT INTO messages (sender, receiver, added, subject, msg) VALUES (0, " . sqlesc($targetid) . ", '" . TIME_NOW . "', $subject, $body)") or sqlerr(__FILE__, __LINE__);
        $mc1->delete_value('inbox_new_' . $targetid);
        $mc1->delete_value('inbox_new_sb_' . $targetid);
        $frag = "friends";
        header("Refresh: 3; url=friends.php?id=$userid#$frag");
        mysqli_affected_rows($GLOBALS["___mysqli_ston"]) == 1 ? stderr("Success", "Friend was added successfully.") : stderr("oopss", "That friend is already confirmed !! .");
    }
}
//== action == delete pending
elseif ($action == 'delpending') {
    $targetid = (int)$_GET['targetid'];
    $sure = isset($_GET['sure']) ? intval($_GET['sure']) : false;
    $type = htmlsafechars($_GET['type']);
    if (!is_valid_id($targetid)) stderr("Error", "Invalid ID.");
    $hash = md5('c@@me' . $CURUSER['id'] . $targetid . $type . 'confirm' . 'sa7t');
    if (!$sure) stderr("Delete $type Request", "Do you really want to delete this friend request? Click\n<a href='?id=$userid&amp;action=delpending&amp;type=$type&amp;targetid=$targetid&amp;sure=1&amp;h=$hash'><b>here</b></a> if you are sure.", FALSE);
    if ($_GET['h'] != $hash) stderr('Error', 'what are you doing?');
    if ($type == 'friend') {
        sql_query("DELETE FROM friends WHERE userid=" . sqlesc($targetid) . " AND friendid=" . sqlesc($userid)) or sqlerr(__FILE__, __LINE__);
        $mc1->delete_value('Friends_' . $userid);
        $mc1->delete_value('Friends_' . $targetid);
        $mc1->delete_value('user_friends_' . $userid);
        $mc1->delete_value('user_friends_' . $targetid);
        $frag = "friends";
        header("Refresh: 3; url=friends.php?id=$userid#$frag");
        mysqli_affected_rows($GLOBALS["___mysqli_ston"]) == 1 ? stderr("Success", "Friend was deleted successfully.") : stderr("oopss", "No friend request found with ID !! .");
    }
}
//== action == delete
elseif ($action == 'delete') {
    $targetid = (int)$_GET['targetid'];
    $sure = isset($_GET['sure']) ? intval($_GET['sure']) : false;
    $type = htmlsafechars($_GET['type']);
    if (!is_valid_id($targetid)) stderr("Error", "Invalid ID.");
    $hash = md5('c@@me' . $CURUSER['id'] . $targetid . $type . 'confirm' . 'sa7t');
    if (!$sure) stderr("Delete $type", "Do you really want to delete a $type? Click\n<a href='?id=$userid&amp;action=delete&amp;type=$type&amp;targetid=$targetid&amp;sure=1&amp;h=$hash'><b>here</b></a> if you are sure.", FALSE);
    if ($_GET['h'] != $hash) stderr('Error', 'what are you doing?');
    if ($type == 'friend') {
        sql_query("DELETE FROM friends WHERE userid=" . sqlesc($userid) . " AND friendid=" . sqlesc($targetid)) or sqlerr(__FILE__, __LINE__);
        sql_query("DELETE FROM friends WHERE userid=" . sqlesc($targetid) . " AND friendid=" . sqlesc($userid)) or sqlerr(__FILE__, __LINE__);
        $mc1->delete_value('Friends_' . $userid);
        $mc1->delete_value('Friends_' . $targetid);
        $mc1->delete_value('user_friends_' . $userid);
        $mc1->delete_value('user_friends_' . $targetid);
        $frag = "friends";
        header("Refresh: 3; url=friends.php?id=$userid#$frag");
        mysqli_affected_rows($GLOBALS["___mysqli_ston"]) == 1 ? stderr("Success", "Friend was deleted successfully.") : stderr("oopss", "No friend request found with ID !! .");
    } elseif ($type == 'block') {
        sql_query("DELETE FROM blocks WHERE userid=" . sqlesc($userid) . " AND blockid=" . sqlesc($targetid)) or sqlerr(__FILE__, __LINE__);
        $mc1->delete_value('Blocks_' . $userid);
        $mc1->delete_value('Blocks_' . $targetid);
        $frag = "blocks";
        header("Refresh: 3; url=friends.php?id=$userid#$frag");
        mysqli_affected_rows($GLOBALS["___mysqli_ston"]) == 1 ? stderr("Success", "Block was deleted successfully.") : stderr("oopss", "No Block found with ID !! .");
    } else stderr("Error", "Unknown type.");
    header("Location: friends.php");
    die;
}
//== Main body shit
$res = sql_query("SELECT * FROM users WHERE id=" . sqlesc($userid)) or sqlerr(__FILE__, __LINE__);
$user = mysqli_fetch_assoc($res) or stderr($lang['friends_error'], $lang['friends_no_user']);
$HTMLOUT = '';
//== Pending
$i = 0;
$res = sql_query("SELECT f.userid as id, u.username, u.class, u.avatar, u.title, u.donor, u.warned, u.enabled, u.leechwarn, u.chatpost, u.pirate, u.king, u.last_access, u.perms FROM friends AS f LEFT JOIN users as u ON f.userid = u.id WHERE friendid=" . sqlesc($CURUSER['id']) . " AND f.confirmed='no' AND NOT f.userid IN (SELECT blockid FROM blocks WHERE blockid=f.userid) ORDER BY username") or sqlerr(__FILE__, __LINE__);
$friendsp = '';
if (mysqli_num_rows($res) == 0) $friendsp = "<em>{$lang['friends_pending_empty']}.</em>";
else while ($friendp = mysqli_fetch_assoc($res)) {
    $dt = TIME_NOW - 180;
    $online = ($friendp["last_access"] >= $dt && $friendp['perms'] < bt_options::PERMS_STEALTH ? '&nbsp;<img src="' . $INSTALLER09['baseurl'] . '/images/staff/online.png" border="0" alt="Online" title="Online" />' : '<img src="' . $INSTALLER09['baseurl'] . '/images/staff/offline.png" border="0" alt="Offline" title="Offline" />');
    $title = htmlsafechars($friendp["title"]);
    if (!$title) $title = get_user_class_name($friendp["class"]);
    $linktouser = "<a href='userdetails.php?id=" . (int)$friendp['id'] . "'><b>" . format_username($friendp) . "</b></a>[$title]<br />{$lang['friends_last_seen']} " . ($friendp['perms'] < bt_options::PERMS_STEALTH ? get_date($friendp['last_access'], '') : "Never");
    $confirm = "<br /><span class='btn'><a href='{$INSTALLER09['baseurl']}/friends.php?id=$userid&amp;action=confirm&amp;type=friend&amp;targetid=" . (int)$friendp['id'] . "'>Confirm</a></span>";
    $block = "&nbsp;<span class='btn'><a href='{$INSTALLER09['baseurl']}/friends.php?action=add&amp;type=block&amp;targetid=" . (int)$friendp['id'] . "'>Block</a></span>";
    $avatar = ($CURUSER["avatars"] == "yes" ? htmlsafechars($friendp["avatar"]) : "");
    if (!$avatar) $avatar = "{$INSTALLER09['pic_base_url']}default_avatar.gif";
    $reject = "&nbsp;<span class='btn'><a href='{$INSTALLER09['baseurl']}/friends.php?id=$userid&amp;action=delpending&amp;type=friend&amp;targetid=" . (int)$friendp['id'] . "'>{$lang['friends_reject']}</a></span>";
    $friendsp.= "<div style='border: 1px solid black;padding:5px;'>" . ($avatar ? "<img width='50px' src='$avatar' style='float:right;' alt='Avatar' />" : "") . "<p >{$linktouser}<br /><br />{$confirm}{$block}{$reject}</p></div><br />";
}
//== Pending ends
//== Awaiting start
$res = sql_query("SELECT f.friendid as id, u.username, u.donor, u.class, u.warned, u.enabled, u.leechwarn, u.chatpost, u.pirate, u.king, u.last_access FROM friends AS f LEFT JOIN users as u ON f.friendid = u.id WHERE userid=" . sqlesc($userid) . " AND f.confirmed='no' ORDER BY username") or sqlerr(__FILE__, __LINE__);
$friendreqs = '';
if (mysqli_num_rows($res) == 0) $friendreqs = "<em>Your requests list is empty.</em>";
else {
    $i = 0;
    $friendreqs = "<table width='100%' cellspacing='0' cellpadding='0'>";
    while ($friendreq = mysqli_fetch_assoc($res)) {
        if ($i % 6 == 0) $friendreqs.= "<tr>";
        $friendreqs.= "<td style='border: none; padding: 4px; spacing: 0px;'><a href='{$INSTALLER09['baseurl']}/userdetails.php?id=" . (int)$friendreq['id'] . "'><b>" . format_username($friendreq) . "</b></a></td></tr>";
        if ($i % 6 == 5) $friendreqs.= "</tr>";
        $i++;
    }
    $friendreqs.= "</table>";
}
//== Awaiting ends
//== Friends block
$i = 0;
$res = sql_query("SELECT f.friendid as id, u.username, u.class, u.avatar, u.title, u.donor, u.warned, u.enabled, u.leechwarn, u.chatpost, u.pirate, u.king, u.last_access, u.uploaded, u.downloaded, u.country, u.perms FROM friends AS f LEFT JOIN users as u ON f.friendid = u.id WHERE userid=" . sqlesc($userid) . " AND f.confirmed='yes' ORDER BY username") or sqlerr(__FILE__, __LINE__);
$friends = '';
if (mysqli_num_rows($res) == 0) $friends = "<em>Your friends list is empty.</em>";
else while ($friend = mysqli_fetch_assoc($res)) {
    $dt = TIME_NOW - 180;
    $online = ($friend["last_access"] >= $dt && $friend['perms'] < bt_options::PERMS_STEALTH ? '&nbsp;<img src="' . $INSTALLER09['baseurl'] . '/images/staff/online.png" border="0" alt="Online" title="Online" />' : '<img src="' . $INSTALLER09['baseurl'] . '/images/staff/offline.png" border="0" alt="Offline" title="Offline" />');
    $title = htmlsafechars($friend["title"]);
    if (!$title) $title = get_user_class_name($friend["class"]);
    $ratio = member_ratio($friend['uploaded'], $INSTALLER09['ratio_free'] ? '0' : $friend['downloaded']);
    $linktouser = "<a href='userdetails.php?id=" . (int)$friend['id'] . "'><b>" . format_username($friend) . "</b></a>[$title]&nbsp;[$ratio]<br />{$lang['friends_last_seen']} " . ($friend['perms'] < bt_options::PERMS_STEALTH ? get_date($friend['last_access'], '') : "Never");
    $delete = "<span class='btn'><a href='{$INSTALLER09['baseurl']}/friends.php?id=$userid&amp;action=delete&amp;type=friend&amp;targetid=" . (int)$friend['id'] . "'>{$lang['friends_remove']}</a></span>";
    $pm_link = "&nbsp;<span class='btn'><a href='{$INSTALLER09['baseurl']}/pm_system.php?action=send_message&amp;receiver=" . (int)$friend['id'] . "'>{$lang['friends_pm']}</a></span>";
    $avatar = ($CURUSER["avatars"] == "yes" ? htmlsafechars($friend["avatar"]) : "");
    if (!$avatar) $avatar = "{$INSTALLER09['pic_base_url']}default_avatar.gif";
    $friends.= "<div style='border: 1px solid black;padding:5px;'>" . ($avatar ? "<img width='50px' src='$avatar' style='float:right;' alt='' />" : "") . "<p >{$linktouser}&nbsp;{$online}<br /><br />{$delete}{$pm_link}</p></div><br />";
}
//== Friends block end
//== Enemies block
$res = sql_query("SELECT b.blockid as id, u.username, u.donor, u.class, u.warned, u.enabled, u.leechwarn, u.chatpost, u.pirate, u.king, u.last_access FROM blocks AS b LEFT JOIN users as u ON b.blockid = u.id WHERE userid=" . sqlesc($userid) . " ORDER BY username") or sqlerr(__FILE__, __LINE__);
$blocks = '';
if (mysqli_num_rows($res) == 0) {
    $blocks = "{$lang['friends_blocks_empty']}<em>.</em>";
} else {
    while ($block = mysqli_fetch_assoc($res)) {
        $blocks.= "<div style='border: 1px solid black;padding:5px;'>";
        $blocks.= "<span class='btn' style='float:right;'><a href='{$INSTALLER09['baseurl']}/friends.php?id=$userid&amp;action=delete&amp;type=block&amp;targetid=" . (int)$block['id'] . "'>{$lang['friends_delete']}</a></span><br />";
        $blocks.= "<p><a href='userdetails.php?id=" . (int)$block['id'] . "'><b>" . format_username($block) . "</b></a></p></div><br />";
    }
}
// Enemies block end
//== OUput the shits \0/
//==country by pdq
function countries()
{
    global $mc1, $INSTALLER09;
    if (($ret = $mc1->get_value('countries::arr')) === false) {
        $res = sql_query("SELECT id, name, flagpic FROM countries ORDER BY name ASC") or sqlerr(__FILE__, __LINE__);
        while ($row = mysqli_fetch_assoc($res)) $ret[] = $row;
        $mc1->cache_value('countries::arr', $ret, $INSTALLER09['expires']['user_flag']);
    }
    return $ret;
}
$country = '';
$countries = countries();
foreach ($countries as $cntry) if ($cntry['id'] == $user['country']) {
    $country = "<img src=\"{$INSTALLER09['pic_base_url']}flag/{$cntry['flagpic']}\" alt=\"" . htmlsafechars($cntry['name']) . "\" style='margin-left: 8pt' />";
    break;
}
$HTMLOUT.= "<br />
  <table class='table table-bordered'>
  <tr><td class='embedded'><h1 style='margin:0px'>&nbsp;{$lang['friends_personal']}&nbsp;" . htmlsafechars($user['username'], ENT_QUOTES) . "&nbsp;$country</h1></td></tr></table>
  <br /><table class='main' width='750' border='0' cellspacing='0' cellpadding='0'>
  <tr>
  <td class='colhead'><h2 align='left' style='width:50%;'><a name='friends'>&nbsp;{$lang['friends_friends_list']}</a></h2></td>
  <td class='colhead'><h2 align='left' style='width:50%;vertical-align:top;'><a name='blocks'>&nbsp;{$lang['friends_blocks_list']}</a></h2></td>
  </tr>
  <tr>
  <td style='padding:10px;background-color:#777777;width:50%;'>$friends</td>
  <td style='padding:10px;background-color:#777777;' valign='top'>$blocks</td>
  </tr>
  </table>
  <br /><br />
  <table class='main' width='750' border='0' cellspacing='0' cellpadding='0'>
  <tr>
  <td class='colhead'><h2 align='left' style='width:50%;'><a name='friendsp'>&nbsp;{$lang['friends_pending_list']}</a></h2></td>
  <td class='colhead'><h2 align='left' style='width:50%;vertical-align:top;'><a name='friendreqs'>&nbsp;{$lang['friends_await_list']}</a></h2></td>
  </tr>
  <tr>
  <td style='padding:10px;background-color:#777777;width:50%;'>$friendsp</td>
  <td style='padding:10px;background-color:#777777;' valign='top'>$friendreqs</td>
  </tr>
  </table><p><a href='users.php'><b>{$lang['friends_user_list']}</b></a></p>";
echo stdhead("{$lang['friends_stdhead']} " . htmlsafechars($user['username'])) . $HTMLOUT . stdfoot();
?>
