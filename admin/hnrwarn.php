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
$lang = array_merge($lang, load_language('ad_hnrwarn'));
$HTMLOUT = '';
function mkint($x)
{
    return (int)$x;
}
$stdfoot = array(
    /** include js **/
    'js' => array(
        'wz_tooltip'
    )
);
$this_url = $_SERVER["SCRIPT_NAME"];
$do = isset($_GET["do"]) && $_GET["do"] == "disabled" ? "disabled" : "hnrwarn";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $r = isset($_POST["ref"]) ? $_POST["ref"] : $this_url;
    $_uids = isset($_POST["users"]) ? array_map('mkint', $_POST["users"]) : 0;
    if ($_uids == 0 || count($_uids) == 0) stderr($lang['hnrwarn_stderror'], $lang['hnrwarn_nouser']);
    $valid = array(
        "unwarn",
        "disable",
        "delete"
    );
    $act = isset($_POST["action"]) && in_array($_POST["action"], $valid) ? $_POST["action"] : false;
    if (!$act) stderr($lang['hnrwarn_stderror'], $lang['hnrwarn_wrong']);
    if ($act == "delete") {
        if (sql_query("DELETE FROM users WHERE id IN (" . join(",", $_uids) . ")")) {
            $c = mysqli_affected_rows($GLOBALS["___mysqli_ston"]);
            header("Refresh: 2; url=" . $r);
            stderr($lang['hnrwarn_success'], $c . $lang['hnrwarn_user'] . ($c > 1 ? $lang['hnrwarn_s'] : "") . $lang['hnrwarn_deleted']);
        } else stderr($lang['hnrwarn_stderror'], $lang['hnrwarn_wrong']);
    }
    if ($act == "disable") {
        if (sql_query("UPDATE users set enabled='no', modcomment=CONCAT(" . sqlesc(get_date(TIME_NOW, 'DATE', 1) . $lang['hnrwarn_disabled'] . $CURUSER['username'] . "\n") . ",modcomment) WHERE id IN (" . join(",", $_uids) . ")")) {
            foreach ($_uids as $uid) $mc1->begin_transaction('MyUser_' . $uid);
            $mc1->update_row(false, array(
                'enabled' => 'no'
            ));
            $mc1->commit_transaction($INSTALLER09['expires']['curuser']);
            $mc1->begin_transaction('user' . $uid);
            $mc1->update_row(false, array(
                'enabled' => 'no'
            ));
            $mc1->commit_transaction($INSTALLER09['expires']['user_cache']);
            $d = mysqli_affected_rows($GLOBALS["___mysqli_ston"]);
            header("Refresh: 2; url=" . $r);
            stderr($lang['hnrwarn_success'], $d . $lang['hnrwarn_user'] . ($d > 1 ? $lang['hnrwarn_s'] : "") . " disabled!");
        } else stderr($lang['hnrwarn_stderror'], $lang['hnrwarn_wrong3']);
    } elseif ($act == "unwarn") {
        $sub = $lang['hnrwarn_removed'];
        $body = $lang['hnrwarn_msg1'] . $CURUSER["username"] . $lang['hnrwarn_msg2'];
        $pms = array();
        foreach ($_uids as $id) $pms[] = "(0," . $id . "," . sqlesc($sub) . "," . sqlesc($body) . "," . sqlesc(TIME_NOW) . ")";
        $mc1->begin_transaction('MyUser_' . $id);
        $mc1->update_row(false, array(
            'hnrwarn' => 'no'
        ));
        $mc1->commit_transaction($INSTALLER09['expires']['curuser']);
        $mc1->begin_transaction('user' . $id);
        $mc1->update_row(false, array(
            'hnrwarn' => 'no'
        ));
        $mc1->commit_transaction($INSTALLER09['expires']['user_cache']);
        if (count($pms)) {
            $g = sql_query("INSERT INTO messages(sender,receiver,subject,msg,added) VALUE " . join(",", $pms)) or sqlerr(__FILE__, __LINE__);
            $q1 = sql_query("UPDATE users set hnrwarn='no', modcomment=CONCAT(" . sqlesc(get_date(TIME_NOW, 'DATE', 1) . $lang['hnrwarn_rem_log'] . $CURUSER['username'] . "\n") . ",modcomment) WHERE id IN (" . join(",", $_uids) . ")") or sqlerr(__FILE__, __LINE__);
            if ($g && $q1) {
                header("Refresh: 2; url=" . $r);
                stderr($lang['hnrwarn_success'], count($pms) . $lang['hnrwarn_user'] . (count($pms) > 1 ? "s" : "") . $lang['hnrwarn_rem_suc']);
            } else stderr($lang['hnrwarn_stderror'], $lang['hnrwarn_q1'] . $q_err . "<br />{$lang['hnrwarn_q2']}" . $q1_err);
        }
    }
    exit;
}
switch ($do) {
case "disabled":
    $query = "SELECT id,username, class, downloaded, uploaded, IF(downloaded>0, round((uploaded/downloaded),2), '---') as ratio, disable_reason, added, last_access FROM users WHERE enabled='no' ORDER BY last_access DESC ";
    $title = $lang['hnrwarn_disabled_title'];
    $link = "<a href=\"staffpanel.php?tool=hnrwarn&amp;action=hnrwarn&amp;?do=warned\">{$lang['hnrwarn_users']}</a>";
    break;

case "hnrwarn":
    $query = "SELECT id, username, class, downloaded, uploaded, IF(downloaded>0, round((uploaded/downloaded),2), '---') as ratio, warn_reason, hnrwarn, added, last_access FROM users WHERE hnrwarn='yes' ORDER BY last_access DESC, hnrwarn DESC ";
    $title = $lang['hnrwarn_warned_title'];
    $link = "<a href=\"staffpanel.php?tool=hnrwarn&amp;action=hnrwarn&amp;do=disabled\">{$lang['hnrwarn_disabled_users']}</a>";
    break;
}
$g = sql_query($query) or sqlerr(__FILE__, __LINE__);
$count = mysqli_num_rows($g);
$HTMLOUT .="<div class='row'><div class='col-md-12'><h2>$title&nbsp;<font class=\"small\">[total - " . $count . " user" . ($count > 1 ? "s" : "") . "]</font>&nbsp;&nbsp;$link</h2> ";
if ($count == 0) $HTMLOUT.= stdmsg($lang['hnrwarn_hey'], $lang['hnrwarn_none'] . strtolower($title));
else {
    $HTMLOUT.= "<div class='row'><div class='col-md-12'>
		<form action='staffpanel.php?tool=hnrwarn&amp;action=hnrwarn' method='post'>
		<table class='table table-bordered'>
		<tr>    	
			<td class='colhead' align='left' width='100%' >{$lang['hnrwarn_form_user']}</td>
			<td class='colhead' align='center' nowrap='nowrap'>{$lang['hnrwarn_form_ratio']}</td>
			<td class='colhead' align='center' nowrap='nowrap'>{$lang['hnrwarn_form_class']}</td>
			<td class='colhead' align='center' nowrap='nowrap'>{$lang['hnrwarn_form_access']}</td>
			<td class='colhead' align='center' nowrap='nowrap'>{$lang['hnrwarn_form_join']}</td>
			<td class='colhead' align='center' nowrap='nowrap'><input type='checkbox' name='checkall' /></td>
		</tr>";
    while ($a = mysqli_fetch_assoc($g)) {
        $tip = ($do == "hnrwarn" ? $lang['hnrwarn_tip1'] . htmlsafechars($a["warn_reason"]) . "<br />" : $lang['hnrwarn_tip2'] . htmlsafechars($a["disable_reason"]));
        $HTMLOUT.= "<tr>
				  <td align='left' width='100%'><a href='userdetails.php?id=" . (int)$a["id"] . "' onmouseover=\"Tip('($tip)')\" onmouseout=\"UnTip()\">" . htmlsafechars($a["username"]) . "</a></td>
				  <td align='left' nowrap='nowrap'>" . (float)$a["ratio"] . "<br /><font class='small'><b>{$lang['hnrwarn_d']}</b>" . mksize($a["downloaded"]) . "&nbsp;<b>{$lang['hnrwarn_u']}</b> " . mksize($a["uploaded"]) . "</font></td>
				  <td align='center' nowrap='nowrap'>" . get_user_class_name($a["class"]) . "</td>
				  <td align='center' nowrap='nowrap'>" . get_date($a["last_access"], 'LONG', 0, 1) . "</td>
				  <td align='center' nowrap='nowrap'>" . get_date($a["added"], 'DATE', 1) . "</td>
				  <td align='center' nowrap='nowrap'><input type='checkbox' name='users[]' value='" . (int)$a["id"] . "' /></td>
				</tr>";
    }
    $HTMLOUT.= "<tr>
			<td colspan='6' class='colhead' align='center'>
				<select name='action'>
					<option value='unwarn'>{$lang['hnrwarn_unwarn']}</option>
					<option value='disable'>{$lang['hnrwarn_disable2']}</option>
					<option value='delete'>{$lang['hnrwarn_delete']}</option>
				</select>
				&raquo;
				<input type='submit' value='{$lang['hnrwarn_apply']}' />
				<input type='hidden' value='" . htmlsafechars($_SERVER["REQUEST_URI"]) . "' name='ref' />
			</td>
			</tr>
			</table>
			</form></div></div><br>";
}

$HTMLOUT .= "</div></div><br>";

echo stdhead($title) . $HTMLOUT . stdfoot($stdfoot);
?>
