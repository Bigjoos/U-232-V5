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
// pdq 2010
function invincible($id, $invincible = true, $bypass_bans = true)
{
    global $CURUSER, $mc1, $INSTALLER09;
	$lang = load_language('invincible_function');
    $ip = '127.0.0.1';
    $setbits = $clrbits = 0;
    if ($invincible) {
        $display = $lang['invincible_now'];
        $setbits|= bt_options::PERMS_NO_IP; // don't log IPs
        if ($bypass_bans) $setbits|= bt_options::PERMS_BYPASS_BAN; // bypass ban on
        else {
            $clrbits|= bt_options::PERMS_BYPASS_BAN; // bypass ban off
            $display = $lang['invincible_now_bypass'];
        }
    } else {
        $display = $lang['invincible_no_longer'];
        $clrbits|= bt_options::PERMS_NO_IP; // log IPs
        $clrbits|= bt_options::PERMS_BYPASS_BAN; // bypass ban off
    }
    // update perms
    if ($setbits || $clrbits) sql_query('UPDATE users SET perms = ((perms | ' . $setbits . ') & ~' . $clrbits . ') 
                 WHERE id = ' . sqlesc($id)) or sqlerr(__file__, __line__);
    // grab current data
    $res = sql_query('SELECT username, torrent_pass, ip, perms, modcomment FROM users 
                     WHERE id = ' . sqlesc($id) . ' LIMIT 1') or sqlerr(__file__, __line__);
    $row = mysqli_fetch_assoc($res);
    $row['perms'] = (int)$row['perms'];
    // delete from iplog current ip
    sql_query('DELETE FROM `ips` WHERE userid = ' .sqlesc($id)) or sqlerr(__file__, __line__);
    // delete any iplog caches
    $mc1->delete_value('ip_history_' . $id);
    $mc1->delete_value('u_passkey_' . $row['torrent_pass']);
    // update ip in db
    $modcomment = get_date(TIME_NOW, '', 1) . ' - ' . $display . $lang['invincible_thank_to'] . $CURUSER['username'] . "\n" . $row['modcomment'];
    //ipf = '.sqlesc($ip).',
    sql_query('UPDATE users SET ip = ' . sqlesc($ip) . ', modcomment = ' . sqlesc($modcomment) . '
              WHERE id = ' . sqlesc($id)) or sqlerr(__file__, __line__);
    //'ipf'   => $ip,
    // update ip in caches
    //$mc1->delete_value('user'.$id);
    $mc1->begin_transaction('user' . $id);
    $mc1->update_row(false, array(
        'ip' => $ip,
        'perms' => $row['perms']
    ));
    $mc1->commit_transaction($INSTALLER09['expires']['user_cache']);
    $mc1->begin_transaction('MyUser_' . $id);
    $mc1->update_row(false, array(
        'ip' => $ip,
        'perms' => $row['perms']
    ));
    $mc1->commit_transaction($INSTALLER09['expires']['curuser']);
    $mc1->begin_transaction('user_stats_' . $id);
    $mc1->update_row(false, array(
        'modcomment' => $modcomment
    ));
    $mc1->commit_transaction($INSTALLER09['expires']['user_stats']);
    //'ipf'   => $ip,
    if ($id == $CURUSER['id']) {
        $mc1->begin_transaction('user' . $CURUSER['id']);
        $mc1->update_row(false, array(
            'ip' => $ip,
            'perms' => $row['perms']
        ));
        $mc1->commit_transaction($INSTALLER09['expires']['user_cache']);
        $mc1->begin_transaction('MyUser_' . $CURUSER['id']);
        $mc1->update_row(false, array(
            'ip' => $ip,
            'perms' => $row['perms']
        ));
        $mc1->commit_transaction($INSTALLER09['expires']['curuser']);
        $mc1->begin_transaction('user_stats_' . $CURUSER['id']);
        $mc1->update_row(false, array(
            'modcomment' => $modcomment
        ));
        $mc1->commit_transaction($INSTALLER09['expires']['user_stats']);
    }
    write_log(''.$lang['invincible_member'].'[b][url=userdetails.php?id=' . $id . ']' . (htmlsafechars($row['username'])) . '[/url][/b]' . $lang['invincible_is'] . ' ' . $display . ' ' . $lang['invincible_thanks_to1'] . ' [b]' . $CURUSER['username'] . '[/b]');
    // header ouput
    $mc1->cache_value('display_' . $CURUSER['id'], $display, 5);
    header('Location: userdetails.php?id=' . $id);
    exit();
}
?>
