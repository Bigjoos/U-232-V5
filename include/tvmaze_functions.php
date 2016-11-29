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
//tvmaze functions converted from former tvrage functions
define('TBUCKET_DIR', BITBUCKET_DIR . DIRECTORY_SEPARATOR . 'tvmaze');
if (!is_dir(TBUCKET_DIR)) {
    mkdir(TBUCKET_DIR);
}

function tvmaze_format($tvmaze_data, $tvmaze_type) {
    $tvmaze_display['show'] = array(
        'name' => '<b>%s</b>',
        'url' => '%s',
        'premiered' => 'Started: %s',
        'origin_country' => 'Country: %s',
        'status' => 'Status: %s',
        'type' => 'Classification: %s',
        'summary' => 'Summary:<br/> %s',
        'runtime' => 'Runtime %s min',
        'genres2' => 'Genres: %s',
    );
    foreach ($tvmaze_display[$tvmaze_type] as $key => $value) {
        if (isset($tvmaze_data[$key])) {
            $tvmaze_display[$tvmaze_type][$key] = sprintf($value, $tvmaze_data[$key]);
        } else {
            $tvmaze_display[$tvmaze_type][$key] = sprintf($value, 'None Found');
        }

    }
    return join('<br/><br/>', $tvmaze_display[$tvmaze_type]);
}
function tvmaze(&$torrents) {
    global $mc1, $INSTALLER09;
    $tvmaze_data = '';
    $row_update = array();
    if (preg_match("/^(.*)S\d+(E\d+)?/i", $torrents['name'], $tmp)) {
        $tvmaze = array(
            'name' => preg_replace('/ $/', '', str_replace(array('.', '_'), ' ', $tmp[1])),
        );
    } else {
        $tvmaze = array(
            'name' => preg_replace('/ $/', '', str_replace(array('.', '_'), ' ', $torrents['name'])),
        );
    }

    $memkey = 'tvmaze::' . strtolower(str_replace(' ', '', $tvmaze['name']));
    if (($tvmaze_id = $mc1->get_value($memkey)) === false) {
        //get tvrage id
        $tvmaze_link = sprintf('http://api.tvmaze.com/singlesearch/shows?q=%s', urlencode($tvmaze['name']));
        $tvmaze_array = json_decode(file_get_contents($tvmaze_link), true);
        if ($tvmaze_array) {
            $tvmaze_id = $tvmaze_array['id'];
            $mc1->cache_value($memkey, $tvmaze_id, 0);
        } else {
            return false;
        }

    }
    $force_update = false;
    if (empty($torrents['newgenre']) || empty($torrents['poster'])) {
        $force_update = true;
    }

    $memkey = 'tvrage::' . $tvmaze_id;
    if ($force_update || ($tvmaze_showinfo = $mc1->get_value($memkey)) === false) {
        //var_dump('Show from tvrage'); //debug
        //get tvrage show info
        $tvmaze['name'] = preg_replace('/\d{4}.$/', '', $tvmaze['name']);
        $tvmaze_link = sprintf('http://api.tvmaze.com/shows/%d', $tvmaze_id);
        $tvmaze_array = json_decode(file_get_contents($tvmaze_link), true);
        $tvmaze_array['origin_country'] = $tvmaze_array['network']['country']['name'];
        if (count($tvmaze_array['genres']) > 0) {
            $tvmaze_array['genres2'] = implode(", ", array_map('strtolower', $tvmaze_array['genres']));
        }

        if (empty($torrents['newgenre'])) {
            $row_update[] = 'newgenre = ' . sqlesc(ucwords($tvmaze_array['genres2']));
        }

        if ($tvmaze_array["image"]["original"] != "") {
            if (!file_exists(TBUCKET_DIR . "/$tvmaze_id.jpg")) {
                file_put_contents(TBUCKET_DIR . "/$tvmaze_id.jpg", file_get_contents($tvmaze_array["image"]["original"]));
            }

            $img = "img.php/tvmaze/$tvmaze_id.jpg";
        }
        //==The torrent cache
        $mc1->begin_transaction('torrent_details_' . $torrents['id']);
        $mc1->update_row(false, array(
            'newgenre' => ucwords($tvmaze_array['genres2']),
        ));
        $mc1->commit_transaction(0);
        if (empty($torrents['poster'])) {
            $row_update[] = 'poster = ' . sqlesc($img);
        }

        //==The torrent cache
        $mc1->begin_transaction('torrent_details_' . $torrents['id']);
        $mc1->update_row(false, array(
            'poster' => $img,
        ));
        $mc1->commit_transaction(0);
        if (count($row_update)) {
            sql_query('UPDATE torrents set ' . join(', ', $row_update) . ' WHERE id = ' . $torrents['id']) or sqlerr(__FILE__, __LINE__);
        }

        $tvmaze_showinfo = tvmaze_format($tvmaze_array, 'show') . '<br/>';
        $mc1->cache_value($memkey, $tvmaze_showinfo, 0);
        $tvmaze_data .= $tvmaze_showinfo;
    } else {
        //var_dump('Show from mem'); //debug
        $tvmaze_data .= $tvmaze_showinfo;
    }
    return $tvmaze_data;
}
?>
