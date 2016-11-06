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
/********************************************************************************
why I used a different method for delete and move I have no idea... 
must have combined two scripts at one point but now it's just funny...
I'll have to change that before the next version :o)
oxo,
snuggs
//print_r($_POST);
//print_r($_GET);
//print_r($pm_messages);
//exit();
********************************************************************************/
//=== move
$pm_messages = $_POST['pm'];
if (isset($_POST['move'])) {
    if (is_valid_id($pm_messages)) {
        sql_query('UPDATE messages SET saved = \'yes\', location = ' . sqlesc($mailbox) . ' WHERE id = ' . sqlesc($pm_messages) . ' AND receiver =' . sqlesc($CURUSER['id'])) or sqlerr(__FILE__, __LINE__);
    } else {
        sql_query('UPDATE messages SET saved = \'yes\', location = ' . sqlesc($mailbox) . ' WHERE id IN (' . implode(', ', array_map('sqlesc', $pm_messages)) . ') AND receiver =' . sqlesc($CURUSER['id'])) or sqlerr(__FILE__, __LINE__);
    }
    //=== Check if messages were moved
    if (mysqli_affected_rows($GLOBALS["___mysqli_ston"]) === 0) stderr($lang['pm_error'], $lang['pm_move_err']);
    header('Location: ?action=view_mailbox&multi_move=1&box=' . $mailbox);
    die();
}
//=== delete
if (isset($_POST['delete'])) {
    $pm_messages = $_POST['pm'];
    //=== Delete multiple messages
    foreach ($pm_messages as $id) {
        $res = sql_query('SELECT * FROM messages WHERE id=' . sqlesc($id));
        $message = mysqli_fetch_assoc($res);
        //=== make sure they aren't deleting a staff message...
        if ($message['receiver'] == $CURUSER['id'] && $message['urgent'] == 'yes' && $message['unread'] == 'yes') stderr($lang['pm_error'], '' . $lang['pm_delete_err'] . '<a class="altlink" href="pm_system.php?action=view_message&id=' . $pm_id . '">' . $lang['pm_delete_back'] . '</a>' . $lang['pm_delete_msg'] . '');
        //=== make sure message isn't saved before deleting it, or just update location
        if ($message['receiver'] == $CURUSER['id'] && $message['saved'] == 'no' || $message['sender'] == $CURUSER['id'] && $message['location'] == PM_DELETED) {
            sql_query('DELETE FROM messages WHERE id=' . sqlesc($id)) or sqlerr(__FILE__, __LINE__);
            $mc1->delete_value('inbox_new_' . $message['receiver']);
            $mc1->delete_value('inbox_new_sb_' . $message['receiver']);
        } elseif ($message['receiver'] == $CURUSER['id'] && $message['saved'] == 'yes') {
            sql_query('UPDATE messages SET location=0, unread=\'no\' WHERE id=' . sqlesc($id)) or sqlerr(__FILE__, __LINE__);
            $mc1->delete_value('inbox_new_' . $message['receiver']);
            $mc1->delete_value('inbox_new_sb_' . $message['receiver']);
        } elseif ($message['sender'] == $CURUSER['id'] && $message['location'] != PM_DELETED) {
            sql_query('UPDATE messages SET saved=\'no\' WHERE id=' . sqlesc($id)) or sqlerr(__FILE__, __LINE__);
            $mc1->delete_value('inbox_new_' . $message['sender']);
            $mc1->delete_value('inbox_new_sb_' . $message['sender']);
        }
    }
    //=== Check if messages were deleted
    if (mysqli_affected_rows($GLOBALS["___mysqli_ston"]) === 0) stderr($lang['pm_error'], $lang['pm_delete_err_multi']);
    if (isset($_POST['draft_section'])) header('Location: pm_system.php?action=viewdrafts&multi_delete=1');
    else header('Location: pm_system.php?action=view_mailbox&multi_delete=1&box=' . $mailbox);
    die();
}
?>
