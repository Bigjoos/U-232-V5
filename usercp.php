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
|   $Date$ 210413
|   $Revision$ 4.0
|   $Author$ Bigjoos, Roguesurfer
|   $URL$
|   $usercp
|   
+------------------------------------------------
*/
require_once (__DIR__ . DIRECTORY_SEPARATOR . 'include' . DIRECTORY_SEPARATOR . 'bittorrent.php');
require_once (CLASS_DIR . 'class_user_options.php');
require_once (CLASS_DIR . 'class_user_options_2.php');
require_once (INCL_DIR . 'user_functions.php');
require_once (INCL_DIR . 'html_functions.php');
require_once (INCL_DIR . 'bbcode_functions.php');
require_once (CLASS_DIR . 'page_verify.php');
require_once (CACHE_DIR . 'timezones.php');
dbconn(false);
loggedinorreturn();
$stdfoot = array(
    /** include js **/
    'js' => array(
        'keyboard',
    )
);
$stdhead = array(
    /** include js **/
    'js' => array(
        'custom-form-elements'
    ),
    /** include css **/
    'css' => array(
         'usercp'
    )
);
//echo user_options::CLEAR_NEW_TAG_MANUALLY;
//die();
$lang = array_merge(load_language('global') , load_language('usercp'));
$newpage = new page_verify();
$newpage->create('tkepe');
$HTMLOUT = $stylesheets = $wherecatina = '';
$templates = sql_query("SELECT id, name FROM stylesheets ORDER BY id");
while ($templ = mysqli_fetch_assoc($templates)) {
    if (file_exists("templates/".intval($templ['id'])."/template.php")) $stylesheets.= "<option value='" . (int)$templ['id'] . "'" . ($templ['id'] == $CURUSER['stylesheet'] ? " selected='selected'" : "") . ">" . htmlsafechars($templ['name']) . "</option>";
}
$countries = "<option value='0'>---- {$lang['usercp_none']} ----</option>\n";
$ct_r = sql_query("SELECT id,name FROM countries ORDER BY name") or sqlerr(__FILE__, __LINE__);
while ($ct_a = mysqli_fetch_assoc($ct_r)) {
    $countries.= "<option value='" . (int)$ct_a['id'] . "'" . ($CURUSER["country"] == $ct_a['id'] ? " selected='selected'" : "") . ">" . htmlsafechars($ct_a['name']) . "</option>\n";
}
$offset = ($CURUSER['time_offset'] != "") ? (string)$CURUSER['time_offset'] : (string)$INSTALLER09['time_offset'];
$time_select = "<select name='user_timezone'>";
foreach ($TZ as $off => $words) {
    if (preg_match("/^time_(-?[\d\.]+)$/", $off, $match)) {
        $time_select.= $match[1] == $offset ? "<option value='{$match[1]}' selected='selected'>$words</option>\n" : "<option value='{$match[1]}'>$words</option>\n";
    }
}
$time_select.= "</select>";
if ($CURUSER['dst_in_use']) {
    $dst_check = 'checked="checked"';
} else {
    $dst_check = '';
}
if ($CURUSER['auto_correct_dst']) {
    $dst_correction = 'checked="checked"';
} else {
    $dst_correction = '';
}
$HTMLOUT.= "<script type='text/javascript'>
    /*<![CDATA[*/
    function daylight_show()
    {
    if ( document.getElementById( 'tz-checkdst' ).checked )
    {
    document.getElementById( 'tz-checkmanual' ).style.display = 'none';
    }
    else
    {
    document.getElementById( 'tz-checkmanual' ).style.display = 'block';
    }
    }
    /*]]>*/
    </script>";
$HTMLOUT.= '
    <script type="text/javascript">
    /*<![CDATA[*/
    $(document).ready(function()	{
    //=== show hide paranoia info
    $("#paranoia_open").click(function() {
    $("#paranoia_info").slideToggle("slow", function() {
    });
    });
    });
    /*]]>*/
    </script>';
$possible_actions = array(
    'avatar',
    'signature',
    'social',
    'location',
    'security',
    'links',
    'torrents',
    'personal',
    'default'
);
$action = isset($_GET["action"]) ? htmlsafechars(trim($_GET["action"])) : '';
if (!in_array($action, $possible_actions)) stderr('<br /><div class="alert alert-error span11">'.$lang['usercp_err1'].'</div>');
if (isset($_GET["edited"])) {
    $HTMLOUT.= "<br /><div class='alert alert-success span11'>{$lang['usercp_updated']}!</div><br />";
    if (isset($_GET["mailsent"])) $HTMLOUT.= "<h2>{$lang['usercp_mail_sent']}!</h2>\n";
} elseif (isset($_GET["emailch"])) {
    $HTMLOUT.= "<h1>{$lang['usercp_emailch']}!</h1>\n";
}
$HTMLOUT.= "

<div class='container-fluid'>
	<div class='row'>
       <div class='col-md-12'>
<fieldset><legend>{$lang['usercp_welcome']}<a href='userdetails.php?id=" . (int)$CURUSER['id'] . "'>" . htmlsafechars($CURUSER['username']) . "</a> !</legend>\n
</div>
</div>
<div class='row'>
    <div class='col-md-12'>
<form method='post' action='takeeditcp.php'>
		<div class='nav offset1'>
		<ul class='nav nav-pills'>
				  <li><a href='usercp.php?action=avatar'>{$lang['usercp_menu_av']}</a></li>
				  <li><a href='usercp.php?action=signature'>{$lang['usercp_menu_sig']}</a></li>
				  <li><a href='usercp.php?action=default'>{$lang['usercp_menu_pms']}</a></li>
				  <li><a href='usercp.php?action=security'>{$lang['usercp_menu_sec']}</a></li>
				  <li><a href='usercp.php?action=torrents'>{$lang['usercp_menu_tts']}</a></li>
				  <li><a href='usercp.php?action=personal'>{$lang['usercp_menu_pers']}</a></li>
				  <li><a href='usercp.php?action=social'>{$lang['usercp_menu_soc']}</a></li>
				  <li><a href='usercp.php?action=location'>{$lang['usercp_menu_loc']}</a></li>
				  <li><a href='usercp.php?action=links'>{$lang['usercp_menu_lnk']}</a></li>
		</ul>
</div>
</div>
<div class='row'><div class='col-md-12'></div></div>
<div style='display:block;height:20px;'></div>
<div class='container'>
<div class='row'>
<div class='col-md-2'>
		<table class='table table-bordered'>";
if (!empty($CURUSER['avatar']) && $CURUSER['av_w'] > 5 && $CURUSER['av_h'] > 5) $HTMLOUT.= "
		<tr><td><img class='img-polaroid' src='{$CURUSER['avatar']}' width='{$CURUSER['av_w']}' height='{$CURUSER['av_h']}' alt='' /></td></tr></table></div>";
else $HTMLOUT.= "<tr><td><img class='img-polaroid' src='{$INSTALLER09['pic_base_url']}forumicons/default_avatar.gif' alt='' /></td></tr>
		</table>
	</div>";

//== Avatar
if ($action == "avatar") {
    $HTMLOUT.= "
<div class='col-md-8'>	
<table class='table table-bordered'>
	<tr>
	<td><input type='hidden' name='action' value='avatar' />{$lang['usercp_av_opt']}</td>
	</tr>";
    //==Disable avatar selection
    if (!($CURUSER["avatarpos"] == 0 OR $CURUSER["avatarpos"] != 1)) {
        $HTMLOUT.= "<tr><td class='rowhead'>{$lang['usercp_avatar']}</td><td><input name='avatar' size='50' value='" . htmlsafechars($CURUSER["avatar"]) . "' /><br />
    <font class='small'>{$lang['usercp_av_mess1']}\n<br />
    {$lang['usercp_av_mess2']} <a href='{$INSTALLER09['baseurl']}/avatar/index.php'>{$lang['usercp_av_mess3']}</a>.<br />
    {$lang['usercp_av_mess4']} <a href='{$INSTALLER09['baseurl']}/bitbucket.php'>{$lang['usercp_av_mess5']}</a>.</font>
    </td></tr>";
    } else {
        $HTMLOUT.= "<tr><td class='rowhead'>{$lang['usercp_avatar']}</td><td><input name='avatar' size='50' value='" . htmlsafechars($CURUSER["avatar"]) . "' readonly='readonly'/>
    <br />{$lang['usercp_no_avatar_allow']}</td></tr>";
    }
    //==End
    //=== adding avatar stuff - snuggs :D
    $HTMLOUT.= tr(''.$lang['usercp_av_viewon'].'', '<input type="radio" name="offensive_avatar" '.($CURUSER['offensive_avatar'] == 'yes' ? 'checked="checked"' : '').' value="yes" />'.$lang['usercp_av_yes1'].'
     <input type="radio" name="offensive_avatar" '.($CURUSER['offensive_avatar'] == 'no' ? 'checked="checked"' : '').' value="no" />'.$lang['usercp_av_no1'].'', 1);
    //$HTMLOUT.= tr('Is your avatar offensive', '<input class="styled" type="checkbox" name="offensive_avatar"' . (($CURUSER['opt1'] & user_options::OFFENSIVE_AVATAR) ? ' checked="checked"' : '') . ' value="yes" /> (Enable to hide avatar)', 1);
    $HTMLOUT.= tr(''.$lang['usercp_av_viewoff'].'', '<input type="radio" name="view_offensive_avatar" '.($CURUSER['view_offensive_avatar'] == 'yes' ? 'checked="checked"' : '').' value="yes" />'.$lang['usercp_av_yes1'].'
     <input type="radio" name="view_offensive_avatar" '.($CURUSER['view_offensive_avatar'] == 'no' ? 'checked="checked"' : '').' value="no" />'.$lang['usercp_av_no1'].'', 1);
    //$HTMLOUT.= tr('View offensive avatars', '<input class="styled" type="checkbox" name="view_offensive_avatar"' . (($CURUSER['opt1'] & user_options::VIEW_OFFENSIVE_AVATAR) ? ' checked="checked"' : '') . ' value="yes" /> (Check to disable viewing of offensive avatars)', 1);
    $HTMLOUT.= tr(''.$lang['usercp_av_viewav'].'', '<input type="radio" name="avatars" '.($CURUSER['avatars'] == 'yes' ? 'checked="checked"' : '').' value="yes" />'.$lang['usercp_av_yes2'].'
     <input type="radio" name="avatars" '.($CURUSER['avatars'] == 'no' ? 'checked="checked"' : '').' value="no" />'.$lang['usercp_av_no1'].'', 1);
    //$HTMLOUT.= tr('View avatars', '<input class="styled" type="checkbox" name="avatars"' . (($CURUSER['opt1'] & user_options::AVATARS) ? ' checked="checked"' : '') . ' value="yes" /> (Low bandwidth user may want to disable this)', 1);
    $HTMLOUT.= "<tr><td align='center' colspan='2'><input class='btn btn-primary' type='submit' value='{$lang['usercp_sign_sub']}' style='height: 40px' /></td></tr>";

$HTMLOUT.="</div>";

}
//== Signature
elseif ($action == "signature") {
    $HTMLOUT.= "<div class='col-md-8'>
	<table class='table table-bordered'>";
    $HTMLOUT.= "<tr><td><input type='hidden' name='action' value='signature' />{$lang['usercp_sign_opt']}</td></tr>";
    //=== signature stuff
    $HTMLOUT.= tr(''.$lang['usercp_sign_view'].'', '<input type="radio" name="signatures" '.($CURUSER['signatures'] == 'yes' ? 'checked="checked"' : '').' value="yes" />'.$lang['usercp_av_yes1'].'
     <input type="radio" name="signatures" '.($CURUSER['signatures'] == 'no' ? 'checked="checked"' : '').' value="no" />'.$lang['usercp_av_no1'].'', 1);
    //$HTMLOUT.= tr('View Signatures', '<input class="styled" type="checkbox" name="signatures"' . (($CURUSER['opt1'] & user_options::SIGNATURES) ? ' checked="checked"' : '') . ' value="yes" /> (Check to view signatures)', 1);
    $HTMLOUT.= tr(''.$lang['usercp_sign_tit'].'', '<textarea name="signature" cols="50" rows="4">' . htmlsafechars($CURUSER['signature'], ENT_QUOTES) . '</textarea><br />'.$lang['usercp_sign_BB'].'', 1);
    $HTMLOUT.= tr($lang['usercp_info'], "<textarea name='info' cols='50' rows='4'>" . htmlsafechars($CURUSER["info"], ENT_QUOTES) . "</textarea><br />{$lang['usercp_tags']}", 1);
    $HTMLOUT.= "<tr ><td align='center' colspan='2'><input class='btn btn-primary' type='submit' value='{$lang['usercp_sign_sub']}' style='height: 40px' /></td></tr>";

$HTMLOUT.="</div>";
}
//== Social
elseif ($action == "social") {
    $HTMLOUT.= "
<div class='col-md-6'>
	<table class='table table-bordered'>";
    $HTMLOUT.= "<tr><td><input type='hidden' name='action' value='social' />{$lang['usercp_soc_ial']}</td></tr>";
    //=== social stuff
    $HTMLOUT.= tr(''.$lang['usercp_soc_goo'].'', '<img src="pic/social_media/google_talk.gif" alt="Google Talk" title="Google Talk" /><input type="text" size="30" name="google_talk"  value="' . htmlsafechars($CURUSER['google_talk']) . '" />', 1);
    $HTMLOUT.= tr(''.$lang['usercp_soc_msn'].'', '<img src="pic/social_media/msn.gif" alt="Msn" title="Msn" /><input type="text" size="30" name="msn"  value="' . htmlsafechars($CURUSER['msn']) . '" />', 1);
    $HTMLOUT.= tr(''.$lang['usercp_soc_aim'].'', ' <img src="pic/social_media/aim.gif" alt="Aim" title="Aim" /><input type="text" size="30" name="aim"  value="' . htmlsafechars($CURUSER['aim']) . '" />', 1);
    $HTMLOUT.= tr(''.$lang['usercp_soc_yahoo'].'', '<img src="pic/social_media/yahoo.gif" alt="Yahoo" title="Yahoo" /><input type="text" size="30" name="yahoo"  value="' . htmlsafechars($CURUSER['yahoo']) . '" />', 1);
    $HTMLOUT.= tr(''.$lang['usercp_soc_icq'].'', '<img src="pic/social_media/icq.gif" alt="Icq" title="Icq" /><input type="text" size="30" name="icq"  value="' . htmlsafechars($CURUSER['icq']) . '" />', 1);
    $HTMLOUT.= tr(''.$lang['usercp_soc_www'].'', '<img src="pic/social_media/www.gif" alt="www" title="www" width="16px" height="16px" /><input type="text" size="30" name="website"  value="' . htmlsafechars($CURUSER['website']) . '" />', 1);
    $HTMLOUT.= "<tr ><td align='center' colspan='2'><input class='btn btn-primary' type='submit' value='{$lang['usercp_sign_sub']}' style='height: 40px' /></td></tr>";

$HTMLOUT.="</div>";
}
//== Location
elseif ($action == "location") {
    $HTMLOUT.= "
<div class='col-md-7'>
	<table class='table table-bordered'>";
    $HTMLOUT.= "<tr><td><input type='hidden' name='action' value='location' />{$lang['usercp_loc_opt']}</td></tr>";
    //==Time Zone
    $HTMLOUT.= tr($lang['usercp_tz'], $time_select, 1);
    $HTMLOUT.= tr($lang['usercp_checkdst'], "<input type='checkbox' name='checkdst' id='tz-checkdst' onclick='daylight_show()' value='1' $dst_correction />&nbsp;{$lang['usercp_auto_dst']}<br />
    <div id='tz-checkmanual' style='display: none;'><input type='checkbox' name='manualdst' value='1' $dst_check />&nbsp;{$lang['usercp_is_dst']}</div>", 1);
    //==Country
    $HTMLOUT.= tr($lang['usercp_country'], "<select name='country'>\n$countries\n</select>", 1);
    //==Language
    $HTMLOUT.= tr($lang['usercp_language'], "<select name='language'>
    <option value='1'" . ($CURUSER['language'] == '1' ? " selected='selected'" : "") . ">{$lang['usercp_loc_loc1']}</option>
    <option value='2'" . ($CURUSER['language'] == '2' ? " selected='selected'" : "") . ">{$lang['usercp_loc_loc4']}</option>
    </select>", $CURUSER['language']);
//    <option value='2'" . ($CURUSER['language'] == '2' ? " selected='selected'" : "") . ">{$lang['usercp_loc_loc2']}</option>
//    <option value='3'" . ($CURUSER['language'] == '3' ? " selected='selected'" : "") . ">{$lang['usercp_loc_loc3']}</option>
    $HTMLOUT.= "<tr ><td align='center' colspan='2'><input class='btn btn-primary' type='submit' value='{$lang['usercp_sign_sub']}' style='height: 40px' /></td></tr>";
$HTMLOUT.="</div>";
}
//== links
elseif ($action == "links") {
    $HTMLOUT.= "<div class='col-md-6'>
	<div class='panel panel-default bordered-heading'>
	<div class='panel-heading'><h5 class='panel-title'><i class='fa fa-list'></i>{$lang['usercp_lnk_opt']}</h5></div>
	<div class='panel'>
					<div class='panel-body'>
						<div class='row'>
							<div class='col-lg-5'>
								<ul class='list-group'><li class='list-group-item btn btn-default'><b>{$lang['usercp_lnk_men']}</b></li>
	<li class='list-group-item'><a href='mytorrents.php'>{$lang['usercp_edit_torrents']}</a></li>
	<li class='list-group-item'><a href='friends.php'>{$lang['usercp_edit_friends']}</a></li>
	<li class='list-group-item'><a href='users.php'>{$lang['usercp_search']}</a></li>
	<li class='list-group-item'><a href='invite.php'>{$lang['usercp_lnk_inv']}</a></li>
	<li class='list-group-item'><a href='tenpercent.php'>{$lang['usercp_lnk_life']}</a></li></ul>
							</div>
							<div class='col-lg-5'>
								<ul class='list-group'>
	<li class='list-group-item btn btn-default'><b>{$lang['usercp_lnk_enter']}</b></li>
	<li class='list-group-item'><a href='topmoods.php'>{$lang['usercp_lnk_top']}</a></li>
	<li class='list-group-item'><a href='lottery.php'>{$lang['usercp_lnk_lott']}</a></li>";
    if ($CURUSER['class'] >= UC_POWER_USER) {
        $HTMLOUT.= "<li class='list-group-item'><a href='blackjack.php'>{$INSTALLER09['site_name']} {$lang['usercp_lnk_black']}</a></li>";
        $HTMLOUT.= "<li class='list-group-item'><a href='casino.php'>{$INSTALLER09['site_name']} {$lang['usercp_lnk_casi']}</a></li>
        </ul>
						</div></div></div></div></div>";
    }
    $HTMLOUT.= "";
}
//== Security
elseif ($action == "security") {
    $HTMLOUT.= "
<div class='col-md-10'>
	<table class='table table-bordered'>";
    $HTMLOUT.= "<tr><td><input type='hidden' name='action' value='security' />{$lang['usercp_secu_opt']}</td></tr>";
    $HTMLOUT.= tr("{$lang['usercp_secu_opts']}", "<fieldset><legend><strong>{$lang['usercp_secu_ssl']}</strong></legend>
       <select name='ssluse'>
                <option value='1' " . ($CURUSER['ssluse'] == 1 ? 'selected=\'selected\'' : '') . ">{$lang['usercp_secu_nossl']}</option>
                <option value='2' " . ($CURUSER['ssluse'] == 2 ? 'selected=\'selected\'' : '') . ">{$lang['usercp_secu_site']}</option>
                <option value='3' " . ($CURUSER['ssluse'] == 3 ? 'selected=\'selected\'' : '') . ">{$lang['usercp_secu_down']}</option>
        </select>
    <br/><small>{$lang['usercp_secu_inf']}</small></fieldset>", 1);
    if (get_parked() == '1') $HTMLOUT.= tr($lang['usercp_acc_parked'], "<input type='radio' name='parked'".($CURUSER["parked"] == "yes" ? " checked='checked'" : "")." value='yes' />".$lang['usercp_av_yes1']."
    <input type='radio' name='parked'".($CURUSER["parked"] == "no" ? " checked='checked'" : "")." value='no' />".$lang['usercp_av_no1']."
    <br /><font class='small' size='1'>{$lang['usercp_acc_parked_message']}<br />{$lang['usercp_acc_parked_message1']}</font>", 1);
    /*$HTMLOUT.= tr($lang['usercp_acc_parked'], "<input type='checkbox' name='parked'" . (($CURUSER['opt1'] & user_options::PARKED) ? " checked='checked'" : "") . " value='yes' />
    <br /><font class='small' size='1'>{$lang['usercp_acc_parked_message']}<br />{$lang['usercp_acc_parked_message1']}</font>", 1);*/
    if (get_anonymous() != '0') $HTMLOUT.= tr($lang['usercp_anonymous'], "<input type='checkbox' name='anonymous'".($CURUSER["anonymous"] == "yes" ? " checked='checked'" : "")." /> {$lang['usercp_default_anonymous']}", 1);
     $HTMLOUT.= tr("{$lang['usercp_secu_curr']}", "<input type='radio' name='hidecur'".($CURUSER["hidecur"] == "yes" ? " checked='checked'" : "")." value='yes' />".$lang['usercp_av_yes1']."<input type='radio' name='hidecur'".($CURUSER["hidecur"] == "no" ? " checked='checked'" : "")." value='no' />".$lang['usercp_av_no1']."", 1);
    /*$HTMLOUT.= tr($lang['usercp_anonymous'], "<input type='checkbox' name='anonymous'" . (($CURUSER['opt1'] & user_options::ANONYMOUS) ? " checked='checked'" : "") . " /> {$lang['usercp_default_anonymous']}", 1);
    $HTMLOUT.= tr("Hide current seed and leech", "<input type='checkbox' name='hidecur'" . (($CURUSER['opt1'] & user_options::HIDECUR) ? " checked='checked'" : "") . " value='yes' />(Hide your snatch lists)", 1);*/
    //=== paranoia level sir_snugglebunny
    if ($CURUSER['class'] > UC_USER) {
        $HTMLOUT.= tr(''.$lang['usercp_parano_my'].'', "<select name='paranoia'>
	  <option value='0'" . ($CURUSER['paranoia'] == 0 ? " selected='selected'" : "") . ">{$lang['usercp_parano_mood1']}</option>
	  <option value='1'" . ($CURUSER['paranoia'] == 1 ? " selected='selected'" : "") . ">{$lang['usercp_parano_mood2']}</option>
	  <option value='2'" . ($CURUSER['paranoia'] == 2 ? " selected='selected'" : "") . ">{$lang['usercp_parano_mood3']}</option>
	  <option value='3'" . ($CURUSER['paranoia'] == 3 ? " selected='selected'" : "") . ">{$lang['usercp_parano_mood4']}</option>
	  </select> <a class='altlink'  title='Click for more info' id='paranoia_open' style='font-weight:bold;cursor:pointer;'>{$lang['usercp_parano_level']}</a> <br /><br />
	  <div id='paranoia_info' style='display:none;background-color:transparent;max-width:400px;padding: 5px 5px 5px 10px;'>
	  <span style='font-weight: bold;'>{$lang['usercp_parano_mood1']}</span><br />
	  <span style='font-size: x-small;'>{$lang['usercp_parano_level1']}</span><br /><br />
	  <span style='font-weight: bold;'>{$lang['usercp_parano_mood2']}</span><br />
	  <span style='font-size: x-small;'>{$lang['usercp_parano_level3']}</span><br /><br />
	  <span style='font-weight: bold;'>{$lang['usercp_parano_mood3']}</span><br />
	  <span style='font-size: x-small;'>{$lang['usercp_parano_level4']}</span><br /><br />
	  <span style='font-weight: bold;'>{$lang['usercp_parano_mood4']}</span><br />
	  <span style='font-size: x-small;'>{$lang['usercp_parano_level5']}</span><br /><br />
	  <span style='font-weight: bold;'>{$lang['usercp_parano_level6']}</span><br />
	  {$lang['usercp_parano_level7']}<br />{$lang['usercp_parano_level8']}<br /></div>", 1);
    }
    $HTMLOUT.= tr($lang['usercp_email'], "<input type='text' name='email' size='50' value='" . htmlsafechars($CURUSER["email"]) . "' /><br />{$lang['usercp_email_pass']}<br /><input type='password' name='chmailpass' size='50' class='keyboardInput' onkeypress='showkwmessage();return false;' />", 1);
    $HTMLOUT.= "<tr><td colspan='2' align='left'>{$lang['usercp_note']}</td></tr>\n";
    //=== email forum stuff
    $HTMLOUT.= tr($lang['usercp_email_shw'], '<input type="radio" name="show_email" '.($CURUSER['show_email'] == 'yes' ? ' checked="checked"' : '').' value="yes" />'.$lang['usercp_av_yes1'].'
    <input type="radio" name="show_email" '.($CURUSER['show_email'] == 'no' ? ' checked="checked"' : '').' value="no" />'.$lang['usercp_av_no1'].'<br />
    '.$lang['usercp_email_visi'].'', 1);
    /*$HTMLOUT.= tr('Show Email', '<input class="styled" type="checkbox" name="show_email"' . (($CURUSER['opt1'] & user_options::SHOW_EMAIL) ? ' checked="checked"' : '') . ' value="yes" /> Yes<br />
	  Do you wish to have your email address visible on the forums?', 1);*/
    $HTMLOUT.= tr($lang['usercp_chpass'], "<input type='password' name='chpassword' size='50' class='keyboardInput' onkeypress='showkwmessage();return false;' />", 1);
    $HTMLOUT.= tr($lang['usercp_pass_again'], "<input type='password' name='passagain' size='50' class='keyboardInput' onkeypress='showkwmessage();return false;' />", 1);
    $secretqs = "<option value='0'>{$lang['usercp_none_select']}</option>\n";
    $questions = array(
        array(
            "id" => "1",
            "question" => "{$lang['usercp_q1']}"
        ) ,
        array(
            "id" => "2",
            "question" => "{$lang['usercp_q2']}"
        ) ,
        array(
            "id" => "3",
            "question" => "{$lang['usercp_q3']}"
        ) ,
        array(
            "id" => "4",
            "question" => "{$lang['usercp_q4']}"
        ) ,
        array(
            "id" => "5",
            "question" => "{$lang['usercp_q5']}"
        ) ,
        array(
            "id" => "6",
            "question" => "{$lang['usercp_q6']}"
        )
    );
    foreach ($questions as $sctq) {
        $secretqs.= "<option value='" . $sctq['id'] . "'" . ($CURUSER["passhint"] == $sctq['id'] ? " selected='selected'" : "") . ">" . $sctq['question'] . "</option>\n";
    }
    $HTMLOUT.= tr($lang['usercp_question'], "<select name='changeq'>\n$secretqs\n</select>", 1);
    $HTMLOUT.= tr($lang['usercp_sec_answer'], "<input type='text' name='secretanswer' size='40' />", 1);
    $HTMLOUT.= "<tr ><td align='center' colspan='2'><input class='btn btn-primary' type='submit' value='{$lang['usercp_sign_sub']}' style='height: 40px' /></td></tr>";
$HTMLOUT.="</div>";
}
//== Torrents
elseif ($action == "torrents") {
    $HTMLOUT.= "<div class='col-md-8'>
	<table class='table table-bordered'>";
    $HTMLOUT.= "<tr><td><input type='hidden' name='action' value='torrents' />{$lang['usercp_tt_opt']}</td></tr>";
    //==cats
    $categories = '';
    $r = sql_query("SELECT id, image, name FROM categories ORDER BY name") or sqlerr(__FILE__, __LINE__);
    if (mysqli_num_rows($r) > 0) {
        $categories.= "<table><tr>\n";
        $i = 0;
        while ($a = mysqli_fetch_assoc($r)) {
            $categories.= ($i && $i % 2 == 0) ? "</tr><tr>" : "";
            $categories.= "<td class='bottom' style='padding-right: 5px'><input name='cat{$a['id']}' type='checkbox' " . (strpos($CURUSER['notifs'], "[cat{$a['id']}]") !== false ? " checked='checked'" : "") . " value='yes' />&nbsp;<a class='catlink' href='browse.php?cat={$a['id']}'><img src='{$INSTALLER09['pic_base_url']}caticons/{$CURUSER['categorie_icon']}/" . htmlspecialchars($a['image']) . "' alt='" . htmlspecialchars($a['name']) . "' title='" . htmlspecialchars($a['name']) . "' /></a>&nbsp;" . htmlspecialchars($a["name"]) . "</td>\n";
            ++$i;
        }
        $categories.= "</tr></table>\n";
    }
    $HTMLOUT.= tr($lang['usercp_email_notif'], "<input type='checkbox' name='pmnotif'" . (strpos($CURUSER['notifs'], "[pm]") !== false ? " checked='checked'" : "") . " value='yes' /> {$lang['usercp_notify_pm']}<br />\n" . "<input type='checkbox' name='emailnotif'" . (strpos($CURUSER['notifs'], "[email]") !== false ? " checked='checked'" : "") . " value='yes' /> {$lang['usercp_notify_torrent']}\n", 1);
    $HTMLOUT.= tr($lang['usercp_browse'], $categories, 1);
    /*$HTMLOUT.= tr($lang['usercp_clearnewtagmanually'], "<input type='checkbox' name='clear_new_tag_manually'".($CURUSER["clear_new_tag_manually"] == "yes" ? " checked='checked'" : "")." /> {$lang['usercp_default_clearnewtagmanually']}", 1);*/
    $HTMLOUT.= tr($lang['usercp_clearnewtagmanually'], "<input type='checkbox' name='clear_new_tag_manually' value='yes'" . (($CURUSER['opt1'] & user_options::CLEAR_NEW_TAG_MANUALLY) ? " checked='checked'" : "") . " /> {$lang['usercp_default_clearnewtagmanually']}", 1);
    /*$HTMLOUT.= tr($lang['usercp_scloud'], "<input type='checkbox' name='viewscloud'".($CURUSER["viewscloud"] == "yes" ? " checked='checked'" : "")." /> {$lang['usercp_scloud1']}", 1);*/
    $HTMLOUT.= tr($lang['usercp_scloud'], "<input type='checkbox' name='viewscloud' value='yes'" . (($CURUSER['opt1'] & user_options::VIEWSCLOUD) ? " checked='checked'" : "") . " /> {$lang['usercp_scloud1']}", 1);
    /*$HTMLOUT.= tr($lang['usercp_split'], "<input type='radio' name='split'".($CURUSER["split"] == "yes" ? " checked='checked'" : "")." value='yes' />Yes<input type='radio' name='split'".($CURUSER["split"] == "no" ? " checked='checked'" : "")." value='no' />No", 1);*/
    $HTMLOUT.= tr($lang['usercp_split'], "<input type='checkbox' name='split'" . (($CURUSER['opt2'] & user_options_2::SPLIT) ? " checked='checked'" : "") . " value='yes' />{$lang['usercp_tt_split']}", 1);
    /*$HTMLOUT.= tr($lang['usercp_icons'], "<input type='radio' name='browse_icons'".($CURUSER["browse_icons"] == "yes" ? " checked='checked'" : "")." value='yes' />Yes<input type='radio' name='browse_icons'".($CURUSER["browse_icons"] == "no" ? " checked='checked'" : "")." value='no' />No", 1);*/
    $HTMLOUT.= tr($lang['usercp_icons'], "<input type='checkbox' name='browse_icons'" . (($CURUSER['opt2'] & user_options_2::BROWSE_ICONS) ? " checked='checked'" : "") . " value='yes' />{$lang['usercp_tt_vcat']}", 1);
    $HTMLOUT.= tr($lang['usercp_cats_sets'], "<select name='categorie_icon'>
     <option value='1'" . ($CURUSER['categorie_icon'] == 1 ? " selected='selected'" : "") . ">{$lang['usercp_tt_typ1']}</option>
     <option value='2'" . ($CURUSER['categorie_icon'] == 2 ? " selected='selected'" : "") . ">{$lang['usercp_tt_typ2']}</option>
     <option value='3'" . ($CURUSER['categorie_icon'] == 3 ? " selected='selected'" : "") . ">{$lang['usercp_tt_typ3']}</option>
     <option value='4'" . ($CURUSER['categorie_icon'] == 4 ? " selected='selected'" : "") . ">{$lang['usercp_tt_typ4']}</option>
     </select>", $CURUSER['categorie_icon']);
    $HTMLOUT.= tr($lang['usercp_tor_perpage'], "<input type='text' size='10' name='torrentsperpage' value='{$CURUSER['torrentsperpage']}' /> {$lang['usercp_default']}", 1);
    $HTMLOUT.= "<tr><td align='center' colspan='2'><input class='btn btn-primary' type='submit' value='{$lang['usercp_sign_sub']}' style='height: 40px' /></td></tr>";
$HTMLOUT.="</div>";

}
//== Personal
elseif ($action == "personal") {
    $HTMLOUT.= "<div class='col-md-8'>
	<table class='table table-bordered'>";
    $HTMLOUT.= "<tr><td><input type='hidden' name='action' value='personal' />{$lang['usercp_pers_opt']}</td></tr>";
    if ($CURUSER['class'] >= UC_VIP) $HTMLOUT.= tr($lang['usercp_title'], "<input size='50' value='" . htmlsafechars($CURUSER["title"]) . "' name='title' /><br />", 1);
    //==status mod
    $CURUSER['archive'] = unserialize($CURUSER['archive']);
    $HTMLOUT.= "<tr><td class='rowhead'><div style='float:right'>{$lang['usercp_pers_onstat']}</div></td><td><fieldset><legend><strong>{$lang['usercp_pers_upstat']}</strong></legend></fieldset>";
    if (isset($CURUSER['last_status'])) $HTMLOUT.= "<div id='current_holder'>
    <small style='font-weight:bold;'>{$lang['usercp_pers_custat']}</small>
    <h2 id='current_status' title='{$lang['usercp_pers_edit']}' onclick='status_pedit()'>" . format_urls($CURUSER["last_status"]) . "</h2></div>";
    $HTMLOUT.= "<small style='font-weight:bold;'>{$lang['usercp_pers_updt']}</small>
    <textarea name='status' id='status' onkeyup='status_count()' cols='50' rows='4'></textarea>
    <div style='width:390px;'>
    <div style='float:left;padding-left:5px;'><small style='font-weight:bold;'>{$lang['usercp_pers_nobb']}</small></div>
    <div style='float:right;font-size:12px;font-weight:bold;' id='status_count'>140</div>
    <div style='clear:both;'></div></div>";
    if (count($CURUSER['archive'])) {
        $HTMLOUT.= "<div style='width:390px'>
    <div style='float:left;padding-left:5px;'><small style='font-weight:bold;'>{$lang['usercp_pers_arcstat']}</small></div>
    <div style='float:right;cursor:pointer' id='status_archive_click' onclick='status_slide()'>+</div>
    <div style='clear:both;'></div>
    <div id='status_archive' style='padding-left:15px;display:none;'>";
        if (is_array($CURUSER['archive'])) foreach (array_reverse($CURUSER['archive'], true) as $a_id => $sa) $HTMLOUT.= '<div id="status_' . $a_id . '">
    <div style="float:left">' . htmlsafechars($sa['status']) . '
    <small>added ' . get_date($sa['date'], '', 0, 1) . '</small></div>
    <div style="float:right;cursor:pointer;"><span onclick="status_delete(' . $a_id . ')"></span></div>
    <div style="clear:both;border:1px solid #222;border-width:1px 0 0 0;margin-bottom:3px;"></div></div>';
        $HTMLOUT.= "</div></div>";
    }
    $HTMLOUT.= "</td></tr>";
    $HTMLOUT.= tr($lang['usercp_top_perpage'], "<input type='text' size='10' name='topicsperpage' value='$CURUSER[topicsperpage]' /> {$lang['usercp_default']}", 1);
    $HTMLOUT.= tr($lang['usercp_post_perpage'], "<input type='text' size='10' name='postsperpage' value='$CURUSER[postsperpage]' /> {$lang['usercp_default']}", 1);
    $HTMLOUT.= tr($lang['usercp_pers_list'], "<input type='radio' name='forum_sort' ".($CURUSER["forum_sort"] == "ASC" ? " checked='checked'" : "")." value='ASC' />{$lang['usercp_pers_bot']}<input type='radio' name='forum_sort' ".($CURUSER["forum_sort"] != "ASC" ? " checked='checked'" : "")." value='DESC' />{$lang['usercp_pers_top']}<br />{$lang['usercp_pers_order']}", 1);
    $HTMLOUT.= tr($lang['usercp_stylesheet'], "<select name='stylesheet'>\n$stylesheets\n</select>", 1);
    $HTMLOUT.= tr($lang['usercp_gender'], "<input type='radio' name='gender'" . ($CURUSER["gender"] == "Male" ? " checked='checked'" : "") . " value='Male' />{$lang['usercp_male']}
    <input type='radio' name='gender'" . ($CURUSER["gender"] == "Female" ? " checked='checked'" : "") . " value='Female' />{$lang['usercp_female']}
    <input type='radio' name='gender'" . ($CURUSER["gender"] == "N/A" ? " checked='checked'" : "") . " value='N/A' />{$lang['usercp_na']}", 1);
    $HTMLOUT.= tr($lang['usercp_shoutback'], "<input type='radio' name='shoutboxbg'" . ($CURUSER["shoutboxbg"] == "1" ? " checked='checked'" : "") . " value='1' />{$lang['usercp_shoutback_white']}
    <input type='radio' name='shoutboxbg'" . ($CURUSER["shoutboxbg"] == "2" ? " checked='checked'" : "") . " value='2' />{$lang['usercp_shoutback_grey']}<input type='radio' name='shoutboxbg'" . ($CURUSER["shoutboxbg"] == "3" ? " checked='checked'" : "") . " value='3' />{$lang['usercp_shoutback_black']}", 1);
    //==09 Birthday
    $day = $month = $year = '';
    $birthday = $CURUSER["birthday"];
    $birthday = date("Y-m-d", strtotime($birthday));
    list($year1, $month1, $day1) = explode('-', $birthday);
    if ($CURUSER['birthday'] == '0000-00-00' OR $CURUSER['birthday'] == '1801-01-01') {
        $year.= "<select name=\"year\"><option value=\"0000\">--</option>\n";
        $i = "1920";
        while ($i <= (date('Y', TIME_NOW) - 13)) {
            $year.= "<option value=\"" . $i . "\">" . $i . "</option>\n";
            $i++;
        }
        $year.= "</select>\n";
        $birthmonths = array(
            "01" => "{$lang['usercp_pers_month1']}",
            "02" => "{$lang['usercp_pers_month2']}",
            "03" => "{$lang['usercp_pers_month3']}",
            "04" => "{$lang['usercp_pers_month4']}",
            "05" => "{$lang['usercp_pers_month5']}",
            "06" => "{$lang['usercp_pers_month6']}",
            "07" => "{$lang['usercp_pers_month7']}",
            "08" => "{$lang['usercp_pers_month8']}",
            "09" => "{$lang['usercp_pers_month9']}",
            "10" => "{$lang['usercp_pers_month10']}",
            "11" => "{$lang['usercp_pers_month11']}",
            "12" => "{$lang['usercp_pers_month12']}",
        );
        $month = "<select name=\"month\"><option value=\"00\">--</option>\n";
        foreach ($birthmonths as $month_no => $show_month) {
            $month.= "<option value=\"$month_no\">$show_month</option>\n";
        }
        $month.= "</select>\n";
        $day.= "<select name=\"day\"><option value=\"00\">--</option>\n";
        $i = 1;
        while ($i <= 31) {
            if ($i < 10) {
                $day.= "<option value=\"0" . $i . "\">0" . $i . "</option>\n";
            } else {
                $day.= "<option value=\"" . $i . "\">" . $i . "</option>\n";
            }
            $i++;
        }
        $day.= "</select>\n";
        $HTMLOUT.= tr($lang['usercp_pers_birth'], $year . $month . $day, 1);
    }
    //== End
    $HTMLOUT.= "<tr><td align='center' colspan='2'><input class='btn btn-primary' type='submit' value='{$lang['usercp_sign_sub']}' style='height: 40px' /></td></tr>";
} else {
    //== Default Pms
    if ($action == "default") $HTMLOUT.= "<div class='col-md-8'>
	<table class='table table-bordered'>";
    $HTMLOUT.= "<tr><td><input type='hidden' name='action' value='default' />{$lang['usercp_pm_opt']}</td></tr>";
    $HTMLOUT.= tr($lang['usercp_accept_pm'], "<input type='radio' name='acceptpms'" . ($CURUSER["acceptpms"] == "yes" ? " checked='checked'" : "") . " value='yes' />{$lang['usercp_except_blocks']}
    <input type='radio' name='acceptpms'" . ($CURUSER["acceptpms"] == "friends" ? " checked='checked'" : "") . " value='friends' />{$lang['usercp_only_friends']}
    <input type='radio' name='acceptpms'" . ($CURUSER["acceptpms"] == "no" ? " checked='checked'" : "") . " value='no' />{$lang['usercp_only_staff']}", 1);
    $HTMLOUT.= tr($lang['usercp_delete_pms'], "<input type='checkbox' name='deletepms'".($CURUSER["deletepms"] == "yes" ? " checked='checked'" : "")." /> {$lang['usercp_default_delete']}", 1);
    //$HTMLOUT.= tr($lang['usercp_delete_pms'], "<input type='checkbox' name='deletepms'" . (($CURUSER['opt1'] & user_options::DELETEPMS) ? " checked='checked'" : "") . " /> {$lang['usercp_default_delete']}", 1);
    $HTMLOUT.= tr($lang['usercp_save_pms'], "<input type='checkbox' name='savepms'".($CURUSER["savepms"] == "yes" ? " checked='checked'" : "")." /> {$lang['usercp_default_save']}", 1);
    //$HTMLOUT.= tr($lang['usercp_save_pms'], "<input type='checkbox' name='savepms'" . (($CURUSER['opt1'] & user_options::SAVEPMS) ? " checked='checked'" : "") . " /> {$lang['usercp_default_save']}", 1);
    $HTMLOUT.= tr($lang['usercp_pm_fopm'], "<input type='radio' name='subscription_pm' ".($CURUSER["subscription_pm"] == "yes" ? " checked='checked'" : "")." value='yes' />".$lang['usercp_av_yes1']." <input type='radio' name='subscription_pm' ".($CURUSER["subscription_pm"] == "no" ? " checked='checked'" : "")." value='no' />".$lang['usercp_av_no1']."<br />".$lang['usercp_pm_pm01']."", 1);
    //$HTMLOUT.= tr("Forum Subscribe Pm", "<input type='checkbox' name='subscription_pm'" . (($CURUSER['opt1'] & user_options::SUBSCRIPTION_PM) ? " checked='checked'" : "") . " value='yes' />(When someone posts in a subscribed thread, you will be PMed)", 1);
    $HTMLOUT.= tr($lang['usercp_pm_topm'], "<input type='radio' name='pm_on_delete' ".($CURUSER["pm_on_delete"] == "yes" ? " checked='checked'" : "")." value='yes' />".$lang['usercp_av_yes1']." <input type='radio' name='pm_on_delete' ".($CURUSER["pm_on_delete"] == "no" ? " checked='checked'" : "")." value='no' />".$lang['usercp_av_no1']."<br />".$lang['usercp_pm_pm02']."", 1);
    //$HTMLOUT.= tr("Torrent deletion Pm", "<input type='checkbox' name='pm_on_delete'" . (($CURUSER['opt2'] & user_options_2::PM_ON_DELETE) ? " checked='checked'" : "") . " value='yes' />(When any of your uploaded torrents are deleted, you will be PMed)", 1);
    $HTMLOUT.= tr($lang['usercp_pm_copm'], "<input type='radio' name='commentpm' ".($CURUSER["commentpm"] == "yes" ? " checked='checked'" : "")." value='yes' />".$lang['usercp_av_yes1']." <input type='radio' name='commentpm' ".($CURUSER["commentpm"] == "no" ? " checked='checked'" : "")." value='no' />".$lang['usercp_av_no1']."<br />".$lang['usercp_pm_pm03']."", 1);
    //$HTMLOUT.= tr("Torrent comment Pm", "<input type='checkbox' name='commentpm'" . (($CURUSER['opt2'] & user_options_2::COMMENTPM) ? " checked='checked'" : "") . " value='yes' />(When any of your uploaded torrents are commented on, you will be PMed)", 1);
    $HTMLOUT.= tr($lang['usercp_pm_force'], "<input type='radio' name='pm_forced' ".($CURUSER["pm_forced"] == "yes" ? " checked='checked'" : "")." value='yes' />".$lang['usercp_av_yes1']." <input type='radio' name='pm_forced' ".($CURUSER["pm_forced"] == "no" ? " checked='checked'" : "")." value='no' />".$lang['usercp_av_no1']."<br />".$lang['usercp_pm_pm04']."", 1);
$HTMLOUT.= "<tr><td align='center' colspan='2'><input class='btn btn-primary' type='submit' value='{$lang['usercp_sign_sub']}' style='height: 40px' /></td></tr>";
$HTMLOUT.="</div>";
}
$HTMLOUT.= "</table></div></form></div><!--</div>--></fieldset></div></div>";
echo stdhead(htmlsafechars($CURUSER["username"], ENT_QUOTES) . "{$lang['usercp_stdhead']} ", true, $stdhead) . $HTMLOUT . stdfoot($stdfoot);
?>
