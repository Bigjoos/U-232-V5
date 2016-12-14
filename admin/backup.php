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
/**
 * Updated Database Backup Manager
 */
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
require_once (INCL_DIR . 'html_functions.php');
require_once (CLASS_DIR . 'class_check.php');
class_check(UC_MAX);
$lang = array_merge($lang, load_language('ad_backup'));
/* add your ids and uncomment this check*/
$allowed_ids = array(
    1
);
if (!in_array($CURUSER['id'], $allowed_ids)) stderr($lang['backup_stderr'], $lang['backup_stderr1']);
$HTMLOUT = '';
/**
 * Configs Start
 */
/**
 * Change to the class allowed to access this page, use an array for more classes
 *
 * example: $required_class = array(UC_SYSOP, UC_ADMINISTRATOR);
 */
$required_class = UC_MAX;
/**
 * Set to true to compress the backed up database using gzip
 */
$use_gzip = false;
/**
 * Set's the document root, change only if you know what you are doing
 */
$ROOT = $_SERVER['DOCUMENT_ROOT'] . '/';
/**
 * The path to the gzip.exe file, no begining slash
 */
$gzip_path = $ROOT . 'include/gzip/gzip.exe';
/**
 * The path to your backup folder, no begining/ending slash
 *
 * example: $backupdir = $ROOT.'include/backups';
 */
$backupdir = $INSTALLER09['backup_dir'];
/**
 * The path to the mysqldump file, used to backup the databases
 */
//$mysqldump_path = 'c:/webdev/mysql/bin/mysqldump';
$mysqldump_path = '/usr/bin/mysqldump'; //==Linux

/**
 * Set to true, to be redirected to the download page after backup
 */
$autodl = false;
/**
 * Set to true, to automatically delete de file after download
 */
$autodel = false;
/**
 * Set to false if you don't want to write the actions to the log
 */
$write2log = true;
/**
 * Configs End
 */
if (is_array($required_class)) {
    if (!in_array($CURUSER['class'], $required_class)) stderr($lang['backup_stderr'], $lang['backup_stderr']);
} else {
    if ($CURUSER['class'] <> $required_class) stderr($lang['backup_stderr'], $lang['backup_stderr1']);
}
$mode = (isset($_GET['mode']) ? $_GET['mode'] : (isset($_POST['mode']) ? $_POST['mode'] : ''));
if (empty($mode)) {
    $HTMLOUT.= "<script type='text/javascript'>
        /*<![CDATA[*/
        var checkflag = 'false';
        var marked_row = new Array;
       
        function check(field)
        {
                if (checkflag == 'false')
                {
                        for (i = 0; i < field.length; i++)
                                field[i].checked = true;
                       
                        checkflag = 'true';
                       
                        return 'Un-Check All';
                }
                else
                {
                        for (i = 0; i < field.length; i++)
                                field[i].checked = false;
                       
                        checkflag = 'false';
                       
                        return 'Check All';
                }
        };
        /*]]>*/
        </script>";
    $HTMLOUT.= begin_main_frame();
    $HTMLOUT.= $lang['backup_welcome'];
    $HTMLOUT.= "<br /><h1 align='center'></h1>";
    $res = sql_query('SELECT db.id, db.name, db.added, u.id AS uid, u.username ' . 'FROM dbbackup AS db ' . 'LEFT JOIN users AS u ON u.id = db.userid ' . 'ORDER BY db.added DESC') or sqlerr(__FILE__, __LINE__);
    if (mysqli_num_rows($res) > 0) {
        $HTMLOUT.= "<form method='post' action='staffpanel.php?tool=backup&amp;mode=delete'>
   <input type='hidden' name='action' value='delete' />
   <table align='center' cellpadding='5' width='75%'>
                <tr>
                <td class='colhead' width='100%'>{$lang['backup_name']}</td>
                <td class='colhead' align='center'>{$lang['backup_addedon']}</td>
   <td class='colhead' style='white-space:nowrap;'>{$lang['backup_addedby']}</td>
                <td class='colhead' align='center'><input style='margin:0' type='checkbox' title='{$lang['backup_markall']}' onclick=\"this.value=check(form);\" /></td>
                </tr>";
        while ($arr = mysqli_fetch_assoc($res)) {
            $HTMLOUT.= "<tr>
                        <td><a href='staffpanel.php?tool=backup&amp;mode=download&amp;id=" . (int)$arr['id'] . "'>" . htmlsafechars($arr['name']) . "</a></td>
                        <td style='white-space:nowrap;'>" . get_date($arr['added'], 'DATE', 1, 0) . "</td>
     <td align='center'>";
            if (!empty($arr['username'])) {
                $HTMLOUT.= "<a href='{$INSTALLER09['baseurl']}/userdetails.php?id=" . (int)$arr['uid'] . "'>" . htmlsafechars($arr['username']) . "</a>";
            } else {
                $HTMLOUT.= "unknown[" . (int)$arr['uid'] . "]";
            }
            $HTMLOUT.= "</td>
                        <td><input type='checkbox' style='margin:0' name='ids[]' title='{$lang['backup_mark']}' value='" . (int)$arr['id'] . "' /></td>
                        </tr>";
        }
        $HTMLOUT.= "<tr>
    <td colspan='4' align='center'>
    <input type='button' value='{$lang['backup_checkall']}' onclick=\"this.value=check(form);\" />
    <input type='submit' value='{$lang['backup_delselected']}' onclick=\"return confirm(''{$lang['backup_confirm']}'');\" />
                 </td></tr></table></form>";
    } else {
        $HTMLOUT.= begin_frame();
        $HTMLOUT.= "<h2 align='center'>'{$lang['backup_nofound']}'</h2>";
        $HTMLOUT.= end_frame();
    }
    $HTMLOUT.= "<br />";
    $HTMLOUT.= stdmsg($lang['backup_options'], "<div align='center'><a href='staffpanel.php?tool=backup&amp;mode=backup'>{$lang['backup_dbbackup']}</a>&nbsp;&nbsp;-&nbsp;&nbsp;<a href='staffpanel.php?tool=backup&amp;mode=check'>{$lang['backup_settingschk']}</a></div>");
    if (!empty($_GET)) $HTMLOUT.= "<br />";
    if (isset($_GET['backedup'])) $HTMLOUT.= stdmsg($lang['backup_success'], $lang['backup_backedup']);
    else if (isset($_GET['deleted'])) $HTMLOUT.= stdmsg($lang['backup_success'], $lang['backup_deleted']);
    else if (isset($_GET['noselection'])) $HTMLOUT.= stdmsg($lang['backup_stderr'], $lang['backup_selectb']);
    $HTMLOUT.= end_main_frame();
    echo stdhead($lang['backup_stdhead']) . $HTMLOUT . stdfoot();
} else if ($mode == "backup") {
    global $INSTALLER09;
    $mysql_host = $INSTALLER09['mysql_host'];
    $mysql_user = $INSTALLER09['mysql_user'];
    $mysql_pass = $INSTALLER09['mysql_pass'];
    $mysql_db = $INSTALLER09['mysql_db'];
    $ext = $mysql_db . '-' . date('d') . '-' . date('m') . '-' . date('Y') . '_' . date('H') . '-' . date('i') . '-' . date('s') . '_' . date('D') . ".sql";
    $filepath = $backupdir . '/' . $ext;
    exec("$mysqldump_path --default-character-set=latin1 -h $mysql_host -u $mysql_user -p$mysql_pass $mysql_db > $filepath");
    if ($use_gzip) exec($gzip_path . ' ' . $filepath);
    sql_query("INSERT INTO dbbackup (name, added, userid) VALUES (" . sqlesc($ext . ($use_gzip ? '.gz' : '')) . ", " . TIME_NOW . ", " . sqlesc($CURUSER['id']) . ")") or sqlerr(__FILE__, __LINE__);
    $location = 'mode=backup';
    if ($autodl) {
        $id = ((is_null($___mysqli_res = mysqli_insert_id($GLOBALS["___mysqli_ston"]))) ? false : $___mysqli_res);
        $location = 'mode=download&id=' . $id;
    }
    if ($write2log) write_log($CURUSER['username'] . '(' . get_user_class_name($CURUSER['class']) . ') '. $lang['backup_successfully'] .'');
    header("Location: staffpanel.php?tool=backup");
} else if ($mode == "download") {
    $id = (isset($_GET['id']) ? (int)$_GET['id'] : 0);
    if (!is_valid_id($id)) stderr($lang['backup_stderr'], $lang['backup_id']);
    $res = sql_query("SELECT name FROM dbbackup WHERE id = " . sqlesc($id)) or sqlerr(__FILE__, __LINE__);
    $arr = mysqli_fetch_assoc($res);
    $filename = $backupdir . '/' . $arr['name'];
    //print $filename;
    //exit();
    if (!is_file($filename)) stderr($lang['backup_stderr'], $lang['backup_inexistent']);
    $file_extension = strtolower(substr(strrchr($filename, ".") , 1));
    switch ($file_extension) {
    case "sql":
        $ctype = "application/sql";
        break;

    case "sql.gz":
    case "gz":
        $ctype = "application/x-gzip";
        break;

    default:
        $ctype = "application/force-download";
    }
    if ($write2log) write_log($CURUSER['username'] . '(' . get_user_class_name($CURUSER['class']) . ') downloaded a database(' . htmlsafechars($arr['name']) . ').');
    header('Refresh: 0; url=staffpanel.php' . ($autodl && !$autodel ? '' : '?tool=backup&mode=delete&id=' . $id));
    header("Pragma: public");
    header("Expires: 0");
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    header("Cache-Control: private", false);
    header("Content-Type: $ctype");
    header("Content-Disposition: attachment; filename=\"" . basename($filename) . "\";");
    header("Content-Transfer-Encoding: binary");
    header("Content-Length: " . filesize($filename));
    readfile($filename);
} else if ($mode == 'delete') {
    $ids = (isset($_POST["ids"]) ? $_POST["ids"] : (isset($_GET['id']) ? array(
        $_GET['id']
    ) : array()));
    if (!empty($ids)) {
        foreach ($ids as $id) if (!is_valid_id($id)) stderr($lang['backup_stderr'], $lang['backup_id']);
        $res = sql_query("SELECT name FROM dbbackup WHERE id IN (" . implode(', ', array_map('sqlesc', $ids)) . ")") or sqlerr(__FILE__, __LINE__);
        $count = mysqli_num_rows($res);
        if ($count > 0) {
            while ($arr = mysqli_fetch_assoc($res)) {
                $filename = $backupdir . '/' . $arr['name'];
                if (is_file($filename)) unlink($filename);
            }
            sql_query('DELETE FROM dbbackup WHERE id IN (' . implode(', ', array_map('sqlesc', $ids)) . ')') or sqlerr(__FILE__, __LINE__);
            if ($write2log) write_log($CURUSER['username'] . '(' . get_user_class_name($CURUSER['class']) . ') '. $lang['backup_deleted1'] .' ' . $count . ($count > 1 ? $lang['backup_database_plural'] : $lang['backup_database_singular']) . '.');
            $location = 'backup';
        } else $location = 'noselection';
    } else $location = 'noselection';
    header('Location:staffpanel.php?tool=backup&mode=' . $location);
} else if ($mode == "check") {
    $HTMLOUT.= begin_main_frame();
    $HTMLOUT.= "<table align='center' cellpadding='5' width='55%'>
         <tr>
  <td class='colhead' colspan='2'>{$lang['backup_settingschk']}(<a href='staffpanel.php?tool=backup'>{$lang['backup_goback']}</a>)</td>
         </tr>
         <tr>
  <td>{$lang['backup_qzip']}<br /><font class='small'>{$lang['backup_optional']}</font></td>
  <td width='1%' align='center'><b>" . ($use_gzip ? "<font color='green'>{$lang['backup_yes']}</font>" : "<font color='red'>{$lang['backup_no']}</font>") . "</b></td>
         </tr>
  <tr>
  <td>{$lang['backup_qzippath']}<br /><font class='small'>" . $gzip_path . "</font></td>
  <td width='1%' align='center'><b>" . (is_file($gzip_path) ? "<font color='green'>{$lang['backup_yes']}</font>" : "<font color='red'>{$lang['backup_no']}</font>") . "</b></td>
  </tr>
  <tr>
  <td>{$lang['backup_pathfolder']}<br /><font class='small'>" . $backupdir . "</font></td>
  <td width='1%' align='center'><b>" . (is_dir($backupdir) ? "<font color='green'>{$lang['backup_yes']}</font>" : "<font color='red'>{$lang['backup_no']}</font>") . "</b></td>
         </tr>
  <tr>
  <td>{$lang['backup_readfolder']}</td>
  <td width='1%' align='center'><b>" . (is_readable($backupdir) ? "<font color='green'>{$lang['backup_yes']}</font>" : "<font color='red'>{$lang['backup_no']}</font>") . "</b></td>
         </tr>
  <tr>
  <td>{$lang['backup_writable']}</td>
  <td width='1%' align='center'><b>" . (is_writable($backupdir) ? "<font color='green'>{$lang['backup_yes']}</font>" : "<font color='red'>{$lang['backup_no']}</font>") . "</b></td>
         </tr>
  <tr>
  <td>{$lang['backup_mysqldump']}<br /><font class='small'>" . $mysqldump_path . "</font></td>
  <td width='1%' align='center'><b>" . (preg_match('/mysqldump/i', exec($mysqldump_path)) ? "<font color='green'>{$lang['backup_yes']}</font>" : "<font color='red'>{$lang['backup_no']}</font>") . "</b></td>
         </tr>
  <tr>
  <td>{$lang['backup_downafter']}</td>
  <td width='1%' align='center'><b>" . ($autodl ? "<font color='green'>{$lang['backup_yes']}</font>" : "<font color='red'>{$lang['backup_no']}</font>") . "</b></td>
         </tr>
  <tr>
  <td>{$lang['backup_delafter']}</td>
  <td width='1%' align='center'><b>" . ($autodel ? "<font color='green'>{$lang['backup_yes']}</font>" : "<font color='red'>{$lang['backup_no']}</font>") . "</b></td>
         </tr>
  <tr>
  <td>{$lang['backup_writeact']}</td>
  <td width='1%' align='center'><b>" . ($write2log ? "<font color='green'>{$lang['backup_yes']}</font>" : "<font color='red'>{$lang['backup_no']}</font>") . "</b></td>
         </tr></table>";
    $HTMLOUT.= end_main_frame();
    echo stdhead($lang['backup_stdhead']) . $HTMLOUT . stdfoot();
} else stderr($lang['backup_srry'], $lang['backup_unknow']);
?>
