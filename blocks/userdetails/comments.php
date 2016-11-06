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
//==comments
if (($torrentcomments = $mc1->get_value('torrent_comments_' . $id)) === false) {
    $res = sql_query("SELECT COUNT(id) FROM comments WHERE user=" . sqlesc($user['id'])) or sqlerr(__FILE__, __LINE__);
    list($torrentcomments) = mysqli_fetch_row($res);
    $mc1->cache_value('torrent_comments_' . $id, $torrentcomments, $INSTALLER09['expires']['torrent_comments']);
}
if ($user['paranoia'] < 2 || $CURUSER['id'] == $id || $CURUSER['class'] >= UC_STAFF) {
    $HTMLOUT.= "<tr><td class='rowhead'>{$lang['userdetails_comments']}</td>";
    if ($torrentcomments && (($user["class"] >= UC_POWER_USER && $user["id"] == $CURUSER["id"]) || $CURUSER['class'] >= UC_STAFF)) $HTMLOUT.= "<td align='left'><a href='userhistory.php?action=viewcomments&amp;id=$id'>" . (int)$torrentcomments . "</a></td></tr>\n";
    else $HTMLOUT.= "<td align='left'>" . (int)$torrentcomments . "</td></tr>\n";
}
//==end
// End Class
// End File
