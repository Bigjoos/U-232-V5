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
require_once INCL_DIR . 'bbcode_functions.php';
dbconn(false);
loggedinorreturn();
$lang = array_merge(load_language('global'),load_language('announce_history'));
$action = (isset($_GET['action']) ? htmlsafechars($_GET['action']) : '');
$HTMLOUT = "";
$HTMLOUT.= "<table class='table table-bordered'>
<tr>
<td>
<h2 class='text-center'>{$lang['annhistory_ann']}</h2>";
$query1 = sprintf('SELECT m.main_id, m.subject, m.body FROM announcement_main AS m ' . 'LEFT JOIN announcement_process AS p ' . 'ON m.main_id = p.main_id AND p.user_id = %s ' . 'WHERE p.status = 2', sqlesc($CURUSER['id']));
$result = sql_query($query1);
$ann_list = array();
while ($x = mysqli_fetch_array($result)) $ann_list[] = $x;
unset($x);
unset($result);
reset($ann_list);
if ($action == 'read_announce') {
    $id = (isset($_GET['id']) ? (int)$_GET['id'] : 0);
    if (!is_int($id)) {
        $HTMLOUT.= stdmsg($lang['annhistory_error'], $lang['annhistory_invalid']);
        echo stdhead($lang['annhistory_ann']) . $HTMLOUT . stdfoot();
        die();
    }
    foreach ($ann_list AS $x) if ($x[0] == $id) list(, $subject, $body) = $x;
    if (empty($subject) OR empty($body)) {
        $HTMLOUT.= stdmsg($lang['annhistory_error'], $lang['annhistory_not']);
        echo stdhead($lang['annhistory_ann']) . $HTMLOUT . stdfoot();
        die();
    }
    $HTMLOUT.= "<table class='table table-bordered'>
 	<tr>
 	<td bgcolor='orange'>{$lang['annhistory_subject']}<b>" . htmlsafechars($subject) . "</b></td>
 	</tr>
 	<tr>
 	<td bgcolor='#333333'>" . format_comment($body) . "</td>
 	</tr>
 	<tr>
 	<td>
 	<a href='" . $_SERVER['PHP_SELF'] . "'>{$lang['annhistory_back']}</a>
 	</td>
 	</tr>
 	</table>";
}
$HTMLOUT.= "<table class='table table-bordered'>
<tr>
<td class='text-center' bgcolor='orange'><b>{$lang['annhistory_subject1']}</b></td>
</tr>";
foreach ($ann_list AS $x) $HTMLOUT.= "<tr><td align='center'><a href='?action=read_announce&amp;id=" . (int)$x[0] . "'>" . htmlsafechars($x[1]) . "</a></td></tr>\n";
$HTMLOUT.= "</table>";
$HTMLOUT.= "</td></tr></table>";
echo stdhead($lang['annhistory_ann']) . $HTMLOUT . stdfoot();
?>
