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
$preview = '';
//=== don't allow direct access
if (!defined('BUNNY_PM_SYSTEM')) {
    $HTMLOUT.= '<!DOCTYPE html>
        <html xmlns="http://www.w3.org/1999/xhtml" lang="en">
        <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1" />
        <title>ERROR</title>
        </head><body>
        <h1 class="text-center">ERROR</h1>
        <p class="text-center">How did you get here? silly rabbit Trix are for kids!.</p>
        </body></html>';
    echo $HTMLOUT;
    exit();
}
$save_or_edit = (isset($_POST['edit']) ? 'edit' : (isset($_GET['edit']) ? 'edit' : 'save'));
if (isset($_POST['buttonval']) && $_POST['buttonval'] == 'save as draft') {
    //=== make sure they wrote something :P
    if (empty($_POST['subject'])) stderr($lang['pm_error'], $lang['pm_draft_err']);
    if (empty($_POST['body'])) stderr($lang['pm_error'], $lang['pm_draft_err1']);
    $body = sqlesc($_POST['body']);
    $subject = sqlesc(strip_tags($_POST['subject']));
    if ($save_or_edit === 'save') {
        sql_query('INSERT INTO messages (sender, receiver, added, msg, subject, location, draft, unread, saved) VALUES  
                                                                        (' . sqlesc($CURUSER['id']) . ', ' . sqlesc($CURUSER['id']) . ',' . TIME_NOW . ', ' . $body . ', ' . $subject . ', \'-2\', \'yes\',\'no\',\'yes\')') or sqlerr(__FILE__, __LINE__);
        $mc1->delete_value('inbox_new_' . $CURUSER['id']);
        $mc1->delete_value('inbox_new_sb_' . $CURUSER['id']);
    }
    if ($save_or_edit === 'edit') {
        sql_query('UPDATE messages SET msg = ' . $body . ', subject = ' . $subject . ' WHERE id = ' . sqlesc($pm_id)) or sqlerr(__FILE__, __LINE__);
    }
    //=== Check if messages was saved as draft
    if (mysqli_affected_rows($GLOBALS["___mysqli_ston"]) === 0) stderr($lang[pm_error], $lang['pm_draft_wasnt']);
    header('Location: /pm_system.php?action=view_mailbox&box=-2&new_draft=1');
    die();
} //=== end save draft
//=== Code for preview Retros code
if (isset($_POST['buttonval']) && $_POST['buttonval'] == 'preview') {
    $subject = htmlsafechars(trim($_POST['subject']));
    $draft = trim($_POST['body']);
    $preview = '
    <table class="table table-striped">
    <tr>
        <td colspan="2" class="text-left"><span style="font-weight: bold;">' . $lang['pm_draft_subject'] . '</span>' . htmlsafechars($subject) . '</td>
    </tr>
    <tr>
        <td valign="top" class="text-center" width="80px" id="photocol">' . avatar_stuff($CURUSER) . '</td>
        <td class="text-left" style="min-width:400px;padding:10px;vertical-align: top;">' . format_comment($draft) . '</td>
    </tr>
    </table><br />';
} else {
    //=== Get the info
    $res = sql_query('SELECT * FROM messages WHERE id=' . sqlesc($pm_id)) or sqlerr(__FILE__, __LINE__);
    $message = mysqli_fetch_assoc($res);
    $subject = htmlsafechars($message['subject']);
    $draft = $message['msg'];
}
//=== print out the page
//echo stdhead('Save / Edit Draft');
$HTMLOUT.= '<legend>' . $lang['pm_draft_save_edit'] . '' . $subject . '</legend>' . $top_links . $preview . '
        <form name="compose" action="pm_system.php" method="post">
        <input type="hidden" name="id" value="' . $pm_id . '" />
        <input type="hidden" name="' . $save_or_edit . '" value="1" />
        <input type="hidden" name="action" value="save_or_edit_draft" />
    <table class="table table-striped">
    <tr>
        <td class="text-left" colspan="2">' . $lang['pm_edmail_edit'] . '</td>
    </tr>
    <tr>
        <td class="text-right" valign="top"><span style="font-weight: bold;">' . $lang['pm_draft_subject'] . '</span></td>
        <td class="text-left" valign="top"><input type="text" class="text_default" name="subject" value="' . $subject . '" /></td>
    </tr>
    <tr>
        <td class="text-right" valign="top"><span style="font-weight: bold;">' . $lang['pm_draft_body'] . '</span></td>
        <td class="text-left" valign="top">' . textbbcode('save_or_edit_draft', 'body', $message['msg']) . '</td>
    </tr>
    <tr>
        <td colspan="2" class="text-center">
        <input type="submit" class="btn btn-primary" name="buttonval" value="preview"/>
        <input type="submit" class="btn btn-primary" name="buttonval" value="save as draft" /></td>
    </tr>
    </table></form>';
?>
