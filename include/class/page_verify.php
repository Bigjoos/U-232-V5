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
// session so that repeated access of this page cannot happen without the calling script.
//
// You use the create function with the sending script, and the check function with the
// receiving script...
//
// You need to pass the value of $task from the calling script to the receiving script. While
// this may appear dangerous, it still only allows a one shot at the receiving script, which
// effectively stops flooding.
// page verify by retro
class page_verify
{
    function __construct()
    {
        if (session_id() == '') {
            session_start();
        }
    }
    function create($task_name = 'Default')
    {
        global $CURUSER, $_SESSION;
        $_SESSION['Task_Time'] = TIME_NOW;
        $_SESSION['Task'] = md5('user_id:'.$CURUSER['id'].'::taskname-'.$task_name.'::'.$_SESSION['Task_Time']);
        $_SESSION['HTTP_USER_AGENT'] = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '';
        //$_SESSION['HTTP_USER_AGENT'] = $_SERVER['HTTP_USER_AGENT'];
    }
    function check($task_name = 'Default')
    {
        global $CURUSER, $INSTALLER09, $lang, $_SESSION;
        $returl = (isset($_SERVER['HTTP_REFERER']) ? htmlsafechars($_SERVER['HTTP_REFERER']) : $INSTALLER09['baseurl']."/login.php");
        $returl = str_replace('&amp;', '&', $returl);
        if (isset($_SESSION['HTTP_USER_AGENT']) && $_SESSION['HTTP_USER_AGENT'] != $_SERVER['HTTP_USER_AGENT']) stderr("Error", "Please resubmit the form. <a href='".$returl."'>Click HERE</a>", false);
        if (isset($_SESSION['Task']) && $_SESSION['Task'] != md5('user_id:'.$CURUSER['id'].'::taskname-'.$task_name.'::'.$_SESSION['Task_Time'])) stderr("Error", "Please resubmit the form. <a href='".$returl."'>Click HERE</a>", false);
        $this->create();
    }
}
?>
