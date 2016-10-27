<?php
/**
 |--------------------------------------------------------------------------|
 |   https://github.com/Bigjoos/                			    |
 |--------------------------------------------------------------------------|
 |   Licence Info: GPL							    |
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
require_once (__DIR__ . DIRECTORY_SEPARATOR . 'include' . DIRECTORY_SEPARATOR . 'bittorrent.php');
require_once (INCL_DIR . 'user_functions.php');
require_once INCL_DIR . 'html_functions.php';
require_once INCL_DIR . 'bbcode_functions.php';
require_once CLASS_DIR . 'page_verify.php';
global $CURUSER;
if (!mkglobal("id")) die();
$id = 0 + $id;
if (!$id) die();
/** who is modding by pdq **/
if ((isset($_GET['unedit']) && $_GET['unedit'] == 1) && $CURUSER['class'] >= UC_STAFF) {
    $returl = "details.php?id=$id";
    if (isset($_POST["returnto"])) $returl.= "&returnto=" . urlencode($_POST["returnto"]);
    header("Refresh: 1; url=$returl");
    $mc1->delete_value('editedby_' . $id);
    exit();
}
dbconn();
loggedinorreturn();
$lang = array_merge(load_language('global') , load_language('edit'), load_language('ad_artefact'));
$stdfoot = array(
    /** include js **/
    'js' => array(
        'shout',
        'FormManager'
    )
);
$stdhead = array(
    /** include css **/
    'css' => array(
        'style2',
        'bbcode',
        'shout'
    )
);
$newpage = new page_verify();
$newpage->create('teit');
$res = sql_query("SELECT * FROM torrents WHERE id = " . sqlesc($id));
$row = mysqli_fetch_assoc($res);
if (!$row) stderr($lang['edit_user_error'], $lang['edit_no_torrent']);
if (!isset($CURUSER) || ($CURUSER["id"] != $row["owner"] && $CURUSER["class"] < UC_STAFF)) {
    stderr($lang['edit_user_error'], sprintf($lang['edit_no_permission'], urlencode($_SERVER['REQUEST_URI'])));
}
$HTMLOUT = $mod_cache_name = '';
$HTMLOUT = "<script type='text/javascript'>
    window.onload = function() {
    setupDependencies('edit'); //name of form(s). Seperate each with a comma (ie: 'weboptions', 'myotherform' )
    };
    </script>";
if ($CURUSER['class'] >= UC_STAFF) {
    if (($mod_cache_name = $mc1->get_value('editedby_' . $id)) === false) {
        $mod_cache_name = $CURUSER['username'];
        $mc1->add_value('editedby_' . $id, $mod_cache_name, $INSTALLER09['expires']['ismoddin']);
    }
    $HTMLOUT.= '<div class="row"><div class="col-sm-4 col-sm-offset-1"><h1><font size="+1"><font color="#FF0000">' . $mod_cache_name . '</font>'.$lang['edit_curr'].'</font></h1></div></div>';
}
$ismodd = '<div class="row"><div class="col-sm-12"><b>'.$lang['edit_stdhead'].'</b> ' . (($CURUSER['class'] > UC_UPLOADER) ? '<small><a href="edit.php?id=' . $id . '&amp;unedit=1">'.$lang['edit_clkhere'].'</a>'.$lang['edit_clktemp'].'</small>' : '') . '</div></div>';
$HTMLOUT.= "<form method='post' name='edit' action='takeedit.php' enctype='multipart/form-data'><input type='hidden' name='id' value='$id' />";
if (isset($_GET["returnto"])) 
$HTMLOUT.= "<input type='hidden' name='returnto' value='" . htmlsafechars($_GET["returnto"]) . "' />";
$HTMLOUT .="<div class='panel inverse' style='width:82%; margin-left:9%;'>
<div class='row'><div class='col-sm-12'>$ismodd</div></div>
<div class='row'><div class='col-sm-12'><input class='form-control' placeholder='{$lang['edit_imdb_url']}' type='text' name='url' value='" . htmlsafechars($row["url"]) . "'></div></div><br>
<div class='row'><div class='col-sm-12'><input class='form-control' placeholder='{$lang['edit_poster']}' type='text' name='poster' value='" . htmlsafechars($row["poster"]) . "'><br />{$lang['edit_poster1']}\n</div></div><br>
<div class='row'><div class='col-sm-12'><input class='form-control' placeholder='{$lang['edit_tube']}' type='text' name='youtube' value='" . htmlsafechars($row["youtube"]) . "'><br />{$lang['edit_youtube_info']}\n</div></div><br>
<div class='row'><div class='col-sm-12'><input class='form-control' placeholder='{$lang['edit_torrent_name']}' type='text' name='name' value='" . htmlsafechars($row["name"]) . "'></div>
</div><br>
<div class='row'><div class='col-sm-12'><input class='form-control' placeholder='{$lang['edit_torrent_tags']}' type='text' name='tags' value='" . htmlsafechars($row["tags"]) . "'><br />({$lang['edit_tags_info']})\n</div>
</div><br>
<div class='row'><div class='col-sm-12'><input class='form-control' placeholder='{$lang['edit_torrent_description']}' type='text' name='description' value='" . htmlsafechars($row["description"]) . "'></div>
</div><br>
<div class='row'><div class='col-sm-12'>{$lang["edit_nfo"]}<br /><input type='radio' name='nfoaction' value='keep' checked='checked' />{$lang['edit_keep_current']}<br /><input type='radio' name='nfoaction' value='update' />{$lang['edit_update']}<br /><input type='file' name='nfo' size='80' /> </div>
</div><br>";
if ((strpos($row["ori_descr"], "<") === false) || (strpos($row["ori_descr"], "&lt;") !== false)) {
    $c = "";
} else {
    $c = " checked";
}
$HTMLOUT.="
<div class='row'><div class='col-sm-12'>{$lang['edit_description']} ". textbbcode("edit","descr","".htmlspecialchars($row['ori_descr'])."")."<br />{$lang['edit_tags']}</div></div><br>";
$s = "<br><select class='form-control' name='type'>";
$cats = genrelist();
foreach ($cats as $subrow) {
    $s.= "<option value='" . (int)$subrow["id"] . "'";
    if ($subrow["id"] == $row["category"]) $s.= " selected='selected'";
    $s.= ">" . htmlsafechars($subrow["name"]) . "</option>\n";
}
$s.= "</select>\n";
$HTMLOUT.="<div class='row'>
<div class='col-sm-3'>{$lang['edit_type']}:$s</div>";
require_once (CACHE_DIR . 'subs.php');
$subs_list = '';
$subs_list.= "";
$i = 0;
foreach ($subs as $s) {
    $subs_list.= ($i && $i % 4 == 0) ? "" : "";
    $subs_list.= "<label class='checkbox-inline'><input name=\"subs[]\" " . (strpos($row["subs"], $s["id"]) !== false ? " checked='checked'" : "") . "  type=\"checkbox\" value=\"" . (int)$s["id"] . "\" />" . htmlsafechars($s["name"]) . "</label>\n";
    ++$i;
}
$subs_list.= "";
$rg = "<select class='form-control' name='release_group'>\n<option value='scene'" . ($row["release_group"] == "scene" ? " selected='selected'" : "") . ">{$lang['edit_scene']}</option>\n<option value='p2p'" . ($row["release_group"] == "p2p" ? " selected='selected'" : "") . ">{$lang['edit_p2p']}</option>\n<option value='none'" . ($row["release_group"] == "none" ? " selected='selected'" : "") . ">{$lang['edit_none']}</option> \n</select>\n";
$HTMLOUT.= "<div class='col-sm-3'>{$lang['edit_relgrp']}$rg</div>";
$HTMLOUT.= "<div class='col-sm-6'>{$lang['edit_subs']}$subs_list</div></div><br>";
$HTMLOUT.= "<br><div class='row'><div class='col-sm-12'></div></div>";
$HTMLOUT.= "<br><div class='row'>
<div class='col-sm-6'>";
$HTMLOUT.= tr($lang['edit_visible'], "<input type='checkbox' name='visible'" . (($row["visible"] == "yes") ? " checked='checked'" : "") . " value='1' /> {$lang['edit_visible_mainpage']}<br /><table border='0' cellspacing='0' cellpadding='0' width='420'><tr><td class='embedded'><font class='small'>{$lang['edit_visible_info']}</font></td></tr></table>", 1);
$HTMLOUT.="</div>";
if ($CURUSER['class'] >= UC_STAFF) 
$HTMLOUT.= "<div class='col-sm-3'>{$lang['edit_banned2']}<input type='checkbox' name='banned'" . (($row["banned"] == "yes") ? " checked='checked'" : "") . " value='1' />{$lang['edit_banned']}</div>";
$HTMLOUT.= "<div class='col-sm-3'>{$lang['edit_recommend_torrent']}<input type='radio' name='recommended' " . (($row["recommended"] == "yes") ? "checked='checked'" : "") . " value='yes' />{$lang['edit_yes']}<input type='radio' name='recommended' " . ($row["recommended"] == "no" ? "checked='checked'" : "") . " value='no' />{$lang['edit_no']}<br/><font class='small'>{$lang['edit_recommend']}</font></div>";
$HTMLOUT.= "</div>";
$HTMLOUT.= "<br><div class='row'><div class='col-sm-12'></div></div>";
if ($CURUSER['class'] >= UC_UPLOADER) {
    $HTMLOUT.= "<div class='row'><div class='col-sm-2'>{$lang['edit_nuked']}<input type='radio' name='nuked'" . ($row["nuked"] == "yes" ? " checked='checked'" : "") . " value='yes' />{$lang['edit_yes']}<input type='radio' name='nuked'" . ($row["nuked"] == "no" ? " checked='checked'" : "") . " value='no' />{$lang['edit_no']}</div>";
    $HTMLOUT.= "<div class='col-sm-10'><input class='form-control' placeholder='{$lang['edit_nukr']}' type='text' name='nukereason' value='" . htmlsafechars($row["nukereason"]) . "' /></div></div>";
}
$HTMLOUT.= "<br><div class='row'><div class='col-sm-12'></div></div>";
$HTMLOUT.= "<br><div class='row'>
<div class='col-sm-4'>";
if ($CURUSER['class'] >= UC_STAFF && XBT_TRACKER == false) {
    $HTMLOUT.= tr("{$lang['edit_add_free']}", ($row['free'] != 0 ? "<input type='checkbox' name='fl' value='1' />{$lang['edit_add_nofree']}" : "
    <select name='free_length'>
    <option value='0'>------</option>
    <option value='42'>{$lang['edit_add_day1']}</option>
    <option value='1'>{$lang['edit_add_week1']}</option>
    <option value='2'>{$lang['edit_add_week2']}</option>
    <option value='4'>{$lang['edit_add_week4']}</option>
    <option value='8'>{$lang['edit_add_week8']}</option>
    <option value='255'>{$lang['edit_add_unltd']}</option>
    </select>") , 1);
    if ($row['free'] != 0) {$HTMLOUT.="<br>";
        $HTMLOUT.= tr("{$lang['edit_free_dur1']}", ($row['free'] != 1 ? "{$lang['edit_until']}" . get_date($row['free'], 'DATE') . " 
		 (" . mkprettytime($row['free'] - TIME_NOW) . " to go)" : 'Unlimited') , 1);
    }}
$HTMLOUT.= "</div>";

$HTMLOUT.= "<div class='col-sm-4'>";

$HTMLOUT.= tr("{$lang['edit_add_silver']}", ($row['silver'] != 0 ? "<input type='checkbox' name='slvr' value='1' />{$lang['edit_add_nosilver']}" : "
    <select name='half_length'>
    <option value='0'>------</option>
    <option value='42'>{$lang['edit_add_sday1']}</option>
    <option value='1'>{$lang['edit_add_sweek1']}</option>
    <option value='2'>{$lang['edit_add_sweek2']}</option>
    <option value='4'>{$lang['edit_add_sweek4']}</option>
    <option value='8'>{$lang['edit_add_sweek8']}</option>
    <option value='255'>{$lang['edit_add_unltd']}</option>
    </select>") , 1);
    if ($row['silver'] != 0) {
        $HTMLOUT.= tr("{$lang['edit_silv_dur1']}", ($row['silver'] != 1 ? "{$lang['edit_until']}" . get_date($row['silver'], 'DATE') . " 
		 (" . mkprettytime($row['silver'] - TIME_NOW) . " to go)" : 'Unlimited') , 1);
    }

$HTMLOUT.= "</div>";

// ===09 Allow Comments
if ($CURUSER['class'] >= UC_STAFF && $CURUSER['class'] == UC_MAX) {
    if ($row["allow_comments"] == "yes") $messc = "&nbsp;<br>{$lang['edit_com_allow']}";
    else $messc = "&nbsp;<br>{$lang['edit_com_only']}";
    $HTMLOUT.= "<div class='col-sm-4'><font color='red'>&nbsp;*&nbsp;</font><b>&nbsp;{$lang['edit_comment']}</b>
    <select name='allow_comments'>
    <option value='" . htmlsafechars($row["allow_comments"]) . "'>" . htmlsafechars($row["allow_comments"]) . "</option>
    <option value='yes'>{$lang['edit_yes']}</option><option value='no'>{$lang['edit_no']}</option></select>{$messc}\n";
}
// ===end
$HTMLOUT.="</div></div>";
$HTMLOUT.= "<br><div class='row'><div class='col-sm-12'></div></div>";
$HTMLOUT.="<div class='row'>";
if ($CURUSER['class'] >= UC_STAFF) {
$HTMLOUT.="<div class='col-sm-4'>";
    $HTMLOUT.= tr($lang['edit_stick1'], "<input type='checkbox' name='sticky'" . (($row["sticky"] == "yes") ? " checked='checked'" : "") . " value='yes' />{$lang['edit_stick2']}", 1);
$HTMLOUT.= "</div>";
$HTMLOUT.="<div class='col-sm-4'>";    
	$HTMLOUT.= tr($lang['edit_anonymous'], "<input type='checkbox' name='anonymous'" . (($row["anonymous"] == "yes") ? " checked='checked'" : "") . " value='1' />{$lang['edit_anonymous1']}", 1);
$HTMLOUT.= "</div>"; 
$HTMLOUT.="<div class='col-sm-4'> ";  
	if (XBT_TRACKER == false) {
        $HTMLOUT.= tr($lang['edit_vip1'], "<input type='checkbox' name='vip'" . (($row["vip"] == 1) ? " checked='checked'" : "") . " value='1' />{$lang['edit_vip2']}", 1);
$HTMLOUT.= "</div>";    }
$HTMLOUT.="<div class='col-sm-4'>";
    if (XBT_TRACKER == true) {
        $HTMLOUT.= tr($lang['edit_add_free'], "<input type='checkbox' name='freetorrent'" . (($row["freetorrent"] == 1) ? " checked='checked'" : "") . " value='1' />{$lang['edit_makefree']}", 1);
 $HTMLOUT.= "</div>";   }
}
$HTMLOUT.="</div>";
$HTMLOUT.= "<br><div class='row'><div class='col-sm-12'></div></div>";
//==09 Genre mod no sql
$HTMLOUT.= "<br><div class='row'>
    <div class='col-sm-8 col-sm-offset-4'><b>{$lang['upload_add_genre']}</b>&nbsp;&nbsp;&nbsp;{$lang['edit_opt_genre']}&nbsp;&nbsp;&nbsp;
        <table>
    <tr>
    <td align='left'>
    <input type='radio' name='genre' value='keep' checked='checked' />{$lang['edit_touch1']} [ <b>{$lang['edit_touch2']}<font color='lightblue'>" . htmlsafechars($row['newgenre']) . "</font></b> ] <br /></td>
    <td style='border:none'><input type='radio' name='genre' value='movie' />{$lang['upload_add_movie']}</td>
    <td style='border:none'><input type='radio' name='genre' value='music' />{$lang['upload_add_music']}</td>
    <td style='border:none'><input type='radio' name='genre' value='game' />{$lang['upload_add_game']}</td>
    <td style='border:none'><input type='radio' name='genre' value='apps' />{$lang['upload_add_apps']}</td>
    <td style='border:none'><input type='radio' name='genre' value='none' />{$lang['upload_add_none']}</td>
    </tr>
    </table> 
    <table> 
    <tr>
    <td colspan='4' style='border:none'>
    <label style='margin-bottom: 1em; padding-bottom: 1em; border-bottom: 3px silver groove;'>
    <input type='hidden' class='Depends on genre being movie or genre being music' /></label>";
$movie = array(
    $lang['movie_mv1'],
    $lang['movie_mv2'],
    $lang['movie_mv3'],
    $lang['movie_mv4'],
    $lang['movie_mv5'],
    $lang['movie_mv6'],
    $lang['movie_mv7']
);
for ($x = 0; $x < count($movie); $x++) {
    $HTMLOUT.= "<label><input type=\"checkbox\" value=\"$movie[$x]\"  name=\"movie[]\" class=\"DEPENDS ON genre BEING movie\" />$movie[$x]</label>";
}
$music = array(
    $lang['music_m1'],
    $lang['music_m2'],
    $lang['music_m3'],
    $lang['music_m4'],
    $lang['music_m5'],
    $lang['music_m6']
);
for ($x = 0; $x < count($music); $x++) {
    $HTMLOUT.= "<label><input type=\"checkbox\" value=\"$music[$x]\" name=\"music[]\" class=\"DEPENDS ON genre BEING music\" />$music[$x]</label>";
}
$game = array(
    $lang['game_g1'],
    $lang['game_g2'],
    $lang['game_g3'],
    $lang['game_g4'],
    $lang['game_g5']
);
for ($x = 0; $x < count($game); $x++) {
    $HTMLOUT.= "<label><input type=\"checkbox\" value=\"$game[$x]\" name=\"game[]\" class=\"DEPENDS ON genre BEING game\" />$game[$x]</label>";
}
$apps = array(
    $lang['app_mv1'],
    $lang['app_mv2'],
    $lang['app_mv3'],
    $lang['app_mv4'],
    $lang['app_mv5'],
    $lang['app_mv6'],
    $lang['app_mv7']
);
for ($x = 0; $x < count($apps); $x++) {
    $HTMLOUT.= "<label><input type=\"checkbox\" value=\"$apps[$x]\" name=\"apps[]\" class=\"DEPENDS ON genre BEING apps\" />$apps[$x]</label>";
}
$HTMLOUT.= "</table></div></div>";
$HTMLOUT.= "<div class='row'><div class='col-sm-4 col-sm-offset-4'><input type='submit' value='{$lang['edit_submit']}' class='btn' /> <input type='reset' value='{$lang['edit_revert']}' class='btn' /></div></div>";
$HTMLOUT.="<br></div></div></form>";
$HTMLOUT.= "
    <br />
<div class='row'><div class='col-sm-12'>
    <form method='post' action='delete.php'>
    <table class='table table-bordered'>
    <tr>
      <td class='colhead' style='background-color: #F5F4EA;padding-bottom: 5px' colspan='2'><b>{$lang['edit_delete_torrent']}.</b> {$lang['edit_reason']}</td>
    </tr>
    <tr>
      <td><input name='reasontype' type='radio' value='1' />&nbsp;{$lang['edit_dead']} </td><td> {$lang['edit_peers']}</td>
    </tr>
    <tr>
      <td><input name='reasontype' type='radio' value='2' />&nbsp;{$lang['edit_dupe']}</td><td><input type='text' size='40' name='reason[]' /></td>
    </tr>
    <tr>
      <td><input name='reasontype' type='radio' value='3' />&nbsp;{$lang['edit_nuked']}</td><td><input type='text' size='40' name='reason[]' /></td>
    </tr>
    <tr>
      <td><input name='reasontype' type='radio' value='4' />&nbsp;{$lang['edit_rules']}</td><td><input type='text' size='40' name='reason[]' />({$lang['edit_req']})</td>
    </tr>
    <tr>
      <td><input name='reasontype' type='radio' value='5' checked='checked' />&nbsp;{$lang['edit_other']}</td><td><input type='text' size='40' name='reason[]' />({$lang['edit_req']})<input type='hidden' name='id' value='$id' /></td>
    </tr>";
if (isset($_GET["returnto"])) {
    $HTMLOUT.= "<input type='hidden' name='returnto' value='" . htmlsafechars($_GET["returnto"]) . "' />\n";
}
$HTMLOUT.= "<tr><td colspan='2' align='center'><input type='submit' value='{$lang['edit_delete']}' class='btn' /></td>
    </tr>
    </table>
    </form></div></div>";
//////////////////////////// HTML OUTPIT ////////////////////////////////
echo stdhead("{$lang['edit_stdhead']} '{$row["name"]}'", true, $stdhead) . $HTMLOUT . stdfoot($stdfoot);
?>
