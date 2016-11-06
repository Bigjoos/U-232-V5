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
function validator($context)
{
    global $CURUSER;
    $timestamp = time();
    $hash = hash_hmac("sha1", $CURUSER['secret'], $context . $timestamp);
    return substr($hash, 0, 20) . dechex($timestamp);
}
function validatorForm($context)
{
    return "<input type=\"hidden\" name=\"validator\" value=\"" . validator($context) . "\"/>";
}
function validate($validator, $context, $seconds = 0)
{
    global $CURUSER;
    $timestamp = hexdec(substr($validator, 20));
    if ($seconds && time() > $timestamp + $seconds) return False;
    $hash = substr(hash_hmac("sha1", $CURUSER['secret'], $context . $timestamp) , 0, 20);
    if (substr($validator, 0, 20) != $hash) return False;
    return True;
}
?>
