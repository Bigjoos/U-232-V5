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
	//show_level
	'rep_ad_show_title' => "User Reputation Manager - Overview",
	'rep_ad_show_html1' => "On this page you can modify the minimum amount required for each reputation level. Make sure you press Update Minimum Levels to save your changes. You cannot set the same minimum amount to more than one level.",
	'rep_ad_show_html2' => "From here you can also choose to edit or remove any single level. Click the Edit link to modify the Level description (see Editing a Reputation Level) or click Remove to delete a level. If you remove a level or modify the minimum reputation needed to be at a level, all users will be updated to reflect their new level if necessary.",
	'rep_ad_show_head' => "User Reputation Manager",
	'rep_ad_show_comments' => "View comments",
	'rep_ad_show_id' => "ID",
	'rep_ad_show_level'	 => "Reputation Level",
	'rep_ad_show_min' => "Minimum Reputation Level",
	'rep_ad_show_controls' => "Controls",
	'rep_ad_show_user' => "User",
	'rep_ad_show_edit' => "Edit",
	'rep_ad_show_del' => "Delete",
	'rep_ad_show_update' => "Update",
	'rep_ad_show_reset' => "Reset",
	'rep_ad_show_add' => "Add New",
	//show_form
	'rep_ad_form_html' => "This allows you to add a new reputation level or edit an existing reputation level.",
	'rep_ad_form_error' => "Error:",
	'rep_ad_form_error_msg' => "Please specify an ID.",
	'rep_ad_form_title' => "Edit Reputation Level",
	'rep_ad_form_id' => "ID:#",
	'rep_ad_form_btn' => "Update",
	'rep_ad_form_back' => "Back",
	'rep_ad_form_add_title' => "Add New Reputation Level",
	'rep_ad_form_add_btn' => "Save",
	'rep_ad_form_desc' => "Level Description",
	'rep_ad_form_descr' => "This is what is displayed for the user when their reputation points are above the amount entered as the minimum.",
	'rep_ad_form_min' => "Minimum amount of reputation points required for this level",
	'rep_ad_form_option' => "This can be a positive or a negative amount. When the user's reputation points reaches this amount, the above description will be displayed.",
	//do_update
	'rep_ad_update_err1' => "The text you entered was too short.",
	'rep_ad_update_err2' => "The text entry is too long.",
	'rep_ad_update_saved' => "Saved Reputation Level",
	'rep_ad_update_success' => "Successfully.",
	'rep_ad_update_err3' => "Not a valid ID.",
	'rep_ad_update_err4' => "No valid ID.",
	'rep_ad_update_save_success' => "Saved Reputation Level Successfully.",
	//do_delete
	'rep_ad_delete_no' => "Rep ID doesn\'t exist",
	'rep_ad_delete_success' => "Reputation deleted successfully",
	//show_form_rep
	'rep_ad_rep_form_nothing' => "Nothing here by that ID.",
	'rep_ad_rep_form_title' => "User Reputation Manager",
	'rep_ad_rep_form_erm' => "Erm, it\'s not there!",
	'rep_ad_rep_form_head' => "Edit Reputation",
	'rep_ad_rep_form_topic' => "Topic",
	'rep_ad_rep_form_left_by' => "Left By",
	'rep_ad_rep_form_left_for' => "Left For",
	'rep_ad_rep_form_comment' => "Comment",
	'rep_ad_rep_form_rep' => "Reputation",
	'rep_ad_rep_form_save' => "Save",
	'rep_ad_rep_form_reset'	 => "Reset",
	//view_list
	'rep_ad_view_title' => "User Reputation Manager",
	'rep_ad_view_view' => "View Reputation Comments",
	'rep_ad_view_page' => "This page allows you to search for reputation comments left by / for specific users over the specified date range.",
	'rep_ad_view_for' => "Left For",
	'rep_ad_view_for_txt' => "To limit the comments left for a specific user, enter the username here. Leave this field empty to receive comments left for every user.",
	'rep_ad_view_by' => "Left By",
	'rep_ad_view_by_txt' => "To limit the comments left by a specific user, enter the username here. Leave this field empty to receive comments left by every user.",
	'rep_ad_view_start' => "Start Date",
	'rep_ad_view_month' => "Month",
	'rep_ad_view_day' => "Day",
	'rep_ad_view_year' => "Year",
	'rep_ad_view_start_select' => "Select a start date for this report. Select a month, day, and year. The selected statistic must be no older than this date for it to be included in the report.",
	'rep_ad_view_end' => "End Date",
	'rep_ad_view_end_select' => "Select an end date for this report. Select a month, day, and year. The selected statistic must not be newer than this date for it to be included in the report. You can use this setting in conjunction with the 'Start Date' setting to create a window of time for this report.",
	'rep_ad_view_search' => "Search",
	'rep_ad_view_reset' => "Reset",
	'rep_ad_view_err1' => "Time",
	'rep_ad_view_err2' => "Start date is after the end date.",
	'rep_ad_view_err3' => "DB ERROR",
	'rep_ad_view_err4' => "Could not find user ",
	'rep_ad_view_cmts' => "Reputation Comments",
	'rep_ad_view_id' => "ID",
	'rep_ad_view_date' => "Date",
	'rep_ad_view_point' => "Point",
	'rep_ad_view_reason' => "Reason",
	'rep_ad_view_control' => "Controls",
	'rep_ad_view_none_found' => "No Matches Found!",
	'rep_ad_view_records' => "Records",
	'rep_ad_view_err5' => "Nothing here",
	'rep_ad_view_edit' => "Edit",
	'rep_ad_view_delete' => "Delete",
	//do_delete_rep
	'rep_ad_delete_rep_err1' => "ERROR",
	'rep_ad_delete_rep_err2' => "Can\'t find ID",
	'rep_ad_delete_rep_err3' => "DELETE",
	'rep_ad_delete_rep_err4' => "No valid ID.",
	'rep_ad_delete_rep_success' => "Deleted Reputation Successfully",
	//do_edit_rep
	'rep_ad_edit_txt' => "TEXT",
	'rep_ad_edit_short' => "The text you entered was too short.",
	'rep_ad_edit_long' => "The text entry is too long.",
	'rep_ad_edit_input' => "INPUT",
	'rep_ad_edit_noid' => "No ID",
	'rep_ad_edit_saved' => "Saved Reputation #ID",
	'rep_ad_edit_success' => "Successfully.",
	//html_out
	'rep_ad_html_error' => "Error",
	'rep_ad_html_nothing' => "Nothing to output",
	//redirect
	'rep_ad_redirect_title' => "Admin Rep Redirection",
	'rep_ad_redirect_redirect' => "Redirecting...",
	'rep_ad_redirect_block' => "Block Settings",
	'rep_ad_redirect_not' => "Click here if not redirected...",
	//get_month_dropdown
	'rep_ad_month_jan' => "January",
	'rep_ad_month_feb' => "February",
	'rep_ad_month_mar' => "March",
	'rep_ad_month_apr' => "April",
	'rep_ad_month_may' => "May",
	'rep_ad_month_june' => "June",
	'rep_ad_month_july' => "July",
	'rep_ad_month_aug' => "August",
	'rep_ad_month_sept' => "September",
	'rep_ad_month_oct' => "October",
	'rep_ad_month_nov' => "November",
	'rep_ad_month_dec' => "December",
	//rep_cache
	'rep_ad_cache_cache' => "CACHE",
	'rep_ad_cache_none' => "No items to cache"
	);
	?>