<?php
/**
 |--------------------------------------------------------------------------|
 |   https://github.com/Bigjoos/                			    |
 |--------------------------------------------------------------------------|
 |   Licence Info: GPL			                                    |
 |--------------------------------------------------------------------------|
 |   Copyright (C) 2010 U-232 V5					    |
 |--------------------------------------------------------------------------|
 |   A bittorrent tracker source based on TBDev.net/tbsource/bytemonsoon.   |
 |--------------------------------------------------------------------------|
 |   Project Leaders: Mindless, Autotron, whocares, Swizzles.					    |
 |--------------------------------------------------------------------------|
  _   _   _   _   _     _   _   _   _   _   _     _   _   _   _
 / \ / \ / \ / \ / \   / \ / \ / \ / \ / \ / \   / \ / \ / \ / \
( U | - | 2 | 3 | 2 )-( S | o | u | r | c | e )-( C | o | d | e )
 \_/ \_/ \_/ \_/ \_/   \_/ \_/ \_/ \_/ \_/ \_/   \_/ \_/ \_/ \_/
 */
//==Updated modtask by Retro
if (!defined('IN_INSTALLER09_ADMIN')) {
    $HTMLOUT = '';
    $HTMLOUT.= "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\"
		\"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">
		<html xmlns='http://www.w3.org/1999/xhtml'>
		<head>
		<title>Error!</title>
		</head>
		<body>
	<div style='font-size:33px;color:white;background-color:red;text-align:center;'>Incorrect access<br />You cannot access this file directly.</div>
	</body></html>";
    echo $HTMLOUT;
    exit();
}
require_once (INCL_DIR . 'user_functions.php');
require_once (CLASS_DIR . 'page_verify.php');
require_once (CLASS_DIR . 'class_check.php');
require_once (INCL_DIR . 'function_autopost.php');
require_once (CLASS_DIR . 'class_user_options.php');
require_once (CLASS_DIR . 'class_user_options_2.php');
class_check(UC_STAFF);
$lang = array_merge($lang, load_language('modtask'));
$newpage = new page_verify();
$newpage->check('mdk1@@9');

$curuser_cache = $user_cache = $stats_cache = $user_stats_cache = '';
$postkey = PostKey(array(
    $_POST['userid'],
    $CURUSER['id']
));
function remove_torrent_pass($torrent_pass)
{
    if (strlen($torrent_pass) != 32 || !bin2hex($torrent_pass)) return false;
    $key = 'user::torrent_pass:::' . $torrent_pass;
    $mc1->delete_value($key);
}
function write_info($text)
{
    $text = sqlesc($text);
    $added = TIME_NOW;
    sql_query("INSERT INTO infolog (added, txt) VALUES($added, $text)") or sqlerr(__FILE__, __LINE__);
}
function resize_image($in)
{
    $out = array(
        'img_width' => $in['cur_width'],
        'img_height' => $in['cur_height']
    );
    if ($in['cur_width'] > $in['max_width']) {
        $out['img_width'] = $in['max_width'];
        $out['img_height'] = ceil(($in['cur_height'] * (($in['max_width'] * 100) / $in['cur_width'])) / 100);
        $in['cur_height'] = $out['img_height'];
        $in['cur_width'] = $out['img_width'];
    }
    if ($in['cur_height'] > $in['max_height']) {
        $out['img_height'] = $in['max_height'];
        $out['img_width'] = ceil(($in['cur_width'] * (($in['max_height'] * 100) / $in['cur_height'])) / 100);
    }
    return $out;
}
if ($CURUSER['class'] < UC_STAFF) stderr("{$lang['modtask_user_error']}", "{$lang['modtask_try_again']}");
//== Correct call to script
if ((isset($_POST['action'])) && ($_POST['action'] == "edituser")) {
    //== Set user id
    if (isset($_POST['userid'])) $userid = (int)$_POST['userid'];
    else stderr("{$lang['modtask_user_error']}", "{$lang['modtask_try_again']}");
    //== And verify...
    if (!is_valid_id($userid)) stderr("{$lang['modtask_error']}", "{$lang['modtask_bad_id']}");
    require_once (CLASS_DIR . 'validator.php');
    if (!validate($_POST['validator'], "ModTask_$userid")) die($lang['modtask_invalid']);
    if (CheckPostKey(array(
        $userid,
        $CURUSER['id']
    ) , $postkey) == false) stderr($lang['modtask_pmsl'], $lang['modtask_die_bit']);
    //== Fetch current user data...
    $res = sql_query("SELECT * FROM users WHERE id=" . sqlesc($userid));
    $user = mysqli_fetch_assoc($res) or sqlerr(__FILE__, __LINE__);
    if ($CURUSER['class'] <= $user['class'] && ($CURUSER['id'] != $userid && $CURUSER['class'] < UC_ADMINISTRATOR)) stderr($lang['modtask_error'], $lang['modtask_cannot_edit']);
    if (($user['immunity'] >= 1) && ($CURUSER['class'] < UC_MAX)) stderr($lang['modtask_error'], $lang['modtask_user_immune']);
    $updateset = $curuser_cache = $user_cache = $stats_cache = $user_stats_cache = $useredit['update'] = array();
    $setbits = $clrbits = 0;
    $username = ($CURUSER['perms'] & bt_options::PERMS_STEALTH ? 'System' : htmlsafechars($CURUSER['username']));
    $modcomment = (isset($_POST['modcomment']) && $CURUSER['class'] == UC_MAX) ? $_POST['modcomment'] : $user['modcomment'];
    //== Set class
    if ((isset($_POST['class'])) && (($class = $_POST['class']) != $user['class'])) {
        if ($class >= UC_MAX || ($class >= $CURUSER['class']) || ($user['class'] >= $CURUSER['class'])) stderr("{$lang['modtask_user_error']}", "{$lang['modtask_try_again']}");
        if (!valid_class($class) || $CURUSER['class'] <= $_POST['class']) stderr(($lang['modtask_error']) , $lang['modtask_badclass']);
        //== Notify user
        $what = ($class > $user['class'] ? "{$lang['modtask_promoted']}" : "{$lang['modtask_demoted']}");
        $subject = sqlesc($lang['modtask_cls_change']);
        $msg = sqlesc(sprintf($lang['modtask_have_been'], $what) . " " . get_user_class_name($class) . " {$lang['modtask_by']} " . $username);
        $added = sqlesc(TIME_NOW);
        sql_query("INSERT INTO messages (sender, receiver, msg, subject, added) VALUES(0, " . sqlesc($userid) . ", $msg, $subject, $added)") or sqlerr(__FILE__, __LINE__);
        $updateset[] = "class = " . sqlesc($class);
        $useredit['update'][] = '' . $what . $lang['modtask_to'] . get_user_class_name($class);
        $curuser_cache['class'] = $class;
        $user_cache['class'] = $class;
        $modcomment = get_date(TIME_NOW, 'DATE', 1) . " - $what {$lang['modtask_to']} '" . get_user_class_name($class) . "'{$lang['modtask_gl_by']} {$CURUSER['username']}.\n" . $modcomment;
    }
    // === add donated amount to user and to funds table
    if ((isset($_POST['donated'])) && (($donated = $_POST['donated']) != $user['donated'])) {
        $added = sqlesc(TIME_NOW);
        sql_query("INSERT INTO funds (cash, user, added) VALUES (".sqlesc($donated).", ".sqlesc($userid).", $added)") or sqlerr(__file__, __line__);
        $updateset[] = "donated = " . sqlesc($donated);
        $updateset[] = "total_donated = " . $user['total_donated'] . " + " . sqlesc($donated);
        $mc1->delete_value('totalfunds_');
        $curuser_cache['donated'] = $donated;
        $user_cache['donated'] = $donated;
        $curuser_cache['total_donated'] = ($user['total_donated'] + $donated);
        $user_cache['total_donated'] = ($user['total_donated'] + $donated);
    }
    // ====end
    // === Set donor - Time based
    if ((isset($_POST['donorlength'])) && ($donorlength = 0 + $_POST['donorlength'])) {
        if ($donorlength == 255) {
            $modcomment = get_date(TIME_NOW, 'DATE', 1) . "{$lang['modtask_donor_set']} " . $CURUSER['username'] . ".\n" . $modcomment;
            $msg = sqlesc($lang['modtask_donor_received'] . $username);
            $subject = sqlesc($lang['modtask_donor_subject']);
            $updateset[] = "donoruntil = '0'";
            $curuser_cache['donoruntil'] = '0';
            $user_cache['donoruntil'] = '0';
        } else {
            $donoruntil = (TIME_NOW + $donorlength * 604800);
            $dur = $donorlength . $lang['modtask_donor_week'] . ($donorlength > 1 ? $lang['modtask_donor_weeks'] : "");
            $msg = sqlesc($lang['modtask_donor_dear'] . $user['username'] . "{$lang['modtask_donor_msg']} $dur {$lang['modtask_donor_msg1']}" . $username);
            $subject = sqlesc($lang['modtask_donor_subject']);
            $modcomment = get_date(TIME_NOW, 'DATE', 1) . "{$lang['modtask_donor_set']}" . $CURUSER['username'] . ".\n" . $modcomment;
            $updateset[] = "donoruntil = " . sqlesc($donoruntil);
            $updateset[] = "vipclass_before = " . sqlesc($user["class"]);
            $curuser_cache['donoruntil'] = $donoruntil;
            $user_cache['donoruntil'] = $donoruntil;
            $curuser_cache['vipclass_before'] = $user["class"];
            $user_cache['vipclass_before'] = $user["class"];
        }
        $added = sqlesc(TIME_NOW);
        sql_query("INSERT INTO messages (sender, subject, receiver, msg, added) VALUES (0, $subject, " . sqlesc($userid) . ", $msg, $added)") or sqlerr(__file__, __line__);
        $updateset[] = "donor = 'yes'";
        $useredit['update'][] = $lang['modtask_donor_yes'];
        $curuser_cache['donor'] = 'yes';
        $user_cache['donor'] = 'yes';
        //$res = sql_query("SELECT class FROM users WHERE id = ".sqlesc($userid)) or sqlerr(__file__,__line__);
        //$arr = mysqli_fetch_assoc($res);
        if ($user['class'] < UC_UPLOADER) $updateset[] = "class = " . UC_VIP . "";
        $curuser_cache['class'] = UC_VIP;
        $user_cache['class'] = UC_VIP;
    }
    // === add to donor length // thanks to CoLdFuSiOn
    if ((isset($_POST['donorlengthadd'])) && ($donorlengthadd = 0 + $_POST['donorlengthadd'])) {
        $donoruntil = (int)$user["donoruntil"];
        $dur = $donorlengthadd . $lang['modtask_donor_week'] . ($donorlengthadd > 1 ? $lang['modtask_donor_weeks'] : "");
        $msg = sqlesc($lang['modtask_donor_dear'] . htmlsafechars($user['username']) . "{$lang['modtask_donor_msg2']} $dur {$lang['modtask_donor_msg3']}" . $username);
        $subject = sqlesc($lang['modtask_donor_subject_again']);
        $modcomment = get_date(TIME_NOW, 'DATE', 1) . "{$lang['modtask_donor_set_another']} $dur {$lang['modtask_gl_by']}" . $CURUSER['username'] . ".\n" . $modcomment;
        $donorlengthadd = $donorlengthadd * 7;
        sql_query("UPDATE users SET vipclass_before=" . sqlesc($user["class"]) . ", donoruntil = IF(donoruntil=0, " . TIME_NOW . " + 86400 * $donorlengthadd, donoruntil + 86400 * $donorlengthadd) WHERE id =" . sqlesc($userid)) or sqlerr(__file__, __line__);
        $added = TIME_NOW;
        sql_query("INSERT INTO messages (sender, subject, receiver, msg, added) VALUES (0, $subject, " . sqlesc($userid) . ", $msg, $added)") or sqlerr(__file__, __line__);
        $updateset[] = "donated = " . $user['donated'] . " + " . sqlesc($_POST['donated']);
        $updateset[] = "total_donated = " . $user['total_donated'] . " + " . sqlesc($_POST['donated']);
        $curuser_cache['donated'] = ($user['donated'] + $_POST['donated']);
        $user_cache['donated'] = ($user['donated'] + $_POST['donated']);
        $curuser_cache['total_donated'] = ($user['total_donated'] + $_POST['donated']);
        $user_cache['total_donated'] = ($user['total_donated'] + $_POST['donated']);
    }
    // === end add to donor length
    // === Clear donor if they were bad
    if (isset($_POST['donor']) && (($donor = $_POST['donor']) != $user['donor'])) {
        $updateset[] = "donor = " . sqlesc($donor);
        $updateset[] = "donoruntil = '0'";
        $updateset[] = "donated = '0'";
        $updateset[] = "class = " . sqlesc($user["vipclass_before"]);
        $useredit['update'][] = $lang['modtask_donor_no'];
        $curuser_cache['donor'] = $donor;
        $user_cache['donor'] = $donor;
        $curuser_cache['donoruntil'] = '0';
        $user_cache['donoruntil'] = '0';
        $curuser_cache['donated'] = '0';
        $user_cache['donated'] = '0';
        $curuser_cache['class'] = $user["vipclass_before"];
        $user_cache['class'] = $user["vipclass_before"];
        if ($donor == 'no') {
            $modcomment = get_date(TIME_NOW, 'DATE', 1) . "{$lang['modtask_donor_removed']} " . $CURUSER['username'] . ".\n" . $modcomment;
            $msg = sqlesc(sprintf($lang['modtask_donor_removed']) . $username);
            $added = sqlesc(TIME_NOW);
            $subject = sqlesc($lang['modtask_donor_subject_expire']);
            sql_query("INSERT INTO messages (sender, subject, receiver, msg, added) VALUES (0, $subject, " . sqlesc($userid) . ", $msg, $added)") or sqlerr(__file__, __line__);
        }
    }
    // ===end
    //== Enable / Disable
    if ((isset($_POST['enabled'])) && (($enabled = $_POST['enabled']) != $user['enabled'])) {
        if ($enabled == 'yes') $modcomment = get_date(TIME_NOW, 'DATE', 1) . " {$lang['modtask_enabled']} " . $CURUSER['username'] . ".\n" . $modcomment;
        else $modcomment = get_date(TIME_NOW, 'DATE', 1) . "{$lang['modtask_disabled']} " . $CURUSER['username'] . ".\n" . $modcomment;
        $updateset[] = "enabled = " . sqlesc($enabled);
        $useredit['update'][] = $lang['modtask_enabled_disabled'] . $enabled . '';
        $curuser_cache['enabled'] = $enabled;
        $user_cache['enabled'] = $enabled;
    }
    //== Set download posssible Time based
    if (isset($_POST['downloadpos']) && ($downloadpos = 0 + $_POST['downloadpos'])) {
        unset($disable_pm);
        if (isset($_POST['disable_pm'])) $disable_pm = $_POST['disable_pm'];
        $subject = sqlesc($lang['modtask_gl_notification']);
        $added = sqlesc(TIME_NOW);
        if ($downloadpos == 255) {
            $modcomment = get_date($added, 'DATE', 1) . $lang['modtask_down_dis_by'] . $CURUSER['username'] . ".\n{$lang['modtask_gl_reason']} $disable_pm\n" . $modcomment;
            $msg = sqlesc($lang['modtask_down_dis_right'] . $username . ($disable_pm ? "\n\n{$lang['modtask_gl_reason']} $disable_pm" : ''));
            $updateset[] = 'downloadpos = 0';
            $useredit['update'][] = $lang['modtask_down_pos_no'];
            $curuser_cache['downloadpos'] = '0';
            $user_cache['downloadpos'] = '0';
        } elseif ($downloadpos == 42) {
            $modcomment = get_date($added, 'DATE', 1) . $lang['modtask_down_dis_status'] . $CURUSER['username'] . ".\n" . $modcomment;
            $msg = sqlesc($lang['modtask_down_res_by'] . $username);
            $updateset[] = 'downloadpos = 1';
            $useredit['update'][] = $lang['modtask_down_pos_yes'];
            $curuser_cache['downloadpos'] = '1';
            $user_cache['downloadpos'] = '1';
        } else {
            $downloadpos_until = ($added + $downloadpos * 604800);
            $dur = $downloadpos . $lang['modtask_gl_week'] . ($downloadpos > 1 ? $lang['modtask_gl_weeks'] : '');
            $msg = sqlesc("{$lang['modtask_gl_received']} $dur {$lang['modtask_down_dis_from']} " . $username . ($disable_pm ? "\n\n{$lang['modtask_gl_reason']} $disable_pm" : ''));
            $modcomment = get_date($added, 'DATE', 1) . "{$lang['modtask_down_dis_for']} $dur {$lang['modtask_gl_by']}" . $CURUSER['username'] . ".\n{$lang['modtask_gl_reason']} $disable_pm\n" . $modcomment;
            $updateset[] = "downloadpos = " . $downloadpos_until;
            $useredit['update'][] = $lang['modtask_down_disabled'] . $downloadpos_until . '';
            $curuser_cache['downloadpos'] = $downloadpos_until;
            $user_cache['downloadpos'] = $downloadpos_until;
        }
        sql_query("INSERT INTO messages (sender, receiver, subject, msg, added) 
	             VALUES (0, ".sqlesc($userid).", $subject, $msg, $added)") or sqlerr(__file__, __line__);
    }
    //== Set upload posssible Time based
    if (isset($_POST['uploadpos']) && ($uploadpos = 0 + $_POST['uploadpos'])) {
        unset($updisable_pm);
        if (isset($_POST['updisable_pm'])) $updisable_pm = $_POST['updisable_pm'];
        $subject = sqlesc($lang['modtask_gl_notification']);
        $added = sqlesc(TIME_NOW);
        if ($uploadpos == 255) {
            $modcomment = get_date($added, 'DATE', 1) . $lang['modtask_up_dis_by'] . $CURUSER['username'] . ".\n{$lang['modtask_gl_reason']} $updisable_pm\n" . $modcomment;
            $msg = sqlesc($lang['modtask_up_dis_right'] . $username . ($updisable_pm ? "\n\n{$lang['modtask_gl_reason']} $updisable_pm" : ''));
            $updateset[] = 'uploadpos = 0';
            $useredit['update'][] = $lang['modtask_up_pos_no'];
            $curuser_cache['uploadpos'] = '0';
            $user_cache['uploadpos'] = '0';
        } elseif ($uploadpos == 42) {
            $modcomment = get_date($added, 'DATE', 1) . $lang['modtask_up_dis_status'] . $CURUSER['username'] . ".\n" . $modcomment;
            $msg = sqlesc($lang['modtask_up_res_by'] . $username);
            $updateset[] = 'uploadpos = 1';
            $useredit['update'][] = $lang['modtask_up_pos_yes'];
            $curuser_cache['uploadpos'] = '1';
            $user_cache['uploadpos'] = '1';
        } else {
            $uploadpos_until = ($added + $uploadpos * 604800);
            $dur = $uploadpos . $lang['modtask_gl_week'] . ($uploadpos > 1 ? $lang['modtask_gl_weeks'] : '');
            $msg = sqlesc("{$lang['modtask_gl_received']} $dur {$lang['modtask_up_dis_from']}" . $username . ($updisable_pm ? "\n\n{$lang['modtask_gl_reason']} $updisable_pm" : ''));
            $modcomment = get_date($added, 'DATE', 1) . "{$lang['modtask_up_dis_for']} $dur {$lang['modtask_gl_by']}" . $CURUSER['username'] . ".\n{$lang['modtask_gl_reason']} $updisable_pm\n" . $modcomment;
            $updateset[] = "uploadpos = " . $uploadpos_until;
            $useredit['update'][] = $lang['modtask_up_disabled'] . $uploadpos_until . '';
            $curuser_cache['uploadpos'] = $uploadpos_until;
            $user_cache['uploadpos'] = $uploadpos_until;
        }
        sql_query("INSERT INTO messages (sender, receiver, subject, msg, added) 
	          VALUES (0, ".sqlesc($userid).", $subject, $msg, $added)") or sqlerr(__file__, __line__);
    }
    //== Set Pm posssible Time based
    if (isset($_POST['sendpmpos']) && ($sendpmpos = 0 + $_POST['sendpmpos'])) {
        unset($pmdisable_pm);
        if (isset($_POST['pmdisable_pm'])) $pmdisable_pm = $_POST['pmdisable_pm'];
        $subject = sqlesc($lang['modtask_gl_notification']);
        $added = sqlesc(TIME_NOW);
        if ($sendpmpos == 255) {
            $modcomment = get_date($added, 'DATE', 1) . $lang['modtask_pm_dis_by'] . $CURUSER['username'] . ".\n{$lang['modtask_gl_reason']} $pmdisable_pm\n" . $modcomment;
            $msg = sqlesc($lang['modtask_pm_dis_right'] . $username . ($pmdisable_pm ? "\n\n{$lang['modtask_gl_reason']} $pmdisable_pm" : ''));
            $updateset[] = 'sendpmpos = 0';
            $useredit['update'][] = $lang['modtask_pm_pos_no'];
            $curuser_cache['sendpmpos'] = '0';
            $user_cache['sendpmpos'] = '0';
        } elseif ($sendpmpos == 42) {
            $modcomment = get_date($added, 'DATE', 1) . $lang['modtask_pm_dis_status'] . $CURUSER['username'] . ".\n" . $modcomment;
            $msg = sqlesc($lang['modtask_pm_res_by'] . $username);
            $updateset[] = 'sendpmpos = 1';
            $useredit['update'][] = $lang['modtask_pm_pos_yes'];
            $curuser_cache['sendpmpos'] = '1';
            $user_cache['sendpmpos'] = '1';
        } else {
            $sendpmpos_until = ($added + $sendpmpos * 604800);
            $dur = $sendpmpos . $lang['modtask_gl_week'] . ($sendpmpos > 1 ? $lang['modtask_gl_weeks'] : '');
            $msg = sqlesc("{$lang['modtask_gl_received']} $dur {$lang['modtask_pm_dis_from']}" . $username . ($pmdisable_pm ? "\n\n{$lang['modtask_gl_reason']} $pmdisable_pm" : ''));
            $modcomment = get_date($added, 'DATE', 1) . "{$lang['modtask_pm_dis_for']} $dur {$lang['modtask_gl_by']}" . $CURUSER['username'] . ".\n{$lang['modtask_gl_reason']} $pmdisable_pm\n" . $modcomment;
            $updateset[] = "sendpmpos = " . $sendpmpos_until;
            $useredit['update'][] = $lang['modtask_pm_disabled'] . $sendpmpos_until . '';
            $curuser_cache['sendpmpos'] = $sendpmpos_until;
            $user_cache['sendpmpos'] = $sendpmpos_until;
        }
        sql_query("INSERT INTO messages (sender, receiver, subject, msg, added) 
	             VALUES (0, ".sqlesc($userid).", $subject, $msg, $added)") or sqlerr(__file__, __line__);
    }
    //== Set shoutbox posssible Time based
    if (isset($_POST['chatpost']) && ($chatpost = 0 + $_POST['chatpost'])) {
        unset($chatdisable_pm);
        if (isset($_POST['chatdisable_pm'])) $chatdisable_pm = $_POST['chatdisable_pm'];
        $subject = sqlesc($lang['modtask_gl_notification']);
        $added = sqlesc(TIME_NOW);
        if ($chatpost == 255) {
            $modcomment = get_date($added, 'DATE', 1) . $lang['modtask_shout_dis_by'] . $CURUSER['username'] . ".\n{$lang['modtask_gl_reason']} $chatdisable_pm\n" . $modcomment;
            $msg = sqlesc($lang['modtask_shout_dis_right'] . $username . ($chatdisable_pm ? "\n\n{$lang['modtask_gl_reason']} $chatdisable_pm" : ''));
            $updateset[] = 'chatpost = 0';
            $useredit['update'][] = $lang['modtask_shout_pos_no'];
            $curuser_cache['chatpost'] = '0';
            $user_cache['chatpost'] = '0';
        } elseif ($chatpost == 42) {
            $modcomment = get_date($added, 'DATE', 1) . $lang['modtask_shout_dis_status'] . $CURUSER['username'] . ".\n" . $modcomment;
            $msg = sqlesc($lang['modtask_shout_res_by'] . $username);
            $updateset[] = 'chatpost = 1';
            $useredit['update'][] = $lang['modtask_shout_pos_yes'];
            $curuser_cache['chatpost'] = '1';
            $user_cache['chatpost'] = '1';
        } else {
            $chatpost_until = ($added + $chatpost * 604800);
            $dur = $chatpost . $lang['modtask_gl_week'] . ($chatpost > 1 ? $lang['modtask_gl_weeks'] : '');
            $msg = sqlesc("{$lang['modtask_gl_received']} $dur {$lang['modtask_shout_dis_from']}" . $username . ($chatdisable_pm ? "\n\n{$lang['modtask_gl_reason']} $chatdisable_pm" : ''));
            $modcomment = get_date($added, 'DATE', 1) . "{$lang['modtask_shout_dis_for']} $dur {$lang['modtask_gl_by']}" . $CURUSER['username'] . ".\n{$lang['modtask_gl_reason']} $chatdisable_pm\n" . $modcomment;
            $updateset[] = "chatpost = " . $chatpost_until;
            $useredit['update'][] = $lang['modtask_shout_disabled'] . $chatpost_until . '';
            $curuser_cache['chatpost'] = $chatpost_until;
            $user_cache['chatpost'] = $chatpost_until;
        }
        sql_query("INSERT INTO messages (sender, receiver, subject, msg, added) 
	             VALUES (0, ".sqlesc($userid).", $subject, $msg, $added)") or sqlerr(__file__, __line__);
    }
    //== Set Immunity Status Time based
    if (isset($_POST['immunity']) && ($immunity = 0 + $_POST['immunity'])) {
        unset($immunity_pm);
        if (isset($_POST['immunity_pm'])) $immunity_pm = $_POST['immunity_pm'];
        $subject = sqlesc($lang['modtask_gl_notification']);
        $added = sqlesc(TIME_NOW);
        if ($immunity == 255) {
            $modcomment = get_date($added, 'DATE', 1) . $lang['modtask_immune_status'] . $CURUSER['username'] . ".\n{$lang['modtask_gl_reason']} $immunity_pm\n" . $modcomment;
            $msg = sqlesc($lang['modtask_immune_received'] . $username . ($immunity_pm ? "\n\n{$lang['modtask_gl_reason']} $immunity_pm" : ''));
            $updateset[] = 'immunity = 1';
            $curuser_cache['immunity'] = '1';
            $user_cache['immunity'] = '1';
        } elseif ($immunity == 42) {
            $modcomment = get_date($added, 'DATE', 1) . $lang['modtask_immune_remove'] . $CURUSER['username'] . ".\n" . $modcomment;
            $msg = sqlesc($lang['modtask_immune_removed'] . $username);
            $updateset[] = 'immunity = 0';
            $curuser_cache['immunity'] = '0';
            $user_cache['immunity'] = '0';
        } else {
            $immunity_until = ($added + $immunity * 604800);
            $dur = $immunity . $lang['modtask_gl_week'] . ($immunity > 1 ? $lang['modtask_gl_weeks'] : '');
            $msg = sqlesc("{$lang['modtask_gl_received']} $dur {$lang['modtask_immune_status_from']}" . $username . ($immunity_pm ? "\n\n{$lang['modtask_gl_reason']} $immunity_pm" : ''));
            $modcomment = get_date($added, 'DATE', 1) . "{$lang['modtask_immune_status_for']} $dur {$lang['modtask_gl_by']}" . $CURUSER['username'] . ".\n{$lang['modtask_gl_reason']} $immunity_pm\n" . $modcomment;
            $updateset[] = "immunity = " . $immunity_until;
            $curuser_cache['immunity'] = $immunity_until;
            $user_cache['immunity'] = $immunity_until;
        }
        sql_query("INSERT INTO messages (sender, receiver, subject, msg, added) 
	             VALUES (0, ".sqlesc($userid).", $subject, $msg, $added)") or sqlerr(__file__, __line__);
    }
    //== Set leechwarn Status Time based
    if (isset($_POST['leechwarn']) && ($leechwarn = 0 + $_POST['leechwarn'])) {
        unset($leechwarn_pm);
        if (isset($_POST['leechwarn_pm'])) $leechwarn_pm = $_POST['leechwarn_pm'];
        $subject = sqlesc($lang['modtask_gl_notification']);
        $added = sqlesc(TIME_NOW);
        if ($leechwarn == 255) {
            $modcomment = get_date($added, 'DATE', 1) . $lang['modtask_leechwarn_status'] . $CURUSER['username'] . ".\n{$lang['modtask_gl_reason']} $leechwarn_pm\n" . $modcomment;
            $msg = sqlesc($lang['modtask_leechwarn_received'] . $username . ($leechwarn_pm ? "\n\n{$lang['modtask_gl_reason']} $leechwarn_pm" : ''));
            $updateset[] = 'leechwarn = 1';
            $curuser_cache['leechwarn'] = '1';
            $user_cache['leechwarn'] = '1';
        } elseif ($leechwarn == 42) {
            $modcomment = get_date($added, 'DATE', 1) . $lang['modtask_leechwarn_remove'] . $CURUSER['username'] . ".\n" . $modcomment;
            $msg = sqlesc($lang['modtask_leechwarn_removed'] . $username);
            $updateset[] = 'leechwarn = 0';
            $curuser_cache['leechwarn'] = '0';
            $user_cache['leechwarn'] = '0';
        } else {
            $leechwarn_until = ($added + $leechwarn * 604800);
            $dur = $leechwarn . $lang['modtask_gl_week'] . ($leechwarn > 1 ? $lang['modtask_gl_weeks'] : '');
            $msg = sqlesc("{$lang['modtask_gl_received']} $dur {$lang['modtask_leechwarn_status_from']}" . $username . ($leechwarn_pm ? "\n\n{$lang['modtask_gl_reason']} $leechwarn_pm" : ''));
            $modcomment = get_date($added, 'DATE', 1) . "{$lang['modtask_leechwarn_status_for']} $dur {$lang['modtask_gl_by']}" . $CURUSER['username'] . ".\n{$lang['modtask_gl_reason']} $leechwarn_pm\n" . $modcomment;
            $updateset[] = "leechwarn = " . $leechwarn_until;
            $curuser_cache['leechwarn'] = $leechwarn_until;
            $user_cache['leechwarn'] = $leechwarn_until;
        }
        sql_query("INSERT INTO messages (sender, receiver, subject, msg, added) 
	             VALUES (0, ".sqlesc($userid).", $subject, $msg, $added)") or sqlerr(__file__, __line__);
    }
    //= Set warn Status Time based
    if (isset($_POST['warned']) && ($warned = 0 + $_POST['warned'])) {
        unset($warned_pm);
        if (isset($_POST['warned_pm'])) $warned_pm = $_POST['warned_pm'];
        $subject = sqlesc($lang['modtask_gl_notification']);
        $added = sqlesc(TIME_NOW);
        if ($warned == 255) {
            $modcomment = get_date($added, 'DATE', 1) . $lang['modtask_warned_status'] . $CURUSER['username'] . ".\n{$lang['modtask_gl_reason']} $warned_pm\n" . $modcomment;
            $msg = sqlesc($lang['modtask_warned_received'] . $username . ($warned_pm ? "\n\n{$lang['modtask_gl_reason']} $warned_pm" : ''));
            $updateset[] = 'warned = 1';
            $curuser_cache['warned'] = '1';
            $user_cache['warned'] = '1';
        } elseif ($warned == 42) {
            $modcomment = get_date($added, 'DATE', 1) . $lang['modtask_warned_remove'] . $CURUSER['username'] . ".\n" . $modcomment;
            $msg = sqlesc($lang['modtask_warned_removed'] . $username);
            $updateset[] = 'warned = 0';
            $curuser_cache['warned'] = '0';
            $user_cache['warned'] = '0';
        } else {
            $warned_until = ($added + $warned * 604800);
            $dur = $warned . $lang['modtask_gl_week'] . ($warned > 1 ? $lang['modtask_gl_weeks'] : '');
            $msg = sqlesc("{$lang['modtask_gl_received']} $dur {$lang['modtask_warned_status_from']}" . $username . ($warned_pm ? "\n\n{$lang['modtask_gl_reason']} $warned_pm" : ''));
            $modcomment = get_date($added, 'DATE', 1) . "{$lang['modtask_warned_status_for']} $dur {$lang['modtask_gl_by']}" . $CURUSER['username'] . ".\n{$lang['modtask_gl_reason']} $warned_pm\n" . $modcomment;
            $updateset[] = "warned = " . $warned_until;
            $curuser_cache['warned'] = $warned_until;
            $user_cache['warned'] = $warned_until;
        }
        sql_query("INSERT INTO messages (sender, receiver, subject, msg, added) 
	             VALUES (0, ".sqlesc($userid).", $subject, $msg, $added)") or sqlerr(__file__, __line__);
    }
    //== Add remove uploaded
    if ($CURUSER['class'] >= UC_ADMINISTRATOR) {
        $uploadtoadd = 0 + $_POST["amountup"];
        $downloadtoadd = 0 + $_POST["amountdown"];
        $formatup = $_POST["formatup"];
        $formatdown = $_POST["formatdown"];
        $mpup = $_POST["upchange"];
        $mpdown = $_POST["downchange"];
        if ($uploadtoadd > 0) {
            if ($mpup == "plus") {
                $newupload = $user["uploaded"] + ($formatup == 'mb' ? ($uploadtoadd * 1048576) : ($uploadtoadd * 1073741824));
                $modcomment = get_date(TIME_NOW, 'DATE', 1) . " {$lang['modtask_add_upload']} (" . $uploadtoadd . " " . $formatup . ") {$lang['modtask_by']} " . $CURUSER['username'] . "\n" . $modcomment;
            } else {
                $newupload = $user["uploaded"] - ($formatup == 'mb' ? ($uploadtoadd * 1048576) : ($uploadtoadd * 1073741824));
                if ($newupload >= 0) $modcomment = get_date(TIME_NOW, 'DATE', 1) . " {$lang['modtask_subtract_upload']} (" . $uploadtoadd . " " . $formatup . ") {$lang['modtask_by']} " . $CURUSER['username'] . "\n" . $modcomment;
            }
            if ($newupload >= 0) $updateset[] = "uploaded = " . sqlesc($newupload) . "";
            $useredit['update'][] = $lang['modtask_uploaded_altered'] . mksize($uploadtoadd) . $lang['modtask_to'] . mksize($newupload);
            $stats_cache['uploaded'] = $newupload;
            $user_stats_cache['uploaded'] = $newupload;
        }
        if ($downloadtoadd > 0) {
            if ($mpdown == "plus") {
                $newdownload = $user["downloaded"] + ($formatdown == 'mb' ? ($downloadtoadd * 1048576) : ($downloadtoadd * 1073741824));
                $modcomment = get_date(TIME_NOW, 'DATE', 1) . " {$lang['modtask_added_download']} (" . $downloadtoadd . " " . $formatdown . ") {$lang['modtask_by']} " . $CURUSER['username'] . "\n" . $modcomment;
            } else {
                $newdownload = $user["downloaded"] - ($formatdown == 'mb' ? ($downloadtoadd * 1048576) : ($downloadtoadd * 1073741824));
                if ($newdownload >= 0) $modcomment = get_date(TIME_NOW, 'DATE', 1) . " {$lang['modtask_subtract_download']} (" . $downloadtoadd . " " . $formatdown . ") {$lang['modtask_by']} " . $CURUSER['username'] . "\n" . $modcomment;
            }
            if ($newdownload >= 0) $updateset[] = "downloaded = " . sqlesc($newdownload) . "";
            $useredit['update'][] = $lang['modtask_download_altered'] . mksize($downloadtoadd) . $lang['modtask_to'] . mksize($newdownload);
            $stats_cache['downloaded'] = $newdownload;
            $user_stats_cache['downloaded'] = $newdownload;
        }
    }
    //== End add/remove upload
    //== Change Custom Title
    if ((isset($_POST['title'])) && (($title = $_POST['title']) != ($curtitle = $user['title']))) {
        $modcomment = get_date(TIME_NOW, 'DATE', 1) . "{$lang['modtask_custom_title']}'" . $title . "'{$lang['modtask_gl_from']}'" . $curtitle . "'{$lang['modtask_by']}" . $CURUSER['username'] . ".\n" . $modcomment;
        $updateset[] = "title = " . sqlesc($title);
        $useredit['update'][] = $lang['modtask_custom_title_altered'];
        $curuser_cache['title'] = $title;
        $user_cache['title'] = $title;
    }
    //== Reset Torrent pass
    if ((isset($_POST['reset_torrent_pass'])) && ($_POST['reset_torrent_pass'])) {
        $newpasskeyversion = ($user['torrent_pass_version'] + 1);
        $newpasskey = md5($user['username'] . TIME_NOW . $user['passhash']);
        $modcomment = get_date(TIME_NOW, 'DATE', 1) . "{$lang['modtask_passkey']}" . sqlesc($user['torrent_pass']) . "{$lang['modtask_reset']}" . sqlesc($newpasskey) . "{$lang['modtask_by']}" . $CURUSER['username'] . ".\n" . $modcomment;
        $curuser_cache['torrent_pass'] = $newpasskey;
        $user_cache['torrent_pass'] = $newpasskey;
        $curuser_cache['torrent_pass_version'] = $newpasskeyversion;
        $user_cache['torrent_pass_version'] = $newpasskeyversion;
        $updateset[] = "torrent_pass=" . sqlesc($newpasskey);
        $updateset[] = "torrent_pass_version=torrent_pass_version+1";
        $useredit['update'][] = $lang['modtask_torrent_pass'] . sqlesc($user['torrent_pass']) . $lang['modtask_torrent_pass_reset'] . $newpasskey . '';
    }
    //== seedbonus
    if ((isset($_POST['seedbonus'])) && (($seedbonus = $_POST['seedbonus']) != ($curseedbonus = $user['seedbonus']))) {
        $modcomment = get_date(TIME_NOW, 'DATE', 1) . $lang['modtask_seedbonus'] . $seedbonus . $lang['modtask_gl_from'] . $curseedbonus . $lang['modtask_gl_by'] . $CURUSER['username'] . ".\n" . $modcomment;
        $updateset[] = 'seedbonus = ' . sqlesc($seedbonus);
        $useredit['update'][] =  $lang['modtask_seedbonus_total'];
        $stats_cache['seedbonus'] = $seedbonus;
        $user_stats_cache['seedbonus'] = $seedbonus;
    }
    //== Reputation
    if ((isset($_POST['reputation'])) && (($reputation = $_POST['reputation']) != ($curreputation = $user['reputation']))) {
        $modcomment = get_date(TIME_NOW, 'DATE', 1) . $lang['modtask_reputation'] . $reputation . $lang['modtask_gl_from'] . $curreputation . $lang['modtask_gl_by'] . $CURUSER['username'] . ".\n" . $modcomment;
        $updateset[] = 'reputation = ' . sqlesc($reputation);
        $useredit['update'][] = $lang['modtask_reputation_total'];
        $curuser_cache['reputation'] = $reputation;
        $user_cache['reputation'] = $reputation;
    }
    //== Add Comment to ModComment
    if ((isset($_POST['addcomment'])) && ($addcomment = trim($_POST['addcomment']))) {
        $modcomment = get_date(TIME_NOW, 'DATE', 1) . " - " . $addcomment . " - " . $CURUSER['username'] . ".\n" . $modcomment;
    }
    //== Avatar Changed
    if ((isset($_POST['avatar'])) && (($avatar = $_POST['avatar']) != ($curavatar = $user['avatar']))) {
        $avatar = trim(urldecode($avatar));
        if (preg_match("/^http:\/\/$/i", $avatar) or preg_match("/[?&;]/", $avatar) or preg_match("#javascript:#is", $avatar) or !preg_match("#^https?://(?:[^<>*\"]+|[a-z0-9/\._\-!]+)$#iU", $avatar)) {
            $avatar = '';
        }
        if (!empty($avatar)) {
            $img_size = @GetImageSize($avatar);
            if ($img_size == FALSE || !in_array($img_size['mime'], $INSTALLER09['allowed_ext'])) stderr("{$lang['modtask_user_error']}", "{$lang['modtask_not_image']}");
            if ($img_size[0] < 5 || $img_size[1] < 5) stderr("{$lang['modtask_user_error']}", "{$lang['modtask_image_small']}");
            if (($img_size[0] > $INSTALLER09['av_img_width']) OR ($img_size[1] > $INSTALLER09['av_img_height'])) {
                $image = resize_image(array(
                    'max_width' => $INSTALLER09['av_img_width'],
                    'max_height' => $INSTALLER09['av_img_height'],
                    'cur_width' => $img_size[0],
                    'cur_height' => $img_size[1]
                ));
            } else {
                $image['img_width'] = $img_size[0];
                $image['img_height'] = $img_size[1];
            }
            $updateset[] = "av_w = " . sqlesc($image['img_width']);
            $updateset[] = "av_h = " . sqlesc($image['img_height']);
        }
        $modcomment = get_date(TIME_NOW, 'DATE', 1) . "{$lang['modtask_avatar_change']}" . htmlsafechars($curavatar) . "{$lang['modtask_to']}" . htmlsafechars($avatar) . "{$lang['modtask_by']} " . $CURUSER['username'] . ".\n" . $modcomment;
        $updateset[] = "avatar = " . sqlesc($avatar);
        $useredit['update'][] = $lang['modtask_avatar_changed'];
        $curuser_cache['avatar'] = $avatar;
        $user_cache['avatar'] = $avatar;
    }
    //== sig checks
    if ((isset($_POST['signature'])) && (($signature = $_POST['signature']) != ($cursignature = $user['signature']))) {
        $signature = trim(urldecode($signature));
        if (preg_match("/^http:\/\/$/i", $signature) or preg_match("/[?&;]/", $signature) or preg_match("#javascript:#is", $signature) or !preg_match("#^https?://(?:[^<>*\"]+|[a-z0-9/\._\-!]+)$#iU", $signature)) {
            $signature = '';
        }
        if (!empty($signature)) {
            $img_size = @GetImageSize($signature);
            if ($img_size == FALSE || !in_array($img_size['mime'], $INSTALLER09['allowed_ext'])) stderr("{$lang['modtask_user_error']}", "{$lang['modtask_not_image']}");
            if ($img_size[0] < 5 || $img_size[1] < 5) stderr("{$lang['modtask_user_error']}", "{$lang['modtask_image_small']}");
            if (($img_size[0] > $INSTALLER09['sig_img_width']) OR ($img_size[1] > $INSTALLER09['sig_img_height'])) {
                $image = resize_image(array(
                    'max_width' => $INSTALLER09['sig_img_width'],
                    'max_height' => $INSTALLER09['sig_img_height'],
                    'cur_width' => $img_size[0],
                    'cur_height' => $img_size[1]
                ));
            } else {
                $image['img_width'] = $img_size[0];
                $image['img_height'] = $img_size[1];
            }
            $updateset[] = "sig_w = " . sqlesc($image['img_width']);
            $updateset[] = "sig_h = " . sqlesc($image['img_height']);
        }
        $modcomment = get_date(TIME_NOW, 'DATE', 1) . "{$lang['modtask_signature_change']}" . htmlsafechars($cursignature) . "{$lang['modtask_to']}" . htmlsafechars($signature) . "{$lang['modtask_by']} " . $CURUSER['username'] . ".\n" . $modcomment;
        $updateset[] = "signature = " . sqlesc($signature);
        $useredit['update'][] = $lang['modtask_signature_changed'];
        $curuser_cache['signature'] = $signature;
        $user_cache['signature'] = $signature;
    }
    //==End
    //=== allow invites
    if ((isset($_POST['invite_on'])) && (($invite_on = $_POST['invite_on']) != $user['invite_on'])) {
        $modcomment = get_date(TIME_NOW, 'DATE', 1) . $lang['modtask_invites_allowed'] . htmlsafechars($user['invite_on']) . "{$lang['modtask_to']}$invite_on{$lang['modtask_gl_by']}" . $CURUSER['username'] . ".\n" . $modcomment;
        $updateset[] = "invite_on = " . sqlesc($invite_on);
        $useredit['update'][] = $lang['modtask_invites_enabled'] . htmlsafechars($invite_on) . '';
        $curuser_cache['invite_on'] = $invite_on;
        $user_cache['invite_on'] = $invite_on;
    }
    //== change invites
    if ((isset($_POST['invites'])) && (($invites = $_POST['invites']) != ($curinvites = $user['invites']))) {
        $modcomment = get_date(TIME_NOW, 'DATE', 1) . $lang['modtask_invites_amount'] . $invites . $lang['modtask_gl_from'] . $curinvites . $lang['modtask_gl_by'] . $CURUSER['username'] . ".\n" . $modcomment;
        $updateset[] = "invites = " . sqlesc($invites);
        $useredit['update'][] = $lang['modtask_invites_total'];
        $curuser_cache['invites'] = $invites;
        $user_cache['invites'] = $invites;
    }
    //== Fls Support
    if ((isset($_POST['support'])) && (($support = $_POST['support']) != $user['support'])) {
        if ($support == 'yes') {
            $modcomment = get_date(TIME_NOW, 'DATE', 1) . $lang['modtask_fls_promoted'] . $CURUSER['username'] . ".\n" . $modcomment;
        } elseif ($support == 'no') {
            $modcomment = get_date(TIME_NOW, 'DATE', 1) . $lang['modtask_fls_demoted'] . $CURUSER['username'] . ".\n" . $modcomment;
        } else stderr("{$lang['modtask_user_error']}", "{$lang['modtask_try_again']}");
        $supportfor = $_POST['supportfor'];
        $updateset[] = "support = " . sqlesc($support);
        $updateset[] = "supportfor = " . sqlesc($supportfor);
        $useredit['update'][] = $lang['modtask_fls_support'] . $support . '';
        $useredit['update'][] = $lang['modtask_fls_support'] . $supportfor . '';
        $curuser_cache['support'] = $support;
        $user_cache['support'] = $support;
        $curuser_cache['supportfor'] = $supportfor;
        $user_cache['supportfor'] = $supportfor;
    }
    //== change freeslots
    if ((isset($_POST['freeslots'])) && (($freeslots = $_POST['freeslots']) != ($curfreeslots = $user['freeslots']))) {
        $modcomment = get_date(TIME_NOW, 'DATE', 1) . $lang['modtask_freeslots_amount'] . $freeslots . $lang['modtask_gl_from'] . $curfreeslots . $lang['modtask_gl_by'] . $CURUSER['username'] . ".\n" . $modcomment;
        $updateset[] = 'freeslots = ' . sqlesc($freeslots);
        $useredit['update'][] = $lang['modtask_freeslots_total'];
        $curuser_cache['freeslots'] = $freeslots;
        $user_cache['freeslots'] = $freeslots;
    }
    //== Set Freeleech Status Time based
    if (isset($_POST['free_switch']) && ($free_switch = 0 + $_POST['free_switch'])) {
        unset($free_pm);
        if (isset($_POST['free_pm'])) $free_pm = $_POST['free_pm'];
        $subject = sqlesc($lang['modtask_gl_notification']);
        $added = sqlesc(TIME_NOW);
        if ($free_switch == 255) {
            $modcomment = get_date($added, 'DATE', 1) . $lang['modtask_freeleech_status'] . $CURUSER['username'] . ".\n{$lang['modtask_gl_reason']} $free_pm\n" . $modcomment;
            $msg = sqlesc($lang['modtask_freeleech_received'] . $username . ($free_pm ? "\n\n{$lang['modtask_gl_reason']} $free_pm" : ''));
            $updateset[] = 'free_switch = 1';
            $useredit['update'][] = $lang['modtask_freeleech_yes'];
            $curuser_cache['free_switch'] = '1';
            $user_cache['free_switch'] = '1';
        } elseif ($free_switch == 42) {
            $modcomment = get_date($added, 'DATE', 1) . $lang['modtask_freeleech_remove'] . $CURUSER['username'] . ".\n" . $modcomment;
            $msg = sqlesc($lang['modtask_freeleech_removed'] . $username);
            $updateset[] = 'free_switch = 0';
            $useredit['update'][] = $lang['modtask_freeleech_no'];
            $curuser_cache['free_switch'] = '0';
            $user_cache['free_switch'] = '0';
        } else {
            $free_until = ($added + $free_switch * 604800);
            $dur = $free_switch . $lang['modtask_gl_week'] . ($free_switch > 1 ? $lang['modtask_gl_weeks'] : '');
            $msg = sqlesc("{$lang['modtask_gl_received']} $dur {$lang['modtask_freeleech_from']}Freeleech Status from " . $username . ($free_pm ? "\n\n{$lang['modtask_gl_reason']} $free_pm" : ''));
            $modcomment = get_date($added, 'DATE', 1) . "{$lang['modtask_freeleech_for']} $dur {$lang['modtask_gl_by']}" . $CURUSER['username'] . ".\n{$lang['modtask_gl_reason']} $free_pm\n" . $modcomment;
            $updateset[] = "free_switch = " . $free_until;
            $useredit['update'][] = $lang['modtask_freeleech_enabled'] . get_date($free_until, 'DATE', 0, 1) . '';
            $curuser_cache['free_switch'] = $free_until;
            $user_cache['free_switch'] = $free_until;
        }
        sql_query("INSERT INTO messages (sender, receiver, subject, msg, added) 
	             VALUES (0, ".sqlesc($userid).", $subject, $msg, $added)") or sqlerr(__file__, __line__);
    }
    //== Set gaming posssible Time based
    if (isset($_POST['game_access']) && ($game_access = 0 + $_POST['game_access'])) {
        unset($game_disable_pm);
        if (isset($_POST['game_disable_pm'])) $game_disable_pm = $_POST['game_disable_pm'];
        $subject = sqlesc($lang['modtask_gl_notification']);
        $added = sqlesc(TIME_NOW);
        if ($game_access == 255) {
            $modcomment = get_date($added, 'DATE', 1) . $lang['modtask_games_dis_by'] . $CURUSER['username'] . ".\n{$lang['modtask_gl_reason']} $game_disable_pm\n" . $modcomment;
            $msg = sqlesc($lang['modtask_games_dis_right'] . $username . ($game_disable_pm ? "\n\n{$lang['modtask_gl_reason']} $game_disable_pm" : ''));
            $updateset[] = 'game_access = 0';
            $useredit['update'][] = $lang['modtask_games_poss_no'];
            $curuser_cache['game_access'] = 0;
            $user_cache['game_access'] = 0;
        } elseif ($game_access == 42) {
            $modcomment = get_date($added, 'DATE', 1) . $lang['modtask_games_dis_status'] . $CURUSER['username'] . ".\n" . $modcomment;
            $msg = sqlesc($lang['modtask_games_res_by'] . $username);
            $updateset[] = 'game_access = 1';
            $useredit['update'][] = $lang['modtask_games_poss_yes'];
            $curuser_cache['game_access'] = 1;
            $user_cache['game_access'] = 1;
        } else {
            $game_access_until = ($added + $game_access * 604800);
            $dur = $game_access . $lang['modtask_gl_week'] . ($game_access > 1 ? $lang['modtask_gl_weeks'] : '');
            $msg = sqlesc("{$lang['modtask_gl_received']} $dur {$lang['modtask_games_dis_from']}" . $username . ($game_disable_pm ? "\n\n{$lang['modtask_gl_reason']} $game_disable_pm" : ''));
            $modcomment = get_date($added, 'DATE', 1) . "{$lang['modtask_games_dis_for']} $dur {$lang['modtask_gl_by']}" . $CURUSER['username'] . ".\n{$lang['modtask_gl_reason']} $game_disable_pm\n" . $modcomment;
            $updateset[] = "game_access = " . $game_access_until;
            $useredit['update'][] = $lang['modtask_games_disabled'] . get_date($game_access_until, 'DATE', 0, 1) . '';
            $curuser_cache['game_access'] = $game_access_until;
            $user_cache['game_access'] = $game_access_until;
        }
        sql_query("INSERT INTO messages (sender, receiver, subject, msg, added)
                 VALUES (0, ".sqlesc($userid).", $subject, $msg, $added)") or sqlerr(__file__, __line__);
    }
    /// Set avatar posssible Time based
    if (isset($_POST['avatarpos']) && ($avatarpos = 0 + $_POST['avatarpos'])) {
        unset($avatardisable_pm);
        if (isset($_POST['avatardisable_pm'])) $avatardisable_pm = $_POST['avatardisable_pm'];
        $subject = sqlesc($lang['modtask_gl_notification']);
        $added = sqlesc(TIME_NOW);
        if ($avatarpos == 255) {
            $modcomment = get_date($added, 'DATE', 1) . $lang['modtask_avatar_dis_by'] . $CURUSER['username'] . ".\n{$lang['modtask_gl_reason']} $avatardisable_pm\n" . $modcomment;
            $msg = sqlesc($lang['modtask_avatar_dis_right'] . $username . ($avatardisable_pm ? "\n\n{$lang['modtask_gl_reason']} $avatardisable_pm" : ''));
            $updateset[] = 'avatarpos = 0';
            $useredit['update'][] = $lang['modtask_avatar_poss_no'];
            $curuser_cache['avatarpos'] = 0;
            $user_cache['avatarpos'] = 0;
        } elseif ($avatarpos == 42) {
            $modcomment = get_date($added, 'DATE', 1) . $lang['modtask_avatar_dis_status'] . $CURUSER['username'] . ".\n" . $modcomment;
            $msg = sqlesc($lang['modtask_avatar_res_by'] . $username);
            $updateset[] = 'avatarpos = 1';
            $useredit['update'][] = $lang['modtask_avatar_poss_yes'];
            $curuser_cache['avatarpos'] = 1;
            $user_cache['avatarpos'] = 1;
        } else {
            $avatarpos_until = ($added + $avatarpos * 604800);
            $dur = $avatarpos . $lang['modtask_gl_week'] . ($avatarpos > 1 ? $lang['modtask_gl_weeks'] : '');
            $msg = sqlesc("{$lang['modtask_gl_received']} $dur {$lang['modtask_avatar_dis_from']}" . $username . ($avatardisable_pm ? "\n\n{$lang['modtask_gl_reason']} $avatardisable_pm" : ''));
            $modcomment = get_date($added, 'DATE', 1) . "{$lang['modtask_avatar_dis_for']} $dur {$lang['modtask_gl_by']}" . $CURUSER['username'] . ".\n{$lang['modtask_gl_reason']} $avatardisable_pm\n" . $modcomment;
            $updateset[] = "avatarpos = " . $avatarpos_until;
            $useredit['update'][] = $lang['modtask_avatar_sel_dis'] . get_date($avatarpos_until, 'DATE', 0, 1) . '';
            $curuser_cache['avatarpos'] = $avatarpos_until;
            $user_cache['avatarpos'] = $avatarpos_until;
        }
        sql_query("INSERT INTO messages (sender, receiver, subject, msg, added) 
                VALUES (0, ".sqlesc($userid).", $subject, $msg, $added)") or sqlerr(__file__, __line__);
    }
    //== Set higspeed Upload Enable / Disable
    if ((isset($_POST['highspeed'])) && (($highspeed = $_POST['highspeed']) != $user['highspeed'])) {
        if ($highspeed == 'yes') {
            $modcomment = get_date(TIME_NOW, 'DATE', 1) . $lang['modtask_highs_enable_by'] . $CURUSER['username'] . ".\n" . $modcomment;
            $subject = sqlesc($lang['modtask_highs_status']);
            $msg = sqlesc($lang['modtask_highs_set'] . $username . $lang['modtask_highs_msg']);
            $added = sqlesc(TIME_NOW);
            sql_query("INSERT INTO messages (sender, receiver, msg, subject, added) VALUES (0, ".sqlesc($userid).", $msg, $subject, $added)") or sqlerr(__file__, __line__);
        } elseif ($highspeed == 'no') {
            $modcomment = get_date(TIME_NOW, 'DATE', 1) . $lang['modtask_highs_disable_by'] . $CURUSER['username'] . ".\n" . $modcomment;
            $subject = sqlesc($lang['modtask_highs_status']);
            $msg = sqlesc($lang['modtask_highs_disabled'] . $username . $lang['modtask_highs_pm'] . $username . $lang['modtask_highs_reason']);
            $added = sqlesc(TIME_NOW);
            sql_query("INSERT INTO messages (sender, receiver, msg, subject, added) VALUES (0, ".sqlesc($userid).", $msg, $subject, $added)") or sqlerr(__file__, __line__);
        } else die(); //== Error
        $updateset[] = "highspeed = " . sqlesc($highspeed);
        $useredit['update'][] = $lang['modtask_highs_enabled'] . $highspeed . '';
        $curuser_cache['highspeed'] = $highspeed;
        $user_cache['highspeed'] = $highspeed;
    }
    //== Set can leech
    if ((isset($_POST['can_leech'])) && (($can_leech = $_POST['can_leech']) != $user['can_leech'])) {
        if ($can_leech == 1) {
            $modcomment = get_date(TIME_NOW, 'DATE', 1) . $lang['modtask_canleech_on_by'] . $CURUSER['username'] . ".\n" . $modcomment;
            $subject = sqlesc($lang['modtask_canleech_status']);
            $msg = sqlesc($lang['modtask_canleech_rights_on'] . $username . ".");
            $added = sqlesc(TIME_NOW);
            sql_query("INSERT INTO messages (sender, receiver, msg, subject, added) VALUES (0, ".sqlesc($userid).", $msg, $subject, $added)") or sqlerr(__file__, __line__);
        } elseif ($can_leech == 0) {
            $modcomment = get_date(TIME_NOW, 'DATE', 1) . $lang['modtask_canleech_off_by'] . $CURUSER['username'] . ".\n" . $modcomment;
            $subject = sqlesc($lang['modtask_canleech_status']);
            $msg = sqlesc($lang['modtask_canleech_ability'] . $username . $lang['modtask_canleech_pm'] . $username . $lang['modtask_canleech_reason']);
            $added = sqlesc(TIME_NOW);
            sql_query("INSERT INTO messages (sender, receiver, msg, subject, added) VALUES (0, ".sqlesc($userid).", $msg, $subject, $added)") or sqlerr(__file__, __line__);
        } else die(); //== Error
        $updateset[] = "can_leech = " . sqlesc($can_leech);
        $useredit['update'][] = $lang['modtask_canleech_edited'] . $can_leech . '';
        $curuser_cache['can_leech'] = $can_leech;
        $user_cache['can_leech'] = $can_leech;
    }
    //=== Wait time
    if ((isset($_POST['wait_time'])) && (($wait_time = $_POST['wait_time']) != $user['wait_time'])) {
        $modcomment = get_date(TIME_NOW, 'DATE', 1) . "{$lang['modtask_wait_set']} $wait_time{$lang['modtask_gl_was']}" . (int)$user['wait_time'] . $lang['modtask_gl_by'] . $CURUSER['username'] . ".\n" . $modcomment;
        $updateset[] = 'wait_time = ' . sqlesc($wait_time);
        $useredit['update'][] =$lang['modtask_wait_yes'];
        $curuser_cache['wait_time'] = $wait_time;
        $user_cache['wait_time'] = $wait_time;
    }
    //=== Peers limit
    if ((isset($_POST['peers_limit'])) && (($peers_limit = $_POST['peers_limit']) != $user['peers_limit'])) {
        $modcomment = get_date(TIME_NOW, 'DATE', 1) . "{$lang['modtask_peer_limit']} $peers_limit{$lang['modtask_gl_was']}" . (int)$user['peers_limit'] . $lang['modtask_gl_by'] . $CURUSER['username'] . ".\n" . $modcomment;
        $updateset[] = 'peers_limit = ' . sqlesc($peers_limit);
        $useredit['update'][] = $lang['modtask_peer_adjusted'];
        $curuser_cache['peers_limit'] = $peers_limit;
        $user_cache['peers_limit'] = $peers_limit;
    }
    //=== Torrents limit
    if ((isset($_POST['torrents_limit'])) && (($torrents_limit = $_POST['torrents_limit']) != $user['torrents_limit'])) {
        $modcomment = get_date(TIME_NOW, 'DATE', 1) . "{$lang['modtask_torrent_limit']} $torrents_limit{$lang['modtask_gl_was']}" . (int)$user['torrents_limit'] . $lang['modtask_gl_by'] . $CURUSER['username'] . ".\n" . $modcomment;
        $updateset[] = 'torrents_limit = ' . sqlesc($torrents_limit);
        $useredit['update'][] = $lang['modtask_torrent_adjusted'];
        $curuser_cache['torrents_limit'] = $torrents_limit;
        $user_cache['torrents_limit'] = $torrents_limit;
    }
    //== Parked accounts
    if ((isset($_POST['parked'])) && (($parked = $_POST['parked']) != $user['parked'])) {
        if ($parked == 'yes') {
            $modcomment = get_date(TIME_NOW, 'DATE', 1) . $lang['modtask_parked_by' ] . $CURUSER['username'] . ".\n" . $modcomment;
        } elseif ($parked == 'no') {
            $modcomment = get_date(TIME_NOW, 'DATE', 1) . $lang['modtask_unparked_by' ] . $CURUSER['username'] . ".\n" . $modcomment;
        } else stderr("{$lang['modtask_user_error']}", "{$lang['modtask_try_again']}");
        $updateset[] = "parked = " . sqlesc($parked);
        $useredit['update'][] = $lang['modtask_parked_acc' ] . $parked . '';
        $curuser_cache['parked'] = $parked;
        $user_cache['parked'] = $parked;
    }
    //== end parked
    //=== suspend account
    if ((isset($_POST['suspended'])) && (($suspended = $_POST['suspended']) != ($suspended = $user['suspended']))) {
        $suspended_reason = $_POST['suspended_reason'];
        if (!$suspended_reason) stderr($lang['modtask_error'], $lang['modtask_suspend_err']);
        if ($_POST['suspended'] === 'yes') {
            $modcomment = get_date(TIME_NOW, 'DATE', 1) . $lang['modtask_suspend_by'] . $CURUSER['username'] . $lang['modtask_suspend_reason'] . sqlesc($suspended_reason) . ".\n" . $modcomment;
            $updateset[] = "downloadpos = '0'";
            $updateset[] = "uploadpos = '0'";
            $updateset[] = "forum_post = 'no'";
            $updateset[] = "invite_on = 'no'";
            $curuser_cache['downloadpos'] = '0';
            $user_cache['downloadpos'] = '0';
            $curuser_cache['uploadpos'] = '0';
            $user_cache['uploadpos'] = '0';
            $curuser_cache['forum_post'] = 'no';
            $user_cache['forum_post'] = 'no';
            $curuser_cache['invite_on'] = 'no';
            $user_cache['invite_on'] = 'no';
            $useredit['update'][] = $lang['modtask_suspended_yes'];
            $subject = sqlesc($lang['modtask_suspend_title']);
            $msg = sqlesc($lang['modtask_suspend_msg'] . $username . ".\n[b]{$lang['modtask_suspend_msg1']}[/b]\n" . sqlesc($suspended_reason) . ".\n\n{$lang['modtask_suspend_msg2']}\n\n{$lang['modtask_suspend_msg3']}\n\n{$lang['modtask_suspend_msg4']}\n" . $INSTALLER09['site_name'] . $lang['modtask_suspend_msg5']);
            //=== post to forum
            $body = sqlesc("{$lang['modtask_suspend_acc_for']}[b][url=" . $INSTALLER09['baseurl'] . "/userdetails.php?id=" . (int)$user["id"] . "]" . htmlsafechars($user["username"]) . "[/url][/b]{$lang['modtask_suspend_has_by']}" . $CURUSER['username'] . "\n\n [b]{$lang['modtask_suspend_reason']}[/b]\n " . sqlesc($suspended_reason) . ".\n");
            auto_post($subject, $body);
        }
        if ($_POST['suspended'] === 'no') {
            $modcomment = get_date(TIME_NOW, 'DATE', 1) . $lang['modtask_unsuspend_by'] . $CURUSER['username'] . $lang['modtask_suspend_reason'] . sqlesc($suspended_reason) . ".\n" . $modcomment;
            $updateset[] = "downloadpos = '1'";
            $updateset[] = "uploadpos = '1'";
            $updateset[] = "forum_post = 'yes'";
            $updateset[] = "invite_on = 'yes'";
            $useredit['update'][] = $lang['modtask_suspended_no'];
            $subject = sqlesc($lang['modtask_unsuspend_title']);
            $msg = sqlesc($lang['modtask_unsuspend_msg'] . $username . ".\n[b]{$lang['modtask_suspend_msg1']}[/b]\n" . sqlesc($suspended_reason) . ". \n\n{$lang['modtask_suspend_msg4']}\n" . $INSTALLER09['site_name'] . $lang['modtask_suspend_msg5']);
        }
        $updateset[] = 'suspended = ' . sqlesc($_POST['suspended']);
        $curuser_cache['suspended'] = $_POST['suspended'];
        $user_cache['suspended'] = $_POST['suspended'];
        $curuser_cache['downloadpos'] = '1';
        $user_cache['downloadpos'] = '1';
        $curuser_cache['uploadpos'] = '1';
        $user_cache['uploadpos'] = '1';
        $curuser_cache['forum_post'] = 'yes';
        $user_cache['forum_post'] = 'yes';
        $curuser_cache['invite_on'] = 'yes';
        $user_cache['invite_on'] = 'yes';
        $added = TIME_NOW;
        sql_query("INSERT INTO messages (sender, subject, receiver, added, msg) VALUES(0, $subject, $userid, $added, $msg)");
    }
    //=== hit and runs
    if ((isset($_POST['hit_and_run_total'])) && (($hit_and_run_total = $_POST['hit_and_run_total']) != $user['hit_and_run_total'])) {
        $modcomment = get_date(TIME_NOW, 'DATE', 1) . "{$lang['modtask_hit_run_set']} $hit_and_run_total{$lang['modtask_gl_was']}" . (int)$user['hit_and_run_total'] . $lang['modtask_gl_by'] . $CURUSER['username'] . ".\n" . $modcomment;
        $updateset[] = 'hit_and_run_total = ' . sqlesc($hit_and_run_total);
        $useredit['update'][] = $lang['modtask_hit_run_adjusted'];
        $curuser_cache['hit_and_run_total'] = $hit_and_run_total;
        $user_cache['hit_and_run_total'] = $hit_and_run_total;
    }
    //=== Forum Post Enable / Disable
    if ((isset($_POST['forum_post'])) && (($forum_post = $_POST['forum_post']) != $user['forum_post'])) {
        if ($forum_post == 'yes') {
            $modcomment = get_date(TIME_NOW, 'DATE', 1) . $lang['modtask_post_en_by'] . $CURUSER['username'] . ".\n" . $modcomment;
            $msg = sqlesc($lang['modtask_post_give_back'] . $username . $lang['modtask_post_forum_again']);
        } else {
            $modcomment = get_date(TIME_NOW, 'DATE', 1) . $lang['modtask_post_dis_by'] . $CURUSER['username'] . ".\n" . $modcomment;
            $msg = sqlesc($lang['modtask_post_rem_by'] . $username . $lang['modtask_post_pm'] . $username . $lang['modtask_post_reason']);
        }
        sql_query('INSERT INTO messages (sender, receiver, msg, subject, added) VALUES (0, ' . sqlesc($user['id']) . ', ' . $msg . ', \' ' . $lang['modtask_post_rights'] .' \', ' . TIME_NOW . ')');
        $updateset[] = 'forum_post = ' . sqlesc($forum_post);
        $useredit['update'][] = $lang['modtask_post_enabled'] . $forum_post . '';
        $curuser_cache['forum_post'] = $forum_post;
        $user_cache['forum_post'] = $forum_post;
    }
     //=== signature rights
    if ((isset($_POST['signature_post'])) && (($signature_post = $_POST['signature_post']) != $user['signature_post'])) {
        if ($signature_post == 'no') {
            $modcomment = get_date(TIME_NOW, 'DATE', 1) . $lang['modtask_signature_rights_off'] . $CURUSER['username'] . ".\n" . $modcomment;
            $msg = sqlesc($lang['modtask_signature_rights_off_by'] . $username . $lang['modtask_signature_rights_pm']);
        } else {
            $modcomment = get_date(TIME_NOW, 'DATE', 1) . $lang['modtask_signature_rights_on'] . $CURUSER['username'] . ".\n" . $modcomment;
            $msg = sqlesc($lang['modtask_signature_rights_on_by'] . $username . '.');
        }
        sql_query('INSERT INTO messages (sender, receiver, msg, subject, added) VALUES (0, ' . sqlesc($user['id']) . ', ' . $msg . ', \' ' . $lang['modtask_signature_rights'] . ' \', ' . TIME_NOW . ')');
        $updateset[] = 'signature_post = ' . sqlesc($signature_post);
        $useredit['update'][] = $lang['modtask_signature_rights_enabled'] . $signature_post .'';
        $curuser_cache['signature_post'] = $signature_post;
        $user_cache['signature_post'] = $signature_post;
    }
    //=== avatar rights
    if ((isset($_POST['avatar_rights'])) && (($avatar_rights = $_POST['avatar_rights']) != $user['avatar_rights'])) {
        if ($avatar_rights == 'no') {
            $modcomment = get_date(TIME_NOW, 'DATE', 1) . $lang['modtask_avatar_rights_off'] . $CURUSER['username'] . ".\n" . $modcomment;
        } else {
            $modcomment = get_date(TIME_NOW, 'DATE', 1) . $lang['modtask_avatar_rights_on'] . $CURUSER['username'] . ".\n" . $modcomment;
        }
        $updateset[] = 'avatar_rights = ' . sqlesc($avatar_rights);
        $useredit['update'][] = $lang['modtask_avatar_rights_enabled'] . $avatar_rights . '';
        $curuser_cache['avatar_rights'] = $avatar_rights;
        $user_cache['avatar_rights'] = $avatar_rights;
    }
    //=== offensive avatar
    if ((isset($_POST['offensive_avatar'])) && (($offensive_avatar = $_POST['offensive_avatar']) != $user['offensive_avatar'])) {
        if ($offensive_avatar == 'no') {
            $modcomment = get_date(TIME_NOW, 'DATE', 1) . $lang['modtask_offensive_no'] . $CURUSER['username'] . ".\n" . $modcomment;
            $msg = sqlesc($lang['modtask_offensive_no_by'] . $username);
        } else {
            $modcomment = get_date(TIME_NOW, 'DATE', 1) . $lang['modtask_offensive_yes'] . $CURUSER['username'] . ".\n" . $modcomment;
            $msg = sqlesc($lang['modtask_offensive_yes_by'] . $username . $lang['modtask_offensive_pm']);
        }
        sql_query('INSERT INTO messages (sender, receiver, msg, subject, added) VALUES (0, ' . sqlesc($user['id']) . ', ' . $msg . ', \' ' . $lang['modtask_offensive_avatar'] . ' \', ' . TIME_NOW . ')');
        $updateset[] = 'offensive_avatar = ' . sqlesc($offensive_avatar);
        $useredit['update'][] = $lang['modtask_offensive_enabled'] . $offensive_avatar . '';
        $curuser_cache['offensive_avatar'] = $offensive_avatar;
        $user_cache['offensive_avatar'] = $offensive_avatar;
    }
    //=== view offensive avatar
    if ((isset($_POST['view_offensive_avatar'])) && (($view_offensive_avatar = $_POST['view_offensive_avatar']) != $user['view_offensive_avatar'])) {
        if ($view_offensive_avatar == 'no') {
            $modcomment = get_date(TIME_NOW, 'DATE', 1) . $lang['modtask_viewoffensive_no'] . $CURUSER['username'] . ".\n" . $modcomment;
        } else {
            $modcomment = get_date(TIME_NOW, 'DATE', 1) . $lang['modtask_viewoffensive_yes'] . $CURUSER['username'] . ".\n" . $modcomment;
        }
        $updateset[] = 'view_offensive_avatar = ' . sqlesc($view_offensive_avatar);
        $useredit['update'][] = $lang['modtask_viewoffensive_enabled'] . $view_offensive_avatar . '';
        $curuser_cache['view_offensive_avatar'] = $view_offensive_avatar;
        $user_cache['view_offensive_avatar'] = $view_offensive_avatar;
    }
    //=== paranoia
    if ((isset($_POST['paranoia'])) && (($paranoia = $_POST['paranoia']) != $user['paranoia'])) {
        $modcomment = get_date(TIME_NOW, 'DATE', 1) . $lang['modtask_paranoia_changed_to'] . intval($_POST['paranoia']) . $lang['modtask_gl_from'] . intval($user['paranoia']) . $lang['modtask_gl_by'] . $CURUSER['username'] . ".\n" . $modcomment;
        $updateset[] = 'paranoia = ' . sqlesc($paranoia);
        $useredit['update'][] = $lang['modtask_paranoia_changed'];
        $curuser_cache['paranoia'] = $paranoia;
        $user_cache['paranoia'] = $paranoia;
    }
    //=== website
    if ((isset($_POST['website'])) && (($website = $_POST['website']) != $user['website'])) {
        $modcomment = get_date(TIME_NOW, 'DATE', 1) . $lang['modtask_website_changed_to'] . strip_tags($_POST['website']) . $lang['modtask_gl_from'] . htmlsafechars($user['website']) . $lang['modtask_gl_by'] . $CURUSER['username'] . ".\n" . $modcomment;
        $updateset[] = 'website = ' . sqlesc($website);
        $useredit['update'][] = $lang['modtask_website_changed'];
        $curuser_cache['website'] = $website;
        $user_cache['website'] = $website;
    }
    //=== google_talk
    if ((isset($_POST['google_talk'])) && (($google_talk = $_POST['google_talk']) != $user['google_talk'])) {
        $modcomment = get_date(TIME_NOW, 'DATE', 1) . $lang['modtask_gtalk_changed_to'] . strip_tags($_POST['google_talk']) . $lang['modtask_gl_from'] . htmlsafechars($user['google_talk']) . $lang['modtask_gl_by'] . $CURUSER['username'] . ".\n" . $modcomment;
        $updateset[] = 'google_talk = ' . sqlesc($google_talk);
        $useredit['update'][] = $lang['modtask_gtalk_changed'];
        $curuser_cache['google_talk'] = $google_talk;
        $user_cache['google_talk'] = $google_talk;
    }
    //=== msn
    if ((isset($_POST['msn'])) && (($msn = $_POST['msn']) != $user['msn'])) {
        $modcomment = get_date(TIME_NOW, 'DATE', 1) . $lang['modtask_msn_changed_to'] . strip_tags($_POST['msn']) . $lang['modtask_gl_from'] . htmlsafechars($user['msn']) . $lang['modtask_gl_by'] . $CURUSER['username'] . ".\n" . $modcomment;
        $updateset[] = 'msn = ' . sqlesc($msn);
        $useredit['update'][] = $lang['modtask_msn_changed'];
        $curuser_cache['msn'] = $msn;
        $user_cache['msn'] = $msn;
    }
    //=== aim
    if ((isset($_POST['aim'])) && (($aim = $_POST['aim']) != $user['aim'])) {
        $modcomment = get_date(TIME_NOW, 'DATE', 1) . $lang['modtask_aim_changed_to'] . strip_tags($_POST['aim']) . $lang['modtask_gl_from'] . htmlsafechars($user['aim']) . $lang['modtask_gl_by'] . $CURUSER['username'] . ".\n" . $modcomment;
        $updateset[] = 'aim = ' . sqlesc($aim);
        $useredit['update'][] = $lang['modtask_aim_changed'];
        $curuser_cache['aim'] = $aim;
        $user_cache['aim'] = $aim;
    }
    //=== yahoo
    if ((isset($_POST['yahoo'])) && (($yahoo = $_POST['yahoo']) != $user['yahoo'])) {
        $modcomment = get_date(TIME_NOW, 'DATE', 1) . $lang['modtask_yahoo_changed_to'] . strip_tags($_POST['yahoo']) . $lang['modtask_gl_from'] . htmlsafechars($user['yahoo']) . $lang['modtask_gl_by'] . $CURUSER['username'] . ".\n" . $modcomment;
        $updateset[] = 'yahoo = ' . sqlesc($yahoo);
        $useredit['update'][] = $lang['modtask_yahoo_changed'];
        $curuser_cache['yahoo'] = $yahoo;
        $user_cache['yahoo'] = $yahoo;
    }
    //=== icq
    if ((isset($_POST['icq'])) && (($icq = $_POST['icq']) != $user['icq'])) {
        $modcomment = get_date(TIME_NOW, 'DATE', 1) . $lang['modtask_icq_changed_to'] . strip_tags($_POST['icq']) . $lang['modtask_gl_from'] . htmlsafechars($user['icq']) . $lang['modtask_gl_by'] . $CURUSER['username'] . ".\n" . $modcomment;
        $updateset[] = 'icq = ' . sqlesc($icq);
        $useredit['update'][] = $lang['modtask_icq_changed'];
        $curuser_cache['icq'] = $icq;
        $user_cache['icq'] = $icq;
    }
     //forum moderator mod by putyn
    if(isset($_POST["forum_mod"]) && ($forum_mod = $_POST["forum_mod"]) != $user["forum_mod"]) {
	$whatm = ($forum_mod == "yes" ? "added " : "removed");
	if($forum_mod == "no")
	$updateset[] = "forums_mod = ''";
        $curuser_cache['forums_mod'] = '';
        $user_cache['forums_mod'] = '';	
	$updateset[] = "forum_mod=".sqlesc($forum_mod);
        $curuser_cache['forum_mod'] = $forum_mod;
        $user_cache['forum_mod'] = $forum_mod;
        $mc1 -> delete_value('forummods');
	$modcomment = get_date( TIME_NOW, 'DATE', 1 ) . " ".$CURUSER["username"]." ".$whatm." forum moderator rights\n" . $modcomment;
        }

        $forums = isset($_POST["forums"]) ? $_POST["forums"] : "";
    if(!empty($forums) && sizeof($forums)>0 && $forum_mod == "yes") {
	$foo = "[".join("][",$forums)."]";
	$q = sql_query("SELECT id FROM topics WHERE forum_id IN (".join(",",$forums).") ") or sqlerr(__FILE__, __LINE__);
		while($a = mysqli_fetch_assoc($q))
		$temp[] = $a["id"];
		topicmods($user["id"],"[".join("][",$temp)."]");
	$updateset[] = "forums_mod =".sqlesc($foo);
        $curuser_cache['forums_mod'] = $foo;
        $user_cache['forums_mod'] = $foo;
        $mc1 -> delete_value('forummods');
    }
    //== Add ModComment... (if we changed stuff we update otherwise we dont include this..)
    if (($CURUSER['class'] == UC_MAX && ($user['modcomment'] != $_POST['modcomment'] || $modcomment != $_POST['modcomment'])) || ($CURUSER['class'] < UC_MAX && $modcomment != $user['modcomment'])) $updateset[] = "modcomment = " . sqlesc($modcomment);
    $user_stats_cache['modcomment'] = $modcomment;
    $stats_cache['modcomment'] = $modcomment;
    //== Memcache - delete the keys
    $mc1->delete_value('inbox_new_' . $userid);
    $mc1->delete_value('inbox_new_sb_' . $userid);
    if ($curuser_cache) {
        $mc1->begin_transaction('MyUser_' . $userid);
        $mc1->update_row(false, $curuser_cache);
        $mc1->commit_transaction($INSTALLER09['expires']['curuser']);
    }
    if ($user_cache) {
        $mc1->begin_transaction('user' . $userid);
        $mc1->update_row(false, $user_cache);
        $mc1->commit_transaction($INSTALLER09['expires']['user_cache']);
    }
    if ($stats_cache) {
        $mc1->begin_transaction('userstats_' . $userid);
        $mc1->update_row(false, $stats_cache);
        $mc1->commit_transaction($INSTALLER09['expires']['u_stats']);
    }
    if ($user_stats_cache) {
        $mc1->begin_transaction('user_stats_' . $userid);
        $mc1->update_row(false, $user_stats_cache);
        $mc1->commit_transaction($INSTALLER09['expires']['user_stats']);
    }
    if (sizeof($updateset) > 0) sql_query("UPDATE users SET " . implode(", ", $updateset) . " WHERE id=" . sqlesc($userid)) or sqlerr(__FILE__, __LINE__);
    status_change($userid);
    forummods(true);
    if ((isset($_POST['class'])) && (($class = $_POST['class']) != $user['class'])) {
        write_staffs();
    }
    if (sizeof($setbits) > 0 || sizeof($clrbits) > 0) sql_query('UPDATE users SET opt1 = ((opt1 | ' . $setbits . ') & ~' . $clrbits . '), opt2 = ((opt2 | ' . $setbits . ') & ~' . $clrbits . ') WHERE id = ' . sqlesc($userid)) or sqlerr(__file__, __line__);
    // grab current data
    $res = sql_query('SELECT opt1, opt2 FROM users WHERE id = ' . sqlesc($userid) . ' LIMIT 1') or sqlerr(__file__, __line__);
    $row = mysqli_fetch_assoc($res);
    $row['opt1'] = $row['opt1'];
    $row['opt2'] = $row['opt2'];
    $mc1->begin_transaction('MyUser_' . $userid);
    $mc1->update_row(false, array(
        'opt1' => $row['opt1'],
        'opt2' => $row['opt2']
    ));
    $mc1->commit_transaction($INSTALLER09['expires']['curuser']);
    $mc1->begin_transaction('user_' . $userid);
    $mc1->update_row(false, array(
        'opt1' => $row['opt1'],
        'opt2' => $row['opt2']
    ));
    $mc1->commit_transaction($INSTALLER09['expires']['user_cache']);
    //== 09 Updated Sysop log - thanks to pdq
    write_info("{$lang['modtask_sysop_user_acc']} $userid (<a href='userdetails.php?id=$userid'>" . htmlsafechars($user['username']) . "</a>)\n{$lang['modtask_sysop_thing']}" . join(', ', $useredit['update']) . "{$lang['modtask_gl_by']}<a href='userdetails.php?id={$CURUSER['id']}'>{$CURUSER['username']}</a>");
    $returnto = htmlsafechars($_POST["returnto"]);
    header("Location: {$INSTALLER09['baseurl']}/$returnto");
    stderr("{$lang['modtask_user_error']}", "{$lang['modtask_try_again']}");
}
stderr("{$lang['modtask_user_error']}", "{$lang['modtask_no_idea']}");
?>
