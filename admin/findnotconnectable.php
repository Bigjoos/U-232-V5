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
require_once (INCL_DIR . 'torrenttable_functions.php');
require_once (CLASS_DIR . 'class_check.php');
$class = get_access(basename($_SERVER['REQUEST_URI']));
class_check($class);
$lang = array_merge($lang, load_language('non_con'));
$HTMLOUT = '';
if (isset($_GET["action1"]) && htmlsafechars($_GET["action1"]) == "list") {
    $res2 = sql_query("SELECT userid, seeder, torrent, agent FROM peers WHERE connectable='no' ORDER BY userid DESC") or sqlerr(__FILE__, __LINE__);
    $HTMLOUT.= "<h3><a href='staffpanel.php?tool=findnotconnectable&amp;action=findnotconnectable&amp;action1=sendpm'>{$lang['non_con_sendall']}</a></h3>
	<h3><a href='staffpanel.php?tool=findnotconnectable&amp;action=findnotconnectable'>{$lang['non_con_view']}</a></h3>
	<h1>{$lang['non_con_peers']}</h1>
	{$lang['non_con_this']}<br /><p><font color='red'>*</font> {$lang['non_con_means']}<br />";
    $result = sql_query("select distinct userid from peers where connectable = 'no'");
    $count = mysqli_num_rows($result);
    $HTMLOUT.= "$count {$lang['non_con_unique']}</p>";
    @((mysqli_free_result($result) || (is_object($result) && (get_class($result) == "mysqli_result"))) ? true : false);
    if (mysqli_num_rows($res2) == 0) $HTMLOUT.= "<p align='center'><b>{$lang['non_con_all']}</b></p>\n";
    else {
        $HTMLOUT.= "<div class='row'><div class='col-md-12'><table class='table table-bordered'>\n";
        $HTMLOUT.= "<tr><td class='colhead'>{$lang['non_con_name']}</td><td class='colhead'>{$lang['non_con_tor']}</td><td class='colhead'>{$lang['non_con_client']}</td></tr>\n";
        while ($arr2 = mysqli_fetch_assoc($res2)) {
            $r2 = sql_query("SELECT username FROM users WHERE id=" . sqlesc($arr2['userid'])) or sqlerr(__FILE__, __LINE__);
            $a2 = mysqli_fetch_assoc($r2);
            $HTMLOUT.= "<tr><td><a href='userdetails.php?id=" . (int)$arr2['userid'] . "'>" . htmlsafechars($a2['username']) . "</a></td><td align='left'><a href='details.php?id=" . (int)$arr2['torrent'] . "&amp;dllist=1#seeders'>" . (int)$arr2['torrent'] . "</a>";
            if ($arr2['seeder'] == 'yes') $HTMLOUT.= "<font color='red'>*</font>";
            $HTMLOUT.= "</td><td align='left'>" . htmlsafechars($arr2['agent']) . "</td></tr>\n";
        }
        $HTMLOUT.= "</table></div></div>\n";
    }
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $dt = TIME_NOW;
    $msg = htmlsafechars($_POST['msg']);
    if (!$msg) stderr("Error", "Please Type In Some Text");
    $query = sql_query("SELECT distinct userid FROM peers WHERE connectable='no'");
    while ($dat = mysqli_fetch_assoc($query)) {
        $subject = "Connectability";
        sql_query("INSERT INTO messages (sender, receiver, added, msg, subject) VALUES (0, " . sqlesc($dat['userid']) . ", " . sqlesc(TIME_NOW) . ", " . sqlesc($msg) . ", " . sqlesc($subject) . ")") or sqlerr(__FILE__, __LINE__);
    }
    sql_query("INSERT INTO notconnectablepmlog (user, date) VALUES (" . sqlesc($CURUSER['id']) . ", " . sqlesc($dt) . ")") or sqlerr(__FILE__, __LINE__);
    header("Refresh: 0; url=staffpanel.php?tool=findnotconnectable");
}
if (isset($_GET["action1"]) && htmlsafechars($_GET["action1"]) == "sendpm") {
    $HTMLOUT.= "<div class='row'><div class='col-md-12'><table class='table table-bordered'><tr><td class='embedded'>
<div align='center'>
<h1>{$lang['non_con_mass']}</h1>
<form method='post' action='staffpanel.php?tool=findnotconnectable&amp;action=findnotconnectable'>";
    if (isset($_GET["returnto"]) || isset($_SERVER["HTTP_REFERER"])) {
        $HTMLOUT.= "<input type='hidden' name='returnto' value='" . (isset($_GET["returnto"]) ? htmlsafechars($_GET["returnto"]) : htmlsafechars($_SERVER["HTTP_REFERER"])) . "' />";
    }
    $receiver = '';
    // default message
    $body = "{$lang['non_con_body']}";
    $HTMLOUT.= "<table class='table table-bordered'>
<tr>
<td>{$lang['non_con_sendall']}<br />
<table class='table table-bordered'>
<tr>
<td style='border: 0'>&nbsp;</td>
<td style='border: 0'>&nbsp;</td>
</tr>
</table>
</td>
</tr>
<tr><td><textarea name='msg' cols='120' rows='15'>$body</textarea></td></tr>

<tr><td colspan='2' align='center'><input type='submit' value='Send' class='btn'/></td></tr>
</table>
<input type='hidden' name='receiver' value='$receiver'/>
</form>
</div></td></tr></table></div></div>
<br />
NOTE: No HTML Code Allowed. (NO HTML)
";
}
if (isset($_GET["action1"]) == "") {
    $getlog = sql_query("SELECT * FROM `notconnectablepmlog` ORDER BY date DESC LIMIT 20") or sqlerr(__FILE__, __LINE__);
    $HTMLOUT.= "<div class='row'><div class='col-md-12'><h1>{$lang['non_con_uncon']}</h1>
	<h3><a href='staffpanel.php?tool=findnotconnectable&amp;action=findnotconnectable&amp;action1=sendpm'>{$lang['non_con_sendall']}</a></h3>
	<h3><a href='staffpanel.php?tool=findnotconnectable&amp;action=findnotconnectable&amp;action1=list'>{$lang['non_con_list']}</a></h3><p>
	<br />{$lang['non_con_please1']}<br /></p>
	<table class='table table-bordered'>\n
	<tr><td class='colhead'>{$lang['non_con_by']}</td>
	<td class='colhead'>{$lang['non_con_date']}</td><td class='colhead'>{$lang['non_con_elapsed']}</td></tr>";
    while ($arr2 = mysqli_fetch_assoc($getlog)) {
        $r2 = sql_query("SELECT username FROM users WHERE id=" . sqlesc($arr2['user'])) or sqlerr(__FILE__, __LINE__);
        $a2 = mysqli_fetch_assoc($r2);
        $elapsed = get_date($arr2['date'], '', 0, 1);
        $HTMLOUT.= "<tr><td class='colhead'><a href='userdetails.php?id=" . (int)$arr2['user'] . "'>" . htmlsafechars($a2['username']) . "</a></td><td class='colhead'>" . get_date($arr2['date'], '') . "</td><td>$elapsed</td></tr>";
    }
    $HTMLOUT.= "</table></div></div>";
}
echo stdhead() . $HTMLOUT . stdfoot();
die();
?>
