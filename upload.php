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
require_once (dirname(__FILE__) . DIRECTORY_SEPARATOR . 'include' . DIRECTORY_SEPARATOR . 'bittorrent.php');
require_once (INCL_DIR . 'user_functions.php');
require_once INCL_DIR . 'html_functions.php';
require_once INCL_DIR . 'bbcode_functions.php';
require_once CLASS_DIR . 'page_verify.php';
require_once (CACHE_DIR . 'subs.php');
dbconn(true);
loggedinorreturn();
$lang = array_merge(load_language('global') , load_language('upload'));
$stdhead = array(
    /** include css **/
    'css' => array(
        'forums',
        'style2',
        'bbcode'
    )
);
$stdfoot = array(
    /** include js **/
    'js' => array(
         'FormManager',
        'getname',
        'shout'
    )
);
if (function_exists('parked')) parked();
$newpage = new page_verify();
$newpage->create('taud');
$HTMLOUT = $offers = $subs_list = $request = $descr = '';
if ($CURUSER['class'] < UC_UPLOADER OR $CURUSER["uploadpos"] == 0 || $CURUSER["uploadpos"] > 1 || $CURUSER['suspended'] == 'yes') stderr($lang['upload_sorry'], $lang['upload_no_auth']);
//==== request dropdown
$res_request = sql_query('SELECT id, request_name FROM requests WHERE filled_by_user_id = 0 ORDER BY request_name ASC');
$request ='
<div class="col-sm-4">Requests<select class="form-control" name="request"><option class="body" value="0"></option>';

if ($res_request) {
    while ($arr_request = mysqli_fetch_assoc($res_request)) {
        $request.= '<option class="body" value="' . (int)$arr_request['id'] . '">' . htmlsafechars($arr_request['request_name']) . '</option>';
    }
} else {
    $request.= '<option class="body" value="0">Currently no requests</option>';
}
$request.= '</select>If you are filling a request,select it here so interested members can be notified.</div> ';
//=== offers list if member has made any offers
$res_offer = sql_query('SELECT id, offer_name FROM offers WHERE offered_by_user_id = ' . sqlesc($CURUSER['id']) . ' AND status = \'approved\' ORDER BY offer_name ASC');
if (mysqli_num_rows($res_offer) > 0) {
    $offers = '  
   <div class="row"><div class="col-sm-12"><select class="form-control" name="offer"><option class="body" value="0"></option>';
    $message = '<option class="body" value="0">Your have no approved offers yet</option>';
    while ($arr_offer = mysqli_fetch_assoc($res_offer)) {
        $offers.= '<option class="body" value="' . (int)$arr_offer['id'] . '">' . htmlsafechars($arr_offer['offer_name']) . '</option>';
    }
    $offers.= '</select></div></div> If you are uploading one of your offers, please select it here so interested members will be notified.';
}
$HTMLOUT.= "
    <script type='text/javascript'>
    window.onload = function() {
    setupDependencies('upload'); //name of form(s). Seperate each with a comma (ie: 'weboptions', 'myotherform' )
    };
    </script>
<div style='width:82%; margin-left:9%;'> 
    <form class='form-horizontal panel inverse' role='form' name='upload' enctype='multipart/form-data' action='./takeupload.php' method='post'>
 <div class='row'>
<div class='col-sm-12'><input class='form-control' type='hidden' name='MAX_FILE_SIZE' value='{$INSTALLER09['max_torrent_size']}'></div>
</div>
<div class='row'>
<div class='col-sm-3 col-sm-offset-1' style='text-align:right;'>{$lang['upload_announce_url']}:</div>
<div class='col-sm-5'><input type=\"text\" class=\"form-control textonly\" value=\"" . $INSTALLER09['announce_urls'][0] . "\" onclick=\"select()\" /></div></div><br>";
$descr = strip_tags(isset($_POST['descr']) ? trim($_POST['descr']) : '');
$HTMLOUT.= "<div class='row'>
<div class='col-sm-12'><input class='form-control' placeholder='{$lang['upload_imdb_url']}' type='text' name='url'>{$lang['upload_imdb_tfi']}{$lang['upload_imdb_rfmo']}</div>
</div><br>
<div class='row'>
<div class='col-sm-12'><input class='form-control' placeholder='{$lang['upload_poster']}' type='text' name='poster'>{$lang['upload_poster1']}</div>
</div><br>
<div class='row'>
<div class='col-sm-12'>
<input class='form-control' placeholder='Place your Youtube link in here.Link should look like http://www.youtube.com/watch?v=camI8yuoy8U' type='text' name='youtube'>{$lang['upload_youtube']}</div>
</div><br>
<div class='row'>
<div class='col-sm-2'>{$lang['upload_bitbucket']}</div><br>
<div class='col-sm-5'><p class='shrink'><iframe class='embed-responsive1' src='imgup.html'></iframe></p>{$lang['upload_bitbucket_1']}</div>
</div><br>
<div class='row'>
<div class='col-sm-12'>  
{$lang['upload_torrent']}<input class='btn btn-default btn-adjust' type='file' name='file' id='torrent' onchange='getname()'></div>
</div><br>
<div class='row'>
<div class='col-sm-12'>  
<input class='form-control' placeholder='{$lang['upload_name']}' type='text' id='name' name='name'>({$lang['upload_filename']})</div>
</div><br>
<div class='row'>
<div class='col-sm-12'>    
<input class='form-control' placeholder='{$lang['upload_tags']}' type='text' name='tags'>({$lang['upload_tag_info']})</div>  
</div><br>
<div class='row'>
<div class='col-sm-12'> 
<input class='form-control' placeholder='{$lang['upload_small_description']}' type='text' name='description'>({$lang['upload_small_descr']})</div>
</div><br>
<div class='row'>
<div class='col-sm-12'> 
{$lang['upload_nfo']}<input class='btn btn-default btn-adjust' type='file' name='nfo'>({$lang['upload_nfo_info']})</div>
</div><br>
<div class='row'>
<div class='col-sm-8'> 
<p style='white-space: nowrap;'>{$lang['upload_description']}</p><p>". textbbcode("upload","descr")."<br />({$lang['upload_html_bbcode']})</p></div></div>";
$s = "<div class='row'><div class='col-sm-4'>Type<select class='form-control' name='type'>\n<option value='0'>({$lang['upload_choose_one']})</option>\n";
$cats = genrelist();
foreach ($cats as $row) {
    $s.= "<option value='" . (int)$row["id"] . "'>" . htmlsafechars($row["name"]) . "</option>\n";
}
$s.= "</select></div>";
$rg = "<div class='col-sm-4'>Release Type<select class='form-control' name='release_group'>\n<option value='none'>None</option>\n<option value='p2p'>p2p</option>\n<option value='scene'>Scene</option>\n</select></div></div><br>";
$HTMLOUT.= "$s";
$HTMLOUT.=$request;
$HTMLOUT.=$rg;
$HTMLOUT.= $offers;
if ($CURUSER['class'] >= UC_UPLOADER AND XBT_TRACKER == false) {
    $HTMLOUT.= "<br><div class='row'>
<div class='col-sm-4'>Free Leech  
    <select class='form-control' name='free_length'>
    <option value='0'>Not Free</option>
    <option value='42'>Free for 1 day</option>
    <option value='1'>Free for 1 week</option>
    <option value='2'>Free for 2 weeks</option>
    <option value='4'>Free for 4 weeks</option>
    <option value='8'>Free for 8 weeks</option>
    <option value='255'>Unlimited</option>
    </select></div>";
    $HTMLOUT.= "<div class='col-sm-4'>Silver Torrent   
    <select class='form-control' name='half_length'>
    <option value='0'>Not Silver</option>
    <option value='42'>Silver for 1 day</option>
    <option value='1'>Silver for 1 week</option>
    <option value='2'>Silver for 2 weeks</option>
    <option value='4'>Silver for 4 weeks</option>
    <option value='8'>Silver for 8 weeks</option>
    <option value='255'>Unlimited</option>
    </select></div>";
    $HTMLOUT.= "<div class='col-sm-4'>Vip Torrent <br><input type='checkbox' name='vip' value='1'><br>If this one is checked, only Vip's can download this torrent</div></div><br>";
}
$subs_list.= "";
$i = 0;
foreach ($subs as $s) {
    $subs_list.= ($i && $i % 4 == 0) ? "" : "";
    $subs_list.= "<label class='checkbox-inline'><input name=\"subs[]\" type=\"checkbox\" value=\"" . (int)$s["id"] . "\" />" . htmlsafechars($s["name"]) . "</label>";
    ++$i;
}
$subs_list.= "";
$HTMLOUT.= "<div class='row'><div class='col-sm-5'>Subtitle<br>$subs_list</div>";
//== 09 Genre mod no mysql by Traffic
$HTMLOUT.= "<div class='col-sm-5'><p>
   Genre
<p>
    <input type='radio' name='genre' value='movie'>Movie
   <input type='radio' name='genre' value='music'>Music
  <input type='radio' name='genre' value='game'>Game
    <input type='radio' name='genre' value='apps'>Apps
    <input type='radio' name='genre' value='' checked='checked'>None
   </p>
    
    <p colspan='4' style='border:none;'>
    <label style='margin-bottom: 1em; padding-bottom: 1em; border-bottom: 3px silver groove;'>
    <input type='hidden' class='Depends on genre being movie or genre being music' /></label>";
$movie = array(
    'Action',
    'Comedy',
    'Thriller',
    'Adventure',
    'Family',
    'Adult',
    'Sci-fi'
);
for ($x = 0; $x < count($movie); $x++) {
    $HTMLOUT.= "<label><input type=\"checkbox\" value=\"$movie[$x]\"  name=\"movie[]\" class=\"DEPENDS ON genre BEING movie\" />$movie[$x]</label>";
}
$music = array(
    'Hip Hop',
    'Rock',
    'Pop',
    'House',
    'Techno',
    'Commercial'
);
for ($x = 0; $x < count($music); $x++) {
    $HTMLOUT.= "<label><input type=\"checkbox\" value=\"$music[$x]\" name=\"music[]\" class=\"DEPENDS ON genre BEING music\" />$music[$x]</label>";
}
$game = array(
    'Fps',
    'Strategy',
    'Adventure',
    '3rd Person',
    'Acton'
);
for ($x = 0; $x < count($game); $x++) {
    $HTMLOUT.= "<label><input type=\"checkbox\" value=\"$game[$x]\" name=\"game[]\" class=\"DEPENDS ON genre BEING game\" />$game[$x]</label>";
}
$apps = array(
    'Burning',
    'Encoding',
    'Anti-Virus',
    'Office',
    'Os',
    'Misc',
    'Image'
);
for ($x = 0; $x < count($apps); $x++) {
    $HTMLOUT.= "<label><input type=\"checkbox\" value=\"$apps[$x]\" name=\"apps[]\" class=\"DEPENDS ON genre BEING apps\" />$apps[$x]</label>";
}
$HTMLOUT.= "</p></p></div></div>";
//== End
$HTMLOUT.="<br><div class='row'>";
$HTMLOUT.= "<div class='col-sm-3'>{$lang['upload_anonymous']}<br><input type='checkbox' name='uplver' value='yes' id='chk1'><br>{$lang['upload_anonymous1']}</div>";
if ($CURUSER['class'] == UC_MAX) {
    $HTMLOUT.= "<div class='col-sm-3'>{$lang['upload_comment']}<br><input type='checkbox' name='allow_commentd' value='yes' id='chk2'><br>{$lang['upload_discom1']}</div>";
}
$HTMLOUT.= "<div class='col-sm-3'>Strip ASCII<br><input type='checkbox' name='strip' value='strip' checked='checked' id='chk3'><br><a href='http://en.wikipedia.org/wiki/ASCII_art' target='_blank'>What is this?</a></div>";

if (XBT_TRACKER == true) {
        $HTMLOUT.= "<div class='col-sm-3'>Freeleech<br><input type='checkbox' name='freetorrent' value='1'><br>Check this to make this torrent freeleech</div>";
    }
$HTMLOUT.="</div>";
$HTMLOUT.= "<div style='display:inline-block;height:50%;'></div><div class='row'><div class='col-sm-12 col-sm-offset-5'><input type='submit' class='btn btn-default' value='{$lang['upload_submit']}'></div></div>
     </br></form></div><br>";
////////////////////////// HTML OUTPUT //////////////////////////
echo stdhead($lang['upload_stdhead'], true, $stdhead) . $HTMLOUT . stdfoot($stdfoot);
?>
