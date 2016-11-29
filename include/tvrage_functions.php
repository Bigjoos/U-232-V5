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
//tvrage functions
$INSTALLER09['tvrage_api'] = 'NxDOrw2uadOgyLuDtmaR';
function tvrage_format($tvrage_data, $tvrage_type)
{
    $tvrage_display['show'] = array(
        'showname' => '<b>%s</b>',
        'showlink' => '%s',
        'startdate' => 'Started: %s',
        'ended' => 'Ended: %s',
        'origin_country' => 'Country: %s',
        'status' => 'Status: %s',
        'classification' => 'Classification: %s',
        'summary' => 'Summary:<br/> %s',
        'runtime' => 'Runtime %s min',
        'genres' => 'Genres: %s'
    );
    $tvrage_display['episode'] = array(
        'episode' => 'This week episode: %s "%s" on %s<br/>%s<br/>Summary: %s',
        'nextepisode' => 'Next episode: %s "%s" on %s %s %s'
    );
    foreach ($tvrage_data as $key => $data) {
        if (!isset($tvrage_display[$tvrage_type][$key])) continue;
        $tvrage_display[$tvrage_type][$key] = is_string($data) ? sprintf($tvrage_display[$tvrage_type][$key], $data) : sprintf($tvrage_display[$tvrage_type][$key], $data['number'], $data['title'], date('M/d/Y - l', strtotime($data['airdate'])) , (isset($data['url']) ? $data['url'] : '') , (isset($data['summary']) ? $data['summary'] : ''));
    }
    if (!isset($tvrage_data['ended'])) unset($tvrage_display[$tvrage_type]['ended']);
    return join('<br/><br/>', $tvrage_display[$tvrage_type]);
}
function tvrage(&$torrents)
{
    global $mc1, $INSTALLER09;
    $tvrage_data = '';
    $row_update = array();
    if (preg_match("/^(.*)S(\d+)(E(\d+))?/", $torrents['name'], $tmp)) $tvrage = array(
        'name' => str_replace('.', ' ', $tmp[1]) ,
        'season' => (int)$tmp[2],
        'episode' => (int)(isset($tmp[4]) ? $tmp[4] : 0)
    );
    else $tvrage = array(
        'name' => str_replace('.', ' ', $torrents['name']) ,
        'season' => 0,
        'episode' => 0
    );
    $memkey = 'tvrage::' . strtolower($tvrage['name']);
    if (($tvrage_id = $mc1->get_value($memkey)) === false) {
        //get tvrage id
        $tvrage_link = sprintf('http://services.tvrage.com/myfeeds/search.php?key=%s&show=%s', $INSTALLER09['tvrage_api'], urlencode($tvrage['name']));
        $tvrage_xml = file_get_contents($tvrage_link);
        if (preg_match('/\<showid\>(\d+)<\/showid\>/', $tvrage_xml, $tmp)) {
            $tvrage_id = $tmp[1];
            $mc1->cache_value($memkey, $tvrage_id, 0);
        } else return false;
    }
    $force_update = false;
    if (empty($torrents['newgenre']) || empty($torrents['poster'])) $force_update = true;
    $memkey = 'tvrage::' . $tvrage_id;
    if ($force_update || ($tvrage_showinfo = $mc1->get_value($memkey)) === false) {
        //var_dump('Show from tvrage'); //debug
        //get tvrage show info
        $tvrage_link = sprintf('http://services.tvrage.com/myfeeds/showinfo.php?key=%s&sid=%d', $INSTALLER09['tvrage_api'], $tvrage_id);
        $tvrage_xml = file_get_contents($tvrage_link);
        preg_match_all('/\<(showname|showlink|startdate|ended|image|origin_country|status|classification|summary|airtime|runtime)\>(.+)\<\/\\1\>/s', $tvrage_xml, $tmp, PREG_SET_ORDER);
        foreach ($tmp as $data) {
            if (!$data[2]) continue;
            $tvrage_showinfo[$data[1]] = $data[2];
        }
        preg_match_all('/\<genre\>(.*?)\<\/genre>/', $tvrage_xml, $tmp);
        if (count($tmp[1])) $tvrage_showinfo['genres'] = join(', ', array_map('strtolower', $tmp[1]));
        if (empty($torrents['newgenre'])) $row_update[] = 'newgenre = ' . sqlesc(ucwords($tvrage_showinfo['genres']));
        //==The torrent cache
        $mc1->begin_transaction('torrent_details_' . $torrents['id']);
        $mc1->update_row(false, array(
            'newgenre' => ucwords($tvrage_showinfo['genres'])
        ));
        $mc1->commit_transaction(0);
        if (empty($torrents['poster'])) $row_update[] = 'poster = ' . sqlesc($tvrage_showinfo['image']);
        //==The torrent cache
        $mc1->begin_transaction('torrent_details_' . $torrents['id']);
        $mc1->update_row(false, array(
            'poster' => $tvrage_showinfo['image']
        ));
        $mc1->commit_transaction(0);
        if (count($row_update)) sql_query('UPDATE torrents set ' . join(', ', $row_update) . ' WHERE id = ' . $torrents['id']) or sqlerr(__FILE__, __LINE__);
        $tvrage_showinfo = tvrage_format($tvrage_showinfo, 'show') . '<br/>';
        $mc1->cache_value($memkey, $tvrage_showinfo, 0);
        $tvrage_data.= $tvrage_showinfo;
    } else {
        //var_dump('Show from mem'); //debug
        $tvrage_data.= $tvrage_showinfo;
    }
    //check to see if its a show its an episode
    if ($tvrage['season'] > 0 && $tvrage['episode'] > 0) {
        $memkey = 'tvrage::' . $tvrage_id . '::' . $tvrage['season'] . 'x' . $tvrage['episode'];
        if (($tvrage_epinfo = $mc1->get_value($memkey)) === false) {
            //var_dump('Ep from tvrage'); //debug
            //get episode info
            $tvrage_link = sprintf('http://services.tvrage.com/myfeeds/episodeinfo.php?key=%s&sid=%d&ep=%dx%d', $INSTALLER09['tvrage_api'], $tvrage_id, $tvrage['season'], $tvrage['episode']);
            $tvrage_xml = file_get_contents($tvrage_link);
            preg_match_all('/\<(episode|nextepisode)\>(.*?)\<\/\\1\>/', $tvrage_xml, $tmp, PREG_SET_ORDER);
            foreach ($tmp as $data) {
                preg_match_all('/\<(number|title|airdate|url|summary)\>(.*?)\<\/\\1\>/s', $data[2], $tmp_1, PREG_SET_ORDER);
                foreach ($tmp_1 as $data_1) $tvrage_epinfo[$data[1]][$data_1[1]] = $data_1[2];
            }
            $tvrage_epinfo = tvrage_format($tvrage_epinfo, 'episode') . '<br/>';
            $mc1->cache_value($memkey, $tvrage_epinfo, 0);
            $tvrage_data.= $tvrage_epinfo;
        } else {
            //var_dump('Ep from mem'); //debug
            $tvrage_data.= $tvrage_epinfo;
        }
    }
    return $tvrage_data;
}
?>