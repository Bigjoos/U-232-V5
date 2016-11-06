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
require_once INCL_DIR . 'bbcode_functions.php';
dbconn(false);
loggedinorreturn();
$lang = array_merge(load_language('global'));
if ($CURUSER['class'] < UC_ADMINISTRATOR) stderr('Error', 'Your not authorised');
$stdhead = array(
    /** include css **/
    'css' => array(
        'style',
        'style2',
        'bbcode'
    )
);
$stdfoot = array(
    /** include js **/
    'js' => array(
        'shout'
    )
);
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    //== The expiry days.
    $days = array(
        array(
            7,
            '7 Days'
        ) ,
        array(
            14,
            '14 Days'
        ) ,
        array(
            21,
            '21 Days'
        ) ,
        array(
            28,
            '28 Days'
        ) ,
        array(
            56,
            '2 Months'
        )
    );
    //== Usersearch POST data...
    $n_pms = (isset($_POST['n_pms']) ? (int)$_POST['n_pms'] : 0);
    $ann_query = (isset($_POST['ann_query']) ? rawurldecode(trim($_POST['ann_query'])) : '');
    $ann_hash = (isset($_POST['ann_hash']) ? trim($_POST['ann_hash']) : '');
    if (hashit($ann_query, $n_pms) != $ann_hash) die(); // Validate POST...
    if (!preg_match('/\\ASELECT.+?FROM.+?WHERE.+?\\z/', $ann_query)) stderr('Error', 'Misformed Query');
    if (!$n_pms) stderr('Error', 'No recipients');
    //== Preview POST data ...
    $body = trim((isset($_POST['body']) ? $_POST['body'] : ''));
    $subject = trim((isset($_POST['subject']) ? $_POST['subject'] : ''));
    $expiry = 0 + (isset($_POST['expiry']) ? $_POST['expiry'] : 0);
    if ((isset($_POST['buttonval']) AND $_POST['buttonval'] == 'Submit')) {
        //== Check values before inserting into row...
        if (empty($body)) stderr('Error', 'No body to announcement');
        if (empty($subject)) stderr('Error', 'No subject to announcement');
        unset($flag);
        reset($days);
        foreach ($days as $x) if ($expiry == $x[0]) $flag = 1;
        if (!isset($flag)) stderr('Error', 'Invalid expiry selection');
        $expires = TIME_NOW + (86400 * $expiry); // 86400 seconds in one day.
        $created = TIME_NOW;
        $query = sprintf('INSERT INTO announcement_main ' . '(owner_id, created, expires, sql_query, subject, body) ' . 'VALUES (%s, %s, %s, %s, %s, %s)', sqlesc($CURUSER['id']) , sqlesc($created) , sqlesc($expires) , sqlesc($ann_query) , sqlesc($subject) , sqlesc($body));
        sql_query($query);
        if (mysqli_affected_rows($GLOBALS["___mysqli_ston"])) stderr('Success', 'Announcement was successfully created');
        stderr('Error', 'Contact an administrator');
    }
    echo stdhead("Create Announcement", false, $stdhead);
    $HTMLOUT = "";
    $HTMLOUT.= "<div class='row'><div class='col-md-12'><table class='table table-bordered'>
 	<tr>
 	<td class='embedded'><div align='center'>
 	<h1>Create Announcement for " . ($n_pms) . " user" . ($n_pms > 1 ? 's' : '') . "&nbsp;!</h1>";
    $HTMLOUT.= "<form name='compose' method='post' action='{$INSTALLER09['baseurl']}/new_announcement.php'>
 	<table class='table table-bordered'>
 	<tr>
 	<td colspan='2'><b>Subject: </b>
 	<input name='subject' type='text' size='76' value='" . htmlsafechars($subject) . "' /></td>
 	</tr>
 	<tr><td colspan='2'><div align='center'>
                       ".textbbcode('compose', 'body')."
  </div></td></tr>";
    $HTMLOUT.= "<tr><td colspan='2' align='center'>";
    $HTMLOUT.= "<select name='expiry'>";
    reset($days);
    foreach ($days as $x) $HTMLOUT.= '<option value="' . $x[0] . '"' . (($expiry == $x[0] ? '' : '')) . '>' . $x[1] . '</option>';
    $HTMLOUT.= "</select>

 	<input type='submit' name='buttonval' value='Preview' class='btn' />
 	<input type='submit' name='buttonval' value='Submit' class='btn' />
 	</td></tr></table>
 	<input type='hidden' name='n_pms' value='" . $n_pms . "' />
 	<input type='hidden' name='ann_query' value='".rawurlencode($ann_query)."' />
 	<input type='hidden' name='ann_hash' value='" . $ann_hash . "' />
 	</form><br /><br />
 	</div></td></tr></table>";
    if ($body) {
        $newtime = TIME_NOW + (86400 * $expiry);
        $HTMLOUT.= "<table class='table table-bordered'>
 	<tr><td bgcolor='#663366' align='center' valign='baseline'><h2><font color='white'>Announcement: 
 	" . htmlsafechars($subject) . "</font></h2></td></tr>
 	<tr><td class='text'>
 	" . format_comment($body) . "<br /><hr />Expires: " . get_date($newtime, 'DATE') . "";
        $HTMLOUT.= "</td></tr></table></div></div><br>";
    }
} else { // Shouldn't be here
    header("HTTP/1.0 404 Not Found");
    $HTMLOUT = "";
    $HTMLOUT.= "<html><h1>Not Found</h1><p>The requested URL " . htmlsafechars($_SERVER['SCRIPT_NAME'], strrpos($_SERVER['SCRIPT_NAME'], '/') + 1) . " was not found on this server.</p>
<hr />
<address>{$_SERVER['SERVER_SOFTWARE']} Server at {$INSTALLER09['baseurl']} Port 80</address></body></html>\n";
    echo $HTMLOUT;
    die();
}
echo $HTMLOUT . stdfoot($stdfoot);
?>
