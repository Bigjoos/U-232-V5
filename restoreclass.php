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
require_once (INCL_DIR . 'user_functions.php');
dbconn(false);
loggedinorreturn();
sql_query("UPDATE users SET override_class='255' WHERE id = " . sqlesc($CURUSER['id']));
$mc1->begin_transaction('MyUser_' . $CURUSER['id']);
$mc1->update_row(false, array(
    'override_class' => 255
));
$mc1->commit_transaction($INSTALLER09['expires']['curuser']);
$mc1->begin_transaction('user' . $CURUSER['id']);
$mc1->update_row(false, array(
    'override_class' => 255
));
$mc1->commit_transaction($INSTALLER09['expires']['user_cache']);
header("Location: {$INSTALLER09['baseurl']}/index.php");
die();
?>
