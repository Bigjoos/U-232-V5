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
//==Uploaded/downloaded
if ($user['paranoia'] < 2 || $CURUSER['id'] == $id || $CURUSER['class'] >= UC_STAFF) {
    $days = round((TIME_NOW - $user['added']) / 86400);
    if ($INSTALLER09['ratio_free']) {
        $HTMLOUT.= "<tr><td class='rowhead'>{$lang['userdetails_h_days']}</td><td align='left'>{$lang['userdetails_rfree_effect']}</td></tr>
    <tr><td class='rowhead'>{$lang['userdetails_uploaded']}</td><td align='left'>" . mksize($user_stats['uploaded']) . " {$lang['userdetails_daily']}" . ($days > 1 ? mksize($user_stats['uploaded'] / $days) : mksize($user_stats['uploaded'])) . "</td></tr>\n";
    } else {
        $HTMLOUT.= "<tr><td class='rowhead'>{$lang['userdetails_downloaded']}</td><td align='left'>" . mksize($user_stats['downloaded']) . " {$lang['userdetails_daily']}" . ($days > 1 ? mksize($user_stats['downloaded'] / $days) : mksize($user_stats['downloaded'])) . "</td></tr>
    <tr><td class='rowhead'>{$lang['userdetails_uploaded']}</td><td align='left'>" . mksize($user_stats['uploaded']) . " {$lang['userdetails_daily']}" . ($days > 1 ? mksize($user_stats['uploaded'] / $days) : mksize($user_stats['uploaded'])) . "</td></tr>\n";
    }
}
//==end
// End Class
// End File
