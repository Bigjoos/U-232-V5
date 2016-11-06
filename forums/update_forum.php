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
/****
* Bleach Forums 
* Rev u-232v5
* Credits - Retro-Alex2005-Putyn-pdq-sir_snugglebunny-Bigjoos
* Bigjoos 2015
******
*/
if (!defined('IN_INSTALLER09_FORUM')) {
    $HTMLOUT = '';
    $HTMLOUT.= '<!DOCTYPE html>
        <html xmlns="http://www.w3.org/1999/xhtml" lang="en">
        <head>
        <meta charset="'.charset().'" />
        <title>ERROR</title>
        </head><body>
        <h1 style="text-align:center;">Error</h1>
        <p style="text-align:center;">How did you get here? silly rabbit Trix are for kids!.</p>
        </body></html>';
    echo $HTMLOUT;
    echo $HTMLOUT;
    exit();
}
// -------- Action: Update Forum
       $forumid = (int)$_GET["forumid"];
    if ($CURUSER['class'] >= MAX_CLASS || isMod($forumid, "forum")) {
        if (!is_valid_id($forumid))
            stderr('Error', 'Invalid ID!');
        $res = sql_query('SELECT id FROM forums WHERE id='.sqlesc($forumid));
        if (mysqli_num_rows($res) == 0)
            stderr('Error', 'No forum with that ID!');
        $name = htmlsafechars($_POST['name']);
        $description = htmlsafechars($_POST['description']);
        if (empty($name))
            stderr("Error", "You must specify a name for the forum.");
        if (empty($description))
            stderr("Error", "You must provide a description for the forum.");
        sql_query("UPDATE forums SET name=".sqlesc($name).", description=".sqlesc($description).", min_class_read=".sqlesc((int)$_POST['readclass']).", min_class_write=".sqlesc((int)$_POST['writeclass']).", min_class_create=".sqlesc((int)$_POST['createclass'])." WHERE id = ".sqlesc($forumid)) or sqlerr(__FILE__, __LINE__);
        header("Location: forums.php");
        exit();
    }
?>
