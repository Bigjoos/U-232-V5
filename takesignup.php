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
require_once (CLASS_DIR . 'page_verify.php');
require_once (INCL_DIR . 'password_functions.php');
require_once (INCL_DIR . 'bbcode_functions.php');
require_once (INCL_DIR . 'function_bemail.php');
dbconn();
global $CURUSER;
if (!$CURUSER) {
    get_template();
}
$lang = array_merge(load_language('global') , load_language('takesignup'));
if (!$INSTALLER09['openreg']) stderr($lang['stderr_errorhead'], "{$lang['takesignup_invite_only']}<a href='" . $INSTALLER09['baseurl'] . "/invite_signup.php'><b>&nbsp;{$lang['takesignup_here']}</b></a>");
$res = sql_query("SELECT COUNT(id) FROM users") or sqlerr(__FILE__, __LINE__);
$arr = mysqli_fetch_row($res);
if ($arr[0] >= $INSTALLER09['maxusers']) stderr($lang['takesignup_error'], $lang['takesignup_limit']);
$newpage = new page_verify();
$newpage->check('tesu');
if (!mkglobal('wantusername:wantpassword:passagain:email' . ($INSTALLER09['captcha_on'] ? ":captchaSelection:" : ":") . 'submitme:passhint:hintanswer:country')) stderr($lang['takesignup_user_error'], $lang['takesignup_form_data']);
if ($submitme != 'X') stderr($lang['takesignup_x_head'], $lang['takesignup_x_body']);
if ($INSTALLER09['captcha_on']) {
    if (empty($captchaSelection) || $_SESSION['simpleCaptchaAnswer'] != $captchaSelection) {
        header("Location: {$INSTALLER09['baseurl']}/signup.php");
        exit;
    }
}
function validusername($username)
{
    global $lang;
    if ($username == "") return false;
    $namelength = strlen($username);
    if (($namelength < 3) OR ($namelength > 32)) {
        stderr($lang['takesignup_user_error'], $lang['takesignup_username_length']);
    }
    // The following characters are allowed in user names
    $allowedchars = $lang['takesignup_allowed_chars'];
    for ($i = 0; $i < $namelength; ++$i) {
        if (strpos($allowedchars, $username[$i]) === false) return false;
    }
    return true;
}
if (empty($wantusername) || empty($wantpassword) || empty($email) || empty($passhint) || empty($hintanswer) || empty($country)) stderr($lang['takesignup_user_error'], $lang['takesignup_blank']);
if (!blacklist($wantusername)) stderr($lang['takesignup_user_error'], sprintf($lang['takesignup_badusername'], htmlsafechars($wantusername)));
if ($wantpassword != $passagain) stderr($lang['takesignup_user_error'], $lang['takesignup_nomatch']);
if (strlen($wantpassword) < 6) stderr($lang['takesignup_user_error'], $lang['takesignup_pass_short']);
if (strlen($wantpassword) > 40) stderr($lang['takesignup_user_error'], $lang['takesignup_pass_long']);
if ($wantpassword == $wantusername) stderr($lang['takesignup_user_error'], $lang['takesignup_same']);
if (!validemail($email)) stderr($lang['takesignup_user_error'], $lang['takesignup_validemail']);
if (!validusername($wantusername)) stderr($lang['takesignup_user_error'], $lang['takesignup_invalidname']);
if (!(isset($_POST['day']) || isset($_POST['month']) || isset($_POST['year']))) stderr($lang['takesignup_error'], $lang['takesignup_birthday']);
if (checkdate($_POST['month'], $_POST['day'], $_POST['year'])) $birthday = $_POST['year'] . '-' . $_POST['month'] . '-' . $_POST['day'];
else stderr($lang['takesignup_error'], $lang['takesignup_correct_birthday']);
if ((date('Y') - $_POST['year']) < 17) stderr($lang['takesignup_error'], $lang['takesignup_yearsold']);
if (!(isset($_POST['country']))) stderr($lang['takesignup_error'], $lang['takesignup_country']);
$country = (((isset($_POST['country']) && is_valid_id($_POST['country'])) ? intval($_POST['country']) : 0));
$gender = isset($_POST['gender']) && isset($_POST['gender']) ? htmlsafechars($_POST['gender']) : '';
// make sure user agrees to everything...
if ($_POST["rulesverify"] != "yes" || $_POST["faqverify"] != "yes" || $_POST["ageverify"] != "yes") stderr($lang['takesignup_failed'], $lang['takesignup_qualify']);
// check if email addy is already in use
$a = (mysqli_fetch_row(sql_query("SELECT COUNT(id) FROM users WHERE email=" . sqlesc($email)))) or sqlerr(__FILE__, __LINE__);
if ($a[0] != 0) stderr($lang['takesignup_user_error'], $lang['takesignup_email_used']);
//=== check if ip addy is already in use
if ($INSTALLER09['dupeip_check_on']) {
    $c = (mysqli_fetch_row(sql_query("SELECT COUNT(id) FROM users WHERE ip=" . sqlesc($_SERVER['REMOTE_ADDR'])))) or sqlerr(__FILE__, __LINE__);
    if ($c[0] != 0) stderr($lang['takesignup_error'], "{$lang['takesignup_ip']}&nbsp;" . htmlsafechars($_SERVER['REMOTE_ADDR']) . "&nbsp;{$lang['takesignup_ip_used']}");
}
// TIMEZONE STUFF
if (isset($_POST["user_timezone"]) && preg_match('#^\-?\d{1,2}(?:\.\d{1,2})?$#', $_POST['user_timezone'])) {
    $time_offset = sqlesc($_POST['user_timezone']);
} else {
    $time_offset = isset($INSTALLER09['time_offset']) ? sqlesc($INSTALLER09['time_offset']) : '0';
}
// have a stab at getting dst parameter?
$dst_in_use = localtime(TIME_NOW + ((int)$time_offset * 3600) , true);
// TIMEZONE STUFF END
$secret = mksecret();
$wantpasshash = make_passhash($secret, md5($wantpassword));
$editsecret = (!$arr[0] ? "" : EMAIL_CONFIRM ? make_passhash_login_key() : "");
$wanthintanswer = md5($hintanswer);
$user_frees = (XBT_TRACKER == true ? 0 : TIME_NOW + 14 * 86400);
check_banned_emails($email);
$psecret = $editsecret;
//$emails = encrypt_email($email);

$ret = sql_query("INSERT INTO users (username, passhash, secret, editsecret, birthday, country, gender, stylesheet, passhint, hintanswer, email, status, " . (!$arr[0] ? "class, " : "") . "added, last_access, time_offset, dst_in_use, free_switch) VALUES (" . implode(",", array_map("sqlesc", array(
    $wantusername,
    $wantpasshash,
    $secret,
    $editsecret,
    $birthday,
    $country,
    $gender,
    $INSTALLER09['stylesheet'],
    $passhint,
    $wanthintanswer,
    $email,
    (!$arr[0] || !EMAIL_CONFIRM ? 'confirmed' : 'pending')
))) . ", " . (!$arr[0] ? UC_SYSOP . ", " : "") . "" . TIME_NOW . "," . TIME_NOW . " , $time_offset, {$dst_in_use['tm_isdst']}, $user_frees)") or sqlerr(__FILE__, __LINE__);

$mc1->delete_value('birthdayusers');

$message = "{$lang['takesignup_welcome']} {$INSTALLER09['site_name']} {$lang['takesignup_member']} ".htmlsafechars($wantusername)."";

if (!$ret) {
    if (((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_errno($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_errno()) ? $___mysqli_res : false)) == 1062) stderr($lang['takesignup_user_error'], $lang['takesignup_user_exists']);
}

$id = ((is_null($___mysqli_res = mysqli_insert_id($GLOBALS["___mysqli_ston"]))) ? false : $___mysqli_res);

sql_query("INSERT INTO usersachiev (id, username) VALUES (" . sqlesc($id) . ", " . sqlesc($wantusername) . ")") or sqlerr(__FILE__, __LINE__);

if (!$arr[0]) {
    write_staffs();
}

//==New member pm
$added = TIME_NOW;
$subject = sqlesc($lang['takesignup_msg_subject']);
$msg = sqlesc("{$lang['takesignup_hey']} " . htmlsafechars($wantusername) . "{$lang['takesignup_msg_body0']} {$INSTALLER09['site_name']} {$lang['takesignup_msg_body1']}");
sql_query("INSERT INTO messages (sender, subject, receiver, msg, added) VALUES (0, $subject, " . sqlesc($id) . ", $msg, $added)") or sqlerr(__FILE__, __LINE__);

//==End new member pm
$latestuser_cache['id'] = (int)$id;
$latestuser_cache['username'] = $wantusername;
$latestuser_cache['class'] = 0;
$latestuser_cache['donor'] = 'no';
$latestuser_cache['warned'] = 0;
$latestuser_cache['enabled'] = 'yes';
$latestuser_cache['chatpost'] = 1;
$latestuser_cache['leechwarn'] = 0;
$latestuser_cache['pirate'] = 0;
$latestuser_cache['king'] = 0;
$mc1->cache_value('latestuser', $latestuser_cache, $INSTALLER09['expires']['latestuser']);

write_log("User account " . (int)$id . " (" . htmlsafechars($wantusername) . ") was created");

if ($INSTALLER09['autoshout_on'] == 1) {
    autoshout($message);
    $mc1->delete_value('shoutbox_');
}

$body = str_replace(array(
    '<#SITENAME#>',
    '<#USEREMAIL#>',
    '<#IP_ADDRESS#>',
    '<#REG_LINK#>'
) , array(
    $INSTALLER09['site_name'],
    $email,
    $_SERVER['REMOTE_ADDR'],
    "{$INSTALLER09['baseurl']}/confirm.php?id=$id&secret=$psecret"
) , $lang['takesignup_email_body']);

if ($arr[0] || EMAIL_CONFIRM) 
mail($email, "{$INSTALLER09['site_name']} {$lang['takesignup_confirm']}", $body, "{$lang['takesignup_from']} {$INSTALLER09['site_email']}");
else 
logincookie($id, $wantpasshash);
header("Refresh: 0; url=ok.php?type=". (!$arr[0]? "sysop" : (EMAIL_CONFIRM ? "signup&email=" . urlencode($email) : "confirm")));
?>
