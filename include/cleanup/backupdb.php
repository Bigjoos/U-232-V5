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
function tables($no_data = "")
{
    global $INSTALLER09;
    if (!empty($no_data));
    $no_data = explode("|", $no_data);
    $r = sql_query("SHOW TABLES") or sqlerr(__FILE__, __LINE__);
    while ($a = mysqli_fetch_assoc($r)) $temp[] = $a;
    foreach ($temp as $k => $tname) {
        $tn = $tname["Tables_in_{$INSTALLER09['mysql_db']}"];
        if (in_array($tn, $no_data)) continue;
        $tables[] = $tn;
    }
    return join(" ", $tables);
}
function docleanup($data)
{
    global $INSTALLER09, $queries, $bdir;
    set_time_limit(0);
    ignore_user_abort(1);
    $mysql_host = $INSTALLER09['mysql_host'];
    $mysql_user = $INSTALLER09['mysql_user'];
    $mysql_pass = $INSTALLER09['mysql_pass'];
    $mysql_db = $INSTALLER09['mysql_db'];
    $bdir = $_SERVER["DOCUMENT_ROOT"] . "/include/backup";
    $c1 = "mysqldump -h " . $mysql_host . " -u " . $mysql_user . " -p" . $mysql_pass . " " . $mysql_db . " -d > " . $bdir . "/db_structure.sql";
    $c = "mysqldump -h " . $mysql_host . " -u " . $mysql_user . " -p" . $mysql_pass . " " . $mysql_db . " " . tables("peers|messages|sitelog") . " | bzip2 -cq9 > " . $bdir . "/db_" . date("m_d_y", TIME_NOW) . ".sql.bz2";
    system($c1);
    system($c);
    $files = glob($bdir . "/db_*");
    foreach ($files as $file) {
        if ((TIME_NOW - filemtime($file)) > 3 * 86400) unlink($file);
    }
    $ext = "db_" . date("m_d_y", TIME_NOW) . ".sql.bz2";
    sql_query("INSERT INTO dbbackup (name, added, userid) VALUES (" . sqlesc($ext) . ", " . TIME_NOW . ", " . $INSTALLER09['site']['owner'] . ")") or sqlerr(__FILE__, __LINE__);
    if ($queries > 0) write_log("Auto-dbbackup----------------------Auto Back Up Complete using $queries queries---------------------");
    if (false !== mysqli_affected_rows($GLOBALS["___mysqli_ston"])) {
        $data['clean_desc'] = mysqli_affected_rows($GLOBALS["___mysqli_ston"]) . " items deleted/updated";
    }
    if ($data['clean_log']) {
        cleanup_log($data);
    }
}
?>
