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
    //torrenttable
    'torrenttable_type' => 'Type',
    'torrenttable_name' => 'Name',
    'torrenttable_subtitles' => 'Subs',
    'torrenttable_dl' => 'DL',
    'torrenttable_wait' => 'Wait',
    'torrenttable_edit' => 'Edit',
    'torrenttable_visible' => 'Visible',
    'torrenttable_files' => 'Files',
    'torrenttable_comments' => 'Comm.',
    'torrenttable_rating' => 'Rating',
    'torrenttable_added' => 'Added',
    'torrenttable_ttl' => 'TTL',
    'torrenttable_size' => 'Size',
    'torrenttable_views' => 'Views',
    'torrenttable_hits' => 'Hits',
    'torrenttable_snatched' => 'Snatched',
    'torrenttable_seeders' => 'Seeders',
    'torrenttable_leechers' => 'Leechers',
    'torrenttable_uppedby' => 'Upped&nbsp;by',
    'torrenttable_wait_h' => 'h',
    'torrenttable_wait_none' => 'None',
    'torrenttable_view_nfo_alt' => 'View NFO',
    'torrenttable_download_alt' => 'Download',
    'torrenttable_edit' => 'Edit',
    'torrenttable_not_visible' => 'No',
    'torrenttable_visible' => 'Yes',
    'torrenttable_hour_singular' => 'hour',
    'torrenttable_hour_plural' => 'hours',
    'torrenttable_time_singular' => 'Times',
    'torrenttable_time_plural' => 'Times',
    'torrenttable_unknown_uploader' => 'Unknown',
    'torrenttable_anon' => "Anonymous",
    'torrenttable_progress' => "Progress",
    'torrenttable_upped' => 'Torrents Uploaded on',
    'torrenttable_mon' => 'Monday',
    'torrenttable_tue' => 'Tuesday',
    'torrenttable_wed' => 'Wednesday',
    'torrenttable_thur' => 'Thursday',
    'torrenttable_fri' => 'Friday',
    'torrenttable_sat' => 'Saturday',
    'torrenttable_sun' => 'Sunday',
    'torrenttable_jan' => 'January',
    'torrenttable_feb' => 'Febuary',
    'torrenttable_mar' => 'March',
    'torrenttable_apr' => 'April',
    'torrenttable_may' => 'May',
    'torrenttable_jun' => 'June',
    'torrenttable_jul' => 'July',
    'torrenttable_aug' => 'August',
    'torrenttable_sep' => 'September',
    'torrenttable_oct' => 'October',
    'torrenttable_nov' => 'November',
    'torrenttable_dec' => 'December',
    'torrenttable_health' => 'Health',
    //commenttable
    'commenttable_by' => 'by',
    'commenttable_donor_alt' => 'Donor',
    'commenttable_warned_alt' => 'Warned',
    'commenttable_orphaned' => 'orphaned',
    'commenttable_edit' => 'Edit',
    'commenttable_delete' => 'Delete',
    'commenttable_view_original' => 'View Original',
    'commenttable_last_edited_by' => 'Last edited by',
    'commenttable_last_edited_at' => 'at',
    // additional terms by yoooov
    'bool_01' => 'The boolean search supports the following operators:',
    'bool_02' => ' A leading plus sign indicates that this word must be present.',
    'bool_03' => ' A leading minus sign indicates that this word must not be present.',
    'bool_04' => ' By default (when neither + nor - is specified) the word is optional, but results that contain it are rated higher. ',
    'bool_05' => ' The asterisk serves as the wildcard operator. Unlike the other operators, it should be appended to the word to be affected. Words match if they begin with the word preceding the * operator.',
    'bool_06' => ' These two operators are used to change a word\'s contribution to the relevance value that is assigned to a word. The > operator increases the contribution and the < operator decreases it.',
    'bool_07' => ' A leading tilde acts as a negation operator, causing the word\'s contribution to the words\'s relevance to be negative. A row containing such a word is rated lower than others, but is not excluded altogether, as it would be with the - operator.',
    'bool_08' => ' A phrase that is enclosed within double quotes return only results that contain the phrase literally, as it was typed. ',
    'bool_09' => '  Parentheses group words into subexpressions. Parenthesized groups can be nested.',
    'search_inf_01' => 'For more information about this search click here',
    'search_inf_02' => ' Only Free Torrents',
    'old_school_b' => 'Old School Browse',
    'search_fct_01' => 'Search'
);
?>