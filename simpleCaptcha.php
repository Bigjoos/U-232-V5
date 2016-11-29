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
// This is the handler for captcha image requests
// The captcha ID is placed in the session, so session vars are required for this plug-in
session_start();
$numImages = '';
// -------------------- EDIT THESE ----------------- //
$images = array(
    'house' => 'captchaImages/01.png',
    'key' => 'captchaImages/04.png',
    'flag' => 'captchaImages/06.png',
    'clock' => 'captchaImages/15.png',
    'bug' => 'captchaImages/16.png',
    'pen' => 'captchaImages/19.png',
    'light bulb' => 'captchaImages/21.png',
    'musical note' => 'captchaImages/40.png',
    'heart' => 'captchaImages/43.png',
    'world' => 'captchaImages/99.png'
);
// ------------------- STOP EDITING ---------------- //
$_SESSION['simpleCaptchaAnswer'] = null;
$_SESSION['simpleCaptchaTimestamp'] = time();
$SALT = "o^Gj" . $_SESSION['simpleCaptchaTimestamp'] . "7%8W";
$resp = array();
header("Content-Type: application/json");
if (!isset($images) || !is_array($images) || sizeof($images) < 3) {
    $resp['error'] = "There aren\'t enough images!";
    echo json_encode($resp);
    exit;
}
if (isset($_POST['numImages']) && strlen($_POST['numImages']) > 0) {
    $numImages = intval($_POST['numImages']);
} else if (isset($_GET['numImages']) && strlen($_GET['numImages']) > 0) {
    $numImages = intval($_GET['numImages']);
}
$numImages = ($numImages > 0) ? $numImages : 5;
$size = sizeof($images);
$num = min(array(
    $size,
    $numImages
));
$keys = array_keys($images);
$used = array();
mt_srand(((float)microtime() * 587) / 33);
for ($i = 0; $i < $num; ++$i) {
    $r = rand(0, $size - 1);
    while (array_search($keys[$r], $used) !== false) {
        $r = rand(0, $size - 1);
    }
    array_push($used, $keys[$r]);
}
$selectText = $used[rand(0, $num - 1) ];
$_SESSION['simpleCaptchaAnswer'] = sha1($selectText . $SALT);
$resp['text'] = '' . $selectText;
$resp['images'] = array();
shuffle($used);
for ($i = 0; $i < sizeof($used); ++$i) {
    array_push($resp['images'], array(
        'hash' => sha1($used[$i] . $SALT) ,
        'file' => $images[$used[$i]]
    ));
}
echo json_encode($resp);
exit;
?>
