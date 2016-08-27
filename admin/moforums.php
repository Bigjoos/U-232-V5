<?php
/**
 |--------------------------------------------------------------------------|
 |   https://github.com/Bigjoos/                			    |
 |--------------------------------------------------------------------------|
 |   Licence Info: GPL						            |
 |--------------------------------------------------------------------------|
 |   Copyright (C) 2010 U-232 V5				            |
 |--------------------------------------------------------------------------|
 |   A bittorrent tracker source based on TBDev.net/tbsource/bytemonsoon.   |
 |--------------------------------------------------------------------------|
 |   Project Leaders: Mindless, Autotron, whocares, son.		    |
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


$lang = array_merge( $lang, load_language('forums') );
$id = isset($_GET['id']) && is_valid_id($_GET['id']) ? (int)$_GET['id'] : (isset($_POST['id']) && is_valid_id($_POST['id']) ? (int)$_POST['id'] : 0);
$v_do = array('edit','process_edit','process_add','delete','');
$do = isset($_GET['do']) && in_array($_GET['do'],$v_do) ? htmlsafechars($_GET['do']) : (isset($_POST['do']) && in_array($_POST['do'],$v_do) ? htmlsafechars($_POST['do']) : '');
$this_url = 'staffpanel.php?tool=moforums&action=moforums';
switch($do) {
case 'delete' : 
	if(!$id)
	stderr('Err','Fool what are you doing!?');
	if(sql_query('DELETE FROM over_forums where id = '.sqlesc($id))) {
		header('Refresh:2; url='.$this_url);
		stderr('Success','Over Forum was deleted! wait till redirect');
	} else 
		stderr('Err','Something happened! Mysql Error '.((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
break;
case 'process_add' :
case 'process_edit' :

	foreach(array('name'=>1,'description'=>1,'minclassview'=>0,'sort'=>0) as $key=>$empty_check) {
		if($empty_check && empty($_POST[$key]))
		stderr('Err','You need to fill all the fields!');
		else 
			$$key = sqlesc($_POST[$key]);
	}
	
	switch(end(explode('_',$do))){
		case 'add':
			$res = 'INSERT INTO over_forums(name,description,forum_id,min_class_view,sort) VALUES('.$name.','.$description.', 1,'.$minclassview.','.$sort.')';
			$msg = 'Over Forum was added! Wait till redirect';
		break; 
		case 'edit':
			$res = 'UPDATE over_forums set name = '.$name.', description = '.$description.',forum_id = 1, min_class_view = '.$minclassview.', sort = '.$sort.' WHERE id = '.sqlesc($id);
			$msg = 'Over Forum was edited! Wait till redirect';
		break;
	}
	if(sql_query($res)) {
		header('Refresh:2; url='.$this_url);
		stderr('Success',$msg);
	} else
		stderr('Err','Something happened! Mysql Error '.((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
break;
case 'edit' : 
default :
$htmlout = "<div class='row'><div class='col-md-12'><h2>Over Forum manager</h2>";
$r1 = sql_query('select name, id, description, min_class_view, forum_id, sort FROM over_forums ORDER BY sort') or  sqlerr(__FILE__,__LINE__);
$f_count = mysqli_num_rows($r1);
if(!$f_count)
$htmlout .= "<h2>Err,There are no overforums, maybe you should add some</h2>";
else {
	$htmlout .= "<script type='text/javascript'>
				/*<![CDATA[*/
					function confirm_delete(id)
					{
						if(confirm('Are you sure you want to delete this forum?'))
						{
							self.location.href=\"".$this_url."&do=delete&id=\"+id;
						}
					}
				/*]]>*/
				</script>
				<table class='table table-bordered'>
					<tr>
						<td class='colhead' align='left'>Over forum Name</td>
						<td class='colhead'>Read</td>
						<td class='colhead' colspan='2'>Modify</td>
					</tr>";
	while($a = mysqli_fetch_assoc($r1))
		$htmlout .="<tr onmouseover=\"this.bgColor='#999';\" onmouseout=\"this.bgColor='';\">
						<td align='left'><a href='forums.php?action=viewforum&amp;forumid=".(int)$a['id']."'>".htmlsafechars($a['name'])."</a><br/><span class='small'>".htmlsafechars($a['description'])."</span></td>
						<td>".get_user_class_name($a['min_class_view'])."</td>
					
						<td><a href='".$this_url."&amp;do=edit&amp;id=".(int)$a['id']."#edit'>Edit</a></td>
						<td><a href='javascript:confirm_delete(".(int)$a['id'].");'>Delete</a></td>
					</tr>";
	$htmlout .="</table>";
}
	$edit_action = false;
	if($do == 'edit' && !$id)
		$htmlout .= "<h2>Edit action,Im not sure what are you trying to do</h2>";
	if($do =='edit' && $id) {
		$r3 = sql_query('select name, id, description , min_class_view ,forum_id, sort FROM over_forums WHERE id ='.sqlesc($id)) or sqlerr(__FILE__,__LINE__);
		if(!mysqli_num_rows($r3))
			$htmlout .= "<h2>Edit action,The Over forum your looking for does not exist</h2>";

		else {
			$edit_action = true;
			$a3 = mysqli_fetch_assoc($r3);
		}
	}
	
$htmlout .= "<form action='".$this_url."' method='post'>
	<table class='table table-bordered' id='edit'>
	<tr><td colspan='2' align='center' class='colhead'>".($edit_action ? 'Edit forum <u>'.htmlsafechars($a3['name']).'</u>' : 'Add new Over forum')."</td></tr>
	<tr><td align='right' valign='top'>Over Forum name</td><td align='left'><input type='text' value='".($edit_action ? htmlsafechars($a3['name']) : '')."'name='name' size='40' /></td></tr>
	<tr><td align='right' valign='top'>Over Forum description</td><td align='left'><textarea rows='3' cols='38' name='description'>".($edit_action ? htmlsafechars($a3['description']) : '')."</textarea></td></tr>";

	$classes = "<select name='#name'>";
	for($i=UC_USER;$i<=UC_MAX;$i++)
		$classes .= "<option value='".$i."'>".get_user_class_name($i)."</option>";
	$classes .="</select>";
	
	if($edit_action)
	$htmlout .= "
	<tr><td align='right' valign='top'>Minimum class view</td><td align='left'>".str_replace(array('#name','value=\''.htmlsafechars($a3['min_class_view']).'\''),array('minclassview','value=\''.htmlsafechars($a3['min_class_view']).'\' selected=\'selected\''),$classes)."</td></tr>";
	else 
	$htmlout .= "
	<tr><td align='right' valign='top'>Minimum class view</td><td align='left'>".str_replace('#name','minclassview',$classes)."</td></tr>";
	$htmlout .= "<tr><td align='right' valign='top'>Over Forum rank</td>
	<td align='left'><select name='sort'>";
	for($i=0;$i<=$f_count+1;$i++)
	$htmlout .="<option value='".$i."' ".($edit_action && $a3['sort'] == $i ? 'selected=\'selected\'' : '').">".(int)$i."</option>";
	$htmlout .="</select></td></tr>
	<tr><td align='center' class='colhead' colspan='2'>".($edit_action ? "<input type='hidden' name='do' value='process_edit' /><input type='hidden' name='id' value='".(int)$a3['id']."'/><input type='submit' value='Edit forum' />" : "<input type='hidden' name='do' value='process_add' /><input type='submit' value='Add Over forum' />")."</td></tr>
	</table></form>";
	$htmlout .= "</div></div>";
	echo(stdhead('Over Forum manager').$htmlout.stdfoot());
}

?>
