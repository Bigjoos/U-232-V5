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
$lang = array_merge($lang, load_language('ad_traceroute'));
$HTMLOUT = "";
if (strtoupper(substr(PHP_OS, 0, 3) == 'WIN')) {
    $windows = 1;
    $unix = 0;
} else {
    $windows = 0;
    $unix = 1;
}
$register_globals = (bool)ini_get('register_gobals');
$system = ini_get('system');
$unix = (bool)$unix;
$win = (bool)$windows;
if ($register_globals) {
    $ip = getenv(REMOTE_ADDR);
    $self = $PHP_SELF;
} else {
    $action = isset($_POST["action"]) ? $_POST["action"] : '';
    $host = isset($_POST["host"]) ? $_POST["host"] : '';
    $ip = $_SERVER['REMOTE_ADDR'];
    $self = $_SERVER['SCRIPT_NAME'];
}
if ($action == 'do') {
    $host = preg_replace('/[^A-Za-z0-9.]/', '', $host);
    $HTMLOUT.= '<div class="error">';
    $HTMLOUT.= '' . $lang['trace_out'] . '<br />';
    $HTMLOUT.= '<pre>';
    if ($unix) {
        system('' . 'traceroute ' . $host);
        system('killall -q traceroute');
    } else {
        system('' . 'tracert ' . $host);
    }
    $HTMLOUT.= '</pre>';
    $HTMLOUT.= '' . $lang['trace_done'] . '</div>';
} else {
    $HTMLOUT.= '<body bgcolor="#FFFFFF" text="#000000"></body>
    <p><font size="2">' . $lang['trace_ip'] . '' . $ip . '</font></p>
    <form method="post" action="' . $_this_script_ . '">' . $lang['trace_host'] . '<input type="text" class="form-control" name="host" value="' . $ip . '" />
    <input type="hidden" name="action" value="do"><input type="submit" value="' . $lang['trace_submit'] . '" class="btn btn-default" />
   </form>';
    $HTMLOUT.= '<br /><b>' . $system . '</b>';
    $HTMLOUT.= '</body></html>';
}
echo stdhead($lang['trace_stdhead']) . $HTMLOUT . stdfoot();
?>
