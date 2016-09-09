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
 |   Project Leaders: Mindless, Autotron, whocares, Swizzles.		    |
 |--------------------------------------------------------------------------|
  _   _   _   _   _     _   _   _   _   _   _     _   _   _   _
 / \ / \ / \ / \ / \   / \ / \ / \ / \ / \ / \   / \ / \ / \ / \
( U | - | 2 | 3 | 2 )-( S | o | u | r | c | e )-( C | o | d | e )
 \_/ \_/ \_/ \_/ \_/   \_/ \_/ \_/ \_/ \_/ \_/   \_/ \_/ \_/ \_/
 */
 //==Template system by Terranova
function stdhead($title = "", $msgalert = true, $stdhead = false)
{
    global $CURUSER, $INSTALLER09, $lang, $free, $_NO_COMPRESS, $query_stat, $querytime, $mc1, $BLOCKS, $CURBLOCK, $mood, $blocks;
    if (!$INSTALLER09['site_online']) die("Site is down for maintenance, please check back again later... thanks<br />");
    if ($title == "") $title = $INSTALLER09['site_name'] . (isset($_GET['tbv']) ? " (" . TBVERSION . ")" : '');
    else $title = $INSTALLER09['site_name'] . (isset($_GET['tbv']) ? " (" . TBVERSION . ")" : '') . " :: " . htmlsafechars($title);
    if ($CURUSER) {
        $INSTALLER09['stylesheet'] = isset($CURUSER['stylesheet']) ? "{$CURUSER['stylesheet']}.css" : $INSTALLER09['stylesheet'];
        $INSTALLER09['categorie_icon'] = isset($CURUSER['categorie_icon']) ? "{$CURUSER['categorie_icon']}" : $INSTALLER09['categorie_icon'];
        $INSTALLER09['language'] = isset($CURUSER['language']) ? "{$CURUSER['language']}" : $INSTALLER09['language'];
    }
    $salty = md5("Th15T3xtis5add3dto66uddy6he@water..." . $CURUSER['username'] . "");
    /** ZZZZZZZZZZZZZZZZZZZZZZZZZZip it! */

if (!isset($_NO_COMPRESS)) if (!ob_start('ob_gzhandler')) ob_start();
    $htmlout = '';
    //== Include js files needed only for the page being used by pdq
    $js_incl = '';
    $js_incl.= '<!-- javascript goes here or in footer -->';
    if (!empty($stdhead['js'])) {
        foreach ($stdhead['js'] as $JS) $js_incl.= "<script type='text/javascript' src='{$INSTALLER09['baseurl']}/scripts/" . $JS . ".js'></script>";
    }

    //== Include css files needed only for the page being used by pdq
    $stylez = ($CURUSER ? "{$CURUSER['stylesheet']}" : "{$INSTALLER09['stylesheet']}");
    $css_incl = '';
    $css_incl.= '<!-- css goes in header -->';
    if (!empty($stdhead['css'])) {
        foreach ($stdhead['css'] as $CSS) $css_incl.= "<link type='text/css' rel='stylesheet' href='{$INSTALLER09['baseurl']}/templates/{$stylez}/css/" . $CSS . ".css' />";
    }
$body_class = isset($_COOKIE['theme']) ? htmlsafechars($_COOKIE['theme']) : 'background-1 skin-1 nb-1 panelhead-1 bootpanel-1 btable-1 btr-1 listgrp-1 buttonS-1 text-1';
$htmlout .='
<!DOCTYPE html>
  <html xmlns="http://www.w3.org/1999/xhtml" lang="en">
        <!-- ####################################################### -->
        <!-- #   This website is powered by U-232 V5	           # -->
        <!-- #   Download and support at:                          # -->
        <!-- #     https://forum-u-232.servebeer.com               # -->
        <!-- #   Template Modded by U-232 Dev Team                 # -->
        <!-- ####################################################### -->
  <head>
    <!--<meta charset="'.charset().'" />-->
    <meta charset="utf-8" />
    <!--[if IE]><meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"><![endif]-->
    <meta name="viewport" content="width=device-width, initial-scale=0.35, maximum-scale=1" />
    <title>'.$title.'</title>
		<!-- favicon  -->
    	<link rel="shortcut icon" href="/favicon.ico" />
	<link rel="stylesheet" href="css/bootstrap.css" type="text/css">
<!-- Template CSS-->
    	<link rel="stylesheet" href="templates/1/1.css" />
       	<link rel="stylesheet" href="css/font-awesome.min.css" />
    	<script src="scripts/jquery-1.11.1.js"></script>
      	<script src="scripts/bootstrap.js"></script>	
<!--THemechanger-->
        <script type="text/javascript" src="scripts/jquery.cookie.js"></script>
	<script type="text/javascript" src="scripts/help.js"></script>
 	<link rel="stylesheet" href="templates/1/themeChanger/css/colorpicker.css" type="text/css">
        <link rel="stylesheet" href="templates/1/themeChanger/css/themeChanger.css" type="text/css">
      	<script type="text/javascript" src="templates/1/themeChanger/js/colorpicker.js"></script>
        <script type="text/javascript" src="templates/1/themeChanger/js/themeChanger.js"></script>
	<!-- Forum CSS-->
    <link rel="stylesheet" href="templates/1/css/forum.css" /> 
    <!-- global javascript-->
	<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
	<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
	<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
	<!--[if gt IE 8]> <![endif]-->
	<!--[if lt IE 9]><meta http-equiv="X-UA-Compatible" content="IE=9"><![endif]-->
    <!-- <script src="scripts/html5shiv.js"  async></script>  -->
    <script src="scripts/respond.min.js"  async></script> <!-- used for IE8 and below-->
    <!-- <script src="http://ie7-js.googlecode.com/svn/version/2.1(beta4)/IE8.js"></script>  -->    
    <script type="application/rss+xml" title="Latest Torrents" src="/rss.php?torrent_pass='.$CURUSER["torrent_pass"].'"></script>';
	$htmlout .= "
    <style type='text/css'>#mlike{cursor:pointer;}</style>
    <script type='text/javascript'>
        /*<![CDATA[*/
		// Like Dislike function
		//================================================== -->
		$(function() {							// the like js
		$('span[id*=mlike]').like232({
		times : 5,            	// times checked 
		disabled : 5,         	// disabled from liking for how many seconds
		time  : 5,             	// period within check is performed
		url : '/ajax.like.php'
		});
		});
	// template changer function
	//================================================== -->
        function themes() {
          window.open('take_theme.php','My themes','height=150,width=200,resizable=no,scrollbars=no,toolbar=no,menubar=no');
        }
	// language changer function
	//================================================== -->
        function language_select() {
          window.open('take_lang.php','My language','height=150,width=200,resizable=no,scrollbars=no,toolbar=no,menubar=no');
        }
	// radio function
	//================================================== -->
        function radio() {
          window.open('radio_popup.php','My Radio','height=700,width=800,resizable=no,scrollbars=no,toolbar=no,menubar=no');
        }
         /*]]>*/
        </script>
        <script type='text/javascript' src='./scripts/jaxo.suggest.js'></script>
				<script type='text/javascript'>
				/*<![CDATA[*/
				$(document).ready(function(){
				$(\"input[name='search']\").search(options);
				});
				/*]]>*/
				</script>
    {$js_incl}{$css_incl}
        </head>
    <body class='{$body_class}'>";
  if ($CURUSER) {
   $htmlout .="
   <nav class='cb navbar-default navbar-fixed-top' role='navigation'>
   <div class='container'>
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class='navbar-header'>
      <button type='button' class='navbar-toggle' data-toggle='collapse' data-target='.navbar-exl-collapse'>
        <span class='sr-only'>Toggle navigation</span>
        <span class='icon-bar'></span>
        <span class='icon-bar'></span>
        <span class='icon-bar'></span>
      </button>
     <a class='navbar-brand' href='" . $INSTALLER09['baseurl'] . "/index.php'>{$INSTALLER09['site_name']}</a>
    </div>
    <!-- Collect the nav links, forms, and other content for toggling -->
     <div class='collapse navbar-collapse navbar-exl-collapse'>
        <ul class='nav navbar-nav navbar-right'>
        <a class='btn btn-success btn-sm' href='" . $INSTALLER09['baseurl'] . "/donate.php'>{$lang['gl_donate']}</a>
        <a class='btn btn-primary btn-sm' href='" . $INSTALLER09['baseurl'] . "/forums.php'>{$lang['gl_forums']}</a>
	<div class='btn-group'>
					  <button class='btn btn-primary navbar-btn btn-sm'>{$lang['gl_general']}</button>
					  <button class='btn dropdown-toggle navbar-btn btn-primary btn-sm' data-toggle='dropdown'>
						<span class='caret'></span>
					  </button>
					  <ul class='dropdown-menu pull-right'>
						<!-- dropdown menu links -->
			<li><a href='" . $INSTALLER09['baseurl'] . "/topten.php'>{$lang['gl_stats']}</a></li>
			<li><a href='" . $INSTALLER09['baseurl'] . "/faq.php'>{$lang['gl_faq']}</a></li>
			<li><a href='" . $INSTALLER09['baseurl'] . "/rules.php'>{$lang['gl_rules']}</a></li>
			<li><a href='" . $INSTALLER09['baseurl'] . "/chat.php'>{$lang['gl_irc']}</a></li>
			<li><a href='" . $INSTALLER09['baseurl'] . "/staff.php'>{$lang['gl_staff']}</a></li>
			<li><a href='" . $INSTALLER09['baseurl'] . "/wiki.php'>{$lang['gl_wiki']}</a></li>
			<li><a href='#' onclick='radio();'>{$lang['gl_radio']}</a></li>
			<li><a href='" . $INSTALLER09['baseurl'] . "/rsstfreak.php'>{$lang['gl_tfreak']}</a></li>
                        <li><a href='" . $INSTALLER09['baseurl'] . "/casino.php'>{$lang['gl_casino']}</a></li>
                        <li><a href='" . $INSTALLER09['baseurl'] . "/blackjack.php'>{$lang['gl_bjack']}</a></li>
                        <li><a href='" . $INSTALLER09['baseurl'] . "/sitepot.php'>{$lang['gl_sitepot']}</a></li>
 					  </ul>
					</div>
				<div class='btn-group'>
					  <button class='btn btn-primary navbar-btn btn-sm'>{$lang['gl_torrent']}</button>
					  <button class='btn dropdown-toggle navbar-btn btn-primary btn-sm' data-toggle='dropdown'>
						<span class='caret'></span>
					  </button>
					  <ul class='dropdown-menu pull-right'>
						<!-- dropdown menu links -->
 	    <li><a href='" . $INSTALLER09['baseurl'] . "/browse.php'>{$lang['gl_torrents']}</a></li>
		<li><a href='" . $INSTALLER09['baseurl'] . "/requests.php'>{$lang['gl_requests']}</a></li>
	    <li><a href='" . $INSTALLER09['baseurl'] . "/offers.php'>{$lang['gl_offers']}</a></li>
	    <li><a href='" . $INSTALLER09['baseurl'] . "/needseed.php?needed=seeders'>{$lang['gl_nseeds']}</a></li>
		" . (isset($CURUSER) && $CURUSER['class'] <= UC_VIP ? "<li><a href='" . $INSTALLER09['baseurl'] . "/uploadapp.php'>{$lang['gl_uapp']}</a> </li>" : "<li><a href='" . $INSTALLER09['baseurl'] . "/upload.php'>{$lang['gl_upload']}</a></li>") . "
                " . (isset($CURUSER) && $CURUSER['class'] <= UC_VIP ? "" : "<li><a href='" . $INSTALLER09['baseurl'] . "/multiupload.php'>{$lang['gl_mupload']}</a></li>") . "
        <li><a href='" . $INSTALLER09['baseurl'] . "/bookmarks.php'>{$lang['gl_bookmarks']}</a></li>
					  </ul>
					</div>
				<!-- <div class='btn-group'>
					  <button class='btn btn-primary navbar-btn btn-sm'>{$lang['gl_games']}</button>
					  <button class='btn dropdown-toggle navbar-btn btn-primary btn-sm' data-toggle='dropdown'>
						<span class='caret'></span>
					  </button>
					  <ul class='dropdown-menu pull-right'>
						<!-- dropdown menu links -->
		<!-- " . (isset($CURUSER) && $CURUSER['class'] >= UC_POWER_USER ? "<li><a href='" . $INSTALLER09['baseurl'] . "/casino.php'>{$lang['gl_casino']}</a></li>" : "") . "
		" . (isset($CURUSER) && $CURUSER['class'] >= UC_POWER_USER ? "<li><a href='" . $INSTALLER09['baseurl'] . "/blackjack.php'>{$lang['gl_bjack']}</a></li>" : "") . "
					  </ul>
					</div> -->
				<div class='btn-group'>
					  <button class='btn btn-primary navbar-btn btn-sm'>Staff Tools</button>
					  <button class='btn dropdown-toggle navbar-btn btn-primary btn-sm' data-toggle='dropdown'>
						<span class='caret'></span>
					  </button>
					  <ul class='dropdown-menu pull-right'>
						<!-- dropdown menu links -->
						   <li> " . (isset($CURUSER) && $CURUSER['class'] < UC_STAFF ? "<a class='brand' href='" . $INSTALLER09['baseurl'] . "/bugs.php?action=add'>{$lang['gl_breport']}</a>" : "<a class='brand' href='" . $INSTALLER09['baseurl'] . "/bugs.php?action=bugs'>{$lang['gl_brespond']}</a>") . "</li>
							<li>" . (isset($CURUSER) && $CURUSER['class'] < UC_STAFF ? "<a class='brand' href='" . $INSTALLER09['baseurl'] . "/contactstaff.php'>{$lang['gl_cstaff']}</a>" : "<a class='brand' href='" . $INSTALLER09['baseurl'] . "/staffbox.php'>{$lang['gl_smessages']}</a>") . "</li>
							" . (isset($CURUSER) && $CURUSER['class'] >= UC_STAFF ? "<li><a href='" . $INSTALLER09['baseurl'] . "/staffpanel.php'>{$lang['gl_admin']}</a></li>" : "") . "
					  </ul>
					</div>
				<div class='btn-group'>
					  <button class='btn btn-primary navbar-btn btn-sm'>Pers Tools</button>
					  <button class='btn dropdown-toggle navbar-btn btn-primary btn-sm' data-toggle='dropdown'>
						<span class='caret'></span>
					  </button>
					  <ul class='dropdown-menu pull-right'>
						<!-- dropdown menu links -->
   		<li><a href='#' onclick='themes();'>{$lang['gl_theme']}</a></li>
		<li><a href='#' onclick='language_select();'>{$lang['gl_language_select']}</a></li>
		<li><a href='" . $INSTALLER09['baseurl'] . "/pm_system.php'>{$lang['gl_pms']}</a></li>
		<li><a href='" . $INSTALLER09['baseurl'] . "/usercp.php?action=default'>{$lang['gl_usercp']}</a></li>
 	    <!-- <li><a href='" . $INSTALLER09['baseurl'] . "/friends.php'>{$lang['gl_friends']}</a></li> -->
		<li class='divider'></li>
		<li>" . (isset($CURUSER) && $CURUSER['got_blocks'] == 'yes' ? "{$lang['gl_userblocks']}<a href='./user_blocks.php'>My Blocks</a>" : "") . "</li>
		<li>" . (isset($CURUSER) && $CURUSER['got_moods'] == 'yes' ? "<a href='./user_unlocks.php'>My Unlocks</a>" : "") . "</li>
					  </ul>
					</div>
		<a class='btn btn-warning btn-sm' href='" . $INSTALLER09['baseurl'] . "/logout.php?hash_please={$salty}'>{$lang['gl_logout']}</a>

     </ul>
    </div><!-- /.navbar-collapse -->
</div></nav><div class='banners'></div>";
		$htmlout .='<div class="alert" style="background:rgba(0, 0, 0, 0.1);">'.StatusBar().'</div>';
		$htmlout .="
    <!-- U-232 Source - Print Global Messages Start -->
    <div class='container'>
    <div class='sa-gm_taps_left'>";
	$htmlout .="<ul class='sa-gm_taps'><li><b>{$lang['gl_alerts']}</b></li>";
    if (curuser::$blocks['global_stdhead'] & block_stdhead::STDHEAD_REPORTS && $BLOCKS['global_staff_report_on']) {
    require_once (BLOCK_DIR.'global/report.php');
    }
    if (curuser::$blocks['global_stdhead'] & block_stdhead::STDHEAD_UPLOADAPP && $BLOCKS['global_staff_uploadapp_on']) {
    require_once (BLOCK_DIR.'global/uploadapp.php');
    }
    if (curuser::$blocks['global_stdhead'] & block_stdhead::STDHEAD_HAPPYHOUR && $BLOCKS['global_happyhour_on']) {
    require_once (BLOCK_DIR.'global/happyhour.php');
    }
    if (curuser::$blocks['global_stdhead'] & block_stdhead::STDHEAD_STAFF_MESSAGE && $BLOCKS['global_staff_warn_on']) {
    require_once (BLOCK_DIR.'global/staffmessages.php');
    }
    if (curuser::$blocks['global_stdhead'] & block_stdhead::STDHEAD_NEWPM && $BLOCKS['global_message_on']) {
    require_once (BLOCK_DIR.'global/message.php');
    }
    if (curuser::$blocks['global_stdhead'] & block_stdhead::STDHEAD_DEMOTION && $BLOCKS['global_demotion_on']) {
    require_once (BLOCK_DIR.'global/demotion.php');
    }
    if (curuser::$blocks['global_stdhead'] & block_stdhead::STDHEAD_FREELEECH && $BLOCKS['global_freeleech_on']) {
    require_once (BLOCK_DIR.'global/freeleech.php');
    }
    if (curuser::$blocks['global_stdhead'] & block_stdhead::STDHEAD_CRAZYHOUR && $BLOCKS['global_crazyhour_on']) {
    require_once (BLOCK_DIR.'global/crazyhour.php');
    }
    if (curuser::$blocks['global_stdhead'] & block_stdhead::STDHEAD_BUG_MESSAGE && $BLOCKS['global_bug_message_on']) {
    require_once (BLOCK_DIR.'global/bugmessages.php');
    }
    if (curuser::$blocks['global_stdhead'] & block_stdhead::STDHEAD_FREELEECH_CONTRIBUTION && $BLOCKS['global_freeleech_contribution_on']) {
    require_once (BLOCK_DIR.'global/freeleech_contribution.php');
    }
    $htmlout.= "</ul></div></div><br />";
    if (curuser::$blocks['global_stdhead'] & block_stdhead::STDHEAD_STAFFTOOLS && $BLOCKS['global_staff_tools_on']) {
    require_once (BLOCK_DIR.'global/staff_tools.php');
    }
    }
    if ($CURUSER) {
    $htmlout.= '<div class="container"> 
    <div id="control_panel"><a href="#" id="control_label"></a></div>';}
    return $htmlout;
   }

 function stdfoot($stdfoot = false)
{
    global $CURUSER, $INSTALLER09, $start, $query_stat, $mc1, $querytime, $lang, $rc;
    $debug = (SQL_DEBUG && in_array($CURUSER['id'], $INSTALLER09['allowed_staff']['id']) ? 1 : 0);
    $cachetime = ($mc1->Time / 1000);
    $seconds = microtime(true) - $start;
    $r_seconds = round($seconds, 5);
    //$phptime = $seconds - $cachetime;
    $phptime = $seconds - $querytime - $cachetime;
    $queries = count($query_stat); // sql query count by pdq
    $percentphp = number_format(($phptime / $seconds) * 100, 2);
    //$percentsql  = number_format(($querytime / $seconds) * 100, 2);
    $percentmc = number_format(($cachetime / $seconds) * 100, 2);
    define('REQUIRED_PHP_VER', 7.0);
    $MemStat = (PHP_VERSION_ID < REQUIRED_PHP_VER ? $mc1->getStats() : $mc1->getStats()["127.0.0.1:11211"]);
    if (($MemStats = $mc1->get_value('mc_hits')) === false) {
        $MemStats =  $MemStat;
        $MemStats['Hits'] = (($MemStats['get_hits'] / $MemStats['cmd_get'] < 0.7) ? '' : number_format(($MemStats['get_hits'] / $MemStats['cmd_get']) * 100, 3));
        $mc1->cache_value('mc_hits', $MemStats, 10);
    }
    // load averages - pdq
    if ($debug) {
        if (($uptime = $mc1->get_value('uptime')) === false) {
            $uptime = `uptime`;
            $mc1->cache_value('uptime', $uptime, 25);
        }
        preg_match('/load average: (.*)$/i', $uptime, $load);
    }

    //== end class
    $header = '';
    $header = '' . $lang['gl_stdfoot_querys_mstat'] . ' ' . mksize(memory_get_peak_usage()) . ' ' . $lang['gl_stdfoot_querys_mstat1'] . ' ' . round($phptime, 2) . 's | ' . round($percentmc, 2) . '' . $lang['gl_stdfoot_querys_mstat2'] . '' . number_format($cachetime, 5) . 's ' . $lang['gl_stdfoot_querys_mstat3'] . '' . $MemStats['Hits'] . '' . $lang['gl_stdfoot_querys_mstat4'] . '' . (100 - $MemStats['Hits']) . '' . $lang['gl_stdfoot_querys_mstat5'] . '' . number_format($MemStats['curr_items']);
    $htmlfoot = '';
    //== query stats
    $htmlfoot.= '';
    if (!empty($stdfoot['js'])) {
        $htmlfoot.= '<!-- javascript goes here in footer -->';
        foreach ($stdfoot['js'] as $JS) $htmlfoot.= '
		<script src="' . $INSTALLER09['baseurl'] . '/scripts/' . $JS . '.js"></script>';
    }
    $querytime = 0;
    if ($CURUSER && $query_stat && $debug) {
        $htmlfoot.= "
<div class='panel panel-default'>
	<div class='panel-heading'>
		<label for='checkbox_4' class='text-left'>{$lang['gl_stdfoot_querys']}</label>
	</div>
	<div class='panel-body'>
					<table class='table table-hover table-bordered'>
						<thead>
							<tr>
								<th class='text-center'>{$lang['gl_stdfoot_id']}</th>
								<th class='text-center'>{$lang['gl_stdfoot_qt']}</th>
								<th class='text-center'>{$lang['gl_stdfoot_qs']}</th>
							</tr>
						</thead>";
        foreach ($query_stat as $key => $value) {
            $querytime+= $value['seconds']; // query execution time
             $htmlfoot.= "
						<tbody>
							<tr>
								<td>" . ($key + 1) . "</td>
								<td>" . ($value['seconds'] > 0.01 ? "
								<span class='text-danger' title='{$lang['gl_stdfoot_ysoq']}'>" . $value['seconds'] . "</span>" : "
								<span class='text-success' title='{$lang['gl_stdfoot_qg']}'>" . $value['seconds'] . "</span>") . "
								</td>
								<td>" . htmlsafechars($value['query']) . "<br /></td>
							</tr>
						</tbody>";
        }
        $htmlfoot.= '</table></table></div></div>';
    }
  if ($CURUSER) {
        /** just in case **/
        $htmlfoot.= "
			<div class='panel panel-default'>	
				<div class='panel-body'>
				<div class='pull-left'>
				" . $INSTALLER09['site_name'] . " {$lang['gl_stdfoot_querys_page']}" . $r_seconds . " {$lang['gl_stdfoot_querys_seconds']}<br />" . "
				{$lang['gl_stdfoot_querys_server']}" . $queries . " {$lang['gl_stdfoot_querys_time']} " . ($queries != 1 ? "{$lang['gl_stdfoot_querys_times']}" : "") . "
				" . ($debug ? "<br />" . $header . "<br />{$lang['gl_stdfoot_uptime']} " . $uptime . "" : " ") . "
				</div>
				<div class='pull-right text-right'>
				{$lang['gl_stdfoot_powered']}" . TBVERSION . "<br />
				{$lang['gl_stdfoot_using']}{$lang['gl_stdfoot_using1']}<br />
				{$lang['gl_stdfoot_support']}<a href='http://forum-u-232.servebeer.com/index.php'>{$lang['gl_stdfoot_here']}</a><br />
				" . ($debug ? "<a title='{$lang['gl_stdfoot_sview']}' rel='external' href='/staffpanel.php?tool=system_view'>{$lang['gl_stdfoot_sview']}</a> | " . "<a rel='external' title='OPCache' href='/staffpanel.php?tool=op'>{$lang['gl_stdfoot_opc']}</a> | " . "<a rel='external' title='Memcache' href='/staffpanel.php?tool=memcache'>{$lang['gl_stdfoot_memcache']}</a>" : "") . "";
			$htmlfoot.= "</div></div></div>";
    }
    $htmlfoot.='
        </div><!--  End main outer container -->
        <!-- Ends Footer -->
		<!-- localStorage for collapse -->
        <script src="scripts/jquery.collapse.localstorage.js"></script>
        </body></html>';
    return $htmlfoot;
}
function stdmsg($heading, $text)
{
$htmlout = "<table class='main' width='750' border='0' cellpadding='0' cellspacing='0'><tr><td class='embedded'>\n";
if ($heading) $htmlout.= "<h2>$heading</h2>\n";
$htmlout.= "<table width='90%' border='1' cellspacing='0' cellpadding='10'><tr><td class='colhead2'>\n";
$htmlout.= "{$text}</td></tr></table><p></p><p></p></td></tr></table>\n";
return $htmlout;
}
function StatusBar()
{
    global $CURUSER, $INSTALLER09, $lang, $rep_is_on, $mc1, $msgalert;
    if (!$CURUSER) return "";
    $upped = mksize($CURUSER['uploaded']);
    $downed = mksize($CURUSER['downloaded']);
    $connectable = "";
    //==Memcache unread pms
    $PMCount = 0;
    if (($unread1 = $mc1->get_value('inbox_new_sb_' . $CURUSER['id'])) === false) {
        $res1 = sql_query("SELECT COUNT(id) FROM messages WHERE receiver=" . sqlesc($CURUSER['id']) . " AND unread = 'yes' AND location = '1'") or sqlerr(__LINE__, __FILE__);
        list($PMCount) = mysqli_fetch_row($res1);
        $PMCount = (int)$PMCount;
        $unread1 = $mc1->cache_value('inbox_new_sb_' . $CURUSER['id'], $PMCount, $INSTALLER09['expires']['unread']);
    }
    $inbox = ($unread1 == 1 ? "$unread1&nbsp;{$lang['gl_msg_singular']}" : "$unread1&nbsp;{$lang['gl_msg_plural']}");
    //==Memcache peers
    if (XBT_TRACKER == true) {
    if (($MyPeersXbtCache = $mc1->get_value('MyPeers_XBT_'.$CURUSER['id'])) === false) {
        $seed['yes'] = $seed['no'] = 0;
        $seed['conn'] = 3;
        $r = sql_query("SELECT COUNT(uid) AS `count`, `left`, `active`, `connectable` FROM `xbt_files_users` WHERE uid= " . sqlesc($CURUSER['id']) . " AND `left` = 0 AND `active` = 1") or sqlerr(__LINE__, __FILE__);
        while ($a = mysqli_fetch_assoc($r)) {
            $key = $a['left'] == 0 ? 'yes' : 'no';
            $seed[$key] = number_format(0 + $a['count']);
            $seed['conn'] = $a['connectable'] == 0 ? 1 : 2;
        }
        $mc1->cache_value('MyPeers_XBT_'.$CURUSER['id'], $seed, $INSTALLER09['expires']['MyPeers_xbt_']);
        unset($r, $a);
    } else {
        $seed = $MyPeersXbtCache;
    }
} else {
    if (($MyPeersCache = $mc1->get_value('MyPeers_' . $CURUSER['id'])) === false) {
        $seed['yes'] = $seed['no'] = 0;
        $seed['conn'] = 3;
        $r = sql_query("SELECT COUNT(id) AS count, seeder, connectable FROM peers WHERE userid=" . sqlesc($CURUSER['id']) . " GROUP BY seeder");
        while ($a = mysqli_fetch_assoc($r)) {
            $key = $a['seeder'] == 'yes' ? 'yes' : 'no';
            $seed[$key] = number_format(0 + $a['count']);
            $seed['conn'] = $a['connectable'] == 'no' ? 1 : 2;
        }
        $mc1->cache_value('MyPeers_' . $CURUSER['id'], $seed, $INSTALLER09['expires']['MyPeers_']);
        unset($r, $a);
    } else {
        $seed = $MyPeersCache;
    }
   }
     // for display connectable  1 / 2 / 3
    if (!empty($seed['conn'])) {
        switch ($seed['conn']) {
        case 1:
            $connectable = "<img src='{$INSTALLER09['pic_base_url']}notcon.png' alt='Not Connectable' title='Not Connectable' />";
            break;
        case 2:
            $connectable = "<img src='{$INSTALLER09['pic_base_url']}yescon.png' alt='Connectable' title='Connectable' />";
            break;
        default:
            $connectable = "N/A";
        }
    } else $connectable = 'N/A';

    if (($Achievement_Points = $mc1->get_value('user_achievement_points_' . $CURUSER['id'])) === false) {
        $Sql = sql_query("SELECT users.id, users.username, usersachiev.achpoints, usersachiev.spentpoints FROM users LEFT JOIN usersachiev ON users.id = usersachiev.id WHERE users.id = " . sqlesc($CURUSER['id'])) or sqlerr(__FILE__, __LINE__);
        $Achievement_Points = mysqli_fetch_assoc($Sql);
        $Achievement_Points['id'] = (int)$Achievement_Points['id'];
        $Achievement_Points['achpoints'] = (int)$Achievement_Points['achpoints'];
        $Achievement_Points['spentpoints'] = (int)$Achievement_Points['spentpoints'];
        $mc1->cache_value('user_achievement_points_' . $CURUSER['id'], $Achievement_Points, 0);
    }
    //$hitnruns = ($CURUSER['hit_and_run_total'] > 0 ? $CURUSER['hit_and_run_total'] : '0');
    //{$lang['gl_hnr']}: <a href='".$INSTALLER09['baseurl']."/hnr.php?id=".$CURUSER['id']."'>{$hitnruns}</a>&nbsp;
    $member_reputation = get_reputation($CURUSER);
    $usrclass = $StatusBar = "";
    if ($CURUSER['override_class'] != 255) $usrclass = "&nbsp;<b>[" . get_user_class_name($CURUSER['class']) . "]</b>&nbsp;";
    else if ($CURUSER['class'] >= UC_STAFF) $usrclass = "&nbsp;<a href='".$INSTALLER09['baseurl']."/setclass.php'><b>[" . get_user_class_name($CURUSER['class']) . "]</b></a>&nbsp;";
    $StatusBar.= "<div class='text-center'>Welcome ".format_username($CURUSER) ." ".(isset($CURUSER) && $CURUSER['class'] < UC_STAFF ? "[".get_user_class_name($CURUSER['class'])."]" : $usrclass)."&nbsp;{$lang['gl_achpoints']}&nbsp;<a href='./achievementhistory.php?id={$CURUSER['id']}'>" . (int)$Achievement_Points['achpoints'] . "</a>&nbsp;{$lang['gl_karma']}: <a href='".$INSTALLER09['baseurl']."/mybonus.php'>{$CURUSER['seedbonus']}</a>&nbsp;{$lang['gl_invites']}: <a href='".$INSTALLER09['baseurl']."/invite.php'>{$CURUSER['invites']}</a>&nbsp;{$lang['gl_rep']}:{$member_reputation}&nbsp;{$lang['gl_shareratio']}&nbsp;". member_ratio($CURUSER['uploaded'], $INSTALLER09['ratio_free'] ? '0' : $CURUSER['downloaded']);
 if ($INSTALLER09['ratio_free']) {
    $StatusBar .= "&nbsp;{$lang['gl_uploaded']}:".$upped;
    } else {
        $StatusBar .= "&nbsp;{$lang['gl_uploaded']}:{$upped} {$lang['gl_downloaded']}:{$downed}&nbsp;{$lang['gl_connectable']}&nbsp;{$connectable}";
}
	$StatusBar .= "</div>";
    return $StatusBar;
}
?>
