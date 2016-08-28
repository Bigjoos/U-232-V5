<?php
//==Rep
$member_reputation = get_reputation($user, 'users');
$HTMLOUT.= "<tr><td class='rowhead' valign='top' align='right' width='1%'>{$lang['userdetails_rep']}</td><td align='left' width='99%'>{$member_reputation}<br /></td></tr>";
//==end
// End Class
// End File
