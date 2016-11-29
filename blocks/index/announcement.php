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
// Announcement Code...
   $ann_subject = trim($CURUSER['curr_ann_subject']);
   $ann_body = trim($CURUSER['curr_ann_body']);
   if ((!empty($ann_subject)) AND (!empty($ann_body)))
   {
   $HTMLOUT .= "<div class='headline'>{$lang['index_announce']}</div>
   <div class='headbody'>
   <table width='100%' border='1' cellspacing='0' cellpadding='5'>
   <tr><td bgcolor='transparent'><b><font color='red'>{$lang['index_ann_title']}&nbsp;: 
   ".htmlsafechars($ann_subject)."</font></b></td></tr>
   <tr><td style='padding: 10px; background:lightgrey'>
   ".format_comment($ann_body)."
   <br /><hr /><br />
   {$lang['index_ann_click']}<a href='{$INSTALLER09['baseurl']}/clear_announcement.php'>
   <i><b>{$lang['index_ann_here']}</b></i></a>{$lang['index_ann_clear']}</td></tr></table></div><br />\n";
   }
//==End
// End Class
// End File
