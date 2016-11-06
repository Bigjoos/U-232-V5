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
require_once (__DIR__ . DIRECTORY_SEPARATOR . 'include' . DIRECTORY_SEPARATOR . 'bittorrent.php');
require_once (INCL_DIR . 'user_functions.php');
//require_once (INCL_DIR . 'html_functions.php');

$radio = array(
    'host' => '',
    'port' => '',
    'password' => ''
);
$langs = array(
    'CURRENTLISTENERS' => 'Current listeners: <b>%d</b>',
    'SERVERTITLE' => 'Server: <b>%s</b>',
    'SERVERURL' => 'Server url: <b>%s' .'</b>',
    'SONGTITLE' => 'Current song: <b>%s</b>',
    'BITRATE' => 'Bitrate: <b>%s kb</b>',
    'BITRATE' => 'Bitrate: <b>%s kb</b>',
    'PEAKLISTENERS' => 'Peak listeners: <b>%d</b>',
);
function radioinfo($radio)
{
    global $langs, $INSTALLER09, $mc1, $CURUSER;
    $xml = $html = $history = '';
    if ($hand = @fsockopen($radio['host'], $radio['port'], $errno, $errstr, 30)) {
        fputs($hand, "GET /admin.cgi?pass=" . $radio['password'] . "&mode=viewxml HTTP/1.1\nUser-Agent:Mozilla/5.0 " . "(Windows; U; Windows NT 6.1; en-GB; rv:1.9.2.6) Gecko/20100625 Firefox/3.6.6\n\n");
        while (!feof($hand)) $xml.= fgets($hand, 1024);
        preg_match_all('/\<(SERVERTITLE|SERVERURL|SONGTITLE|STREAMSTATUS|BITRATE|CURRENTLISTENERS|PEAKLISTENERS)\>(.*?)<\/\\1\>/iU', $xml, $tempdata, PREG_SET_ORDER);
        foreach ($tempdata as $t2) $data[$t2[1]] = isset($langs[$t2[1]]) ? sprintf($langs[$t2[1]], $t2[2]) : $t2[2];
        unset($tempdata);
        preg_match_all('/\<SONG>(.*?)<\/SONG\>/', $xml, $temph);
        unset($temph[0][0], $temph[1]);
        $history = array();
        foreach ($temph[0] as $temph2) {
            preg_match_all('/\<(TITLE|PLAYEDAT)>(.*?)<\/\\1\>/i', $temph2, $temph3, PREG_PATTERN_ORDER);
            $history[] = '<b>&nbsp;' . $temph3[2][1] . '</b> <sub>(' . get_date($temph3[2][0], 'DATE') . ')</sub>';
        }
        preg_match_all('/\<HOSTNAME>(.*?)<\/HOSTNAME>/', $xml, $temph);
        if (count($temph[1])) $users_ip = join(', ', array_map('sqlesc', $temph[1]));
        if ($data['STREAMSTATUS'] == 0) return 'Sorry ' . $CURUSER['username'] . '... : Server ' . $radio['host'] . ' is online but there is no stream';
        else {
            unset($data['STREAMSTATUS']);
            $md5_current_song = md5($data['SONGTITLE']);
            $current_song = $mc1->get('current_radio_song');
            if ($current_song === false || $current_song != $md5_current_song) {
                autoshout(str_replace(array('<','>'),array('[',']'),$data['SONGTITLE'].' playing on '.strtolower($data['SERVERTITLE']).' - '.strtolower($data['SERVERURL'])));
                $mc1->cache_value('current_radio_song', $md5_current_song, 0);
            }
            $html = '<fieldset>
                <legend>' . $INSTALLER09['site_name'] . ' radio</legend><ul>';
            foreach ($data as $d) $html.= '<li><b>' . $d . '</b></li>';
            $html.= '<li><b>Playlist history: </b> ' . (count($history) > 0 ? join(', ', $history) : 'No playlist history') . '</li>';
            if (empty($users_ip) === false) {
                $q1 = sql_query('SELECT id, username, paranoia FROM users WHERE ip IN (' . $users_ip . ') ORDER BY username ASC') or sqlerr(__FILE__, __LINE__);
                if (mysqli_num_rows($q1) == 0) $html.= '<li><b>Listeners</b>: currently no listener from site </li>';
                else {
                    $users = array();
                    while ($a1 = mysqli_fetch_assoc($q1)) $users[] = ($a1['paranoia'] < 1 || $CURUSER['id'] == $a1['id'] || $CURUSER['class'] >= UC_STAFF) ? sprintf('<a href="/userdetails.php?id=%d">%s</a>', $a1['id'], $a1['username']) : 'Anonymous';
                    $html.= '<li><b>Listeners</b>: ' . join(', ', $users) . '</li>';
                }
            }
            $html.= '</ul></fieldset>';
            return $html;
        }
    } else $html.= '<fieldset><legend>' . $INSTALLER09['site_name'] . ' radio</legend>
    <font size="3" color="red"><img src="' . $INSTALLER09['pic_base_url'] . 'off1.gif" alt="Off" title="Off" border="0" /><br />
    <b>Sorry ' . $CURUSER['username'] . ' Radio is currently Offline</b></font></fieldset><br />';
    //echo strval ($STREAMSTATUS);
    return $html;
}
?>
