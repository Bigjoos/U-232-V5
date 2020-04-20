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
 */

use Blocktrail\CryptoJSAES\CryptoJSAES;

function encrypt($input)
{
    global $INSTALLER09;
    $encrypted = CryptoJSAES::encrypt($input, $INSTALLER09['cipher_key']['key']);

    return base64_encode($encrypted);
}

function decrypt($input)
{
    global $INSTALLER09;
    $str = base64_decode($input);

    return CryptoJSAES::decrypt($str, $INSTALLER09['cipher_key']['key']);
}

function encrypt_ip($ip)
{
    return encrypt($ip);
}

function decrypt_ip($ip)
{
    return decrypt($ip);
}

function encrypt_email($email)
{
    return encrypt($email);
}

function decrypt_email($email)
{
    return decrypt($email);
}
