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
/*
+------------------------------------------------
|   $Date$ 10022011
|   $Revision$ 1.0
|   $Author$ pdq,Bigjoos
|   $User block system
|   
+------------------------------------------------
*/
require_once (__DIR__ . DIRECTORY_SEPARATOR . 'include' . DIRECTORY_SEPARATOR . 'bittorrent.php');
require_once (INCL_DIR . 'html_functions.php');
require_once (INCL_DIR . 'user_functions.php');
dbconn(false);
loggedinorreturn();
//$lang = load_language('global');
$lang = array_merge(load_language('global'), load_language('user_blocks'));
$id = (isset($_GET['id']) ? $_GET['id'] : $CURUSER['id']);
if (!is_valid_id($id) || $CURUSER['class'] < UC_STAFF) $id = $CURUSER['id'];
if ($CURUSER['got_blocks'] == 'no') {
    stderr($lang['gl_error'], $lang['user_b_err1']);
    die;
}
    //$mc1->delete_value('blocks::' . $id);
    
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $updateset = array();
    $setbits_index_page = $clrbits_index_page = $setbits_global_stdhead = $clrbits_global_stdhead = $setbits_userdetails_page = $clrbits_userdetails_page = 0;
    //==Index
    if (isset($_POST['ie_alert'])) $setbits_index_page|= block_index::IE_ALERT;
    else $clrbits_index_page|= block_index::IE_ALERT;
    if (isset($_POST['news'])) $setbits_index_page|= block_index::NEWS;
    else $clrbits_index_page|= block_index::NEWS;
    if (isset($_POST['shoutbox'])) $setbits_index_page|= block_index::SHOUTBOX;
    else $clrbits_index_page|= block_index::SHOUTBOX;
    if (isset($_POST['active_users'])) $setbits_index_page|= block_index::ACTIVE_USERS;
    else $clrbits_index_page|= block_index::ACTIVE_USERS;
    if (isset($_POST['last_24_active_users'])) $setbits_index_page|= block_index::LAST_24_ACTIVE_USERS;
    else $clrbits_index_page|= block_index::LAST_24_ACTIVE_USERS;
    if (isset($_POST['irc_active_users'])) $setbits_index_page|= block_index::IRC_ACTIVE_USERS;
    else $clrbits_index_page|= block_index::IRC_ACTIVE_USERS;
    if (isset($_POST['birthday_active_users'])) $setbits_index_page|= block_index::BIRTHDAY_ACTIVE_USERS;
    else $clrbits_index_page|= block_index::BIRTHDAY_ACTIVE_USERS;
    if (isset($_POST['stats'])) $setbits_index_page|= block_index::STATS;
    else $clrbits_index_page|= block_index::STATS;
    if (isset($_POST['disclaimer'])) $setbits_index_page|= block_index::DISCLAIMER;
    else $clrbits_index_page|= block_index::DISCLAIMER;
    if (isset($_POST['latest_user'])) $setbits_index_page|= block_index::LATEST_USER;
    else $clrbits_index_page|= block_index::LATEST_USER;
    if (isset($_POST['forumposts'])) $setbits_index_page|= block_index::FORUMPOSTS;
    else $clrbits_index_page|= block_index::FORUMPOSTS;
    if (isset($_POST['latest_torrents'])) $setbits_index_page|= block_index::LATEST_TORRENTS;
    else $clrbits_index_page|= block_index::LATEST_TORRENTS;
    if (isset($_POST['latest_torrents_scroll'])) $setbits_index_page|= block_index::LATEST_TORRENTS_SCROLL;
    else $clrbits_index_page|= block_index::LATEST_TORRENTS_SCROLL;
    if (isset($_POST['announcement'])) $setbits_index_page|= block_index::ANNOUNCEMENT;
    else $clrbits_index_page|= block_index::ANNOUNCEMENT;
    if (isset($_POST['donation_progress'])) $setbits_index_page|= block_index::DONATION_PROGRESS;
    else $clrbits_index_page|= block_index::DONATION_PROGRESS;
    if (isset($_POST['advertisements'])) $setbits_index_page|= block_index::ADVERTISEMENTS;
    else $clrbits_index_page|= block_index::ADVERTISEMENTS;
    if (isset($_POST['radio'])) $setbits_index_page|= block_index::RADIO;
    else $clrbits_index_page|= block_index::RADIO;
    if (isset($_POST['torrentfreak'])) $setbits_index_page|= block_index::TORRENTFREAK;
    else $clrbits_index_page|= block_index::TORRENTFREAK;
    if (isset($_POST['xmas_gift'])) $setbits_index_page|= block_index::XMAS_GIFT;
    else $clrbits_index_page|= block_index::XMAS_GIFT;
    if (isset($_POST['active_poll'])) $setbits_index_page|= block_index::ACTIVE_POLL;
    else $clrbits_index_page|= block_index::ACTIVE_POLL;
    if (isset($_POST['staff_shoutbox'])) $setbits_index_page|= block_index::STAFF_SHOUT;
    else $clrbits_index_page|= block_index::STAFF_SHOUT;
    if (isset($_POST['movie_ofthe_week'])) $setbits_index_page|= block_index::MOVIEOFWEEK;
    else $clrbits_index_page|= block_index::MOVIEOFWEEK;
    if (isset($_POST['requests_and_offers'])) $setbits_index_page|= block_index::REQNOFF;
    else $clrbits_index_page|= block_index::REQNOFF;
    //==Stdhead
    if (isset($_POST['stdhead_freeleech'])) $setbits_global_stdhead|= block_stdhead::STDHEAD_FREELEECH;
    else $clrbits_global_stdhead|= block_stdhead::STDHEAD_FREELEECH;
    if (isset($_POST['stdhead_demotion'])) $setbits_global_stdhead|= block_stdhead::STDHEAD_DEMOTION;
    else $clrbits_global_stdhead|= block_stdhead::STDHEAD_DEMOTION;
    if (isset($_POST['stdhead_newpm'])) $setbits_global_stdhead|= block_stdhead::STDHEAD_NEWPM;
    else $clrbits_global_stdhead|= block_stdhead::STDHEAD_NEWPM;
    if (isset($_POST['stdhead_staff_message'])) $setbits_global_stdhead|= block_stdhead::STDHEAD_STAFF_MESSAGE;
    else $clrbits_global_stdhead|= block_stdhead::STDHEAD_STAFF_MESSAGE;
    if (isset($_POST['stdhead_reports'])) $setbits_global_stdhead|= block_stdhead::STDHEAD_REPORTS;
    else $clrbits_global_stdhead|= block_stdhead::STDHEAD_REPORTS;
    if (isset($_POST['stdhead_uploadapp'])) $setbits_global_stdhead|= block_stdhead::STDHEAD_UPLOADAPP;
    else $clrbits_global_stdhead|= block_stdhead::STDHEAD_UPLOADAPP;
    if (isset($_POST['stdhead_happyhour'])) $setbits_global_stdhead|= block_stdhead::STDHEAD_HAPPYHOUR;
    else $clrbits_global_stdhead|= block_stdhead::STDHEAD_HAPPYHOUR;
    if (isset($_POST['stdhead_crazyhour'])) $setbits_global_stdhead|= block_stdhead::STDHEAD_CRAZYHOUR;
    else $clrbits_global_stdhead|= block_stdhead::STDHEAD_CRAZYHOUR;
    if (isset($_POST['stdhead_bugmessage'])) $setbits_global_stdhead|= block_stdhead::STDHEAD_BUG_MESSAGE;
    else $clrbits_global_stdhead|= block_stdhead::STDHEAD_BUG_MESSAGE;
    if (isset($_POST['stdhead_freeleech_contribution'])) $setbits_global_stdhead|= block_stdhead::STDHEAD_FREELEECH_CONTRIBUTION;
    else $clrbits_global_stdhead|= block_stdhead::STDHEAD_FREELEECH_CONTRIBUTION;
    if (isset($_POST['stdhead_stafftools'])) $setbits_global_stdhead|= block_stdhead::STDHEAD_STAFFTOOLS;
    else $clrbits_global_stdhead|= block_stdhead::STDHEAD_STAFFTOOLS;
    //==Userdetails
    if (isset($_POST['userdetails_login_link'])) $setbits_userdetails_page|= block_userdetails::LOGIN_LINK;
    else $clrbits_userdetails_page|= block_userdetails::LOGIN_LINK;
    if (isset($_POST['userdetails_flush'])) $setbits_userdetails_page|= block_userdetails::FLUSH;
    else $clrbits_userdetails_page|= block_userdetails::FLUSH;
    if (isset($_POST['userdetails_joined'])) $setbits_userdetails_page|= block_userdetails::JOINED;
    else $clrbits_userdetails_page|= block_userdetails::JOINED;
    if (isset($_POST['userdetails_online_time'])) $setbits_userdetails_page|= block_userdetails::ONLINETIME;
    else $clrbits_userdetails_page|= block_userdetails::ONLINETIME;
    if (isset($_POST['userdetails_browser'])) $setbits_userdetails_page|= block_userdetails::BROWSER;
    else $clrbits_userdetails_page|= block_userdetails::BROWSER;
    if (isset($_POST['userdetails_reputation'])) $setbits_userdetails_page|= block_userdetails::REPUTATION;
    else $clrbits_userdetails_page|= block_userdetails::REPUTATION;
    if (isset($_POST['userdetails_user_hits'])) $setbits_userdetails_page|= block_userdetails::PROFILE_HITS;
    else $clrbits_userdetails_page|= block_userdetails::PROFILE_HITS;
    if (isset($_POST['userdetails_birthday'])) $setbits_userdetails_page|= block_userdetails::BIRTHDAY;
    else $clrbits_userdetails_page|= block_userdetails::BIRTHDAY;
    if (isset($_POST['userdetails_birthday'])) $setbits_userdetails_page|= block_userdetails::BIRTHDAY;
    else $clrbits_userdetails_page|= block_userdetails::BIRTHDAY;
    if (isset($_POST['userdetails_contact_info'])) $setbits_userdetails_page|= block_userdetails::CONTACT_INFO;
    else $clrbits_userdetails_page|= block_userdetails::CONTACT_INFO;
    if (isset($_POST['userdetails_iphistory'])) $setbits_userdetails_page|= block_userdetails::IPHISTORY;
    else $clrbits_userdetails_page|= block_userdetails::IPHISTORY;
    if (isset($_POST['userdetails_traffic'])) $setbits_userdetails_page|= block_userdetails::TRAFFIC;
    else $clrbits_userdetails_page|= block_userdetails::TRAFFIC;
    if (isset($_POST['userdetails_share_ratio'])) $setbits_userdetails_page|= block_userdetails::SHARE_RATIO;
    else $clrbits_userdetails_page|= block_userdetails::SHARE_RATIO;
    if (isset($_POST['userdetails_seedtime_ratio'])) $setbits_userdetails_page|= block_userdetails::SEEDTIME_RATIO;
    else $clrbits_userdetails_page|= block_userdetails::SEEDTIME_RATIO;
    if (isset($_POST['userdetails_seedbonus'])) $setbits_userdetails_page|= block_userdetails::SEEDBONUS;
    else $clrbits_userdetails_page|= block_userdetails::SEEDBONUS;
    if (isset($_POST['userdetails_irc_stats'])) $setbits_userdetails_page|= block_userdetails::IRC_STATS;
    else $clrbits_userdetails_page|= block_userdetails::IRC_STATS;
    if (isset($_POST['userdetails_connectable_port'])) $setbits_userdetails_page|= block_userdetails::CONNECTABLE_PORT;
    else $clrbits_userdetails_page|= block_userdetails::CONNECTABLE_PORT;
    if (isset($_POST['userdetails_avatar'])) $setbits_userdetails_page|= block_userdetails::AVATAR;
    else $clrbits_userdetails_page|= block_userdetails::AVATAR;
    if (isset($_POST['userdetails_userclass'])) $setbits_userdetails_page|= block_userdetails::USERCLASS;
    else $clrbits_userdetails_page|= block_userdetails::USERCLASS;
    if (isset($_POST['userdetails_gender'])) $setbits_userdetails_page|= block_userdetails::GENDER;
    else $clrbits_userdetails_page|= block_userdetails::GENDER;
    if (isset($_POST['userdetails_freestuffs'])) $setbits_userdetails_page|= block_userdetails::FREESTUFFS;
    else $clrbits_userdetails_page|= block_userdetails::FREESTUFFS;
    if (isset($_POST['userdetails_comments'])) $setbits_userdetails_page|= block_userdetails::COMMENTS;
    else $clrbits_userdetails_page|= block_userdetails::COMMENTS;
    if (isset($_POST['userdetails_forumposts'])) $setbits_userdetails_page|= block_userdetails::FORUMPOSTS;
    else $clrbits_userdetails_page|= block_userdetails::FORUMPOSTS;
    if (isset($_POST['userdetails_invitedby'])) $setbits_userdetails_page|= block_userdetails::INVITEDBY;
    else $clrbits_userdetails_page|= block_userdetails::INVITEDBY;
    if (isset($_POST['userdetails_torrents_block'])) $setbits_userdetails_page|= block_userdetails::TORRENTS_BLOCK;
    else $clrbits_userdetails_page|= block_userdetails::TORRENTS_BLOCK;
    if (isset($_POST['userdetails_completed'])) $setbits_userdetails_page|= block_userdetails::COMPLETED;
    else $clrbits_userdetails_page|= block_userdetails::COMPLETED;
    if (isset($_POST['userdetails_snatched_staff'])) $setbits_userdetails_page|= block_userdetails::SNATCHED_STAFF;
    else $clrbits_userdetails_page|= block_userdetails::SNATCHED_STAFF;
    if (isset($_POST['userdetails_userinfo'])) $setbits_userdetails_page|= block_userdetails::USERINFO;
    else $clrbits_userdetails_page|= block_userdetails::USERINFO;
    if (isset($_POST['userdetails_showpm'])) $setbits_userdetails_page|= block_userdetails::SHOWPM;
    else $clrbits_userdetails_page|= block_userdetails::SHOWPM;
    if (isset($_POST['userdetails_report_user'])) $setbits_userdetails_page|= block_userdetails::REPORT_USER;
    else $clrbits_userdetails_page|= block_userdetails::REPORT_USER;
    if (isset($_POST['userdetails_user_status'])) $setbits_userdetails_page|= block_userdetails::USERSTATUS;
    else $clrbits_userdetails_page|= block_userdetails::USERSTATUS;
    if (isset($_POST['userdetails_user_comments'])) $setbits_userdetails_page|= block_userdetails::USERCOMMENTS;
    else $clrbits_userdetails_page|= block_userdetails::USERCOMMENTS;
    if (isset($_POST['userdetails_showfriends'])) $setbits_userdetails_page|= block_userdetails::SHOWFRIENDS;
    else $clrbits_userdetails_page|= block_userdetails::SHOWFRIENDS;
    //== set n clear
    if ($setbits_index_page) $updateset[] = 'index_page = (index_page | ' . $setbits_index_page . ')';
    if ($clrbits_index_page) $updateset[] = 'index_page = (index_page & ~' . $clrbits_index_page . ')';
    if ($setbits_global_stdhead) $updateset[] = 'global_stdhead = (global_stdhead | ' . $setbits_global_stdhead . ')';
    if ($clrbits_global_stdhead) $updateset[] = 'global_stdhead = (global_stdhead & ~' . $clrbits_global_stdhead . ')';
    if ($setbits_userdetails_page) $updateset[] = 'userdetails_page = (userdetails_page | ' . $setbits_userdetails_page . ')';
    if ($clrbits_userdetails_page) $updateset[] = 'userdetails_page = (userdetails_page & ~' . $clrbits_userdetails_page . ')';
    if (count($updateset)) sql_query('UPDATE user_blocks SET ' . implode(',', $updateset) . ' WHERE userid = ' . sqlesc($id)) or sqlerr(__FILE__, __LINE__);
    $mc1->delete_value('blocks::' . $id);
    header('Location: ' . $INSTALLER09['baseurl'] . '/user_blocks.php');
    exit();
}
//==Index
$checkbox_index_ie_alert = ((curuser::$blocks['index_page'] & block_index::IE_ALERT) ? ' checked="checked"' : '');
$checkbox_index_news = ((curuser::$blocks['index_page'] & block_index::NEWS) ? ' checked="checked"' : '');
$checkbox_index_shoutbox = ((curuser::$blocks['index_page'] & block_index::SHOUTBOX) ? ' checked="checked"' : '');
$checkbox_index_active_users = ((curuser::$blocks['index_page'] & block_index::ACTIVE_USERS) ? ' checked="checked"' : '');
$checkbox_index_active_24h_users = ((curuser::$blocks['index_page'] & block_index::LAST_24_ACTIVE_USERS) ? ' checked="checked"' : '');
$checkbox_index_active_irc_users = ((curuser::$blocks['index_page'] & block_index::IRC_ACTIVE_USERS) ? ' checked="checked"' : '');
$checkbox_index_active_birthday_users = ((curuser::$blocks['index_page'] & block_index::BIRTHDAY_ACTIVE_USERS) ? ' checked="checked"' : '');
$checkbox_index_stats = ((curuser::$blocks['index_page'] & block_index::STATS) ? ' checked="checked"' : '');
$checkbox_index_disclaimer = ((curuser::$blocks['index_page'] & block_index::DISCLAIMER) ? ' checked="checked"' : '');
$checkbox_index_latest_user = ((curuser::$blocks['index_page'] & block_index::LATEST_USER) ? ' checked="checked"' : '');
$checkbox_index_latest_forumposts = ((curuser::$blocks['index_page'] & block_index::FORUMPOSTS) ? ' checked="checked"' : '');
$checkbox_index_latest_torrents = ((curuser::$blocks['index_page'] & block_index::LATEST_TORRENTS) ? ' checked="checked"' : '');
$checkbox_index_latest_torrents_scroll = ((curuser::$blocks['index_page'] & block_index::LATEST_TORRENTS_SCROLL) ? ' checked="checked"' : '');
$checkbox_index_announcement = ((curuser::$blocks['index_page'] & block_index::ANNOUNCEMENT) ? ' checked="checked"' : '');
$checkbox_index_donation_progress = ((curuser::$blocks['index_page'] & block_index::DONATION_PROGRESS) ? ' checked="checked"' : '');
$checkbox_index_ads = ((curuser::$blocks['index_page'] & block_index::ADVERTISEMENTS) ? ' checked="checked"' : '');
$checkbox_index_radio = ((curuser::$blocks['index_page'] & block_index::RADIO) ? ' checked="checked"' : '');
$checkbox_index_torrentfreak = ((curuser::$blocks['index_page'] & block_index::TORRENTFREAK) ? ' checked="checked"' : '');
$checkbox_index_xmasgift = ((curuser::$blocks['index_page'] & block_index::XMAS_GIFT) ? ' checked="checked"' : '');
$checkbox_index_active_poll = ((curuser::$blocks['index_page'] & block_index::ACTIVE_POLL) ? ' checked="checked"' : '');
$checkbox_index_staffshoutbox = ((curuser::$blocks['index_page'] & block_index::STAFF_SHOUT) ? ' checked="checked"' : '');
$checkbox_index_mow = ((curuser::$blocks['index_page'] & block_index::MOVIEOFWEEK) ? ' checked="checked"' : '');
$checkbox_index_reqnoff = ((curuser::$blocks['index_page'] & block_index::REQNOFF) ? ' checked="checked"' : '');
//==Stdhead
$checkbox_global_freeleech = ((curuser::$blocks['global_stdhead'] & block_stdhead::STDHEAD_FREELEECH) ? ' checked="checked"' : '');
$checkbox_global_demotion = ((curuser::$blocks['global_stdhead'] & block_stdhead::STDHEAD_DEMOTION) ? ' checked="checked"' : '');
$checkbox_global_message_alert = ((curuser::$blocks['global_stdhead'] & block_stdhead::STDHEAD_NEWPM) ? ' checked="checked"' : '');
$checkbox_global_staff_message_alert = ((curuser::$blocks['global_stdhead'] & block_stdhead::STDHEAD_STAFF_MESSAGE) ? ' checked="checked"' : '');
$checkbox_global_staff_report = ((curuser::$blocks['global_stdhead'] & block_stdhead::STDHEAD_REPORTS) ? ' checked="checked"' : '');
$checkbox_global_staff_uploadapp = ((curuser::$blocks['global_stdhead'] & block_stdhead::STDHEAD_UPLOADAPP) ? ' checked="checked"' : '');
$checkbox_global_happyhour = ((curuser::$blocks['global_stdhead'] & block_stdhead::STDHEAD_HAPPYHOUR) ? ' checked="checked"' : '');
$checkbox_global_crazyhour = ((curuser::$blocks['global_stdhead'] & block_stdhead::STDHEAD_CRAZYHOUR) ? ' checked="checked"' : '');
$checkbox_global_bugmessage = ((curuser::$blocks['global_stdhead'] & block_stdhead::STDHEAD_BUG_MESSAGE) ? ' checked="checked"' : '');
$checkbox_global_freeleech_contribution = ((curuser::$blocks['global_stdhead'] & block_stdhead::STDHEAD_FREELEECH_CONTRIBUTION) ? ' checked="checked"' : '');
$checkbox_global_stafftools = ((curuser::$blocks['global_stdhead'] & block_stdhead::STDHEAD_STAFFTOOLS) ? ' checked="checked"' : '');
//==Userdetails
$checkbox_userdetails_login_link = ((curuser::$blocks['userdetails_page'] & block_userdetails::LOGIN_LINK) ? ' checked="checked"' : '');
$checkbox_userdetails_flush = ((curuser::$blocks['userdetails_page'] & block_userdetails::FLUSH) ? ' checked="checked"' : '');
$checkbox_userdetails_joined = ((curuser::$blocks['userdetails_page'] & block_userdetails::JOINED) ? ' checked="checked"' : '');
$checkbox_userdetails_onlinetime = ((curuser::$blocks['userdetails_page'] & block_userdetails::ONLINETIME) ? ' checked="checked"' : '');
$checkbox_userdetails_browser = ((curuser::$blocks['userdetails_page'] & block_userdetails::BROWSER) ? ' checked="checked"' : '');
$checkbox_userdetails_reputation = ((curuser::$blocks['userdetails_page'] & block_userdetails::REPUTATION) ? ' checked="checked"' : '');
$checkbox_userdetails_userhits = ((curuser::$blocks['userdetails_page'] & block_userdetails::PROFILE_HITS) ? ' checked="checked"' : '');
$checkbox_userdetails_birthday = ((curuser::$blocks['userdetails_page'] & block_userdetails::BIRTHDAY) ? ' checked="checked"' : '');
$checkbox_userdetails_contact_info = ((curuser::$blocks['userdetails_page'] & block_userdetails::CONTACT_INFO) ? ' checked="checked"' : '');
$checkbox_userdetails_iphistory = ((curuser::$blocks['userdetails_page'] & block_userdetails::IPHISTORY) ? ' checked="checked"' : '');
$checkbox_userdetails_traffic = ((curuser::$blocks['userdetails_page'] & block_userdetails::TRAFFIC) ? ' checked="checked"' : '');
$checkbox_userdetails_shareratio = ((curuser::$blocks['userdetails_page'] & block_userdetails::SHARE_RATIO) ? ' checked="checked"' : '');
$checkbox_userdetails_seedtime_ratio = ((curuser::$blocks['userdetails_page'] & block_userdetails::SEEDTIME_RATIO) ? ' checked="checked"' : '');
$checkbox_userdetails_seedbonus = ((curuser::$blocks['userdetails_page'] & block_userdetails::SEEDBONUS) ? ' checked="checked"' : '');
$checkbox_userdetails_irc_stats = ((curuser::$blocks['userdetails_page'] & block_userdetails::IRC_STATS) ? ' checked="checked"' : '');
$checkbox_userdetails_connectable = ((curuser::$blocks['userdetails_page'] & block_userdetails::CONNECTABLE_PORT) ? ' checked="checked"' : '');
$checkbox_userdetails_avatar = ((curuser::$blocks['userdetails_page'] & block_userdetails::AVATAR) ? ' checked="checked"' : '');
$checkbox_userdetails_userclass = ((curuser::$blocks['userdetails_page'] & block_userdetails::USERCLASS) ? ' checked="checked"' : '');
$checkbox_userdetails_gender = ((curuser::$blocks['userdetails_page'] & block_userdetails::GENDER) ? ' checked="checked"' : '');
$checkbox_userdetails_freestuffs = ((curuser::$blocks['userdetails_page'] & block_userdetails::FREESTUFFS) ? ' checked="checked"' : '');
$checkbox_userdetails_torrent_comments = ((curuser::$blocks['userdetails_page'] & block_userdetails::COMMENTS) ? ' checked="checked"' : '');
$checkbox_userdetails_forumposts = ((curuser::$blocks['userdetails_page'] & block_userdetails::FORUMPOSTS) ? ' checked="checked"' : '');
$checkbox_userdetails_invitedby = ((curuser::$blocks['userdetails_page'] & block_userdetails::INVITEDBY) ? ' checked="checked"' : '');
$checkbox_userdetails_torrents_block = ((curuser::$blocks['userdetails_page'] & block_userdetails::TORRENTS_BLOCK) ? ' checked="checked"' : '');
$checkbox_userdetails_completed = ((curuser::$blocks['userdetails_page'] & block_userdetails::COMPLETED) ? ' checked="checked"' : '');
$checkbox_userdetails_snatched_staff = ((curuser::$blocks['userdetails_page'] & block_userdetails::SNATCHED_STAFF) ? ' checked="checked"' : '');
$checkbox_userdetails_userinfo = ((curuser::$blocks['userdetails_page'] & block_userdetails::USERINFO) ? ' checked="checked"' : '');
$checkbox_userdetails_showpm = ((curuser::$blocks['userdetails_page'] & block_userdetails::SHOWPM) ? ' checked="checked"' : '');
$checkbox_userdetails_report = ((curuser::$blocks['userdetails_page'] & block_userdetails::REPORT_USER) ? ' checked="checked"' : '');
$checkbox_userdetails_userstatus = ((curuser::$blocks['userdetails_page'] & block_userdetails::USERSTATUS) ? ' checked="checked"' : '');
$checkbox_userdetails_usercomments = ((curuser::$blocks['userdetails_page'] & block_userdetails::USERCOMMENTS) ? ' checked="checked"' : '');
$checkbox_userdetails_showfriends = ((curuser::$blocks['userdetails_page'] & block_userdetails::SHOWFRIENDS) ? ' checked="checked"' : '');
$HTMLOUT = '';
$HTMLOUT.= '<div class="container">
<h2 class="text-center">'.$lang['user_b_head'].'</h2><br>
<form class="form-horizontal col-sm-10 col-sm-offset-1" action="" method="post">
<ul id="myTab" class="nav nav-pills col-sm-offset-3">
   <li class="active"><a href="#Home" data-toggle="tab">'.$lang['user_b_title1'].'</a></li>   
   <li><a href="#site" data-toggle="tab">'.$lang['user_b_title2'].'</a></li>
   <li><a href="#user" data-toggle="tab">'.$lang['user_b_title3'].'</a></li>  
</ul><br>
<div style="display:block;height:20px;"></div>
<div id="myTabContent" class="tab-content"> 
<div class="tab-pane fade in active" id="Home">
 <fieldset><legend>'.$lang['user_b_title1'].'</legend></fieldset>
        <table class="table table-bordered">
        <tr><td class="userblock"><b>'.$lang['user_b_ie1'].'</b></td><td>
        <div class="checkbox-inline col-sm-offset-0"><label><input data-toggle="toggle" type="checkbox" id="ie_alert" name="ie_alert" value="yes"' . $checkbox_index_ie_alert . '></label>
        <span>'.$lang['user_b_chk'].''.$lang['user_b_ie2'].'</span></div>             
    </td>
    </tr>
        <tr class="userblock"><td><b>'.$lang['user_b_nb1'].'</b></td><td>
        <div class="checkbox-inline"><label><input data-toggle="toggle" type="checkbox" id="index_news" value="yes" name="news"' . $checkbox_index_news . '></label>
               <span>'.$lang['user_b_chk'].''.$lang['user_b_nb2'].'</span></div>
    </td>
        </tr>
        <tr class="userblock"><td><b>'.$lang['user_b_sh1'].'</b></td><td>
        <div class="checkbox-inline"><label><input data-toggle="toggle" type="checkbox" id="shoutbox" name="shoutbox" value="yes"' . $checkbox_index_shoutbox . '></label>
               <span>'.$lang['user_b_chk'].''.$lang['user_b_sh2'].'</span></div>
        </td>
        </tr>';
if ($CURUSER['class'] >= UC_STAFF) {
    $HTMLOUT.= '<tr class="userblock"><td><b>'.$lang['user_b_shst1'].'</b></td><td>
        <div class="checkbox-inline"><label><input data-toggle="toggle" type="checkbox" id="staffshout" name="staff_shoutbox" value="yes"' . $checkbox_index_staffshoutbox . '>
        </label><span>'.$lang['user_b_chk'].''.$lang['user_b_shst2'].'</span></div>
            </td>
        </tr>';
}
$HTMLOUT.= '<tr class="userblock"><td><b>'.$lang['user_b_actu1'].'</b></td><td>
        <div class="checkbox-inline"><label><input data-toggle="toggle" type="checkbox" id="active_users" name="active_users" value="yes"' . $checkbox_index_active_users . '>
        </label><span>'.$lang['user_b_chk'].''.$lang['user_b_actu2'].'</span></div>
            </td>
        </tr>       
        <tr class="userblock"><td><b>'.$lang['user_b_act24'].'</b></td><td>
        <div class="checkbox-inline"><label><input data-toggle="toggle" type="checkbox" id="active_users2" name="last_24_active_users" value="yes"' . $checkbox_index_active_24h_users . '>
        </label><span>'.$lang['user_b_chk'].''.$lang['user_b_act25'].'</span></div>
            </td>
        </tr>       
        <tr class="userblock"><td><b>'.$lang['user_b_irc1'].'</b></td><td>
        <div class="checkbox-inline"><label><input data-toggle="toggle" type="checkbox" id="active_users3" name="irc_active_users" value="yes"' . $checkbox_index_active_irc_users . '>
        </label><span>'.$lang['user_b_chk'].''.$lang['user_b_irc2'].'</span></div>       
        </td>
        </tr>
        <tr class="userblock"><td><b>'.$lang['user_b_bir1'].'</b></td><td>
         <div class="checkbox-inline"><label><input data-toggle="toggle" type="checkbox" id="birthday_active_users" name="birthday_active_users" value="yes"' . $checkbox_index_active_birthday_users . '>
        </label> <span>'.$lang['user_b_chk'].''.$lang['user_b_bir2'].'</span></div>
            </td>
        </tr>   
        <tr class="userblock"><td><b>'.$lang['user_b_sit1'].'</b></td><td>
         <div class="checkbox-inline"><label><input data-toggle="toggle" type="checkbox" id="stats" name="stats" value="yes"' . $checkbox_index_stats . '>
    </label><span>'.$lang['user_b_chk'].''.$lang['user_b_sit2'].'</span></div>        
        </td>
        </tr>       
        <tr class="userblock"><td><b>'.$lang['user_b_disc1'].'</b></td><td>
         <div class="checkbox-inline"><label><input data-toggle="toggle" type="checkbox" id="disclaimer" name="disclaimer" value="yes"' . $checkbox_index_disclaimer . '>
    </label><span>'.$lang['user_b_chk'].''.$lang['user_b_disc2'].'</span></div>
        </td>
        </tr>   
        <tr class="userblock"><td><b>'.$lang['user_b_last1'].'</b></td><td>
    <div class="checkbox-inline"><label><input data-toggle="toggle" type="checkbox" id="latest_user" name="latest_user" value="yes"' . $checkbox_index_latest_user . '>
    </label><span>'.$lang['user_b_chk'].''.$lang['user_b_last2'].'</span></div>
        </td>
        </tr>   
        <tr class="userblock"><td><b>'.$lang['user_b_fol1'].'</b></td><td>
    <div class="checkbox-inline"><label><input data-toggle="toggle" type="checkbox" id="forumposts" name="forumposts" value="yes"' . $checkbox_index_latest_forumposts . '>
    </label> <span>'.$lang['user_b_chk'].''.$lang['user_b_fol2'].'</span></div>
        </td>
        </tr>       
        <tr class="userblock"><td><b>'.$lang['user_b_torl1'].'</b></td><td>
        <div class="checkbox-inline"><label><input data-toggle="toggle" type="checkbox" id="latest_torrents" name="latest_torrents" value="yes"' . $checkbox_index_latest_torrents . '>
    </label><span>'.$lang['user_b_chk'].''.$lang['user_b_torl2'].'</span></div>
        </td>
        </tr>
        
        <tr class="userblock"><td><b>'.$lang['user_b_tors1'].'</b></td><td>
        <div class="checkbox-inline"><label><input data-toggle="toggle" type="checkbox" id="latest_torrents_scroll" name="latest_torrents_scroll" value="yes"' . $checkbox_index_latest_torrents_scroll . '>
    </label><span>'.$lang['user_b_chk'].''.$lang['user_b_tors2'].'</span></div>
        </td>
        </tr>       
        <tr class="userblock"><td><b>'.$lang['user_b_ann1'].'</b></td><td>
    <div class="checkbox-inline"><label><input data-toggle="toggle" type="checkbox" id="announcement" name="announcement" value="yes"' . $checkbox_index_announcement . '>
    </label><span>'.$lang['user_b_chk'].''.$lang['user_b_ann2'].'</span></div>
        </td>
        </tr>       
        <tr class="userblock"><td><b>'.$lang['user_b_don1'].'</b></td><td>
        <div class="checkbox-inline"><label><input data-toggle="toggle" type="checkbox" id="donation_progress" name="donation_progress" value="yes"' . $checkbox_index_donation_progress . '>
    </label><span>'.$lang['user_b_chk'].''.$lang['user_b_don2'].'</span></div>
        </td>
        </tr>
        <tr class="userblock"><td><b>'.$lang['user_b_adv1'].'</b></td><td>
        <div class="checkbox-inline"><label><input data-toggle="toggle" type="checkbox" id="advertisements" name="advertisements" value="yes"' . $checkbox_index_ads . '>
    </label><span>'.$lang['user_b_chk'].''.$lang['user_b_adv2'].'</span></div>
        </td>
        </tr>
        <tr class="userblock"><td><b>'.$lang['user_b_rad1'].'</b></td><td>
       <div class="checkbox-inline"><label><input data-toggle="toggle" type="checkbox" id="radio" name="radio" value="yes"' . $checkbox_index_radio . '>
    </label><span>'.$lang['user_b_chk'].''.$lang['user_b_rad2'].'</span></div>
        </td>
        </tr>
        <tr class="userblock"><td><b>'.$lang['user_b_tf1'].'</b></td><td>
    <div class="checkbox-inline"><label><input data-toggle="toggle" type="checkbox" id="torrentfreak" name="torrentfreak" value="yes"' . $checkbox_index_torrentfreak . '>
    </label><span>'.$lang['user_b_chk'].''.$lang['user_b_tf2'].'</span></div>
        </td>
        </tr>       
        <tr class="userblock"><td><b>'.$lang['user_b_xmas1'].'</b></td><td>
        <div class="checkbox-inline"><label><input data-toggle="toggle" type="checkbox" id="xmas_gift" name="xmas_gift" value="yes"' . $checkbox_index_xmasgift . ' />
    </label><span>'.$lang['user_b_chk'].''.$lang['user_b_xmas2'].'</span></div>
        </td>
        </tr>       
        <tr class="userblock"><td><b>'.$lang['user_b_poll1'].'</b></td><td>
        <div class="checkbox-inline"><label><input data-toggle="toggle" type="checkbox" id="active_poll" name="active_poll" value="yes"' . $checkbox_index_active_poll . '>
    </label><span>'.$lang['user_b_chk'].''.$lang['user_b_poll2'].'</span></div>
        </td>
        </tr>       
        <tr class="userblock"><td><b>'.$lang['user_b_mow1'].'</b></td><td>
        <div class="checkbox-inline"><label><input data-toggle="toggle" type="checkbox" id="index_movie_ofthe_week" name="movie_ofthe_week" value="yes"' . $checkbox_index_mow . '><label for="index_movie_ofthe_week">
    </label><span>'.$lang['user_b_chk'].''.$lang['user_b_mow2'].'</span></div>
        </td>
        </tr>
        <tr class="userblock"><td><b>'.$lang['user_b_rqno1'].'</b></td><td>
        <div class="checkbox-inline"><label><input data-toggle="toggle" type="checkbox" id="index_requests_and_offers" name="requests_and_offers" value="yes"' . $checkbox_index_reqnoff . '><label for="index_requests_and_offers">
    </label><span>'.$lang['user_b_chk'].''.$lang['user_b_rqno2'].'</span></div>
        </td>
        </tr>
    </table>         
    <div class="col-sm-offset-5"><input class="btn btn-primary" type="submit" name="submit" value="'.$lang['user_b_butt'].'" tabindex="2" accesskey="s"></div><br><br></div>';
$HTMLOUT.='<div class="tab-pane fade" id="site">
<fieldset><legend>'.$lang['user_b_title2'].'</legend></fieldset>
        <table class="table table-bordered">        
    <tr class="userblock"><td><b>'.$lang['user_s_free1'].'</b></td><td>
        <div class="checkbox-inline"><label><input data-toggle="toggle"  type="checkbox" id="stdhead_freeleech" name="stdhead_freeleech" value="yes"' . $checkbox_global_freeleech . '>
</label><span>'.$lang['user_s_free2'].'</span></div>        
        </td>
        </tr>       
        <tr><td><b>'.$lang['user_s_rep1'].'</b></td><td>
        <div class="checkbox-inline"><label><input data-toggle="toggle" type="checkbox" id="stdhead_reports" name="stdhead_reports" value="yes"' . $checkbox_global_staff_report . '>
</label><span>'.$lang['user_s_rep2'].'</span></div>        
        </td>
        </tr>       
        <tr><td><b>'.$lang['user_s_app1'].'</b></td><td>
        <div class="checkbox-inline"><label><input data-toggle="toggle" type="checkbox" id="stdhead_uploadapp" name="stdhead_uploadapp" value="yes"' . $checkbox_global_staff_uploadapp . '>
</label><span>'.$lang['user_s_app1'].'</span></div>        
        </td>
        </tr>';
if ($CURUSER['class'] >= UC_STAFF) {
    $HTMLOUT.= '        
    <tr><td><b>'.$lang['user_s_dem1'].'</b></td><td>
        <div class="checkbox-inline"><label><input data-toggle="toggle" type="checkbox" id="stdhead_demotion" name="stdhead_demotion" value="yes"' . $checkbox_global_demotion . '>
</label><span>'.$lang['user_s_dem2'].'</span></div>        
        </td>
        </tr>';
}
if ($CURUSER['class'] >= UC_STAFF) {
    $HTMLOUT.= '
    <tr><td><b>'.$lang['user_s_warn1'].'</b></td><td>
        <div class="checkbox-inline"><label><input data-toggle="toggle" type="checkbox" id="stdhead_staff_message" name="stdhead_staff_message" value="yes"' . $checkbox_global_staff_message_alert . '>
</label><span>'.$lang['user_s_warn2'].'</span></div>        
        </td>
        </tr>';
}
if ($CURUSER['class'] >= UC_STAFF) {
    $HTMLOUT.= '
    <tr><td><b>'.$lang['user_s_bug1'].'</b></td><td>
         <div class="checkbox-inline"><label><input data-toggle="toggle" type="checkbox" id="stdhead_bugmessage" name="stdhead_bugmessage" value="yes"' . $checkbox_global_bugmessage . '>
</label><span>'.$lang['user_s_bug2'].'</span></div>        
        </td>
        </tr>';
}
$HTMLOUT.= '
    <tr><td><b>'.$lang['user_s_mess1'].'</b></td><td>
        <div class="checkbox-inline"><label><input data-toggle="toggle" type="checkbox" id="stdhead_newpm" name="stdhead_newpm" value="yes"' . $checkbox_global_message_alert . '>
</label><span>'.$lang['user_s_mess2'].'</span></div>        
       </td>
        </tr>       
        <tr><td><b>'.$lang['user_s_hh1'].'</b></td><td>
        <div class="checkbox-inline"><label><input data-toggle="toggle" type="checkbox" id="stdhead_happyhour" name="stdhead_happyhour" value="yes"' . $checkbox_global_happyhour . '>
</label><span>'.$lang['user_s_hh2'].'</span></div>        
        </td>
        </tr>       
        <tr><td><b>'.$lang['user_s_ch1'].'</b></td><td>
        <div class="checkbox-inline"><label><input data-toggle="toggle" type="checkbox" id="stdhead_crazyhour" name="stdhead_crazyhour" value="yes"' . $checkbox_global_crazyhour . '>
</label><span>'.$lang['user_s_ch2'].'</span></div>        
        </td>
        </tr>   
        <tr><td><b>'.$lang['user_s_kc1'].'</b></td><td>
        <div class="checkbox-inline"><label><input data-toggle="toggle" type="checkbox" id="stdhead_freeleech_contribution" name="stdhead_freeleech_contribution" value="yes"' . $checkbox_global_freeleech_contribution . '>
</label><span>'.$lang['user_s_kc2'].'</span></div>        
        </td>
       </tr>';
if ($CURUSER['class'] >= UC_STAFF) {
$HTMLOUT.= '
        <tr><td><b>'.$lang['user_s_stq1'].'</b></td><td>
        <div class="checkbox-inline"><label><input data-toggle="toggle" type="checkbox" id="stdhead_stafftools" name="stdhead_stafftools" value="yes"' . $checkbox_global_stafftools . '>
</label><span>'.$lang['user_s_stq2'].'</span></div>        
        </td>
        </tr>';
}
       $HTMLOUT.= '</table><div class="col-sm-offset-5"><input class="btn btn-primary" type="submit" name="submit" value="'.$lang['user_b_butt'].'" tabindex="2" accesskey="s"></div><br><br></div>';
$HTMLOUT.= '<div class="tab-pane fade" id="user">
<fieldset><legend>'.$lang['user_b_title3'].'</legend></fieldset>
        <table class="table table-bordered">
        <tr><td><b>'.$lang['user_u_ll1'].'</b></td><td>
        <div class="checkbox-inline"><label><input data-toggle="toggle" type="checkbox" id="userdetails_login_link" name="userdetails_login_link" value="yes"' . $checkbox_userdetails_login_link . '>
</label><span>'.$lang['user_u_ll2'].'</span></div>   
        </td>
        </tr>
        <tr><td><b>'.$lang['user_u_ftt1'].'</b></td><td>
        <div class="checkbox-inline"><label><input data-toggle="toggle" type="checkbox" id="userdetails_flush" name="userdetails_flush" value="yes"' . $checkbox_userdetails_flush . '>
</label><span>'.$lang['user_u_ftt2'].'</span></div>        
        </td>
        </tr>       
        <tr><td><b>'.$lang['user_u_join1'].'</b></td><td>
        <div class="checkbox-inline"><label><input data-toggle="toggle" type="checkbox" id="userdetails_joined" name="userdetails_joined" value="yes"' . $checkbox_userdetails_joined . '>
</label><span>'.$lang['user_u_join2'].'</span></div>        
        </td>
        </tr>       
        <tr><td><b>'.$lang['user_u_onl1'].'</b></td><td>
        <div class="checkbox-inline"><label><input data-toggle="toggle" type="checkbox" id="userdetails_online_time" name="userdetails_online_time" value="yes"' . $checkbox_userdetails_onlinetime . '>
</label><span>'.$lang['user_u_onl2'].'</span></div>        
        </td>
        </tr>   
        <tr><td><b>'.$lang['user_u_brw1'].'</b></td><td>
        <div class="checkbox-inline"><label><input data-toggle="toggle" type="checkbox" id="userdetails_browser" name="userdetails_browser" value="yes"' . $checkbox_userdetails_browser . '>
</label><span>'.$lang['user_u_brw2'].'</span></div>        
        </td>
        </tr>   
        '.($INSTALLER09['rep_sys_on'] ? '<tr><td><b>'.$lang['user_u_rep1'].'</b></td><td>
        <div class="checkbox-inline"><label><input data-toggle="toggle" type="checkbox" id="userdetails_reputation" name="userdetails_reputation" value="yes"' . $checkbox_userdetails_reputation . '>
</label><span>'.$lang['user_u_rep2'].'</span></div>        
        </td>
        </tr>' : '').'       
        <tr><td><b>'.$lang['user_u_phit1'].'</b></td><td>
        <div class="checkbox-inline"><label><input data-toggle="toggle" type="checkbox" id="userdetails_user_hits" name="userdetails_user_hits" value="yes"' . $checkbox_userdetails_userhits . '>
</label><span>'.$lang['user_u_phit2'].'</span></div>        
        </td>
        </tr>       
        <tr><td><b>'.$lang['user_u_bir1'].'</b></td><td>
        <div class="checkbox-inline"><label><input data-toggle="toggle" type="checkbox" id="userdetails_birthday" name="userdetails_birthday" value="yes"' . $checkbox_userdetails_birthday . '>
</label><span>'.$lang['user_u_bir2'].'</span></div>       
        </td>
        </tr>   
        <tr><td><b>'.$lang['user_u_con1'].'</b></td><td>
        <div class="checkbox-inline"><label><input data-toggle="toggle" type="checkbox" id="userdetails_contact_info" name="userdetails_contact_info" value="yes"' . $checkbox_userdetails_contact_info . '>
</label><span>'.$lang['user_u_con2'].'</span></div>        
       </td>
        </tr>       
        <tr><td><b>'.$lang['user_u_ip1'].'</b></td><td>
        <div class="checkbox-inline"><label><input data-toggle="toggle" type="checkbox" id="userdetails_iphistory" name="userdetails_iphistory" value="yes"' . $checkbox_userdetails_iphistory . '>
</label><span>'.$lang['user_u_ip2'].'</span></div>        
        </td>
        </tr>       
        <tr><td><b>'.$lang['user_u_ut1'].'</b></td><td>
        <div class="checkbox-inline"><label><input data-toggle="toggle" type="checkbox" id="userdetails_traffic" name="userdetails_traffic" value="yes"' . $checkbox_userdetails_traffic . '>
</label> <span>'.$lang['user_u_ut2'].'</span></div>       
        </td>
        </tr>       
        <tr><td><b>'.$lang['user_u_shr1'].'</b></td><td>
        <div class="checkbox-inline"><label><input data-toggle="toggle" type="checkbox" id="userdetails_share_ratio" name="userdetails_share_ratio" value="yes"' . $checkbox_userdetails_shareratio . '>
</label><span>'.$lang['user_u_shr2'].'</span></div>       
        </td>
        </tr>       
        <tr><td><b>'.$lang['user_u_st1'].'</b></td><td>
        <div class="checkbox-inline"><label><input data-toggle="toggle" type="checkbox" id="userdetails_seedtime_ratio" name="userdetails_seedtime_ratio" value="yes"' . $checkbox_userdetails_seedtime_ratio . '>
</label><span>'.$lang['user_u_st2'].'</span></div>        
        </td>
        </tr>   
        <tr><td><b>'.$lang['user_u_seed1'].'</b></td><td>
        <div class="checkbox-inline"><label><input data-toggle="toggle" type="checkbox" id="userdetails_seedbonus" name="userdetails_seedbonus" value="yes"' . $checkbox_userdetails_seedbonus . '>
</label><span>'.$lang['user_u_seed2'].'</span></div>       
         </td>
        </tr>
        <tr><td><b>'.$lang['user_u_ircs1'].'</b></td><td>
        <div class="checkbox-inline"><label><input data-toggle="toggle" type="checkbox" id="userdetails_irc_stats" name="userdetails_irc_stats" value="yes"' . $checkbox_userdetails_irc_stats . '>
</label><span>'.$lang['user_u_ircs2'].'</span></div>       
        </td>
        </tr>   
        <tr><td><b>'.$lang['user_u_cnn1'].'</b></td><td>
        <div class="checkbox-inline"><label><input data-toggle="toggle" type="checkbox" id="userdetails_connectable_port" name="userdetails_connectable_port" value="yes"' . $checkbox_userdetails_connectable . '>
</label><span>'.$lang['user_u_cnn2'].'</span></div>        
        </td>
        </tr>   
        <tr><td><b>'.$lang['user_u_av1'].'</b></td><td>
        <div class="checkbox-inline"><label><input data-toggle="toggle" type="checkbox" id="userdetails_avatar" name="userdetails_avatar" value="yes"' . $checkbox_userdetails_avatar . '>
</label><span>'.$lang['user_u_av2'].'</span></div>        
        </td>
        </tr>   
        <tr><td><b>'.$lang['user_u_ucc1'].'</b></td><td>
        <div class="checkbox-inline"><label><input data-toggle="toggle" type="checkbox" id="userdetails_userclass" name="userdetails_userclass" value="yes"' . $checkbox_userdetails_userclass . '>
</label><span>'.$lang['user_u_ucc2'].'</span></div>       
        </td>
        </tr>       
        <tr><td><b>'.$lang['user_u_gen1'].'</b></td><td>
        <div class="checkbox-inline"><label><input data-toggle="toggle" type="checkbox" id="userdetails_gender" name="userdetails_gender" value="yes"' . $checkbox_userdetails_gender . '>
</label><span>'.$lang['user_u_gen2'].'</span></div>       
        </td>
        </tr>   
        <tr><td><b>'.$lang['user_u_free1'].'</b></td><td>
        <div class="checkbox-inline"><label><input data-toggle="toggle" type="checkbox" id="userdetails_freestuffs" name="userdetails_freestuffs" value="yes"' . $checkbox_userdetails_freestuffs . '>
</label><span>'.$lang['user_u_free2'].'</span></div>        
        </td>
        </tr>       
        <tr><td><b>'.$lang['user_u_cmm1'].'</b></td><td>
        <div class="checkbox-inline"><label><input data-toggle="toggle" type="checkbox" id="userdetails_comments" name="userdetails_comments" value="yes"' . $checkbox_userdetails_torrent_comments . '>
</label><span>'.$lang['user_u_cmm2'].'</span></div>        
        </td>
        </tr>   
        <tr><td><b>'.$lang['user_u_fpt1'].'</b></td><td>
        <div class="checkbox-inline"><label><input data-toggle="toggle" type="checkbox" id="userdetails_forumposts" name="userdetails_forumposts" value="yes"' . $checkbox_userdetails_forumposts . '>
</label><span>'.$lang['user_u_fpt2'].'</span></div>        
        </td>
        </tr>       
        <tr><td><b>'.$lang['user_u_inv1'].'</b></td><td>
        <div class="checkbox-inline"><label><input data-toggle="toggle" type="checkbox" id="userdetails_invitedby" name="userdetails_invitedby" value="yes"' . $checkbox_userdetails_invitedby . '>
</label><span>'.$lang['user_u_inv2'].'</span></div>        
        </td>
        </tr>   
        <tr><td><b>'.$lang['user_u_tb1'].'</b></td><td>
        <div class="checkbox-inline"><label><input data-toggle="toggle" type="checkbox" id="userdetails_torrents_block" name="userdetails_torrents_block" value="yes"' . $checkbox_userdetails_torrents_block . '>
</label><span>'.$lang['user_u_tb2'].'</span></div>       
        </td>
        </tr>   
        <tr><td><b>'.$lang['user_u_sts1'].'</b></td><td>
        <div class="checkbox-inline"><label><input data-toggle="toggle" type="checkbox" id="userdetails_snatched_staff" name="userdetails_snatched_staff" value="yes"' . $checkbox_userdetails_snatched_staff . '>
</label><span>'.$lang['user_u_sts2'].'</span></div>        
        </td>
        </tr>       
        <tr><td><b>'.$lang['user_u_usinf1'].'</b></td><td>
        <div class="checkbox-inline"><label><input data-toggle="toggle" type="checkbox" id="userdetails_userinfo" name="userdetails_userinfo" value="yes"' . $checkbox_userdetails_userinfo . '>
</label><span>'.$lang['user_u_usinf2'].'</span></div>        
        </td>
        </tr>       
        <tr><td><b>'.$lang['user_u_pm1'].'</b></td><td>
        <div class="checkbox-inline"><label><input data-toggle="toggle" type="checkbox" id="userdetails_showpm" name="userdetails_showpm" value="yes"' . $checkbox_userdetails_showpm . '>
</label><span>'.$lang['user_u_pm2'].'</span></div>       
        </td>
        </tr>';
if ($BLOCKS['userdetails_report_user_on']) {		
        $HTMLOUT.= '<tr><td><b>'.$lang['user_u_rpu1'].'</b></td><td>
        <div class="checkbox-inline"><label><input data-toggle="toggle" type="checkbox" id="userdetails_report_user" name="userdetails_report_user" value="yes"' . $checkbox_userdetails_report . '>
</label><span>'.$lang['user_u_rpu2'].'</span></div>        
        </td>
        </tr>';
}	
$HTMLOUT.= '<tr><td><b>'.$lang['user_u_ust1'].'</b></td><td>
        <div class="checkbox-inline"><label><input data-toggle="toggle" type="checkbox" id="userdetails_user_status" name="userdetails_user_status" value="yes"' . $checkbox_userdetails_userstatus . '>
</label><span>'.$lang['user_u_ust2'].'</span></div>        
        </td>
        </tr>       
        <tr><td><b>'.$lang['user_u_ucmm1'].'</b></td><td>
        <div class="checkbox-inline"><label><input data-toggle="toggle" type="checkbox" id="userdetails_user_comments" name="userdetails_user_comments" value="yes"' . $checkbox_userdetails_usercomments . '>
</label><span>'.$lang['user_u_ucmm2'].'</span></div>        
        </td>
        </tr>';
if ($CURUSER['class'] >= UC_STAFF) {
    $HTMLOUT.= '
    <tr><td><b>'.$lang['user_u_comp1'].'</b></td><td>
        <div class="checkbox-inline"><label><input data-toggle="toggle" type="checkbox" id="userdetails_completed" name="userdetails_completed" value="yes"' . $checkbox_userdetails_completed . '>
</label><span>'.$lang['user_u_comp2'].'</span></div>        
        </td>
        </tr>';
}
$HTMLOUT.= '
    <tr><td><b>'.$lang['user_u_sfd1'].'</b></td><td>
        <div class="checkbox-inline"><label><input data-toggle="toggle" type="checkbox" id="userdetails_showfriends" name="userdetails_showfriends" value="yes"' . $checkbox_userdetails_showfriends . '>
</label><span>'.$lang['user_u_sfd2'].'</span></div>        
        </td>
        </tr>
    </table>
<div class="col-sm-offset-5"><input class="btn btn-primary" type="submit" name="submit" value="'.$lang['user_b_butt'].'" tabindex="2" accesskey="s"></div></div>';
$HTMLOUT.= '</div></form></div>';
echo stdhead($lang['user_b_echo'], true) . $HTMLOUT . stdfoot();
?>
