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
require_once(__DIR__ . DIRECTORY_SEPARATOR . 'include' . DIRECTORY_SEPARATOR . 'bittorrent.php');
require_once(INCL_DIR . 'user_functions.php');
require_once(CLASS_DIR . 'page_verify.php');
require_once(CLASS_DIR . 'class.bencdec.php');
require_once INCL_DIR . 'function_ircbot.php';
require_once INCL_DIR . 'function_memcache.php';
dbconn();
loggedinorreturn();
ini_set('upload_max_filesize', $INSTALLER09['max_torrent_size']);
ini_set('memory_limit', '64M');
//smth putyn
//print_r($_POST);
//print_r($_GET);
//exit();
$auth_key = array(
    '2d257f64005d740db092a6b91170ab5f'
);
$gotkey   = isset($_POST['key']) && strlen($_POST['key']) == 32 && in_array($_POST['key'], $auth_key) ? true : false;
$lang     = array_merge(load_language('global'), load_language('takeupload'));
if (!$gotkey) {
    $newpage = new page_verify();
    $newpage->check('tamud');
}
if ($CURUSER['class'] < UC_UPLOADER OR $CURUSER["uploadpos"] == 0 || $CURUSER["uploadpos"] > 1 || $CURUSER['suspended'] == 'yes') {
    header("Location: {$INSTALLER09['baseurl']}/upload.php");
    exit();
}

$total_torrents = 0;

if (!isset($_FILES["file"]))
    stderr($lang['takeupload_failed'], $lang['takeupload_no_formdata']);

$total_torrents = count($_FILES['file']['name']);
function file_list($arr, $id)
{
    foreach ($arr as $v)
        $new[] = "($id," . sqlesc($v[0]) . "," . $v[1] . ")";
    return join(",", $new);
}
$cats = "";
    $res  = sql_query("SELECT id, name FROM categories");
    while ($arr = mysqli_fetch_assoc($res))
        $cats[$arr["id"]] = $arr["name"];
$processed = 0;

//parse _FILES into readable format
$file_list = array();
while( $processed < $total_torrents ) {

    $file_list[$processed] = array();
    $file_list[$processed]['torrent'] = array();
    $file_list[$processed]['torrent']['name'] = $_FILES['file']['name'][$processed];
    $file_list[$processed]['torrent']['tmp_name'] = $_FILES['file']['tmp_name'][$processed];

    $file_list[$processed]['nfo'] = array();
    $file_list[$processed]['nfo']['name'] = $_FILES['nfo']['name'][$processed];
    $file_list[$processed]['nfo']['tmp_name'] = $_FILES['nfo']['tmp_name'][$processed];
    $file_list[$processed]['nfo']['size'] = $_FILES['nfo']['size'][$processed];

    $file_list[$processed]['type'] = $_POST['type'][$processed];

    $processed++;
}

$ids = [];

foreach( $file_list as $key=>$f ) {
    $fname = unesc($f['torrent']["name"]);

    if (empty($fname))
        continue;

    if (!validfilename($fname))
        continue;

    if (!preg_match('/^(.+)\.torrent$/si', $fname, $matches))
        continue;
    $shortfname = $torrent = $matches[1];

    $tmpname = $f['torrent']["tmp_name"];
    if (!is_uploaded_file($tmpname))
        continue;
    if (!filesize($tmpname))
        continue;

    $anonymous = "yes";
    $anon      = "Anonymous";
    $allow_comments = "yes";
    $disallow       = "No";
    $free =  $freetorrent = $silver = $request = $offer = 0;
    $descr = $description = $subs = $youtube = $tags = $poster = $genre = '';
    $release_group = 'none';

    $nfo = sqlesc('');

    $nfofile = $f['nfo'];
    if ($nfofile['name'] == '' || $nfofile['size'] == 0 || $nfofile['size'] > 65535) {
        $nfo = sqlesc('');
    } else {
        $nfofilename = $nfofile['tmp_name'];
        if (@!is_uploaded_file($nfofilename)) {
            $nfo = sqlesc('');
        } else {
            $nfo = sqlesc(str_replace("\x0d\x0d\x0a", "\x0d\x0a", @file_get_contents($nfofilename)));
            $descr = str_replace("\x0d\x0d\x0a", "\x0d\x0a", @file_get_contents($nfofilename));
        }
    }


    $catid = (0 + $f["type"]);
    if (!is_valid_id($catid))
        continue;



    $dict = bencdec::decode_file($tmpname, $INSTALLER09['max_torrent_size'], bencdec::OPTION_EXTENDED_VALIDATION);
    if ($dict === false)
        continue;
    if (isset($dict['announce-list']))
        unset($dict['announce-list']);
    $dict['info']['private'] = 1;
    if (!isset($dict['info']))
        continue;
    $info =& $dict['info'];
    $infohash = pack("H*", sha1(bencdec::encode($info)));
    if (bencdec::get_type($info) != 'dictionary')
        continue;
    if (!isset($info['name']) || !isset($info['piece length']) || !isset($info['pieces']))
        continue;
    if (bencdec::get_type($info['name']) != 'string' || bencdec::get_type($info['piece length']) != 'integer' || bencdec::get_type($info['pieces']) != 'string')
        continue;
    $dname      = $info['name'];
    $plen       = $info['piece length'];
    $pieces_len = strlen($info['pieces']);
    if ($pieces_len % 20 != 0)
        continue;
    if ($plen % 4096)
        continue;
    $filelist = array();
    if (isset($info['length'])) {
        if (bencdec::get_type($info['length']) != 'integer')
            continue;
        $totallen   = $info['length'];
        $filelist[] = array(
            $dname,
            $totallen
        );
        $type       = 'single';
    } else {
        if (!isset($info['files']))
            continue;
        if (bencdec::get_type($info['files']) != 'list')
            continue;
        $flist =& $info['files'];
        if (!count($flist))
            continue;
        $totallen = 0;
        foreach ($flist as $fn) {
            if (!isset($fn['length']) || !isset($fn['path']))
                continue;
            if (bencdec::get_type($fn['length']) != 'integer' || bencdec::get_type($fn['path']) != 'list')
                continue;
            $ll = $fn['length'];
            $ff = $fn['path'];
            $totallen += $ll;
            $ffa = array();
            foreach ($ff as $ffe) {
                if (bencdec::get_type($ffe) != 'string')
                    continue;
                $ffa[] = $ffe;
            }
            if (!count($ffa))
                continue;
            $ffe        = implode('/', $ffa);
            $filelist[] = array(
                $ffe,
                $ll
            );
        }
        $type = 'multi';
    }
    $num_pieces      = $pieces_len / 20;
    $expected_pieces = (int) ceil($totallen / $plen);
    if ($num_pieces != $expected_pieces)
        continue;
//==
    $tmaker          = (isset($dict['created by']) && !empty($dict['created by'])) ? sqlesc($dict['created by']) : sqlesc($lang['takeupload_unkown']);
    $dict['comment'] = ("In using this torrent you are bound by the {$INSTALLER09['site_name']} Confidentiality Agreement By Law"); // change torrent comment
// Replace punctuation characters with spaces
    $visible         = (XBT_TRACKER == true ? "yes" : "no");
    $torrent         = str_replace("_", " ", $torrent);
    $vip             = "0";


    $ret = sql_query("INSERT INTO torrents (search_text, filename, owner, username, visible, vip, release_group, newgenre, poster, anonymous, allow_comments, info_hash, name, size, numfiles, type, offer, request, url, subs, descr, ori_descr, description, category, free, silver, save_as, youtube, tags, added, last_action, mtime, ctime, freetorrent, nfo, client_created_by) VALUES (" . implode(",", array_map("sqlesc", array(
            searchfield("$shortfname $dname $torrent"),
            $fname,
            $CURUSER["id"],
            $CURUSER["username"],
            $visible,
            $vip,
            $release_group,
            $genre,
            $poster,
            $anonymous,
            $allow_comments,
            $infohash,
            $torrent,
            $totallen,
            count($filelist),
            $type,
            $offer,
            $request,
            $url,
            $subs,
            $descr,
            $descr,
            $description,
            $catid,
            $free,
            $silver,
            $dname,
            $youtube,
            $tags
        ))) . ", " . TIME_NOW . ", " . TIME_NOW . ", " . TIME_NOW . ", " . TIME_NOW . ", $freetorrent, $nfo, $tmaker)");

    if (!$ret) {
        if (((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_errno($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_errno()) ? $___mysqli_res : false)) == 1062)
            continue;
       // stderr($lang['takeupload_failed'], "mysql puked: " . ((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
    }

    if (XBT_TRACKER == false) {
        remove_torrent($infohash);
    }


    $id = ((is_null($___mysqli_res = mysqli_insert_id($GLOBALS["___mysqli_ston"]))) ? false : $___mysqli_res);

    $ids[] = $id;
    $messages = "{$INSTALLER09['site_name']} New Torrent: $torrent Uploaded By: $anon " . mksize($totallen) . " {$INSTALLER09['baseurl']}/details.php?id=$id";
    $message = "New Torrent : Category = ".htmlsafechars($cats[$catid]).", [url={$INSTALLER09['baseurl']}/details.php?id=$id] " . htmlsafechars($torrent) . "[/url] Uploaded - Anonymous User";

    sql_query("DELETE FROM files WHERE torrent = " . sqlesc($id));

    sql_query("INSERT INTO files (torrent, filename, size) VALUES " . file_list($filelist, $id));

    $dir = $INSTALLER09['torrent_dir'] . '/' . $id . '.torrent';
    if (!bencdec::encode_file($dir, $dict))
        continue;
    @unlink($tmpname);
    chmod($dir, 0664);



    if ($INSTALLER09['autoshout_on'] == 1) {
        autoshout($message);
        ircbot($messages);
        $mc1->delete_value('shoutbox_');
    }

    /* RSS feeds */
if (($fd1 = @fopen("rss.xml", "w")) && ($fd2 = fopen("rssdd.xml", "w"))) {
    
    $s = "<?xml version=\"1.0\" encoding=\"iso-8859-1\" ?>\n<rss version=\"0.91\">\n<channel>\n" . "<title>{$INSTALLER09['site_name']}</title>\n<description>Installer09 is the best!</description>\n<link>{$INSTALLER09['baseurl']}/</link>\n";
    @fwrite($fd1, $s);
    @fwrite($fd2, $s);
    $r = sql_query("SELECT id,name,descr,filename,category FROM torrents ORDER BY added DESC LIMIT 15") or sqlerr(__FILE__, __LINE__);
    while ($a = mysqli_fetch_assoc($r)) {
        $cat = $cats[$a["category"]];
        $s   = "<item>\n<title>" . htmlsafechars($a["name"] . " ($cat)") . "</title>\n" . "<description>" . htmlsafechars($a["descr"]) . "</description>\n";
        @fwrite($fd1, $s);
        @fwrite($fd2, $s);
        @fwrite($fd1, "<link>{$INSTALLER09['baseurl']}/details.php?id=" . (int) $a['id'] . "&amp;hit=1</link>\n</item>\n");
        $filename = htmlsafechars($a["filename"]);
        @fwrite($fd2, "<link>{$INSTALLER09['baseurl']}/download.php?torrent=" . (int) $a['id'] . "/$filename</link>\n</item>\n");
    }
    $s = "</channel>\n</rss>\n";
    @fwrite($fd1, $s);
    @fwrite($fd2, $s);
    @fclose($fd1);
    @fclose($fd2);
}
}


$mc1->delete_value('MyPeers_' . $CURUSER['id']);
//$mc1->delete_value('lastest_tor_');  //
$mc1->delete_value('last5_tor_');
$mc1->delete_value('scroll_tor_');

//==

//==
if ($INSTALLER09['seedbonus_on'] == 1) {

    $bonus_val = ($INSTALLER09['bonus_per_upload']*$total_torrents);
    //===add karma
    sql_query("UPDATE users SET seedbonus=seedbonus+" . sqlesc($bonus_val) . ", numuploads=numuploads+1 WHERE id = " . sqlesc($CURUSER["id"])) or sqlerr(__FILE__, __LINE__);
    //===end
    $update['seedbonus'] = ($CURUSER['seedbonus'] + $bonus_val);
    $mc1->begin_transaction('userstats_' . $CURUSER["id"]);
    $mc1->update_row(false, array(
        'seedbonus' => $update['seedbonus']
    ));
    $mc1->commit_transaction($INSTALLER09['expires']['u_stats']);
    $mc1->begin_transaction('user_stats_' . $CURUSER["id"]);
    $mc1->update_row(false, array(
        'seedbonus' => $update['seedbonus']
    ));
    $mc1->commit_transaction($INSTALLER09['expires']['user_stats']);
}


/* Email notifs */
/*******************

$res = sql_query("SELECT name FROM categories WHERE id=".sqlesc($catid)) or sqlerr(__FILE__, __LINE__);
$arr = mysqli_fetch_assoc($res);
$cat = htmlsafechars($arr["name"]);
$res = sql_query("SELECT email FROM users WHERE enabled='yes' AND notifs LIKE '%[cat$catid]%'") or sqlerr(__FILE__, __LINE__);
$uploader = $CURUSER['username'];

$size = mksize($totallen);
$description = ($html ? strip_tags($descr) : $descr);

$body = <<<EOD
A new torrent has been uploaded.

Name: $torrent
Size: $size
Category: $cat
Uploaded by: $uploader

Description
-------------------------------------------------------------------------------
$description
-------------------------------------------------------------------------------

You can use the URL below to download the torrent (you may have to login).

{$INSTALLER09['baseurl']}/details.php?id=$id&hit=1

-- 
{$INSTALLER09['site_name']}
EOD;

$to = "";
$nmax = 100; // Max recipients per message
$nthis = 0;
$ntotal = 0;
$total = mysqli_num_rows($res);
while ($arr = mysqli_fetch_row($res))
{
if ($nthis == 0)
$to = $arr[0];
else
$to .= "," . $arr[0];
++$nthis;
++$ntotal;
if ($nthis == $nmax || $ntotal == $total)
{
if (!mail("Multiple recipients <{$INSTALLER09['site_email']}>", "New torrent - $torrent", $body,
"From: {$INSTALLER09['site_email']}\r\nBcc: $to"))
stderr("Error", "Your torrent has been been uploaded. DO NOT RELOAD THE PAGE!\n" .
"There was however a problem delivering the e-mail notifcations.\n" .
"Please let an administrator know about this error!\n");
$nthis = 0;
}
}
 *******************/

$ids = implode('&id[]=',$ids);
header("Location: {$INSTALLER09['baseurl']}/multidetails.php?id[]=" . $ids);
?> 
