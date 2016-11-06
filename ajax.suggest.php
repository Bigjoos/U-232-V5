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

require_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'include'.DIRECTORY_SEPARATOR.'bittorrent.php');
require_once INCL_DIR.'user_functions.php';

dbconn(true);
loggedinorreturn();

if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')

{
		$orderby = 'ORDER BY ';			
		$order = array(
							0 => 'seeders',
							1 => 'leechers',
							2 => 'id',
							3 => 'size',
							4 => 'hits',
							5 => 'vip'
						);
	$outhtml = "<style>.hover:hover{color:".(isset($_POST["color"]) ? $_POST["color"] : 'green')."}</style><table border='0' style='width:100%;border:0px;' ><tr><td>";		
		if(empty($_POST['search'])){die(false);}
		$wh = isset($_POST["order"]) ? (int)$_POST["order"] : 2;
		$orderby .= isset($wh) && array_key_exists($wh,$order) ? sqlesc($order[$wh]) : 'id';
		$limit = isset($_POST["limit"]) ? (int)$_POST["limit"] : 10;
		$where = isset($_POST["search"]) ? sprintf('WHERE name LIKE \'%s\'','%'.$_POST["search"].'%') : die(false);
		$query = "SELECT id, name FROM torrents $where $orderby LIMIT $limit";
    	$res = sql_query("SELECT COUNT(id) FROM torrents $where") or sqlerr(__FILE__, __LINE__);
        $row = mysqli_fetch_row($res);
        $count = $row[0];
	    if($count > 0)
	    {
		   $res = sql_query($query) or sqlerr(__FILE__, __LINE__);$ye = '';$i=1;
	       while ($row = mysqli_fetch_assoc($res)) 
		   {
				if(empty($row['name'])){
                                  die(false);
}
				$outhtml .="$i : <a href='details.php?id=".(int)$row['id']."' class='hover'>".htmlsafechars($row['name'])."</a><br/>";
				$i++;
					
		   }
				echo $outhtml .= "</td></tr></table>";
        }
        else{die(false);}
}
else
{
	header("Location: {$INSTALLER09['baseurl']}/index.php");
}
die(false);

?>
