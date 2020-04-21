<?php
/**
 * |--------------------------------------------------------------------------|
 * |   https://github.com/Bigjoos/                                            |
 * |--------------------------------------------------------------------------|
 * |   Licence Info: WTFPL                                                    |
 * |--------------------------------------------------------------------------|
 * |   Copyright (C) 2010 U-232 V5                                            |
 * |--------------------------------------------------------------------------|
 * |   A bittorrent tracker source based on TBDev.net/tbsource/bytemonsoon.   |
 * |--------------------------------------------------------------------------|
 * |   Project Leaders: Mindless, Autotron, whocares, Swizzles.               |
 * |--------------------------------------------------------------------------|
 * _   _   _   _   _     _   _   _   _   _   _     _   _   _   _
 * / \ / \ / \ / \ / \   / \ / \ / \ / \ / \ / \   / \ / \ / \ / \
 * ( U | - | 2 | 3 | 2 )-( S | o | u | r | c | e )-( C | o | d | e )
 * \_/ \_/ \_/ \_/ \_/   \_/ \_/ \_/ \_/ \_/ \_/   \_/ \_/ \_/ \_/
 *
 * @param mixed $len
 */
function mksecret($len = 5)
{
    $salt = '';
    for ($i = 0; $i < $len; $i++) {
        $num = rand(33, 126);
        if ($num == '92') {
            $num = 93;
        }
        $salt.= chr($num);
    }
    return $salt;
}
function make_passhash_login_key($len = 60)
{
    $pass = mksecret($len);
    return password_hash($pass, PASSWORD_DEFAULT);
}
function make_passhash($password)
{
    return password_hash($password, PASSWORD_DEFAULT, ['cost' => 12]);
}
