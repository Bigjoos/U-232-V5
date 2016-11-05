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
$flag_xy = array(
    1 => array(
        121,
        111
    ) ,
    2 => array(
        121,
        140
    ) ,
    3 => array(
        121,
        169
    )
);
$user = isset($_GET['user']) ? htmlsafechars($_GET['user']) : '';
if (!file_exists($_settings . strtolower($user) . ".set") || !is_array($var = unserialize(file_get_contents($_settings . strtolower($user) . ".set")))) exit("Can't create avatar, settings file not found!");
$_fromCache = true;
if ((time() - filemtime($_settings . strtolower($user) . ".set")) > 84600 || !file_exists($_settings . strtolower($user) . ".png")) $_fromCache = false;
function hex2rgb($color)
{
    return array(
        hexdec(substr($color, 0, 2)) ,
        hexdec(substr($color, 2, 2)) ,
        hexdec(substr($color, 4, 2))
    );
}
if (!$_fromCache) {
    $var['use_country'] = false;
    for ($i = 1; $i <= 3; $i++) {
        if (isset($var['line' . $i]['value_p']) && is_array($var['line' . $i]['value_p'])) {
            $var['use_country'] = true;
            $_flag_xy = $flag_xy[$i];
            $_flag = $var['line' . $i]['value_p']['iso'];
            $var['line' . $i]['value_p'] = $var['line' . $i]['value_p']['name'];
        }
    }
    //create image
    $im = imagecreatetruecolor(150, 190);
    //load font
    $fonts = array(
        1 => 'msmincho.gdf',
        2 => 'smallfont.gdf',
        3 => 'visitort2.gdf'
    );
    $font = imageloadfont("fonts/" . $fonts[$var['font']]);
    //define colors
    //border color
    list($br, $bg, $bb) = hex2rgb($var['bColor']);
    $bColor = imagecolorallocate($im, $br, $bg, $bb);
    //background color
    list($bgr, $bgg, $bgb) = hex2rgb($var['bgColor']);
    $bgColor = imagecolorallocate($im, $bgr, $bgg, $bgb);
    //font color
    list($fr, $fg, $fb) = hex2rgb($var['fontColor']);
    $fontColor = imagecolorallocate($im, $fr, $fg, $fb);
    //fill avatar body with the background color
    imagefilledrectangle($im, 0, 0, 150, 190, $bgColor);
    //draw border
    imagerectangle($im, 0, 0, 149, 189, $bColor);
    //add smile
    $smile = imagecreatefrompng("templates/pack" . $var['pack'] . "/" . ($var['smile'] == 225 ? rand(1, 20) : $var['smile']) . ".png");
    $smile_pos = array(
        1 => array(
            'x' => '-15',
            'y' => '18'
        ) ,
        2 => array(
            'x' => '-9',
            'y' => '12'
        ) ,
        3 => array(
            'x' => '-11',
            'y' => '11'
        ) ,
        4 => array(
            'x' => '-10',
            'y' => '12'
        )
    );
    imagecopy($im, $smile, $smile_pos[$var['pack']]['y'], $smile_pos[$var['pack']]['x'], 0, 0, 128, 128);
    //country
    if ($var['use_country']) {
        $country = imagecreatefrompng("flags/" . $_flag . ".png");
        //$country = imagecreatefrompng("../pic/flags/" . $_flag . ".gif");
        imagecopy($im, $country, $_flag_xy[0], $_flag_xy[1], 0, 0, 16, 11);
    }
    //add username if the option is true
    if ($var['showuser']) imagestring($im, $font, 5, 2, $user, $fontColor);
    if (isset($var['line1']['value_p']) && !empty($var['line1']['value_p'])) {
        imagestring($im, $font, 10, 98, $var['line1']['title'], $fontColor);
        imagerectangle($im, 10, 108, 140, 125, $bColor); //text line
        imagestring($im, $font, 14, 112, $var['line1']['value_p'], $fontColor);
    }
    if (isset($var['line2']['value_p']) && !empty($var['line2']['value_p'])) {
        imagestring($im, $font, 10, 127, $var['line2']['title'], $fontColor);
        imagerectangle($im, 10, 137, 140, 154, $bColor); //text line
        imagestring($im, $font, 14, 142, $var['line2']['value_p'], $fontColor);
    }
    if (isset($var['line3']['value_p']) && !empty($var['line3']['value_p'])) {
        imagestring($im, $font, 10, 156, $var['line3']['title'], $fontColor);
        imagerectangle($im, 10, 166, 140, 183, $bColor); //text line
        imagestring($im, $font, 14, 170, $var['line3']['value_p'], $fontColor);
    }
} else $im = imagecreatefrompng($_settings . strtolower($user) . ".png");
header('Content-type: image/png');
if (!$_fromCache) {
    imagepng($im, $_settings . strtolower($user) . ".png", 9);
    imagepng($im);
} else imagepng($im);
imagedestroy($im);
?>
