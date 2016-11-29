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
dbconn(false);
$lang = array_merge(load_language('global') , load_language('videoformats'));
$HTMLOUT = '';
$HTMLOUT.= "
<fieldset class='header'><legend>{$lang['videoformats_body']}</legend>
	<div class='container-fluid cite text-center'>
		<table class='table table-bordered  table-striped'>
			<tbody>
				<tr>
					<td class='row-fluid span2'>
						<b>{$lang['videoformats_cam']}</b><br />
						<br/>{$lang['videoformats_cam1']}<br />
					</td>
				</tr>
				<tr>
					<td class='row-fluid span1'>
						<b>{$lang['videoformats_ts']}</b><br />
						<br/>{$lang['videoformats_ts1']}<br />
					</td>
				</tr>
				<tr>
					<td class='row-fluid span2'>
						<b>{$lang['videoformats_tc']}</b><br />
						<br />{$lang['videoformats_tc1']}<br />
					</td>
				</tr>
				<tr>
					<td class='row-fluid span2'>
						<b>{$lang['videoformats_scr']}</b><br />
						<br />{$lang['videoformats_scr1']}<br />
					</td>
				</tr>
				<tr>
					<td class='row-fluid span2'>
						<b>{$lang['videoformats_dvdscr']}</b><br />
						<br />{$lang['videoformats_dvdscr1']}<br />
					</td>
				</tr>
				<tr>
					<td class='row-fluid span2'>
						<b>{$lang['videoformats_dvdrip']}</b><br />
						<br />{$lang['videoformats_dvdrip1']}<br />
					</td>
				</tr>
				<tr>
					<td class='row-fluid span2'>
						<b>{$lang['videoformats_vhsrip']}</b><br />
						<br />{$lang['videoformats_vhsrip1']}<br />
					</td>
				</tr>
				<tr>
					<td class='row-fluid span2'>
						<b>{$lang['videoformats_tvrip']}</b><br />
						<br />{$lang['videoformats_tvrip1']}<br />
					</td>
				</tr>
				<tr>
					<td class='row-fluid span2'>
						<b>{$lang['videoformats_workpoint']}</b><br />
						<br />{$lang['videoformats_workpoint1']}<br />
					</td>
				</tr>
				<tr>
					<td class='row-fluid span2'>
						<b>{$lang['videoformats_divxre']}</b><br />
						<br />{$lang['videoformats_divxre1']}<br />
					</td>
				</tr>
				<tr>
					<td class='row-fluid span2'>
						<b>{$lang['videoformats_watermarks']}</b><br />
						<br />{$lang['videoformats_watermarks1']}<br />
					</td>
				</tr>
				<tr>
					<td class='row-fluid span2'>
						<b>{$lang['videoformats_pdvd']}</b><br />
						<br />{$lang['videoformats_pdvd1']}<br />
					</td>
				</tr>
				<tr>
					<td class='row-fluid span2'>
						<b>{$lang['videoformats_scene']}</b><br />
					</td>
				</tr>
				<tr>
					<td class='row-fluid span2'>
						<b>{$lang['videoformats_proper']}</b><br />
						<br />{$lang['videoformats_proper1']}<br />
					</td>
				</tr>
				<tr>
					<td class='row-fluid span2'>
						<b>{$lang['videoformats_limited']}</b><br />
						<br />{$lang['videoformats_limited1']}<br />
					</td>
				</tr>
				<tr>
					<td class='row-fluid span2'>
						<b>{$lang['videoformats_internal']}</b><br />
						<br />{$lang['videoformats_internal1']}<br />
					</td>
				</tr>
				<tr>
					<td class='row-fluid span2'>
						<b>{$lang['videoformats_stv']}</b><br />
						<br />{$lang['videoformats_stv1']}<br />
					</td>
				</tr>
				<tr>
					<td class='row-fluid span2'>
						<b>{$lang['videoformats_aspect']}</b><br />
						<br />{$lang['videoformats_ws']}<br />
					</td>
				</tr>
				<tr>
					<td class='row-fluid span2'>
						<b>{$lang['videoformats_repack']}</b><br />
						<br />{$lang['videoformats_repack1']}<br />
					</td>
				</tr>
				<tr>
					<td class='row-fluid span2'>
						<b>{$lang['videoformats_nuked']}</b><br />
						<br />{$lang['videoformats_nuked1']}<br />
					</td>
				</tr>
				<tr>
					<td class='row-fluid span2'>
						<b>{$lang['videoformats_reason']}</b>{$lang['videoformats_reason1']}<br />
						<b>{$lang['videoformats_badar']}</b>{$lang['videoformats_badar1']}<br />
						<b>{$lang['videoformats_badivtc']}</b>{$lang['videoformats_badivtc1']}<br />
						<b>{$lang['videoformats_interlaced']}</b>{$lang['videoformats_interlaced1']}<br />
					</td>
				</tr>
				<tr>
					<td class='row-fluid span2'>
						<b>{$lang['videoformats_dupe']}</b><br />
						<br />{$lang['videoformats_dupe1']}<br />
					</td>
				</tr>
			</tbody>	
		</table>
	</div>
</fieldset>";
echo stdhead($lang['videoformats_header']) . $HTMLOUT . stdfoot();
?>
