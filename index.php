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
require_once (__DIR__ . DIRECTORY_SEPARATOR . 'include' . DIRECTORY_SEPARATOR . 'bittorrent.php');
require_once INCL_DIR . 'user_functions.php';
require_once INCL_DIR . 'bbcode_functions.php';
require_once INCL_DIR . 'html_functions.php';
require_once ROOT_DIR . 'polls.php';
require_once (CLASS_DIR . 'class_user_options.php');
require_once (CLASS_DIR . 'class_user_options_2.php');
dbconn(true);
loggedinorreturn();
require_once(TEMPLATE_DIR.''.$CURUSER['stylesheet'].'' . DIRECTORY_SEPARATOR . 'html_functions' . DIRECTORY_SEPARATOR . 'global_html_functions.php'); 
require_once(TEMPLATE_DIR.''.$CURUSER['stylesheet'].'' . DIRECTORY_SEPARATOR . 'html_functions' . DIRECTORY_SEPARATOR . 'navigation_html_functions.php'); 

$stdhead = array(
    /** include css **/
    'css' => array(
        'bbcode'
    )
);
$stdfoot = array(
    /** include js **/
    'js' => array(
	/*'gallery',*/
    'shout'
    )
);

$lang = array_merge(load_language('global') , load_language('index'));

$HTMLOUT = '';
//==Global blocks by elephant
//==Curuser blocks by pdq
	if (curuser::$blocks['index_page'] & block_index::IE_ALERT && $BLOCKS['ie_user_alert']) {
$HTMLOUT .="<div id='IE_ALERT'>";
	require_once (BLOCK_DIR . 'index/ie_user.php');
$HTMLOUT .="</div>";
	}

	if (curuser::$blocks['index_page'] & block_index::ANNOUNCEMENT && $BLOCKS['announcement_on']) {
$HTMLOUT .="<div id='ANNOUNCEMENT'>";
    	require_once (BLOCK_DIR . 'index/announcement.php');
$HTMLOUT .="</div>";
	}

	if ($CURUSER['class'] >= UC_STAFF && curuser::$blocks['index_page'] & block_index::STAFF_SHOUT && $BLOCKS['staff_shoutbox_on']) {
$HTMLOUT .="<div id='STAFF_SHOUT'>";
   	 require_once (BLOCK_DIR . 'index/staff_shoutbox.php');
$HTMLOUT .="</div>";
	}

	if (curuser::$blocks['index_page'] & block_index::SHOUTBOX && $BLOCKS['shoutbox_on']) {
$HTMLOUT .="<div id='SHOUTBOX'>";
    	require_once (BLOCK_DIR . 'index/shoutbox.php');
$HTMLOUT .="</div>";
	}

	if (curuser::$blocks['index_page'] & block_index::NEWS && $BLOCKS['news_on']) {
$HTMLOUT .="<div id='NEWS'>";
 	require_once (BLOCK_DIR . 'index/news.php');
$HTMLOUT .="</div>";
	}

	if (curuser::$blocks['index_page'] & block_index::ADVERTISEMENTS && $BLOCKS['ads_on']) {
$HTMLOUT .="<div id='ADVERTISEMENTS'>";
   	require_once (BLOCK_DIR . 'index/advertise.php');
$HTMLOUT .="</div>";
	}

	if (curuser::$blocks['index_page'] & block_index::FORUMPOSTS && $BLOCKS['forum_posts_on']) {
$HTMLOUT .="<div id='FORUMPOSTS'>";
    	require_once (BLOCK_DIR . 'index/forum_posts.php');
$HTMLOUT .="</div>";
	}

	if (curuser::$blocks['index_page'] & block_index::MOVIEOFWEEK && $BLOCKS['movie_ofthe_week_on']) {
$HTMLOUT .="<div id='MOVIEOFWEEK'>";
    	require_once (BLOCK_DIR . 'index/mow.php');
$HTMLOUT .="</div>";
	}

	if (curuser::$blocks['index_page'] & block_index::LATEST_TORRENTS && $BLOCKS['latest_torrents_on']) {
$HTMLOUT .="<div id='LATEST_TORRENTS'>";
    	require_once (BLOCK_DIR . 'index/latest_torrents.php');
$HTMLOUT .="</div>";
	}

        if (curuser::$blocks['index_page'] & block_index::REQNOFF && $BLOCKS['requests_and_offers_on']) {
$HTMLOUT .="<div id='REQUESTS_AND_OFFERS'>";
    	require_once (BLOCK_DIR . 'index/req_n_off.php');
$HTMLOUT .="</div>";
	}

	if (curuser::$blocks['index_page'] & block_index::LATEST_TORRENTS_SCROLL && $BLOCKS['latest_torrents_scroll_on']) {
$HTMLOUT .="<div id='LATEST_TORRENTS_SCROLL'>";
    	require_once (BLOCK_DIR . 'index/latest_torrents_scroll.php');
$HTMLOUT .="</div>";
	}

	if (curuser::$blocks['index_page'] & block_index::STATS && $BLOCKS['stats_on']) {
$HTMLOUT .="<div id='STATS'>";
    	require_once (BLOCK_DIR . 'index/stats.php');
$HTMLOUT .="</div>";
	}
	if (curuser::$blocks['index_page'] & block_index::ACTIVE_USERS && $BLOCKS['active_users_on']) {
$HTMLOUT .="<div id='ACTIVE_USERS'>";
    	require_once (BLOCK_DIR . 'index/active_users.php');
$HTMLOUT .="</div>";
	}

	if (curuser::$blocks['index_page'] & block_index::IRC_ACTIVE_USERS && $BLOCKS['active_irc_users_on']) {
$HTMLOUT .="<div id='IRC_ACTIVE_USERS'>";
    	require_once (BLOCK_DIR . 'index/active_irc_users.php');
$HTMLOUT .="</div>";
	}

	if (curuser::$blocks['index_page'] & block_index::LAST_24_ACTIVE_USERS && $BLOCKS['active_24h_users_on']) {
$HTMLOUT .="<div id='LAST_24_ACTIVE_USERS'>";
    	require_once (BLOCK_DIR . 'index/active_24h_users.php');
$HTMLOUT .="</div>";
	}

	if (curuser::$blocks['index_page'] & block_index::BIRTHDAY_ACTIVE_USERS && $BLOCKS['active_birthday_users_on']) {
$HTMLOUT .="<div id='BIRTHDAY_ACTIVE_USERS'>";
    	require_once (BLOCK_DIR . 'index/active_birthday_users.php');
$HTMLOUT .="</div>";
	}

	if (curuser::$blocks['index_page'] & block_index::LATEST_USER && $BLOCKS['latest_user_on']) {
$HTMLOUT .="<div id='LATEST_USER'>";
    	require_once (BLOCK_DIR . 'index/latest_user.php');
$HTMLOUT .="</div>";
	}

	if (curuser::$blocks['index_page'] & block_index::ACTIVE_POLL && $BLOCKS['active_poll_on']) {
$HTMLOUT .="<div id='ACTIVE_POLL'>";
    	require_once (BLOCK_DIR . 'index/poll.php');
$HTMLOUT .="</div>";
	}

	if (curuser::$blocks['index_page'] & block_index::XMAS_GIFT && $BLOCKS['xmas_gift_on']) {
$HTMLOUT .="<div id='XMAS_GIFT'>";
    	require_once (BLOCK_DIR . 'index/gift.php');
$HTMLOUT .="</div>";
	}

	if (curuser::$blocks['index_page'] & block_index::RADIO && $BLOCKS['radio_on']) {
$HTMLOUT .="<div id='RADIO'>";
    	require_once (BLOCK_DIR . 'index/radio.php');
$HTMLOUT .="</div>";
	}

	if (curuser::$blocks['index_page'] & block_index::TORRENTFREAK && $BLOCKS['torrentfreak_on']) {
$HTMLOUT .="<div id='TORRENTFREAK'>";
    	require_once (BLOCK_DIR . 'index/torrentfreak.php');
$HTMLOUT .="</div>";
	}

	if (curuser::$blocks['index_page'] & block_index::DISCLAIMER && $BLOCKS['disclaimer_on']) {
$HTMLOUT .="<div id='DISCLAIMER'>";
    	require_once (BLOCK_DIR . 'index/disclaimer.php');
$HTMLOUT .="</div>";
	}

	if (curuser::$blocks['index_page'] & block_index::DONATION_PROGRESS && $BLOCKS['donation_progress_on']) {
$HTMLOUT .="<div id='DONATION_PROGRESS'>";
    	require_once (BLOCK_DIR . 'index/donations.php');
$HTMLOUT .="</div>";
	}

echo stdhead('Home', true, $stdhead) . $HTMLOUT . stdfoot($stdfoot);
?>
