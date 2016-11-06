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
require_once (INCL_DIR . 'bbcode_functions.php');
require_once (INCL_DIR . 'pager_functions.php');
require_once (INCL_DIR . 'html_functions.php');
dbconn(false);
loggedinorreturn();
function mkint($x)
{
    return 0 + $x;
}
$lang = array_merge(load_language('global') , load_language('staffbox'));
$stdfoot = array(
    /** include js **/
    'js' => array(
        'staffcontact'
    )
);

if ($CURUSER['class'] < UC_STAFF) stderr($lang['staffbox_err'], $lang['staffbox_class']);
$valid_do = array(
    'view',
    'delete',
    'setanswered',
    'restart',
    ''
);
$do = isset($_GET['do']) && in_array($_GET['do'], $valid_do) ? $_GET['do'] : (isset($_POST['do']) && in_array($_POST['do'], $valid_do) ? $_POST['do'] : '');
$id = isset($_GET['id']) ? (int)$_GET['id'] : (isset($_POST['id']) && is_array($_POST['id']) ? array_map('mkint', $_POST['id']) : 0);
$message = isset($_POST['message']) && !empty($_POST['message']) ? htmlsafechars($_POST['message']) : '';
$reply = isset($_POST['reply']) && $_POST['reply'] == 1 ? true : false;
$stdhead = $HTMLOUT = '';
switch ($do) {
case 'delete':
    if ($id > 0) {
        if (sql_query('DELETE FROM staffmessages WHERE id IN (' . join(',', $id) . ')')) {
            $mc1->delete_value('staff_mess_');
            header('Refresh: 2; url=' . $_SERVER['PHP_SELF']);
            stderr($lang['staffbox_success'], $lang['staffbox_delete_ids']);
        } else stderr($lang['staffbox_err'], sprintf($lang['staffbox_sql_err'], ((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false))));
    } else stderr($lang['staffbox_err'], $lang['staffbox_odd_err']);
    break;
case 'setanswered':
    if ($id > 0) {
        if ($reply && empty($message)) {
            stderr($lang['staffbox_err'], $lang['staffbox_no_message']);
            exit;
        }
        $q1 = sql_query('SELECT s.msg,s.sender,s.subject,u.username FROM staffmessages as s LEFT JOIN users as u ON s.sender=u.id WHERE s.id IN (' . join(',', $id) . ')') or sqlerr(__FILE__, __LINE__);
        $a = mysqli_fetch_assoc($q1);
        $response = htmlsafechars($message) . "\n---" . htmlsafechars($a['username']) . " wrote ---\n" . htmlsafechars($a['msg']);
        sql_query('INSERT INTO messages(sender,receiver,added,subject,msg) VALUES(' . sqlesc($CURUSER['id']) . ',' . sqlesc($a['sender']) . ',' . TIME_NOW . ',' . sqlesc('RE: ' . $a['subject']) . ',' . sqlesc($response) . ')') or sqlerr(__FILE__, __LINE__);
        $mc1->delete_value('inbox_new_' . $a['sender']);
        $mc1->delete_value('inbox_new_sb_' . $a['sender']);
        $message = ', answer=' . sqlesc($message);
        if (sql_query('UPDATE staffmessages SET answered=\'1\', answeredby=' . sqlesc($CURUSER['id']) . ' ' . $message . ' WHERE id IN (' . join(',', $id) . ')')) {
            $mc1->delete_value('staff_mess_');
            header('Refresh: 2; url=' . $_SERVER['PHP_SELF']);
            stderr($lang['staffbox_success'], $lang['staffbox_setanswered_ids']);
        } else stderr($lang['staffbox_err'], sprintf($lang['staffbox_sql_err'], ((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false))));
    } else stderr($lang['staffbox_err'], $lang['staffbox_odd_err']);
    break;
case 'view':
    if ($id > 0) {
        $q2 = sql_query('SELECT s.id, s.added, s.msg, s.subject, s.answered, s.answer, s.answeredby, s.sender, s.answer, u.username, u2.username as username2 FROM staffmessages as s LEFT JOIN users as u ON s.sender = u.id LEFT JOIN users as u2 ON s.answeredby = u2.id  WHERE s.id = ' . sqlesc($id)) or sqlerr(__FILE__, __LINE__);
        if (mysqli_num_rows($q2) == 1) {
            $a = mysqli_fetch_assoc($q2);            
$HTMLOUT.= "<div class='row'><div class='col-md-12'><h2>{$lang['staffbox_pm_view']}</h2></div></div>";
$HTMLOUT.= "<div class='row'><div class='col-md-12'>";
            $HTMLOUT.= "<form action='" . $_SERVER['PHP_SELF'] . "' method='post'>
		<table class='table table-bordered'>
		<tr><td>{$lang['staffbox_pm_from']}&nbsp;<a href='userdetails.php?id=" . (int)$a['sender'] . "'>" . htmlsafechars($a['username']) . "</a> at " . get_date($a['added'], 'DATE', 1) . "<br/>
			{$lang['staffbox_pm_subject']} : <b>" . htmlsafechars($a['subject']) . "</b><br/>
			{$lang['staffbox_pm_answered']} : <b>" . ($a['answeredby'] > 0 ? "<a href='userdetails.php?id=" . (int)$a['answeredby'] . "'>" . htmlsafechars($a['username2']) . "</a>" : "<span style='color:#ff0000'>No</span>") . "</b>
					</td></tr>
			<tr><td>" . format_comment($a['msg']) . "</td></tr>
			<tr><td>{$lang['staffbox_pm_answer']}<br/>
			" . ($a['answeredby'] == 0 ? "<textarea rows='5' cols='75' name='message' ></textarea>" : ($a['answer'] ? format_comment($a['answer']) : "<b>{$lang['staffbox_pm_noanswer']}</b>")) . "
								</td></tr>
			<tr><td><select name='do'>
			    <option value='setanswered' " . ($a['answeredby'] > 0 ? 'disabled=\'disabled\'' : "") . ">{$lang['staffbox_pm_reply']}</option>
			    <option value='restart' " . ($a['answeredby'] != $CURUSER['id'] ? 'disabled=\'disabled\'' : "") . ">{$lang['staffbox_pm_restart']}</option>
			    <option value='delete'>{$lang['staffbox_pm_delete']}</option>
									</select>
			<input type='hidden' name='reply' value='1'/>
			<input type='hidden' name='id[]' value='" . (int)$a['id'] . "'/><input type='submit' value='{$lang['staffbox_confirm']}' /></td></tr>
								</table>
								</form>";
$HTMLOUT.= "</div></div>";
             echo (stdhead('StaffBox', true, $stdhead) . $HTMLOUT . stdfoot());
        } else stderr($lang['staffbox_err'], $lang['staffbox_msg_noid']);
    } else stderr($lang['staffbox_err'], $lang['staffbox_odd_err']);
    break;
case 'restart':
    if ($id > 0) {
        if (sql_query('UPDATE staffmessages SET answered=\'0\', answeredby=\'0\' WHERE id IN (' . join(',', $id) . ')')) {
            $mc1->delete_value('staff_mess_');
            header('Refresh: 2; url=' . $_SERVER['PHP_SELF']);
            stderr($lang['staffbox_success'], $lang['staffbox_restart_ids']);
        } else stderr($lang['staffbox_err'], sprintf($lang['staffbox_sql_err'], ((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false))));
    } else stderr($lang['staffbox_err'], $lang['staffbox_odd_err']);
    break;
default:
    $count_msgs = get_row_count('staffmessages');
    $perpage = 4;
    $pager = pager($perpage, $count_msgs, 'staffbox.php?');
    if (!$count_msgs) stderr($lang['staffbox_err'], $lang['staffbox_no_msgs']);
    else {
$HTMLOUT.= "<div class='row'><div class='col-md-12'><h2>{$lang['staffbox_info']}</h2></div></div>";
$HTMLOUT.= "<div class='row'><div class='col-md-12'>";
        $HTMLOUT.= "<form method='post' name='staffbox' action='" . $_SERVER['PHP_SELF'] . "'>";
        $HTMLOUT.= $pager['pagertop']."<br>";
        $HTMLOUT.= "<table class='table table-bordered'>";
        $HTMLOUT.= "<tr>
                 <td style='text-align:center;'><h4>{$lang['staffbox_subject']}</h4></td>
                 <td style='text-align:center;'><h4>{$lang['staffbox_sender']}</h4></td>
                 <td style='text-align:center;'><h4>{$lang['staffbox_added']}</h4></td>
                 <td style='text-align:center;'><h4>{$lang['staffbox_answered']}</h4></td>
                 <td><h4><input type='checkbox' name='t' onclick=\"checkbox('staffbox')\" /></h4></td>
                </tr>";
        $r = sql_query('SELECT s.id, s.added, s.subject, s.answered, s.answeredby, s.sender, s.answer, u.username, u2.username as username2 FROM staffmessages as s LEFT JOIN users as u ON s.sender = u.id LEFT JOIN users as u2 ON s.answeredby = u2.id ORDER BY id desc ' . $pager['limit']) or sqlerr(__FILE__, __LINE__);
        while ($a = mysqli_fetch_assoc($r)) $HTMLOUT.= "<tr>
                   <td><a href='" . $_SERVER['PHP_SELF'] . "?do=view&amp;id=" . (int)$a['id'] . "'>" . htmlsafechars($a['subject']) . "</a></td>
                   <td ><b>" . ($a['username'] ? "<a href='userdetails.php?id=" . (int)$a['sender'] . "'>" . htmlsafechars($a['username']) . "</a>" : "Unknown[" . (int)$a['sender'] . "]") . "</b></td>
                   <td nowrap='nowrap'>" . get_date($a['added'], 'DATE', 1) . "<br/><span class='small'>" . get_date($a['added'], 0, 1) . "</span></td>
				   <td ><b>" . ($a['answeredby'] > 0 ? "by <a href='userdetails.php?id=" . (int)$a['answeredby'] . "'>" . htmlsafechars($a['username2']) . "</a>" : "<span style='color:#ff0000'>No</span>") . "</b></td>
                   <td><input type='checkbox' name='id[]' value='" . (int)$a['id'] . "' /></td>
                  </tr>\n";
        $HTMLOUT.= "<tr><td>
					<select name='do'>
						<option value='delete'>{$lang['staffbox_do_delete']}</option>
						<option value='setanswered'>{$lang['staffbox_do_set']}</option>
					</select>
					<input type='submit' value='{$lang['staffbox_confirm']}' /></td></tr>
				</table></form>";
        $HTMLOUT.= $pager['pagerbottom']."<br>";
$HTMLOUT.= "</div></div>";
          }
    echo stdhead($lang['staffbox_head'], true, $stdhead) . $HTMLOUT . stdfoot($stdfoot);
}
?>
