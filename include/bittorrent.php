<?php
/**
 |--------------------------------------------------------------------------|
 |   https://github.com/Bigjoos/                			    |
 |--------------------------------------------------------------------------|
 |   Licence Info: GPL						            |
 |--------------------------------------------------------------------------|
 |   Copyright (C) 2010 U-232 V5				            |
 |--------------------------------------------------------------------------|
 |   A bittorrent tracker source based on TBDev.net/tbsource/bytemonsoon.   |
 |--------------------------------------------------------------------------|
 |   Project Leaders: Mindless, Autotron, whocares, Swizzles.		    |
 |--------------------------------------------------------------------------|
  _   _   _   _   _     _   _   _   _   _   _     _   _   _   _
 / \ / \ / \ / \ / \   / \ / \ / \ / \ / \ / \   / \ / \ / \ / \
( U | - | 2 | 3 | 2 )-( S | o | u | r | c | e )-( C | o | d | e )
 \_/ \_/ \_/ \_/ \_/   \_/ \_/ \_/ \_/ \_/ \_/   \_/ \_/ \_/ \_/
 */
//==Start execution time
$start = microtime(true);
if( !file_exists(__DIR__ . DIRECTORY_SEPARATOR . 'config.php') ) {
    header('Location: /install');
    die();
}
require_once (__DIR__ . DIRECTORY_SEPARATOR . 'config.php');
require_once (CACHE_DIR . 'free_cache.php');
require_once (CACHE_DIR . 'site_settings.php');
require_once (CACHE_DIR . 'staff_settings.php');
require_once (CACHE_DIR . 'class_config.php');
//==Start memcache
require_once (CLASS_DIR . 'class_cache.php');
require_once(CLASS_DIR.'class.crypt.php');
$mc1 = NEW CACHE();
//==Block class
class curuser
{
    public static $blocks = array();
}
$CURBLOCK = & curuser::$blocks;
/*
class curuser_mod
{
    public static $mod_blocks = array();
}
$CURMODBLOCK = & curuser_mod::$mod_blocks;
*/
require_once CLASS_DIR . 'class_blocks_index.php';
require_once CLASS_DIR . 'class_blocks_stdhead.php';
require_once CLASS_DIR . 'class_blocks_userdetails.php';
require_once CLASS_DIR . 'class_bt_options.php';
require_once CACHE_DIR . 'block_settings_cache.php';
//== djgrrr
$load = sys_getloadavg();
if ($load[0] > 20)
  die('Load is too high, Dont continuously refresh, or you will just make the problem last longer');
if (preg_match('/(?:\< *(?:java|script)|script\:|\+document\.)/i', serialize($_SERVER)))
  die('Forbidden');
if (preg_match('/(?:\< *(?:java|script)|script\:|\+document\.)/i', serialize($_GET)))
  die('Forbidden');
if (preg_match('/(?:\< *(?:java|script)|script\:|\+document\.)/i', serialize($_POST)))
  die('Forbidden');
if (preg_match('/(?:\< *(?:java|script)|script\:|\+document\.)/i', serialize($_COOKIE)))
  die('Forbidden');
//==
////////Strip slashes by system//////////
function cleanquotes(&$in)
{
    if (is_array($in)) return array_walk($in, 'cleanquotes');
    return $in = stripslashes($in);
}
if (get_magic_quotes_gpc()) {
    array_walk($_GET, 'cleanquotes');
    array_walk($_POST, 'cleanquotes');
    array_walk($_COOKIE, 'cleanquotes');
    array_walk($_REQUEST, 'cleanquotes');
}
//== Updated 02/215
function htmlsafechars($txt = '')
{
    $txt = preg_replace("/&(?!#[0-9]+;)(?:amp;)?/s", '&amp;', $txt);
    $txt = str_replace(array(
        "<",
        ">",
        '"',
        "'"
    ), array(
        "&lt;",
        "&gt;",
        "&quot;",
        '&#039;'
    ), $txt);
    return $txt;
}
function PostKey($ids = array())
{
    global $INSTALLER09;
    if (!is_array($ids)) return false;
    return md5($INSTALLER09['tracker_post_key'] . join('', $ids) . $INSTALLER09['tracker_post_key']);
}
function CheckPostKey($ids, $key)
{
    global $INSTALLER09;
    if (!is_array($ids) OR !$key) return false;
    return $key == md5($INSTALLER09['tracker_post_key'] . join('', $ids) . $INSTALLER09['tracker_post_key']);
}
/**** validip/getip courtesy of manolete <manolete@myway.com> ****/
//== IP Validation
function validip($ip)
{
	return filter_var($ip, FILTER_VALIDATE_IP,
                  array('flags' => FILTER_FLAG_NO_PRIV_RANGE, FILTER_FLAG_NO_RES_RANGE)
                  ) ? true : false;
}

//== Patched function to detect REAL IP address if it's valid
function getip() {
   if (isset($_SERVER)) {
     if (isset($_SERVER['HTTP_X_FORWARDED_FOR']) && validip($_SERVER['HTTP_X_FORWARDED_FOR'])) {
       $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
     } elseif (isset($_SERVER['HTTP_CLIENT_IP']) && validip($_SERVER['HTTP_CLIENT_IP'])) {
       $ip = $_SERVER['HTTP_CLIENT_IP'];
     } else {
       $ip = $_SERVER['REMOTE_ADDR'];
     }
   } else {
     if (getenv('HTTP_X_FORWARDED_FOR') && validip(getenv('HTTP_X_FORWARDED_FOR'))) {
       $ip = getenv('HTTP_X_FORWARDED_FOR');
     } elseif (getenv('HTTP_CLIENT_IP') && validip(getenv('HTTP_CLIENT_IP'))) {
       $ip = getenv('HTTP_CLIENT_IP');
     } else {
       $ip = getenv('REMOTE_ADDR');
     }
   }

   return $ip;
 }
function dbconn($autoclean = false)
{
    global $INSTALLER09;
    if (!@($GLOBALS["___mysqli_ston"] = mysqli_connect($INSTALLER09['mysql_host'], $INSTALLER09['mysql_user'], $INSTALLER09['mysql_pass']))) {
        switch (((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_errno($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_errno()) ? $___mysqli_res : false))) {
        case 1040:
        case 2002:
            if ($_SERVER['REQUEST_METHOD'] == "GET") die("<html><head><meta http-equiv='refresh' content=\"5 $_SERVER[REQUEST_URI]\"></head><body><table border='0' width='100%' height='100%'><tr><td><h3 align='center'>The server load is very high at the moment. Retrying, please wait...</h3></td></tr></table></body></html>");
            else die("Too many users. Please press the Refresh button in your browser to retry.");
        default:
            die("[" . ((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_errno($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_errno()) ? $___mysqli_res : false)) . "] dbconn: mysql_connect: " . ((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
        }
    }
    ((bool)mysqli_query($GLOBALS["___mysqli_ston"], "USE {$INSTALLER09['mysql_db']}")) or die('dbconn: mysql_select_db: ' . ((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
    userlogin();
    referer();
    if ($autoclean) register_shutdown_function("autoclean");
}
function status_change($id)
{
    sql_query('UPDATE announcement_process SET status = 0 WHERE user_id = ' . sqlesc($id) . ' AND status = 1');
}
function hashit($var, $addtext = "")
{
    return md5("Th15T3xt" . $addtext . $var . $addtext . "is5add3dto66uddy6he@water...");
}
//== check bans by djGrrr <3 pdq
function check_bans($ip, &$reason = '')
{
    global $INSTALLER09, $mc1, $c;
    //$ip_decrypt = $c->decrypt($ip);
    $key = 'bans:::' . $ip;
    if (($ban = $mc1->get_value($key)) === false && $ip != '127.0.0.1') { 
        $nip = ip2long($ip);
        $ban_sql = sql_query('SELECT comment FROM bans WHERE (first <= ' . $nip . ' AND last >= ' . $nip . ') LIMIT 1');
        if (mysqli_num_rows($ban_sql)) {
            $comment = mysqli_fetch_row($ban_sql);
            $reason = 'Manual Ban (' . $comment[0] . ')';
            $mc1->cache_value($key, $reason, 86400); // 86400 // banned
            return true;
        }
        ((mysqli_free_result($ban_sql) || (is_object($ban_sql) && (get_class($ban_sql) == "mysqli_result"))) ? true : false);
        $mc1->cache_value($key, 0, 86400); // 86400 // not banned
        return false;
    } elseif (!$ban) return false;
    else {
        $reason = $ban;
        return true;
    }
}
function userlogin()
{
    global $INSTALLER09, $mc1, $CURBLOCK, $mood, $whereis, $CURUSER, $c;
    unset($GLOBALS["CURUSER"]);
    $dt = TIME_NOW;
    $ip = getip();
    //$ipe = $c -> decrypt($ip);
    $nip = ip2long($ip);
    $ipf = $_SERVER['REMOTE_ADDR'];
    if (isset($CURUSER)) return;
    if (!$INSTALLER09['site_online'] || !get_mycookie('uid') || !get_mycookie('pass') || !get_mycookie('hashv')) return;
    $id = intval(get_mycookie('uid'));
    if (!$id OR (strlen(get_mycookie('pass')) != 32) OR (get_mycookie('hashv') != hashit($id, get_mycookie('pass')))) return;
    // let's cache $CURUSER - pdq - *Updated*
    if (($row = $mc1->get_value('MyUser_' . $id)) === false) { // $row not found
        $user_fields_ar_int = array(
            'id',
            'added',
            'last_login',
            'last_access',
            'curr_ann_last_check',
            'curr_ann_id',
            'stylesheet',
            'class',
            'override_class',
            'language',
            'av_w',
            'av_h',
            'country',
            'warned',
            'torrentsperpage',
            'topicsperpage',
            'postsperpage',
            'reputation',
            'dst_in_use',
            'auto_correct_dst',
            'chatpost',
            'smile_until',
            'vip_until',
            'freeslots',
            'free_switch',
            'reputation',
            'invites',
            'invitedby',
            'uploadpos',
            'forumpost',
            'downloadpos',
            'immunity',
            'leechwarn',
            'last_browse',
            'sig_w',
            'sig_h',
            'forum_access',
            'hit_and_run_total',
            'donoruntil',
            'donated',
            'vipclass_before',
            'passhint',
            'avatarpos',
            'sendpmpos',
            'invitedate',
            'anonymous_until',
            'pirate',
            'king',
            'ssluse',
            'paranoia',
            'parked_until',
            'bjwins',
            'bjlosses',
            'irctotal',
            'last_access_numb',
            'onlinetime',
            'hits',
            'comments',
            'categorie_icon',
            'perms',
            'mood',
            'pms_per_page',
            'watched_user',
            'game_access',
            'opt1',
            'opt2',
            'can_leech',
            'wait_time',
            'torrents_limit',
            'peers_limit',
            'torrent_pass_version'
        );
        $user_fields_ar_float = array(
            'time_offset',
            'total_donated'
        );
        $user_fields_ar_str = array(
            'username',
            'passhash',
            'secret',
            'torrent_pass',
            'email',
            'status',
            'editsecret',
            'privacy',
            'info',
            'acceptpms',
            'ip',
            'avatar',
            'title',
            'notifs',
            'enabled',
            'donor',
            'deletepms',
            'savepms',
            'show_shout',
            'show_staffshout',
            'shoutboxbg',
            'vip_added',
            'invite_rights',
            'anonymous',
            'disable_reason',
            'clear_new_tag_manually',
            'signatures',
            'signature',
            'highspeed',
            'hnrwarn',
            'parked',
            'hintanswer',
            'support',
            'supportfor',
            'invitees',
            'invite_on',
            'subscription_pm',
            'gender',
            'viewscloud',
            'tenpercent',
            'avatars',
            'offavatar',
            'hidecur',
            'signature_post',
            'forum_post',
            'avatar_rights',
            'offensive_avatar',
            'view_offensive_avatar',
            'google_talk',
            'msn',
            'aim',
            'yahoo',
            'website',
            'icq',
            'show_email',
            'gotgift',
            'hash1',
            'suspended',
            'warn_reason',
            'onirc',
            'birthday',
            'got_blocks',
            'pm_on_delete',
            'commentpm',
            'split',
            'browser',
            'got_moods',
            'show_pm_avatar',
            'watched_user_reason',
            'staff_notes',
            'where_is',
            'ignore_list',
            'browse_icons',
            'forum_mod',
            'forums_mod',
            'altnick',
            'forum_sort',
            'pm_forced'
        );
        $user_fields = implode(', ', array_merge($user_fields_ar_int, $user_fields_ar_float, $user_fields_ar_str));
        //$res = sql_query("SELECT " . $user_fields . " " . "FROM users " . "WHERE id = " . sqlesc($id) . " " . "AND enabled='yes' " . "AND status = 'confirmed'") or sqlerr(__FILE__, __LINE__);
         $res = sql_query("SELECT {$user_fields}, ann_main.subject AS curr_ann_subject, ann_main.body AS curr_ann_body " . "FROM users AS u " . "LEFT JOIN announcement_main AS ann_main " . "ON ann_main.main_id = u.curr_ann_id " . "WHERE u.id = " . sqlesc($id)." AND u.enabled='yes' AND u.status = 'confirmed'") or sqlerr(__FILE__, __LINE__);
        if (mysqli_num_rows($res) == 0) {
            $salty = md5("Th15T3xtis5add3dto66uddy6he@water..." . $row['username'] . "");
            header("Location: {$INSTALLER09['baseurl']}/logout.php?hash_please={$salty}");
            //die;
            return;
        }
        $row = mysqli_fetch_assoc($res);
        foreach ($user_fields_ar_int as $i) $row[$i] = (int)$row[$i];
        foreach ($user_fields_ar_float as $i) $row[$i] = (float)$row[$i];
        foreach ($user_fields_ar_str as $i) $row[$i] = $row[$i];
        $mc1->cache_value('MyUser_' . $id, $row, $INSTALLER09['expires']['curuser']);
        unset($res);
    }
    //==
    if (get_mycookie('pass') !== md5($row["passhash"] . $_SERVER["REMOTE_ADDR"])) {
        $salty = md5("Th15T3xtis5add3dto66uddy6he@water..." . $row['username'] . "");
        header("Location: {$INSTALLER09['baseurl']}/logout.php?hash_please={$salty}");
        //die;
        return;
    }

    //If curr_ann_id > 0 but curr_ann_body IS NULL, then force a refresh
    if (($row['curr_ann_id'] > 0) AND ($row['curr_ann_body'] == NULL)) {
    $row['curr_ann_id'] = 0;
    $row['curr_ann_last_check'] = 0;
    }
    // If elapsed > 10 minutes, force a announcement refresh.
    if (($row['curr_ann_last_check'] != 0) AND ($row['curr_ann_last_check'] < $dt - 900))
    $row['curr_ann_last_check'] = 0;
    
             if (($row['curr_ann_id'] == 0) AND ($row['curr_ann_last_check'] == 0))
             { // Force an immediate check...
                     $query = sprintf('SELECT m.*,p.process_id FROM announcement_main AS m '.
                             'LEFT JOIN announcement_process AS p ON m.main_id = p.main_id '.
                             'AND p.user_id = %s '.
                             'WHERE p.process_id IS NULL '.
                             'OR p.status = 0 '.
                             'ORDER BY m.main_id ASC '.
                             'LIMIT 1',
            sqlesc($row['id']));
            $result = sql_query($query);
            if (mysqli_num_rows($result))
            { // Main Result set exists
            $ann_row = mysqli_fetch_assoc($result);
            $query = sqlesc($ann_row['sql_query']);
            // Ensure it only selects...
            if (!preg_match('/\\ASELECT.+?FROM.+?WHERE.+?\\z/', $query)) die('Oops, Query error');
            // The following line modifies the query to only return the current user
            // row if the existing query matches any attributes.
            $query .= ' AND u.id = '.sqlesc($row['id']).' LIMIT 1';
            $result = sql_query($query);
            if (mysqli_num_rows($result))
            { // Announcement valid for member
            $row['curr_ann_id'] = (int)$ann_row['main_id'];
            // Create two row elements to hold announcement subject and body.
            $row['curr_ann_subject'] = htmlsafechars($ann_row['subject']);
            $row['curr_ann_body'] = htmlsafechars($ann_row['body']);
            // Create additional set for main UPDATE query.
            $add_set = ', curr_ann_id = '.sqlesc($ann_row['main_id']);
            $mc1->begin_transaction('user' . $CURUSER['id']);
            $mc1->update_row(false, array(
                'curr_ann_id' => $ann_row['main_id']
            ));
            $mc1->commit_transaction($INSTALLER09['expires']['user_cache']);
            $mc1->begin_transaction('MyUser_' . $CURUSER['id']);
            $mc1->update_row(false, array(
                'curr_ann_id' => $ann_row['main_id']
            ));
            $mc1->commit_transaction($INSTALLER09['expires']['curuser']);
            $status = 2;
            //$status = 0;
            }
            else
            {
            // Announcement not valid for member...
            $add_set = ', curr_ann_last_check = '.sqlesc($dt);
            $mc1->begin_transaction('user' . $CURUSER['id']);
            $mc1->update_row(false, array(
                'curr_ann_last_check' => $dt
            ));
            $mc1->commit_transaction($INSTALLER09['expires']['user_cache']);
            $mc1->begin_transaction('MyUser_' . $CURUSER['id']);
            $mc1->update_row(false, array(
                'curr_ann_last_check' => $dt
            ));
            $mc1->commit_transaction($INSTALLER09['expires']['curuser']);
            $status = 1;
            }
            // Create or set status of process
            if ($ann_row['process_id'] === NULL)
            {
            // Insert Process result set status = 1 (Ignore)
            $query = sprintf('INSERT INTO announcement_process (main_id, '.
            'user_id, status) VALUES (%s, %s, %s)',
            sqlesc($ann_row['main_id']),
            sqlesc($row['id']),
            sqlesc($status));
            }
            else
            {
            // Update Process result set status = 2 (Read)
            $query = sprintf('UPDATE announcement_process SET status = %s '.
            'WHERE process_id = %s',
            sqlesc($status),
            sqlesc($ann_row['process_id']));
            }
            sql_query($query);
            }
            else
            {
            // No Main Result Set. Set last update to now...
            $add_set = ', curr_ann_last_check = '.sqlesc($dt);
            $mc1->begin_transaction('user' . $CURUSER['id']);
            $mc1->update_row(false, array(
            'curr_ann_last_check' => $dt
        ));
            $mc1->commit_transaction($INSTALLER09['expires']['user_cache']);
            $mc1->begin_transaction('MyUser_' . $CURUSER['id']);
            $mc1->update_row(false, array(
            'curr_ann_last_check' => $dt
        ));
            $mc1->commit_transaction($INSTALLER09['expires']['curuser']);
            }
            unset($result);
            unset($ann_row);
    }
    // bans by djGrrr <3 pdq
    if (!isset($row['perms']) || (!($row['perms'] & bt_options::PERMS_BYPASS_BAN))) {
        $banned = false;
        if (check_bans($ip, $reason)) $banned = true;
        else {
            if ($ip != $ipf) {
                if (check_bans($ipf, $reason)) $banned = true;
            }
        }
        if ($banned) {
            header('Content-Type: text/html; charset=utf-8');
            echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
      <html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en"><head>
      <title>Forbidden</title>
      </head><body>
      <h1>403 Forbidden</h1>Unauthorized IP address!
      <p>Reason: <strong>' . htmlsafechars($reason) . '</strong></p>
      </body></html>';
            die;
        }
    }
    // Allowed staff
    if ($row["class"] >= UC_STAFF) {
        $allowed_ID = $INSTALLER09['allowed_staff']['id'];
        if (!in_array(((int)$row["id"]) , $allowed_ID, true)) {
            $msg = "Fake Account Detected: Username: " . htmlsafechars($row["username"]) . " - UserID: " . (int)$row["id"] . " - UserIP : " . getip();
            // Demote and disable
            sql_query("UPDATE users SET enabled = 'no', class = 0 WHERE id =" . sqlesc($row["id"])) or sqlerr(__file__, __line__);
            $mc1->begin_transaction('MyUser_' . $row['id']);
            $mc1->update_row(false, array(
                'enabled' => 'no',
                'class' => 0
            ));
            $mc1->commit_transaction($INSTALLER09['expires']['curuser']);
            $mc1->begin_transaction('user' . $row['id']);
            $mc1->update_row(false, array(
                'enabled' => 'no',
                'class' => 0
            ));
            $mc1->commit_transaction($INSTALLER09['expires']['user_cache']);
            write_log($msg);
            $salty = md5("Th15T3xtis5add3dto66uddy6he@water..." . $row['username'] . "");
            header("Location: {$INSTALLER09['baseurl']}/logout.php?hash_please={$salty}");
            die;
        }
    }
    // user stats - *Updated*
    $What_Cache = (XBT_TRACKER == true ? 'userstats_xbt_' : 'userstats_');
    if (($stats = $mc1->get_value($What_Cache.$id)) === false) {
    $What_Expire = (XBT_TRACKER == true ? $INSTALLER09['expires']['u_stats_xbt'] : $INSTALLER09['expires']['u_stats']);
        $stats_fields_ar_int = array(
            'uploaded',
            'downloaded'
        );
        $stats_fields_ar_float = array(
            'seedbonus'
        );
        $stats_fields_ar_str = array(
            'modcomment',
            'bonuscomment'
        );
        $stats_fields = implode(', ', array_merge($stats_fields_ar_int, $stats_fields_ar_float, $stats_fields_ar_str));
        $s = sql_query("SELECT " . $stats_fields . " FROM users WHERE id=" . sqlesc($id)) or sqlerr(__FILE__, __LINE__);
        $stats = mysqli_fetch_assoc($s);
        foreach ($stats_fields_ar_int as $i) $stats[$i] = (int)$stats[$i];
        foreach ($stats_fields_ar_float as $i) $stats[$i] = (float)$stats[$i];
        foreach ($stats_fields_ar_str as $i) $stats[$i] = $stats[$i];
        $mc1->cache_value($What_Cache.$id, $stats, $What_Expire);
    }
    $row['seedbonus'] = $stats['seedbonus'];
    $row['uploaded'] = $stats['uploaded'];
    $row['downloaded'] = $stats['downloaded'];
    //==
    if (($ustatus = $mc1->get_value('userstatus_' . $id)) === false) {
        $sql2 = sql_query('SELECT * FROM ustatus WHERE userid = ' . sqlesc($id));
        if (mysqli_num_rows($sql2)) $ustatus = mysqli_fetch_assoc($sql2);
        else $ustatus = array(
            'last_status' => '',
            'last_update' => 0,
            'archive' => ''
        );
        $mc1->add_value('userstatus_' . $id, $ustatus, $INSTALLER09['expires']['u_status']); // 30 days
    }
    $row['last_status'] = $ustatus['last_status'];
    $row['last_update'] = $ustatus['last_update'];
    $row['archive'] = $ustatus['archive'];
    //==
    if ($row['ssluse'] > 1 && !isset($_SERVER['HTTPS']) && !defined('NO_FORCE_SSL')) {
        $INSTALLER09['baseurl'] = str_replace('http', 'https', $INSTALLER09['baseurl']);
        header('Location: ' . $INSTALLER09['baseurl'] . $_SERVER['REQUEST_URI']);
        exit();
    }
    // bitwise curuser bloks by pdq
    $blocks_key = 'blocks::' . $row['id'];
    if (($CURBLOCK = $mc1->get_value($blocks_key)) === false) {
        $c_sql = sql_query('SELECT * FROM user_blocks WHERE userid = ' . sqlesc($row['id'])) or sqlerr(__FILE__, __LINE__);
        if (mysqli_num_rows($c_sql) == 0) {
            sql_query('INSERT INTO user_blocks(userid) VALUES(' . sqlesc($row['id']) . ')');
            header('Location: index.php');
            die();
        }
        $CURBLOCK = mysqli_fetch_assoc($c_sql);
        $CURBLOCK['index_page'] = (int)$CURBLOCK['index_page'];
        $CURBLOCK['global_stdhead'] = (int)$CURBLOCK['global_stdhead'];
        $CURBLOCK['userdetails_page'] = (int)$CURBLOCK['userdetails_page'];
        $mc1->cache_value($blocks_key, $CURBLOCK, 0);
    }
    /*
    // bitwise curuser mods by Bigjoos
    $mods_blocks_key = 'mod_blocks::' . $row['id'];
    if (($CURMODBLOCK = $mc1->get_value($mods_blocks_key)) === false) {
        $m_sql = sql_query('SELECT * FROM mods_control WHERE userid = ' . sqlesc($row['id'])) or sqlerr(__FILE__, __LINE__);
        if (mysqli_num_rows($m_sql) == 0) {
            sql_query('INSERT INTO mods_control(userid) VALUES(' . sqlesc($row['id']) . ')');
            header('Location: index.php');
            die();
        }
        $CURMODBLOCK = mysqli_fetch_assoc($m_sql);
        $CURMODBLOCK['index_page_mods'] = (int)$CURMODBLOCK['index_page_mods'];
        $CURMODBLOCK['global_stdhead_mods'] = (int)$CURMODBLOCK['global_stdhead_mods'];
        $CURMODBLOCK['userdetails_page_mods'] = (int)$CURMODBLOCK['userdetails_page_mods'];
        $mc1->cache_value($mods_blocks_key, $CURMODBLOCK, 30);
    }
    */
    //== where is by putyn
    $where_is['username'] = htmlsafechars($row['username']);
    $whereis_array = array(
        'index' => '%s is viewing the <a href="%s">home page</a>',
        'browse' => '%s is viewing the <a href="%s">torrents page</a>',
        'requests' => '%s is viewing the <a href="%s">requests page</a>',
        'upload' => '%s is viewing the <a href="%s">upload page</a>',
        'casino' => '%s is viewing the <a href="%s">casino page</a>',
        'blackjack' => '%s is viewing the <a href="%s">blackjack page</a>',
        'radio' => '%s is viewing the <a href="%s">radio page</a>',
        'forums' => '%s is viewing the <a href="%s">forums page</a>',
        'chat' => '%s is viewing the <a href="%s">irc page</a>',
        'topten' => '%s is viewing the <a href="%s">statistics page</a>',
        'faq' => '%s is viewing the <a href="%s">faq page</a>',
        'rules' => '%s is viewing the <a href="%s">rules page</a>',
        'staff' => '%s is viewing the <a href="%s">staff page</a>',
        'wiki' => '%s is viewing the <a href="%s">wiki page</a>',
        'usercp' => '%s is viewing the <a href="%s">usercp page</a>',
        'offers' => '%s is viewing the <a href="%s">offers page</a>',
        'pm_system' => '%s is viewing the <a href="%s">mailbox page</a>',
        'userdetails' => '%s is viewing the <a href="%s">personal profile page</a>',
        'details' => '%s is viewing the <a href="%s">torrents details page</a>',
        'unknown' => '%s location is unknown'
    );
    if (preg_match('/\/(.*?)\.php/is', $_SERVER['REQUEST_URI'], $whereis_temp)) {
        if (isset($whereis_array[$whereis_temp[1]])) $whereis = sprintf($whereis_array[$whereis_temp[1]], $where_is['username'], htmlsafechars($_SERVER['REQUEST_URI']));
        else $whereis = sprintf($whereis_array['unknown'], $where_is['username']);
    } else $whereis = sprintf($whereis_array['unknown'], $where_is['username']);
    //== online time pdq, original code by superman
    $userupdate0 = 'onlinetime = onlinetime + 0';
    $new_time = TIME_NOW - $row['last_access_numb'];
    $update_time = 0;
    if ($new_time < 300) {
        $userupdate0 = "onlinetime = onlinetime + " . $new_time;
        $update_time = $new_time;
    }
    $userupdate1 = "last_access_numb = " . TIME_NOW;
    //end online-time
    $update_time = ($row['onlinetime'] + $update_time);
    $add_set = (isset($add_set)) ? $add_set : '';
     if (($row['last_access'] != '0') AND (($row['last_access']) < ($dt - 180))/** 3 mins **/ || ($row['ip'] !== $ip)) 
    {
        sql_query("UPDATE users SET where_is =" . sqlesc($whereis) . ", ip=".sqlesc($ip).$add_set.", last_access=" . TIME_NOW . ", $userupdate0, $userupdate1 WHERE id=" . sqlesc($row['id']));
        $mc1->begin_transaction('MyUser_' . $row['id']);
        $mc1->update_row(false, array(
            'last_access' => TIME_NOW,
            'onlinetime' => $update_time,
            'last_access_numb' => TIME_NOW,
            'where_is' => $whereis,
            'ip' => $ip
        ));
        $mc1->commit_transaction($INSTALLER09['expires']['curuser']);
        $mc1->begin_transaction('user' . $row['id']);
        $mc1->update_row(false, array(
            'last_access' => TIME_NOW,
            'onlinetime' => $update_time,
            'last_access_numb' => TIME_NOW,
            'where_is' => $whereis,
            'ip' => $ip
        ));
        $mc1->commit_transaction($INSTALLER09['expires']['user_cache']);
    }
    //==
    if ($row['override_class'] < $row['class']) $row['class'] = $row['override_class']; // Override class and save in GLOBAL array below.
    $GLOBALS["CURUSER"] = $row;
    get_template();
    $mood = create_moods();
}
function charset()
{
    global $CURUSER, $INSTALLER09;
    $lang_charset = $CURUSER['language'];
    switch ($lang_charset) {
    case ($lang_charset == 2):
        return "ISO-8859-1";
    case ($lang_charset == 3):
        return "ISO-8859-17";
    case ($lang_charset == 4):
		return "ISO-8859-15";
    default:
        return "UTF-8";
    }
}
//== 2010 Tbdev Cleanup Manager by ColdFusion
function autoclean()
{
    global $INSTALLER09;
    $now = TIME_NOW;
    $sql = sql_query("SELECT * FROM cleanup WHERE clean_on = 1 AND clean_time <= {$now} ORDER BY clean_time ASC LIMIT 0,1");
    $row = mysqli_fetch_assoc($sql);
    if ($row['clean_id']) {
        $next_clean = intval($now + ($row['clean_increment'] ? $row['clean_increment'] : 15 * 60));
        sql_query("UPDATE cleanup SET clean_time = ".sqlesc($next_clean)." WHERE clean_id = ".sqlesc($row['clean_id']));
        if (file_exists(CLEAN_DIR . '' . $row['clean_file'])) {
            require_once (CLEAN_DIR . 'clean_log.php');
            require_once (CLEAN_DIR . '' . $row['clean_file']);
            if (function_exists('docleanup')) {
                register_shutdown_function('docleanup', $row);
            }
        }
    }
}
function get_template()
{
    global $CURUSER, $INSTALLER09;
    if (isset($CURUSER)) {
        if (file_exists(TEMPLATE_DIR . "{$CURUSER['stylesheet']}/template.php")) {
            require_once (TEMPLATE_DIR . "{$CURUSER['stylesheet']}/template.php");
        } else {
            if (isset($INSTALLER09)) {
                if (file_exists(TEMPLATE_DIR . "{$INSTALLER09['stylesheet']}/template.php")) {
                    require_once (TEMPLATE_DIR . "{$INSTALLER09['stylesheet']}/template.php");
                } else {
                    echo "Sorry, Templates do not seem to be working properly and missing some code. Please report this to the programmers/owners.";
                }
            } else {
                if (file_exists(TEMPLATE_DIR . "1/template.php")) {
                    require_once (TEMPLATE_DIR . "1/template.php");
                } else {
                    echo "Sorry, Templates do not seem to be working properly and missing some code. Please report this to the programmers/owners.";
                }
            }
        }
    } else {
        if (file_exists(TEMPLATE_DIR . "{$INSTALLER09['stylesheet']}/template.php")) {
            require_once (TEMPLATE_DIR . "{$INSTALLER09['stylesheet']}/template.php");
        } else {
            echo "Sorry, Templates do not seem to be working properly and missing some code. Please report this to the programmers/owners.";
        }
    }
    if (!function_exists("stdhead")) {
        echo "stdhead function missing";
        function stdhead($title = "", $message = true)
        {
            return "<html><head><title>$title</title></head><body>";
        }
    }
    if (!function_exists("stdfoot")) {
        echo "stdfoot function missing";
        function stdfoot()
        {
            return "</body></html>";
        }
    }
    if (!function_exists("stdmsg")) {
        echo "stdmgs function missing";
        function stdmsg($title, $message)
        {
            return "<b>" . $title . "</b><br />$message";
        }
    }
    if (!function_exists("StatusBar")) {
        echo "StatusBar function missing";
        function StatusBar()
        {
            global $CURUSER, $lang;
            return "{$lang['gl_msg_welcome']}, {$CURUSER['username']}";
        }
    }
}
//== Alternate color class
    class ListCycler {
    private $cols, $offs, $len;
    //== expects two or more string parameters ( . ) ( . ) 
    public function __construct() {
        $this->offs = -1;
        $this->len = func_num_args();
        $this->cols = func_get_args();
        foreach($this->cols as &$c)
            $c = trim(strval($c));
    }
    //== the object auto-increments every time it is read \0/
    public function __toString() {
        $this->offs = ($this->offs+1) % $this->len;
        return $this->cols[ $this->offs ];
       }
    }
    $rc = new ListCycler('one','two');
//slots - pdq
function make_freeslots($userid, $key)
{
    global $mc1, $INSTALLER09;
    if (($slot = $mc1->get_value($key . $userid)) === false) {
        $res_slots = sql_query('SELECT * FROM freeslots WHERE userid = ' . sqlesc($userid)) or sqlerr(__file__, __line__);
        $slot = array();
        if (mysqli_num_rows($res_slots)) {
            while ($rowslot = mysqli_fetch_assoc($res_slots)) $slot[] = $rowslot;
        }
        $mc1->cache_value($key . $userid, $slot, 86400 * 7);
    }
    return $slot;
}
//bookmarks - pdq
function make_bookmarks($userid, $key)
{
    global $mc1, $INSTALLER09;
    if (($book = $mc1->get_value($key . $userid)) === false) {
        $res_books = sql_query('SELECT * FROM bookmarks WHERE userid = ' . sqlesc($userid)) or sqlerr(__file__, __line__);
        $book = array();
        if (mysqli_num_rows($res_books)) {
            while ($rowbook = mysqli_fetch_assoc($res_books)) $book[] = $rowbook;
        }
        $mc1->cache_value($key . $userid, $book, 86400 * 7); // 7 days
    }
    return $book;
}
//genrelist - pdq
function genrelist()
{
    global $mc1, $INSTALLER09;
    if (($ret = $mc1->get_value('genrelist')) == false) {
        $ret = array();
        $res = sql_query("SELECT id, image, name, min_class FROM categories ORDER BY name");
        while ($row = mysqli_fetch_assoc($res)) $ret[] = $row;
        $mc1->cache_value('genrelist', $ret, $INSTALLER09['expires']['genrelist']);
    }
    return $ret;
}
// moods - pdq
function create_moods($force = false)
{
    global $mc1, $INSTALLER09;
    $key = 'moods';
    if (($mood = $mc1->get_value($key)) === false || $force) {
        $res_moods = sql_query('SELECT * FROM moods ORDER BY id ASC') or sqlerr(__file__, __line__);
        $mood = array();
        if (mysqli_num_rows($res_moods)) {
            while ($rmood = mysqli_fetch_assoc($res_moods)) {
                $mood['image'][$rmood['id']] = $rmood['image'];
                $mood['name'][$rmood['id']] = $rmood['name'];
            }
        }
        $mc1->cache_value($key, $mood, 86400 * 7);
    }
    return $mood;
}
//== delete
function delete_id_keys($keys, $keyname = false)
{
    global $mc1;
    if (!(is_array($keys) || $keyname)) // if no key given or not an array
    return false;
    else foreach ($keys as $id) // proceed
    $mc1->delete_value($keyname . $id);
    return true;
}
function unesc($x)
{
    if (get_magic_quotes_gpc()) return stripslashes($x);
    return $x;
}
function mksize($bytes) {
    $bytes = max(0, (int)$bytes);
    if ($bytes < 1024000) return number_format($bytes / 1024, 2).' KB'; #Kilobyte
    elseif ($bytes < 1048576000) return number_format($bytes / 1048576, 2).' MB'; #Megabyte
    elseif ($bytes < 1073741824000) return number_format($bytes / 1073741824, 2).' GB'; #Gigebyte
    elseif ($bytes < 1099511627776000) return number_format($bytes / 1099511627776, 3).' TB'; #Terabyte
    elseif ($bytes < 1125899906842624000) return number_format($bytes / 1125899906842624, 3).' PB'; #Petabyte
    elseif ($bytes < 1152921504606846976000) return number_format($bytes / 1152921504606846976, 3).' EB'; #Exabyte
    elseif ($bytes < 1180591620717411303424000) return number_format($bytes / 1180591620717411303424, 3).' ZB'; #Zettabyte
    else return number_format($bytes / 1208925819614629174706176, 3).' YB'; #Yottabyte
}
function mkprettytime($s)
{
    if ($s < 0) $s = 0;
    $t = array();
    foreach (array(
        "60:sec",
        "60:min",
        "24:hour",
        "0:day"
    ) as $x) {
        $y = explode(":", $x);
        if ($y[0] > 1) {
            $v = $s % $y[0];
            $s = floor($s / $y[0]);
        } else $v = $s;
        $t[$y[1]] = $v;
    }
    if ($t["day"]) return $t["day"] . "d " . sprintf("%02d:%02d:%02d", $t["hour"], $t["min"], $t["sec"]);
    if ($t["hour"]) return sprintf("%d:%02d:%02d", $t["hour"], $t["min"], $t["sec"]);
    return sprintf("%d:%02d", $t["min"], $t["sec"]);
}
function mkglobal($vars)
{
    if (!is_array($vars)) $vars = explode(":", $vars);
    foreach ($vars as $v) {
        if (isset($_GET[$v])) $GLOBALS[$v] = unesc($_GET[$v]);
        elseif (isset($_POST[$v])) $GLOBALS[$v] = unesc($_POST[$v]);
        else return 0;
    }
    return 1;
}
function validfilename($name)
{
    return preg_match('/^[^\0-\x1f:\\\\\/?*\xff#<>|]+$/si', $name);
}
function validemail($email)
{
    return preg_match('/^[\w.-]+@([\w.-]+\.)+[a-z]{2,6}$/is', $email);
}
//putyn  08/08/2011
function sqlesc($x)
{
    if (is_integer($x)) return (int)$x;
    return sprintf('\'%s\'', ((isset($GLOBALS["___mysqli_ston"]) && is_object($GLOBALS["___mysqli_ston"])) ? mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $x) : ((trigger_error("Err", E_USER_ERROR)) ? "" : "")));
}
function sqlwildcardesc($x)
{
    return str_replace(array(
        "%",
        "_"
    ) , array(
        "\\%",
        "\\_"
    ) , ((isset($GLOBALS["___mysqli_ston"]) && is_object($GLOBALS["___mysqli_ston"])) ? mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $x) : ((trigger_error("", E_USER_ERROR)) ? "" : "")));
}
function httperr($code = 404)
{
    header("HTTP/1.0 404 Not found");
    echo "<h1>Not Found</h1>\n";
    echo "<p>Sorry pal :(</p>\n";
    exit();
}
function logincookie($id, $passhash, $updatedb = 1, $expires = 0x7fffffff)
{
    set_mycookie("uid", $id, $expires);
    set_mycookie("pass", $passhash, $expires);
    set_mycookie("hashv", hashit($id, $passhash) , $expires);
    if ($updatedb) sql_query("UPDATE users SET last_login = " . TIME_NOW . " WHERE id = " . sqlesc($id)) or sqlerr(__file__, __line__);
}
function set_mycookie($name, $value = "", $expires_in = 0, $sticky = 1)
{
    global $INSTALLER09;
    if ($sticky == 1) {
        $expires = TIME_NOW + 60 * 60 * 24 * 365;
    } else if ($expires_in) {
        $expires = TIME_NOW + ($expires_in * 86400);
    } else {
        $expires = FALSE;
    }
    $INSTALLER09['cookie_domain'] = $INSTALLER09['cookie_domain'] == "" ? "" : $INSTALLER09['cookie_domain'];
    $INSTALLER09['cookie_path'] = $INSTALLER09['cookie_path'] == "" ? "/" : $INSTALLER09['cookie_path'];
    if (PHP_VERSION < 5.2) {
        if ($INSTALLER09['cookie_domain']) {
            @setcookie($INSTALLER09['cookie_prefix'] . $name, $value, $expires, $INSTALLER09['cookie_path'], $INSTALLER09['cookie_domain'] . '; HttpOnly');
        } else {
            @setcookie($INSTALLER09['cookie_prefix'] . $name, $value, $expires, $INSTALLER09['cookie_path']);
        }
    } else {
        @setcookie($INSTALLER09['cookie_prefix'] . $name, $value, $expires, $INSTALLER09['cookie_path'], $INSTALLER09['cookie_domain'], NULL, TRUE);
    }
}
function get_mycookie($name)
{
    global $INSTALLER09;
    if (isset($_COOKIE[$INSTALLER09['cookie_prefix'] . $name]) AND !empty($_COOKIE[$INSTALLER09['cookie_prefix'] . $name])) {
        return urldecode($_COOKIE[$INSTALLER09['cookie_prefix'] . $name]);
    } else {
        return FALSE;
    }
}
function logoutcookie()
{
    set_mycookie('uid', '-1');
    set_mycookie('pass', '-1');
    set_mycookie('hashv', '-1');
}
function loggedinorreturn()
{
    global $CURUSER, $INSTALLER09;
    if (!$CURUSER) {
        header("Location: {$INSTALLER09['baseurl']}/login.php?returnto=" . urlencode($_SERVER["REQUEST_URI"]));
        exit();
    }
}
function searchfield($s)
{
    return preg_replace(array(
        '/[^a-z0-9]/si',
        '/^\s*/s',
        '/\s*$/s',
        '/\s+/s'
    ) , array(
        " ",
        "",
        "",
        " "
    ) , $s);
}
function get_row_count($table, $suffix = "")
{
    if ($suffix) $suffix = " $suffix";
    ($r = sql_query("SELECT COUNT(*) FROM $table$suffix")) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
    ($a = mysqli_fetch_row($r)) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
    return $a[0];
}
function stderr($heading, $text)
{
    $htmlout = stdhead();
    $htmlout.= stdmsg($heading, $text);
    $htmlout.= stdfoot();
    echo $htmlout;
    exit();
}
// Basic MySQL error handler
function sqlerr($file = '', $line = '')
{
    global $INSTALLER09, $CURUSER;
    $the_error = ((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false));
    $the_error_no = ((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_errno($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_errno()) ? $___mysqli_res : false));
    if (SQL_DEBUG == 0) {
        exit();
    } else if ($INSTALLER09['sql_error_log'] AND SQL_DEBUG == 1) {
        $_error_string = "\n===================================================";
        $_error_string.= "\n Date: " . date('r');
        $_error_string.= "\n Error Number: " . $the_error_no;
        $_error_string.= "\n Error: " . $the_error;
        $_error_string.= "\n IP Address: " . $_SERVER['REMOTE_ADDR'];
        $_error_string.= "\n in file " . $file . " on line " . $line;
        $_error_string.= "\n URL:" . $_SERVER['REQUEST_URI'];
        $_error_string.= "\n Username: {$CURUSER['username']}[{$CURUSER['id']}]";
        if ($FH = @fopen($INSTALLER09['sql_error_log'], 'a')) {
            @fwrite($FH, $_error_string);
            @fclose($FH);
        }
        echo "<html><head><title>MySQLI Error</title>
					<style>P,BODY{ font-family:arial,sans-serif; font-size:11px; }</style></head><body>
		    		   <blockquote><h1>MySQLI Error</h1><b>There appears to be an error with the database.</b><br />
		    		   You can try to refresh the page by clicking <a href=\"javascript:window.location=window.location;\">here</a>
				  </body></html>";
    } else {
        $the_error = "\nSQL error: " . $the_error . "\n";
        $the_error.= "SQL error code: " . $the_error_no . "\n";
        $the_error.= "Date: " . date("l dS \of F Y h:i:s A");
        $out = "<html>\n<head>\n<title>MySQLI Error</title>\n
	    		   <style>P,BODY{ font-family:arial,sans-serif; font-size:11px; }</style>\n</head>\n<body>\n
	    		   <blockquote>\n<h1>MySQLI Error</h1><b>There appears to be an error with the database.</b><br />
	    		   You can try to refresh the page by clicking <a href=\"javascript:window.location=window.location;\">here</a>.
	    		   <br /><br /><b>Error Returned</b><br />
	    		   <form name='mysql'><textarea rows=\"15\" cols=\"60\">" . htmlsafechars($the_error, ENT_QUOTES) . "</textarea></form><br>We apologise for any inconvenience</blockquote></body></html>";
        echo $out;
    }
    exit();
}
function get_dt_num()
{
    return gmdate("YmdHis");
}
function write_log($text)
{
    $text = sqlesc($text);
    $added = TIME_NOW;
    sql_query("INSERT INTO sitelog (added, txt) VALUES($added, $text)") or sqlerr(__FILE__, __LINE__);
}
function sql_timestamp_to_unix_timestamp($s)
{
    return mktime(substr($s, 11, 2) , substr($s, 14, 2) , substr($s, 17, 2) , substr($s, 5, 2) , substr($s, 8, 2) , substr($s, 0, 4));
}
function unixstamp_to_human($unix = 0)
{
    $offset = get_time_offset();
    $tmp = gmdate('j,n,Y,G,i', $unix + $offset);
    list($day, $month, $year, $hour, $min) = explode(',', $tmp);
    return array(
        'day' => $day,
        'month' => $month,
        'year' => $year,
        'hour' => $hour,
        'minute' => $min
    );
}
function get_time_offset()
{
    global $CURUSER, $INSTALLER09;
    $r = 0;
    $r = (($CURUSER['time_offset'] != "") ? $CURUSER['time_offset'] : $INSTALLER09['time_offset']) * 3600;
    if ($INSTALLER09['time_adjust']) {
        $r+= ($INSTALLER09['time_adjust'] * 60);
    }
    if ($CURUSER['dst_in_use']) {
        $r+= 3600;
    }
    return $r;
}
function get_date($date, $method, $norelative = 0, $full_relative = 0)
{
    global $INSTALLER09;
    static $offset_set = 0;
    static $today_time = 0;
    static $yesterday_time = 0;
    $time_options = array(
        'JOINED' => $INSTALLER09['time_joined'],
        'SHORT' => $INSTALLER09['time_short'],
        'LONG' => $INSTALLER09['time_long'],
        'TINY' => $INSTALLER09['time_tiny'] ? $INSTALLER09['time_tiny'] : 'j M Y - G:i',
        'DATE' => $INSTALLER09['time_date'] ? $INSTALLER09['time_date'] : 'j M Y'
    );
    if (!$date) {
        return '--';
    }
    if (empty($method)) {
        $method = 'LONG';
    }
    if ($offset_set == 0) {
        $GLOBALS['offset'] = get_time_offset();
        if ($INSTALLER09['time_use_relative']) {
            $today_time = gmdate('d,m,Y', (TIME_NOW + $GLOBALS['offset']));
            $yesterday_time = gmdate('d,m,Y', ((TIME_NOW - 86400) + $GLOBALS['offset']));
        }
        $offset_set = 1;
    }
    if ($INSTALLER09['time_use_relative'] == 3) {
        $full_relative = 1;
    }
    if ($full_relative and ($norelative != 1)) {
        $diff = TIME_NOW - $date;
        if ($diff < 3600) {
            if ($diff < 120) {
                return '< 1 minute ago';
            } else {
                return sprintf('%s minutes ago', intval($diff / 60));
            }
        } else if ($diff < 7200) {
            return '&lt 1 hour ago';
        } else if ($diff < 86400) {
            return sprintf('%s hours ago', intval($diff / 3600));
        } else if ($diff < 172800) {
            return '&lt 1 day ago';
        } else if ($diff < 604800) {
            return sprintf('%s days ago', intval($diff / 86400));
        } else if ($diff < 1209600) {
            return '&lt 1 week ago';
        } else if ($diff < 3024000) {
            return sprintf('%s weeks ago', intval($diff / 604900));
        } else {
            return gmdate($time_options[$method], ($date + $GLOBALS['offset']));
        }
    } else if ($INSTALLER09['time_use_relative'] and ($norelative != 1)) {
        $this_time = gmdate('d,m,Y', ($date + $GLOBALS['offset']));
        if ($INSTALLER09['time_use_relative'] == 2) {
            $diff = TIME_NOW - $date;
            if ($diff < 3600) {
                if ($diff < 120) {
                    return '< 1 minute ago';
                } else {
                    return sprintf('%s minutes ago', intval($diff / 60));
                }
            }
        }
        if ($this_time == $today_time) {
            return str_replace('{--}', 'Today', gmdate($INSTALLER09['time_use_relative_format'], ($date + $GLOBALS['offset'])));
        } else if ($this_time == $yesterday_time) {
            return str_replace('{--}', 'Yesterday', gmdate($INSTALLER09['time_use_relative_format'], ($date + $GLOBALS['offset'])));
        } else {
            return gmdate($time_options[$method], ($date + $GLOBALS['offset']));
        }
    } else {
        return gmdate($time_options[$method], ($date + $GLOBALS['offset']));
    }
}
function ratingpic($num)
{
    global $INSTALLER09;
    $r = round($num * 2) / 2;
    if ($r < 1 || $r > 5) return;
    return "<img src=\"pic/ratings/{$r}.gif\" border=\"0\" alt=\"Rating: $num / 5\" title=\"Rating: $num / 5\" />";
}
function hash_pad($hash)
{
    return str_pad($hash, 20);
}
//== cutname = Laffin
function CutName($txt, $len = 40)
{
    return (strlen($txt) > $len ? substr($txt, 0, $len - 1) . '...' : $txt);
}
function CutName_B($txt, $len = 20)
{
    return (strlen($txt) > $len ? substr($txt, 0, $len - 1) . '...' : $txt);
}
function load_language($file = '')
{
    global $INSTALLER09, $CURUSER;
    if (!isset($GLOBALS['CURUSER']) OR empty($GLOBALS['CURUSER']['language'])) {
        if (!file_exists(LANG_DIR . "{$INSTALLER09['language']}/lang_{$file}.php")) {
            stderr('System Error', 'Can\'t find language files');
        }
        require_once (LANG_DIR . "{$INSTALLER09['language']}/lang_{$file}.php");
        return $lang;
    }
    if (!file_exists(LANG_DIR . "{$CURUSER['language']}/lang_{$file}.php")) {
        stderr('System Error', 'Can\'t find language files');
    } else {
        require_once LANG_DIR . "{$CURUSER['language']}/lang_{$file}.php";
    }
    return $lang;
}
function flood_limit($table)
{
    global $CURUSER, $INSTALLER09, $lang;
    if (!file_exists($INSTALLER09['flood_file']) || !is_array($max = unserialize(file_get_contents($INSTALLER09['flood_file'])))) return;
    if (!isset($max[$CURUSER['class']])) return;
    $tb = array(
        'posts' => 'posts.user_id',
        'comments' => 'comments.user',
        'messages' => 'messages.sender'
    );
    $q = sql_query('SELECT min(' . $table . '.added) as first_post, count(' . $table . '.id) as how_many FROM ' . $table . ' WHERE ' . $tb[$table] . ' = ' . $CURUSER['id'] . ' AND ' . TIME_NOW . ' - ' . $table . '.added < ' . $INSTALLER09['flood_time']);
    $a = mysqli_fetch_assoc($q);
    if ($a['how_many'] > $max[$CURUSER['class']]) stderr($lang['gl_sorry'], $lang['gl_flood_msg'] . '' . mkprettytime($INSTALLER09['flood_time'] - (TIME_NOW - $a['first_post'])));
}
//== Sql query count by pdq
function sql_query($query)
{
    global $query_stat;
    $query_start_time = microtime(true); // Start time
    $result = mysqli_query($GLOBALS["___mysqli_ston"], $query);
    $query_end_time = microtime(true); // End time
    $querytime = ($query_end_time - $query_start_time);
    $query_stat[] = array(
        'seconds' => number_format($query_end_time - $query_start_time, 6) ,
        'query' => $query
    );
    return $result;
}
//=== progress bar
function get_percent_completed_image($p)
{
    $img = 'progress-';
    switch (true) {
    case ($p >= 100):
        $img.= 5;
        break;
    case (($p >= 0) && ($p <= 10)):
        $img.= 0;
        break;
    case (($p >= 11) && ($p <= 40)):
        $img.= 1;
        break;
    case (($p >= 41) && ($p <= 60)):
        $img.= 2;
        break;
    case (($p >= 61) && ($p <= 80)):
        $img.= 3;
        break;
    case (($p >= 81) && ($p <= 99)):
        $img.= 4;
        break;
    }
    return '<img src="/pic/' . $img . '.gif" alt="percent" />';
}
function strip_tags_array($ar)
{
    if (is_array($ar)) {
        foreach ($ar as $k => $v) $ar[strip_tags($k) ] = strip_tags($v);
    } else $ar = strip_tags($ar);
    return $ar;
}
function referer()
{
    $http_referer = getenv("HTTP_REFERER");
    if ((strstr($http_referer, $_SERVER["HTTP_HOST"]) == false) && ($http_referer != "")) {
        $ip = $_SERVER['REMOTE_ADDR'];
        $http_agent = $_SERVER["HTTP_USER_AGENT"];
        $http_page = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['SCRIPT_NAME'];
        if (!empty($_SERVER["QUERY_STRING"])) $http_page.= "?" . $_SERVER['QUERY_STRING'];
        sql_query("INSERT INTO referrers (browser, ip, referer, page, date) VALUES (" . sqlesc($http_agent) . ", " . sqlesc($ip) . ", " . sqlesc($http_referer) . ", " . sqlesc($http_page) . ", " . sqlesc(TIME_NOW) . ")");
    }
}
if (file_exists("install/index.php")) {
    $HTMLOUT = '';
    $HTMLOUT.= "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\"
    \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">
    <html xmlns='http://www.w3.org/1999/xhtml'>
    <head>
    <title>Warning</title>
    </head>
    <body><div style='font-size:33px;color:white;background-color:red;text-align:center;'>Delete the install directory</div></body></html>";
    echo $HTMLOUT;
    exit();
}
function mysql_fetch_all($query, $default_value = Array())
{
    $r = @sql_query($query);
    $result = Array();
    if ($err = ((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)))return $err;
    if (@mysqli_num_rows($r))
        while ($row = mysqli_fetch_array($r))$result[] = $row;
    if (count($result) == 0)
        return $default_value;
    return $result;
}
function write_bonus_log($userid, $amount, $type){
  $added = TIME_NOW;
  $donation_type = $type;
  sql_query("INSERT INTO bonuslog (id, donation, type, added_at) VALUES(".sqlesc($userid).", ".sqlesc($amount).", ".sqlesc($donation_type).", $added)") or sqlerr(__FILE__, __LINE__);
}


//IMDB Function with memcache
function get_imdb($imdburl) {
    global $INSTALLER09, $mc1;
    $imdb_info['id'] = $imdb_info['title'] = $imdb_info['orig_title'] = $imdb_info['year'] = $imdb_info['rating'] = $imdb_info['votes'] = $imdb_info['gen'] = $imdb_info['runtime'] = $imdb_info['country'] = $imdb_info['lanuage'] = $imdb_info['director'] = $imdb_info['produce'] = $imdb_info['write'] = $imdb_info['compose'] = $imdb_info['plotoutline'] = $imdb_info['plot'] = $imdb_info['trailers'] = $imdb_info['comment'] = "";
    require_once(IMDB_DIR.'imdb.class.php');
    $rurl = trim($imdburl);
    $thenumbers = ltrim(strrchr($rurl,'tt'),'tt'); 
    $thenumbers = ($thenumbers[strlen($thenumbers)-1] == "/" ? substr($thenumbers,0,strlen($thenumbers)-1) : $thenumbers); 
    $thenumbers = preg_replace("[^A-Za-z0-9]", "", $thenumbers);
    if (($imdb_info = $mc1->get_value('imdb_info_'.$thenumbers)) === false) {
    $movie = new imdb ($thenumbers); 
    $movieid = $thenumbers;
    $movie->setid ($movieid);
    $cast = $movie->cast();
    $imdb_info['id']  = $movieid ;
    $imdb_info['title'] = $movie->title();
    $imdb_info['orig_title'] = $movie->orig_title();
    $imdb_info['year'] = $movie->year();
    $mvotes = $movie->votes();
    $mvrating = $movie->rating();
    if (!empty($mvrating)) {
    $imdb_info['rating'] = "$mvrating";
    $imdb_info['votes'] = "$mvotes";
    }else{
    $imdb_info['rating'] = "N/A";
    }
    $gen = $movie->genres();
    if (!empty($gen)) {
    //Changed count($gen) for 4 to limit to only two genres to help keep it tidy on site
    for ($i = 0; $i + 1 < count($gen); $i++) {
    $imdb_info['gen'] .= "$gen[$i], ";
    }
    $imdb_info['gen'] .="$gen[$i]";
    }
    else $imdb_info['gen'] = "None Found";
    $runtime = $movie->runtime();
    if (!empty($runtime)) {
    $imdb_info['runtime'] = "$runtime"; 
    }else{
    $imdb_info['runtime'] = "N/A";
    }

    $country = $movie->country ();
    if (!empty($country)) {
    for ($i = 0; $i + 1 < count ($country); $i++) {
    $imdb_info['country'] .="$country[$i], ";
    }
    $imdb_info['country'] .= "$country[$i]";
    }
    else
    $imdb_info['country'] = "None Available";
    $mvlang = $movie->language();
    if (!empty($mvlang)) {
    $imdb_info['lanuage'] = "$mvlang";
    }
    else
    $imdb_info['lanuage'] = "None Available";
    $director = $movie->director();
    if (!empty($director)) {
    for ($i = 0; $i < count ($director); $i++) {
    $imdb_info['director'].= "<a target=\"_blank\" href=\"http://www.imdb.com/name/nm" . "".$director[$i]["imdb"]."" ."\">" . "".$director[$i]["name"]."" . "</a>, ";
    }
    $imdb_info['director'].= "<a target=\"_blank\" href=\"http://www.imdb.com/name/nm" . "".$director[$i]["imdb"]."" ."\">" . "".   $director[$i]["name"]."" . "</a> ";
    }
    else
    $imdb_info['director'] = "None Available";
    $produce = $movie->producer();
    if (!empty($produce)) {
    for ($i = 0; $i < count ($produce); $i++) {
    $imdb_info['produce'].= "<a target=\"_blank\" href=\"http://www.imdb.com/name/nm" . "".$produce[$i]["imdb"]."" ." \">" . "".$produce[$i]["name"]."" . "</a>,";
    }       
    $imdb_info['produce'].= "<a target=\"_blank\" href=\"http://www.imdb.com/name/nm" . "".$produce[$i]["imdb"]."" ." \">" . "".$produce[$i]["name"]."" . "</a>";
    }
    else
    $imdb_info['produce'] = "None Available";
    $write = $movie->writing();
    if (!empty($write)) {
    for ($i = 0; $i < count ($write); $i++) {
    $imdb_info['write'].= "<a target=\"_blank\" href=\"http://www.imdb.com/name/nm" . "".$write[$i]["imdb"]."" ."\">" . "".$write[$i]["name"]."" . "</a>, ";
    }
    $imdb_info['write'].= "<a target=\"_blank\" href=\"http://www.imdb.com/name/nm" . "".$write[$i]["imdb"]."" ."\">" . "".$write[$i]["name"]."" . "</a> ";
    }
    $compose = $movie->composer();
    if (!empty($compose)) {
    for ($i = 0; $i < count($compose); $i++) {
    $imdb_info['compose'].= "<a target=\"_blank\" href=\"http://www.imdb.com/name/nm" . "".$compose[$i]["imdb"]."" ." \">" . "".$compose[$i]["name"]."" . "</a>, "; 
    }
    }else{
    $imdb_info['compose'].= "N/A"; 
    }
    $plotoutline = $movie->plotoutline();
    if (!empty($plotoutline)) { 
    $imdb_info['plotoutline']="".str_replace(array('<p>', '</p>','<a href="plotsummary">See full summary</a>'), array("",""), "$plotoutline")."";
    }
    else
    $imdb_info['plotoutline'].= "No Summary Available";
    $plot = $movie->plot ();
    if (!empty($plot)) {
    for ($i = 0; $i < count ($plot); $i++) {
    $imdb_info['plot'].=str_replace(array("&", "<p>", "</p>"), array("&amp;","",""), "$plot[$i]<br /><br />");
    }
    }
    else
    $imdb_info['plot'].= "No Plot Available";
    $trailers = $movie->trailers();
    if (!empty($trailers)) {
    for ($i = 0; $i < count ($trailers); $i++) {
    $imdb_info['trailers'].= "<a href='".$trailers[$i]."' title='Trailer' target='_blank'>IMDB Trailer</a><br />";
    }
    $imdb_info['trailers'].= "<a href='".$trailers[$i]."' title='Trailer' target='_blank'>IMDB Trailer</a>";
    }
    else
    $imdb_info['trailers'] = "None Available";
    $comment = $movie->comment();
    if (!empty($comment)) {
    $imdb_info['comment']= "".str_replace(array("<p>", "</p>", "<br>","<a></a>"), array("<br />", "<br />","<br />",""), "$comment")."";
    }
    else
    $imdb_info['comment'] = "No comments available";
    if (($photo_url = $movie->photo_localurl() ) != false) {
    $imdb_info['poster'] = $photo_url;
    } 
    $mc1->cache_value('imdb_info_'.$thenumbers, $imdb_info, 0);
    }
    return $imdb_info;
}
?>
