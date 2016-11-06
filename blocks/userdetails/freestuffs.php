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
//==Freeleech info
$HTMLOUT.= "<tr><td class='rowhead'>{$lang['userdetails_freeleech_slots']}</td><td align='left'>" . (int)$user['freeslots'] . "</td></tr>";
$HTMLOUT.= "<tr><td class='rowhead'>{$lang['userdetails_freeleech_status']}</td><td align='left'>" . ($user['free_switch'] != 0 ? $lang['userdetails_fstatus'] . ($user['free_switch'] > 1 ? $lang['userdetails_fexpire'] . get_date($user['free_switch'], 'DATE') . ' (' . mkprettytime($user['free_switch'] - TIME_NOW) . '' . $lang['userdetails_ftogo'] . ') <br />' : '' . $lang['userdetails_funlimited'] . '<br />') : $lang['userdetails_fnone']) . "</td></tr>";
//==end
// End Class
// End File
