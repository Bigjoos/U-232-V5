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
$htmlout = '';
$lang = array_merge($lang, load_language('ad_forum_manage'));

$id = isset($_GET['id']) && is_valid_id($_GET['id']) ? (int)$_GET['id'] : (isset($_POST['id']) && is_valid_id($_POST['id']) ? (int)$_POST['id'] : 0);
$v_do = array('edit','process_edit','process_add','delete','');
$do = isset($_GET['do']) && in_array($_GET['do'],$v_do) ? htmlsafechars($_GET['do']) : (isset($_POST['do']) && in_array($_POST['do'],$v_do) ? htmlsafechars($_POST['do']) : '');
$this_url = 'staffpanel.php?tool=forummanager&action=forummanager';
switch($do) {
case 'delete' : 
	if(!$id)
	stderr('Err','Fool what are you doing!?');
	if(sql_query('DELETE f.*,t.*,p.*,r.* FROM forums AS f LEFT JOIN topics AS t ON t.forum_id = f.id LEFT JOIN posts AS p ON p.topic_id = t.id  LEFT JOIN read_posts AS r ON r.topic_id = t.id WHERE f.id ='.sqlesc($id))) {
		header('Refresh:2; url='.$this_url);
		stderr('Success','Forum was deleted! wait till redirect');
	} else 
		stderr('Err','Something happened! Mysql Error '.((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
break;
case 'process_add' :
case 'process_edit' :

	foreach(array('forumname'=>1,'forumdescr'=>1,'overforum'=>1,'minclassread'=>0,'minclasswrite'=>0,'minclasscreate'=>0,'forumsort'=>0) as $key=>$empty_check) {
		if($empty_check && empty($_POST[$key]))
		stderr('Err','You need to fill all the fields!');
		else 
			$$key = sqlesc($_POST[$key]);
	}
	
	switch(end(explode('_',$do))){
		case 'add':
			$res = 'INSERT INTO forums(name, description, forum_id, min_class_read, min_class_write, min_class_create, sort) VALUES('.$forumname.', '.$forumdescr.', '.$overforum.', '.$minclassread.', '.$minclasswrite.', '.$minclasscreate.', '.$forumsort.')';
			$msg = 'Forum was added!Wait till redirect';
		break; 
		case 'edit':
			$res = 'UPDATE forums set name = '.$forumname.', description = '.$forumdescr.', forum_id = '.$overforum.', min_class_read = '.$minclassread.', min_class_write = '.$minclasswrite.', min_class_create = '.$minclasscreate.', sort = '.$forumsort.' WHERE id = '.sqlesc($id);
			$msg = 'Forum was edited!Wait till redirect';
		break;
	}
	if(sql_query($res)) {
		
		stderr('Success',$msg);
                header('Refresh:2; url='.$this_url);
	} else
		stderr('Err','Something happened! Mysql Error '.((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
break;
case 'edit' : 
default :
$htmlout .= "<div class='row'><div class='col-md-12'><h2>Forum Manager</h2>";

$r1 = sql_query('select f.name as f_name, f.id as fid, f.description,f.min_class_read,f.min_class_write, f.min_class_create, o.name as o_name,o.id as oid FROM forums as f LEFT JOIN over_forums as o ON f.forum_id = o.id ORDER BY f.sort') or  sqlerr(__FILE__,__LINE__);
$f_count = mysqli_num_rows($r1);
if(!$f_count)
$htmlout .= stdmsg('Err','There are no topics, maybe you should add some');
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
						<td class='colhead' align='left'>Name</td>
						<td class='colhead'>OverForum</td>
						<td class='colhead'>Read</td>
						<td class='colhead'>Write</td>
						<td class='colhead'>Create topic</td>
						<td class='colhead' colspan='2'>Modify</td>
					</tr>";
	while($a = mysqli_fetch_assoc($r1))
		$htmlout .="<tr onmouseover=\"this.bgColor='#999';\" onmouseout=\"this.bgColor='';\">
						<td align='left'><a href='forums.php?action=viewforum&amp;forumid=".(int)$a['fid']."'>".htmlsafechars($a['f_name'])."</a><br/><span class='small'>".htmlsafechars($a['description'])."</span></td>
						<td><a href='forums.php?action=viewforum&amp;forumid=".(int)$a['oid']."'>".htmlsafechars($a['o_name'])."</a></td>
						<td>".get_user_class_name($a['min_class_read'])."</td>
						<td>".get_user_class_name($a['min_class_write'])."</td>
						<td>".get_user_class_name($a['min_class_create'])."</td>
						<td><a href='".$this_url."&amp;do=edit&amp;id=".(int)$a['fid']."#edit'>Edit</a></td>
						<td><a href='javascript:confirm_delete(".(int)$a['fid'].");'>Delete</a></td>
					</tr>";
	$htmlout .="</table>";
}
	$edit_action = false;
	if($do == 'edit' && !$id)
		$htmlout .= stdmsg('Edit action','Im not sure what are you trying to do');
	if($do =='edit' && $id) {
		$r3 = sql_query('select f.name as f_name , f.id as fid , f.description , f.min_class_read , f.min_class_write , f.min_class_create, f.forum_id, f.sort FROM forums as f WHERE f.id ='.sqlesc($id)) or sqlerr(__FILE__,__LINE__);
		if(!mysqli_num_rows($r3))
			$htmlout .= stdmsg('Edit action','The forum your looking for does not exists');
		else {
			$edit_action = true;
			$a3 = mysqli_fetch_assoc($r3);
		}
	}
	
$htmlout .= "<div class='row'><div class='col-md-12'><h2>".($edit_action ? 'Edit forum <u>'.htmlsafechars($a3['f_name']).'</u>' : 'Add new forum')."</h2>";
$htmlout .= "<form action='".$this_url."' method='post'>
	<table class='table table-bordered'>
	<tr><td colspan='2' align='center' class='colhead'>".($edit_action ? 'Edit forum <u>'.htmlsafechars($a3['f_name']).'</u>' : 'Add new forum')."</td></tr>
	<tr><td align='right' valign='top'>Forum name</td><td align='left'><input type='text' value='".($edit_action ? htmlsafechars($a3['f_name']) : '')."'name='forumname' size='40' /></td></tr>
	<tr><td align='right' valign='top'>Forum description</td><td align='left'><textarea rows='3' cols='38' name='forumdescr'>".($edit_action ? htmlsafechars($a3['description']) : '')."</textarea></td></tr>";
	$htmlout .= "<tr><td align='right' valign='top'>Overforum</td><td align='left'><select name='overforum'>";
	$r2 = sql_query('SELECT id,name FROM over_forums ORDER BY name') or sqlerr(__FILE__,__LINE__);
	while($a = mysqli_fetch_assoc($r2))
		$htmlout .="<option value='".(int)$a['id']."' ".($edit_action && ($a['id'] == $a3['forum_id']) ? 'selected=\'selected\'' : '').">".htmlsafechars($a['name'])."</option>";
	$htmlout .= "</select></td></tr>";
	$classes = "<select name='#name'>";
	for($i=UC_USER;$i<=UC_MAX;$i++)
		$classes .= "<option value='".$i."'>".get_user_class_name($i)."</option>";
	$classes .="</select>";
	if($edit_action)
	$htmlout .= "
	<tr><td align='right' valign='top'>Minim class read</td><td align='left'>".str_replace(array('#name','value=\''.$a3['min_class_read'].'\''),array('minclassread','value=\''.htmlsafechars($a3['min_class_read']).'\' selected=\'selected\''),$classes)."</td></tr>
	<tr><td align='right' valign='top'>Minim class write</td><td align='left'>".str_replace(array('#name','value=\''.$a3['min_class_write'].'\''),array('minclasswrite','value=\''.htmlsafechars($a3['min_class_write']).'\' selected=\'selected\''),$classes)."</td></tr>
	<tr><td align='right' valign='top'>Minim class create</td><td align='left'>".str_replace(array('#name','value=\''.$a3['min_class_create'].'\''),array('minclasscreate','value=\''.htmlsafechars($a3['min_class_create']).'\' selected=\'selected\''),$classes)."</td></tr>";
	else 
	$htmlout .= "
	<tr><td align='right' valign='top'>Minim class read</td><td align='left'>".str_replace('#name','minclassread',$classes)."</td></tr>
	<tr><td align='right' valign='top'>Minim class write</td><td align='left'>".str_replace('#name','minclasswrite',$classes)."</td></tr>
	<tr><td align='right' valign='top'>Minim class create</td><td align='left'>".str_replace('#name','minclasscreate',$classes)."</td></tr>";
	$htmlout .= "<tr><td align='right' valign='top'>Forum rank</td><td align='left'><select name='forumsort'>";
		for($i=0;$i<=$f_count+1;$i++)
		$htmlout .="<option value='".$i."' ".($edit_action && $a3['sort'] == $i ? 'selected=\'selected\'' : '').">".$i."</option>";
	$htmlout .="</select></td></tr>
	<tr><td align='center' class='colhead' colspan='2'>".($edit_action ? "<input type='hidden' name='do' value='process_edit' /><input type='hidden' name='id' value='".(int)$a3['fid']."'/><input type='submit' value='Edit forum' />" : "<input type='hidden' name='do' value='process_add' /><input type='submit' value='Add forum' />")."</td></tr>
	</table></form>";
$htmlout .= "</div></div>";
	
	echo(stdhead('Forum manager').$htmlout.stdfoot());
}

?>
