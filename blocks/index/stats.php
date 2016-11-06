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
//==Stats Begin
if (($stats_cache = $mc1->get_value('site_stats_')) === false) {
    $stats_cache = mysqli_fetch_assoc(sql_query("SELECT *, seeders + leechers AS peers, seeders / leechers AS ratio, unconnectables / (seeders + leechers) AS ratiounconn FROM stats WHERE id = '1' LIMIT 1"));
    $stats_cache['seeders'] = (int)$stats_cache['seeders'];
    $stats_cache['leechers'] = (int)$stats_cache['leechers'];
    $stats_cache['regusers'] = (int)$stats_cache['regusers'];
    $stats_cache['unconusers'] = (int)$stats_cache['unconusers'];
    $stats_cache['torrents'] = (int)$stats_cache['torrents'];
    $stats_cache['torrentstoday'] = (int)$stats_cache['torrentstoday'];
    $stats_cache['ratiounconn'] = (int)$stats_cache['ratiounconn'];
    $stats_cache['unconnectables'] = (int)$stats_cache['unconnectables'];
    $stats_cache['ratio'] = (int)$stats_cache['ratio'];
    $stats_cache['peers'] = (int)$stats_cache['peers'];
    $stats_cache['numactive'] = (int)$stats_cache['numactive'];
    $stats_cache['donors'] = (int)$stats_cache['donors'];
    $stats_cache['forumposts'] = (int)$stats_cache['forumposts'];
    $stats_cache['forumtopics'] = (int)$stats_cache['forumtopics'];
    $stats_cache['torrentsmonth'] = (int)$stats_cache['torrentsmonth'];
    $stats_cache['gender_na'] = (int)$stats_cache['gender_na'];
    $stats_cache['gender_male'] = (int)$stats_cache['gender_male'];
    $stats_cache['gender_female'] = (int)$stats_cache['gender_female'];
    $stats_cache['powerusers'] = (int)$stats_cache['powerusers'];
    $stats_cache['disabled'] = (int)$stats_cache['disabled'];
    $stats_cache['uploaders'] = (int)$stats_cache['uploaders'];
    $stats_cache['moderators'] = (int)$stats_cache['moderators'];
    $stats_cache['administrators'] = (int)$stats_cache['administrators'];
    $stats_cache['sysops'] = (int)$stats_cache['sysops'];
    $mc1->cache_value('site_stats_', $stats_cache, $INSTALLER09['expires']['site_stats']);
}
//==End
//==Installer 09 stats
$HTMLOUT.= "
<div class='panel panel-default'>
        <div class='panel-heading'>
                <label for='checkbox_4' class='text-left'>{$lang['index_stats_title']}</label>
        </div>
        <div class='panel-body'>
                <div class='row'>
                        <div class='col-lg-3'>
                                <ul class='list-group'>
                                        <li class='list-group-item btn btn-default '><b>{$lang['index_stats_uinfo']}</b></li>
                                        <li class='list-group-item'>{$lang['index_stats_regged']}<span class='badge'>{$stats_cache['regusers']}</span></li>
                                        <li class='list-group-item'>{$lang['index_stats_max']}<span class='badge'>{$INSTALLER09['maxusers']}</span></li>
                                        <li class='list-group-item'>{$lang['index_stats_online']}<span class='badge'>{$stats_cache['numactive']}</span></li>
                                        <li class='list-group-item'>{$lang['index_stats_uncon']}<span class='badge'>{$stats_cache['unconusers']}</span></li>
                                        <li class='list-group-item'>{$lang['index_stats_gender_na']}<span class='badge'>{$stats_cache['gender_na']}</span></li>
                                        <li class='list-group-item'>{$lang['index_stats_gender_male']}<span class='badge'>{$stats_cache['gender_male']}</span></li>
                                        <li class='list-group-item'>{$lang['index_stats_gender_female']}<span class='badge'>{$stats_cache['gender_female']}</span></li>
                                </ul>
                        </div>
                        <div class='col-lg-3'>
                                <ul class='list-group'>
                                        <li class='list-group-item btn btn-default'><b>{$lang['index_stats_cinfo']}</b></li>                                                                    
                                        <li class='list-group-item'>{$lang['index_stats_powerusers']}<span class='badge'>{$stats_cache['powerusers']}</span></li>
                                        <li class='list-group-item'>{$lang['index_stats_banned']}<span class='badge'>{$stats_cache['disabled']}</span></li>
                                        <li class='list-group-item'>{$lang['index_stats_uploaders']}<span class='badge'>{$stats_cache['uploaders']}</span></li>
                                        <li class='list-group-item'>{$lang['index_stats_moderators']}<span class='badge'>{$stats_cache['moderators']}</span></li>
                                        <li class='list-group-item'>{$lang['index_stats_admin']}<span class='badge'>{$stats_cache['administrators']}</span></li>
                                        <li class='list-group-item'>{$lang['index_stats_sysops']}<span class='badge'>{$stats_cache['sysops']}</span></li>
                                </ul>
                        </div>
                        <div class='col-lg-3'>
                                <ul class='list-group'>
                                        <li class='list-group-item btn btn-default'><b>{$lang['index_stats_finfo']}</b></li>                                                                    
                                        <li class='list-group-item'>{$lang['index_stats_topics']}<span class='badge'>{$stats_cache['forumtopics']}</span></li>
                                        <li class='list-group-item'>{$lang['index_stats_posts']}<span class='badge'>{$stats_cache['forumposts']}</span></li>
                                </ul>
                        </div>
                        <div class='col-lg-3'>
                                <ul class='list-group'>
                                        <li class='list-group-item btn btn-default'><b>{$lang['index_stats_tinfo']}</b></li>                                                                                                                                            <li class='list-group-item'>{$lang['index_stats_torrents']}<span class='badge'>{$stats_cache['torrents']}</span></li>
                                        <li class='list-group-item'>{$lang['index_stats_newtor']}<span class='badge'>{$stats_cache['torrentstoday']}</span></li>
                                        <li class='list-group-item'>{$lang['index_stats_peers']}<span class='badge'>{$stats_cache['peers']}</span></li>
                                        <li class='list-group-item'>{$lang['index_stats_unconpeer']}<span class='badge'>{$stats_cache['unconnectables']}</span></li>
                                        <li class='list-group-item'>{$lang['index_stats_seeders']}<span class='badge'>{$stats_cache['seeders']}</span></li>
                                        <li class='list-group-item'>{$lang['index_stats_unconratio']}<span class='badge'>" . round($stats_cache['ratiounconn'] * 100) . "</span></li>
                                        <li class='list-group-item'>{$lang['index_stats_leechers']}<span class='badge'>{$stats_cache['leechers']}</span></li>
                                        <li class='list-group-item'>{$lang['index_stats_slratio']}<span class='badge'>" . round($stats_cache['ratio'] * 100) . "</span></li>
                                </ul>
                        </div>
                </div>
        </div>
</div>";
//==End
// End Class
// End File
