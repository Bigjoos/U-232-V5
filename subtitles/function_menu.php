<?php
/**
 * |--------------------------------------------------------------------------|
 * |   https://github.com/Bigjoos/                                            |
 * |--------------------------------------------------------------------------|
 * |   Licence Info: WTFPL                                                    |
 * |--------------------------------------------------------------------------|
 * |   Copyright (C) 2010 U-232 V5                                            |
 * |--------------------------------------------------------------------------|
 * |   A bittorrent tracker source based on TBDev.net/tbsource/bytemonsoon.   |
 * |--------------------------------------------------------------------------|
 * |   Project Leaders: Mindless, Autotron, whocares, Swizzles.               |
 * |--------------------------------------------------------------------------|
 * _   _   _   _   _     _   _   _   _   _   _     _   _   _   _
 * / \ / \ / \ / \ / \   / \ / \ / \ / \ / \ / \   / \ / \ / \ / \
 * ( U | - | 2 | 3 | 2 )-( S | o | u | r | c | e )-( C | o | d | e )
 * \_/ \_/ \_/ \_/ \_/   \_/ \_/ \_/ \_/ \_/ \_/   \_/ \_/ \_/ \_/
 *
 * @param mixed $name
 * @param mixed $arr
 * @param mixed $val
 */
//|------------------------------------------------------- |\\
//|search for subtiles on http://www.opensubtitles.org/    |\\
//|made by putyn @tbdev 27/2/2009                          |\\
//|--------------------------------------------------------|\\

//function to build the menu

function build_menu($name, $arr, $val="")
{
    $menu='';
    if (!is_array($arr)) {
        die("cant build menu");
    }

    $menu .= "<select name=\"" . $name . "\"><option value=\"\">Select</option>\n";
    foreach ($arr as $value=>$opname) {
        $menu .="<option value=\"" . $value . "\" " . ($value == $val ? "selected=\"selected\"" : "") . ">" . $opname . "</option>\n";
    }
    $menu .="</select>";
    return $menu;
}
//arrays for menu
$lang_menu = [
    "all"=>"ALL",
    "alb"=>"Albanian",
    "ara"=>"Arabic",
    "arm"=>"Armenian",
    "ass"=>"Assyrian",
    "bos"=>"Bosnian",
    "bul"=>"Bulgarian",
    "cat"=>"Catalan",
    "chi"=>"Chinese",
    "hrv"=>"Croatian",
    "cze"=>"Czech",
    "dan"=>"Danish",
    "dut"=>"Dutch",
    "eng"=>"English",
    "epo"=>"Esperanto",
    "est"=>"Estonian",
    "per"=>"Farsi",
    "fin"=>"Finnish",
    "fre"=>"French",
    "glg"=>"Galician",
    "geo"=>"Georgian",
    "ger"=>"German",
    "ell"=>"Greek",
    "heb"=>"Hebrew",
    "hin"=>"Hindi",
    "hun"=>"Hungarian",
    "ice"=>"Icelandic",
    "ind"=>"Indonesian",
    "ita"=>"Italian",
    "jpn"=>"Japanese",
    "kaz"=>"Kazakh",
    "kor"=>"Korean",
    "lav"=>"Latvian",
    "lit"=>"Lithuanian",
    "ltz"=>"Luxembourgish",
    "mac"=>"Macedonian",
    "may"=>"Malay",
    "nor"=>"Norwegian",
    "oci"=>"Occitan",
    "pol"=>"Polish",
    "por"=>"Portuguese",
    "pob"=>"Portuguese-BR",
    "rum"=>"Romanian",
    "rus"=>"Russian",
    "scc"=>"Serbian",
    "slo"=>"Slovak",
    "slv"=>"Slovenian",
    "spa"=>"Spanish",
    "swe"=>"Swedish",
    "tha"=>"Thai",
    "tur"=>"Turkish",
    "ukr"=>"Ukrainian",
    "urd"=>"Urdu",
    "vie"=>"Vietnamese"];
$fps_menu = [
    "23.976"=>"23.976",
    "23.980"=>"23.980",
    "24.000"=>"24.000",
    "25.000"=>"25.000",
    "29.970"=>"29.970",
    "30.000"=>"30.000"
];
$format_menu = [
    "sub"=>"sub",
    "srt"=>"srt",
    "txt"=>"txt",
    "ssa"=>"ssa",
    "smi"=>"smi",
    "mpl"=>"mpl",
    "tmp"=>"tmp"
];
$cds_menu = [
    "1"=>"1 CD",
    "2"=>"2 CDs",
    "3"=>"3 CDs",
    "4"=>"4 CDs"
];
