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
dbconn();
loggedinorreturn();
$HTMLOUT = '';
$lang = array_merge(load_language('global'));
$uploaded = 0 + $CURUSER["uploaded"];
$downloaded = 0 + $CURUSER["downloaded"];
$newuploaded = 0 + ($uploaded * 1.1);
if ($downloaded > 0) {
    $ratio = number_format($uploaded / $downloaded, 3);
    $newratio = number_format($newuploaded / $downloaded, 3);
    $ratiochange = number_format(($newuploaded / $downloaded) - ($uploaded / $downloaded) , 3);
} elseif ($uploaded > 0) $ratio = $newratio = $ratiochange = "Inf.";
else $ratio = $newratio = $ratiochange = "---";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($CURUSER["tenpercent"] == "yes") stderr("Used", "It appears that you have already used your 10% addition.");
    $sure = (isset($_POST['sure']) ? intval($_POST['sure']) : '');
    if (!$sure) stderr("Are you sure?", "It appears that you are not yet sure whether you want to add 10% to your upload or not. Once you are sure you can <a href='tenpercent.php'>return</a> to the 10% page.");
    $time = TIME_NOW;
    $subject = "10% Addition";
    $msg = "Today, " . get_date($time, 'LONG', 0, 1) . ", you have increased your total upload amount by 10% from [b]" . mksize($uploaded) . "[/b] to [b]" . mksize($newuploaded) . "[/b], which brings your ratio to [b]" . $newratio . "[/b].";
    $res = sql_query("UPDATE users SET uploaded = uploaded * 1.1, tenpercent = 'yes' WHERE id = " . sqlesc($CURUSER['id'])) or sqlerr(__FILE__, __LINE__);
    $update['uploaded'] = ($CURUSER['uploaded'] * 1.1);
    $mc1->begin_transaction('userstats_' . $CURUSER['id']);
    $mc1->update_row(false, array(
        'uploaded' => $update['uploaded']
    ));
    $mc1->commit_transaction($INSTALLER09['expires']['u_stats']);
    $mc1->begin_transaction('user_stats_' . $CURUSER['id']);
    $mc1->update_row(false, array(
        'uploaded' => $update['uploaded']
    ));
    $mc1->commit_transaction($INSTALLER09['expires']['user_stats']);
    $mc1->begin_transaction('user' . $CURUSER['id']);
    $mc1->update_row(false, array(
        'tenpercent' => 'yes'
    ));
    $mc1->commit_transaction($INSTALLER09['expires']['user_cache']);
    $mc1->begin_transaction('MyUser_' . $CURUSER['id']);
    $mc1->update_row(false, array(
        'tenpercent' => 'yes'
    ));
    $mc1->commit_transaction($INSTALLER09['expires']['user_cache']);
    $res1 = sql_query("INSERT INTO messages (sender, poster, receiver, subject, msg, added) VALUES (0, 0, " . sqlesc($CURUSER['id']) . ", " . sqlesc($subject) . ", " . sqlesc($msg) . ", '" . TIME_NOW . "')") or sqlerr(__FILE__, __LINE__);
    $mc1->delete_value('inbox_new_' . $CURUSER['id']);
    $mc1->delete_value('inbox_new_sb_' . $CURUSER['id']);
    if (!$res) stderr("Error", "It appears that something went wrong while trying to add 10% to your upload amount.");
    else stderr("10% Added", "Your total upload amount has been increased by 10% from <b>" . mksize($uploaded) . "</b> to <b>" . mksize($newuploaded) . "</b>, which brings your ratio to <b>$newratio</b>.");
}
if ($CURUSER["tenpercent"] == "no") {
    $HTMLOUT.= "
  <script type='text/javascript'>
  /*<![CDATA[*/
  function enablesubmit() {
	document.tenpercent.submit.disabled = document.tenpercent.submit.checked;
  }
  function disablesubmit() {
	document.tenpercent.submit.disabled = !document.tenpercent.submit.checked;
  }
  /*]]>*/
  </script>";
}
if ($CURUSER["tenpercent"] == "yes") {
    stderr("Oops", "It appears that you have already used your 10% addition");
    exit();
}
$HTMLOUT.= "<div class='row'><div class='col-md-12'>";
$HTMLOUT.= "<h1 class='text-center'>10&#37;</h1>
<table class='table table-bordered'>
<tr>
<td style='padding-bottom: 0px'>
<p><b>How it works:</b></p>
<p class='sub'>From this page you can <b>add 10&#37;</b> of your current upload amount to your upload amount bringing it it to <b>110%</b> of its current amount. More details about how this would work out for you can be found in the tables below.</p>
<br /><p><b>However, there are some things you should know first:</b></p><b>
&#8226;&nbsp;This can only be done <b>once</b>, so chose your moment wisely.<br />
&#8226;&nbsp;The staff will <b>not</b> reset your 10&#37; addition for any reason.<br /><br />
</b></td></tr></table>
<table class='table table-bordered'>
<tr><td class='normalrowhead'>Current&nbsp;upload&nbsp;amount:</td><td class='normal'>" . str_replace(" ", "&nbsp;", mksize($uploaded)) . "</td><td class='embedded' width='5%'></td><td class='normalrowhead'>Increase:</td><td class='normal'>" . str_replace(" ", "&nbsp;", mksize($newuploaded - $uploaded)) . "</td><td class='embedded' width='5%'></td><td class='normalrowhead'>New&nbsp;upload&nbsp;amount:</td><td class='normal'>" . str_replace(" ", "&nbsp;", mksize($newuploaded)) . "</td></tr>
<tr><td class='normalrowhead'>Current&nbsp;download&nbsp;amount:</td><td class='normal'>" . str_replace(" ", "&nbsp;", mksize($downloaded)) . "</td><td class='embedded' width='5%'></td><td class='normalrowhead'>Increase:</td><td class='normal'>" . str_replace(" ", "&nbsp;", mksize(0)) . "</td><td class='embedded' width='5%'></td><td class='normalrowhead'>New&nbsp;download&nbsp;amount:</td><td class='normal'>" . str_replace(" ", "&nbsp;", mksize($downloaded)) . "</td></tr>
<tr><td class='normalrowhead'>Current&nbsp;ratio:</td><td class='normal'>$ratio</td><td class='embedded' width='5%'></td><td class='normalrowhead'>Increase:</td><td class='normal'>$ratiochange</td><td class='embedded' width='5%'></td><td class='normalrowhead'>New&nbsp;ratio:</td><td class='normal'>$newratio</td></tr>
</table>
<form name='tenpercent' method='post' action='tenpercent.php'>
<table class='table table-bordered'>
<tr><td align='center'><b>Yes please </b><input type='checkbox' name='sure' value='1' onclick='if (this.checked) enablesubmit(); else disablesubmit();' /></td></tr>
<tr><td align='center'><input type='submit' name='submit' value='Add 10%' class='btn' disabled='disabled' /></td></tr>
</table></form>\n";
$HTMLOUT.= "</div></div>";
echo stdhead("Ten Percent") . $HTMLOUT . stdfoot();
?>
