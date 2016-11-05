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
define('IN_INSTALLER09_FORUM', TRUE);
require_once (__DIR__ . DIRECTORY_SEPARATOR . 'include' . DIRECTORY_SEPARATOR . 'bittorrent.php');
require_once(INCL_DIR.'user_functions.php');
require_once(INCL_DIR.'pager_functions.php');
require_once(INCL_DIR.'html_functions.php');
require_once(INCL_DIR.'function_rating.php');
dbconn(false);
loggedinorreturn();
flood_limit('posts');
require_once(TEMPLATE_DIR.''.$CURUSER['stylesheet'].'' . DIRECTORY_SEPARATOR . 'html_functions' . DIRECTORY_SEPARATOR . 'forums_html_functions.php');
require_once(TEMPLATE_DIR.''.$CURUSER['stylesheet'].'' . DIRECTORY_SEPARATOR . 'html_functions' . DIRECTORY_SEPARATOR . 'global_html_functions.php'); 
require_once(TEMPLATE_DIR.''.$CURUSER['stylesheet'].'' . DIRECTORY_SEPARATOR . 'html_functions' . DIRECTORY_SEPARATOR . 'navigation_html_functions.php'); 
define('MAX_CLASS', UC_STAFF);
$lang = array_merge( load_language('global'), load_language('forums') );
if ($INSTALLER09['forums_online'] == 0 && $CURUSER['class'] < UC_STAFF)
stderr($lang['forum_pg_inf1'], $lang['forum_pg_inf2']);
if (function_exists('parked'))
parked();
$INSTALLER09['show_last_10'] = false;
$INSTALLER09['expires']['forum_activeusers'] = 30; // 30 seconds for testing
$Multi_forum['configs']['maxfilesize'] = 1024 * 1024;
ini_set("upload_max_filesize", $Multi_forum['configs']['maxfilesize']);
$Multi_forum['configs']['attachment_dir'] = ROOT_DIR."uploads";
$Multi_forum['configs']['forum_width'] = '100%';
$Multi_forum['configs']['allowed_file_extensions'] = array('rar', 'zip', 'gz');
$Multi_forum['configs']['maxsubjectlength'] = 80;
$Multi_forum['configs']['postsperpage'] = (empty($CURUSER['postsperpage']) ? 10 : (int)$CURUSER['postsperpage']);
$Multi_forum['configs']['use_flood_mod'] = true;
$Multi_forum['configs']['minutes'] = 5;
$Multi_forum['configs']['limit'] = 10;
$Multi_forum['configs']['use_attachment_mod'] = true; //=== disable this feat
$Multi_forum['configs']['use_poll_mod'] = true;
$Multi_forum['configs']['use_forum_stats_mod'] = true;
/**
* Change the pics here
*/
$Multi_forum['configs']['forum_pics'] = array('default_avatar' => 'default_avatar.gif', 'arrow_up' => 'up.gif', 'online_btn' => 'buddy_online.png', 'offline_btn' => 'buddy_offline.png', 'pm_btn' => 'pm.gif');
/**
* Configs End
*/
/**
* Define htmlout, javascripts & css
*/
$HTMLOUT='';
$stdhead = array(
    /** include css **/
    'css' => array(
        'style2',
        'bbcode',
        'rating_style',
    )
);
$stdfoot = array(
    /** include js **/
    'js' => array(
        'popup',
        'shout',
        'sack'
    )
);
//=== Post/Get actions - so we know what to do :P
$posted_action = (isset($_GET["action"]) ? htmlsafechars($_GET["action"]) : (isset($_POST["action"]) ? htmlsafechars($_POST["action"]) : ''));
//=== Add all possible actions here and check them to be sure they are allowed :)
    $valid_actions = array(
        'view_default',
        'updatetopic',
        'editforum',
        'updateforum',
        'deleteforum',
        'newtopic',
        'post',
        'usermood',
        'viewtopic',
        'quotepost',
        'reply',
        'editpost',
        'deletetopic',
        'deletepost',
        'deletepoll',
        'makepoll',
        'attachment',
        'whodownloaded',
        'viewforum',
        'viewunread',
        'getdaily',
        'search',
        'forumview',
        'catchup',
        'preview'
    );
//=== Check posted action, and if no action was posted, show the default main forums page :(
$action = (in_array($posted_action, $valid_actions) ? $posted_action : 'view_default');
//=== Here we go with all the possibilities \\o\o/o//
//=== Will try to put these in order of most hit to make it a bit faster \0/          
 switch($action) {
                  case 'updatetopic':
                  require_once FORUM_DIR."/functions.php";
                  require_once FORUM_DIR."/update_topic.php";
           exit();
           break;
                  case 'editforum':
                  require FORUM_DIR."/functions.php";
                  require_once FORUM_DIR."/edit.php";
           exit();
           break;
                  case 'updateforum':
                  require_once FORUM_DIR."/update_forum.php";
           exit();
           break;
                  case 'deleteforum':
                  require_once FORUM_DIR."/functions.php";
                  require_once FORUM_DIR."/delete.php";
           exit();
           break;
                  case 'newtopic':
                  require_once INCL_DIR."/bbcode_functions.php";
                  require_once FORUM_DIR."/post_functions.php";
                  require_once FORUM_DIR."/new_topic.php";
           exit();
           break;
                  case 'post':
                  require_once FORUM_DIR."/functions.php";
                  require_once FORUM_DIR."/post.php";
           exit();
           break;
                  case 'usermood':
                  require_once ROOT_DIR."/usermood.php";
           exit();
           break;
                  case 'viewtopic':
                  require_once INCL_DIR."/bbcode_functions.php";
                  require_once (INCL_DIR . 'html_functions.php');
                  require_once (INCL_DIR . 'add_functions.php');
                  require_once FORUM_DIR."/post_functions.php";
                  require_once FORUM_DIR."/functions.php";
                  require_once FORUM_DIR."/view_topic.php";
                  
           exit();
           break;
                  case 'quotepost':
                  require_once INCL_DIR."/bbcode_functions.php";
                  require_once FORUM_DIR."/post_functions.php";
                  require_once FORUM_DIR."/quote_post.php";
           exit();
           break;
                  case 'reply':
                  require_once INCL_DIR."/bbcode_functions.php";
                  require_once FORUM_DIR."/post_functions.php";
                  require_once FORUM_DIR."/reply.php";
           exit();
           break;
                  case 'editpost':
                  require_once INCL_DIR."/bbcode_functions.php";
                  require_once FORUM_DIR."/functions.php";
                  require_once FORUM_DIR."/post_functions.php";
                  require_once FORUM_DIR."/edit_post.php";
           exit();
           break;
                  case 'deletetopic':
                  require_once FORUM_DIR."/delete_topic.php";
           exit();
           break;
                  case 'deletepost':
           if ($CURUSER['class'] >= UC_STAFF) {
                  require_once FORUM_DIR."/functions.php";
                  require_once FORUM_DIR."/delete_post.php";
           }
           exit();
           break;
                  case 'deletepoll':
                  require_once FORUM_DIR."/delete_poll.php";
           exit();
           break;
                  case 'makepoll':
                  require_once FORUM_DIR."/make_poll.php";
           exit();
           break;
                  case 'attachment':
           if( $Multi_forum['configs']['use_attachment_mod'] )
                  require_once FORUM_DIR."/forum_attachment.php";
           exit();
           break;
                  case 'whodownloaded':
           if( $Multi_forum['configs']['use_attachment_mod'] )
                  require_once FORUM_DIR."/forum_whodownloaded.php";
           exit();
           break;
                  case 'viewforum':
                  require_once FORUM_DIR."/post_functions.php";
                  require_once FORUM_DIR."/functions.php";
                  require_once FORUM_DIR."/view.php";
           exit();
           break;
                  case 'viewunread':
                  require_once FORUM_DIR."/view_unread.php";
           exit();
           break;
                  case 'getdaily':
                  require_once FORUM_DIR."/get_daily.php";
           exit();
           break;
                  case 'search':
                  require_once FORUM_DIR."/search.php";
           exit();
           break;
                  case 'forumview':
                  require_once FORUM_DIR."/functions.php";
                  require_once FORUM_DIR."/parent_view.php";
           exit();
           break;
                  case 'catchup':
                  require_once FORUM_DIR."/functions.php";
                  catch_up();
                  header('Location: forums.php');
           exit();
           break;
                  case 'preview':
                  require_once INCL_DIR."/html_functions.php";
                  require_once INCL_DIR."/bbcode_functions.php";
                  require_once INCL_DIR."/user_functions.php";
                  require_once FORUM_DIR."/preview.php";
           exit();
           break;
                  case 'view_default':
                  require_once FORUM_DIR."/functions.php";
           $forums = array();
           sql_query("UPDATE users SET forum_access = '".sqlesc(TIME_NOW)."' WHERE id=".sqlesc($CURUSER['id'])) or sqlerr(__FILE__, __LINE__);
           $sub_forums = sql_query("SELECT f.id, f2.name, f2.id AS subid, f2.post_count, f2.topic_count, p.added, p.anonymous, p.user_id, p.id AS pid, u.username, t.topic_name, t.id as tid, r.last_post_read, t.last_post FROM forums AS f LEFT JOIN forums AS f2 ON f2.place = f.id AND f2.min_class_read<=".sqlesc($CURUSER["class"])." LEFT JOIN posts AS p ON p.id = (SELECT MAX(last_post) FROM topics WHERE forum_id = f2.id ) LEFT JOIN users AS u ON u.id = p.user_id LEFT JOIN topics AS t ON t.id = p.topic_id LEFT JOIN read_posts AS r ON r.user_id =".sqlesc($CURUSER["id"])." AND r.topic_id = p.topic_id ORDER BY t.last_post ASC, f2.name, f.id ASC") or sqlerr(__FILE__, __LINE__);
            while ($a = mysqli_fetch_assoc($sub_forums)) {
                if ($a["subid"] == 0)
                    $forums[$a["id"]] = false;
                else {
                    $forums[$a["id"]]["last_post"] = array("anonymous" => $a["anonymous"],"postid" => $a["pid"], "userid" => $a["user_id"], "user" => $a["username"], "topic" => $a["topic_name"], "topic" => $a["tid"], "tname" => $a["topic_name"], "added" => $a["added"]);
                    $forums[$a["id"]]["count"][] = array("posts" => $a["post_count"], "topics" => $a["topic_count"]);
                    $forums[$a["id"]]["topics"][] = array ("id" => $a["subid"], "name" => $a["name"], "new" => ($a["last_post"]) != $a["last_post_read"] ? 1 : 0);
             }
          }
          if ($INSTALLER09['forums_online'] == 0)
          $HTMLOUT .= stdmsg($lang['forum_pg_warn1'], $lang['forum_pg_warn2']);
          $HTMLOUT .= "<div class='navigation'><a href='index.php'>" . $INSTALLER09["site_name"] . "</a>
          <br><span class='active'></span></div> <br />";
	  $ovf_res = sql_query("SELECT id, name, min_class_view FROM over_forums ORDER BY sort ASC") or sqlerr(__FILE__, __LINE__);
	  while ($ovf_arr = mysqli_fetch_assoc($ovf_res)) {
	  if ($CURUSER['class'] < $ovf_arr["min_class_view"])
	  continue;
          $ovfid = (int)$ovf_arr["id"];
          $ovfname = htmlsafechars($ovf_arr["name"]);
          $HTMLOUT .= "<div class='panel panel-default'><div class='panel-heading'>
          <span class='nav navbar-nav navbar-right'><label for='checkbox_4' class='text-left'>
          </label></span>";
          $HTMLOUT .="&nbsp;&nbsp;<strong><a href='{$INSTALLER09['baseurl']}/forums.php?action=forumview&amp;forid=".$ovfid."'>".$ovfname."</a></strong></div>
          <div class='table table-responsive table-bordered table-hover'>";
          $HTMLOUT .= show_forums($ovfid, false, $forums, true, true);
          }
$HTMLOUT .= "";
          if ($Multi_forum['configs']['use_forum_stats_mod'])
          $HTMLOUT .= forum_stats();
$HTMLOUT .= "<div class='col-sm-12 col-sm-offset-0'>
          <p align='center'>
	  <a href='{$INSTALLER09['baseurl']}/forums.php?action=search'><b class='btn btn-default btn-sm'>&nbsp;&nbsp;{$lang['forum_pg_srch']}&nbsp;&nbsp;</b></a>&nbsp;&nbsp; 
	  <a href='{$INSTALLER09['baseurl']}/forums.php?action=viewunread'><b class='btn btn-default btn-sm'>&nbsp;&nbsp;{$lang['forum_pg_new']}&nbsp;&nbsp;</b></a>&nbsp;&nbsp; 
	  <a href='{$INSTALLER09['baseurl']}/forums.php?action=getdaily'><b class='btn btn-default btn-sm'>&nbsp;&nbsp;{$lang['forum_pg_24h']}&nbsp;&nbsp;</b></a>&nbsp;&nbsp; 
	  <a href='{$INSTALLER09['baseurl']}/forums.php?catchup'><b class='btn btn-default btn-sm'>&nbsp;&nbsp;{$lang['forum_pg_mark']}&nbsp;&nbsp;</b></a></p>
          </div><br /><br />";
          echo stdhead($lang['forums_forum_heading'], true, $stdhead) . $HTMLOUT . stdfoot($stdfoot);
          exit();
          break;
}
exit($lang['forum_pg_deary']);
?>
