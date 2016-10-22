<?php
/**
 |--------------------------------------------------------------------------|
 |   https://github.com/Bigjoos/                			    |
 |--------------------------------------------------------------------------|
 |   Licence Info: GPL			                                    |
 |--------------------------------------------------------------------------|
 |   Copyright (C) 2010 U-232 V5					    |
 |--------------------------------------------------------------------------|
 |   A bittorrent tracker source based on TBDev.net/tbsource/bytemonsoon.   |
 |--------------------------------------------------------------------------|
 |   Project Leaders: Mindless, Autotron, whocares, Swizzles.					    |
 |--------------------------------------------------------------------------|
  _   _   _   _   _     _   _   _   _   _   _     _   _   _   _
 / \ / \ / \ / \ / \   / \ / \ / \ / \ / \ / \   / \ / \ / \ / \
( U | - | 2 | 3 | 2 )-( S | o | u | r | c | e )-( C | o | d | e )
 \_/ \_/ \_/ \_/ \_/   \_/ \_/ \_/ \_/ \_/ \_/   \_/ \_/ \_/ \_/
 */
require_once (__DIR__ . DIRECTORY_SEPARATOR . 'include' . DIRECTORY_SEPARATOR . 'bittorrent.php');
require_once (INCL_DIR . 'user_functions.php');
require_once INCL_DIR . 'pager_functions.php';
dbconn();
loggedinorreturn();
$lang = array_merge(load_language('global') , load_language('snatches'));
$HTMLOUT = "";
if (empty($_GET['id'])) {
    $HTMLOUT = '';
    $HTMLOUT.= "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\"
		\"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">
		<html xmlns='http://www.w3.org/1999/xhtml'>
		<head>
		<title>Error!</title>
		</head>
		<body>
	<div style='font-size:18px;color:black;background-color:red;text-align:center;'>Incorrect access<br />Silly Rabbit - Trix are for kids.. Snatches must be accessed using a valid id !</div>
	</body></html>";
    echo $HTMLOUT;
    exit();
}
$id = 0 + $_GET["id"];
if (!is_valid_id($id)) stderr("Error", "It appears that you have entered an invalid id.");
$res = sql_query("SELECT id, name FROM torrents WHERE id = " . sqlesc($id)) or sqlerr(__FILE__, __LINE__);
$arr = mysqli_fetch_assoc($res);
if (!$arr) stderr("Error", "It appears that there is no torrent with that id.");
$res = sql_query("SELECT COUNT(fid) FROM xbt_files_users WHERE completedtime !=0 AND fid =" . sqlesc($id)) or sqlerr(__FILE__, __LINE__);
$row = mysqli_fetch_row($res);
$count = $row[0];
$perpage = 15;
$pager = pager($perpage, $count, "snatches.php?id=$id&amp;");
if (!$count) stderr("No snatches", "It appears that there are currently no snatches for the torrent <a href='details.php?id=" . (int)$arr['id'] . "'>" . htmlsafechars($arr['name']) . "</a>.");
$HTMLOUT.= "<h1>Snatches for torrent <a href='{$INSTALLER09['baseurl']}/details.php?id=" . (int)$arr['id'] . "'>" . htmlsafechars($arr['name']) . "</a></h1>\n";
$HTMLOUT.= "<h2>Currently {$row['0']} snatch" . ($row[0] == 1 ? "" : "es") . "</h2>\n";
if ($count > $perpage) $HTMLOUT.= $pager['pagertop'];
$HTMLOUT.= "<table class='table table-bordered'>
<tr>
<td class='colhead' align='left'>{$lang['snatches_username']}</td>
<td class='colhead' align='right'>{$lang['snatches_uploaded']}</td>
" . ($INSTALLER09['ratio_free'] ? "" : "<td class='colhead' align='right'>{$lang['snatches_downloaded']}</td>") . "
<td class='colhead' align='right'>{$lang['snatches_ratio']}</td>
<td class='colhead' align='right'>{$lang['snatches_seedtime']}</td>
<td class='colhead' align='right'>{$lang['snatches_leechtime']}</td>
<td class='colhead' align='center'>{$lang['snatches_lastaction']}</td>
<td class='colhead' align='center'>{$lang['snatches_announced']}</td>
<td class='colhead' align='center'>Active</td>
<td class='colhead' align='right'>{$lang['snatches_completed']}</td>
</tr>\n";
$res = sql_query("SELECT x.*, x.uid AS xu, torrents.username as username1, users.username as username2, users.paranoia, torrents.anonymous as anonymous1, users.anonymous as anonymous2, size, parked, warned, enabled, class, chatpost, leechwarn, donor, uid FROM xbt_files_users AS x INNER JOIN users ON x.uid = users.id INNER JOIN torrents ON x.fid = torrents.id WHERE fid = " . sqlesc($id) . " AND completedtime !=0 ORDER BY fid DESC " . $pager['limit']) or sqlerr(__FILE__, __LINE__);
while ($arr = mysqli_fetch_assoc($res)) {
    $ratio = ($arr["downloaded"] > 0 ? number_format($arr["uploaded"] / $arr["downloaded"], 3) : ($arr["uploaded"] > 0 ? "Inf." : "---"));
    $active = ($arr['active'] == 1 ? $active = "<img src='" . $INSTALLER09['pic_base_url'] . "aff_tick.gif' alt='Yes' title='Yes' />" : $active = "<img src='" . $INSTALLER09['pic_base_url'] . "aff_cross.gif' alt='No' title='No' />");
    $completed = ($arr['completed'] >= 1 ? $completed = "<img src='" . $INSTALLER09['pic_base_url'] . "aff_tick.gif' alt='Yes' title='Yes' />" : $completed = "<img src='" . $INSTALLER09['pic_base_url'] . "aff_cross.gif' alt='No' title='No' />");
    $snatchuser = (isset($arr['username2']) ? ("<a href='userdetails.php?id=" . (int)$arr['uid'] . "'><b>" . htmlsafechars($arr['username2']) . "</b></a>") : "{$lang['snatches_unknown']}");
    $username = (($arr['anonymous2'] == 'yes' OR $arr['paranoia'] >= 2) ? ($CURUSER['class'] < UC_STAFF && $arr['uid'] != $CURUSER['id'] ? '' : $snatchuser . ' - ') . "<i>{$lang['snatches_anon']}</i>" : $snatchuser);
    $HTMLOUT.= "<tr>
  <td align='left'>{$username}</td>
  <td align='right'>" . mksize($arr["uploaded"]) . "</td>
  " . ($INSTALLER09['ratio_free'] ? "" : "<td align='right'>" . mksize($arr["downloaded"]) . "</td>") . "
  <td align='right'>" . htmlsafechars($ratio) . "</td>
  <td align='right'>" . mkprettytime($arr["seedtime"]) . "</td>
  <td align='right'>" . mkprettytime($arr["leechtime"]) . "</td>
  <td align='right'>" . get_date($arr["mtime"], '', 0, 1) . "</td>
  <td align='right'>" . (int)$arr["announced"] . "</td>
  <td align='center'>" . $active . "</td>
  <td align='center'>" . $completed . "</td>
  </tr>\n";
}
$HTMLOUT.= "</table>\n";
if ($count > $perpage) $HTMLOUT.= $pager['pagerbottom'];
echo stdhead('Snatches') . $HTMLOUT . stdfoot();
die;
?>
