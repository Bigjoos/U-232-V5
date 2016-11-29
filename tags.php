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
require_once (INCL_DIR . 'html_functions.php');
dbconn();
loggedinorreturn();
$lang = array_merge(load_language('global') , load_language('tags'));
function insert_tag($name, $description, $syntax, $example, $remarks)
{
    global $lang;
    $result = format_comment($example);
    $htmlout = '';
    $htmlout.= "<div class='sub'><b>$name</b></div>\n";
    $htmlout.= "<table class='main' width='100%' border='1' cellspacing='0' cellpadding='5'>\n";
    $htmlout.= "<tr valign='top'><td width='25%'>{$lang['tags_description']}</td><td>$description</td></tr>\n";
    $htmlout.= "<tr valign='top'><td>{$lang['tags_systax']}</td><td><tt>$syntax</tt></td></tr>\n";
    $htmlout.= "<tr valign='top'><td>{$lang['tags_example']}</td><td><tt>$example</tt></td></tr>\n";
    $htmlout.= "<tr valign='top'><td>{$lang['tags_result']}</td><td>$result</td></tr>\n";
    if ($remarks != "") $htmlout.= "<tr><td>{$lang['tags_remarks']}</td><td>$remarks</td></tr>\n";
    $htmlout.= "</table>\n";
    return $htmlout;
}
$HTMLOUT = '';
$HTMLOUT.= begin_main_frame();
$HTMLOUT.= begin_frame("Tags");
$test = isset($_POST["test"]) ? $_POST["test"] : '';
$HTMLOUT.= "{$lang['tags_title']}

    <form method='post' action='?'>
    <textarea name='test' cols='60' rows='3'>" . ($test ? htmlspecialchars($test) : "") . "</textarea>
    <input type='submit' value='{$lang['tags_test']}' style='height: 23px; margin-left: 5px' />
    </form>";
if ($test != "") $HTMLOUT.= "<p><hr>" . format_comment($test) . "<hr></p>\n";
$HTMLOUT.= insert_tag($lang['tags_bold1'], $lang['tags_bold2'], $lang['tags_bold3'], $lang['tags_bold4'], "");
$HTMLOUT.= insert_tag($lang['tags_italic1'], $lang['tags_italic2'], $lang['tags_italic3'], $lang['tags_italic4'], "");
$HTMLOUT.= insert_tag($lang['tags_underline1'], $lang['tags_underline2'], $lang['tags_underline3'], $lang['tags_underline4'], "");
$HTMLOUT.= insert_tag($lang['tags_color1'], $lang['tags_color2'], $lang['tags_color3'], $lang['tags_color4'], $lang['tags_color5']);
$HTMLOUT.= insert_tag($lang['tags_color6'], $lang['tags_color7'], $lang['tags_color8'], $lang['tags_color9'], $lang['tags_color10']);
$HTMLOUT.= insert_tag($lang['tags_size1'], $lang['tags_size2'], $lang['tags_size3'], $lang['tags_size4'], $lang['tags_size5']);
$HTMLOUT.= insert_tag($lang['tags_fonts1'], $lang['tags_fonts2'], $lang['tags_fonts3'], $lang['tags_fonts4'], $lang['tags_fonts5']);
$HTMLOUT.= insert_tag($lang['tags_hyper1'], $lang['tags_hyper2'], $lang['tags_hyper3'], $lang['tags_hyper4'], $lang['tags_hyper5']);
$HTMLOUT.= insert_tag($lang['tags_hyper6'], $lang['tags_hyper7'], $lang['tags_hyper8'], $lang['tags_hyper9'], $lang['tags_hyper10']);
$HTMLOUT.= insert_tag($lang['tags_image1'], $lang['tags_image2'], $lang['tags_image3'], $lang['tags_image4'], $lang['tags_image5']);
$HTMLOUT.= insert_tag($lang['tags_image6'], $lang['tags_image7'], $lang['tags_image8'], $lang['tags_image9'], $lang['tags_image10']);
$HTMLOUT.= insert_tag($lang['tags_quote1'], $lang['tags_quote2'], $lang['tags_quote3'], $lang['tags_quote4'], "");
$HTMLOUT.= insert_tag($lang['tags_quote5'], $lang['tags_quote6'], $lang['tags_quote7'], $lang['tags_quote8'], "");
$HTMLOUT.= insert_tag($lang['tags_list1'], $lang['tags_list2'], $lang['tags_list3'], $lang['tags_list4'], "");
$HTMLOUT.= insert_tag($lang['tags_preformat1'], $lang['tags_preformat2'], $lang['tags_preformat3'], $lang['tags_preformat4'], "");
$HTMLOUT.= end_frame();
$HTMLOUT.= end_main_frame();
echo stdhead("{$lang['tags_tags']}") . $HTMLOUT . stdfoot();
?>
