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
// by system
// pic management by pdq
// no rights reserved - public domain FTW!
require_once (__DIR__.DIRECTORY_SEPARATOR.'include'.DIRECTORY_SEPARATOR.'bittorrent.php');
require_once (INCL_DIR.'user_functions.php');
require_once (INCL_DIR.'bbcode_functions.php');
dbconn();
loggedinorreturn();
$lang = array_merge(load_language('global') , load_language('bitbucket'));
$HTMLOUT = "";
/* Image folder located outside of webroot */
// BITBUCKET_DIR Now defined in config.php
//define('BITBUCKET_DIR', DIRECTORY_SEPARATOR.'var'.DIRECTORY_SEPARATOR.'bucket');
/* Avatar folder located inside BITBUCKET_DIR */
define('AVATAR_DIR', BITBUCKET_DIR.DIRECTORY_SEPARATOR.'avatar');
if (!is_dir(AVATAR_DIR)) {
    mkdir(AVATAR_DIR);
}
$SaLt = 'mE0wI924dsfsfs!@B'; // change this!
$SaLty = '8368364562'; // NEW!
$skey = 'eTe5$Ybnsccgbsfdsfsw4h6W'; // change this!
$maxsize = $INSTALLER09['bucket_maxsize'];
/* seperate images into */
$folders = date('Y/m');
// valid file formats
$formats = array(
    '.gif',
    '.jpg',
    '.jpeg',
    '.png',
);
// path to bucket/avatar directories
$bucketdir = (isset($_POST["avy"]) ? AVATAR_DIR.'/' : BITBUCKET_DIR.'/'.$folders.'/');
$bucketlink = ((isset($_POST["avy"]) || (isset($_GET['images']) && $_GET['images'] == 2)) ? 'avatar/' : $folders.'/');
$address = $INSTALLER09['baseurl'].'/';
$PICSALT = md5($SaLt . $CURUSER['username']);
//rename files and obscufate uploader
$USERSALT = substr(md5($SaLty.$CURUSER['id']) , 0, 6);
/* this is a hack, you should create folders named 2012, 2013, 2014, etc,
* inside these folders you should have folders for the months named 01 to 12
* then comment out the following 2 lines
*/
make_year(BITBUCKET_DIR);
make_month(BITBUCKET_DIR);
if (!isset($_FILES['file'])) {
    if (isset($_GET["delete"])) {
        $getfile = htmlsafechars($_GET['delete']);
        $delfile = urldecode(decrypt($getfile));
        $delhash = md5($delfile.$USERSALT.$SaLt);
        //$delhash = md5($delfile . $CURUSER['username'] . $SaLt);
        if ($delhash != $_GET['delhash']) stderr($lang['bitbucket_umm'], "{$lang['bitbucket_wayd']}");
        //$myfile = ROOT_DIR . '/' . $delfile; //== for pdq define directories
        //$myfile = '/home/yourdir/public_html/'.$delfile; // Full relative path to web root
        $myfile = BITBUCKET_DIR.'/'.$delfile;
        if ((($pi = pathinfo($myfile)) && preg_match('#^(jpg|jpeg|gif|png)$#i', $pi['extension'])) && is_file($myfile))
        //if (is_file($myfile))
        unlink($myfile);
        else stderr($lang['bitbucket_hey'], "{$lang['bitbucket_imagenf']}");
        $folder_m = (!isset($_GET['month']) ? '&month='.date('m') : '&month='.(int)$_GET['month']);
        $yea = (!isset($_GET['year']) ? '&year='.date('Y') : '&year='.(int)$_GET['year']);
        if (isset($_GET["type"]) && $_GET["type"] == 2) header("Refresh: 2; url={$INSTALLER09['baseurl']}/bitbucket.php?images=2");
        else header("Refresh: 2; url={$INSTALLER09['baseurl']}/bitbucket.php?images=1".$yea.$folder_m);
        die($lang['bitbucket_deleting'] . $delfile . $lang['bitbucket_redir']);
    }
    if (isset($_GET["avatar"]) && $_GET["avatar"] != '' && (($_GET["avatar"]) != $CURUSER["avatar"])) {
        $type = ((isset($_GET["type"]) && $_GET["type"] == 1) ? 1 : 2);
        if (preg_match("/^http:\/\/$/i", $_GET["avatar"]) OR preg_match("/[?&;]/", $_GET["avatar"]) OR preg_match("#javascript:#is", $_GET["avatar"]) OR !preg_match("#^https?://(?:[^<>*\"]+|[a-z0-9/\._\-!]+)$#iU", $_GET["avatar"])) stderr($lang['bitbucket_error'], "{$lang['bitbucket_mustbe']}");
        $avatar = sqlesc($_GET['avatar']);
        sql_query("UPDATE users SET avatar = $avatar WHERE id = {$CURUSER['id']}") or sqlerr(__FILE__, __LINE__);
        $mc1->begin_transaction('MyUser_'.$CURUSER['id']);
        $mc1->update_row(false, array(
            'avatar' => $_GET['avatar']
        ));
        $mc1->commit_transaction($INSTALLER09['expires']['curuser']);
        $mc1->begin_transaction('user'.$CURUSER['id']);
        $mc1->update_row(false, array(
            'avatar' => $_GET['avatar']
        ));
        $mc1->commit_transaction($INSTALLER09['expires']['user_cache']);
        header("Refresh: 0; url={$INSTALLER09['baseurl']}/bitbucket.php?images=$type&updated=avatar");
    }
    if (isset($_GET["updated"]) && $_GET["updated"] == 'avatar') {
        $HTMLOUT.= "<h3>{$lang['bitbucket_updated']}<img src='".htmlsafechars($CURUSER['avatar'])."' border='0' alt='' /></h3>";
    }
    $HTMLOUT.= "<form action=\"".$_SERVER['PHP_SELF']."\" method=\"post\" enctype=\"multipart/form-data\">
<table width=\"300\" align=\"center\">
<tr>
<td class=\"clearalt6\" align=\"center\"><p><b>{$lang['bitbucket_invalid_extension']}".join(', ', $formats)."</b></p>
<p><b>{$lang['bitbucket_max']}".mksize($maxsize)."</b></p>
<p>{$lang['bitbucket_disclaimer']}</p></td>
</tr>
<tr>
<td align=\"center\"><input type=\"file\" name=\"file\" /></td>
</tr>
<tr><td align=\"center\"> <input type=\"checkbox\" name=\"avy\" value=\"1\" />{$lang['bitbucket_tick']}</td> </tr>
<tr>
<td align=\"center\"><input class=\"btn\" type=\"submit\" value=\"{$lang['bitbucket_upload']}\" /></td>
</tr>
</table>
</form>";
    $HTMLOUT.= "<script type=\"text/javascript\">
/*<![CDATA[*/
function SelectAll(id)
{
document.getElementById(id).focus();
document.getElementById(id).select();
}
/*]]>*/
</script>";
    if (isset($_GET['images']) && $_GET['images'] == 1) {
        $folder_month = (!isset($_GET['month']) ? date('m') : ($_GET['month'] < 10 ? '0' : '').(int)$_GET['month']);
        $year = (!isset($_GET['year']) ? '&amp;year='.date('Y') : '&amp;year='.(int)$_GET['year']);
        $HTMLOUT.= '<p align="center"><a href="bitbucket.php?images=2">' . $lang['bitbucket_viewmya'] . '</a></p>
<p align="center"><a href="bitbucket.php">' . $lang['bitbucket_hideimgs'] . '</a></p>
<p align="center"><b>' . $lang['bitbucket_previousimg'] . '</b><br />
<a href="bitbucket.php?images=1&amp;month='.$folder_month.'&amp;year='.(isset($_GET['year']) && $_GET['year'] != date('Y') ? date('Y').'">This' : (date('Y') - 1).'">' . $lang['bitbucket_last'] . '').'' . $lang['bitbucket_year'] . '</a> &nbsp;
<a href="bitbucket.php?images=1&amp;month=01'.$year.'">' . $lang['bitbucket_jan'] . '</a> &nbsp;
<a href="bitbucket.php?images=1&amp;month=02'.$year.'">' . $lang['bitbucket_feb'] . '</a> &nbsp;
<a href="bitbucket.php?images=1&amp;month=03'.$year.'">' . $lang['bitbucket_mar'] . '</a> &nbsp;
<a href="bitbucket.php?images=1&amp;month=04'.$year.'">' . $lang['bitbucket_apr'] . '</a> &nbsp;
<a href="bitbucket.php?images=1&amp;month=05'.$year.'">' . $lang['bitbucket_may'] . '</a> &nbsp;
<a href="bitbucket.php?images=1&amp;month=06'.$year.'">' . $lang['bitbucket_june'] . '</a> &nbsp;
<a href="bitbucket.php?images=1&amp;month=07'.$year.'">' . $lang['bitbucket_jul'] . '</a> &nbsp;
<a href="bitbucket.php?images=1&amp;month=08'.$year.'">' . $lang['bitbucket_aug'] . '</a> &nbsp;
<a href="bitbucket.php?images=1&amp;month=09'.$year.'">' . $lang['bitbucket_sep'] . '</a> &nbsp;
<a href="bitbucket.php?images=1&amp;month=10'.$year.'">' . $lang['bitbucket_oct'] . '</a> &nbsp;
<a href="bitbucket.php?images=1&amp;month=11'.$year.'">' . $lang['bitbucket_nov'] . '</a> &nbsp;
<a href="bitbucket.php?images=1&amp;month=12'.$year.'">' . $lang['bitbucket_dec'] . '</a> &nbsp;
</p>';
    } elseif (isset($_GET['images']) && $_GET['images'] == 2) {
        $HTMLOUT.= "<p align=\"center\"><a href=\"{$INSTALLER09['baseurl']}/bitbucket.php?images=1\">{$lang['bitbucket_viewmonths']}</a></p>
<p align=\"center\"><a href=\"{$INSTALLER09['baseurl']}/bitbucket.php\">{$lang['bitbucket_hidemya']}</a></p>";
    } else {
        $HTMLOUT.= "<p align=\"center\"><a href=\"{$INSTALLER09['baseurl']}/bitbucket.php?images=1\">{$lang['bitbucket_viewmonths']}</a></p>
<p align=\"center\"><a href=\"{$INSTALLER09['baseurl']}/bitbucket.php?images=2\">{$lang['bitbucket_viewmya']}</a></p>";
    }
    if (isset($_GET['images'])) {
        $folder_month = (!isset($_GET['month']) ? date('m') : ($_GET['month'] < 10 ? '0' : '').(int)$_GET['month']);
        $folder_name = (!isset($_GET['year']) ? date('Y').'/' : (int)$_GET['year'].'/').$folder_month;
        $bucketlink2 = ((isset($_POST["avy"]) || (isset($_GET['images']) && $_GET['images'] == 2)) ? 'avatars/' : $folder_name.'/');
        foreach ((array)glob(($_GET['images'] == 2 ? AVATAR_DIR.'/'.$USERSALT : BITBUCKET_DIR.'/'.$folder_name.'/'.$USERSALT).'_*') as $filename) {
            if (!empty($filename)) {
                $filename = basename($filename);
                $filename = $bucketlink2.$filename;
                $encryptedfilename = urlencode(encrypt($filename));
                $eid = md5($filename);
                $HTMLOUT.= "<a href=\"{$address}img.php/{$filename}\"><img src=\"{$address}img.php/{$filename}\" width=\"200\" alt=\"\" /><br />{$address}img.php/{$filename}</a><br />";
                $HTMLOUT.= "<p>{$lang['bitbucket_directlink']}<br /><input style=\"font-size: 9pt;text-align: center;\" id=\"d".$eid."d\" onclick=\"SelectAll('d".$eid."d');\" type=\"text\" size=\"70\" value=\"{$address}img.php/{$filename}\" readonly=\"readonly\" /></p>";
                $HTMLOUT.= "<p align=\"center\">{$lang['bitbucket_tags']}<br /><input style=\"font-size: 9pt;text-align: center;\" id=\"t".$eid."t\" onclick=\"SelectAll('t".$eid."t');\" type=\"text\" size=\"70\" value=\"[img]{$address}img.php/{$filename}[/img]\" readonly=\"readonly\" /></p>";
                $HTMLOUT.= "<p align=\"center\"><a href=\"{$INSTALLER09['baseurl']}/bitbucket.php?type=".((isset($_GET['images']) && $_GET['images'] == 2) ? '2' : '1')."&amp;avatar={$address}img.php/{$filename}\">{$lang['bitbucket_maketma']}</a></p>";
                $HTMLOUT.= "<p align=\"center\"><a href=\"{$INSTALLER09['baseurl']}/bitbucket.php?type=".((isset($_GET['images']) && $_GET['images'] == 2) ? '2' : '1')."&amp;delete=".$encryptedfilename."&amp;delhash=".md5($filename.$USERSALT.$SaLt)."&amp;month=".(!isset($_GET['month']) ? date('m') : ($_GET['month'] < 10 ? '0' : '').(int)$_GET['month'])."&amp;year=".(!isset($_GET['year']) ? date('Y') : (int)$_GET['year'])."\">{$lang['bitbucket_delete']}</a></p><br />";
            } else $HTMLOUT.= "{$lang['bitbucket_noimages']}";
        }
    }
    echo stdhead($lang['bitbucket_bitbucket']).$HTMLOUT.stdfoot();
    exit();
}
if ($_FILES['file']['size'] == 0) stderr($lang['bitbucket_error'], $lang['bitbucket_upfail']);
if ($_FILES['file']['size'] > $maxsize) stderr($lang['bitbucket_error'], $lang['bitbucket_to_large']);
$file = preg_replace('`[^a-z0-9\-\_\.]`i', '', $_FILES['file']['name']);
$allow = ','.join(',', $formats);
if (false === stristr($allow, ','.substr($file, -4))) stderr($lang['bitbucket_err'], $lang['bitbucket_invalid']);
if (!function_exists('exif_imagetype')) {
    function exif_imagetype($filename)
    {
        if ((list($width, $height, $type, $attr) = getimagesize($filename)) !== false) {
            return $type;
        }
        return false;
    }
}
$it1 = exif_imagetype($_FILES['file']['tmp_name']);
if ($it1 != IMAGETYPE_GIF && $it1 != IMAGETYPE_JPEG && $it1 != IMAGETYPE_PNG) {
    $HTMLOUT.= "<h1>{$lang['bitbucket_upfail']}<br />{$lang['bitbucket_sorry']}";
    exit;
}
$file = strtolower($file);
$path = $bucketdir.$USERSALT.'_'.$file;
$pathlink = $bucketlink.$USERSALT.'_'.$file;
$loop = 0;
while (true) {
    if ($loop > 10) stderr($lang['bitbucket_error'], $lang['bitbucket_upfail']);
    if (!file_exists($path)) break;

    $randb = bucketrand();
    $path = $bucketdir.$USERSALT.'_'.$randb.$file;
    $pathlink = $bucketlink.$USERSALT.'_'.$randb.$file;
    $loop++;
}
if (!move_uploaded_file($_FILES['file']['tmp_name'], $path)) stderr($lang['bitbucket_error'], $lang['bitbucket_upfail']);
if (isset($_POST["from"]) && $_POST["from"] == "upload") {
    echo "<p><b><font color='red'>{$lang['bitbucket_success']}</b></p>
<p><b><strong>".$address."img.php/".$pathlink."</strong></font></b></p>";
    exit;
}
$HTMLOUT.= "<table width=\"300\" align=\"center\">
<tr class=\"clear\">
<td align=\"center\"><p><a href=\"".$_SERVER['PHP_SELF']."\"><strong>{$lang['bitbucket_up_another']}</strong></a></p>
<p>{$lang['bitbucket_thefile']}</p>
<p><img src=\"".$address."img.php/".$pathlink."\" border=\"0\" alt=\"\"/></p>";
$HTMLOUT.= "<script type=\"text/javascript\">
/*<![CDATA[*/
function SelectAll(id)
{
document.getElementById(id).focus();
document.getElementById(id).select();
}
/*]]>*/
</script>";
$HTMLOUT.= "<p>{$lang['bitbucket_directlink']}<br />
<input style=\"font-size: 9pt;text-align: center;\" id=\"direct\" onclick=\"SelectAll('direct');\" type=\"text\" size=\"70\" value=\"".$address."img.php/".$pathlink."\" readonly=\"readonly\" /></p>
<p align=\"center\">{$lang['bitbucket_tags']}
<input style=\"font-size: 9pt;text-align: center;\" id=\"tag\" onclick=\"SelectAll('tag');\" type=\"text\" size=\"70\" value=\"[img]".$address."img.php/".$pathlink."[/img]\" readonly=\"readonly\" /></p>
<p align=\"center\"><a href=\"{$INSTALLER09['baseurl']}/bitbucket.php?images=1\">{$lang['bitbucket_viewmyi']}</a></p>
<p align=\"center\"><a href=\"{$INSTALLER09['baseurl']}/bitbucket.php?images=2\">{$lang['bitbucket_viewmya']}</a></p>
</td>
</tr>
</table>";
echo stdhead($lang['bitbucket_bitbucket']).$HTMLOUT.stdfoot();
function bucketrand()
{
    $chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $out = '';
    for ($i = 0; $i < 6; $i++) $out.= $chars[mt_rand(0, 61) ];
    return $out;
}
function encrypt($text)
{
    global $PICSALT;
    return trim(base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $PICSALT, $text, MCRYPT_MODE_ECB, mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB) , MCRYPT_RAND))));
}
function decrypt($text)
{
    global $PICSALT;
    return trim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $PICSALT, base64_decode($text) , MCRYPT_MODE_ECB, mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB) , MCRYPT_RAND)));
}
/* Sanity checking by pdq */
function valid_path($root, $input)
{
    $fullpath = $root.$input;
    $fullpath = realpath($fullpath);
    $root = realpath($root);
    $rl = strlen($root);
    return ($root != substr($fullpath, 0, $rl)) ? NULL : $fullpath;
}
function make_year($path)
{
    $dir = $path.'/'.date('Y');
    if (!is_dir($dir)) mkdir($dir);
}
function make_month($path)
{
    $dir = $path.'/'.date('Y/m');
    if (!is_dir($dir)) mkdir($dir);
}
// EndFile

?>
