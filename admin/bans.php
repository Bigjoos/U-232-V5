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
require_once (INCL_DIR . 'pager_functions.php');
require_once (CLASS_DIR . 'class_check.php');
$class = get_access(basename($_SERVER['REQUEST_URI']));
class_check($class);
$lang = array_merge($lang, load_language('ad_bans'));
$remove = isset($_GET['remove']) ? (int)$_GET['remove'] : 0;
if ($remove > 0) {
    $banned = sql_query('SELECT first, last FROM bans WHERE id = ' . sqlesc($remove)) or sqlerr(__FILE__, __LINE__);
    if (!mysqli_num_rows($banned)) stderr($lang['stderr_error'], $lang['stderr_error1']);
    $ban = mysqli_fetch_assoc($banned);
    $first = 0 + $ban['first'];
    $last = 0 + $ban['last'];
    for ($i = $first; $i <= $last; $i++) {
        $ip = long2ip($i);
        $mc1->delete_value('bans:::' . $ip);
    }
    if (is_valid_id($remove)) {
        sql_query("DELETE FROM bans WHERE id=" . sqlesc($remove)) or sqlerr(__FILE__, __LINE__);
        $removed = sprintf($lang['text_banremoved'], $remove);
        write_log("{$removed}" . $CURUSER['id'] . " (" . $CURUSER['username'] . ")");
    }
}
if ($_SERVER["REQUEST_METHOD"] == "POST" && $CURUSER['class'] == UC_MAX) {
    $first = trim($_POST["first"]);
    $last = trim($_POST["last"]);
    $comment = htmlsafechars(trim($_POST["comment"]));
    if (!$first || !$last || !$comment) stderr("{$lang['stderr_error']}", "{$lang['text_missing']}");
    $first = ip2long($first);
    $last = ip2long($last);
    if ($first == - 1 || $first === FALSE || $last == - 1 || $last === FALSE) stderr("{$lang['stderr_error']}", "{$lang['text_badip.']}");
    $added = TIME_NOW;
    for ($i = $first; $i <= $last; $i++) {
        $key = 'bans:::' . long2ip($i);
        $mc1->delete_value($key);
    }
    sql_query("INSERT INTO bans (added, addedby, first, last, comment) VALUES($added, " . sqlesc($CURUSER['id']) . ", " . sqlesc($first) . ", " . sqlesc($last) . ", " . sqlesc($comment) . ")") or sqlerr(__FILE__, __LINE__);
    header("Location: {$INSTALLER09['baseurl']}/staffpanel.php?tool=bans");
    die;
}
$bc = sql_query('SELECT COUNT(*) FROM bans') or sqlerr(__FILE__, __LINE__);
$bcount = mysqli_fetch_row($bc);
$count = $bcount[0];
$perpage = 15;
$pager = pager($perpage, $count, 'staffpanel.php?tool=bans&amp;');
$res = sql_query("SELECT b.*, u.username FROM bans b LEFT JOIN users u on b.addedby = u.id ORDER BY added DESC {$pager['limit']}") or sqlerr(__FILE__, __LINE__);
$HTMLOUT = '';
$HTMLOUT.= "<div class='row'><div class='col-md-12'>";
$HTMLOUT.= "<h1>{$lang['text_current']}</h1>\n";
if (mysqli_num_rows($res) == 0) {
    $HTMLOUT.= "<p align='center'><b>{$lang['text_nothing']}</b></p>\n";
} else {
    if ($count > $perpage) $HTMLOUT.= $pager['pagertop'];
    $HTMLOUT.= "<br />
      <table class='table table-bordered'>\n";
    $HTMLOUT.= "<tr>
        <td class='colhead'>{$lang['header_added']}</td><td class='colhead' align='left'>{$lang['header_firstip']}</td>
        <td class='colhead' align='left'>{$lang['header_lastip']}</td>
        <td class='colhead' align='left'>{$lang['header_by']}</td>
        <td class='colhead' align='left'>{$lang['header_comment']}</td>
        <td class='colhead'>{$lang['header_remove']}</td>
      </tr>\n";
    while ($arr = mysqli_fetch_assoc($res)) {
        $arr["first"] = long2ip($arr["first"]);
        $arr["last"] = long2ip($arr["last"]);
        $HTMLOUT.= "<tr>
          <td>" . get_date($arr['added'], '') . "</td>
          <td align='left'>" . htmlsafechars($arr['first']) . "</td>
          <td align='left'>" . htmlsafechars($arr['last']) . "</td>
          <td align='left'><a href='userdetails.php?id=" . (int)$arr['addedby'] . "'>" . htmlsafechars($arr['username']) . "</a></td>
          <td align='left'>" . htmlsafechars($arr['comment'], ENT_QUOTES) . "</td>
          <td><a href='staffpanel.php?tool=bans&amp;remove=" . (int)$arr['id'] . "'>{$lang['text_remove']}</a></td>
         </tr>\n";
    }
    $HTMLOUT.= "</table>\n";
$HTMLOUT .="</div></div>";
    if ($count > $perpage) $HTMLOUT.= $pager['pagerbottom'];
}
if ($CURUSER['class'] == UC_MAX) {
	$HTMLOUT .="<div class='row'><div class='col-md-12'>";
    $HTMLOUT.= "<h2>{$lang['text_addban']}</h2>
      <form method='post' action='staffpanel.php?tool=bans'>
      <table class='table table-bordered'>
      <tr><td class='rowhead'>{$lang['table_firstip']}</td>
      <td><input type='text' name='first' size='40' /></td>
      </tr>
      <tr>
      <td class='rowhead'>{$lang['table_lastip']}</td>
      <td><input type='text' name='last' size='40' /></td>
      </tr>
      <tr>
      <td class='rowhead'>{$lang['table_comment']}</td><td><input type='text' name='comment' size='40' /></td>
      </tr>
      <tr>
      <td colspan='2' align='center'><input type='submit' name='okay' value='{$lang['btn_add']}' class='btn' /></td>
      </tr>
      </table>
      </form>";
 	$HTMLOUT .="</div></div>";
}
echo stdhead("{$lang['stdhead_adduser']}") . $HTMLOUT . stdfoot();
?>
