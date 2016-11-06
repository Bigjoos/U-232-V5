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
	//cleanup
	'cleanup_stderr' => "Error",
	'cleanup_stderr1' => "Another cleanup operation is already in progress. Refresh to try again.",
	'cleanup_stderr2' => "Bad you!",
	'cleanup_stderr3' => "Why me?",
	'cleanup_head' => "Current Cleanup Tasks",
	'cleanup_title' => "Cleanup Title &amp; Description",
	'cleanup_run' => "Runs every",
	'cleanup_next'  => "Next Clean Time",
	'cleanup_edit'  =>  "Edit",
	'cleanup_delete'    =>  "Delete",
	'cleanup_on'    =>  "Off/On",
	'cleanup_run_now'   =>  "Run&nbsp;now",
	'cleanup_panic'  =>  "Fucking panic now!",
	'cleanup_lock'  =>  " (Locked)",
	'cleanup_edit'  =>  "Edit",
	'cleanup_edit2' =>  "Edit Cleanup",
	'cleanup_delete1'    =>  "Delete",
	'cleanup_delete2'   =>  "Delete Cleanup",
	'cleanup_off_on2'   =>  "On/Off Cleanup",
	'cleanup_off_on'    =>  "on/off",
	'cleanup_run_now2'  =>  "Run it now",
	'cleanup_add_new'  =>  "Add new",
	'cleanup_stdhead'   =>  "Cleanup Manager - View",
       
	//cleanup_show_edit
	'cleanup_show_head' =>  "Editing cleanup: ",
	'cleanup_show_title' =>  "Title",
	'cleanup_show_descr'  =>  "Description",
	'cleanup_show_file' =>  "Cleanup File Name",
	'cleanup_show_interval' =>  "Cleanup Interval",
	'cleanup_show_log'  =>  "Cleanup Log",
	'cleanup_show_on'   =>  "Cleanup On or Off?",
	'cleanup_show_yes'  =>  "Yes &nbsp; ",
	'cleanup_show_no'   =>  " &nbsp; No",
	'cleanup_show_edit' =>  "Edit",
	'cleanup_show_cancel'   =>  "Cancel",
	'cleanup_show_stdhead'  =>  "Cleanup Manager - Edit",
       
	//cleanup_take_edit
	'cleanup_take_error'    =>  "Error",
	'cleanup_take_error1'   =>  "Don't leave any field blank ",
	'cleanup_take_error2'   =>  "Don't leave any field blank",
	'cleanup_take_error3'   =>  "You need to upload the cleanup file first!",
       
	//cleanup_show_new
	'cleanup_new_head'  =>  "Add a new cleanup task",
	'cleanup_new_add'   =>  "Add",
	'cleanup_new_cancel'    =>  "Cancel",
	'cleanup_new_stdhead'   =>  "Cleanup Manager - Add New",
	'cleanup_new_success'   =>  "Success, new cleanup task added!",
	'cleanup_new_info'  =>  "Info",
	'cleanup_new_error' =>  "Error",
	'cleanup_new_error1' =>  "Something went horridly wrong",
       
	//cleanup_take_delete
	'cleanup_del_error' =>  "Error",
	'cleanup_del_error1'    =>  "Bad you!",
	'cleanup_del_info'  =>  "Info",
	'cleanup_del_success'   =>  "Success, cleanup task deleted!",
	'cleanup_del_error2'    =>  "Something went horridly wrong",
       
	//cleanup_take_unlock
	'cleanup_unlock_error'    =>  "Error",
	'cleanup_unlock_error1'   =>  "Don't leave any field blank ",
	'cleanup_unlock_error2'   =>  "Something went horridly wrong",
	//Achiev global Update
	'doc_achiev_earned' => "New Achievement Earned!",
	'doc_achiev_congrats' => "Congratulations, you have just earned the",
	'doc_achiev_msg' => "achievement. :)",
	'doc_achiev_member' => " Member(s)",
	'doc_achiev_items' => " items updated",
	'doc_achiev_queries' => "queries.",
	//Achiev Avatar Update
	'doc_avatar_setter' => "Avatar Setter",
	'doc_avatar_profile' => "User has successfully set an avatar on profile settings.",
	'doc_avatar_clean' => "Achievements Cleanup: Achievements Avatar Setter Completed using",
	'doc_avatar_award' => "Avatar Achievements awarded to - ",
	//Birthday updated
	'doc_bday_first' => "First Birthday",
	'doc_bday_fiirst1' => "Been a member for at least 1 year.",
	'doc_bday_second' => "Second Birthday",
	'doc_bday_second1' => "Been a member for a period of at least 2 years.",
	'doc_bday_third' => "Third Birthday",
	'doc_bday_third1' => "Been a member for a period of at least 3 years.",
	'doc_bday_fourth' => "Fourth Birthday",
	'doc_bday_fourth1' => "Been a member for a period of at least 4 years.",
	'doc_bday_fifth' => "Fifth Birthday",
	'doc_bday_fifth1' => "Been a member for a period of at least 5 years.",
	'doc_bday_sixth' => "Sixth Birthday",
	'doc_bday_sixth1' => "Been a member for a period of at least 6 years.",
	'doc_bday_clean' => "Achievements Cleanup: Achievements Birthdays Completed using",
	'doc_bday_award' => "Birthday Achievements awarded to - ",
	//Corrupt update
	'doc_corrupt_count' => "Corruption Counts",
	'doc_corrupt_transf' => "Transferred at least 1 byte of incoming corrupt data.",
	'doc_corrupt_clean' => "Achievements Cleanup:  Achievements Corruption Completed using",
	'doc_corrupt_award' => "Client Corruption Achievements awarded to - ",
	//Fpost update
	'doc_fpost_lvl1' => "Forum Poster Level 1",
	'doc_fpost_made1' => "Made at least 1 post in the forums.",
	'doc_fpost_lvl2' => "Forum Poster Level 2",
	'doc_fpost_made2' => "Made at least 25 posts in the forums.",
	'doc_fpost_lvl3' => "Forum Poster Level 3",
	'doc_fpost_made3' => "Made at least 50 posts in the forums.",
	'doc_fpost_lvl4' => "Forum Poster Level 4",
	'doc_fpost_made4' => "Made at least 100 posts in the forums.",
	'doc_fpost_lvl5' => "Forum Poster Level 5",
	'doc_fpost_made5' => "Made at least 250 posts in the forums.",
	'doc_fpost_lvl6' => "Forum Poster Level 6",
	'doc_fpost_made6' => "Made at least 500 posts in the forums.",
	'doc_fpost_lvl7' => "Forum Poster Level 7",
	'doc_fpost_made7' => "Made at least 750 posts in the forums.",
	'doc_fpost_clean' => "Achievements Cleanup: Achievements Forum Posts Completed",
	'doc_fpost_award' => "Forum Posts Achievements awarded to - "

	
	);
?>