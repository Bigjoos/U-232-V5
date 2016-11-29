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
function calctime($val)
{
	global $lang;
    $days = intval($val / 86400);
    $val-= $days * 86400;
    $hours = intval($val / 3600);
    $val-= $hours * 3600;
    $mins = intval($val / 60);
    $secs = $val - ($mins * 60);
    return "<br>&nbsp;&nbsp;&nbsp;$days {$lang['gl_irc_days']}, $hours {$lang['gl_irc_hrs']}, $mins {$lang['gl_irc_min']}";
}
//== Start activeircusers pdq
$keys['activeircusers'] = 'activeircusers';
if (($active_irc_users_cache = $mc1->get_value($keys['activeircusers'])) === false) {
    $dt = $_SERVER['REQUEST_TIME'] - 180;
    $activeircusers = '';
    $active_irc_users_cache = array();
    $res = sql_query('SELECT id, username, irctotal, class, donor, title, warned, enabled, chatpost, leechwarn, pirate, king, perms ' . 'FROM users WHERE onirc = "yes" ' . 'AND perms < ' . bt_options::PERMS_STEALTH . ' ORDER BY username ASC') or sqlerr(__FILE__, __LINE__);
    $actcount = mysqli_num_rows($res);
    while ($arr = mysqli_fetch_assoc($res)) {
        if ($activeircusers) $activeircusers.= ",\n";
        $activeircusers.= '<b>' . format_username($arr) . '</b>';
        //$ircbonus   = (!empty($arr['irctotal'])?number_format($arr["irctotal"] / ($INSTALLER09['autoclean_interval'] * 4), 1):'0.0');
        //$irctotal = (!empty($arr['irctotal'])?calctime($arr['irctotal']):'');
        //$activeircusers .= '<span class="tool"><b>'.format_username($arr).'</b><span class="tip">'.$ircbonus.' points. - '.$irctotal.'</span></span>';
     }
    $active_irc_users_cache['activeircusers'] = $activeircusers;
    $active_irc_users_cache['actcount'] = $actcount;
    $mc1->cache_value($keys['activeircusers'], $active_irc_users_cache, $INSTALLER09['expires']['activeircusers']);
}
if (!$active_irc_users_cache['activeircusers']) $active_irc_users_cache['activeircusers'] = $lang['index_irc_nousers'];
$active_irc_users = '<div class="panel panel-default">
	<div class="panel-heading">
		<label for="checkbox_4" class="text-left">' . $lang['index_active_irc'] . '&nbsp;&nbsp;<span class="badge btn btn-success disabled" style="color:#fff">' . $active_irc_users_cache['actcount'] . '</span></label>
	</div>
	<div class="panel-body">
			  ' . $active_irc_users_cache['activeircusers'] . '
			 </div></div>';
$HTMLOUT.= $active_irc_users ."  ";
//==End
// End Class
// End File
