<?php
if ($user['paranoia'] < 1 || $CURUSER['id'] == $id || $CURUSER['class'] >= UC_STAFF) {
    if (isset($user_status['last_status'])) $HTMLOUT.= "<tr valign='top'><td class='rowhead'>{$lang['userdetails_status']}</td><td align='left'>" . format_urls($user_status['last_status']) . "<br/><small>added " . get_date($user_status['last_update'], '', 0, 1) . "</small></td></tr>\n";
}
//==end
// End Class
// End File
