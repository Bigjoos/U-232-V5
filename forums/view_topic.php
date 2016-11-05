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
    $HTMLOUT .= '<!DOCTYPE html>
        <html xmlns="http://www.w3.org/1999/xhtml" lang="en">
        <head>
        <meta charset="' . charset() . '" />
        <title>ERROR</title>
        </head><body>
        <h1 style="text-align:center;">Error</h1>
        <p style="text-align:center;">How did you get here? silly rabbit Trix are for kids!.</p>
        </body></html>';
    echo $HTMLOUT;
    exit();
}
$userid = (int) $CURUSER["id"];
if ($Multi_forum['configs']['use_poll_mod'] && $_SERVER['REQUEST_METHOD'] == "POST") {
    $choice = htmlsafechars($_POST['choice']);
    $pollid = (int) $_POST["pollid"];
    if (ctype_digit($choice) && $choice < 256 && $choice == floor($choice)) {
        $res = sql_query("SELECT pa.id " . "FROM postpolls AS p " . "LEFT JOIN postpollanswers AS pa ON pa.pollid = p.id AND pa.userid=" . sqlesc($userid) . " " . "WHERE p.id = " . sqlesc($pollid)) or sqlerr(__FILE__, __LINE__);
        $arr = mysqli_fetch_assoc($res) or stderr('Sorry', 'Inexistent poll!');
        if (is_valid_id($arr['id']))
            stderr("Error...", "Dupe vote");
        sql_query("INSERT INTO postpollanswers (pollid, userid, selection) VALUES(" . sqlesc($pollid) . ", " . sqlesc($userid) . ", " . sqlesc($choice) . ")") or sqlerr(__FILE__, __LINE__);
        if (mysqli_affected_rows($GLOBALS["___mysqli_ston"]) != 1)
            stderr("Error...", "An error occured. Your vote has not been counted.");
    } else
        stderr("Error...", "Please select an option.");
}
$topicid = (int) $_GET["topicid"];
if (!is_valid_id($topicid))
    stderr('Error', 'Invalid topic ID!');
$page = (isset($_GET["page"]) ? (int) $_GET["page"] : 0);
// ------ Get topic info
$res = sql_query("SELECT " . ($Multi_forum['configs']['use_poll_mod'] ? 't.poll_id, ' : '') . "t.locked, t.num_ratings, t.rating_sum,  t.topic_name, t.sticky, t.user_id AS t_userid, t.forum_id, f.name AS forum_name, f.min_class_read, f.min_class_write, f.min_class_create, (SELECT COUNT(id)FROM posts WHERE topic_id = t.id) AS p_count " . "FROM topics AS t " . "LEFT JOIN forums AS f ON f.id = t.forum_id " . "WHERE t.id = " . sqlesc($topicid)) or sqlerr(__FILE__, __LINE__);
$arr = mysqli_fetch_assoc($res) or stderr("Error", "Topic not found");
((mysqli_free_result($res) || (is_object($res) && (get_class($res) == "mysqli_result"))) ? true : false);
($Multi_forum['configs']['use_poll_mod'] ? $pollid = (int) $arr["poll_id"] : null);
$t_userid  = (int) $arr['t_userid'];
$locked    = ($arr['locked'] == 'yes' ? true : false);
$subject   = $arr['topic_name'];
$sticky    = ($arr['sticky'] == "yes" ? true : false);
$forumid   = (int) $arr['forum_id'];
$forum     = htmlsafechars($arr["forum_name"]);
$postcount = (int) $arr['p_count'];
if ($CURUSER["class"] < $arr["min_class_read"])
    stderr("Error", "You are not permitted to view this topic.");
// ------ Update hits column
sql_query("UPDATE topics SET views = views + 1 WHERE id=" . sqlesc($topicid)) or sqlerr(__FILE__, __LINE__);
//------ Make page menu
$pagemenu1 = "<div class='pagination'><span class='btn btn-default btn-xs'><i style='font-size: 14px;' class='fa fa-paperclip'></i>&nbsp;&nbsp;Pages&nbsp;</span>&nbsp;&nbsp;";
$perpage   = $Multi_forum['configs']['postsperpage'];
$pages     = ceil($postcount / $perpage);
if ($page[0] == "p") {
    $findpost = substr($page, 1);
    $res = sql_query("SELECT id FROM posts WHERE topic_id=" . sqlesc($topicid) . " ORDER BY added") or sqlerr(__FILE__, __LINE__);
    $i = 1;
    while ($arr = mysqli_fetch_row($res)) {
        if ($arr[0] == $findpost)
            break;
        ++$i;
    }
    $page = ceil($i / $perpage);
}
if ($page == "last")
    $page = $pages;
else {
    if ($page < 1)
        $page = 1;
    else if ($page > $pages)
        $page = $pages;
}
$offset    = ((int) $page * $perpage) - $perpage;
$offset    = ($offset < 0 ? 0 : $offset);
$pagemenu2 = '';
for ($i = 1; $i <= $pages; ++$i)
    $pagemenu2 .= ($i == $page ? " <span class='pagination'>$i</span>&nbsp;" : "<a class='pagination_page' href='{$INSTALLER09['baseurl']}/forums.php?action=viewtopic&amp;topicid=$topicid&amp;page=$i'><b>$i</b></a>");
$pagemenu1 .= ($page == 1 ? "" : "<a class='pagination' href='{$INSTALLER09['baseurl']}/forums.php?action=viewtopic&amp;topicid=$topicid&amp;page=" . ($page - 1) . "'><i class='fa fa-angle-double-left'></i></a>");
$pmlb      = "&nbsp;&nbsp;&nbsp;";
$pagemenu3 = ($page == $pages ? "</div>" : "<a class='pagination' href='{$INSTALLER09['baseurl']}/forums.php?action=viewtopic&amp;topicid=$topicid&amp;page=" . ($page + 1) . "'><i class='fa fa-angle-double-right'></i></a></div>");
//$HTMLOUT .= begin_main_frame();
$HTMLOUT .= "<div class='navigation'>
                <a href='index.php'>" . $INSTALLER09["site_name"] . "</a> 
                &gt;
                <a href='forums.php'>Forums</a>
                &gt;
                <a href='{$INSTALLER09['baseurl']}/forums.php?action=viewforum&amp;forumid=" . $forumid . "'>{$forum}</a>
                <br><img src='templates/1/pic/carbon/nav_bit.png' alt=''>
                <span class='active'>" . htmlsafechars($subject) . "</span>
                </div><br />";
$HTMLOUT .= "<div class='row'><div class='col-sm-12 col-sm-offset-0'>";
if ($Multi_forum['configs']['use_poll_mod'] && is_valid_id($pollid)) {
    $res = sql_query("SELECT p.*, pa.id AS pa_id, pa.selection FROM postpolls AS p LEFT JOIN postpollanswers AS pa ON pa.pollid = p.id AND pa.userid = " . sqlesc($CURUSER['id']) . " WHERE p.id=" . sqlesc($pollid)) or sqlerr(__FILE__, __LINE__);
    if (mysqli_num_rows($res) > 0) {
        $arr1     = mysqli_fetch_assoc($res);
        $userid   = (int) $CURUSER['id'];
        $question = htmlsafechars($arr1["question"]);
        $o        = array(
            $arr1["option0"],
            $arr1["option1"],
            $arr1["option2"],
            $arr1["option3"],
            $arr1["option4"],
            $arr1["option5"],
            $arr1["option6"],
            $arr1["option7"],
            $arr1["option8"],
            $arr1["option9"],
            $arr1["option10"],
            $arr1["option11"],
            $arr1["option12"],
            $arr1["option13"],
            $arr1["option14"],
            $arr1["option15"],
            $arr1["option16"],
            $arr1["option17"],
            $arr1["option18"],
            $arr1["option19"]
        );
        $HTMLOUT .= "<table border='0' cellspacing='0' cellpadding='5' class='tborder tfixed'>
          <tr>
<td colspan='2' class='thead' style='text-align: center;'><strong>Poll: {$question}</strong></td>
</tr>
         ";
        $HTMLOUT .= "<tr>";
        $voted = (is_valid_id($arr1['pa_id']) ? true : false);
        if (($locked && $CURUSER['class'] < UC_STAFF) ? true : $voted) {
            $uservote = ($arr1["selection"] != '' ? (int) $arr1["selection"] : -1);
            $res_v    = sql_query("SELECT selection FROM postpollanswers WHERE pollid=" . sqlesc($pollid) . " AND selection < 20");
            $tvotes   = mysqli_num_rows($res_v);
            $vs       = $os = array();
            for ($i = 0; $i < 20; $i++)
                $vs[$i] = 0;
            while ($arr_v = mysqli_fetch_row($res_v))
                $vs[$arr_v[0]] += 1;
            reset($o);
            for ($i = 0; $i < count($o); ++$i)
                if ($o[$i])
                    $os[$i] = array(
                        $vs[$i],
                        $o[$i]
                    );
            function srt($a, $b)
            {
                if ($a[0] > $b[0])
                    return -1;
                if ($a[0] < $b[0])
                    return 1;
                return 0;
            }
            if ($arr1["sort"] == "yes")
                usort($os, "srt");
            $HTMLOUT .= "<br />
              ";
            foreach ($os as $a) {
                if ($i == $uservote)
                    $a[1] .= " *";
                $p = ($tvotes == 0 ? 0 : round($a[0] / $tvotes * 100));
                $c = ($i % 2 ? '' : "poll");
                $p = ($tvotes == 0 ? 0 : round($a[0] / $tvotes * 100));
                $c = ($i % 2 ? '' : "poll");
                $HTMLOUT .= "<tr>";
                $HTMLOUT .= "<td  class=row  colspan='2'>
                    <!--
                    <img src='{$INSTALLER09['pic_base_url']}bar_left.gif' alt='bar_left.gif' />
                    <img src='{$INSTALLER09['pic_base_url']}bar.gif' alt='bar.gif'  height='9' width='" . ($p * 3) . "' />
                    <img src='{$INSTALLER09['pic_base_url']}bar_right.gif'  alt='bar_right.gif' />&nbsp;" . $p . "%</td>
                    -->
                    
                    <div class='progress'>
  <div class='progress-bar progress-bar-striped active' role='progressbar' aria-valuenow='" . $p . "' aria-valuemin='0' aria-valuemax='100' style='width: " . $p . "%''>
    " . htmlsafechars($a[1]) . " (" . $p . "%)
  </div>
</div>
                    </td> </tr>";
            }
            $HTMLOUT .= "
                  <td colspan='2' class=row style='text-align: center;'>Votes: <b>" . number_format($tvotes) . "</b></td>";
        } else {
            $HTMLOUT .= "<form method='post' action='{$INSTALLER09['baseurl']}/forums.php?action=viewtopic&amp;topicid=" . $topicid . "'>
                  <input type='hidden' name='pollid' value='" . $pollid . "' />";
            for ($i = 0; $a = $o[$i]; ++$i)
                $HTMLOUT .= "<tr><td colspan='2' class=row style='text-align: center;'> <input type='radio' name='choice' value='$i' />" . htmlsafechars($a) . "
                            <input class='btn btn-primary dropdown-toggle' type='submit' value='Vote!' /></td></tr>";
        }
        $HTMLOUT .= "</form></tr>
                <tr><td colspan='2' class='tfoot' style='text-align: right;'>";
        if ($userid == $t_userid || $CURUSER['class'] >= UC_STAFF) {
            $HTMLOUT .= "<font class='small'><a href='{$INSTALLER09['baseurl']}/forums.php?action=makepoll&amp;subaction=edit&amp;pollid=" . $pollid . "'><span class='btn btn-default btn-sm'><b>Edit</b></span></a></font>&nbsp;&nbsp;";
            if ($CURUSER['class'] >= UC_STAFF) {
                $HTMLOUT .= "<font class='small'><a href='{$INSTALLER09['baseurl']}/forums.php?action=deletepoll&amp;pollid=" . $pollid . "'><span class='btn btn-default btn-sm'><b>Delete</b></span></a></font>&nbsp;&nbsp;";
            }
        }
        $HTMLOUT .= "";
        $listvotes = (isset($_GET['listvotes']) ? true : false);
        if ($CURUSER['class'] >= UC_ADMINISTRATOR) {
            if (!$listvotes)
                $HTMLOUT .= "<font class='small'><a href='{$INSTALLER09['baseurl']}/forums.php?action=viewtopic&amp;topicid=$topicid&amp;listvotes'><span class='btn btn-default btn-sm'><b>List Voters</b></span></a></font>";
            else {
                $res_vv = sql_query("SELECT pa.userid, u.username, u.anonymous FROM postpollanswers AS pa LEFT JOIN users AS u ON u.id = pa.userid WHERE pa.pollid=" . sqlesc($pollid)) or sqlerr(__FILE__, __LINE__);
                $voters = '';
                while ($arr_vv = mysqli_fetch_assoc($res_vv)) {
                    if (!empty($voters) && !empty($arr_vv['username']))
                        $voters .= ', ';
                    if ($arr_vv["anonymous"] == "yes") {
                        if ($CURUSER['class'] < UC_STAFF && $arr_vv["userid"] != $CURUSER["id"])
                            $voters = "<i>Anonymous</i>";
                        else
                            $voters = "<i>Anonymous</i>[<a href='{$INSTALLER09['baseurl']}/userdetails.php?id=" . (int) $arr_vv['userid'] . "'><b>" . htmlsafechars($arr_vv['username']) . "</b></a>]";
                    } else
                        $voters .= "<a href='{$INSTALLER09['baseurl']}/userdetails.php?id=" . (int) $arr_vv['userid'] . "'><b>" . htmlsafechars($arr_vv['username']) . "</b></a>";
                }
                $HTMLOUT .= $voters . "<br />[<font class='small'><a href='{$INSTALLER09['baseurl']}/forums.php?action=viewtopic&amp;topicid=$topicid'>hide</a></font>]";
            }
        }
        $HTMLOUT .= "</td></tr></table>";
    } else {
        $HTMLOUT .= "<br />";
        stderr('Sorry', "Poll doesn't exist");
    }
    $HTMLOUT .= "<br />";
}
$HTMLOUT .= "<div class='float_left'>";
$HTMLOUT .= $pagemenu1 . $pmlb . $pagemenu2 . $pmlb . $pagemenu3;
$HTMLOUT .= "</div>";
$HTMLOUT .= "<div style='padding-top: 4px;' class='float_right'>";
$maypost = ($CURUSER['class'] >= $arr["min_class_write"] && $CURUSER['class'] >= $arr["min_class_create"]);
if ($locked && $CURUSER['class'] < UC_STAFF && !isMod($forumid, "forum")) {
    $HTMLOUT .= "<p align='center'>This topic is locked; no new posts are allowed.</p>";
} else {
    $writearr = get_forum_access_levels($forumid);
    if ($CURUSER['class'] < $writearr["write"]) {
        $HTMLOUT .= "<p align='center'><i>You are not permitted to post in this forum.</i></p>";
        $maypost = false;
    } else
        $maypost = true;
}
// ------ "View unread" / "Add reply" buttons
//=== who is here
sql_query('DELETE FROM now_viewing WHERE user_id =' . sqlesc($CURUSER['id']));
sql_query('INSERT INTO now_viewing (user_id, forum_id, topic_id, added) VALUES(' . sqlesc($CURUSER['id']) . ', ' . sqlesc($forumid) . ', ' . sqlesc($topicid) . ', ' . TIME_NOW . ')');
//=== now_viewing
$keys['now_viewing'] = 'now_viewing_topic';
if (($topic_users_cache = $mc1->get_value($keys['now_viewing'])) === false) {
    $topicusers        = '';
    $topic_users_cache = array();
    $res = sql_query('SELECT n_v.user_id, u.id, u.username, u.class, u.donor, u.suspended, u.warned, u.enabled, u.chatpost, u.leechwarn, u.pirate, u.king, u.perms FROM now_viewing AS n_v LEFT JOIN users AS u ON n_v.user_id = u.id WHERE topic_id = ' . sqlesc($topicid)) or sqlerr(__FILE__, __LINE__);
    $actcount = mysqli_num_rows($res);
    while ($arr = mysqli_fetch_assoc($res)) {
        if ($topicusers)
            $topicusers .= ",\n";
        $topicusers .= ($arr['perms'] & bt_options::PERMS_STEALTH ? '<i>UnKn0wn</i>' : format_username($arr));
    }
    $topic_users_cache['topic_users'] = $topicusers;
    $topic_users_cache['actcount']    = $actcount;
    $mc1->add_value($keys['now_viewing'], $topic_users_cache, $INSTALLER09['expires']['forum_users']);
}

if (!$topic_users_cache['topic_users'])
    $topic_users_cache['topic_users'] = 'There have been no active users in the last 15 minutes.';
//$forum_users = '&nbsp;('.$forum_users_cache['actcount'].')';
$topic_users = $topic_users_cache['topic_users'];
if ($topic_users != '') {
    $topic_users = 'Currently viewing this topic: ' . $topic_users;
}

$HTMLOUT .= "<a href='forums.php?action=viewunread' class='button new_reply_button'><span>Show New</span></a>&nbsp;";
if ($maypost) {
    $HTMLOUT .= "<a href='forums.php?action=reply&topicid=" . $topicid . "' class='button new_reply_button'><span>New Reply</span></a>&nbsp;";
}
// $HTMLOUT .="<strong class='float_left' style='padding-right: 10px;'>Thread Rating:</strong>" . (getRate($topicid, "topic")) . "";
$HTMLOUT .= "</div>";
$HTMLOUT .= "<br /><a name='top'></a>";
$HTMLOUT .= "<table border='0' cellspacing='0' cellpadding='5' class='tborder tfixed clear'>";
$HTMLOUT .= "<tr>
            <td class='thead'>
                <div class='float_right'>
                    " . (getRate($topicid, "topic")) . "
                </div>
                <div>
                <span class='smalltext'><strong><a href='{$INSTALLER09['baseurl']}/subscriptions.php?topicid=$topicid&amp;subscribe=1'><b><font color='red'>Subscribe to Forum</font></b></a><br />
                <span class='smalltext'><strong>{$topic_users}</strong></span> 
</div>
            </td>
        </tr>";
$HTMLOUT .= "
             <script  type='text/javascript'>
             /*<![CDATA[*/
             function confirm_att(id)
             {
             if(confirm('Are you sure you want to delete this ?'))
             {
               window.open('{$INSTALLER09['baseurl']}/forums.php?action=attachment&amp;subaction=delete&amp;attachmentid='+id,'attachment','toolbar=no, scrollbars=yes, resizable=yes, width=600, height=250, top=50, left=50');
               window.location.reload(true)
             }
             }
             function popitup(url) {
             newwindow=window.open(url,'./usermood.php','height=335,width=735,resizable=no,scrollbars=no,toolbar=no,menubar=no');
             if (window.focus) {newwindow.focus()}
             return false;
             }
             /*]]>*/
             </script>";
// ------ echo table
// $HTMLOUT .= begin_frame();
$res = sql_query("SELECT p.id, p.added, p.user_id, p.added, p.body, p.edited_by, p.edit_date, p.icon, p.anonymous as p_anon, p.user_likes, u.id AS uid, u.username as uusername, u.class, u.avatar, u.offensive_avatar, u.donor, u.title, u.username, u.reputation, u.mood, u.anonymous, u.country, u.enabled, u.warned, u.chatpost, u.leechwarn, u.pirate, u.king, u.uploaded, u.downloaded, u.signature, u.last_access, (SELECT COUNT(id)  FROM posts WHERE user_id = u.id) AS posts_count, u2.username as u2_username " . ($Multi_forum['configs']['use_attachment_mod'] ? ", at.id as at_id, at.file_name as at_filename, at.post_id as at_postid, at.size as at_size, at.times_downloaded as at_downloads, at.user_id as at_owner " : "") . ", (SELECT last_post_read FROM read_posts WHERE user_id = " . sqlesc((int) $CURUSER['id']) . " AND topic_id = p.topic_id LIMIT 1) AS last_post_read " . "FROM posts AS p " . "LEFT JOIN users AS u ON p.user_id = u.id " . ($Multi_forum['configs']['use_attachment_mod'] ? "LEFT JOIN attachments AS at ON at.post_id = p.id " : "") . "LEFT JOIN users AS u2 ON u2.id = p.edited_by " . "WHERE p.topic_id = " . sqlesc($topicid) . " ORDER BY id LIMIT $offset, $perpage") or sqlerr(__FILE__, __LINE__);
$pc = mysqli_num_rows($res);
$pn = 0;
while ($arr = mysqli_fetch_assoc($res)) {
    ++$pn;
    // --------------- likes start------
    $att_str = '';
    if (!empty($arr['user_likes'])) {
        $likes = explode(',', $arr['user_likes']);
    } else {
        $likes = '';
    }
    if (!empty($likes) && count(array_unique($likes)) > 0) {
        if (in_array($CURUSER['id'], $likes)) {
            if (count($likes) == 1) {
                $att_str = jq('You like this');
            } elseif (count(array_unique($likes)) > 1) {
                $att_str = jq('You and&nbsp;') . ((count(array_unique($likes)) - 1) == '1' ? '1 other person likes this' : (count($likes) - 1) . '&nbsp;others like this');
            }
        } elseif (!(in_array($CURUSER['id'], $likes))) {
            if (count(array_unique($likes)) == 1) {
                $att_str = '1 other person likes this';
            } elseif (count(array_unique($likes)) > 1) {
                $att_str = (count(array_unique($likes))) . '&nbsp;others like this';
            }
        }
    }
    $wht               = ((!empty($likes) && count(array_unique($likes)) > 0 && in_array($CURUSER['id'], $likes)) ? 'unlike' : 'like');
    // --------------- likes end------
    $lpr               = (int) $arr['last_post_read'];
    $postid            = (int) $arr["id"];
    $postadd           = (int) $arr['added'];
    $posterid          = (int) $arr['user_id'];
    $posticon          = ($arr["icon"] > 0 ? "<img src=\"{$INSTALLER09['pic_base_url']}post_icons/icon" . htmlsafechars($arr["icon"]) . ".gif\" style=\"padding-left:3px;\" alt=\"post icon\" title=\"post icon\" />" : "&nbsp;");
    $added             = get_date($arr['added'], 'DATE', 1, 0) . " GMT <font class='small'>(" . (get_date($arr['added'], 'LONG', 1, 0)) . ")</font>";
    // ---- Get poster details
    $uploaded          = mksize($arr['uploaded']);
    $downloaded        = mksize($arr['downloaded']);
    $member_reputation = $arr['uusername'] != '' ? get_reputation($arr, 'posts', TRUE, $postid) : '';
    $last_access       = get_date($arr['last_access'], 'DATE', 1, 0);
    $Ratio             = member_ratio($arr['uploaded'], $INSTALLER09['ratio_free'] ? '0' : $arr['downloaded']);
    if (($postid > $lpr) && ($postadd > (TIME_NOW - $INSTALLER09['readpost_expiry']))) {
        $newp = "&nbsp;&nbsp;<span class='badge btn btn-danger disabled' style='color:#fff'><b></b>NEW</b></span>";
    }
    $moodname         = (isset($mood['name'][$arr['mood']]) ? htmlsafechars($mood['name'][$arr['mood']]) : 'is feeling neutral');
    $moodpic          = (isset($mood['image'][$arr['mood']]) ? htmlsafechars($mood['image'][$arr['mood']]) : 'noexpression.gif');
    $signature        = ($CURUSER['signatures'] == 'yes' ? format_comment($arr['signature']) : '');
    $user_stuff       = $arr;
    $user_stuff['id'] = (int) $arr['uid'];
    $postername       = format_username($user_stuff, true);
    $width = '75';
    $avatar           = ($CURUSER["avatars"] == "yes" ? (($arr['p_anon'] == 'yes' && $CURUSER['class'] < UC_STAFF) ? '<img style="max-width:' . $width . 'px;" src="' . $INSTALLER09['pic_base_url'] . 'anonymous_1.jpg" alt="avatar" />' : avatar_stuff($arr)) : "");
    $title2           = (!empty($postername) ? (empty($arr['title']) ? "(" . get_user_class_name($arr['class']) . ")" : "(" . (htmlsafechars($arr['title'])) . ")") : '');
    $title            = ($arr['p_anon'] == 'yes' ? '<i>' . "Anonymous" . '</i>' : htmlsafechars($title2));
    $class_name       = (($arr['p_anon'] == 'yes' && $CURUSER['class'] < UC_STAFF) ? "Anonymous" : get_user_class_name($arr["class"]));
    $forumposts       = (!empty($postername) ? ($arr['posts_count'] != 0 ? (int) $arr['posts_count'] : 'N/A') : 'N/A');
    if ($arr["p_anon"] == "yes") {
        if ($CURUSER['class'] < UC_STAFF)
            $by = "<i>Anonymous</i>";
        else
            $by = "<i>Anonymous</i> [<a href='{$INSTALLER09['baseurl']}/userdetails.php?id=$posterid'> " . $postername . "</a>]" . ($arr['enabled'] == 'no' ? "<img src='" . $INSTALLER09['pic_base_url'] . "disabled.gif' alt='This account is disabled' style='margin-left: 2px' />" : '') . "$title";
    } else {
        $by = (!empty($postername) ? "<a href='{$INSTALLER09['baseurl']}/userdetails.php?id=$posterid'>" . $postername . "</a>" . ($arr['enabled'] == 'no' ? "<img src='" . $INSTALLER09['pic_base_url'] . "disabled.gif' alt='This account is disabled' style='margin-left: 2px' />" : '') : "unknown[" . $posterid . "]") . "";
    }
    if (empty($avatar))
        $avatar = "<img src='" . $INSTALLER09['pic_base_url'] . $Multi_forum['configs']['forum_pics']['default_avatar'] . "' alt='Avatar' title='Avatar' />";
    $HTMLOUT .= ($pn == $pc ? '<a name=\'last\'></a>' : '');
    //  $HTMLOUT .= begin_table();
    $HTMLOUT .= "<td id='posts_container'>
    <div id='posts'>
<a name='" . $postid . "' id='" . $postid . "'></a>
<div class='post ' style='' id='post_" . $postid . "'>
<div class='post_author'>
        <!-- start: postbit_avatar -->
        <div class='author_avatar'>{$avatar}</div>
        <!-- end: postbit_avatar -->
        <div class='author_information'>
            <strong><span class='largetext'>
            " . $by . "</strong> 
            <!-- start: postbit_online -->
            <img src='" . $INSTALLER09['pic_base_url'] . $Multi_forum['configs']['forum_pics'][($last_access > (TIME_NOW - 360) || $posterid == $CURUSER['id'] ? 'on' : 'off') . 'line_btn'] . "' border='0' alt='' />
        <br />
            <span class='smalltext'>" . $class_name . "</span><br />";
     if($INSTALLER09['mood_sys_on']) {
        $HTMLOUT .= '<!-- Mood -->
            <span class="smalltext"><a href="javascript:;" onclick="PopUp(\'usermood.php\',\'Mood\',530,500,1,1);"><img src="' . $INSTALLER09['pic_base_url'] . 'smilies/' . $moodpic . '" alt="' . $moodname . '" border="0" /></a>
      <span class="tip">' . (($arr['p_anon'] == 'yes' && $CURUSER['class'] < UC_STAFF) ? '<i>Anonymous</i>' : htmlsafechars($arr['username'])) . ' ' . $moodname . ' !</span>&nbsp;</span>';
    }
    $HTMLOUT .= "<br /></div>";
    // end left
    // begin right
    //=== rate topic \o/
    //' . (getRate($topicid, "topic")) . '
    $HTMLOUT .= "<div class='author_statistics'>";
    if ($arr["p_anon"] == "yes") {
        if ($CURUSER['class'] < UC_STAFF && $posterid != $CURUSER["id"])
            $HTMLOUT .= "";
        else
            $HTMLOUT .= "
          Posts:&nbsp;{$forumposts}<br />
          Ratio:&nbsp;{$Ratio}<br />
          Uploaded:&nbsp;{$uploaded}<br />
          Downloaded:&nbsp;{$downloaded}<br />
          ".($INSTALLER09['rep_sys_on'] ? $member_reputation : "")."";
    } else {
        $HTMLOUT .= "
          Posts:&nbsp;{$forumposts}<br />
          Ratio:&nbsp;{$Ratio}<br />
          Uploaded:&nbsp;{$uploaded}<br />
          Downloaded:&nbsp;{$downloaded}<br />
          ".($INSTALLER09['rep_sys_on'] ? $member_reputation : "")."";
    }
    $HTMLOUT .= "</div></div>";
    $HTMLOUT .= "<div class='panel panel-default'>
    <div class='post_head'>
<div class='float_right' style='vertical-align: top'>
<strong><a  id='p" . $postid . "' name='p{$postid}' href='{$INSTALLER09['baseurl']}/forums.php?action=viewtopic&amp;topicid=" . $topicid . "&amp;page=p" . $postid . "#" . $postid . "'>#" . $postid . "</a></strong>
</div>
{$posticon}&nbsp;
        <span class='post_date'>" . $added . "&nbsp;<span id='mlike' data-com='" . (int) $arr["id"] . "' class='forum {$wht}'>[" . ucfirst($wht) . "]</span><span class='tot-" . (int) $arr["id"] . "' data-tot='" . (!empty($likes) && count(array_unique($likes)) > 0 ? count(array_unique($likes)) : '') . "'>&nbsp;{$att_str}</span>";
    if (is_valid_id($arr['edited_by']))
        $HTMLOUT .= "<span class='post_edit' id='edited_by_14'><font size='1' class='small'>Last edited by <a href='{$INSTALLER09['baseurl']}/userdetails.php?id=" . (int) $arr['edited_by'] . "'><b>" . htmlsafechars($arr['u2_username']) . "</b></a> at " . get_date($arr['edit_date'], 'LONG', 1, 0) . " GMT</font></span>";
    $HTMLOUT .= "</span>
    </div>";
    if (isset($newp)) {
        $HTMLOUT .= $newp;
    }
    //$HTMLOUT .="</td><td style='border:none;'><a href='#top'><img align='right' src='{$INSTALLER09['pic_base_url']}".$Multi_forum['configs']['forum_pics']['arrow_up']."' alt='Top' /></a></td></tr></table></td></tr>";
    $highlight = (isset($_GET['highlight']) ? htmlsafechars($_GET['highlight']) : '');
    $body      = (!empty($highlight) ? highlight(htmlsafechars(trim($highlight)), format_comment($arr['body'])) : format_comment($arr['body']));
    if ($Multi_forum['configs']['use_attachment_mod'] && ((!empty($arr['at_filename']) && is_valid_id($arr['at_id'])) && $arr['at_postid'] == $postid)) {
        foreach ($Multi_forum['configs']['allowed_file_extensions'] as $allowed_file_extension)
            if (substr($arr['at_filename'], -2) OR substr($arr['at_filename'], -3) == $allowed_file_extension)
                $aimg = $allowed_file_extension;
        $body .= "<div style='padding:6px'>
                <fieldset class='fieldset'>
                    <legend>Attached Files</legend>
                    <table cellpadding='0' cellspacing='3' border='0'>
                    <tr>
                    <td><img class='inlineimg' src='{$INSTALLER09['pic_base_url']}$aimg.gif' alt='' width='16' height='16' border='0' style='vertical-align:baseline' />&nbsp;</td>
                    <td><a href='{$INSTALLER09['baseurl']}/forums.php?action=attachment&amp;attachmentid=" . (int) $arr['at_id'] . "' target='_blank'>" . htmlsafechars($arr['at_filename']) . "</a> [" . mksize($arr['at_size']) . ", " . (int) $arr['at_downloads'] . " downloads]</td>
                    <td>&nbsp;&nbsp;<input type='button' class='none' value='See who downloaded' tabindex='1' onclick=\"window.open('{$INSTALLER09['baseurl']}/forums.php?action=whodownloaded&amp;fileid=" . (int) $arr['at_id'] . "','whodownloaded','toolbar=no, scrollbars=yes, resizable=yes, width=600, height=250, top=50, left=50'); return false;\" />" . ($CURUSER['class'] >= UC_STAFF ? "&nbsp;&nbsp;<input type='button' class='gobutton' value='Delete' tabindex='2' onclick=\"window.open('{$INSTALLER09['baseurl']}/forums.php?action=attachment&amp;subaction=delete&amp;attachmentid=" . (int) $arr['at_id'] . "','attachment','toolbar=no, scrollbars=yes, resizable=yes, width=600, height=250, top=50, left=50'); return false;\" />" : "") . "</td>
                    </tr>
                    </table>
                    </fieldset>
                    </div>";
    }
    if (!empty($signature) && $arr["p_anon"] == "no")
        $body .= "<p style='vertical-align:bottom'><br />____________________<br />" . $signature . "</p>";
    $HTMLOUT .= "<div class='post_body scaleimages'>
      {$body}
      </div>";
    $HTMLOUT .= "<div class='post_controls'>
    <div class='postbit_buttons author_buttons float_left'>";
    if ($arr["p_anon"] == "yes") {
        if ($CURUSER['class'] < UC_STAFF)
            $HTMLOUT .= "";
        else
            $HTMLOUT .= "<a href='{$INSTALLER09['baseurl']}/pm_system.php?action=send_message&amp;receiver=" . $posterid . "' title='Send this user a private message' class='postbit_email'><span>PM</span></a>";
    } else {
        $HTMLOUT .= "<a href='{$INSTALLER09['baseurl']}/pm_system.php?action=send_message&amp;receiver=" . $posterid . "' title='Send this user a private message' class='postbit_email'><span>PM</span></a>";
    }
    $HTMLOUT .= "<a href='{$INSTALLER09['baseurl']}/report.php?type=Post&amp;id=" . $postid . "&amp;id_2=" . $topicid . "&amp;id_3=" . $posterid . "' title='Report this post to a moderator' class='postbit_report'><span>Report</span></a>";
    $HTMLOUT .= "</div><div class='postbit_buttons post_management_buttons float_right'>";
    if (!$locked || $CURUSER['class'] >= UC_STAFF || isMod($forumid, "forum")) {
        if ($arr["p_anon"] == "yes") {
            if ($CURUSER['class'] < UC_STAFF)
                $HTMLOUT .= "";
        } else
            $HTMLOUT .= "<a href='{$INSTALLER09['baseurl']}/forums.php?action=quotepost&amp;topicid=" . $topicid . "&amp;postid=" . $postid . "' class='postbit_quote' ><span>Quote</span></a>";
    } else {
        $HTMLOUT .= "<a href='{$INSTALLER09['baseurl']}/forums.php?action=quotepost&amp;topicid=" . $topicid . "&amp;postid=" . $postid . "' class='postbit_quote' ><span>Quote</span></a>";
    }
    if ($CURUSER['class'] >= UC_STAFF || isMod($forumid, "forum")) {
        $HTMLOUT .= "<a href='{$INSTALLER09['baseurl']}/forums.php?action=deletepost&amp;postid=" . $postid . "' class='postbit_qdelete'><span>Delete</span></a>";
    }
    if (($CURUSER["id"] == $posterid && !$locked) || $CURUSER['class'] >= UC_STAFF || isMod($forumid, "forum")) {
        $HTMLOUT .= "<a href='{$INSTALLER09['baseurl']}/forums.php?action=editpost&amp;postid=" . $postid . "' class='postbit_edit'><span>Edit</span></a>";
    }
    $HTMLOUT .= "<a href='#top' class='postbit_goup'><span>Up</span></a>";
    $HTMLOUT .= "</div>
</div>
</div></div></td></tr>";
}
$HTMLOUT .= "<tr>
            <td class='tfoot'>
    <div class='float_right'>";
$HTMLOUT .= insert_quick_jump_menu($forumid);
$HTMLOUT .= "</div>
    </td>
        </tr>
    </table><br />";
// end of posts
$HTMLOUT .= "<div style='padding-top: 4px;' class='float_right'>";
// ------ "View unread" / "Add reply" buttons
$HTMLOUT .= "<a href='forums.php?action=viewunread' class='button new_reply_button'><span>Show New</span></a>&nbsp;";
if ($maypost) {
    $HTMLOUT .= "<a href='forums.php?action=reply&topicid=" . $topicid . "' class='button new_reply_button'><span>New Reply</span></a>&nbsp;";
}
$HTMLOUT .= "</div><br /><br /><br />";
if ($locked) {
    $HTMLOUT .= "";
} else {
    $HTMLOUT .= "<div class='float_left' style='margin-top:-4em'>";
    $HTMLOUT .= $pagemenu1 . $pmlb . $pagemenu2 . $pmlb . $pagemenu3;
    if ($Multi_forum['configs']['use_poll_mod'] && (($userid == $t_userid || $CURUSER['class'] >= UC_STAFF || isMod($forumid, "forum")) && !is_valid_id($pollid))) {
        $HTMLOUT .= "<form style='margin-top:-6em' method='post' action='forums.php'>
<input type='hidden' name='action' value='makepoll' />
  <input type='hidden' name='topicid' value='" . $topicid . "' />
  <input type='submit' class='btn btn-default' value='Add a Poll' />
  </form>";
    }
    $HTMLOUT .= "</div>";
    $HTMLOUT .= "<h3>Quick Reply:</h3>" . insert_compose_frame($topicid, false, false, true);
    /**
    $HTMLOUT .="<br class='clear' />
    <br />
    <form  style='margin-top:-1em' name='compose' method='post' action='forums.php'>
    <table border='0' cellspacing='0' cellpadding='5' class='tborder'>
    <thead>
    <tr>
    <td class='thead' colspan='2'>
    <div><strong>Quick Reply</strong></div>
    </td>
    </tr>
    </thead>
    <tbody style='' id='quickreply_e'>
    <tr>
    <td class='trowqr' valign='top' width='22%'>
    <span class='smalltext'>Anonymous: <input type='checkbox' name='anonymous' value='yes' ".($CURUSER['anonymous'] == 'yes' ? "checked='checked'":'')." /><br />
    Smilies and some options to be added here </span>
    </td>
    <td class='trowqr'>
    <input type='hidden' name='action' value='post' />
    <input type='hidden' name='topicid' value='".$topicid."' />
    <div style='width: 95%'>
    <textarea style='width: 100%; padding: 4px; margin: 0;' rows='8' cols='80' name='body' rows='4' class='form-control col-md-12' cols='70'></textarea><br />
    </div>
    </td>
    </tr>
    <tr>
    <td colspan='2' align='center' class='tfoot'>
    <input type='submit' class='btn btn-default' value='Submit' /> 
    </td>
    </tr>
    </tbody>
    </table>
    </form>
    <br />";**/
}
if (($postid > $lpr) && ($postadd > (TIME_NOW - $INSTALLER09['readpost_expiry']))) {
    if ($lpr)
        sql_query("UPDATE read_posts SET last_post_read=" . sqlesc($postid) . " WHERE user_id=" . sqlesc($userid) . " AND topic_id=" . sqlesc($topicid)) or sqlerr(__FILE__, __LINE__);
    else
        sql_query("INSERT INTO read_posts (user_id, topic_id, last_post_read) VALUES(" . sqlesc($userid) . ", " . sqlesc($topicid) . ", " . sqlesc($postid) . ")") or sqlerr(__FILE__, __LINE__);
}
// ------ Mod options
if ($CURUSER['class'] >= UC_STAFF || isMod($forumid, "forum")) {
    require_once FORUM_DIR . "/mod_panel.php";
}
// $HTMLOUT .= end_frame();
$HTMLOUT .= "<br /></div></div>";
//$HTMLOUT .= end_main_frame();
if (isMod($topicid))
    $CURUSER['class'] = UC_STAFF;
echo stdhead("Forums :: View Topic: $subject", true, $stdhead) . $HTMLOUT . stdfoot($stdfoot);
$uploaderror = (isset($_GET['uploaderror']) ? htmlsafechars($_GET['uploaderror']) : '');
if (!empty($uploaderror)) {
    $HTMLOUT .= "<script>alert(\"Upload Failed: {$uploaderror}\nHowever your post was successful saved!\n\nClick 'OK' to continue.\");</script>";
}
exit();
?> 
