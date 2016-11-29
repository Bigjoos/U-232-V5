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
$lang = array(
    //index
    'index_announce' => "Announcements",
    'index_latest' => "Latest Torrents",
    'index_shoutbox_refresh' => "[ Refresh ]",
    'index_shoutbox_commands' => "[ Commands ]",
    'index_shoutbox_csmilies' => "[ Custom Smilies ]",
    'index_shoutbox_ssmilies' => "[ Staff Smilies ]",
    'index_shoutbox_smilies' => "[ More Smilies ]",
    'index_shout' => "Shoutbox",
    'index_shoutbox' => "ShoutBox",
    'index_shoutbox_shout' => "Shout",
    'index_shoutbox_send' => "Send",
    'index_shoutbox_close' => "Close",
    'index_shoutbox_history' => "History",
    'index_shoutbox_open' => "Open",
    'index_staff_shoutbox' => "Staff Shoutbox",
    'index_active_irc' => "Active Irc users",
    'index_active' => "Active users",
    'index_active24' => "Active users in the last 24hrs",
    'index_most24' => "Most ever visited in 24 hours was",
    'index_member24' => "Member's",
    'index_noactive' => "Sorry - No users active presently",
    'index_disclaimer' => "Disclaimer",
    'index_donations' => "Donate",
    'index_serverload' => "Server Load",
    'index_u-232' => "U-232 Forum",
    'index_u-232_git' => "U-232 Repo",
    'index_serverscene' => "Server Scene",
    'index_birthday' => "Members birthdays",
    //News
    'news_title' => "Recent News",
    'news_link' => "News Page",
    'news_edit' => "Edit",
    'news_delete' => "Delete",
    //latest torrents
    'latesttorrents' => $INSTALLER09['latest_torrents_limit'] . " latest torrents",
    'latesttorrents_title' => $INSTALLER09['latest_torrents_limit'] . " latest torrents",
    'latesttorrents_type' => "Type",
    'latesttorrents_name' => "Name",
    'latesttorrents_seeders' => "Seeders",
    'latesttorrents_leechers' => "Leechers",
    'latesttorrents_no_torrents' => "No torrents Found",
    // last 5
    'last5torrents' => "Last 5 torrents",
    'last5torrents_title' => "Last 5 torrents",
    'last5torrents_type' => "Type",
    'last5torrents_name' => "Name",
    'last5torrents_seeders' => "Seeders",
    'last5torrents_leechers' => "Leechers",
    'last5torrents_health' => "Health",
    'last5torrents_no_torrents' => "No torrents Found",
    // top 5
    'top5torrents' => " Top 5 torrents",
    'top5torrents_title' => " Top 5 torrents",
    'top5torrents_type' => "Type",
    'top5torrents_name' => "Name",
    'top5torrents_seeders' => "Seeders",
    'top5torrents_leechers' => "Leechers",
    'top5torrents_health' => "Health",
    'top5torrents_no_torrents' => "No torrents Found",
    //Change log
    'clog_title' => "Change log",
    'clog_link' => "Log Page",
    'clog_edit' => "Edit",
    'clog_delete' => "Delete",
    //latest forum posts
    'latestposts_title' => $INSTALLER09['latest_posts_limit'] . " Latest Forum Posts",
    'latestposts_topic_title' => "Topic&nbsp;Title",
    'latestposts_replies' => "Replies",
    'latestposts_views' => "Views",
    'latestposts_last_post' => "Last&nbsp;Post",
    'latestposts_posted_at' => "Posted&nbsp;At",
    'latestposts_no_posts' => "No Posts Found",
    //Stats
    'index_stats_title' => "Stats",
    'index_stats_regged' => "Registered Users",
    'index_stats_max' => "Maximum Users",
    'index_stats_online' => "Users Online",
    'index_stats_uncon' => "Unconfirmed Users",
    'index_stats_donor' => "Donors",
    'index_stats_topics' => "Forum Topics",
    'index_stats_torrents' => "Torrents",
    'index_stats_posts' => "Forum Posts",
    'index_stats_newtor' => "New Torrents Today",
    'index_stats_newtor_month' => "New Torrents This Month",
    'index_stats_peers' => "Peers",
    'index_stats_unconpeer' => "Unconnectable Peers",
    'index_stats_seeders' => "Seeders",
    'index_stats_unconratio' => "Unconnectables ratio (%)",
    'index_stats_leechers' => "Leechers",
    'index_stats_slratio' => "Seeder/leecher ratio (%)",
    'index_stats_gender_na' => "Gender not sure",
    'index_stats_gender_male' => "Males",
    'index_stats_gender_female' => "Females",
    'index_stats_powerusers' => "Power Users",
    'index_stats_banned' => "Disabled",
    'index_stats_uploaders' => "Uploaders",
    'index_stats_moderators' => "Moderators",
    'index_stats_admin' => "Administrators",
    'index_stats_sysops' => "Sysops",
    //disclaimer
    'foot_disclaimer' => "None of the files shown here are actually hosted on this server. The links are provided solely by this site's users.
The administrator of this site (%s) cannot be held responsible for what its users post, or any other actions of its users.
You may not use this site to distribute or download any material when you do not have the legal rights to do so.
It is your own responsibility to adhere to these terms.",
    //last24
    'index_last24_nousers' => "There&nbsp;have&nbsp;been&nbsp;no&nbsp;active&nbsp;users&nbsp;in&nbsp;the&nbsp;last&nbsp;15&nbsp;minutes.",
    'index_last24_list' => "&nbsp;-&nbsp;List&nbsp;updated&nbsp;hourly",
    'index_last24_during' => " visited during the last 24 hours",
    'index_last24_most' => "Most ever visited in 24 hours was ",
    'index_last24_on' => " on ",
    //global show hide
    'index_hide_show' => "[Hide/Show]",
    'index_click_more' => "Click for more info",
    //irc users
    'index_irc_days' => "days",
    'index_irc_hrs' => "hrs",
    'index_irc_min' => "minutes",
    'index_irc_nousers' => "There have been no active irc users in the last 15 minutes.",
    //birthday users
    'index_birthday_no' => "There is no members birthdays today.",
    //active users
    'index_active_users_no' => "There have been no active users in the last 15 minutes.",
    //advertise
    'index_advertise_t' => "U-232",
    //announcement
    'index_ann_title' => "Announcement",
    'index_ann_click' => "Click ",
    'index_ann_here' => "here",
    'index_ann_clear' => " to clear this announcement.",
    //forum_posts
    'index_fposts_anonymous' => "Anonymous",
    'index_fposts_unknow' => "Unknown",
    'index_fposts_system' => "System",
    'index_fposts_sticky' => "Sticky",
    'index_fposts_stickyt' => "Sticky Topic",
    'index_fposts_locked' => "Locked",
    'index_fposts_lockedt' => "Locked Topic",
    'index_fposts_in' => "in ",
    //xmas gift
    'index_xmas_gift' => "Xmas Gift",
    //ie user
    'index_ie_warn' => "Warning - Internet Explorer Browser",
    'index_ie_not' => " It appears as though you are running Internet Explorer, this site was <b>NOT</b> intended to be viewed with internet explorer and chances are it will not look right and may not even function correctly.",
    'index_ie_suggest' => " suggests that you ",
    'index_ie_bhappy' => "browse happy",
    'index_ie_consider' => " and consider switching to one of the many better alternatives.",
    'index_ie_firefox' => "Get Firefox!",
    'index_ie_get' => "Get a SAFER browser !",
    ///Latest Torrents
    'index_ltst_name' => "Name:",
    'index_ltst_seeder' => "Seeders:",
    'index_ltst_leecher' => "Leechers:",
    //Latest Member
    'index_lmember' => "Latest Member",
    'index_wmember' => "Welcome our newest member ",
    //movie of the week
    'index_mow_title' => "Movie of the Week",
    'index_mow_type' => "Type",
    'index_mow_name' => "Name",
    'index_mow_snatched' => "Snatched",
    'index_mow_seeder' => "Seeders",
    'index_mow_leecher' => "Leechers",
    'index_mow_no' => "No Movie of the week set!",
    //news
    'index_news_title' => "&nbsp;&nbsp;Add / Edit",
    'index_news_ed' => "Edit news",
    'index_news_del' => "Delete news",
    'index_news_added' => "&nbsp;-&nbsp;Added by ",
    'index_news_anon' => "Anonymous",
    'index_news_not' => "We currently have fuck all to say :-P",
    'index_news_txt' => "&nbsp;-&nbsp;",
    //shoutbox
    'index_shoutbox_general' => "ShoutBox - General Chit-chat",
    //torrent freak
    'index_torr_freak' => " Torrent Freak News",
    //polls
    'index_poll_title' => "Add / Edit",
    'index_poll_name' => "Site Poll",
    //add_stats_bl_by yoooov
    'index_stats_uinfo' => "User Info",
    'index_stats_cinfo' => "Class Info",
    'index_stats_finfo' => "Forum Info",
    'index_stats_tinfo' => "Torrent Info",
    //add_reqnoff_bl_by_yoooov
    'req_off_label' => "Requests and Offers",
    'req_off_unfld' => "Unfilled Requests",
    'req_off_cat' => "Category",
    'req_off_tit' => "Title",
    'req_off_add' => "Added",
    'req_off_com' => "Comm",
    'req_off_vot' => "Votes",
    'req_off_reqby' => "Requested By",
    'req_off_fild' => "Filled",
    'req_off_goto' => "Go to torrent page!!!",
    'req_off_yes1' => "yes!",
    'req_off_no1' => "no",
    'req_off_yes2' => "yes: ",
    'req_off_no2' => "no: ",
    'req_off_noreq' => "No Requests Found",
    'req_off_offers' => "Offers",
    'req_off_offd' => "Offered",
    'req_off_stat' => "Status",
    'req_off_app' => "Approved!",
    'req_off_pend' => "Pending...",
    'req_off_den' => "Denied",
    'req_off_nooff' => "No Offers Found",
);
?>
