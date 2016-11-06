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
$lang = array_merge($lang, load_language('ad_ipcheck'));
$HTMLOUT = "";
$res = sql_query("SELECT count(*) AS dupl, ip FROM users WHERE enabled = 'yes' AND ip <> '' AND ip <> '127.0.0.0' GROUP BY ip ORDER BY dupl DESC, ip") or sqlerr(__FILE__, __LINE__);
$HTMLOUT.= "<div class='row'><div class='col-md-12'>";
$HTMLOUT.= "<table class='table table-bordered'>
<tr>
 <td>{$lang['ipcheck_user']}</td>
 <td>{$lang['ipcheck_email']}</td>
 <td>{$lang['ipcheck_regged']}</td>
 <td>{$lang['ipcheck_lastacc']}</td>
 " . ($INSTALLER09['ratio_free'] ? "" : "<td>{$lang['ipcheck_dload']}</td>") . "
 <td>{$lang['ipcheck_upped']}</td>
 <td>{$lang['ipcheck_ratio']}</td>
 <td>{$lang['ipcheck_ip']}</td></tr>\n";
$ip = '';
$uc = 0;
while ($ras = mysqli_fetch_assoc($res)) {
    if ($ras["dupl"] <= 1) break;

    if ($ip <> $ras['ip']) {
        $ros = sql_query("SELECT id, username, class, email, chatpost, pirate, king, leechwarn, added, last_access, downloaded, uploaded, ip, warned, donor, enabled FROM users WHERE ip=" . sqlesc($ras['ip']) . " ORDER BY id") or sqlerr(__FILE__, __LINE__);
        $num2 = mysqli_num_rows($ros);
        if ($num2 > 1) {
            $uc++;
            while ($arr = mysqli_fetch_assoc($ros)) {
                if ($arr['added'] == '0') $arr['added'] = '-';
                if ($arr['last_access'] == '0') $arr['last_access'] = '-';
                $uploaded = mksize($arr["uploaded"]);
                $downloaded = mksize($arr["downloaded"]);
                $added = get_date($arr['added'], 'DATE', 1, 0);
                $last_access = get_date($arr['last_access'], '', 1, 0);
                if ($uc % 2 == 0) $utc = "";
                else $utc = " bgcolor=\"333333\"";
                $HTMLOUT.= "<tr$utc><td align='left'><a href='userdetails.php?id=" . (int)$arr['id'] . "'>" . format_username($arr, true) . "</a></td>
                                  <td style='max-width:130px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;'>" . htmlsafechars($arr['email']) . "</td>
                                  <td>$added</td>
                                  <td>$last_access</td>
                                  " . ($INSTALLER09['ratio_free'] ? "" : "<td align='center'>$downloaded</td>") . "
                                  <td>$uploaded</td>
                                  <td>" . member_ratio($arr['uploaded'], $INSTALLER09['ratio_free'] ? '0' : $arr['downloaded']) . "</td>
                                  <td><span style=\"font-weight: bold;\">" . htmlsafechars($arr['ip']) . "</span></td>\n</tr>\n";
                $ip = htmlsafechars($arr["ip"]);
            }
        }
    }
}
$HTMLOUT.="</table>";
$HTMLOUT.="</div></div>";
echo stdhead($lang['ipcheck_stdhead']) . $HTMLOUT . stdfoot();
?>
