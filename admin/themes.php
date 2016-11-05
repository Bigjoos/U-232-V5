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
//==Template Manager By Terranova
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
class_check(UC_MAX);
$lang = array_merge($lang, load_language('ad_themes'));
$HTML = '';
if (!function_exists("html")) {
    function html($VAL)
    {
        return htmlsafechars($VAL, ENT_QUOTES);
    }
}
if (isset($_GET['act'])) {
    $ACT = (int)$_GET['act'];
    if (!is_valid_id($ACT)) stderr("{$lang['themes_error']}", "{$lang['themes_inv_act']}");
    if ($ACT == 1) { //--EDIT
        if (!isset($_GET['id'])) stderr("{$lang['themes_error']}", "{$lang['themes_inv_id']}");
        $ID = (int)$_GET['id'];
        if (!is_valid_id($ID)) stderr("{$lang['themes_error']}", "{$lang['themes_inv_id']}");
        $TEMPLATE = sql_query("SELECT * FROM stylesheets WHERE id=" . sqlesc($ID) . " LIMIT 1");
        $TEM = mysqli_fetch_array($TEMPLATE);
        $HTML.= "<div class='row'><div class='col-md-12'>
			<form action='{$INSTALLER09['baseurl']}/staffpanel.php?tool=themes&amp;action=themes&amp;act=4' method='post'>
         <input type='hidden' value='" . (int)$TEM['id'] . "' name='uri' />
         <table class='table table-bordered'>
			<tr><td colspan='2' class='colhead' align='center'>{$lang['themes_edit_tem']} " . htmlsafechars($TEM['name']) . "</td></tr>
			<tr><td class='rowhead'>{$lang['themes_id']}<br/>{$lang['themes_explain_id']}</td>
         <td><input type='text' value='" . (int)$TEM['id'] . "' name='id' /></td></tr>
			<tr><td class='rowhead'>{$lang['themes_uri']}</td>
         <td><input type='text' value='" . (int)$TEM['uri'] . "' name='uri' /></td></tr>
			<tr><td class='rowhead'>{$lang['themes_name']}</td>
         <td><input type='text' value='" . htmlsafechars($TEM['name']) . "' name='title' /></td></tr>
			<tr><td class='rowhead'>{$lang['themes_is_folder']}</td><td>
			<b>" . (file_exists("templates/" . (int)$TEM['id'] . "/template.php") ? "{$lang['themes_file_exists']}" : "{$lang['themes_not_exists']}") . "</b>
			</td></tr>
			<tr><td class='colhead' colspan='2' align='center'><input type='submit' value='{$lang['themes_save']}' /></td></tr></table></form></div></div><br>
			";
    }
    if ($ACT == 2) { //--DELETE
        if (!isset($_GET['id'])) stderr("{$lang['themes_error']}", "{$lang['themes_inv_id']}");
        $ID = (int)$_GET['id'];
        if (!is_valid_id($ID)) stderr("{$lang['themes_error']}", "{$lang['themes_inv_id']}");
        stderr("{$lang['themes_delete_q']}", "{$lang['themes_delete_sure_q']}<a href='{$INSTALLER09['baseurl']}/staffpanel.php?tool=themes&amp;action=themes&amp;act=5&amp;id=$ID&amp;sure=1'>
			{$lang['themes_delete_sure_q2']}</a> {$lang['themes_delete_sure_q3']}");
    }
    if ($ACT == 3) { //--ADD NEW
        $IDS = sql_query("SELECT id FROM stylesheets");
        while ($ID = mysqli_fetch_array($IDS)) {
            if (file_exists("templates/" . (int)$ID['id'] . "/template.php")) $TAKEN[] = "<font color='green'>$ID[id]</font>";
            else $TAKEN[] = "<font color='red'>$ID[id]</font>";
        }
        $HTML.= "<div class='row'><div class='col-md-12'>
			<form action='staffpanel.php?tool=themes&amp;action=themes&amp;act=6' method='post'>
			<table class='table table-bordered'>
			<tr><td class='colhead' colspan='2' align='center'>{$lang['themes_addnew']}</td></tr>
			<tr valign='middle'><td class='rowhead'>{$lang['themes_id']}</td><td><input type='text' value='' name='id' /><br />
			{$lang['themes_takenids']}<b>" . implode(", ", $TAKEN) . "</b></td></tr>
			<tr valign='middle'><td class='rowhead'>{$lang['themes_uri']}</td><td><input type='text' value='' name='uri' /></td></tr>
			<tr valign='middle'><td class='rowhead'>{$lang['themes_name']}</td><td><input type='text' value='' name='name' /></td></tr>
			<tr><td colspan='2'>{$lang['themes_guide']}</td></tr>
			<tr><td class='colhead' colspan='2' align='center'><input type='submit' value='{$lang['themes_add']}' /></td></tr>
			</table>
			</form></div></div><br>
			";
    }
    if ($ACT == 4) { //--SAVE EDIT
        if (!isset($_POST['id'])) stderr("{$lang['themes_error']}", "{$lang['themes_inv_id']}");
        if (!isset($_POST['uri'])) stderr("{$lang['themes_error']}", "{$lang['themes_inv_uri']}");
        if (!isset($_POST['title'])) stderr("{$lang['themes_error']}", "{$lang['themes_inv_name']}");
        $ID = (int)$_POST['id'];
        $URI = (int)$_POST['uri'];
        $NAME = htmlsafechars($_POST['title']);
        if (!is_valid_id($ID)) stderr("{$lang['themes_error']}", "{$lang['themes_inv_id']}");
        $CURRENT = sql_query("SELECT * FROM stylesheets WHERE id=" . sqlesc($URI));
        $CUR = mysqli_fetch_array($CURRENT);
        if ($ID != $CUR['id']) $EDIT[] = "id=" . sqlesc($ID);
        if ($URI != $CUR['uri']) $EDIT[] = "uri=" . sqlesc($URI);
        if ($NAME != $CUR['name']) $EDIT[] = "name=" . sqlesc($NAME);
        if (!@sql_query("UPDATE stylesheets SET " . implode(", ", $EDIT) . " WHERE id=" . sqlesc($URI))) stderr("{$lang['themes_error']}", "{$lang['themes_some_wrong']}");
        header("Location: {$INSTALLER09['baseurl']}/staffpanel.php?tool=themes&action=themes&msg=1");
    }
    if ($ACT == 5) { //--DELETE FINAL
        if (!isset($_GET['id'])) stderr("{$lang['themes_error']}", "{$lang['themes_inv_id']}");
        $ID = (int)$_GET['id'];
        if (!is_valid_id($ID)) stderr("{$lang['themes_error']}", "{$lang['themes_inv_id']}");
        if (!isset($_POST['sure'])) header("Location: staffpanel.php?tool=themes");
        if (isset($_POST['sure']) && $_POST['sure'] != 1) header("Location: staffpanel.php?tool=themes");
        sql_query("DELETE FROM stylesheets WHERE id=" . sqlesc($ID));
        $RANDSTYLE = mysqli_fetch_array(sql_query("SELECT id FROM stylesheets ORDER BY RAND() LIMIT 1"));
        sql_query("UPDATE users SET stylesheet=" . sqlesc($RANDSTYLE['id']) . " WHERE stylesheet=" . sqlesc($ID));
        header("Location: {$INSTALLER09['baseurl']}/staffpanel.php?tool=themes&action=themes&msg=2");
    }
    if ($ACT == 6) { //--ADD NEW SAVE
        if (!isset($_POST['id'])) stderr("{$lang['themes_error']}", "{$lang['themes_inv_id']}");
        if (!isset($_POST['uri'])) stderr("{$lang['themes_error']}", "{$lang['themes_inv_uri']}");
        if (!isset($_POST['name'])) stderr("{$lang['themes_error']}", "{$lang['themes_inv_name']}");
        if (!file_exists("templates/" . $_POST['id'] . "/template.php")) stderr("{$lang['themes_nofile']}", "{$lang['themes_inv_file']}<a href='{$INSTALLER09['baseurl']}/staffpanel.php?tool=themes&amp;action=themes&amp;act=7&amp;id=" . (int)$_POST['id'] . "&amp;uri=" . (int)$_POST['uri'] . "&amp;name=" . htmlsafechars($_POST['name']) . "'>{$lang['themes_file_exists']}</a>/
			<a href='{$INSTALLER09['baseurl']}/staffpanel.php?tool=themes'>{$lang['themes_not_exists']}</a>");
        sql_query("INSERT INTO stylesheets(id, uri, name)VALUES(" . sqlesc($_POST['id']) . ", " . sqlesc($_POST['uri']) . ", " . sqlesc($_POST['name']) . ")");
        header("Location: {$INSTALLER09['baseurl']}/staffpanel.php?tool=themes&action=themes&msg=3");
    }
    if ($ACT == 7) { //--ADD NEW IF FOLDER NO EXISTS
        if (!isset($_GET['id'])) stderr("{$lang['themes_error']}", "{$lang['themes_inv_id']}");
        if (!isset($_GET['uri'])) stderr("{$lang['themes_error']}", "{$lang['themes_inv_uri']}");
        if (!isset($_GET['name'])) stderr("{$lang['themes_error']}", "{$lang['themes_inv_name']}");
        $ID = (int)$_GET['id'];
        $URI = (int)$_GET['uri'];
        $NAME = htmlsafechars($_GET['name']);
        sql_query("INSERT INTO stylesheets(id, uri, name)VALUES(" . sqlesc($ID) . ", " . sqlesc($URI) . ",  " . sqlesc($NAME) . ")");
        header("Location: staffpanel.php?tool=themes&action=themes&msg=3");
    }
}
if (isset($_GET['msg'])) {
    $MSG = $_GET['msg'];
    if ($MSG > 0) $HTML.= "<h1>{$lang['themes_msg']}</h1>";
}
if (!isset($_GET['act'])) {
    $HTML.= "<div class='row'><div class='col-md-12'>
<table class='table table-bordered'>
		<tr><td colspan='5'><a href='{$INSTALLER09['baseurl']}/staffpanel.php?tool=themes&amp;action=themes&amp;act=3'><span class='btn'>{$lang['themes_addnew']}</span></a></td></tr>
		<tr>
		<td class='colhead'>{$lang['themes_id']}</td>
		<td class='colhead'>{$lang['themes_uri']}</td>
		<td class='colhead'>{$lang['themes_name']}</td>
		<td class='colhead'>{$lang['themes_is_folder']}</td>
		<td class='colhead'>{$lang['themes_e_d']}</td>
		</tr>";
    $TEMPLATES = sql_query("SELECT * FROM stylesheets");
    while ($TE = mysqli_fetch_array($TEMPLATES)) {
        $HTML.= "
			<tr>
			<td align='left'>$TE[id]</td>
			<td align='left'>" . html($TE['uri']) . "</td>
			<td align='left'>" . html($TE['name']) . "</td>
			<td align='left'><b>" . (file_exists("templates/" . (int)$TE['id'] . "/template.php") ? "{$lang['themes_file_exists']}" : "{$lang['themes_not_exists']}") . "</b></td>
			<td align='left'><a href='{$INSTALLER09['baseurl']}/staffpanel.php?tool=themes&amp;action=themes&amp;act=1&amp;id=" . (int)$TE['id'] . "'>[{$lang['themes_edit']}]</a>
			<a href='{$INSTALLER09['baseurl']}/staffpanel.php?tool=themes&amp;action=themes&amp;act=2&amp;id=" . (int)$TE['id'] . "'>[{$lang['themes_delete']}]</a></td>
			</tr>
			";
    }
    $HTML.= "<tr><td class='colhead' colspan='5' align='center'></td></tr></table></div></div><br>";
}
echo stdhead("{$lang['stdhead_templates']}") . $HTML . stdfoot();
?>
