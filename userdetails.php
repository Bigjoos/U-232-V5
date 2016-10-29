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
require_once CLASS_DIR . 'page_verify.php';
require_once (INCL_DIR . 'user_functions.php');
require_once INCL_DIR . 'bbcode_functions.php';
require_once INCL_DIR . 'html_functions.php';
require_once INCL_DIR . 'comment_functions.php';
require_once (INCL_DIR . 'function_onlinetime.php');
require_once (CLASS_DIR . 'class_user_options.php');
require_once (CLASS_DIR . 'class_user_options_2.php');
dbconn(false);
loggedinorreturn();
$lang = array_merge(load_language('global') , load_language('userdetails'));
if (function_exists('parked')) parked();
$newpage = new page_verify();
$newpage->create('mdk1@@9');
$stdhead = array(
    /** include css **/
    'css' => array(
     'jquery.treeview',
    )
);
$stdfoot = array(
    /** include js **/
    'js' => array(
        'java_klappe',
        'jquery.treeview.pack',
        'flip_box',
        'sprinkle',
        'flush_torrents'
    )
);
$id = (int)$_GET["id"];
if (!is_valid_id($id)) stderr($lang['userdetails_error'], "{$lang['userdetails_bad_id']}");
if (($user = $mc1->get_value('user' . $id)) === false) {
    $user_fields_ar_int = array(
        'id',
        'added',
        'last_login',
        'last_access',
        'curr_ann_last_check',
        'curr_ann_id',
        'stylesheet',
        'class',
        'override_class',
        'language',
        'av_w',
        'av_h',
        'country',
        'warned',
        'torrentsperpage',
        'topicsperpage',
        'postsperpage',
        'reputation',
        'dst_in_use',
        'auto_correct_dst',
        'chatpost',
        'smile_until',
        'vip_until',
        'freeslots',
        'free_switch',
        'invites',
        'invitedby',
        'uploadpos',
        'forumpost',
        'downloadpos',
        'immunity',
        'leechwarn',
        'last_browse',
        'sig_w',
        'sig_h',
        'forum_access',
        'hit_and_run_total',
        'donoruntil',
        'donated',
        'vipclass_before',
        'passhint',
        'avatarpos',
        'sendpmpos',
        'invitedate',
        'anonymous_until',
        'pirate',
        'king',
        'ssluse',
        'paranoia',
        'parked_until',
        'bjwins',
        'bjlosses',
        'irctotal',
        'last_access_numb',
        'onlinetime',
        'hits',
        'comments',
        'categorie_icon',
        'perms',
        'mood',
        'pms_per_page',
        'watched_user',
        'game_access',
        'reputation',
        'opt1',
        'opt2',
        'can_leech',
        'wait_time',
        'torrents_limit',
        'peers_limit',
        'torrent_pass_version',
    );
    $user_fields_ar_float = array(
        'time_offset',
        'total_donated'
    );
    $user_fields_ar_str = array(
        'username',
        'passhash',
        'secret',
        'torrent_pass',
        'email',
        'status',
        'editsecret',
        'privacy',
        'info',
        'acceptpms',
        'ip',
        'avatar',
        'title',
        'notifs',
        'enabled',
        'donor',
        'deletepms',
        'savepms',
        'show_shout',
        'show_staffshout',
        'shoutboxbg',
        'vip_added',
        'invite_rights',
        'anonymous',
        'disable_reason',
        'clear_new_tag_manually',
        'signatures',
        'signature',
        'highspeed',
        'hnrwarn',
        'parked',
        'hintanswer',
        'support',
        'supportfor',
        'invitees',
        'invite_on',
        'subscription_pm',
        'gender',
        'viewscloud',
        'tenpercent',
        'avatars',
        'offavatar',
        'hidecur',
        'signature_post',
        'forum_post',
        'avatar_rights',
        'offensive_avatar',
        'view_offensive_avatar',
        'google_talk',
        'msn',
        'aim',
        'yahoo',
        'website',
        'icq',
        'show_email',
        'gotgift',
        'hash1',
        'suspended',
        'warn_reason',
        'onirc',
        'birthday',
        'got_blocks',
        'pm_on_delete',
        'commentpm',
        'split',
        'browser',
        'got_moods',
        'show_pm_avatar',
        'watched_user_reason',
        'staff_notes',
        'where_is',
        'browse_icons',
        'forum_mod',
        'forums_mod',
        'altnick',
        'forum_sort',
        'pm_forced'
    );
    $user_fields = implode(', ', array_merge($user_fields_ar_int, $user_fields_ar_float, $user_fields_ar_str));
    $r1 = sql_query("SELECT " . $user_fields . " FROM users WHERE id=" . sqlesc($id)) or sqlerr(__FILE__, __LINE__);
    $user = mysqli_fetch_assoc($r1) or stderr($lang['userdetails_error'], "{$lang['userdetails_no_user']}");
    foreach ($user_fields_ar_int as $i) $user[$i] = (int)$user[$i];
    foreach ($user_fields_ar_float as $i) $user[$i] = (float)$user[$i];
    foreach ($user_fields_ar_str as $i) $user[$i] = $user[$i];
    $mc1->cache_value('user' . $id, $user, $INSTALLER09['expires']['user_cache']);
}
if ($user["status"] == "pending") stderr($lang['userdetails_error'], $lang['userdetails_pending']);
// user stats
$What_Cache = (XBT_TRACKER == true ? 'user_stats_xbt_' : 'user_stats_');
if (($user_stats = $mc1->get_value($What_Cache.$id)) === false) {
    $What_Expire = (XBT_TRACKER == true ? $INSTALLER09['expires']['user_stats_xbt'] : $INSTALLER09['expires']['user_stats']);
    $stats_fields_ar_int = array(
            'uploaded',
            'downloaded'
        );
        $stats_fields_ar_float = array(
            'seedbonus'
        );
        $stats_fields_ar_str = array(
            'modcomment',
            'bonuscomment'
        );
        $stats_fields = implode(', ', array_merge($stats_fields_ar_int, $stats_fields_ar_float, $stats_fields_ar_str));
    $sql_1 = sql_query('SELECT ' . $stats_fields . ' FROM users WHERE id= ' . sqlesc($id)) or sqlerr(__FILE__, __LINE__);
    $user_stats = mysqli_fetch_assoc($sql_1);
    foreach ($stats_fields_ar_int as $i) $user_stats[$i] = (int)$user_stats[$i];
    foreach ($stats_fields_ar_float as $i) $user_stats[$i] = (float)$user_stats[$i];
    foreach ($stats_fields_ar_str as $i) $user_stats[$i] = $user_stats[$i];
    $mc1->cache_value($What_Cache.$id, $user_stats, $What_Expire); // 5 mins
}
if (($user_status = $mc1->get_value('user_status_' . $id)) === false) {
    $sql_2 = sql_query('SELECT * FROM ustatus WHERE userid = ' . sqlesc($id));
    if (mysqli_num_rows($sql_2)) $user_status = mysqli_fetch_assoc($sql_2);
    else $user_status = array(
        'last_status' => '',
        'last_update' => 0,
        'archive' => ''
    );
    $mc1->add_value('user_status_' . $id, $user_status, $INSTALLER09['expires']['user_status']); // 30 days
    
}
//===  paranoid settings
if ($user['paranoia'] == 3 && $CURUSER['class'] < UC_STAFF && $CURUSER['id'] <> $id) {
    stderr($lang['userdetails_error'], '<span style="font-weight: bold; text-align: center;"><img src="pic/smilies/tinfoilhat.gif" alt="'.$lang['userdetails_tinfoil'].'" title="'.$lang['userdetails_tinfoil'].'" />
       '.$lang['userdetails_tinfoil2'].' <img src="pic/smilies/tinfoilhat.gif" alt="'.$lang['userdetails_tinfoil'].'" title="'.$lang['userdetails_tinfoil'].'"></span>');
    die();
}
//=== delete H&R
if (isset($_GET['delete_hit_and_run']) && $CURUSER['class'] >= UC_STAFF) {
    $delete_me = isset($_GET['delete_hit_and_run']) ? intval($_GET['delete_hit_and_run']) : 0;
    if (!is_valid_id($delete_me)) stderr($lang['userdetails_error'], $lang['userdetails_bad_id']);
    if(XBT_TRACKER === false) {
    sql_query('UPDATE snatched SET hit_and_run = \'0\', mark_of_cain = \'no\' WHERE id = ' . sqlesc($delete_me)) or sqlerr(__FILE__, __LINE__);
    } else {
    sql_query('UPDATE xbt_files_users SET hit_and_run = \'0\', mark_of_cain = \'no\' WHERE fid = ' . sqlesc($delete_me)) or sqlerr(__FILE__, __LINE__);
    }
    if (@mysqli_affected_rows($GLOBALS["___mysqli_ston"]) === 0) {
        stderr($lang['userdetails_error'], $lang['userdetails_notdeleted']);
    }
    header('Location: ?id=' . $id . '&completed=1');
    die();
}
$r = sql_query("SELECT t.id, t.name, t.seeders, t.leechers, c.name AS cname, c.image FROM torrents t LEFT JOIN categories c ON t.category = c.id WHERE t.owner = " . sqlesc($id) . " ORDER BY t.name") or sqlerr(__FILE__, __LINE__);
if (mysqli_num_rows($r) > 0) {
    $torrents = "<table class='table table-bordered'>" . "<tr><td class='text-center'>{$lang['userdetails_type']}</td><td class='text-center'>{$lang['userdetails_name']}</td><td class='text-center'>{$lang['userdetails_seeders']}</td><td class='text-center'>{$lang['userdetails_leechers']}</td></tr>\n";
    while ($a = mysqli_fetch_assoc($r)) {
        $cat = "<img src=\"{$INSTALLER09['pic_base_url']}/caticons/{$CURUSER['categorie_icon']}/" . htmlsafechars($a['image']) . "\" title=\"" . htmlsafechars($a['cname']) . "\" alt=\"" . htmlsafechars($a['cname']) . "\">";
        $torrents.= "<tr><td class='text-center'>$cat</td><td><a href='details.php?id=" . (int)$a['id'] . "&amp;hit=1'><b>" . htmlsafechars($a["name"]) . "</b></a></td>" . "<td class='text-right'>" . (int)$a['seeders'] . "</td><td class='text-right'>" . (int)$a['leechers'] . "</td></tr>\n";
    }
    $torrents.= "</table>";
}
if ($user['ip'] && ($CURUSER['class'] >= UC_STAFF || $user['id'] == $CURUSER['id'])) {
    $dom = @gethostbyaddr($user['ip']);
    $addr = ($dom == $user['ip'] || @gethostbyname($dom) != $user['ip']) ? $user['ip'] : $user['ip'] . ' (' . $dom . ')';
}
if ($user['added'] == 0 OR $user['perms'] & bt_options::PERMS_STEALTH) $joindate = "{$lang['userdetails_na']}";
else $joindate = get_date($user['added'], '');
$lastseen = $user["last_access"];
if ($lastseen == 0 OR $user['perms'] & bt_options::PERMS_STEALTH) $lastseen = "{$lang['userdetails_never']}";
else {
    $lastseen = get_date($user['last_access'], '', 0, 1);
}


/** #$^$&%$&@ invincible! NO IP LOGGING..pdq **/
if ((($user['class'] == UC_MAX OR $user['id'] == $CURUSER['id']) || ($user['class'] < UC_MAX) && $CURUSER['class'] == UC_MAX) && isset($_GET['invincible'])) {
    require_once (INCL_DIR . 'invincible.php');
    if ($_GET['invincible'] == 'yes') $HTMLOUT.= "<div class='row'><div class'col-md-4'>". invincible($id). "</div></div";
    elseif ($_GET['invincible'] == 'remove_bypass') $HTMLOUT.= "<div class='row'><div class'col-md-4'>".invincible($id, true, false);
    else $HTMLOUT.= invincible($id, false);
} // End

/** #$^$&%$&@ stealth!..pdq **/
if ((($user['class'] >= UC_STAFF OR $user['id'] == $CURUSER['id']) || ($user['class'] < UC_STAFF) && $CURUSER['class'] >= UC_STAFF) && isset($_GET['stealth'])) {
    require_once (INCL_DIR . 'stealth.php');
    if ($_GET['stealth'] == 'yes') $HTMLOUT.= "<div class='row'><div class'col-md-4'>". stealth($id). "</div></div";
    elseif ($_GET['stealth'] == 'no') $HTMLOUT.= "<div class='row'><div class'col-md-4'>". stealth($id, false). "</div></div";
} // End
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
    $country = "<img src=\"{$INSTALLER09['pic_base_url']}flag/{$cntry['flagpic']}\" alt=\"" . htmlsafechars($cntry['name']) . "\" style='margin-left: 8pt'>";
    break;
}
if (XBT_TRACKER == true) {
    $res = sql_query("SELECT x.fid, x.uploaded, x.downloaded, x.active, x.left, t.added, t.name as torrentname, t.size, t.category, t.seeders, t.leechers, c.name as catname, c.image FROM xbt_files_users x LEFT JOIN torrents t ON x.fid = t.id LEFT JOIN categories c ON t.category = c.id WHERE x.uid=" . sqlesc($id)) or sqlerr(__FILE__, __LINE__);
    while ($arr = mysqli_fetch_assoc($res)) {
        if ($arr['left'] == '0') $seeding[] = $arr;
        else $leeching[] = $arr;
    }
} else {
    $res = sql_query("SELECT p.torrent, p.uploaded, p.downloaded, p.seeder, t.added, t.name as torrentname, t.size, t.category, t.seeders, t.leechers, c.name as catname, c.image FROM peers p LEFT JOIN torrents t ON p.torrent = t.id LEFT JOIN categories c ON t.category = c.id WHERE p.userid=" . sqlesc($id)) or sqlerr(__FILE__, __LINE__);
    while ($arr = mysqli_fetch_assoc($res)) {
        if ($arr['seeder'] == 'yes') $seeding[] = $arr;
        else $leeching[] = $arr;
    }
}
//==userhits update by pdq
if (!(isset($_GET["hit"])) && $CURUSER["id"] <> $user["id"]) {
    $res = sql_query("SELECT added FROM userhits WHERE userid =" . sqlesc($CURUSER['id']) . " AND hitid = " . sqlesc($id) . " LIMIT 1") or sqlerr(__FILE__, __LINE__);
    $row = mysqli_fetch_row($res);
    if (!($row[0] > TIME_NOW - 3600)) {
        $hitnumber = $user['hits'] + 1;
        sql_query("UPDATE users SET hits = hits + 1 WHERE id = " . sqlesc($id)) or sqlerr(__FILE__, __LINE__);
        // do update hits userdetails cache
        $update['user_hits'] = ($user['hits'] + 1);
        $mc1->begin_transaction('MyUser_' . $id);
        $mc1->update_row(false, array(
            'hits' => $update['user_hits']
        ));
        $mc1->commit_transaction($INSTALLER09['expires']['curuser']);
        $mc1->begin_transaction('user' . $id);
        $mc1->update_row(false, array(
            'hits' => $update['user_hits']
        ));
        $mc1->commit_transaction($INSTALLER09['expires']['user_cache']);
        sql_query("INSERT INTO userhits (userid, hitid, number, added) VALUES(" . sqlesc($CURUSER['id']) . ", " . sqlesc($id) . ", " . sqlesc($hitnumber) . ", " . sqlesc(TIME_NOW) . ")") or sqlerr(__FILE__, __LINE__);
    }
}

$HTMLOUT = $perms = $stealth = $suspended = $watched_user = $h1_thingie = '';
if (($user['opt1'] & user_options::ANONYMOUS) && ($CURUSER['class'] < UC_STAFF && $user["id"] != $CURUSER["id"])) {
    $HTMLOUT.= "<table>";
    $HTMLOUT.= "<tr><td colspan='2' align='center'>{$lang['userdetails_anonymous']}</td></tr>";
    if ($user["avatar"]) $HTMLOUT.= "<tr><td colspan='2' align='center'><img src='" . htmlsafechars($user["avatar"]) . "'></td></tr>\n";
    if ($user["info"]) $HTMLOUT.= "<tr valign='top'><td align='left' colspan='2' class='text' bgcolor='#F4F4F0'>'" . format_comment($user["info"]) . "'</td></tr>\n";
    $HTMLOUT.= "<tr><td colspan='2' align='center'><form method='get' action='{$INSTALLER09['baseurl']}/pm_system.php?action=send_message'><input type='hidden' name='receiver' value='" . (int)$user["id"] . "'><input type='submit' value='{$lang['userdetails_sendmess']}' style='height: 23px'></form>";
    if ($CURUSER['class'] < UC_STAFF && $user["id"] != $CURUSER["id"]) {
        echo stdhead($lang['userdetails_anonymoususer']) . $HTMLOUT . stdfoot();
        die;
    }
    $HTMLOUT.= "</td></tr></table><br>";
}
$h1_thingie = ((isset($_GET['sn']) || isset($_GET['wu'])) ? '<h1>'.$lang['userdetails_updated'].'</h1>' : '');
if ($CURUSER["id"] <> $user["id"] && $CURUSER['class'] >= UC_STAFF) $suspended.= ($user['suspended'] == 'yes' ? '&nbsp;&nbsp;<img src="' . $INSTALLER09['pic_base_url'] . 'smilies/excl.gif" alt="'.$lang['userdetails_suspended'].'" title="'.$lang['userdetails_suspended'].'">&nbsp;<b>'.$lang['userdetails_usersuspended'].'</b>&nbsp;<img src="' . $INSTALLER09['pic_base_url'] . 'smilies/excl.gif" alt="'.$lang['userdetails_suspended'].'" title="'.$lang['userdetails_suspended'].'">' : '');
if ($CURUSER["id"] <> $user["id"] && $CURUSER['class'] >= UC_STAFF) $watched_user.= ($user['watched_user'] == 0 ? '' : '&nbsp;&nbsp;<img src="' . $INSTALLER09['pic_base_url'] . 'smilies/excl.gif" align="middle" alt="'.$lang['userdetails_watched'].'" title="'.$lang['userdetails_watched'].'"> <b>'.$lang['userdetails_watchlist1'].' <a href="staffpanel.php?tool=watched_users" >'.$lang['userdetails_watchlist2'].'</a></b> <img src="' . $INSTALLER09['pic_base_url'] . 'smilies/excl.gif" align="middle" alt="'.$lang['userdetails_watched'].'" title="'.$lang['userdetails_watched'].'">');
$perms.= ($CURUSER['class'] >= UC_STAFF ? (($user['perms'] & bt_options::PERMS_NO_IP) ? '&nbsp;&nbsp;<img src="' . $INSTALLER09['pic_base_url'] . 'smilies/super.gif" alt="'.$lang['userdetails_invincible'].'"  title="'.$lang['userdetails_invincible'].'">' : '') : '');
$stealth.= ($CURUSER['class'] >= UC_STAFF ? (($user['perms'] & bt_options::PERMS_STEALTH) ? '&nbsp;&nbsp;<img src="' . $INSTALLER09['pic_base_url'] . 'smilies/ninja.gif" alt="'.$lang['userdetails_stelth'].'"  title="'.$lang['userdetails_stelth'].'">' : '') : '');
$enabled = $user["enabled"] == 'yes';
$HTMLOUT.= "<table class='table table bordered'>" . "<tr><td><h2 style='margin:0px'>" . format_username($user, true) . "</h2>$country$perms$stealth$watched_user$suspended$h1_thingie</td></tr></table>\n";
if ($CURUSER['id'] != $user['id']) $HTMLOUT.= "<div class='col-sm-2'><h4><a href='{$INSTALLER09['baseurl']}/sharemarks.php?id=$id'>{$lang['userdetails_sharemarks']}</a></h4></div>";
if ($user['opt1'] & user_options::PARKED) $HTMLOUT.= "<p><b>{$lang['userdetails_parked']}</b></p>\n";
if (!$enabled) $HTMLOUT.= "<p><b>{$lang['userdetails_disabled']}</b></p>\n";
elseif ($CURUSER["id"] <> $user["id"]) {
    if (($friends = $mc1->get_value('Friends_' . $id)) === false) {
        $r3 = sql_query("SELECT id FROM friends WHERE userid=" . sqlesc($CURUSER['id']) . " AND friendid=" . sqlesc($id)) or sqlerr(__FILE__, __LINE__);
        $friends = mysqli_num_rows($r3);
        $mc1->cache_value('Friends_' . $id, $friends, $INSTALLER09['expires']['user_friends']);
    }
    if (($blocks = $mc1->get_value('Blocks_' . $id)) === false) {
        $r4 = sql_query("SELECT id FROM blocks WHERE userid=" . sqlesc($CURUSER['id']) . " AND blockid=" . sqlesc($id)) or sqlerr(__FILE__, __LINE__);
        $blocks = mysqli_num_rows($r4);
        $mc1->cache_value('Blocks_' . $id, $blocks, $INSTALLER09['expires']['user_blocks']);
    }
    if ($friends > 0) $HTMLOUT.= "<div class='row'><div class='col-md-1'><p><a href='friends.php?action=delete&amp;type=friend&amp;targetid=$id'>{$lang['userdetails_remove_friends']}</a></p></div>\n";
    else $HTMLOUT.= "<div class='row'><div class='col-md-1'><p><a href='friends.php?action=add&amp;type=friend&amp;targetid=$id'>{$lang['userdetails_add_friends']}</a></p></div>";
    if ($blocks > 0) $HTMLOUT.= "<div class='col-md-1'><p><a href='friends.php?action=delete&amp;type=block&amp;targetid=$id'>{$lang['userdetails_remove_blocks']}</a></p></div>\n";
    else $HTMLOUT.= "<div class='row'><div class='col-md-1'><p><a href='friends.php?action=add&amp;type=block&amp;targetid=$id'>{$lang['userdetails_add_blocks']}</a></p></div>\n";
}
//== 09 Shitlist by Sir_Snuggles
if ($CURUSER['class'] >= UC_STAFF) {
    $shitty = '';
    if (($shit_list = $mc1->get_value('shit_list_' . $id)) === false) {
        $check_if_theyre_shitty = sql_query("SELECT suspect FROM shit_list WHERE userid=" . sqlesc($CURUSER['id']) . " AND suspect=" . sqlesc($id)) or sqlerr(__FILE__, __LINE__);
        list($shit_list) = mysqli_fetch_row($check_if_theyre_shitty);
        $mc1->cache_value('shit_list_' . $id, $shit_list, $INSTALLER09['expires']['shit_list']);
    }
    if ($shit_list > 0) {
        $shitty = "<img src='pic/smilies/shit.gif' alt='Shit' title='Shit'>";
        $HTMLOUT.= "<div class='col-md-6'><b>" . $shitty . "&nbsp;{$lang['userdetails_shit1']} <a class='altlink' href='staffpanel.php?tool=shit_list&amp;action=shit_list'>{$lang['userdetails_here']}</a> {$lang['userdetails_shit2']}&nbsp;" . $shitty . "</b></div>";
    } elseif ($CURUSER["id"] <> $user["id"]) {
        $HTMLOUT.= "<div class='col-md-6'><a class='altlink' href='staffpanel.php?tool=shit_list&amp;action=shit_list&amp;action2=new&amp;shit_list_id=" . $id . "&amp;return_to=userdetails.php?id=" . $id . "'><b>{$lang['userdetails_shit3']}</b></a></div>";
    }
}

$HTMLOUT .="</div>";
if ($CURUSER['id'] == $user['id']) $HTMLOUT.= "
<div class='container'>
<div class='row'>
<div class='col-sm-4'><h3><a href='{$INSTALLER09['baseurl']}/usercp.php?action=default'>[{$lang['userdetails_editself']}]</a></h3></div>
<div class='col-sm-4 col-sm-pull-1'><h3><a href='{$INSTALLER09['baseurl']}/view_announce_history.php'>[{$lang['userdetails_announcements']}]</a></h3></div></div>";

//==invincible no iplogging and ban bypass by pdq
$invincible = $mc1->get_value('display_' . $CURUSER['id']);
if ($invincible) $HTMLOUT.= '<div class="col-sm-2 col-md-push-2"><h3>' . htmlsafechars($user['username']) . ' '.$lang['userdetails_is'].' ' . $invincible . ' '.$lang['userdetails_invincible'].'</h3></div>';

//== links to make invincible method 1(PERMS_NO_IP/ no log ip) and 2(PERMS_BYPASS_BAN/cannot be banned)
$HTMLOUT.= "<div class='container'>
<div class='row'>
<div class='col-md-5'>".($CURUSER['class'] === UC_MAX ? (($user['perms'] & bt_options::PERMS_NO_IP) ? ' [<a title=' . "\n" . '"'.$lang['userdetails_invincible_def1'].' ' . "\n" . ''.$lang['userdetails_invincible_def2'].'" href="userdetails.php?id=' . $id . '&amp;invincible=no">' . "\n" . ''.$lang['userdetails_invincible_remove'].'</a>]' . (($user['perms'] & bt_options::PERMS_BYPASS_BAN) ? ' - ' . "\n" . ' [<a title="'.$lang['userdetails_invincible_def3'].'' . "\n" . ' '.$lang['userdetails_invincible_def4'].'" href="userdetails.php?id=' . $id . '&amp;' . "\n" . 'invincible=remove_bypass">'.$lang['userdetails_remove_bypass'].'</a>]' : ' - [<a title="'.$lang['userdetails_invincible_def5'].' ' . "\n" . $lang['userdetails_invincible_def6'] . "\n" . ' '.$lang['userdetails_invincible_def7'].' ' . "\n" . ''.$lang['userdetails_invincible_def8'].'" href="userdetails.php?id=' . $id . '&amp;invincible=yes">' . "\n" . ''.$lang['userdetails_add_bypass'].'</a>]') : '[<a title="'.$lang['userdetails_invincible_def9'].'' . "
               \n" . ' '.$lang['userdetails_invincible_def0'].'" ' . "\n" . 'href="userdetails.php?id=' . $id . '&amp;invincible=yes">'.$lang['userdetails_make_invincible'].'</a>]') : '') ."</div></div>";

//==Stealth mode
$stealth = $mc1->get_value('display_stealth' . $CURUSER['id']);
if ($stealth) $HTMLOUT.= '<div class="row"><div class="col-md-6 col-md-pull-0"><h4>' . htmlsafechars($user['username']) . '&nbsp;' . $stealth . ' '.$lang['userdetails_in_stelth'].'</h4>';
$HTMLOUT.= "".($CURUSER['class'] >= UC_STAFF ? (($user['perms'] & bt_options::PERMS_STEALTH) ? '[<a title=' . "" . '"'.$lang['userdetails_stelth_def1'].' ' . "" . ' '.$lang['userdetails_stelth_def2'].'" href="userdetails.php?id=' . $id . '&amp;stealth=no">' . "" . ''.$lang['userdetails_stelth_disable'].'</a>]' : '[<a title="'.$lang['userdetails_stelth_def1'].'' . "
               " . ' '.$lang['userdetails_stelth_def2'].'" ' . "" . 'href="userdetails.php?id=' . $id . '&amp;stealth=yes">'.$lang['userdetails_stelth_enable'].'</a>]') : '')."</div></div>";
$HTMLOUT.= "</div></div>";
// ===donor count down
if ($user["donor"] && $CURUSER["id"] == $user["id"] || $CURUSER["class"] == UC_SYSOP) {
    $donoruntil = htmlsafechars($user['donoruntil']);
    if ($donoruntil == '0') $HTMLOUT.= "";
    else {
        $HTMLOUT.= "<br><div class='row'><div class='col-md-8 col-md-push-2'><b>{$lang['userdetails_donatedtill']} - " . get_date($user['donoruntil'], 'DATE') . "";
        $HTMLOUT.= " [ " . mkprettytime($donoruntil - TIME_NOW) . " ] {$lang['userdetails_togo']}...</b><font size=\"-2\"> {$lang['userdetails_renew']} <a class='altlink' href='{$INSTALLER09['baseurl']}/donate.php'>{$lang['userdetails_here']}</a>.</font></div></div>\n";
    }
}

$possible_actions = array(
    'torrents',
    'snatched',
    'general',
    'social',
    'activity',
    'comments',
    'edit',
    'default'
);
$action = isset($_GET["action"]) ? htmlsafechars(trim($_GET["action"])) : 'torrents';
if (!in_array($action, $possible_actions)) stderr('Error','<br><div class="alert alert-error span11">Error! Change a few things up and try submitting again.</div>');
             $HTMLOUT.= "</div>
<div class='container'>
<div style='display:inline-block;height:50px;'></div>
     <div class='row'>
    <div class='col-md-12'>
        <div class='nav offset1'>
        <ul class='nav nav-pills'>
       <li><a href='userdetails.php?id={$id}&amp;action=torrents'>{$lang['userdetails_torrents']}</a></li>
       <li><a href='userdetails.php?id={$id}&amp;action=snatched'>{$lang['userdetails_snatched_menu']}</a></li>
       <li><a href='userdetails.php?id={$id}&amp;action=general'>{$lang['userdetails_general']}</a></li>
       <li><a href='userdetails.php?id={$id}&amp;action=activity'>{$lang['userdetails_activity']}</a></li>
       <li><a href='userdetails.php?id={$id}&amp;action=comments'>{$lang['userdetails_usercomments']}</a></li>";
if ($CURUSER['class'] >= UC_STAFF && $user["class"] < $CURUSER['class']) {
    $HTMLOUT.= '<li><a href="userdetails.php?id='.$id.'&amp;action=edit">'.$lang['userdetails_edit_user'].'</a></li>';
}
        $HTMLOUT.= "</ul></div></div></div>
<div style='display:block;height:20px;'></div>
<div class='row well'>";
$HTMLOUT.= "<div id='tabvanilla' class='widget'>";
if ($action == "torrents") {
$HTMLOUT.= "<table class='table table-bordered'>";
if (curuser::$blocks['userdetails_page'] & block_userdetails::FLUSH && $BLOCKS['userdetails_flush_on']) {
    require_once (BLOCK_DIR . 'userdetails/flush.php');
}
if (curuser::$blocks['userdetails_page'] & block_userdetails::TRAFFIC && $BLOCKS['userdetails_traffic_on']) {
    require_once (BLOCK_DIR . 'userdetails/traffic.php');
}
if (curuser::$blocks['userdetails_page'] & block_userdetails::SHARE_RATIO && $BLOCKS['userdetails_share_ratio_on']) {
    require_once (BLOCK_DIR . 'userdetails/shareratio.php');
}
if (curuser::$blocks['userdetails_page'] & block_userdetails::SEEDTIME_RATIO && $BLOCKS['userdetails_seedtime_ratio_on']) {
    require_once (BLOCK_DIR . 'userdetails/seedtimeratio.php');
}
if (curuser::$blocks['userdetails_page'] & block_userdetails::TORRENTS_BLOCK && $BLOCKS['userdetails_torrents_block_on']) {
    require_once (BLOCK_DIR . 'userdetails/torrents_block.php');
}
if (curuser::$blocks['userdetails_page'] & block_userdetails::COMPLETED && $BLOCKS['userdetails_completed_on']/* && XBT_TRACKER == false*/) {
    require_once (BLOCK_DIR . 'userdetails/completed.php');
}
if (curuser::$blocks['userdetails_page'] & block_userdetails::CONNECTABLE_PORT && $BLOCKS['userdetails_connectable_port_on']) {
    require_once (BLOCK_DIR . 'userdetails/connectable.php');
}
$HTMLOUT.= "</table>";
}
if ($action == "snatched") {
$HTMLOUT.= "<table class='table table-bordered'>";
if (curuser::$blocks['userdetails_page'] & block_userdetails::TORRENTS_BLOCK && $BLOCKS['userdetails_torrents_block_on']) {
    require_once (BLOCK_DIR . 'userdetails/snatched_block.php');
}
if (curuser::$blocks['userdetails_page'] & block_userdetails::SNATCHED_STAFF && $BLOCKS['userdetails_snatched_staff_on']/* && XBT_TRACKER == false*/) {
    require_once (BLOCK_DIR . 'userdetails/snatched_staff.php');
}
$HTMLOUT.= "</table>";
}

if ($action == "general") {

$HTMLOUT.= "<table class='table table-bordered'>";
// === make sure prople can't see their own naughty history by snuggles
if (($CURUSER['id'] !== $user['id']) && ($CURUSER['class'] >= UC_STAFF)) {
    //=== watched user stuff
    $the_flip_box = '[ <a name="watched_user"></a><a class="altlink" href="#watched_user" onclick="javascript:flipBox(\'3\')" title="'.$lang['userdetails_flip1'].'">' . ($user['watched_user'] > 0 ? ''.$lang['userdetails_flip2'].' ' : ''.$lang['userdetails_flip3'].' ') . '<img onclick="javascript:flipBox(\'3\')" src="pic/panel_on.gif" name="b_3" style="vertical-align:middle;"   width="8" height="8" alt="'.$lang['userdetails_flip1'].'" title="'.$lang['userdetails_flip1'].'"></a> ]';
    $HTMLOUT.= '<tr><td class="rowhead">'.$lang['userdetails_watched'].'</td>
                            <td align="left">' . ($user['watched_user'] > 0 ? ''.$lang['userdetails_watched_since'].'  ' . get_date($user['watched_user'], '') . ' ' : ' '.$lang['userdetails_not_watched'].' ') . $the_flip_box . '
                            <div align="left" id="box_3" style="display:none">
                            <form method="post" action="member_input.php" name="notes_for_staff">
                            <input name="id" type="hidden" value="' . $id . '">
                            <input type="hidden" value="watched_user" name="action">
                            '.$lang['userdetails_add_watch'].'                  
                            <input type="radio" value="yes" name="add_to_watched_users"' . ($user['watched_user'] > 0 ? ' checked="checked"' : '') . '> '.$lang['userdetails_yes1'].'
                            <input type="radio" value="no" name="add_to_watched_users"' . ($user['watched_user'] == 0 ? ' checked="checked"' : '') . '> '.$lang['userdetails_no1'].' <br>
                            <span id="desc_text" style="color:red;font-size: xx-small;">* '.$lang['userdetails_watch_change1'].'<br>
                            '.$lang['userdetails_watch_change2'].'</span><br>
                            <textarea id="watched_reason" cols="50" rows="6" name="watched_reason">' . htmlsafechars($user['watched_user_reason']) . '</textarea><br>
                            <input id="watched_user_button" type="submit" value="'.$lang['userdetails_submit'].'" class="btn" name="watched_user_button">
                            </form></div> </td></tr>';
    //=== staff Notes
    $the_flip_box_4 = '[ <a name="staff_notes"></a><a class="altlink" href="#staff_notes" onclick="javascript:flipBox(\'4\')" name="b_4" title="'.$lang['userdetails_open_staff'].'">view <img onclick="javascript:flipBox(\'4\')" src="pic/panel_on.gif" name="b_4" style="vertical-align:middle;" width="8" height="8" alt="'.$lang['userdetails_open_staff'].'" title="'.$lang['userdetails_open_staff'].'"></a> ]';
    $HTMLOUT.= '<tr><td class="rowhead">'.$lang['userdetails_staffnotes'].'</td><td align="left">           
                            <a class="altlink" href="#staff_notes" onclick="javascript:flipBox(\'6\')" name="b_6" title="'.$lang['userdetails_aev_staffnote'].'">' . ($user['staff_notes'] !== '' ? ''.$lang['userdetails_vae'].' ' : ''.$lang['userdetails_add'].' ') . '<img onclick="javascript:flipBox(\'6\')" src="pic/panel_on.gif" name="b_6" style="vertical-align:middle;" width="8" height="8" alt="'.$lang['userdetails_aev_staffnote'].'" title="'.$lang['userdetails_aev_staffnote'].'"></a>
                            <div align="left" id="box_6" style="display:none">
                            <form method="post" action="member_input.php" name="notes_for_staff">
                            <input name="id" type="hidden" value="' . (int)$user['id'] . '">
                            <input type="hidden" value="staff_notes" name="action" id="action">
                            <textarea id="new_staff_note" cols="50" rows="6" name="new_staff_note">' . htmlsafechars($user['staff_notes']) . '</textarea>
                            <br><input id="staff_notes_button" type="submit" value="'.$lang['userdetails_submit'].'" class="btn" name="staff_notes_button"/>
                            </form>
                            </div> </td></tr>';
    //=== system comments
    $the_flip_box_7 = '[ <a name="system_comments"></a><a class="altlink" href="#system_comments" onclick="javascript:flipBox(\'7\')"  name="b_7" title="'.$lang['userdetails_open_system'].'">view <img onclick="javascript:flipBox(\'7\')" src="pic/panel_on.gif" name="b_7" style="vertical-align:middle;" width="8" height="8" alt="'.$lang['userdetails_open_system'].'" title="'.$lang['userdetails_open_system'].'"></a> ]';
    if (!empty($user_stats['modcomment'])) $HTMLOUT.= "<tr><td class='rowhead'>{$lang['userdetails_system']}</td><td align='left'>" . ($user_stats['modcomment'] != '' ? $the_flip_box_7 . '<div align="left" id="box_7" style="display:none"><hr>' . format_comment($user_stats['modcomment']) . '</div>' : '') . "</td></tr>";
}
//==Begin blocks
if (curuser::$blocks['userdetails_page'] & block_userdetails::SHOWFRIENDS && $BLOCKS['userdetails_showfriends_on']){
require_once (BLOCK_DIR . 'userdetails/showfriends.php');
}
if (curuser::$blocks['userdetails_page'] & block_userdetails::LOGIN_LINK && $BLOCKS['userdetails_login_link_on']) {
    require_once (BLOCK_DIR . 'userdetails/loginlink.php');
}
if (curuser::$blocks['userdetails_page'] & block_userdetails::JOINED && $BLOCKS['userdetails_joined_on']) {
    require_once (BLOCK_DIR . 'userdetails/joined.php');
}
if (curuser::$blocks['userdetails_page'] & block_userdetails::ONLINETIME && $BLOCKS['userdetails_online_time_on']) {
    require_once (BLOCK_DIR . 'userdetails/onlinetime.php');
}
if (curuser::$blocks['userdetails_page'] & block_userdetails::BROWSER && $BLOCKS['userdetails_browser_on']) {
    require_once (BLOCK_DIR . 'userdetails/browser.php');
}
if (curuser::$blocks['userdetails_page'] & block_userdetails::BIRTHDAY && $BLOCKS['userdetails_birthday_on']) {
    require_once (BLOCK_DIR . 'userdetails/birthday.php');
}
if (curuser::$blocks['userdetails_page'] & block_userdetails::CONTACT_INFO && $BLOCKS['userdetails_contact_info_on']) {
    require_once (BLOCK_DIR . 'userdetails/contactinfo.php');
}
if (curuser::$blocks['userdetails_page'] & block_userdetails::IPHISTORY && $BLOCKS['userdetails_iphistory_on']) {
    require_once (BLOCK_DIR . 'userdetails/iphistory.php');
}
if (curuser::$blocks['userdetails_page'] & block_userdetails::AVATAR && $BLOCKS['userdetails_avatar_on']) {
    require_once (BLOCK_DIR . 'userdetails/avatar.php');
}
if (curuser::$blocks['userdetails_page'] & block_userdetails::USERCLASS && $BLOCKS['userdetails_userclass_on']) {
    require_once (BLOCK_DIR . 'userdetails/userclass.php');
}
if (curuser::$blocks['userdetails_page'] & block_userdetails::GENDER && $BLOCKS['userdetails_gender_on']) {
    require_once (BLOCK_DIR . 'userdetails/gender.php');
}
if (curuser::$blocks['userdetails_page'] & block_userdetails::USERINFO && $BLOCKS['userdetails_userinfo_on']) {
    require_once (BLOCK_DIR . 'userdetails/userinfo.php');
}
if (curuser::$blocks['userdetails_page'] & block_userdetails::REPORT_USER && $BLOCKS['userdetails_report_user_on']) {
    require_once (BLOCK_DIR . 'userdetails/report.php');
}
if (curuser::$blocks['userdetails_page'] & block_userdetails::USERSTATUS && $BLOCKS['userdetails_user_status_on']) {
    require_once (BLOCK_DIR . 'userdetails/userstatus.php');
}
if (curuser::$blocks['userdetails_page'] & block_userdetails::SHOWPM && $BLOCKS['userdetails_showpm_on']) {
    require_once (BLOCK_DIR . 'userdetails/showpm.php');
}
$HTMLOUT.= "</table>";
}
if ($action == "activity") {
$HTMLOUT.= "<table class='table table-bordered'>";
//==where is user now
if (!empty($user['where_is'])) $HTMLOUT.= "<tr><td class='rowhead' width='1%'>{$lang['userdetails_location']}</td><td align='left' width='99%'>" . format_urls($user['where_is']) . "</td></tr>";
//==
if ($INSTALLER09['mood_sys_on']) {
$moodname = (isset($mood['name'][$user['mood']]) ? htmlsafechars($mood['name'][$user['mood']]) : $lang['userdetails_neutral']);
$moodpic = (isset($mood['image'][$user['mood']]) ? htmlsafechars($mood['image'][$user['mood']]) : 'noexpression.gif');
$HTMLOUT.= '<tr><td class="rowhead">'.$lang['userdetails_currentmood'].'</td><td align="left"><span class="tool">
       <a href="javascript:;" onclick="PopUp(\'usermood.php\',\''.$lang['userdetails_mood'].'\',530,500,1,1);">
       <img src="' . $INSTALLER09['pic_base_url'] . 'smilies/' . $moodpic . '" alt="' . $moodname . '" border="0">
       <span class="tip">' . htmlsafechars($user['username']) . ' ' . $moodname . ' !</span></a></span></td></tr>'; 
}
if (curuser::$blocks['userdetails_page'] & block_userdetails::SEEDBONUS && $BLOCKS['userdetails_seedbonus_on']) {
    require_once (BLOCK_DIR . 'userdetails/seedbonus.php');
}
if (curuser::$blocks['userdetails_page'] & block_userdetails::IRC_STATS && $BLOCKS['userdetails_irc_stats_on']) {
    require_once (BLOCK_DIR . 'userdetails/irc.php');
}
if (curuser::$blocks['userdetails_page'] & block_userdetails::REPUTATION && $BLOCKS['userdetails_reputation_on'] && $INSTALLER09['rep_sys_on']) {
    require_once (BLOCK_DIR . 'userdetails/reputation.php');
}
if (curuser::$blocks['userdetails_page'] & block_userdetails::PROFILE_HITS && $BLOCKS['userdetails_profile_hits_on']) {
    require_once (BLOCK_DIR . 'userdetails/userhits.php');
}
if (curuser::$blocks['userdetails_page'] & block_userdetails::FREESTUFFS && $BLOCKS['userdetails_freestuffs_on'] && XBT_TRACKER == false) {
    require_once (BLOCK_DIR . 'userdetails/freestuffs.php');
}
if (curuser::$blocks['userdetails_page'] & block_userdetails::COMMENTS && $BLOCKS['userdetails_comments_on']) {
    require_once (BLOCK_DIR . 'userdetails/comments.php');
}
if (curuser::$blocks['userdetails_page'] & block_userdetails::FORUMPOSTS && $BLOCKS['userdetails_forumposts_on']) {
    require_once (BLOCK_DIR . 'userdetails/forumposts.php');
}
if (curuser::$blocks['userdetails_page'] & block_userdetails::INVITEDBY && $BLOCKS['userdetails_invitedby_on']) {
    require_once (BLOCK_DIR . 'userdetails/invitedby.php');
}
$HTMLOUT.= "</table>";
}
if ($action == "comments") {
if (curuser::$blocks['userdetails_page'] & block_userdetails::USERCOMMENTS && $BLOCKS['userdetails_user_comments_on']) {
    require_once (BLOCK_DIR . 'userdetails/usercomments.php');
}
}


if ($action == "edit") {
//==end blocks

$HTMLOUT.= "<script type='text/javascript'>
       /*<![CDATA[*/
       function togglepic(bu, picid, formid){
              var pic = document.getElementById(picid);
              var form = document.getElementById(formid);
           
              if(pic.src == bu + '/pic/plus.gif')   {
                    pic.src = bu + '/pic/minus.gif';
                    form.value = 'minus';
              }else{
                    pic.src = bu + '/pic/plus.gif';
                    form.value = 'plus';
              }
       }
       /*]]>*/
       </script>";
$HTMLOUT .='<script type="text/javascript">
			$(document).ready(function () {
				$("#browser").treeview();
			});
		</script>';

if ($CURUSER['class'] >= UC_STAFF && $user["class"] < $CURUSER['class']) {
    //$HTMLOUT .= begin_frame("Edit User", true);
    $HTMLOUT.= "<form class='form-horizontal' method='post' action='staffpanel.php?tool=modtask'>";
    require_once CLASS_DIR . 'validator.php';
    $HTMLOUT.= validatorForm('ModTask_' . $user['id']);
    $postkey = PostKey(array(
        $user['id'],
        $CURUSER['id']
    ));
    $HTMLOUT.= "<input class='form-control' type='hidden' name='action' value='edituser'>";
    $HTMLOUT.= "<input class='form-control' type='hidden' name='userid' value='$id'>";
    $HTMLOUT.= "<input class='form-control' type='hidden' name='postkey' value='$postkey'>";
    $HTMLOUT.= "<input class='form-control' type='hidden' name='returnto' value='userdetails.php?id=$id'>";
    $HTMLOUT.= "
         <table class='table table-bordered'>";
   
    $HTMLOUT.= "<div class='form-group'><div class='row'><div class='col-sm-6'><input class='form-control' placeholder='{$lang['userdetails_title']}' type='text'name='title' value='" . htmlsafechars($user['title']) . "'></div>";
    $avatar = htmlsafechars($user["avatar"]);
    $HTMLOUT.= "<div class='col-sm-6'><input class='form-control' placeholder='{$lang['userdetails_avatar_url']}' type='text' name='avatar' value='$avatar'></div></div>";
   
    $HTMLOUT.="<br>
	<div class='row'>
    <div class='col-sm-6'><textarea placeholder='{$lang['userdetails_signature']}' cols='60' rows='2' name='signature'>" . htmlsafechars($user['signature']) . "</textarea></div>
    <div class='col-sm-4'>{$lang['userdetails_signature_rights']}
    <input name='signature_post' value='yes' type='radio'".($user['signature_post'] == "yes" ? "    checked='checked'" : "").">{$lang['userdetails_yes']}
    <input name='signature_post' value='no' type='radio'".($user['signature_post'] == "no" ? " checked='checked'" : "").">{$lang['userdetails_disable_signature']}</div></div>
     <br>     
        <div class='row'>
    <div class='col-sm-4'><input class='form-control' placeholder='{$lang['userdetails_gtalk']}' type='text' name='google_talk' value='" . htmlsafechars($user['google_talk']) . "'></div>
    <div class='col-sm-4'><input class='form-control' placeholder='{$lang['userdetails_msn']}' type='text' name='msn' value='" . htmlsafechars($user['msn']) . "'></div>
    <div class='col-sm-4'><input class='form-control' placeholder='{$lang['userdetails_aim']}' type='text' size='60' name='aim' value='" . htmlsafechars($user['aim']) . "'></div></div>
    <br>      
        <div class='row'>
    <div class='col-sm-4'><input class='form-control' placeholder='{$lang['userdetails_yahoo']}' type='text' name='yahoo' value='" . htmlsafechars($user['yahoo']) . "'></div>
    <div class='col-sm-4'><input class='form-control' placeholder='{$lang['userdetails_icq']}' type='text' name='icq' value='" . htmlsafechars($user['icq']) . "'></div>
    <div class='col-sm-4'><input class='form-control' placeholder='{$lang['userdetails_website']}' type='text' name='website' value='" . htmlsafechars($user['website']) . "'></div></div><br>";
    

//== we do not want mods to be able to change user classes or amount donated...
    // === Donor mod time based by snuggles

    if ($CURUSER["class"] == UC_MAX) {
        $donor = $user["donor"] == "yes";
        $HTMLOUT.= "<div class='row'><div class='col-sm-1'><b>{$lang['userdetails_donor']}</b></div>";
        if ($donor) {
            $donoruntil = (int)$user['donoruntil'];
            if ($donoruntil == '0') $HTMLOUT.= $lang['userdetails_arbitrary'];
            else {
                $HTMLOUT.= "<b>" . $lang['userdetails_donor2'] . "</b> " . get_date($user['donoruntil'], 'DATE') . " ";
                $HTMLOUT.= " [ " . mkprettytime($donoruntil - TIME_NOW) . " ] {$lang['userdetails_togo']}";
            }
        } else {
            $HTMLOUT.= "<div class='col-sm-2'>{$lang['userdetails_dfor']}<select class='form-control' name='donorlength'><option value='0'>------</option><option value='4'>1 {$lang['userdetails_month']}</option>" . "<option value='6'>6 {$lang['userdetails_weeks']}</option><option value='8'>2 {$lang['userdetails_months']}</option><option value='10'>10 {$lang['userdetails_weeks']}</option>" . "<option value='12'>3 {$lang['userdetails_months']}</option><option value='255'>{$lang['userdetails_unlimited']}</option></select></div>";
        }
        $HTMLOUT.= "<div class='col-sm-2'><b>{$lang['userdetails_cdonation']}</b><input class='form-control' placeholder='{$lang['userdetails_cdonation']}' type='text' name='donated' value=\"" . htmlsafechars($user["donated"]) . "\">" . "<b>{$lang['userdetails_tdonations']}</b>" . htmlsafechars($user["total_donated"]) . "</div>";
        if ($donor) {
            $HTMLOUT.= "<div class='col-sm-2'><b>{$lang['userdetails_adonor']}</b><select class='form-control' name='donorlengthadd'><option value='0'>------</option><option value='4'>1 {$lang['userdetails_month']}</option>" . "<option value='6'>6 {$lang['userdetails_weeks']}</option><option value='8'>2 {$lang['userdetails_months']}</option><option value='10'>10 {$lang['userdetails_weeks']}</option>" . "<option value='12'>3 {$lang['userdetails_months']}</option><option value='255'>{$lang['userdetails_unlimited']}</option></select></div>";
            
	    $HTMLOUT.= "<div class='col-sm-2'>{$lang['userdetails_rdonor']}</b><input class='form-control' name='donor' value='no' type='checkbox'> [ {$lang['userdetails_bad']} ]</div>";
        }
        $HTMLOUT.= "<br>";
    }
    // ====End
    if ($CURUSER['class'] == UC_STAFF && $user["class"] > UC_VIP) $HTMLOUT.= "<input class='form-control'type='hidden' name='class' value='{$user['class']}'>";
    else {
        $HTMLOUT.= "<div class='col-sm-1 text-right'>Class</div><div class='col-sm-4'><select class='form-control' name='class'>";
        if ($CURUSER['class'] == UC_STAFF) $maxclass = UC_VIP;
        else $maxclass = $CURUSER['class'] - 1;
        for ($i = 0; $i <= $maxclass; ++$i) $HTMLOUT.= "<option value='$i'" . ($user["class"] == $i ? " selected='selected'" : "") . ">" . get_user_class_name($i) . "</option>";
        $HTMLOUT.= "</select></div></div>";
    }
    $supportfor = htmlsafechars($user["supportfor"]);
 
$HTMLOUT.= "<br><div class='row'><div class='col-sm-6'><textarea placeholder='{$lang['userdetails_supportfor']}' cols='60' rows='2' name='supportfor'>{$supportfor}</textarea></div>";

 $HTMLOUT.= "<div class='col-sm-1'>{$lang['userdetails_support']}</div><div class='col-sm-3'><input type='radio' name='support' value='yes'".($user["support"] == "yes" ? " checked='checked'" : "").">{$lang['userdetails_yes']}<input type='radio' name='support' value='no'".($user["support"] == "no" ? " checked='checked'" : "").">{$lang['userdetails_no']}</div></div>";


    $modcomment = htmlsafechars($user_stats["modcomment"]);
    if ($CURUSER["class"] < UC_SYSOP) {
        $HTMLOUT.= "<br><div class='row'><div class='col-sm-4'><p>{$lang['userdetails_comment']}</p><textarea class='shrink' placeholder='{$lang['userdetails_comment']}' cols='40' rows='6' name='modcomment' readonly='readonly'>$modcomment</textarea></div>";
    } else {
        $HTMLOUT.= "<br><div class='row'><div class='col-sm-4'><p>{$lang['userdetails_comment']}</p><textarea class='shrink' placeholder='{$lang['userdetails_comment']}' cols='40' rows='6' name='modcomment'>$modcomment</textarea></div>";
    }
    $HTMLOUT.= "<div class='col-sm-4'><p>{$lang['userdetails_add_comment']}</p><textarea class='shrink' placeholder='{$lang['userdetails_add_comment']}' cols='40' rows='6' name='addcomment'></textarea></div>";
    //=== bonus comment
    $bonuscomment = htmlsafechars($user_stats["bonuscomment"]);
    $HTMLOUT.= "<div class='col-sm-4'><p>{$lang['userdetails_bonus_comment']}</p><textarea class='shrink' placeholder='{$lang['userdetails_bonus_comment']}' cols='40' rows='6' name='bonuscomment' readonly='readonly' style='background:purple;color:yellow;'>$bonuscomment</textarea></div></div>";
    //==end
   
 $HTMLOUT.= "<br><div class='row'><div class='col-sm-1'>{$lang['userdetails_enabled']}</div><div class='col-sm-2'><input name='enabled' value='yes' type='radio'" . ($enabled ? " checked='checked'" : "") . ">{$lang['userdetails_yes']} <input name='enabled' value='no' type='radio'" . (!$enabled ? " checked='checked'" : "") . ">{$lang['userdetails_no']}</div>";
    




if ($CURUSER['class'] >= UC_STAFF && XBT_TRACKER == false) $HTMLOUT.= "<div class='col-sm-1'>{$lang['userdetails_freeleech_slots']}</div><div class='col-sm-1'><input class='form-control' type='text' name='freeslots' value='" . (int)$user['freeslots'] . "'></div>";
    
if ($CURUSER['class'] >= UC_ADMINISTRATOR && XBT_TRACKER == false) {
        $free_switch = $user['free_switch'] != 0;
        $HTMLOUT.= "<div class='col-sm-1 text-right'" . (!$free_switch ? '' : '') . ">{$lang['userdetails_freeleech_status']}</div>
                <div class='col-sm-1'>" . ($free_switch ? "<input name='free_switch' value='42' type='radio'>{$lang['userdetails_remove_freeleech']}" :'') . "</div>";
        if ($free_switch) {
            if ($user['free_switch'] == 1) $HTMLOUT.= '<div class="col-sm-2">('.$lang['userdetails_unlimited_d'].')</div>';
            else $HTMLOUT.= "<div class='col-sm-2'>{$lang['userdetails_until']} " . get_date($user['free_switch'], 'DATE') . " (" . mkprettytime($user['free_switch'] - TIME_NOW) . " {$lang['userdetails_togo']})</div>";
        } else {
            $HTMLOUT.= '<div class="col-sm-2">'.$lang['userdetails_freeleech_for'].' <select class="form-control" name="free_switch">
         <option value="0">------</option>
         <option value="1">1 '.$lang['userdetails_week'].'</option>
         <option value="2">2 '.$lang['userdetails_weeks'].'</option>
         <option value="4">4 '.$lang['userdetails_weeks'].'</option>
         <option value="8">8 '.$lang['userdetails_weeks'].'</option>
         <option value="90">'.$lang['userdetails_unlimited'].'</option>
         </select></div>
         <div class="col-sm-2">'.$lang['userdetails_pm_comment'].':<input class="form-control" type="text" name="free_pm"></div></div>';
        }
    }
    //==XBT - Can Leech
    if (XBT_TRACKER == true) {
        $HTMLOUT.= "<div class='col-sm-1'>{$lang['userdetails_canleech']}</div><div class='col-sm-3'><input type='radio' name='can_leech' value='1' " . ($user["can_leech"] == 1 ? " checked='checked'" : "") . ">{$lang['userdetails_yes']} <input type='radio' name='can_leech' value='0' " . ($user["can_leech"] == 0 ? " checked='checked'" : "") . ">{$lang['userdetails_no']}</div></div>";
    }
    


//==Download disable== editted for announce======//

    if ($CURUSER['class'] >= UC_STAFF && XBT_TRACKER == false) {
        $downloadpos = $user['downloadpos'] != 1;
        $HTMLOUT.= "<br><div class='row'><div class='col-sm-2'" . (!$downloadpos ? ' rowspan="2"' : '') . ">{$lang['userdetails_dpos']}</div>
               <div class='col-sm-2'>" . ($downloadpos ? "<input name='downloadpos' value='42' type='radio'>{$lang['userdetails_remove_download_d']}" : $lang['userdetails_no_disablement']) . "</div>";
        if ($downloadpos) {
            if ($user['downloadpos'] == 0) $HTMLOUT.= '<div class="col-sm-1">('.$lang['userdetails_unlimited_d'].')</div>';
            else $HTMLOUT.= "<div class='col-sm-2'>{$lang['userdetails_until']} " . get_date($user['downloadpos'], 'DATE') . " (" . mkprettytime($user['downloadpos'] - TIME_NOW) . " {$lang['userdetails_togo']})</div><div class='col-sm-6'><!--<input class='form-control' placeholder='Comments' type='text' name='disable_pm'></div></div>";
        } else {
            $HTMLOUT.= '<div class="col-sm-2">'.$lang['userdetails_disable_for'].' <select name="downloadpos">
        <option value="0">------</option>
        <option value="1">1 '.$lang['userdetails_week'].'</option>
        <option value="2">2 '.$lang['userdetails_weeks'].'</option>
        <option value="4">4 '.$lang['userdetails_weeks'].'</option>
        <option value="8">8 '.$lang['userdetails_weeks'].'</option>
        <option value="90">'.$lang['userdetails_unlimited'].'</option>
        </select></div>
        <div class="col-sm-6"><input class="form-control" placeholder="Comments" type="text" size="60" name="disable_pm"></div></div>';
        }
    }
    

//==Upload disable
    if ($CURUSER['class'] >= UC_STAFF) {
        $uploadpos = $user['uploadpos'] != 1;
        $HTMLOUT.= "<br><div class='row'><div class='col-sm-2'" . (!$uploadpos ? ' rowspan="2"' : '') . ">{$lang['userdetails_upos']}</div>
              <div class='col-sm-2'> " . ($uploadpos ? "<input name='uploadpos' value='42' type='radio'>{$lang['userdetails_remove_upload_d']}" : $lang['userdetails_no_disablement']) . "</div>";
        if ($uploadpos) {
            if ($user['uploadpos'] == 0) $HTMLOUT.= '<div class="col-sm-1">('.$lang['userdetails_unlimited_d'].')</div>';
            else $HTMLOUT.= "<div class='col-sm-2'>{$lang['userdetails_until']} " . get_date($user['uploadpos'], 'DATE') . " (" . mkprettytime($user['uploadpos'] - TIME_NOW) . " {$lang['userdetails_togo']})</div><div class='col-sm-6'><!--<input class='form-control' placeholder='Comments' type='text' name='updisable_pm'>--></div></div>";
        } else {
            $HTMLOUT.= '<div class="col-sm-2">'.$lang['userdetails_disable_for'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <select name="uploadpos">
        <option value="0">------</option>
        <option value="1">1 '.$lang['userdetails_week'].'</option>
        <option value="2">2 '.$lang['userdetails_weeks'].'</option>
        <option value="4">4 '.$lang['userdetails_weeks'].'</option>
        <option value="8">8 '.$lang['userdetails_weeks'].'</option>
        <option value="90">'.$lang['userdetails_unlimited'].'</option>
        </select></div>
        <div class="col-sm-6"><input class="form-control" placeholder="Comment" type="text" name="updisable_pm"></div></div>';
        }
    }
 


   //==
    //==Pm disable
    if ($CURUSER['class'] >= UC_STAFF) {
        $sendpmpos = $user['sendpmpos'] != 1;
        $HTMLOUT.= "<br><div class='row'><div class='col-sm-2'" . (!$sendpmpos ? ' rowspan="2"' : '') . ">{$lang['userdetails_pmpos']}</div>
               <div class='col-sm-2'>" . ($sendpmpos ? "<input name='sendpmpos' value='42' type='radio'>{$lang['userdetails_remove_pm_d']}" : $lang['userdetails_no_disablement']) . "</div>";
        if ($sendpmpos) {
            if ($user['sendpmpos'] == 0) $HTMLOUT.= '<div class="col-sm-1">('.$lang['userdetails_unlimited_d'].')</div>';
            else $HTMLOUT.= "<div class='col-sm-2'>{$lang['userdetails_until']} " . get_date($user['sendpmpos'], 'DATE') . " (" . mkprettytime($user['sendpmpos'] - TIME_NOW) . " {$lang['userdetails_togo']})</div><div class='col-sm-6'><!--<input placeholder='Comments' class='form-control' type='text' name='pmdisable_pm'>--></div></div>";
        } else {
            $HTMLOUT.= '<div class="col-sm-2">'.$lang['userdetails_disable_for'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <select name="sendpmpos">
        <option value="0">------</option>
        <option value="1">1 '.$lang['userdetails_week'].'</option>
        <option value="2">2 '.$lang['userdetails_weeks'].'</option>
        <option value="4">4 '.$lang['userdetails_weeks'].'</option>
        <option value="8">8 '.$lang['userdetails_weeks'].'</option>
        <option value="90">'.$lang['userdetails_unlimited'].'</option>
        </select></div>
        <div class="col-sm-6"><input placeholder="Comments" class="form-control" type="text" name="pmdisable_pm"></div></div>';
        }
    }
 


   //==Shoutbox disable
    if ($CURUSER['class'] >= UC_STAFF) {
        $chatpost = $user['chatpost'] != 1;
        $HTMLOUT.= "<br><div class='row'><div class='col-sm-2'" . (!$chatpost ? ' rowspan="2"' : '') . ">{$lang['userdetails_chatpos']}</div>
               <div class='col-sm-2'>" . ($chatpost ? "<input name='chatpost' value='42' type='radio'>{$lang['userdetails_remove_shout_d']}" : $lang['userdetails_no_disablement']) . "</div>";
        if ($chatpost) {
            if ($user['chatpost'] == 0) $HTMLOUT.= '<div class="col-sm-1">('.$lang['userdetails_unlimited_d'].')</div>';
            else $HTMLOUT.= "<div class='col-sm-2'>{$lang['userdetails_until']} " . get_date($user['chatpost'], 'DATE') . " (" . mkprettytime($user['chatpost'] - TIME_NOW) . " {$lang['userdetails_togo']})</div><div class='col-sm-6'><!--<input placeholder='Comments' class='form-control' type='text' name='chatdisable_pm'>--></div></div>";
        } else {
            $HTMLOUT.= '<div class="col-sm-2">'.$lang['userdetails_disable_for'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <select name="chatpost">
        <option value="0">------</option>
        <option value="1">1 '.$lang['userdetails_week'].'</option>
        <option value="2">2 '.$lang['userdetails_weeks'].'</option>
        <option value="4">4 '.$lang['userdetails_weeks'].'</option>
        <option value="8">8 '.$lang['userdetails_weeks'].'</option>
        <option value="90">'.$lang['userdetails_unlimited'].'</option>
        </select></div>
        <div class="col-sm-6"><input placeholder="Comments" class="form-control" type="text" name="chatdisable_pm"></div></div>';
        }
    }
 

   //==Avatar disable
    if ($CURUSER['class'] >= UC_STAFF) {
        $avatarpos = $user['avatarpos'] != 1;
        $HTMLOUT.= "<br><div class='row'><div class='col-sm-2'" . (!$avatarpos ? ' rowspan="2"' : '') . ">{$lang['userdetails_avatarpos']}</div>
          <div class='col-sm-2'>" . ($avatarpos ? "<input name='avatarpos' value='42' type='radio'>{$lang['userdetails_remove_avatar_d']}" : $lang['userdetails_no_disablement']) . "</div>";
        if ($avatarpos) {
            if ($user['avatarpos'] == 0) $HTMLOUT.= '<div class="col-sm-1">('.$lang['userdetails_unlimited_d'].')</div>';
            else $HTMLOUT.= "<div class='col-sm-2'>{$lang['userdetails_until']} " . get_date($user['avatarpos'], 'DATE') . " (" . mkprettytime($user['avatarpos'] - TIME_NOW) . " {$lang['userdetails_togo']})</div><div class='col-sm-6'><!--<input placeholder='Comments' class='form-control' type='text' name='avatardisable_pm'>--></div></div>";
        } else {
            $HTMLOUT.= '<div class="col-sm-2">'.$lang['userdetails_disable_for'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <select name="avatarpos">
        <option value="0">------</option>
        <option value="1">1 '.$lang['userdetails_week'].'</option>
        <option value="2">2 '.$lang['userdetails_weeks'].'</option>
        <option value="4">4 '.$lang['userdetails_weeks'].'</option>
        <option value="8">8 '.$lang['userdetails_weeks'].'</option>
        <option value="90">'.$lang['userdetails_unlimited'].'</option>
        </select></div>
        <div class="col-sm-6"><input placeholder="Comments" class="form-control" type="text" name="avatardisable_pm"></div></div>';
        }
    }


    //==Immunity
    if ($CURUSER['class'] >= UC_STAFF) {
        $immunity = $user['immunity'] != 0;
        $HTMLOUT.= "<br><div class='row'><div class='col-sm-2'" . (!$immunity ? ' rowspan="2"' : '') . ">{$lang['userdetails_immunity']}</div>
               <div class='col-sm-2'>" . ($immunity ? "<input name='immunity' value='42' type='radio'>{$lang['userdetails_remove_immunity']}" : $lang['userdetails_no_immunity']) . "</div>";
        if ($immunity) {
            if ($user['immunity'] == 1) $HTMLOUT.= '<div class="col-sm-1">('.$lang['userdetails_unlimited_d'].')</div>';
            else $HTMLOUT.= "<div class='col-sm-2'>{$lang['userdetails_until']} " . get_date($user['immunity'], 'DATE') . " (" . mkprettytime($user['immunity'] - TIME_NOW) . " {$lang['userdetails_togo']})</div><div class='col-sm-6'><!--<input placeholder='Comments' class='form-control' type='text'  name='immunity_pm'>--></div></div>";
        } else {
            $HTMLOUT.= '<div class="col-sm-2">'.$lang['userdetails_immunity_for'].'&nbsp;&nbsp;&nbsp;&nbsp; <select name="immunity">
        <option value="0">------</option>
        <option value="1">1 '.$lang['userdetails_week'].'</option>
        <option value="2">2 '.$lang['userdetails_weeks'].'</option>
        <option value="4">4 '.$lang['userdetails_weeks'].'</option>
        <option value="8">8 '.$lang['userdetails_weeks'].'</option>
        <option value="90">'.$lang['userdetails_unlimited'].'</option>
        </select></div>
        <div class="col-sm-6"><input placeholder="Comments" class="form-control" type="text"  name="immunity_pm"></div></div>';
        }
    }
 

   //==End
    //==Leech Warnings
    if ($CURUSER['class'] >= UC_STAFF) {
        $leechwarn = $user['leechwarn'] != 0;
        $HTMLOUT.= "<br><div class='row'><div class='col-sm-2'" . (!$leechwarn ? ' rowspan="2"' : '') . ">{$lang['userdetails_leechwarn']}</div>
               <div class='col-sm-2'>" . ($leechwarn ? "<input name='leechwarn' value='42' type='radio'>{$lang['userdetails_remove_leechwarn']}" : $lang['userdetails_no_leechwarn']) . "</div>";
        if ($leechwarn) {
            if ($user['leechwarn'] == 1) $HTMLOUT.= '<div class="col-sm-1">('.$lang['userdetails_unlimited_d'].')</div>';
            else $HTMLOUT.= "<div class='col-sm-2'>{$lang['userdetails_until']} " . get_date($user['leechwarn'], 'DATE') . " (" . mkprettytime($user['leechwarn'] - TIME_NOW) . " {$lang['userdetails_togo']})</div><div class='col-sm-6'><!--<input placeholder='Comments' class='form-control' type='text' size='60' name='leechwarn_pm'>--></div></div>";
        } else {
            $HTMLOUT.= '<div class="col-sm-2">'.$lang['userdetails_leechwarn_for'].'&nbsp; <select name="leechwarn">
        <option value="0">------</option>
        <option value="1">1 '.$lang['userdetails_week'].'</option>
        <option value="2">2 '.$lang['userdetails_weeks'].'</option>
        <option value="4">4 '.$lang['userdetails_weeks'].'</option>
        <option value="8">8 '.$lang['userdetails_weeks'].'</option>
        <option value="90">'.$lang['userdetails_unlimited'].'</option>
        </select></div>
        <div class="col-sm-6"><input placeholder="Comments" class="form-control" type="text" name="leechwarn_pm"></div></div>';
        }
    }
    //==End
 

   //==Warnings
    if ($CURUSER['class'] >= UC_STAFF) {
        $warned = $user['warned'] != 0;
        $HTMLOUT.= "<br><div class='row'><div class='col-sm-2'" . (!$warned ? ' rowspan="2"' : '') . ">{$lang['userdetails_warned']}</div>
               <div class='col-sm-2'>" . ($warned ? "<input name='warned' value='42' type='radio'>{$lang['userdetails_remove_warned']}" : $lang['userdetails_no_warning']) . "</div>";
        if ($warned) {
            if ($user['warned'] == 1) $HTMLOUT.= '<div class="col-sm-1">('.$lang['userdetails_unlimited_d'].')</div>';
            else $HTMLOUT.= "<div class='col-sm-2'>{$lang['userdetails_until']} " . get_date($user['warned'], 'DATE') . " (" . mkprettytime($user['warned'] - TIME_NOW) . " {$lang['userdetails_togo']})</div><div class='col-sm-6'><!--<input placeholder='Comments' class='form-control' type='text' name='warned_pm'>--></div></div>";
        } else {
            $HTMLOUT.= '<div class="col-sm-2">' . $lang['userdetails_warn_for'] . '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<select name="warned">
        <option value="0">' . $lang['userdetails_warn0'] . '</option>
        <option value="1">' . $lang['userdetails_warn1'] . '</option>
        <option value="2">' . $lang['userdetails_warn2'] . '</option>
        <option value="4">' . $lang['userdetails_warn4'] . '</option>
        <option value="8">' . $lang['userdetails_warn8'] . '</option>
        <option value="90">' . $lang['userdetails_warninf'] . '</option>
        </select></div>
        <div class="col-sm-6"><input placeholder="Comments" class="form-control" type="text" name="warned_pm"></div></div>';
        }
    }
    //==End
    //==Games disable
    if ($CURUSER['class'] >= UC_STAFF) {
        $game_access = $user['game_access'] != 1;
        $HTMLOUT.= "<br><div class='row'><div class='col-sm-2'" . (!$game_access ? ' rowspan="2"' : '') . ">{$lang['userdetails_games']}</div>
           <div class='col-sm-2'>" . ($game_access ? "<input name='game_access' value='42' type='radio'>{$lang['userdetails_remove_game_d']}" : $lang['userdetails_no_disablement']) . "</div>";
        if ($game_access) {
            if ($user['game_access'] == 0) $HTMLOUT.= '<td align="center">('.$lang['userdetails_unlimited_d'].')</td></tr>';
            else $HTMLOUT.= "<div class='col-sm-2'>{$lang['userdetails_until']} " . get_date($user['game_access'], 'DATE') . " (" . mkprettytime($user['game_access'] - TIME_NOW) . " {$lang['userdetails_togo']})</div><div class='col-sm-6'><!--<input placeholder='Comments' class='form-control' type='text' name='game_disable_pm'>--></div></div>";
        } else {
            $HTMLOUT.= '<div class="col-sm-2">'.$lang['userdetails_disable_for'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<select name="game_access">
        <option value="0">------</option>
        <option value="1">1 '.$lang['userdetails_week'].'</option>
        <option value="2">2 '.$lang['userdetails_weeks'].'</option>
        <option value="4">4 '.$lang['userdetails_weeks'].'</option>
        <option value="8">8 '.$lang['userdetails_weeks'].'</option>
        <option value="90">'.$lang['userdetails_unlimited'].'</option>
        </select></div>
        <div class="col-sm-6"><input placeholder="Comments" class="form-control" type="text" name="game_disable_pm"></div></div>';
        }
    }
    
$HTMLOUT.="<div style='display:inline-block;height:100px;'></div>";

//Adjust up/down
    if ($CURUSER['class'] >= UC_ADMINISTRATOR) {
        $HTMLOUT.= "<div class='row'>
<div class='col-sm-1'>{$lang['userdetails_addupload']}<img src='{$INSTALLER09['pic_base_url']}plus.gif' alt='{$lang['userdetails_change_ratio']}' title='{$lang['userdetails_change_ratio']}!' id='uppic' onclick=\"togglepic('{$INSTALLER09['baseurl']}', 'uppic','upchange')\"></div>
<div class='col-sm-2'><input class='form-control' type='text' name='amountup'></div>
        
         <div class='col-sm-2'><select class='form-control'  name='formatup'>
         <option value='mb'>{$lang['userdetails_MB']}</option>
         <option value='gb'>{$lang['userdetails_GB']}</option></select></div>
<div class='col-sm-1'>
<input class='form-control' type='hidden' id='upchange' name='upchange' value='plus'></div>
         
<div class='col-sm-1'>{$lang['userdetails_adddownload']}<img src='{$INSTALLER09['pic_base_url']}plus.gif' alt='{$lang['userdetails_change_ratio']}' title='{$lang['userdetails_change_ratio']}!' id='downpic' onclick=\"togglepic('{$INSTALLER09['baseurl']}','downpic','downchange')\"></div>
<div class='col-sm-2'><input class='form-control' type='text' name='amountdown'></div>
         
         <div class='col-sm-2'><select class='form-control' name='formatdown'>
         <option value='mb'>{$lang['userdetails_MB']}</option>
         <option value='gb'>{$lang['userdetails_GB']}</option></select></div>

         <div class='col-sm-1'><input class='form-control' type='hidden' id='downchange' name='downchange' value='plus'>
         </div></div>";
    }

$HTMLOUT.="<div style='display:inline-block;height:50px;'></div>";

//==ALL BITS AND BOBS START HERE

if (XBT_TRACKER == true) {
        // == Wait time
        if ($CURUSER['class'] >= UC_STAFF) $HTMLOUT.= "<br><div class='row'>
			<div class='col-sm-1'>{$lang['userdetails_waittime']}<input class='form-control' type='text' name='wait_time' value='" . (int)$user['wait_time'] . "'></div>";
        // ==end
        // == Peers limit
        if ($CURUSER['class'] >= UC_STAFF) $HTMLOUT.= "<div class='col-sm-1'>{$lang['userdetails_peerslimit']}<input class='form-control' type='text'' name='peers_limit' value='" . (int)$user['peers_limit'] . "'></div>";
        // ==end
        // == Torrents limit
        if ($CURUSER['class'] >= UC_STAFF) $HTMLOUT.= "<div class='col-sm-1'>{$lang['userdetails_torrentslimit']}<input class='form-control' type='text' name='torrents_limit' value='" . (int)$user['torrents_limit'] . "'></div><!--</div>-->";
        // ==end
        
    }
    
//==High speed php announce
    if ($CURUSER["class"] == UC_MAX && XBT_TRACKER == false) {
         $HTMLOUT.= "<br><br><div class='col-sm-2'>{$lang['userdetails_highspeed']}<br><input type='radio' name='highspeed' value='yes' ".($user["highspeed"] == "yes" ? " checked='checked'" : "").">{$lang['userdetails_yes']} <input type='radio' name='highspeed' value='no' ".($user["highspeed"] == "no" ? " checked='checked'" : "").">{$lang['userdetails_no']}</div>";
    }
 

$HTMLOUT.="<div style='display:inline-block;height:50px;'></div>";

//==Invites
    $HTMLOUT.= "<div class='col-sm-1'>{$lang['userdetails_invright']}<input type='radio' name='invite_on' value='yes'".($user["invite_on"] == "yes" ? " checked='checked'" : "").">{$lang['userdetails_yes']}<input type='radio' name='invite_on' value='no'".($user["invite_on"] == "no" ? " checked='checked'" : "").">{$lang['userdetails_no']}</div>";
   $HTMLOUT.= "<div class='col-sm-1'><b>{$lang['userdetails_invites']}</b><input class='form-control' type='text'name='invites' value='" . htmlsafechars($user['invites']) . "'></div><!--</div>-->";
//==end invites
    
// == seedbonus
    if ($CURUSER['class'] >= UC_STAFF) $HTMLOUT.= "<div class='col-sm-2'>{$lang['userdetails_bonus_points']}<input class='form-control' type='text' name='seedbonus' value='" . (int)$user_stats['seedbonus'] . "'></div>";
    // ==end
    // == rep
    if ($CURUSER['class'] >= UC_STAFF) $HTMLOUT.= "<div class='col-sm-2'>{$lang['userdetails_rep_points']}<input class='form-control' type='text' name='reputation' value='" . (int)$user['reputation'] . "'></div></div>";
    // ==end

$HTMLOUT.="<div style='display:inline-block;height:50px;'></div>";
//==new row
    
	$HTMLOUT.= '<div class="row"><div class="col-sm-1">'.$lang['userdetails_hnr'].'<br><input class="form-control" type="text" name="hit_and_run_total" value="' . (int)$user['hit_and_run_total'] . '"></div>
                 
	<div class="col-sm-1">'.$lang['userdetails_suspended'].'<br><input name="suspended" value="yes" type="radio"'.($user['suspended'] == 'yes' ? ' checked="checked"' : '').'>'.$lang['userdetails_yes'].'
                     <input name="suspended" value="no" type="radio"'.($user['suspended'] == 'no' ? ' checked="checked"' : '').'></div><div class="col-sm-4">'.$lang['userdetails_no'].'
		 '.$lang['userdetails_suspended_reason'].'<input class="form-control" type="text" name="suspended_reason"></div>';
$HTMLOUT.= "
		<div class='col-sm-2'>{$lang['userdetails_paranoia']}<select class='form-control' name='paranoia'>
                      <option value='0'" . ($user['paranoia'] == 0 ? " selected='selected'" : "") . ">{$lang['userdetails_paranoia_0']}</option>
                      <option value='1'" . ($user['paranoia'] == 1 ? " selected='selected'" : "") . ">{$lang['userdetails_paranoia_1']}</option>
                      <option value='2'" . ($user['paranoia'] == 2 ? " selected='selected'" : "") . ">{$lang['userdetails_paranoia_2']}</option>
                      <option value='3'" . ($user['paranoia'] == 3 ? " selected='selected'" : "") . ">{$lang['userdetails_paranoia_3']}</option>
                      </select></div></div>";

$HTMLOUT.="<div style='display:inline-block;height:50px;'></div>";

//==new row

$HTMLOUT.= "<br><div class='row'>
	<div class='col-sm-2'>{$lang['userdetails_avatar_rights']}<br><input name='view_offensive_avatar' value='yes' type='radio'".($user['view_offensive_avatar'] == "yes" ? " checked='checked'" : "").">{$lang['userdetails_yes']}
                  <input name='view_offensive_avatar' value='no' type='radio'".($user['view_offensive_avatar'] == "no" ? " checked='checked'" : "").">{$lang['userdetails_no']} </div>
                 
                <div class='col-sm-2'>{$lang['userdetails_offensive']}<br><input name='offensive_avatar' value='yes' type='radio'".($user['offensive_avatar'] == "yes" ? " checked='checked'" : "").">{$lang['userdetails_yes']}
                  <input name='offensive_avatar' value='no' type='radio'".($user['offensive_avatar'] == "no" ? " checked='checked'" : "").">{$lang['userdetails_no']} </div>
               
                <div class='col-sm-2'>{$lang['userdetails_view_offensive']}<br>
                 <input name='avatar_rights' value='yes' type='radio'".($user['avatar_rights'] == "yes" ? " checked='checked'" : "").">{$lang['userdetails_yes']}
                  <input name='avatar_rights' value='no' type='radio'".($user['avatar_rights'] == "no" ? " checked='checked'" : "").">{$lang['userdetails_no']} </div>";
 
//users parked
     $HTMLOUT.= "<div class='col-sm-1'>{$lang['userdetails_park']}<br><input name='parked' value='yes' type='radio'".($user["parked"] == "yes" ? " checked='checked'" : "").">{$lang['userdetails_yes']} <input name='parked' value='no' type='radio'".($user["parked"] == "no" ? " checked='checked'" : "").">{$lang['userdetails_no']}</div>";
//end users parked     

//reset passkey
    $HTMLOUT.= "<div class='col-sm-2'>{$lang['userdetails_reset']}<br><input type='checkbox' name='reset_torrent_pass' value='1'><br><font class='small'>{$lang['userdetails_pass_msg']}</font></div></div>";
//end reset    

$HTMLOUT.="<div style='display:inline-block;height:50px;'></div>";

//==ANOTHER ROW

$HTMLOUT.= "
<div class='row'>

<div class='col-sm-2'>{$lang['userdetails_forum_rights']}<br><input name='forum_post' value='yes' type='radio'".($user['forum_post'] == "yes" ? " checked='checked'" : "").">{$lang['userdetails_yes']}
                     <input name='forum_post' value='no' type='radio'".($user['forum_post'] == "no" ? " checked='checked'" : "")."><br>{$lang['userdetails_forums_no']}</div>";
  

$HTMLOUT .="<div class=\"col-sm-2\">Forum Moderator<br><input name=\"forum_mod\" value=\"yes\" type=radio " . ($user["forum_mod"]=="yes" ? "checked=\"checked\"" : "") . ">Yes <input name=\"forum_mod\" value=\"no\" type=\"radio\" " . ($user["forum_mod"]=="no" ? "checked=\"checked\"" : "") . ">No</div>";
  

$q = sql_query("SELECT o.id as oid, o.name as oname, f.id as fid, f.name as fname FROM `over_forums` as o LEFT JOIN forums as f ON f.forum_id = o.id ") or sqlerr(__FILE__, __LINE__);
	while($a = mysqli_fetch_assoc($q))
		$boo[$a['oname']][] = array($a['fid'],$a['fname']);
	$forum_list = "<ul id=\"browser\" class=\"filetree treeview-gray\" style=\"width:50%;text-align:left;\">";
	foreach($boo as $fo=>$foo) {
		$forum_list .="<li class=\"closed\"><span class=\"folder\">".$fo."</span>";
		$forum_list .="<ul>";
			foreach($foo as $fooo)
				$forum_list .= "<li><label for=\"forum_".$fooo[0]."\"><span class=\"file\" style=\"position:relative;width:200px;\"><b>".$fooo[1]."</b><div style=\"display:inline-block;width:15px;\"></div><input type=\"checkbox\" ".(stristr($user["forums_mod"],"[".$fooo[0]."]") ? "checked=\"checked\"" : "" )."style=\"right:0;top:0;position:absolute;\" name=\"forums[]\" id=\"forum_".$fooo[0]."\" value=\"".$fooo[0]."\"></span></label></li>";
		$forum_list .= "</ul></li>";	
	}
	$forum_list .= "</ul>";
  

$HTMLOUT .="<div class=\"col-sm-8\">Forums List<br>".$forum_list."</div></div>";
   
    $HTMLOUT.= "<br><br><div class='row'><div class='col-sm-offset-5'><input type='submit' class='btn btn-default' value='{$lang['userdetails_okay']}'></div></div>";
    $HTMLOUT.= "</table>";
    $HTMLOUT.= "</form>";
    }
}
$HTMLOUT.= "</div></div>";
echo stdhead("{$lang['userdetails_details']} " . $user["username"], true, $stdhead) . $HTMLOUT . stdfoot($stdfoot);
?>
