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
# fastdelete.php language file
$lang = array(

'fastdelete_error' => 'Error',
'fastdelete_error_id' => 'Invalid ID',
'fastdelete_no_acc' => 'Sorry yer no tall enough',
'fastdelete_sure' => 'Security Check',
'fastdelete_sure_msg' => 'Are you sure you want to delete this torrent?<br /><a href=\'fastdelete.php?id='.(int)$_GET['id'].'&sure=1\' class=\'altlink\'>Click here</a> if you are',
'fastdelete_msg_first' => 'Your upload',
'fastdelete_msg_last' => 'has been deleted by',
'fastdelete_log_first' => 'Torrent',
'fastdelete_log_last' => 'was deleted by',
'fastdelete_returnto' => 'Go back',
'fastdelete_index' => 'Back to index',
'fastdelete_deleted' => 'Torrent deleted',
'fastdelete_head' => 'Delete Torrent (Fast)'
);
?>