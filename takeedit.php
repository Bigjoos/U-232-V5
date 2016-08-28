<?php
/**
 |--------------------------------------------------------------------------|
 |   https://github.com/Bigjoos/                			    |
 |--------------------------------------------------------------------------|
 |   Licence Info: GPL			                                    |
 |--------------------------------------------------------------------------|
 |   Copyright (C) 2010 U-232 V5					    |
 |--------------------------------------------------------------------------|
 |   A bittorrent tracker source based on TBDev.net/tbsource/bytemonsoon.   |
 |--------------------------------------------------------------------------|
 |   Project Leaders: Mindless, Autotron, whocares, Swizzles.					    |
 |--------------------------------------------------------------------------|
  _   _   _   _   _     _   _   _   _   _   _     _   _   _   _
 / \ / \ / \ / \ / \   / \ / \ / \ / \ / \ / \   / \ / \ / \ / \
( U | - | 2 | 3 | 2 )-( S | o | u | r | c | e )-( C | o | d | e )
 \_/ \_/ \_/ \_/ \_/   \_/ \_/ \_/ \_/ \_/ \_/   \_/ \_/ \_/ \_/
 */
/**
 * @Credits Retro-Neptune-Bigjoos
 * @Project TBDev.net 09 takeedit.php
 * @Category Addon Mods
 * @Date Monday, Aug 2, 2010
 */
require_once (__DIR__ . DIRECTORY_SEPARATOR . 'include' . DIRECTORY_SEPARATOR . 'bittorrent.php');
require_once (INCL_DIR . 'user_functions.php');
require_once (CLASS_DIR . 'page_verify.php');
require_once INCL_DIR . 'function_memcache.php';
define('MIN_CLASS', UC_STAFF);
define('NFO_SIZE', 65535);
dbconn();
loggedinorreturn();
$lang = array_merge(load_language('global') , load_language('takeedit'));
$newpage = new page_verify();
$newpage->check('teit');
$torrent_cache = $torrent_txt_cache = '';
$possible_extensions = array(
    'nfo',
    'txt'
);
if (!mkglobal('id:name:descr:type')) die('Id,descr,name or type missing');
$id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
if (!is_valid_id($id)) stderr($lang['takedit_failed'], $lang['takedit_no_data']);
/**
 *
 * @Function valid_torrent_name
 * @Notes only safe characters are allowed..
 * @Begin
 */
function valid_torrent_name($torrent_name)
{
    $allowedchars = 'abcdefghijklmnopqrstuvwxyz ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789.-_';
    for ($i = 0; $i < strlen($torrent_name); ++$i) if (strpos($allowedchars, $torrent_name[$i]) === false) return false;
    return true;
}
/**
 *
 * @Function is_valid_url
 * @Begin
 */
if (!function_exists('is_valid_url')) {
    function is_valid_url($link)
    {
        return preg_match('|^http(s)?://[a-z0-9-]+(.[a-z0-9-]+)*(:[0-9]+)?(/.*)?$|i', $link);
    }
}
/**
 *
 * @Function is_valid_url
 * @End
 */
$nfoaction = '';
$select_torrent = sql_query('SELECT name, descr, category, visible, vip, release_group, poster, url, newgenre, description, anonymous, sticky, owner, allow_comments, nuked, nukereason, filename, save_as, youtube, tags, info_hash, freetorrent FROM torrents WHERE id = ' . sqlesc($id)) or sqlerr(__FILE__, __LINE__);
$fetch_assoc = mysqli_fetch_assoc($select_torrent) or stderr('Error', 'No torrent with this ID!');
$infohash = $fetch_assoc['info_hash'];
if ($CURUSER['id'] != $fetch_assoc['owner'] && $CURUSER['class'] < MIN_CLASS) stderr('You\'re not the owner!', 'How did that happen?');
$updateset = $torrent_cache = $torrent_txt_cache = array();
$fname = $fetch_assoc['filename'];
preg_match('/^(.+)\.torrent$/si', $fname, $matches);
$shortfname = $matches[1];
$dname = $fetch_assoc['save_as'];
if ((isset($_POST['nfoaction'])) && ($_POST['nfoaction'] == 'update')) {
    if (empty($_FILES['nfo']['name'])) stderr('Updated failed', 'No NFO!');
    if ($_FILES['nfo']['size'] == 0) stderr('Updated failed', '0-byte NFO!');
    if (!preg_match('/^(.+)\.[' . join(']|[', $possible_extensions) . ']$/si', $_FILES['nfo']['name'])) stderr('Updated failed', 'Invalid extension. <b>' . join(', ', $possible_extensions) . '</b> only!', false);
    if (!empty($_FILES['nfo']['name']) && $_FILES['nfo']['size'] > NFO_SIZE) stderr('Updated failed', 'NFO is too big! Max ' . number_format(NFO_SIZE) . ' bytes!');
    if (@is_uploaded_file($_FILES['nfo']['tmp_name']) && @filesize($_FILES['nfo']['tmp_name']) > 0) $updateset[] = "nfo = " . sqlesc(str_replace("\x0d\x0d\x0a", "\x0d\x0a", file_get_contents($_FILES['nfo']['tmp_name'])));
    $torrent_cache['nfo'] = str_replace("\x0d\x0d\x0a", "\x0d\x0a", file_get_contents($_FILES['nfo']['tmp_name']));
} else if ($nfoaction == "remove") {
    $updateset[] = "nfo = ''";
    $torrent_cache['nfo'] = '';
}
//== Make sure they do not forget to fill these fields :D
foreach (array(
    $type,
    $descr,
    $name
) as $x) {
    if (empty($x)) stderr("Error", $lang['takedit_no_data']);
}
if (isset($_POST['youtube']) && preg_match($youtube_pattern, $_POST['youtube'], $temp_youtube)) {
    if ($temp_youtube[0] != $fetch_assoc['youtube']) $updateset[] = "youtube = " . sqlesc($temp_youtube[0]);
    $torrent_cache['youtube'] = $temp_youtube[0];
}
if (isset($_POST['name']) && (($name = $_POST['name']) != $fetch_assoc['name']) && valid_torrent_name($name)) {
    $updateset[] = 'name = ' . sqlesc($name);
    $updateset[] = 'search_text = ' . sqlesc(searchfield("$shortfname $dname"));
    $torrent_cache['search_text'] = searchfield("$shortfname $dname");
    $torrent_cache['name'] = $name;
}
if (isset($_POST['descr']) && ($descr = $_POST['descr']) != $fetch_assoc['descr']) {
    $updateset[] = 'descr = ' . sqlesc($descr);
    $updateset[] = 'ori_descr = ' . sqlesc($descr);
    $torrent_txt_cache['descr'] = $descr;
}
if (isset($_POST['description']) && ($smalldescr = $_POST['description']) != $fetch_assoc['description']) {
    $updateset[] = "description = " . sqlesc($smalldescr);
    $torrent_cache['description'] = $smalldescr;
}
if (isset($_POST['tags']) && ($tags = $_POST['tags']) != $fetch_assoc['tags']) {
    $updateset[] = "tags = " . sqlesc($tags);
    $torrent_cache['tags'] = $tags;
}
if (isset($_POST['type']) && (($category = 0 + $_POST['type']) != $fetch_assoc['category']) && is_valid_id($category)) {
    $updateset[] = 'category = ' . sqlesc($category);
    $torrent_cache['category'] = $category;
}
///////////////////////////////
if (($visible = (isset($_POST['visible']) != '' ? 'yes' : 'no')) != $fetch_assoc['visible']) {
    $updateset[] = 'visible = ' . sqlesc($visible);
    $torrent_cache['visible'] = $visible;
}
if ($CURUSER['class'] > UC_STAFF) {
    if (isset($_POST["banned"])) {
        $updateset[] = "banned = 'yes'";
        $_POST["visible"] = 0;
        $torrent_cache['banned'] = 'yes';
        $torrent_cache['visible'] = 0;
    } else $updateset[] = "banned = 'no'";
    $torrent_cache['banned'] = 'no';
}
/**
 *
 * @Custom Mods
 *
 */
//== Subs
if (in_array($category, $INSTALLER09['movie_cats'])) {
    $subs = isset($_POST['subs']) ? implode(",", $_POST['subs']) : "";
    $updateset[] = "subs = " . sqlesc($subs);
    $torrent_cache['subs'] = $subs;
}
// ==09 Sticky torrents
if (($sticky = (isset($_POST['sticky']) != '' ? 'yes' : 'no')) != $fetch_assoc['sticky']) {
    $updateset[] = 'sticky = ' . sqlesc($sticky);
    if ($sticky == 'yes') sql_query("UPDATE usersachiev SET stickyup = stickyup + 1 WHERE id = " . sqlesc($fetch_assoc['owner'])) or sqlerr(__FILE__, __LINE__);
    //$torrent_cache['sticky'] = $sticky;
}
// ==09 Simple nuke/reason mod
if (isset($_POST['nuked']) && ($nuked = $_POST['nuked']) != $fetch_assoc['nuked']) {
    $updateset[] = 'nuked = ' . sqlesc($nuked);
    $torrent_cache['nuked'] = $nuked;
}
if (isset($_POST['nukereason']) && ($nukereason = $_POST['nukereason']) != $fetch_assoc['nukereason']) {
    $updateset[] = 'nukereason = ' . sqlesc($nukereason);
    $torrent_cache['nukereason'] = $nukereason;
}
// ==09 Poster Mod
if (isset($_POST['poster']) && (($poster = $_POST['poster']) != $fetch_assoc['poster'])) {
    if (!preg_match("/^(http|https):\/\/[^\s'\"<>]+\.(jpg|gif|png)$/i", $poster)  && !empty($poster)) stderr('Updated failed', 'Poster MUST be in jpg, gif or png format. Make sure you include http:// in the URL.');
    $updateset[] = 'poster = ' . sqlesc($poster);
    $torrent_cache['poster'] = $poster;
}
//==09 Set Freeleech on Torrent Time Based
if (isset($_POST['free_length']) && ($free_length = 0 + $_POST['free_length'])) {
    if ($free_length == 255) $free = 1;
    elseif ($free_length == 42) $free = (86400 + TIME_NOW);
    else $free = (TIME_NOW + $free_length * 604800);
    $updateset[] = "free = " . sqlesc($free);
    $torrent_cache['free'] = $free;
    write_log("Torrent $id ($name) set Free for " . ($free != 1 ? "Until " . get_date($free, 'DATE') : 'Unlimited') . " by $CURUSER[username]");
}
if (isset($_POST['fl']) && ($_POST['fl'] == 1)) {
    $updateset[] = "free = '0'";
    $torrent_cache['free'] = '0';
    write_log("Torrent $id ($name) No Longer Free. Removed by $CURUSER[username]");
}
/// end freeleech mod
//==09 Set Silver on Torrent Time Based
if (isset($_POST['half_length']) && ($half_length = 0 + $_POST['half_length'])) {
    if ($half_length == 255) $silver = 1;
    elseif ($half_length == 42) $silver = (86400 + TIME_NOW);
    else $silver = (TIME_NOW + $half_length * 604800);
    $updateset[] = "silver = " . sqlesc($silver);
    $torrent_cache['silver'] = $silver;
    write_log("Torrent $id ($name) set Half leech for " . ($silver != 1 ? "Until " . get_date($silver, 'DATE') : 'Unlimited') . " by $CURUSER[username]");
}
if (isset($_POST['slvr']) && ($_POST['slvr'] == 1)) {
    $updateset[] = "silver = '0'";
    $torrent_cache['silver'] = '0';
    write_log("Torrent $id ($name) No Longer Half leech. Removed by $CURUSER[username]");
}
/// end silver torrent mod
// ===09 Allowcomments
if ((isset($_POST['allow_comments'])) && (($allow_comments = $_POST['allow_comments']) != $fetch_assoc['allow_comments'])) {
    if ($CURUSER['class'] >= UC_STAFF) $updateset[] = "allow_comments = " . sqlesc($allow_comments);
    $torrent_cache['allow_comments'] = $allow_comments;
}
// ===end
//==Xbt freetorrent
if (($freetorrent = (isset($_POST['freetorrent']) != '' ? '1' : '0')) != $fetch_assoc['freetorrent']) {
    $updateset[] = 'freetorrent = ' . sqlesc($freetorrent);
    $torrent_cache['freetorrent'] = $freetorrent;
}
//==09 Imdb mod
if (isset($_POST['url']) && (($url = $_POST['url']) != $fetch_assoc['url'])) {
    if (!preg_match('|^http(s)?://[a-z0-9-]+(.[a-z0-9-]+)*(:[0-9]+)?(/.*)?$|i', $url) && !empty($url))
    //if (!preg_match("/^(http|https):\/\/[^\s'\"<>]+\.(jpg|gif|png)$/i", $url))
    stderr('Updated failed', 'Make sure you include http:// in the URL.');
    $updateset[] = 'url = ' . sqlesc($url);
    $torrent_cache['url'] = $url;
}
//==09 Anonymous torrents
if (($anonymous = (isset($_POST['anonymous']) != '' ? 'yes' : 'no')) != $fetch_assoc['anonymous']) {
    $updateset[] = 'anonymous = ' . sqlesc($anonymous);
    $torrent_cache['anonymous'] = $anonymous;
}
//==09 vip tor
if (($vip = (isset($_POST['vip']) != '' ? '1' : '0')) != $fetch_assoc['vip']) {
    $updateset[] = 'vip = ' . sqlesc($vip);
    $torrent_cache['vip'] = $vip;
}
//==Release group
$release_group_choices = array(
    'scene' => 1,
    'p2p' => 2,
    'none' => 3
); {
    $release_group = (isset($_POST['release_group']) ? $_POST['release_group'] : 'none');
    if (isset($release_group_choices[$release_group])) $updateset[] = "release_group = " . sqlesc($release_group);
    $torrent_cache['release_group'] = $release_group;
}
//==09 Genre Mod without mysql table by Traffic
$genreaction = (isset($_POST['genre']) ? $_POST['genre'] : ''); {
    $genre = '';
}
if ($genreaction != "keep") {
    if (isset($_POST["music"])) $genre = implode(",", $_POST['music']);
    elseif (isset($_POST["movie"])) $genre = implode(",", $_POST['movie']);
    elseif (isset($_POST["game"])) $genre = implode(",", $_POST['game']);
    elseif (isset($_POST["apps"])) $genre = implode(",", $_POST['apps']);
    $updateset[] = "newgenre = " . sqlesc($genre);
    $torrent_cache['newgenre'] = $genre;
}
//==End - now update the sets
if (sizeof($updateset) > 0) sql_query('UPDATE torrents SET ' . implode(',', $updateset) . ' WHERE id = ' . sqlesc($id)) or sqlerr(__FILE__, __LINE__);
if ($torrent_cache) {
    $mc1->begin_transaction('torrent_details_' . $id);
    $mc1->update_row(false, $torrent_cache);
    $mc1->commit_transaction($INSTALLER09['expires']['torrent_details']);
    $mc1->delete_value('top5_tor_');
    $mc1->delete_value('last5_tor_');
    $mc1->delete_value('scroll_tor_');
}
if ($torrent_txt_cache) {
    $mc1->begin_transaction('torrent_details_txt' . $id);
    $mc1->update_row(false, $torrent_txt_cache);
    $mc1->commit_transaction($INSTALLER09['expires']['torrent_details_text']);
}
remove_torrent($infohash);
write_log("torrent edited - " . htmlsafechars($name) . ' was edited by ' . (($fetch_assoc['anonymous'] == 'yes') ? 'Anonymous' : htmlsafechars($CURUSER['username'])) . "");
$mc1->delete_value('editedby_' . $id);
$returl = (isset($_POST['returnto']) ? '&returnto=' . urlencode($_POST['returnto']) : 'details.php?id=' . $id . '&edited=1');
header("Refresh: 0; url=$returl");
?>
