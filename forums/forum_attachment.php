<?php
/**
 |--------------------------------------------------------------------------|
 |   https://github.com/Bigjoos/                			    |
 |--------------------------------------------------------------------------|
 |   Licence Info: GPL						            |
 |--------------------------------------------------------------------------|
 |   Copyright (C) 2010 U-232 V5				            |
 |--------------------------------------------------------------------------|
 |   A bittorrent tracker source based on TBDev.net/tbsource/bytemonsoon.   |
 |--------------------------------------------------------------------------|
 |   Project Leaders: Mindless, Autotron, whocares, Swizzles.		    |
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
	@ini_set('zlib.output_compression', 'Off');
	@set_time_limit(0);
	if (@ini_get('output_handler') == 'ob_gzhandler' && @ob_get_length() !== false)
	{
		@ob_end_clean();
		header('Content-Encoding:');
	}
	$id = (int)$_GET['attachmentid'];
	if (!is_valid_id($id))
		die('Invalid Attachment ID!');
	$at = sql_query("SELECT filename, owner, type FROM attachments WHERE id=".sqlesc($id)) or sqlerr(__FILE__, __LINE__);
	$resat = mysqli_fetch_assoc($at) or die('No attachment with that ID!');
	$filename = $Multi_forum['configs']['attachment_dir'].'/'.$resat['filename'];
	if (!is_file($filename))
		die('Inexistent atachment.');
	if (!is_readable($filename))
		die('Attachment is unreadable.');
	if ((isset($_GET['subaction']) ? htmlsafechars($_GET['subaction']) : '') == 'delete')
	{
		if ($CURUSER['id'] <> $resat["owner"] && $CURUSER['class'] < UC_STAFF)
			die('Not your attachment to delete.');
		unlink($filename);
		sql_query("DELETE attachments, attachmentdownloads ".
					"FROM attachments ".
					"LEFT JOIN attachmentdownloads ON attachmentdownloads.fileid = attachments.id ".
					"WHERE attachments.id=".sqlesc($id)) or sqlerr(__FILE__, __LINE__);
		die("<font color='red'>File successfully deleted...</font>");
	}
	sql_query("UPDATE attachments SET downloads=downloads+1 WHERE id=".sqlesc($id)) or sqlerr(__FILE__, __LINE__);
	$res = sql_query("SELECT fileid FROM attachmentdownloads WHERE fileid=".sqlesc($id)." AND userid=".sqlesc($CURUSER['id'])) or sqlerr(__FILE__, __LINE__);
	if (mysqli_num_rows($res) == 0)
		sql_query("INSERT INTO attachmentdownloads (fileid, username, userid, date, downloads) VALUES (".sqlesc($id).", ".sqlesc($CURUSER['username']).", ".sqlesc($CURUSER['id']).", ".TIME_NOW.", 1)") or sqlerr(__FILE__, __LINE__);
	else
		sql_query("UPDATE attachmentdownloads SET downloads = downloads + 1 WHERE fileid = ".sqlesc($id)." AND userid = ".sqlesc($CURUSER['id'])) or sqlerr(__FILE__, __LINE__);
	$arr=0;
	header("Pragma: public");
	header("Expires: 0");
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	header("Cache-Control: private", false); // required for certain browsers 
	header("Content-Type: ".$arr['type']."");
	header("Content-Disposition: attachment; filename=\"".basename($filename)."\";" );
	header("Content-Transfer-Encoding: binary");
	header("Content-Length: ".filesize($filename));
	readfile($filename);
	exit();
?>
