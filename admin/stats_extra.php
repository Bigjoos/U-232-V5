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
$lang = array_merge($lang, load_language('ad_stats_extra'));
$inbound = array_merge($_GET, $_POST);
if (!isset($inbound['mode'])) $inbound['mode'] = '';
$form_code = '';
$month_names = array(
    1 => $lang['stats_ex_jan'],
    $lang['stats_ex_jan'],
    $lang['stats_ex_feb'],
	$lang['stats_ex_mar'],
	$lang['stats_ex_apr'],
	$lang['stats_ex_may'],
	$lang['stats_ex_jun'],
	$lang['stats_ex_jul'],
	$lang['stats_ex_sep'],
	$lang['stats_ex_oct'],
	$lang['stats_ex_nov'],
	$lang['stats_ex_dec']
);
switch ($inbound['mode']) {
case 'show_reg':
    result_screen('reg');
    break;

case 'show_topic':
    result_screen('topic');
    break;

case 'topic':
    main_screen('topic');
    break;

case 'show_comms':
    result_screen('comms');
    break;

case 'comms':
    main_screen('comms');
    break;

case 'show_torrents':
    result_screen('torrents');
    break;

case 'torrents':
    main_screen('torrents');
    break;

case 'show_reps':
    result_screen('reps');
    break;

case 'reps':
    main_screen('reps');
    break;

case 'show_post':
    result_screen('post');
    break;

case 'post':
    main_screen('post');
    break;

case 'show_msg':
    result_screen('msg');
    break;

case 'msg':
    main_screen('msg');
    break;

case 'show_views':
    show_views();
    break;

case 'views':
    main_screen('views');
    break;

default:
    main_screen('reg');
    break;
}
function show_views()
{
    global $inbound, $month_names, $lang;
    $page_title = $lang['stats_ex_ptitle'];
    $page_detail = $lang['stats_ex_pdetail'];
    /* This function not available in this version, you need tbdev2010 */
    stderr($lang['stats_ex_stderr'], $lang['stats_ex_stderr1']);
    if (!checkdate($inbound['to_month'], $inbound['to_day'], $inbound['to_year'])) {
        stderr($lang['stats_ex_ustderr'], $lang['stats_ex_ustderr1']);
    }
    if (!checkdate($inbound['from_month'], $inbound['from_day'], $inbound['from_year'])) {
        stderr($lang['stats_ex_ustderr'], $lang['stats_ex_dstderr']);
    }
    $to_time = mktime(12, 0, 0, $inbound['to_month'], $inbound['to_day'], $inbound['to_year']);
    $from_time = mktime(12, 0, 0, $inbound['from_month'], $inbound['from_day'], $inbound['from_year']);
    $human_to_date = getdate($to_time);
    $human_from_date = getdate($from_time);
    $sql = array(
        'from_time' => $from_time,
        'to_time' => $to_time,
        'sortby' => $inbound['sortby']
    );
    $q = sql_query("SELECT SUM(t.views) as result_count, t.forumid, f.name as result_name
					FROM topics t
					LEFT JOIN forums f ON (f.id=t.forumid)
					WHERE t.start_date > '{$sql['from_time']}'
					AND t.start_date < '{$sql['to_time']}'
					GROUP BY t.forumid
					ORDER BY result_count {$sql['sortby']}") or sqlerr(__FILE__, __LINE__);
    $running_total = 0;
    $max_result = 0;
    $results = array();
    $menu = make_side_menu();
    $heading = "{$lang['stats_ex_topicv']} ({$human_from_date['mday']} {$month_names[$human_from_date['mon']]} {$human_from_date['year']} {$lang['stats_ex_topict']} {$human_to_date['mday']} {$month_names[$human_to_date['mon']]} {$human_to_date['year']})";
    $htmlout = "<div class='row'><div class='col-md-12'>{$lang['stats_ex_center']}</div></div><br>
<div class='row'><div class='col-md-12'>{$menu}</div></div><br>
<div><table class='table table-bordered'>
		<tr>
    <td colspan='3' align='left'>{$heading}</td>
    </tr>
		<tr>
    <td>{$lang['stats_ex_date']}</td>
    <td>{$lang['stats_ex_result']}</td>
    <td>{$lang['stats_ex_count']}</td>
    </tr>";
    if (mysqli_num_rows($q)) {
        while ($row = mysqli_fetch_assoc($q)) {
            if ($row['result_count'] > $max_result) {
                $max_result = $row['result_count'];
            }
            $running_total+= $row['result_count'];
            $results[] = array(
                'result_name' => $row['result_name'],
                'result_count' => $row['result_count'],
            );
        }
        foreach ($results as $data) {
            $img_width = intval(($data['result_count'] / $max_result) * 100 - 8);
            if ($img_width < 1) {
                $img_width = 1;
            }
            $img_width.= '%';
            $htmlout.= "<tr>
    			<td valign='middle'>$date</td>
    			<td valign='middle'><img src='{$INSTALLER09['pic_base_url']}/bar_left.gif' border='0' width='4' height='11' align='middle' alt='' /><img src='{$INSTALLER09['pic_base_url']}/bar.gif' border='0' width='$img_width' height='11' align='middle' alt='' /><img src='{$INSTALLER09['pic_base_url']}/bar_right.gif' border='0' width='4' height='11' align='middle' alt='' /></td>
					<td valign='middle'><center>{$data['result_count']}</center></td>
					</tr>";
        }
        $htmlout.= "<tr>
<td>&nbsp;</td>
<td><div align='right'><b>{$lang['stats_ex_total']}</b></div></td>
<td><center><b>{$running_total}</b></center></td>
</tr>";
    } else {
        $htmlout.= "<tr><td colspan='3' align='center'>{$lang['stats_ex_noresult']}</td></tr>";
    }
    $htmlout.= '</table></div></div>';
    echo stdhead($page_title) . $htmlout . stdfoot();
}
function result_screen($mode = 'reg')
{
    global $INSTALLER09, $inbound, $month_names, $lang;
    $page_title = $lang['stats_ex_center_result'];
    $page_detail = "&nbsp;";
    if (!checkdate($inbound['to_month'], $inbound['to_day'], $inbound['to_year'])) {
        stderr($lang['stats_ex_ustderr'], $lang['stats_ex_ustderr1']);
    }
    if (!checkdate($inbound['from_month'], $inbound['from_day'], $inbound['from_year'])) {
        stderr($lang['stats_ex_ustderr'], $lang['stats_ex_dstderr']);
    }
    $to_time = mktime(0, 0, 0, $inbound['to_month'], $inbound['to_day'], $inbound['to_year']);
    $from_time = mktime(0, 0, 0, $inbound['from_month'], $inbound['from_day'], $inbound['from_year']);
    $human_to_date = getdate($to_time);
    $human_from_date = getdate($from_time);
    if ($mode == 'reg') {
        $table = $lang['stats_ex_registr'];
        $sql_table = 'users';
        $sql_field = 'added';
        $page_detail = $lang['stats_ex_rdetails'];
    } else if ($mode == 'topic') {
        $table = $lang['stats_ex_newtopicst'];
        $sql_table = 'topics';
        $sql_field = 'added';
        $page_detail = $lang['stats_ex_topdetails'];
    } else if ($mode == 'post') {
        $table = $lang['stats_ex_poststs'];
        $sql_table = 'posts';
        $sql_field = 'added';
        $page_detail = $lang['stats_ex_postdetails'];
    } else if ($mode == 'msg') {
        $table = $lang['stats_ex_pmsts'];
        $sql_table = 'messages';
        $sql_field = 'added';
        $page_detail = $lang['stats_ex_pmdetails'];
    } else if ($mode == 'comms') {
        $table = $lang['stats_ex_comsts'];
        $sql_table = 'comments';
        $sql_field = 'added';
        $page_detail = $lang['stats_ex_cdetails'];
    } else if ($mode == 'torrents') {
        $table = $lang['stats_ex_torrsts'];
        $sql_table = 'torrents';
        $sql_field = 'added';
        $page_detail = $lang['stats_ex_tordetails'];
    } else if ($mode == 'reps') {
        $table = $lang['stats_ex_repsts'];
        $sql_table = 'reputation';
        $sql_field = 'dateadd';
        $page_detail = $lang['stats_ex_repdetails'];
    }
    switch ($inbound['timescale']) {
    case 'daily':
        $sql_date = "%w %U %m %Y";
        $php_date = "F jS - Y";
        break;

    case 'monthly':
        $sql_date = "%m %Y";
        $php_date = "F Y";
        break;

    default:
        // weekly
        $sql_date = "%U %Y";
        $php_date = " [F Y]";
        break;
    }
    $sort_by = ($inbound['sortby'] == 'DESC') ? 'DESC' : 'ASC';
    $sql = array(
        'from_time' => $from_time,
        'to_time' => $to_time,
        'sortby' => $sort_by,
        'sql_field' => $sql_field,
        'sql_table' => $sql_table,
        'sql_date' => $sql_date
    );
    $q1 = sql_query("SELECT MAX({$sql['sql_field']}) as result_maxdate,
				 COUNT(*) as result_count,
				 DATE_FORMAT(from_unixtime({$sql['sql_field']}),'{$sql['sql_date']}') AS result_time
				 FROM {$sql['sql_table']}
				 WHERE {$sql['sql_field']} > '{$sql['from_time']}'
				 AND {$sql['sql_field']} < '{$sql['to_time']}'
				 GROUP BY result_time
				 ORDER BY {$sql['sql_field']} {$sql['sortby']}");
    $running_total = 0;
    $max_result = 0;
    $results = array();
    $heading = ucfirst($inbound['timescale']) . " $table ({$human_from_date['mday']} {$month_names[$human_from_date['mon']]} {$human_from_date['year']} to {$human_to_date['mday']} {$month_names[$human_to_date['mon']]} {$human_to_date['year']})";
    $menu = make_side_menu();
    $htmlout = "<div>
      <div class='row'><div class='col-md-12'><h2 class='text-center'>{$lang['stats_ex_center']}</h2></div></div><br>
      <div class='row'><div class='col-md-12'>{$menu}</div></div><br>
      <div class='row'><div class='col-md-12'><table class='table table-bordered'>
		<tr>
    <td colspan='3' align='left'>{$heading}<br />{$page_detail}</td>
    </tr><tr>
    <td>{$lang['stats_ex_date']}</td>
    <td>{$lang['stats_ex_result']}</td>
    <td>{$lang['stats_ex_count']}</td>
    </tr>";
    if (mysqli_num_rows($q1)) {
        while ($row = mysqli_fetch_assoc($q1)) {
            if ($row['result_count'] > $max_result) {
                $max_result = $row['result_count'];
            }
            $running_total+= $row['result_count'];
            $results[] = array(
                'result_maxdate' => $row['result_maxdate'],
                'result_count' => $row['result_count'],
                'result_time' => $row['result_time'],
            );
        }
        foreach ($results as $data) {
            $img_width = intval(($data['result_count'] / $max_result) * 100 - 8);
            if ($img_width < 1) {
                $img_width = 1;
            }
            $img_width.= '%';
            if ($inbound['timescale'] == 'weekly') {
                $date = "Week #" . strftime("%W", $data['result_maxdate']) . date($php_date, $data['result_maxdate']);
            } else {
                $date = date($php_date, $data['result_maxdate']);
            }
            $htmlout.= "<tr>
    			<td>$date</td>
    			<td><img src='{$INSTALLER09['pic_base_url']}/bar_left.gif' border='0' width='4' height='11' align='middle' alt='' /><img src='{$INSTALLER09['pic_base_url']}/bar.gif' border='0' width='$img_width' height='11' align='middle' alt='' /><img src='{$INSTALLER09['pic_base_url']}/bar_right.gif' border='0' width='4' height='11' align='middle' alt='' /></td>
					<td>{$data['result_count']}</td>
					</tr>";
        }
        $htmlout.= "<tr>
<td>&nbsp;</td>
<td><div align='right'><b>{$lang['stats_ex_total']}</b></div></td>
<td><b>{$running_total}</b></td>
</tr>";
    } else {
        $htmlout.= "<tr><td colspan='3' align='center'>{$lang['stats_ex_noresult']}</td></tr>";
    }
    $htmlout.= '</table></div></div>';
    echo stdhead($page_title) . $htmlout . stdfoot();
}
function main_screen($mode = 'reg')
{
    global $INSTALLER09, $lang;
    $page_title = $lang['stats_ex_center'];
    $page_detail = "{$lang['stats_ex_details_main']}<br />{$lang['stats_ex_details_main1']}";
    if ($mode == 'reg') {
        $form_code = 'show_reg';
        $table = "<div class='row'><div class='col-md-12'>{$lang['stats_ex_registr']}</div></div>";
    } else if ($mode == 'topic') {
        $form_code = 'show_topic';
        $table = $lang['stats_ex_newtopicst'];
    } else if ($mode == 'post') {
        $form_code = 'show_post';
        $table = "<div class='row'><div class='col-md-12'>{$lang['stats_ex_poststs']}</div></div>";
    } else if ($mode == 'msg') {
        $form_code = 'show_msg';
        $table = "<div class='row'><div class='col-md-12'>{$lang['stats_ex_pmsts']}</div></div>";
    } else if ($mode == 'views') {
        $form_code = 'show_views';
        $table = "<div class='row'><div class='col-md-12'>{$lang['stats_ex_topicviewsts']}</div></div>";
    } else if ($mode == 'comms') {
        $form_code = 'show_comms';
        $table = "<div class='row'><div class='col-md-12'>{$lang['stats_ex_comsts']}</div></div>";
    } else if ($mode == 'torrents') {
        $form_code = 'show_torrents';
        $table = "<div class='row'><div class='col-md-12'>{$lang['stats_ex_torrsts']}</div></div>";
    } else if ($mode == 'reps') {
        $form_code = 'show_reps';
        $table = "<div class='row'><div class='col-md-12'>{$lang['stats_ex_repsts']}</div></div>";
    }
    $old_date = getdate(time() - (3600 * 24 * 90));
    $new_date = getdate(time() + (3600 * 24));
    $menu = make_side_menu();
    $htmlout = "
    <div class='well'><div class='row'><div class='col-md-12'><h2 class='text-center'>{$lang['stats_ex_center']}</h2></div></div><br><div class='row'><div class='col-md-12'>{$menu}</div></div><br><div class='row'><div class='col-md-12'>
    <form action='{$INSTALLER09['baseurl']}/staffpanel.php?tool=stats_extra&amp;action=stats_extra' method='post' name='StatsForm'>
    <input name='mode' value='{$form_code}' type='hidden'>
    <div class='row'><div class='col-md-12'><h4 class='text-center'>{$table}</h4></div></div>
    <div class='row well'><div class='col-md-12'><fieldset><legend><strong>{$lang['stats_ex_infor']}</strong></legend>{$page_detail}</fieldset></div></div>
    <div class='row well'><div class='col-md-12'><fieldset><legend><strong>{$lang['stats_ex_datefrom']}</strong></legend>";
    $htmlout.= make_select('from_month', make_month() , $old_date['mon']) . '&nbsp;&nbsp;';
    $htmlout.= make_select('from_day', make_day() , $old_date['mday']) . '&nbsp;&nbsp;';
    $htmlout.= make_select('from_year', make_year() , $old_date['year']) . '</fieldset><br>';
    $htmlout.= "<fieldset><legend><strong>{$lang['stats_ex_dateto']}</strong></legend>";
    $htmlout.= make_select('to_month', make_month() , $new_date['mon']) . '&nbsp;&nbsp;';
    $htmlout.= make_select('to_day', make_day() , $new_date['mday']) . '&nbsp;&nbsp;';
    $htmlout.= make_select('to_year', make_year() , $new_date['year']) . '</fieldset>';
    $htmlout.="</div></div>";
    if ($mode != 'views') {
        $htmlout.= "<div class='row'><div class='col-md-12'></div></div><div class='row well'><div class='col-md-12'><fieldset><legend><strong>{$lang['stats_ex_timescale']}</strong></legend>";
        $htmlout.= make_select('timescale', array(
            0 => array(
                'daily',
                $lang['stats_ex_daily']
            ) ,
            1 => array(
                'weekly',
                $lang['stats_ex_weekly']
            ) ,
            2 => array(
                'monthly',
                $lang['stats_ex_monthly']
            )
        )) . '</fieldset>';
    }
    $htmlout.= "<br><fieldset><legend><strong>{$lang['stats_ex_ressort']}</strong></legend>";
    $htmlout.= make_select('sortby', array(
        0 => array(
            'asc',
            $lang['stats_ex_asc']
        ) ,
        1 => array(
            'desc',
            $lang['stats_ex_desc']
        )
    ) , 'desc') . '</fieldset>';
$htmlout.= "</div></div></div>";
    $htmlout.= "<br><fieldset class='text-center'><legend><strong>{$lang['stats_ex_submit']}</strong></legend>
		<input value='{$lang['stats_ex_show']}' class='btn btn-default' accesskey='s' type='submit'></fieldset></form></div></div>";
    echo stdhead($page_title) . $htmlout  . stdfoot();
}
function make_year()
{
    $time_now = getdate();
    $return = array();
    $start_year = 2005;
    $latest_year = intval($time_now['year']);
    if ($latest_year == $start_year) {
        $start_year-= 1;
    }
    for ($y = $start_year; $y <= $latest_year; $y++) {
        $return[] = array(
            $y,
            $y
        );
    }
    return $return;
}
function make_month()
{
    global $month_names;
    $return = array();
    for ($m = 1; $m <= 12; $m++) {
        $return[] = array(
            $m,
            $month_names[$m]
        );
    }
    return $return;
}
function make_day()
{
    $return = array();
    for ($d = 1; $d <= 31; $d++) {
        $return[] = array(
            $d,
            $d
        );
    }
    return $return;
}
function make_select($name, $in = array() , $default = "")
{
    $html = "<select name='$name' class='dropdown'>\n";
    foreach ($in as $v) {
        $selected = "";
        if (($default != "") and ($v[0] == $default)) {
            $selected = " selected='selected'";
        }
        $html.= "<option value='{$v[0]}'{$selected}>{$v[1]}</option>\n";
    }
    $html.= "</select>\n\n";
    return $html;
}
function make_side_menu()
{
    global $INSTALLER09, $lang;
    $htmlout = "<div class='row'><div class='col-md-12'>
		<div class='nav offset1'>
		<ul class='nav nav-pills'>    
    <li>&nbsp;&nbsp;<a href='{$INSTALLER09['baseurl']}/staffpanel.php?tool=stats_extra&amp;action=stats_extra&amp;mode=reg' style='text-decoration: none;'>{$lang['stats_ex_menureg']}</a></li>
    <li>&nbsp;&nbsp;<a href='{$INSTALLER09['baseurl']}/staffpanel.php?tool=stats_extra&amp;action=stats_extra&amp;mode=topic' style='text-decoration: none;'>{$lang['stats_ex_menutopnew']}</a></li>
    <li>&nbsp;&nbsp;<a href='{$INSTALLER09['baseurl']}/staffpanel.php?tool=stats_extra&amp;action=stats_extra&amp;mode=post' style='text-decoration: none;'>{$lang['stats_ex_menuposts']}</a></li>
    <li>&nbsp;&nbsp;<a href='{$INSTALLER09['baseurl']}/staffpanel.php?tool=stats_extra&amp;action=stats_extra&amp;mode=msg' style='text-decoration: none;'>{$lang['stats_ex_menupm']}</a></li>
    <li>&nbsp;&nbsp;<a href='{$INSTALLER09['baseurl']}/staffpanel.php?tool=stats_extra&amp;action=stats_extra&amp;mode=views' style='text-decoration: none;'>{$lang['stats_ex_menutopic']}</a></li>
    <li>&nbsp;&nbsp;<a href='{$INSTALLER09['baseurl']}/staffpanel.php?tool=stats_extra&amp;action=stats_extra&amp;mode=comms' style='text-decoration: none;'>{$lang['stats_ex_menucomm']}</a></li>
    <li>&nbsp;&nbsp;<a href='{$INSTALLER09['baseurl']}/staffpanel.php?tool=stats_extra&amp;action=stats_extra&amp;mode=torrents' style='text-decoration: none;'>{$lang['stats_ex_menutorr']}</a></li>
    <li>&nbsp;&nbsp;<a href='{$INSTALLER09['baseurl']}/staffpanel.php?tool=stats_extra&amp;action=stats_extra&amp;mode=reps' style='text-decoration: none;'>{$lang['stats_ex_menurep']}</a></li>
</ul></div>
</div></div>";
    return $htmlout;
}
?>
