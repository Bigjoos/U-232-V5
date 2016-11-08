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
// 09 poster mod
$stdhead = array(
    /** include js **/
    'js' => array(
        'raphael-min',
        'jquery.mousewheel',
        'icarousel'
    )
);
 
$HTMLOUT.= '
<!--<script type="text/javascript" src="/scripts/raphael-min.js"></script>
<script type="text/javascript" src="/scripts/icarousel.js"></script>
<script type="text/javascript" src="/scripts/jquery.mousewheel.js"></script>-->

<link rel="stylesheet" href="css/icarousel.css" type="text/css" />

<script type="text/javascript" language="javascript">
/*<![CDATA[*/
$(document).ready(function(){ $("#icarousel").iCarousel({
easing: "ease-in-out",
			slides: 14,
			make3D: !1,
			perspective: 5,
			animationSpeed: 500,
			pauseTime: 5E3,
			startSlide: 5,
			directionNav: !0,
			autoPlay: 0,
			keyboardNav: !0,
			touchNav: !0,
			mouseWheel: false,
			pauseOnHover: !1,
			nextLabel: "Next",
			previousLabel: "Previous",
			playLabel: "Play",
			pauseLabel: "Pause",
			randomStart: !1,
			slidesSpace: "100",
			slidesTopSpace: "0",
			direction: "rtl",
			timer: "false",
			timerBg: "#111",
			timerColor: "#111",
			timerOpacity: 0.0,
			timerDiameter: 35,
			timerPadding: 4,
			timerStroke: 3,
			timerBarStroke: 1,
			timerBarStrokeColor: "#111",
			timerBarStrokeStyle: "solid",
			timerBarStrokeRadius: 4,
			timerPosition: "top-right",
			timerX: 10,
			timerY: 10

}); });
/*]]>*/
</script>';

//AND poster != ''
//$mc1->delete_value('scroll_tor_');
if (($scroll_torrents = $mc1->get_value('scroll_tor_')) === false) {
    $scroll = sql_query("SELECT id, seeders, leechers, name, poster FROM torrents WHERE seeders >= '1' ORDER BY added DESC LIMIT {$INSTALLER09['latest_torrents_limit_scroll']}") or sqlerr(__FILE__, __LINE__);
    while ($scroll_torrent = mysqli_fetch_assoc($scroll)) $scroll_torrents[] = $scroll_torrent;
    $mc1->cache_value('scroll_tor_', $scroll_torrents, $INSTALLER09['expires']['scroll_torrents']);
}

if (count($scroll_torrents) > 0) {
$HTMLOUT.= "<div class='panel panel-default'>
  <div class='panel-heading'>
<label class='text-left'>{$lang['index_latest']}</label>
</div>
    <div class='panel-body'>";
$HTMLOUT .='<div id="carousel-container" class="carousel-container">
<div id="icarousel" class="icarousel">';

if ($scroll_torrents) {
        foreach ($scroll_torrents as $s_t) {
            $i = $INSTALLER09['latest_torrents_limit_scroll'];
            $id = (int)$s_t['id'];
            $name = htmlsafechars($s_t['name']);
	    $poster = ($s_t['poster'] == '' ? ''.$INSTALLER09['pic_base_url'].'noposter.png' : $s_t['poster']);
            $seeders = number_format((int)$s_t['seeders']);
            $leechers = number_format((int)$s_t['leechers']);
            $name = str_replace('_', ' ', $name);
            $name = str_replace('.', ' ', $name);
            $name = substr($name, 0, 50);
            $HTMLOUT.= "<div class='slide'><a href='{$INSTALLER09['baseurl']}/details.php?id=$id'><img src='".htmlsafechars($poster)."' class='glossy tester' alt='{$name}' title='{$name} - Seeders : {$seeders} - Leechers : {$leechers}'border='0' /></a></div>";
}
$HTMLOUT .='</div></div></div></div>';
    } else {
        //== If there are no torrents
        if (empty($scroll_torrents)) $HTMLOUT.= "No torrents here yet !!</div></div></div></div><br />";
    }
}
//==End 09 poster mod
//== End Class
//== End File
