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
dbconn(false);
require_once (CLASS_DIR . 'class_check.php');
class_check(UC_STAFF);
loggedinorreturn();
$lang = array_merge(load_language('global'));
$htmlout = '';
$htmlout = "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\"
	\"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">
	<html xmlns='http://www.w3.org/1999/xhtml'>
	<head>
  <meta name='generator' content='TBDev.net' />
	<meta name='MSSmartTagsPreventParsing' content='TRUE' />
  <title>Shoutbox Commands</title>
  <link rel='stylesheet' href='./templates/" . $CURUSER['stylesheet'] . "/" . $CURUSER['stylesheet'] . ".css' type='text/css' />
  </head>
  <body>
  <script type='text/javascript'>
  function command(command,form,text){
  window.opener.document.forms[form].elements[text].value = window.opener.document.forms[form].elements[text].value+command+' ';
  window.opener.document.forms[form].elements[text].focus();
  window.close();
  }
  </script>
  <table class='list' width='100%' cellpadding='1' cellspacing='1'>
  <tr>
  <td align='center'><b>empty</b>. To use type /EMPTY [username here without the brackets]</td>
	<td align='center'><b>gag</b>. To use type /GAG [username here without the brackets]</td>
	</tr>
	<tr>
	<td align='center'><b><input type='text' size='20' value='/EMPTY' onclick=\"command('/EMPTY','shbox','shbox_text')\" /></b></td>
	<td align='center'><b><input type='text' size='20' value='/GAG' onclick=\"command('/GAG','shbox','shbox_text')\" /></b></td>
	</tr>
  <tr>
	<td align='center'><b>ungag</b>. To use type /UNGAG [username here without the brackets]</td>
	<td align='center'><b>disable</b>. To use type /DISABLE [username here without the brackets]</td>
	</tr>
	<tr>
	<td align='center'><b><input type='text' size='20' value='/UNGAG' onclick=\"command('/UNGAG','shbox','shbox_text')\" /></b></td>
	<td align='center'><b><input type='text' size='20' value='/DISABLE' onclick=\"command('/DISABLE','shbox','shbox_text')\" /></b></td>
	</tr>
	<tr>
	<td align='center'><b>enable</b>. To use type /ENABLE [username here without the brackets]</td>
	<td align='center'><b>warn</b>. To use type /WARN [username here without the brackets]</td>
	</tr>
	<tr>
	<td align='center'><b><input type='text' size='20' value='/ENABLE' onclick=\"command('/ENABLE','shbox','shbox_text')\" /></b></td>
	<td align='center'><b><input type='text' size='20' value='/WARN' onclick=\"command('/WARN','shbox','shbox_text')\" /></b></td>
	</tr>
	<tr>
	<td align='center'><b>unwarn</b>. To use type /UNWARN [username here without the brackets]</td>
  <td align='center'><b>System</b>. To use type /System [text here without the brackets]</td>
	</tr>
	<tr>
	<td align='center'><b><input type='text' size='20' value='/UNWARN' onclick=\"command('/UNWARN','shbox','shbox_text')\" /></b></td>
	<td align='center'><b><input type='text' size='20' value='/System' onclick=\"command('/System','shbox','shbox_text')\" /></b></td>
	</tr>
	<tr>
	<td align='center'><b>private</b>. To use type /private [username here without the brackets] then rest of your text</td>
	</tr>
	<tr>
	<td align='center'><b><input type='text' size='20' value='/private' onclick=\"command('/private','shbox','shbox_text')\" /></b></td>
	</tr></table><br /><div align='center'><a class='altlink' href='javascript: window.close()'><b>[ Close window ]</b></a></div></body></html>";
echo $htmlout;
?>
