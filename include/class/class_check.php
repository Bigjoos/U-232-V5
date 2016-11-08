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
//==include/class_check.php
/*
class_check by pdq,
autopost and 404 idea by Retro, 
staff array & auth by system,
PIN idea by SirSnuggleBunny.
*/
/** 
 // USAGE in staff pages: //
 // below:
 dbconn();
 loggedinorreturn();
 // add:
 require_once 'include/class_check.php';
 class_check(UC_MODERATOR);                // staff class check
 // require PIN:
 require_once 'include/class_check.php';
 class_check(UC_MODERATOR, true, true); // staff class check & require PIN
 // USAGE in non-staff pages: //
 require_once 'include/class_check.php';
 class_check(UC_POWER_USER, false);     // use for non-staff pages
 // END //
 *
 */
if (!defined('TBVERSION')) { //cannot access this file directly
    $HTMLOUT = '';
    $HTMLOUT.= '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
        <html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
        <head>
        <meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
        <title>ERROR</title>
        </head><body>
        <h1>ERROR</h1>Cannot Access this file directly.
        </body></html>';
    echo $HTMLOUT;
    exit();
}
/** $class = UC_CLASS_NAME: minimum class required to view page
 $staff = true: make sure staff are really staff and have permission to view page
 $pin   = true: require staff PIN
 *
 */
function class_check($class = 0, $staff = true, $pin = false)
{
    global $CURUSER, $INSTALLER09, $mc1;
    require_once (CACHE_DIR.'staff_settings2.php');
    /** basic checking **/
    if (!$CURUSER) {
        require_once '404.html';
        //die('404');
        exit();
    }
    /** required class check **/
    if ($CURUSER['class'] >= $class) {
        /** require correct staff PIN **/
        if ($pin) {
            // not allowed staff!
            if (!isset($INSTALLER09['staff']['allowed'][$CURUSER['username']])) {
                require_once '404.html';
                //die('404 - Kiss my aRse !!');
                exit();
            }
            $passed = false;
            // have sent a username/pass and are using their own username
            if (isset($_SERVER['PHP_AUTH_USER']) && isset($_SERVER['PHP_AUTH_PW']) && $_SERVER['PHP_AUTH_USER'] === ($CURUSER['username'])) {
                // generate a passhash from the sent password
                $hash = md5($INSTALLER09['site']['salt2'] . $_SERVER['PHP_AUTH_PW'] . $CURUSER['secret']);
                // if the password is correct, exit this function
                if (md5($INSTALLER09['site']['salt2'] . $INSTALLER09['staff']['staff_pin'] . $CURUSER['secret']) === $hash) $passed = true;
            }
            if (!$passed) {
                // they're not allowed, the username doesn't match their own, the password is
                // wrong or they have not sent user/pass yet so we exit
                header('WWW-Authenticate: Basic realm="Administration"');
                header('HTTP/1.0 401 Unauthorized');
                $HTMLOUT = '';
                $HTMLOUT.= '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
                      <html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
                      <head>
                      <meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
                      <title>ERROR</title>
                      </head><body>
                      <h1 align="center">ERROR</h1><p align="center">Sorry! Access denied!</p>
                      </body></html>';
                echo $HTMLOUT;
                exit();
            }
        } // end PIN
        if ($staff) { // staff class required
            
            /** do some checking **/
            //if ((!valid_class($CURUSER['class'])) || (!isset($INSTALLER09['staff']['allowed'][strtolower($CURUSER['username'])]))) { // failed: illegal access ...
            if (($CURUSER['class'] > UC_MAX) || (!isset($INSTALLER09['staff']['allowed'][$CURUSER['username']]))) { // failed: illegal access ...
                
                /** user info **/
                $ip = getip();
                /** file ban them **/
                // @fclose(@fopen(INCL_DIR.'bans/'.$ip, 'w'));
                
                /** SQL ban them **/
                //require_once(INCL_DIR.'bans.php');
                //make_bans($ip, $_SERVER['REMOTE_ADDR'], 'Bad Class. Join IRC for assistance.');
                
                /** auto post to forums**/
                $body = sqlesc("User " . $CURUSER['username'] . " - " . $ip . "\n Class " . $CURUSER['class'] . "\n Current page: " . $_SERVER['PHP_SELF'] . ", Previous page: " . (isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'no referer') . ", Action: " . $_SERVER['REQUEST_URI'] . "\n Member has been disabled and demoted by class check system.");
                /*
                $body2 = sqlesc("User ".$CURUSER['username']." - ".$ip.
                               " Class ".$CURUSER['class'].
                               " Current page: ".$_SERVER['PHP_SELF'].
                               ", Previous page: ".(isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'no referer').
                               ", Action: ".$_SERVER['REQUEST_URI'].
                               " Member has been disabled and demoted by class check system. - Kill the fuX0r");
                */
                $topicid = (int)$INSTALLER09['staff']['forumid'];
                $added = TIME_NOW;
                $icon = 1;
                sql_query("INSERT INTO posts (topic_id, user_id, added, body, icon) " . "VALUES(".sqlesc($topicid)." , " . $INSTALLER09['bot_id'] . ", $added, $body, ".sqlesc($icon).")") or sqlerr(__file__, __line__);
                /** get mysql_insert_id(); **/
                $res = sql_query("SELECT id FROM posts WHERE topic_id = ".sqlesc($topicid)." 
                                  ORDER BY id DESC LIMIT 1") or sqlerr(__file__, __line__);
                $arr = mysqli_fetch_row($res) or die('No staff post found');
                $postid = (int)$arr[0];
                sql_query("UPDATE topics SET last_post = ".sqlesc($postid)." WHERE id = ".sqlesc($topicid)) or sqlerr(__file__, __line__);
                /** PM Owner **/
                $subject = sqlesc('Warning Class Check System!');
                sql_query("INSERT INTO messages (sender, receiver, added, subject, msg) 
                VALUES (0, " . $INSTALLER09['site']['owner'] . ", $added, $subject, $body)") or sqlerr(__file__, __line__);
                /** punishments **/
                //sql_query("UPDATE users SET enabled = 'no', class = 1 WHERE id = {$CURUSER['id']}") or sqlerr(__file__, __line__);
                sql_query("UPDATE users SET class = 1 WHERE id = {$CURUSER['id']}") or sqlerr(__file__, __line__);
                /** remove caches **/
                $mc1->begin_transaction('user' . $CURUSER['id']);
                $mc1->update_row(false, array(
                    'class' => 1
                ));
                $mc1->commit_transaction($INSTALLER09['expires']['user_cache']);
                $mc1->begin_transaction('MyUser_' . $CURUSER['id']);
                $mc1->update_row(false, array(
                    'class' => 1
                ));
                $mc1->commit_transaction($INSTALLER09['expires']['curuser']);
                //==
                
                /** log **/
                //write_log("<span style='color:#FA0606;'>Class Check System Initialized</span><a href='forums.php?action=viewtopic&amp;topicid=$topicid&amp;page=last#$postid'>VIEW</a>", UC_SYSOP, false);
                write_log('Class Check System Initialized [url=' . $INSTALLER09['baseurl'] . '/forums.php?action=view_topic&amp;topic_id=' . $topicid . '&amp;page=last#' . $postid . ']VIEW[/url]');
                //require_once(INCL_DIR.'user_functions.php');
                //autoshout($body2);
                $HTMLOUT = '';
                $HTMLOUT.= "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\"
		            \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">
		            <html xmlns='http://www.w3.org/1999/xhtml'>
		            <head>
		            <title>Error!</title>
		            </head>
		            <body>
	              <div style='font-size:18px;color:black;background-color:red;text-align:center;'>Incorrect access<br />Silly Rabbit - Trix are for kids.. You dont have the correct credentials to be here !</div>
	              </body></html>";
                echo $HTMLOUT;
                exit();
                //die('No access!'); // give em some Output
                
            }
        }
    } else { // if less than required class
        if (!$staff) // if not staff page :P
        stderr('ERROR', 'No Permission. Page is for ' . get_user_class_name($class) . 's and above. Read FAQ.');
        else { // if staff page
            require_once '404.html';
            //die('404');
            exit();
        }
    }
}
//===== Auto Set Script Access Class by Mistero ================\\
//===== Modded For V4 By Stoner ================\\
       function get_access($script) {
            global $CURUSER, $INSTALLER09, $mc1;
            $ending = parse_url($script, PHP_URL_QUERY);
            $count = substr_count($ending, "&");
            $i = 0;
            while ($i <= $count) {
       if (strpos($ending, "&")){
            $ending = substr( $ending, 0, strrpos( $ending, "&"));
            }
            $i++;
       }
            if (($class = $mc1 ->get_value('av_class_'.$ending)) == false) {
            $classid = sql_query("SELECT av_class FROM staffpanel WHERE file_name LIKE '%$ending%'") or sqlerr(__file__,__line__);
            $classid = mysqli_fetch_assoc($classid);
            $class = (int)$classid['av_class'];
            $mc1->cache_value('av_class_' . $ending, $class, 900); //== test values 15 minutes to 0 once delete key in place //==
       }
            return $class;
       }
?>
