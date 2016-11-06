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
//== Group pm - putyn
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
$lang = array_merge($lang, load_language('ad_grouppm'));
$HTMLOUT = '';
$err = array();
$FSCLASS = UC_STAFF; //== First staff class;
$LSCLASS = UC_MAX; //== Last staff class;
$FUCLASS = UC_MIN; //== First users class;
$LUCLASS = UC_STAFF - 1; //== Last users class;
$sent2classes = array();
function classes2name($min, $max)
{
    GLOBAL $sent2classes;
    for ($i = $min; $i < $max + 1; $i++) $sent2classes[] = get_user_class_name($i);
}
function mkint($x)
{
    return (int)$x;
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $groups = isset($_POST["groups"]) ? $_POST["groups"] : "";
    //$groups = isset($_POST["groups"]) ? array_map('mkint',$_POST["groups"]) : ""; //no need for this kind of check because every value its checked inside the switch also the array contains no integer values so that will be a problem
    $subject = isset($_POST["subject"]) ? htmlsafechars($_POST["subject"]) : "";
    $msg = isset($_POST["message"]) ? htmlsafechars($_POST["message"]) : "";
    $msg = str_replace("&amp", "&", $_POST["message"]);
    $sender = isset($_POST["system"]) && $_POST["system"] == "yes" ? 0 : $CURUSER["id"];
    if (empty($subject)) $err[] = $lang['grouppm_nosub'];
    if (empty($msg)) $err[] = $lang['grouppm_nomsg'];
    //$msg .= "\n This is a group message !";
    if (empty($groups)) $err[] = $lang['grouppm_nogrp'];
    if (sizeof($err) == 0) {
        $where = $classes = $ids = array();
        foreach ($groups as $group) {
            if (is_string($group)) {
                switch ($group) {
                case "all_staff":
                    $where[] = "u.class BETWEEN " . $FSCLASS . " and " . $LSCLASS;
                    classes2name($FSCLASS, $LSCLASS);
                    break;

                case "all_users":
                    $where[] = "u.class BETWEEN " . $FUCLASS . " and " . $LSCLASS;
                    classes2name($FUCLASS, $LSCLASS);
                    break;

                case "fls":
                    $where[] = "u.support='yes'";
                    $sent2classes[] = ''.$lang['grouppm_fls'].'';
                    break;

                case "donor":
                    $where[] = "u.donor = 'yes'";
                    $sent2classes[] = ''.$lang['grouppm_donor'].'';
                    break;

                case "all_friends":
                    {$fq = sql_query("SELECT friendid FROM friends WHERE userid=" . sqlesc($CURUSER["id"])) or sqlerr(__FILE__, __LINE__);
                        if (mysqli_num_rows($fq)) while ($fa = mysqli_fetch_row($fq)) $ids[] = $fa[0];
                    }
                    break;
                }
            }
            if (is_numeric($group + 0) && $group + 0 > 0) {
                $classes[] = $group;
                $sent2classes[] = get_user_class_name($group);
            }
        }
        if (sizeof($classes) > 0) $where[] = "u.class IN (" . join(",", $classes) . ")";
        if (sizeof($where) > 0) {
            $q1 = sql_query("SELECT u.id FROM users AS u WHERE " . join(" OR ", $where)) or sqlerr(__FILE__, __LINE__);
            if (mysqli_num_rows($q1) > 0) while ($a = mysqli_fetch_row($q1)) $ids[] = $a[0];
        }
        $ids = array_unique($ids);
        if (sizeof($ids) > 0) {
            $pms = array();
            $msg.= $lang['grouppm_this'] . join(', ', $sent2classes);
            foreach ($ids as $rid) $pms[] = "(" . $sender . "," . $rid . "," . TIME_NOW . "," . sqlesc($msg) . "," . sqlesc($subject) . ")";
            if (sizeof($pms) > 0) $r = sql_query("INSERT INTO messages(sender,receiver,added,msg,subject) VALUES " . join(",", $pms)) or sqlerr(__FILE__, __LINE__);
            $mc1->delete_value('inbox_new_' . $rid);
            $mc1->delete_value('inbox_new_sb_' . $rid);
            $err[] = ($r ? $lang['grouppm_sent'] : $lang['grouppm_again']);
        } else $err[] = $lang['grouppm_nousers'];
    }
}
$groups = array();
$groups['staff'] = array("opname" => $lang['grouppm_staff'],
        "minclass" => UC_USER);
for ($i = $FSCLASS; $i <= $LSCLASS; $i++) $groups['staff']['ops'][$i] = get_user_class_name($i);
$groups['staff']['ops']['fls'] = $lang['grouppm_fls'];
$groups['staff']['ops']['all_staff'] = $lang['grouppm_allstaff'];
$groups['members'] = array();
$groups['members'] = array("opname" => $lang['grouppm_mem'],
        "minclass" => UC_STAFF);
for ($i = $FUCLASS; $i <= $LUCLASS; $i++) $groups['members']['ops'][$i] = get_user_class_name($i);
$groups['members']['ops']['donor'] = $lang['grouppm_donor'];
$groups['members']['ops']['all_users'] = $lang['grouppm_allusers'];
$groups['friends'] = array("opname" => $lang['grouppm_related'],
        "minclass" => UC_USER,
        "ops" => array("all_friends" => $lang['grouppm_friends']));
function dropdown()
{
    global $CURUSER, $groups;
    $r = "<select class='form-control' multiple=\"multiple\" name=\"groups[]\"  size=\"11\" style=\"padding:5px; width:180px;\">";
    foreach ($groups as $group) {
        if ($group["minclass"] >= $CURUSER["class"]) continue;
        $r.= "<optgroup label=\"" . $group["opname"] . "\">";
        $ops = $group["ops"];
        foreach ($ops as $k => $v) $r.= "<option value=\"" . $k . "\">" . $v . "</option>";
        $r.= "</optgroup>";
    }
    $r.= "</select>";
    return $r;
}
$HTMLOUT.= "<div class='row'><div class='col-md-12'>";
if (sizeof($err) > 0) {
    $class = (stristr($err[0], "sent!") == true ? "sent" : "notsent");
    $errs = "<ul><li>" . join("</li><li>", $err) . "</li></ul>";
    $HTMLOUT.= "<div class=\"" . $class . "\">$errs</div>";
}
$HTMLOUT.= "<fieldset style='border:1px solid #333333; padding:5px;'>
	<legend style='padding:3px 5px 3px 5px; border:solid 1px #333333; font-size:12px;font-weight:bold;'>{$lang['grouppm_head']}</legend>
	<form action='staffpanel.php?tool=grouppm&amp;action=grouppm' method='post'>
	  <table class=table table-bordered'>
		<tr>
		  <td nowrap='nowrap' align='left' colspan='2'><b>{$lang['grouppm_sub']}</b> &nbsp;&nbsp;
			<input type='text' name='subject' size='30' style='width:300px;'/></td>
		</tr>
		<tr>
		  <td nowrap='nowrap' valign='top' align='left'><b>{$lang['grouppm_body']}</b></td>
		  <td nowrap='nowrap' align='left'><b>{$lang['grouppm_groups']}</b></td>
		  </tr>
		<tr>
		  <td width='100%' align='center'><textarea name='message' rows='5' cols='32' style='width:500px; height:155px'></textarea></td>
		  <td width='100%' >" . dropdown() . "</td>
		</tr>
		<tr>
		 <td align='left'><label for='sys'>{$lang['grouppm_sendas']}</label><input id='sys' type='checkbox' name='system' value='yes' /></td><td align='right' ><input class='btn btn-default' type='submit' value='{$lang['grouppm_send']}' /></td>
		</tr>
	  </table>
	</form>
	</fieldset>";
$HTMLOUT.= "</div></div><br>";
echo stdhead($lang['grouppm_stdhead']) . $HTMLOUT . stdfoot();
?>
