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
$lang = array_merge(load_language('global'), load_language('faq'));
$HTMLOUT = '<div class="panel panel-default">';
$HTMLOUT.= "<div class='panel-heading'>{$lang['faq_welcome']}</div>";
$HTMLOUT.= "<div class='panel panel-default'>";
$HTMLOUT.= "<table class='table table-bordered table-striped'><tr><td class='embedded'><h2>{$lang['faq_contents_header']}</h2><ul id='myTab' class='nav nav-pills'>";
$count = 0;
$cats = array();
$q = sql_query("SELECT * FROM faq_cat WHERE min_view <=" . sqlesc($CURUSER['class']));
while ($item = mysqli_fetch_assoc($q)) {
    $cats[] = $item;
}
foreach ($cats as $row) {
    if ($count == 9) $HTMLOUT.= "<div style='display:block;height:50px;'></div>";
    if ($count == 0) $HTMLOUT.= "<li class='active'>";
    else $HTMLOUT.= "<li>";
    $HTMLOUT.= "<a href='#".htmlsafechars($row['shortcut'])."' data-toggle='tab'>".htmlsafechars($row['name'])."</a></li>";
    $count++;
}
$HTMLOUT.= "</ul>
<hr />
<div style='display:block;height:20px;'></div>
<div id='myTabContent' class='panel panel-body tab-content'>";
$count = 0;
if (($faqs = $mc1->get_value('faqs__')) === false) {
    $faqs = array();
    $q2 = sql_query("SELECT * FROM faq");
    while ($row = mysqli_fetch_assoc($q2)) $faqs[] = $row;
    $mc1->cache_value('faqs__', $faqs, $INSTALLER09['expires']['faqs']);
}
foreach ($cats as $row) {
    $HTMLOUT.= "<div class='tab-pane fade " . ($count == 0 ? "in active" : "") . "' id='".htmlsafechars($row['shortcut'])."'>
      <p><h2>".htmlsafechars($row['name'])."</h2></p><p>";    
    foreach ($faqs as $item) {
        if($item['type'] == $row['id']){
            $item['text'] = str_replace(array(
                "SITE_NAME",
                "SITE_PIC_URL",
                "BASE_URL",
                "  "
                ) , array(
                "{$INSTALLER09['site_name']}",
                "{$INSTALLER09['pic_base_url']}",
                "{$INSTALLER09['baseurl']}",
                "&nbsp; "
                ) , $item['text']); 
        
                $HTMLOUT.= "<b>".htmlspecialchars_decode($item['title'])."</b><br />
            <br />".htmlspecialchars_decode($item['text'])."<br />
            <br />
            <br />";
        }
    }
    $HTMLOUT.= "</p></div>";
    $count++;
}
$HTMLOUT.= "</table>";
$HTMLOUT.= "</div></div>";
/////////////////////// HTML OUTPUT ///////////////////////
echo stdhead('FAQ') . $HTMLOUT . stdfoot();
?>
