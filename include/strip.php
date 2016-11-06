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
function trim_ml(&$descr)
{
    $lines = array();
    foreach (explode("\n", $descr) as $line) {
        $lines[] = trim($line, "\x00..\x1F.,-+=\t ~");
    }
    $descr = implode("\n", $lines);
}
function trim_regex($pattern, $replacement, $subject)
{
    trim_ml($subject);
    return preg_replace($pattern, $replacement, $subject);
}
function strip(&$desc)
{
    $desc = preg_replace('`[\x00-\x08\x0b-\x0c\x0e-\x1f\x7f-\xff]`', '', $desc);
    return;
}
?>