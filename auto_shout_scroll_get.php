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
require_once (INCL_DIR . 'bbcode_functions.php');
dbconn(true);
loggedinorreturn();
echo "";
//Check for Auto Shouts and cache it
//$mc1->delete_value('auto_shoutbox_');
//== cache the data
if (($shouts = $mc1->get_value('auto_shoutbox_')) === false) {
    $res = sql_query("SELECT text FROM shoutbox WHERE staff_shout ='no' AND autoshout ='yes' ORDER BY id DESC LIMIT 10") or sqlerr(__FILE__, __LINE__);
    while ($shout = mysqli_fetch_assoc($res)) $shouts[] = $shout;
    $mc1->cache_value('auto_shoutbox_', $shouts, $INSTALLER09['expires']['shoutbox']);
}

//Output the shouts
if (is_array($shouts)) {
	foreach ($shouts as $arr) {
		echo format_comment($arr["text"])."&nbsp;&nbsp;&nbsp;";
	}
}

?>
