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
    //takeinvites
    'takeinvites_error' => "Error",
    'takeinvites_limit' => "Sorry, user limit reached. Please try again later.",
    'takeinvites_sorry' => "Sorry",
    'takeinvites_removed' => "Your invite previlages has been removed.",
    'takeinvites_user_error' => "Invite Failed",
    'takeinvites_noinvites' => "No Invites!",
    'takeinvites_entermessage' => "You must enter a message!",
    'takeinvites_invalidemail' => "Invalid Email Address!",
    'takeinvites_email_used' => "The e-mail address is already in use.",
    'takeinvites_user_exists' => "Username already exists!",
    'takeinvites_fatal_error' => "Fatal Error!",
    'takeinvites_confirm' => "New membership request",
    'takeinvites_from' => "From:"
);
$lang['takeinvites_email_body'] = <<<EOD

You have been invited to <#SITENAME#> by <#INVITENICK#>. They have
specified this address (<#USEREMAIL#>) as your email. 

If you did not do this, please ignore this email. The person who entered your
email address had the IP address <#IP_ADDRESS#>. Please do not reply.

Message:
-------------------------------------------------------------------------------
<#MESSAGE#>
-------------------------------------------------------------------------------

This is a private site and you must follow the rules.

To confirm your invitation, you have to follow this link:

<#REG_LINK#>

After you do this, you will be able to use your new account. If you fail to
do this, your account will be deleted within a few days. We urge you to read
the RULES and FAQ before you start using <#SITENAME#>.
EOD;

?>