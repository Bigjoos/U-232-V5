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
    //Modtask
    'modtask_user_error' => "USER ERROR",
    'modtask_try_again' => "Please try again",
    'modtask_error' => "Error",
    'modtask_bad_id' => "Bad user ID.",
	//change class
    'modtask_promoted' => "Promoted",
    'modtask_demoted' => "Demoted",
    'modtask_have_been' => "You have been %s to",
    'modtask_by' => "by",
	'modtask_invalid' => "Invalid",
	'modtask_pmsl' => "Pmsl",
	'modtask_die_bit' => "Die bitch",
	'modtask_cannot_edit' => "You cannot edit someone of the same or higher class.. injecting stuff arent we? Action logged",
	'modtask_user_immune' => "This user is immune to your commands !",
	'modtask_badclass' => "Bad class :P",
	'modtask_cls_change' => "Member Class Change",
	//donor
    'modtask_donor_removed' => " - Donor status removed by ",
    'modtask_donor_expired' => "Your donator status has expired.",
    'modtask_donor_set' => " - Donor status set by ",
    'modtask_donor_received' => "You have received donor status from ",
    'modtask_donor_duration' => "You have received donator status for %s from ",
    'modtask_donor_for' => " - Donator status set for %s by ",
	'modtask_donor_sts' => "You have received donor status from ",
	'modtask_donor_subject' => "Thank You for Your Donation!",
	'modtask_donor_week' => " week",
	'modtask_donor_weeks' => "s",
	'modtask_donor_dear' => "Dear",
	'modtask_donor_msg' => "
       :wave:
       Thanks for your support to {$INSTALLER09['site_name']} !
       Your donation helps us in the costs of running the site!
       As a donor, you are given some bonus gigs added to your uploaded amount, the status of VIP, and the warm fuzzy feeling you get inside for helping to support this site that we all know and love :smile: so, thanks again, and enjoy!
       cheers,
       {$INSTALLER09['site_name']} Staff
       PS. Your donator status will last for ",
	'modtask_donor_msg1' => "and can be found on your user details page and can only be seen by you :smile: It was set by ",
	'modtask_donor_msg2' => "
       :wave:
       Thanks for your continued support to {$INSTALLER09['site_name']} !
       Your donation helps us in the costs of running the site. Everything above the current running costs will go towards next months costs!
       As a donor, you are given some bonus gigs added to your uploaded amount, and, you have the the status of VIP, and the warm fuzzy feeling you get inside for helping to support this site that we all know and love :smile: so, thanks again, and enjoy! cheers,
       {$INSTALLER09['site_name']} Staff
        PS. Your donator status will last for an extra ",
	'modtask_donor_msg3' => " on top of your current donation status, and can be found on your user details page and can only be seen by you :smile: It was set by ",
	'modtask_donor_subject_again' => "Thank You for Your Donation... Again!",
	'modtask_donor_set_another' => " - Donator status set for another ",
	'modtask_donor_subject_expire' => "Donator status expired.",
	'modtask_donor_yes' => "Donor = Yes",	
	'modtask_donor_no' => "Donor = No",
	//enabled/disabled
    'modtask_enabled' => "- Enabled by ",
    'modtask_disabled' => "- Disabled by ",
	'modtask_enabled_disabled' => "Enabled = ",
	///Global notification
	'modtask_gl_notification' => "Notification!",
	'modtask_gl_reason' => "Reason:",
	'modtask_gl_received' => "You have received",
	'modtask_gl_by' => " by ",
	'modtask_gl_week' => " week",
	'modtask_gl_weeks' => "s",
	'modtask_gl_from' => " from ",
	'modtask_to' => " to ",
	'modtask_gl_was' => ". was ",
    'modtask_to' => "to",
	//down pos
	/*
    'modtask_downloadpos' => " - Download disabled by ",
    'modtask_downloadpos_removed' => "Your downloads have been restored by ",
    'modtask_dldisabled_by' => " - Downloads disabled by ",
    'modtask_dldisable_received' => "Downloads disabled by ",
    'modtask_dldisabled_for' => " - Downloads for %s by ",
    'modtask_dldisabled_duration' => "You have received a %s Download disablement from ",
	*/
	/////down possible 
	'modtask_down_dis_by' => " - Download disablement by ",
	'modtask_down_dis_right' => "Your Downloading rights have been disabled by ",
	'modtask_down_dis_status' => " - Download disablement status removed by ",
	'modtask_down_res_by' => "Your Downloading rights have been restored by ",
	'modtask_down_dis_from' => "Download disablement from ",
	'modtask_down_dis_for' => " - Download disablement for",
	'modtask_down_pos_no' => "Download possible = No",
	'modtask_down_pos_yes' => "Download possible = Yes",
	'modtask_down_disabled' => "Downloads disabled  = ",
	//upload posssible
	'modtask_up_dis_by' => " - Upload disablement by ",
	'modtask_up_dis_right' => "Your Uploading rights have been disabled by ",
	'modtask_up_dis_status' => " - Upload disablement status removed by ",
	'modtask_up_res_by' => "Your Uploading rights have been restored by ",
	'modtask_up_dis_from' => "Upload disablement from ",
	'modtask_up_dis_for' => " - Upload disablement for",
	'modtask_up_pos_no' => "Uploads enabled = No",
	'modtask_up_pos_yes' => "Uploads enabled = Yes",
	'modtask_up_disabled' => "Uploads disabled  = ",
	//pm possible
	'modtask_pm_dis_by' => " - Pm disablement by ",
	'modtask_pm_dis_right' => "Your Pm rights have been disabled by ",
	'modtask_pm_dis_status' => " - Pm disablement status removed by ",
	'modtask_pm_res_by' => "Your Pm rights have been restored by ",
	'modtask_pm_dis_from' => "Pm disablement from ",
	'modtask_pm_dis_for' => " - Pm disablement for",
	'modtask_pm_pos_no' => "Private messages enabled = No",
	'modtask_pm_pos_yes' => "Private messages enabled = Yes",
	'modtask_pm_disabled' => "Private messages disabled = ",
	//chat possible
    //'modtask_chatpos' => "- Chat post rights set to",
	'modtask_shout_dis_by' => " - Shout disablement by ",
	'modtask_shout_dis_right' => "Your Shoutbox rights have been disabled by ",
	'modtask_shout_dis_status' => " - Shoutbox disablement status removed by ",
	'modtask_shout_res_by' => "Your Shoutbox rights have been restored by ",
	'modtask_shout_dis_from' => "Shoutbox disablement from ",
	'modtask_shout_dis_for' => " - Shoutbox disablement for",
	'modtask_shout_pos_no' => "Shoutbox enabled = No",
	'modtask_shout_pos_yes' => "Shoutbox enabled = Yes",
	'modtask_shout_disabled' => "Shoutbox disabled = ",
	//immunity
	'modtask_immune_status' => " - Immune Status enabled by ",
	'modtask_immune_received' => "You have received immunity Status from ",
	'modtask_immune_remove' => " - Immunity Status removed by ",
	'modtask_immune_removed' => "Your Immunity Status has been removed by ",
	'modtask_immune_status_from' => "Immunity Status from ",
	'modtask_immune_status_for' => " - Immunity Status for",
	//leechwarn
	'modtask_leechwarn_status' => " - leechwarn Status enabled by ",
	'modtask_leechwarn_received' => "You have received leechwarn Status from ",
	'modtask_leechwarn_remove' => " - leechwarn Status removed by ",
	'modtask_leechwarn_removed' => "Your leechwarn Status has been removed by ",
	'modtask_leechwarn_status_from' => "leechwarn Status from ",
	'modtask_leechwarn_status_for' => " - leechwarn Status for",
	//warned
	/*
	//warn
    'modtask_warned' => " - Warning removed by ",
    'modtask_warned_removed' => "Your warning has been removed by ",
    'modtask_warned_by' => " - Warned by ",
    'modtask_reason' => "Reason:",
    'modtask_warning_received' => "You have received a warning from ",
    'modtask_warning_duration' => "You have received a %s warning from ",
    'modtask_warned_for' => " - Warned for %s by ",
	*/
	'modtask_warned_status' => " - warned Status enabled by ",
	'modtask_warned_received' => "You have received warned Status from ",
	'modtask_warned_remove' => " - warned Status removed by ",
	'modtask_warned_removed' => "Your warned Status has been removed by ",
	'modtask_warned_status_from' => "warned Status from ",
	'modtask_warned_status_for' => " - warned Status for",
	//add/substract uploaded
    'modtask_add_upload' => " - Added Upload",
    'modtask_subtract_upload' => " - Subtracted Upload",
	'modtask_uploaded_altered' => "Uploaded total altered from ",
	//add/substract downloaded
    'modtask_subtract_download' => " - Subtracted Download",
    'modtask_added_download' => " - Added Download",
	'modtask_download_altered' => "Downloaded total altered from ",
	//custom title
    'modtask_custom_title' => " - Custom Title changed to ",
	'modtask_custom_title_altered' => "Custom title altered",
	//reset torrent pass
    'modtask_passkey' => " - Passkey ",
    'modtask_reset' => " Reset to ",
	'modtask_torrent_pass' => "Passkey ",
	'modtask_torrent_pass_reset' => " reset to ",
	//seedbonus
	'modtask_seedbonus' => " - Seedbonus amount changed to ",
	'modtask_seedbonus_total' => "Seedbonus points total adjusted",
	//reputation
	'modtask_reputation' => " - Reputation points changed to ",
	'modtask_reputation_total' => "Reputation points total adjusted",
	//img err avatar & signature
	'modtask_not_image' => "Not an image or unsupported image!",
    'modtask_image_small' => "Image is too small",
	//avatar
    'modtask_avatar_change' => " - Avatar changed from ",
	'modtask_avatar_changed' => "Avatar changed",
	//signature
    'modtask_signature_change' => " - Signature changed from ",
	'modtask_signature_changed' => "Signature changed",
	//invites
	/*
    'modtask_invites_enabled' => " - Invite rights enabled by ",
    'modtask_invites_rights' => "Your invite rights have been given back by ",
    'modtask_invites_youcan' => "  You can invite users again.",
    'modtask_invites_removed' => "Your invite rights have been removed by",
    'modtask_invites_reason' => "probably because you invited a bad user.",
    'modtask_invites_amount' => "- Invite amount changed to",
    'modtask_invites_from' => "from",
    'modtask_invites_by' => "by",
	*/
	'modtask_invites_allowed' => " - Invites allowed changed from ",
	'modtask_invites_enabled' => "Invites enabled = ",
	'modtask_invites_amount' => " - Invite amount changed to ",
	'modtask_invites_total' => "Invites total adjusted",
	//fls support
	'modtask_fls_promoted' => " - Promoted to FLS by ",
	'modtask_fls_demoted' => " - Demoted from FLS by ",
	'modtask_fls_support' => "Support  = ",
	//free slots
	'modtask_freeslots_amount' => " - freeslots amount changed to ",
	'modtask_freeslots_total' => "Freeeslots total adjusted = Yes",
	//freelech
	'modtask_freelech_status' => " - Freeleech Status enabled by ",
	'modtask_freelech_received' => "You have received Freeleech Status from ",
	'modtask_freelech_yes' => "Freeleech enabled = Yes",
	'modtask_freelech_remove' => " - Freeleech Status removed by ",
	'modtask_freelech_removed' => "Your Freeleech Status has been removed by ",
	'modtask_freelech_no' => "Freeleech enabled = No",
	'modtask_freelech_from' => "Freeleech Status from ",
	'modtask_freelech_for' => " - Freeleech Status for",
	'modtask_freelech_enabled' => "Freeleech enabled = ",	
	//game possible
	'modtask_games_dis_by' => " - Gaming disablement by ",
	'modtask_games_dis_right' => "Your gaming rights have been disabled by ",
	'modtask_games_dis_status' => " - Gaming disablement status removed by ",
	'modtask_games_res_by' => "Your gaming rights have been restored by ",
	'modtask_games_dis_from' => "games disablement from ",
	'modtask_games_dis_for' => " - Games disablement for",
	'modtask_games_disabled' => "Games disabled  = ",
	'modtask_games_poss_yes' => "Games possible = Yes",
	'modtask_games_poss_no' => "Games possible = No",
	//Avatar possible
	'modtask_avatar_dis_by' => " - Avatar disablement by ",
	'modtask_avatar_dis_right' => "Your Avatar rights have been disabled by ",
	'modtask_avatar_dis_status' => " - Avatar disablement status removed by ",
	'modtask_avatar_res_by' => "Your Avatar rights have been restored by ",
	'modtask_avatar_dis_from' => "Avatar disablement from ",
	'modtask_avatar_dis_for' => " - Avatar disablement for",
	'modtask_avatar_sel_dis' => "Avatar selection disabled  = ",
	'modtask_avatar_poss_yes' => "Avatars possible = Yes",
	'modtask_avatar_poss_no' => "Avatars possible = No",
	//highspeed 
	'modtask_highs_enable_by' => " - Highspeed Upload enabled by ",
	'modtask_highs_status' => "Highspeed uploader status.",
	'modtask_highs_set' => "You have been set as a high speed uploader by ",
	'modtask_highs_msg' => ". You can now upload torrents using highspeeds without being flagged as a cheater.",
	'modtask_highs_disable_by' => " - Highspeed Upload disabled by ",
	'modtask_highs_disabled' => "Your highspeed upload setting has been disabled by ",
	'modtask_highs_pm' => ". Please PM ",
	'modtask_highs_reason' => " for the reason why.",
	'modtask_highs_enabled' => "Highspeed uploader enabled = ",
	//can leech
	'modtask_canleech_on_by' => " - Download enabled by ",
	'modtask_canleech_status' => "Download status.",
	'modtask_canleech_rights_on' => "Your Downloads have been enabled by ",
	'modtask_canleech_off_by' => " - Downloads disabled by ",
	'modtask_canleech_ability' => "Your downloading ability has been disabled by ",
	'modtask_canleech_pm' => ". Please PM ",
	'modtask_canleech_reason' => " for the reason why.",
	'modtask_canleech_edited' => "Downloads edited = ",
	//wait time
	'modtask_wait_set' => " - Wait time set to",
	'modtask_wait_yes' => "Wait time adjusted = Yes",
	//peers limit
	'modtask_peer_limit' => " - Peers limit set to",
	'modtask_peer_adjusted' => "Peers limit adjusted = Yes",
	//torrent limits
	'modtask_torrent_limit' => " - Torrents limit set to",
	'modtask_torrent_adjusted' => "Torrents limit adjusted = Yes",
	//parked
	'modtask_parked_by' => " - Account Parked by ",
	'modtask_unparked_by' => " - Account UnParked by ",
	'modtask_parked_acc' => "Account parked = ",
	//suspend
	'modtask_suspend_err' => "You must enter a reason to suspend this account!",
	'modtask_suspend_by' => " - This account has been suspended by ",
	'modtask_suspend_reason' => " reason: ",
	'modtask_suspended_yes' => "Account suspended = Yes",
	'modtask_suspend_title' => "Account Suspended!",
	'modtask_suspend_msg' => "Your account has been suspended by ",
	'modtask_suspend_msg1' => "The Reason:",
	'modtask_suspend_msg2' => "While your account is suspended, your posting - uploading - downloading - commenting - invites will not work, and the only people that you can PM are staff members.",
	'modtask_suspend_msg3' => "If you feel this suspension is in error, please feel free to contact a staff member. ",
	'modtask_suspend_msg4' => "cheers,",
	'modtask_suspend_msg5' => " Staff",
	'modtask_suspend_acc_for' => "Account for ",
	'modtask_suspend_has_by' => " has been suspended by ",
	'modtask_unsuspend_by' => " - This account has been Un-suspended by ",
	'modtask_suspended_no' => "Account suspended = No",
	'modtask_unsuspend_title' => "Account Un-Suspended!",
	'modtask_unsuspend_msg' => "Your account has had it's suspension lifted by ",
	//hit & run
	'modtask_hit_run_set' => " - Hit and runs set to ",
	'modtask_hit_run_adjusted' => "Hit and run total adjusted = Yes",
	//forum post enable/disable
	'modtask_post_en_by' => " - Posting enabled by ",
	'modtask_post_give_back' => "Your Posting rights have been given back by ",
	'modtask_post_forum_again' => ". You can post to forum again.",
	'modtask_post_dis_by' => " - Posting disabled by ",
	'modtask_post_rem_by' => "Your Posting rights have been removed by ",
	'modtask_post_pm' => ", Please PM ",
	'modtask_post_reason' => " for the reason why.",
	'modtask_post_rights' => "Posting rights",
	'modtask_post_enabled' => "Forum post enabled = ",
	//signature rights
	'modtask_signature_rights_off' => " - Signature rights turned off by ",
	'modtask_signature_rights_off_by' => "Your Signature rights turned off by ",
	'modtask_signature_rights_pm' => ". PM them for more information.",
	'modtask_signature_rights_on' => " - Signature rights turned on by ",
	'modtask_signature_rights_on_by' => "Your Signature rights turned back on by ",
	'modtask_signature_rights' => "Signature rights",
	'modtask_signature_rights_enabled' => "Signature post enabled = ",
	//avatar rights
	'modtask_avatar_rights_off' => " - Avatar rights turned off by ",
	'modtask_avatar_rights_on' => " - Avatar rights turned on by ",
	'modtask_avatar_rights_enabled' => "Avatar rights enabled = ",
	//offensive avatar
	'modtask_offensive_no' => " - Offensive avatar set to no by ",
	'modtask_offensive_no_by' => "Your avatar has been set to not offensive by ",
	'modtask_offensive_yes' => " - Offensive avatar set to yes by ",
	'modtask_offensive_yes_by' => "Your avatar has been set to offensive by ",
	'modtask_offensive_pm' => " PM them to ask why.'",
	'modtask_offensive_avatar' => "Offensive avatar",
	'modtask_offensive_enabled' => "Offensive avatar enabled = ",	
	'modtask_view_offensive_no' => " - View offensive avatar set to no by ",
	'modtask_view_offensive_yes' => " - View offensive avatar set to yes by ",
	'modtask_view_offensive_enabled' => "View offensive avatar enabled = ",
	//paranoia
	'modtask_paranoia_changed_to' => " - Paranoia changed to ",
	'modtask_paranoia_changed' => "Paranoia level changed",	
	//website
	'modtask_website_changed_to' => " - website changed to ",
	'modtask_website_changed' => "Website changed",
	//google talk
	'modtask_gtalk_changed_to' => " - google_talk changed to ",
	'modtask_gtalk_changed' => "Google talk address changed",
	//msn
	'modtask_msn_changed_to' => " - msn changed to ",
	'modtask_msn_changed' => "Msn address changed",
	//aim
	'modtask_aim_changed_to' => " - aim changed to ",
	'modtask_aim_changed' => "AIM address changed",
	//yahoo
	'modtask_yahoo_changed_to' => " - yahoo changed to ",
	'modtask_yahoo_changed' => "Yahoo address changed",
	//icq
	'modtask_icq_changed_to' => " - icq changed to ",
	'modtask_icq_changed' => "ICQ address changed",
	// Sysop log
	'modtask_sysop_user_acc' => "User account",
	'modtask_sysop_thing' => "Things edited: ",
	'modtask_from' => "From",
    'modtask_no_idea' => "No idea what to do"
);
?>