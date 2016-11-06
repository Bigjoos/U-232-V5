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
dbconn(false);
loggedinorreturn();
$lang = array_merge(load_language('global') , load_language('links'));
function add_link($url, $title, $description = "")
{
    $text = "<a class='altlink' href=$url>$title</a>";
    if ($description) $text = "$text - $description";
    return "<li>$text</li>\n";
}
$HTMLOUT = '';
if ($CURUSER) {
    $HTMLOUT.= "{$lang['links_dead']}";
}
$HTMLOUT.= "<table class='table table-bordered'><tr><td class='embedded'>";
$HTMLOUT.= "{$lang['links_other_pages_header']}
    <table class='table table-bordered'><tr><td class='text'><ul>
    {$lang['links_other_pages_body']}
    </ul></td></tr></table>";
$HTMLOUT.= "{$lang['links_bt_header']}
    <table class='table table-bordered'><tr><td class='text'><ul>
    {$lang['links_bt_body']}
    </ul></td></tr></table>";
$HTMLOUT.= "{$lang['links_software_header']}
    <table class='table table-bordered'><tr><td class='text'><ul>
    {$lang['links_software_body']}
    </ul></td></tr></table>";
$HTMLOUT.= "{$lang['links_download_header']}
    <table class='table table-bordered'><tr><td class='text'><ul>
    {$lang['links_download_body']}
    </ul></td></tr></table>";
$HTMLOUT.= "{$lang['links_forums_header']}
    <table class='table table-bordered'><tr><td class='text'><ul>
   {$lang['links_forums_body']}
    </ul></td></tr></table>";
$HTMLOUT.= "{$lang['links_other_header']}
    <table class='table table-bordered'><tr><td class='text'><ul>
    {$lang['links_other_body']}
    </ul></td></tr></table>";
$HTMLOUT.= "{$lang['links_tbdev_header']}>
    <table class='table table-bordered'><tr><td class='text'>
    {$lang['links_tbdev_body']}
    </td></tr></table>";
$HTMLOUT.= "</td></tr></table>";
echo stdhead("Links") . $HTMLOUT . stdfoot();
?>
