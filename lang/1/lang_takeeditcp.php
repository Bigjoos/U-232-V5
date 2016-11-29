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
    //takeeditcp
    'takeeditcp_no_data' => "missing form data",
    'takeeditcp_pass_long' => "Sorry, password is too long (max is 40 chars)",
    'takeeditcp_pass_not_match' => "The passwords didn't match. Try again.",
    'takeeditcp_not_valid_email' => "That doesn't look like a valid email address.",
    'takeeditcp_address_taken' => "Could not change email, address already taken or password mismatch.",
    'takeeditcp_user_error' => "USER ERROR",
    'takeeditcp_image_error' => "Not an image or unsupported image!",
    'takeeditcp_small_image' => "Image is too small",
    'takeeditcp_confirm' => "profile change confirmation",
    'takeeditcp_avatar_not_allow' => "Sorry - Avatar changing disabled to your current user class",
	'takeeditcp_err' => "Error",
	'takeeditcp_uerr' => "USER ERROR",
	'takeeditcp_img_unsupported' => "Not an image or unsupported image!",
	'takeeditcp_img_to_small' => "Image is too small",
	'takeeditcp_sorry' => "Sorry",
	'takeeditcp_secret_long' => "secret answer is too long (max is 40 chars)",
	'takeeditcp_secret_short' => "secret answer is too sort (min is 6 chars)",
	'takeeditcp_email_from' => "From: ",
	'takeeditcp_email_alert' => "Email Alert",
	'takeeditcp_email_user' => "User ",
	'takeeditcp_email_changed' => " changed email address :",
	'takeeditcp_email_old' => " Old email was ",
	'takeeditcp_email_new' => " new email is ",
	'takeeditcp_email_check' => ", please check this was for a legitimate reason",
	'takeeditcp_invalid_custom' => "Invalid custom title!",
	'takeeditcp_birth_year' => "Please set your birth year.",
	'takeeditcp_birth_month' => "Please set your birth month.",
	'takeeditcp_birth_day' => "Please set your birth day.",
	'takeeditcp_birth_not' => "The date entered is not a valid date, please try again",
);
$lang['takeeditcp_email_body'] = <<<EOD
You have requested that your user profile (username <#USERNAME#>)
on <#SITENAME#> should be updated with this email address (<#USEREMAIL#>) as
user contact.

If you did not do this, please ignore this email. The person who entered your
email address had the IP address <#IP_ADDRESS#>. Please do not reply.

To complete the update of your user profile, please follow this link:

<#CHANGE_LINK#>

Your new email address will appear in your profile after you do this. Otherwise
your profile will remain unchanged.
EOD;

?>
