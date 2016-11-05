<?php
if (!defined('TBVERSION')) exit('No direct script access allowed');
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
/** free mod for TBDev 09 by pdq **/
/** free addon start **/
$is = $fl = '';
$isfree['yep'] = $isfree['expires'] = 0;
$freeimg = '<img src="' . $INSTALLER09['pic_base_url'] . 'freedownload.gif" border="0" alt="Free download" title="Free download" />';
$silverimg = '<img src="' . $INSTALLER09['pic_base_url'] . 'silverdownload.gif" border="0" alt="Silver Torrent" title="Silver Torrent" />';
if (isset($free)) {
    foreach ($free as $fl) {
        switch ($fl['modifier']) {
        case 1:
            $mode = 'All Torrents Free';
            break;

        case 2:
            $mode = 'All Double Upload';
            break;

        case 3:
            $mode = 'All Torrents Free and Double Upload';
            break;

        case 4:
            $mode = 'All Torrents Silver';
            break;

        default:
            $mode = 0;
        }
        $isfree['yep'] = ($fl['modifier'] != 0) && ($fl['expires'] > TIME_NOW || $fl['expires'] == 1);
        $isfree['expires'] = $fl['expires'];
    }
}
$HTMLOUT.= (($torrents['free'] != 0 || $torrents['silver'] != 0 || $CURUSER['free_switch'] != 0 || $isfree['yep']) ? '
<tr><td align="right" class="heading">Free Status</td><td align="left">' . ($torrents['free'] != 0 ? $freeimg . '<b><font color="' . $torrent['free_color'] . '">Torrent FREE</font></b> ' . ($torrents['free'] > 1 ? 'Expires: ' . get_date($torrents['free'], 'DATE') . ' 
(' . mkprettytime($torrents['free'] - TIME_NOW) . ' to go)<br />' : 'Unlimited<br />') : '') : '') . ($torrents['silver'] != 0 ? $silverimg . '&nbsp;<b><font color="' . $torrent['silver_color'] . '">Torrent SILVER</font></b> ' . ($torrents['silver'] > 1 ? 'Expires: ' . get_date($torrents['silver'], 'DATE') . ' 
(' . mkprettytime($torrents['silver'] - TIME_NOW) . ' to go)<br />' : 'Unlimited<br />') : '') . ($CURUSER['free_switch'] != 0 ? $freeimg . '<b><font color="' . $torrent['free_color'] . '">Personal FREE Status</font></b> ' . ($CURUSER['free_switch'] > 1 ? 'Expires: ' . get_date($CURUSER['free_switch'], 'DATE') . ' 
(' . mkprettytime($CURUSER['free_switch'] - TIME_NOW) . ' to go)<br />' : 'Unlimited<br />') : '') . ($isfree['yep'] ? $freeimg . '<b><font color="' . $torrent['free_color'] . '">' . $mode . '</font></b> ' . ($isfree['expires'] != 1 ? 'Expires: ' . get_date($isfree['expires'], 'DATE') . ' 
(' . mkprettytime($isfree['expires'] - TIME_NOW) . ' to go)<br />' : 'Unlimited<br />') : '') . (($torrents['free'] != 0 || $torrents['silver'] != 0 || $CURUSER['free_switch'] != 0 || $isfree['yep']) ? '</td></tr>' : '') . '';
?>
