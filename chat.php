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
dbconn();
loggedinorreturn();
$lang = array_merge(load_language('global') , load_language('chat'));
$nick = ($CURUSER ? $CURUSER['username'] : ('Guest'.rand(1000, 9999)));
$irc_url = 'irc.mibbit.com';
$irc_channel = '#';
$irc_network = 'CHANGEME';
$HTMLOUT = '';
$HTMLOUT.= "<p>{$lang['chat_channel']}<a href='irc://{$irc_url}/{$irc_channel}'>{$irc_channel}</a> {$lang['chat_on']} {$irc_network} {$lang['chat_network']}</p>
<iframe src='https://kiwiirc.com/client/{$irc_url}/?nick={$nick}|?&theme=cli{$irc_channel}' style='border:0; width:100%; height:450px;'></iframe>";
///////////////////// HTML OUTPUT ////////////////////////////
echo stdhead("{$lang['chat_chat']}").$HTMLOUT.stdfoot();
?>
