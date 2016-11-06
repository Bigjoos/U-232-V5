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
require_once ('include/ann_config.php');
require_once ('include/ann_functions.php');
require_once ('include/class/class_bt_options.php');

function error($err)
{
    header('Content-Type: text/plain; charset=UTF-8');
    header('Pragma: no-cache');
    exit("d14:failure reason" . strlen($err) . ":{$err}ed5:flagsd20:min_request_intervali1800eeee");
}

function getip()
{
    foreach (array(
        'HTTP_CLIENT_IP',
        'HTTP_X_FORWARDED_FOR',
        'HTTP_X_FORWARDED',
        'HTTP_X_CLUSTER_CLIENT_IP',
        'HTTP_FORWARDED_FOR',
        'HTTP_FORWARDED',
        'REMOTE_ADDR'
    ) as $key) {
        if (array_key_exists($key, $_SERVER) === true) {
            foreach (array_map('trim', explode(',', $_SERVER[$key])) as $ip) {
                if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false) {
                    return $ip;
                }
            }
        }
    }
}

function check_bans($ip, &$reason = '')
{
    global $INSTALLER09, $mc1;
    $key = 'bans:::' . $ip;
    if (($ban = $mc1->get_value($key)) === false) {
        $nip = ip2long($ip);
        $ban_sql = sql_query('SELECT comment FROM bans WHERE (first <= ' . $nip . ' AND last >= ' . $nip . ') LIMIT 1');
        if (mysqli_num_rows($ban_sql)) {
            $comment = mysqli_fetch_row($ban_sql);
            $reason = 'Manual Ban (' . $comment[0] . ')';
            $mc1->cache_value($key, $reason, 86400); // 86400 // banned
            return true;
        }
        ((mysqli_free_result($ban_sql) || (is_object($ban_sql) && (get_class($ban_sql) == "mysqli_result"))) ? true : false);
        $mc1->cache_value($key, 0, 86400); // 86400 // not banned
        return false;
    } elseif (!$ban) return false;
    else {
        $reason = $ban;
        return true;
    }
}

$q = explode('&',$_SERVER['QUERY_STRING']);
$_GET = array();
foreach ($q as $p)
  {
   $ps = explode('=',$p,2);
   $p1 = rawurldecode(trim($ps[0]));
   $p2 = rawurldecode(trim($ps[1]));
   if (strlen($p1) > 0)
     {
      if (!isset($_GET[$p1]))
        {
         $_GET[$p1] = $p2;
        }
      elseif (!is_array($_GET[$p1]))
        {
         $temp = $_GET[$p1];
         unset($_GET[$p1]);
         $_GET[$p1] = array();
         $_GET[$p1][] = $temp;
         $_GET[$p1][] = $p2;
        }
      else
        {
         $_GET[$p1][] = $p2;
        }
     }
  }

if (isset($_GET['torrent_pass']) && strlen($_GET['torrent_pass']) != 32)
  {
   $lentorrent_pass = strlen($_GET['torrent_pass']);
   if ($lentorrent_pass > 32 && preg_match('/^([0-9a-f]{32})\?(([0-9a-zA-Z]|_)+)\=/',$_GET['torrent_pass'], $matches))
     {
      $lenget = strlen($matches[0]);
      $valget = substr($_GET['torrent_pass'], $lenget);
      if (!isset($_GET[$matches[2]]))
        $_GET[$matches[2]] = $valget;
      elseif (!is_array($_GET[$matches[2]]))
        {
         $temp = $_GET[$matches[2]];
         $_GET[$matches[2]] = array();
         $_GET[$matches[2]][] = $temp;
         $_GET[$matches[2]][] = $valget;
        }
      else
        $_GET[$matches[2]][] = $valget;

      $_GET['torrent_pass'] = $matches[1];
     }
   else
     error('torrent pass not valid, please redownload your torrent file');
  }

$torrent_pass = isset($_GET['torrent_pass']) && ($_GET['torrent_pass'])  ? $_GET['torrent_pass'] : '';
//$torrent_pass = $_GET['torrent_pass'];
if (!$torrent_pass)
	die('scrape error');

if (!@($GLOBALS["___mysqli_ston"] = mysqli_connect($INSTALLER09['mysql_host'], $INSTALLER09['mysql_user'], $INSTALLER09['mysql_pass']))) {
    exit();
}
@((bool)mysqli_query($GLOBALS["___mysqli_ston"], "USE {$INSTALLER09['mysql_db']}")) or exit();
$numhash = count($_GET['info_hash']);
$torrents = array();
if ($numhash < 1) die("Scrape Error d5:filesdee");
elseif ($numhash == 1) {
    $torrent = get_torrent_from_hash($_GET['info_hash']);
    if ($torrent) $torrents[$_GET['info_hash']] = $torrent;
} else {
    foreach ($_GET['info_hash'] as $hash) {
        $torrent = get_torrent_from_hash($hash);
        if ($torrent) $torrents[$hash] = $torrent;
    }
}

$user = get_user_from_torrent_pass($torrent_pass);
if (!$user || !count($torrents))
	die('scrape user error');
$r = 'd5:filesd';
foreach ($torrents as $info_hash => $torrent) $r.= '20:' . $info_hash . 'd8:completei' . $torrent['seeders'] . 'e10:downloadedi' . $torrent['times_completed'] . 'e10:incompletei' . $torrent['leechers'] . 'ee';
$r.= 'ee';
header('Content-Type: text/plain; charset=UTF-8');
header('Pragma: no-cache');
echo ($r);
die();
?>
