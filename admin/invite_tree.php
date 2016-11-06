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
/*******************************************
//=== new invite tree system for TBDev 2010ish  (c) my great schlong 2010 \\o\o/o//
I think this was based on a code that was in broken stones, but I have no idea
if anyone knows, please post and I'll give proper credit. - snuggs
UPDATED may 25 2010 fixed some html and added more security thanks pdq ;)
*********************************************/
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
require_once (INCL_DIR . 'user_functions.php');
require_once (INCL_DIR . 'bbcode_functions.php');
require_once (INCL_DIR . 'pager_new.php');
require_once (CLASS_DIR . 'class_check.php');
$lang = array_merge($lang, load_language('ad_invite_tree'));
$class = get_access(basename($_SERVER['REQUEST_URI']));
class_check($class);
$lang = array_merge($lang);
$HTMLOUT = '';
//=== if we got here from a members page, get their info... if not, ask for a username to get the info...
$id = (isset($_GET['id']) ? intval($_GET['id']) : (isset($_POST['id']) ? intval($_POST['id']) : 0));
if ($id !== 0) {
    $rez_user = sql_query('SELECT username, warned, suspended, enabled, donor, invitedby FROM users WHERE id = ' . sqlesc($id));
    $arr_user = mysqli_fetch_assoc($rez_user);
    //=== start the page
    $HTMLOUT.= '<h1>' . htmlsafechars($arr_user['username']) . (substr($arr_user['username'], -1) == 's' ? '\'' : '\'s') . ' '.$lang['invite_head'].'</h1>
		<p>' . ($arr_user['invitedby'] == 0 ? '<a title="' . htmlsafechars($arr_user['username']) . ' '.$lang['invite_open'].'">'.$lang['invite_up'].'</a>' : '<a href="staffpanel.php?tool=invite_tree&amp;action=invite_tree&amp;really_deep=1&amp;id=' . (int)$arr_user['invitedby'] . '" title="go up one level">'.$lang['invite_up'].'</a>') . ' | 
		| <a href="staffpanel.php?tool=invite_tree&amp;action=invite_tree' . (isset($_GET['deeper']) ? '' : '&amp;deeper=1') . '&amp;id=' . $id . '" title=" '.$lang['invite_click'].' ' . (isset($_GET['deeper']) ? $lang['invite_shrink'] : $lang['invite_expand']) . ' '.$lang['invite_this'].' ">'.$lang['invite_expand_tree'].'</a> | 
		| <a href="staffpanel.php?tool=invite_tree&amp;action=invite_tree&amp;really_deep=1&amp;id=' . $id . '" title="'.$lang['invite_click_more'].'">'.$lang['invite_expand_more'].'</a></p>';
    $HTMLOUT.= '<table class="main" width="750px" border="0" cellspacing="0" cellpadding="0">
		<tr><td class="embedded" align="center">';
    //=== members invites
    $rez_invited = sql_query('SELECT id, username, email, uploaded, downloaded, status, warned, suspended, enabled, donor, email, ip, class, chatpost, leechwarn, pirate, king FROM users WHERE invitedby = ' . sqlesc($id) . ' ORDER BY added');
    if (mysqli_num_rows($rez_invited) < 1) $HTMLOUT.= $lang['invite_none'];
    else {
        $HTMLOUT.= '<table width="100%" border="1" cellspacing="0" cellpadding="5">
		<tr><td class="colhead"><span style="font-weight: bold;">'.$lang['invite_username'].'</span></td>
		<td class="colhead"><span style="font-weight: bold;">'.$lang['invite_email'].'</span></td>
		<td class="colhead"><span style="font-weight: bold;">'.$lang['invite_uploaded'].'</span></td>
		<td class="colhead"><span style="font-weight: bold;">'.$lang['invite_downloaded'].'</span></td>
		<td class="colhead"><span style="font-weight: bold;">'.$lang['invite_ratio'].'</span></td>
		<td class="colhead"><span style="font-weight: bold;">'.$lang['invite_status'].'</span></td></tr>';
        while ($arr_invited = mysqli_fetch_assoc($rez_invited)) {
            $deeper = '';
            //=== if  deeper get the invitees invitees
            if (isset($_GET['deeper']) || isset($_GET['really_deep'])) {
                $rez_invited_deeper = sql_query('SELECT id, username, email, uploaded, downloaded, status, warned, suspended, enabled, donor, email, ip, class, chatpost, leechwarn, pirate, king FROM users WHERE invitedby = ' . sqlesc($arr_invited['id']) . ' ORDER BY added');
                if (mysqli_num_rows($rez_invited_deeper) > 0) {
                    $deeper.= '<tr><td  class="two" colspan="6"><span style="font-weight: bold;">' . htmlsafechars($arr_invited['username']) . (substr($arr_invited['username'], -1) == 's' ? '\'' : '\'s') . ''.$lang['invite_invites'].'</span><br />
						<div align="center"><table width="95%" border="1" cellspacing="0" cellpadding="5">
						<tr><td class="colhead"><span style="font-weight: bold;">'.$lang['invite_username'].'</span></td>
						<td class="colhead"><span style="font-weight: bold;">'.$lang['invite_email'].'</span></td>
						<td class="colhead"><span style="font-weight: bold;">'.$lang['invite_uploaded'].'</span></td>
						<td class="colhead"><span style="font-weight: bold;">'.$lang['invite_downloaded'].'</span></td>
						<td class="colhead"><span style="font-weight: bold;">'.$lang['invite_ratio'].'</span></td>
						<td class="colhead"><span style="font-weight: bold;">'.$lang['invite_status'].'</span></td></tr>';
                    while ($arr_invited_deeper = mysqli_fetch_assoc($rez_invited_deeper)) {
                        $really_deep = '';
                        //=== if  really_deep get the invitees invitees invitees
                        if (isset($_GET['really_deep'])) {
                            $rez_invited_really_deep = sql_query('SELECT id, username, email, uploaded, downloaded, status, warned, suspended, enabled, donor, email, ip, class, chatpost, leechwarn, pirate, king FROM users WHERE invitedby = ' . sqlesc($arr_invited_deeper['id']) . ' ORDER BY added');
                            if (mysqli_num_rows($rez_invited_really_deep) > 0) {
                                $really_deep.= '<tr><td  class="one" colspan="6"><span style="font-weight: bold;">' . htmlsafechars($arr_invited_deeper['username']) . (substr($arr_invited_deeper['username'], -1) == 's' ? '\'' : '\'s') . ' Invites:</span><br />
										<div align="center"><table width="95%" border="1" cellspacing="0" cellpadding="5">
										<tr><td class="colhead"><span style="font-weight: bold;">'.$lang['invite_username'].'</span></td>
										<td class="colhead"><span style="font-weight: bold;">'.$lang['invite_email'].'</span></td>
										<td class="colhead"><span style="font-weight: bold;">'.$lang['invite_uploaded'].'</span></td>
										<td class="colhead"><span style="font-weight: bold;">'.$lang['invite_downloaded'].'</span></td>
										<td class="colhead"><span style="font-weight: bold;">'.$lang['invite_ratio'].'</span></td>
										<td class="colhead"><span style="font-weight: bold;">'.$lang['invite_status'].'</span></td></tr>';
                                while ($arr_invited_really_deep = mysqli_fetch_assoc($rez_invited_really_deep)) {
                                    $really_deep.= '<tr><td class="one">' . ($arr_invited_really_deep['status'] == 'pending' ? htmlsafechars($arr_invited_really_deep['username']) : format_username($arr_invited_really_deep) . '<br />' . $arr_invited_really_deep['ip']) . '
											</td><td class="one">' . htmlsafechars($arr_invited_really_deep['email']) . '</td>
											<td class="one">' . mksize($arr_invited_really_deep['uploaded']) . '</td>
											<td class="one">' . mksize($arr_invited_really_deep['downloaded']) . '</td>
											<td class="one">' . member_ratio($arr_invited_really_deep['uploaded'], $arr_invited_really_deep['downloaded']) . '</td>
											<td class="one">' . ($arr_invited_really_deep['status'] == 'confirmed' ? '<span style="color: green;">'.$lang['invite_confirmed'].'</span></td></tr>' : '<span style="color: red;">'.$lang['invite_pending'].'</span></td></tr>');
                                }
                                $really_deep.= '</td></tr></table></div>';
                            }
                        }
                        $deeper.= '<tr><td class="two">' . ($arr_invited_deeper['status'] == 'pending' ? htmlsafechars($arr_invited_deeper['username']) : format_username($arr_invited_deeper) . '<br />' . $arr_invited_deeper['ip']) . '</td>
	`						<td class="two">' . htmlsafechars($arr_invited_deeper['email']) . '</td>
							<td class="two">' . mksize($arr_invited_deeper['uploaded']) . '</td>
							<td class="two">' . mksize($arr_invited_deeper['downloaded']) . '</td>
							<td class="two">' . member_ratio($arr_invited_deeper['uploaded'], $arr_invited_deeper['downloaded']) . '</td>
							<td class="two">' . ($arr_invited_deeper['status'] == 'confirmed' ? '<span style="color: green;">'.$lang['invite_confirmed'].'</span></td></tr>' : '<span style="color: red;">'.$lang['invite_pending'].'</span></td></tr>');
                    }
                    $deeper.= (isset($_GET['really_deep']) ? $really_deep . '</table></div>' : '</td></tr></table></div>');
                }
            }
            $HTMLOUT.= '<tr><td>' . ($arr_invited['status'] == 'pending' ? htmlsafechars($arr_invited['username']) : format_username($arr_invited) . '<br />' . $arr_invited['ip']) . '</td>
			<td>' . htmlsafechars($arr_invited['email']) . '</td>
			<td>' . mksize($arr_invited['uploaded']) . '</td>
			<td>' . mksize($arr_invited['downloaded']) . '</td>
			<td>' . member_ratio($arr_invited['uploaded'], $arr_invited['downloaded']) . '</td>
			<td>' . ($arr_invited['status'] == 'confirmed' ? '<span style="color: green;">'.$lang['invite_confirmed'].'</span></td></tr>' : '<span style="color: red;">'.$lang['invite_pending'].'</span></td></tr>');
            $HTMLOUT.= $deeper;
        }
        $HTMLOUT.= '</table>';
    }
    $HTMLOUT.= '</td></tr></table>';
} else {
    //=== ok, that was fun, but if no ID we can search members to see their invite trees \\o\o/o//
    $id = '';
    //=== search members
    $search = isset($_GET['search']) ? strip_tags(trim($_GET['search'])) : '';
    $class = isset($_GET['class']) ? $_GET['class'] : '-';
    $letter = '';
    $q = '';
    if ($class == '-' || !ctype_digit($class)) $class = '';
    if ($search != '' || $class) {
        $query = 'username LIKE ' . sqlesc("%$search%") . ' AND status=\'confirmed\'';
        if ($search) $q = 'search=' . htmlsafechars($search);
    } else {
        $letter = isset($_GET['letter']) ? trim((string)$_GET['letter']) : '';
        if (strlen($letter) > 1) die;
        if ($letter == '' || strpos('abcdefghijklmnopqrstuvwxyz0123456789', $letter) === false) $letter = '';
        $query = 'username LIKE ' . sqlesc("$letter%") . ' AND status=\'confirmed\'';
        $q = 'letter=' . $letter;
    }
    if (ctype_digit($class)) {
        $query.= ' AND class=' . sqlesc($class);
        $q.= ($q ? '&amp;' : '') . 'class=' . $class;
    }
    //=== start the page
    $HTMLOUT.= '<h1>'.$lang['invite_search'].'</h1>
			<form method="get" action="staffpanel.php?tool=invite_tree&amp;search=1&amp;">
			<input type="hidden" name="action" value="invite_tree"/>
			<input type="text" size="30" name="search" value="' . $search . '"/>
			<select name="class">
			<option value="-">'.$lang['invite_any'].'</option>';
    for ($i = 0;; ++$i) {
        if ($c = get_user_class_name($i)) $HTMLOUT.= '<option value="' . $i . '"' . (ctype_digit($class) && $class == $i ? ' selected="selected"' : '') . '>' . $c . '</option>';
        else break;
    }
    $HTMLOUT.= '</select>
			<input type="submit" value="'.$lang['invite_btn'].'" class="btn" />
			</form>
			<br /><br />';
    $aa = range('0', '9');
    $bb = range('a', 'z');
    $cc = array_merge($aa, $bb);
    unset($aa, $bb);
    $HTMLOUT.= '<div align="center">';
    $count = 0;
    foreach ($cc as $L) {
        $HTMLOUT.= ($count == 10) ? '<br /><br />' : '';
        if (!strcmp($L, $letter)) $HTMLOUT.= ' <span class="btn" style="background:orange;">' . strtoupper($L) . '</span>';
        else $HTMLOUT.= ' <a href="staffpanel.php?tool=invite_tree&amp;action=invite_tree&amp;letter=' . $L . '"><span class="btn">' . strtoupper($L) . '</span></a>';
        $count++;
    }
    $HTMLOUT.= '</div><br />';
    //=== get stuff for the pager
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 0;
    $perpage = isset($_GET['perpage']) ? (int)$_GET['perpage'] : 20;
    $res_count = sql_query('SELECT COUNT(id) FROM users WHERE ' . $query);
    $arr_count = mysqli_fetch_row($res_count);
    $count = ($arr_count[0] > 0 ? $arr_count[0] : 0);
    list($menu, $LIMIT) = pager_new($count, $perpage, $page, 'staffpanel.php?tool=invite_tree&amp;action=invite_tree');
    $HTMLOUT.= ($arr_count[0] > $perpage) ? '' . $menu . '<br /><br />' : '<br /><br />';
    if ($arr_count[0] > 0) {
        $res = sql_query('SELECT users.*, countries.name, countries.flagpic FROM users FORCE INDEX ( username ) LEFT JOIN countries ON country = countries.id WHERE ' . $query . ' ORDER BY username ' . $LIMIT);
        $HTMLOUT.= '<table border="1" cellspacing="0" cellpadding="5">

			<tr><td class="colhead" align="left">'.$lang['invite_search_user'].'</td>
			<td class="colhead">'.$lang['invite_search_reg'].'</td>
			<td class="colhead">'.$lang['invite_search_la'].'</td>
			<td class="colhead" align="left">'.$lang['invite_search_class'].'</td>
			<td class="colhead">'.$lang['invite_search_country'].'</td>
			<td class="colhead">'.$lang['invite_search_edit'].'</td></tr>';
        while ($row = mysqli_fetch_assoc($res)) {
            $country = ($row['name'] != NULL) ? '<td style="padding: 0px" align="center"><img src="' . $INSTALLER09['pic_base_url'] . 'flag/' . (int)$row['flagpic'] . '" alt="' . htmlsafechars($row['name']) . '" /></td>' : '<td align="center">---</td>';
            $HTMLOUT.= '<tr><td align="left">' . format_username($row) . '</td>
		<td>' . get_date($row['added'], '') . '</td><td>' . get_date($row['last_access'], '') . '</td>
		<td align="left">' . get_user_class_name($row['class']) . '</td>
		' . $country . '
		<td align="center">
		<a href="staffpanel.php?tool=invite_tree&amp;action=invite_tree&amp;id=' . (int)$row['id'] . '" title="'.$lang['invite_search_look'].'"><span class="btn">'.$lang['invite_search_view'].'</span></a></td></tr>';
        }
        $HTMLOUT.= '</table>';
    } else $HTMLOUT.= $lang['invite_search_none'];
    $HTMLOUT.= ($arr_count[0] > $perpage) ? '<br />' . $menu . '' : '<br /><br />';
}
echo stdhead($lang['invite_stdhead']) . $HTMLOUT . stdfoot();
?>
