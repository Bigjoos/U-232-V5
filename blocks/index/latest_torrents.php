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
if (!function_exists('health')) {
    function health($leechers, $seeders)
    {
        global $INSTALLER09;
        if ($leechers > 0 && $seeders > 0) $ratio = $seeders / $leechers * 100;
        if ($leechers == 1 && $seeders == 1) $ratio = $seeders / $leechers * 1;
        if (($leechers == 0 && $seeders == 0) || ($leechers > 0 && $seeders == 0)) return "<img src=' " . $INSTALLER09['baseurl'] . "/images/health/health_0.gif' alt='Torrent Dead' title='Torrent Dead' />";
        elseif ($seeders > $leechers) return "<img src=' " . $INSTALLER09['baseurl'] . "/images/health/health_10.gif' alt='Torrent health' title='Torrent health' />";
        switch ($ratio) {
        case $ratio > 0 && $ratio < 15:
            return "<img src=' " . $INSTALLER09['baseurl'] . "/images/health/health_1.gif' alt='Torrent health' title='Torrent health' />";
            break;
         case $ratio >= 15 && $ratio < 25:
            return "<img src=' " . $INSTALLER09['baseurl'] . "/images/health/health_2.gif' alt='Torrent health' title='Torrent health' />";
            break;
         case $ratio >= 25 && $ratio < 35:
            return "<img src=' " . $INSTALLER09['baseurl'] . "/images/health/health_3.gif' alt='Torrent health' title='Torrent health' />";
            break;
         case $ratio >= 35 && $ratio < 45:
            return "<img src=' " . $INSTALLER09['baseurl'] . "/images/health/health_4.gif' alt='Torrent health' title='Torrent health' />";
            break;
         case $ratio >= 45 && $ratio < 55:
            return "<img src=' " . $INSTALLER09['baseurl'] . "/images/health/health_5.gif' alt='Torrent health' title='Torrent health' />";
            break;
         case $ratio >= 55 && $ratio < 65:
            return "<img src=' " . $INSTALLER09['baseurl'] . "/images/health/health_6.gif' alt='Torrent health' title='Torrent health' />";
            break;
         case $ratio >= 65 && $ratio < 75:
            return "<img src=' " . $INSTALLER09['baseurl'] . "/images/health/health_7.gif' alt='Torrent health' title='Torrent health' />";
            break;
         case $ratio >= 75 && $ratio < 85:
            return "<img src=' " . $INSTALLER09['baseurl'] . "/images/health/health_8.gif' alt='Torrent health' title='Torrent health' />";
            break;
         case $ratio >= 85 && $ratio < 95:
            return "<img src=' " . $INSTALLER09['baseurl'] . "/images/health/health_9.gif' alt='Torrent health' title='Torrent health' />";
            break;
        }
    }
}
$categorie = genrelist();
foreach ($categorie as $key => $value) $change[$value['id']] = array(
    'id' => $value['id'],
    'name' => $value['name'],
    'image' => $value['image']
);
//== O9 Top 5 and last5 torrents with tooltip
$HTMLOUT.= "<script src='{$INSTALLER09['baseurl']}/scripts/wz_tooltip.js'></script>";
$HTMLOUT.="<div class='panel panel-default'>
	<div class='panel-heading'>
		<label for='checkbox_4' class='text-left'>{$lang['index_latest']}</label>
	</div>
	<div class='panel-body'>
";
//$mc1->delete_value('top5_tor_');
if (($top5torrents = $mc1->get_value('top5_tor_')) === false) {
    $res = sql_query("SELECT id, seeders, poster, leechers, name, category from torrents ORDER BY seeders + leechers DESC LIMIT {$INSTALLER09['latest_torrents_limit']}") or sqlerr(__FILE__, __LINE__);
    while ($top5torrent = mysqli_fetch_assoc($res)) $top5torrents[] = $top5torrent;
    $mc1->cache_value('top5_tor_', $top5torrents, $INSTALLER09['expires']['top5_torrents']);
}
if (count($top5torrents) > 0) {
    $HTMLOUT.= "<div class='module'><div class='tbadge tbadge-top'></div>
     	    <table class='table table-bordered'>
            <thead><tr>
            <th class=' col-md-1 text-left'><b>{$lang['top5torrents_type']}</b></th>
            <th class=' col-md-5 text-left'><b>{$lang['top5torrents_name']}</b></th>
            <th class=' col-md-2 text-center'>{$lang['top5torrents_seeders']}</th>
            <th class=' col-md-2 text-center'>{$lang['top5torrents_leechers']}</th>
	    <th class=' col-md-3 text-center'>{$lang['top5torrents_health']}</th></tr></thead>";
if ($top5torrents) {
        foreach ($top5torrents as $top5torrentarr) {
            $top5torrentarr['cat_name'] = htmlsafechars($change[$top5torrentarr['category']]['name']);
	    $top5torrentarr['cat_pic'] = htmlsafechars($change[$top5torrentarr['category']]['image']);
            $torrname = htmlsafechars($top5torrentarr['name']);
            if (strlen($torrname) > 50) $torrname = substr($torrname, 0, 50) . "...";
            $thealth = health($top5torrentarr['leechers'], $top5torrentarr['seeders']);
            $poster = empty($top5torrentarr["poster"]) ? "<img src=\'{$INSTALLER09['pic_base_url']}noposter.jpg\' width=\'150\' height=\'220\' />" : "<img src=\'" . htmlsafechars($top5torrentarr['poster']) . "\' width=\'150\' height=\'220\' />";
            $HTMLOUT.= "
            <tbody><tr>
            <td class='text-center'><img src='pic/caticons/{$CURUSER['categorie_icon']}/" . htmlsafechars($top5torrentarr["cat_pic"]) . "' alt='" . htmlsafechars($top5torrentarr["cat_name"]) . "' title='" . htmlsafechars($top5torrentarr["cat_name"]) . "' /></td>
            <td><a href=\"{$INSTALLER09['baseurl']}/details.php?id=" . (int)$top5torrentarr['id'] . "&amp;hit=1\" onmouseover=\"Tip('<b>{$lang['index_ltst_name']}" . htmlsafechars($top5torrentarr['name']) . "</b><br /><b>{$lang['index_ltst_seeder']}" . (int)$top5torrentarr['seeders'] . "</b><br /><b>{$lang['index_ltst_leecher']}" . (int)$top5torrentarr['leechers'] . "</b><br />$poster');\" onmouseout=\"UnTip();\">{$torrname}</a></td>
          <td class='text-center'><span class='badge'>" . (int)$top5torrentarr['seeders'] . "</span></td>
          <td class='text-center'><span class='badge'>" . (int)$top5torrentarr['leechers'] . "</span></td>
          <td class='text-center'><span class='badge'>$thealth</span></td>       
	 </tr></tbody>";
        }
        $HTMLOUT.= "</table>";
    } else {
        //== If there are no torrents
        if (empty($top5torrents)) $HTMLOUT.= "<tbody><tr><td class='text-left' colspan='3'>{$lang['top5torrents_no_torrents']}</td></tr></tbody></table>";
    }
}
//==Last 5 begin
//$mc1->delete_value('last5_tor_');
if (($last5torrents = $mc1->get_value('last5_tor_')) === false) {
    $sql = "SELECT id, seeders, poster, leechers, name, category FROM torrents WHERE visible='yes' ORDER BY added DESC LIMIT {$INSTALLER09['latest_torrents_limit']}";
    $result = sql_query($sql) or sqlerr(__FILE__, __LINE__);
    while ($last5torrent = mysqli_fetch_assoc($result)) $last5torrents[] = $last5torrent;
    $mc1->cache_value('last5_tor_', $last5torrents, $INSTALLER09['expires']['last5_torrents']);
}
if (count($last5torrents) > 0) {
    $HTMLOUT.= "<div class='module'><div class='tbadge tbadge-new'></div>
    	        <table class='table table-bordered'>
                <thead><tr>
                <th class=' col-md-1 text-left'><b>{$lang['last5torrents_type']}</b></th>
                <th class=' col-md-5 text-left'><b>{$lang['last5torrents_name']}</b></th>
                <th class=' col-md-2 text-center'>{$lang['last5torrents_seeders']}</th>
                <th class=' col-md-2 text-center'>{$lang['last5torrents_leechers']}</th>
 		<th class=' col-md-3 text-center'>{$lang['top5torrents_health']}</th>
                </tr></thead>";
    if ($last5torrents) {
        foreach ($last5torrents as $last5torrentarr) {
            $last5torrentarr['cat_name'] = htmlsafechars($change[$last5torrentarr['category']]['name']);
	    $last5torrentarr['cat_pic'] = htmlsafechars($change[$last5torrentarr['category']]['image']);
            $thealth = health($last5torrentarr['leechers'], $last5torrentarr['seeders']);
            $torrname = htmlsafechars($last5torrentarr['name']);
            if (strlen($torrname) > 50) $torrname = substr($torrname, 0, 50) . "...";
            $poster = empty($last5torrentarr["poster"]) ? "<img src=\'{$INSTALLER09['pic_base_url']}noposter.jpg\' width=\'150\' height=\'220\' />" : "<img src=\'" . htmlsafechars($last5torrentarr['poster']) . "\' width=\'150\' height=\'220\' />";
            $HTMLOUT.= "
            <tbody><tr>
            <td class='text-center'><img src='pic/caticons/{$CURUSER['categorie_icon']}/" . htmlsafechars($last5torrentarr["cat_pic"]) . "' alt='" . htmlsafechars($last5torrentarr["cat_name"]) . "' title='" . htmlsafechars($last5torrentarr["cat_name"]) . "' /></td>
            <td><a href=\"{$INSTALLER09['baseurl']}/details.php?id=" . (int)$last5torrentarr['id'] . "&amp;hit=1\"></a><a href=\"{$INSTALLER09['baseurl']}/details.php?id=" . (int)$last5torrentarr['id'] . "&amp;hit=1\" onmouseover=\"Tip('<b>{$lang['index_ltst_name']}" . htmlsafechars($last5torrentarr['name']) . "</b><br /><b>{$lang['index_ltst_seeder']}" . (int)$last5torrentarr['seeders'] . "</b><br /><b>{$lang['index_ltst_leecher']}" . (int)$last5torrentarr['leechers'] . "</b><br />$poster');\" onmouseout=\"UnTip();\">{$torrname}</a></td>
            <td class='text-center'><span class='badge'>".(int)$last5torrentarr['seeders']."</span></td>
            <td class='text-center'><span class='badge'>".(int)$last5torrentarr['leechers']."</span></td>
<td class='text-center'><span class='badge'>$thealth</td>             
	    </tr></tbody>";
        }
        $HTMLOUT.= "</table>";
    } else {
        //== If there are no torrents
        if (empty($last5torrents)) $HTMLOUT.= "<tbody><tr><td class='text-left' colspan='3'>{$lang['last5torrents_no_torrents']}</td></tr></tbody></table>";
    }
}
$HTMLOUT.="</div></div></div>";
//== End 09 last5 and top5 torrents
//==End	
// End Class
// End File
