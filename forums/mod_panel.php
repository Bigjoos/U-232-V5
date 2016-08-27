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
   if ($CURUSER['class'] >= UC_STAFF || isMod($forumid, "forum")) {
	 $HTMLOUT .="<form method='post' action='forums.php'>
	 <input type='hidden' name='action' value='updatetopic' />
	 <input type='hidden' name='topicid' value='{$topicid}' />";
	 /*$HTMLOUT .= begin_table();*/
	 $HTMLOUT .="<table class='table table-hover table-bordered'>
	 <tr>
	 <td colspan='2' class='colhead'>Staff options</td>
	 </tr>
	 <tr>
	 <td class='rowhead' width='1%'>Sticky</td>
	 <td>
	 <select name='sticky'>
	 <option value='yes'". ($sticky ? " selected='selected'" : '').">Yes</option>
	 <option value='no' ". (!$sticky ? " selected='selected'" : '').">No</option>
	 </select>
	 </td>
	 </tr>
	 <tr>
	 <td class='rowhead'>Locked</td>
	 <td>
	 <select name='locked'>
	 <option value='yes'". ($locked ? " selected='selected'" : '').">Yes</option>
	 <option value='no'". (!$locked ? " selected='selected'" : '').">No</option>
	 </select>
	 </td>
	 </tr>
	 <tr>
	 <td class='rowhead'>Topic name</td>
	 <td>
	 <input type='text' name='topic_name' size='60' maxlength='{$Multi_forum['configs']['maxsubjectlength']}' value='".htmlsafechars($subject)."' />
	 </td>
	 </tr>
	 <tr>
	 <td class='rowhead'>Move topic</td>
	 <td>
	 <select name='new_forumid'>";
	 $res = sql_query("SELECT id, name, min_class_write FROM forums ORDER BY name") or sqlerr(__FILE__, __LINE__);
	 while ($arr = mysqli_fetch_assoc($res))
	 if ($CURUSER['class'] >= $arr["min_class_write"])
	 $HTMLOUT .= '<option value="'.(int)$arr["id"].'"'.($arr["id"] == $forumid ? ' selected="selected"' : '').'>'.htmlsafechars($arr["name"]).'</option>';
	 $HTMLOUT .="</select>
	 </td></tr>
	 <tr>
	 <td class='rowhead' style='white-space:nowrap;'>Delete topic</td>
	 <td>
    <select name='delete'>
	 <option value='no' selected='selected'>No</option>
	 <option value='yes'>Yes</option>
	 </select>
	 <br />
	 <b>Note:</b> Any changes made to the topic won't take effect if you select 'yes'
	 </td>
	 </tr>
	 <tr>
	 <td colspan='2' align='center'>
	 <input type='submit' class='btn btn-primary' value='Update Topic' />
	 </td>
	 </tr>";
	$HTMLOUT .= "</table>";
	/*$HTMLOUT .= end_table();*/
	   $HTMLOUT .="</form>";
	 }
?>
