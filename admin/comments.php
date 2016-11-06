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
require_once (CLASS_DIR . 'class_check.php');
$class = get_access(basename($_SERVER['REQUEST_URI']));
class_check($class);
//==== Load Languages
$lang = array_merge($lang, load_language('ad_comments'));
$view = isset($_GET['view']) ? htmlsafechars($_GET['view']) : '';
switch($view) {
//==== Page: View all comments
case "allComments":
        $sql = "SELECT c.id, c.user, c.torrent, c.text, c.ori_text, c.added, t.name, u.username " .
        "FROM comments AS c " .
        "JOIN users AS u ON u.id = c.user " .
        "JOIN torrents AS t ON  c.torrent = t.id " .
        "ORDER BY c.id DESC";
        
        $query = sql_query("{$sql}");
        $rows = mysqli_num_rows($query);

        $Row_Count = 0;

        //==== HTML Output
	$HTMLOUT = "<div class='row'><div class='col-md-12'><h3><a href='staffpanel.php?tool=comments'>{$lang['text_overview']}</a>" .
        " - <a href='staffpanel.php?tool=comments&amp;view=allComments'>{$lang['text_all']}</a>" .
        " - <a href='staffpanel.php?tool=comments&amp;view=search'>{$lang['text_search']}</a>" .
        "</h3>" . 
        "<hr class='separator' />" . 
        "<br />" . 
        "<table class='table table-bordered'>" . 
        "<tr><td align='center' colspan='9'><strong><em>{$lang['text_all_comm']}</em></strong></td></tr>" . 
        "<tr>" . 
        "<td class='colhead'>{$lang['text_comm_id']}</td>" . 
        "<td class='colhead'>{$lang['text_user_id']}</td>" . 
        "<td class='colhead'>{$lang['text_torr_id']}</td>" . 
        "<td class='colhead'>{$lang['text_comm']}</td>" . 
        "<td class='colhead'>{$lang['text_comm_ori']}</td>" . 
        "<td class='colhead'>{$lang['text_user']}</td>" . 
        "<td class='colhead'>{$lang['text_torr']}</td>" . 
        "<td class='colhead'>{$lang['text_added']}</td>" . 
        "<td class='colhead'>{$lang['text_actions']}</td>" . 
        "</tr>";

        while($comment = mysqli_fetch_assoc($query)) {
                //==== Begin an array that will sanitize all the variables from the MySQLI query
                $comment = array(
                        'user' => (int) $comment['user'],
                        'torrent' => (int) $comment['torrent'],
                        'id' => (int) $comment['id'],
                        'text' => htmlsafechars($comment['text']),
                        'ori_text' => htmlsafechars($comment['ori_text']),
                        'username' => htmlsafechars($comment['username']),
                        'name' => htmlsafechars($comment['name']),
                        'added' => (int) $comment['added']
                );
                //==== Alternate colors in table rows generated using MySQLI
                $Row_Class = $Row_Count % 2 ? 'regular' : 'alternate';

                //==== HTML Output
                $HTMLOUT .= "<tr class='{$Row_Class}'>" . 
                "<td><a href='./details.php?id={$comment['torrent']}#comm{$comment['id']}'>{$comment['id']}</a>" . 
                " (<a href='./comment.php?action=vieworiginal&amp;cid={$comment['id']}'>{$lang['text_view_ori_comm']}</a>)</td>" . 
                "<td>{$comment['user']}</td>" . 
                "<td>{$comment['torrent']}</td>" . 
                "<td>{$comment['text']}</td>" . 
                "<td>{$comment['ori_text']}</td>" . 
                "<td><a href='./userdetails.php?id={$comment['user']}'>{$comment['username']}</a>" . 
                " [<a href='./pm_system.php?action=send_message&amp;receiver={$comment['user']}'>{$lang['text_msg']}</a>]</td>" . 
                "<td><a href='./details.php?id={$comment['torrent']}'>{$comment['name']}</a></td>" . 
                "<td>" . get_date($comment['added'], 'DATE') . "</td>" . 
                "<td><a href='./comment.php?action=edit&amp;cid={$comment['id']}'>{$lang['text_edit']}</a>" . 
                " - <a href='./comment.php?action=delete&amp;cid={$comment['id']}'>{$lang['text_delete']}</a></td>" . 
                "</tr>";

                //==== Increase the count for every row generated
                $Row_Count++;
        }

        if($rows == 0)
                //==== Display an error if there are no rows in the MySQLI table
                $HTMLOUT .= "<tr><td align='center' colspan='9'>{$lang['text_no_rows']}</td></tr>";

        $HTMLOUT .= "</table></div></div>";
	//==== Display Everything
        echo stdhead("{$lang['text_all_comm']}") . $HTMLOUT . stdfoot();
exit();
break;

//==== Page: Search
case "search":
	$HTMLOUT = "<div class='row'><div class='col-md-12'>";
        $HTMLOUT = "<form method='post' action='staffpanel.php?tool=comments&amp;view=results'>" . 
        "<table class='table table-bordered'>" . 
        "<tr>" . 
        "<td align='center' class='colhead' colspan='2'>{$lang['text_search']}</td>" . 
        "</tr>" . 
        "<tr><td align='right'>{$lang['text_keywords']}</td><td><input type='text' name='keywords' size='40' /></td></tr>" . 
        "<tr><td align='center' colspan='2'><input type='submit' value='{$lang['text_submit']}' /></td></tr>" . 
        "</table>" . 
        "</form>";
	$HTMLOUT .= "</div></div>";
        //==== Display Everything
        echo stdhead("{$lang['text_search']}") . $HTMLOUT . stdfoot();
exit();
break;

//==== Page: Search Results
case "results":
        $sql = "SELECT c.id, c.user, c.torrent, c.text, c.added, t.name, u.username " .
        "FROM comments AS c " .
        "JOIN users AS u ON u.id = c.user " .
        "JOIN torrents AS t ON c.torrent = t.id " .
        "WHERE c.text LIKE " . sqlesc("%{$_POST['keywords']}%") .
        "ORDER BY c.added DESC";

        $query = sql_query("{$sql}") or sqlerr(__FILE__, __LINE__);
        $rows = mysqli_num_rows($query);

        $Row_Count = 0;

        //==== HTML Output
	$HTMLOUT = "<div class='row'><div class='col-md-12'><table class='table table-bordered'>" .
        "<tr><td align='center' colspan='8'><strong><em>{$lang['text_results']} " . htmlsafechars($_POST['keywords']) . "</em>" .
        "</strong></td></tr>" .
        "<tr><td class='colhead'>{$lang['text_comm_id']}</td>" .
        "<td class='colhead'>{$lang['text_user_id']}</td>" .
        "<td class='colhead'>{$lang['text_torr_id']}</td>" .
        "<td class='colhead'>{$lang['text_comm']}</td>" .
        "<td class='colhead'>{$lang['text_user']}</td>" .
        "<td class='colhead'>{$lang['text_torr']}</td>" .
        "<td class='colhead'>{$lang['text_added']}</td>" .
        "<td class='colhead'>{$lang['text_actions']}</td>" .
        "</tr>";

        while($comment = mysqli_fetch_assoc($query)) {
                //==== Begin an array that will sanitize all variables from the MySQLI query
                $comment = array(
                        'id' => (int) $comment['id'],
                        'user' => (int) $comment['user'],
                        'torrent' => (int) $comment['torrent'],
                        'text' => htmlsafechars($comment['text']),
                        'added' => (int) $comment['added'],
                        'name' => htmlsafechars($comment['name']),
                        'username' => htmlsafechars($comment['username'])
                );

                //==== Alternate colors in table rows generated using MySQLI
                $Row_Class = $Row_Count % 2 ? 'regular' : 'alternate';

                //==== HTML Output
                $HTMLOUT .= "<tr class='{$Row_Class}'>" .
                "<td>{$comment['id']}</td>" .
                "<td>{$comment['user']}</td>" .
                "<td>{$comment['torrent']}</td>" .
                "<td>{$comment['text']}</td>" .
                "<td><a href='./userdetails.php?id={$comment['user']}'>{$comment['username']}</a></td>" .
                "<td><a href='./details.php?id={$comment['torrent']}'>{$comment['name']}</a></td>" .
                "<td>" . get_date($comment['added'], "DATE") . "</td>" .
                "<td><a href='./comment.php?action=edit&amp;cid={$comment['id']}'>{$lang['text_edit']}</a>" .
                " - <a href='./comment.php?action=delete&amp;cid={$comment['id']}'>{$lang['text_delete']}</a>" .
                "</td></tr>";
                $Row_Count++;
        }

        $HTMLOUT .= "</table></div></div>";
	//==== Display Everything
        echo stdhead("{$lang['text_results']}{$_POST['keywords']}") . $HTMLOUT . stdfoot();
exit();
break;
}

//==== Begin the main page
$sql = "SELECT c.id, c.user, c.torrent, c.text, c.ori_text, c.added, c.checked_by, c.checked_when, t.name, u.username " .
"FROM comments AS c " .
"JOIN users AS u ON u.id = c.user " .
"JOIN torrents AS t ON  c.torrent = t.id " .
"ORDER BY c.id DESC " .
"LIMIT 10";

$query = sql_query("{$sql}");
$rows = mysqli_num_rows($query);
$Row_Count = 0;

//==== HTML Output
$HTMLOUT = "<div class='row'><div class='col-md-12'><h3><a href='staffpanel.php?tool=comments'>{$lang['text_overview']}</a>" .
" - <a href='staffpanel.php?tool=comments&amp;view=allComments'>{$lang['text_all']}</a>" .
" - <a href='staffpanel.php?tool=comments&amp;view=search'>{$lang['text_search']}</a>" .
"</h3>" .
"<hr class='separator' />" .
"<br />" .
"<table class='table table-bordered'>" .
"<tr><td align='center' colspan='9'><strong><em>{$lang['text_recent']}</em></strong></td></tr>" .
"<tr>" .
"<td class='colhead'>{$lang['text_comm_id']}</td>" .
"<td class='colhead'>{$lang['text_user_id']}</td>" .
"<td class='colhead'>{$lang['text_torr_id']}</td>" .
"<td class='colhead'>{$lang['text_comm']}</td>" .
"<td class='colhead'>{$lang['text_comm_ori']}</td>" .
"<td class='colhead'>{$lang['text_user']}</td>" .
"<td class='colhead'>{$lang['text_torr']}</td>" .
"<td class='colhead'>{$lang['text_added']}</td>" .
"<td class='colhead'>{$lang['text_actions']}</td>" .
"</tr>";

while($comment = mysqli_fetch_assoc($query)) {
        //==== Begin an array that will sanitize all the variables from the MySQLI query
        $comment = array(
                'user' => (int) $comment['user'],
                'torrent' => (int) $comment['torrent'],
                'id' => (int) $comment['id'],
                'text' => htmlsafechars($comment['text']),
                'ori_text' => htmlsafechars($comment['ori_text']),
                'username' => htmlsafechars($comment['username']),
                'name' => htmlsafechars($comment['name']),
                'added' => (int) $comment['added']
        );
        //==== Alternate colors in table rows generated using MySQLI
        $Row_Class = $Row_Count % 2 ? 'regular' : 'alternate';

        //==== HTML Output
        $HTMLOUT .= "<tr class='{$Row_Class}'>" .
        "<td><a href='./details.php?id={$comment['torrent']}#comm{$comment['id']}'>{$comment['id']}</a>" .
        " (<a href='./comment.php?action=vieworiginal&amp;cid={$comment['id']}'>{$lang['text_view_ori_comm']}</a>)</td>" .
        "<td>{$comment['user']}</td>" .
        "<td>{$comment['torrent']}</td>" .
        "<td>{$comment['text']}</td>" .
        "<td>{$comment['ori_text']}</td>" .
        "<td><a href='./userdetails.php?id={$comment['user']}'>{$comment['username']}</a> " .
        "[<a href='./pm_system.php?action=send_message&amp;receiver={$comment['user']}'>{$lang['text_msg']}</a>]</td>" .
        "<td><a href='./details.php?id={$comment['torrent']}'>{$comment['name']}</a></td>" .
        "<td>" . get_date($comment['added'], 'DATE') . "</td>" .
        "<td><a href='./comment.php?action=edit&amp;cid={$comment['id']}'>{$lang['text_edit']}</a>" .
        " - <a href='./comment.php?action=delete&amp;cid={$comment['id']}'>{$lang['text_delete']}</a></td>" .
        "</tr>";
        

        //==== Increase the count for every row generated
        $Row_Count++;
}

if($rows == 0)
        //==== Show an error if there are no rows in the MySQLI table
        $HTMLOUT .= "<tr><td align='center' colspan='9'>{$lang['text_no_rows']}</td></tr>";

$HTMLOUT .= "</table></div></div>";
//==== Display Everything
echo stdhead("{$lang['text_overview']}") . $HTMLOUT . stdfoot();
?>
