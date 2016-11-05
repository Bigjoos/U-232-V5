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
if(XBT_TRACKER == true) {
$htmlout.= "
        <li>
        <a class='sa-tooltip' href='index.php#'><b class='btn btn-success btn-sm'>XBT TRACKER</b>
		<span class='custom info alert alert-success'><em>XBT TRACKER</em>
      <br />When XBT TRACKER is running -<br /> There is no alerts for crazyhour, happyhour, or active freeslots :-(<br /></span></a></li>";
} else {
/** karma contribution alert hack **/
$fpoints = $dpoints = $hpoints = $freeleech_enabled = $double_upload_enabled = $half_down_enabled ='';
if(($scheduled_events = $mc1->get_value('freecontribution_datas_alerts_')) === false) {
    $scheduled_events = mysql_fetch_all("SELECT * from `events` ORDER BY `startTime` DESC LIMIT 3;", array());
    $mc1->cache_value('freecontribution_datas_alerts_', $scheduled_events, 3 * 86400);
    }

    if (is_array($scheduled_events)){
        foreach ($scheduled_events as $scheduled_event) {
            if (is_array($scheduled_event) && array_key_exists('startTime', $scheduled_event) &&
                array_key_exists('endTime', $scheduled_event)){
                $startTime = 0;
                $endTime = 0;
                $startTime = $scheduled_event['startTime'];
                $endTime = $scheduled_event['endTime'];
                if (TIME_NOW < $endTime && TIME_NOW > $startTime){
                    if (array_key_exists('freeleechEnabled', $scheduled_event)) {
                        $freeleechEnabled = $scheduled_event['freeleechEnabled'];
                        if ($scheduled_event['freeleechEnabled']){
                            $freeleech_start_time = $scheduled_event['startTime'];
                            $freeleech_end_time = $scheduled_event['endTime'];
                            $freeleech_enabled = true;
                        }
                    }
                    if (array_key_exists('duploadEnabled', $scheduled_event)){
                        $duploadEnabled = $scheduled_event['duploadEnabled'];
                        if ($scheduled_event['duploadEnabled']){
                            $double_upload_start_time = $scheduled_event['startTime'];
                            $double_upload_end_time = $scheduled_event['endTime'];
                            $double_upload_enabled = true;
                        }
                    }
                    if (array_key_exists('hdownEnabled', $scheduled_event)) {
                        $hdownEnabled = $scheduled_event['hdownEnabled'];    
                        if ($scheduled_event['hdownEnabled']){
                            $half_down_start_time = $scheduled_event['startTime'];
                            $half_down_end_time = $scheduled_event['endTime'];
                            $half_down_enabled = true;
                        }
                        }
                        }
                        }
                        }
                        }
//=== get total points
//$target_fl = 30000;
if(($freeleech_counter = $mc1->get_value('freeleech_counter_alerts_')) === false) {
	$total_fl = sql_query('SELECT SUM(pointspool) AS pointspool, points FROM bonus WHERE id =11');
    $fl_total_row = mysqli_fetch_assoc($total_fl);
    $percent_fl = number_format($fl_total_row['pointspool'] / $fl_total_row['points'] * 100, 2);
    $mc1->cache_value('freeleech_counter_alerts_', $percent_fl, 0);
    } else
    $percent_fl = $freeleech_counter;
			switch ($percent_fl)
			{
	   			case $percent_fl >= 90:
			$font_color_fl = '<strong>'.number_format($percent_fl).' %</strong>';
				break; 
				   case $percent_fl >= 80:
			$font_color_fl = '<strong>'.number_format($percent_fl).' %</strong>';
				break;
				   case $percent_fl >= 70:
			$font_color_fl = '<strong>'.number_format($percent_fl).' %</strong>';
				break;
				   case $percent_fl >= 50:
			$font_color_fl = '<strong>'.number_format($percent_fl).' %</strong>';
				break;
				   case $percent_fl >= 40:
			$font_color_fl  = '<strong>'.number_format($percent_fl).' %</strong>';
				break;
				   case $percent_fl >= 30:
			$font_color_fl = '<strong>'.number_format($percent_fl).' %</strong>';
				break;
				   case $percent_fl >= 20:
			$font_color_fl = '<strong>'.number_format($percent_fl).' %</strong>';
				break;				
				   case $percent_fl < 20:
			$font_color_fl = '<strong>'.number_format($percent_fl).' %</strong>';
				break;
			}
//=== get total points
//$target_du = 30000;
if(($doubleupload_counter = $mc1->get_value('doubleupload_counter_alerts_')) === false) {
	$total_du = sql_query('SELECT SUM(pointspool) AS pointspool, points FROM bonus WHERE id =12');
    $du_total_row = mysqli_fetch_assoc($total_du);
    $percent_du = number_format($du_total_row['pointspool'] / $du_total_row['points'] * 100, 2);
    $mc1->cache_value('doubleupload_counter_alerts_', $percent_du, 0);
    } else
    $percent_du = $doubleupload_counter;
        switch ($percent_du)
			{
	   			case $percent_du >= 90:
			$font_color_du = '<strong>'.number_format($percent_du).' %</strong>';
				break; 
				   case $percent_du >= 80:
			$font_color_du = '<strong>'.number_format($percent_du).' %</strong>';
				break;
				   case $percent_du >= 70:
			$font_color_du = '<strong>'.number_format($percent_du).' %</strong>';
				break;
				   case $percent_du >= 50:
			$font_color_du = '<strong>'.number_format($percent_du).' %</strong>';
				break;
				   case $percent_du >= 40:
			$font_color_du  = '<strong>'.number_format($percent_du).' %</strong>';
				break;
				   case $percent_du >= 30:
			$font_color_du = '<strong>'.number_format($percent_du).' %</strong>';
				break;
				   case $percent_du >= 20:
			$font_color_du = '<strong>'.number_format($percent_du).' %</strong>';
				break;				
				   case $percent_du < 20:
			$font_color_du = '<strong>'.number_format($percent_du).' %</strong>';
            break;
			}
//=== get total points
//$target_hd = 30000;
if(($halfdownload_counter = $mc1->get_value('halfdownload_counter_alerts_')) === false) {
	$total_hd = sql_query('SELECT SUM(pointspool) AS pointspool, points FROM bonus WHERE id =13');
    $hd_total_row = mysqli_fetch_assoc($total_hd);
    $percent_hd = number_format($hd_total_row['pointspool'] / $hd_total_row['points'] * 100, 2);
    $mc1->cache_value('halfdownload_counter_alerts_', $percent_hd, 0);
    } else
    $percent_hd = $halfdownload_counter;
        switch ($percent_hd)
			{
	   			case $percent_hd >= 90:
			$font_color_hd = '<strong>'.number_format($percent_hd).'&nbsp;%</strong>';
				break; 
				   case $percent_hd >= 80:
			$font_color_hd = '<strong>'.number_format($percent_hd).'&nbsp;%</strong>';
				break;
				   case $percent_hd >= 70:
			$font_color_hd = '<strong>'.number_format($percent_hd).'&nbsp;%</strong>';
				break;
				   case $percent_hd >= 50:
			$font_color_hd = '<strong>'.number_format($percent_hd).'&nbsp;%</strong>';
				break;
				   case $percent_hd >= 40:
			$font_color_hd = '<strong>'.number_format($percent_hd).'&nbsp;%</strong>';
				break;
				   case $percent_hd >= 30:
			$font_color_hd = '<strong>'.number_format($percent_hd).'&nbsp;%</strong>';
				break;
				   case $percent_hd >= 20:
			$font_color_hd = '<strong>'.number_format($percent_hd).'&nbsp;%</strong>';
				break;				
				   case $percent_hd < 20:
			$font_color_hd = '<strong>'.number_format($percent_hd).'&nbsp;%</strong>';
            break;
			}

    if($freeleech_enabled){
        $fstatus = "<strong>&nbsp;ON&nbsp;</strong>";
    } else {
        $fstatus = $font_color_fl ."";
    }
    if($double_upload_enabled){
        $dstatus = "<strong>&nbsp;ON&nbsp;</strong>";
    } else {
        $dstatus = $font_color_du ."";
    }
    if($half_down_enabled){
        $hstatus = "<strong>&nbsp;ON&nbsp;</strong>";
    } else {
        $hstatus = $font_color_hd ."";
    }     
   $htmlout .="<li><a class='sa-tooltip' href='./mybonus.php'><b class='btn btn-success btn-sm'>Karma Contribution's</b><span class='custom info alert alert-success'>Freeleech&nbsp;[&nbsp;";
            if($freeleech_enabled){
            $htmlout .="<strong>&nbsp;ON</strong>&nbsp;".get_date($freeleech_start_time, 'DATE') . "&nbsp;-&nbsp;" .get_date($freeleech_end_time, 'DATE');
            } else {
            $htmlout .="<strong>{$fstatus}</strong>";
            }
            $htmlout .="&nbsp;]<br />";
    
            $htmlout .="DoubleUpload&nbsp;[&nbsp;";
            if($double_upload_enabled){
            $htmlout .="<strong>&nbsp;ON</strong>&nbsp;".get_date($double_upload_start_time, 'DATE') . "&nbsp;-&nbsp;" .get_date($double_upload_end_time, 'DATE');
            } else {
            $htmlout .="<strong>{$dstatus}</strong>";
            }
            $htmlout .="&nbsp;]<br />";
            
            $htmlout .="Half Download&nbsp;[&nbsp;";
            if($half_down_enabled){
            $htmlout .="<strong>&nbsp;ON</strong>&nbsp;".get_date($half_down_start_time, 'DATE') . "&nbsp;-&nbsp;" .get_date($half_down_end_time, 'DATE');
            } else {
            $htmlout .="<strong>{$hstatus}</strong>";
            }
            $htmlout .="&nbsp;]</span></a></li>";
}
//=== karma contribution alert end
// End Class
// End File
