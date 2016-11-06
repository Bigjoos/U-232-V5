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
sleep(1);
require_once (__DIR__ . DIRECTORY_SEPARATOR . 'include' . DIRECTORY_SEPARATOR . 'bittorrent.php');
dbconn();
loggedinorreturn();
if (!isset($CURUSER)) stderr("Error", "Sorry but you cant add a thank you on your own torrent");
$uid = (int)$CURUSER['id'];
$tid = isset($_POST['torrentid']) ? (int)$_POST['torrentid'] : (isset($_GET['torrentid']) ? (int)$_GET['torrentid'] : 0);
$do = isset($_POST['action']) ? htmlsafechars($_POST['action']) : (isset($_GET['action']) ? htmlsafechars($_GET['action']) : 'list');
$ajax = isset($_POST['ajax']) && $_POST['ajax'] == 1 ? true : false;
function print_list()
{
    global $uid, $tid, $ajax;
    $target = $ajax ? '_self' : '_parent';
    $qt = sql_query("SELECT th.userid, u.username, u.seedbonus FROM thanks as th INNER JOIN users as u ON u.id=th.userid WHERE th.torrentid=" . sqlesc($tid) . " ORDER BY u.class DESC") or sqlerr(__FILE__, __LINE__);
    $list = array();
    $hadTh = false;
    if (mysqli_num_rows($qt) > 0) {
        while ($a = mysqli_fetch_assoc($qt)) {
            $list[] = '<a href=\'userdetails.php?id=' . (int)$a['userid'] . '\' target=\'' . $target . '\'>' . htmlsafechars($a['username']) . '</a>';
            $ids[] = (int)$a['userid'];
        }
        $hadTh = in_array($uid, $ids) ? true : false;
    }
    if ($ajax) return json_encode(array(
        'list' => (count($list) > 0 ? join(', ', $list) : 'Not yet') ,
        'hadTh' => $hadTh,
        'status' => true
    ));
    else {
        $form = !$hadTh ? "<br/><form action='thanks.php' method='post'><input type='submit' class='btn' name='submit' value='Say thanks' /><input type='hidden' name='torrentid' value='{$tid}' /><input type='hidden' name='action' value='add' /></form>" : "";
        $out = (count($list) > 0 ? join(', ', $list) : 'Not yet');
        
		return <<<IFRAME
        
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
<style type='text/css'>
body { margin:0;padding:0; 
	   font-size:12px;
	   font-family:arial,sans-serif;
	   color: #FFFFFF;
}
a, a:link, a:visited {
  text-decoration: none;
  color: #FFFFFF;
  font-size:12px;
}
a:hover {
  color: #FFFFFF
  text-decoration:underline;
  
}
.btn {
background-color:#890537;
border:1px solid #000000;
color:#FFFFFF;
font-family:arial,sans-serif;
font-size:12px;
padding:1px 3px;
}
</style>
<title>::</title>
</head>
<body>
{$out}{$form}
</body>
</html>

IFRAME;
        
    }
}
switch ($do) {
case 'list':
    print (print_list());
    break;

case 'add':
    if ($uid > 0 && $tid > 0) {
        $c = 'SELECT count(id) FROM thanks WHERE userid = ' . sqlesc($uid) . ' AND torrentid = ' . sqlesc($tid);
        $result = sql_query($c);
        $arr = $result->fetch_row();
        if ($arr[0] == 0) {
            if (sql_query('INSERT INTO thanks(userid,torrentid) VALUES(' . sqlesc($uid) . ',' . sqlesc($tid) . ')')) echo (print_list());
            else {
                $msg = 'There was an error with the query,contact the staff. Mysql error ' . ((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false));
                echo ($ajax ? json_encode(array(
                    'status' => false,
                    'err' => $msg
                )) : $msg);
            }
            
        }
    }
    header("Refresh: 0; url=details.php?id=$tid");
    if ($INSTALLER09['seedbonus_on'] == 1) {
        // ===add karma
        sql_query("UPDATE users SET seedbonus = seedbonus+".sqlesc($INSTALLER09['bonus_per_thanks'])." WHERE id =" . sqlesc($uid)) or sqlerr(__FILE__, __LINE__);
        $sql = sql_query('SELECT seedbonus ' . 'FROM users ' . 'WHERE id = ' . sqlesc($uid)) or sqlerr(__FILE__, __LINE__);
        $User = mysqli_fetch_assoc($sql);
        $update['seedbonus'] = ($User['seedbonus'] + $INSTALLER09['bonus_per_thanks']);
        //header("Refresh: 1; url=details.php?id=$id");
        $mc1->begin_transaction('userstats_' . $uid);
        $mc1->update_row(false, array(
            'seedbonus' => $update['seedbonus']
        ));
        $mc1->commit_transaction($INSTALLER09['expires']['u_stats']);
        $mc1->begin_transaction('user_stats_' . $uid);
        $mc1->update_row(false, array(
            'seedbonus' => $update['seedbonus']
        ));
        $mc1->commit_transaction($INSTALLER09['expires']['user_stats']);
        // ===end
        
    }
    break;
}
?>
