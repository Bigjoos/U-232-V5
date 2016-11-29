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
require_once (INCL_DIR . 'html_functions.php');
require_once (CLASS_DIR . 'class_check.php');
$class = get_access(basename($_SERVER['REQUEST_URI']));
class_check($class);


$lang = array_merge($lang, load_language('forums'));


$HTMLOUT = $select = '';
$this_url = 'staffpanel.php?tool=msubforums&action=msubforums';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    mkglobal("subforum:descr:place");
    if (empty($subforum) || empty($descr) || empty($place))
        stderr($lang['forum_mngr_err1'], $lang['forum_mngr_warn1']);
    else {
        sql_query("INSERT INTO forums(`name`,`description` ,`min_class_read` ,`min_class_write` ,`min_class_create`,`place`,`forum_id`) VALUES(" . join(",", array_map("sqlesc", array($subforum, $descr, $readclass, $writeclass, $createclass, $place, $place))) . ")") or sqlerr(__FILE__, __LINE__);
        if (((is_null($___mysqli_res = mysqli_insert_id($GLOBALS["___mysqli_ston"]))) ? false : $___mysqli_res)) {
            header("Refresh: 2; url=" . $this_url);
            stderr($lang['forum_mngr_succ'], $lang['forum_sub_add']);
        } else
            stderr($lang['forum_mngr_err1'], $lang['forum_mngr_warn2']);
    }
} else {
  
    //$HTMLOUT .= begin_frame();

	$HTMLOUT .= "<div class='row'><div class='col-md-12'>";
    // first build the list with all the subforums
    $r_list = sql_query("SELECT f.id as parrentid , f.name as parrentname , f2.id as subid , f2.name as subname, f2.min_class_read, f2.min_class_write, f2.min_class_create, f2.description FROM forums as f LEFT JOIN forums as f2 ON f2.place=f.id WHERE f2.place !=-1 ORDER BY f.id ASC") or sqlerr(__FILE__, __LINE__);

	$HTMLOUT .="<table class='table table-bordered'>
              <tr>
    	        <td width='100%' align='left' rowspan='2' class='colhead'>{$lang['forum_sub_sub']}</td>
              <td nowrap='nowrap' align='center' rowspan='2' class='colhead'>{$lang['forum_sub_par']}</td>
              <td colspan='3' align='center' class='colhead'>{$lang['forum_sub_per']}</td>
              <td align='center' rowspan='2' class='colhead'>{$lang['forum_sub_mod']}</td>
              </tr>
              <tr>
    	      <td nowrap='nowrap' class='colhead'>{$lang['forum_sub_rd']}</td>
              <td nowrap='nowrap' class='colhead'>{$lang['forum_sub_wr']}</td>
              <td nowrap='nowrap' class='colhead'>{$lang['forum_sub_cr']}</td>
              </tr>";


    while ($a = mysqli_fetch_assoc($r_list)) {

        
		$HTMLOUT .="<tr>
    <td width='100%' align='left' ><a href='{$INSTALLER09['baseurl']}/forums.php?action=viewforum&amp;forumid=".((int)$a["subid"])."' >".(htmlsafechars($a["subname"]))."</a><br/>".(htmlsafechars($a["description"]))."</td>
    <td nowrap='nowrap' align='center'><a href='{$INSTALLER09['baseurl']}/forums.php?action=viewforum&amp;forumid=".(int)($a["parrentid"])."' >".(htmlsafechars($a["parrentname"]))."</a></td>
    <td nowrap='nowrap'>".(get_user_class_name($a['min_class_read']))."</td>
    <td nowrap='nowrap'>".(get_user_class_name($a['min_class_write']))."</td>
    <td nowrap='nowrap'>".(get_user_class_name($a['min_class_create']))."</td>
		<td align='center' nowrap='nowrap' ><a href='{$INSTALLER09['baseurl']}/forums.php?action=deleteforum&amp;forumid=".(int)($a['subid'])."'>
		<img src='{$INSTALLER09['pic_base_url']}del.png' alt='Delete Forum' title='Delete Forum' style='border:none;padding:2px;' /></a>
		<a href='{$INSTALLER09['baseurl']}/forums.php?action=editforum&amp;forumid=".(int)($a['subid'])."'><img src='{$INSTALLER09['pic_base_url']}edit.png' alt='Edit Forum' title='Edit Forum' style='border:none;padding:2px;' /></a></td>
    </tr>";
    }
    
    $HTMLOUT .="</table>";
	$HTMLOUT .= "</div></div>";

    //$HTMLOUT .= end_frame();
    //$HTMLOUT .= begin_frame('Add new subforum');
	$HTMLOUT .= "<div class='row'><div class='col-md-12'>";
	  $HTMLOUT .="<form action='".$this_url."' method='post'>
	  <table class='table table-bordered'>
	  <tr>
		<td align='right' class='colhead'>{$lang['forum_sub_in']}</td>
		<td nowrap='nowrap' colspan='3' align='left' >";
    $select .="<select name=\"place\"><option value=\"\">Select</option>\n";
    $r = sql_query("SELECT id,name FROM forums WHERE place=-1 ORDER BY name ASC") or sqlerr(__FILE__, __LINE__);
    while ($ar = mysqli_fetch_assoc($r))
    $select .= "<option value=\"" . (int)$ar["id"] . "\">" . htmlsafechars($ar["name"]) . "</option>\n";
    $select .= "</select>\n";
    $HTMLOUT .=($select);
    
		$HTMLOUT .="</td>
	  </tr>
	  <tr>
		<td align='right' class='colhead'>{$lang['forum_sub_sub1']}</td>
		<td nowrap='nowrap' colspan='3' align='left' >
		<input type='text' name='subforum' size='60' /></td>
	  </tr>
	  <tr>
		<td align='right' class='colhead'>{$lang['forum_sub_desc']}</td>
		<td nowrap='nowrap' colspan='3' align='left'>
		<textarea name='descr' rows='4' cols='60'></textarea></td>
	  </tr>
	  <tr>
		<td align='right' class='colhead'>{$lang['forum_sub_per1']}</td>
		<td align='center'>
		<select name='createclass'>
		<option value=''>{$lang['forum_sub_cr']}</option>";
    $maxclass = UC_MAX;
    for ($i = 0; $i <= $maxclass; ++$i)
    $HTMLOUT .="<option value=\"$i\">" . get_user_class_name($i) . "</option>\n";
    $HTMLOUT .=" </select></td>
		<td align='center'><select name='writeclass'>
		<option value=''>{$lang['forum_sub_wr']}</option>";
    $maxclass = $CURUSER["class"];
    for ($i = 0; $i <= $maxclass; ++$i)
    $HTMLOUT .="<option value=\"$i\">" . get_user_class_name($i) . "</option>\n";
    $HTMLOUT .="</select></td>
	  <td align='center'><select name='readclass'>
		<option value=''>{$lang['forum_sub_rd']}</option>";
    $maxclass = $CURUSER["class"];
    for ($i = 0; $i <= $maxclass; ++$i)
    $HTMLOUT .="<option value=\"$i\">" . get_user_class_name($i) . "</option>\n";
    $HTMLOUT .="</select></td>
	  </tr>
	  <tr>
	  <td align='center' colspan='4' class='colhead'>
	  <input type='submit' value='{$lang['forum_sub_ads']}'/></td></tr>
	  </table>
	  </form>";
	$HTMLOUT .= "</div></div>";

    //$HTMLOUT .= end_frame();
     echo stdhead($lang['forum_sub_mng']) . $HTMLOUT . stdfoot();
}

?>
