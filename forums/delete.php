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
// -------- Action: Delete Forum
        $forumid = (int)$_GET['forumid'];
    if ($CURUSER['class'] >= MAX_CLASS || isMod($forumid, "forum")) {
        if (!is_valid_id($forumid))
            stderr('Error', 'Invalid ID!');
        $confirmed = (int)isset($_GET['confirmed']) && (int)$_GET['confirmed'];
        if (!$confirmed) {
            $rt = sql_query("SELECT topics.id, forums.name " . "FROM topics " . "LEFT JOIN forums ON forums.id=topics.forum_id " . "WHERE topics.forum_id=".sqlesc($forumid)) or sqlerr(__FILE__, __LINE__);
            $topics = mysqli_num_rows($rt);
            $posts = 0;
            if ($topics > 0) {
                while ($topic = mysqli_fetch_assoc($rt)) {
                    $ids[] = $topic['id'];
                    $forum = htmlsafechars($topic['name']);
                }
                $rp = sql_query("SELECT COUNT(id) FROM posts WHERE topic_id IN (" . join(', ', $ids) . ")");
                foreach ($ids as $id)
                if ($a = mysqli_fetch_row($rp))
                    $posts += $a[0];
            }
            if ($Multi_forum['configs']['use_attachment_mod'] || $Multi_forum['configs']['use_poll_mod']) {
                $res = sql_query("SELECT " .
                    ($Multi_forum['configs']['use_attachment_mod'] ? "COUNT(attachments.id) AS attachments " : "") .
                    ($Multi_forum['configs']['use_poll_mod'] ? ($Multi_forum['configs']['use_attachment_mod'] ? ', ' : '') . "COUNT(postpolls.id) AS polls " : "") . "FROM topics " . "LEFT JOIN posts ON topics.id=posts.topic_id " .
                    ($Multi_forum['configs']['use_attachment_mod'] ? "LEFT JOIN attachments ON attachments.post_id = posts.id " : "") .
                    ($Multi_forum['configs']['use_poll_mod'] ? "LEFT JOIN postpolls ON postpolls.id=topics.poll_id " : "") . "WHERE topics.forum_id=".sqlesc($forumid)) or sqlerr(__FILE__, __LINE__);
                ($Multi_forum['configs']['use_attachment_mod'] ? $attachments = 0 : null);
                ($Multi_forum['configs']['use_poll_mod'] ? $polls = 0 : null);
                if ($arr = mysqli_fetch_assoc($res)) {
                    ($Multi_forum['configs']['use_attachment_mod'] ? $attachments = $arr['attachments'] : null);
                    ($Multi_forum['configs']['use_poll_mod'] ? $polls = $arr['polls'] : null);
                }
            }
            stderr("** WARNING! **", "Deleting forum with id=$forumid (" . $forumid . ") will also delete ".$posts." post" . ($posts != 1 ? 's' : '') . ($Multi_forum['configs']['use_attachment_mod'] ? ", ".$attachments." attachment" . ($attachments != 1 ? 's' : '') : "") . ($Multi_forum['configs']['use_poll_mod'] ? " and " . ($polls - $attachments) . " poll" . (($polls - $attachments) != 1 ? 's' : '') : "") . " in ".$topics." topic" . ($topics != 1 ? 's' : '') . ". [<a href='{$INSTALLER09['baseurl']}/forums.php?action=deleteforum&amp;forumid=$forumid&amp;confirmed=1'>Accept</a>] [<a href='{$INSTALLER09['baseurl']}/forums.php?action=viewforum&amp;forumid=$forumid>Cancel</a>]");
        }
        $rt = sql_query("SELECT topics.id ".($Multi_forum['configs']['use_attachment_mod'] ? ", attachments.file_name " : "")." FROM topics " . "LEFT JOIN posts ON topics.id = posts.topic_id ".($Multi_forum['configs']['use_attachment_mod'] ? "LEFT JOIN attachments ON attachments.post_id = posts.id " : "")." WHERE topics.forum_id=".sqlesc($forumid)) or sqlerr(__FILE__, __LINE__);
        $topics = mysqli_num_rows($rt);
		    if ($topics == 0){
		    sql_query("DELETE FROM forums WHERE id=".sqlesc($forumid)) or sqlerr(__FILE__, __LINE__);
			  header("Location: forums.php");
	      exit();
        } 
        while ($topic = mysqli_fetch_assoc($rt)) {
            $tids[] = $topic['id'];
            if ($Multi_forum['configs']['use_attachment_mod'] && !empty($topic['filename'])) {
                $filename = $Multi_forum['configs']['attachment_dir']."/".htmlsafechars($topic['filename']);
                if (is_file($filename))
                    unlink($filename);
            }
        }
        sql_query("DELETE posts.*, topics.*, forums.* ".($Multi_forum['configs']['use_attachment_mod'] ? ", attachments.*, attachmentdownloads.* " : "").($Multi_forum['configs']['use_poll_mod'] ? ", postpolls.*, postpollanswers.* " : "")." FROM posts ".($Multi_forum['configs']['use_attachment_mod'] ? "LEFT JOIN attachments ON attachments.post_id = posts.id " . "LEFT JOIN attachmentdownloads ON attachmentdownloads.file_id = attachments.id " : "")."LEFT JOIN topics ON topics.id = posts.topic_id ". "LEFT JOIN forums ON forums.id = topics.forum_id ".($Multi_forum['configs']['use_poll_mod'] ? "LEFT JOIN postpolls ON postpolls.id = topics.poll_id " . "LEFT JOIN postpollanswers ON postpollanswers.pollid = postpolls.id " : "")." WHERE posts.topic_id IN (" . join(', ', $tids) . ")") or sqlerr(__FILE__, __LINE__);
        header("Location: forums.php");
        exit();
    }
?>
