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
/*
+------------------------------------------------
|   $Date$ 010810
|   $Revision$ 2.0
|   $Author$ Bigjoos
|   $URL$
|   $takeeditcp
|   
+------------------------------------------------
*/
require_once (__DIR__ . DIRECTORY_SEPARATOR . 'include' . DIRECTORY_SEPARATOR . 'bittorrent.php');
require_once (INCL_DIR . 'user_functions.php');
require_once (CLASS_DIR . 'page_verify.php');
require_once (INCL_DIR . 'password_functions.php');
require_once (CLASS_DIR . 'class_user_options.php');
require_once (CLASS_DIR . 'class_user_options_2.php');
dbconn();
loggedinorreturn();
$curuser_cache = $user_cache = $urladd = $changedemail = $birthday = '';
$lang = array_merge(load_language('global') , load_language('takeeditcp'));
$newpage = new page_verify();
$newpage->check('tkepe');
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
$action = isset($_POST["action"]) ? htmlsafechars(trim($_POST["action"])) : '';
$updateset = $curuser_cache = $user_cache = array();
$setbits = $clrbits = 0;
//== Avatars stuffs
if ($action == "avatar") {
    $avatars = (isset($_POST['avatars']) && $_POST['avatars'] === 'yes' ? 'yes' : 'no');
    $offensive_avatar = (isset($_POST['offensive_avatar']) && $_POST['offensive_avatar'] === 'yes' ? 'yes' : 'no');
    $view_offensive_avatar = (isset($_POST['view_offensive_avatar']) && $_POST['view_offensive_avatar'] === 'yes' ? 'yes' : 'no');
    if (!($CURUSER["avatarpos"] == 0 OR $CURUSER["avatarpos"] != 1)) {
        $avatar = trim(urldecode($_POST["avatar"]));
        if (preg_match("/^http:\/\/$/i", $avatar) or preg_match("/[?&;]/", $avatar) or preg_match("#javascript:#is", $avatar) or !preg_match("#^https?://(?:[^<>*\"]+|[a-z0-9/\._\-!]+)$#iU", $avatar)) {
            $avatar = '';
        }
    }
    if (!empty($avatar)) {
        $img_size = @GetImageSize($avatar);
        if ($img_size == FALSE || !in_array($img_size['mime'], $INSTALLER09['allowed_ext'])) stderr($lang['takeeditcp_user_error'], $lang['takeeditcp_image_error']);
        if ($img_size[0] < 5 || $img_size[1] < 5) stderr($lang['takeeditcp_user_error'], $lang['takeeditcp_small_image']);
        sql_query("UPDATE usersachiev SET avatarset=avatarset+1 WHERE id=" . sqlesc($CURUSER["id"]) . " AND avatarset = '0'") or sqlerr(__FILE__, __LINE__);
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
        $curuser_cache['av_w'] = ($image['img_width']);
        $user_cache['av_w'] = ($image['img_width']);
        $curuser_cache['av_h'] = ($image['img_height']);
        $user_cache['av_h'] = ($image['img_height']);
    }
    $updateset[] = 'offensive_avatar = '.sqlesc($offensive_avatar);
    $updateset[] = 'view_offensive_avatar = '.sqlesc($view_offensive_avatar);
    if (!($CURUSER["avatarpos"] == 0 OR $CURUSER["avatarpos"] != 1)) {
        $updateset[] = "avatar = " . sqlesc($avatar);
    }
    $updateset[] = 'avatars = '.sqlesc($avatars);
    $curuser_cache['offensive_avatar'] = $offensive_avatar;
    $user_cache['offensive_avatar'] = $offensive_avatar;
    $curuser_cache['view_offensive_avatar'] = $view_offensive_avatar;
    $user_cache['view_offensive_avatar'] = $view_offensive_avatar;
    $curuser_cache['avatar'] = $avatar;
    $user_cache['avatar'] = $avatar;
    $curuser_cache['avatars'] = $avatars;
    $user_cache['avatars'] = $avatars;
    //if (isset($_POST['offensive_avatar'])) $setbits|= user_options::OFFENSIVE_AVATAR;
    // else $clrbits|= user_options::OFFENSIVE_AVATAR;
    //if (isset($_POST['view_offensive_avatar'])) $setbits|= user_options::VIEW_OFFENSIVE_AVATAR;
    //else $clrbits|= user_options::VIEW_OFFENSIVE_AVATAR;
    //if (isset($_POST['avatars'])) $setbits|= user_options::AVATARS;
    //else $clrbits|= user_options::AVATARS;
    $action = "avatar";
}
//== Signature stuffs
elseif ($action == "signature") {
    if (isset($_POST["info"]) && (($info = $_POST["info"]) != $CURUSER["info"])) {
        $updateset[] = "info = " . sqlesc($info);
        $curuser_cache['info'] = $info;
        $user_cache['info'] = $info;
    }
    $signatures = (isset($_POST['signatures']) && $_POST['signatures'] === 'yes' ? 'yes' : 'no');
    $signature = trim(urldecode($_POST["signature"]));
    if (preg_match("/^http:\/\/$/i", $signature) or preg_match("/[?&;]/", $signature) or preg_match("#javascript:#is", $signature) or !preg_match("#^https?://(?:[^<>*\"]+|[a-z0-9/\._\-!]+)$#iU", $signature)) {
        $signature = '';
    }
    if (!empty($signature)) {
        $img_size = @GetImageSize($signature);
        if ($img_size == FALSE || !in_array($img_size['mime'], $INSTALLER09['allowed_ext'])) stderr($lang['takeeditcp_uerr'], $lang['takeeditcp_img_unsupported']);
        if ($img_size[0] < 5 || $img_size[1] < 5) stderr($lang['takeeditcp_uerr'], $lang['takeeditcp_img_to_small']);
        sql_query("UPDATE usersachiev SET sigset=sigset+1 WHERE id=" . sqlesc($CURUSER["id"]) . " AND sigset = '0'") or sqlerr(__FILE__, __LINE__);
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
        $curuser_cache['sig_w'] = ($image['img_width']);
        $user_cache['sig_w'] = ($image['img_width']);
        $curuser_cache['sig_h'] = ($image['img_height']);
        $user_cache['sig_h'] = ($image['img_height']);
        $updateset[] = "signature = " . sqlesc("[img]" . $signature . "[/img]\n");
        $curuser_cache['signature'] = ("[img]" . $signature . "[/img]\n");
        $user_cache['signature'] = ("[img]" . $signature . "[/img]\n");
    }
    $updateset[] = "signatures = '$signatures'";
    $curuser_cache['signatures'] = $signatures;
    $user_cache['signatures'] = $signatures;
    //if (isset($_POST['signatures'])) $setbits|= user_options::SIGNATURES;
    //else $clrbits|= user_options::SIGNATURES;
    $action = "signature";
}
//== Security Stuffs
elseif ($action == "security") {
    if (isset($_POST['ssluse']) && ($ssluse = (int)$_POST['ssluse']) && ($ssluse != $CURUSER['ssluse'])) $updateset[] = "ssluse = " . $ssluse;
    $curuser_cache['ssluse'] = $ssluse;
    $user_cache['ssluse'] = $ssluse;
    if (!mkglobal("email:chpassword:passagain:chmailpass:secretanswer")) stderr($lang['takeeditcp_err'], $lang['takeeditcp_no_data']);
    if ($chpassword != "") {
        if (strlen($chpassword) > 40) stderr($lang['takeeditcp_err'], $lang['takeeditcp_pass_long']);
        if ($chpassword != $passagain) stderr($lang['takeeditcp_err'], $lang['takeeditcp_pass_not_match']);
        $secret = mksecret();
        $passhash = make_passhash($secret, md5($chpassword));
        $updateset[] = "secret = " . sqlesc($secret);
        $updateset[] = "passhash = " . sqlesc($passhash);
        $curuser_cache['secret'] = $secret;
        $user_cache['secret'] = $secret;
        $curuser_cache['passhash'] = $passhash;
        $user_cache['passhash'] = $passhash;
        logincookie($CURUSER["id"], md5($passhash . $_SERVER["REMOTE_ADDR"]));
    }
    if ($email != $CURUSER["email"]) {
        if (!validemail($email)) stderr($lang['takeeditcp_err'], $lang['takeeditcp_not_valid_email']);
        $r = sql_query("SELECT id FROM users WHERE email=" . sqlesc($email)) or sqlerr(__FILE__, __LINE__);
        if (mysqli_num_rows($r) > 0 || ($CURUSER["passhash"] != make_passhash($CURUSER['secret'], md5($chmailpass)))) stderr($lang['takeeditcp_err'], $lang['takeeditcp_address_taken']);
        $changedemail = 1;
    }
    if ($secretanswer != '') {
        if (strlen($secretanswer) > 40) stderr($lang['takeeditcp_sorry'], $lang['takeeditcp_secret_long']);
        if (strlen($secretanswer) < 6) stderr($lang['takeeditcp_sorry'], $lang['takeeditcp_secret_short']);
        $new_secret_answer = md5($secretanswer);
        $updateset[] = "hintanswer = " . sqlesc($new_secret_answer);
        $curuser_cache['hintanswer'] = $new_secret_answer;
        $user_cache['hintanswer'] = $new_secret_answer;
    }
    if (get_parked() == '1') {
        //if (isset($_POST['parked'])) $setbits|= user_options::PARKED;
        //else $clrbits|= user_options::PARKED;
        if (isset($_POST["parked"]) && ($parked = $_POST["parked"]) != $CURUSER["parked"]){
        $updateset[] = "parked = " . sqlesc($parked);
        $curuser_cache['parked'] = $parked;
        $user_cache['parked'] = $parked;
        }
        
    }
    if (get_anonymous() != '0') {
        //if (isset($_POST['anonymous'])) $setbits|= user_options::ANONYMOUS;
        //else $clrbits|= user_options::ANONYMOUS;
        $anonymous = (isset($_POST['anonymous']) && $_POST["anonymous"] != "" ? "yes" : "no");
        $updateset[] = "anonymous = ".sqlesc($anonymous);
        $curuser_cache['anonymous'] = $anonymous;
        $user_cache['anonymous'] = $anonymous;
        
    }
    //if (isset($_POST['hidecur'])) $setbits|= user_options::HIDECUR;
    //else $clrbits|= user_options::HIDECUR;
    if (isset($_POST["hidecur"]) && ($hidecur = $_POST["hidecur"]) != $CURUSER["hidecur"]){
    $updateset[] = "hidecur = " . sqlesc($hidecur);
    $curuser_cache['hidecur'] = $hidecur;
    $user_cache['hidecur'] = $hidecur;
    }
    
    //if (isset($_POST['show_email'])) $setbits|= user_options::SHOW_EMAIL;
    //else $clrbits|= user_options::SHOW_EMAIL;
    if (isset($_POST["show_email"]) && ($show_email = $_POST["show_email"]) != $CURUSER["show_email"]){
    $updateset[] = "show_email= " . sqlesc($show_email);
    $curuser_cache['show_email'] = $show_email;
    $user_cache['show_email'] = $show_email;
    }
    
    if (isset($_POST["paranoia"]) && ($paranoia = $_POST["paranoia"]) != $CURUSER["paranoia"]) {
        $updateset[] = "paranoia= " . sqlesc($paranoia);
        $curuser_cache['paranoia'] = $paranoia;
        $user_cache['paranoia'] = $paranoia;
    }
    if (isset($_POST["changeq"]) && (($changeq = (int)$_POST["changeq"]) != $CURUSER["passhint"]) && is_valid_id($changeq)) {
        $updateset[] = "passhint = " . sqlesc($changeq);
        $curuser_cache['passhint'] = $changeq;
        $user_cache['passhint'] = $changeq;
    }
    if ($changedemail) {
        $sec = mksecret();
        $hash = md5($sec . $email . $sec);
        $obemail = urlencode($email);
        $updateset[] = "editsecret = " . sqlesc($sec);
        $curuser_cache['editsecret'] = $sec;
        $user_cache['editsecret'] = $sec;
        $thishost = $_SERVER["HTTP_HOST"];
        $thisdomain = preg_replace('/^www\./is', "", $thishost);
        $body = str_replace(array(
            '<#USERNAME#>',
            '<#SITENAME#>',
            '<#USEREMAIL#>',
            '<#IP_ADDRESS#>',
            '<#CHANGE_LINK#>'
        ) , array(
            $CURUSER['username'],
            $INSTALLER09['site_name'],
            $email,
            $_SERVER['REMOTE_ADDR'],
            "{$INSTALLER09['baseurl']}/confirmemail.php?uid={$CURUSER['id']}&key=$hash&email=$obemail"
        ) , $lang['takeeditcp_email_body']);
        mail($email, "$thisdomain {$lang['takeeditcp_confirm']}", $body, "{$lang['takeeditcp_email_from']}{$INSTALLER09['site_email']}");
        $emailquery = sql_query("SELECT id, username, email FROM users WHERE id=" . sqlesc($CURUSER['id'])) or sqlerr(__FILE__, __LINE__);
        $spm = mysqli_fetch_assoc($emailquery);
        $dt = TIME_NOW;
        $subject = sqlesc($lang['takeeditcp_email_alert']);
        $msg = sqlesc("{$lang['takeeditcp_email_user']}[url={$INSTALLER09['baseurl']}/userdetails.php?id=" . (int)$spm['id'] . "][b]" . htmlsafechars($spm['username']) . "[/b][/url]{$lang['takeeditcp_email_changed']}{$lang['takeeditcp_email_old']}" . htmlsafechars($spm['email']) . "{$lang['takeeditcp_email_new']}$email{$lang['takeeditcp_email_check']}");
        $pmstaff = sql_query('SELECT id FROM users WHERE class = ' . UC_ADMINISTRATOR) or sqlerr(__FILE__, __LINE__);
        while ($arr = mysqli_fetch_assoc($pmstaff)) sql_query("INSERT INTO messages(sender, receiver, added, msg, subject) VALUES(0, " . sqlesc($arr['id']) . ", $dt, $msg, $subject)") or sqlerr(__FILE__, __LINE__);
        $mc1->delete_value('inbox_new_' . $arr['id']);
        $mc1->delete_value('inbox_new_sb_' . $arr['id']);
        $urladd.= "&mailsent=1";
    }
    $action = "security";
}
//== Torrent stuffs
elseif ($action == "torrents") {
    $pmnotif = isset($_POST["pmnotif"]) ? $_POST["pmnotif"] : '';
    $emailnotif = isset($_POST["emailnotif"]) ? $_POST["emailnotif"] : '';
    $notifs = ($pmnotif == 'yes' ? "[pm]" : "");
    $notifs.= ($emailnotif == 'yes' ? "[email]" : "");
    //==cats
    $r = sql_query("SELECT id FROM categories") or sqlerr(__FILE__, __LINE__);
    $rows = mysqli_num_rows($r);
    for ($i = 0; $i < $rows; ++$i) {
        $a = mysqli_fetch_assoc($r);
        if (isset($_POST["cat{$a['id']}"]) && $_POST["cat{$a['id']}"] == 'yes') $notifs.= "[cat{$a['id']}]";
    }
    $updateset[] = "notifs = " . sqlesc($notifs) . "";
    $curuser_cache['notifs'] = $notifs;
    $user_cache['notifs'] = $notifs;
    //==
    if (isset($_POST["torrentsperpage"]) && (($torrentspp = min(100, 0 + $_POST["torrentsperpage"])) != $CURUSER["torrentsperpage"])) { 
    $updateset[] = "torrentsperpage = $torrentspp";
    $curuser_cache['torrentsperpage'] = $torrentspp;
    $user_cache['torrentsperpage'] = $torrentspp;
    }
    //==
    if (isset($_POST['viewscloud'])) $setbits|= user_options::VIEWSCLOUD;
    else $clrbits|= user_options::VIEWSCLOUD;
    /*
    $viewscloud = (isset($_POST['viewscloud']) && $_POST["viewscloud"] != "" ? "yes" : "no");{
    $updateset[] = "viewscloud = ".sqlesc($viewscloud);
    $curuser_cache['viewscloud'] = $viewscloud;
    $user_cache['viewscloud'] = $viewscloud;
    }
    */
    if (isset($_POST['clear_new_tag_manually'])) $setbits|= user_options::CLEAR_NEW_TAG_MANUALLY;
    else $clrbits|= user_options::CLEAR_NEW_TAG_MANUALLY;
    /*
    $clear_new_tag_manually = (isset($_POST['clear_new_tag_manually']) && $_POST["clear_new_tag_manually"] != "" ? "yes" : "no");{
    $updateset[] = "clear_new_tag_manually = " . sqlesc($clear_new_tag_manually);
    $curuser_cache['clear_new_tag_manually'] = $clear_new_tag_manually;
    $user_cache['clear_new_tag_manually'] = $clear_new_tag_manually;
    }
    */
    if (isset($_POST['split'])) $setbits|= user_options_2::SPLIT;
    else $clrbits|= user_options_2::SPLIT;
    /*
    $split = ($_POST["split"] == "yes" ? "yes" : "no");{
    $updateset[] = "split = " . sqlesc($split);
    $curuser_cache['split'] = $split;
    $user_cache['split'] = $split;
    }
    */
    if (isset($_POST['browse_icons'])) $setbits|= user_options_2::BROWSE_ICONS;
    else $clrbits|= user_options_2::BROWSE_ICONS;
    /*
    $browse_icons = ($_POST["browse_icons"] == "yes" ? "yes" : "no");{
    $updateset[] = "browse_icons = " . sqlesc($browse_icons);
    $curuser_cache['browse_icons'] = $browse_icons;
    $user_cache['browse_icons'] = $browse_icons;
    }
    */
    if (isset($_POST['categorie_icon']) && (($categorie_icon = (int)$_POST['categorie_icon']) != $CURUSER['categorie_icon']) && is_valid_id($categorie_icon)) {
        $updateset[] = 'categorie_icon = ' . sqlesc($categorie_icon);
        $curuser_cache['categorie_icon'] = $categorie_icon;
        $user_cache['categorie_icon'] = $categorie_icon;
    }
    $action = "torrents";
}
//== Personal stuffs
elseif ($action == "personal") {
	
    //custom-title check
    if (isset($_POST["title"]) && $CURUSER["class"] >= UC_VIP && ($title = $_POST["title"]) != $CURUSER["title"]) {
        $notallow = array(
            "sysop",
            "administrator",
            "admin",
            "mod",
            "moderator",
            "vip",
            "motherfucker"
        );
        if (in_array(strtolower($title) , ($notallow))) stderr($lang['takeeditcp_err'], $lang['takeeditcp_invalid_custom']);
        $updateset[] = "title = " . sqlesc($title);
        $curuser_cache['title'] = $title;
        $user_cache['title'] = $title;
    }
    //status update
    if (isset($_POST['status']) && ($status = $_POST['status']) && !empty($status)) {
        $status_archive = ((isset($CURUSER['archive']) && is_array(unserialize($CURUSER['archive']))) ? unserialize($CURUSER['archive']) : array());
        if (!empty($CURUSER['last_status'])) $status_archive[] = array(
            'status' => $CURUSER['last_status'],
            'date' => $CURUSER['last_update']
        );
        sql_query('INSERT INTO ustatus(userid,last_status,last_update,archive) VALUES(' . sqlesc($CURUSER['id']) . ',' . sqlesc($status) . ',' . TIME_NOW . ',' . sqlesc(serialize($status_archive)) . ') ON DUPLICATE KEY UPDATE last_status=values(last_status),last_update=values(last_update),archive=values(archive)') or sqlerr(__FILE__, __LINE__);
        $mc1->delete_value('userstatus_' . $CURUSER['id']);
        $mc1->delete_value('user_status_' . $CURUSER['id']);
    }
    //end status update;
    if (isset($_POST['stylesheet']) && (($stylesheet = (int)$_POST['stylesheet']) != $CURUSER['stylesheet']) && is_valid_id($stylesheet)) {
    $updateset[] = 'stylesheet = ' . sqlesc($stylesheet);
    $curuser_cache['stylesheet'] = $stylesheet;
    $user_cache['stylesheet'] = $stylesheet;
    }
    if (isset($_POST["topicsperpage"]) && (($topicspp = min(100, 0 + $_POST["topicsperpage"])) != $CURUSER["topicsperpage"])) {
    $updateset[] = "topicsperpage = $topicspp";
    $curuser_cache['topicsperpage'] = $topicspp;
    $user_cache['topicsperpage'] = $topicspp;
}
    if (isset($_POST["postsperpage"]) && (($postspp = min(100, 0 + $_POST["postsperpage"])) != $CURUSER["postsperpage"])) {
    $updateset[] = "postsperpage = $postspp";
    $curuser_cache['postsperpage'] = $postspp;
    $user_cache['postsperpage'] = $postspp;
    }
    if (isset($_POST["forum_sort"]) && ($forum_sort = $_POST["forum_sort"]) != $CURUSER["forum_sort"]) {
        $updateset[] = "forum_sort= ".sqlesc($forum_sort);
        $curuser_cache['forum_sort'] = $forum_sort;
        $user_cache['forum_sort'] = $forum_sort;
    }
    if (isset($_POST["gender"]) && ($gender = $_POST["gender"]) != $CURUSER["gender"]) {
        $updateset[] = "gender = " . sqlesc($gender);
        $curuser_cache['gender'] = $gender;
        $user_cache['gender'] = $gender;
    }
    $shoutboxbg = 0 + $_POST["shoutboxbg"];
    $updateset[] = "shoutboxbg = " . sqlesc($shoutboxbg);
    $curuser_cache['shoutboxbg'] = $shoutboxbg;
    $user_cache['shoutboxbg'] = $shoutboxbg;
	
    if ($CURUSER['birthday'] == '0000-00-00' OR $CURUSER['birthday'] == '1801-01-01') {
        $year = isset($_POST["year"]) ? 0 + $_POST["year"] : 0;
        $month = isset($_POST["month"]) ? 0 + $_POST["month"] : 0;
        $day = isset($_POST["day"]) ? 0 + $_POST["day"] : 0;
        $birthday = date("$year.$month.$day");
        if ($year == '0000') stderr($lang['takeeditcp_err'], $lang['takeeditcp_birth_year']);
        if ($month == '00') stderr($lang['takeeditcp_err'], $lang['takeeditcp_birth_month']);
        if ($day == '00') stderr($lang['takeeditcp_err'], $lang['takeeditcp_birth_day']);
        if (!checkdate($month, $day, $year)) stderr($lang['takeeditcp_err'], "<br /><div id='error' align='center'><font color='red' size='+1'>{$lang['takeeditcp_birth_not']}</font></div><br />");
        $updateset[] = "birthday = " . sqlesc($birthday);
        $curuser_cache['birthday'] = $birthday;
        $user_cache['birthday'] = $birthday;
        $mc1->delete_value('birthdayusers');
    }
    $action = "personal";
}
elseif ($action == "social") {
if (isset($_POST["google_talk"]) && ($google_talk = $_POST["google_talk"]) != $CURUSER["google_talk"]) {
        $updateset[] = "google_talk= " . sqlesc($google_talk);
        $curuser_cache['google_talk'] = $google_talk;
        $user_cache['google_talk'] = $google_talk;
    }
    if (isset($_POST["msn"]) && ($msn = $_POST["msn"]) != $CURUSER["msn"]) {
        $updateset[] = "msn= " . sqlesc($msn);
        $curuser_cache['msn'] = $msn;
        $user_cache['msn'] = $msn;
    }
    if (isset($_POST["aim"]) && ($aim = $_POST["aim"]) != $CURUSER["aim"]) {
        $updateset[] = "aim= " . sqlesc($aim);
        $curuser_cache['aim'] = $aim;
        $user_cache['aim'] = $aim;
    }
    if (isset($_POST["yahoo"]) && ($yahoo = $_POST["yahoo"]) != $CURUSER["yahoo"]) {
        $updateset[] = "yahoo= " . sqlesc($yahoo);
        $curuser_cache['yahoo'] = $yahoo;
        $user_cache['yahoo'] = $yahoo;
    }
    if (isset($_POST["icq"]) && ($icq = $_POST["icq"]) != $CURUSER["icq"]) {
        $updateset[] = "icq= " . sqlesc($icq);
        $curuser_cache['icq'] = $icq;
        $user_cache['icq'] = $icq;
    }
    if (isset($_POST["website"]) && ($website = $_POST["website"]) != $CURUSER["website"]) {
        $updateset[] = "website= " . sqlesc($website);
        $curuser_cache['website'] = $website;
        $user_cache['website'] = $website;
    }
   $action = "social";
}
elseif ($action == "location") {
    if (isset($_POST["country"]) && (($country = $_POST["country"]) != $CURUSER["country"]) && is_valid_id($country)) {
    $updateset[] = "country = $country";
    $curuser_cache['country'] = $country;
    $user_cache['country'] = $country;
    }
    if (isset($_POST['language']) && (($language = (int)$_POST['language']) != $CURUSER['language'])) {
        $updateset[] = 'language = ' . sqlesc($language);
        $curuser_cache['language'] = $language;
        $user_cache['language'] = $language;
    }
    if (isset($_POST["user_timezone"]) && preg_match('#^\-?\d{1,2}(?:\.\d{1,2})?$#', $_POST['user_timezone'])) {
    $updateset[] = "time_offset = " . sqlesc($_POST['user_timezone']);
    $updateset[] = "auto_correct_dst = " . (isset($_POST['checkdst']) ? 1 : 0);
    $updateset[] = "dst_in_use = " . (isset($_POST['manualdst']) ? 1 : 0);
    $curuser_cache['time_offset'] = $_POST['user_timezone'];
    $user_cache['time_offset'] = $_POST['user_timezone'];
    $curuser_cache['auto_correct_dst'] = (isset($_POST['checkdst']) ? 1 : 0);
    $user_cache['auto_correct_dst'] = (isset($_POST['checkdst']) ? 1 : 0);
    $curuser_cache['dst_in_use'] = (isset($_POST['manualdst']) ? 1 : 0);
    $user_cache['dst_in_use'] = (isset($_POST['manualdst']) ? 1 : 0);
    }
   $action = "location";
}
//== Pm stuffs
elseif ($action == "default") {
    $acceptpms_choices = array(
        'yes' => 1,
        'friends' => 2,
        'no' => 3
    );
    $acceptpms = (isset($_POST['acceptpms']) ? $_POST['acceptpms'] : 'all');
    if (isset($acceptpms_choices[$acceptpms])) $updateset[] = "acceptpms = " . sqlesc($acceptpms);
    $curuser_cache['acceptpms'] = $acceptpms;
    $user_cache['acceptpms'] = $acceptpms;
    $deletepms = isset($_POST["deletepms"]) ? "yes" : "no";
    $updateset[] = "deletepms = '$deletepms'";
    $curuser_cache['deletepms'] = $deletepms;
    $user_cache['deletepms'] = $deletepms;
    //if (isset($_POST['deletepms'])) $setbits|= user_options::DELETEPMS;
    //else $clrbits|= user_options::DELETEPMS;
    $savepms = (isset($_POST['savepms']) && $_POST["savepms"] != "" ? "yes" : "no");
    $updateset[] = "savepms = '$savepms'";
    $curuser_cache['savepms'] = $savepms;
    $user_cache['savepms'] = $savepms;
    //if (isset($_POST['savepms'])) $setbits|= user_options::SAVEPMS;
    //else $clrbits|= user_options::SAVEPMS;
    if (isset($_POST["subscription_pm"]) && ($subscription_pm = $_POST["subscription_pm"]) != $CURUSER["subscription_pm"]){  
    $updateset[] = "subscription_pm = " . sqlesc($subscription_pm);
    $curuser_cache['subscription_pm'] = $subscription_pm;
    $user_cache['subscription_pm'] = $subscription_pm;
    }
    if (isset($_POST["pm_forced"]) && ($pm_forced = $_POST["pm_forced"]) != $CURUSER["pm_forced"]){  
    $updateset[] = "pm_forced = " . sqlesc($pm_forced);
    $curuser_cache['pm_forced'] = $pm_forced;
    $user_cache['pm_forced'] = $pm_forced;
    }
    //if (isset($_POST['subscription_pm'])) $setbits|= user_options::SUBSCRIPTION_PM;
    //else $clrbits|= user_options::SUBSCRIPTION_PM;
    if (isset($_POST["pm_on_delete"]) && ($pm_on_delete = $_POST["pm_on_delete"]) != $CURUSER["pm_on_delete"]){  
    $updateset[] = "pm_on_delete = " . sqlesc($pm_on_delete);
    $curuser_cache['pm_on_delete'] = $pm_on_delete;
    $user_cache['pm_on_delete'] = $pm_on_delete;
    }
    //if (isset($_POST['pm_on_delete'])) $setbits|= user_options_2::PM_ON_DELETE;
    //else $clrbits|= user_options_2::PM_ON_DELETE;
    if (isset($_POST["commentpm"]) && ($commentpm = $_POST["commentpm"]) != $CURUSER["commentpm"]){  
    $updateset[] = "commentpm = " . sqlesc($commentpm);
    $curuser_cache['commentpm'] = $commentpm;
    $user_cache['commentpm'] = $commentpm;
    }
    //if (isset($_POST['commentpm'])) $setbits|= user_options_2::COMMENTPM;
    //else $clrbits|= user_options_2::COMMENTPM;
    $action = "default";
}
//== End == then update the sets :)
if ($curuser_cache) {
    $mc1->begin_transaction('MyUser_' . $CURUSER['id']);
    $mc1->update_row(false, $curuser_cache);
    $mc1->commit_transaction($INSTALLER09['expires']['curuser']);
}
if ($user_cache) {
    $mc1->begin_transaction('user' . $CURUSER['id']);
    $mc1->update_row(false, $user_cache);
    $mc1->commit_transaction($INSTALLER09['expires']['user_cache']);
}
if (sizeof($updateset) > 0) sql_query("UPDATE users SET " . implode(",", $updateset) . " WHERE id = " . sqlesc($CURUSER["id"])) or sqlerr(__FILE__, __LINE__);
if ($setbits || $clrbits) sql_query('UPDATE users SET opt1 = ((opt1 | ' . $setbits . ') & ~' . $clrbits . '), opt2 = ((opt2 | ' . $setbits . ') & ~' . $clrbits . ') WHERE id = ' . sqlesc($CURUSER["id"])) or sqlerr(__file__, __line__);
// grab current data
$res = sql_query('SELECT opt1, opt2 FROM users 
                     WHERE id = ' . sqlesc($CURUSER["id"]) . ' LIMIT 1') or sqlerr(__file__, __line__);
$row = mysqli_fetch_assoc($res);
$row['opt1'] = (int)$row['opt1'];
$row['opt2'] = (int)$row['opt2'];
$mc1->begin_transaction('MyUser_' . $CURUSER["id"]);
$mc1->update_row(false, array(
    'opt1' => $row['opt1'],
    'opt2' => $row['opt2']
));
$mc1->commit_transaction($INSTALLER09['expires']['curuser']);
$mc1->begin_transaction('user_' . $CURUSER["id"]);
$mc1->update_row(false, array(
    'opt1' => $row['opt1'],
    'opt2' => $row['opt2']
));
$mc1->commit_transaction($INSTALLER09['expires']['user_cache']);
header("Location: {$INSTALLER09['baseurl']}/usercp.php?edited=1&action=$action" . $urladd);
?>
