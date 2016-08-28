<?php
$lang = array(
    //buttons text
    'login_btn' => "Login",
    'recover_btn' => "Recover",
    'signup_btn' => "Signup",
    //Login
    'login_username' => "Username:",
    'login_password' => "Password:",
    'login_duration' => "Duration:",
    'login_15mins' => "Log me out after 15 minutes inactivity",
    'login_refresh' => "Click to refresh image",
    'login_captcha' => "Captcha image",
    'login_pin' => "PIN:",
    'login_login' => "Log in!",
    'login_signup' => "<p>Don't have an account? <a href='signup.php'>Sign up</a> right now!</p>",
    'login_login_btn' => "Login",
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
    'captcha_image_alt' => "Captcha image",
    'captcha_pin' => "PIN:",
    //recover
    'recover_unamepass' => "Recover lost user name or password",
    'recover_form' => "Use the form below to have your password reset and your account details mailed back to you.<br />(You will have to reply to a confirmation email.)",
    'recover_regdemail' => "Registered email:",
    'recover_button' => "Do it!",
    //head
    'head_signup' => "Signup",
    //stderr
    'stderr_ulimit' => "The current user account limit (%u) has been reached. Inactive accounts are pruned all the time, please check back again later...",
    //signup
    'signup_cookies' => "Note: You need cookies enabled to sign up or log in.",
    'signup_uname' => "Desired username:",
    'signup_pass' => "Pick a password:",
    'signup_passa' => "Enter password again:",
    'signup_email' => "Email address:",
    'signup_valemail' => "The email address must be valid.You will receive a confirmation email which you need to respond to. The email address won't be publicly shown anywhere.",
    'signup_timez' => "Timezone:",
    'signup_rules' => "I have read the site rules page.",
    'signup_faq' => "I agree to read the FAQ before asking questions.",
    'signup_age' => "I am at least 13 years old.",
    'signup_button' => "Sign up! (PRESS ONLY ONCE)",
);
?>