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
    echo $HTMLOUT;
    exit();
}
    $subaction = (isset($_GET["subaction"]) ? htmlsafechars($_GET["subaction"]) : (isset($_POST["subaction"]) ? htmlsafechars($_POST["subaction"]) : ''));
    $pollid = (isset($_GET["pollid"]) ? (int)$_GET["pollid"] : (isset($_POST["pollid"]) ? (int)$_POST["pollid"] : 0));
    $topicid = (isset($_POST["topicid"]) ? (int)$_POST["topicid"] : 0);
    if ($subaction == "edit") {
        if (!is_valid_id($pollid))
            stderr("Error", "Invalid ID!");
        $res = sql_query("SELECT pp.*, t.id AS tid FROM postpolls AS pp LEFT JOIN topics AS t ON t.poll_id = pp.id WHERE pp.id=".sqlesc($pollid)) or sqlerr(__FILE__, __LINE__);
        if (mysqli_num_rows($res) == 0)
            stderr("Error", "No poll found with that ID.");
        $poll = mysqli_fetch_assoc($res);
    }
    if ($_SERVER["REQUEST_METHOD"] == "POST" && !$topicid)
	{
		$topicid = ($subaction == "edit" ? (int)$poll['tid'] : (int)$_POST["updatetopicid"]);
		$question = htmlsafechars($_POST["question"]);
		$option0 = htmlsafechars($_POST["option0"]);
		$option1 = htmlsafechars($_POST["option1"]);
		$option2 = htmlsafechars($_POST["option2"]);
		$option3 = htmlsafechars($_POST["option3"]);
		$option4 = htmlsafechars($_POST["option4"]);
		$option5 = htmlsafechars($_POST["option5"]);
		$option6 = htmlsafechars($_POST["option6"]);
		$option7 = htmlsafechars($_POST["option7"]);
		$option8 = htmlsafechars($_POST["option8"]);
		$option9 = htmlsafechars($_POST["option9"]);
		$option10 = htmlsafechars($_POST["option10"]);
		$option11 = htmlsafechars($_POST["option11"]);
		$option12 = htmlsafechars($_POST["option12"]);
		$option13 = htmlsafechars($_POST["option13"]);
		$option14 = htmlsafechars($_POST["option14"]);
		$option15 = htmlsafechars($_POST["option15"]);
		$option16 = htmlsafechars($_POST["option16"]);
		$option17 = htmlsafechars($_POST["option17"]);
		$option18 = htmlsafechars($_POST["option18"]);
		$option19 = htmlsafechars($_POST["option19"]);
		$sort = htmlsafechars($_POST["sort"]);
		if (!$question || !$option0 || !$option1)
			stderr("Error", "Missing form data!");
		if ($subaction == "edit" && is_valid_id($pollid))
			sql_query("UPDATE postpolls SET " .
							"question = " . sqlesc($question) . ", " .
							"option0 = " . sqlesc($option0) . ", " .
							"option1 = " . sqlesc($option1) . ", " .
							"option2 = " . sqlesc($option2) . ", " .
							"option3 = " . sqlesc($option3) . ", " .
							"option4 = " . sqlesc($option4) . ", " .
							"option5 = " . sqlesc($option5) . ", " .
							"option6 = " . sqlesc($option6) . ", " .
							"option7 = " . sqlesc($option7) . ", " .
							"option8 = " . sqlesc($option8) . ", " .
							"option9 = " . sqlesc($option9) . ", " .
							"option10 = " . sqlesc($option10) . ", " .
							"option11 = " . sqlesc($option11) . ", " .
							"option12 = " . sqlesc($option12) . ", " .
							"option13 = " . sqlesc($option13) . ", " .
							"option14 = " . sqlesc($option14) . ", " .
							"option15 = " . sqlesc($option15) . ", " .
							"option16 = " . sqlesc($option16) . ", " .
							"option17 = " . sqlesc($option17) . ", " .
							"option18 = " . sqlesc($option18) . ", " .
							"option19 = " . sqlesc($option19) . ", " .
							"sort = " . sqlesc($sort) . " " .
					"WHERE id = ".sqlesc((int)$poll["id"])) or sqlerr(__FILE__, __LINE__);
		else
		{
			if (!is_valid_id($topicid))
				stderr('Error', 'Invalid topic ID!');
			sql_query("INSERT INTO postpolls VALUES(id" .
							", " . sqlesc(TIME_NOW) .
							", " . sqlesc($question) .
							", " . sqlesc($option0) .
							", " . sqlesc($option1) .
							", " . sqlesc($option2) .
							", " . sqlesc($option3) .
							", " . sqlesc($option4) .
							", " . sqlesc($option5) .
							", " . sqlesc($option6) .
							", " . sqlesc($option7) .
							", " . sqlesc($option8) .
							", " . sqlesc($option9) .
							", " . sqlesc($option10) .
							", " . sqlesc($option11) .
							", " . sqlesc($option12) .
							", " . sqlesc($option13) .
							", " . sqlesc($option14) .
							", " . sqlesc($option15) .
							", " . sqlesc($option16) .
							", " . sqlesc($option17) .
							", " . sqlesc($option18) .
							", " . sqlesc($option19) .
							", " . sqlesc($sort).")") or sqlerr(__FILE__, __LINE__);
			$pollnum = ((is_null($___mysqli_res = mysqli_insert_id($GLOBALS["___mysqli_ston"]))) ? false : $___mysqli_res);
			sql_query("UPDATE topics SET poll_id=".sqlesc($pollnum)." WHERE id=".sqlesc($topicid)) or sqlerr(__FILE__, __LINE__);
		}
		header("Location: {$INSTALLER09['baseurl']}/forums.php?action=viewtopic&topicid=$topicid");
		exit();
	}
	$HTMLOUT .= begin_main_frame();
	if ($subaction == "edit")
	$HTMLOUT .="<h1>Edit poll</h1>";
	$HTMLOUT .="<form method='post' action='forums.php'>
   <input type='hidden' name='action' value='".$action."' />
	<input type='hidden' name='subaction' value='".$subaction."' />
	<input type='hidden' name='updatetopicid' value='".$topicid."' />
	<table border='1' cellspacing='0' cellpadding='5' width='100%'>";
	if ($subaction == "edit")
	{
	$HTMLOUT .="<input type='hidden' name='pollid' value='".(int)$poll["id"]."'>";
	}
	$HTMLOUT .="
	<tr><td class='rowhead'>Question <font color='red'>*</font></td><td align='left'><textarea name='question' cols='70' rows='4'>". ($subaction == "edit" ? htmlsafechars($poll['question']) : '')."</textarea></td></tr>
	<tr><td class='rowhead'>Option 1 <font color='red'>*</font></td><td align='left'><input name='option0' size='80' maxlength='40' value='". ($subaction == "edit" ? htmlsafechars($poll['option0']) : '')."' /><br /></td></tr>
	<tr><td class='rowhead'>Option 2 <font color='red'>*</font></td><td align='left'><input name='option1' size='80' maxlength='40' value='". ($subaction == "edit" ? htmlsafechars($poll['option1']) : '')."' /><br /></td></tr>
	<tr><td class='rowhead'>Option 3</td><td align='left'><input name='option2' size='80' maxlength='40' value='".($subaction == "edit" ? htmlsafechars($poll['option2']) : '')."' /><br /></td></tr>
	<tr><td class='rowhead'>Option 4</td><td align='left'><input name='option3' size='80' maxlength='40' value='". ($subaction == "edit" ? htmlsafechars($poll['option3']) : '')."' /><br /></td></tr>
	<tr><td class='rowhead'>Option 5</td><td align='left'><input name='option4' size='80' maxlength='40' value='". ($subaction == "edit" ? htmlsafechars($poll['option4']) : '')."' /><br /></td></tr>
	<tr><td class='rowhead'>Option 6</td><td align='left'><input name='option5' size='80' maxlength='40' value='". ($subaction == "edit" ? htmlsafechars($poll['option5']) : '')."' /><br /></td></tr>
	<tr><td class='rowhead'>Option 7</td><td align='left'><input name='option6' size='80' maxlength='40' value='". ($subaction == "edit" ? htmlsafechars($poll['option6']) : '')."' /><br /></td></tr>
	<tr><td class='rowhead'>Option 8</td><td align='left'><input name='option7' size='80' maxlength='40' value='". ($subaction == "edit" ? htmlsafechars($poll['option7']) : '')."' /><br /></td></tr>
	<tr><td class='rowhead'>Option 9</td><td align='left'><input name='option8' size='80' maxlength='40' value='". ($subaction == "edit" ? htmlsafechars($poll['option8']) : '')."' /><br /></td></tr>
	<tr><td class='rowhead'>Option 10</td><td align='left'><input name='option9' size='80' maxlength='40' value='". ($subaction == "edit" ? htmlsafechars($poll['option9']) : '')."' /><br /></td></tr>
	<tr><td class='rowhead'>Option 11</td><td align='left'><input name='option10' size='80' maxlength='40' value='". ($subaction == "edit" ? htmlsafechars($poll['option10']) : '')."' /><br /></td></tr>
	<tr><td class='rowhead'>Option 12</td><td align='left'><input name='option11' size='80' maxlength='40' value='". ($subaction == "edit" ? htmlsafechars($poll['option11']) : '')."' /><br /></td></tr>
	<tr><td class='rowhead'>Option 13</td><td align='left'><input name='option12' size='80' maxlength='40' value='". ($subaction == "edit" ? htmlsafechars($poll['option12']) : '')."' /><br /></td></tr>
	<tr><td class='rowhead'>Option 14</td><td align='left'><input name='option13' size='80' maxlength='40' value='". ($subaction == "edit" ? htmlsafechars($poll['option13']) : '')."' /><br /></td></tr>
	<tr><td class='rowhead'>Option 15</td><td align='left'><input name='option14' size='80' maxlength='40' value='". ($subaction == "edit" ? htmlsafechars($poll['option14']) : '')."' /><br /></td></tr>
	<tr><td class='rowhead'>Option 16</td><td align='left'><input name='option15' size='80' maxlength='40' value='". ($subaction == "edit" ? htmlsafechars($poll['option15']) : '')."' /><br /></td></tr>
	<tr><td class='rowhead'>Option 17</td><td align='left'><input name='option16' size='80' maxlength='40' value='". ($subaction == "edit" ? htmlsafechars($poll['option16']) : '')."' /><br /></td></tr>
	<tr><td class='rowhead'>Option 18</td><td align='left'><input name='option17' size='80' maxlength='40' value='". ($subaction == "edit" ? htmlsafechars($poll['option17']) : '')."' /><br /></td></tr>
	<tr><td class='rowhead'>Option 19</td><td align='left'><input name='option18' size='80' maxlength='40' value='". ($subaction == "edit" ? htmlsafechars($poll['option18']) : '')."' /><br /></td></tr>
	<tr><td class='rowhead'>Option 20</td><td align='left'><input name='option19' size='80' maxlength='40' value='". ($subaction == "edit" ? htmlsafechars($poll['option19']) : '')."' /><br /></td></tr>
	<tr><td class='rowhead'>Sort</td><td>
	<input type='radio' name='sort' value='yes' ". ($subaction == "edit" ? ($poll["sort"] != "no" ? " checked='checked'" : "") : '')." />Yes
	<input type='radio' name='sort' value='no' ".  ($subaction == "edit" ? ($poll["sort"] == "no" ? " checked='checked'" : "") : '')." />No
	</td></tr>
	<tr><td colspan='2' align='center'><input type='submit' value='". ($pollid ? 'Edit poll' : 'Create poll')."' style='height: 20pt' /></td></tr>
	</table>
	<p align='center'><font color='red'>*</font> required</p>
	</form>";
	$HTMLOUT .= end_main_frame(); 
	echo stdhead("Polls") . $HTMLOUT . stdfoot($stdfoot);
?>
