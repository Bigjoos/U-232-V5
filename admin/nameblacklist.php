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
//== Made by putyn
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
$lang = array_merge($lang, load_language('ad_nameblacklist'));
$blacklist = file_exists($INSTALLER09['nameblacklist']) && is_array(unserialize(file_get_contents($INSTALLER09['nameblacklist']))) ? unserialize(file_get_contents($INSTALLER09['nameblacklist'])) : array();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $badnames = isset($_POST['badnames']) && !empty($_POST['badnames']) ? trim($_POST['badnames']) : '';
    if (empty($badnames)) stderr($lang['name_hmm'], $lang['name_think']);
    if (strpos($badnames, ',')) {
        foreach (explode(',', $badnames) as $badname) $blacklist[$badname] = (int)1;
    } else $blacklist[$badnames] = (int)1;
    if (file_put_contents($INSTALLER09['nameblacklist'], serialize($blacklist))) {
        header('Refresh:2; url=staffpanel.php?tool=nameblacklist');
        stderr($lang['name_success'], $lang['name_file']);
    } else stderr($lang['name_err'], ' ' .$lang['name_hmm'] .'<b>' . $INSTALLER09['nameblacklist'] . '</b>' . $lang['name_is'] . '');
} else {
   
$out .= "<div class='row'><div class='col-md-8 col-md-offset-2'>";    
    $out.= stdmsg($lang['name_curr'], count($blacklist) ? join(', ', array_keys($blacklist)) : $lang['name_no']);
    $out.= stdmsg($lang['name_add'], '<form action="staffpanel.php?tool=nameblacklist&amp;action=nameblacklist" method="post"><table class="table table-bordered">
	<tr><td align="center"><textarea rows="3" cols="100" name="badnames"></textarea></td></tr>
    <tr><td align="center">' . $lang['name_note'] . '</td></tr>
	<tr> <td align="center"><input type="submit" value="' . $lang['name_update'] . '"/></td></tr>
	</table></form>');
$out.="</div></div><br>";
        echo (stdhead($lang['name_stdhead']) . $out . stdfoot());
}
?>
