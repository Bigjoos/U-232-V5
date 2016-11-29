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
$lang = array_merge($lang, load_language('bonusmanager'));
$HTMLOUT = $count = '';
$res = sql_query("SELECT * FROM bonus") or sqlerr(__FILE__, __LINE__);
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["id"]) || isset($_POST["points"]) || isset($_POST["pointspool"]) || isset($_POST["minpoints"]) || isset($_POST["description"]) || isset($_POST["enabled"])) {
        $id = 0 + $_POST["id"];
        $points = 0 + $_POST["bonuspoints"];
        $pointspool = 0 + $_POST["pointspool"];
        $minpoints = 0 + $_POST["minpoints"];
        $descr = htmlsafechars($_POST["description"]);
        $enabled = "yes";
        if (isset($_POST["enabled"]) == '') {
            $enabled = "no";
        }
        $sql = sql_query("UPDATE bonus SET points = ".sqlesc($points).", pointspool=".sqlesc($pointspool).", minpoints=".sqlesc($minpoints).", enabled = ".sqlesc($enabled).", description = ".sqlesc($descr)." WHERE id = ".sqlesc($id));
        if ($sql) {
            header("Location: {$INSTALLER09['baseurl']}/staffpanel.php?tool=bonusmanage");
        } else {
            stderr($lang['bonusmanager_oops'], "{$lang['bonusmanager_sql']}");
        }
    }
}
while ($arr = mysqli_fetch_assoc($res)) {
    $count = (++$count) % 2;
    $class = ($count == 0 ? 'one' : 'two');
    $HTMLOUT.= "<div class='row'><div class='col-md-12 col-md-offset-1'>
<form name='bonusmanage' method='post' action='staffpanel.php?tool=bonusmanage&amp;action=bonusmanage'>
	  <div class='roundedCorners' style='text-align:left;width:80%;border:1px solid black;padding:5px;'>
   <div class='colhead'><span style='font-weight:bold;font-size:12pt;'>{$lang['bonusmanager_bm']}</span></div>
	  <table class='table table-bordered'>
	  <div class='row'><div class='col-md-8 col-md-offset-2'><tr>
		<td>{$lang['bonusmanager_id']}</td>
		<td>{$lang['bonusmanager_enabled']}</td>
		<td>{$lang['bonusmanager_bonus']}</td>
		<td>{$lang['bonusmanager_points']}</td>
		<td>{$lang['bonusmanager_pointspool']}</td>
		<td>{$lang['bonusmanager_minpoints']}</td>
		<td>{$lang['bonusmanager_description']}</td>
	  <td>{$lang['bonusmanager_type']}</td>
		<td>{$lang['bonusmanager_quantity']}</td>
		<td>{$lang['bonusmanager_action']}</td></tr> 
	  <tr><td class='$class'>
		<input name='id' type='hidden' value='" . (int)$arr["id"] . "' />" . (int)$arr['id'] . "</td>
		<td class='$class'><input name='enabled' type='checkbox'" . ($arr["enabled"] == "yes" ? " checked='checked'" : "") . " /></td>
		<td class='$class'>" . htmlsafechars($arr["bonusname"]) . "</td>
		<td class='$class'><input type='text' name='bonuspoints' value='" . (int)$arr["points"] . "' size='4' /></td>
		<td class='$class'><input type='text' name='pointspool' value='" . (int)$arr["pointspool"] . "' size='4' /></td>
		<td class='$class'><input type='text' name='minpoints' value='" . (int)$arr["minpoints"] . "' size='4' /></td>
		<td class='$class'><textarea name='description' rows='4' cols='10'>" . htmlsafechars($arr["description"]) . "</textarea></td>
		<td class='$class'>".htmlsafechars($arr["art"])."</td>
		<td class='$class'>" . (($arr["art"] == "traffic" || $arr["art"] == "traffic2" || $arr["art"] == "gift_1" || $arr["art"] == "gift_2") ? (htmlsafechars($arr["menge"]) / 1024 / 1024 / 1024) . " GB" : htmlsafechars($arr["menge"])) . "</td>
		<td align='center'><input type='submit' value='{$lang['bonusmanager_submit']}' /></td>
		</tr></div></div></table></div></form></div></div><br>";
}
echo stdhead($lang['bonusmanager_stdhead']) . $HTMLOUT . stdfoot();
?>
