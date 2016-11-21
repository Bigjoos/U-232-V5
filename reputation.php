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
require_once (INCL_DIR . 'user_functions.php');
require_once (CLASS_DIR . 'class_user_options.php');
require_once (CLASS_DIR . 'class_user_options_2.php');
dbconn(false);
loggedinorreturn();
$lang = load_language('reputation');
define('TIMENOW', time());
// mod or not?
$is_mod = ($CURUSER['class'] >= UC_STAFF) ? TRUE : FALSE;
//$CURUSER['class'] = 2;
//$rep_maxperday = 10;
//$rep_repeat = 20;
$closewindow = TRUE;
require_once (CACHE_DIR . 'rep_settings_cache.php');
//print_r($GVARS);
if (!$GVARS['rep_is_online']) {
    exit($lang["info_reputation_offline"]);
}
///////////////////////////////////////////////
//	Need only deal with one input value
///////////////////////////////////////////////
if (isset($_POST) || isset($_GET)) {
    $input = array_merge($_GET, $_POST);
    //print_r($input);
    //die;
    
}
//$input['reputation'] = 'pos';
//$input['reason'] = 'la di da di di la';
///////////////////////////////////////////////
//	Just added to Reputation?
///////////////////////////////////////////////
if (isset($input['done'])) {
    rep_output($lang["info_reputation_added"]);
}
///////////////////////////////////////////////
//	Nope, so do something different, like check stuff
///////////////////////////////////////////////
/// weeeeeeeeee =]
$check = isset($input['pid']) ? is_valid_id(intval($input['pid'])) : false;
$locales = array(
    'posts',
    'comments',
    'torrents',
    'users'
);
$rep_locale = (isset($input['locale']) && (in_array($input['locale'], $locales)) ? htmlsafechars($input['locale']) : 'posts');
if (!$check) {
    rep_output('Incorrect Access');
}
if ($rep_locale == 'posts') {
    ///////////////////////////////////////////////
    // check the post actually exists!
    ///////////////////////////////////////////////
    $forum = sql_query("SELECT posts.topic_id AS locale, posts.user_id AS userid, forums.min_class_read,
users.username, users.reputation
FROM posts
LEFT JOIN topics ON topic_id = topics.id
LEFT JOIN forums ON topics.forum_id = forums.id
LEFT JOIN users ON posts.user_id = users.id
WHERE posts.id =".sqlesc($input['pid'])) or sqlerr(__FILE__, __LINE__);
} elseif ($rep_locale == 'comments') {
    ///////////////////////////////////////////////
    // check the comment actually exists!
    ///////////////////////////////////////////////
    //uncomment the following  if use comments.anonymous field
    $forum = sql_query("SELECT comments.id, comments.user AS userid, comments.anonymous AS anon,
     comments.torrent AS locale,
     users.username, users.reputation
     FROM comments
     LEFT JOIN users ON comments.user = users.id
     WHERE comments.id = ".sqlesc($input['pid'])) or sqlerr(__FILE__, __LINE__);
} elseif ($rep_locale == 'torrents') {
    ///////////////////////////////////////////////
    // check the uploader actually exists!
    ///////////////////////////////////////////////
    $forum = sql_query("SELECT torrents.id as locale, torrents.owner AS userid, torrents.anonymous AS anon,
    users.username, users.reputation
    FROM torrents
    LEFT JOIN users ON torrents.owner = users.id
    WHERE torrents.id =".sqlesc($input['pid'])) or sqlerr(__FILE__, __LINE__);
} elseif ($rep_locale == 'users') {
    ///////////////////////////////////////////////
    // check the user actually exists!
    ///////////////////////////////////////////////
    $forum = sql_query("SELECT id AS userid, username, reputation, opt1, opt2 FROM users WHERE id =".sqlesc($input['pid'])) or sqlerr(__FILE__, __LINE__);
} // end
switch ($rep_locale) {
case 'comments':
    $this_rep = 'Comment';
    break;

case 'torrents':
    $this_rep = 'Torrent';
    break;

case 'users':
    $this_rep = 'Profile';
    break;

default:
    $this_rep = 'Post';
}
// does it or don't it?
if (!mysqli_num_rows($forum)) rep_output($this_rep . ' Does Not Exist - Incorrect Access');
///////////////////////////////////////////////
// ok, lets proceed
///////////////////////////////////////////////
$res = mysqli_fetch_assoc($forum);
if (isset($res['minclassread'])) // 'posts'
if ($CURUSER['class'] < $res['minclassread'])
// check permissions! Dun want sneaky pests lookin!
{
    rep_output('Wrong Permissions');
}
///////////////////////////////////////////////
//	Does the user have memory loss? Have they already rep'd?
///////////////////////////////////////////////
$repeat = sql_query("SELECT postid FROM reputation WHERE postid =".sqlesc($input['pid'])." AND whoadded=".sqlesc($CURUSER['id'])) or sqlerr(__FILE__, __LINE__);
//$repres = mysql_fetch_assoc( $forum ) or sqlerr(__LINE__,__FILE__);
if (mysqli_num_rows($repeat) > 0 && $rep_locale != 'users') // blOOdy eedjit check!
{
    rep_output('You have already added Rep to this ' . $this_rep . '!'); // Is insane!
    
}
///////////////////////////////////////////////
// 	Is a mod or gone over the limit?
///////////////////////////////////////////////
if (!$is_mod) {
    if ($GVARS['rep_maxperday'] >= $GVARS['rep_repeat']) {
        $klimit = intval($GVARS['rep_maxperday'] + 1);
    } else {
        $klimit = intval($GVARS['rep_repeat'] + 1);
    }
    ///////////////////////////////////////////////
    //	Some trivial flood checking
    ///////////////////////////////////////////////
    $flood = sql_query("SELECT dateadd, userid FROM reputation WHERE whoadded = ".sqlesc($CURUSER['id'])." ORDER BY dateadd DESC LIMIT 0 , ".sqlesc($klimit)) or sqlerr(__FILE__, __LINE__);
    if (mysqli_num_rows($flood)) {
        $i = 0;
        while ($check = mysqli_fetch_assoc($flood)) {
            if (($i < $GVARS['rep_repeat']) && ($check['userid'] == $CURUSER['id'])) //$res['userid'] ) )
            {
                rep_output($lang["info_cannot_rate_own"]);
            }
            if ((($i + 1) == $GVARS['rep_maxperday']) && (($check['dateadd'] + 86400) > TIMENOW)) {
                rep_output($lang["info_daily_rep_limit_expired"]);
            }
            $i++;
        }
    }
}
///////////////////////////////////////////////
//	Passed flood checkin, what to do now?
///////////////////////////////////////////////
// Note: if you use another forum type, you may already have this GLOBAL available
// So you can save a query here, else...
$r = sql_query("SELECT COUNT(*) FROM posts WHERE user_id = ".sqlesc($CURUSER['id'])) or sqlerr(__FILE__, __LINE__);
$a = mysqli_fetch_row($r);
$CURUSER['posts'] = intval($a[0]);
///////////////////////////////////////////////
// What's the reason for bothering me?
///////////////////////////////////////////////
$reason = '';
if (isset($input['reason']) && !empty($input['reason'])) {
    $reason = trim($input['reason']);
    $temp = stripslashes($input['reason']);
    if ((strlen(trim($temp)) < 2) || ($reason == "")) {
        rep_output($lang["info_reason_too_short"]);
    }
    if (strlen(preg_replace("/&#([0-9]+);/", "-", stripslashes($input['reason']))) > 250) {
        rep_output($lang["info_reason_too_long"]);
    }
}
//$input['do'] = 'addrep';
//$input['reputation'] = 1;
//$INSTALLER09['baseurl'] ='';
///////////////////////////////////////////////
//	Are we adding a rep or what?
///////////////////////////////////////////////
if (isset($input['do']) && $input['do'] == 'addrep') {
    if ($res['userid'] == $CURUSER['id']) // sneaky bastiges!
    {
        rep_output($lang["info_cannot_rate_own"]);
    }
    $score = fetch_reppower($CURUSER, $input['reputation']);
    $res['reputation']+= $score;
    sql_query("UPDATE users set reputation=" . sqlesc(intval($res['reputation'])) . " WHERE id=" . sqlesc($res['userid'])) or sqlerr(__FILE__, __LINE__);
    $mc1->begin_transaction('MyUser_' . $res['userid']);
    $mc1->update_row(false, array(
        'reputation' => $res['reputation']
    ));
    $mc1->commit_transaction($INSTALLER09['expires']['curuser']);
    $mc1->begin_transaction('user' . $res['userid']);
    $mc1->update_row(false, array(
        'reputation' => $res['reputation']
    ));
    $mc1->commit_transaction($INSTALLER09['expires']['user_cache']);
    $mc1->delete_value('user_rep_' . $res['userid']);
    $save = array(
        'reputation' => sqlesc($score),
        'whoadded' => sqlesc($CURUSER['id']),
        'reason' => sqlesc($reason) ,
        'dateadd' => TIMENOW,
        'locale' => sqlesc($rep_locale) ,
        'postid' => sqlesc(intval($input['pid'])),
        'userid' => sqlesc(intval($res['userid']))
    );
    //print( join( ',', $save) );
    //print( join(',', array_keys($save)));
    sql_query("INSERT INTO reputation (" . join(',', array_keys($save)) . ") VALUES (" . join(',', $save) . ")") or sqlerr(__FILE__, __LINE__);
    header("Location: {$INSTALLER09['baseurl']}/reputation.php?pid=".intval($input['pid'])."&done=1");
} // Move along, nothing to see here!
else {
    if ($res['userid'] == $CURUSER['id']) // same as him!
    {
        // check for fish!
        $query1 = sql_query("SELECT r.*, leftby.id AS leftby_id, leftby.username AS leftby_name
                                        FROM reputation r
                                        LEFT JOIN users leftby ON leftby.id=r.whoadded
                                        WHERE postid=".sqlesc($input['pid'])."
                                        AND r.locale = " . sqlesc($input['locale']) . "
                                        ORDER BY dateadd DESC") or sqlerr(__FILE__, __LINE__);
        $reasonbits = '';
        if (false !== mysqli_num_rows($query1)) {
            $total = 0;
            while ($postrep = mysqli_fetch_assoc($query1)) {
                $total+= $postrep['reputation'];
                if ($postrep['reputation'] > 0) {
                    $posneg = 'pos';
                } elseif ($postrep['reputation'] < 0) {
                    $posneg = 'neg';
                } else {
                    $posneg = 'balance';
                }
                if ($GVARS['g_rep_seeown']) {
                    $postrep['reason'] = htmlsafechars($postrep['reason']) . " <span class='desc'>{$lang["rep_left_by"]} <a href=\"{$INSTALLER09['baseurl']}/userdetails.php?id=".intval($postrep['leftby_id'])."\" target='_blank'>".htmlspecialchars($postrep['leftby_name'])."</a></span>";
                }
                $reasonbits.= "<tr>
	<td class='row2' width='1%'><img src='./pic/rep/reputation_$posneg.gif' border='0' alt='' /></td>
	<td class='row2'>".htmlspecialchars($postrep['reason'])."</td>
</tr>";
            }
            ///////////////////////////////////////////////
            //	The negativity...oh such negativity
            ///////////////////////////////////////////////
            if ($total == 0) {
                $rep = $lang["rep_even"];
            } elseif ($total > 0 && $total <= 5) {
                $rep = $lang["rep_somewhat_positive"];
            } elseif ($total > 5 && $total <= 15) {
                $rep = $lang["rep_positive"];
            } elseif ($total > 15 && $total <= 25) {
                $rep = $lang["rep_very_positive"];
            } elseif ($total > 25) {
                $rep = $lang["rep_extremely_positive"];
            } elseif ($total < 0 && $total >= - 5) {
                $rep = $lang["rep_somewhat_negative"];
            } elseif ($total < - 5 && $total >= - 15) {
                $rep = $lang["rep_negative"];
            } elseif ($total < - 15 && $total >= - 25) {
                $rep = $lang["rep_very_negative"];
            } elseif ($total < - 25) {
                $rep = $lang["rep_extremely_negative"];
            }
        } else {
            $rep = $lang["rep_even"]; //Ok, dunno what to do, so just make it quits!
            
        }
        switch ($rep_locale) {
        case 'comments':
            $rep_info = sprintf("Your reputation on <a href='{$INSTALLER09['baseurl']}/details.php?id=%d&amp;viewcomm=%d#comm%d' target='_blank'>this Comment</a> is %s<br />Total: %s points.", $res['locale'], $input['pid'], $input['pid'], $rep, $total);
            break;

        case 'torrents':
            $rep_info = sprintf("Your reputation on <a href='{$INSTALLER09['baseurl']}/details.php?id=%d' target='_blank'>this Torrent</a> is %s<br />Total: %s points.", $input['pid'], $rep, $total);
            break;

        case 'users':
            $rep_info = sprintf("Your reputation on <a href='{$INSTALLER09['baseurl']}/userdetails.php?id=%d' target='_blank'>your profile</a> is %s<br />Total: %s points.", $input['pid'], $rep, $total);
            break;

        default:
            $rep_info = sprintf("Your reputation on <a href='{$INSTALLER09['baseurl']}/forums.php?action=viewtopic&amp;topicid=%d&amp;page=p%d#%d' target='_blank'>this Post</a> is %s<br />Total: %s points.", $res['locale'], $input['pid'], $input['pid'], $rep, $total);
        }
        ///////////////////////////////////////////////
        //	Compile some HTML for the 'own post'/ 'user view' reputation
        //	Feel free to do ya own html/css here
        ///////////////////////////////////////////////
        //$rep_info = sprintf("".$lang["info_your_rep_on"]." <a href='{$INSTALLER09['baseurl']}/forums.php?action=viewtopic&amp;topicid=%d&amp;page=p%d#%d' target='_blank'>".$lang["info_this_post"]."</a> ".$lang["info_is"]." %s.", $res['topicid'], $input['pid'], $input['pid'], $rep );
        $rep_points = sprintf("" . $lang["info_you_have"] . " %d " . $lang["info_reputation_points"] . "", $CURUSER['reputation']);
        $html = "<tr><td class='darkrow1'>".htmlsafechars($rep_info)."</td></tr>
						<tr>
							<td class='row2'>
							<div class='tablepad'>";
        if ($reasonbits) {
            $html.= "<fieldset class='fieldset'>
								<legend>{$lang["rep_comments"]}</legend>
								<table class='ipbtable' cellpadding='0'>
								$reasonbits
								</table>
							</fieldset><br />";
        }
        $html.= "<div class='formsubtitle' align='center'><strong>{$rep_points}</strong></div>
						</div>
						</td>
					</tr>";
    } else {
        ///////////////////////////////////////////////
        //	HTML/CSS for 'add reputaion'
        //	Feel free to alter HTML/CSS here
        ///////////////////////////////////////////////
        $res['anon'] = (isset($res['anon']) ? $res['anon'] : 'no');
        $rep_text = sprintf("What do you think of %s's " . $this_rep . "?", ($res['anon'] == 'yes' ? 'Anonymous' : htmlsafechars($res['username'])));
        $negativerep = ($is_mod || $GVARS['g_rep_negative']) ? TRUE : FALSE;
        $closewindow = FALSE;
        $html = "<tr><td class='darkrow1'>{$lang["info_add_rep"]} <b>" . htmlsafechars($res['username']) . "</b></td></tr>
						<tr>
							<td class='row2'>
							<form action='reputation.php' method='post'>	
							<div class='tablepad'>
								<fieldset>
									<legend>$rep_text</legend>
									<table class='f_row' cellspacing='0'>
									<tr>
										<td>
											<div><label for='rb_reputation_pos'>
											<input type='radio' name='reputation' value='pos' id='rb_reputation_pos' checked='checked' class='radiobutton' style='margin:0px;' /> &nbsp;{$lang["rep_i_approve"]}</label></div>";
        if ($negativerep) {
            $html.= "<div><label for='rb_reputation_neg'><input type='radio' name='reputation' value='neg' id='rb_reputation_neg' class='radiobutton' style='margin:0px;' /> &nbsp;{$lang["rep_i_disapprove"]}</label></div>";
        }
        $html.= "</td>
							</tr>
							<tr>
								<td>
									{$lang["rep_your_comm_on_this_post"]} " . $this_rep . "<br />
									<input type='text' size='40' maxlength='250' name='reason' style='margin:0px;' />
								</td>
							</tr>
							</table>
						</fieldset>
					</div>
					<div align='center' style='margin-top:3px;'>
						<input type='hidden' name='act' value='reputation' />
						<input type='hidden' name='do' value='addrep' />
						<input type='hidden' name='pid' value='".intval($input['pid'])."' />
						<input type='hidden' name='locale' value='".htmlsafechars($input['locale'])."' />
						<input type='submit' value='" . $lang["info_add_rep"] . "' class='button' accesskey='s' />
						<input type='button' value='Close Window' class='button' accesskey='c' onclick='self.close()' />
					</div>	
					</form>	
					</td>
				</tr>";
    }
    rep_output("", $html); // send to spewer-outer function
    
} // END
///////////////////////////////////////////////
//	Reputation output function
//	$msg -> string
//	$html -> string
///////////////////////////////////////////////
function rep_output($msg = "", $html = "")
{
    global $closewindow, $lang, $CURUSER, $INSTALLER09;
    if ($msg && empty($html)) {
        $html = "<tr><td class='row'>$msg</td></tr>";
    }
?>
    <!DOCTYPE html>
  <html xmlns="http://www.w3.org/1999/xhtml" lang="en">
		<head>
		    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=0.35, maximum-scale=1" />			
		<title>Reputation System</title>
    	<link rel="stylesheet" href="css/font-awesome.min.css" />
        <link rel="stylesheet" href="css/bootstrap.css" type="text/css">
        <link rel="stylesheet" href="css/global_media.css" type="text/css" />
<link rel='stylesheet' href='<?php
    echo $INSTALLER09['baseurl']; ?>/templates/<?php
    echo $CURUSER['stylesheet']; ?>/<?php
    echo $CURUSER['stylesheet']; ?>.css' type='text/css' />
  
    </head>
    <body>
    <?php
    $html = "<div class='panel panel-default' id='reputation'>
	<div class='panel-heading'>
		<label for='checkbox_1' class='text-left'>Reputation System</label>
	</div><div class='panel-body'>
<table class='table table-striped table-bordered'>
		$html";

    if ($closewindow) {
        $html.= "<tr><td class='main' align='center'><a href='javascript:self.close();'><b>{$lang["info_close_rep"]}</b></a></td></tr>";
    }
    $html.= "</table></div></div></body></html>";
    echo $html;
    exit();
}
///////////////////////////////////////////////
//	Fetch Reputation function
//	$user -> array all about the user
//	$rep -> string what kind of rep this user has
///////////////////////////////////////////////
function fetch_reppower($user = array() , $rep = 'pos')
{
    global $GVARS, $is_mod;
    $reppower = '';
    // is the user allowed to do negative reps?
    if (!$GVARS['g_rep_negative']) {
        $rep = 'pos';
    }
    if (!$GVARS['g_rep_use']) // allowed to rep at all?
    {
        $rep = 0;
    } elseif ($is_mod && $GVARS['rep_adminpower']) // is a mod and has loadsa power?
    { //work out positive or negative admin power
        $reppower = ($rep != 'pos') ? intval($GVARS['rep_adminpower'] * -1) : intval($GVARS['rep_adminpower']);
    } elseif (($user['posts'] < $GVARS['rep_minpost']) || ($user['reputation'] < $GVARS['rep_minrep'])) { // not an admin, then work out postal based power
        $reppower = 0;
    } else { // ok failed all tests, so ratio is 1:1 but not negative, unless allowed
        $reppower = 1;
        if ($GVARS['rep_pcpower']) { // percentage power
            $reppower+= intval($user['posts'] / $GVARS['rep_pcpower']);
        }
        if ($GVARS['rep_kppower']) { // rep as based upon a constant of kppower global
            $reppower+= intval($user['reputation'] / $GVARS['rep_kppower']);
        }
        if ($GVARS['rep_rdpower']) { // time based power
            $reppower+= intval((TIMENOW - $user['added']) / 86400 / $GVARS['rep_rdpower']);
        }
        if ($rep != 'pos') {
            // Negative rep is worth half that of positive, but must be atleast 1, else it gets messy
            $reppower = intval($reppower / 2);
            $reppower = ($reppower < 1) ? 1 : $reppower;
            $reppower*= - 1;
        }
    }
    return $reppower;
}
// erm, FIN

?>
