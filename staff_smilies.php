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
require_once INCL_DIR . 'bbcode_functions.php';
require_once INCL_DIR . 'user_functions.php';
dbconn(false);
loggedinorreturn();
if ($CURUSER["class"] < UC_STAFF) {
    stderr("Error", "Yer no tall enough");
    exit();
}
$lang = array_merge(load_language('global'));
$htmlout = '';
$htmlout = "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\"
		\"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">
		<html xmlns='http://www.w3.org/1999/xhtml'>
		<head>
    <meta name='generator' content='U-232' />
	  <meta name='MSSmartTagsPreventParsing' content='TRUE' />
		<title>Staff Smilies</title>
    <link rel='stylesheet' href='./templates/" . $CURUSER['stylesheet'] . "/" . $CURUSER['stylesheet'] . ".css' type='text/css' />
    </head>
    <body>
    <script type='text/javascript'>
    function SmileIT(smile,form,text){
    window.opener.document.forms[form].elements[text].value = window.opener.document.forms[form].elements[text].value+' '+smile+' ';
    window.opener.document.forms[form].elements[text].focus();
    window.close();
    }
    </script>
    <table class='list' width='100%' cellpadding='1' cellspacing='1'>";
$count = 0;
$ctr = 0;
global $staff_smilies;
while ((list($code, $url) = each($staff_smilies))) {
    if ($count % 3 == 0) $htmlout.= "<tr>";
    $htmlout.= "<td align='center'><a href=\"javascript: SmileIT('" . str_replace("'", "\'", $code) . "','" . htmlsafechars($_GET['form']) . "','" . htmlsafechars($_GET['text']) . "')\"><img border='0' src='./pic/smilies/" . $url . "' alt='' /></a></td>";
    $count++;
    if ($count % 3 == 0) $htmlout.= "</tr>";
}
$htmlout.= "</tr></table><br /><div align='center'><a class='altlink' href='javascript: window.close()'><b>[ Close window ]</b></a></div></body></html>";
echo $htmlout;
?>
