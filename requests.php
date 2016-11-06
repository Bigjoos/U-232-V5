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
/*****************************************************
a nice shiney new request system for TB based sited
based on a date I had back in highschool... don't ask!
this file is copyright my 1864 by the incredible hulk!
xox,
snuggs
PS. this file will self destruct in 
10, 9, 8, 7, 6, 5, 4, 3, 2, BOUM!!!
****************************************************/
require_once (__DIR__ . DIRECTORY_SEPARATOR . 'include' . DIRECTORY_SEPARATOR . 'bittorrent.php');
require_once INCL_DIR . 'user_functions.php';
dbconn(false);
loggedinorreturn();
$lang = array_merge(load_language('global'), load_language('requests'));
$stdhead = array(
    /** include css **/
    'css' => array(
        'style2'
    )
);
$stdfoot = array(
    /** include js **/
    'js' => array(
        'jquery.validate.min',
        'check_selected',
        'shout'
    )
);
$HTMLOUT = $count2 = '';
if ($CURUSER['class'] < UC_POWER_USER) stderr($lang['error_error'], $lang['req_add_err2']);
//=== possible stuff to be $_GETting lol
$id = (isset($_GET['id']) ? intval($_GET['id']) : (isset($_POST['id']) ? intval($_POST['id']) : 0));
$comment_id = (isset($_GET['comment_id']) ? intval($_GET['comment_id']) : (isset($_POST['comment_id']) ? intval($_POST['comment_id']) : 0));
$category = (isset($_GET['category']) ? intval($_GET['category']) : (isset($_POST['category']) ? intval($_POST['category']) : 0));
$requested_by_id = isset($_GET['requested_by_id']) ? intval($_GET['requested_by_id']) : 0;
$vote = isset($_POST['vote']) ? intval($_POST['vote']) : 0;
$posted_action = strip_tags((isset($_GET['action']) ? htmlsafechars($_GET['action']) : (isset($_POST['action']) ? htmlsafechars($_POST['action']) : '')));
//===========================================================================================//
//==================================    let them vote on it!    ==========================================//
//===========================================================================================//
//=== add all possible actions here and check them to be sure they are ok
$valid_actions = array(
    'add_new_request',
    'delete_request',
    'edit_request',
    'request_details',
    'vote',
    'add_comment',
    'edit_comment',
    'delete_comment'
);
//=== check posted action, and if no action was posted, show the default page
$action = (in_array($posted_action, $valid_actions) ? $posted_action : 'default');
//=== top menu :D
$top_menu = '<p style="text-align: center;"><a class="altlink" href="requests.php">'.$lang['req_view_all'].'</a> || <a class="altlink" href="requests.php?action=add_new_request">'.$lang['req_add_new'].'</a></p>';
switch ($action) {
case 'vote':
    //=== kill if nasty
    if (!isset($id) || !is_valid_id($id) || !isset($vote) || !is_valid_id($vote)) stderr($lang['req_add_err3'], $lang['req_add_err4']);
    //=== see if they voted yet
    $res_did_they_vote = sql_query('SELECT vote FROM request_votes WHERE user_id = ' . sqlesc($CURUSER['id']) . ' AND request_id = ' . sqlesc($id));
    $row_did_they_vote = mysqli_fetch_row($res_did_they_vote);
    if ($row_did_they_vote[0] == '') {
        $yes_or_no = ($vote == 1 ? 'Yes' : 'No');
        sql_query('INSERT INTO request_votes (request_id, user_id, vote) VALUES (' . sqlesc($id) . ', ' . sqlesc($CURUSER['id']) . ', ' . sqlesc($yes_or_no) . ')');
        sql_query('UPDATE requests SET ' . ($yes_or_no == 'Yes' ? 'vote_yes_count = vote_yes_count + 1' : 'vote_no_count = vote_no_count + 1') . ' WHERE id = ' . sqlesc($id));
        header('Location: /requests.php?action=request_details&voted=1&id=' . sqlesc($id));
        die();
    } else stderr($lang['req_add_err3'], $lang['req_add_err5']);
    break;
    //===========================================================================================//
    //=======================    the default page listing all the requests w/ pager         ===============================//
    //===========================================================================================//
    
case 'default':
    require_once INCL_DIR . 'bbcode_functions.php';
    require_once INCL_DIR . 'pager_new.php';
    //=== get stuff for the pager
    $count_query = sql_query('SELECT COUNT(id) FROM requests');
    $count_arr = mysqli_fetch_row($count_query);
    $count = $count_arr[0];
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 0;
    $perpage = isset($_GET['perpage']) ? (int)$_GET['perpage'] : 20;
    list($menu, $LIMIT) = pager_new($count, $perpage, $page, 'requests.php?' . ($perpage == 20 ? '' : '&amp;perpage=' . $perpage));
    $main_query_res = sql_query('SELECT r.id AS request_id, r.request_name, r.category, r.added, r.requested_by_user_id, r.filled_by_user_id, r.filled_torrent_id, r.vote_yes_count, r.vote_no_count, r.comments, u.id, u.username, u.warned, u.suspended, u.enabled, u.donor, u.class, u.leechwarn, u.chatpost, u.pirate, u.king,
c.id AS cat_id, c.name AS cat_name, c.image AS cat_image FROM requests AS r LEFT JOIN categories AS c ON r.category = c.id LEFT JOIN users AS u ON r.requested_by_user_id = u.id ORDER BY r.added DESC ' . $LIMIT);
    if ($count = 0) stderr($lang['error_error'], $lang['req_add_err6']);
    $HTMLOUT.= (isset($_GET['new']) ? '<h1>'.$lang['req_add_adr'].'</h1>' : '') . (isset($_GET['request_deleted']) ? '<h1>'.$lang['req_add_delr'].'</h1>' : '') . $top_menu . '' . $menu . '<br />';
    $HTMLOUT.= '<table class="table table-hover table-bordered">
    <tr>
        <td class="colhead" align="center">'.$lang['req_type'].'</td>
        <td class="colhead" align="left">'.$lang['req_name'].'</td>
        <td class="colhead" align="center">'.$lang['req_added'].'</td>
        <td class="colhead" align="center">'.$lang['req_add_comm'].'</td>  
        <td class="colhead" align="center">'.$lang['req_votes'].'</td>
        <td class="colhead" align="center">'.$lang['req_req_by'].'</td>
        <td class="colhead" align="center">'.$lang['req_filled'].'</td>
    </tr>';
    while ($main_query_arr = mysqli_fetch_assoc($main_query_res)) {
        //=======change colors
        $count2 = (++$count2) % 2;
        $class = ($count2 == 0 ? 'one' : 'two');
        $HTMLOUT.= '
    <tr>
        <td class="' . $class . '" align="center" style="margin: 0; padding: 1;"><img border="0" src="pic/caticons/' . $CURUSER['categorie_icon'] . '/' . htmlsafechars($main_query_arr['cat_image'], ENT_QUOTES) . '" alt="' . htmlsafechars($main_query_arr['cat_name'], ENT_QUOTES) . '" /></td>
        <td class="' . $class . '" align="left"><a class="altlink" href="requests.php?action=request_details&amp;id=' . (int)$main_query_arr['request_id'] . '">' . htmlsafechars($main_query_arr['request_name'], ENT_QUOTES) . '</a></td>
        <td class="' . $class . '" align="center">' . get_date($main_query_arr['added'], 'LONG') . '</td>
        <td class="' . $class . '" align="center">' . number_format($main_query_arr['comments']) . '</td>  
        <td class="' . $class . '" align="center">yes: ' . number_format($main_query_arr['vote_yes_count']) . '<br />
        no: ' . number_format($main_query_arr['vote_no_count']) . '</td> 
        <td class="' . $class . '" align="center">' . print_user_stuff($main_query_arr) . '</td>
        <td class="' . $class . '" align="center">' . ($main_query_arr['filled_by_user_id'] > 0 ? '<a href="details.php?id=' . (int)$main_query_arr['filled_torrent_id'] . '" title="'.$lang['req_mouse_go'].'"><span style="color: limegreen;font-weight: bold;">'.$lang['req_det_yes1'].'</span></a>' : '<span style="color: red;font-weight: bold;">'.$lang['req_det_no1'].'</span>') . '</td>
    </tr>';
    }
    $HTMLOUT.= '</table>';
    $HTMLOUT.= '' . $menu . '<br />';
    echo stdhead($lang['gl_requests'], true, $stdhead) . $HTMLOUT . stdfoot($stdfoot);
    break;
    //===========================================================================================//
    //==============================the details page for the request! ========================================//
    //===========================================================================================//    
case 'request_details':
    require_once INCL_DIR . 'bbcode_functions.php';
    require_once INCL_DIR . 'pager_new.php';
    //=== kill if nasty
    if (!isset($id) || !is_valid_id($id)) stderr($lang['req_add_err3'], $lang['error_bad']);
    $res = sql_query('SELECT r.id AS request_id, r.request_name, r.category, r.added, r.requested_by_user_id, r.filled_by_user_id, r.filled_torrent_id, r.vote_yes_count, 
                            r.vote_no_count, r.image, r.link, r.description, r.comments,
                            u.id, u.username, u.warned, u.suspended, u.enabled, u.donor, u.class, u.uploaded, u.downloaded, u.leechwarn, u.chatpost, u.pirate, u.king,
                            c.name AS cat_name, c.image AS cat_image
                            FROM requests AS r
                            LEFT JOIN categories AS c ON r.category = c.id
                            LEFT JOIN users AS u ON r.requested_by_user_id = u.id
                            WHERE r.id = ' . sqlesc($id));
    $arr = mysqli_fetch_assoc($res);
    //=== see if they voted yet
    $res_did_they_vote = sql_query('SELECT vote FROM request_votes WHERE user_id = ' . sqlesc($CURUSER['id']) . ' AND request_id = ' . sqlesc($id));
    $row_did_they_vote = mysqli_fetch_row($res_did_they_vote);
    if ($row_did_they_vote[0] == '') {
        $vote_yes = '<form method="post" action="requests.php">
                    <input type="hidden" name="action" value="vote" />
                    <input type="hidden" name="id" value="' . $id . '" />
                    <input type="hidden" name="vote" value="1" />
                    <input type="submit" class="button" value='.$lang['req_det_voty'].' onmouseover="this.className=\'button_hover\'" onmouseout="this.className=\'button\'" />
                    </form>'.$lang['req_det_phr1'].'';
        $vote_no = '<form method="post" action="requests.php">
                    <input type="hidden" name="action" value="vote" />
                    <input type="hidden" name="id" value="' . $id . '" />
                    <input type="hidden" name="vote" value="2" />
                    <input type="submit" class="button" value='.$lang['req_det_votn'].' onmouseover="this.className=\'button_hover\'" onmouseout="this.className=\'button\'" />
                    </form>'.$lang['req_det_phr2'].'';
        $your_vote_was = '';
    } else {
        $vote_yes = '';
        $vote_no = '';
        $your_vote_was = $lang['req_det_votu'] . $row_did_they_vote[0] . ' ';
    }
    //=== start page
    $HTMLOUT.= (isset($_GET['voted']) ? '<h1>'.$lang['req_det_votadd'].'</h1>' : '') . (isset($_GET['comment_deleted']) ? '<h1>'.$lang['req_det_comdel'].'</h1>' : '') . $top_menu . '
  <table class="table table-hover table-bordered">
  <tr>
  <td class="colhead" align="center" colspan="2"><h1>' . htmlsafechars($arr['request_name'], ENT_QUOTES) . ($CURUSER['class'] < UC_STAFF ? '' : ' [ <a href="requests.php?action=edit_request&amp;id=' . $id . '">'.$lang['req_det_edit'].'</a> ] 
  [ <a href="requests.php?action=delete_request&amp;id=' . $id . '">'.$lang['req_add_del'].'</a> ]') . '</h1></td>
  </tr>
  <tr>
  <td class="two" align="right">'.$lang['add_image'].'</td>
  <td class="two" align="left"><img src="' . strip_tags($arr['image']) . '" alt="image" style="max-width:600px;" /></td>
  </tr>
  <tr>
  <td class="two" align="right">'.$lang['add_description'].'</td>
  <td class="two" align="left">' . format_comment($arr['description']) . '</td>
  </tr>
  <tr>
  <td class="two" align="right">'.$lang['add_cat'].'</td>
  <td class="two" align="left"><img border="0" src="pic/caticons/' . $CURUSER['categorie_icon'] . '/' . htmlsafechars($arr['cat_image'], ENT_QUOTES) . '" alt="' . htmlsafechars($arr['cat_name'], ENT_QUOTES) . '" /></td>
  </tr>
  <tr>
  <td class="two" align="right">'.$lang['req_det_link'].'</td>
  <td class="two" align="left"><a class="altlink" href="' . htmlsafechars($arr['link'], ENT_QUOTES) . '"  target="_blank">' . htmlsafechars($arr['link'], ENT_QUOTES) . '</a></td>
  </tr>
  <tr>
  <td class="two" align="right">'.$lang['req_votes'].'</td>
  <td class="two" align="left">
  <span style="font-weight:bold;color: green;">'.$lang['req_det_yes'].' ' . number_format($arr['vote_yes_count']) . '</span> ' . $vote_yes . '<br />
  <span style="font-weight:bold;color: red;">'.$lang['req_det_no'].' ' . number_format($arr['vote_no_count']) . '</span> ' . $vote_no . '<br /> ' . $your_vote_was . '</td>
  </tr>
  <tr>
  <td class="two" align="right">'.$lang['req_req_by'].'</td>
  <td class="two" align="left">' . print_user_stuff($arr) . ' [ ' . get_user_class_name($arr['class']) . ' ]   
  ratio: ' . member_ratio($arr['uploaded'], $INSTALLER09['ratio_free'] ? "0" : $arr['downloaded']) . get_user_ratio_image($arr['uploaded'], ($INSTALLER09['ratio_free'] ? "1" : $arr['downloaded'])) . '</td>
  </tr>' . ($arr['filled_torrent_id'] > 0 ? '<tr>
  <td class="two" align="right">'.$lang['req_filled'].'</td>
  <td class="two" align="left"><a class="altlink" href="details.php?id=' . $arr['filled_torrent_id'] . '">'.$lang['req_det_clkvw'].'</a></td>
  </tr>' : '') . '
  <tr>
  <td class="two" align="right">'.$lang['details_report'].'</td>
  <td class="two" align="left"><form action="report.php?type=Request&amp;id=' . $id . '" method="post">
  <input type="submit" class="button_med" value='.$lang['req_det_repthis'].' onmouseover="this.className=\'button_med_hover\'" onmouseout="this.className=\'button_med\'" />
  '.$lang['req_det_brk'].' <a class="altlink" href="rules.php">'.$lang['gl_rules'].'</a></form></td>
  </tr>
  </table>';
    $HTMLOUT.= '<h1>'.$lang['req_det_cofor'].' ' . htmlsafechars($arr['request_name'], ENT_QUOTES) . '</h1><p><a name="startcomments"></a></p>';
    $commentbar = '<p align="center"><a class="index" href="requests.php?action=add_comment&amp;id=' . $id . '">'.$lang['details_add_comment'].'</a></p>';
    $count = (int)$arr['comments'];
    if (!$count) {
        $HTMLOUT.= '<h2>'.$lang['details_no_comment'].'</h2>';
    } else {
        //=== get stuff for the pager
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 0;
        $perpage = isset($_GET['perpage']) ? (int)$_GET['perpage'] : 20;
        list($menu, $LIMIT) = pager_new($count, $perpage, $page, 'requests.php?action=request_details&amp;id=' . $id, ($perpage == 20 ? '' : '&amp;perpage=' . $perpage) . '#comments');
        $subres = sql_query('SELECT c.request, c.id AS comment_id, c.text, c.added, c.editedby, c.editedat, u.id, u.username, u.warned, u.suspended, u.enabled, u.donor, u.class, u.avatar, u.offensive_avatar, u.leechwarn, u.chatpost, u.pirate, u.king, u.title FROM comments AS c LEFT JOIN users AS u ON c.user = u.id WHERE c.request = ' . sqlesc($id) . ' ORDER BY c.id ' . $LIMIT) or sqlerr(__FILE__, __LINE__);
        $allrows = array();
        while ($subrow = mysqli_fetch_assoc($subres)) $allrows[] = $subrow;
        $HTMLOUT.= $commentbar . '<a name="comments"></a>';
        $HTMLOUT.= ($count > $perpage) ? '' . $menu . '<br />' : '<br />';
        $HTMLOUT.= comment_table($allrows);
        $HTMLOUT.= ($count > $perpage) ? '' . $menu . '<br />' : '<br />';
    }
    $HTMLOUT.= $commentbar;
    echo stdhead($lang['details_details'] . htmlsafechars($arr['request_name'], ENT_QUOTES) , true, $stdhead) . $HTMLOUT . stdfoot($stdfoot);
    break;
    //===========================================================================================//
    //====================================    add new request      ========================================//
    //===========================================================================================//

case 'add_new_request':
    require_once INCL_DIR . 'bbcode_functions.php';
    $request_name = strip_tags(isset($_POST['request_name']) ? trim($_POST['request_name']) : '');
    $image = strip_tags(isset($_POST['image']) ? trim(htmlsafechars($_POST['image'])) : '');
    $body = (isset($_POST['descr']) ? trim(htmlsafechars($_POST['descr'])) : '');
    $link = strip_tags(isset($_POST['link']) ? trim(htmlsafechars($_POST['link'])) : '');
    //=== do the cat list :D
    $category_drop_down = '<select name="category" class="required"><option class="body" value="">'.$lang['add_select_cat'].'</option>';
    $cats = genrelist();
    foreach ($cats as $row) {
        $category_drop_down.= '<option class="body" value="' . (int)$row['id'] . '"' . ($category == $row['id'] ? ' selected="selected"' : '') . '>' . htmlsafechars($row['name']) . '</option>';
    }
    $category_drop_down.= '</select>';
    if (isset($_POST['category'])) {
        $cat_res = sql_query('SELECT id AS cat_id, name AS cat_name, image AS cat_image FROM categories WHERE id = ' . sqlesc($category));
        $cat_arr = mysqli_fetch_assoc($cat_res);
        $cat_image = htmlsafechars($cat_arr['cat_image'], ENT_QUOTES);
        $cat_name = htmlsafechars($cat_arr['cat_name'], ENT_QUOTES);
    }
    //=== if posted and not preview, process it :D
    if (isset($_POST['button']) && $_POST['button'] == $lang['req_det_sbmt']) {
        sql_query('INSERT INTO requests (request_name, image, description, category, added, requested_by_user_id, link) VALUES 
                    (' . sqlesc($request_name) . ', ' . sqlesc($image) . ', ' . sqlesc($body) . ', ' . sqlesc($category) . ', ' . TIME_NOW . ', ' . sqlesc($CURUSER['id']) . ',  ' . sqlesc($link) . ');');
        $new_request_id = ((is_null($___mysqli_res = mysqli_insert_id($GLOBALS["___mysqli_ston"]))) ? false : $___mysqli_res);
        header('Location: requests.php?action=request_details&new=1&id=' . $new_request_id);
        die();
    }
    //=== start page
    $HTMLOUT.= '<table class="table table-hover table-bordered">
   <tr>
   <td class="embedded" align="center"><h1 style="text-align: center;">'.$lang['req_add_new'].'</h1>' . $top_menu . '
   <form method="post" action="requests.php?action=add_new_request" name="request_form" id="request_form">
   ' . (isset($_POST['button']) && $_POST['button'] == $lang['req_det_prvw'] ? '<br />
	<table border="0" cellspacing="0" cellpadding="5" align="center" width="700px">
   <tr>
   <td class="colhead" align="center" colspan="2"><h1>' . htmlsafechars($request_name, ENT_QUOTES) . '</h1></td>
   </tr>
   <tr>
   <td class="two" align="right">'.$lang['add_image'].'</td>
   <td class="two" align="left"><img src="' . htmlsafechars($image, ENT_QUOTES) . '" alt="image" style="max-width:600px;" /></td>
   </tr>
   <tr>
   <td class="two" align="right">'.$lang['add_description'].'</td>
   <td class="two" align="left">' . format_comment($body) . '</td>
   </tr>
   <tr>
   <td class="two" align="right">'.$lang['add_cat'].'</td>
   <td class="two" align="left"><img border="0" src="pic/caticons/' . $CURUSER['categorie_icon'] . '/' . htmlsafechars($cat_image, ENT_QUOTES) . '" alt="' . htmlsafechars($cat_name, ENT_QUOTES) . '" /></td>
    </tr>
    <tr>
    <td class="two" align="right">'.$lang['req_det_link'].'</td>
    <td class="two" align="left"><a class="altlink" href="' . htmlsafechars($link, ENT_QUOTES) . '" target="_blank">' . htmlsafechars($link, ENT_QUOTES) . '</a></td>
    </tr>
    <tr>
    <td class="two" align="right">'.$lang['req_req_by'].'</td>
    <td class="two" align="left">' . print_user_stuff($CURUSER) . ' [ ' . get_user_class_name($CURUSER['class']) . ' ]   
    ratio: ' . member_ratio($CURUSER['uploaded'], $INSTALLER09['ratio_free'] ? "0" : $CURUSER['downloaded']) . get_user_ratio_image($CURUSER['uploaded'], ($INSTALLER09['ratio_free'] ? "1" : $CURUSER['downloaded'])) . '</td>
    </tr>
    </table>
    <br />' : '') . '
    <table class="table table-hover table-bordered">
    <tr>
    <td class="colhead" align="center" colspan="2"><h1>'.$lang['req_make_req'].'</h1></td>
    </tr>
    <tr>
    <td align="center" colspan="2" class="two">'.$lang['req_add_att1'].'<a class="altlink" href="search.php">'.$lang['req_add_att2'].'</a>
    '.$lang['req_add_att3'].'<br /><br />'.$lang['req_add_att4'].'</td>
    </tr>
    <tr>
    <td class="two" align="right">'.$lang['req_name'].'</td>
    <td class="two" align="left"><input type="text" size="80"  name="request_name" value="' . htmlsafechars($request_name, ENT_QUOTES) . '" class="required" /></td>
    </tr>
    <tr>
    <td class="two" align="right">'.$lang['add_image'].'</td>
    <td class="two" align="left"><input type="text" size="80"  name="image" value="' . htmlsafechars($image, ENT_QUOTES) . '" class="required" /></td>
    </tr>
    <tr>
    <td class="two" align="right">'.$lang['req_det_link'].'</td>
    <td class="two" align="left"><input type="text" size="80"  name="link" value="' . htmlsafechars($link, ENT_QUOTES) . '" class="required" /></td>
    </tr>
    <tr>
    <td class="two" align="right">'.$lang['add_cat'].'</td>
    <td class="two" align="left">' . $category_drop_down . '</td>
    </tr>
    <tr>
    <td class="two" align="right">'.$lang['add_description'].'</td>
    <td class="two" align="left">'. textbbcode('requests','descr').'</td>
    </tr>
    <tr>
    <td colspan="2" align="center" class="two">
    <input type="submit" name="button" class="button" value="'.$lang['req_det_prvw'].'" onmouseover="this.className=\'button_hover\'" onmouseout="this.className=\'button\'" />
    <input type="submit" name="button" class="button" value="'.$lang['req_det_sbmt'].'" onmouseover="this.className=\'button_hover\'" onmouseout="this.className=\'button\'" /></td>
    </tr>
    </table></form>
	 </td></tr></table><br />
    <script type="text/javascript">
    /*<![CDATA[*/
    $(document).ready(function()	{
    //=== form validation
    $("#request_form").validate();
    });
    /*]]>*/
    </script>';
    echo stdhead($lang['req_add_req'], true, $stdhead) . $HTMLOUT . stdfoot($stdfoot);
    break;
    //===========================================================================================//
    //====================================      delete  request      ========================================//
    //===========================================================================================//
    
case 'delete_request':
    if (!isset($id) || !is_valid_id($id)) stderr($lang['error_error'], $lang['error_bad']);
    $res = sql_query('SELECT request_name, requested_by_user_id FROM requests WHERE id =' . sqlesc($id)) or sqlerr(__FILE__, __LINE__);
    $arr = mysqli_fetch_assoc($res);
    if (!$arr) stderr($lang['error_error'], $lang['error_invalid']);
    if ($arr['requested_by_user_id'] !== $CURUSER['id'] && $CURUSER['class'] < UC_STAFF) stderr($lang['error_error'], $lang['req_add_err8']);
    if (!isset($_GET['do_it'])) {
        stderr($lang['req_add_warn1'], $lang['req_add_warn2'] . htmlsafechars($arr['request_name'], ENT_QUOTES) . ''.$lang['req_add_warn3'].' 
        <a class="altlink" href="requests.php?action=delete_request&amp;id=' . $id . '&amp;do_it=666" >'.$lang['req_add_warn4'].'</a>.');
    } else {
        sql_query('DELETE FROM requests WHERE id=' . sqlesc($id));
        sql_query('DELETE FROM request_votes WHERE request_id =' . sqlesc($id));
        sql_query('DELETE FROM comments WHERE request =' . sqlesc($id));
        header('Location: /requests.php?request_deleted=1');
        die();
    }
    echo stdhead($lang['details_delete'], true, $stdhead) . $HTMLOUT . stdfoot($stdfoot);
    break;
    //===========================================================================================//
    //====================================          edit request      ========================================//
    //===========================================================================================//
    
case 'edit_request':
    require_once INCL_DIR . 'bbcode_functions.php';
    if (!isset($id) || !is_valid_id($id)) stderr($lang['error_error'], $lang['error_bad']);
    $edit_res = sql_query('SELECT request_name, image, description, category, requested_by_user_id, filled_by_user_id, filled_torrent_id, link FROM requests WHERE id =' . sqlesc($id)) or sqlerr(__FILE__, __LINE__);
    $edit_arr = mysqli_fetch_assoc($edit_res);
    if ($CURUSER['class'] < UC_STAFF && $CURUSER['id'] !== $edit_arr['requested_by_user_id']) stderr($lang['error_error'], $lang['error_not_yours']);
    $filled_by = '';
    if ($edit_arr['filled_by_user_id'] > 0) {
        $filled_by_res = sql_query('SELECT id, username, warned, suspended, enabled, leechwarn, chatpost, pirate, king, donor, class FROM users WHERE id =' . sqlesc($edit_arr['filled_by_user_id'])) or sqlerr(__FILE__, __LINE__);
        $filled_by_arr = mysqli_fetch_assoc($edit_res);
        $filled_by = 'this request was filled by ' . print_user_stuff($filled_by_arr);
    }
    $request_name = strip_tags(isset($_POST['request_name']) ? trim($_POST['request_name']) : $edit_arr['request_name']);
    $image = strip_tags(isset($_POST['image']) ? trim($_POST['image']) : $edit_arr['image']);
    $body = strip_tags((isset($_POST['descr']) ? trim($_POST['descr']) : $edit_arr['description']));
    $link = strip_tags(isset($_POST['link']) ? trim($_POST['link']) : $edit_arr['link']);
    $category = (isset($_POST['category']) ? intval($_POST['category']) : $edit_arr['category']);
    //=== do the cat list :D
    $category_drop_down = '<select name="category" class="required"><option class="body" value="">'.$lang['req_slct_req'].'</option>';
    $cats = genrelist();
    foreach ($cats as $row) {
        $category_drop_down.= '<option class="body" value="' . (int)$row['id'] . '"' . ($category == $row['id'] ? ' selected="selected""' : '') . '>' . htmlsafechars($row['name'], ENT_QUOTES) . '</option>';
    }
    $category_drop_down.= '</select>';
    $cat_res = sql_query('SELECT id AS cat_id, name AS cat_name, image AS cat_image FROM categories WHERE id = ' . sqlesc($category));
    $cat_arr = mysqli_fetch_assoc($cat_res);
    $cat_image = htmlsafechars($cat_arr['cat_image'], ENT_QUOTES);
    $cat_name = htmlsafechars($cat_arr['cat_name'], ENT_QUOTES);
    //=== if posted and not preview, process it :D
    if (isset($_POST['button']) && $_POST['button'] == $lang['req_det_edit']) {
        $remove_or_not = (isset($_POST['filled_by']) ? ' filled_by_user_id = 0, filled_torrent_id = 0' : '');
        sql_query('UPDATE requests SET request_name = ' . sqlesc($request_name) . ', image = ' . sqlesc($image) . ', description = ' . sqlesc($body) . ', 
                    category = ' . sqlesc($category) . ', link = ' . sqlesc($link) . $remove_or_not . ' WHERE id = ' . sqlesc($id));
        header('Location: requests.php?action=request_details&edited=1&id=' . $id);
        die();
    }
    //=== start page
    $HTMLOUT.= '<table class="table table-hover table-bordered">
   <tr>
   <td class="embedded" align="center">
   <h1 style="text-align: center;">'.$lang['details_edit'].'</h1>' . $top_menu . '
   <form method="post" action="requests.php?action=edit_request" name="request_form" id="request_form">
   <input type="hidden" name="id" value="' . $id . '" />
   ' . (isset($_POST['button']) && $_POST['button'] == $lang['req_det_prvw'] ? '<br />
	<table class="table table-hover table-bordered">
   <tr>
   <td class="colhead" align="center" colspan="2"><h1>' . htmlsafechars($request_name, ENT_QUOTES) . '</h1></td>
   </tr>
   <tr>
   <td class="two" align="right">'.$lang['add_image'].'</td>
   <td class="two" align="left"><img src="' . htmlsafechars($image, ENT_QUOTES) . '" alt="image" style="max-width:600px;" /></td>
   </tr>
   <tr>
   <td class="two" align="right">'.$lang['add_description'].'</td>
   <td class="two" align="left">' . format_comment($body) . '</td>
   </tr>
   <tr>
   <td class="two" align="right">'.$lang['add_cat'].'</td>
   <td class="two" align="left"><img border="0" src="pic/caticons/' . $CURUSER['categorie_icon'] . '/' . htmlsafechars($cat_image, ENT_QUOTES) . '" alt="' . htmlsafechars($cat_name, ENT_QUOTES) . '" /></td>
   </tr>
   <tr>
   <td class="two" align="right">'.$lang['req_det_link'].'</td>
   <td class="two" align="left"><a class="altlink" href="' . htmlsafechars($link, ENT_QUOTES) . '" target="_blank">' . htmlsafechars($link, ENT_QUOTES) . '</a></td>
   </tr>
   </table>
   <br />' : '') . '
   <table class="table table-hover table-bordered">
   <tr>
   <td class="colhead" align="center" colspan="2"><h1>'.$lang['details_edit'].'</h1></td>
   </tr>
   <tr>
   <td align="center" colspan="2" class="two">'.$lang['req_add_att4'].'</td>
   </tr>
   <tr>
   <td class="two" align="right">'.$lang['req_name'].'</td>
   <td class="two" align="left"><input type="text" size="80"  name="request_name" value="' . htmlsafechars($request_name, ENT_QUOTES) . '" class="required" /></td>
   </tr>
   <tr>
   <td class="two" align="right">'.$lang['add_image'].'</td>
   <td class="two" align="left"><input type="text" size="80"  name="image" value="' . htmlsafechars($image, ENT_QUOTES) . '" class="required" /></td>
   </tr>
   <tr>
   <td class="two" align="right">'.$lang['req_det_link'].'</td>
   <td class="two" align="left"><input type="text" size="80"  name="link" value="' . htmlsafechars($link, ENT_QUOTES) . '" class="required" /></td>
   </tr>
   <tr>
   <td class="two" align="right">'.$lang['add_cat'].'</td>
   <td class="two" align="left">' . $category_drop_down . '</td>
   </tr>
   <tr>
   <td class="two" align="right">'.$lang['add_description'].'</td>
   <td class="two" align="left">'. textbbcode('requests','descr', $edit_arr['description']).'</td>
   </tr>' . ($edit_arr['filled_by_user_id'] == 0 ? '' : '
   <tr>
   <td class="two" align="right">'.$lang['req_filled'].'</td>
   <td class="two" align="left">' . $filled_by . ' <input type="checkbox" name="filled_by" value="1"' . (isset($_POST['filled_by']) ? ' "checked"' : '') . ' />'.$lang['req_fil_chk'].'</td>
   </tr>') . '
   <tr>
   <td colspan="2" align="center" class="two">
   <input type="submit" name="button" class="button" value="'.$lang['req_det_prvw'].'" onmouseover="this.className=\'button_hover\'" onmouseout="this.className=\'button\'" />
   <input type="submit" name="button" class="button" value="'.$lang['req_det_edit'].'" onmouseover="this.className=\'button_hover\'" onmouseout="this.className=\'button\'" /></td>
   </tr>
   </table></form>
	</td></tr></table><br />
   <script type="text/javascript">
   /*<![CDATA[*/
   $(document).ready(function()	{
   //=== form validation
   $("#request_form").validate();
   });
   /*]]>*/
   </script>';
    echo stdhead($lang['details_edit'], true, $stdhead) . $HTMLOUT . stdfoot($stdfoot);
    break;
    //===========================================================================================//
    //====================================    add comment          ========================================//
    //===========================================================================================//
    
case 'add_comment':
    require_once INCL_DIR . 'bbcode_functions.php';
    require_once INCL_DIR . 'pager_new.php';
    //=== kill if nasty
    if (!isset($id) || !is_valid_id($id)) stderr($lang['req_add_err3'], $lang['error_bad']);
    $res = sql_query('SELECT request_name FROM requests WHERE id = ' . sqlesc($id)) or sqlerr(__FILE__, __LINE__);
    $arr = mysqli_fetch_assoc($res);
    if (!$arr) stderr($lang['req_add_err3'], $lang['error_error1']);
    if (isset($_POST['button']) && $_POST['button'] == $lang['req_det_save']) {
        $body = strip_tags(trim($_POST['descr']));
        if (!$body) stderr($lang['req_add_err3'], $lang['error_error2']);
        sql_query("INSERT INTO comments (user, request, added, text, ori_text) VALUES (" . sqlesc($CURUSER['id']) . ", " . sqlesc($id) . ", " . TIME_NOW . ", " . sqlesc($body) . "," . sqlesc($body) . ")");
        $newid = ((is_null($___mysqli_res = mysqli_insert_id($GLOBALS["___mysqli_ston"]))) ? false : $___mysqli_res);
        sql_query('UPDATE requests SET comments = comments + 1 WHERE id = ' . sqlesc($id)) or sqlerr(__FILE__, __LINE__);
        header('Location: /requests.php?action=request_details&id=' . $id . '&viewcomm=' . $newid . '#comm' . $newid);
        die();
    }
    $body = htmlsafechars((isset($_POST['descr']) ? $_POST['descr'] : ''));
    $HTMLOUT.= $top_menu . '<form method="post" action="requests.php?action=add_comment">
    <input type="hidden" name="id" value="' . $id . '"/>
    ' . (isset($_POST['button']) && $_POST['button'] == $lang['req_det_prvw'] ? '
    <table class="table table-hover table-bordered">
    <tr>
    <td class="colhead" colspan="2"><h1>'.$lang['req_det_prvw'].'</h1></td>
    </tr>
	 <tr>
    <td width="80" valign="top" class="two">' . avatar_stuff($CURUSER) . '</td>
    <td valign="top" align="left" class="two">' . format_comment($body) . '</td>
    </tr></table><br />' : '') . '
	 <table class="table table-hover table-bordered">
	 <tr>
    <td align="center" class="colhead" colspan="2"><h1>'.$lang['req_det_adco'].'' . htmlsafechars($arr['request_name'], ENT_QUOTES) . '"</h1></td>
    </tr>
	 <tr>
    <td align="right" valign="top" class="two"><b>'.$lang['req_det_comnt'].'</b></td>
    <td align="left" class="two">'. textbbcode('requests','descr').'</td>
    </tr>
	 <tr>
    <td align="center" colspan="2" class="two"> 
    <input name="button" type="submit" class="button" value="'.$lang['req_det_prvw'].'" onmouseover="this.className=\'button_hover\'" onmouseout="this.className=\'button\'" /> 
    <input name="button" type="submit" class="button" value="'.$lang['req_det_save'].'" onmouseover="this.className=\'button_hover\'" onmouseout="this.className=\'button\'" /></td>
    </tr>
	 </table></form>';
    $res = sql_query('SELECT c.request, c.id AS comment_id, c.text, c.added, c.editedby, c.editedat, 
                                u.id, u.username, u.warned, u.suspended, u.enabled, u.donor, u.class, u.avatar, u.offensive_avatar, u.title, u.leechwarn, u.chatpost, u.pirate,  u.king FROM comments AS c LEFT JOIN users AS u ON c.user = u.id WHERE request = ' . sqlesc($id) . ' ORDER BY c.id DESC LIMIT 5');
    $allrows = array();
    while ($row = mysqli_fetch_assoc($res)) $allrows[] = $row;
    if (count($allrows)) {
        $HTMLOUT.= '<h2>'.$lang['req_det_most'].'</h2>';
        $HTMLOUT.= comment_table($allrows);
    }
    echo stdhead($lang['req_det_adco'] . $arr['request_name'] . '"', true, $stdhead) . $HTMLOUT . stdfoot($stdfoot);
    break;
    //===========================================================================================//
    //==================================    edit comment    =============================================//
    //===========================================================================================//
    
case 'edit_comment':
    require_once INCL_DIR . 'bbcode_functions.php';
    if (!isset($comment_id) || !is_valid_id($comment_id)) stderr($lang['error_error'], $lang['error_bad']);
    $res = sql_query('SELECT c.*, r.request_name FROM comments AS c LEFT JOIN requests AS r ON c.request = r.id WHERE c.id=' . sqlesc($comment_id)) or sqlerr(__FILE__, __LINE__);
    $arr = mysqli_fetch_assoc($res);
    if (!$arr) stderr($lang['error_error'], $lang['error_invalid']);
    if ($arr['user'] != $CURUSER['id'] && $CURUSER['class'] < UC_STAFF) stderr($lang['error_error'], $lang['req_add_err8']);
    $body = htmlsafechars((isset($_POST['descr']) ? $_POST['descr'] : $arr['text']));
    if (isset($_POST['button']) && $_POST['button'] == $lang['req_det_edit']) {
        if ($body == '') stderr($lang['error_error'], $lang['error_error2']);
        sql_query('UPDATE comments SET text=' . sqlesc($body) . ', editedat=' . TIME_NOW . ', editedby=' . sqlesc($CURUSER['id']) . ' WHERE id=' . sqlesc($comment_id)) or sqlerr(__FILE__, __LINE__);
        header('Location: /requests.php?action=request_details&id=' . $id . '&viewcomm=' . $comment_id . '#comm' . $comment_id);
        die();
    }
    if ($CURUSER['id'] == $arr['user']) {
        $avatar = avatar_stuff($CURUSER);
    } else {
        $res_user = sql_query('SELECT avatar, offensive_avatar, view_offensive_avatar FROM users WHERE id=' . sqlesc($arr['user'])) or sqlerr(__FILE__, __LINE__);
        $arr_user = mysqli_fetch_assoc($res_user);
        $avatar = avatar_stuff($arr_user);
    }
    $HTMLOUT.= $top_menu . '<form method="post" action="requests.php?action=edit_comment">
    <input type="hidden" name="id" value="' . $arr['request'] . '"/>
    <input type="hidden" name="comment_id" value="' . $comment_id . '"/>
	 ' . (isset($_POST['button']) && $_POST['button'] == $lang['req_det_prvw'] ? '<table class="table table-hover table-bordered">
    <tr>
    <td class="colhead" colspan="2"><h1>'.$lang['req_det_prvw'].'</h1></td>
    </tr>
	 <tr>
    <td width="80" valign="top" class="two">' . $avatar . '</td>
    <td valign="top" align="left" class="two">' . format_comment($body) . '</td>
    </tr></table><br />' : '') . '
    <table class="table table-hover table-bordered">
	 <tr>
    <td align="center" class="colhead" colspan="2"><h1>'.$lang['req_det_edco'].'' . htmlsafechars($arr['request_name'], ENT_QUOTES) . '"</h1></td>
    </tr>
	 <tr>
    <td align="right" valign="top" class="two"><b>'.$lang['req_det_comnt'].'</b></td><td align="left">'. textbbcode('requests','descr', $arr['text']).'</td>
    </tr>
	 <tr>
    <td align="center" colspan="2" class="two">
    <input name="button" type="submit" class="button" value="'.$lang['req_det_prvw'].'" onmouseover="this.className=\'button_hover\'" onmouseout="this.className=\'button\'" /> 
    <input name="button" type="submit" class="button" value="'.$lang['req_det_edit'].'" onmouseover="this.className=\'button_hover\'" onmouseout="this.className=\'button\'" /></td>
    </tr>
	 </table></form>';
    echo stdhead($arr['req_det_edco'] . $arr['request_name'] . '"', true, $stdhead) . $HTMLOUT . stdfoot($stdfoot);
    break;
    //===========================================================================================//
    //==================================    delete comment    =============================================//
    //===========================================================================================//
    
case 'delete_comment':
    if (!isset($comment_id) || !is_valid_id($comment_id)) stderr($lang['error_error'], $lang['error_bad']);
    $res = sql_query('SELECT user, request FROM comments WHERE id=' . $comment_id) or sqlerr(__FILE__, __LINE__);
    $arr = mysqli_fetch_assoc($res);
    if (!$arr) stderr($lang['error_error'], $lang['error_invalid']);
    if ($arr['user'] != $CURUSER['id'] && $CURUSER['class'] < UC_STAFF) stderr($lang['error_error'], $lang['req_add_err8']);
    if (!isset($_GET['do_it'])) {
        stderr($lang['req_add_warn1'], ''.$lang['req_com_del1'].' <a class="altlink" href="requests.php?action=delete_comment&amp;id=' . (int)$arr['request'] . '&amp;comment_id=' . $comment_id . '&amp;do_it=666" >'.$lang['req_add_warn4'].'</a>.');
    } else {
        sql_query('DELETE FROM comments WHERE id=' . sqlesc($comment_id));
        sql_query('UPDATE requests SET comments = comments - 1 WHERE id = ' . sqlesc($arr['request']));
        header('Location: /requests.php?action=request_details&id=' . $id . '&comment_deleted=1');
        die();
    }
    break;
} //=== end all actions / switch
//=== functions n' stuff \o/
function comment_table($rows)
{
    $count2 = '';
    global $CURUSER, $INSTALLER09;
    $comment_table = '<table class="table table-hover table-bordered">
    <tr>
    <td class="three" align="center">';
    foreach ($rows as $row) {
        //=======change colors
        $count2 = (++$count2) % 2;
        $class = ($count2 == 0 ? 'one' : 'two');
        $text = format_comment($row['text']);
        if ($row['editedby']) {
            $res_user = sql_query('SELECT username FROM users WHERE id=' . sqlesc($row['editedby'])) or sqlerr(__FILE__, __LINE__);
            $arr_user = mysqli_fetch_assoc($res_user);
            $text.= '<p><font size="1" class="small">Last edited by <a href="userdetails.php?id=' . (int)$row['editedby'] . '"><b>' . htmlsafechars($arr_user['username']) . '</b></a> at ' . get_date($row['editedat'], 'DATE') . '</font></p>';
        }
        $top_comment_stuff = (int)$row['comment_id'] . ' by ' . (isset($row['username']) ? print_user_stuff($row) . ($row['title'] !== '' ? ' [ ' . htmlsafechars($row['title']) . ' ] ' : ' [ ' . get_user_class_name($row['class']) . ' ]  ') : ' M.I.A. ') . get_date($row['added'], '') . ($row['id'] == $CURUSER['id'] || $CURUSER['class'] >= UC_STAFF ? '
     - [<a href="requests.php?action=edit_comment&amp;id=' . (int)$row['request'] . '&amp;comment_id=' . (int)$row['comment_id'] . '">Edit</a>]' : '') . ($CURUSER['class'] >= UC_STAFF ? '
     - [<a href="requests.php?action=delete_comment&amp;id=' . (int)$row['request'] . '&amp;comment_id=' . (int)$row['comment_id'] . '">Delete</a>]' : '') . ($row['editedby'] && $CURUSER['class'] >= UC_STAFF ? '
     - [<a href="comment.php?action=vieworiginal&amp;cid=' . (int)$row['id'] . '">View original</a>]' : '') . ' 
    - [<a href="report.php?type=Request_Comment&amp;id_2=' . (int)$row['request'] . '&amp;id=' . (int)$row['comment_id'] . '">Report</a>]';
        $comment_table.= '
    <table class="table table-hover table-bordered">
    <tr>
    <td align="left" colspan="2" class="colhead"># ' . $top_comment_stuff . '</td>
    </tr>
    <tr>
    <td align="center" width="80" class="' . $class . '" style="padding: 0px;">' . avatar_stuff($row) . '</td>
    <td class="' . $class . '">' . $text . '</td>
    </tr>
    </table><br />';
    }
    $comment_table.= '</td></tr></table>';
    return $comment_table;
}
?>