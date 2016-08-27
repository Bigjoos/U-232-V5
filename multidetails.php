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
require_once (INCL_DIR . 'bbcode_functions.php');
require_once (INCL_DIR . 'pager_functions.php');
require_once (INCL_DIR . 'comment_functions.php');
require_once (INCL_DIR . 'html_functions.php');
require_once (INCL_DIR . 'function_rating.php');
require_once (INCL_DIR . 'tvrage_functions.php');
require_once (IMDB_DIR . 'imdb.class.php');
dbconn(false);
loggedinorreturn();
$lang = array_merge(load_language('global'), load_language('details'));
parked();
$stdhead = array(
    /** include css **/
    'css' => array(
	'bbcode',
        'details',
        'rating_style'
    )
);
$stdfoot = array(
    /** include js **/
    'js' => array(
        'popup',
        'jquery.thanks',
        'wz_tooltip',
        'java_klappe',
        'balloontip',
        'shout',
        'thumbs',
        'sack'
    )
);
$HTMLOUT = $torrent_cache = '';
if (!isset($_GET['id']) || !is_array($_GET['id'])) stderr("{$lang['details_user_error']}", "{$lang['details_bad_id']}");


//==pdq memcache slots
$slot = make_freeslots($CURUSER['id'], 'fllslot_');
$torrent['addedfree'] = $torrent['addedup'] = $free_slot = $double_slot = '';
if (!empty($slot)) foreach ($slot as $sl) {
    if ($sl['torrentid'] == $id && $sl['free'] == 'yes') {
        $free_slot = 1;
        $torrent['addedfree'] = $sl['addedfree'];
    }
    if ($sl['torrentid'] == $id && $sl['doubleup'] == 'yes') {
        $double_slot = 1;
        $torrent['addedup'] = $sl['addedup'];
    }
    if ($free_slot && $double_slot) break;
}




$HTMLOUT.= "<div class='alert alert-success col-md-11' align='center'><h2>{$lang['details_success']}</h2></div>\n";
$HTMLOUT.= "<p>{$lang['details_start_seeding']}</p>\n";

foreach($_GET['id'] as $id ) {

    $id = (int)$id;

    if (($torrents = $mc1->get_value('torrent_details_' . $id)) === false) {
        $tor_fields_ar_int = array(
            'id'
        );
        $tor_fields_ar_str = array(
            'name',
            'save_as',
            'url',
            'filename'
        );
        $tor_fields = implode(', ', array_merge($tor_fields_ar_int, $tor_fields_ar_str));
        $result = sql_query("SELECT " . $tor_fields . ", LENGTH(nfo) AS nfosz, IF(num_ratings < {$INSTALLER09['minvotes']}, NULL, ROUND(rating_sum / num_ratings, 1)) AS rating FROM torrents WHERE id = " . sqlesc($id)) or sqlerr(__FILE__, __LINE__);
        $torrents = mysqli_fetch_assoc($result);
        foreach ($tor_fields_ar_int as $i) $torrents[$i] = (int)$torrents[$i];
        foreach ($tor_fields_ar_str as $i) $torrents[$i] = $torrents[$i];

        $s = htmlsafechars($torrents["name"], ENT_QUOTES);

    }


    $HTMLOUT .="<div class='container'>
	<div class='row'>";

    $HTMLOUT .= "<div class='col-md-12'><h2>{$s}</h2></div>";

    $Free_Slot = (XBT_TRACKER == true ? '' : $freeslot);
    $Free_Slot_Zip = (XBT_TRACKER == true ? '' : $freeslot_zip);
    $Free_Slot_Text = (XBT_TRACKER == true ? '' : $freeslot_text);

    $HTMLOUT.= "<div class='col-md-12'>
	<table class='table table-bordered'>
			<tr>
			<td align=\"right\" class=\"heading\" width=\"3%\">{$lang['details_download']}</td>
			<td align=\"left\" class='details-text-ellipsis'>
			<a class=\"index\" href=\"download.php?torrent={$id}" . ($CURUSER['ssluse'] == 3 ? "&amp;ssl=1" : "") . "\">&nbsp;<u>" . htmlsafechars($torrents["filename"]) . "</u></a>{$Free_Slot}
			</td>
			</tr>";
    /** end **/
    //==Torrent as zip by putyn
    $HTMLOUT.= "<tr>
		<td>{$lang['details_zip']}</td>
		<td align=\"left\" class='details-text-ellipsis'>
		<a class=\"index\" href=\"download.php?torrent={$id}" . ($CURUSER['ssluse'] == 3 ? "&amp;ssl=1" : "") . "&amp;zip=1\">&nbsp;<u>" . htmlsafechars($torrents["filename"]) . "</u></a>{$Free_Slot_Zip}</td></tr>";
    //==Torrent as text by putyn
    $HTMLOUT.= "<tr>
		<td>{$lang['details_text']}</td>
		<td align=\"left\" class='details-text-ellipsis'>
		<a class=\"index\" href=\"download.php?torrent={$id}" . ($CURUSER['ssluse'] == 3 ? "&amp;ssl=1" : "") . "&amp;text=1\">&nbsp;<u>" . htmlsafechars($torrents["filename"]) . "</u></a>{$Free_Slot_Text}</td></tr></table>";

    $HTMLOUT.= "</div><!-- closnig col-md-8 --> </div><!-- closing row -->";
    $HTMLOUT .="</div><!-- closing tab pane -->";

}




 $HTMLOUT.="</div></div><div class='row'><div class='col-md-1'></div><div class='col-md-12'>";
//////////////////////// HTML OUTPUT ////////////////////////////
echo stdhead("{$lang['details_details']}\"" . htmlsafechars($torrents["name"], ENT_QUOTES) . "\"", true, $stdhead) . $HTMLOUT . stdfoot($stdfoot);
?>
