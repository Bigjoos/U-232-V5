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
// -------- Action: Edit post
    $postid = (int)$_GET["postid"];
    if (!is_valid_id($postid))
    stderr('Error', 'Invalid ID!');
    $res = sql_query("SELECT p.user_id, p.topic_id, p.icon, p.body, t.locked, t.forum_id  " . "FROM posts AS p " . "LEFT JOIN topics AS t ON t.id = p.topic_id " . "WHERE p.id = ".sqlesc($postid)) or sqlerr(__FILE__, __LINE__);
    if (mysqli_num_rows($res) == 0)
        stderr("Error", "No post with that ID!");
    $arr = mysqli_fetch_assoc($res);
    if (($CURUSER["id"] != $arr["user_id"] || $arr["locked"] == 'yes') && $CURUSER['class'] < UC_STAFF && !isMod($arr["forum_id"], "forum"))
        stderr("Error", "Access Denied!");
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $body = trim(htmlsafechars($_POST['body']));
        $posticon = (isset($_POST["iconid"]) ? 0 + $_POST["iconid"] : 0);
        if (empty($body))
            stderr("Error", "Body cannot be empty!");
        if(!isset($_POST['lasteditedby']))
	      sql_query("UPDATE posts SET body=".sqlesc($body).", edit_date=".TIME_NOW.", edited_by=".sqlesc($CURUSER['id']).", icon=".sqlesc($posticon)." WHERE id=".sqlesc($postid)) or sqlerr(__FILE__, __LINE__);
        else
	      sql_query("UPDATE posts SET body=".sqlesc($body).", icon=".sqlesc($posticon)." WHERE id=".sqlesc($postid)) or sqlerr(__FILE__, __LINE__);
        header("Location: {$INSTALLER09['baseurl']}/forums.php?action=viewtopic&topicid=".(int)$arr['topic_id']."&page=p$postid#p$postid");
        exit();
    }
    if ($INSTALLER09['forums_online'] == 0)
    $HTMLOUT .= stdmsg('Warning', 'Forums are currently in maintainance mode');
    $HTMLOUT .= begin_main_frame();
	 $HTMLOUT .="<h3>Edit Post</h3>";
	 $HTMLOUT .="<form name='compose' method='post' action='{$INSTALLER09['baseurl']}/forums.php?action=editpost&amp;postid=".$postid."'>
	 <table border='1' cellspacing='0' cellpadding='5' width='100%'>
	 <tr>
	 <td class='rowhead' width='10%'>Body</td>
	 <td align='left' style='padding: 0px'>";
    $ebody = htmlsafechars($arr["body"]);
    if (function_exists('textbbcode'))
    $HTMLOUT .= textbbcode('compose', 'body', isset($ebody) ? $ebody : '');
    else {
    $HTMLOUT .="<textarea name='body' style='width:99%' rows='7'>{$ebody}</textarea>";
    }
	 $HTMLOUT .="</td></tr>";
	 if ($CURUSER["class"] >= UC_STAFF)
    $HTMLOUT.="<tr><td colspan='1' align='center'><input type='checkbox' name='lasteditedby' /></td><td align='left' colspan='1'>Don't show the Last edited by <font class='small'>(Staff Only)</font></td></tr>";
	 $HTMLOUT.="<tr>
	 <td align='center' colspan='2'>
	 ".(post_icons($arr["icon"]))."
	 </td>
	 </tr>
	 <tr>
	 <td align='center' colspan='2'>
	 <input type='submit' class='btn btn-primary' value='Update post' class='gobutton' />
	 </td>
	 </tr>
	 </table>
	 </form>";
    $HTMLOUT .= end_main_frame();
    echo stdhead("Edit Post", true, $stdhead) . $HTMLOUT . stdfoot($stdfoot);
    exit;
?>
