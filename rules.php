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
require_once (INCL_DIR . 'bbcode_functions.php');
dbconn(false);
loggedinorreturn();
$lang = array_merge(load_language('global'), load_language('rules'));
$HTMLOUT = '';
$HTMLOUT.= "<div><h1 class='text-center'>{$lang['rules_welcome']}</h1></div>";
$HTMLOUT.= "<div class='panel inverse'>";
$HTMLOUT.= "<table class='table table-bordered table-striped'><tr><td class='embedded'>
    <h2>{$lang['rules_contents_header']}</h2>
 <ul id='myTab' class='nav nav-pills'>";
$count = 0;
$rules = array();
if (($rules = $mc1->get_value('rules__')) === false) {
$q = sql_query("SELECT rules_cat.id, rules_cat.name, rules_cat.shortcut, rules_cat.min_view, rules.type, rules.title, rules.text FROM rules_cat LEFT JOIN rules ON rules.type=rules_cat.id WHERE rules_cat.min_view <=" . sqlesc($CURUSER['class']));
while ($item = mysqli_fetch_assoc($q)) $rules[] = $item;
$mc1->cache_value('rules__', $rules, $INSTALLER09['expires']['rules']);
}
foreach ($rules as $row) {
    if ($count == 6) $HTMLOUT.= "<div style='display:block;height:50px;'></div>";
    if ($count == 0) $HTMLOUT.= "<li class='active'>";
    else $HTMLOUT.= "<li>";
    $HTMLOUT.= "<a href='#".htmlsafechars($row['shortcut'])."' data-toggle='tab'>".htmlsafechars($row['name'])."</a></li>";
    $count++;
}
$HTMLOUT.= "</ul>
<hr />
<div style='display:block;height:20px;'></div>
<div id='myTabContent' class='tab-content'>";
$count = 0;
foreach ($rules as $row) {
    $HTMLOUT.= "<div class='tab-pane fade " . ($count == 0 ? "in active" : "") . "' id='".htmlsafechars($row['shortcut'])."'>
      <p><h2>".htmlsafechars($row['name'])."</h2></p><p>";
    $HTMLOUT.= "<b>".htmlsafechars($row['title'])."</b><br /><br />".htmlspecialchars_decode($row['text'])."<br /><br /><br />";
    $HTMLOUT.= "</p></div>";
    $count++;
}
$HTMLOUT.= "</table>";
$HTMLOUT.= "</div>";
/////////////////////// HTML OUTPUT ///////////////////////
echo stdhead('Rules') . $HTMLOUT . stdfoot();
?>
