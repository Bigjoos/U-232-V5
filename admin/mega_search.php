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
/**********************************************************************************
Mega search thingie coded by RedPower! and this is one of the most helpful 
scripts that I have ever seen posted!!! cudos to RedPower for that!!! now? 
more or less fondled, recoded  a bit and spilt beer on for 
TBDev 2010(ish) - snuggs  feb 25 2010 
** changed $_GET to $_POST to be able to test longer strings
** added multiple username search and invite code search... remove if not needed :D
*********************************************************************************/
if (!defined('IN_INSTALLER09_ADMIN')) {
    $HTMLOUT = '';
    $HTMLOUT.= "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\"
		\"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">
		<html xmlns='http://www.w3.org/1999/xhtml'>
		<head>
		<title>Error!</title>
		</head>
		<body>
	<div style='font-size:33px;color:white;background-color:red;text-align:center;'>Incorrect access<br />You cannot access this file directly.</div>
	</body></html>";
    echo $HTMLOUT;
    exit();
}
require_once INCL_DIR . 'user_functions.php';
require_once INCL_DIR . 'html_functions.php';
require_once (CLASS_DIR . 'class_check.php');
$class = get_access(basename($_SERVER['REQUEST_URI']));
class_check($class);
$lang = array_merge($lang, load_language('ad_mega_search'));
$stdhead = array(
    /** include css **/
    'css' => array(
        'forums'
    )
);
//=== bubble tool tip
function bubble($link, $text)
{
    $bubble = '<a href="#" class="tt_f"><span class="tooltip_forum_bubble"><span class="top"></span><span class="middle">' . $text . '</span><span class="bottom"></span></span>' . $link . '</a>';
    return $bubble;
}
//=== tool tip
function tool_tip($link, $text, $title = false)
{
    $bubble = '<a href="#" class="tt_f2"><span class="tooltip_forum_tip"><span class="top">' . $title . '</span><span class="middle">' . $text . '</span></span>' . $link . '</a>';
    return $bubble;
}
//=== make pretty IP
function make_nice_address($ip)
{
    $dom = @gethostbyaddr($ip);
    if ($dom == $ip || @gethostbyname($dom) != $ip) {
        return $ip;
    } else {
        return $ip . '<br />' . $dom;
    }
}
$msg_to_analyze = (isset($_POST['msg_to_analyze']) ? htmlsafechars($_POST['msg_to_analyze']) : '');
$invite_code = (isset($_POST['invite_code']) ? htmlsafechars($_POST['invite_code']) : '');
$user_names = (isset($_POST['user_names']) ? preg_replace('/[^a-zA-Z0-9]/', '', htmlsafechars($_POST['user_names'])) : '');
$HTMLOUT = $found = $not_found = $count = $no_matches_for_this_email = $matches_for_email = $no_matches_for_this_ip = $matches_for_ip = '';
$number = 0;
$HTMLOUT .='<div class="row"><div class="col-md-12">';
$HTMLOUT.= '
    <form method="post" action="staffpanel.php?tool=mega_search&amp;action=mega_search">
    <h1 style="text-align: center;">' . $lang['mega_heading'] . '</h1>
    <h1>' . $lang['mega_analyze'] . '</h1>
    <table class="table table-bordered">
    <tr>
    <td valign="middle" align="left">
    ' . bubble('<b>' . $lang['mega_text'] . '</b>', $lang['mega_text_1']) . '</td>
    </tr>
    <tr>
    <td align="left">
    <textarea name="msg_to_analyze" rows="20" cols="70">' . $msg_to_analyze . '</textarea></td>
    </tr>
    <tr>
    <td align="left"><input type="submit" class="button" value="' . $lang['mega_search_btn'] . '" onmouseover="this.className=\'button_hover\'" onmouseout="this.className=\'button\'" /></td>
    </tr>
    </table>
    </form>
    <form method="post" action="staffpanel.php?tool=mega_search&amp;action=mega_search">
    <table class="table table-bordered">
    <tr>
    <td valign="middle" align="left">
    ' . bubble('<b>' . $lang['mega_invite'] . '</b>', $lang['mega_invite_1']) . '</td>
    </tr>
    <tr>
    <td align="left"><input type="text" name="invite_code" size="70" value="' . $invite_code . '" /></td>
    </tr>
    <tr>
    <td align="left"><input type="submit" class="button" value="' . $lang['mega_search_btn'] . '" onmouseover="this.className=\'button_hover\'" onmouseout="this.className=\'button\'" /></td>
    </tr>
    </table>
    </form>
    <form method="post" action="staffpanel.php?tool=mega_search&amp;action=mega_search">
    <table class="table table-bordered">
    <tr>
    <td valign="middle" align="left">
    ' . bubble('<b>' . $lang['mega_names'] . '</b>', $lang['mega_names_1']) . '</td>
    </tr>
    <tr>
    <td align="left"><textarea name="user_names" rows="4" cols="70">' . $user_names . '</textarea></td>
    </tr>
    <tr>
    <td align="left"><input type="submit" class="button" value="' . $lang['mega_search_btn'] . '" onmouseover="this.className=\'button_hover\'" onmouseout="this.className=\'button\'" /></td>
    </tr>
    </table>
    </form>';
//=== if searching for usernames
if (isset($_POST['user_names'])) {
    //=== make the $_POST into a nice array and remove all non alpha numeric stuff 'cept  _ & -
    $searched_users = array(
        explode(' ', $user_names)
    );
    foreach ($searched_users[0] as $search_users) {
        $search_users = trim($search_users);
        $res_search_usernames = sql_query('SELECT id, username, class, donor, suspended, leechwarn, chatpost, pirate, king, warned, enabled, uploaded, downloaded, invitedby, email, ip, added, last_access FROM users WHERE username LIKE \'%' . $search_users . '%\'');
        if (mysqli_num_rows($res_search_usernames) == 0) {
            $not_found.= '<span style="color: blue;">' . $search_users . '</span><br />';
        } else {
            $arr = mysqli_fetch_array($res_search_usernames);
            $number = 1;
            $random_number = mt_rand(1, 666666666);
            //=== change colors
            $count = (++$count) % 2;
            $class2 = ($count == 0 ? 'one' : 'two');
            $found.= '<tr>
    <td align="left" class="' . $class2 . '">' . $search_users . '</td>
    <td align="left" class="' . $class2 . '">' . print_user_stuff($arr) . '</td>
    <td align="center" class="' . $class2 . '">' . htmlsafechars($arr['email']) . '</td>
    <td align="center" class="' . $class2 . '">
    <span style="color: blue;" title="added">' . get_date($arr['added'], '') . '</span><br />
    <span style="color: green;" title="last access">' . get_date($arr['last_access'], '') . '</span></td>
    <td align="center" class="' . $class2 . '"><img src="pic/up.png" alt="' . $lang['mega_up'] . '" title="' . $lang['mega_uploaded'] . '" /> 
    <span style="color: green;">' . mksize($arr['uploaded']) . '</span>
    ' . ($INSTALLER09['ratio_free'] ? '' : '<br />
    <img src="pic/dl.png" alt="' . $lang['mega_down'] . '" title="' . $lang['mega_downloaded'] . '" />  
    <span style="color: red;">' . mksize($arr['downloaded']) . '</span></td>') . '
    <td align="center" class="' . $class2 . '">' . member_ratio($arr['uploaded'], $INSTALLER09['ratio_free'] ? '0' : $arr['downloaded']) . '</td>
    <td align="center" class="' . $class2 . '">' . make_nice_address($arr['ip']) . '<br /></td>
    </tr>';
        }
    }
    $print_if_any_username_matches = ($number > 0 ? '<table align="center" width="100%" border="1" cellspacing="0" cellpadding="5">
    <tr>
    <td class="colhead" align="center">' . $lang['mega_searched'] . '</td>
    <td class="colhead" align="left">' . $lang['mega_member'] . '</td>
    <td class="colhead" align="center">' . $lang['mega_email'] . '</td>
    <td class="colhead" align="center">' . $lang['mega_registered'] . '<br />' . $lang['mega_last_acc'] . '</td>
    <td class="colhead" align="center">' . $lang['mega_stats'] . '</td>
    <td class="colhead" align="center">' . $lang['mega_ratio'] . '</td>
    <td class="colhead" align="center">' . $lang['mega_ip'] . '</td>
    </tr>' . $found : '') . '</table><br />';
    $HTMLOUT.= '<h1>' . $lang['mega_searched_2'] . '</h1>' . $print_if_any_username_matches . ($not_found !== '' ? '
    <table class="table table-bordered">
    <tr>
    <td class="colhead" align="left"><h1>' . $lang['mega_not_found'] . '</h1></td>
    </tr>
    <tr>
    <td align="left">' . $not_found . '</td>
    </tr></table>' : '');
} //=== end searching usernames
//=== search IP adresses in members ip_history & emails for matches :o)
if (isset($_POST['msg_to_analyze'])) {
    //=== first lets search emails :D
    $email_search = $_POST['msg_to_analyze'];
    $regex = '/[\._a-zA-Z0-9-]+@[\._a-zA-Z0-9-]+/i';
    $email_to_test = array();
    $number_of_matches = preg_match_all($regex, $email_search, $email_to_test);
    $matches_for_email.= '<h1>' . $lang['mega_emails'] . '</h1>';
    foreach ($email_to_test[0] as $tested_email) {
        $res_search_others = sql_query('SELECT id, username, class, donor, suspended, leechwarn, chatpost, pirate, king, warned, enabled, uploaded, downloaded, invitedby, email, ip, added, last_access FROM users WHERE email LIKE \'' . $tested_email . '\'');
        if (mysqli_num_rows($res_search_others) == 0) {
            $no_matches_for_this_email.= '<span style="color: blue;">' . $lang['mega_no_exact'] . '<span style="color: blue;">' . $tested_email . '</span><br />';
        } else {
            $number = 1;
            while ($arr = mysqli_fetch_array($res_search_others)) {
                if ($arr['username'] !== '') {
                    //=== change colors
                    $count = (++$count) % 2;
                    $class2 = ($count == 0 ? 'one' : 'two');
                    //=== get inviter
                    if ($arr['invitedby'] > 0) {
                        $res_inviter = sql_query('SELECT id, username, class, donor, suspended, leechwarn, chatpost, pirate, king, warned, enabled FROM users WHERE id = ' . sqlesc($arr['invitedby']));
                        $arr_inviter = mysqli_fetch_array($res_inviter);
                        $inviter = ($arr_inviter['username'] !== '' ? print_user_stuff($arr_inviter) : 'open signups');
                    } else {
                        $inviter = $lang['mega_open'];
                    }
                    $random_number = mt_rand(1, 666666666);
                    $matches_for_email.= '<tr>
    <td align="left" class="' . $class2 . '">' . print_user_stuff($arr) . '</td>
    <td align="center" class="' . $class2 . '">' . htmlsafechars($arr['email']) . '</td>
    <td align="center" class="' . $class2 . '">
    <span style="color: blue;" title="added">' . get_date($arr['added'], '') . '</span><br />
    <span style="color: green;" title="last access">' . get_date($arr['last_access'], '') . '</span></td>
    <td align="center" class="' . $class2 . '">
    <img src="pic/up.png" alt="' . $lang['mega_up'] . '" title="' . $lang['mega_uploaded'] . '" /> 
    <span style="color: green;">' . mksize($arr['uploaded']) . '</span>
    ' . ($INSTALLER09['ratio_free'] ? '' : '<br />
    <img src="pic/dl.png" alt="' . $lang['mega_down'] . '" title="' . $lang['mega_downloaded'] . '" />  
    <span style="color: red;">' . mksize($arr['downloaded']) . '</span></td>') . '
    <td align="center" class="' . $class2 . '">' . member_ratio($arr['uploaded'], $INSTALLER09['ratio_free'] ? '0' : $arr['downloaded']) . '</td>
    <td align="center" class="' . $class2 . '">' . make_nice_address($arr['ip']) . '<br /></td>
    <td align="left" class="' . $class2 . '">' . $inviter . '</td>
    </tr>';
                }
            }
        }
    } //=== end email search
    $print_if_any_matches = ($number > 0 ? '<table align="center" width="100%" border="1" cellspacing="0" cellpadding="5">
   <tr>
   <td class="colhead" align="left">' . $lang['mega_member'] . '</td>
   <td class="colhead" align="center">' . $lang['mega_matched_email'] . '</td>
   <td class="colhead" align="center">' . $lang['mega_registered'] . '<br />' . $lang['mega_last_acc'] . '</td>
   <td class="colhead" align="center">' . $lang['mega_stats'] . '</td>
   <td class="colhead" align="center">' . $lang['mega_ratio'] . '</td>
   <td class="colhead" align="center">' . $lang['mega_ip'] . '</td>
   <td class="colhead" align="left">' . $lang['mega_invited_by'] . '</td>
   </tr>' . $matches_for_email : '') . '</table><br />';
    $HTMLOUT.= $print_if_any_matches . ($no_matches_for_this_email !== '' ? '<table align="center" width="100%" border="1" cellspacing="0" cellpadding="5">
   <tr><td class="colhead" align="left"><h1>' . $lang['mega_not_found_email'] . '</h1></td></tr>
   <tr><td align="left">' . $no_matches_for_this_email . '</td></tr></table>' : '');
    //=== now let's search for emails that are similar...
    $regex = '/[\._a-zA-Z0-9-]+@/i';
    $email_to_test_like = array();
    $number_of_matches_like = preg_match_all($regex, $email_search, $email_to_test_like);
    $number = 0;
    $similar_emails = 0;
    foreach ($email_to_test_like[0] as $tested_email_like) {
        $res_search_others_like = sql_query('SELECT id, username, class, donor, suspended, leechwarn, chatpost, pirate, king, warned, enabled, email FROM users WHERE email LIKE \'%' . $tested_email_like . '%\'');
        if (mysqli_num_rows($res_search_others_like) > 0) {
            $email = preg_replace('/[^a-zA-Z0-9_-\s]/', '', $tested_email_like);
            $similar_emails.= '<h1>' . $lang['mega_email_using'] . ' "' . $email . '" </h1>';
            $number = 1;
            while ($arr = mysqli_fetch_array($res_search_others_like)) {
                $similar_emails.= str_ireplace($email, '<span style="color: red; font-weight: bold;">' . $email . '</span>', $arr['email']) . $lang['mega_used_by'] . print_user_stuff($arr) . '<br />';
            }
        }
    } //=== end emails like XXX
    $HTMLOUT.= ($number === 1 ? '<br /><table align="center" width="100%" border="1" cellspacing="0" cellpadding="5">
    <tr><td class="colhead" align="left"><h1>' . $lang['mega_search_sim'] . '</h1></td></tr>
    <tr><td align="left">' . $similar_emails . '</td></tr></table><br />' : '');
    //=== now let's do the IP search!
    $ip_history = $_POST['msg_to_analyze'];
    $regex = '/([\d]{1,3}\.){3}[\d]{1,3}/';
    $ip_to_test = array();
    $number_of_matches = preg_match_all($regex, $ip_history, $ip_to_test);
    foreach ($ip_to_test[0] as $tested_ip) {
        $res_search_others = sql_query('SELECT id, username, class, donor, suspended, leechwarn, chatpost, pirate, king, warned, enabled, uploaded, downloaded, invitedby, email, ip, added, last_access FROM users WHERE ip LIKE \'%' . $tested_ip . '%\'');
        if (mysqli_num_rows($res_search_others) == 0) {
            $no_matches_for_this_ip.= '<span style="color: blue;">No matches for IP: ' . $tested_ip . '</span><br />';
        } else {
            $matches_for_ip.= '<h1>' . $lang['mega_used_ip'] . ' ' . $tested_ip . '</h1>
    <table class="table table-bordered">
    <tr>
    <td class="colhead" align="left">' . $lang['mega_member'] . '</td>
    <td class="colhead" align="center">' . $lang['mega_matched_ip'] . '</td>
    <td class="colhead" align="center">' . $lang['mega_email'] . '</td>
    <td class="colhead" align="center">' . $lang['mega_registered'] . '<br />' . $lang['mega_last_acc'] . '</td>
    <td class="colhead" align="center">' . $lang['mega_stats'] . '</td>
    <td class="colhead" align="center">' . $lang['mega_ratio'] . '</td>
    <td class="colhead" align="center">' . $lang['mega_ip'] . '</td>
    <td class="colhead" align="left">' . $lang['mega_invited_by'] . '</td>
    </tr>';
            while ($arr = mysqli_fetch_array($res_search_others)) {
                if ($arr['username'] !== '') {
                    //=== change colors
                    $count = (++$count) % 2;
                    $class2 = ($count == 0 ? 'one' : 'two');
                    //=== get inviter
                    if ($arr['invitedby'] > 0) {
                        $res_inviter = sql_query('SELECT id, username, class, donor, suspended, leechwarn, chatpost, pirate, king, warned, enabled FROM users WHERE id = ' . sqlesc($arr['invitedby']));
                        $arr_inviter = mysqli_fetch_array($res_inviter);
                        $inviter = ($arr_inviter['username'] !== '' ? print_user_stuff($arr_inviter) : $lang['mega_open']);
                    } else {
                        $inviter = $lang['mega_open'];
                    }
                    //=== highlight the matched IP in the ip history \\o\o/o//
                    //$ip_history = nl2br($arr['ip_history']);
                    $random_number = mt_rand(1, 666666666);
                    $matches_for_ip.= '<tr>
                            <td align="left" class="' . $class2 . '">' . print_user_stuff($arr) . '</td>
                            <td align="center" class="' . $class2 . '"><span style="color: red; font-weight: bold;">' . $tested_ip . ' </span></td>
                            <td align="center" class="' . $class2 . '">' . htmlsafechars($arr['email']) . '</td>
                            <td align="center" class="' . $class2 . '">
                            <span style="color: blue;" title="added">' . get_date($arr['added'], '') . '</span><br />
                            <span style="color: green;" title="last access">' . get_date($arr['last_access'], '') . '</span>
                            </td>
                            <td align="center" class="' . $class2 . '">
                            <img src="pic/up.png" alt="' . $lang['mega_up'] . '" title="' . $lang['mega_uploaded'] . '" /> 
                            <span style="color: green;">' . mksize($arr['uploaded']) . '</span>
                            ' . ($INSTALLER09['ratio_free'] ? '' : '<br />
                            <img src="pic/dl.png" alt="' . $lang['mega_down'] . '" title="' . $lang['mega_downloaded'] . '" />  
                            <span style="color: red;">' . mksize($arr['downloaded']) . '</span></td>') . '
                            <td align="center" class="' . $class2 . '">' . member_ratio($arr['uploaded'], $INSTALLER09['ratio_free'] ? '0' : $arr['downloaded']) . '</td>
                            <td align="center" class="' . $class2 . '">' . make_nice_address($arr['ip']) . '<br />
                            </td>
                            <td align="left" class="' . $class2 . '">' . $inviter . '</td>
                              </tr>';
                }
            }
            $matches_for_ip.= '</td></tr></table><br />';
        }
    }
    $HTMLOUT.= (($matches_for_ip != '' || $no_matches_for_this_ip !== '') ? '<h1>' . $lang['mega_searched_ip'] . '</h1>' : '') . $matches_for_ip . ($no_matches_for_this_ip !== '' ? '<table align="center" width="100%" border="1" cellspacing="0" cellpadding="5">
                                                    <tr><td class="colhead" align="left"><h1>' . $lang['mega_no_ips'] . '</h1></td></tr>
                                                    <tr><td align="left">' . $no_matches_for_this_ip . '</td></tr></table>' : '');
} //=== end search IP and email
if (isset($_POST['invite_code'])) {
    if (strlen($invite_code) != 32) {
        stderr($lang['mega_error'], $lang['mega_bad_invite']);
    } else {
        $inviter = sql_query('SELECT u.id, u.username, u.ip, u.last_access, u.email, u.added, u.class, u.leechwarn, u.chatpost, u.pirate, u.king, u.uploaded, u.downloaded, u.donor, u.enabled, u.warned, u.suspended, u.invitedby, i.id AS invite_id, i.added AS invite_added FROM users AS u LEFT JOIN invites AS i ON u.id = i.sender WHERE  i.code = ' . sqlesc($invite_code));
        $user = mysqli_fetch_array($inviter);
        if ($user['username'] == '') {
            $HTMLOUT.= stdmsg($lang['mega_error'], $lang['mega_invite_gone']);
        } else {
            $u1 = sql_query('SELECT id, username, donor, class, enabled, leechwarn, chatpost, pirate, king, warned, suspended FROM users WHERE  id=' . sqlesc($user['invitedby']));
            $user1 = mysqli_fetch_array($u1);
            $HTMLOUT.= '<h1>' . print_user_stuff($user) . $lang['mega_made'] . $invite_code . '  (' . get_date($user['invite_added'], '') . ')</h1>
                <table class="table table-bordered">
                <tr>
                <td class="colhead" align="left">' . $lang['mega_invited'] . '</td>
                <td class="colhead" align="center">' . $lang['mega_email'] . '</td>
                <td class="colhead" align="center">' . $lang['mega_ip'] . '</td>
                <td class="colhead" align="center">' . $lang['mega_last_acc'] . '</td>
                <td class="colhead" align="center">' . $lang['mega_joined'] . '</td>
                <td class="colhead" align="center">' . $lang['mega_ud'] . '</td>
                <td class="colhead" align="center">' . $lang['mega_ratio'] . '</td>
                <td class="colhead" align="center">' . $lang['mega_invited_by'] . '</td>
                </tr>
                <tr>
                <td align="left">' . print_user_stuff($user) . '</td>
                <td align="center">' . htmlsafechars($user['email']) . '</td>
                <td align="center">' . htmlsafechars($user['ip']) . '</td>
                <td align="center">' . get_date($user['last_access'], '') . '</td>
                <td align="center">' . get_date($user['added'], '') . '</td>
                <td align="center"><img src="pic/up.png" alt="' . $lang['mega_up'] . '" title="' . $lang['mega_uploaded'] . '" /> <span style="color: green;">' . mksize($user['uploaded']) . '</span>
                ' . ($INSTALLER09['ratio_free'] ? '' : '<br />
                <img src="pic/dl.png" alt="' . $lang['mega_down'] . '" title="' . $lang['mega_downloaded'] . '" />  
                <span style="color: red;">' . mksize($user['downloaded']) . '</span></td>') . '
                <td align="center" class="' . $class2 . '">' . member_ratio($user['uploaded'], $INSTALLER09['ratio_free'] ? '0' : $user['downloaded']) . '</td>
                <td align="center">' . ($user['invitedby'] == 0 ? $lang['mega_open'] : print_user_stuff($user1)) . '</td>
                </tr>
                </table>';
        }
        $invited = sql_query('SELECT u.id, u.username, u.ip, u.last_access, u.email, u.added, u.leechwarn, u.chatpost, u.pirate, u.king, u.class, u.uploaded, u.downloaded, u.donor, u.enabled, u.warned, u.suspended, u.invitedby, i.id AS invite_id FROM users AS u LEFT JOIN invites AS i ON u.id = i.receiver WHERE  i.code = ' . sqlesc($invite_code));
        $user_invited = mysqli_fetch_array($invited);
        if ($user_invited['username'] == '') {
            $HTMLOUT.= stdmsg($lang['mega_error'],$lang['mega_not_used']);
        } else {
            $u2 = sql_query('SELECT id, username, donor, class, enabled, warned, leechwarn, chatpost, pirate, king, suspended FROM users WHERE id=' . sqlesc($user_invited['invitedby']));
            $user2 = mysqli_fetch_array($u2);
            $HTMLOUT.= '<h1>' . print_user_stuff($user_invited) . $lang['mega_used_from'] . print_user_stuff($user) . '</h1>
                <table class="table table-bordered">
                <tr>
                <td class="colhead" align="left">' . $lang['mega_invited'] . '</td>
                <td class="colhead" align="center">' . $lang['mega_email'] . '</td>
                <td class="colhead" align="center">' . $lang['mega_ip'] . '</td>
                <td class="colhead" align="center">' . $lang['mega_last_acc'] . '</td>
                <td class="colhead" align="center">' . $lang['mega_joined'] . '</td>
                <td class="colhead" align="center">' . $lang['mega_ud'] . '</td>
                <td class="colhead" align="center">' . $lang['mega_ratio'] . '</td>
                <td class="colhead" align="center">' . $lang['mega_invited_by'] . '</td>
                </tr>
                <tr>
                <td align="left">' . print_user_stuff($user_invited) . '</td>
                
                <td align="center">' . htmlsafechars($user_invited['email']) . '</td>
                <td align="center">' . htmlsafechars($user_invited['ip']) . '</td>
                <td align="center">' . get_date($user_invited['last_access'], '') . '</td>
                <td align="center">' . get_date($user_invited['added'], '') . '</td>
                <td align="center"><img src="pic/up.png" alt="' . $lang['mega_up'] . '" title="' . $lang['mega_uploaded'] . '" /> <span style="color: green;">' . mksize($user_invited['uploaded']) . '</span>
                ' . ($INSTALLER09['ratio_free'] ? '' : '<br />
                <img src="pic/dl.png" alt="' . $lang['mega_down'] . '" title="' . $lang['mega_downloaded'] . '" />  
                <span style="color: red;">' . mksize($user_invited['downloaded']) . '</span></td>') . '
                <td align="center" class="' . $class2 . '">' . member_ratio($user_invited['uploaded'], $INSTALLER09['ratio_free'] ? '0' : $user_invited['downloaded']) . '</td>
                <td align="center">' . ($user_invited['invitedby'] == 0 ? $lang['mega_open'] : print_user_stuff($user2)) . '</td>
                </tr>
                </table>';
        }
    }
    $HTMLOUT.= '</td></tr></table>';
}
$HTMLOUT.= '</div></div>';
echo stdhead($lang['mega_stdhead'], true, $stdhead) . $HTMLOUT . stdfoot();
?> 
