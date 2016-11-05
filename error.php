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
$string = $_SERVER['QUERY_STRING'];
if ($string == '404') {
    $page = 'Page Not Found - 404';
    $text = 'Sorry, The page you are looking for cannot be found.';
}
if ($string == '401') {
    $page = 'Authorization Required - 401';
    $text = 'You need to be Authorized to access this page. You do not have the correct credentials.';
}
if ($string == '403') {
    $page = 'Forbidden - 403';
    $text = 'You do not have full permission to access this page.';
}
if ($string == '500') {
    $page = 'Internal Server Error - 500';
    $text = 'There seems to have been an error on this server. Please notify the webmaster of the site.';
}
if ($string == '400') {
    $page = 'Bad Request - 400';
    $text = 'There has been an error with the page you are trying to view. Please try again later.';
}
$domain = htmlsafechars($_SERVER['HTTP_HOST']);
$htmlout = '';
$htmlout = "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\"
		\"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">
		<html xmlns='http://www.w3.org/1999/xhtml'>
		<head>
    <meta http-equiv='refresh' content='5; url=http://" . $domain . "' />
    <meta name='generator' content='u-232.servebeer.com' />
	  <meta name='MSSmartTagsPreventParsing' content='TRUE' />
		<title>{$page}</title>
    <style type='text/css'>
    <!--
    body
    {
    margin: 4;
    background-color: white;
    }
    p
    {
    margin: 0;
    font-family: Arial, Arial, Helvetica, sans-serif;
    color: #000000;
    font-size: 14px;
    }
    .style1 {	color: #666666;
	  font-family: Arial, Helvetica, sans-serif;
	  font-size: 12px;
    }
    -->
    </style>
    </head>
    <body>
    <div align='center'>
    <table width='300' border='0' cellpadding='0' cellspacing='0'>
    <!--Error pic layout-->
    <tr>
    <td width='300' height='50' valign='top'><!--Error 404 EmptyCell-->&nbsp;</td>
    </tr>
    <tr>
    <td height='520' valign='top'><img src='{$INSTALLER09['pic_base_url']}error404.png' alt='Error Not Found' width='300' height='520' border='0' usemap='#Map' /></td>
    </tr>
    <tr>
    <td height='14' valign='top'><div align='center'><span class='style1'>&copy; U-232 V3</span></div></td>
    </tr>
    </table></div><map name='Map' id='map'>
    <area shape='rect' coords='99,425,203,481' alt='Error Not Found' />
    </map>
    <p align='center'><b>{$page}</b></p>
    <p align='center'>{$text}</p><br />
    <p align='center'>You will be redirected back to {$domain} in 5 seconds</p>
    </body>
    </html>";
echo $htmlout;
