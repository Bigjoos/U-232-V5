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
//=== member contact stuff
$HTMLOUT.= (($CURUSER['class'] >= UC_STAFF || $user['show_email'] === 'yes') ? '
		<tr>
			<td class="rowhead">' . $lang['userdetails_email'] . '</td>
			<td align="left"><a class="altlink" href="mailto:' . /*decrypt_email(*/htmlsafechars($user['email'])/*)*/ . '"  title="' . $lang['userdetails_email_click'] . '" target="_blank"><img src="pic/email.gif" alt="email" width="25" />' . $lang['userdetails_send_email'] . '</a></td>
		</tr>' : '');
//==end
// End Class
// End File
