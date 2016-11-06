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
require_once ("getstats.php");
$_settings = $_SERVER["DOCUMENT_ROOT"] . "/avatar/settings/";
$do = isset($_POST['action']) && htmlsafechars($_POST['action']) == 'load' ? 'load' : 'save';
$user = isset($_POST['user']) ? strtolower(htmlsafechars($_POST['user'])) : '';
$set['bColor'] = isset($_POST['bColor']) ? htmlsafechars($_POST['bColor']) : '666666';
$set['bgColor'] = isset($_POST['bgColor']) ? htmlsafechars($_POST['bgColor']) : '979797';
$set['fontColor'] = isset($_POST['fColor']) ? htmlsafechars($_POST['fColor']) : 'cccccc';
$set['smile'] = isset($_POST['smile']) ? htmlsafechars($_POST['smile']) : 10;
$set['font'] = isset($_POST['font']) ? htmlsafechars($_POST['font']) : 1;
$set['pack'] = isset($_POST['pack']) ? htmlsafechars($_POST['pack']) : 1;
$set['showuser'] = isset($_POST['showuser']) && htmlsafechars($_POST['showuser']) == 1 ? 1 : 0;
for ($i = 1; $i <= 3; $i++) {
    $set['line' . $i]['title'] = isset($_POST['line' . $i]) ? str_replace('&amp;', '&', $_POST['line' . $i]) : '';
    $set['line' . $i]['value'] = isset($_POST['drp' . $i]) ? $_POST['drp' . $i] : '';
}
if (!empty($user) && $do == 'save') {
    print (file_put_contents($_settings . $user . ".set", serialize($set)) ? 1 : 0);
    getStats($user);
} else {
    if (file_exists($_settings . $user . ".set")) print (json_encode(unserialize(file_get_contents($_settings . $user . ".set"))));
}
?>
