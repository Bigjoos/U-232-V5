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
function checkdir(&$dirs)
{
    foreach ($dirs as $dir => $x) {
        if (is_dir($dir)) {
            $fn = $dir . uniqid(time()) . '.tmp';
            if (@file_put_contents($fn, '1')) {
                unlink($fn);
                $dirs[$dir] = 1;
            } else $dirs[$dir] = 0;
        } else $dirs[$dir] = 0;
    }
}

function permissioncheck()
{
    global $root;
    if (file_exists('step0.lock')) header('Location: index.php?step=1');
    $dirs = array(
        $root . 'dir_list/' => 0,
        $root . 'imdb/' => 0,
        $root . 'cache/' => 0,
        $root . 'torrents/' => 0,
        $root . 'uploads/' => 0,
        $root . 'include/backup/' => 0,
        $root . 'sqlerr_logs/' => 0,
        $root . 'install/' => 0,
        $root . 'install/extra/' => 0,
        $root . 'include/' => 0
    );
    checkdir($dirs);
    $continue = true;
    $out = '<fieldset><legend>Directory check</legend>';
    $cmd = 'chmod 0777';
    foreach ($dirs as $dir => $state) {
        if (!$state) {
            $continue = false;
            $cmd .= ' ' . $dir;
        }
        $out .= '<div class="' . ($state ? 'readable' : 'notreadable') . '">' . $dir . '</div>';
    }

    if (!$continue) {
        $out .= '<div class="info">It looks like you need to chmod some directories!<br/>all directories marked in red should be chmoded 0777<br/>' .
            '<label for="show-chmod" class="btn">Show me the CHMOD command</label><input type="checkbox" id="show-chmod">'.
            '<pre class="chmod-cmd">' . $cmd . '</pre>'.
            '<input type="button" value="Reload" onclick="window.location.reload()"/>'.
            '</div>';
    }
    $out .= '</fieldset>';


    $out .= '<fieldset><legend>Module check</legend>';
    $memcached_loaded = true;
    if (!extension_loaded('memcached')) {
        $continue = $memcached_loaded = false;
        $out .= '<div class="notreadable">memcached</div>';
    } else {
        $out .= '<div class="readable">memcached</div>';
    }

    if( !$memcached_loaded ) {
        $out .= '<div class="info">The memcached module for PHP is not installed and is required for u232<br/>' .
            '<input type="button" value="Reload" onclick="window.location.reload()"/>'.
            '</div>';
    }
    $out .= '</fieldset>';

    if ($continue) {
        $out .= '<fieldset><div><input type="button" onclick="window.location.href=\'index.php?step=1\'" value="Next step" /></div></fieldset>';
        file_put_contents('step0.lock', '1');
    }
    return $out;
}

