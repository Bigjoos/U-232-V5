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
require_once (INCL_DIR . 'pager_functions.php');
require_once (CLASS_DIR . 'class_check.php');
$class = get_access(basename($_SERVER['REQUEST_URI']));
class_check($class);
$lang = array_merge($lang, load_language('ad_acp'));
$stdfoot = array(
    /** include js **/
    'js' => array(
        'acp'
    )
);
$HTMLOUT = "";
if (isset($_POST['ids'])) {
    $ids = $_POST["ids"];
    foreach ($ids as $id) if (!is_valid_id($id)) stderr($lang['std_error'], $lang['text_invalid']);
    $do = isset($_POST["do"]) ? htmlsafechars(trim($_POST["do"])) : '';
    if ($do == 'enabled') sql_query("UPDATE users SET enabled = 'yes' WHERE ID IN(" . join(', ', array_map('sqlesc',$ids)) . ") AND enabled = 'no'") or sqlerr(__FILE__, __LINE__);
    $mc1->begin_transaction('MyUser_' . $id);
    $mc1->update_row(false, array(
        'enabled' => 'yes'
    ));
    $mc1->commit_transaction($INSTALLER09['expires']['curuser']);
    $mc1->begin_transaction('user' . $id);
    $mc1->update_row(false, array(
        'enabled' => 'yes'
    ));
    $mc1->commit_transaction($INSTALLER09['expires']['user_cache']);
    //else
    if ($do == 'confirm') sql_query("UPDATE users SET status = 'confirmed' WHERE ID IN(" . join(', ', array_map('sqlesc', $ids)) . ") AND status = 'pending'") or sqlerr(__FILE__, __LINE__);
    $mc1->begin_transaction('MyUser_' . $id);
    $mc1->update_row(false, array(
        'status' => 'confirmed'
    ));
    $mc1->commit_transaction($INSTALLER09['expires']['curuser']);
    $mc1->begin_transaction('user' . $id);
    $mc1->update_row(false, array(
        'status' => 'confirmed'
    ));
    $mc1->commit_transaction($INSTALLER09['expires']['user_cache']);
    //else
    if ($do == 'delete') sql_query("DELETE FROM users WHERE ID IN(" . join(', ', array_map('sqlesc',$ids)) . ") AND class < 3") or sqlerr(__FILE__, __LINE__);
    else {
        header('Location: staffpanel.php?tool=acpmanage&amp;action=acpmanage');
        exit;
    }
}
$disabled = number_format(get_row_count("users", "WHERE enabled='no'"));
$pending = number_format(get_row_count("users", "WHERE status='pending'"));
$count = number_format(get_row_count("users", "WHERE enabled='no' OR status='pending' ORDER BY username DESC"));
$perpage = 25;
$pager = pager($perpage, $count, "staffpanel.php?tool=acpmanage&amp;action=acpmanage&amp;");
$res = sql_query("SELECT id, username, added, downloaded, uploaded, last_access, class, donor, warned, enabled, status FROM users WHERE enabled='no' OR status='pending' ORDER BY username DESC {$pager['limit']}");
 $HTMLOUT.= "<div class='row'><div class='col-md-12'><table class='table table-bordered'><tr><td>{$lang['text_du']}  $disabled</td><td> {$lang['text_pu']}  $pending</td></tr></table></div><br>";
if (mysqli_num_rows($res) != 0) {
    if ($count > $perpage) $HTMLOUT.= $pager['pagertop'];
    $HTMLOUT.= "<div class='col-md-12'>";
    $HTMLOUT.= "<form action='staffpanel.php?tool=acpmanage&amp;action=acpmanage' method='post'>";
    $HTMLOUT.= "<table class='table table-bordered'>";
    $HTMLOUT.= "<tr align='center'><td class='colhead'>
	  <input style='margin:0' type='checkbox' title='" . $lang['text_markall'] . "' value='" . $lang['text_markall'] . "' onclick=\"this.value=check(form);\" /></td>
	  <td class='colhead'>{$lang['text_username']}</td>
	  <td class='colhead' style='white-space: nowrap;'>{$lang['text_reg']}</td>
	  <td class='colhead' style='white-space: nowrap;'>{$lang['text_la']}</td>
	  <td class='colhead'>{$lang['text_class']}</td>
	  <td class='colhead'>{$lang['text_dload']}</td>
	  <td class='colhead'>{$lang['text_upload']}</td>
	  <td class='colhead'>{$lang['text_ratio']}</td>
	  <td class='colhead'>{$lang['text_status']}</td>
	  <td class='colhead' style='white-space: nowrap;'>{$lang['text_enabled']}</td>
	  </tr>";
    while ($arr = mysqli_fetch_assoc($res)) {
        $uploaded = mksize($arr["uploaded"]);
        $downloaded = mksize($arr["downloaded"]);
        $ratio = $arr['downloaded'] > 0 ? $arr['uploaded'] / $arr['downloaded'] : 0;
        $ratio = number_format($ratio, 2);
        $color = get_ratio_color($ratio);
        if ($color) $ratio = "<font color='$color'>$ratio</font>";
        $added = get_date($arr['added'], 'LONG', 0, 1);
        $last_access = get_date($arr['last_access'], 'LONG', 0, 1);
        $class = get_user_class_name($arr["class"]);
        $status = htmlsafechars($arr['status']);
        $enabled = htmlsafechars($arr['enabled']);
        $HTMLOUT.= "<tr align='center'><td><input type=\"checkbox\" name=\"ids[]\" value=\"" . (int)$arr['id'] . "\" /></td><td><a href='/userdetails.php?id=" . (int)$arr['id'] . "'><b>" . htmlsafechars($arr['username']) . "</b></a>" . ($arr["donor"] == "yes" ? "<img src='pic/star.gif' border='0' alt='" . $lang['text_donor'] . "' />" : "") . ($arr["warned"] >= 1 ? "<img src='pic/warned.gif' border='0' alt='" . $lang['text_warned'] . "' />" : "") . "</td>
		<td style='white-space: nowrap;'>{$added}</td>
		<td style='white-space: nowrap;'>{$last_access}</td>
		<td>{$class}</td>
		<td>{$downloaded}</td>
		<td>{$uploaded}</td>
		<td>{$ratio}</td>
		<td>{$status}</td>
		<td>{$enabled}</td>
		</tr>\n";
    }
    $HTMLOUT.= "<tr><td colspan='10' align='center'><select name='do'><option value='enabled' disabled='disabled' selected='selected'>{$lang['text_wtd']}</option><option value='enabled'>{$lang['text_es']}</option><option value='confirm'>{$lang['text_cs']}</option><option value='delete'>{$lang['text_ds']}</option></select><input type='submit' value='" . $lang['text_submit'] . "' /></td></tr>";
    $HTMLOUT.= "</table>";
    $HTMLOUT.= "</form>";
 $HTMLOUT.= "</div>";
       if ($count > $perpage) $HTMLOUT.= $pager['pagerbottom'];
} else $HTMLOUT.= stdmsg($lang['std_sorry'], $lang['std_nf']);
 $HTMLOUT.= "</div>";
echo stdhead($lang['text_stdhead']) . $HTMLOUT . stdfoot($stdfoot);
?>
