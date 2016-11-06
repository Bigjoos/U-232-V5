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
// img.php by pdq 2011 =)
error_reporting(0);
/* Locate images folder outside of webroot */
define('BITBUCKET_DIR', DIRECTORY_SEPARATOR . 'var' . DIRECTORY_SEPARATOR . 'bucket'); // /path/to/bitbucket
/* Sanity checking */
function valid_path($root, $input)
{
    $fullpath = $root . $input;
    $fullpath = realpath($fullpath);
    $root = realpath($root);
    $rl = strlen($root);
    return ($root != substr($fullpath, 0, $rl)) ? NULL : $fullpath;
}
/* Process request */
if (isset($_SERVER['REQUEST_URI'])) {
    $image = valid_path(BITBUCKET_DIR, substr($_SERVER['REQUEST_URI'], strlen($_SERVER['SCRIPT_NAME'])));
    if (!((($pi = pathinfo($image)) && preg_match('#^(jpg|jpeg|gif|png)$#i', $pi['extension'])) && $image && is_file($image))) die('^_^');
    $img['last_mod'] = filemtime($image);
    $img['date_fmt'] = 'D, d M Y H:i:s T';
    $img['lm_date'] = date($img['date_fmt'], $img['last_mod']);
    $img['ex_date'] = date($img['date_fmt'], time() + (86400 * 7));
    $img['stop'] = false;
    if (isset($_SERVER['HTTP_IF_MODIFIED_SINCE'])) {
        $img['since'] = explode(';', $_SERVER['HTTP_IF_MODIFIED_SINCE'], 2);
        $img['since'] = strtotime($img['since'][0]);
        if ($img['since'] == $img['last_mod']) {
            header($_SERVER['SERVER_PROTOCOL'] . ' 304 Not Modified');
            $img['stop'] = true;
        }
    }
    header('Expires: ' . $img['ex_date']);
    header('Cache-Control: private, max-age=604800');
    if ($img['stop']) die();
    header('Last-Modified: ' . $img['lm_date']);
    header('Content-type: image/' . $pi['extension']);
    readfile($image);
    exit();
}
// End of File

?>
