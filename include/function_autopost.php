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
// === auto post by retro
function auto_post($subject = "Error - Subject Missing", $body = "Error - No Body") // Function to use the special system message forum
{
    global $CURUSER, $INSTALLER09, $mc1;
    $res = sql_query("SELECT id FROM topics WHERE forum_id = {$INSTALLER09['staff']['forumid']} AND topic_name = " . sqlesc($subject));
    if (mysqli_num_rows($res) == 1) { // Topic already exists in the system forum.
        $arr = mysqli_fetch_assoc($res);
        $topicid = (int)$arr['id'];
    } else { // Create new topic.
        sql_query("INSERT INTO topics (user_id, forum_id, topic_name) VALUES({$INSTALLER09['bot_id']}, {$INSTALLER09['staff']['forumid']}, $subject)") or sqlerr(__FILE__, __LINE__);
        $topicid = ((is_null($___mysqli_res = mysqli_insert_id($GLOBALS["___mysqli_ston"]))) ? false : $___mysqli_res);
    $mc1->delete_value('last_posts_' . $CURUSER['class']);
    $mc1->delete_value('forum_posts_' . $CURUSER['id']);
    }
    $added = TIME_NOW;
    sql_query("INSERT INTO posts (topic_id, user_id, added, body) " . "VALUES(" . sqlesc($topicid) . ", {$INSTALLER09['bot_id']}, $added, ".sqlesc($body).")") or sqlerr(__FILE__, __LINE__);
    $res = sql_query("SELECT id FROM posts WHERE topic_id=" . sqlesc($topicid) . " ORDER BY id DESC LIMIT 1") or sqlerr(__FILE__, __LINE__);
    $arr = mysqli_fetch_row($res) or die("No post found");
    $postid = $arr[0];
    sql_query("UPDATE topics SET last_post=" . sqlesc($postid) . " WHERE id=" . sqlesc($topicid)) or sqlerr(__FILE__, __LINE__);
    $mc1->delete_value('last_posts_' . $CURUSER['class']);
    $mc1->delete_value('forum_posts_' . $CURUSER['id']);
    }
?>
