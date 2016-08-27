<?php
require_once (dirname(__FILE__) . DIRECTORY_SEPARATOR . '../include' . DIRECTORY_SEPARATOR . 'bittorrent.php');
require_once (INCL_DIR . 'user_functions.php');
dbconn(false);
loggedinorreturn();

if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')
{
	
	$modes = array('torrent','forum');
	$htmlout = $att = '';
	
	if(isset($_POST['search']) && !empty($_POST['search']) && isset($_POST['qsearch']) && in_array($_POST['qsearch'],$modes))
	{	
		
		$cleansearchstr = searchfield(sqlesc($_POST['search']));
		$i = 1;
		if($_POST['qsearch'] == 'torrent')
		{
			$query = sql_query("SELECT * FROM torrents WHERE name LIKE '%$cleansearchstr%' AND visible = 'yes' AND banned = 'no' AND nuked = 'no' ORDER BY id LIMIT 5");
		    $count = $query->num_rows;
			if(!$count){die('No Torrent found by that search!');}
			while($res = mysqli_fetch_assoc($query))
			{
				$att .="<div class='tr'>
								<div class='td'>$i</div>
								<div class='td'><a href='details.php?id=".(int)$res['id']."'>".htmlsafechars($res['name'])."</a></div>
								<div class='tdclear'></div>
							</div>";
			$i++;
			}
		}
		elseif($_POST['qsearch'] == 'forum')
		{
			$query = sql_query("SELECT forum.*,topic.*,topic.id as tid FROM topics as topic INNER JOIN forums as forum ON topic.forum_id = forum.id AND forum.min_class_read >= 0 AND topic.topic_name LIKE '%$cleansearchstr%' ORDER BY tid DESC LIMIT 5");
			$count = $query->num_rows;
			if(!$count){die('No topic found by that search!');}
			while($res = mysqli_fetch_assoc($query))
			{
				$att .="<div class='tr'>
								<div class='td'>$i</div>
								<div class='td'><a href='details.php?id=".(int)$res['id']."' class='colhead'>".htmlsafechars($res['name'])."</a></div>
								<div class='tdclear'></div>
							</div>";
			$i++;
			}
		}
			$htmlout .="
						<style>
						.t {display: table; }
						.tr {display: table-row;}
						.tdclear{height:5px;content:''}
						.td {display:table-cell; vertical-align:top;padding-right:5px;}
						</style>
						<div class='t'>						
							$att
						</div>";
			echo $htmlout;
	}
	else
	{
   echo "Please Enter something to search";
	}	
}
?>
