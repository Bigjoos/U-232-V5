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
$lang = array(
    //Links
    'links_dead' => "<p><a href='pm_system.php?action=send_message&amp;receiver=1'>Please report dead links!</a></p>",
    'links_other_pages_header' => "<h2>Other pages on this site</h2>",
    'links_other_pages_body' => "<li><a class='altlink' href='rss.xml'>RSS feed</a> -
      For use with RSS-enabled software. An alternative to torrent email notifications.</li>
    <li><a class='altlink' href='rssdd.xml'>RSS feed (direct download)</a> -
      Links directly to the torrent file.</li>
    <li><a class='altlink' href='bitbucket.php'>Bitbucket</a> -
      If you need a place to host your avatar or other pictures.</li>",
    'links_bt_header' => "<h2>BitTorrent Information</h2>",
    'links_bt_body' => "<li><a class='altlink' href='http://dessent.net/btfaq/'>Brian's BitTorrent FAQ and Guide</a> -
      Everything you need to know about BitTorrent. Required reading for all n00bs.</li>
    <li><a class='altlink' href='http://10mbit.com/faq/bt/'>The Ultimate BitTorrent FAQ</a> -
      Another nice BitTorrent FAQ, by Evil Timmy.</li>",
    'links_software_header' => "<h2>BitTorrent Software</h2>",
    'links_software_body' => "<li><a class='altlink' href='http://pingpong-abc.sourceforge.net/'>ABC</a> -
      &quot;ABC is an improved client for the Bittorrent peer-to-peer file distribution solution.&quot;</li>
    <li><a class='altlink' href='http://azureus.sourceforge.net/'>Azureus</a> -
      &quot;Azureus is a java bittorrent client. It provides a quite full bittorrent protocol implementation using java language.&quot;</li>
    <li><a class='altlink' href='http://bnbt.go-dedicated.com/'>BNBT</a> -
      Nice BitTorrent tracker written in C++.</li>
    <li><a class='altlink' href='http://bittornado.com/'>BitTornado</a> -
      a.k.a &quot;TheSHAD0W's Experimental BitTorrent Client&quot;.</li>
    <li><a class='altlink' href='http://www.bitconjurer.org/BitTorrent'>BitTorrent</a> -
      Bram Cohen's official BitTorrent client.</li>
    <li><a class='altlink' href='http://ei.kefro.st/projects/btclient/'>BitTorrent EXPERIMENTAL</a> -
      &quot;This is an unsupported, unofficial, and, most importantly, experimental build of the BitTorrent GUI for Windows.&quot;</li>
    <li><a class='altlink' href='http://krypt.dyndns.org:81/torrent/'>Burst!</a> -
      Alternative Win32 BitTorrent client.</li>
    <li><a class='altlink' href='http://g3torrent.sourceforge.net/'>G3 Torrent</a> -
      &quot;A feature rich and graphically empowered bittorrent client written in python.&quot;</li>
    <li><a class='altlink' href='http://krypt.dyndns.org:81/torrent/maketorrent/'>MakeTorrent</a> -
      A tool for creating torrents.</li>
    <li><a class='altlink' href='http://ptc.sourceforge.net/'>Personal Torrent Collector</a> -
      BitTorrent client.</li>
    <li><a class='altlink' href='http://www.shareaza.com/'>Shareaza</a> -
      Gnutella, eDonkey and BitTorrent client.</li>",
    'links_download_header' => "<h2>Download sites</h2>",
    'links_download_body' => "<li><a class='altlink' href='http://www.suprnova.org/'>SuprNova</a> -
      Apps, games, movies, TV and other stuff. [popups]</li>
    <li><a class='altlink' href='http://empornium.us:6969/'>Empornium</a> -
      Pr0n, and then some!</li>",
    'links_forums_header' => "<h2>Forum communities</h2>",
    'links_forums_body' => " <li><a class='altlink' href='http://www.filesoup.com/'>Filesoup</a> -
      BitTorrent community.</li>
    <li><a class='altlink' href='http://www.torrent-addiction.com/forums/index.php'>Torrent Addiction</a> -
      Another BitTorrent community. [popups]</li>
    <li><a class='altlink' href='http://www.terabits.net/'>TeraBits</a> -
    Games, movies, apps both unix and win, tracker support, music, xxx.</li>
    <li><a class='altlink' href='http://www.ftpdreams.com/new/forum/sitenews.asp'>FTP Dreams</a> - &quot;Where Dreams Become a Reality&quot;.</li>",
    'links_other_header' => "<h2>Other sites</h2>",
    'links_other_body' => "<li><a class='altlink' href='http://www.nforce.nl/'>NFOrce</a> -
      Game and movie release tracker / forums.</li>
    <li><a class='altlink' href='http://www.grokmusiq.com/'>grokMusiQ</a> -
      Music release tracker.</li>
    <li><a class='altlink' href='http://www.izonews.com/'>iSONEWS</a> -
      Release tracker and forums.</li>
    <li><a class='altlink' href='http://www.btsites.tk'>BTSITES.TK</a> -
      BitTorrent link site. [popups]</li>
    <li><a class='altlink' href='http://www.litezone.com/'>Link2U</a> -
      BitTorrent link site.</li>",
    'links_tbdev_header' => "<h2>Link to U-232</h2",
    'links_tbdev_body' => "Do you want a link to U-232 on your homepage?<br />
    Copy the following and paste it into your homepage code.<br />
    <br />
    <font color='#004E98'>
    &lt;!-- U-232 Link --&gt;<br />
    <br />
    &lt;a href='https://u-232.com'&gt;<br />
    &lt;img src='{$INSTALLER09['pic_base_url']}u232.gif' border='0' alt='U-232 - The best!'&gt;&lt;/a&gt;<br />
    <br />
    &lt;!-- End of U-232 Link --&gt;</font><br />
    <br />
    <br />
    It will look like this:<br />
    <br />
    <a href='{$INSTALLER09['baseurl']}'>
    <img src='./pic/u232.gif' border='0' alt='U-232 - The best!' /></a>
    <br />"
);
?>
