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
$lang = array(
    //Headers
    'stdhead_templates' => 'Templates',
    //Main table
    'themes_id' => 'ID',
    'themes_name' => 'Name',
    'themes_uri' => 'Uri',
    'themes_is_folder' => 'Folder Exists ?',
    'themes_e_d' => 'Edit/Delete',
    'themes_edit' => 'Edit',
    'themes_delete' => 'Delete',
    'themes_file_exists' => '<font color=\'green\'>Yes</font>',
    'themes_not_exists' => '<font color=\'red\'>No</font>',
    //Other Stuff
    'themes_use_temp' => 'Use this template',
    'themes_addnew' => 'Add a template',
    'themes_edit_tem' => 'Edit Template', //---' <Template Name>' added in source
    'themes_edit_uri' => 'Edit Uri',
    'themes_save' => 'Save',
    'themes_add' => 'Add',
    'themes_some_wrong' => 'Something Went Wrong',
    'themes_delete_sure_q' => 'Are you sure you want to delete this template ??',
    'themes_delete_sure_q2' => 'Click here',
    'themes_delete_sure_q3' => 'if you are sure',
    'themes_delete_q' => 'Delete Template',
    'themes_takenids' => 'Taken Id\'s: ',
    //Messages
    'themes_msg' => 'Succesfully Edited',
    'themes_msg1' => 'Succesfully Saved',
    'themes_msg2' => 'Succesfully Deleted',
    'themes_msg3' => 'Succesfully Added',
    //Guide/Explains
    'themes_guide' => '<ul>
<li>Make a folder in Templates dir</li>
<li>Make a php file called template.php inside of the folder made in step 1</li>
<li>In template.php there shall be minimum 4 functions
<ul>
<li>stdhead</li>
<li>stdfoot</li>
<li>stdmsg</li>
<li>StatusBar</li>
</ul></li>
</ul>
',
    'themes_explain_id' => 'This shall be the same as the folder name',
    //Errors
    'themes_error' => 'Error',
    'themes_inv_act' => 'Invalid Action',
    'themes_inv_id' => 'Invalid ID',
    'themes_inv_uri' => 'Invalid Uri',
    'themes_inv_name' => 'Invalid Name',
    'themes_nofile' => 'Template file does not exist',
    'themes_inv_file' => 'Continue ?',
    //Credits
    'themes_credits' => 'Credits to AronTh for making this template mananger and the template system',
);
?>