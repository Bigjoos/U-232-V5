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
$lang = array_merge($lang, load_language('ad_leechwarn'));
$HTMLOUT = "";
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
$do = isset($_GET["do"]) && $_GET["do"] == "disabled" ? "disabled" : "leechwarn";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $r = isset($_POST["ref"]) ? $_POST["ref"] : $this_url;
    $_uids = isset($_POST["users"]) ? array_map('mkint', $_POST["users"]) : 0;
    if ($_uids == 0 || count($_uids) == 0) stderr($lang['leechwarn_stderror'], $lang['leechwarn_nouser']);
    $valid = array(
        "unwarn",
        "disable",
        "delete"
    );
    $act = isset($_POST["action"]) && in_array($_POST["action"], $valid) ? $_POST["action"] : false;
    if (!$act) stderr($lang['leechwarn_stderror'], $lang['leechwarn_wrong']);
    if ($act == "delete") {
        if (sql_query("DELETE FROM users WHERE id IN (" . join(",", $_uids) . ")")) {
            $c = mysqli_affected_rows($GLOBALS["___mysqli_ston"]);
            header("Refresh: 2; url=" . $r);
            stderr($lang['leechwarn_success'], $c . $lang['leechwarn_user'] . ($c > 1 ? $lang['leechwarn_s'] : "") . $lang['leechwarn_deleted']);
        } else stderr($lang['leechwarn_stderror'], $lang['leechwarn_wrong2']);
    }
    if ($act == "disable") {
        if (sql_query("UPDATE users set enabled='no', modcomment=CONCAT(" . sqlesc(get_date(TIME_NOW, 'DATE', 1) . $lang['leechwarn_disabled_by'] . $CURUSER['username'] . "\n") . ",modcomment) WHERE id IN (" . join(",", $_uids) . ")")) {
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
            stderr($lang['leechwarn_success'], $c . $lang['leechwarn_user'] . ($c > 1 ? $lang['leechwarn_s'] : "") . $lang['leechwarn_disabled']);
        } else stderr($lang['leechwarn_stderror'], $lang['leechwarn_wrong3']);
    } elseif ($act == "unwarn") {
        $sub = $lang['leechwarn_removed'];
        $body = $lang['leechwarn_removed_msg1'] . $CURUSER["username"] . $lang['leechwarn_removed_msg2'];
        foreach ($_uids as $uid) $mc1->begin_transaction('MyUser_' . $uid);
        $mc1->update_row(false, array(
            'leechwarn' => 0
        ));
        $mc1->commit_transaction($INSTALLER09['expires']['curuser']);
        $mc1->begin_transaction('user' . $uid);
        $mc1->update_row(false, array(
            'leechwarn' => 0
        ));
        $mc1->commit_transaction($INSTALLER09['expires']['user_cache']);
        $pms = array();
        foreach ($_uids as $id) $pms[] = "(0," . $id . "," . sqlesc($sub) . "," . sqlesc($body) . "," . sqlesc(TIME_NOW) . ")";
        if (count($pms)) {
            $g = sql_query("INSERT INTO messages(sender,receiver,subject,msg,added) VALUE " . join(",", $pms)) or ($q_err = ((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
            $q1 = sql_query("UPDATE users set leechwarn='0', modcomment=CONCAT(" . sqlesc(get_date(TIME_NOW, 'DATE', 1) . $lang['leechwarn_mod'] . $CURUSER['username'] . "\n") . ",modcomment) WHERE id IN (" . join(",", $_uids) . ")") or ($q2_err = ((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
            if ($g && $q1) {
                header("Refresh: 2; url=" . $r);
                stderr($lang['leechwarn_success'], count($pms) . $lang['leechwarn_user'] . (count($pms) > 1 ? $lang['leechwarn_s'] : "") . $lang['leechwarn_removed_success']);
            } else stderr($lang['leechwarn_stderror'], $lang['leechwarn_q1'] . $q_err . "<br />{$lang['leechwarn_q2']}" . $q2_err);
        }
    }
    exit;
}
switch ($do) {
case "disabled":
    $query = "SELECT id,username, class, downloaded, uploaded, IF(downloaded>0, round((uploaded/downloaded),2), '---') as ratio, disable_reason, added, last_access FROM users WHERE enabled='no' ORDER BY last_access DESC ";
    $title = $lang['leechwarn_disabled_title'];
    $link = "<a href=\"staffpanel.php?tool=leechwarn&amp;action=leechwarn&amp;?do=warned\">{$lang['leechwarn_warned_link']}</a>";
    break;

case "leechwarn":
    $query = "SELECT id, username, class, downloaded, uploaded, IF(downloaded>0, round((uploaded/downloaded),2), '---') as ratio, warn_reason, leechwarn, added, last_access FROM users WHERE leechwarn>='1' ORDER BY last_access DESC, leechwarn DESC ";
    $title = $lang['leechwarn_leechwarn_title'];
    $link = "<a href=\"staffpanel.php?tool=leechwarn&amp;action=leechwarn&amp;do=disabled\">{$lang['leechwarn_disabled_link']}</a>";
    break;
}
$g = sql_query($query) or print (((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
$count = mysqli_num_rows($g);
$HTMLOUT .="<div class='row'><div class='col-md-12'><h2>$title&nbsp;<font class=\"small\">[{$lang['leechwarn_total']}" . $count . $lang['leechwarn_user'] . ($count > 1 ? $lang['leechwarn_s'] : "") . "]</font>&nbsp;&nbsp;$link</h2> ";
if ($count == 0) $HTMLOUT.= stdmsg($lang['leechwarn_hey'], $lang['leechwarn_none'] . strtolower($title));
else {
    $HTMLOUT.= "<div class='row'><div class='col-md-12'>
		<form action='staffpanel.php?tool=leechwarn&amp;action=leechwarn' method='post'>
		<table class='table table-bordered'>
		<tr>    	
			<td class='colhead' align='left' width='100%' >{$lang['leechwarn_user2']}</td>
			<td class='colhead' align='center' nowrap='nowrap'>{$lang['leechwarn_ratio']}</td>
			<td class='colhead' align='center' nowrap='nowrap'>{$lang['leechwarn_class']}</td>
			<td class='colhead' align='center' nowrap='nowrap'>{$lang['leechwarn_access']}</td>
			<td class='colhead' align='center' nowrap='nowrap'>{$lang['leechwarn_joined']}</td>
			<td class='colhead' align='center' nowrap='nowrap'><input type='checkbox' name='checkall' /></td>
		</tr>";
    while ($a = mysqli_fetch_assoc($g)) {
        $tip = ($do == "leechwarn" ? $lang['leechwarn_warned_for'] . htmlsafechars($a["warn_reason"]) . "<br />" . $lang['leechwarn_warned_till'] . get_date($a["leechwarn"], 'DATE', 1) . " - " . mkprettytime($a['leechwarn'] - TIME_NOW) : $lang['leechwarn_disabled_for'] . htmlsafechars($a["disable_reason"]));
        $HTMLOUT.= "<tr>
				  <td align='left' width='100%'><a href='userdetails.php?id=" . (int)$a["id"] . "' onmouseover=\"Tip('($tip)')\" onmouseout=\"UnTip()\">" . htmlsafechars($a["username"]) . "</a></td>
				  <td align='left' nowrap='nowrap'>" . (float)$a["ratio"] . "<br /><font class='small'><b>{$lang['leechwarn_d']}</b>" . mksize($a["downloaded"]) . "&nbsp;<b>{$lang['leechwarn_u']}</b> " . mksize($a["uploaded"]) . "</font></td>
				  <td align='center' nowrap='nowrap'>" . get_user_class_name($a["class"]) . "</td>
				  <td align='center' nowrap='nowrap'>" . get_date($a["last_access"], 'LONG', 0, 1) . "</td>
				  <td align='center' nowrap='nowrap'>" . get_date($a["added"], 'DATE', 1) . "</td>
				  <td align='center' nowrap='nowrap'><input type='checkbox' name='users[]' value='" . (int)$a["id"] . "' /></td>
				</tr>";
    }
    $HTMLOUT.= "<tr>
			<td colspan='6' class='colhead' align='center'>
				<select name='action'>
					<option value='unwarn'>{$lang['leechwarn_unwarn']}</option>
					<option value='disable'>{$lang['leechwarn_disable']}</option>
					<option value='delete'>{$lang['leechwarn_delete']}</option>
				</select>
				&raquo;
				<input type='submit' value='{$lang['leechwarn_apply']}' />
				<input type='hidden' value='" . htmlsafechars($_SERVER["REQUEST_URI"]) . "' name='ref' />
			</td>
			</tr>
			</table>
			</form></div></div><br>";
}
$HTMLOUT .= "</div></div><br>";
echo stdhead($title) . $HTMLOUT . stdfoot($stdfoot);
?>
