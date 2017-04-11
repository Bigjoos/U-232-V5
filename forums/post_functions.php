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
//== Putyns post icons
function post_icons($s = 0)
{
    global $INSTALLER09;
    $body = "<table width=\"100%\" cellspacing=\"0\" cellpadding=\"8\" >
				 <tr><td width=\"20%\" valign=\"top\" align=\"right\"><strong>Post Icons</strong> <br/>
				 <font class=\"small\">(Optional)</font></td>\n";
    $body .= "<td width=\"80%\" align=\"left\">\n";
    for($i = 1; $i < 15;$i++) {
        $body .= "<input type=\"radio\" value=\"{$i}\" name=\"iconid\" ".($s == $i ? "checked=\"checked\"" : "")." />\n<img align=\"middle\" alt=\"Post icon\" src=\"{$INSTALLER09['pic_base_url']}post_icons/icon{$i}.gif\"/>\n";
        if ($i == 14)
        $body .= "";
    }
    $body .= "<br /><input type=\"radio\" value=\"0\" name=\"iconid\"  ".($s == 0 ? "checked=\"checked\"" : "")." />[Use None]\n";
    $body .= "</td></tr></table>\n";
    return $body;
}
//-------- Inserts a compose frame
function insert_quick_jump_menu($currentforum = 0)
{
	global $CURUSER, $INSTALLER09;
	$htmlout='';
	$htmlout .="
	<form method='get' action='{$INSTALLER09['baseurl']}/forums.php' name='jump'>
	<input type='hidden' name='action' value='viewforum' />
	<div align='right'>Quick jump:
	<font color='black'><select  name='forumid' onchange=\"if(this.options[this.selectedIndex].value != -1){ forms['jump'].submit() }\">";
	$res = sql_query("SELECT id, name, min_class_read FROM forums ORDER BY name") or sqlerr(__FILE__, __LINE__);
	while ($arr = mysqli_fetch_assoc($res))
	if ($CURUSER['class'] >= $arr["min_class_read"])
	$htmlout .="<option value='".(int)$arr["id"].($currentforum == $arr["id"] ? " selected='selected'" : "")."'>".htmlsafechars($arr["name"])."</option>";
   $htmlout .="</select></font>
	<input type='submit' value='Go!' class='btn btn-default btn-sm dropdown-toggle' />
	</div>
	</form>";
  return $htmlout;
  }
// -------- Inserts a compose frame
    function insert_compose_frame($id, $newtopic = true, $quote = false, $attachment = false)
   {
    global  $CURUSER, $INSTALLER09, $Multi_forum;
    $htmlout='';
    if ($newtopic) {
        $res = sql_query("SELECT name FROM forums WHERE id=".sqlesc($id)) or sqlerr(__FILE__, __LINE__);
        $arr = mysqli_fetch_assoc($res) or die("Bad forum ID!");
       // $htmlout .="<h3>New topic in <a href='{$INSTALLER09['baseurl']}/forums.php?action=viewforum&amp;forumid=".$id."'>".htmlsafechars($arr["name"])."</a> forum</h3>";
        						   $htmlout .="<!--<div class='navigation'>
				<a href='index.php'>" . $INSTALLER09["site_name"] . "</a> 
				&gt;
				<a href='forums.php'>Forums</a>
				&gt;
				<a href='{$INSTALLER09['baseurl']}/forums.php?action=viewforum&amp;forumid=".$id."'>".htmlsafechars($arr["name"])."</a>
				<br><img src='templates/1/pic/carbon/nav_bit.png' alt=''>
				<span class='active'>New Topic</span>
				</div><br />-->";
		} else {
        $res = sql_query("SELECT t.forum_id, t.topic_name, t.locked, f.min_class_read, f.name AS forum_name FROM topics AS t LEFT JOIN forums AS f ON f.id = t.forum_id WHERE t.id=".sqlesc($id)) or sqlerr(__FILE__, __LINE__);
        $arr = mysqli_fetch_assoc($res) or die("Forum error, Topic not found.");
		$forum = htmlsafechars($arr["forum_name"]);
		$forumid = (int)$arr['forum_id'];
        if ($arr['locked'] == 'yes') {
            stderr("Sorry", "The topic is locked.");
            $htmlout .= end_table();
            $htmlout .= end_main_frame();
            echo stdhead("Compose" , true, $stdhead) . $htmlout . stdfoot($stdfoot);
            exit();
        }
        if($CURUSER["class"] < $arr["min_class_read"]){
		    $htmlout .= stdmsg("Sorry", "You are not allowed in here.");
				$htmlout .= end_table(); 
				$htmlout .= end_main_frame(); 
				echo stdhead("Compose") . $htmlout . stdfoot();
		    exit();
		    }
						   $htmlout .="<!--<div class='navigation'>
				<a href='index.php'>" . $INSTALLER09["site_name"] . "</a> 
				&gt;
				<a href='forums.php'>Forums</a>
				&gt;
				<a href='{$INSTALLER09['baseurl']}/forums.php?action=viewforum&amp;forumid=".$forumid."'>{$forum}</a>
				&gt;
				<a href='{$INSTALLER09['baseurl']}/forums.php?action=viewtopic&amp;topicid=".$id."'>".htmlsafechars($arr["topic_name"])."</a>
				<br><img src='templates/1/pic/carbon/nav_bit.png' alt=''>
				<span class='active'>Post Reply</span>
				</div><br />-->";
       // $htmlout .="<h3 align='center'>Reply to topic:<a href='{$INSTALLER09['baseurl']}/forums.php?action=viewtopic&amp;topicid=".$id."'>".htmlsafechars($arr["topic_name"])."</a></h3>";
    }
    $htmlout .="
    <script type='text/javascript'>
    /*<![CDATA[*/
    function Preview()
    {
    document.compose.action = './forums.php?action=preview'
    document.compose.target = '_blank';
    document.compose.submit();
    document.compose.action = '{$INSTALLER09['baseurl']}/forums.php';
    document.compose.target = '_self';
    return true;
    }
    /*]]>*/
    </script>";
    //$htmlout .= begin_frame("Compose", true);
    $htmlout .="<form method='post' name='compose' action='{$INSTALLER09['baseurl']}/forums.php' enctype='multipart/form-data'>
	  <input type='hidden' name='action' value='post' />
	  <input type='hidden' name='". ($newtopic ? 'forumid' : 'topicid')."' value='".$id."' />";
    //$htmlout .= begin_table(true);
	$htmlout .="<table border='0' cellspacing='0' cellpadding='5' class='tborder'>
	<tr>
<td class='thead' colspan='2'><strong>Compose</strong></td>
</tr>
	";
    if ($newtopic) {
		$htmlout .="<tr>
			<td class=row width='10%'>Subject</td>
			<td class=row align='left'>
				<input type='text' class='form-control col-md-12' size='100' maxlength='{$Multi_forum['configs']['maxsubjectlength']}' name='topic_name'  />
			</td>
		</tr>";
    }
    if ($quote) {
        $postid = (int)$_GET["postid"];
        if (!is_valid_id($postid)) {
            stderr("Error", "Invalid ID!");
            $htmlout .= end_table();
            $htmlout .= end_main_frame();
            echo stdhead("Compose", true, $stdhead) . $htmlout . stdfoot($stdfoot);
            exit();
        }
        $res = sql_query("SELECT posts.*, users.username FROM posts JOIN users ON posts.user_id = users.id WHERE posts.id =".sqlesc($postid)) or sqlerr(__FILE__, __LINE__);
        if (mysqli_num_rows($res) == 0) {
            stderr("Error", "No post with this ID");
            $htmlout .= end_table();
            $htmlout .= end_main_frame();
            echo stdhead("Error - No post with this ID", true, $stdhead) . $htmlout . stdfoot($stdfoot);
            exit();
        }
        $arr = mysqli_fetch_assoc($res);
    }
    $htmlout .="<tr>
		<td class=row valign='top'>Body</td>
		<td class=row>";
		$qbody = ($quote ? "[quote=".htmlsafechars($arr["username"])."]".htmlsafechars($arr["body"])."[/quote]" : "");
		//if (function_exists('BBcode'))
		//$htmlout .= BBcode($qbody, true);
		if (function_exists('textbbcode'))
		$htmlout .= ' 
		'.textbbcode('compose', 'body', isset($qbody) ? htmlsafechars($qbody) : '').' 
		';
		else
		{
		$htmlout .="<textarea name='body' style='width:99%' rows='7'>{$qbody}</textarea>";
		}
		$htmlout .="</td></tr>";
		if ($Multi_forum['configs']['use_attachment_mod'] && $attachment)
		{
		$htmlout .="<tr>
				<td colspan='2'><fieldset class='fieldset'><legend>Add Attachment</legend>
				<input type='checkbox' name='uploadattachment' value='yes' />
				<input type='file' name='file' size='60' />
        <div class='error'>Allowed Files: rar, zip<br />Size Limit ".mksize($Multi_forum['configs']['maxfilesize'])."</div></fieldset>
				</td>
			</tr>";
		  }
		  $htmlout .="<tr>
   	  <td class=row align='center' colspan='2'>".(post_icons())."</td>
 	     </tr><tr class=row>
 		  <td colspan='2' align='center'>
 	     <input class='btn btn-primary dropdown-toggle' type='submit' value='Submit' /><input class='btn btn-primary dropdown-toggle' type='button' value='Preview' name='button2' onclick='return Preview();' />\n";
      if ($newtopic){
      $htmlout .= "Anonymous Topic<input type='checkbox' name='anonymous' value='yes'/>\n";
      }
      else
      {
      $htmlout .= "Anonymous Post<input type='checkbox' name='anonymous' value='yes'/>\n";
      }
      $htmlout .= "</td></tr></form>\n";
	  			$htmlout .= "<tr>
				<td colspan='2' align='right' class='tfoot'>
				".insert_quick_jump_menu()."
				</td>
			</tr>";
    $htmlout .= end_table();
    $htmlout .="<br />";
   // $htmlout .= end_frame();
    // ------ Get 10 last posts if this is a reply
    if (!$newtopic && $INSTALLER09['show_last_10']) {
        $postres = sql_query("SELECT p.id, p.added, p.body, p.anonymous, u.id AS uid, u.enabled, u.class, u.donor, u.warned, u.chatpost, u.leechwarn, u.pirate, u.king, u.username, u.avatar, u.offensive_avatar " . "FROM posts AS p " . "LEFT JOIN users AS u ON u.id = p.user_id " . "WHERE p.topic_id=".sqlesc($id)." " . "ORDER BY p.id DESC LIMIT 10") or sqlerr(__FILE__, __LINE__);
        if (mysqli_num_rows($postres) > 0) {
            $htmlout .="<br />";
            $htmlout .= begin_frame("10 last posts, in reverse order");
            while ($post = mysqli_fetch_assoc($postres)) {
            //$avatar = ($CURUSER["avatars"] == "all" ? htmlsafechars($post["avatar"]) : ($CURUSER["avatars"] == "some" && $post["offavatar"] == "no" ? htmlsafechars($post["avatar"]) : ""));
            $avatar = ($CURUSER["avatars"] == "yes" ? avatar_stuff($post) : "");
             if ($post['anonymous'] == 'yes') {
             $avatar = $INSTALLER09['pic_base_url'] . $Multi_forum['configs']['forum_pics']['default_avatar'];
             }
             else {
             $avatar = ($CURUSER["avatars"] == "yes" ? avatar_stuff($post) : '');
             }
             if (empty($avatar))
             $avatar = $INSTALLER09['pic_base_url'] . $Multi_forum['configs']['forum_pics']['default_avatar'];
             $user_stuff = $post;
             $user_stuff['id'] = (int)$post['uid'];
             if ($post["anonymous"] == "yes")
             if($CURUSER['class'] < UC_STAFF && $post["uid"] != $CURUSER["id"]){	
             $htmlout .= "<p class='sub'>#".(int)$post["id"]." by <i>Anonymous</i> at ".get_date($post["added"], 'LONG',1,0)."</p>";
             }
             else{	
             $htmlout .= "<p class='sub'>#".(int)$post["id"]." by <i>Anonymous</i> [<b>".format_username($user_stuff, true)."</b>] at ".get_date($post["added"], 'LONG',1,0)."</p>"; 
             }
             else
             $htmlout .="<p class='sub'>#".(int)$post["id"]." by ". (!empty($post["username"]) ? format_username($user_stuff, true) : "unknown[".(int)$post['uid']."]")." at ".get_date($post["added"], 'LONG',1,0)."</p>";
             $htmlout .= begin_table(true);
			    $htmlout .="<tr>
				 <td height='100' width='100' align='center' style='padding: 0px' valign='top'><img height='100' width='100' src='".$avatar."' alt='User avvy' /></td>
				 <td class='comment' valign='top'>".format_comment($post["body"])."</td>
				 </tr>";
             $htmlout .= end_table();
             }
            $htmlout .= end_frame();
        }
    }
    //$htmlout .= insert_quick_jump_menu();
    return $htmlout;
    }
?>
