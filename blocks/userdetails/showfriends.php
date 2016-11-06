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
//== Users friends list
$dt = TIME_NOW - 180;
$keys['user_friends'] = 'user_friends_' . $id;
if (($users_friends = $mc1->get_value($keys['user_friends'])) === false) {
    $fr = sql_query("SELECT f.friendid as uid, f.userid AS userid, u.last_access, u.id, u.ip, u.avatar, u.username, u.class, u.donor, u.title, u.warned, u.enabled, u.chatpost, u.leechwarn, u.pirate, u.king, u.downloaded, u.uploaded, u.perms FROM friends AS f LEFT JOIN users as u ON f.friendid = u.id WHERE userid=" . sqlesc($id) . " ORDER BY username ASC LIMIT 100") or sqlerr(__file__, __line__);
    while ($user_friends = mysqli_fetch_assoc($fr)) $users_friends[] = $user_friends;
    $mc1->cache_value($keys['user_friends'], $users_friends, 0);
}
if (count($users_friends) > 0) {
    $user_friends = "<table width='100%' class='main' border='1' cellspacing='0' cellpadding='5'>\n" . "<tr><td class='colhead' width='20'>{$lang['userdetails_avatar']}</td><td class='colhead'>{$lang['userdetails_username']}" . ($CURUSER['class'] >= UC_STAFF ? $lang['userdetails_fip'] : "") . "</td><td class='colhead' align='center'>{$lang['userdetails_uploaded']}</td>" . ($INSTALLER09['ratio_free'] ? "" : "<td class='colhead' align='center'>{$lang['userdetails_downloaded']}</td>") . "<td class='colhead' align='center'>{$lang['userdetails_ratio']}</td><td class='colhead' align='center'>{$lang['userdetails_status']}</td></tr>\n";
    if ($users_friends) {
        foreach ($users_friends as $a) {
            $avatar = (($user['opt1'] & user_options::AVATARS) ? ($a['avatar'] == '' ? '<img src="' . $INSTALLER09['pic_base_url'] . 'default_avatar.gif"  width="40" alt="default avatar" />' : '<img src="' . htmlsafechars($a['avatar']) . '" alt="avatar"  width="40" />') : '');
            $status = "<img style='vertical-align: middle;' src='{$INSTALLER09['pic_base_url']}" . ($a['last_access'] > $dt && $a['perms'] < bt_options::PERMS_STEALTH ? "online.png" : "offline.png") . "' border='0' alt='' />";
            $user_stuff = $a;
            $user_stuff['id'] = (int)$a['id'];
            $user_friends.= "<tr><td class='one' style='padding: 0px; border: none' width='40px'>" . $avatar . "</td><td class='one'>" . format_username($user_stuff) . "<br />" . ($CURUSER['class'] >= UC_STAFF ? "" . htmlsafechars($a['ip']) . "" : "") . "</td><td class='one' style='padding: 1px' align='center'>" . mksize($a['uploaded']) . "</td>" . ($INSTALLER09['ratio_free'] ? "" : "<td class='one' style='padding: 1px' align='center'>" . mksize($a['downloaded']) . "</td>") . "<td class='one' style='padding: 1px' align='center'>" . member_ratio($a['uploaded'], $INSTALLER09['ratio_free'] ? '0' : $a['downloaded']) . "</td><td class='one' style='padding: 1px' align='center'>" . $status . "</td></tr>\n";
        }
        $user_friends.= "</table>";
        $HTMLOUT.= "<tr><td class='rowhead' width='1%'>{$lang['userdetails_friends']}</td><td align='left' width='99%'><a href=\"javascript: klappe_news('a6')\"><img border=\"0\" src=\"pic/plus.png\" id=\"pica6" . (int)$a['uid'] . "\" alt=\"{$lang['userdetails_hide_show']}\" title=\"{$lang['userdetails_hide_show']}\" /></a><div id=\"ka6\" style=\"display: none;\"><br />$user_friends</div></td></tr>";
    } else {
        if (empty($users_friends)) $HTMLOUT.= "<tr><td colspan='2'>{$lang['userdetails_no_friends']}</td></tr>";
    }
}
//== thee end
//==end
// End Class
// End File
