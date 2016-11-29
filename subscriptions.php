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
require_once (__DIR__ . DIRECTORY_SEPARATOR . 'include' . DIRECTORY_SEPARATOR . 'bittorrent.php');
require_once(INCL_DIR.'user_functions.php');
require_once(INCL_DIR.'html_functions.php');
require_once(INCL_DIR.'bbcode_functions.php');
dbconn(false);
loggedinorreturn();

$lang = array_merge( load_language('global') );

$HTMLOUT = '';
$limit = 20;
$userid = (int) $CURUSER["id"];
if (!is_valid_id($userid)) stderr("Error", "Invalid ID");

if ($CURUSER["class"] < UC_USER || ($CURUSER["id"] != $userid && $CURUSER["class"] < UC_STAFF))
    stderr("Error", "Permission denied");
// === subscribe to thread

if (isset($_GET["subscribe"])){
    $subscribe = (int)$_GET["subscribe"];
    if ($subscribe != 1)
        stderr("Error", "I smell a rat!");

    if (isset($_GET["topicid"])) {
        $topicid = (int)$_GET["topicid"];
        if (!is_valid_id($topicid))
            stderr("Error", "Bad Topic Id!");
    }

    if ((get_row_count("subscriptions", "WHERE user_id=".sqlesc($CURUSER['id'])." AND topic_id = ".sqlesc($topicid))) > 0)
        stderr("Error", "Already subscribed to thread number <b>".(int)($topicid)."</b> Click <a href='{$INSTALLER09['baseurl']}/forums.php?action=viewtopic&amp;topicid=$topicid'> <b>Here</b></a> to go back to the thread. Or click <a href='{$INSTALLER09['baseurl']}/subscriptions.php'> <b>Here</b></a> to view your subscriptions.");
    sql_query("INSERT INTO subscriptions (user_id, topic_id) VALUES (".sqlesc($CURUSER['id']).", ".sqlesc($topicid).")") or sqlerr(__FILE__, __LINE__);
    $res = sql_query("SELECT topic_name FROM `topics` WHERE id=".sqlesc($topicid)) or sqlerr(__FILE__, __LINE__);
    $arr = mysqli_fetch_assoc($res) or stderr("Error", "Bad forum id!");
    $forumname = htmlsafechars($arr["topic_name"]);
    stderr("Success", "Successfully subscribed to thread <b>".($forumname)."</b> Click <a href='{$INSTALLER09['baseurl']}/forums.php?action=viewtopic&amp;topicid=$topicid'> <b>Here</b></a> to go back to the thread. Or click <a href='{$INSTALLER09['baseurl']}/subscriptions.php'> <b>Here</b></a> to view your subscriptions.");
}
// === end subscribe to thread
// === Action: Delete subscription
if (isset($_GET["delete"])){
    if (!isset($_GET["deletesubscription"]))
        stderr("Error", "Nothing selected");

    $checked = htmlsafechars($_GET['deletesubscription']);
    foreach ($checked as $delete) {
    sql_query("DELETE FROM subscriptions WHERE user_id = ".sqlesc($CURUSER['id'])." AND topic_id=" . sqlesc($delete)) or sqlerr(__FILE__, __LINE__);
    }

    header("Refresh: 0; url={$INSTALLER09['baseurl']}/subscriptions.php?deleted=1");
}
// ===end
$res = sql_query("SELECT id, username, donor, warned, class, chatpost, leechwarn, enabled FROM users WHERE id=".sqlesc($userid)) or sqlerr(__FILE__, __LINE__);

if (mysqli_num_rows($res) == 1) {
    $arr = mysqli_fetch_assoc($res);

    $subject = "<a class='altlink' href='{$INSTALLER09['baseurl']}/userdetails.php?id=$userid'><b> ".htmlsafechars($arr['username'])."</b></a>";
} else
    $subject = "unknown[$userid]";

$where_is = "p.user_id = ".sqlesc($userid)." AND f.min_class_read <= " . sqlesc($CURUSER['class']);
$order_is = "t.id DESC";
$from_is = "subscriptions AS p LEFT JOIN topics as t ON p.topic_id = t.id LEFT JOIN forums AS f ON t.forum_id = f.id LEFT JOIN read_posts as r ON p.topic_id = r.topic_id AND p.user_id = r.user_id";
$select_is = "f.id AS f_id, f.name, t.id AS t_id, t.topic_name, t.last_post, r.last_post_read, p.topic_id";
$query = "SELECT $select_is FROM $from_is WHERE $where_is ORDER BY $order_is";

$res = sql_query($query) or sqlerr(__FILE__, __LINE__);

$HTMLOUT='';
$HTMLOUT.="<h4>Subscribed Forums for{$subject}</h4><p align='center'>To be notified via PM when there is a new post, go to your <a class='altlink' href='{$INSTALLER09['baseurl']}/my.php'>profile</a> and set <b><i>PM on Subscriptions</i></b> to yes</p>\n";

if (isset($_GET["deleted"])) {
    $HTMLOUT.="<h1>subscription(s) Deleted</h1>";
}
// ------ Print table
//$HTMLOUT.= begin_main_frame();

//$HTMLOUT.= begin_frame();
//$HTMLOUT.="<div class='container'>";
$HTMLOUT.="<div class='row'><div class='col-md-12'>";
if (mysqli_num_rows($res) == 0)
   //$HTMLOUT.="<p align='center'><font size=\"+2\"><b>No Subscriptions Found</b></font></p><p>You are not yet subscribed to any forums...</p><p>To subscribe to a forum at <b>".$INSTALLER09['site_name']."</b>, click the <b><i>Subscribe to this Forum</i></b> link at the top of the thread page.</p>";
$HTMLOUT.="<p class=text-center'><b>No Subscriptions Found</b></p><p>You are not yet subscribed to any forums...</p><p>To subscribe to a forum at <b>".$INSTALLER09['site_name']."</b>, click the <b><i>Subscribe to this Forum</i></b> link at the top of the thread page.</p>";

while ($arr = mysqli_fetch_assoc($res)) {
    $topicid = (int)$arr["t_id"];
    $topicname = htmlsafechars($arr["topic_name"]);
    $forumid = (int)$arr["f_id"];
    $forumname = htmlsafechars($arr["name"]);
    $newposts = ($arr["last_post_read"] < $arr["last_post"]) && $CURUSER["id"] == $userid;
    $order_is = "p.id DESC";
    $from_is = "posts AS p LEFT JOIN topics as t ON p.topic_id = t.id LEFT JOIN forums AS f ON t.forum_id = f.id";
    $select_is = "t.id, p.*";
    $where_is = "t.id = $topicid AND f.min_class_read <= " . $CURUSER['class'];
    $queryposts = "SELECT $select_is FROM $from_is WHERE $where_is ORDER BY $order_is";
    $res2 = sql_query($queryposts) or sqlerr(__FILE__, __LINE__);
    $arr2 = mysqli_fetch_assoc($res2);
    $postid = (int)$arr2["id"];
    $posterid = (int)$arr2["user_id"];
    $queryuser = sql_query("SELECT username FROM users WHERE id=".sqlesc($arr2['user_id']));
    $res3 = mysqli_fetch_assoc($queryuser);
    $added = get_date($arr2["added"], 'DATE',1,0) . " GMT (" . (get_date($arr2["added"], 'LONG',1,0)) . ")";
    $count2 = '';
    // =======change colors
    if ($count2 == 0) {
        $count2 = $count2 + 1;
        $class = "one";
    } else {
        $count2 = 0;
        $class = "two";
    }
    // =======end
    $HTMLOUT.="
    <table class='table table-bordered'>
    <tr><td class='colhead' width='100%'>" . ($newposts ? " <b><font color='red'>New Reply !</font></b>" : "") . "<br /><b>Forum: </b>
<a class='altlink' href='{$INSTALLER09['baseurl']}/forums.php?action=viewforum&amp;forumid=$forumid'>{$forumname}</a>
<b>Topic: </b>
<a class='altlink' href='{$INSTALLER09['baseurl']}/forums.php?action=viewtopic&amp;topicid=$topicid'>{$topicname}</a>
<b>Post: </b>
#<a class='altlink' href='{$INSTALLER09['baseurl']}/forums.php?action=viewtopic&amp;topicid=$topicid&amp;page=p$postid#$postid'>{$postid}</a><br />
<b>Last Post By:</b><a class='altlink' href='{$INSTALLER09['baseurl']}/userdetails.php?id=$posterid'><b>".htmlsafechars($res3['username'])."</b></a> added:{$added}</td>
<td class='colhead' align='right' width='20%'>";
    // === delete subscription
    if (isset($_GET["check"]) == "yes")
    $HTMLOUT.="<input type='checkbox' checked='checked' name='deletesubscription[]' value='{$topicid}' />";
    else
    $HTMLOUT.="<input type='checkbox' name='deletesubscription[]' value='{$topicid}' />";
    // === end
    $HTMLOUT.="<b>un-subscribe</b></td></tr></table>\n";
 $body = format_comment($arr2["body"]);
    if ((is_valid_id(isset($arr['edited_by'])))) {
        $subres = sql_query("SELECT username FROM users WHERE id=".sqlesc($arr['edited_by']));
        if (mysqli_num_rows($subres) == 1) {
            $subrow = mysqli_fetch_assoc($subres);
            $body .= "<p><font size='1' class='small'>Last edited by <a href='{$INSTALLER09['baseurl']}/userdetails.php?id=".(int)$arr['edited_by']."'><b>".htmlsafechars($subrow['username'])."</b></a> at ".get_date($arr['edit_date'], 'LONG',1,0)." GMT</font></p>\n";
        }
    }
   $HTMLOUT.="<table class='table tabe-bordered'><tr valign='top'><td class='$class'>{$body}</td></tr></table>\n";
}
$HTMLOUT.="<form action=\"".$_SERVER["PHP_SELF"]."\" method=\"post\">
<table class='table table-bordered'>
<tr>
<td class='colhead text-center'>
<a class='altlink' href='{$INSTALLER09['baseurl']}/subscriptions.php?action=".isset(htmlsafechars($_GET["action"]))."&amp;box=".isset(intval($_GET["box"]))."&amp;check=yes'>select all</a> -
<a class='altlink' href='{$INSTALLER09['baseurl']}/subscriptions.php?action=".isset(htmlsafechars($_GET["action"]))."&amp;box=".isset(intval($_GET["box"]))."&amp;uncheck=yes'>un-select all</a>
<input class='button' type='submit' name='delete' value='Delete' /> selected</td></tr></table></form>";
$HTMLOUT.= "</div></div>";
echo stdhead('Subscriptions') . $HTMLOUT . stdfoot();
die;
?>
