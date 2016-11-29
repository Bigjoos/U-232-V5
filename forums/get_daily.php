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
	$res = sql_query('SELECT COUNT(p.id) AS post_count '.
					   'FROM posts AS p '.
					   'LEFT JOIN topics AS t ON t.id = p.topic_id '.
					   'LEFT JOIN forums AS f ON f.id = t.forum_id '.
					   'WHERE p.added > '.TIME_NOW.' - 86400 AND f.min_class_read <= '.sqlesc($CURUSER['class'])) or sqlerr(__FILE__, __LINE__);
	$arr = mysqli_fetch_assoc($res);
	((mysqli_free_result($res) || (is_object($res) && (get_class($res) == "mysqli_result"))) ? true : false);
        $count = (int)$arr['post_count'];
        if (empty($count))
        stderr('Sorry', 'No posts in the last 24 hours.');
        if ($INSTALLER09['forums_online'] == 0)
        $HTMLOUT .= stdmsg('Warning', 'Forums are currently in maintainance mode');
        $HTMLOUT .= "<div class='row'><div class='col-md-12'>";
        $perpage = 20;
        $pager = pager($perpage, $count, $INSTALLER09['baseurl'].'/forums.php?action='.$action.'&amp;');
	$HTMLOUT .= "<h2 align='center'>Today Posts (Last 24 Hours)</h2>";
	$HTMLOUT .= "<div class='row'><div class='col-sm-12 col-sm-offset-0'>";
			   $HTMLOUT .="<div class='navigation'>
				<a href='index.php'>" . $INSTALLER09["site_name"] . "</a> 
				&gt;
				<a href='forums.php'>Forums</a>
				<br><img src='templates/1/pic/carbon/nav_bit.png' alt=''>
				<span class='active'>Today Posts (Last 24 Hours)</span>
				</div> <br />";
	$HTMLOUT .= $pager['pagertop'];
        $HTMLOUT .= "<br /><table class='table table-bordered'>
	<tr>
		<td class='thead' colspan='4'>
			<div>
				<strong>Today Posts (Last 24 Hours) </strong>
			</div>
		</td>
	</tr>
    <tr align='center'>
		<td class='tcat' width='100%' align='left'>Topic Title</td>
		<td class='tcat'>Views</td>
		<td class='tcat'>Author</td>
		<td class='tcat'>Posted At</td>
	  </tr>";
        $res = sql_query('SELECT p.id AS pid, p.topic_id, p.user_id AS userpost, p.added, t.id AS tid, t.topic_name, t.forum_id, t.last_post, t.views, f.name, f.min_class_read, f.topic_count, u.username '.
					   'FROM posts AS p '.
					   'LEFT JOIN topics AS t ON t.id = p.topic_id '.
					   'LEFT JOIN forums AS f ON f.id = t.forum_id '.
					   'LEFT JOIN users AS u ON u.id = p.user_id '.
					   'LEFT JOIN users AS topicposter ON topicposter.id = t.user_id '.
					   'WHERE p.added > '.TIME_NOW.' - 86400 AND f.min_class_read <= '.sqlesc($CURUSER['class']).' '.
					   'ORDER BY p.added DESC '.$pager["limit"]) or sqlerr(__FILE__, __LINE__);
    while ($getdaily = mysqli_fetch_assoc($res))
	  {
		$postid = (int)$getdaily['pid'];
		$posterid = (int)$getdaily['userpost'];
		$HTMLOUT .= "<tr>
			<td class='row forumdisplay_regular' align='left'>
		  <a href='{$INSTALLER09['baseurl']}/forums.php?action=viewtopic&amp;topicid=".(int)$getdaily['tid']."&amp;page=".$postid."#".$postid ."'>".htmlsafechars($getdaily['topic_name'])."</a><br />
      <b>In</b>&nbsp;<a href='{$INSTALLER09['baseurl']}/forums.php?action=viewforum&amp;forumid=". (int)$getdaily['forum_id']."'>". htmlsafechars($getdaily['name'])."</a>
      </td>
      <td class='row forumdisplay_regular' align='center'>". number_format($getdaily['views'])."</td>
      <td class='row forumdisplay_regular' align='center'>";
				if (!empty($getdaily['username']))
				{
				$HTMLOUT .= "<a href='{$INSTALLER09['baseurl']}/userdetails.php?id=".$posterid."'>".htmlsafechars($getdaily['username'])."</a>";
				}
				else
				{
				$HTMLOUT .= "<b>unknown[".$posterid."]</b>";
				}
			  $HTMLOUT .= "</td>";
	      $HTMLOUT .= "<td class='row forumdisplay_regular' style='white-space: nowrap;'>".get_date($getdaily['added'], 'LONG',1,0)."</td></tr>";
	}
	((mysqli_free_result($res) || (is_object($res) && (get_class($res) == "mysqli_result"))) ? true : false);
	$HTMLOUT .= " <tr><td class='tfoot' colspan='4'></td></tr>";
	//$HTMLOUT .= end_table();
$HTMLOUT .= "</table>";
	$HTMLOUT .= $pager['pagerbottom'];
	$HTMLOUT .= " <br />";
	$HTMLOUT .= "</div></div><br>";
	
	echo stdhead('Today Posts (Last 24 Hours)') . $HTMLOUT . stdfoot($stdfoot);
?>
