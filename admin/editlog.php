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
// Written by RetroKill to allow scripters to see what scripts have changed since
// they last updated their own list.
//
// This script will create a unique list for each member allowed to access this
// script. It allows them to see what scripts have been updated since they last
// updated their own list, allowing scripters to work together better.
//
// The first run will produce no results, as it will initialise the list for the
// member running the script. Further runs will show the scripter when a script
// has been updated from their original list (someone else, or they, have modified
// a script). When a member updates a script, they should run this script, which
// will show the update, then update their list using the update button, to bring
// their list up to date. If an update appears when the scripter hasn't made any
// changes, then they know that another scripter has modified a script.
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
require_once (CLASS_DIR . 'class_check.php');
$class = get_access(basename($_SERVER['REQUEST_URI']));
class_check($class);
loggedinorreturn();
//== ID list - Add individual user IDs to this list for access to this script
/*$allowed_ids = array(
    1
); //== 1 Is Sysop*/
if (!in_array($CURUSER['id'], $INSTALLER09['allowed_staff']['id'] /*$allowed_ids*/)) stderr($lang['editlog_error'], $lang['editlog_denied']);
$lang = array_merge($lang, load_language('editlog'));
$HTMLOUT = '';
$file_data = './dir_list/data_' . $CURUSER['username'] . '.txt';
if (file_exists($file_data)) {
    // Fetch existing data
    $data = unserialize(file_get_contents($file_data));
    $exist = TRUE;
} else {
    // Initialise File
    $exist = FALSE;
}
$fetch_set = array();
$i = 0;
$directories = array();
//== Enter directories to log... if you dont have them - comment them out or edit
//$directories[] = '/var/bucket/';
//$directories[] = '/var/bucket/avatars/';
$directories[] = './'; // Webroot
$directories[] = './include/';
$directories[] = './forums/';
$directories[] = './mods/';
$directories[] = './scripts/';
$directories[] = './uploads/';
$directories[] = './uploadsub/';
$directories[] = './lottery/';
$directories[] = './avatar/';
$directories[] = './templates/';
$directories[] = './include/settings/';
$directories[] = './cache/';
$directories[] = './logs/';
//$directories[] = './torrents/';  //== watch this fella if you have 1000's of torrents it will timeout
$directories[] = './admin/';
foreach ($directories AS $x) {
    if ($handle = opendir($x)) {
        while (false !== ($file = readdir($handle))) {
            if ($file != "." && $file != "..") {
                if (!is_dir($x . '/' . $file)) {
                    $fetch_set[$i]['modify'] = filemtime($x . $file);
                    $fetch_set[$i]['size'] = filesize($x . $file);
                    $fetch_set[$i]['name'] = $x . $file;
                    $fetch_set[$i]['key'] = $i;
                    $i++;
                }
            }
        }
        closedir($handle);
    }
}
if (!$exist OR (isset($_POST['update']) AND ($_POST['update'] == 'Update'))) {
    // Create first disk image of files
    // OR update existing data...
    $data = serialize($fetch_set);
    $handle = fopen($file_data, "w");
    fputs($handle, $data);
    fclose($handle);
    $data = unserialize($data);
}
// We now need to link current contents with stored contents.
reset($fetch_set);
reset($data);
$current = $fetch_set;
$last = $data;
foreach ($current as $x) {
    // Search the data sets for differences
    foreach ($last AS $y) {
        if ($x['name'] == $y['name']) {
            if (($x['size'] == $y['size']) AND ($x['modify'] == $y['modify'])) {
                unset($current[$x['key']]);
                unset($last[$y['key']]);
            } else $current[$x['key']]['status'] = 'modified';
        }
        if (isset($last[$y['key']])) $last[$y['key']]['status'] = 'deleted';
    }
    if (isset($current[$x['key']]['name']) AND !isset($current[$x['key']]['status'])) $current[$x['key']]['status'] = 'new';
}
$current+= $last; // Add deleted entries to current list
unset($last);
// $fetch_data contains a current list of directory
// $data contains the last snapshot of the directory
// $current contains a current list of files in the directory that are
// new, modified or deleted...
// Remove lists from current code...
unset($data);
unset($fetch_set);
$HTMLOUT.= "<div class='row'><div class='col-md-12'>";
$HTMLOUT.= "<table class='table table-bordered'>
<tr>
<td align='center' width='70%' bgcolor='orange'><strong>{$lang['editlog_new']}</strong></td>
<td align='center' bgcolor='orange'><strong>{$lang['editlog_added']}</strong></td>
</tr>";
reset($current);
$count = 0;
foreach ($current AS $x) {
    if ($x['status'] == 'new') {
        $HTMLOUT.= "
<tr>
<td align='center'>";
        $HTMLOUT.= htmlsafechars(substr($x['name'], 2));
        $HTMLOUT.= "</td>
<td align='center'>";
        $HTMLOUT.= get_date($x['modify'], 'DATE', 0, 1);
        $HTMLOUT.= "</td>
</tr>";
        $count++;
    }
}
if (!$count) {
    $HTMLOUT.= "
<tr>
<td align='center' colspan='2'><b>{$lang['editlog_no_new']}</b></td>
</tr>";
}
$HTMLOUT.= "
</table>
<br /><br /><br />
<table class='table table-bordered'>
<tr>
<td align='center' width='70%' bgcolor='orange'><strong>{$lang['editlog_modified']}</strong></td>
<td align='center' bgcolor='orange'><strong>{$lang['editlog_modified1']}</strong></td>
</tr>";
reset($current);
$count = 0;
foreach ($current AS $x) {
    if ($x['status'] == 'modified') {
        $HTMLOUT.= "
<tr>
<td align='center'>";
        $HTMLOUT.= htmlsafechars(substr($x['name'], 2));
        $HTMLOUT.= "</td>
<td align='center'>";
        $HTMLOUT.= get_date($x['modify'], 'DATE', 0, 1);
        $HTMLOUT.= "</td>
</tr>";
        $count++;
    }
}
if (!$count) {
    $HTMLOUT.= "
<tr>
<td align='center' colspan='2'><b>{$lang['editlog_no_modified']}</b></td>
</tr>";
}
$HTMLOUT.= "
</table>
<br /><br /><br />
<table class='table table-bordered'>
<tr>
<td align='center' width='70%' bgcolor='orange'><strong>{$lang['editlog_deleted']}</strong></td>
<td align='center' bgcolor='orange'><strong>{$lang['editlog_deleted1']}</strong></td>
</tr>";
reset($current);
$count = 0;
foreach ($current AS $x) {
    if ($x['status'] == 'deleted') {
        $HTMLOUT.= "
<tr>
<td align='center'>";
        $HTMLOUT.= htmlsafechars(substr($x['name'], 2));
        $HTMLOUT.= "</td>
<td align='center'>";
        $HTMLOUT.= get_date($x['modify'], 'DATE', 0, 1);
        $HTMLOUT.= "</td>
</tr>";
        $count++;
    }
}
if (!$count) {
    $HTMLOUT.= "
<tr>
<td align='center' colspan='2'><b>{$lang['editlog_no_deleted']}</b></td>
</tr>";
}
$HTMLOUT.= "
</table>
<br /><br /><br />
<form method='post' action='staffpanel.php?tool=editlog&amp;action=editlog'>
<table class='table table-bordered'>
<tr>
<td align='center' bgcolor='orange'>
<input name='update' type='submit' value='{$lang['editlog_update']}' />
</td>
</tr>
</table>
</form>";
$HTMLOUT .="</div></div>";
echo stdhead($lang['editlog_stdhead']) . $HTMLOUT . stdfoot();
?>
