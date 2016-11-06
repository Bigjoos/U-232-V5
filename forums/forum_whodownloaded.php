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
/****
* Bleach Forums 
* Rev u-232v5
* Credits - Retro-Alex2005-Putyn-pdq-sir_snugglebunny-Bigjoos
* Bigjoos 2015
******
*/
if (!defined('IN_INSTALLER09_FORUM')) {
    $HTMLOUT = '';
    $HTMLOUT.= '<!DOCTYPE html>
        <html xmlns="http://www.w3.org/1999/xhtml" lang="en">
        <head>
        <meta charset="'.charset().'" />
        <title>ERROR</title>
        </head><body>
        <h1 style="text-align:center;">Error</h1>
        <p style="text-align:center;">How did you get here? silly rabbit Trix are for kids!.</p>
        </body></html>';
    echo $HTMLOUT;
    exit();
}
	$fileid = (int)$_GET['fileid'];
	if (!is_valid_id($fileid))
		die('Invalid ID!');
	$res = sql_query("SELECT file_id, at.file_name, at.user_id, username, atdl.times_downloaded, date, at.times_downloaded AS dl ".
					   "FROM attachmentdownloads AS atdl ".
					   "LEFT JOIN attachments AS at ON at.id=atdl.file_id ".
					   "WHERE file_id = ".sqlesc($fileid).($CURUSER['class'] < UC_STAFF ? " AND user_id=".sqlesc($CURUSER['id']) : '')) or sqlerr(__FILE__, __LINE__);
	if (mysqli_num_rows($res) == 0)
	die("<h2 align='center'>Nothing found!</h2>");
	else
	{
	$HTMLOUT = "<!DOCTYPE html>
        <html xmlns='http://www.w3.org/1999/xhtml' lang='en'>
		<head>
    <meta name='generator' content='u-232.servebeer.com' />
	  <meta name='MSSmartTagsPreventParsing' content='TRUE' />
		<title>Who Downloaded</title>
    <link rel='stylesheet' href='{$INSTALLER09['baseurl']}/templates/{$CURUSER['stylesheet']}/{$CURUSER['stylesheet']}.css' type='text/css' />
    </head>
  <body>
	<table width='100%' cellpadding='5' border='1'>
	<tr align='center'>
	<td>File Name</td>
	<td style='white-space: nowrap;'>Downloaded by</td>
	<td>Downloads</td>
	<td>Date</td>
	</tr>";
  $dls = 0;
	while ($arr = mysqli_fetch_assoc($res))
	{
	$HTMLOUT .="<tr align='center'>".
				 "<td>".htmlsafechars($arr['file_name'])."</td>".
				 "<td><a class='pointer' onclick=\"opener.location=('/userdetails.php?id=".(int)$arr['user_id']."'); self.close();\">".htmlsafechars($arr['username'])."</a></td>".
				 "<td>".(int)$arr['times_downloaded']."</td>".
				 "<td>".get_date($arr['date'], 'DATE',1,0)." (".get_date($arr['date'], 'DATE',1,0).")</td>".
				 "</tr>";
	  $dls += (int)$arr['times_downloaded'];
		}
		$HTMLOUT .="<tr><td colspan='4'><b>Total Downloads:</b><b>".number_format($dls)."</b></td></tr></table></body></html>";
	}
	echo($HTMLOUT);
?>
