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
		</tr>' : '') . ($user['google_talk'] !== '' ? '
		<tr>
			<td class="rowhead">' . $lang['userdetails_gtalk'] . '</td>
			<td align="left"><a class="altlink" href="http://talkgadget.google.com/talkgadget/popout?member=' . htmlsafechars($user['google_talk']) . '" title="' . $lang['userdetails_gtalk_click'] . '"  target="_blank"><img src="pic/forums/google_talk.gif" alt="google_talk" />' . $lang['userdetails_open'] . '</a></td>
		</tr>' : '') . ($user['msn'] !== '' ? '
		<tr>
			<td class="rowhead">' . $lang['userdetails_msn'] . '</td>
			<td align="left"><a class="altlink" href="http://members.msn.com/' . htmlsafechars($user['msn']) . '" target="_blank" title="' . $lang['userdetails_msn_click'] . '"><img src="pic/forums/msn.gif" alt="msn" />' . $lang['userdetails_open'] . '</a></td>
		</tr>' : '') . ($user['yahoo'] !== '' ? '
		<tr>
			<td class="rowhead">' . $lang['userdetails_yahoo'] . '</td>
			<td align="left"><a class="altlink" href="http://webmessenger.yahoo.com/?im=' . htmlsafechars($user['yahoo']) . '" target="_blank" title="' . $lang['userdetails_yahoo_click'] . '"><img src="pic/forums/yahoo.gif" alt="yahoo" />' . $lang['userdetails_open'] . '</a></td>
		</tr>' : '') . ($user['aim'] !== '' ? '
		<tr>
			<td class="rowhead">' . $lang['userdetails_aim'] . '</td>
			<td align="left"><a class="altlink" href="http://aim.search.aol.com/aol/search?s_it=searchbox.webhome&amp;q=' . htmlsafechars($user['aim']) . '" target="_blank" title="' . $lang['userdetails_aim_click'] . '"><img src="pic/forums/aim.gif" alt="AIM" />' . $lang['userdetails_open'] . '</a></td>
		</tr>' : '') . ($user['icq'] !== '' ? '
		<tr>
			<td class="rowhead">' . $lang['userdetails_icq'] . '</td>
			<td align="left"><a class="altlink" href="http://people.icq.com/people/&amp;uin=' . htmlsafechars($user['icq']) . '" title="' . $lang['userdetails_icq_click'] . '" target="_blank"><img src="pic/forums/icq.gif" alt="icq" />' . $lang['userdetails_open'] . '</a></td>
		</tr>' : '') . ($user['website'] !== '' ? '
		<tr>
			<td class="rowhead">' . $lang['userdetails_website'] . '</td>
			<td align="left"><a class="altlink" href="' . htmlsafechars($user['website']) . '" target="_blank" title="' . $lang['userdetails_website_click'] . '"><img src="pic/forums/www.gif" width="18" alt="website" /> ' . htmlsafechars($user['website']) . '</a></td>
		</tr>' : '');
//==end
// End Class
// End File
