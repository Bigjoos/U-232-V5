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
//==Qlogin by stonebreath and laffin
if ($CURUSER['class'] >= UC_STAFF && $id == $CURUSER['id']) {
    $hash1 = $mc1->get_value('hash1_' . $id);
    if ($hash1 === false) {
        $res = sql_query("SELECT hash1 FROM users WHERE id = " . sqlesc($CURUSER['id']) . " AND class >= " . UC_STAFF) or sqlerr(__FILE__, __LINE__);
        $hash1 = mysqli_fetch_assoc($res);
        $mc1->cache_value('hash1_' . $id, $hash1, $INSTALLER09['expires']['user_hash']);
    }
    $arr = $hash1;
    if ($arr['hash1'] != '') {
        $HTMLOUT.= "<tr><td class='rowhead'>{$lang['userdetails_login_link']}<br /><a href='createlink.php?action=reset&amp;id=" . (int)$CURUSER['id'] . "' target='_blank'>{$lang['userdetails_login_reset']}</a></td><td align='left'>{$INSTALLER09['baseurl']}/pagelogin.php?qlogin=" . htmlsafechars($arr['hash1']) . "</td></tr>";
    } else {
        $HTMLOUT.= "<tr><td class='rowhead'>{$lang['userdetails_login_link']}</td><td align='left'><a href='createlink.php?id=" . (int)$CURUSER['id'] . "' target='_blank'>{$lang['userdetails_login_create']}</a></td></tr>";
    }
}
//==End
// End Class
// End File
