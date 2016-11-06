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
//==Start birthdayusers pdq
$current_date = getdate();
$keys['birthdayusers'] = 'birthdayusers';
if (($birthday_users_cache = $mc1->get_value($keys['birthdayusers'])) === false) {
    $birthdayusers = '';
    $birthday_users_cache = array();
    $res = sql_query("SELECT id, username, class, donor, title, warned, enabled, chatpost, leechwarn, pirate, king, birthday, perms FROM users WHERE MONTH(birthday) = " . sqlesc($current_date['mon']) . " AND DAYOFMONTH(birthday) = " . sqlesc($current_date['mday']) . " AND perms < " . bt_options::PERMS_STEALTH . " ORDER BY username ASC") or sqlerr(__FILE__, __LINE__);
    $actcount = mysqli_num_rows($res);
    while ($arr = mysqli_fetch_assoc($res)) {
        if ($birthdayusers) $birthdayusers.= ",";
        $birthdayusers.= '<b>' . format_username($arr) . '</b>';
    }
    $birthday_users_cache['birthdayusers'] = $birthdayusers;
    $birthday_users_cache['actcount'] = $actcount;
    $mc1->cache_value($keys['birthdayusers'], $birthday_users_cache, $INSTALLER09['expires']['birthdayusers']);
}
if (!$birthday_users_cache['birthdayusers']) $birthday_users_cache['birthdayusers'] = $lang['index_birthday_no'];
$birthday_users ='<div class="panel panel-default">
	<div class="panel-heading">
		<label for="checkbox_4" class="text-left">' . $lang['index_birthday'] . '&nbsp;&nbsp;<span class="badge btn btn-success disabled" style="color:#fff">' . $birthday_users_cache['actcount'] . '</span></label>
	</div>
	<div class="panel-body">' . $birthday_users_cache['birthdayusers'] . '</div></div>';
$HTMLOUT.= $birthday_users ."";
//==End
// End Class
// End File
