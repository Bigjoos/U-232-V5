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
function check_banned_emails($email)
{
    global $lang;
    $expl = explode("@", $email);
    $wildemail = "*@" . $expl[1];
    /* Ban emails by x0r @tbdev.net */
    $res = sql_query("SELECT id, comment FROM bannedemails WHERE email = " . sqlesc($email) . " OR email = " . sqlesc($wildemail)) or sqlerr(__FILE__, __LINE__);
    if ($arr = mysqli_fetch_assoc($res)) stderr("{$lang['takesignup_user_error']}", "{$lang['takesignup_bannedmail']}" . htmlsafechars($arr['comment']));
}
?>
