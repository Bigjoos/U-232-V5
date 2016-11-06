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
require_once (__DIR__ . DIRECTORY_SEPARATOR . 'include' . DIRECTORY_SEPARATOR . 'bittorrent.php');
dbconn(false);
loggedinorreturn();
$query1 = sprintf('UPDATE users SET curr_ann_id = 0, curr_ann_last_check = \'0\' ' . 'WHERE id = %s AND curr_ann_id != 0', sqlesc($CURUSER['id']));
sql_query($query1);
$mc1->begin_transaction('user' . $CURUSER['id']);
$mc1->update_row(false, array(
    'curr_ann_id' => 0,
    'curr_ann_last_check' => 0
));
$mc1->commit_transaction($INSTALLER09['expires']['user_cache']);
$mc1->begin_transaction('MyUser_' . $CURUSER['id']);
$mc1->update_row(false, array(
    'curr_ann_id' => 0,
    'curr_ann_last_check' => 0
));
$mc1->commit_transaction($INSTALLER09['expires']['curuser']);
//$status = 2;
header("Location: {$INSTALLER09['baseurl']}/index.php");
?>
