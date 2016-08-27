<?php
$lang = array(
	//ers
	'usersearch_error' => 'Error',
	'usersearch_warn' => 'Warning',
	'usersearch_bademail' => 'Bad email',
	'usersearch_badip' => 'Bad ip',
	'usersearch_badmask' => 'Bad subnet mask',
	'usersearch_badratio' => 'Bad ratio',
	'usersearch_badratio2' => 'Two ratios needed for this type of search.',
	'usersearch_badratio2' => 'Bad second ratio.',
	'usersearch_badup' => 'Bad upload ammount.',
	'usersearch_badup2' => 'Two uploaded amounts needed for this type of search.',
	'usersearch_badup3' => 'Bad second uploaded amount.',
	'usersearch_baddl' => 'Bad download ammount.',
	'usersearch_baddl2' => 'Two downloaded amounts needed for this type of search.',
	'usersearch_baddl3' => 'Bad second downloaded amount.',
	'usersearch_baddate' => 'Invalid date',
	'usersearch_baddate2' => 'Two dates needed for this type of search.',
	'usersearch_nouser' => 'No user was found.',
	//temp thingy
	'usersearch_count' => 'Count Query',
	'usersearch_query' => 'Search Query',
	'usersearch_url' => 'URL Parameters \'Actually\' Used',
	//main table
	'usersearch_window_title' => 'Administrative User Search',
	'usersearch_title' => 'Administrative User Search',
	'usersearch_inlink' => 'Instructions',
	'usersearch_reset' => 'Reset',
	'usersearch_name' => 'Name',
	'usersearch_ratio' => 'Ratio',
	'usersearch_status' => 'Member status',
	'usersearch_email' => 'Email',
	'usersearch_ip' => 'IP',
	'usersearch_acstatus' => 'Account status',
	'usersearch_comments' => 'Comments',
	'usersearch_mask' => 'Mask',
	'usersearch_class' => 'Class',
	'usersearch_joined' => 'Joined',
	'usersearch_uploaded' => 'Uploaded',
	'usersearch_donor' => 'Donor',
	'usersearch_lastseen' => 'Last seen',
	'usersearch_downloaded' => 'Downloaded',
	'usersearch_warned' => 'Warned',
	'usersearch_active' => 'Active only',
	'usersearch_banned' => 'Disabled IP',
	'usersearch_hnrwarn' => 'HNR Warned',
	//second table
	'usersearch_enabled' => 'Enabled',
	'usersearch_asts' => 'Status',
	'usersearch_history' => 'History',
	'usersearch_pR' => 'pR',
	'usersearch_pUL' => 'pUL (MB)',
	'usersearch_pDL' => 'pDL(MB)',
	//select area
	'usersearch_equal' => 'equal',     
	'usersearch_above' => 'above',     
	'usersearch_below' => 'below', 
	'usersearch_between' => 'between', 
	'usersearch_any' => "(any)",
	'usersearch_confirmed' => "confirmed",
	'usersearch_pending' => "pending",
	'usersearch_enabled' => "enabled",
	'usersearch_disabled' => "disabled",
	'usersearch_on' => "on",
	'usersearch_before' => "before",
	'usersearch_after' => "after",
	'usersearch_yes' => "Yes",
	'usersearch_no' => "No",
	'usersearch_create_ann' => "Create New Announcement",
	    //instructions
	'usersearch_instructions' => "<table border='0' align='center'><tr><td class='embedded' bgcolor='#F5F4EA'><div align='left'>\n
	    Fields left blank will be ignored;\n
	    Wildcards * and ? may be used in Name, Email and Comments, as well as multiple values\n
	    separated by spaces (e.g. 'wyz Max*' in Name will list both users named\n
	    'wyz' and those whose names start by 'Max'. Similarly  '~' can be used for\n
	    negation, e.g. '~alfiest' in comments will restrict the search to users\n
	    that do not have 'alfiest' in their comments).<br /><br />\n
       The Ratio field accepts 'Inf' and '---' besides the usual numeric values.<br /><br />\n
	    The subnet mask may be entered either in dotted decimal or CIDR notation\n
	    (e.g. 255.255.255.0 is the same as /24).<br /><br />\n
       Uploaded and Downloaded should be entered in GB.<br /><br />\n
	    For search parameters with multiple text fields the second will be\n
	    ignored unless relevant for the type of search chosen. <br /><br />\n
	    'Active only' restricts the search to users currently leeching or seeding,\n
	    'Disabled IPs' to those whose IPs also show up in disabled accounts.<br /><br />\n
	    The 'p' columns in the results show partial stats, that is, those\n
	    of the torrents in progress. <br /><br />\n
	    The History column lists the number of forum posts and torrent comments,\n
	    respectively, as well as linking to the history page.\n
	    </div></td></tr></table><br /><br />\n"
);
?>