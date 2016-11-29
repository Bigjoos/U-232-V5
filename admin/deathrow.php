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
/* Deathrow by pdq */
if (!defined('IN_INSTALLER09_ADMIN')) {
    $HTMLOUT = '';
    $HTMLOUT.= "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\"
		\"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">
		<html xmlns='http://www.w3.org/1999/xhtml'>
		<head>
		<title>Error!</title>
		</head>
		<body>
	<div style='font-size:33px;color:white;background-color:red;text-align:center;'>Incorrect access<br />You cannot access this file directly.</div>
	</body></html>";
    echo $HTMLOUT;
    exit();
}
require_once (INCL_DIR . 'user_functions.php');
require_once (INCL_DIR . 'pager_functions.php');
require_once (INCL_DIR . 'function_memcache.php');
require_once (CLASS_DIR . 'class_check.php');
$class = get_access(basename($_SERVER['REQUEST_URI']));
class_check($class);

$lang = array_merge($lang, load_language('ad_deathrow'));

$HTMLOUT = '';

function calctime($val)
{
	global $lang;
    $days = intval($val / 86400);
    $val-= $days * 86400;
    $hours = intval($val / 3600);
    $val-= $hours * 3600;
    $mins = intval($val / 60);
    $secs = $val - ($mins * 60);
    return "$days {$lang['deathrow_days']}, $hours {$lang['deathrow_hrs']}, $mins {$lang['deathrow_minutes']}";
}

function delete_torrent($delete_array, $page)
{
    global $INSTALLER09, $CURUSER, $mc1, $lang;
    if (empty($delete_array)) return false;
    $delete = array();
    foreach ($delete_array as $remove) $delete[] = 0 + $remove;
    $delete = array_unique($delete);
    $count = count($delete);
    if (!$count) return false;
    if ($count > 25) die(' '.$lang['deathrow_try'].' (' . $count . ').');
    $res = sql_query('SELECT id, added, name, owner, seeders, info_hash FROM torrents ' . 'WHERE id IN (' . implode(', ', $delete) . ')') or sqlerr(__FILE__, __LINE__);
    while ($row = mysqli_fetch_assoc($res)) {
        if (!(($CURUSER['id'] == $row['owner'] || $CURUSER['class'] >= UC_STAFF) && $row['seeders'] == 0)) continue;
        $ids[] = $row['id'];
        $names[] = htmlsafechars($row['name']);
        $id = (int)$row['id'];
        /** unlink() **/
        unlink("{$INSTALLER09['torrent_dir']}/$id.torrent");
        // announce
        remove_torrent_peers($id);
        remove_torrent($row['info_hash']);
        // index_last5_posters
        $mc1 -> delete_value('last5_tor_');
        $mc1 -> delete_value('top5_tor_');
        $mc1 -> delete_value('scroll_tor_');
        // torrent_details
        $mc1 -> delete_value('torrent_details_' . $id);
        $mc1 -> delete_value('torrent_xbt_data_' . $id);
        $mc1 -> delete_value('torrent_details_txt' . $id);
        $mc1 -> delete_value('coin_points_' . $id);;
        $mc1 -> delete_value('similiar_tor_' . $id);
        $dt = sqlesc(TIME_NOW - (14 * 86400)); // lose karma if deleted within 2 weeks
        if ($row['added'] < $dt) sql_query("UPDATE users SET seedbonus = seedbonus-15.0 WHERE id = ".sqlesc($row['owner'])) or sqlerr(__FILE__, __LINE__);
    }
    $unique_ids = array_unique($ids);
    $countids = count($unique_ids);
    if ($countids > 0) {
        sql_query('DELETE FROM torrents WHERE id IN (' . implode(', ', $ids) . ')');
        foreach (explode(".", "bookmarks.snatched.thanks.thankyou.coins") as $y) sql_query('DELETE FROM ' . $y . ' WHERE torrentid IN (' . implode(', ', $ids) . ')');
        foreach (explode(".", "peers.files.comments.rating") as $x) sql_query('DELETE FROM ' . $x . ' WHERE torrent IN (' . implode(', ', $ids) . ')');
        sql_query('DELETE FROM deathrow WHERE tid IN (' . implode(', ', $ids) . ')') or sqlerr(__FILE__, __LINE__);
        sql_query('DELETE FROM thanks WHERE torrentid IN (' . implode(', ', $ids) . ')') or sqlerr(__FILE__, __LINE__);
        sql_query('DELETE FROM thankyou WHERE torid IN (' . implode(', ', $ids) . ')') or sqlerr(__FILE__, __LINE__);
        write_log(' '.$lang['deathrow_torr'].' (' . implode(', ', $names) . '.)  '.$lang['deathrow_were'].' ' . $CURUSER['username'] . ' (' . $page . ')' . "\n");
        return $countids;
    } else return false;
} // end
if (!empty($_POST['remove'])) {
    $deleted = delete_torrent($_POST['remove'], 'deathrow');
    if ($deleted) {
        stderr($lang['deathrow_success'], $lang['deathrow_deleted'] . $deleted . $lang['deathrow_torrs']);
    } else stderr($lang['deathrow_err'], $lang['deathrow_no_torr']);
}
// Give 'em 5 days to seed back their torrent (no peers, not seeded with in x days)
$x_time = 604800; // Delete Routine 1 // 5 days
// Give 'em 7 days to seed back their torrent (no peers, not snatched in x days)
$y_time = 2419200; // Delete Routine 2 // 28 days
// Give 'em 2 days to seed back their torrent (no seeder activity within x hours of torrent upload)
$z_time = 2 * 86400; // Delete Routine 3 // 2 days
$dx_time = sqlesc(TIME_NOW - $x_time);
$dy_time = sqlesc(TIME_NOW - $y_time);
$dz_time = sqlesc(TIME_NOW - $z_time);
if ($CURUSER["class"] >= UC_STAFF) {
    $uploaders = array();
    // Deathrow Routine 1
    $query = 'SELECT t.id AS tid, t.name, t.owner, (t.seeders + t.leechers) AS peers, t.last_action, u.username, u.id AS uid FROM torrents AS t INNER JOIN users AS u ON t.owner = u.id LEFT JOIN peers AS p ON t.id = p.torrent WHERE t.last_action < ' . $dx_time . ' HAVING peers = 0';
    $res = sql_query($query) or sqlerr(__FILE__, __LINE__);
    while ($arr = mysqli_fetch_assoc($res)) {
        $uploaders[$arr['uid'] . '|' . $arr['username']][] = array(
            'tid' => $arr['tid'],
            'torrent_name' => $arr['name'],
            'reason' => 1
        );
    }
    /*
    // Deathrow Routine 2
    $query = 'SELECT t.id, t.owner, t.name, u.id AS uid, u.username, MAX(s.complete_date) AS max_fstamp FROM torrents AS t LEFT JOIN snatched AS s ON t.id = s.torrent LEFT JOIN users AS u ON t.owner = u.id WHERE (t.seeders + t.leechers) = 0 AND s.complete_date != \'0\' GROUP BY t.id HAVING MAX(s.complete_date) < '.$dy_time;
    $res = sql_query($query) or sqlerr(__FILE__, __LINE__);
    while ($arr = mysqli_fetch_assoc($res))
    {
    $uploaders[$arr['uid'].'|'.$arr['username']][] = array('tid' => $arr['id'], 'torrent_name' => $arr['name'], 'reason' => 2);
    }
    */
    // Deathrow Routine 3
    $query = 'SELECT t.id, t.name, t.owner, t.added, t.last_action, u.id AS uid, u.username FROM torrents AS t INNER JOIN users AS u ON t.owner = u.id LEFT JOIN peers AS p ON t.id = p.torrent WHERE t.last_action < ' . (TIME_NOW - 1 * 86400) . ' AND t.added < ' . $dz_time . ' GROUP BY t.id HAVING(SUM(p.seeder) = 0)';
    $res = sql_query($query) or sqlerr(__FILE__, __LINE__);
    while ($arr = mysqli_fetch_assoc($res)) {
        $uploaders[$arr['uid'] . '|' . $arr['username']][] = array(
            'tid' => $arr['id'],
            'torrent_name' => $arr['name'],
            'reason' => 3
        );
    }
    foreach ($uploaders AS $user_info => $torrent_array) {
        $ex_usr = explode('|', $user_info);
        foreach ($torrent_array AS $key => $torrent_info) {
            sql_query('INSERT INTO deathrow (uid, username, tid, torrent_name, reason) VALUES (' . $ex_usr[0] . ', \'' . $ex_usr[1] . '\', ' . $torrent_info['tid'] . ', ' . sqlesc($torrent_info['torrent_name']) . ', ' . $torrent_info['reason'] . ') ON DUPLICATE KEY UPDATE reason = ' . $torrent_info['reason'] . '');
        }
    }
    unset($res);
}
$res = sql_query("SELECT COUNT(tid) FROM deathrow") or sqlerr(__FILE__, __LINE__);
$row = mysqli_fetch_array($res, MYSQLI_NUM);
$count = $row[0];
if ($count) {
    $perpage = 25;
    $orderby = 'ORDER BY username ASC';
    $HTMLOUT .= '<script  type="text/javascript">
	//<![CDATA[
	var checkflag = "false";
	function check(field) {
	if (checkflag == "false") {
	for (i = 0; i < field.length; i++) {
	field[i].checked = true;}
	checkflag = "true";
	return "Uncheck All Remove"; }
	else {
	for (i = 0; i < field.length; i++) {
	field[i].checked = false; }
	checkflag = "false";
	return "Check All Remove"; }
	}
	//]]>
	</script>';
    $pager = pager($perpage, $count, "staffpanel.php?tool=deathrow&amp;", array(
        'lastpagedefault' => 1
    ));
    //
    $query = "SELECT * FROM deathrow {$orderby} {$pager['limit']}";
    $res = sql_query($query) or sqlerr(__FILE__, __LINE__);
    $b = "<div class='row'><div class='col-md-12'><p><b>$count {$lang['deathrow_title']}</b>" . "</p><form action='' method='post'><table class='table table-bordered'>" . "<thead><tr><th class='colhead' align='center'>{$lang['deathrow_uname']}</th><th class='colhead' align='center'>{$lang['deathrow_tname']}</th><th class='colhead'>{$lang['deathrow_del_resn']}</th><th class='colhead'>{$lang['deathrow_del_torr']}</th></tr></thead>\n";
    while ($queued = mysqli_fetch_assoc($res)) {
        if ($queued['reason'] == 1) $reason = $lang['deathrow_nopeer'] . calctime($x_time);
        elseif ($queued['reason'] == 2) $reason = $lang['deathrow_no_peers'] . calctime($y_time);
        else $reason = $lang['deathrow_no_seed'] . calctime($z_time) . $lang['deathrow_new_torr'];
        $id = 0 + $queued['tid'];
        $b.= "<tr>" . ($CURUSER["class"] >= UC_STAFF ? "<td align='center'><a href='userdetails.php?id=" . $queued["uid"] . "&amp;hit=1'><b>" . htmlsafechars($queued["username"]) . "</b></a></td>" : "<td align='center'><strong>{$lang['deathrow_hidden']}</strong></td>") . "<td align='center'><a href='details.php?id=" . $id . "&amp;hit=1'>" . htmlsafechars($queued["torrent_name"]) . "</a></td><td align='center'>" . $reason . "</td><td align='center'>" . ($queued["username"] == $CURUSER["username"] || $CURUSER["class"] >= UC_STAFF ? "<input type=\"checkbox\" name=\"remove[]\" value=\"" . $id . "\" /><b>" . ($queued["username"] == $CURUSER["username"] ? '&nbsp;&nbsp;<font color="#800000">'.$lang['deathrow_delete'].'</font>' : ''.$lang['deathrow_delete1'].'') . "</b>" : "{$lang['deathrow_ownstaff']}") . "</td></tr>";
    }
    $b.= '<tr><td class="table" colspan="11" align="right"><input type="button" value="'.$lang['deathrow_checkall'].'" onclick="this.value=check(this.form.elements[\'remove[]\'])"/>
<input type="submit" name="submit" value="'.$lang['deathrow_apply'].'" /></td></tr></table></form></div></div>';
    $HTMLOUT .= ($pager['pagertop']);
    $HTMLOUT = $b;
    $HTMLOUT .= ($pager['pagerbottom']);
    echo stdhead($lang['deathrow_stdhead']) . $HTMLOUT . stdfoot();
} else {
    $HTMLOUT .= '<br /><strong>'.$lang['deathrow_msg'].'</strong>'.$lang['deathrow_msg1'].'
    <br /><br /><br /><strong>'.$lang['deathrow_msg2'].'</strong>'.$lang['deathrow_msg3'].' ' . $CURUSER['username'] . ''.$lang['deathrow_msg4'].'.
    <br /><br /><br /><strong>'.$lang['deathrow_msg'].'</strong>'.$lang['deathrow_msg33'].' ' . $CURUSER['username'] . ''.$lang['deathrow_msg4'].'.
    <br /><br /><br /><strong>'.$lang['deathrow_msg2'].'</strong>'.$lang['deathrow_msg5'].'
    <br /><br /><br /><strong>'.$lang['deathrow_msg'].'</strong>'.$lang['deathrow_msg6'].'
    <br /><br /><br /><strong>'.$lang['deathrow_msg2'].'</strong> ' . $CURUSER['username'] . ''.$lang['deathrow_msg7'].'
    <br /><br /><br /><strong>'.$lang['deathrow_msg'].'</strong>'.$lang['deathrow_msg8'].'
    <br /><br /><br /><strong>'.$lang['deathrow_msg2'].'</strong>'.$lang['deathrow_msg9'].'
    <br /><br /><br /><strong>'.$lang['deathrow_msg'].'</strong>'.$lang['deathrow_msg0'].' ';
echo stdhead($lang['deathrow_stdhead0']) . $HTMLOUT . stdfoot();
}
?>
