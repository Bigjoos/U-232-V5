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
require_once (INCL_DIR . 'bbcode_functions.php');
require_once (INCL_DIR . 'pager_functions.php');
require_once (CLASS_DIR . 'class_check.php');
class_check(UC_MAX);
$lang = array_merge($lang, load_language('ad_sysoplog'));
$HTMLOUT = $where = '';
$search = isset($_POST['search']) ? strip_tags($_POST['search']) : '';
if(isset($_GET['search'])) $search = strip_tags($_GET['search']);
if (!empty($search)) $where = "WHERE txt LIKE " . sqlesc("%$search%") . "";
//== Delete items older than 1 month
$secs = 30 * 86400;
sql_query("DELETE FROM infolog WHERE " . TIME_NOW . " - added > $secs") or sqlerr(__FILE__, __LINE__);
$res = sql_query("SELECT COUNT(id) FROM infolog $where");
$row = mysqli_fetch_array($res);
$count = $row[0];
$perpage = 15;
$pager = pager($perpage, $count, "staffpanel.php?tool=sysoplog&amp;action=sysoplog&amp;" . (!empty($search) ? "search=$search&amp;" : '') . "");
$HTMLOUT = '';
$res = sql_query("SELECT added, txt FROM infolog $where ORDER BY added DESC {$pager['limit']}") or sqlerr(__FILE__, __LINE__);
$HTMLOUT.= "<div class='row'><div class='col-md-12'>";
$HTMLOUT.= "<h1>{$lang['sysoplog_staff']}</h1>";
$HTMLOUT.= "<table class='table table-bordered'>\n
             <tr>
			 <td class='tabletitle' align='left'>{$lang['sysoplog_search']}</td>\n
			 </tr>
             <tr>
			 <td class='table' align='left'>\n
			 <form method='post' action='staffpanel.php?tool=sysoplog&amp;action=sysoplog'>\n
			 <input type='text' name='search' size='40' value='' />\n
			 <input type='submit' value='{$lang['sysoplog_search']}' style='height: 20px' />\n
			 </form></td></tr></table>";
if ($count > $perpage) $HTMLOUT.= $pager['pagertop'];
if (mysqli_num_rows($res) == 0) {
    $HTMLOUT.= "<b>{$lang['sysoplog_norecord']}</b>";
} else {
    $HTMLOUT.= "<table class='table table-bordered'>
      <tr>
        <td class='colhead' align='left'>{$lang['sysoplog_date']}</td>
        <td class='colhead' align='left'>{$lang['sysoplog_time']}</td>
        <td class='colhead' align='left'>{$lang['sysoplog_event']}</td>
      </tr>";
    while ($arr = mysqli_fetch_assoc($res)) {
        $color = '#FF4763';
        if (strpos($arr['txt'], $lang['sysoplog_warned'])) $color = "#FF0000";
        if (strpos($arr['txt'], $lang['sysoplog_leechw'])) $color = "#9ED9D0";
        if (strpos($arr['txt'], $lang['sysoplog_down'])) $color = "#62D962";
        if (strpos($arr['txt'], $lang['sysoplog_imun'])) $color = "#FFFF00";
        if (strpos($arr['txt'], $lang['sysoplog_enable'])) $color = "#47FFE3";
        if (strpos($arr['txt'], $lang['sysoplog_donor'])) $color = "#FF8112";
        if (strpos($arr['txt'], $lang['sysoplog_paranoia'])) $color = "#E8001F";
        if (strpos($arr['txt'], $lang['sysoplog_uptotal'])) $color = "#14ED00";
        if (strpos($arr['txt'], $lang['sysoplog_downtotal'])) $color = "#5A63C7";
        if (strpos($arr['txt'], $lang['sysoplog_invitet'])) $color = "#54ACBA";
        if (strpos($arr['txt'], $lang['sysoplog_seed'])) $color = "#BA6154";
        if (strpos($arr['txt'], $lang['sysoplog_rep'])) $color = "#57AD00";
        if (strpos($arr['txt'], $lang['sysoplog_prom'])) $color = "#E01E00";
        if (strpos($arr['txt'], $lang['sysoplog_dem'])) $color = "#BA5480";
        if (strpos($arr['txt'], $lang['sysoplog_web'])) $color = "#00CFA2";
        $date = get_date($arr['added'], 'DATE');
        $time = get_date($arr['added'], 'LONG', 0, 1);
        $HTMLOUT.= "<tr class='tableb'><td style='background-color:$color'><font color='black'>{$date}</font></td>
<td style='background-color:$color'><font color='black'>{$time}</font></td>
<td style='background-color:$color' align='left'><font color='black'>{$arr['txt']}</font></td></tr>\n";
    }
    $HTMLOUT.= "</table>";
}
if ($count > $perpage) $HTMLOUT.= $pager['pagerbottom']."<br>";
$HTMLOUT.= "<p>{$lang['sysoplog_times']}</p>\n";
$HTMLOUT.= "</div></div>";
echo stdhead($lang['sysoplog_sys']) . $HTMLOUT . stdfoot();
?>
