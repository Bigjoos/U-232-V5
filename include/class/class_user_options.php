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
class user_options
{
    const ENABLED = 0x1; // 1
    const DONOR = 0x2; // 2  exclude
    const DELETEPMS = 0x4; // 4
    const SAVEPMS = 0x8; // 8. exclude
    const SHOW_SHOUT = 0x10; // 16
    const VIP_ADDED = 0x20; // 32  exclude
    const INVITE_RIGHTS = 0x40; // 64
    const ANONYMOUS = 0x80; // 128  exclude
    const CLEAR_NEW_TAG_MANUALLY = 0x100; // 256   exclude
    const SIGNATURES = 0x200; // 512
    const HIGHSPEED = 0x400; // 1024  exclude
    const HNRWARN = 0x800; // 2048  exclude
    const PARKED = 0x1000; // 4096 exclude
    const SUPPORT = 0x2000; // 8192 exclude
    const INVITE_ON = 0x4000; // 16384
    const SUBSCRIPTION_PM = 0x8000; // 32768 exclude
    const VIEWSCLOUD = 0x10000; // 65536
    const TENPERCENT = 0x20000; // 131072
    const AVATARS = 0x40000; // 262144
    const OFFAVATAR = 0x80000; // 524288 exclude
    const HIDECUR = 0x100000; // 1048576 exclude
    const SIGNATURE_POST = 0x200000; // 2097152
    const FORUM_POST = 0x400000; // 4194304
    const AVATAR_RIGHTS = 0x800000; // 8388608
    const OFFENSIVE_AVATAR = 0x1000000; // 16777216  exclude
    const VIEW_OFFENSIVE_AVATAR = 0x2000000; // 33554432
    const SHOW_EMAIL = 0x4000000; // 67108864  exclude
    const GOTGIFT = 0x8000000; // 134217728
    const SUSPENDED = 0x10000000; // 268435456 exclude
    const ONIRC = 0x20000000; // 536870912  exclude
    const GOTBLOCKS = 0x40000000; // 1073741824  exclude
    
}
?>
