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
//== pdq Class Checker and Verify Staff
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
require_once CLASS_DIR . 'class_check.php';
class_check(UC_MAX);
$lang = array_merge($lang, load_language('ad_staff_config'));
function write_staffs2()
{	
	global $lang;
    //==ids
    $t = '$INSTALLER09';
    $iconfigfile = "<" . "?php\n/**\n{$lang['staffcfg_file_created']}" . date('M d Y H:i:s') . ".\n{$lang['staffcfg_mod_by']}\n**/\n";
    $ri = sql_query("SELECT id, username, class FROM users WHERE class BETWEEN " . UC_STAFF . " AND " . UC_MAX . " ORDER BY id ASC") or sqlerr(__file__, __line__);
    $iconfigfile.= "" . $t . "['allowed_staff']['id'] = array(";
    while ($ai = mysqli_fetch_assoc($ri)) {
        $ids[] = $ai['id'];
        $usernames[] = "'" . $ai["username"] . "' => 1";
    }
    $iconfigfile.= "" . join(",", $ids);
    $iconfigfile.= ");";
    $iconfigfile.= "\n?" . ">";
    $filenum = fopen('./cache/staff_settings.php', 'w');
    ftruncate($filenum, 0);
    fwrite($filenum, $iconfigfile);
    fclose($filenum);
    //==names
    $t = '$INSTALLER09';
    $nconfigfile = "<" . "?php\n/**\n{$lang['staffcfg_file_created']}" . date('M d Y H:i:s') . ".\n{$lang['staffcfg_mod_by']}\n**/\n";
    $nconfigfile.= "" . $t . "['staff']['allowed'] = array(";
    $nconfigfile.= "" . join(",", $usernames);
    $nconfigfile.= ");";
    $nconfigfile.= "\n?" . ">";
    $filenum1 = fopen('./cache/staff_settings2.php', 'w');
    ftruncate($filenum1, 0);
    fwrite($filenum1, $nconfigfile);
    fclose($filenum1);
    stderr($lang['staffcfg_success'], $lang['staffcfg_updated']);
}
write_staffs2();
echo stdhead($lang['staffcfg_stdhead']) . stdfoot();
?>
