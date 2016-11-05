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
$lang = array_merge($lang, load_language('ad_ipsearch'));
$HTMLOUT = $ip = $mask = '';
$HTMLOUT.= "<div class='row'><div class='col-md-12'>";
$ip = isset($_GET["ip"]) ? htmlsafechars(trim($_GET["ip"])) : '';
if ($ip) {
    $regex = "/^(((1?\d{1,2})|(2[0-4]\d)|(25[0-5]))(\.\b|$)){4}$/";
    if (!preg_match($regex, $ip)) {
        $HTMLOUT.= stdmsg($lang['ipsearch_error'], $lang['ipsearch_invalid']);
        echo stdhead("IP Search") . $HTMLOUT . stdfoot();
        die();
    }
    $mask = isset($_GET["mask"]) ? htmlsafechars(trim($_GET["mask"])) : '';
    if ($mask == "" || $mask == "255.255.255.255") {
        $where1 = "u.ip = '$ip'";
        $where2 = "ips.ip = '$ip'";
        $dom = @gethostbyaddr($ip);
        if ($dom == $ip || @gethostbyname($dom) != $ip) $addr = "";
        else $addr = $dom;
    } else {
        if (substr($mask, 0, 1) == "/") {
            $n = substr($mask, 1, strlen($mask) - 1);
            if (!is_numeric($n) or $n < 0 or $n > 32) {
                $HTMLOUT.= stdmsg($lang['ipsearch_error'], $lang['ipsearch_subnet']);
                echo stdhead("IP Search") . $HTMLOUT . stdfoot();
                die();
            } else $mask = long2ip(pow(2, 32) - pow(2, 32 - $n));
        } elseif (!preg_match($regex, $mask)) {
            $HTMLOUT.= stdmsg($lang['ipsearch_error'], $lang['ipsearch_subnet']);
            echo stdhead("IP Search") . $HTMLOUT . stdfoot();
            die();
        }
        $where1 = "INET_ATON(u.ip) & INET_ATON('$mask') = INET_ATON('$ip') & INET_ATON('$mask')";
        $where2 = "INET_ATON(ips.ip) & INET_ATON('$mask') = INET_ATON('$ip') & INET_ATON('$mask')";
        $addr = "{$lang['ipsearch_mask']} $mask";
    }
    $queryc = "SELECT COUNT(id) FROM
		   (
			 SELECT u.id FROM users AS u WHERE $where1
			 UNION SELECT u.id FROM users AS u RIGHT JOIN ips ON u.id = ips.userid WHERE $where2
			 GROUP BY u.id
		   ) AS ipsearch";
    $res = sql_query($queryc) or sqlerr(__FILE__, __LINE__);
    $row = mysqli_fetch_array($res);
    $count = $row[0];
    if ($count == 0) {
        $HTMLOUT.= "<br /><b>No users found</b>\n";
        $HTMLOUT.= "</div></div>";
        echo stdhead("IP SEARCH") . $HTMLOUT . stdfoot();
        die;
    }
    $order = isset($_GET['order']) && $_GET['order'];
    $page = isset($_GET['page']) && 0 + $_GET['page'];
    $perpage = 20;
    $pager = pager($perpage, $count, "staffpanel.php?tool=ipsearch&amp;action=ipsearch&amp;ip=$ip&amp;mask=$mask&amp;order=$order&amp;");
    if ($order == "added") $orderby = "added DESC";
    elseif ($order == "username") $orderby = "UPPER(username) ASC";
    elseif ($order == "email") $orderby = "email ASC";
    elseif ($order == "last_ip") $orderby = "last_ip ASC";
    elseif ($order == "last_access") $orderby = "last_ip ASC";
    else $orderby = "access DESC";
    $query1 = "SELECT * FROM (
		  SELECT u.id, u.username, u.ip AS ip, u.ip AS last_ip, u.last_access, u.last_access AS access, u.email, u.invitedby, u.added, u.class, u.uploaded, u.downloaded, u.donor, u.enabled, u.warned, u.leechwarn, u.chatpost, u.pirate, u.king
		  FROM users AS u
		  WHERE $where1
		  UNION SELECT u.id, u.username, ips.ip AS ip, u.ip as last_ip, u.last_access, max(ips.lastlogin) AS access, u.email, u.invitedby, u.added, u.class, u.uploaded, u.downloaded, u.donor, u.enabled, u.warned, u.leechwarn, u.chatpost, u.pirate, u.king
		  FROM users AS u
		  RIGHT JOIN ips ON u.id = ips.userid
		  WHERE $where2
		  GROUP BY u.id ) as ipsearch
		  GROUP BY id
		  ORDER BY $orderby
		  " . $pager['limit'] . "";
    $res = sql_query($query1) or sqlerr(__FILE__, __LINE__);
    $HTMLOUT.="<div class='row><div class='col-md-12'><h4 class='text-center'>" . htmlsafechars($count) . " {$lang['ipsearch_have_used']}" . htmlsafechars($ip) . " (" . htmlsafechars($addr) . ")</h4></div></div>";
    if ($count > $perpage) $HTMLOUT.= $pager['pagertop'];
    $HTMLOUT.= "<table class='table table-bordered'>\n";
    $HTMLOUT.= "<tr>
	  <td class='colhead'><a href='{$INSTALLER09['baseurl']}/staffpanel.php?tool=ipsearch&amp;action=ipsearch&amp;ip=$ip&amp;mask=$mask&amp;order=username'>{$lang['ipsearch_username']}</a></td>" . "<td class='colhead'>{$lang['ipsearch_ratio']}</td>" . "<td class='colhead'><a href='{$INSTALLER09['baseurl']}/staffpanel.php?tool=ipsearch&amp;action=ipsearch&amp;ip=$ip&amp;mask=$mask&amp;order=email'>{$lang['ipsearch_email']}</a></td>" . "<td class='colhead'><a href='{$INSTALLER09['baseurl']}/staffpanel.php?tool=ipsearch&amp;action=ipsearch&amp;ip=$ip&amp;mask=$mask&amp;order=last_ip'>{$lang['ipsearch_ip']}</a></td>" . "<td class='colhead'><a href='{$INSTALLER09['baseurl']}/staffpanel.php?tool=ipsearch&amp;action=ipsearch&amp;ip=$ip&amp;mask=$mask&amp;order=last_access'>{$lang['ipsearch_access']}</a></td>" . "<td class='colhead'>{$lang['ipsearch_num']}</td>" . "<td class='colhead'><a href='{$INSTALLER09['baseurl']}/staffpanel.php?tool=ipsearch&amp;action=ipsearch&amp;ip=$ip&amp;mask=$mask'>{$lang['ipsearch_access']} on <br />" . htmlsafechars($ip) . "</a></td>" . "<td class='colhead'><a href='{$INSTALLER09['baseurl']}/staffpanel.php?tool=ipsearch&amp;action=ipsearch&amp;ip=$ip&amp;mask=$mask&amp;order=added'>{$lang['ipsearch_added']}</a></td>" . "<td class='colhead'>{$lang['ipsearch_invited']}</td></tr>";
    while ($user = mysqli_fetch_assoc($res)) {
        if ($user['added'] == '0') $user['added'] = '---';
        if ($user['last_access'] == '0') $user['last_access'] = '---';
        if ($user['last_ip']) {
            $nip = ip2long($user['last_ip']);
            $res1 = sql_query("SELECT COUNT(*) FROM bans WHERE $nip >= first AND $nip <= last") or sqlerr(__FILE__, __LINE__);
            $array = mysqli_fetch_row($res1);
            if ($array[0] == 0) $ipstr = $user['last_ip'];
            else $ipstr = "<a href='{$INSTALLER09['baseurl']}/staffpanel.php?tool=testip&amp;action=testip&amp;ip=" . htmlsafechars($user['last_ip']) . "'><font color='#FF0000'><b>" . htmlsafechars($user["last_ip"]) . "</b></font></a>";
        } else $ipstr = "---";
        $resip = sql_query("SELECT ip FROM ips WHERE userid=" . sqlesc($user["id"]) . " GROUP BY ips.ip") or sqlerr(__FILE__, __LINE__);
        $iphistory = mysqli_num_rows($resip);
        if ($user["invitedby"] > 0) {
            $res2 = sql_query("SELECT username FROM users WHERE id=" . sqlesc($user["invitedby"]) . "");
            $array = mysqli_fetch_assoc($res2);
            $invitedby = $array["username"];
            if ($invitedby == "") $invitedby = "<i>[{$lang['ipsearch_deleted']}]</i>";
            else $invitedby = "<a href='{$INSTALLER09['baseurl']}/userdetails.php?id={$user['invitedby']}'>" . htmlsafechars($invitedby) . "</a>";
        } else $invitedby = "--";
        $HTMLOUT.= "<tr>
	   	<td><b><a href='{$INSTALLER09['baseurl']}/userdetails.php?id=" . (int)$user['id'] . "'></a></b>" . format_username($user) . "</td>" . "<td>" . member_ratio($user['uploaded'], $user['downloaded']) . "</td>
		  <td style='max-width:130px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;'>" . $user['email'] . "</td><td>" . $ipstr . "</td>
		  <td><div class='text-center'>" . get_date($user['last_access'], 'DATE', 1, 0) . "</div></td>
		  <td><div class='text-center'><b><a href='{$INSTALLER09['baseurl']}/staffpanel.php?tool=iphistory&amp;action=iphistory&amp;id=" . (int)$user['id'] . "'>" . htmlsafechars($iphistory) . "</a></b></div></td>
		  <td><div class='text-center'>" . get_date($user['access'], 'DATE', 1, 0) . "</div></td>
		  <td><div class='text-center'>" . get_date($user['added'], 'DATE', 1, 0) . "</div></td>
		  <td><div class='text-center'>" . $invitedby . "</div></td>
		  </tr>\n";
    }
    $HTMLOUT.= "</table>";
    if ($count > $perpage) $pager['pagerbottom'];
}
echo stdhead($lang['ipsearch_stdhead']) . $HTMLOUT . stdfoot();
die;
?>