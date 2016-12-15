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
require_once (__DIR__ . DIRECTORY_SEPARATOR . 'include' . DIRECTORY_SEPARATOR . 'bittorrent.php');
require_once (INCL_DIR . 'user_functions.php');
require_once (INCL_DIR . 'bbcode_functions.php');
require_once (INCL_DIR . 'html_functions.php');
require_once (INCL_DIR . 'pager_new.php');
require_once (CLASS_DIR . 'class_user_options.php');
require_once (CLASS_DIR . 'class_user_options_2.php');
dbconn(false);
loggedinorreturn();
flood_limit('messages');
define('BUNNY_PM_SYSTEM', TRUE);
/*********************************************************
- Pm system by snuggles
- write up some credits... based on Tux mailbox mod, using code from Retro
*******************************************************/
// Define constants
define("INBOX_SCRIPT", null);
define('PM_DELETED', 0); // Message was deleted
define('PM_INBOX', 1); // Message located in Inbox for reciever
define('PM_SENTBOX', -1); // GET value for sent box
define('PM_DRAFTS', -2); //  new drafts folder
$lang = array_merge(load_language('global') , load_language('takesignup'), load_language('pm'));
$stdhead = array(
    /** include css **/
    'css' => array(
        'forum',
       /* 'style', */
        'style2',
        //'jquery.lightbox-0.5', <-doe not exist in repo
	'bbcode'
    )
);
$stdfoot = array(
    /** include js **/
    'js' => array(
        'browse',
        'shout',
        'jquery.lightbox-0.5.min',
        'lightbox',
        'check_selected'
    )
);
$HTMLOUT = $count2 = $other_box_info = $maxpic = $maxbox = '';
//== validusername
function validusername($username)
{
    global $lang;
    if ($username == "") return false;
    $namelength = strlen($username);
    if (($namelength < 3) OR ($namelength > 32)) {
        stderr($lang['takesignup_user_error'], $lang['takesignup_username_length']);
    }
    // The following characters are allowed in user names
    $allowedchars = $lang['takesignup_allowed_chars'];
    for ($i = 0; $i < $namelength; ++$i) {
        if (strpos($allowedchars, $username[$i]) === false) return false;
    }
    return true;
}

switch ($CURUSER['class']) {
case UC_USER:
    $maxbox = 50;
    $maxboxes = 5;
    break;

case UC_POWER_USER:
    $maxbox = 100;
    $maxboxes = 6;
    break;

case UC_VIP:
    $maxbox = 250;
    $maxboxes = 10;
    break;

case UC_UPLOADER:
    $maxbox = 300;
    $maxboxes = 15;
    break;

case UC_MODERATOR:
    $maxbox = 300;
    $maxboxes = 20;
    break;

case UC_ADMINISTRATOR:
    $maxbox = 400;
    $maxboxes = 30;
    break;

case UC_SYSOP:
    $maxbox = 500;
    $maxboxes = 40;
    break;
case UC_MAX:
    $maxbox = 900;
    $maxboxes = 90;
    break;
default:
    $maxbox = 100;
    $maxboxes = 15;
    break;
}
//=== get action and check to see if it's ok...
$returnto = isset($_GET['returnto']) ? $_GET['returnto'] : '/index.php';
$possible_actions = array(
    'view_mailbox',
    'use_draft',
    'new_draft',
    'save_or_edit_draft',
    'view_message',
    'move',
    'forward',
    'forward_pm',
    'edit_mailboxes',
    'delete',
    'search',
    'move_or_delete_multi',
    'send_message'
);
$action = (isset($_GET['action']) ? htmlsafechars($_GET['action']) : (isset($_POST['action']) ? htmlsafechars($_POST['action']) : 'view_mailbox'));
if (!in_array($action, $possible_actions)) stderr($lang['pm_error'], $lang['pm_error_ruffian']);
//=== possible stuff to be $_GETting lol
$change_pm_number = (isset($_GET['change_pm_number']) ? intval($_GET['change_pm_number']) : (isset($_POST['change_pm_number']) ? intval($_POST['change_pm_number']) : 0));
$page = (isset($_GET['page']) ? intval($_GET['page']) : 0);
$perpage = (isset($_GET['perpage']) ? intval($_GET['perpage']) : ($CURUSER['pms_per_page'] > 0 ? $CURUSER['pms_per_page'] : 20));
$mailbox = (isset($_GET['box']) ? intval($_GET['box']) : (isset($_POST['box']) ? intval($_POST['box']) : 1));
$pm_id = (isset($_GET['id']) ? intval($_GET['id']) : (isset($_POST['id']) ? intval($_POST['id']) : 0));
$save = ((isset($_POST['save']) && $_POST['save'] === 1) ? '1' : '0');
$urgent = ((isset($_POST['urgent']) && $_POST['urgent'] === 'yes') ? 'yes' : 'no');
//=== change ASC to DESC and back for sort by
$desc_asc = (isset($_GET['ASC']) ? '&amp;DESC=1' : (isset($_GET['DESC']) ? '&amp;ASC=1' : ''));
$desc_asc_2 = (isset($_GET['DESC']) ? 'ascending' : 'descending');
$spacer = '&nbsp;&nbsp;&nbsp;&nbsp;';
//=== get orderby and check to see if it's ok...
$good_order_by = array(
    'username',
    'added',
    'subject',
    'id'
);
$order_by = (isset($_GET['order_by']) ? htmlsafechars($_GET['order_by']) : 'added');
if (!in_array($order_by, $good_order_by)) stderr($lang['pm_error'], $lang['pm_error_temp']);
//=== top of page:
$top_links = '<div class="row"><div class="col-sm-12">
        <a class="altlink"  href="pm_system.php?action=search"><button type="button" class="btn btn-primary">' . $lang['pm_search'] . '</button></a>
        <a class="altlink"  href="pm_system.php?action=edit_mailboxes"><button type="button" class="btn btn-primary">' . $lang['pm_manager'] . '</button></a>
        <a class="altlink" href="pm_system.php?action=new_draft"><button type="button" class="btn btn-primary">' . $lang['pm_write_new'] . '</button></a>
        <a class="altlink" href="pm_system.php?action=view_mailbox"><button type="button" class="btn btn-primary">' . $lang['pm_in_box'] . '</button></a></div></div><br>';
//=== change  number of PMs per page on the fly
if (isset($_GET['change_pm_number'])) {
    $change_pm_number = (isset($_GET['change_pm_number']) ? intval($_GET['change_pm_number']) : 20);
    sql_query('UPDATE users SET pms_per_page = ' . sqlesc($change_pm_number) . ' WHERE id = ' . sqlesc($CURUSER['id'])) or sqlerr(__FILE__, __LINE__);
    $mc1->begin_transaction('user' . $CURUSER['id']);
    $mc1->update_row(false, array(
        'pms_per_page' => $change_pm_number
    ));
    $mc1->commit_transaction($INSTALLER09['expires']['user_cache']);
    $mc1->begin_transaction('MyUser_' . $CURUSER['id']);
    $mc1->update_row(false, array(
        'pms_per_page' => $change_pm_number
    ));
    $mc1->commit_transaction($INSTALLER09['expires']['curuser']);
    if (isset($_GET['edit_mail_boxes'])) header('Location: pm_system.php?action=edit_mailboxes&pm=1');
    else header('Location: pm_system.php?action=view_mailbox&pm=1&box=' . $mailbox);
    die();
}
//=== show small avatar drop down thingie / change on the fly
if (isset($_GET['show_pm_avatar'])) {
    $show_pm_avatar = ($_GET['show_pm_avatar'] === 'yes' ? 'yes' : 'no');
    sql_query('UPDATE users SET show_pm_avatar = ' . sqlesc($show_pm_avatar) . ' WHERE id = ' . sqlesc($CURUSER['id'])) or sqlerr(__FILE__, __LINE__);
    $mc1->begin_transaction('user' . $CURUSER['id']);
    $mc1->update_row(false, array(
        'show_pm_avatar' => $show_pm_avatar
    ));
    $mc1->commit_transaction($INSTALLER09['expires']['user_cache']);
    $mc1->begin_transaction('MyUser_' . $CURUSER['id']);
    $mc1->update_row(false, array(
        'show_pm_avatar' => $show_pm_avatar
    ));
    $mc1->commit_transaction($INSTALLER09['expires']['curuser']);
    if (isset($_GET['edit_mail_boxes'])) header('Location: pm_system.php?action=edit_mailboxes&avatar=1');
    else header('Location: pm_system.php?action=view_mailbox&avatar=1&box=' . $mailbox);
    die();
}
//=== some get stuff to display messages
$HTMLOUT = $h1_thingie = '';
$HTMLOUT.= "<style type='css'>body{padding-top: 45px;}</style>";
$h1_thingie.= (isset($_GET['deleted']) ? '<div class="alert alert-success">' . $lang['pm_deleted'] . '</div>' : '');
$h1_thingie.= (isset($_GET['avatar']) ? '<div class="alert alert-success">' . $lang['pm_avatar'] . '</div>' : '');
$h1_thingie.= (isset($_GET['pm']) ? '<div class="alert alert-success">' . $lang['pm_changed'] . '</div>' : '');
$h1_thingie.= (isset($_GET['singlemove']) ? '<div class="alert alert-success">' . $lang['pm_moved'] . '</div>' : '');
$h1_thingie.= (isset($_GET['multi_move']) ? '<div class="alert alert-success">' . $lang['pm_moved_s'] . '</div>' : '');
$h1_thingie.= (isset($_GET['multi_delete']) ? '<div class="alert alert-success">' . $lang['pm_deleted_s'] . '</div>' : '');
$h1_thingie.= (isset($_GET['forwarded']) ? '<div class="alert alert-success">' . $lang['pm_forwarded'] . '</div>' : '');
$h1_thingie.= (isset($_GET['boxes']) ? '<div class="alert alert-success">' . $lang['pm_box_added'] . '</div>' : '');
$h1_thingie.= (isset($_GET['name']) ? '<div class="alert alert-success">' . $lang['pm_box_updated'] . '</div>' : '');
$h1_thingie.= (isset($_GET['new_draft']) ? '<div class="alert alert-success">' . $lang['pm_draft_saved'] . '</div>' : '');
$h1_thingie.= (isset($_GET['sent']) ? '<div class="alert alert-success">' . $lang['pm_msg_sent'] . '</div>' : '');
$h1_thingie.= (isset($_GET['pms']) ? '<div class="alert alert-success">' . $lang['pm_msg_sett'] . '</div>' : '');
//=== mailbox name default:
$mailbox_name = ($mailbox === PM_INBOX ? $lang['pm_inbox'] : ($mailbox === PM_SENTBOX ? $lang['pm_sentbox'] : $lang['pm_drafts']));
switch ($action) {
case 'view_mailbox':
    require_once (PM_DIR . 'view_mailbox.php');
    break;

case 'view_message':
    require_once (PM_DIR . 'view_message.php');
    break;

case 'send_message':
    require_once (PM_DIR . 'send_message.php');
    break;

case 'move':
    require_once (PM_DIR . 'move.php');
    break;

case 'delete':
    require_once (PM_DIR . 'delete.php');
    break;

case 'move_or_delete_multi':
    require_once (PM_DIR . 'move_or_delete_multi.php');
    break;

case 'forward':
    require_once (PM_DIR . 'forward.php');
    break;

case 'forward_pm':
    require_once (PM_DIR . 'forward_pm.php');
    break;

case 'new_draft':
    require_once (PM_DIR . 'new_draft.php');
    break;

case 'save_or_edit_draft':
    require_once (PM_DIR . 'save_or_edit_draft.php');
    break;

case 'use_draft':
    require_once (PM_DIR . 'use_draft.php');
    break;

case 'search':
    require_once (PM_DIR . 'search.php');
    break;

case 'edit_mailboxes':
    require_once (PM_DIR . 'edit_mailboxes.php');
    break;
}
//=== get all PM boxes
function get_all_boxes()
{
    global $CURUSER, $mc1, $INSTALLER09, $lang;
    //if (($get_all_boxes = $mc1->get_value('get_all_boxes' . $CURUSER['id'])) === false) {
        $res = sql_query('SELECT boxnumber, name FROM pmboxes WHERE userid=' . sqlesc($CURUSER['id']) . ' ORDER BY boxnumber') or sqlerr(__FILE__, __LINE__);
        $get_all_boxes = '<div class="col-sm-2"><select class="form-control" name="box">
					<!--<option class="head" value="">' . $lang['pm_search_move_to'] . '</option>-->

                                            <option class="body" value="1">' . $lang['pm_inbox'] . '</option>
                                            <option class="body" value="-1">' . $lang['pm_sentbox'] . '</option>
                                            <option class="body" value="-2">' . $lang['pm_drafts'] . '</option>';
        while ($row = mysqli_fetch_assoc($res)) {
            $get_all_boxes.= '<option class="body" value="' . (int)$row['boxnumber'] . '">' . htmlsafechars($row['name']) . '</option>';
        }
        $get_all_boxes.= '</select></div>';
        //$mc1->cache_value('get_all_boxes' . $CURUSER['id'], $get_all_boxes, $INSTALLER09['expires']['get_all_boxes']);
    //}
    return $get_all_boxes;
}
//=== insert jump to box
function insertJumpTo($mailbox)
{
    global $CURUSER, $mc1, $INSTALLER09, $lang;
    //if (($insertJumpTo = $mc1->get_value('insertJumpTo' . $CURUSER['id'])) === false) {
        $res = sql_query('SELECT boxnumber,name FROM pmboxes WHERE userid=' . sqlesc($CURUSER['id']) . ' ORDER BY boxnumber') or sqlerr(__FILE__, __LINE__);
        $insertJumpTo = '<div class="col-sm-2 col-sm-offset-10" style="margin-top:-4.95%;">
				    <form class="form-horizontal" role="form" action="pm_system.php" method="get">
                                    <input class="form-control" type="hidden" name="action" value="view_mailbox">
                                    <select  class="form-control" name="box" onchange="location = this.options[this.selectedIndex].value;">
                                    <option class="head" value="">' . $lang['pm_jump_to'] . '</option>
                                    <option class="body" value="pm_system.php?action=view_mailbox&amp;box=1" ' . ($mailbox == '1' ? 'selected="selected"' : '') . '>' . $lang['pm_inbox'] . '</option>
                                    <option class="body" value="pm_system.php?action=view_mailbox&amp;box=-1" ' . ($mailbox == '-1' ? 'selected="selected"' : '') . '>' . $lang['pm_sentbox'] . '</option>
                                    <option class="body" value="pm_system.php?action=view_mailbox&amp;box=-2" ' . ($mailbox == '-2' ? 'selected="selected"' : '') . '>' . $lang['pm_drafts'] . '</option>';
        while ($row = mysqli_fetch_assoc($res)) {
            $insertJumpTo.= '<option class="body" value="pm_system.php?action=view_mailbox&amp;box=' . (int)$row['boxnumber'] . '" ' . ((int)$row['boxnumber'] == $mailbox ? 'selected="selected"' : '') . '>' . htmlsafechars($row['name']) . '</option>';
        }
        $insertJumpTo.= '</select></form></div>';
        //$mc1->cache_value('insertJumpTo' . $CURUSER['id'], $insertJumpTo, $INSTALLER09['expires']['insertJumpTo']);
    //}
    return $insertJumpTo;
}
echo stdhead($lang['pm_stdhead'], true, $stdhead) . $HTMLOUT . stdfoot($stdfoot);
?>
