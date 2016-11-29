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
// === Staff shoutbox 09
if ($CURUSER['opt2'] & user_options_2::SHOW_STAFFSHOUT) {
    $commandbutton = $refreshbutton = $smilebutton = $custombutton = $staffsmiliebutton = '';
    if ($CURUSER['class'] >= UC_STAFF) {
        $staffsmiliebutton.= "<a href=\"javascript:PopStaffSmiles('staff_shbox','staff_shbox_text')\">{$lang['index_shoutbox_ssmilies']}</a>";
    }
    if (get_smile() != 0) $custombutton.= "<a href=\"javascript:PopCustomSmiles('staff_shbox','staff_shbox_text')\">{$lang['index_shoutbox_csmilies']}</a>";
    if ($CURUSER['class'] >= UC_STAFF) {
        $commandbutton = "<a href=\"javascript:popUp('shoutbox_commands.php')\">{$lang['index_shoutbox_commands']}</a>\n";
    }
    $refreshbutton = "<a href='staff_shoutbox.php' target='staff_shoutbox'>{$lang['index_shoutbox_refresh']}</a>\n";
    $smilebutton = "<a href=\"javascript:PopMoreSmiles('staff_shbox','staff_shbox_text')\">{$lang['index_shoutbox_smilies']}</a>\n";
    $HTMLOUT.= "<script src='{$INSTALLER09['baseurl']}/scripts/shout.js'></script>";
    if ($CURUSER['class'] >= UC_STAFF)
    {
    $HTMLOUT.= "
   <div class='panel panel-default'>
	<div class='panel-heading'>
	<!--<span class='shouthis'>-->
	<span><a class='btn btn-default' href='{$INSTALLER09['baseurl']}/staff_shoutbox.php?show_staffshout=1&amp;show_staff=no'>{$lang['index_shoutbox_close']}</a></span>
		<label for='checkbox_4' class='text-left'>{$lang['index_staff_shoutbox']}</label>
<span class='nav navbar-nav navbar-right'><a class='btn btn-primary btn-sm navbar-btn' style='margin-top:-2px;' href='{$INSTALLER09['baseurl']}/staffpanel.php?tool=staff_shistory'>{$lang['index_shoutbox_history']}</a></span>
</div>
	<div class='panel-body'>
<div class='text-center'>";
    }
    $HTMLOUT.= "<form action='staff_shoutbox.php' method='get' target='staff_shoutbox' name='staff_shbox' onsubmit='staff_mysubmit()'>
   <iframe src='{$INSTALLER09['baseurl']}/staff_shoutbox.php' class='shout-table' name='staff_shoutbox'></iframe>
	<div class='text-center'>
		<div class='input-group'>
		<div class='input-group-btn dropup'>
		<button type=button class='btn btn-primary dropdown-toggle' data-toggle='dropdown'>{$lang['index_shoutbox_shout']}<span class='caret'></span></button>
        <ul class='dropdown-menu' role='menu'>
			<li>{$commandbutton}</li>
			<li>{$staffsmiliebutton}</li>
			<li>{$smilebutton}</li>
			<li>{$custombutton}</li>
			<li>{$refreshbutton}</li>
        </ul>
			</div>
				<input type='text' class='form-control col-lg-12' name='staff_shbox_text' placeholder='Staff Shout Text'>
			<span class='input-group-btn'>
				<input class='btn btn-primary' type='submit' value='{$lang['index_shoutbox_send']}' />
				<input type='hidden' name='staff_sent' value='yes' />
			</span>
		</div>
		   <a href=\"javascript:SmileIT(':-)','staff_shbox','staff_shbox_text')\"><img src='{$INSTALLER09['pic_base_url']}smilies/smile1.gif' alt='Smile' title='Smile' /></a> 
		   <a href=\"javascript:SmileIT(':smile:','staff_shbox','staff_shbox_text')\"><img src='{$INSTALLER09['pic_base_url']}smilies/smile2.gif' alt='Smiling' title='Smiling' /></a> 
		   <a href=\"javascript:SmileIT(':-D','staff_shbox','staff_shbox_text')\"><img src='{$INSTALLER09['pic_base_url']}smilies/grin.gif' alt='Grin' title='Grin' /></a> 
		   <a href=\"javascript:SmileIT(':lol:','staff_shbox','staff_shbox_text')\"><img src='{$INSTALLER09['pic_base_url']}smilies/laugh.gif' alt='Laughing' title='Laughing' /></a> 
		   <a href=\"javascript:SmileIT(':w00t:','staff_shbox','staff_shbox_text')\"><img src='{$INSTALLER09['pic_base_url']}smilies/w00t.gif' alt='W00t' title='W00t' /></a> 
		   <a href=\"javascript:SmileIT(':blum:','staff_shbox','staff_shbox_text')\"><img src='{$INSTALLER09['pic_base_url']}smilies/blum.gif' alt='Rasp' title='Rasp' /></a> 
		   <a href=\"javascript:SmileIT(';-)','staff_shbox','staff_shbox_text')\"><img src='{$INSTALLER09['pic_base_url']}smilies/wink.gif' alt='Wink' title='Wink' /></a> 
		   <a href=\"javascript:SmileIT(':devil:','staff_shbox','staff_shbox_text')\"><img src='{$INSTALLER09['pic_base_url']}smilies/devil.gif' alt='Devil' title='Devil' /></a> 
		   <a href=\"javascript:SmileIT(':yawn:','staff_shbox','staff_shbox_text')\"><img src='{$INSTALLER09['pic_base_url']}smilies/yawn.gif' alt='Yawn' title='Yawn' /></a> 
		   <a href=\"javascript:SmileIT(':-/','staff_shbox','staff_shbox_text')\"><img src='{$INSTALLER09['pic_base_url']}smilies/confused.gif' alt='Confused' title='Confused' /></a> 
		   <a href=\"javascript:SmileIT(':o)','staff_shbox','staff_shbox_text')\"><img src='{$INSTALLER09['pic_base_url']}smilies/clown.gif' alt='Clown' title='Clown' /></a> 
		   <a href=\"javascript:SmileIT(':innocent:','staff_shbox','staff_shbox_text')\"><img src='{$INSTALLER09['pic_base_url']}smilies/innocent.gif' alt='Innocent' title='innocent' /></a> 
		   <a href=\"javascript:SmileIT(':whistle:','staff_shbox','staff_shbox_text')\"><img src='{$INSTALLER09['pic_base_url']}smilies/whistle.gif' alt='Whistle' title='Whistle' /></a> 
		   <a href=\"javascript:SmileIT(':unsure:','staff_shbox','staff_shbox_text')\"><img src='{$INSTALLER09['pic_base_url']}smilies/unsure.gif' alt='Unsure' title='Unsure' /></a> 
		   <a href=\"javascript:SmileIT(':blush:','staff_shbox','staff_shbox_text')\"><img src='{$INSTALLER09['pic_base_url']}smilies/blush.gif' alt='Blush' title='Blush' /></a> 
		   <a href=\"javascript:SmileIT(':hmm:','staff_shbox','staff_shbox_text')\"><img src='{$INSTALLER09['pic_base_url']}smilies/hmm.gif' alt='Hmm' title='Hmm' /></a> 
		   <a href=\"javascript:SmileIT(':hmmm:','staff_shbox','staff_shbox_text')\"><img src='{$INSTALLER09['pic_base_url']}smilies/hmmm.gif' alt='Hmmm' title='Hmmm' /></a> 
		   <a href=\"javascript:SmileIT(':huh:','staff_shbox','staff_shbox_text')\"><img src='{$INSTALLER09['pic_base_url']}smilies/huh.gif' alt='Huh' title='Huh' /></a> 
		   <a href=\"javascript:SmileIT(':look:','staff_shbox','staff_shbox_text')\"><img src='{$INSTALLER09['pic_base_url']}smilies/look.gif' alt='Look' title='Look' /></a> 
		   <a href=\"javascript:SmileIT(':rolleyes:','staff_shbox','staff_shbox_text')\"><img src='{$INSTALLER09['pic_base_url']}smilies/rolleyes.gif' alt='Roll Eyes' title='Roll Eyes' /></a> 
		   <a href=\"javascript:SmileIT(':kiss:','staff_shbox','staff_shbox_text')\"><img src='{$INSTALLER09['pic_base_url']}smilies/kiss.gif' alt='Kiss' title='Kiss' /></a> 
		   <a href=\"javascript:SmileIT(':blink:','staff_shbox','staff_shbox_text')\"><img src='{$INSTALLER09['pic_base_url']}smilies/blink.gif' alt='Blink' title='Blink' /></a> 
		   <a href=\"javascript:SmileIT(':baby:','staff_shbox','staff_shbox_text')\"><img src='{$INSTALLER09['pic_base_url']}smilies/baby.gif' alt='Baby' title='Baby' /></a>
	   </div>
	 </div>
   </form></div></div>";
}
if (!($CURUSER['opt2'] & user_options_2::SHOW_STAFFSHOUT)) {
    $HTMLOUT.= "<fieldset class='header'><legend><b>{$lang['index_staff_shoutbox']}</b></legend></fieldset><div class='container'><a class='btn btn-default' href='{$INSTALLER09['baseurl']}/staff_shoutbox.php?show_staffshout=1&amp;show_staff=yes'>{$lang['index_shoutbox_open']}</a></div><hr>";
}
//==end 09 Staff shoutbox
// End Class
// End File
