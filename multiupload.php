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
        'multiupload'
    )
);
if (function_exists('parked')) parked();
$newpage = new page_verify();
$newpage->create('tamud');
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
    <form class='form-horizontal well' role='form' name='upload' enctype='multipart/form-data' action='./takemultiupload.php' method='post'>
 <div class='row'>
<div class='col-sm-12'><input class='form-control' type='hidden' name='MAX_FILE_SIZE' value='{$INSTALLER09['max_torrent_size']}'></div>
</div>
<div class='row'>
<div class='col-sm-3 col-sm-offset-1 text-right'>{$lang['upload_announce_url']}:</div>
<div class='col-sm-5'><input type=\"text\" class=\"form-control textonly\" readonly value=\"" . $INSTALLER09['announce_urls'][0] . "\" onclick=\"select()\" /></div></div><br>";
$descr = strip_tags(isset($_POST['descr']) ? trim($_POST['descr']) : '');
$HTMLOUT.= "<div class='torrent-seperator clone-me'>
<div class='row'>
<div class='col-md-4'>{$lang['upload_torrent']}<input class='btn btn-default btn-adjust' type='file' name='file[]' id='torrent' onchange='getname()'></div>
<div class='col-md-4'>{$lang['upload_nfo']}<input class='btn btn-default btn-adjust' type='file' name='nfo[]'>({$lang['upload_nfo_info']})</div>";
$HTMLOUT .= "<div class='col-md-4'>Type<select class='form-control' name='type[]'>\n<option value='0'>({$lang['upload_choose_one']})</option>\n";
$cats = genrelist();
foreach ($cats as $row) {
    $HTMLOUT.= "<option value='" . (int)$row["id"] . "'>" . htmlsafechars($row["name"]) . "</option>\n";
}
$HTMLOUT.= "</select></div></div>";
$HTMLOUT.= "</div>";
$HTMLOUT .= "<div class='torrent-seperator'><br><br><div class='row'><div class='col-sm-12 text-left'>";
$HTMLOUT .= "<a href='#' class='btn btn-default clone-torrent-form'>Add another torrent</a>";
$HTMLOUT.= "</div></div></div>";
$HTMLOUT.= "<div style='display:inline-block;height:50%;'></div><div class='row'><div class='col-sm-12 col-sm-offset-5'><input type='submit' class='btn btn-default' value='{$lang['upload_submit']}'></div></div>
     </br></form><br>";
////////////////////////// HTML OUTPUT //////////////////////////
echo stdhead($lang['upload_stdhead'], true, $stdhead) . $HTMLOUT . stdfoot($stdfoot);
?>
