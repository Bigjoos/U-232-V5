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
    //stderr
    'stderr_errorhead' => "Error",
    'stderr_successhead' => "Success",
    'stderr_invalidemail' => "You must enter an email address",
    'stderr_notfound' => "The email address was not found in the database",
    'stderr_dberror' => "Database error. Please contact an administrator about this.",
    'stderr_confmailsent' => "A confirmation email has been mailed. Please allow a few minutes for the mail to arrive.",
    'stderr_nomail' => "Unable to send mail. Please contact an administrator about this error.",
    'stderr_noupdate' => "Unable to update user data. Please contact an administrator about this error.",
    'stderr_mailed' => "The new account details have been mailed to <b>(%s)</b>. Please allow a few minutes for the mail to arrive.",
    //head
    'head_recover' => "Recover",
    //email
    'email_head' => "Error",
    'email_subjdetails' => "account details",
    'email_subjreset' => "password reset confirmation",
    'email_request' => "Someone, hopefully you, requested that the password for the account
associated with this email address (%s) be reset.

The request originated from %s.

If you did not do this ignore this email. Please do not reply.


Should you wish to confirm this request, please follow this link:

%s/recover.php?id=%u&secret=%s


After you do this, your password will be reset and emailed back
to you.

--",
    'email_newpass' => "As per your request we have generated a new password for your account.

Here is the information we now have on file for this account:

    User name: %s
    Password:  %s

You may login at %s/login.php

--",
    //captcha
    'captcha_spam' => "NO SPAM! Wait 10 seconds and then refresh page",
    'captcha_refresh' => "Click to refresh image",
    'captcha_imagealt' => "Captcha image",
    'captcha_pin' => "PIN:",
    //recover
    'recover_unamepass' => "Recover lost user name or password",
    'recover_form' => "Use the form below to have your password reset and your account details mailed back to you.<br />(You will have to reply to a confirmation email.)",
    'recover_regdemail' => "Registered email",
    'recover_btn' => "Do it!"
);
?>