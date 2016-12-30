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
//=== get mailbox name
if ($mailbox > 1) {
    //== get name of PM box if not in or out
    $res_box_name = sql_query('SELECT name FROM pmboxes WHERE userid = ' . sqlesc($CURUSER['id']) . ' AND boxnumber=' . sqlesc($mailbox) . ' LIMIT 1') or sqlerr(__FILE__, __LINE__);
    $arr_box_name = mysqli_fetch_row($res_box_name);
    if (mysqli_num_rows($res_box_name) === 0) stderr($lang['pm_error'], $lang['pm_mailbox_invalid']);
    $mailbox_name = htmlsafechars($arr_box_name[0]);
    $other_box_info = '<p align="center"><span style="color: red;">' . $lang['pm_mailbox_asterisc'] . '</span><span style="font-weight: bold;">' . $lang['pm_mailbox_note'] . '</span>
                                            ' . $lang['pm_mailbox_max'] . '<span style="font-weight: bold;">' . $maxbox . '</span>' . $lang['pm_mailbox_either'] . '
                                            <span style="font-weight: bold;">' . $lang['pm_mailbox_inbox'] . '</span>' . $lang['pm_mailbox_or'] . '<span style="font-weight: bold;">' . $lang['pm_mailbox_sentbox'] . '</span>' . $lang['pm_mailbox_dot'] . '</p>';
}
//==== get count from PM boxs & get image & % box full
//=== get stuff for the pager
$res_count = sql_query('SELECT COUNT(id) FROM messages WHERE ' . ($mailbox === PM_INBOX ? 'receiver = ' . sqlesc($CURUSER['id']) . ' AND location = 1' : ($mailbox === PM_SENTBOX ? 'sender = ' . sqlesc($CURUSER['id']) . ' AND (saved = \'yes\' || unread= \'yes\') AND draft = \'no\' ' : 'receiver = ' . sqlesc($CURUSER['id'])) . ' AND location = ' . sqlesc($mailbox))) or sqlerr(__FILE__, __LINE__);
$arr_count = mysqli_fetch_row($res_count);
$messages = $arr_count[0];
//==== get count from PM boxs & get image & % box full
$filled = $messages > 0 ? (($messages / $maxbox) * 100) : 0;
//$filled = (($messages / $maxbox) * 100);
$mailbox_pic = get_percent_completed_image(round($filled) , $maxpic);
$num_messages = number_format($filled, 0);
$link = 'pm_system.php?action=view_mailbox&amp;box=' . $mailbox . ($perpage < $messages ? '&amp;page=' . $page : '') . '&amp;order_by=' . $order_by . $desc_asc;
list($menu, $LIMIT) = pager_new($messages, $perpage, $page, $link);
//=== get message info we need to display then all nice and tidy like \o/
$res = sql_query('SELECT m.id AS message_id, m.sender, m.receiver, m.added, m.subject, m.unread, m.urgent, u.id, u.username, u.uploaded, u.downloaded, u.warned, u.suspended, u.enabled, u.donor, u.class, u.avatar, u.opt1, u.opt2,  u.leechwarn, u.chatpost, u.pirate, u.king, f.id AS friend, b.id AS blocked FROM messages AS m 
                            LEFT JOIN users AS u ON u.id=m.' . ($mailbox === PM_SENTBOX ? 'receiver' : 'sender') . ' 
                            LEFT JOIN friends AS f ON f.userid = ' . $CURUSER['id'] . ' AND f.friendid = m.sender
                            LEFT JOIN blocks AS b ON b.userid = ' . $CURUSER['id'] . ' AND b.blockid = m.sender
                            WHERE ' . ($mailbox === PM_INBOX ? 'receiver = ' . $CURUSER['id'] . ' AND location = 1' : ($mailbox === PM_SENTBOX ? 'sender = ' . $CURUSER['id'] . ' AND (saved = \'yes\' || unread= \'yes\') AND draft = \'no\' ' : 'receiver = ' . $CURUSER['id'] . ' AND location = ' . sqlesc($mailbox))) . ' 
                            ORDER BY ' . $order_by . (isset($_GET['ASC']) ? ' ASC ' : ' DESC ') . $LIMIT) or sqlerr(__FILE__, __LINE__);
//=== Start Page
//echo stdhead(htmlsafechars($mailbox_name));
//=== let's make the table
$HTMLOUT.= $h1_thingie . $top_links . '
    <a name="pm"></a>
    <form action="pm_system.php" method="post" name="checkme" onsubmit="return ValidateForm(this,\'pm\')">
    
    <table class="table table-striped table-bordered">
    <tr>
        <td class="text-center" colspan="5"><span class="font_size_1">' . $messages . ' / ' . $maxbox . '</span>
        ' . $spacer . '<span class="font_size_5">' . $mailbox_name . '</span>' . $spacer . '
        <span class="font_size_1">' . $lang['pm_mailbox_full'] . '' . $num_messages . '' . $lang['pm_mailbox_full1'] . '</span><br />
        ' . $mailbox_pic . '</td>
    </tr>
    <tr>
    <td class="one" align="right" colspan="5">
    ' . insertJumpTo($mailbox) . $other_box_info . ($perpage < $messages ? $menu . '' : '') . '
    </td>
    </tr>
    <tr>
        <td class="colhead" width="1%">&nbsp;&nbsp;
        
        <input type="hidden" name="action" value="move_or_delete_multi" /></td>
        <td class="colhead" align="left"><a class="altlink" href="pm_system.php?action=view_mailbox&amp;box=' . $mailbox . ($perpage == 20 ? '' : '&amp;perpage=' . $perpage) . ($perpage < $messages ? '&amp;page=' . $page : '') . '&amp;order_by=subject' . $desc_asc . '#pm" title="' . $lang['pm_mailbox_sorder'] . '' . $desc_asc_2 . '">' . $lang['pm_mailbox_subject'] . '</a></td>
        <td class="colhead" align="left"><a class="altlink" href="pm_system.php?action=view_mailbox&amp;box=' . $mailbox . ($perpage == 20 ? '' : '&amp;perpage=' . $perpage) . ($perpage < $messages ? '&amp;page=' . $page : '') . '&amp;order_by=username' . $desc_asc . '#pm" title="' . $lang['pm_mailbox_morder'] . '' . $desc_asc_2 . '">' . ($mailbox === PM_SENTBOX ? $lang['pm_search_sent_to'] : $lang['pm_search_sender']) . '</a></td>
        <td class="colhead" align="left"><a class="altlink" href="pm_system.php?action=view_mailbox&amp;box=' . $mailbox . ($perpage == 20 ? '' : '&amp;perpage=' . $perpage) . ($perpage < $messages ? '&amp;page=' . $page : '') . '&amp;order_by=added' . $desc_asc . '#pm" title="' . $lang['pm_mailbox_dorder'] . '' . $desc_asc_2 . '">' . $lang['pm_mailbox_date'] . '</a></td>
        <td class="colhead" width="1%"></td>
    </tr>';
if (mysqli_num_rows($res) === 0) {
    $HTMLOUT.= '
        <tr>
            <td class="text-center" colspan="5"><span style="font-weight: bold;">' . $lang['pm_mailbox_nomsg'] . '' . $mailbox_name . '</span></td>
        </tr>';
} else {
    while ($row = mysqli_fetch_assoc($res)) {
        //=======change colors
        $count2 = (++$count2) % 2;
        $class = ($count2 == 0 ? 'one' : 'two');
        $class2 = ($count2 == 0 ? 'two' : 'one');
        //=== if not system or themselves, see if  they are a friend yet?
        if ($mailbox === PM_DRAFTS || $row['id'] === 0) {
            $friends = '';
        } else {
            if ($row['friend'] > 0) $friends = '' . $lang['pm_mailbox_char1'] . '<span class="font_size_1"><a href="friends.php?action=delete&amp;type=friend&amp;targetid=' . (int)$row['id'] . '">' . $lang['pm_mailbox_removef'] . '</a></span>' . $lang['pm_mailbox_char2'] . '';
            elseif ($row['blocked'] > 0) $friends = '' . $lang['pm_mailbox_char1'] . '<span class="font_size_1"><a href="friends.php?action=delete&amp;type=block&amp;targetid=' . (int)$row['id'] . '">' . $lang['pm_mailbox_removeb'] . '</a></span>' . $lang['pm_mailbox_char2'] . '';
            else $friends = '' . $lang['pm_mailbox_char1'] . '<span class="font_size_1"><a href="friends.php?action=add&amp;type=friend&amp;targetid=' . (int)$row['id'] . '">' . $lang['pm_mailbox_addf'] . '</a></span>' . $lang['pm_mailbox_char2'] . '
                                          ' . $lang['pm_mailbox_char1'] . '<span class="font_size_1"><a href="friends.php?action=add&amp;type=block&amp;targetid=' . (int)$row['id'] . '">' . $lang['pm_mailbox_addb'] . '</a></span>' . $lang['pm_mailbox_char2'] . '';
        }
        /*
                $subject = (!empty($row['subject']) ? htmlsafechars($row['subject']) : 'No Subject');
                $who_sent_it = ($row['id'] == 0 ? '<span style="font-weight: bold;">System</span>' : print_user_stuff($row).$friends);
                $read_unread = ($row['unread'] === 'yes' ? '<img src="pic/pn_inboxnew.gif" title="' . $lang['pm_mailbox_unreadmsg'] . '" alt="' . $lang['pm_mailbox_unread'] . '" />' : '<img src="pic/pn_inbox.gif" title="' . $lang['pm_mailbox_readmsg'] . '" alt="' . $lang['pm_mailbox_read'] . '" />');
                $extra = ($row['unread'] === 'yes' ? $spacer.'' . $lang['pm_mailbox_char1'] . '<span style="color: red;">' . $lang['pm_mailbox_unread'] . '</span>' . $lang['pm_mailbox_char2'] . '' : '').($row['urgent'] === 'yes' ? $spacer.'<span style="color: red;">' . $lang['pm_mailbox_urgent'] . '</span>' : '');
                $avatar = (($CURUSER['avatars'] === 'no' || $CURUSER['show_pm_avatar'] === 'no' || $row['id'] == 0)? '' : (empty($row['avatar']) ? '
                <img width="40" src="pic/default_avatar.gif" alt="no avatar" />' : (($row['offensive_avatar'] === 'yes' && $CURUSER['view_offensive_avatar'] === 'no') ? 
                '<img width="40" src="pic/fuzzybunny.gif" alt="fuzzy!" />' : '<img width="40" src="'.htmlsafechars($row['avatar']).'" alt="avatar" />')));
        
                $HTMLOUT .= '
                <tr>
                    <td class="'.$class.'" align="center">'.$read_unread.'</td>
                    <td class="'.$class.'" align="left"><a class="altlink"  href="pm_system.php?action=view_message&amp;id='.(int)$row['message_id'].'">'.$subject.'</a>'.$extra.'</td>
                    <td class="'.$class.'" align="left">'.$avatar.$who_sent_it.'</td>
                    <td class="'.$class.'" align="left">'.get_date($row['added'], '').'</td>
                    <td class="'.$class.'" align="center"><input type="checkbox" name="pm[]" value="'.(int)$row['message_id'].'" /></td>
                </tr>';
        */
        $subject = (!empty($row['subject']) ? htmlsafechars($row['subject']) : $lang['pm_search_nosubject']);
        $who_sent_it = ($row['id'] == 0 ? '<span style="font-weight: bold;">'. $lang['pm_forward_system'] . '</span>' : print_user_stuff($row) . $friends);
        $read_unread = ($row['unread'] === 'yes' ? '<img src="pic/pn_inboxnew.gif" title="' . $lang['pm_mailbox_unreadmsg'] . '" alt="' . $lang['pm_mailbox_unread'] . '" />' : '<img src="pic/pn_inbox.gif" title="' . $lang['pm_mailbox_readmsg'] . '" alt="' . $lang['pm_mailbox_read'] . '" />');
        $extra = ($row['unread'] === 'yes' ? $spacer . '' . $lang['pm_mailbox_char1'] . '<span style="color: red;">' . $lang['pm_mailbox_unread'] . '</span>' . $lang['pm_mailbox_char2'] . '' : '') . ($row['urgent'] === 'yes' ? $spacer . '<span style="color: red;">' . $lang['pm_mailbox_urgent'] . '</span>' : '');
        $avatar = ((!$CURUSER['opt1'] & user_options::AVATARS || !$CURUSER['opt2'] & user_options_2::SHOW_PM_AVATAR || $row['id'] == 0) ? '' : (empty($row['avatar']) ? '
                <img width="40" src="pic/default_avatar.gif" alt="no avatar" />' : (($row['opt1'] & user_options::OFFENSIVE_AVATAR && !$CURUSER['opt1'] & user_options::VIEW_OFFENSIVE_AVATAR) ? '<img width="40" src="pic/fuzzybunny.gif" alt="fuzzy!" />' : '<img width="40" src="' . htmlsafechars($row['avatar']) . '" alt="avatar" />')));
        $HTMLOUT.= '
                <tr>
                    <td class="text-center">' . $read_unread . '</td>
                    <td class="text-left"><a class="altlink"  href="pm_system.php?action=view_message&amp;id=' . (int)$row['message_id'] . '">' . $subject . '</a>' . $extra . '</td>
                    <td class="text-left">' . $avatar . $who_sent_it . '</td>
                    <td class="text-left">' . get_date($row['added'], '') . '</td>
                    <td class="text-center"><input type="checkbox" name="pm[]" value="' . (int)$row['message_id'] . '" /></td>
                </tr>';
    }
}
//=== per page drop down
$per_page_drop_down = '<form action="pm_system.php" method="post"><select name="amount_per_page" onchange="location = this.options[this.selectedIndex].value;">';
$i = 20;
while ($i <= ($maxbox > 200 ? 200 : $maxbox)) {
    $per_page_drop_down.= '<option class="body" value="' . $link . '&amp;change_pm_number=' . $i . '"  ' . ($CURUSER['pms_per_page'] == $i ? ' selected="selected"' : '') . '>' . $i . '' .$lang['pm_edmail_perpage'] . '</option>';
    $i = ($i < 100 ? $i = $i + 10 : $i = $i + 25);
}
$per_page_drop_down.= '</select><input type="hidden" name="box" value="' . $mailbox . '" /></form>';
//=== avatars on off
$show_pm_avatar_drop_down = '
    <form method="post" action="pm_system.php">
        <select name="show_pm_avatar" onchange="location = this.options[this.selectedIndex].value;">
            <option value="' . $link . '&amp;show_pm_avatar=yes" ' . (($CURUSER['opt2'] & user_options_2::SHOW_PM_AVATAR) ? ' selected="selected"' : '') . '>' .$lang['pm_mailbox_doav'] . '</option>
            <option value="' . $link . '&amp;show_pm_avatar=no" ' . (($CURUSER['opt2'] | user_options_2::SHOW_PM_AVATAR) ? ' selected="selected"' : '') . '>' .$lang['pm_mailbox_dontav'] . '</option>
        </select>
            <input type="hidden" name="box" value="' . $mailbox . '" /></form>';
//=== the bottom
$HTMLOUT.= (mysqli_num_rows($res) > 0 ? '
   <tr>
   <td colspan="5" class="text-right">
 ' . $lang['pm_mailbox_char1'] . '<a class="altlink" href="javascript:SetChecked(1,\'pm[]\')">' .$lang['pm_search_selall'] . '</a>' . $lang['pm_mailbox_char2'] . '' . $lang['pm_mailbox_char1'] . '<a class="altlink" href="javascript:SetChecked(0,\'pm[]\')">' .$lang['pm_search_unsellall'] . '</a>   ' . $lang['pm_mailbox_char2'] . '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . $spacer . '
   <input type="submit" class="button" name="move" value="' .$lang['pm_search_move_to'] . '" onmouseover="this.className=\'button_hover\'" onmouseout="this.className=\'button\'" /> ' . get_all_boxes() . ' or
   <input type="submit" class="button" name="delete" value="' .$lang['pm_search_delete'] . '" onmouseover="this.className=\'button_hover\'" onmouseout="this.className=\'button\'" />' . $lang['pm_search_selected'] . '</td>
   </tr>
    <tr>
        <td colspan="5" align="left">
        <img src="pic/pn_inboxnew.gif" title="' . $lang['pm_mailbox_unreadmsg'] . '" alt="' . $lang['pm_mailbox_unread'] . '" />' . $lang['pm_mailbox_unreadmsgs'] . '<br />
        <img src="pic/pn_inbox.gif" title="' . $lang['pm_mailbox_readmsg'] . '" alt="' . $lang['pm_mailbox_read'] . '" />' . $lang['pm_mailbox_readmsgs'] . '</td>
    </tr>' : '') . '
    </table>
        ' . ($perpage < $messages ? '' . $menu . '<br />' : '') . '
    <div align="center">
    <table class="table table-striped table-bordered">
    <tr>

        <td align="center">' . $per_page_drop_down . '</td>
        <td align="center">' . $show_pm_avatar_drop_down . '</td>
    </tr>
    </table><br /></div></form>';
?>
