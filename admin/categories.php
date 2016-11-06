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
$lang = array_merge($lang, load_language('ad_categories'));
$params = array_merge($_GET, $_POST);
$params['mode'] = isset($params['mode']) ? $params['mode'] : '';
switch ($params['mode']) {
case 'takemove_cat':
    move_cat();
    break;

case 'move_cat':
    move_cat_form();
    break;

case 'takeadd_cat':
    add_cat();
    break;

case 'takedel_cat':
    delete_cat();
    break;

case 'del_cat':
    delete_cat_form();
    break;

case 'takeedit_cat':
    edit_cat();
    break;

case 'edit_cat':
    edit_cat_form();
    break;

case 'cat_form':
    show_cat_form();
    break;

default:
    show_categories();
    break;
}
function move_cat()
{
    global $INSTALLER09, $params, $mc1, $lang;
    if ((!isset($params['id']) OR !is_valid_id($params['id'])) OR (!isset($params['new_cat_id']) OR !is_valid_id($params['new_cat_id']))) {
        stderr($lang['categories_error'], $lang['categories_no_id']);
    }
    if (!is_valid_id($params['new_cat_id']) OR ($params['id'] == $params['new_cat_id'])) {
        stderr($lang['categories_error'], $lang['categories_move_error2']);
    }
    $old_cat_id = intval($params['id']);
    $new_cat_id = intval($params['new_cat_id']);
    // make sure both categories exist
    $q = sql_query("SELECT id FROM categories WHERE id IN($old_cat_id, $new_cat_id)");
    if (2 != mysqli_num_rows($q)) {
        stderr($lang['categories_error'], $lang['categories_exist_error']);
    }
    //all go
    sql_query("UPDATE torrents SET category = " . sqlesc($new_cat_id) . " WHERE category = " . sqlesc($old_cat_id));
    $mc1->delete_value('genrelist');
    if (-1 != mysqli_affected_rows($GLOBALS["___mysqli_ston"])) {
        header("Location: {$INSTALLER09['baseurl']}/staffpanel.php?tool=categories&action=categories");
    } else {
        stderr($lang['categories_error'], $lang['categories_move_error4']);
    }
}
function move_cat_form()
{
    global $params, $lang;
    if (!isset($params['id']) OR !is_valid_id($params['id'])) {
        stderr($lang['categories_error'], $lang['categories_no_id']);
    }
    $q = sql_query("SELECT * FROM categories WHERE id = " . intval($params['id']));
    if (false == mysqli_num_rows($q)) {
        stderr($lang['categories_error'], $lang['categories_exist_error']);
    }
    $r = mysqli_fetch_assoc($q);
    $check = '';
    $select = "<select name='new_cat_id'>\n<option value='0'>{$lang['categories_select']}</option>\n";
    $cats = genrelist();
    foreach ($cats as $c) {
        $select.= ($c['id'] != $r['id']) ? "<option value='{$c["id"]}'>" . htmlsafechars($c['name'], ENT_QUOTES) . "</option>\n" : "";
    }
    $select.= "</select>\n";
    $check.= "<tr>
      <td align='right' width='50%'><span style='color:limegreen;font-weight:bold;'>{$lang['categories_select_new']}</span></td>
      <td>$select</td>
    </tr>";
    $htmlout = '';
$htlmout .="<div class='row'><div class='col-md-12'>";
    $htmlout.= "<form action='staffpanel.php?tool=categories&amp;action=categories' method='post'>
      <input type='hidden' name='mode' value='takemove_cat' />
      <input type='hidden' name='id' value='".intval($r['id'])."' />
    
      <table class='table table-bordered'>
      <tr>
        <td colspan='2' class='colhead'>". $lang['categories_move_about'] . htmlsafechars($r['name'], ENT_QUOTES) . "</td>
      </tr>
      <tr>
        <td colspan='2'>{$lang['categories_move_note']}</td>
      </tr>
      <tr>
        <td align='right' width='50%'><span style='color:red;font-weight:bold;'>{$lang['categories_move_old']}</span></td>
        <td>" . htmlsafechars($r['name'], ENT_QUOTES) . "</td>
      </tr>
      {$check}
      <tr>
        <td colspan='2' align='center'>
         <input type='submit' class='btn' value='{$lang['categories_move']}' /><input type='button' class='btn' value={$lang['categories_cancel']}' onclick=\"history.go(-1)\" /></td>
      </tr>
      </table>
      </form>";
$htlmout .="</div></div>";
    echo stdhead($lang['categories_move_stdhead']. $r['name']) . $htmlout . stdfoot();
}
function add_cat()
{
    global $INSTALLER09, $params, $mc1, $lang;
    foreach (array(
        'new_cat_name',
        'new_cat_desc',
        'new_cat_image',
        'new_cat_minclass'
    ) as $x) {
        if (!isset($params[$x]) OR ($x != 'new_cat_minclass' AND empty($params[$x]))) stderr($lang['categories_error'], $lang['categories_add_error1']);
    }
    if (!preg_match("/^cat_[A-Za-z0-9_]+\.(?:gif|jpg|jpeg|png)$/i", $params['new_cat_image'])) {
        stderr($lang['categories_error'], $lang['categories_add_error2']);
    }
    $cat_name = sqlesc($params['new_cat_name']);
    $cat_desc = sqlesc($params['new_cat_desc']);
    $cat_image = sqlesc($params['new_cat_image']);
    $min_class = sqlesc($params['new_cat_minclass']);
    sql_query("INSERT INTO categories (name, cat_desc, image, min_class) VALUES($cat_name, $cat_desc, $cat_image, $min_class)");
    $mc1->delete_value('genrelist');
    if (-1 == mysqli_affected_rows($GLOBALS["___mysqli_ston"])) {
        stderr($lang['categories_error'], $lang['categories_exist_error']);
    } else {
        header("Location: {$INSTALLER09['baseurl']}/staffpanel.php?tool=categories&action=categories");
    }
}
function delete_cat()
{
    global $INSTALLER09, $params, $mc1, $lang;
    if (!isset($params['id']) OR !is_valid_id($params['id'])) {
        stderr($lang['categories_error'], $lang['categories_no_id']);
    }
    $q = sql_query("SELECT * FROM categories WHERE id = " . intval($params['id']));
    if (false == mysqli_num_rows($q)) {
        stderr($lang['categories_error'], $lang['categories_exist_error']);
    }
    $r = mysqli_fetch_assoc($q);
    $old_cat_id = intval($r['id']);
    if (isset($params['new_cat_id'])) {
        if (!is_valid_id($params['new_cat_id']) OR ($r['id'] == $params['new_cat_id'])) {
            stderr($lang['categories_error'], $lang['categories_exist_error']);
        }
        $new_cat_id = intval($params['new_cat_id']);
        //make sure category isn't out of range before moving torrents! else orphans!
        $q = sql_query("SELECT COUNT(*) FROM categories WHERE id = " . sqlesc($new_cat_id));
        $count = mysqli_fetch_array($q, MYSQLI_NUM);
        if (!$count[0]) {
            stderr($lang['categories_error'], $lang['categories_exist_error']);
        }
        //all go
        sql_query("UPDATE torrents SET category = " . sqlesc($new_cat_id) . " WHERE category = " . sqlesc($old_cat_id));
    }
    sql_query("DELETE FROM categories WHERE id = " . sqlesc($old_cat_id));
    $mc1->delete_value('genrelist');
    if (mysqli_affected_rows($GLOBALS["___mysqli_ston"])) {
        header("Location: {$INSTALLER09['baseurl']}/staffpanel.php?tool=categories&action=categories");
    } else {
        stderr($lang['categories_error'], $lang['categories_del_error1']);
    }
}
function delete_cat_form()
{
    global $params, $lang;
    if (!isset($params['id']) OR !is_valid_id($params['id'])) {
        stderr($lang['categories_error'], $lang['categories_no_id']);
    }
    $q = sql_query("SELECT * FROM categories WHERE id = " . intval($params['id']));
    if (false == mysqli_num_rows($q)) {
        stderr($lang['categories_error'], $lang['categories_exist_error']);
    }
    $r = mysqli_fetch_assoc($q);
    $q = sql_query("SELECT COUNT(*) FROM torrents WHERE category = " . intval($r['id']));
    $count = mysqli_fetch_array($q, MYSQLI_NUM);
    $check = '';
    if ($count[0]) {
        $select = "<select name='new_cat_id'>\n<option value='0'>{$lang['categories_select']}</option>\n";
        $cats = genrelist();
        foreach ($cats as $c) {
            $select.= ($c['id'] != $r['id']) ? "<option value='{$c["id"]}'>" . htmlsafechars($c['name'], ENT_QUOTES) . "</option>\n" : "";
        }
        $select.= "</select>\n";
        $check.= "<tr>
        <td align='right' width='50%'>{$lang['categories_select_new']}<br /><span style='color:red;font-weight:bold;'>{$lang['categories_del_warning']}</span></td>
        <td>$select</td>
      </tr>";
    }
    $htmlout = '';
$htlmout .="<div class='row'><div class='col-md-12'>";
    $htmlout.= "<form action='staffpanel.php?tool=categories&amp;action=categories' method='post'>
      <input type='hidden' name='mode' value='takedel_cat' />
      <input type='hidden' name='id' value='" . (int)$r['id'] . "' />
    
      <table class='torrenttable' align='center' width='80%' bgcolor='#555555' cellspacing='2' cellpadding='2'>
      <tr>
        <td colspan='2' class='colhead'>{$lang['categories_del_about']}" . htmlsafechars($r['name'], ENT_QUOTES) . "</td>
      </tr>
      <tr>
        <td align='right' width='50%'>{$lang['categories_del_name']}</td>
        <td>" . htmlsafechars($r['name'], ENT_QUOTES) . "</td>
      </tr>
      <tr>
        <td align='right'>{$lang['categories_del_description']}</td>
        <td>" . htmlsafechars($r['cat_desc'], ENT_QUOTES) . "</td>
      </tr>
       <tr>
        <td align='right'>{$lang['categories_show_minclass']}</td>
        <td>" . htmlsafechars(get_user_class_name($r['min_class']), ENT_QUOTES) . "</td>
          </tr>
      <tr>
        <td align='right'>{$lang['categories_del_image']}</td>
        <td>" . htmlsafechars($r['image'], ENT_QUOTES) . "</td>
      </tr>
      {$check}
      <tr>
        <td colspan='2' align='center'>
         <input type='submit' class='btn' value='{$lang['categories_del_delete']}' /><input type='button' class='btn' value='{$lang['categories_cancel']}' onclick=\"history.go(-1)\" /></td>
      </tr>
      </table>
      </form>";
$htlmout .="</div></div>";
    echo stdhead($lang['categories_del_stdhead']. $r['name']) . $htmlout . stdfoot();
}
function edit_cat()
{
    global $INSTALLER09, $params, $mc1, $lang;
    if (!isset($params['id']) OR !is_valid_id($params['id'])) {
        stderr($lang['categories_error'], $lang['categories_no_id']);
    }
    foreach (array(
        'cat_name',
        'cat_desc',
        'cat_image',
        'edit_cat_minclass'
    ) as $x) {
        if (!isset($params[$x]) OR ($x != 'edit_cat_minclass' AND empty($params[$x]))) stderr($lang['categories_error'], $lang['categories_add_error1']);
    }
    if (!preg_match("/^cat_[A-Za-z0-9_]+\.(?:gif|jpg|jpeg|png)$/i", $params['cat_image'])) {
        stderr($lang['categories_error'], $lang['categories_edit_error2']);
    }
    $cat_name = sqlesc($params['cat_name']);
    $cat_desc = sqlesc($params['cat_desc']);
    $cat_image = sqlesc($params['cat_image']);
    $min_class = sqlesc($params['edit_cat_minclass']);
    $cat_id = intval($params['id']);
    sql_query("UPDATE categories SET name = $cat_name, cat_desc = $cat_desc, image = $cat_image, min_class = $min_class WHERE id = $cat_id");
    $mc1->delete_value('genrelist');
    if (-1 == mysqli_affected_rows($GLOBALS["___mysqli_ston"])) {
        stderr($lang['categories_error'], $lang['categories_exist_error']);
    } else {
        header("Location: {$INSTALLER09['baseurl']}/staffpanel.php?tool=categories&action=categories");
    }
}
function edit_cat_form()
{
    global $INSTALLER09, $params, $lang;
    if (!isset($params['id']) OR !is_valid_id($params['id'])) {
        stderr($lang['categories_error'], $lang['categories_no_id']);
    }
    $htmlout = '';
    $q = sql_query("SELECT * FROM categories WHERE id = " . intval($params['id']));
    if (false == mysqli_num_rows($q)) {
        stderr($lang['categories_error'], $lang['categories_exist_error']);
    }
    $r = mysqli_fetch_assoc($q);
    $dh = opendir($INSTALLER09['pic_base_url'] . 'caticons/1');
    $files = array();
    while (false !== ($file = readdir($dh))) {
        if (($file != ".") && ($file != "..")) {
            if (preg_match("/^cat_[A-Za-z0-9_]+\.(?:gif|jpg|jpeg|png)$/i", $file)) {
                $files[] = $file;
            }
        }
    }
    closedir($dh);
    if (is_array($files) AND count($files)) {
        $select = "<select name='cat_image'>\n<option value='0'>{$lang['categories_edit_select']}</option>\n";
        foreach ($files as $f) {
            $selected = ($f == $r['image']) ? " selected='selected'" : "";
            $select.= "<option value='" . htmlsafechars($f, ENT_QUOTES) . "'$selected>" . htmlsafechars($f, ENT_QUOTES) . "</option>\n";
        }
        $select.= "</select>\n";
        $check = "<tr>
        <td align='right' width='50%'>{$lang['categories_edit_select_new']}<br /><span style='color:limegreen;font-weight:bold;'>{$lang['categories_edit_info']}</span></td>
        <td>$select</td>
      </tr>";
    } else {
        $check = "<tr>
        <td align='right' width='50%'>{$lang['categories_edit_select_new']}</td>
        <td><span style='color:red;font-weight:bold;'>{$lang['categories_edit_warning']}</span></td>
      </tr>";
    }
     $minclass = "<select name='edit_cat_minclass'>\n";
     for ($i = 0; $i <= UC_MAX; ++$i) $minclass.= "<option value='$i'" . ($i == $r['min_class'] ? " selected='selected'" : "") . ">" . get_user_class_name($i) . "</option>\n";
    $minclass.= "</select>\n";
    $htmlout.= "<div class='row'><div class='col-md-12'><form action='staffpanel.php?tool=categories&amp;action=categories' method='post'>
      <input type='hidden' name='mode' value='takeedit_cat' />
      <input type='hidden' name='id' value='" . (int)$r['id'] . "' />
    
      <table class='torrenttable' align='center' width='80%' bgcolor='#555555' cellspacing='2' cellpadding='2'>
      <tr>
        <td align='right'>{$lang['categories_edit_name']}</td>
        <td><input type='text' name='cat_name' class='option' size='50' value='" . htmlsafechars($r['name'], ENT_QUOTES) . "' /></td>
      </tr>
      <tr>
        <td align='right'>{$lang['categories_del_description']}</td>
        <td><textarea cols='50' rows='5' name='cat_desc'>" . htmlsafechars($r['cat_desc'], ENT_QUOTES) . "</textarea></td>
      </tr>
          <tr>
            <td align='right'>{$lang['categories_show_minclass']}</td>
            <td>$minclass</td>
          </tr>
      {$check}
      <tr>
        <td colspan='2' align='center'>
         <input type='submit' class='btn' value='{$lang['categories_edit_edit']}' /><input type='button' class='btn' value='{$lang['categories_cancel']}' onclick=\"history.go(-1)\" /></td>
      </tr>
      </table>
      </form></div></div>";
    echo stdhead($lang['categories_edit_stdhead'] . $r['name']) . $htmlout . stdfoot();
}
function show_categories()
{
    global $INSTALLER09, $lang, $minclass;
    $htmlout = '';
    $dh = opendir($INSTALLER09['pic_base_url'] . 'caticons/1');
    $files = array();
    while (false !== ($file = readdir($dh))) {
        if (($file != ".") && ($file != "..")) {
            if (preg_match("/^cat_[A-Za-z0-9_]+\.(?:gif|jpg|jpeg|png)$/i", $file)) {
                $files[] = $file;
            }
        }
    }
    closedir($dh);
    if (is_array($files) AND count($files)) {
        $select = "<select name='new_cat_image'>\n<option value='0'>{$lang['categories_edit_select']}</option>\n";
        foreach ($files as $f) {
            $i = 0;
            $select.= "<option value='" . htmlsafechars($f, ENT_QUOTES) . "'>" . htmlsafechars($f, ENT_QUOTES) . "</option>\n";
            $i++;
        }
        $select.= "</select>\n";
        $check = "<tr>
        <td align='right' width='50%'>{$lang['categories_edit_select_new']}<br /><span style='color:limegreen;font-weight:bold;'>{$lang['categories_edit_warning1']}</span></td>
        <td>$select</td>
      </tr>";
    } else {
        $check = "<tr>
        <td align='right' width='50%'>{$lang['categories_edit_select_new']}</td>
        <td><span style='color:red;font-weight:bold;'{$lang['categories_edit_select_warning']}</span></td>
      </tr>";
    }
    $minclass = "<select name='new_cat_minclass'>\n";
    for ($i = 0; $i <= UC_MAX; ++$i) $minclass.= "<option value='$i'" . ($i == 0 ? " selected='selected'" : "") . ">" . get_user_class_name($i) . "</option>\n";
    $minclass.= "</select>\n";
    $htmlout.= "<div class='row'><div class='col-md-12'>
<form action='staffpanel.php?tool=categories&amp;action=categories' method='post'>
    <input type='hidden' name='mode' value='takeadd_cat' />
    
    <table class='table table-bordered'>
    <tr>
      <td class='colhead' colspan='2' align='center'>
        <b>{$lang['categories_show_make']}</b>
      </td>
    </tr>
    <tr>
      <td align='right'>{$lang['categories_edit_name']}</td>
      <td align='left'><input type='text' name='new_cat_name' size='50' maxlength='50' /></td>
    </tr>
    <tr>
      <td align='right'>{$lang['categories_del_description']}</td>
      <td align='left'><textarea cols='50' rows='5' name='new_cat_desc'></textarea></td>
    </tr>
        <tr>
            <td align='right' width='50%'>{$lang['categories_show_minclass']}</td>
            <td>$minclass</td>
        </tr>
    <!--<tr>
      <td align='right'>{$lang['categories_show_file']}</td>
      <td align='left'><input type='text' name='new_cat_image' class='option' size='50' /></td>
    </tr>-->
    {$check}
    <tr>
      <td colspan='2' align='center'>
        <input type='submit' value='{$lang['categories_show_add']}' class='btn' />
        <input type='reset' value='{$lang['categories_show_reset']}' class='btn' />
      </td>
    </tr>
    </table>
    </form>
</div></div>
<div class='row'><div class='col-md-12'>
    <h2>{$lang['categories_show_head']}</h2>
    <table class='table table-bordered'>
    <tr>
      <td>{$lang['categories_show_id']}</td>
      <td>{$lang['categories_show_name']}</td>
      <td>{$lang['categories_show_descr']}</td>
      <td>{$lang['categories_show_minclass']}</td>
      <td>{$lang['categories_show_image']}</td>
      <td>{$lang['categories_show_edit']}</td>
      <td>{$lang['categories_show_delete']}</td>
      <td>{$lang['categories_show_move']}</td>
    </tr>";
    $query = sql_query("SELECT * FROM categories ORDER BY id ASC");
    if (false == mysqli_num_rows($query)) {
        $htmlout = '<h1>'.$lang['categories_show_oops'].'</h1>';
    } else {
        while ($row = mysqli_fetch_assoc($query)) {
            $cat_image = file_exists($INSTALLER09['pic_base_url'] . 'caticons/1/' . $row['image']) ? "<img border='0' src='{$INSTALLER09['pic_base_url']}caticons/1/" . htmlsafechars($row['image']) . "' alt='" . (int)$row['id'] . "' />" : "{$lang['categories_show_no_image']}";
            $htmlout.= "<tr>
          <td><b>{$lang['categories_show_id2']} (" . (int)$row['id'] . ")</b></td>	
          <td>" . htmlsafechars($row['name']) . "</td>
          <td>" . htmlsafechars($row['cat_desc']) . "</td>
          <td>" . htmlsafechars(get_user_class_name($row['min_class'])) . "</td>
          <td>$cat_image</td>
          <td ><a href='staffpanel.php?tool=categories&amp;action=categories&amp;mode=edit_cat&amp;id=" . (int)$row['id'] . "'>
            <img src='{$INSTALLER09['pic_base_url']}aff_tick.gif' alt='{$lang['categories_show_edit2']}' title='{$lang['categories_show_edit']}' width='12' height='12' border='0' /></a></td>
          <td><a href='staffpanel.php?tool=categories&amp;action=categories&amp;mode=del_cat&amp;id=" . (int)$row['id'] . "'>
            <img src='{$INSTALLER09['pic_base_url']}aff_cross.gif' alt='{$lang['categories_show_delete2']}' title='{$lang['categories_show_delete']}' width='12' height='12' border='0' /></a></td>
          <td><a href='staffpanel.php?tool=categories&amp;action=categories&amp;mode=move_cat&amp;id=" . (int)$row['id'] . "'>
            <img src='{$INSTALLER09['pic_base_url']}plus.gif' alt='{$lang['categories_show_move2']}' title='{$lang['categories_show_move']}' width='12' height='12' border='0' /></a></td>
        </tr>";
        }
    } //endif
    $htmlout.= '</table>';

$htmlout .="</div></div>";


    echo stdhead($lang['categories_show_stdhead']) . $htmlout . stdfoot();
}
?>
