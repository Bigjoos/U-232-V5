<?php
/**
 |--------------------------------------------------------------------------|
 |   https://github.com/Bigjoos/                			    |
 |--------------------------------------------------------------------------|
 |   Licence Info: GPL						            |
 |--------------------------------------------------------------------------|
 |   Copyright (C) 2010 U-232 V5				            |
 |--------------------------------------------------------------------------|
 |   A bittorrent tracker source based on TBDev.net/tbsource/bytemonsoon.   |
 |--------------------------------------------------------------------------|
 |   Project Leaders: Mindless, Autotron, whocares, Swizzles.		    |
 |--------------------------------------------------------------------------|
  _   _   _   _   _     _   _   _   _   _   _     _   _   _   _
 / \ / \ / \ / \ / \   / \ / \ / \ / \ / \ / \   / \ / \ / \ / \
( U | - | 2 | 3 | 2 )-( S | o | u | r | c | e )-( C | o | d | e )
 \_/ \_/ \_/ \_/ \_/   \_/ \_/ \_/ \_/ \_/ \_/   \_/ \_/ \_/ \_/
 */
// happy hour
if(XBT_TRACKER == false OR $INSTALLER09['happy_hour'] == true) {
if ($CURUSER) {
    require_once (INCL_DIR . 'function_happyhour.php');
    if (happyHour("check")) {
        $htmlout.= "
        <li>
        <a class='sa-tooltip' href='browse.php?cat=" . happyCheck("check") . "'><b class='btn btn-success btn-sm'>{$lang['gl_happyhour']}</b>
		<span class='custom info alert alert-success'>
        {$lang['gl_happyhour1']}<br /> " . ((happyCheck("check") == 255) ? "{$lang['gl_happyhour2']}" : "{$lang['gl_happyhour3']}") . "<br /><font color='red'><b> " . happyHour("time") . " </b></font> {$lang['gl_happyhour4']}</span></a></li>";
    }
}
}
//==
// End Class
// End File
