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
require_once (CLASS_DIR . 'class_check.php');
$lang = array_merge($lang, load_language('ad_cleanup_manager'));
$class = get_access(basename($_SERVER['REQUEST_URI']));
class_check($class);
$params = array_merge($_GET, $_POST);
$params['mode'] = isset($params['mode']) ? $params['mode'] : '';
switch ($params['mode']) {
case 'unlock':
    cleanup_take_unlock();
    break;

case 'delete':
    cleanup_take_delete();
    break;

case 'takenew':
    cleanup_take_new();
    break;

case 'new':
    cleanup_show_new();
    break;

case 'takeedit':
    cleanup_take_edit();
    break;

case 'edit':
    cleanup_show_edit();
    break;

case 'run':
    manualclean();
    break;

default:
    cleanup_show_main();
    break;
}
function manualclean()
{
    global $params, $lang;
    if (function_exists('docleanup')) {
        stderr($lang['cleanup_stderr'], $lang['cleanup_stderr1']);
    }
    $opts = array(
        'options' => array(
            'min_range' => 1
        )
    );
    $params['cid'] = filter_var($params['cid'], FILTER_VALIDATE_INT, $opts);
    if (!is_numeric($params['cid'])) stderr($lang['cleanup_stderr'], $lang['cleanup_stderr2']);
    $params['cid'] = sqlesc($params['cid']);
    $sql = sql_query("SELECT * FROM cleanup WHERE clean_id = " . sqlesc($params['cid'])) or sqlerr(__file__, __line__);
    $row = mysqli_fetch_assoc($sql);
    if ($row['clean_id']) {
        $next_clean = intval(TIME_NOW + ($row['clean_increment'] ? $row['clean_increment'] : 15 * 60));
        sql_query("UPDATE cleanup SET clean_time = " . sqlesc($next_clean) . " WHERE clean_id = " . sqlesc($row['clean_id'])) or sqlerr(__file__, __line__);
        if (is_file(CLEAN_DIR . '' . $row['clean_file'])) {
            require_once (CLEAN_DIR . 'clean_log.php');
            require_once (CLEAN_DIR . '' . $row['clean_file']);
        }
        if (function_exists('docleanup')) {
            docleanup($row);
        }
    }
    cleanup_show_main(); //instead of header() so can see queries in footer (using sql_query())
    exit();
}
function cleanup_show_main()
{
	global $lang;
    $count1 = get_row_count('cleanup');
    $perpage = 15;
    $pager = pager($perpage, $count1, 'staffpanel.php?tool=cleanup_manager&amp;');
    $htmlout = "<div class='row'><div class='col-md-12'>
    <h2>{$lang['cleanup_head']}</h2>
    <table class='table table-bordered'>
    <tr>
      <td class='colhead'>{$lang['cleanup_title']}</td>
      <td class='colhead' width='150px'>{$lang['cleanup_run']}</td>
      <td class='colhead' width='150px'>{$lang['cleanup_next']}</td>
      <td class='colhead' width='40px'>{$lang['cleanup_edit']}</td>
      <td class='colhead' width='40px'>{$lang['cleanup_delete']}</td>
      <td class='colhead' width='40px'>{$lang['cleanup_on']}</td>
      <td class='colhead' style='width: 40px;'>{$lang['cleanup_run_now']}</td>
    </tr>";
    $sql = sql_query("SELECT * FROM cleanup ORDER BY clean_time ASC " . $pager['limit']) or sqlerr(__FILE__, __LINE__);
    if (!mysqli_num_rows($sql)) stderr($lang['cleanup_stderr'], $lang['cleanup_panic']);
    while ($row = mysqli_fetch_assoc($sql)) {
        $row['_clean_time'] = get_date($row['clean_time'], 'LONG');
        $row['clean_increment'] = $row['clean_increment'];
        $row['_class'] = $row['clean_on'] != 1 ? " style='color:red'" : '';
        $row['_title'] = $row['clean_on'] != 1 ? " {$lang['cleanup_lock']}" : '';
        $row['_clean_time'] = $row['clean_on'] != 1 ? "<span style='color:red'>{$row['_clean_time']}</span>" : $row['_clean_time'];
        $htmlout.= "<tr>
          <td{$row['_class']}><strong>{$row['clean_title']}{$row['_title']}</strong><br />{$row['clean_desc']}</td>
          <td>" . mkprettytime($row['clean_increment']) . "</td>
          <td>{$row['_clean_time']}</td>
          <td align='center'><a href='staffpanel.php?tool=cleanup_manager&amp;action=cleanup_manager&amp;mode=edit&amp;cid={$row['clean_id']}'>
            <img src='./pic/aff_tick.gif' alt='{$lang['cleanup_edit2']}' title='{$lang['cleanup_edit']}' border='0' height='12' width='12' /></a></td>

          <td align='center'><a href='staffpanel.php?tool=cleanup_manager&amp;action=cleanup_manager&amp;mode=delete&amp;cid={$row['clean_id']}'>
            <img src='./pic/aff_cross.gif' alt='{$lang['cleanup_delete2']}' title='{$lang['cleanup_delete1']}' border='0' height='12' width='12' /></a></td>
          <td align='center'><a href='staffpanel.php?tool=cleanup_manager&amp;action=cleanup_manager&amp;mode=unlock&amp;cid={$row['clean_id']}&amp;clean_on={$row['clean_on']}'>
            <img src='./pic/warned.png' alt='{$lang['cleanup_off_on2']}' title='{$lang['cleanup_off_on']}' border='0' height='12' width='12' /></a></td>
<td align='center'><a href='staffpanel.php?tool=cleanup_manager&amp;action=cleanup_manager&amp;mode=run&amp;cid={$row['clean_id']}'>{$lang['cleanup_run_now2']}</a></td>
 </tr>";
    }
    $htmlout.= "</table></div></div>";
    if ($count1 > $perpage) $htmlout.= $pager['pagerbottom'];
    $htmlout.= "<br />
                <span class='btn'><a href='./staffpanel.php?tool=cleanup_manager&amp;action=cleanup_manager&amp;mode=new'>{$lang['cleanup_add_new']}</a></span>";
    echo stdhead($lang['cleanup_stdhead']) . $htmlout . stdfoot();
}
function cleanup_show_edit()
{
    global $params, $lang;
    if (!isset($params['cid']) OR empty($params['cid']) OR !is_valid_id($params['cid'])) {
        cleanup_show_main();
        exit;
    }
    $cid = intval($params['cid']);
    $sql = sql_query("SELECT * FROM cleanup WHERE clean_id = $cid");
    if (!mysqli_num_rows($sql)) stderr($lang['cleanup_stderr'], $lang['cleanup_stderr3']);
    $row = mysqli_fetch_assoc($sql);
    $row['clean_title'] = htmlsafechars($row['clean_title'], ENT_QUOTES);
    $row['clean_desc'] = htmlsafechars($row['clean_desc'], ENT_QUOTES);
    $row['clean_file'] = htmlsafechars($row['clean_file'], ENT_QUOTES);
    $row['clean_title'] = htmlsafechars($row['clean_title'], ENT_QUOTES);
    $logyes = $row['clean_log'] ? 'checked="checked"' : '';
    $logno = !$row['clean_log'] ? 'checked="checked"' : '';
    $cleanon = $row['clean_on'] ? 'checked="checked"' : '';
    $cleanoff = !$row['clean_on'] ? 'checked="checked"' : '';
    $htmlout = '';
    $htmlout = "<h2>{$lang['cleanup_show_head']} {$row['clean_title']}</h2>
    <div style='width: 800px; text-align: left; padding: 10px; margin: 0 auto;border-style: solid; border-color: #333333; border-width: 5px 2px;'>
    <form name='inputform' method='post' action='staffpanel.php?tool=cleanup_manager&amp;action=cleanup_manager'>
    <input type='hidden' name='mode' value='takeedit' />
    <input type='hidden' name='cid' value='{$row['clean_id']}' />
    
    <div style='margin-bottom:5px;'>
    <label style='float:left;width:200px;'>{$lang['cleanup_show_title']}</label>
    <input type='text' value='{$row['clean_title']}' name='clean_title' style='width:250px;' /></div>
    <div style='margin-bottom:5px;'>
    <label style='float:left;width:200px;'>{$lang['cleanup_show_descr']}</label>
    <input type='text' value='{$row['clean_desc']}' name='clean_desc' style='width:380px;' />
    </div>
    
    <div style='margin-bottom:5px;'>
    <label style='float:left;width:200px;'>{$lang['cleanup_show_file']}</label>
    <input type='text' value='{$row['clean_file']}' name='clean_file' style='width:380px;' />
    
    </div>
    
    
    <div style='margin-bottom:5px;'>
    <label style='float:left;width:200px;'>{$lang['cleanup_show_interval']}</label>
    <input type='text' value='{$row['clean_increment']}' name='clean_increment' style='width:380px;' />
    </div>
    
    <div style='margin-bottom:5px;'>
    <label style='float:left;width:200px;'>{$lang['cleanup_show_log']}</label>{$lang['cleanup_show_yes']}<input name='clean_log' value='1' $logyes type='radio' />&nbsp;&nbsp;&nbsp;<input name='clean_log' value='0' $logno type='radio' />{$lang['cleanup_show_no']}</div>
    
    <div style='margin-bottom:5px;'>
    <label style='float:left;width:200px;'>{$lang['cleanup_show_on']}</label>
    {$lang['cleanup_show_yes']} <input name='clean_on' value='1' $cleanon type='radio' />&nbsp;&nbsp;&nbsp;<input name='clean_on' value='0' $cleanoff type='radio' /> {$lang['cleanup_show_no']}
    </div>
    
    <div style='text-align:center;'><input type='submit' name='submit' value='{$lang['cleanup_show_edit']}' class='button' />&nbsp;<input type='button' value='{$lang['cleanup_show_cancel']}' onclick='javascript: history.back()' /></div>
    </form>
    </div>";
    echo stdhead($lang['cleanup_show_stdhead']) . $htmlout . stdfoot();
}
function cleanup_take_edit()
{
    global $params, $lang;
    //ints
    foreach (array(
        'cid',
        'clean_increment',
        'clean_log',
        'clean_on'
    ) as $x) {
        unset($opts);
        if ($x == 'cid' OR $x == 'clean_increment') {
            $opts = array(
                'options' => array(
                    'min_range' => 1
                )
            );
        } else {
            $opts = array(
                'options' => array(
                    'min_range' => 0,
                    'max_range' => 1
                )
            );
        }
        $params[$x] = filter_var($params[$x], FILTER_VALIDATE_INT, $opts);
        if (!is_numeric($params[$x])) stderr($lang['cleanup_take_error'], "{$lang['cleanup_take_error1']} $x");
    }
    unset($opts);
    // strings
    foreach (array(
        'clean_title',
        'clean_desc',
        'clean_file'
    ) as $x) {
        $opts = array(
            'flags' => FILTER_FLAG_STRIP_LOW,
            FILTER_FLAG_STRIP_HIGH
        );
        $params[$x] = filter_var($params[$x], FILTER_SANITIZE_STRING, $opts);
        if (empty($params[$x])) stderr($lang['cleanup_take_error'], "{$lang['cleanup_take_error2']}");
    }
    $params['clean_file'] = preg_replace('#\.{1,}#s', '.', $params['clean_file']);
    if (!file_exists(CLEAN_DIR . "{$params['clean_file']}")) {
        stderr($lang['cleanup_take_error'], "{$lang['cleanup_take_error3']}");
    }
    // new clean time =
    $params['clean_time'] = intval(TIME_NOW + $params['clean_increment']);
    //one more time around! LoL
    foreach ($params as $k => $v) {
        $params[$k] = sqlesc($v);
    }
    sql_query("UPDATE cleanup SET clean_title = {$params['clean_title']}, clean_desc = {$params['clean_desc']}, clean_file = {$params['clean_file']}, clean_time = {$params['clean_time']}, clean_increment = {$params['clean_increment']}, clean_log = {$params['clean_log']}, clean_on = {$params['clean_on']} WHERE clean_id = {$params['cid']}");
    cleanup_show_main();
    exit();
}
function cleanup_show_new()
{
	global $lang;
    $htmlout = "<h2>{$lang['cleanup_new_head']}</h2>
    <div style='width: 800px; text-align: left; padding: 10px; margin: 0 auto;border-style: solid; border-color: #333333; border-width: 5px 2px;'>
    <form name='inputform' method='post' action='staffpanel.php?tool=cleanup_manager&amp;action=cleanup_manager'>
    <input type='hidden' name='mode' value='takenew' />
    
    <div style='margin-bottom:5px;'>
    <label style='float:left;width:200px;'>{$lang['cleanup_show_title']}</label>
    <input type='text' value='' name='clean_title' style='width:350px;' />
    </div>
    
    <div style='margin-bottom:5px;'>
    <label style='float:left;width:200px;'>{$lang['cleanup_show_descr']}</label>
    <input type='text' value='' name='clean_desc' style='width:350px;' />
    </div>
    
    <div style='margin-bottom:5px;'>
    <label style='float:left;width:200px;'>{$lang['cleanup_show_file']}</label>
    <input type='text' value='' name='clean_file' style='width:350px;' />
    </div>
    
    
    <div style='margin-bottom:5px;'>
    <label style='float:left;width:200px;'>{$lang['cleanup_show_interval']}</label>
    <input type='text' value='' name='clean_increment' style='width:350px;' />
    </div>
    
    <div style='margin-bottom:5px;'>
    <label style='float:left;width:200px;'>{$lang['cleanup_show_log']}</label>
    {$lang['cleanup_show_yes']} <input name='clean_log' value='1' type='radio' />&nbsp;&nbsp;&nbsp;<input name='clean_log' value='0' checked='checked' type='radio' /> {$lang['cleanup_show_no']}
    </div>
    
    <div style='margin-bottom:5px;'>
    <label style='float:left;width:200px;'>{$lang['cleanup_show_on']}</label>
    {$lang['cleanup_show_yes']} <input name='clean_on' value='1' type='radio' />&nbsp;&nbsp;&nbsp;<input name='clean_on' value='0' checked='checked' type='radio' /> {$lang['cleanup_show_no']}
    </div>
    
    <div style='text-align:center;'><input type='submit' name='submit' value='{$lang['cleanup_new_add']}' class='button' />&nbsp;<input type='button' value='{$lang['cleanup_new_cancel']}' onclick='javascript: history.back()' /></div>
    </form>
    </div>";
    echo stdhead($lang['cleanup_new_stdhead']) . $htmlout . stdfoot();
}
function cleanup_take_new()
{
    global $params, $lang;
    //ints
    foreach (array(
        'clean_increment',
        'clean_log',
        'clean_on'
    ) as $x) {
        unset($opts);
        if ($x == 'clean_increment') {
            $opts = array(
                'options' => array(
                    'min_range' => 1
                )
            );
        } else {
            $opts = array(
                'options' => array(
                    'min_range' => 0,
                    'max_range' => 1
                )
            );
        }
        $params[$x] = filter_var($params[$x], FILTER_VALIDATE_INT, $opts);
        if (!is_numeric($params[$x])) stderr($lang['cleanup_take_error'], "{$lang['cleanup_take_error1']} $x");
    }
    unset($opts);
    // strings
    foreach (array(
        'clean_title',
        'clean_desc',
        'clean_file'
    ) as $x) {
        $opts = array(
            'flags' => FILTER_FLAG_STRIP_LOW,
            FILTER_FLAG_STRIP_HIGH
        );
        $params[$x] = filter_var($params[$x], FILTER_SANITIZE_STRING, $opts);
        if (empty($params[$x])) stderr($lang['cleanup_take_error'], "{$lang['cleanup_take_error2']}");
    }
    $params['clean_file'] = preg_replace('#\.{1,}#s', '.', $params['clean_file']);
    if (!file_exists(CLEAN_DIR . "{$params['clean_file']}")) {
        stderr($lang['cleanup_take_error'], "{$lang['cleanup_take_error3']}");
    }
    // new clean time =
    $params['clean_time'] = intval(time() + $params['clean_increment']);
    $params['clean_cron_key'] = md5(uniqid()); // just for now.
    //one more time around! LoL
    foreach ($params as $k => $v) {
        $params[$k] = sqlesc($v);
    }
    sql_query("INSERT INTO cleanup (clean_title, clean_desc, clean_file, clean_time, clean_increment, clean_cron_key, clean_log, clean_on) VALUES ({$params['clean_title']}, {$params['clean_desc']}, {$params['clean_file']}, {$params['clean_time']}, {$params['clean_increment']}, {$params['clean_cron_key']}, {$params['clean_log']}, {$params['clean_on']})");
    if (((is_null($___mysqli_res = mysqli_insert_id($GLOBALS["___mysqli_ston"]))) ? false : $___mysqli_res)) {
        stderr($lang['cleanup_new_info'], "{$lang['cleanup_new_success']}");
    } else {
        stderr($lang['cleanup_new_error'], "{$lang['cleanup_new_error1']}");
    }
    exit();
}
function cleanup_take_delete()
{
    global $params, $lang;
    $opts = array(
        'options' => array(
            'min_range' => 1
        )
    );
    $params['cid'] = filter_var($params['cid'], FILTER_VALIDATE_INT, $opts);
    if (!is_numeric($params['cid'])) stderr($lang['cleanup_del_error'], "{$lang['cleanup_del_error1']}");
    $params['cid'] = sqlesc($params['cid']);
    sql_query("DELETE FROM cleanup WHERE clean_id = {$params['cid']}");
    if (1 === mysqli_affected_rows($GLOBALS["___mysqli_ston"])) {
        stderr($lang['cleanup_del_info'], "{$lang['cleanup_del_success']}");
    } else {
        stderr($lang['cleanup_del_error'], "{$lang['cleanup_del_error2']}");
    }
    exit();
}
function cleanup_take_unlock()
{
    global $params, $lang;
    foreach (array(
        'cid',
        'clean_on'
    ) as $x) {
        unset($opts);
        if ($x == 'cid') {
            $opts = array(
                'options' => array(
                    'min_range' => 1
                )
            );
        } else {
            $opts = array(
                'options' => array(
                    'min_range' => 0,
                    'max_range' => 1
                )
            );
        }
        $params[$x] = filter_var($params[$x], FILTER_VALIDATE_INT, $opts);
        if (!is_numeric($params[$x])) stderr($lang['cleanup_unlock_error'], "{$lang['cleanup_unlock_error1']} $x");
    }
    unset($opts);
    $params['cid'] = sqlesc($params['cid']);
    $params['clean_on'] = ($params['clean_on'] === 1 ? sqlesc($params['clean_on'] - 1) : sqlesc($params['clean_on'] + 1));
    sql_query("UPDATE cleanup SET clean_on = {$params['clean_on']} WHERE clean_id = {$params['cid']}");
    if (1 === mysqli_affected_rows($GLOBALS["___mysqli_ston"])) {
        cleanup_show_main(); // this go bye bye later
        
    } else {
        stderr($lang['cleanup_unlock_error'], "{$lang['cleanup_unlock_error']}");
    }
    exit();
}
?>
