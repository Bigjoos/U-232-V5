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
require_once (INCL_DIR . 'html_functions.php');
require_once (CLASS_DIR . 'class_check.php');
$class = get_access(basename($_SERVER['REQUEST_URI']));
class_check($class);
$lang = array_merge($lang, load_language('ad_stats'));
$HTMLOUT = '';
//$HTMLOUT.= begin_main_frame();
$HTMLOUT.= "<div class='row'><div class='col-md-12'>";
$res = sql_query("SELECT COUNT(id) FROM torrents") or sqlerr(__FILE__, __LINE__);
$n = mysqli_fetch_row($res);
$n_tor = $n[0];
$res = sql_query("SELECT COUNT(id) FROM peers") or sqlerr(__FILE__, __LINE__);
$n = mysqli_fetch_row($res);
$n_peers = $n[0];
$uporder = isset($_GET['uporder']) ? $_GET['uporder'] : '';
$catorder = isset($_GET["catorder"]) ? $_GET["catorder"] : '';
if ($uporder == "lastul") $orderby = "last DESC, name";
elseif ($uporder == "torrents") $orderby = "n_t DESC, name";
elseif ($uporder == "peers") $orderby = "n_p DESC, name";
else $orderby = "name";
$query = "SELECT u.id, u.username AS name, MAX(t.added) AS last, COUNT(DISTINCT t.id) AS n_t, COUNT(p.id) as n_p
      FROM users as u LEFT JOIN torrents as t ON u.id = t.owner LEFT JOIN peers as p ON t.id = p.torrent WHERE u.class = " . UC_UPLOADER . "
      GROUP BY u.id UNION SELECT u.id, u.username AS name, MAX(t.added) AS last, COUNT(DISTINCT t.id) AS n_t, COUNT(p.id) as n_p
      FROM users as u LEFT JOIN torrents as t ON u.id = t.owner LEFT JOIN peers as p ON t.id = p.torrent WHERE u.class > " . UC_UPLOADER . "
      GROUP BY u.id ORDER BY $orderby";
$res = sql_query($query) or sqlerr(__FILE__, __LINE__);
if (mysqli_num_rows($res) == 0) stdmsg($lang['stats_error'], $lang['stats_error1']);
else {
    //$HTMLOUT.= begin_frame($lang['stats_title1'], True);
    //$HTMLOUT.= begin_table();
    $HTMLOUT.= "<h2>{$lang['stats_title1']}</h2>";
    $HTMLOUT.= "<table class='table table-bordered'>";
    $HTMLOUT.= "<tr>
      <td class='colhead'><a href='staffpanel.php?tool=stats&amp;action=stats&amp;uporder=uploader&amp;catorder=$catorder' class='colheadlink'>{$lang['stats_uploader']}</a></td>
      <td class='colhead'><a href='staffpanel.php?tool=stats&amp;action=stats&amp;uporder=lastul&amp;catorder=$catorder' class='colheadlink'>{$lang['stats_last']}</a></td>
      <td class='colhead'><a href='staffpanel.php?tool=stats&amp;action=stats&amp;uporder=torrents&amp;catorder=$catorder' class='colheadlink'>{$lang['stats_torrent']}</a></td>
      <td class='colhead'>Perc.</td>
      <td class='colhead'><a href='staffpanel.php?tool=stats&amp;action=stats&amp;uporder=peers&amp;catorder=$catorder' class='colheadlink'>{$lang['stats_peers']}</a></td>
      <td class='colhead'>Perc.</td>
      </tr>\n";
    while ($uper = mysqli_fetch_assoc($res)) {
        $HTMLOUT.= "<tr>
        <td><a href='userdetails.php?id=" . (int)$uper['id'] . "'><b>" . htmlsafechars($uper['name']) . "</b></a></td>
        <td " . ($uper['last'] ? (">" . get_date($uper['last'], '') . " (" . get_date($uper['last'], '', 0, 1) . ")") : "align='center'>---") . "</td>
        <td align='right'>{$uper['n_t']}</td>
        <td align='right'>" . ($n_tor > 0 ? number_format(100 * $uper['n_t'] / $n_tor, 1) . "%" : "---") . "</td>
        <td align='right'>" . $uper['n_p'] . "</td>
        <td align='right'>" . ($n_peers > 0 ? number_format(100 * $uper['n_p'] / $n_peers, 1) . "%" : "---") . "</td></tr>\n";
    }
    $HTMLOUT.= "</table>";
    //$HTMLOUT.= end_frame();
}
if ($n_tor == 0) stdmsg($lang['stats_error'], $lang['stats_error2']);
else {
    if ($catorder == "lastul") $orderby = "last DESC, c.name";
    elseif ($catorder == "torrents") $orderby = "n_t DESC, c.name";
    elseif ($catorder == "peers") $orderby = "n_p DESC, name";
    else $orderby = "c.name";
    $res = sql_query("SELECT c.name, MAX(t.added) AS last, COUNT(DISTINCT t.id) AS n_t, COUNT(p.id) AS n_p
      FROM categories as c LEFT JOIN torrents as t ON t.category = c.id LEFT JOIN peers as p
      ON t.id = p.torrent GROUP BY c.id ORDER BY $orderby") or sqlerr(__FILE__, __LINE__);
    //$HTMLOUT.= begin_frame($lang['stats_title2'], True);
    //$HTMLOUT.= begin_table();
    $HTMLOUT.= "<h2>{$lang['stats_title2']}</h2>";
    $HTMLOUT.= "<table class='table table-bordered'>";
    $HTMLOUT.= "<tr>
      <td class='colhead'><a href='staffpanel.php?tool=stats&amp;action=stats&amp;uporder=$uporder&amp;catorder=category' class='colheadlink'>{$lang['stats_category']}</a></td>
      <td class='colhead'><a href='staffpanel.php?tool=stats&amp;action=stats&amp;uporder=$uporder&amp;catorder=lastul' class='colheadlink'>{$lang['stats_last']}</a></td>
      <td class='colhead'><a href='staffpanel.php?tool=stats&amp;action=stats&amp;uporder=$uporder&amp;catorder=torrents' class='colheadlink'>{$lang['stats_torrent']}</a></td>
      <td class='colhead'>Perc.</td>
      <td class='colhead'><a href='staffpanel.php?tool=stats&amp;action=stats&amp;uporder=$uporder&amp;catorder=peers' class='colheadlink'>{$lang['stats_peers']}</a></td>
      <td class='colhead'>Perc.</td>
      </tr>\n";
    while ($cat = mysqli_fetch_assoc($res)) {
        $HTMLOUT.= "<tr>
        <td class='rowhead'>" . htmlsafechars($cat['name']) . "</td>
        <td " . ($cat['last'] ? (">" . get_date($cat['last'], '') . " (" . get_date($cat['last'], '', 0, 1) . ")") : "align='center'>---") . "</td>
        <td align='right'>{$cat['n_t']}</td>
        <td align='right'>" . number_format(100 * $cat['n_t'] / $n_tor, 1) . "%</td>
        <td align='right'>{$cat['n_p']}</td>
        <td align='right'>" . ($n_peers > 0 ? number_format(100 * $cat['n_p'] / $n_peers, 1) . "%" : "---") . "</td></tr>\n";
    }
    $HTMLOUT.= "</table>";
    //$HTMLOUT.= end_frame();
}
$HTMLOUT.= "</div></div>";
echo stdhead($lang['stats_window_title']) . $HTMLOUT . stdfoot();
die;
?>
