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
/*
  function deny_access($def) {
        global $INSTALLER09;
    if (!defined($def)) {
        //== browsers and user agents that support xhtml
                if (stristr($_SERVER['HTTP_ACCEPT'], 'application/xhtml+xml')) {
                        header('Content-type: application/xhtml+xml; charset='.$INSTALLER09['char_set']);
                        $doctype = '<?xml version="1.0" encoding="'.$INSTALLER09['char_set'].'" ?>'.
                                   '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" '.
                               '"http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">'.
                       '<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="'.$INSTALLER09['language'].'">';
                }
                //== browsers and user agents that DO NOT support xhtml
                else {
                header('Content-type: text/html; charset='.$INSTALLER09['char_set']);
                        $doctype = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" '.
                                   '"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">'.
                                       '<html xmlns="http://www.w3.org/1999/xhtml">';
                }
                echo $doctype.
                         '<head>'.
                         '<style type="text/css">div#error{font-size:33px;color:white;background-color:red;text-align:center;}</style>'.
                         '<title>ERROR</title>'.
                 '</head><body>'.
             '<div id="error">Incorrect access<br />You cannot access this file directly.</div>'.
             '</body></html>';
        
        exit();
    }
}


  deny_access('IN_INSTALLER09_ADMIN');
*/
require_once (INCL_DIR . 'user_functions.php');
require_once (CLASS_DIR . 'class_check.php');
$class = get_access(basename($_SERVER['REQUEST_URI']));
class_check($class);
//error_reporting(E_ALL);
$lang = array_merge($lang, load_language('ad_allagents'));
$HTMLOUT = '';
$res = sql_query("SELECT agent, peer_id FROM peers GROUP BY agent") or sqlerr(__FILE__, __LINE__);
$HTMLOUT.= "<div class='row'><div class='col-md-12'><table class='table table-bordered'>
	<tr><td class='colhead'>{$lang['allagents_client']}</td><td class='colhead'>{$lang['allagents_peerid']}</td></tr>";
while ($arr = mysqli_fetch_assoc($res)) {
    $HTMLOUT.= "<tr><td align='left'>" . htmlsafechars($arr["agent"]) . "</td><td align='left'>" . htmlsafechars($arr["peer_id"]) . "</td></tr>\n";
}
$HTMLOUT.= "</table></div></div>\n";
echo stdhead($lang['allagents_allclients']) . $HTMLOUT . stdfoot();
?>
