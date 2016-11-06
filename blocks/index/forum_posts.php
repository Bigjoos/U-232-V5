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
//== Latest forum posts [set limit from config] - Multilayer
$HTMLOUT.= "";
			$page = 1;
			$num = 0;
			if (($topics = $mc1->get_value('last_posts_b_' . $CURUSER['class'])) === false) {
			$topicres = sql_query("SELECT t.id, t.user_id, t.topic_name, t.locked, t.forum_id, t.last_post, t.sticky, t.views, t.anonymous AS tan, f.min_class_read, f.name " . ", (SELECT COUNT(id) FROM posts WHERE topic_id=t.id) AS p_count " . ", p.user_id AS puser_id, p.added, p.anonymous AS pan " . ", u.id AS uid, u.username " . ", u2.username AS u2_username " . "FROM topics AS t " . "LEFT JOIN forums AS f ON f.id = t.forum_id " . "LEFT JOIN posts AS p ON p.id=(SELECT MAX(id) FROM posts WHERE topic_id = t.id) " . "LEFT JOIN users AS u ON u.id=p.user_id " . "LEFT JOIN users AS u2 ON u2.id=t.user_id " . "WHERE f.min_class_read <= " . $CURUSER['class'] . " " . "ORDER BY t.last_post DESC LIMIT {$INSTALLER09['latest_posts_limit']}") or sqlerr(__FILE__, __LINE__);
			while ($topic = mysqli_fetch_assoc($topicres)) $topics[] = $topic;
			$mc1->cache_value('last_posts_b_' . $CURUSER['class'], $topics, $INSTALLER09['expires']['latestposts']);
			}
			if (count($topics) > 0) {
			$HTMLOUT.= "<div class='panel panel-default'>
	<div class='panel-heading'>
		<label for='checkbox_4' class='text-left'>{$lang['latestposts_title']}</label>
	</div>
	<div class='panel-body'>
				<table class='table  table-hover table-bordered'>
					<thead>
						<tr>
							<th class='row-fluid col-sm-8 text-left'>{$lang['latestposts_topic_title']}</th>
							<th class='row-fluid col-sm-1 text-center'>{$lang['latestposts_replies']}</th>
							<th class='row-fluid col-sm-1 text-center'>{$lang['latestposts_views']}</th>
							<th class='row-fluid col-sm-2 text-center'>{$lang['latestposts_last_post']}</th>
						</tr>
					</thead>";
				if ($topics) {
				foreach ($topics as $topicarr) {
				$topicid = (int)$topicarr['id'];
				$topic_userid = (int)$topicarr['user_id'];
				$perpage = empty($CURUSER['postsperpage']) ? 10 : (int)$CURUSER['postsperpage'];
				if (!$perpage) $perpage = 24;
				$posts = 0 + $topicarr['p_count'];
				$replies = max(0, $posts - 1);
				$first = ($page * $perpage) - $perpage + 1;
				$last = $first + $perpage - 1;
				if ($last > $num) $last = $num;
				$pages = ceil($posts / $perpage);
				$menu = '';
				for ($i = 1; $i <= $pages; $i++) {
				if ($i == 1 && $i != $pages) {
				$menu.= "[ ";
				}
				if ($pages > 1) {
				$menu.= "<a href='/forums.php?action=viewtopic&amp;topicid=$topicid&amp;page=$i'>$i</a>\n";
				}
				if ($i < $pages) {
				$menu.= "|\n";
				}
				if ($i == $pages && $i > 1) {
				$menu.= "]";
				}
				}
				$added = get_date($topicarr['added'], '', 0, 1);
				if ($topicarr['pan'] == 'yes') {
				if ($CURUSER['class'] < UC_STAFF && $topicarr['user_id'] != $CURUSER['id']) $username = (!empty($topicarr['username']) ? "<i>{$lang['index_fposts_anonymous']}</i>" : "<i>{$lang['index_fposts_unknow']}</i>");
				else $username = (!empty($topicarr['username']) ? "<i>{$lang['index_fposts_anonymous']}</i>&nbsp;&nbsp;<a href='" . $INSTALLER09['baseurl'] . "/userdetails.php?id=" . (int)$topicarr['puser_id'] . "'><b>[" . htmlsafechars($topicarr['username']) . "]</b></a>" : "<i>{$lang['index_fposts_unknow']}[$topic_userid]</i>");
				} else {
				$username = (!empty($topicarr['username']) ? "<a href='" . $INSTALLER09['baseurl'] . "/userdetails.php?id=" . (int)$topicarr['puser_id'] . "'><b>" . htmlsafechars($topicarr['username']) . "</b></a>" : "<i>{$lang['index_fposts_unknow']}[$topic_userid]</i>");
				}
				if ($topicarr['tan'] == 'yes') {
				if ($CURUSER['class'] < UC_STAFF && $topicarr['user_id'] != $CURUSER['id']) $author = (!empty($topicarr['u2_username']) ? "<i>{$lang['index_fposts_anonymous']}</i>" : ($topic_userid == '0' ? "<i>System</i>" : "<i>{$lang['index_fposts_unknow']}</i>"));
				else $author = (!empty($topicarr['u2_username']) ? "<i>{$lang['index_fposts_anonymous']}</i>&nbsp;&nbsp;<a href='" . $INSTALLER09['baseurl'] . "/userdetails.php?id=" . $topic_userid . "'><b>[" . htmlsafechars($topicarr['u2_username']) . "]</b></a>" : ($topic_userid == '0' ? "<i>System</i>" : "<i>{$lang['index_fposts_unknow']}[$topic_userid]</i>"));
				} else {
				$author = (!empty($topicarr['u2_username']) ? "<a href='" . $INSTALLER09['baseurl'] . "/userdetails.php?id=" . $topic_userid . "'><b>" . htmlsafechars($topicarr['u2_username']) . "</b></a>" : ($topic_userid == '0' ? "<i>System</i>" : "<i>{$lang['index_fposts_unknow']}[$topic_userid]</i>"));
				}
				$staffimg = ($topicarr['min_class_read'] >= UC_STAFF ? "<img src='" . $INSTALLER09['pic_base_url'] . "staff.png' border='0' alt='Staff forum' title='Staff Forum' />" : '');
				$stickyimg = ($topicarr['sticky'] == 'yes' ? "<img src='" . $INSTALLER09['pic_base_url'] . "sticky.gif' border='0' alt='{$lang['index_fposts_sticky']}' title='{$lang['index_fposts_stickyt']}' />&nbsp;&nbsp;" : '');
				$lockedimg = ($topicarr['locked'] == 'yes' ? "<img src='" . $INSTALLER09['pic_base_url'] . "forumicons/locked.gif' alt='{$lang['index_fposts_locked']}' title='{$lang['index_fposts_lockedt']}' />&nbsp;" : '');
				$topic_name = $lockedimg . $stickyimg . "<a href='/forums.php?action=viewtopic&amp;topicid=$topicid&amp;page=last#" . (int)$topicarr['last_post'] . "'><b>" . htmlsafechars($topicarr['topic_name']) . "</b></a>&nbsp;&nbsp;$staffimg&nbsp;&nbsp;$menu<br />{$lang['index_fposts_in']}<a href='forums.php?action=viewforum&amp;forumid=" . (int)$topicarr['forum_id'] . "'>" . htmlsafechars($topicarr['name']) . "</a>&nbsp;by&nbsp;$author&nbsp;&nbsp;($added)";
				$HTMLOUT.= "
					<tr>
						<td class='col-sm-8'>{$topic_name}</td>
						<td class='col-sm-1 text-center'><span class='badge'>{$replies}</span></td>
						<td class='col-sm-1 text-center'><span class='badge'>" . number_format($topicarr['views']) . "</span></td>
						<td class='col-sm-2 text-left'>{$username}</td>
					</tr>";
				}
				$HTMLOUT.= "</table></div>";
    } else {
        //if there are no posts...
        if (empty($topics)) $HTMLOUT.= "<tr><td class='fullwidth'>{$lang['latestposts_no_posts']}</td></tr></table></div>";
    }
}
//$mc1->delete_value('last_posts_b_' . $CURUSER['class']);
//==End
// End Class
// End File
