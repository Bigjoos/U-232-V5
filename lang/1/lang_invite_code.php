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
    //invite errors
    'invites_error' => "Error",
    'invites_deny' => "Denied",
    'invites_limit' => "Sorry, user limit reached. Please try again later.",
    'invites_disabled' => "Your invite sending privileges has been disabled by the Staff!",
    'invites_noinvite' => "No invites !",
    'invites_invalidemail' => "That doesn't look like a valid email address.",
    'invites_noemail' => "You must enter an email address!",
    'invites_unable' => "Unable to send mail. Please contact an administrator about this error.",
    'invites_confirmation' => "A confirmation email has been sent to the address you specified.",
    'invites_invalid' => "Invalid ID!",
    'invites_noexsist' => "This invite code does not exist.",
    'invites_sure' => "Are you sure you want to delete this invite code?",
    'invites_errorid' => "No user with this ID.",
    'invites_sure1' => "Are you sure you want to confirm",
    //invites
    'invites_users' => "Invited Users",
    'invites_nousers' => "No Invitees Yet",
    'invites_username' => "Username",
    'invites_uploaded' => "Uploaded",
    'invites_downloaded' => "Downloaded",
    'invites_ratio' => "Ratio",
    'invites_status' => "Status",
    'invites_confirm' => "Confirm",
    'invites_confirm1' => "Confirmed",
    'invites_pend' => "Pending",
    'invites_codes' => "Created Invite Codes",
    'invites_nocodes' => "You have not created any invite codes at the moment!",
    'invites_date' => "Created Date",
    'invites_delete' => "Delete",
    'invites_create' => "Create Invite Code",
    'invites_send_code' => "Send Invite Code",
    'invites_delete1' => "Delete Invite",
    'invites_confirm1' => "Confirmed Account",
    /// addterms by yoooov
    'invites_sure2' => "\'s account? Click ",
    'invites_sure3' => "HERE",
    'invites_sure4' => " to confirm it or ",
    'invites_sure5' => " to go back.",    
    'invites_err1' => "Sorry",
    'invites_err2' => "Your account is suspended",
    'invites_invits' => "Invites",
    ///
    'invites_mail_email' => "Email",
    'invites_mail_send' => "Send Email",    
    'invites_mail_err' => "This email address is already in use!",
    'invites_send_emailpart1' => "You have been invited to {$INSTALLER09['site_name']} by",
    'invites_send_emailpart2' => "\n\nThey have specified this address ", 
    'invites_send_emailpart3' => " as your email.\n
If you do not know this person, please ignore this email.\n
Please do not reply.
 
This is a private site and you must agree to the rules before you can enter:\n
 
{$INSTALLER09['baseurl']}/useragreement.php\n
 
{$INSTALLER09['baseurl']}/rules.php\n
 
{$INSTALLER09['baseurl']}/faq.php\n
 
------------------------------------------------------------
 
To confirm your invitation, you have to follow this link and type the invite code:
 
{$INSTALLER09['baseurl']}/invite_signup.php
 
Invite Code: ",
        'invites_send_emailpart4' => "\n
------------------------------------------------------------
 
After you do this, your inviter need's to confirm your account. 
We urge you to read the RULES and FAQ before you start using {$INSTALLER09['site_name']}.",
        ///
        'invites_send_email1_ema' => "You have been invited to {$INSTALLER09['site_name']}",
        'invites_send_email1_bod' => "From: {$INSTALLER09['site_email']}",
        ///
    'invites_send_email2' => "Hey there :wave:
Welcome to {$INSTALLER09['site_name']}!\n
We have made many changes to the site, and we hope you enjoy them!\n 
We have been working hard to make {$INSTALLER09['site_name']} somethin' special!\n
{$INSTALLER09['site_name']} has a strong community (just check out forums), and is a feature rich site.\n
We hope you'll join in on all the fun!\n
Be sure to read the [url={$INSTALLER09['baseurl']}/rules.php]Rules[/url] and [url={$INSTALLER09['baseurl']}/faq.php]FAQ[/url] before you start using the site.\n
We are a strong friendly community here :D {$INSTALLER09['site_name']} is so much more then just torrents.\n
Just for kicks, we've started you out with 200.0 Karma Bonus  Points, and a couple of bonus GB to get ya started!\n 
so, enjoy\n  
cheers,\n 
{$INSTALLER09['site_name']} Staff.\n",
        ///
        'invites_send_email2_sub' => "Welcome to {$INSTALLER09['site_name']} !"
);
?>