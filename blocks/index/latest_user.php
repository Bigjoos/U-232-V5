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
/** latestuser index **/
if (($latestuser_cache = $mc1->get_value('latestuser')) === false) {
    $latestuser_cache = mysqli_fetch_assoc(sql_query('SELECT id, username, class, donor, warned, enabled, chatpost, leechwarn, pirate, king FROM users WHERE status="confirmed" ORDER BY id DESC LIMIT 1'));
    $latestuser_cache['id'] = (int)$latestuser_cache['id'];
    $latestuser_cache['class'] = (int)$latestuser_cache['class'];
    $latestuser_cache['warned'] = (int)$latestuser_cache['warned'];
    $latestuser_cache['chatpost'] = (int)$latestuser_cache['chatpost'];
    $latestuser_cache['leechwarn'] = (int)$latestuser_cache['leechwarn'];
    $latestuser_cache['pirate'] = (int)$latestuser_cache['pirate'];
    $latestuser_cache['king'] = (int)$latestuser_cache['king'];
    $mc1->cache_value('latestuser', $latestuser_cache, $INSTALLER09['expires']['latestuser']);
}
$latestuser = '<div class="panel panel-default">
	<div class="panel-heading">
		<label for="checkbox_4" class="text-left">' . $lang['index_lmember'] . '</label>
	</div>
	<div class="panel-body">
		' . $lang['index_wmember'] . '
		<b>' . format_username($latestuser_cache) . '!</b>
		</div></div>';
//==MemCached latest user
$HTMLOUT.= $latestuser ."";
//==End	
// End Class
// End File
