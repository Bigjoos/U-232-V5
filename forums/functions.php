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
function catch_up($id = 0)
{
    global $CURUSER, $INSTALLER09;
    $userid = (int)$CURUSER['id'];
    $res = sql_query("SELECT t.id, t.last_post, r.id AS r_id, r.last_post_read " . "FROM topics AS t " . "LEFT JOIN posts AS p ON p.id = t.last_post " . "LEFT JOIN read_posts AS r ON r.user_id=" . sqlesc($userid) . " AND r.topic_id=t.id " . "WHERE p.added > " . sqlesc(TIME_NOW - $INSTALLER09['readpost_expiry']) .
        (!empty($id) ? ' AND t.id ' . (is_array($id) ? 'IN (' . implode(', ', $id) . ')' : '= ' . sqlesc($id)) : '')) or sqlerr(__FILE__, __LINE__);
    while ($arr = mysqli_fetch_assoc($res)) {
        $postid = (int)$arr['lastpost'];
        if (!is_valid_id($arr['r_id']))
            sql_query("INSERT INTO read_posts (user_id, topic_id, last_post_read) VALUES".sqlesc($userid).", ".sqlesc($arr['id']).", ".sqlesc($postid).")") or sqlerr(__FILE__, __LINE__);
        else if ($arr['last_post_read'] < $postid)
            sql_query("UPDATE read_posts SET last_post_read=".sqlesc($postid)." WHERE id =".sqlesc($arr['r_id'])) or sqlerr(__FILE__, __LINE__);
    }
    ((mysqli_free_result($res) || (is_object($res) && (get_class($res) == "mysqli_result"))) ? true : false);
}  
// -------- Returns the minimum read/write class levels of a forum
function get_forum_access_levels($forumid)
{
    $res = sql_query("SELECT min_class_read, min_class_write, min_class_create FROM forums WHERE id=".sqlesc($forumid)) or sqlerr(__FILE__, __LINE__);
    if (mysqli_num_rows($res) != 1)
        return false;
    $arr = mysqli_fetch_assoc($res);
    return array("read" => $arr["min_class_read"], "write" => $arr["min_class_write"], "create" => $arr["min_class_create"]);
}
// -------- Returns the forum ID of a topic, or false on error
function get_topic_forum($topicid)
{
    $res = sql_query("SELECT forum_id FROM topics WHERE id=".sqlesc($topicid)) or sqlerr(__FILE__, __LINE__);
    if (mysqli_num_rows($res) != 1)
        return false;
    $arr = mysqli_fetch_assoc($res);
    return (int)$arr['forum_id'];
}
// -------- Returns the ID of the last post of a forum
function update_topic_last_post($topicid)
{
    $res = sql_query("SELECT MAX(id) AS id FROM posts WHERE topic_id=".sqlesc($topicid)) or sqlerr(__FILE__, __LINE__);
    $arr = mysqli_fetch_assoc($res) or die("No post found");
    sql_query("UPDATE topics SET last_post=".sqlesc($arr['id'])." WHERE id=".sqlesc($topicid)) or sqlerr(__FILE__, __LINE__);
}
function get_forum_last_post($forumid)
{
    $res = sql_query("SELECT MAX(last_post) AS last_post FROM topics WHERE forum_id=".sqlesc($forumid)) or sqlerr(__FILE__, __LINE__);
    $arr = mysqli_fetch_assoc($res);
    $postid = (int)$arr['last_post'];
    return (is_valid_id($postid) ? $postid : 0);
}
//==Putyns subforums
function subforums($arr)
{
    global $INSTALLER09;
    $sub = "<font class=\"small\">Subforums:";
    $i = 0;
    foreach($arr as $k) {
        $sub .= "&nbsp;<img src=\"{$INSTALLER09['pic_base_url']}bullet_" . ($k["new"] == 1 ? "green.png" : "white.png") . "\" width=\"8\" title=\"".($k["new"] == 1 ? "New posts" : "Not new")."\" border=\"0\" alt='Subforum' /><a href=\"{$INSTALLER09['baseurl']}/forums.php?action=viewforum&amp;forumid=".(int)$k["id"]."\">".htmlsafechars($k["name"])."</a>" . ((count($arr)-1) == $i ? "" : ",");
        $i++;
    }
    $sub .= "</font>";
    return $sub;
}
function get_count($arr)
{
    $topics = 0;
    $posts = 0;
    foreach($arr as $k) {
        $topics += $k["topics"];
        $posts += $k["posts"];
    }
    return array($posts, $topics);
}
//== End subforum
//== Forum moderator - putyn
function isMod($id,$what="topic") {
	global $CURUSER;
	if($what == "topic" ) {
		$topics = topicmods($CURUSER["id"],"",true);
		return (stristr($topics,"[".$id."]") == true ? true : false);
	}elseif($what == "forum") {
		return (stristr($CURUSER["forums_mod"], "[".$id."]") == true ? true : false);
	}else
		return false;
}
function showMods($ars)
{
    $mods = "<font class=\"small\">Led by:&nbsp;";
    $i = 0;
    $count = count($ars);
    foreach($ars as $a) {
        $mods .= "<a href=\"userdetails.php?id=" . (int)$a[0] . "\">" . htmlsafechars($a[1]) . "</a>" . (($count -1) == $i ? "":" ,");
        $i++;
    }
    $mods .= "</font>";
    return $mods;
}
function forum_stats()
 	{
	global $INSTALLER09, $Multi_forum, $lang, $CURUSER, $mc1;
         $htmlout='';
         $keys['f_activeusers'] = 'forum_activeusers';
         if(($forum_active_users_cache = $mc1->get_value($keys['f_activeusers'])) === false ) {
         $dt = $_SERVER['REQUEST_TIME'] - 180;                      
         $htmlout = $forum_activeusers = '';
         $forum_active_users_cache = array();
         $res = sql_query('SELECT id, username, class, donor, warned, enabled, chatpost, leechwarn, pirate, king '.
                  'FROM users WHERE forum_access >= '.$dt.' '.
                  'ORDER BY username ASC') or sqlerr(__FILE__, __LINE__);
         $forum_actcount = mysqli_num_rows($res);
         while ($arr = mysqli_fetch_assoc($res)) {
          if ($forum_activeusers)
          $forum_activeusers .= ",\n";
          $forum_activeusers .= '<b>'.format_username($arr).'</b>';
         }
         $forum_active_users_cache['activeusers'] = $forum_activeusers;
         $forum_active_users_cache['actcount']    = $forum_actcount;
         $mc1->cache_value($keys['f_activeusers'], $forum_active_users_cache, $INSTALLER09['expires']['forum_activeusers']);
         }
         if (!$forum_active_users_cache['activeusers'])
         $forum_active_users_cache['activeusers'] = 'There have been no active users in the last 15 minutes.';
$htmlout .= begin_f_main_div();
$htmlout .= begin_f_head_div();
$htmlout .= begin_f_head_label_noimage("collapseonline");
$htmlout.= 'Active users on Forum:&nbsp;&nbsp;<span class="badge btn btn-success disabled">'.$forum_active_users_cache["actcount"]."</span>";
$htmlout .= end_f_head_label_noimage();
$htmlout .= end_f_head_div();
$htmlout .= begin_f_body_div("collapseonline");		 
$htmlout.= "".$forum_active_users_cache["activeusers"]."";
$htmlout .= end_f_body_div();
$htmlout .= end_f_main_div();
return $htmlout;
         }
function show_forums($forid, $subforums = false, $sfa = "", $mods_array = "", $show_mods = false)
    {
    global $CURUSER, $INSTALLER09, $Multi_forum;
    $mods_array = forummods();
    $htmlout='';
    $forums_res = sql_query("SELECT f.id, f.name, f.description, f.post_count, f.topic_count, f.min_class_read, p.added, p.topic_id, p.anonymous, p.user_id, p.id AS pid, u.id AS uid, u.username, u.class, u.donor, u.enabled, u.warned, u.chatpost, u.leechwarn, u.pirate, u.king, t.topic_name, t.last_post, r.last_post_read " . "FROM forums AS f " . "LEFT JOIN posts AS p ON p.id = (SELECT MAX(last_post) FROM topics WHERE forum_id = f.id) " . "LEFT JOIN users AS u ON u.id = p.user_id " . "LEFT JOIN topics AS t ON t.id = p.topic_id " . "LEFT JOIN read_posts AS r ON r.user_id = " . sqlesc($CURUSER['id']) . " AND r.topic_id = p.topic_id " . "WHERE " . ($subforums == false ? "f.forum_id = ".sqlesc($forid)." AND f.place =-1 ORDER BY f.forum_id ASC" : "f.place=".sqlesc($forid)." ORDER BY f.id ASC") . "") or sqlerr(__FILE__, __LINE__);
	$htmlout.= begin_f_main_table();
	while ($forums_arr = mysqli_fetch_assoc($forums_res)) {
        if ($CURUSER['class'] < $forums_arr["min_class_read"])
            continue;
        $forumid = (int)$forums_arr["id"];
        $lastpostid = (int)$forums_arr['last_post'];
        $user_stuff = $forums_arr;
        $user_stuff['id'] = (int)$forums_arr['uid'];
        if ($subforums == false && !empty($sfa[$forumid])) {
        if (($sfa[$forumid]['last_post']['postid'] > $forums_arr['pid'])) {
        if ($sfa[$forumid]['last_post']["anonymous"] == "yes") {
        if($CURUSER['class'] < UC_STAFF && $sfa[$forumid]['last_post']['user_id'] != $CURUSER['id'])	
        $lastpost1 = "Anonymous<br />";
        else
        $lastpost1 = "Anonymous[<a href='{$INSTALLER09['baseurl']}/userdetails.php?id=".(int)$sfa[$forumid]['last_--post']['userid']."'><b>" . htmlsafechars($sfa[$forumid]['last_post']['user'])."</b></a>]<br />";
        }
        elseif ($sfa[$forumid]['last_post']["anonymous"] == "no") { 
        $lastpost1 = "<a href='{$INSTALLER09['baseurl']}/userdetails.php?id=".(int)$sfa[$forumid]['last_post']['userid']."'><b>".htmlsafechars($sfa[$forumid]['last_post']['user'])."</b></a><br />";
        }
        $lastpost = "".get_date($sfa[$forumid]['last_post']['added'], 'LONG',1,0)."<br />" . "by $lastpost1" . "in <a href='{$INSTALLER09['baseurl']}/forums.php?action=viewtopic&amp;topicid=".(int)$sfa[$forumid]['last_post']['topic']."&amp;page=p".(int)$sfa[$forumid]['last_post']['post_id']."#p".(int)$sfa[$forumid]['last_post']['post_id']."'><b>".htmlsafechars($sfa[$forumid]['last_post']['tname'])."</b></a>";
        }
        elseif (($sfa[$forumid]['last_post']['postid'] < $forums_arr['pid'])) {
        if ($forums_arr["anonymous"] == "yes") {
        if($CURUSER['class'] < UC_STAFF && $forums_arr["user_id"] != $CURUSER["id"])	
        $lastpost2 = "Anonymous<br />";
        else
        $lastpost2 = "Anonymous[<a href='{$INSTALLER09['baseurl']}/userdetails.php?id=".(int)$forums_arr["user_id"]."'><b>".format_username($user_stuff, true)."</b></a>]<br />";
        }
        elseif ($forums_arr["anonymous"] == "no") { 
        $lastpost2 = "<a href='{$INSTALLER09['baseurl']}/userdetails.php?id=".(int)$forums_arr["user_id"]."'><b>".format_username($user_stuff, true)."</b></a><br />";
        }
        $lastpost = "".get_date($forums_arr["added"], 'LONG',1,0)."<br />" . "by $lastpost2" . "in <a href='{$INSTALLER09['baseurl']}/forums.php?action=viewtopic&amp;topicid=".(int)$forums_arr["topic_id"]."&amp;page=p$lastpostid#p$lastpostid'><b>".htmlsafechars($forums_arr['topic_name'])."</b></a>";
        } else
        $lastpost = "N/A";
        } else {
        if (is_valid_id($forums_arr['pid']))
        if ($forums_arr["anonymous"] == "yes") {
        if($CURUSER['class'] < UC_STAFF && $forums_arr["user_id"] != $CURUSER["id"])
        $lastpost ="".get_date($forums_arr["added"], 'LONG',1,0)."<br />" . "by <i>Anonymous</i><br />" . "in <a href='".$INSTALLER09['baseurl']."/forums.php?action=viewtopic&amp;topicid=".(int)$forums_arr["topic_id"]."&amp;page=p$lastpostid#p$lastpostid'><b>".htmlsafechars($forums_arr['topic_name'])."</b></a>"; 
        else
        $lastpost ="".get_date($forums_arr["added"], 'LONG',1,0) . "<br />" . "by <i>Anonymous[</i><a href='{$INSTALLER09['baseurl']}/userdetails.php?id=".(int)$forums_arr["user_id"]."'><b>".format_username($user_stuff, true)."</b></a>]<br />" . "in <a href='{$INSTALLER09['baseurl']}/forums.php??action=viewtopic&amp;topicid=".(int)$forums_arr["topic_id"]."&amp;page=p$lastpostid#p$lastpostid'><b>".htmlsafechars($forums_arr['topic_name'])."</b></a>";
        }
        else 
        $lastpost = "<span class='smalltext'><a href='{$INSTALLER09['baseurl']}/forums.php?action=viewtopic&amp;topicid=".(int)$forums_arr["topic_id"]."&amp;page=p$lastpostid#p$lastpostid'>".htmlsafechars($forums_arr['topic_name'])."</a><br />" . "".get_date($forums_arr["added"], 'LONG',1,0)."<br />" . "by <a href='{$INSTALLER09['baseurl']}/userdetails.php?id=".(int)$forums_arr["user_id"]."'>".format_username($user_stuff, true)."</a> ";
		else
        $lastpost = "N/A";
        }
	$image_to_use = ($forums_arr['added'] > (TIME_NOW - $INSTALLER09['readpost_expiry'])) ? ((int)$forums_arr['pid'] > $forums_arr['last_post_read']) : 0;
        if (is_valid_id($forums_arr['pid']))
	$img = ($image_to_use ? '<span class="forum_status forum_on ajax_mark_read" title="Forum Contains New Posts" ></span>' : '<span class="forum_status forum_off ajax_mark_read" title="Forum Contains No New Posts" ></span>');
        else
            $img = "<span class='forum_status forum_offlock ajax_mark_read' title='Forum Contains No Posts' ></span>";
        if ($subforums == false && !empty($sfa[$forumid])) {
            list($subposts, $subtopics) = get_count($sfa[$forumid]["count"]);
            $topics = $forums_arr["topic_count"] + $subtopics;
            $posts = $forums_arr["post_count"] + $subposts;
        } else {
            $topics = (int)$forums_arr["topic_count"];
            $posts = (int)$forums_arr["post_count"];
        }
      $htmlout.="
					<tr>
						<td class=row align='center' valign='middle' width='1%'>".$img."</td>
						<td class=row valign='middle' width='50%'>
						<strong><a href='{$INSTALLER09['baseurl']}/forums.php?action=viewforum&amp;forumid=".$forumid."'><b>".htmlsafechars($forums_arr["name"])."</b></a></strong>
";
       if ($CURUSER['class'] >= UC_ADMINISTRATOR || isMod($forumid, "forum")) {
       $htmlout.="&nbsp;<font class='small'><a class='altlink' href='{$INSTALLER09['baseurl']}/forums.php?action=editforum&amp;forumid=".$forumid."'><span class='btn btn-default btn-xs'><i class='fa fa-pencil-square-o'></i>
		   Edit</span></a>&nbsp;&nbsp<a class='altlink' href='{$INSTALLER09['baseurl']}/forums.php?action=deleteforum&amp;forumid=".$forumid."'><span class='btn btn-default btn-xs'><i class='fa fa-eraser'></i>
		   Delete</span></a></font>";
        }
        if (!empty($forums_arr["description"])) {
        $htmlout.="<br />".htmlsafechars($forums_arr["description"])."";
        }
        if ($subforums == false && !empty($sfa[$forumid]))
            $htmlout.="<br/>".subforums($sfa[$forumid]["topics"]);
        if ($show_mods == true && isset($mods_array[$forumid]))
            $htmlout.="<br/>".showMods($mods_array[$forumid]);
        $htmlout.="</td>
<td class=row valign='top' style='white-space: nowrap' width= '8%'>
<span class='badge'>".number_format($posts)."</span> Posts</br>
<span class='badge'>".number_format($topics)."</span> Topics
</td>
			<td class=row valign='top' align='right' style='white-space: nowrap'>".$lastpost."</td>
		</tr>
		";
    }
		$htmlout.="</table><br />";
	$htmlout .= end_f_body_div();
$htmlout .= end_f_main_div();
return $htmlout;
}
if (!function_exists('highlight')) {
    function highlight($search, $subject, $hlstart = '<b><font color=\"red\">', $hlend = '</font></b>')
    {
        $srchlen = strlen($search); // length of searched string
        if ($srchlen == 0)
            return $subject;
        $find = $subject;
        while ($find = stristr($find, $search)) { // find $search text in $subject - case insensitive
            $srchtxt = substr($find, 0, $srchlen); // get new search text
            $find = substr($find, $srchlen);
            $subject = str_replace($srchtxt, $hlstart . $srchtxt . $hlend, $subject); // highlight founded case insensitive search text
        }
        return $subject;
    }
}
?>
