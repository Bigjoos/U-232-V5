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
/* Flush all torrents mod */
//=== flush torrents staff or members own torrents
if ($CURUSER['class'] >= UC_STAFF || $CURUSER['id'] == $user['id']) {
    $HTMLOUT.= '<tr valign="top"><td class="rowhead"><a name="flush"></a>' . $lang['userdetails_flush_title'] . '</td>
			<td align="left">
			<form method="post" id="form" action="" name="flush_thing">
			<input id="id" type="hidden" value="' . (int)$user['id'] . '" name="id" />
			<input id="action2" type="hidden" value="flush_torrents" name="action2" />
			<span id="success" style="display:none;color:green;font-weight: bold;">' . $lang['userdetails_flush_system'] . '<br />
			' . $lang['userdetails_flush_please'] . '</span>
			<span id="flush_error" style="display:none;color:red;font-weight: bold;">' . $lang['userdetails_flush_error'] . '<br />
			' . $lang['userdetails_flush_try'] . '</span>
			<span id="flush">' . $lang['userdetails_flush_ensure'] . '
			<br /><input id="flush_button" type="submit" value="' . $lang['userdetails_flush_btn'] . '" class="btn" name="flush_button"/>
			<br /><span style="font-size: x-small;color:red;">' . $lang['userdetails_flush_all'] . '</span></span>
			</form>
			</td></tr>';
}
//==end
// End Class
// End File
