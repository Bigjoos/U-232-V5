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
require_once (__DIR__ . DIRECTORY_SEPARATOR . 'include' . DIRECTORY_SEPARATOR . 'bittorrent.php');
require_once (INCL_DIR . 'user_functions.php');
require_once INCL_DIR . 'html_functions.php';
dbconn(false);
loggedinorreturn();
$lang = array_merge(load_language('global'));
require_once ROOT_DIR . 'radio.php';
$HTMLOUT = '';
$HTMLOUT = "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\"
		\"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">
		<html xmlns='http://www.w3.org/1999/xhtml'>
		<head>
    <meta name='generator' content='u-232.com' />
	 <meta name='MSSmartTagsPreventParsing' content='TRUE' />
	 <title>{$INSTALLER09['site_name']} Radio</title>
    <link rel='stylesheet' href='./templates/" . $CURUSER['stylesheet'] . "/" . $CURUSER['stylesheet'] . ".css' type='text/css' />
    </head>
    <body>";
$HTMLOUT.= "<script type='text/javascript'>
    /*<![CDATA[*/
    function roll_over(img_name, img_src)
    {
    document[img_name].src=img_src;
    }
    /*]]>*/
    </script>";
$HTMLOUT.= "<h2>{$INSTALLER09['site_name']} Site Radio</h2>" . "<div  align=\"center\">" . "<a href=\"http://" . $radio['host'] . ":" . $radio['port'] . "/listen.pls\" onmouseover=\"roll_over('winamp', 'pic/winamp_over.png')\" onmouseout=\"roll_over('winamp', 'pic/winamp.png')\" style=\"border:hidden;\" ><img src=\"pic/winamp.png\" name=\"winamp\" alt=\"Click here to listen with Winamp\" title=\"Click here to listen with Winamp\" style=\"border:hidden;\" /></a>" . "<a href=\"http://" . $radio['host'] . ":" . $radio['port'] . "/listen.asx\" onmouseover=\"roll_over('wmp', 'pic/wmp_over.png')\" onmouseout=\"roll_over('wmp', 'pic/wmp.png')\" style=\"border:hidden;\" ><img src=\"pic/wmp.png\" name=\"wmp\" alt=\"Click here to listen with Windows Media Player\" title=\"Click here to listen with Windows Media Player\" style=\"border:hidden;\" /></a>" . "</div>" . radioinfo($radio);
$HTMLOUT.= "<div align='center'><a class='altlink' href='javascript: window.close()'><b>[ Close window ]</b></a></div></body></html>";
echo $HTMLOUT;
?>
