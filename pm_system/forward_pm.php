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
//=== don't allow direct access
if (!defined('BUNNY_PM_SYSTEM')) {
    $HTMLOUT = '';
    $HTMLOUT.= '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
        <html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
        <head>
        <meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
        <title>ERROR</title>
        </head><body>
        <h1 style="text-align:center;">ERROR</h1>
        <p style="text-align:center;">How did you get here? silly rabbit Trix are for kids!.</p>
        </body></html>';
    echo $HTMLOUT;
    exit();
}
//=== make sure they "should" be forwarding this PM
$res = sql_query('SELECT * FROM messages WHERE id=' . sqlesc($pm_id)) or sqlerr(__FILE__, __LINE__);
$message = mysqli_fetch_assoc($res);
if (mysqli_num_rows($res) === 0) stderr($lang['pm_error'], $lang['pm_forwardpm_notfound']);
if ($message['receiver'] == $CURUSER['id'] && $message['sender'] == $CURUSER['id']) stderr($lang['pm_error'], $lang['pm_forwardpm_gentleman']);
//=== Try finding a user with specified name
$res_username = sql_query('SELECT id, class, acceptpms, notifs FROM users WHERE LOWER(username)=LOWER(' . sqlesc(htmlsafechars($_POST['to'])) . ') LIMIT 1');
$to_username = mysqli_fetch_assoc($res_username);
if (mysqli_num_rows($res_username) === 0) stderr($lang['pm_error'], $lang['pm_forwardpm_nomember']);
//=== make sure the reciever has space in their box
$res_count = sql_query('SELECT COUNT(id) FROM messages WHERE receiver = ' . sqlesc($to_username['id']) . ' AND location = 1') or sqlerr(__FILE__, __LINE__);
if (mysqli_num_rows($res_count) > ($maxbox * 6) && $CURUSER['class'] < UC_STAFF) stderr($lang['pm_forwardpm_srry'], $lang['pm_forwardpm_full']);
//=== allow suspended users to PM / forward to staff only
if ($CURUSER['suspended'] === 'yes') {
    $res = sql_query('SELECT class FROM users WHERE id = ' . sqlesc($to_username['id'])) or sqlerr(__FILE__, __LINE__);
    $row = mysqli_fetch_assoc($res);
    if ($row['class'] < UC_STAFF) stderr($lang['pm_error'], $lang['pm_forwardpm_account']);
}
//=== Other then from staff, Make sure recipient wants this message...
if ($CURUSER['class'] < UC_STAFF) {
    //=== first if they have PMs turned off
    if ($to_username['acceptpms'] === 'no') stderr($lang['pm_error'], $lang['pm_forwardpm_dont_accept']);
    //=== if this member has blocked the sender
    $res2 = sql_query('SELECT id FROM blocks WHERE userid=' . sqlesc($to_username['id']) . ' AND blockid=' . sqlesc($CURUSER['id'])) or sqlerr(__FILE__, __LINE__);
    if (mysqli_num_rows($res2) === 1) stderr($lang['pm_forwardpm_refused'], $lang['pm_forwardpm_blocked']);
    //=== finally if they only allow PMs from friends
    if ($to_username['acceptpms'] === 'friends') {
        $res2 = sql_query('SELECT * FROM friends WHERE userid=' . sqlesc($to_username['id']) . ' AND friendid=' . sqlesc($CURUSER['id'])) or sqlerr(__FILE__, __LINE__);
        if (mysqli_num_rows($res2) != 1) stderr($lang['pm_forwardpm_refused'], $lang['pm_forwardpm_accept']);
    }
}
//=== ok... all is good... let's get the info and send it :D
$subject = htmlsafechars($_POST['subject']);
$first_from = (validusername($_POST['first_from']) ? htmlsafechars($_POST['first_from']) : '');
$body = "\n\n" . $_POST['body'] . "\n\n{$lang['pm_forwardpm_0']}[b]" . $first_from . "{$lang['pm_forwardpm_1']}[/b] \"" . htmlsafechars($message['subject']) . "\"{$lang['pm_forwardpm_2']}" . $message['msg'] . "\n";
sql_query('INSERT INTO `messages` (`sender`, `receiver`, `added`, `subject`, `msg`, `unread`, `location`, `saved`, `poster`, `urgent`) 
                        VALUES (' . sqlesc($CURUSER['id']) . ', ' . sqlesc($to_username['id']) . ', ' . TIME_NOW . ', ' . sqlesc($subject) . ', ' . sqlesc($body) . ', \'yes\', 1, ' . sqlesc($save) . ', 0, ' . sqlesc($urgent) . ')') or sqlerr(__FILE__, __LINE__);
$mc1->delete_value('inbox_new_' . $to_username['id']);
$mc1->delete_value('inbox_new_sb_' . $to_username['id']);
//=== Check if message was forwarded
if (mysqli_affected_rows($GLOBALS["___mysqli_ston"]) === 0) stderr($lang['pm_error'], $lang['pm_forwardpm_msg_fwd']);
//=== if they just have to know about it right away... send them an email (if selected if profile)
if (strpos($to_username['notifs'], '[pm]') !== false) {
    $username = htmlsafechars($CURUSER['username']);
    $body = <<<EOD
{$lang['pm_forwardpm_pmfrom']}$username{$lang['pm_forwardpm_exc']}

{$lang['pm_forwardpm_url']}

{$INSTALLER09['baseurl']}/pm_system.php

--
{$INSTALLER09['site_name']}
EOD;
    @mail($user['email'], $lang['pm_forwardpm_pmfrom'] . $username . $lang['pm_forwardpm_exc'] , $body, "{$lang['pm_forwardpm_from']}{$INSTALLER09['site_email']}");
}
header('Location: pm_system.php?action=view_mailbox&forwarded=1');
die();
?>
