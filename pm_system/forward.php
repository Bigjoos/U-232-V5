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
$body = '';
//=== don't allow direct access
if (!defined('BUNNY_PM_SYSTEM')) {
    $HTMLOUT = '';
    $HTMLOUT.= '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
        <html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
        <head>
        <meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
        <title>ERROR</title>
        </head><body>
        <h1 style="text-align:center;">ERROR</h1>
        <p style="text-align:center;">How did you get here? silly rabbit Trix are for kids!.</p>
        </body></html>';
    echo $HTMLOUT;
    exit();
}
//=== Get the info
$res = sql_query('SELECT * FROM messages WHERE id=' . sqlesc($pm_id)) or sqlerr(__FILE__, __LINE__);
$message = mysqli_fetch_assoc($res);
if ($message['sender'] == $CURUSER['id'] && $message['sender'] == $CURUSER['id'] || mysqli_num_rows($res) === 0) stderr($lang['pm_error'], $lang['pm_forward_err']);
//=== if not from curuser then get who from
if ($message['sender'] !== $CURUSER['id']) {
    $res_forward = sql_query('SELECT username FROM users WHERE id=' . sqlesc($message['sender'])) or sqlerr(__FILE__, __LINE__);
    $arr_forward = mysqli_fetch_assoc($res_forward);
    $forwarded_username = ($message['sender'] === 0 ? $lang['pm_forward_system'] : (mysqli_num_rows($res_forward) === 0 ? $lang['pm_forward_unknow'] : $arr_forward['username']));
} else $forwarded_username = htmlsafechars($CURUSER['username']);
//=== print out the forwarding page
$HTMLOUT.= '<h1>' . $lang['pm_forward_fwd'] . '' . htmlsafechars($message['subject']) . '</h1>
        <form name="compose" action="pm_system.php" method="post">
        <input type="hidden" name="id" value="' . $pm_id . '" />
        <input type="hidden" name="action" value="forward_pm" />
    <table class="table table-striped">
    <tr>
        <td colspan="2" class="text-left" valign="top"><h1>' . $lang['pm_forward_fwd_msg'] . '
        <img src="pic/arrow_next.gif" alt=":" />' . $lang['pm_forward_fwd'] . '' . htmlsafechars($message['subject']) . '</h1></td>
    </tr>
    <tr>
        <td class="text-rigt" valign="top"><span style="font-weight: bold;">' . $lang['pm_forward_to'] . '</span></td>
        <td class="text-left" valign="top"><input type="text" name="to" value="' . $lang['pm_forward_user'] . '" class="member" onfocus="this.value=\'\';" /></td>
    </tr>
    <tr>
        <td class="text-right" valign="top"><span style="font-weight: bold;">' . $lang['pm_forward_original'] . '</span></td>
        <td class="text-left" valign="top"><span style="font-weight: bold;">' . $forwarded_username . '</span></td>
    </tr>
    <tr>
        <td class="text-right" valign="top"><span style="font-weight: bold;">' . $lang['pm_forward_from'] . '</span></td>
        <td class="text-left" valign="top"><span style="font-weight: bold;">' . $CURUSER['username'] . '</span></td>
    </tr>
    <tr>
        <td class="text-right" valign="top"><span style="font-weight: bold;">' . $lang['pm_forward_subject'] . '</span></td>
        <td class="text-left" valign="top"><input type="text" class="text_default" name="subject" value="' . $lang['pm_forward_fwd'] . '' . htmlsafechars($message['subject']) . '" /></td>
    </tr>
    <tr>
        <td class="text-center"></td>
        <td class="text-left">' . $lang['pm_forward_org_msg'] . '' . $forwarded_username . '' . $lang['pm_forward_org_msg1'] . '<br />' . format_comment($message['msg']) . '</td>
    </tr>
    <tr>
        <td class="text-right" valign="top"></td>
        <td class="text-left"><span style="font-weight: bold;">' . $lang['pm_forward_appear'] . '</span></td>
    </tr>
    <tr>
        <td class="text-right" valign="top"><span style="font-weight: bold;">' . $lang['pm_forward_message'] . '</span></td>
        <td class="text-left" valign="top">' . textbbcode('compose', 'body') . '</td>
    </tr>
    <tr>
        <td colspan="2" class="text-center">' . ($CURUSER['class'] >= UC_STAFF ? '<span class="label label-danger">' . $lang['pm_forward_mark'] . '</span>
        <input type="checkbox" name="urgent" value="yes" />&nbsp' : '') . '' . $lang['pm_forward_save'] . '
        <input type="checkbox" name="save" value="1" />
        <input type="hidden" name="first_from" value="' . $forwarded_username . '" /> 
        <input type="submit" class="btn btn-primary" name="move" value="Foward" /></td>
    </tr>
    </table></form>';
?>
