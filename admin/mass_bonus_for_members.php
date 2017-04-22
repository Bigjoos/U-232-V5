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
//=== mass bonus stuff for members coded for TB sites 2011 ~ snuggs
if (!defined('IN_INSTALLER09_ADMIN')) {
    header('HTTP/1.0 404 Not Found');
    $HTMLOUT = '';
    $HTMLOUT.= '
<html><head>
<title>404 Not Found</title>
</head><body>
<h1>Not Found</h1>
<p>The requested URL ' . htmlsafechars($_SERVER['SCRIPT_NAME'], strrpos($_SERVER['SCRIPT_NAME'], '/') + 1) . ' was not found on this server.</p>
<hr />
<address>' . $_SERVER['SERVER_SOFTWARE'] . ' Server at ' . $INSTALLER09['baseurl'] . ' Port 80</address>
</body></html>';
    echo $HTMLOUT;
    exit();
}
require_once INCL_DIR . 'user_functions.php';
require_once INCL_DIR . 'bbcode_functions.php';
require_once (CLASS_DIR . 'class_check.php');
$class = get_access(basename($_SERVER['REQUEST_URI']));
class_check($class);
//=== all the defaults
$lang = array_merge($lang, load_language('ad_bonus_for_members'));

$stdhead = array(
    /** include css **/
    'css' => array(
        'style2',
        'bbcode'
    )/*,
    /** include js **/
    /*'js' => array(
        'popup',
        'shout'
    )*/
);
$stdfoot = array(
    /** include js **/
    'js' => array(
        'shout',
        'browse',
        'check_selected'
    )
);
$h1_thingie = $HTMLOUT = '';
//=== check if action_2 is sent ($_POST) if so make sure it's what you want it to be
$action_2 = (isset($_POST['action_2']) ? htmlsafechars($_POST['action_2']) : 'no_action');
$good_stuff = array(
    'upload_credit',
    'karma',
    'freeslots',
    'invite',
    'pm'
);
$action = (($action_2 && in_array($action_2, $good_stuff, true)) ? $action_2 : '');
//=== see if the credit is for all classes or selected classes all_or_selected_classes
if (isset($_POST['all_or_selected_classes'])) {
    $free_for_classes = 1;
} else {
    $free_for_classes = 0;
    $free_for = (isset($_POST['free_for_classes']) ? htmlsafechars($_POST['free_for_classes']) : '');
}
//=== switch for the actions \\o\o/o//
switch ($action) {
case 'upload_credit':
    $GB = isset($_POST['GB']) ? 0 + $_POST['GB'] : 0;
    if ($GB < 1073741824 || $GB > 53687091200) //=== forgot to enter GB or wrong numbers
    stderr($lang['bonusmanager_up_err'], $lang['bonusmanager_up_err1']);
    $bonus_added = ($GB / 1073741824);
    //=== if for all classes
    if ($free_for_classes === 1) {
        $res_GB = sql_query('SELECT id, uploaded, modcomment FROM users WHERE enabled = \'yes\' AND suspended = \'no\'') or sqlerr(__FILE__, __LINE__);
        $pm_buffer = $users_buffer = array();
        if (mysqli_num_rows($res_GB) > 0) {
            $subject = sqlesc($lang['bonusmanager_up_added']);
            $msg = sqlesc($lang['bonusmanager_up_addedmsg'] . $bonus_added . $lang['bonusmanager_up_addedmsg1'] . $INSTALLER09['site_name'] . "{$lang['bonusmanager_up_addedmsg2']}{$lang['bonusmanager_up_addedmsg22']}" . $GB . " " . $GB_new."");
		while ($arr_GB = mysqli_fetch_assoc($res_GB)) {
                $GB_new = ($arr_GB['uploaded'] + $GB);
                $modcomment = $arr_GB['modcomment'];
                $modcomment = get_date(TIME_NOW, 'DATE', 1) . " - " . $bonus_added . $lang['bonusmanager_up_modcomment'] . $modcomment;
                $modcom = sqlesc($modcomment);
                $pm_buffer[] = '(0, ' . $arr_GB['id'] . ', ' . TIME_NOW . ', ' . $msg . ', ' . $subject . ')';
                $users_buffer[] = '(' . $arr_GB['id'] . ', ' . $GB_new . ', ' . $modcom . ')';
                $mc1->begin_transaction('user_stats_' . $arr_GB['id']);
                $mc1->update_row(false, array(
                    'uploaded' => $GB_new,
                    'modcomment' => $modcomment
                ));
                $mc1->commit_transaction($INSTALLER09['expires']['user_stats']);
                $mc1->begin_transaction('userstats_' . $arr_GB['id']);
                $mc1->update_row(false, array(
                    'uploaded' => $GB_new
                ));
                $mc1->commit_transaction($INSTALLER09['expires']['u_stats']);
                $mc1->delete_value('inbox_new_' . $arr_GB['id']);
                $mc1->delete_value('inbox_new_sb_' . $arr_GB['id']);
            }
            $count = count($users_buffer);
            if ($count > 0) {
                sql_query("INSERT INTO messages (sender,receiver,added,msg,subject) VALUES " . implode(', ', $pm_buffer)) or sqlerr(__FILE__, __LINE__);
                sql_query("INSERT INTO users (id, uploaded, modcomment) VALUES " . implode(', ', $users_buffer) . " ON DUPLICATE key UPDATE uploaded=values(uploaded),modcomment=values(modcomment)") or sqlerr(__FILE__, __LINE__);
                write_log($lang['bonusmanager_up_writelog'] . $count . $lang['bonusmanager_up_writelog1'] . $CURUSER['username']);
            }
            unset($users_buffer, $pm_buffer, $count);
        }
        header('Location: staffpanel.php?tool=mass_bonus_for_members&action=mass_bonus_for_members&GB=1');
        die();
    } elseif ($free_for_classes === 0) {
        foreach ($free_for as $class) {
            if (ctype_digit($class)) {
                $res_GB = sql_query('SELECT id, uploaded, modcomment FROM users WHERE enabled = \'yes\' AND suspended = \'no\' AND class = ' . $class);
                $pm_buffer = $users_buffer = array();
                if (mysqli_num_rows($res_GB) > 0) {
                    $subject = sqlesc($lang['bonusmanager_up_added']);
                    $msg = sqlesc($lang['bonusmanager_up_addedmsg'] . $bonus_added . $lang['bonusmanager_up_addedmsg3'] . $INSTALLER09['site_name'] . $lang['bonusmanager_up_addedmsg2']);
                    while ($arr_GB = mysqli_fetch_assoc($res_GB)) {
                        $GB_new = ($arr_GB['uploaded'] + $GB);
                        $modcomment = $arr_GB['modcomment'];
                        $modcomment = get_date(TIME_NOW, 'DATE', 1) . " - " . $bonus_added . $lang['bonusmanager_up_modcomment'] . $modcomment;
                        $modcom = sqlesc($modcomment);
                        $pm_buffer[] = '(0, ' . $arr_GB['id'] . ', ' . TIME_NOW . ', ' . $msg . ', ' . $subject . ')';
                        $users_buffer[] = '(' . $arr_GB['id'] . ', ' . $GB_new . ', ' . $modcom . ')';
                        $mc1->begin_transaction('user_stats_' . $arr_GB['id']);
                        $mc1->update_row(false, array(
                            'uploaded' => $GB_new,
                            'modcomment' => $modcomment
                        ));
                        $mc1->commit_transaction($INSTALLER09['expires']['user_stats']);
                        $mc1->begin_transaction('userstats_' . $arr_GB['id']);
                        $mc1->update_row(false, array(
                            'uploaded' => $GB_new
                        ));
                        $mc1->commit_transaction($INSTALLER09['expires']['u_stats']);
                        $mc1->delete_value('inbox_new_' . $arr_GB['id']);
                        $mc1->delete_value('inbox_new_sb_' . $arr_GB['id']);
                    }
                    $count = count($users_buffer);
                    if ($count > 0) {
                        sql_query("INSERT INTO messages (sender,receiver,added,msg,subject) VALUES " . implode(', ', $pm_buffer)) or sqlerr(__FILE__, __LINE__);
                        sql_query("INSERT INTO users (id, uploaded, modcomment) VALUES " . implode(', ', $users_buffer) . " ON DUPLICATE key UPDATE uploaded=values(uploaded),modcomment=values(modcomment)") or sqlerr(__FILE__, __LINE__);
                        write_log($lang['bonusmanager_up_writelog'] . $count . $lang['bonusmanager_up_writelog2'] . $CURUSER['username']);
                    }
                    unset($users_buffer, $pm_buffer, $count);
                }
            }
        }
        header('Location: staffpanel.php?tool=mass_bonus_for_members&action=mass_bonus_for_members&GB=2');
        die();
    }
    break;

case 'karma':
    $karma = isset($_POST['karma']) ? 0 + $_POST['karma'] : 0;
    if ($karma < 100 || $karma > 5000) //=== forgot to enter karma or wrong numbers
    stderr($lang['bonusmanager_karma_err'],$lang['bonusmanager_karma_err1']);
    //=== if for all classes
    if ($free_for_classes === 1) {
        $res_karma = sql_query('SELECT id, seedbonus, modcomment FROM users WHERE enabled = \'yes\' AND suspended = \'no\'') or sqlerr(__FILE__, __LINE__);
        $pm_buffer = $users_buffer = array();
        if (mysqli_num_rows($res_karma) > 0) {
            $subject = sqlesc($lang['bonusmanager_karma_added']);
            $msg = sqlesc($lang['bonusmanager_karma_addedmsg'] . $karma . $lang['bonusmanager_karma_addedmsg1'] . $INSTALLER09['site_name'] . $lang['bonusmanager_karma_addedmsg2']);
            while ($arr_karma = mysqli_fetch_assoc($res_karma)) {
                $karma_new = ($arr_karma['seedbonus'] + $karma);
                $modcomment = $arr_karma['modcomment'];
                $modcomment = get_date(TIME_NOW, 'DATE', 1) . " - " . $karma . $lang['bonusmanager_karma_modcomment'] . $modcomment;
                $modcom = sqlesc($modcomment);
                $pm_buffer[] = '(0, ' . $arr_karma['id'] . ', ' . TIME_NOW . ', ' . $msg . ', ' . $subject . ')';
                $users_buffer[] = '(' . $arr_karma['id'] . ', ' . $karma_new . ', ' . $modcom . ')';
                $mc1->begin_transaction('user_stats_' . $arr_karma['id']);
                $mc1->update_row(false, array(
                    'seedbonus' => $karma_new,
                    'modcomment' => $modcomment
                ));
                $mc1->commit_transaction($INSTALLER09['expires']['user_stats']);
                $mc1->begin_transaction('userstats_' . $arr_karma['id']);
                $mc1->update_row(false, array(
                    'seedbonus' => $karma_new
                ));
                $mc1->commit_transaction($INSTALLER09['expires']['u_stats']);
                $mc1->delete_value('inbox_new_' . $arr_karma['id']);
                $mc1->delete_value('inbox_new_sb_' . $arr_karma['id']);
            }
            $count = count($users_buffer);
            if ($count > 0) {
                sql_query("INSERT INTO messages (sender,receiver,added,msg,subject) VALUES " . implode(', ', $pm_buffer)) or sqlerr(__FILE__, __LINE__);
                sql_query("INSERT INTO users (id, seedbonus, modcomment) VALUES " . implode(', ', $users_buffer) . " ON DUPLICATE key UPDATE seedbonus=values(seedbonus),modcomment=values(modcomment)") or sqlerr(__FILE__, __LINE__);
                write_log($lang['bonusmanager_karma_writelog'] . $count . $lang['bonusmanager_karma_writelog1'] . $CURUSER['username']);
            }
            unset($users_buffer, $pm_buffer, $count);
        }
        header('Location: staffpanel.php?tool=mass_bonus_for_members&action=mass_bonus_for_members&karma=1');
        die();
    } elseif ($free_for_classes === 0) {
        foreach ($free_for as $class) {
            if (ctype_digit($class)) {
                $res_karma = sql_query('SELECT id, seedbonus, modcomment FROM users WHERE enabled = \'yes\' AND suspended = \'no\' AND class = ' . $class);
                $pm_buffer = $users_buffer = array();
                if (mysqli_num_rows($res_karma) > 0) {
                    $subject = sqlesc($lang['bonusmanager_karma_added']);
                    $msg = sqlesc($lang['bonusmanager_karma_addedmsg'] . $karma . $lang['bonusmanager_karma_addedmsg3'] . $INSTALLER09['site_name'] . $lang['bonusmanager_karma_addedmsg2']);
                    while ($arr_karma = mysqli_fetch_assoc($res_karma)) {
                        $karma_new = ($arr_karma['seedbonus'] + $karma);
                        $modcomment = $arr_karma['modcomment'];
                        $modcomment = get_date(TIME_NOW, 'DATE', 1) . " - " . $karma . $lang['bonusmanager_karma_modcomment'] . $modcomment;
                        $modcom = sqlesc($modcomment);
                        $pm_buffer[] = '(0, ' . $arr_karma['id'] . ', ' . TIME_NOW . ', ' . $msg . ', ' . $subject . ')';
                        $users_buffer[] = '(' . $arr_karma['id'] . ', ' . $karma_new . ', ' . $modcom . ')';
                        $mc1->begin_transaction('user_stats_' . $arr_karma['id']);
                        $mc1->update_row(false, array(
                            'seedbonus' => $karma_new,
                            'modcomment' => $modcomment
                        ));
                        $mc1->commit_transaction($INSTALLER09['expires']['user_stats']);
                        $mc1->begin_transaction('userstats_' . $arr_karma['id']);
                        $mc1->update_row(false, array(
                            'seedbonus' => $karma_new
                        ));
                        $mc1->commit_transaction($INSTALLER09['expires']['u_stats']);
                        $mc1->delete_value('inbox_new_' . $arr_karma['id']);
                        $mc1->delete_value('inbox_new_sb_' . $arr_karma['id']);
                    }
                    $count = count($users_buffer);
                    if ($count > 0) {
                        sql_query("INSERT INTO messages (sender,receiver,added,msg,subject) VALUES " . implode(', ', $pm_buffer)) or sqlerr(__FILE__, __LINE__);
                        sql_query("INSERT INTO users (id, seedbonus, modcomment) VALUES " . implode(', ', $users_buffer) . " ON DUPLICATE key UPDATE seedbonus=values(seedbonus),modcomment=values(modcomment)") or sqlerr(__FILE__, __LINE__);
                        write_log($lang['bonusmanager_karma_writelog'] . $count . $lang['bonusmanager_karma_writelog2'] . $CURUSER['username']);
                    }
                    unset($users_buffer, $pm_buffer, $count);
                }
            }
        }
        header('Location: staffpanel.php?tool=mass_bonus_for_members&action=mass_bonus_for_members&karma=2');
        die();
    }
    break;

case 'freeslots':
    $freeslots = isset($_POST['freeslots']) ? 0 + $_POST['freeslots'] : 0;
    if ($freeslots < 1 || $freeslots > 50) //=== forgot to enter freeslots or wrong numbers
    stderr($lang['bonusmanager_freeslots_err'], $lang['bonusmanager_freeslots_err1']);
    //=== if for all classes
    if ($free_for_classes === 1) {
        $res_freeslots = sql_query('SELECT id, freeslots, modcomment FROM users WHERE enabled = \'yes\' AND suspended = \'no\'') or sqlerr(__FILE__, __LINE__);
        $pm_buffer = $users_buffer = array();
        if (mysqli_num_rows($res_freeslots) > 0) {
            $subject = sqlesc($lang['bonusmanager_freeslots_added']);
            $msg = sqlesc($lang['bonusmanager_freeslots_addedmsg'] . $freeslots . $lang['bonusmanager_freeslots_addedmsg1'] . $INSTALLER09['site_name'] . $lang['bonusmanager_freeslots_addedmsg2']);
            while ($arr_freeslots = mysqli_fetch_assoc($res_freeslots)) {
                $freeslots_new = ($arr_freeslots['freeslots'] + $freeslots);
                $modcomment = $arr_freeslots['modcomment'];
                $modcomment = get_date(TIME_NOW, 'DATE', 1) . " - " . $freeslots . $lang['bonusmanager_freeslots_modcomment'] . $modcomment;
                $modcom = sqlesc($modcomment);
                $pm_buffer[] = '(0, ' . $arr_freeslots['id'] . ', ' . TIME_NOW . ', ' . $msg . ', ' . $subject . ')';
                $users_buffer[] = '(' . $arr_freeslots['id'] . ', ' . $freeslots_new . ', ' . $modcom . ')';
                $mc1->begin_transaction('MyUser_' . $arr_freeslots['id']);
                $mc1->update_row(false, array(
                    'freeslots' => $freeslots_new
                ));
                $mc1->commit_transaction($INSTALLER09['expires']['curuser']);
                $mc1->begin_transaction('user' . $arr_freeslots['id']);
                $mc1->update_row(false, array(
                    'freeslots' => $freeslots_new
                ));
                $mc1->commit_transaction($INSTALLER09['expires']['user_cache']);
                $mc1->begin_transaction('user_stats_' . $arr_freeslots['id']);
                $mc1->update_row(false, array(
                    'modcomment' => $modcomment
                ));
                $mc1->commit_transaction($INSTALLER09['expires']['user_stats']);
                $mc1->delete_value('inbox_new_' . $arr_freeslots['id']);
                $mc1->delete_value('inbox_new_sb_' . $arr_freeslots['id']);
            }
            $count = count($users_buffer);
            if ($count > 0) {
                sql_query("INSERT INTO messages (sender,receiver,added,msg,subject) VALUES " . implode(', ', $pm_buffer)) or sqlerr(__FILE__, __LINE__);
                sql_query("INSERT INTO users (id, freeslots, modcomment) VALUES " . implode(', ', $users_buffer) . " ON DUPLICATE key UPDATE freeslots=values(freeslots),modcomment=values(modcomment)") or sqlerr(__FILE__, __LINE__);
                write_log($lang['bonusmanager_freeslots_writelog'] . $count . $lang['bonusmanager_freeslots_writelog1'] . $CURUSER['username']);
            }
            unset($users_buffer, $pm_buffer, $count);
        }
        header('Location: staffpanel.php?tool=mass_bonus_for_members&action=mass_bonus_for_members&freeslots=1');
        die();
    } elseif ($free_for_classes === 0) {
        foreach ($free_for as $class) {
            if (ctype_digit($class)) {
                $res_freeslots = sql_query('SELECT id, freeslots, modcomment FROM users WHERE enabled = \'yes\' AND suspended = \'no\' AND class = ' . $class);
                $pm_buffer = $users_buffer = array();
                if (mysqli_num_rows($res_freeslots) > 0) {
                    $subject = sqlesc($lang['bonusmanager_freeslots_added']);
                    $msg = sqlesc($lang['bonusmanager_freeslots_addedmsg'] . $freeslots . $lang['bonusmanager_freeslots_addedmsg3'] . $INSTALLER09['site_name'] . $lang['bonusmanager_freeslots_addedmsg2']);
                    while ($arr_freeslots = mysqli_fetch_assoc($res_freeslots)) {
                        $freeslots_new = ($arr_freeslots['freeslots'] + $freeslots);
                        $modcomment = $arr_freeslots['modcomment'];
                        $modcomment = get_date(TIME_NOW, 'DATE', 1) . " - " . $freeslots . $lang['bonusmanager_freeslots_modcomment'] . $modcomment;
                        $modcom = sqlesc($modcomment);
                        $pm_buffer[] = '(0, ' . $arr_freeslots['id'] . ', ' . TIME_NOW . ', ' . $msg . ', ' . $subject . ')';
                        $users_buffer[] = '(' . $arr_freeslots['id'] . ', ' . $freeslots_new . ', ' . $modcom . ')';
                        $mc1->begin_transaction('MyUser_' . $arr_freeslots['id']);
                        $mc1->update_row(false, array(
                            'freeslots' => $freeslots_new
                        ));
                        $mc1->commit_transaction($INSTALLER09['expires']['curuser']);
                        $mc1->begin_transaction('user' . $arr_freeslots['id']);
                        $mc1->update_row(false, array(
                            'freeslots' => $freeslots_new
                        ));
                        $mc1->commit_transaction($INSTALLER09['expires']['user_cache']);
                        $mc1->begin_transaction('user_stats_' . $arr_freeslots['id']);
                        $mc1->update_row(false, array(
                            'modcomment' => $modcomment
                        ));
                        $mc1->commit_transaction($INSTALLER09['expires']['user_stats']);
                        $mc1->delete_value('inbox_new_' . $arr_freeslots['id']);
                        $mc1->delete_value('inbox_new_sb_' . $arr_freeslots['id']);
                    }
                    $count = count($users_buffer);
                    if ($count > 0) {
                        sql_query("INSERT INTO messages (sender,receiver,added,msg,subject) VALUES " . implode(', ', $pm_buffer)) or sqlerr(__FILE__, __LINE__);
                        sql_query("INSERT INTO users (id, freeslots, modcomment) VALUES " . implode(', ', $users_buffer) . " ON DUPLICATE key UPDATE freeslots=values(freeslots),modcomment=values(modcomment)") or sqlerr(__FILE__, __LINE__);
                        write_log($lang['bonusmanager_freeslots_writelog'] . $count . $lang['bonusmanager_freeslots_writelog2'] . $CURUSER['username']);
                    }
                    unset($users_buffer, $pm_buffer, $count);
                }
            }
        }
        header('Location: staffpanel.php?tool=mass_bonus_for_members&action=mass_bonus_for_members&freeslots=2');
        die();
    }
    break;

case 'invite':
    $invites = isset($_POST['invites']) ? 0 + $_POST['invites'] : 0;
    if ($invites < 1 || $invites > 50) //=== forgot to enter invites or wrong numbers
    stderr($lang['bonusmanager_invite_err'], $lang['bonusmanager_invite_err1']);
    //=== if for all classes
    if ($free_for_classes === 1) {
        $res_invites = sql_query('SELECT id, invites, modcomment FROM users WHERE enabled = \'yes\' AND suspended = \'no\' AND invite_on = \'yes\'');
        $pm_buffer = $users_buffer = array();
        if (mysqli_num_rows($res_invites) > 0) {
            $subject = sqlesc($lang['bonusmanager_invite_added']);
            $msg = sqlesc($lang['bonusmanager_invite_addedmsg'] . $invites . $lang['bonusmanager_invite_addedmsg1'] . $INSTALLER09['site_name'] . $lang['bonusmanager_invite_addedmsg2']);
            while ($arr_invites = mysqli_fetch_assoc($res_invites)) {
                $invites_new = ($arr_invites['invites'] + $invites);
                $modcomment = $arr_invites['modcomment'];
                $modcomment = get_date(TIME_NOW, 'DATE', 1) . " - " . $invites . $lang['bonusmanager_invite_modcomment'] . $modcomment;
                $modcom = sqlesc($modcomment);
                $pm_buffer[] = '(0, ' . $arr_invites['id'] . ', ' . TIME_NOW . ', ' . $msg . ', ' . $subject . ')';
                $users_buffer[] = '(' . $arr_invites['id'] . ', ' . $invites_new . ', ' . $modcom . ')';
                $mc1->begin_transaction('MyUser_' . $arr_invites['id']);
                $mc1->update_row(false, array(
                    'invites' => $invites_new
                ));
                $mc1->commit_transaction($INSTALLER09['expires']['curuser']);
                $mc1->begin_transaction('user' . $arr_invites['id']);
                $mc1->update_row(false, array(
                    'invites' => $invites_new
                ));
                $mc1->commit_transaction($INSTALLER09['expires']['user_cache']);
                $mc1->begin_transaction('user_stats_' . $arr_invites['id']);
                $mc1->update_row(false, array(
                    'modcomment' => $modcomment
                ));
                $mc1->commit_transaction($INSTALLER09['expires']['user_stats']);
                $mc1->delete_value('inbox_new_' . $arr_invites['id']);
                $mc1->delete_value('inbox_new_sb_' . $arr_invites['id']);
            }
            $count = count($users_buffer);
            if ($count > 0) {
                sql_query("INSERT INTO messages (sender,receiver,added,msg,subject) VALUES " . implode(', ', $pm_buffer)) or sqlerr(__FILE__, __LINE__);
                sql_query("INSERT INTO users (id, invites, modcomment) VALUES " . implode(', ', $users_buffer) . " ON DUPLICATE key UPDATE invites=values(invites),modcomment=values(modcomment)") or sqlerr(__FILE__, __LINE__);
                write_log($lang['bonusmanager_invite_writelog'] . $count . $lang['bonusmanager_invite_writelog1'] . $CURUSER['username']);
            }
            unset($users_buffer, $pm_buffer, $count);
        }
        header('Location: staffpanel.php?tool=mass_bonus_for_members&action=mass_bonus_for_members&invites=1');
        die();
    } elseif ($free_for_classes === 0) {
        foreach ($free_for as $class) {
            if (ctype_digit($class)) {
                $res_invites = sql_query('SELECT id, invites, modcomment FROM users WHERE enabled = \'yes\' AND suspended = \'no\' AND invite_on = \'yes\' AND class = ' . $class);
                $pm_buffer = $users_buffer = array();
                if (mysqli_num_rows($res_invites) > 0) {
                    $subject = sqlesc($lang['bonusmanager_invite_added']);
                    $msg = sqlesc($lang['bonusmanager_invite_addedmsg'] . $invites . $lang['bonusmanager_invite_addedmsg3'] . $INSTALLER09['site_name'] . $lang['bonusmanager_invite_addedmsg2']);
                    while ($arr_invites = mysqli_fetch_assoc($res_invites)) {
                        $invites_new = ($arr_invites['invites'] + $invites);
                        $modcomment = $arr_invites['modcomment'];
                        $modcomment = get_date(TIME_NOW, 'DATE', 1) . " - " . $invites . $lang['bonusmanager_invite_modcomment'] . $modcomment;
                        $modcom = sqlesc($modcomment);
                        $pm_buffer[] = '(0, ' . $arr_invites['id'] . ', ' . TIME_NOW . ', ' . $msg . ', ' . $subject . ')';
                        $users_buffer[] = '(' . $arr_invites['id'] . ', ' . $invites_new . ', ' . $modcom . ')';
                        $mc1->begin_transaction('MyUser_' . $arr_invites['id']);
                        $mc1->update_row(false, array(
                            'invites' => $invites_new
                        ));
                        $mc1->commit_transaction($INSTALLER09['expires']['curuser']);
                        $mc1->begin_transaction('user' . $arr_invites['id']);
                        $mc1->update_row(false, array(
                            'invites' => $invites_new
                        ));
                        $mc1->commit_transaction($INSTALLER09['expires']['user_cache']);
                        $mc1->begin_transaction('user_stats_' . $arr_invites['id']);
                        $mc1->update_row(false, array(
                            'modcomment' => $modcomment
                        ));
                        $mc1->commit_transaction($INSTALLER09['expires']['user_stats']);
                        $mc1->delete_value('inbox_new_' . $arr_invites['id']);
                        $mc1->delete_value('inbox_new_sb_' . $arr_invites['id']);
                    }
                    $count = count($users_buffer);
                    if ($count > 0) {
                        sql_query("INSERT INTO messages (sender,receiver,added,msg,subject) VALUES " . implode(', ', $pm_buffer)) or sqlerr(__FILE__, __LINE__);
                        sql_query("INSERT INTO users (id, invites, modcomment) VALUES " . implode(', ', $users_buffer) . " ON DUPLICATE key UPDATE invites=values(invites),modcomment=values(modcomment)") or sqlerr(__FILE__, __LINE__);
                        write_log($lang['bonusmanager_invite_writelog'] . $count . $lang['bonusmanager_invite_writelog2'] . $CURUSER['username']);
                    }
                    unset($users_buffer, $pm_buffer, $count);
                }
            }
        }
        header('Location: staffpanel.php?tool=mass_bonus_for_members&action=mass_bonus_for_members&invites=2');
        die();
    }
case 'pm':
    if (!isset($_POST['subject'])) stderr($lang['bonusmanager_pm_err'], $lang['bonusmanager_pm_err1']);
    if (!isset($_POST['body'])) stderr($lang['bonusmanager_pm_err'], $lang['bonusmanager_pm_err2']);
    //=== if for all classes
    if ($free_for_classes === 1) {
        $res_pms = sql_query('SELECT id FROM users WHERE enabled = \'yes\' AND suspended = \'no\'');
        $pm_buffer = array();
        if (mysqli_num_rows($res_pms) > 0) {
            $subject = sqlesc(htmlsafechars($_POST['subject']));
            $body = sqlesc(htmlsafechars($_POST['body']));
            while ($arr_pms = mysqli_fetch_assoc($res_pms)) {
                $pm_buffer[] = '(0, ' . $arr_pms['id'] . ', ' . TIME_NOW . ', ' . $body . ', ' . $subject . ')';
                $mc1->delete_value('inbox_new_' . $arr_pms['id']);
                $mc1->delete_value('inbox_new_sb_' . $arr_pms['id']);
            }
            $count = count($pm_buffer);
            if ($count > 0) {
                sql_query("INSERT INTO messages (sender,receiver,added,msg,subject) VALUES " . implode(', ', $pm_buffer)) or sqlerr(__FILE__, __LINE__);
                write_log($lang['bonusmanager_pm_writelog'] . $count . $lang['bonusmanager_pm_writelog1'] . $CURUSER['username']);
            }
            unset($pm_buffer, $count);
        }
        header('Location: staffpanel.php?tool=mass_bonus_for_members&action=mass_bonus_for_members&pm=1');
        die();
    } elseif ($free_for_classes === 0) {
        foreach ($free_for as $class) {
            if (ctype_digit($class)) {
                $res_pms = sql_query('SELECT id FROM users WHERE enabled = \'yes\' AND suspended = \'no\' AND class = ' . $class);
                $pm_buffer = array();
                if (mysqli_num_rows($res_pms) > 0) {
                    $subject = sqlesc(htmlsafechars($_POST['subject']));
                    $body = sqlesc(htmlsafechars($_POST['body']));
                    while ($arr_pms = mysqli_fetch_assoc($res_pms)) {
                        $pm_buffer[] = '(0, ' . $arr_pms['id'] . ', ' . TIME_NOW . ', ' . $body . ', ' . $subject . ')';
                        $mc1->delete_value('inbox_new_' . $arr_pms['id']);
                        $mc1->delete_value('inbox_new_sb_' . $arr_pms['id']);
                    }
                    $count = count($pm_buffer);
                    if ($count > 0) {
                        sql_query("INSERT INTO messages (sender,receiver,added,msg,subject) VALUES " . implode(', ', $pm_buffer)) or sqlerr(__FILE__, __LINE__);
                        write_log($lang['bonusmanager_pm_writelog'] . $count . $lang['bonusmanager_pm_writelog2'] . $CURUSER['username']);
                    }
                    unset($pm_buffer, $count);
                }
            }
            header('Location: staffpanel.php?tool=mass_bonus_for_members&action=mass_bonus_for_members&pm=2');
            die();
        }
    }
    break;
} //=== end switch
//=== make the class based selection thingie bit here :D
$count = 1;
$all_classes_check_boxes = '<table class="table table-bordered"><tr>';
for ($i = UC_MIN; $i <= UC_MAX; ++$i) {
    $all_classes_check_boxes.= '<td class="one">
		<input type="checkbox" name="free_for_classes[]" value="' . $i . '" checked="checked" /> <span style="font-weight: bold;color:#' . get_user_class_color($i) . ';">' . get_user_class_name($i) . '</span></td>';
    if ($count == 6) {
        $all_classes_check_boxes.= '</tr>' . ($i < UC_MAX ? '<tr>' : '');
        $count = 0;
    }
    $count++;
}
$all_classes_check_boxes.= ($count == 0 ? '</table>' : '<tr><td colspan="' . (7 - $count) . '" class="one"></td></tr></table>') . '';
$bonus_GB = '<select class="form-control" name="GB">
        <option class="head" value="">'.$lang['bonusmanager_up_add'].'</option>
        <option class="body" value="1073741824">'.$lang['bonusmanager_up_1gb' ].'</option>
        <option class="body" value="2147483648">'.$lang['bonusmanager_up_2gb' ].'</option>
        <option class="body" value="3221225472">'.$lang['bonusmanager_up_3gb' ].'</option>
        <option class="body" value="4294967296">'.$lang['bonusmanager_up_4gb' ].'</option>
        <option class="body" value="5368709120">'.$lang['bonusmanager_up_5gb' ].'</option>
        <option class="body" value="6442450944">'.$lang['bonusmanager_up_6gb' ].'</option>
        <option class="body" value="7516192768">'.$lang['bonusmanager_up_7gb' ].'</option>
        <option class="body" value="8589934592">'.$lang['bonusmanager_up_8gb' ].'</option>
        <option class="body" value="9663676416">'.$lang['bonusmanager_up_9gb' ].'</option>
        <option class="body" value="10737418240">'.$lang['bonusmanager_up_10gb' ].'</option>
        <option class="body" value="16106127360">'.$lang['bonusmanager_up_15gb' ].'</option>
        <option class="body" value="21474836480">'.$lang['bonusmanager_up_20gb' ].'</option>
        <option class="body" value="26843545600">'.$lang['bonusmanager_up_25gb' ].'</option>
        <option class="body" value="32212254720">'.$lang['bonusmanager_up_30gb' ].'</option>
        <option class="body" value="53687091200">'.$lang['bonusmanager_up_50gb' ].'</option>
        </select>'.$lang['bonusmanager_up_amount' ].' ';
$karma_drop_down = '
        <select name="karma" class="form-control">
        <option class="head" value="">' . $lang['bonusmanager_karma_add'] . '</option>';
$i = 100;
while ($i <= 5000) {
    $karma_drop_down.= '<option class="body" value="' . $i . '.0">' . $i . ' ' . $lang['bonusmanager_karma_points'] . '</option>';
    $i = ($i < 1000 ? $i = $i + 100 : $i = $i + 500);
}
$karma_drop_down.= '</select> ' . $lang['bonusmanager_karma_amount'] . ' ';
$free_leech_slot_drop_down = '
        <select class="form-control" name="freeslots">
        <option class="head" value="">' . $lang['bonusmanager_freeslots_add'] . '</option>';
$i = 1;
while ($i <= 50) {
    $free_leech_slot_drop_down.= '<option class="body" value="' . $i . '.0">' . $i . '' . ($i !== 1 ? $lang['bonusmanager_freeslots_plural'] : $lang['bonusmanager_freeslots_singular']) . '</option>';
    $i = ($i < 10 ? $i = $i + 1 : $i = $i + 5);
}
$free_leech_slot_drop_down.= '</select>' . $lang['bonusmanager_freeslots_amount'] . ' ';
$invites_drop_down = '
        <select class="form-control" name="invites">
        <option class="head" value="">' . $lang['bonusmanager_invite_add'] . '</option>';
$i = 1;
while ($i <= 50) {
    $invites_drop_down.= '<option class="body" value="' . $i . '.0">' . $i . '' . ($i !== 1 ? $lang['bonusmanager_invite_plural'] : $lang['bonusmanager_invite_singular']) . '</option>';
    $i = ($i < 10 ? $i = $i + 1 : $i = $i + 5);
}
$invites_drop_down.= '</select>' . $lang['bonusmanager_invite_amount'] . '';
//== pms \0/ (*)(*)
$subject = isset($_POST['subject']) ? htmlsafechars($_POST['subject']) : $lang['bonusmanager_pm_masspm'];
$body = isset($_POST['body']) ? htmlsafechars($_POST['body']) : $lang['bonusmanager_pm_texthere'];
$pm_drop_down = '<form name="pm" method="post" action="mass_bonus_for_members.php">
                 <input type="hidden" name="pm" value="pm" />
                 <table class="table table-bordered">
                 <tr>
                 <td align="left" colspan="2" class="colhead">' . $lang['bonusmanager_pm_send'] . '</td>
                 </tr>
                 <tr>
                 <td align="right" class="one"><span style="font-weight: bold;">' . $lang['bonusmanager_pm_subject'] . '</span></td>
                 <td align="left" class="one"><input name="subject" type="text" class="text_default" value="' . $subject . '" /></td>
                 </tr>
                 <tr>
                 <td align="right" class="one"><span style="font-weight: bold;">' . $lang['bonusmanager_pm_body'] . '</span></td>
                 <td align="left" class="one">'.textbbcode('pm', 'body', $body).'</td>
                 </tr>
                 </table></form>';
$drop_down = '
        <select class="form-control" name="bonus_options_1" id="bonus_options_1">
        <option value="">' . $lang['bonusmanager_select'] . '</option>
        <option value="upload_credit">' . $lang['bonusmanager_select_upload'] . '</option>
        <option value="karma">' . $lang['bonusmanager_select_karma'] . '</option>
        <option value="freeslots">' . $lang['bonusmanager_select_freeslots'] . '</option>
        <option value="invite">' . $lang['bonusmanager_select_invite'] . '</option>
        <option value="pm">' . $lang['bonusmanager_select_pm'] . '</option>
        <option value="">' . $lang['bonusmanager_reset'] . '</option>
        </select>';
//=== h1 stuffzzzz
$h1_thingie.= (isset($_GET['GB']) ? ($_GET['GB'] === 1 ? '<h2>' . $lang['bonusmanager_h1_upload'] . '</h2>' : '<h2>' . $lang['bonusmanager_h1_upload'] . '</h2>') : '');
$h1_thingie.= (isset($_GET['karma']) ? ($_GET['karma'] === 1 ? '<h2>' . $lang['bonusmanager_h1_karma'] . '</h2>' : '<h2>' . $lang['bonusmanager_h1_karma1'] . '</h2>') : '');
$h1_thingie.= (isset($_GET['freeslots']) ? ($_GET['freeslots'] === 1 ? '<h2>' . $lang['bonusmanager_h1_freeslot'] . '<h2>' : '<h2>' . $lang['bonusmanager_h1_freeslot1'] . '</h2>') : '');
$h1_thingie.= (isset($_GET['invites']) ? ($_GET['invites'] === 1 ? '<h2>' . $lang['bonusmanager_h1_invite'] . '</h2>' : '<h2>' . $lang['bonusmanager_h1_invite1'] . '</h2>') : '');
$h1_thingie.= (isset($_GET['pm']) ? ($_GET['pm'] === 1 ? '<h2>' . $lang['bonusmanager_h1_pm'] . '</h2>' : '<h2>' . $lang['bonusmanager_h1_pm1'] . '</h2>') : '');
$HTMLOUT.= '<h1>' . $INSTALLER09['site_name'] . ' ' . $lang['bonusmanager_mass_bonus'] . '</h1>' . $h1_thingie;
$HTMLOUT.= '<form name="inputform" method="post" action="staffpanel.php?tool=mass_bonus_for_members&amp;action=mass_bonus_for_members" enctype="multipart/form-data">
        <input type="hidden" id="action_2" name="action_2" value="" />
    <table class="table table-bordered">
    <tr>
        <td align="center" class="colhead" colspan="2">' . $lang['bonusmanager_mass_bonus_selected'] . '</td>
    </tr>
    <tr>
        <td align="right" class="one" width="160px" valign="top"><span style="font-weight: bold;">' . $lang['bonusmanager_bonus_type'] . '</span></td>
        <td align="left" class="one">' . $drop_down . '
        <div id="div_upload_credit" class="select_me"><br />' . $bonus_GB . '<hr /></div>
        <div id="div_karma" class="select_me"><br />' . $karma_drop_down . '<hr /></div>
        <div id="div_freeslots" class="select_me"><br />' . $free_leech_slot_drop_down . '<hr /></div>
        <div id="div_invite" class="select_me"><br />' . $invites_drop_down . '<hr /></div>
        <div id="div_pm" class="select_me"><br />' . $pm_drop_down . '<hr /></div>
        </td>
    </tr>                
	<tr>
		<td class="one" valign="top" align="right"><span style="font-weight: bold;">' . $lang['bonusmanager_apply_bonus'] . '</span></td>
        <td valign="top" align="left" class="one">
        <input type="checkbox" id="all_or_selected_classes" name="all_or_selected_classes" value="1"  checked="checked" /> 
        <span style="font-weight: bold;">' . $lang['bonusmanager_all_classes'] . '</span>' . $lang['bonusmanager_uncheck'] . '
        <div id="classes_open" style="display:none;"><br />' . $all_classes_check_boxes . '</div></td>
	</tr>            
	<tr>
		<td class="one" valign="top" align="right"></td>
        <td valign="top" align="left" class="one">' . $lang['bonusmanager_note'] . '<br /></td>
	</tr>        
    <tr>
        <td align="center" class="one" colspan="2">
        <input type="submit" class="btn btn-default" class="btn" name="button" value="' . $lang['bonusmanager_doit'] . '"  /></td>
    </tr>
    </table></form>
<script type="text/javascript">
/*<![CDATA[*/
$(document).ready(function(){
 $(".select_me").hide();
  $("#bonus_options_1").change(function() {
    $(".select_me").hide();
    $("#div_" + $(this).val()).show();
    //=== change the hidden input actin 2 thingie
      var text = $(this).val();
      $("#action_2").val(text);
 });
//=== show hide selected classes
$("#all_or_selected_classes").click(function() {
  $("#classes_open").slideToggle("slow", function() {
  });
});

});
/*]]>*/
</script>';
echo stdhead($lang['bonusmanager_h1_upload'], true, $stdhead) . $HTMLOUT . stdfoot($stdfoot);
?>
