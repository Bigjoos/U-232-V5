<?php
//==profile hits
if ($CURUSER["id"] == $user["id"] || $user['paranoia'] < 2) $HTMLOUT.= "<tr><td class='rowhead'>{$lang['userdetails_pviews']}</td><td align='left'><a href='staffpanel.php?tool=user_hits&amp;id=$id'>" . number_format((int)$user["hits"]) . "</a></td></tr>\n";
//==end
// End Class
// End File
