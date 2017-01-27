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
require_once (INCL_DIR . 'pager_functions.php');
require_once (INCL_DIR . 'html_functions.php');
dbconn(false);
loggedinorreturn();
$lang = array_merge(load_language('global') , load_language('contactstaff'));
$stdhead = array(
    /** include css **/
    'css' => array(
        'contact_staff'
    )
);
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $msg = isset($_POST['msg']) ? htmlsafechars($_POST['msg']) : '';
    $subject = isset($_POST['subject']) ? htmlsafechars($_POST['subject']) : '';
    $returnto = isset($_POST['returnto']) ? htmlsafechars($_POST['returnto']) : $_SERVER['PHP_SELF'];
    if (empty($msg)) stderr($lang['contactstaff_error'], $lang['contactstaff_no_msg']);
    if (empty($subject)) stderr($lang['contactstaff_error'], $lang['contactstaff_no_sub']);
    if (sql_query('INSERT INTO staffmessages (sender, added, msg, subject) VALUES(' . sqlesc($CURUSER['id']) . ', ' . TIME_NOW . ', ' . sqlesc($msg) . ', ' . sqlesc($subject) . ')')) {
        $mc1->delete_value('staff_mess_');
        header('Refresh: 3; url=' . urldecode($returnto)); //redirect but wait 3 seconds
        stderr($lang['contactstaff_success'], $lang['contactstaff_success_msg']);
    } else stderr($lang['contactstaff_error'], sprintf($lang['contactstaff_mysql_err'], ((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false))));
} else {
    $HTMLOUT = "
   <div class='container'><h1 class='text-center'><img src='images/global.design/support.png' alt='' title='Support'/>Contact Staff</h1>
       
    <form method='post' name='message' action='" . $_SERVER['PHP_SELF'] . "'>
				 <table class='table table-bordered'>
				  <tr><td>
					<h1 class='text-center'>{$lang['contactstaff_title']}</h1>
					<p class='text-center small'>{$lang['contactstaff_info']}</p>
				  </td></tr>
				  <tr><td>
					<input class='form-control' type='text' name='subject' placeholder='{$lang['contactstaff_subject']}'/>
				  </td></tr>
		<tr><td align='center' colspan='2'>";
    if (isset($_GET['returnto'])) $HTMLOUT.= "<input type='hidden' name='returnto' value='" . urlencode($_GET['returnto']) . "' />";
    $HTMLOUT.= "<textarea class='form-control' name='msg' rows='10'></textarea>
                       </td>
                     </tr>
                    <tr><td class='text-center'><input type='submit' value='{$lang['contactstaff_sendit']}' class='btn btn-default' /></td></tr>
                    </table>
        </form></div><br>";
    echo stdhead($lang['contactstaff_header'], true, $stdhead) . $HTMLOUT . stdfoot();
}
?>