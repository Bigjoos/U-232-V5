<?php
//|------------------------------------------------------- |\\
//|search for subtiles on http://www.opensubtitles.org/    |\\
//|made by putyn @tbdev 27/2/2009                          |\\
//|--------------------------------------------------------|\\
require_once("function_menu.php");
require_once("functions.php");

  $pager="";
	$name = (isset($_GET["sub_name"]) ? $_GET["sub_name"] : "");
		if($name)
	$pager = "sub_name=".$name."&amp;";
	$searchby = (isset($_GET["searchby"]) ? $_GET["searchby"] : "");
		if($searchby)
	$pager .="searchby=".$searchby."&amp;";
	$lang = (isset($_GET["lang"]) ? $_GET["lang"] : "all");
		if($lang)
	$pager .="lang=".$lang."&amp;";
	$fps = (isset($_GET["fps"]) ? $_GET["fps"] : "");
		if($fps)
	$pager .="fps=".$fls."&amp;";
	$format = (isset($_GET["format"]) ? $_GET["format"] : "");
		if($format)
	$pager .="format=".$format."&amp;";
	$cds = (isset($_GET["cds"]) ? 0+$_GET["cds"] : "");
		if($cds)
	$pager .="cds=".$cds."&amp;";
	$offset = (isset($_GET["offset"]) ? 0+$_GET["offset"] : "");
	
		if($searchby == "name")
	$name = str_replace(array(".","/","\"","!","-","+","_","@","#","$","%","&","^","(",")","*")," ",$name);

	


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Subtitle Search</title>
<style type="text/css">
body {
	font-family: "tahoma", "arial", "helvetica", "sans-serif";
	font-size: 9pt;
	background-color: #333333;
	color:#ffffff;
	font-weight:bold;
	padding-top:15px;
	padding-bottom:20px;
}
fieldset {
	border: 1px solid #666666;
	width:40%;
}
legend {
	border: none;
	padding:5px 5px 5px 5px
}
input, select, textarea {
	font-size: 8pt;
	background: #CCCCCC;
	color:#333333;
	border: solid 1px #666666;
}
input:hover, select:hover, textarea:hover {
	border: solid 1px #999999;
}
input[type=button], input[type=submit], input[type=reset] {
	font-weight:bold;
	margin:5px;
}
a:link, a:hover , a:visited {
	color:#FFFFFF;
}
.releasename {font-size: 8pt;color:#cccccc;}
.sublink {
		border:1px solid #222222;
		text-decoration:none;
		background-color:#999999;
		color:#333333;
		margin:4px
		font-weight:bold;
		padding: 0px 5px;
		width: 15px; height:15px;
	}
.sublink:hover, a.sublink:active{
		border:1px solid #cccccc;
		color:#333333;
}
.sublink-active {
		border:1px solid #cccccc;
		background-color:#999999;
		margin:4px
		font-weight:bold;
		padding: 0px 5px;
	}
</style>
</head>
<body>
<div align="center">
<fieldset>
<legend>Search for subtitle</legend>
<form action=" " method="get" >
  <table width="40%" cellpadding="10" border="1" cellspacing="0" style="border-collapse:collapse" align="center">
    <tr>
      <td nowrap="nowrap" align="center">Search </td>
      <td align="left" colspan="7" nowrap="nowrap"><input type="text" name="sub_name" value="<?php echo ($name ? $name : "")?>" size="80" />
        &nbsp;by&nbsp;
        <select name="searchby">
          <option value="name" <?php echo ($searchby == "name" ? "selected=\"selected\"" : "")?>>Name</option>
          <option value="imdb" <?php echo ($searchby == "imdb" ? "selected=\"selected\"" : "")?>>IMDb id</option>
        </select></td>
    </tr>
    <tr>
      <td nowrap="nowrap" align="center">Subtitle format</td>
      <td><?php echo (build_menu("format",$format_menu,$format))?></td>
      <td nowrap="nowrap" align="center">Cds</td>
      <td><?php echo (build_menu("cds",$cds_menu,$cds))?></td>
      <td nowrap="nowrap" align="center">Language</td>
      <td><?php echo (build_menu("lang",$lang_menu,$lang))?></td>
      <td nowrap="nowrap" align="center">FPS</td>
      <td><?php echo (build_menu("fps",$fps_menu,$fps))?></td>
    </tr>
	<tr><td align="center" colspan="8"><input type="submit" value="Search" /></td></tr>
  </table>
</form>
</fieldset>
<br/>

<?php
	if(!empty($name))
	{
		$search= xmlconvert(requestXML($name,$searchby,$lang,$cds,$format,$fps,$offset));
		print(build_result($search,"?".$pager));
	}

?>
</div>
</body>
</html>
