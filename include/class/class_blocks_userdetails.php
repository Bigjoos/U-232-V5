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
class block_userdetails
{
    const LOGIN_LINK = 0x1; // 1
    const FLUSH = 0x2; // 2
    const JOINED = 0x4; // 4
    const ONLINETIME = 0x8; // 8.
    const BROWSER = 0x10; // 16
    const REPUTATION = 0x20; // 32
    const PROFILE_HITS = 0x40; // 64
    const BIRTHDAY = 0x80; // 128
    const CONTACT_INFO = 0x100; // 256
    const IPHISTORY = 0x200; // 512
    const TRAFFIC = 0x400; // 1024
    const SHARE_RATIO = 0x800; // 2048
    const SEEDTIME_RATIO = 0x1000; // 4096
    const SEEDBONUS = 0x2000; // 8192
    const IRC_STATS = 0x4000; // 16384
    const CONNECTABLE_PORT = 0x8000; // 32768
    const AVATAR = 0x10000; // 65536
    const USERCLASS = 0x20000; // 131072
    const GENDER = 0x40000; // 262144
    const FREESTUFFS = 0x80000; // 524288
    const COMMENTS = 0x100000; // 1048576
    const FORUMPOSTS = 0x200000; // 2097152
    const INVITEDBY = 0x400000; // 4194304
    const TORRENTS_BLOCK = 0x800000; // 8388608
    const COMPLETED = 0x1000000; // 16777216
    const SNATCHED_STAFF = 0x2000000; // 33554432
    const USERINFO = 0x4000000; // 67108864
    const SHOWPM = 0x8000000; // 134217728
    const REPORT_USER = 0x10000000; // 268435456
    const USERSTATUS = 0x20000000; // 536870912
    const USERCOMMENTS = 0x40000000; // 1073741824
    const SHOWFRIENDS		         = 0x80000000; // 2147483648
    
}
?>
