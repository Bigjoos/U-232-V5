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
// -------- Action: View forum
    $forumid = (int)$_GET['forumid'];
    if (!is_valid_id($forumid))
        stderr('Error', 'Invalid ID!');
    $page = (isset($_GET["page"]) ? (int)$_GET["page"] : 0);
    $userid = (int)$CURUSER["id"];
    // ------ Get forum details
    $res = sql_query("SELECT f.name AS forum_name, f.min_class_read, (SELECT COUNT(id) FROM topics WHERE forum_id = f.id) AS t_count " . "FROM forums AS f " . "WHERE f.id = " . sqlesc($forumid)) or sqlerr(__FILE__, __LINE__);
    $arr = mysqli_fetch_assoc($res) or stderr('Error', 'No forum with that ID!');
    if ($CURUSER['class'] < $arr["min_class_read"])
        stderr('Error', 'Access Denied!');
    $perpage = (empty($CURUSER['topicsperpage']) ? 20 : (int)$CURUSER['topicsperpage']);
    $num = (int)$arr['t_count'];
    if ($page == 0)
        $page = 1;
    $first = ($page * $perpage) - $perpage + 1;
    $last = $first + $perpage - 1;
    if ($last > $num)
        $last = $num;
    $pages = floor($num / $perpage);
    if ($perpage * $pages < $num)
        ++$pages;
    // ------ Build menu
    $menu1 = "<div class='pagination'><span class='btn btn-default btn-xs'><i style='font-size: 14px;' class='fa fa-paperclip'></i>&nbsp;&nbsp;Pages&nbsp;</span> ";
    $menu2 = '';
    $lastspace = false;
    for ($i = 1; $i <= $pages; ++$i) {
        if ($i == $page)
            $menu2 .= "<span class='pagination_current'>$i</span>&nbsp;";
        else if ($i > 3 && ($i < $pages - 2) && ($page - $i > 3 || $i - $page > 3)) {
            if ($lastspace)
                continue;
            $menu2 .= "... \n";
            $lastspace = true;
        } else {
            $menu2 .= "<a class='pagination_page' href='{$INSTALLER09['baseurl']}/forums.php?action=viewforum&amp;forumid=$forumid&amp;page=$i'>$i</a>";
            $lastspace = false;
        }
        if ($i < $pages)
            $menu2 .= "|";
    }
    $menu1 .= ($page == 1 ? "" : "<a class='pagination_page' href='{$INSTALLER09['baseurl']}/forums.php?action=viewforum&amp;forumid=$forumid&amp;page=".($page - 1)."'>&lt;&lt;&nbsp;Prev</a>");
    $mlb = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
    $menu3 = ($last == $num ? "</div>" : "<a class='pagination_page' href='{$INSTALLER09['baseurl']}/forums.php?action=viewforum&amp;forumid=$forumid&amp;page=".($page + 1)."'>Next&nbsp;&gt;&gt;</a></div>");
    $offset = $first - 1;
    $topics_res = sql_query("SELECT t.id, t.user_id, t.views, t.locked, t.sticky" . ($Multi_forum['configs']['use_poll_mod'] ? ', t.poll_id' : '') . ", t.num_ratings, t.rating_sum, t.topic_name, t.anonymous,  u1.id AS uid1, u1.enabled, u1.class, u1.donor, u1.chatpost,  u1.warned, u1.leechwarn, u1.pirate, u1.king, u1.username, r.last_post_read, p.id AS p_id,p2.icon, p.user_id AS p_userid, p.anonymous as p_anon, p.added AS p_added, (SELECT COUNT(id) FROM posts WHERE topic_id=t.id) AS p_count, u2.id AS uid2, u2.enabled, u2.class, u2.donor, u2.chatpost,  u2.warned, u2.leechwarn, u2.pirate, u2.king, u2.username AS u2_username " . "FROM topics AS t " . "LEFT JOIN users AS u1 ON u1.id=t.user_id " . "LEFT JOIN read_posts AS r ON r.user_id = ".sqlesc($userid)." AND r.topic_id = t.id " . "LEFT JOIN posts AS p ON p.id = (SELECT MAX(id) FROM posts WHERE topic_id = t.id) " . "LEFT JOIN posts AS p2 ON p2.id = (SELECT MIN(id) FROM posts WHERE topic_id = t.id) " . "LEFT JOIN users AS u2 ON u2.id = p.user_id " . "WHERE t.forum_id=".sqlesc($forumid)." ORDER BY t.sticky, t.last_post DESC LIMIT $offset, $perpage") or sqlerr(__FILE__, __LINE__);
    // subforums
    $r_subforums = sql_query("SELECT id FROM forums where place=".sqlesc($forumid)) or sqlerr(__FILE__, __LINE__);
    $subforums = mysqli_num_rows($r_subforums);
    //$HTMLOUT .= begin_main_frame();
$HTMLOUT .= "<div class='row'><div class='col-sm-12 col-sm-offset-0'>";
			   $HTMLOUT .="<div class='navigation'>
				<a href='index.php'>" . $INSTALLER09["site_name"] . "</a> 
				&gt;
				<a href='forums.php'>Forums</a>
				<br><img src='templates/1/pic/carbon/nav_bit.png' alt=''>
				<span class='active'>". htmlsafechars($arr["forum_name"])."</span>
				</div> <br />";
    if ($INSTALLER09['forums_online'] == 0)
    $HTMLOUT .= stdmsg('Warning', 'Forums are currently in maintainance mode');
    if ($subforums > 0) {
	$HTMLOUT .= begin_main_div();
$HTMLOUT .= begin_head_div(); 
$HTMLOUT .= begin_head_label("collapse".$forumid.""); 
$HTMLOUT .="<img src='templates/1/pic/carbon/collapse.png' alt='[+/-]' title='[+/-]' />";
$HTMLOUT .="&nbsp;&nbsp;<strong>". htmlsafechars($arr["forum_name"])."</strong><span class='desc'></span>";
$HTMLOUT .= end_head_label();
$HTMLOUT .= end_div();
$HTMLOUT .= begin_body_div("collapse".$forumid."");	
	 $HTMLOUT .="<!--<table border='1' cellspacing='0' cellpadding='5' width='{$Multi_forum['configs']['forum_width']}'>-->
<br />
<table border='0' cellspacing='0' cellpadding='5' class='tborder clear'>
";
    $HTMLOUT .= show_forums($forumid, true);
    $HTMLOUT .= end_table();
    }
$HTMLOUT .="<div class='float_left'>";
	$HTMLOUT .= $menu1.$mlb.$menu2.$mlb.$menu3;
	$HTMLOUT .="</div>";
	// start new topic
	$newtopicarr = get_forum_access_levels($forumid) or die();
	$maypost = ($CURUSER['class'] >= $newtopicarr["write"] && $CURUSER['class'] >= $newtopicarr["create"]);
		if (!$maypost)
	{
	$HTMLOUT .="<div class='float_right'><a class='button new_thread_button'><span><i style='font-size: 14px;' class='fa fa-check-square'></i> No Permissions</span></a></div>";
	}
	else
	{
	$HTMLOUT .="<div class='float_right'><a href='forums.php?action=newtopic&forumid=".$forumid."' class='button new_thread_button'><span><i style='font-size: 14px;' class='fa fa-check-square'></i>  Start new topic</span></a></div>";
	}
	// start new topic end
	$HTMLOUT .="<div class='float_right'> <a href='forums.php?action=viewunread' class='button new_thread_button'><span><i style='font-size: 14px;' class='fa fa-check fa-fw'></i> View Unread</a></div>";
	if (mysqli_num_rows($topics_res) > 0) {
    $HTMLOUT .="<br />
<table border='0' cellspacing='0' cellpadding='5' class='tborder clear'>
	<tr>
		<td class='thead' colspan='8'>
			<div>
				<strong>". htmlsafechars($arr["forum_name"])." </strong>
			</div>
		</td>
	</tr>
		<tr>
			<td class='tcat' colspan='3' width='66%'><span class='smalltext'><strong>Thread / Author</strong></span></td>
			<td class='tcat' align='center' width='7%'><span class='smalltext'><strong>Rating</strong></span></td>
			<td class='tcat' align='center' width='7%'><span class='smalltext'><strong>Replies</strong></span></td>
			<td class='tcat' align='center' width='7%'><span class='smalltext'><strong>Views</strong></span></td>
			<td class='tcat' align='right' width='20%'><span class='smalltext'><strong>Last&nbsp;post</strong></span></td>
		</tr>";
        while ($topic_arr = mysqli_fetch_assoc($topics_res))
		{
			$user_stuff = $topic_arr;
                        $user_stuff['id'] = (int)$topic_arr['uid1'];
                        $user_stuff1 = $topic_arr;
                        $user_stuff1['id'] = (int)$topic_arr['uid2'];
                        $user_stuff1['username'] = htmlsafechars($topic_arr['u2_username']);
                        $topicid = (int)$topic_arr['id'];
			$topic_userid = (int)$topic_arr['user_id'];
			$sticky = ($topic_arr['sticky'] == "yes");
			$pollim = $topic_arr['poll_id'] > "0";
			($Multi_forum['configs']['use_poll_mod'] ? $topicpoll = is_valid_id($topic_arr["poll_id"]) : NULL);
			$tpages = floor($topic_arr['p_count'] / $Multi_forum['configs']['postsperpage']);
			if (($tpages * $Multi_forum['configs']['postsperpage']) != $topic_arr['p_count'])
				++$tpages;
			if ($tpages > 1)
			{
				$topicpages = "&nbsp;(<img src='".$INSTALLER09['pic_base_url']."multipage.gif' alt='Multiple pages' title='Multiple pages' />";
				$split = ($tpages > 10) ? true : false;
				$flag = false;
				for ($i = 1; $i <= $tpages; ++$i)
				{
					if ($split && ($i > 4 && $i < ($tpages - 3)))
					{
						if (!$flag)
						{
							$topicpages .= '&nbsp;...';
							$flag = true;
						}
						continue;
					}
					$topicpages .= "&nbsp;<a href='{$INSTALLER09['baseurl']}/forums.php?action=viewtopic&amp;topicid=$topicid&amp;page=$i'>$i</a>";
				}
				$topicpages .= ")";
			}
			else
				$topicpages = '';
		if ($topic_arr["p_anon"] == "yes") {
      if($CURUSER['class'] < UC_STAFF && $topic_arr["p_userid"] != $CURUSER["id"])
      $lpusername = "<i>Anonymous</i>";
      else
      $lpusername = "<i>Anonymous</i><br />(<a href='{$INSTALLER09['baseurl']}/userdetails.php?id=".(int)$topic_arr['p_userid']."'><b>".format_username($user_stuff1, true)."</b></a>)";
      }
      else
      $lpusername = (is_valid_id($topic_arr['p_userid']) && !empty($topic_arr['u2_username']) ? "<a href='{$INSTALLER09['baseurl']}/userdetails.php?id=".(int)$topic_arr['p_userid']."'><b>".format_username($user_stuff1, true)."</b></a>" : "unknown[$topic_userid]");
      if ($topic_arr["anonymous"] == "yes") {
      if($CURUSER['class'] < UC_STAFF && $topic_arr["user_id"] != $CURUSER["id"])
      $lpauthor = "<i>Anonymous</i>";
      else
      $lpauthor = "<i>Anonymous</i><br />[<a href='{$INSTALLER09['baseurl']}/userdetails.php?id=$topic_userid'><b>".format_username($user_stuff, true)."</b></a>]";
      }
      else
      $lpauthor = (is_valid_id($topic_arr['user_id']) && !empty($topic_arr['username']) ? "<a href='{$INSTALLER09['baseurl']}/userdetails.php?id=$topic_userid'><b>".format_username($user_stuff, true)."</b></a>" : "unknown[$topic_userid]");
			$new = ($topic_arr["p_added"] > (TIME_NOW - $INSTALLER09['readpost_expiry'])) ? ((int)$topic_arr['p_id'] > $topic_arr['last_post_read']) : 0;
			$topicpic = ($topic_arr['locked'] == "yes" ? ($new ? "<span class='thread_status newlockfolder' title='Topic locked, new posts.'>&nbsp;</span>" : "<span class='thread_status newlockfolder' title='Topic Locked.'>&nbsp;</span>") : ($new ? "<span class='thread_status newfolder' title='New posts.'>&nbsp;</span>" : "<span class='thread_status dot_folder' title='No new posts.'>&nbsp;</span>"));
			$post_icon = ($sticky ? "<img src=\"".$INSTALLER09['pic_base_url']."sticky.gif\" alt=\"Sticky topic\" title=\"Sticky topic\"/>" : ($topic_arr["icon"] > 0 ? "<img src=\"".$INSTALLER09['pic_base_url']."post_icons/icon".htmlsafechars($topic_arr["icon"]).".gif\" alt=\"post icon\" title=\"post icon\" />" : "&nbsp;"));
      $HTMLOUT .="<tr class='inline_row'>
				<td align='center' class='row forumdisplay_regular' width='2%'>".$topicpic."</td>
				<td align='center' class='row forumdisplay_regular' width='3%'>".$post_icon."</td>
				<td class='row forumdisplay_regular'>". ($pollim ? "Poll: " : '')."". ($sticky ? 'Sticky:&nbsp;' : '')."<a href='{$INSTALLER09['baseurl']}/forums.php?action=viewtopic&amp;topicid=".$topicid."'>".htmlsafechars($topic_arr['topic_name'])."</a>{$topicpages}<div class='author smalltext'>". $lpauthor."</div></td>
				<td class='row forumdisplay_regular' align='center'>" . (getRate($topicid, "topic")) . "</td>
				<td class='row forumdisplay_regular' align='center'><span class='badge'>". max(0, $topic_arr['p_count'] - 1)."</span></td>
				<td class='row forumdisplay_regular' align='center'><span class='badge'>". number_format($topic_arr['views'])."</span></td>
				<td class='row forumdisplay_regular' style='white-space: nowrap; text-align: right;'>".get_date($topic_arr["p_added"],'DATE',1,0)."<br />by&nbsp;". $lpusername."</td></tr>";
		    }
	  }
	  else
	  {
		$HTMLOUT .="<table border='0' cellspacing='0' cellpadding='5' class='tborder clear'>
	<tr>
		<td class='thead' colspan='8'>
			<div>
				<strong>". htmlsafechars($arr["forum_name"])." </strong>
			</div>
		</td>
	</tr>
		<tr>
			<td class='tcat' colspan='3' width='66%'><span class='smalltext'><strong>Thread</strong></span></td>
			<td class='tcat' align='center' width='7%'><span class='smalltext'><strong>Replies</strong></span></td>
			<td class='tcat' align='center' width='7%'><span class='smalltext'><strong>Views</strong></span></td>
			<td class='tcat' align='center' width='7%'><span class='smalltext'><strong>Author</strong></span></td>
			<td class='tcat' align='right' width='20%'><span class='smalltext'><strong>Last&nbsp;post</strong></span></td>
		</tr>
		<tr  class='inline_row'>
		<td colspan='8' class='row forumdisplay_regular'> No Topics Found </td>
		</tr>
		";
	  }
	$HTMLOUT .="<tr><td class='tfoot' colspan='8'>";
	$HTMLOUT .="<div class='float_right'>";
	$HTMLOUT .= insert_quick_jump_menu($forumid);
	$HTMLOUT .="</div></td></tr>";
$HTMLOUT .= end_table();
$HTMLOUT .="<div class='float_left'>";
	$HTMLOUT .= $menu1.$mlb.$menu2.$mlb.$menu3;
	$HTMLOUT .="</div>";
		if (!$maypost)
	{
	$HTMLOUT .="<div class='float_right'><a class='button new_thread_button'><span><i style='font-size: 14px;' class='fa fa-check-square'></i> No Permissions</span></a></div>";
	}
	else
	{
	$HTMLOUT .="<div class='float_right'><a href='forums.php?action=newtopic&forumid=".$forumid."' class='button new_thread_button'><span><i style='font-size: 14px;' class='fa fa-check-square'></i>  Start new topic</span></a></div>";
	}
	// start new topic end
	$HTMLOUT .="<div class='float_right'> <a href='forums.php?action=viewunread' class='button new_thread_button'><span><i style='font-size: 14px;' class='fa fa-check fa-fw'></i> View Unread</a></div>";
	$HTMLOUT .=" <br />";
	/*
	if (!$maypost)
	{
	$HTMLOUT .="<p><i>You are not permitted to start new topics in this forum.</i></p>";
	}
	$HTMLOUT .="<!--<table border='0' class='main' cellspacing='0' cellpadding='0' align='center'>-->
<table class='table table-bordered'>
	<tr>
	<td class='embedded'><form method='get' action='forums.php'>
	<input type='hidden' name='action' value='viewunread' />
	<input type='submit' value='View unread' class='gobutton' /></form></td>";
	if ($maypost)
	{
	$HTMLOUT .="<td class='embedded'>
	<form method='get' action='forums.php'>
	<input type='hidden' name='action' value='newtopic' />
	<input type='hidden' name='forumid' value='".$forumid."' />
	<input type='submit' value='New topic' class='gobutton' style='margin-left: 10px' /></form></td>";
	}
	$HTMLOUT .="</tr></table>";
	*/
	$HTMLOUT .= "</div></div>";
//$HTMLOUT .= end_main_frame(); 
	echo stdhead("View Forums", true, $stdhead) . $HTMLOUT . stdfoot($stdfoot);
	exit();
?>
