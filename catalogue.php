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
|   $Date$ 030810
|   $Revision$ 2.0
|   $Author$ EnzoF1,putyn,Bigjoos
|   $URL$
|   $catalogue
|   
+------------------------------------------------
*/
require_once(__DIR__ . DIRECTORY_SEPARATOR . 'include' . DIRECTORY_SEPARATOR . 'bittorrent.php');
require_once(INCL_DIR . 'user_functions.php');
require_once(INCL_DIR . 'bbcode_functions.php');
require_once INCL_DIR . 'html_functions.php';
require_once INCL_DIR . 'pager_functions.php';

dbconn(false);
loggedinorreturn();
$lang = array_merge(load_language('global'), load_language('catalogue'));
$htmlout = '';
function readMore($text, $char, $link)
{
    global $INSTALLER09, $lang;
    return (strlen($text) > $char ? substr(htmlsafechars($text), 0, $char - 1) . "...<br /><a href='$link'>{$lang['catol_read_more']}</a>" : htmlsafechars($text));
}
function peer_list($array)
{
    global $INSTALLER09, $lang;
    $htmlout = '';
    $htmlout .= "
            {$lang['catol_user']}            {$lang['catol_port']}&amp;{$lang['catol_ip']}            {$lang['catol_ratio']}            {$lang['catol_downloaded']}            {$lang['catol_uploaded']}            {$lang['catol_started']}            {$lang['catol_finished']}       </tr>-->";
    foreach ($array as $p) {
        $time = max(1, (TIME_NOW - $p["started"]) - (TIME_NOW - $p["last_action"]));
        $htmlout .= "
            <a href='userdetails.php?id=" . (int) $p["p_uid"] . "' >" . htmlsafechars($p["p_user"]) . "</a>            
" . ($CURUSER['class'] >= UC_STAFF ? htmlsafechars($p["ip"]) . " : " . (int) $p["port"] : "xx.xx.xx.xx:xxxx") . "            
" . ($p["downloaded"] > 0 ? number_format(($p["uploaded"] / $p["downloaded"]), 2) : ($p["uploaded"] > 0 ? "&infin;" : "---")) . "            
" . ($p["downloaded"] > 0 ? mksize($p["downloaded"]) . " @" . (mksize(($p["downloaded"] - $p["downloadoffset"]) / $time)) . "s" : "0kb") . "            
" . ($p["uploaded"] > 0 ? mksize($p["uploaded"]) . " @" . (mksize(($p["uploaded"] - $p["uploadoffset"]) / $time)) . "s" : "0kb") . "            
" . (get_date($p["started"], 'LONG', 0, 1)) . "            <td align='center'>" . (get_date($p["finishedat"], 'LONG', 0, 1)) . "  ";
    
}
    $htmlout .= "";
    return $htmlout;
}
$letter = (isset($_GET["letter"]) ? htmlsafechars($_GET["letter"]) : "");
$search = (isset($_GET["search"]) ? htmlsafechars($_GET["search"]) : "");
if (strlen($search) > 4) {
    $where = "WHERE t.name LIKE" . sqlesc("%" . $search . "%");
    $p = "search=" . $search . "&amp;";
} elseif (strlen($letter) == 1 && strpos("abcdefghijklmnopqrstuvwxyz", $letter) !== false) {
    $where = "WHERE t.name LIKE '" . $letter . "%'";
    $p = "letter=" . $letter . "&amp;";
} else {
    $where = "WHERE t.name LIKE 'a%'";
    $p = "letter=a&amp;";
    $letter = "a";
}
$count = mysqli_fetch_row(sql_query("SELECT count(*) FROM torrents AS t $where"));
$perpage = 12;
$pager = pager($perpage, $count[0], $_SERVER["PHP_SELF"] . "?" . $p);
//$tid='';
//$rows='';
//$top = '';
//$bottom = '';
$rows = array();
$tids = array();
$t = sql_query("SELECT t.id,t.name,t.leechers,t.seeders,t.poster,t.times_completed as snatched,t.owner,t.size,t.added,t.descr, u.username as user FROM torrents as t LEFT JOIN users AS u on u.id=t.owner $where ORDER BY t.name ASC " . $pager['limit']) or sqlerr(__FILE__, __LINE__);
while ($ta = mysqli_fetch_assoc($t)) {
    $rows[] = $ta;
    $tid[] = (int) $ta["id"];
}
if (isset($tids) && count($tids)) {
    $p = sql_query("SELECT p.id,p.torrent as tid,p.seeder, p.finishedat, p.downloadoffset, p.uploadoffset, p.ip, p.port, p.uploaded, p.downloaded, p.started AS started, p.last_action AS last_action, u.id as p_uid , u.username as p_user FROM peers AS p LEFT JOIN users as u on u.id=p.userid WHERE p.torrent IN (" . join(",", $tid) . ") AND p.seeder = 'yes' AND to_go=0 LIMIT 5") or sqlerr(__FILE__, __LINE__);
    while ($pa = mysqli_fetch_assoc($p))
        $peers[$pa["tid"]][] = $pa;
}

$htmlout .= "<div class='row'><div class='col-md-12'>
        <fieldset style='border:2px solid #333333;'>
            <div class='row'><div class='col-md-8 col-md-push-2'><h4 class='text-center'>{$lang['catol_search']}</h4>
                <form  action='" . $_SERVER["PHP_SELF"] . "' method='get' style='margin:10px;'>
                    <input type='text' size='100' name='search' value='" . ($search ? $search : "{$lang['catol_search_for_tor']}") . "' onblur=\"if (this.value == '') this.value='{$lang['catol_search_for_tor']}';\" onfocus=\"if (this.value == '{$lang['catol_search_for_tor']}') this.value='';\" />&nbsp;<input type='submit' value='search!' />
                </form></div></div>";
$htmlout .= "<div class='row'><div class='col-md-8 col-md-push-4'>";
for ($i = 97; $i < 123; ++$i) {
    $l = chr($i);
    $L = chr($i - 32);
    if ($l == $letter)
        $htmlout .= "<font class=\"sublink-active\">$L</font>\n";
    else
        $htmlout .= "<a class=\"sublink\" href=\"" . $_SERVER["PHP_SELF"] . "?letter=" . $l . "\">" . $L . "</a>\n";
$htmlout .= "<!--</div></div>-->";
}
$htmlout .= "</fieldset></div></div><br>";

$htmlout .="<div class='container'>";
if (count($rows) > 0) {
    $htmlout .= "<div class='row'><div class='col-md-10'>" . $pager['pagerbottom'] ."</div><br><br><div class='col-md-2 col-md-push-0'><a class='btn btn-default btn-link' title='Back to Browse' href='" . $INSTALLER09['baseurl'] . "/browse.php'>Back to Browse</a></div></div>";
    $htmlout .= "<h3 class='text-center'>{$lang['catol_std_head']}</h3>";
$htmlout .="<div class='row'>";
    foreach ($rows as $row) {
        $htmlout .= "<div class='panel col-sm-3 col-sm-offset-0 panel-default browsep'>
        <div style='display:block; height:5px;'></div>

  	<p class='browsed text-center'><b><font color='rgb(67,158,76)'>{$lang['catol_upper']} :</font></b>&nbsp;<a href='userdetails.php?id=" . (int) $row["owner"] . "'>" . ($row["user"] ? htmlsafechars($row["user"]) : "{$lang['catol_unknown']}[" . (int) $row["owner"] . "]") . "</a></p>

	<p class='browsepd text-center'>" . ($row["poster"] ? "<a href=\"" . htmlsafechars($row["poster"]) . "\"><img src=\"" . htmlsafechars($row["poster"]) . "\" border=\"0\" width=\"150\" height=\"225\" alt=\"{$lang['catol_no_poster']}\" title=\"{$lang['catol_no_poster']}\" /></a>" : "<img src=\"pic/noposter.png\" border=\"0\" width=\"150\" alt=\"{$lang['catol_no_poster']}\" title=\"{$lang['catol_no_poster']}\" />") . "</p>
  
<p  class='squashp browsepd text-center'><b><font color='rgb(67,158,76)'>Torrent:</font></b>&nbsp;<a href='details.php?id=" . (int) $row["id"] . "&amp;hit=1'><b>" . substr(htmlsafechars($row["name"]), 0, 60) . "</b></a></p>
	
";


  $htmlout .= "<div class=''>
<p><b><font color='rgb(67,158,76)'>{$lang['catol_added']}:</font></b>&nbsp;" . get_date($row["added"], 'LONG', 0, 1) . "<br>
           <b><font color='rgb(67,158,76)'>{$lang['catol_size']}:</font></b>&nbsp;" . (mksize($row["size"])) . "<br >
           <b><font color='rgb(67,158,76)'>{$lang['catol_snatched']}:</font></b>&nbsp;" . ($row["snatched"] > 0 ? ($row["snatched"] == 1 ? (int) $row["snatched"] . " time" : (int) $row["snatched"] . " times") : 0) . "<br>
           <b><font color='rgb(67,158,76)'>Seeds:</font></b>&nbsp;" . (int) $row["seeders"] . "<br>
           <b><font color='rgb(67,158,76)'>Leechers:</font></b>&nbsp;" . (int) $row["leechers"] . "<br>
          </p>
  	<p class='squashp'><b><font color='rgb(67,158,76)'>{$lang['catol_info']}:</font></b>&nbsp;" . readMore($row["descr"], 500, "details.php?id=" . (int) $row["id"] . "&amp;hit=1") . "</p>
  	<!--<p><b><font color='rgb(67,158,76)'>{$lang['catol_seeder_info']}:</font></b>" . (isset($peers[$row["id"]]) ? peer_list($peers[$row["id"]]) : "{$lang['catol_no_info_show']}") . "</p>-->
	<p><b><font color='rgb(67,158,76)'>{$lang['catol_orig_created_by']}</font></b></p></div></div>";
 }
$htmlout .= "</div></div><br>";
$htmlout .= $pager['pagerbottom'] ."<br>";
} else
    $htmlout .= "<div class='row'><div class='col-sm-04'><h2>{$lang['catol_nothing_found']}!</h2></div></div>";
echo stdhead($lang['catol_std_head']) . $htmlout . stdfoot();
?>
