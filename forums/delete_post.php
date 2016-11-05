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
// -------- Action: Delete post
        $postid = (int)$_GET['postid'];
    if (!is_valid_id($postid))
        stderr('Error', 'Invalid ID');
    $res = sql_query("SELECT p.topic_id " . ($Multi_forum['configs']['use_attachment_mod'] ? ", a.file_name" : "") . ", t.forum_id, (SELECT COUNT(id) FROM posts WHERE topic_id=p.topic_id) AS posts_count, " . "(SELECT MAX(id) FROM posts WHERE topic_id=p.topic_id AND id < p.id) AS p_id " . "FROM posts AS p " . "LEFT JOIN topics as t on t.id=p.topic_id ".($Multi_forum['configs']['use_attachment_mod'] ? "LEFT JOIN attachments AS a ON a.post_id = p.id " : "")."WHERE p.id=".sqlesc($postid)) or sqlerr(__FILE__, __LINE__);
    $arr = mysqli_fetch_assoc($res) or stderr("Error", "Post not found");
    if (isMod($arr["forumid"], "forum") || $CURUSER['class'] >= UC_STAFF) {
        $topicid = (int)$arr['topic_id'];
        if ($arr['posts_count'] < 2)
            stderr("Error", "Can't delete post; it is the only post of the topic. You should<br /><a href='{$INSTALLER09['baseurl']}/forums.php?action=deletetopic&amp;topicid=$topicid'>delete the topic</a> instead.");
        $redirtopost = (is_valid_id($arr['p_id']) ? "&page=p" . $arr['p_id'] . "#p" . $arr['p_id'] : '');
        $sure = (int)isset($_GET['sure']) && (int) $_GET['sure'];
        if (!$sure)
            stderr("Sanity check...", "You are about to delete a post. Click <a href='{$INSTALLER09['baseurl']}/forums.php?action=deletepost&amp;postid=$postid&amp;sure=1'>here</a> if you are sure.");
        sql_query("DELETE posts.* " . ($Multi_forum['configs']['use_attachment_mod'] ? ", attachments.*, attachmentdownloads.* " : "") . "FROM posts ".($Multi_forum['configs']['use_attachment_mod'] ? "LEFT JOIN attachments ON attachments.post_id = posts.id " . "LEFT JOIN attachmentdownloads ON attachmentdownloads.file_id = attachments.id " : "")."WHERE posts.id=".sqlesc($postid)) or sqlerr(__FILE__, __LINE__);
        if ($Multi_forum['configs']['use_attachment_mod'] && !empty($arr['filename'])) {
            $filename = $Multi_forum['configs']['attachment_dir']."/".$arr['filename'];
            if (is_file($filename))
                unlink($filename);
        }
        update_topic_last_post($topicid);
        header("Location: {$INSTALLER09['baseurl']}/forums.php?action=viewtopic&topicid=".$topicid.$redirtopost);
        exit();
    }
?>
