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
    $HTMLOUT .= "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\"
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
require_once(INCL_DIR . 'user_functions.php');
require_once(INCL_DIR . 'password_functions.php');
require_once(CLASS_DIR . 'class_check.php');
$class = get_access(basename($_SERVER['REQUEST_URI']));
class_check($class);
$mc1->delete_value('rules__');

$lang = array_merge($lang, load_language('ad_rules'));

$params = array_merge($_GET, $_POST);
$params['mode'] = isset($params['mode']) ? htmlsafechars($params['mode']) : '';
switch ($params['mode']) {
    case 'cat_new':
        New_Cat_Form();
        break;
    case 'cat_add':
        Do_Cat_Add();
        break;
    case 'cat_edit':
        Show_Cat_Edit_Form();
        break;
    case 'takeedit_cat':
        Do_Cat_Update();
        break;
    case 'cat_delete':
        Cat_Delete();
        break;
    case 'cat_delete_chk':
        Cat_Delete(true);
        break;
    case 'rules_new':
        New_Rules_Form();
        break;
    case 'rules_edit':
        Show_Rules_Edit();
        break;
    case 'takeedit_rules':
        Do_Rules_Update();
        break;
    case 'takeadd_rules':
        Do_Rules_Add();
        break;
    case 'rules_delete':
        Do_Rules_Delete();
        break;
    default:
        Do_show();
        break;
}
function Do_show()
{
    global $INSTALLER09, $lang;
    $sql = sql_query("SELECT * FROM rules_cat") or sqlerr(__FILE__, __LINE__);
    if (!mysqli_num_rows($sql))
        stderr("Error", "There Are No Categories. <br /><br />
       <span class='btn'><a href='{$INSTALLER09['baseurl']}/staffpanel.php?tool=rules_admin&amp;mode=cat_new'>Add Category</a></span>");
    $htmlout = '';
    $htmlout .= "
            <div class='container'>
<div class='row'>
<div class='col-sm-3 col-sm-offset-5'>  
<h2><b>{$lang['rules_cat_title']}</b></div></div>
<div class='row'>
      <div class='col-sm-col-4 col-sm-offset-2'>
            <span class='btn'><a href='{$INSTALLER09['baseurl']}/staffpanel.php?tool=rules_admin&amp;mode=cat_new'>{$lang['rules_btn_newcat']}</a></span>&nbsp;
            <span class='btn'><a href='{$INSTALLER09['baseurl']}/staffpanel.php?tool=rules_admin&amp;mode=rules_new'>{$lang['rules_btn_newrule']}</a></span>
            </div><br>
            <div class='col-sm-8 col-sm-offset-2'>     
<table class='table table-bordered table-striped'>
            <tr>
            <td class='colhead'>Id</td>
            <td class='colhead'>Name</td>
            <td class='colhead'>Shortcut</td>
            <td class='colhead'>Min Class</td>
            <td class='colhead'>Tools</td></tr>";
    while ($arr = mysqli_fetch_assoc($sql)) {
        $htmlout .= "
            <tr>
            <td>" . intval($arr['id']) . "</td>
            <td><a href='{$INSTALLER09['baseurl']}/staffpanel.php?tool=rules_admin&amp;mode=rules_edit&amp;catid=" . intval($arr['id']) . "'>" . htmlsafechars($arr['name']) . "</a></td>
            <td>" . htmlsafechars($arr['shortcut']) . "</td>
            <td>" . htmlsafechars($arr['min_view']) . "</td>
            <td><a href='{$INSTALLER09['baseurl']}/staffpanel.php?tool=rules_admin&amp;mode=cat_edit&amp;catid=" . intval($arr['id']) . "'><img src='{$INSTALLER09['pic_base_url']}button_edit2.gif' height='15px' width='14px' alt='{$lang['rules_edit']}' style='padding-right:3px' /></a>
            <a href='{$INSTALLER09['baseurl']}/staffpanel.php?tool=rules_admin&amp;mode=cat_delete&amp;catid=" . intval($arr['id']) . "'><img src='{$INSTALLER09['pic_base_url']}button_delete2.gif' height='13px' width='13px' alt='{$lang['rules_delete']}' style='padding-left:3px' /></a></td>
            </tr>";
    }
    $htmlout .= "</table></div></div></div>";
    echo stdhead("{$lang['rules_rules']}") . $htmlout . stdfoot();
    exit();
}
// ===added delete
function Do_Rules_Delete()
{
    global $mc1;
    if (!isset($_POST['fdata']) OR !is_array($_POST['fdata']))
        stderr("Error", "Bad data!");
    $id = array();
    foreach ($_POST['fdata'] as $k => $v) {
        if (isset($v['rules_id']) AND !empty($v['rules_id'])) {
            $id[] = sqlesc(intval($v['rules_id']));
        }
    }
    if (!count($id))
        stderr("Error", "No rules selected!");
    sql_query("DELETE FROM rules WHERE id IN( " . implode(',', $id) . " )") or sqlerr(__FILE__, __LINE__);
    $mc1->delete_value('rules__');
    header("Refresh: 3; url=staffpanel.php?tool=rules_admin");
    stderr("Info", "Rules successfully Deleted! Please wait while you are redirected.");
}
// ====end
function Cat_Delete($chk = false)
{
    global $mc1;
    $id = isset($_GET['catid']) ? (int) $_GET['catid'] : 0;
    if (!is_valid_id($id))
        stderr("Error", "Bad ID!");
    if (!$chk) {
        stderr("Sanity Check!", "You're about to delete a rules category, this will delete ALL content within that category! <br />
<a href='staffpanel.php?tool=rules_admin&amp;catid={$id}&amp;mode=cat_delete_chk'><span style='font-weight: bold; color: green'>Continue?</span></a>
or <a href='staffpanel.php?tool=rules_admin'><span style='font-weight: bold; color: red'>Cancel?</span></a>");
    }
    sql_query("DELETE FROM rules WHERE type = " . sqlesc($id)) or sqlerr(__FILE__, __LINE__);
    sql_query("DELETE FROM rules_cat WHERE id = " . sqlesc($id)) or sqlerr(__FILE__, __LINE__);
    $mc1->delete_value('rules__');
    header("Refresh: 3; url=staffpanel.php?tool=rules_admin");
    stderr("Info", "Rules category deleted successfully! Please wait while you are redirected.");
}
function Show_Cat_Edit_Form()
{
    global $lang, $CURUSER;
    $htmlout = '';
    $maxclass = intval($CURUSER['class']);
    if (!isset($_GET['catid']) || empty($_GET['catid']) || !is_valid_id($_GET['catid']))
        $htmlout .= Do_Error("Error", "No Section selected");
    $cat_id = (int) $_GET['catid'];
    $sql = sql_query("SELECT * FROM rules_cat WHERE id = " . sqlesc($cat_id)) or sqlerr(__FILE__, __LINE__);
    if (!mysqli_num_rows($sql))
        stderr("SQL Error", "Nothing doing here!");
    $htmlout .= "<table class='table table-bordered table-striped'>
                <tr>
                <td class='colhead'>Name</td>
                <td class='colhead'>Shortcut</td>
                <td class='colhead'>Min Class</td></tr>";
    while ($row = mysqli_fetch_assoc($sql)) {
        $htmlout .= "<h2>Title No." . intval($row['id']) . "</h2>
        <form name='inputform' method='post' action='staffpanel.php?tool=rules_admin'>
        <input type='hidden' name='mode' value='takeedit_cat' />
        <input type='hidden' name='cat' value='" . intval($row['id']) . "' />
        <tr><td><input type='text' value='" . htmlsafechars($row['name']) . "' name='name' style='width:380px;' /></td>
        <td><input type='text' value='" . htmlsafechars($row['shortcut']) . "' name='shortcut' style='width:380px;' /></td>

        <td><select name='min_view'>";
        for ($i = 0; $i <= $maxclass; ++$i) {
            $htmlout .= '<option value="' . $i . '"'.($row['min_view'] == $i ? " selected='selected'" : "").'">' . get_user_class_name($i) . '</option>';
        }
        $htmlout .= "</select></td>
        <td colspan='4'><input type='submit' name='submit' value='Edit' class='button' /></td>
        </tr></form>";
    }
    $htmlout .= "</table>";
    echo stdhead("Edit options") . $htmlout . stdfoot();
    exit();
}
function Show_Rules_Edit()
{
    global $lang, $CURUSER;
    $htmlout = '';
    $maxclass = $CURUSER['class'];
    if (!isset($_GET['catid']) || empty($_GET['catid']) || !is_valid_id($_GET['catid']))
        stderr("Error", "No Section selected");
    $cat_id = (int) $_GET['catid'];
    $sql = sql_query("SELECT * FROM rules WHERE type = " . sqlesc($cat_id)) or sqlerr(__FILE__, __LINE__);
    if (!mysqli_num_rows($sql))
        stderr("SQL Error", "Nothing doing here!");
    $htmlout .= "<form name='compose' method='post' action='staffpanel.php?tool=rules_admin'>";
    while ($row = mysqli_fetch_assoc($sql)) {
        $htmlout .= "<strong>Rules No." . intval($row['id']) . "</strong>";
        $htmlout .= "<br />
          <div style='text-align: left; width: 70%; border: 1px solid;'>
          <input type='text' value='" . htmlsafechars($row['title']) . "' name='fdata[{$row['id']}][title]' style='width:650px;' />
          <span style='float:right;'>
          <input type='checkbox' name='fdata[{$row['id']}][rules_id]' value='" . intval($row['id']) . "' />
          </span>
          <br />
          <textarea name='fdata[{$row['id']}][text]' rows='10' cols='20' style='width:650px;'>" . htmlsafechars($row['text']) . "</textarea>
          </div><br />";
    }
    $htmlout .= "<input type='submit' name='submit' value='With Selected' class='button' />&nbsp;
         <select name='mode'>
         <option value=''>--- Select One ---</option>
         <option value='takeedit_rules'>Update Rules</option>
         <option value='rules_delete'>Delete Rules</option>
         </select>
         </form>";
    echo stdhead("Edit options") . $htmlout . stdfoot();
    exit();
}
function Do_Rules_Update()
{
    global $mc1;
    $time = TIME_NOW;
    $updateset = array();
    if (!isset($_POST['fdata']) || !is_array($_POST['fdata']))
        stderr("Error", "Don't leave any fields blank");
    foreach ($_POST['fdata'] as $k => $v) {
        $holder = '';
        if (isset($v['rules_id']) AND !empty($v['rules_id'])) {
            foreach (array(
                'title',
                'text'
            ) as $x) {
                isset($v[$x]) AND !empty($v[$x]) ? $holder .= "{$x} = " . sqlesc($v[$x]) . ", " : stderr('Error', "{$x} is empty");
            }
            $holder = substr($holder, 0, -1);
            $holder = rtrim($holder, ',');
            $updateset[] = "UPDATE rules SET {$holder} WHERE id = " . sqlesc(intval($v['rules_id']));
        }
    }
    
    foreach ($updateset as $x) {
        sql_query($x) or sqlerr(__FILE__, __LINE__);
    }
    if (mysqli_affected_rows($GLOBALS["___mysqli_ston"]) == -1)
        stderr("SQL Error", "Update failed");
    header("Refresh: 3; url=staffpanel.php?tool=rules_admin");
    $mc1->delete_value('rules__');
    stderr("Info", "Updated successfully! Please wait while you are redirected.");
}
function Do_Cat_Update()
{
    global $mc1;
    $cat_id = (int) $_POST['cat'];
    $min_view = sqlesc(intval($_POST['min_view']));
    if (!is_valid_id($cat_id))
        stderr("Error", "No values");
    if (empty($_POST['name']) || (strlen($_POST['name']) > 100))
        stderr("Error", "No value or value too big");
    if (empty($_POST['shortcut']) || (strlen($_POST['shortcut']) > 100))
        stderr("Error", "No value or value too big");
    $sql = "UPDATE rules_cat SET name = " . sqlesc(strip_tags($_POST['name'])) . ", shortcut = " . sqlesc($_POST['shortcut']) . ", min_view=$min_view WHERE id=" . sqlesc($cat_id);
    sql_query($sql) or sqlerr(__FILE__, __LINE__);
    if (mysqli_affected_rows($GLOBALS["___mysqli_ston"]) == -1)
        stderr("Warning", "Could not carry out that request");
    header("Refresh: 3; url=staffpanel.php?tool=rules_admin");
    $mc1->delete_value('rules__');
    stderr("Info", "Updated successfully! Please wait while you are redirected.");
}
function Do_Cat_Add()
{
    global $INSTALLER09, $mc1;
    $htmlout = '';
    if (empty($_POST['name']) || strlen($_POST['name']) > 100)
        stderr("Error", "Field is blank or length too long!");
    if (empty($_POST['shortcut']) || strlen($_POST['shortcut']) > 100)
        stderr("Error", "Field is blank or length too long!");
    $cat_name = sqlesc(strip_tags($_POST['name']));
    $cat_scut = sqlesc(strip_tags($_POST['shortcut']));
    $min_view = sqlesc(strip_tags($_POST['min_view']));
    $sql = "INSERT INTO rules_cat (name, shortcut, min_view) VALUES ($cat_name, $cat_scut, $min_view)";
    sql_query($sql) or sqlerr(__FILE__, __LINE__);
    if (mysqli_affected_rows($GLOBALS["___mysqli_ston"]) == -1)
        stderr("Warning", "Couldn't forefill that request");
    $mc1->delete_value('rules__');
    $htmlout .= New_Cat_Form(1);
    echo stdhead("Add New Title") . $htmlout . stdfoot();
    exit();
}
function Do_Rules_Add()
{
    global $lang, $mc1;
    $cat_id = sqlesc(intval($_POST['cat']));
    if (!is_valid_id($cat_id))
        stderr("Error", "No id");
    if (empty($_POST['title']) || empty($_POST['text']) || strlen($_POST['title']) > 100)
        stderr("Error", "Field is blank or length too long! <a href='staffpanel.php?tool=rules_admin'>Go Back</a>");
    $title = sqlesc(strip_tags($_POST['title']));
    $text = sqlesc($_POST['text']);
    $sql = "INSERT INTO rules (type, title, text) VALUES ($cat_id, $title, $text)";
    sql_query($sql) or sqlerr(__FILE__, __LINE__);
    if (mysqli_affected_rows($GLOBALS["___mysqli_ston"]) == -1)
        stderr("Warning", "Couldn't forefill that request");
    $mc1->delete_value('rules__');
    New_Rules_Form(1);
    exit();
}
function New_Cat_Form()
{
    global $CURUSER, $lang;
    $htmlout = '';
    $maxclass = $CURUSER['class'];
    $htmlout .= "<h2>Add A New Title</h2>
<form class='form-inline' name='inputform' method='post' action='staffpanel.php?tool=rules_admin'>
    <table class='table table-bordered table-striped'>
                <tr>
<input type='hidden' name='mode' value='cat_add' />
<td align='left'><input class='form-control' placeholder='NAME' type='text' value='' name='name'></td>
<td><input class='form-control' placeholder='SHORTCUT' type='text' value='' name='shortcut'></td>
<td><select class='form-control'  name='min_view'>";
    for ($i = 0; $i <= $maxclass; ++$i) {
        $htmlout .= '<option value="' . $i . '">' . get_user_class_name($i) . '</option>';
    }
    $htmlout .= "</select></td>
<td colspan='3'><input class='form-control' type='submit' name='submit' value='Add' class='btn btn-default' /></td>
</tr></table></form>";
    echo stdhead("Add New Category") . $htmlout . stdfoot();
    exit();
}
function New_Rules_Form()
{
    global $CURUSER, $lang;
    $htmlout = '';
    $sql = sql_query("SELECT * FROM rules_cat") or sqlerr(__FILE__, __LINE__);
    if (!mysqli_num_rows($sql))
        stderr("Error", "There Are No Categories. <br /><br />
<span class='btn'><a href='{$INSTALLER09['baseurl']}/staffpanel.php?tool=rules_admin&amp;mode=cat_add'>Add Category</a></span>");
    $htmlout .= "
<div class='container'>
<div class='row'>
<div class='col-sm-10 col-sm-offset-1 panel'><h2>Add A New section</h2>
<form class='form-inline' name='inputform' method='post' action='staffpanel.php?tool=rules_admin'>
<input class='form-control' type='hidden' name='mode' value='takeadd_rules' />
<input class='form-control' placeholder='TYPE' type='hidden'type='text' value='' name='type'>
<input class='form-control' placeholder='TITLE' type='text' value='' name='title'><br><br>
<select class='form-control' name='cat'>
<option value=''>--Select--</option>";
    while ($v = mysqli_fetch_assoc($sql)) {
        $htmlout .= "<option value='" . intval($v['id']) . "'>" . htmlsafechars($v['name']) . "</option>";
    }
    $htmlout .= "</select><br /><br />
<textarea name='text' rows='15' cols='20' class='textbox' style='width:650px;'>
</textarea><br />
<input class='form-control' type='submit' name='save_cat' value='Add' class='btn btn-default' />
</form></div></div></div>";
    echo stdhead("Add New Rule") . $htmlout . stdfoot();
    exit();
}
function Do_Info($text)
{
    global $INSTALLER09;
    $info = "<div class='infohead'><img src='{$INSTALLER09['pic_base_url']}warned0.gif' alt='Info' title='Info' /> Info</div><div class='infobody'>\n";
    $info .= $text;
    $info .= "</div>";
    $info .= "<a href='staffpanel.php?tool=rules_admin'>Go Back To Admin</a> Or Add another?";
    return $info;
}
function Do_Error($heading, $text)
{
    global $INSTALLER09;
    $htmlout = '';
    $htmlout .= "<div class='errorhead'><img src='{$INSTALLER09['pic_base_url']}warned.gif' alt='Warned' /> $heading</div><div class='errorbody'>\n";
    $htmlout .= "$text\n";
    $htmlout .= "</div>";
    return $htmlout;
    echo stdhead("Error") . $HTMLOUT . stdfoot();
    exit;
}
?> 
