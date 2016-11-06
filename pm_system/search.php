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
$num_result = $and_member = '';
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
//=== get post / get stuff
$keywords = (isset($_POST['keywords']) ? htmlsafechars($_POST['keywords']) : '');
$member = (isset($_POST['member']) ? htmlsafechars($_POST['member']) : '');
$all_boxes = (isset($_POST['all_boxes']) ? intval($_POST['all_boxes']) : '');
$sender_reciever = ($mailbox >= 1 ? 'sender' : 'receiver');
//== query stuff
$what_in_out = ($mailbox >= 1 ? 'AND receiver = ' . sqlesc($CURUSER['id']) . ' AND saved = \'yes\'' : 'AND sender = ' . sqlesc($CURUSER['id']) . ' AND saved = \'yes\'');
$location = (isset($_POST['all_boxes']) ? 'AND location != 0' : 'AND location = ' . $mailbox);
$limit = (isset($_POST['limit']) ? intval($_POST['limit']) : 25);
$as_list_post = (isset($_POST['as_list_post']) ? intval($_POST['as_list_post']) : 2);
$desc_asc = (isset($_POST['ASC']) == 1 ? 'ASC' : 'DESC');
//=== search in
$subject = (isset($_POST['subject']) ? htmlsafechars($_POST['subject']) : '');
$text = (isset($_POST['text']) ? htmlsafechars($_POST['text']) : '');
$member_sys = (isset($_POST['system']) ? 'system' : '');
//=== get sort and check to see if it's ok...
$possible_sort = array(
    'added',
    'subject',
    'sender',
    'receiver',
    'relevance'
);
$sort = (isset($_GET['sort']) ? htmlsafechars($_GET['sort']) : (isset($_POST['sort']) ? htmlsafechars($_POST['sort']) : 'relevance'));
if (!in_array($sort, $possible_sort)) {
    stderr($lang['pm_error'], $lang['pm_error_ruffian']);
} else {
    $sort = htmlsafechars(isset($_POST['sort']));
}
//=== Try finding a user with specified name
if ($member) {
    $res_username = sql_query('SELECT id, username, class, warned, suspended, leechwarn, chatpost, pirate, king, enabled, donor FROM users WHERE LOWER(username)=LOWER(' . sqlesc($member) . ') LIMIT 1') or sqlerr(__FILE__, __LINE__);
    $arr_username = mysqli_fetch_assoc($res_username);
    if (mysqli_num_rows($res_username) === 0) stderr($lang['pm_error'], $lang['pm_forwardpm_nomember']);
    //=== if searching by member...
    $and_member = ($mailbox >= 1 ? ' AND sender = ' . sqlesc($arr_username['id']) . ' AND saved = \'yes\' ' : ' AND receiver = ' . sqlesc($arr_username['id']) . ' AND saved = \'yes\' ');
    $the_username = print_user_stuff($arr_username);
}
if ($member_sys) {
    $and_member = ' AND sender = 0 ';
    $the_username = '<span style="font-weight: bold;">' . $lang['pm_search_sysbot'] . '</span>';
}
//=== get all boxes
$res = sql_query('SELECT boxnumber, name FROM pmboxes WHERE userid = ' . sqlesc($CURUSER['id']) . ' ORDER BY boxnumber') or sqlerr(__FILE__, __LINE__);
$get_all_boxes = '<select name="box">
                                            <option class="body" value="1" ' . ($mailbox == PM_INBOX ? 'selected="selected"' : '') . '>' . $lang['pm_inbox'] . '</option>
                                            <option class="body" value="-1" ' . ($mailbox == PM_SENTBOX ? 'selected="selected"' : '') . '>' . $lang['pm_sentbox'] . '</option>
                                            <option class="body" value="-2" ' . ($mailbox == PM_DRAFTS ? 'selected="selected"' : '') . '>' . $lang['pm_drafts'] . '</option>';
while ($row = mysqli_fetch_assoc($res)) {
    $get_all_boxes.= '<option class="body" value="' . (int)$row['boxnumber'] . '" ' . ($row['boxnumber'] == $mailbox ? 'selected="selected"' : '') . '>' . htmlsafechars($row['name']) . '</option>';
}
$get_all_boxes.= '</select>';
//=== make up page
//echo stdhead('Search Messages');
$HTMLOUT.= '<h1>' . $lang['pm_search_title'] . '</h1>' . $top_links . '
        <form action="pm_system.php" method="post">
        <input type="hidden" name="action"  value="' . $lang['pm_search_btn'] . '" />
    <table class="table table-striped">
    <tr>
        <td class="text-left" colspan="2">' . $lang['pm_search_s'] . '</td>
    </tr>
    <tr>
        <td class="text-right" valign="middle"><span style="font-weight: bold;">' . $lang['pm_search_terms'] . '</span></td>
        <td class="text-left"><input type="text" class="search" name="keywords" value="' . $keywords . '" />' . $lang['pm_search_common'] . '</td>
    </tr>
    <tr>
        <td class="text-right" valign="middle"><span style="font-weight: bold;">' . $lang['pm_search_box'] . '</span></td>
        <td class="text-left">' . $get_all_boxes . '</td>
    </tr>
    <tr>
        <td class="text-right" valign="middle"><span style="font-weight: bold;">' . $lang['pm_search_allbox'] . '</span></td>
        <td class="text-left"><input name="all_boxes" type="checkbox" value="1" ' . ($all_boxes == 1 ? ' checked="checked"' : '') . ' />' . $lang['pm_search_ignored'] . '</td>
    </tr>
    <tr>
        <td class="text-right" valign="middle"><span style="font-weight: bold;">' . $lang['pm_search_member_by'] . '</span></td>
        <td class="text-left"><input type="text" class="member" name="member" value="' . $member . '" />' . $lang['pm_search_member_only'] . '</td>
    </tr>
    <tr>
        <td class="text-right" valign="middle"><span style="font-weight: bold;">' . $lang['pm_search_system'] . '</span></td>
        <td class="text-left"><input name="system" type="checkbox" value="system" ' . ($member_sys == 'system' ? ' checked="checked"' : '') . ' />' . $lang['pm_search_system_only'] . '</td>
    </tr>
    <tr>
        <td class="text-right" valign="middle"><span style="font-weight: bold;">' . $lang['pm_search_in'] . '</span></td>
        <td class="text-left"><input name="subject" type="checkbox" value="1" ' . ($subject == 1 ? ' checked="checked"' : '') . ' />' . $lang['pm_search_subject'] . '
        <input name="text" type="checkbox" value="1" ' . ($text === 1 ? ' checked="checked"' : '') . ' />' . $lang['pm_search_msgtext'] . '</td>
    </tr>
    <tr>
        <td class="text-right" valign="middle"><span style="font-weight: bold;">' . $lang['pm_search_sortby'] . '</span></td>
        <td class="text-left">
        <select name="sort">
            <option value="relevance" ' . ($sort === 'relevance' ? ' selected="selected"' : '') . '>' . $lang['pm_search_relevance'] . '</option>
            <option value="subject" ' . ($sort === 'subject' ? ' selected="selected"' : '') . '>' . $lang['pm_search_subject'] . '</option>
            <option value="added" ' . ($sort === 'added' ? ' selected="selected"' : '') . '>' . $lang['pm_search_added'] . '</option>
            <option value="' . $sender_reciever . '" ' . ($sort === $sender_reciever ? ' selected="selected' : '') . '>' . $lang['pm_search_member'] . '</option>
        </select>
            <input name="ASC" type="radio" value="1" ' . ((isset($_POST['ASC']) && $_POST['ASC'] == 1) ? ' checked="checked"' : '') . ' />' . $lang['pm_search_asc'] . '
            <input name="ASC" type="radio" value="2" ' . ((isset($_POST['ASC']) && $_POST['ASC'] == 2 || !isset($_POST['ASC'])) ? ' checked="checked"' : '') . ' />' . $lang['pm_search_desc'] . '</td>
    </tr>
    <tr>
        <td class="text-right" valign="middle"><span style="font-weight: bold;">' . $lang['pm_search_show'] . '</span></td>
        <td class="text-left">
        <select name="limit">
            <option value="25"' . (($limit == 25 || !$limit) ? ' selected="selected"' : '') . '>' . $lang['pm_search_25'] . '</option>
            <option value="50"' . ($limit == 50 ? ' selected="selected"' : '') . '>' . $lang['pm_search_50'] . '</option>
            <option value="75"' . ($limit == 75 ? ' selected="selected"' : '') . '>' . $lang['pm_search_75'] . '</option>
            <option value="100"' . ($limit == 100 ? ' selected="selected"' : '') . '>' . $lang['pm_search_100'] . '</option>
            <option value="150"' . ($limit == 150 ? ' selected="selected"' : '') . '>' . $lang['pm_search_150'] . '</option>
            <option value="200"' . ($limit == 200 ? ' selected="selected"' : '') . '>' . $lang['pm_search_200'] . '</option>
            <option value="1000"' . ($limit == 1000 ? ' selected="selected"' : '') . '>' . $lang['pm_search_allres'] . '</option>
        </select></td>
    </tr>' . ($limit < 100 ? '
    <tr>
        <td class="text-right" valign="middle"><span style="font-weight: bold;">' . $lang['pm_search_display'] . '</span></td>
        <td class="text-left"><input name="as_list_post" type="radio" value="1" ' . ($as_list_post == 1 ? ' checked="checked"' : '') . ' /> <span style="font-weight: bold;">' . $lang['pm_search_list'] . '</span>
        <input name="as_list_post" type="radio" value="2" ' . ($as_list_post == 2 ? ' checked="checked"' : '') . ' /> <span style="font-weight: bold;"> ' . $lang['pm_search_message'] . '</span></td>
    </tr>' : '') . '
    <tr>
        <td colspan="2" class="text-center">
        <input type="submit" class="button" name="change" value="' . $lang['pm_search_btn'] . '" onmouseover="this.className=\'button_hover\'" onmouseout="this.className=\'button\'" /></td>
    </tr>
    </table></form>';
//=== do the search and print page :)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //=== remove common words first. add more if you like...
    $remove_me = array(
        'a',
        'the',
        'and',
        'to',
        'for',
        'by'
    );
    $search = preg_replace('/\b(' . implode('|', $remove_me) . ')\b/', '', $keywords);
    //=== do the search!
    switch (true) {
        //=== if only member name is entered and no search string... get all messages by that member
        
    case (!$keywords && $member):
        $res_search = sql_query("SELECT * FROM messages WHERE sender = " . sqlesc($arr_username['id']) . " AND saved = 'yes' $location AND receiver = " . sqlesc($CURUSER['id']) . " ORDER BY " . sqlesc($sort) . " $desc_asc LIMIT " . $limit) or sqlerr(__FILE__, __LINE__);
        break;
        //=== if system entered default both ...
        
    case (!$keywords && $member_sys):
        $res_search = sql_query("SELECT * FROM messages WHERE sender = 0 $location AND receiver = " . sqlesc($CURUSER['id']) . " ORDER BY " . sqlesc($sort) . " $desc_asc LIMIT " . $limit) or sqlerr(__FILE__, __LINE__);
        break;
        //=== if just subject
        
    case ($subject && !$text):
        $res_search = sql_query("SELECT *, MATCH(subject) AGAINST(" . sqlesc($search) . " IN BOOLEAN MODE) AS relevance FROM messages WHERE ( MATCH(subject) AGAINST (" . sqlesc($search) . " IN BOOLEAN MODE) ) $and_member $location $what_in_out ORDER BY " . sqlesc($sort) . " $desc_asc LIMIT " . $limit) or sqlerr(__FILE__, __LINE__);
        break;
        //=== if just message
        
    case (!$subject && $text):
        $res_search = sql_query("SELECT *, MATCH(msg) AGAINST(" . sqlesc($search) . " IN BOOLEAN MODE) AS relevance FROM messages WHERE ( MATCH(msg) AGAINST (" . sqlesc($search) . " IN BOOLEAN MODE) ) $and_member $location $what_in_out ORDER BY " . sqlesc($sort) . " $desc_asc LIMIT " . $limit) or sqlerr(__FILE__, __LINE__);;
        break;
        //=== if subject and message
        
    case ($subject && $text || !$subject && !$text):
        $res_search = sql_query("SELECT *, ( (1.3 * (MATCH(subject) AGAINST (" . sqlesc($search) . " IN BOOLEAN MODE))) + (0.6 * (MATCH(msg) AGAINST (" . sqlesc($search) . " IN BOOLEAN MODE)))) AS relevance FROM messages WHERE ( MATCH(subject,msg) AGAINST (" . sqlesc($search) . " IN BOOLEAN MODE) ) $and_member $location $what_in_out ORDER BY " . sqlesc($sort) . " $desc_asc LIMIT " . $limit) or sqlerr(__FILE__, __LINE__);
        break;
    }
    $num_result = mysqli_num_rows($res_search);
    //=== show the search resaults \o/o\o/o\o/
    $HTMLOUT.= '<h1>' . $lang['pm_search_your_for'] . '' . ($keywords ? '"' . $keywords . '"' : ($member ? $lang['pm_search_member'] . htmlsafechars($arr_username['username']) . $lang['pm_search_pms'] : ($member_sys ? $lang['pm_search_sysmsg'] : ''))) . '</h1>
        <div style="text-align: center;">' . ($num_result < $limit ? $lang['pm_search_returned'] : $lang['pm_search_show_first']) . ' <span style="font-weight: bold;">' . $num_result . '</span> 
        ' . $lang['pm_search_match'] . '' . ($num_result === 1 ? '' : $lang['pm_search_matches']) . $lang['pm_search_excl'] . ($num_result === 0 ? $lang['pm_search_better'] : '') . '</div>';
    //=== let's make the table
    $HTMLOUT.= ($num_result > 0 ? '
        <form action="pm_system.php" method="post"  name="messages" onsubmit="return ValidateForm(this,\'pm\')">
        <input type="hidden" name="action" value="move_or_delete_multi" />
    <table border="0" cellspacing="0" cellpadding="5" class="text-center" style="max-width:800px">
        ' . ($as_list_post == 2 ? '' : '
    <tr>
        <td colspan="5" class="text-center"><h1>' . $mailbox_name . '</h1></td>
    </tr>
    <tr>
        <td width= "1%" class="colhead">&nbsp;</td>
        <td class="colhead">' . $lang['pm_search_subject'] . '</td>
        <td width="35%" class="colhead">' . ($mailbox === PM_SENTBOX ? $lang['pm_search_send_to'] : $lang['pm_search_sender']) . '</td>
        <td width="1%" class="colhead">' . $lang['pm_search_date'] . '</td>
        <td width="1%" class="colhead"></td>
    </tr>') : '');
    while ($row = mysqli_fetch_assoc($res_search)) {
        //=======change colors
        $count2 = (++$count2) % 2;
        $class = ($count2 == 0 ? 'one' : 'two');
        $class2 = ($count2 == 0 ? 'two' : 'one');
        //=== if not searching one member...
        if (!$member) {
            $res_username = sql_query('SELECT id, username, warned, suspended, enabled, donor, leechwarn, chatpost, pirate, king, class FROM users WHERE id = ' . sqlesc($row[$sender_reciever]) . ' LIMIT 1') or sqlerr(__FILE__, __LINE__);
            $arr_username = mysqli_fetch_assoc($res_username);
            $the_username = print_user_stuff($arr_username);
        }
        //=== if searching all boxes...
        $arr_box = ($row['location'] == 1 ? $lang['pm_inbox'] : ($row['location'] == - 1 ? $lang['pm_sentbox'] : ($row['location'] == - 2 ? $lang['pm_drafts'] : '')));
        if ($all_boxes && $arr_box === '') {
            $res_box_name = sql_query('SELECT name FROM pmboxes WHERE userid = ' . sqlesc($CURUSER['id']) . ' AND boxnumber = ' . sqlesc($row['location'])) or sqlerr(__FILE__, __LINE__);
            $arr_box_name = mysqli_fetch_assoc($res_box_name);
            $arr_box = htmlsafechars($arr_box_name['name']);
        }
        //==== highlight search terms... from Jaits search forums mod
        $body = str_ireplace($keywords, '<span style="font-weight:bold;">' . $keywords . '</span>', format_comment($row['msg']));
        $subject = str_ireplace($keywords, '<span style="font-weight:bold;">' . $keywords . '</span>', htmlsafechars($row['subject']));
        //=== print the damn thing ... if it's as a list or as posts...
        $HTMLOUT.= ($as_list_post == 2 ? '
    <tr>
        <td class="colhead" colspan="4">' . $lang['pm_search_msgfrom'] . '' . ($row[$sender_reciever] == 0 ? $lang['pm_search_sysbot'] : $the_username) . '</td>
    </tr>
    <tr>
        <td colspan="4"><span style="font-weight: bold;">' . $lang['pm_search_subject'] . '</span>
        <a class="altlink"  href="pm_system.php?action=view_message&amp;id=' . $row['id'] . '">' . ($row['subject'] !== '' ? $subject : $lang['pm_search_nosubject']) . '</a> 
        ' . ($all_boxes ? $lang['pm_search_foundin'] . $arr_box . $lang['pm_search_sign'] : '') . $lang['pm_search_at'] . get_date($row['added'], '') . $lang['pm_search_gmt'] . get_date($row['added'], '', 0, 1) . '' . $lang['pm_search_sign'] . '</td>
    </tr>
    <tr>
        <td colspan="4">' . $body . '</td>
    </tr>' : '
    <tr>
        <td><img src="pic/readpm.gif" title="' . $lang['pm_search_messg'] . '" alt="' . $lang['pm_search_read'] . '" /></td>
        <td><a class="altlink" href="pm_system.php?action=view_message&amp;id=' . $row['id'] . '">' . ($row['subject'] !== '' ? $subject : $lang['pm_search_nosubject']) . '</a> ' . ($all_boxes ? $lang['pm_search_foundin'] . $arr_box . $lang['pm_search_sign'] : '') . '</td>
        <td>' . ($row[$sender_reciever] == 0 ? $lang['pm_search_sysbot'] : $the_username) . '</td>
        <td>' . get_date($row['added'], '') . $lang['pm_search_gmt'] . get_date($row['added'], '', 0, 1) . '] </td>
        <td><input type="checkbox" name="pm[]" value="' . (int)$row['id'] . '" /></td>
    </tr>');
    }
}
//=== the bottom
$HTMLOUT.= ($num_result > 0 ? '
    <tr>
        <td colspan="4" class="text-right">
        <a class="altlink" href="javascript:SetChecked(1,\'pm[]\')">' . $lang['pm_search_selall'] . '</a> - 
        <a class="altlink" href="javascript:SetChecked(0,\'pm[]\')">' . $lang['pm_search_unselall'] . '</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <input type="submit" class="button" name="move" value="' . $lang['pm_search_move_to'] . '" onmouseover="this.className=\'button_hover\'" onmouseout="this.className=\'button\'" /> ' . get_all_boxes() . ' or  
        <input type="submit" class="button" name="delete" value="' . $lang['pm_search_delete'] . '" onmouseover="this.className=\'button_hover\'" onmouseout="this.className=\'button\'" />' . $lang['pm_search_selected'] . '</td>
    </tr>
    </table></form>' : '') . '<br />';
?>
