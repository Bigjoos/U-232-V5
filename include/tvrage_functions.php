<?php
/**
 * |--------------------------------------------------------------------------|
 * |   https://github.com/Bigjoos/                                            |
 * |--------------------------------------------------------------------------|
 * |   Licence Info: WTFPL                                                    |
 * |--------------------------------------------------------------------------|
 * |   Copyright (C) 2010 U-232 V5                                            |
 * |--------------------------------------------------------------------------|
 * |   A bittorrent tracker source based on TBDev.net/tbsource/bytemonsoon.   |
 * |--------------------------------------------------------------------------|
 * |   Project Leaders: Mindless, Autotron, whocares, Swizzles.               |
 * |--------------------------------------------------------------------------|
 * _   _   _   _   _     _   _   _   _   _   _     _   _   _   _
 * / \ / \ / \ / \ / \   / \ / \ / \ / \ / \ / \   / \ / \ / \ / \
 * ( U | - | 2 | 3 | 2 )-( S | o | u | r | c | e )-( C | o | d | e )
 * \_/ \_/ \_/ \_/ \_/   \_/ \_/ \_/ \_/ \_/ \_/   \_/ \_/ \_/ \_/
 */
//tvrage functions
$INSTALLER09['tvrage_api'] = 'NxDOrw2uadOgyLuDtmaR';
function tvrage_format($tvrage_data, $tvrage_type)
{
    $tvrage_display['show'] = [
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
    ];
    $tvrage_display['episode'] = [
        'episode' => 'This week episode: %s "%s" on %s<br/>%s<br/>Summary: %s',
        'nextepisode' => 'Next episode: %s "%s" on %s %s %s'
    ];
    foreach ($tvrage_data as $key => $data) {
        if (!isset($tvrage_display[$tvrage_type][$key])) {
            continue;
        }
        $tvrage_display[$tvrage_type][$key] = is_string($data) ? sprintf($tvrage_display[$tvrage_type][$key], $data) : sprintf($tvrage_display[$tvrage_type][$key], $data['number'], $data['title'], date('M/d/Y - l', strtotime($data['airdate'])), (isset($data['url']) ? $data['url'] : ''), (isset($data['summary']) ? $data['summary'] : ''));
    }
    if (!isset($tvrage_data['ended'])) {
        unset($tvrage_display[$tvrage_type]['ended']);
    }
    return join('<br/><br/>', $tvrage_display[$tvrage_type]);
}
function tvrage(&$torrents)
{
    global $cache, $INSTALLER09;
    $tvrage_data = '';
    $row_update = [];
    if (preg_match("/^(.*)S(\d+)(E(\d+))?/", $torrents['name'], $tmp)) {
        $tvrage = [
            'name' => str_replace('.', ' ', $tmp[1]) ,
            'season' => (int) $tmp[2],
            'episode' => (int) (isset($tmp[4]) ? $tmp[4] : 0)
        ];
    } else {
        $tvrage = [
            'name' => str_replace('.', ' ', $torrents['name']) ,
            'season' => 0,
            'episode' => 0
        ];
    }
    $memkey = 'tvrage::' . strtolower($tvrage['name']);
    if (($tvrage_id = $cache->get($memkey)) === false) {
        //get tvrage id
        $tvrage_link = sprintf('http://services.tvrage.com/myfeeds/search.php?key=%s&show=%s', $INSTALLER09['tvrage_api'], urlencode($tvrage['name']));
        $tvrage_xml = file_get_contents($tvrage_link);
        if (preg_match('/\<showid\>(\d+)<\/showid\>/', $tvrage_xml, $tmp)) {
            $tvrage_id = $tmp[1];
            $cache->set($memkey, $tvrage_id, 0);
        } else {
            return false;
        }
    }
    $force_update = false;
    if (empty($torrents['newgenre']) || empty($torrents['poster'])) {
        $force_update = true;
    }
    $memkey = 'tvrage::' . $tvrage_id;
    if ($force_update || ($tvrage_showinfo = $cache->get($memkey)) === false) {
        //var_dump('Show from tvrage'); //debug
        //get tvrage show info
        $tvrage_link = sprintf('http://services.tvrage.com/myfeeds/showinfo.php?key=%s&sid=%d', $INSTALLER09['tvrage_api'], $tvrage_id);
        $tvrage_xml = file_get_contents($tvrage_link);
        preg_match_all('/\<(showname|showlink|startdate|ended|image|origin_country|status|classification|summary|airtime|runtime)\>(.+)\<\/\\1\>/s', $tvrage_xml, $tmp, PREG_SET_ORDER);
        foreach ($tmp as $data) {
            if (!$data[2]) {
                continue;
            }
            $tvrage_showinfo[$data[1]] = $data[2];
        }
        preg_match_all('/\<genre\>(.*?)\<\/genre>/', $tvrage_xml, $tmp);
        if (count($tmp[1])) {
            $tvrage_showinfo['genres'] = join(', ', array_map('strtolower', $tmp[1]));
        }
        if (empty($torrents['newgenre'])) {
            $row_update[] = 'newgenre = ' . sqlesc(ucwords($tvrage_showinfo['genres']));
        }
        //==The torrent cache
        $cache->update_row('torrent_details_' . $torrents['id'],  [
            'newgenre' => ucwords($tvrage_showinfo['genres'])
        ], 0);
        if (empty($torrents['poster'])) {
            $row_update[] = 'poster = ' . sqlesc($tvrage_showinfo['image']);
        }
        //==The torrent cache
        $cache->update_row('torrent_details_' . $torrents['id'],  [
            'poster' => $tvrage_showinfo['image']
        ], 0);
        if (count($row_update)) {
            sql_query('UPDATE torrents set ' . join(', ', $row_update) . ' WHERE id = ' . $torrents['id']) or sqlerr(__FILE__, __LINE__);
        }
        $tvrage_showinfo = tvrage_format($tvrage_showinfo, 'show') . '<br/>';
        $cache->set($memkey, $tvrage_showinfo, 0);
        $tvrage_data.= $tvrage_showinfo;
    } else {
        //var_dump('Show from mem'); //debug
        $tvrage_data.= $tvrage_showinfo;
    }
    //check to see if its a show its an episode
    if ($tvrage['season'] > 0 && $tvrage['episode'] > 0) {
        $memkey = 'tvrage::' . $tvrage_id . '::' . $tvrage['season'] . 'x' . $tvrage['episode'];
        if (($tvrage_epinfo = $cache->get($memkey)) === false) {
            //var_dump('Ep from tvrage'); //debug
            //get episode info
            $tvrage_link = sprintf('http://services.tvrage.com/myfeeds/episodeinfo.php?key=%s&sid=%d&ep=%dx%d', $INSTALLER09['tvrage_api'], $tvrage_id, $tvrage['season'], $tvrage['episode']);
            $tvrage_xml = file_get_contents($tvrage_link);
            preg_match_all('/\<(episode|nextepisode)\>(.*?)\<\/\\1\>/', $tvrage_xml, $tmp, PREG_SET_ORDER);
            foreach ($tmp as $data) {
                preg_match_all('/\<(number|title|airdate|url|summary)\>(.*?)\<\/\\1\>/s', $data[2], $tmp_1, PREG_SET_ORDER);
                foreach ($tmp_1 as $data_1) {
                    $tvrage_epinfo[$data[1]][$data_1[1]] = $data_1[2];
                }
            }
            $tvrage_epinfo = tvrage_format($tvrage_epinfo, 'episode') . '<br/>';
            $cache->set($memkey, $tvrage_epinfo, 0);
            $tvrage_data.= $tvrage_epinfo;
        } else {
            //var_dump('Ep from mem'); //debug
            $tvrage_data.= $tvrage_epinfo;
        }
    }
    return $tvrage_data;
}
