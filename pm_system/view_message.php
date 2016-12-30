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
$subject = $friends = '';
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
//=== Get the message
$res = sql_query('SELECT m.*, f.id AS friend, b.id AS blocked
                            FROM messages AS m LEFT JOIN friends AS f ON f.userid = ' . sqlesc($CURUSER['id']) . ' AND f.friendid = m.sender
                            LEFT JOIN blocks AS b ON b.userid = ' . sqlesc($CURUSER['id']) . ' AND b.blockid = m.sender WHERE m.id = ' . sqlesc($pm_id) . ' AND (receiver=' . sqlesc($CURUSER['id']) . ' OR (sender=' . sqlesc($CURUSER['id']) . ' AND (saved = \'yes\' || unread= \'yes\'))) LIMIT 1') or sqlerr(__FILE__, __LINE__);
$message = mysqli_fetch_assoc($res);
if (!$res) stderr($lang['pm_error'], $lang['pm_viewmsg_err']);
//=== get user stuff
$res_user_stuff = sql_query('SELECT id, username, uploaded, warned, suspended, enabled, donor, class, avatar, leechwarn, chatpost, pirate, king, opt1, opt2 FROM users WHERE id=' . ($message['sender'] === $CURUSER['id'] ? sqlesc($message['receiver']) : sqlesc($message['sender']))) or sqlerr(__FILE__, __LINE__);
$arr_user_stuff = mysqli_fetch_assoc($res_user_stuff);
$id = (int)$arr_user_stuff['id'];
//=== Mark message read
sql_query('UPDATE messages SET unread=\'no\' WHERE id=' . sqlesc($pm_id) . ' AND receiver=' . sqlesc($CURUSER['id']) . ' LIMIT 1') or sqlerr(__FILE__, __LINE__);
$mc1->delete_value('inbox_new_' . $CURUSER['id']);
$mc1->delete_value('inbox_new_sb_' . $CURUSER['id']);
if ($message['friend'] > 0) $friends = '' . $lang['pm_mailbox_char1'] . '<span class="font_size_1"><a href="friends.php?action=delete&amp;type=friend&amp;targetid=' . $id . '">' . $lang['pm_mailbox_removef'] . '</a></span>' . $lang['pm_mailbox_char2'] . '';
elseif ($message['blocked'] > 0) $friends = '' . $lang['pm_mailbox_char1'] . '<span class="font_size_1"><a href="friends.php?action=delete&amp;type=block&amp;targetid=' . $id . '">' . $lang['pm_mailbox_removeb'] . '</a></span>' . $lang['pm_mailbox_char2'] . '';
elseif ($id > 0) $friends = '' . $lang['pm_mailbox_char1'] . '<span class="font_size_1"><a href="friends.php?action=add&amp;type=friend&amp;targetid=' . $id . '">' . $lang['pm_mailbox_addf'] . '</a></span>' . $lang['pm_mailbox_char2'] . ' 
                               ' . $lang['pm_mailbox_char1'] . '<span class="font_size_1"><a href="friends.php?action=add&amp;type=block&amp;targetid=' . $id . '">' . $lang['pm_mailbox_addb'] . '</a></span>' . $lang['pm_mailbox_char2'] . '';


$avatar = (!$CURUSER['opt1'] & user_options::AVATARS ? '' : (empty($arr_user_stuff['avatar']) ? '
    <img width="80" src="pic/default_avatar.gif" alt="no avatar" />' : (($arr_user_stuff['opt1'] & user_options::OFFENSIVE_AVATAR && !$CURUSER['opt1'] & user_options::VIEW_OFFENSIVE_AVATAR) ? '<img width="80" src="pic/fuzzybunny.gif" alt="fuzzy!" />' : '<a href="' . htmlsafechars($arr_user_stuff['avatar']) . '"><img width="80" src="' . htmlsafechars($arr_user_stuff['avatar']) . '" alt="avatar" /></a>')));
$the_buttons = '<input type="submit" class="button_tiny" value="' . $lang['pm_viewmsg_move'] . '" onmouseover="this.className=\'button_tiny_hover\'" onmouseout="this.className=\'button_tiny\'"></form>
            <a class="buttlink"  href="pm_system.php?action=delete&amp;id=' . $pm_id . '"><input type="submit" class="btn btn-primary" value="' . $lang['pm_viewmsg_delete'] . '"></a>' . ($message['draft'] === 'no' ? '
            <a class="buttlink"  href="pm_system.php?action=save_or_edit_draft&amp;id=' . $pm_id . '"><input type="submit" class="btn btn-primary" value="' . $lang['pm_viewmsg_sdraft'] . '" </a>' . (($id < 1 || $message['sender'] === $CURUSER['id']) ? '' : '
            <a class="buttlink"  href="pm_system.php?action=send_message&amp;receiver=' . (int)$message['sender'] . '&amp;replyto=' . $pm_id . '"><input type="submit" class="btn btn-primary" value="' . $lang['pm_viewmsg_reply'] . '"></a>
            <a class="buttlink"  href="pm_system.php?action=forward&amp;id=' . $pm_id . '"><input type="submit" class="btn btn-primary" value="' . $lang['pm_viewmsg_fwd'] . '"></a>  ') : '
            <a class="buttlink"  href="pm_system.php?action=save_or_edit_draft&amp;edit=1&amp;id=' . $pm_id . '"><input type="submit" class="btn btn-primary" value="' . $lang['pm_viewmsg_dedit'] . '"></a>
            <a class="buttlink"  href="pm_system.php?action=use_draft&amp;send=1&amp;id=' . $pm_id . '"><input type="submit" class="btn btn-primary" value="' . $lang['pm_viewmsg_duse'] . '"></a>');
//=== get mailbox name
if ($message['location'] > 1) {
    //== get name of PM box if not in or out
    $res_box_name = sql_query('SELECT name FROM pmboxes WHERE userid = ' . sqlesc($CURUSER['id']) . ' AND boxnumber=' . sqlesc($mailbox) . ' LIMIT 1') or sqlerr(__FILE__, __LINE__);
    $arr_box_name = mysqli_fetch_row($res_box_name);
    if (mysqli_num_rows($res) === 0) stderr($lang['pm_error'], $lang['pm_mailbox_invalid']);
    $mailbox_name = htmlsafechars($arr_box_name[0]);
    $other_box_info = '<p class="text-center"><span style="color: red;">' . $lang['pm_mailbox_asterisc'] . '</span><span style="font-weight: bold;">' . $lang['pm_mailbox_note'] . '</span>
                                           ' . $lang['pm_mailbox_max'] . '<span style="font-weight: bold;">' . $maxbox . '</span>' . $lang['pm_mailbox_either'] . '
                                            <span style="font-weight: bold;">' . $lang['pm_mailbox_inbox'] . '</span>' . $lang['pm_mailbox_or'] . '<span style="font-weight: bold;">' . $lang['pm_mailbox_sentbox'] . '</span>.</p>';
}
//=== Display the message already!
$HTMLOUT.= $h1_thingie . ($message['draft'] === 'yes' ? '<h1>' . $lang['pm_viewmsg_tdraft'] . '</h1>' : '<h1>' . $lang['pm_viewmsg_mailbox'] . '' . $mailbox_name . '</h1>') . $top_links . '
    <table class="table table-bordered">
    <tr>
        <td class="text-center" colspan="2" class="colhead"><h1>' . $lang['pm_send_subject'] . '
        <span style="font-weight: bold;">' . ($message['subject'] !== '' ? htmlsafechars($message['subject']) : $lang['pm_search_nosubject'] ) . '</span></h1></td>
        </tr>
    <tr>
        <td colspan="2" class="text-left"><span style="font-weight: bold;">' . ($message['sender'] === $CURUSER['id'] ? $lang['pm_viewmsg_to'] : $lang['pm_viewmsg_from']) . ':</span>
        ' . ($arr_user_stuff['id'] == 0 ? $lang['pm_viewmsg_sys'] : print_user_stuff($arr_user_stuff)) . $spacer . $friends . $spacer . $spacer . '
        <span style="font-weight: bold;">' . $lang['pm_viewmsg_sent'] . '</span> ' . get_date($message['added'], '') . $spacer . (($message['sender'] === $CURUSER['id'] && $message['unread'] == 'yes') ? '' . $lang['pm_mailbox_char1'] . '<span style="font-weight: bold;color:red;">' . $lang['pm_mailbox_unread'] . '</span>' . $lang['pm_mailbox_char2'] . '' : '') . ($message['urgent'] === 'yes' ? '<span style="font-weight: bold;color:red;">' . $lang['pm_mailbox_urgent'] . '</span>' : '') . '</td>
    </tr>
    <tr>
        <td class="text-center" valign="top" width="0px" id="photocol">' . $avatar . '</td>
        <td class="text-left text-resize">' . format_comment($message['msg']) . '</td>
    </tr>
   <tr>
        <td class="textright" colspan="2">     
<form class="form-horizontal" role="form" action="pm_system.php" method="post">        
<input class="form-control" type="hidden" name="id" value="' . $pm_id . '">
<input class="form-control" type="hidden" name="action" value="move">' . get_all_boxes() .'<br>'. $the_buttons . insertJumpTo(0).'</td></tr></table>';
?>
