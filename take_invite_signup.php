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
require_once (INCL_DIR . 'password_functions.php');
require_once (INCL_DIR . 'function_bemail.php');
require_once (CLASS_DIR . 'page_verify.php');
dbconn();
global $CURUSER;
if (!$CURUSER) {
    get_template();
}
$lang = array_merge(load_language('global') , load_language('takesignup'));
$newpage = new page_verify();
$newpage->check('tkIs');
$res = sql_query("SELECT COUNT(id) FROM users") or sqlerr(__FILE__, __LINE__);
$arr = mysqli_fetch_row($res);
if ($arr[0] >= $INSTALLER09['invites']) stderr($lang['stderr_errorhead'], sprintf($lang['stderr_ulimit'], $INSTALLER09['invites']));
if (!$INSTALLER09['openreg_invites']) stderr('Sorry', 'Invite Signups are closed presently');
if (!mkglobal('wantusername:wantpassword:passagain:email:invite' . ($INSTALLER09['captcha_on'] ? ":captchaSelection:" : ":") . 'submitme:passhint:hintanswer')) stderr("Oops", "Missing form data - You must fill all fields");
if ($submitme != 'X') stderr('Ha Ha', 'You Missed, You plonker !');
if ($INSTALLER09['captcha_on']) {
    if (empty($captchaSelection) || $_SESSION['simpleCaptchaAnswer'] != $captchaSelection) {
        header('Location: invite_signup.php');
        exit();
    }
}
function validusername($username)
{
    if ($username == "") return false;
    // The following characters are allowed in user names
    $allowedchars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    for ($i = 0; $i < strlen($username); ++$i) if (strpos($allowedchars, $username[$i]) === false) return false;
    return true;
}
if (empty($wantusername) || empty($wantpassword) || empty($email) || empty($invite) || empty($passhint) || empty($hintanswer)) stderr("Error", "Don't leave any fields blank.");
if (!blacklist($wantusername)) stderr($lang['takesignup_user_error'], sprintf($lang['takesignup_badusername'], htmlsafechars($wantusername)));
if (strlen($wantusername) > 12) stderr("Error", "Sorry, username is too long (max is 12 chars)");
if ($wantpassword != $passagain) stderr("Error", "The passwords didn't match! Must've typoed. Try again.");
if (strlen($wantpassword) < 6) stderr("Error", "Sorry, password is too short (min is 6 chars)");
if (strlen($wantpassword) > 40) stderr("Error", "Sorry, password is too long (max is 40 chars)");
if ($wantpassword == $wantusername) stderr("Error", "Sorry, password cannot be same as user name.");
if (!validemail($email)) stderr("Error", "That doesn't look like a valid email address.");
if (!validusername($wantusername)) stderr("Error", "Invalid username.");
if (!(isset($_POST['day']) || isset($_POST['month']) || isset($_POST['year']))) stderr('Error', 'You have to fill in your birthday.');
if (checkdate($_POST['month'], $_POST['day'], $_POST['year'])) $birthday = $_POST['year'] . '-' . $_POST['month'] . '-' . $_POST['day'];
else stderr('Error', 'You have to fill in your birthday correctly.');
if ((date('Y') - $_POST['year']) < 17) stderr('Error', 'You must be at least 18 years old to register.');
// make sure user agrees to everything...
if ($_POST["rulesverify"] != "yes" || $_POST["faqverify"] != "yes" || $_POST["ageverify"] != "yes") stderr("Error", "Sorry, you're not qualified to become a member of this site.");
if (!(isset($_POST['country']))) stderr($lang['takesignup_error'], $lang['takesignup_country']);
$pincode = (int)$_POST['pin_code'];
if ($pincode != $_POST['pin_code2']) stderr($lang['takesignup_user_error'], "Pin Codes don't match");
if (strlen((string)$pincode) != 4) stderr($lang['takesignup_user_error'], "Pin Code must be 4 digits");
$country = (((isset($_POST['country']) && is_valid_id($_POST['country'])) ? intval($_POST['country']) : 0));
$gender = isset($_POST['gender']) && isset($_POST['gender']) ? htmlsafechars($_POST['gender']) : '';
// check if email addy is already in use
$a = (mysqli_fetch_row(sql_query('SELECT COUNT(id) FROM users WHERE email = ' . sqlesc($email)))) or sqlerr(__FILE__, __LINE__);
if ($a[0] != 0) stderr('Error', 'The e-mail address <b>' . htmlsafechars($email) . '</b> is already in use.');
//=== check if ip addy is already in use
if ($INSTALLER09['dupeip_check_on']) {
    $c = (mysqli_fetch_row(sql_query("SELECT COUNT(id) FROM users WHERE ip=" . sqlesc($_SERVER['REMOTE_ADDR'])))) or sqlerr(__FILE__, __LINE__);
    if ($c[0] != 0) stderr("Error", "The ip " . htmlsafechars($_SERVER['REMOTE_ADDR']) . " is already in use. We only allow one account per ip address.");
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
$select_inv = sql_query('SELECT sender, receiver, status FROM invite_codes WHERE code = ' . sqlesc($invite)) or sqlerr(__FILE__, __LINE__);
$rows = mysqli_num_rows($select_inv);
$assoc = mysqli_fetch_assoc($select_inv);
if ($rows == 0) stderr("Error", "Invite not found.\nPlease request a invite from one of our members.");
if ($assoc["receiver"] != 0) stderr("Error", "Invite already taken.\nPlease request a new one from your inviter.");
$secret = mksecret();
$wantpasshash = make_passhash($secret, md5($wantpassword));
$editsecret = (!$arr[0] ? "" : make_passhash_login_key());
$wanthintanswer = md5($hintanswer);
check_banned_emails($email);
$user_frees = (TIME_NOW + 14 * 86400);
//$emails = encrypt_email($email);
$new_user = sql_query("INSERT INTO users (username, passhash, secret, passhint, hintanswer, editsecret, birthday, country, gender, stylesheet, invitedby, email, added, last_access, last_login, time_offset, dst_in_use, free_switch, pin_code) VALUES (" . implode(",", array_map("sqlesc", array(
    $wantusername,
    $wantpasshash,
    $secret,
    $passhint,
    $wanthintanswer,
    $editsecret,
    $birthday,
    $country,
    $gender,
    $INSTALLER09['stylesheet'],
    (int)$assoc['sender'],
    $email,
    TIME_NOW,
    TIME_NOW,
    TIME_NOW,
    $time_offset,
    $dst_in_use['tm_isdst'],
    $user_frees,
    $pincode
))) . ")") or sqlerr(__FILE__, __LINE__);
$id = ((is_null($___mysqli_res = mysqli_insert_id($GLOBALS["___mysqli_ston"]))) ? false : $___mysqli_res);
sql_query("INSERT INTO usersachiev (id, username) VALUES (" . sqlesc($id) . ", " . sqlesc($wantusername) . ")") or sqlerr(__FILE__, __LINE__);
sql_query("UPDATE usersachiev SET invited=invited+1 WHERE id =" . sqlesc($assoc['sender'])) or sqlerr(__FILE__, __LINE__);
$message = "Welcome New {$INSTALLER09['site_name']} Member : - " . htmlsafechars($wantusername) . "";
if (!$new_user) {
    if (((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_errno($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_errno()) ? $___mysqli_res : false)) == 1062) stderr("Error", "Username already exists!");
}
//===send PM to inviter
$sender = (int)$assoc["sender"];
$added = TIME_NOW;
$msg = sqlesc("Hey there [you] ! :wave:\nIt seems that someone you invited to {$INSTALLER09['site_name']} has arrived ! :clap2: \n\n Please go to your [url={$INSTALLER09['baseurl']}/invite.php]Invite page[/url] to confirm them so they can log in.\n\ncheers\n");
$subject = sqlesc("Someone you invited has arrived!");
sql_query("INSERT INTO messages (sender, subject, receiver, msg, added) VALUES (0, $subject, " . sqlesc($sender) . ", $msg, $added)") or sqlerr(__FILE__, __LINE__);
$mc1->delete_value('inbox_new_' . $sender);
$mc1->delete_value('inbox_new_sb_' . $sender);
//////////////end/////////////////////
sql_query('UPDATE invite_codes SET receiver = ' . sqlesc($id) . ', status = "Confirmed" WHERE sender = ' . sqlesc((int)$assoc['sender']) . ' AND code = ' . sqlesc($invite)) or sqlerr(__FILE__, __LINE__);
$latestuser_cache['id'] = (int)$id;
$latestuser_cache['username'] = $wantusername;
$latestuser_cache['class'] = '0';
$latestuser_cache['donor'] = 'no';
$latestuser_cache['warned'] = '0';
$latestuser_cache['enabled'] = 'yes';
$latestuser_cache['chatpost'] = '1';
$latestuser_cache['leechwarn'] = '0';
$latestuser_cache['pirate'] = '0';
$latestuser_cache['king'] = '0';
//$latestuser_cache['perms'] =  (int)$arr['perms'];

/** OOPs **/
$mc1->cache_value('latestuser', $latestuser_cache, 0, $INSTALLER09['expires']['latestuser']);
$mc1->delete_value('birthdayusers');
write_log('User account ' . htmlsafechars($wantusername) . ' was created!');
if ($INSTALLER09['autoshout_on'] == 1) {
    autoshout($message);
}
stderr('Success', 'Signup successfull, Your inviter needs to confirm your account now before you can use your account !');
?>
