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
    $newpage->check('taud');
}
if ($CURUSER['class'] < UC_UPLOADER OR $CURUSER["uploadpos"] == 0 || $CURUSER["uploadpos"] > 1 || $CURUSER['suspended'] == 'yes') {
    header("Location: {$INSTALLER09['baseurl']}/upload.php");
    exit();
}
foreach (explode(":", "descr:type:name") as $v) {
    if (!isset($_POST[$v]))
        stderr($lang['takeupload_failed'], $lang['takeupload_no_formdata']);
}
if (!isset($_FILES["file"]))
    stderr($lang['takeupload_failed'], $lang['takeupload_no_formdata']);

$f     = $_FILES["file"];
$fname = unesc($f["name"]);
if (empty($fname))
    stderr($lang['takeupload_failed'], $lang['takeupload_no_filename']);
if (isset($_POST['uplver']) && $_POST['uplver'] == 'yes') {
    $anonymous = "yes";
    $anon      = "Anonymous";
} else {
    $anonymous = "no";
    $anon      = $CURUSER["username"];
}
if (isset($_POST['allow_comments']) && $_POST['allow_comments'] == 'yes') {
    $allow_comments = "no";
    $disallow       = "Yes";
} else {
    $allow_comments = "yes";
    $disallow       = "No";
}
if (isset($_POST["music"])) {
    $genre = implode(",", $_POST['music']);
} elseif (isset($_POST["movie"])) {
    $genre = implode(",", $_POST['movie']);
} elseif (isset($_POST["game"])) {
    $genre = implode(",", $_POST['game']);
} elseif (isset($_POST["apps"])) {
    $genre = implode(",", $_POST['apps']);
} else {
    $genre = '';
}
$nfo = sqlesc('');
/////////////////////// NFO FILE ////////////////////////
if (isset($_FILES['nfo']) && !empty($_FILES['nfo']['name'])) {
    $nfofile = $_FILES['nfo'];
    if ($nfofile['name'] == '')
        stderr($lang['takeupload_failed'], $lang['takeupload_no_nfo']);
    if ($nfofile['size'] == 0)
        stderr($lang['takeupload_failed'], $lang['takeupload_0_byte']);
    if ($nfofile['size'] > 65535)
        stderr($lang['takeupload_failed'], $lang['takeupload_nfo_big']);
    $nfofilename = $nfofile['tmp_name'];
    if (@!is_uploaded_file($nfofilename))
        stderr($lang['takeupload_failed'], $lang['takeupload_nfo_failed']);
    $nfo = sqlesc(str_replace("\x0d\x0d\x0a", "\x0d\x0a", @file_get_contents($nfofilename)));
}
/////////////////////// NFO FILE END /////////////////////
/// Set Freeleech on Torrent Time Based
$free2 = 0;
if (isset($_POST['free_length']) && ($free_length = 0 + $_POST['free_length'])) {
    if ($free_length == 255)
        $free2 = 1;
    elseif ($free_length == 42)
        $free2 = (86400 + TIME_NOW);
    else
        $free2 = (TIME_NOW + $free_length * 604800);
}
/// end
/// Set Silver Torrent Time Based
$silver = 0;
if (isset($_POST['half_length']) && ($half_length = 0 + $_POST['half_length'])) {
    if ($half_length == 255)
        $silver = 1;
    elseif ($half_length == 42)
        $silver = (86400 + TIME_NOW);
    else
        $silver = (TIME_NOW + $half_length * 604800);
}
/// end
//==Xbt freetorrent
$freetorrent = (((isset($_POST['freetorrent']) && is_valid_id($_POST['freetorrent'])) ? intval($_POST['freetorrent']) : 0));
$descr       = strip_tags(isset($_POST['descr']) ? trim($_POST['descr']) : '');
if (!$descr)
    stderr($lang['takeupload_failed'], $lang['takeupload_no_descr']);
$description = strip_tags(isset($_POST['description']) ? trim($_POST['description']) : '');
if (isset($_POST['strip']) && $_POST['strip']) {
    require_once(INCL_DIR . 'strip.php');
    $descr = preg_replace("/[^\\x20-\\x7e\\x0a\\x0d]/", " ", $descr);
    strip($descr);
    //$descr = preg_replace("/\n+/","\n",$descr);
    
}
$catid = (0 + $_POST["type"]);
if (!is_valid_id($catid))
    stderr($lang['takeupload_failed'], $lang['takeupload_no_cat']);
$request             = (((isset($_POST['request']) && is_valid_id($_POST['request'])) ? intval($_POST['request']) : 0));
$offer               = (((isset($_POST['offer']) && is_valid_id($_POST['offer'])) ? intval($_POST['offer']) : 0));
$subs                = isset($_POST["subs"]) ? implode(",", $_POST['subs']) : "";
$release_group_array = array(
    'scene' => 1,
    'p2p' => 1,
    'none' => 1
);
$release_group       = isset($_POST['release_group']) && isset($release_group_array[$_POST['release_group']]) ? $_POST['release_group'] : 'none';
$youtube             = '';
if (isset($_POST['youtube']) && preg_match($youtube_pattern, $_POST['youtube'], $temp_youtube))
    $youtube = $temp_youtube[0];
$tags = strip_tags(isset($_POST['tags']) ? trim($_POST['tags']) : '');
if (!validfilename($fname))
    stderr($lang['takeupload_failed'], $lang['takeupload_invalid']);
if (!preg_match('/^(.+)\.torrent$/si', $fname, $matches))
    stderr($lang['takeupload_failed'], $lang['takeupload_not_torrent']);
$shortfname = $torrent = $matches[1];
if (!empty($_POST["name"]))
    $torrent = unesc($_POST["name"]);
$tmpname = $f["tmp_name"];
if (!is_uploaded_file($tmpname))
    stderr($lang['takeupload_failed'], $lang['takeupload_eek']);
if (!filesize($tmpname))
    stderr($lang['takeupload_failed'], $lang['takeupload_no_file']);
// bencdec by djGrrr <3
$dict = bencdec::decode_file($tmpname, $INSTALLER09['max_torrent_size'], bencdec::OPTION_EXTENDED_VALIDATION);
if ($dict === false)
    stderr('Error', 'What the hell did you upload? This is not a bencoded file!');
if (isset($dict['announce-list']))
    unset($dict['announce-list']);
$dict['info']['private'] = 1;
if (!isset($dict['info']))
    stderr('Error', 'invalid torrent, info dictionary does not exist');
$info =& $dict['info'];
$infohash = pack("H*", sha1(bencdec::encode($info)));
if (bencdec::get_type($info) != 'dictionary')
    stderr('Error', 'invalid torrent, info is not a dictionary');
if (!isset($info['name']) || !isset($info['piece length']) || !isset($info['pieces']))
    stderr('Error', 'invalid torrent, missing parts of the info dictionary');
if (bencdec::get_type($info['name']) != 'string' || bencdec::get_type($info['piece length']) != 'integer' || bencdec::get_type($info['pieces']) != 'string')
    stderr('Error', 'invalid torrent, invalid types in info dictionary');
$dname      = $info['name'];
$plen       = $info['piece length'];
$pieces_len = strlen($info['pieces']);
if ($pieces_len % 20 != 0)
    stderr('Error', 'invalid pieces');
if ($plen % 4096)
    stderr('Error', 'piece size is not mod(4096), wtf kind of torrent is that?');
$filelist = array();
if (isset($info['length'])) {
    if (bencdec::get_type($info['length']) != 'integer')
        stderr('Error', 'length must be an integer');
    $totallen   = $info['length'];
    $filelist[] = array(
        $dname,
        $totallen
    );
    $type       = 'single';
} else {
    if (!isset($info['files']))
        stderr('Error', 'missing both length and files');
    if (bencdec::get_type($info['files']) != 'list')
        stderr('Error', 'invalid files, not a list');
    $flist =& $info['files'];
    if (!count($flist))
        stderr('Error', 'no files');
    $totallen = 0;
    foreach ($flist as $fn) {
        if (!isset($fn['length']) || !isset($fn['path']))
            stderr('Error', 'file info not found');
        if (bencdec::get_type($fn['length']) != 'integer' || bencdec::get_type($fn['path']) != 'list')
            stderr('Error', 'invalid file info');
        $ll = $fn['length'];
        $ff = $fn['path'];
        $totallen += $ll;
        $ffa = array();
        foreach ($ff as $ffe) {
            if (bencdec::get_type($ffe) != 'string')
                stderr('Error', 'filename type error');
            $ffa[] = $ffe;
        }
        if (!count($ffa))
            stderr('Error', 'filename error');
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
    stderr('Whoops', 'total file size and number of pieces do not match');
//==
$tmaker          = (isset($dict['created by']) && !empty($dict['created by'])) ? sqlesc($dict['created by']) : sqlesc($lang['takeupload_unkown']);
$dict['comment'] = ("In using this torrent you are bound by the {$INSTALLER09['site_name']} Confidentiality Agreement By Law"); // change torrent comment
// Replace punctuation characters with spaces
$visible         = (XBT_TRACKER == true ? "yes" : "no");
$torrent         = str_replace("_", " ", $torrent);
$vip             = (isset($_POST["vip"]) ? "1" : "0");
$url = strip_tags(isset($_POST['url']) ? trim($_POST['url']) : '');
if (!$url)
    stderr($lang['takeupload_failed'], 'No IMDB Found');
$poster = strip_tags(isset($_POST['poster']) ? trim($_POST['poster']) : '');
ret = sql_query("INSERT INTO torrents (search_text, filename, owner, username, visible, vip, release_group, newgenre, poster, anonymous, allow_comments, info_hash, name, size, numfiles, type, offer, request, url, subs, descr, ori_descr, description, category, free, silver, save_as, youtube, tags, added, last_action, mtime, ctime, freetorrent, nfo, client_created_by) VALUES (" . implode(",", array_map("sqlesc", array(
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
    0 + $_POST["type"],
    $free2,
    $silver,
    $dname,
    $youtube,
    $tags
))) . ", " . TIME_NOW . ", " . TIME_NOW . ", " . TIME_NOW . ", " . TIME_NOW . ", $freetorrent, $nfo, $tmaker)");
if (!$ret) {
    if (((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_errno($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_errno()) ? $___mysqli_res : false)) == 1062)
        stderr($lang['takeupload_failed'], $lang['takeupload_already']);
    stderr($lang['takeupload_failed'], "mysql puked: " . ((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
}
if (XBT_TRACKER == false) {
    remove_torrent($infohash);
}
$id = ((is_null($___mysqli_res = mysqli_insert_id($GLOBALS["___mysqli_ston"]))) ? false : $___mysqli_res);
$mc1->delete_value('MyPeers_' . $CURUSER['id']);
//$mc1->delete_value('lastest_tor_');  //
$mc1->delete_value('last5_tor_');
$mc1->delete_value('scroll_tor_');

sql_query("DELETE FROM files WHERE torrent = " . sqlesc($id));
function file_list($arr, $id)
{
    foreach ($arr as $v)
        $new[] = "($id," . sqlesc($v[0]) . "," . $v[1] . ")";
    return join(",", $new);
}
sql_query("INSERT INTO files (torrent, filename, size) VALUES " . file_list($filelist, $id));
//==
$dir = $INSTALLER09['torrent_dir'] . '/' . $id . '.torrent';
if (!bencdec::encode_file($dir, $dict))
    stderr('Error', 'Could not properly encode file');
@unlink($tmpname);
chmod($dir, 0664);
//==

//=== if it was an offer notify the folks who liked it :D
if ($offer > 0) {
    $res_offer = sql_query('SELECT user_id FROM offer_votes WHERE vote = \'yes\' AND user_id != ' . sqlesc($CURUSER['id']) . ' AND offer_id = ' . sqlesc($offer)) or sqlerr(__FILE__, __LINE__);
    $subject = sqlesc('An offer you voted for has been uploaded!');
    $message = sqlesc("Hi, \n An offer you were interested in has been uploaded!!! \n\n Click  [url=" . $INSTALLER09['baseurl'] . "/details.php?id=" . $id . "]" . htmlsafechars($torrent, ENT_QUOTES) . "[/url] to see the torrent page!");
    while ($arr_offer = mysqli_fetch_assoc($res_offer)) {
        sql_query('INSERT INTO messages (sender, receiver, added, msg, subject, saved, location) 
    VALUES(0, ' . sqlesc($arr_offer['user_id']) . ', ' . TIME_NOW . ', ' . $message . ', ' . $subject . ', \'yes\', 1)') or sqlerr(__FILE__, __LINE__);
        $mc1->delete_value('inbox_new_' . $arr_offer['user_id']);
        $mc1->delete_value('inbox_new_sb_' . $arr_offer['user_id']);
    }
    write_log('Offered torrent ' . $id . ' (' . htmlsafechars($torrent) . ') was uploaded by ' . $CURUSER['username']);
    $filled = 1;
}
$filled = 0;
//=== if it was a request notify the folks who voted :D
if ($request > 0) {
    $res_req = sql_query('SELECT user_id FROM request_votes WHERE vote = \'yes\' AND request_id = ' . sqlesc($request)) or sqlerr(__FILE__, __LINE__);
    $subject = sqlesc('A  request you were interested in has been uploaded!');
    $message = sqlesc("Hi :D \n A request you were interested in has been uploaded!!! \n\n Click  [url=" . $INSTALLER09['baseurl'] . "/details.php?id=" . $id . "]" . htmlsafechars($torrent, ENT_QUOTES) . "[/url] to see the torrent page!");
    while ($arr_req = mysqli_fetch_assoc($res_req)) {
        sql_query('INSERT INTO messages (sender, receiver, added, msg, subject, saved, location) 
    VALUES(0, ' . sqlesc($arr_req['user_id']) . ', ' . TIME_NOW . ', ' . $message . ', ' . $subject . ', \'yes\', 1)') or sqlerr(__FILE__, __LINE__);
        $mc1->delete_value('inbox_new_' . $arr_req['user_id']);
        $mc1->delete_value('inbox_new_sb_' . $arr_req['user_id']);
    }
    sql_query('UPDATE requests SET filled_by_user_id = ' . sqlesc($CURUSER['id']) . ', filled_torrent_id = ' . sqlesc($id) . ' WHERE id = ' . sqlesc($request)) or sqlerr(__FILE__, __LINE__);
    sql_query("UPDATE usersachiev SET reqfilled = reqfilled + 1 WHERE id =" . sqlesc($CURUSER['id'])) or sqlerr(__FILE__, __LINE__);
    write_log('Request for torrent ' . $id . ' (' . htmlsafechars($torrent) . ') was filled by ' . $CURUSER['username']);
    $filled = 1;
}
if ($filled == 0)
    write_log(sprintf($lang['takeupload_log'], $id, $torrent, $CURUSER['username']));
/* RSS feeds */
if (($fd1 = @fopen("rss.xml", "w")) && ($fd2 = fopen("rssdd.xml", "w"))) {
    $cats = "";
    $res  = sql_query("SELECT id, name FROM categories");
    while ($arr = mysqli_fetch_assoc($res))
        $cats[$arr["id"]] = htmlsafechars($arr["name"]);
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
/* end rss */
$categorie = genrelist();
foreach ($categorie as $key => $value) $change[$value['id']] = array(
    'id' => $value['id'],
    'name' => $value['name']
);
$Cat_Name['cat_name'] = htmlsafechars($change[$_POST['type']]['name']);
if ($INSTALLER09['seedbonus_on'] == 1) {
    if (isset($_POST['uplver']) && $_POST['uplver'] == 'yes')
        $message = "New Torrent : Category = ".htmlsafechars($Cat_Name['cat_name']).", [url={$INSTALLER09['baseurl']}/details.php?id=$id] " . htmlsafechars($torrent) . "[/url] Uploaded - Anonymous User";
else
        $message = "New Torrent : Category = ".htmlsafechars($Cat_Name['cat_name']).", [url={$INSTALLER09['baseurl']}/details.php?id=$id] " . htmlsafechars($torrent) . "[/url] Uploaded by " . htmlsafechars($CURUSER["username"]) . "";
        $messages = "{$INSTALLER09['site_name']} New Torrent : Category = ".htmlsafechars($Cat_Name['cat_name']).", $torrent Uploaded By: $anon " . mksize($totallen) . " {$INSTALLER09['baseurl']}/details.php?id=$id";
    //===add karma
    sql_query("UPDATE users SET seedbonus=seedbonus+" . sqlesc($INSTALLER09['bonus_per_upload']) . ", numuploads=numuploads+1 WHERE id = " . sqlesc($CURUSER["id"])) or sqlerr(__FILE__, __LINE__);
    //===end
    $update['seedbonus'] = ($CURUSER['seedbonus'] + $INSTALLER09['bonus_per_upload']);
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
if ($INSTALLER09['autoshout_on'] == 1) {
    autoshout($message);
    ircbot($messages);
    $mc1->delete_value('shoutbox_');
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
header("Location: {$INSTALLER09['baseurl']}/details.php?id=$id&uploaded=1");
?> 
