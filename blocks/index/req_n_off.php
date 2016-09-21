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
//== category
$categorie = genrelist();
foreach ($categorie as $key => $value) $change[$value['id']] = array(
    'id' => $value['id'],
    'name' => $value['name'],
    'image' => $value['image']
);
$HTMLOUT.="<div class='panel panel-default'>
	<div class='panel-heading'>
		<label for='checkbox_4' class='text-left'>Requests and Offers</label>
	</div>
	<div class='panel-body'>";
//== Requests
$HTMLOUT.="<div class='panel panel-default'>
	<div class='panel-heading'>
		<label class='text-left'>Unfilled Requests</label>
	</div>
	<div class='panel-body'>";
$requests = array();
if (($requests = $mc1->get_value('requests_')) === false) {
    $res = sql_query("SELECT r.id AS request_id, r.request_name, r.category, r.comments, r.added, r.vote_yes_count, r.vote_no_count, r.filled_by_user_id, u.id, u.username, u.warned, u.suspended, u.enabled, u.donor, u.class, u.leechwarn, u.chatpost, u.pirate, u.king FROM requests AS r LEFT JOIN users AS u ON r.requested_by_user_id = u.id WHERE filled_by_user_id = '' ORDER BY added DESC LIMIT {$INSTALLER09['requests']['req_limit']}") or sqlerr(__FILE__, __LINE__);
    if (mysqli_num_rows($res)) {
        while ($request = mysqli_fetch_assoc($res)) $requests[] = $request;
        $mc1->cache_value('requests_', $requests, $INSTALLER09['expires']['req_limit']);
    }
}
if (count($requests) > 0) {
    $HTMLOUT.= "<table class='table table-striped table-bordered'>";
    $HTMLOUT.= " <thead><tr>
                <th class='col-md-1 text-left'><b>Category</b></th>
                <th class='col-md-5 text-left'><b>Title</b></th>
	        <th class='col-md-1 text-center'><b>Added</b></th>
        	<th class='col-md-1 text-center''>Comm</th>  
        	<th class='col-md-1 text-center''>Votes</th>
        	<th class='col-md-1 text-center'>Requested By</th>
<th class='col-md-1 text-center'>Filled</th>

</tr></thead>\n";
    if ($requests) {
        foreach ($requests as $requestarr) {
            $torrname = htmlsafechars($requestarr['request_name']);
            $requestarr['cat_name'] = htmlsafechars($change[$requestarr['category']]['name']);
	    $requestarr['cat_pic'] = htmlsafechars($change[$requestarr['category']]['image']);
   	    $request_f =($requestarr['filled_by_user_id'] > 0 ? '<a href="details.php?id=' . (int)$requestarr['filled_torrent_id'] . '" title="go to torrent page!!!"><span style="color: limegreen;font-weight: bold;">yes!</span></a>' : '<span style="color: red;font-weight: bold;">no</span>'); 
            
if (strlen($torrname) > 50) $torrname = substr($torrname, 0, 50) . "...";
            $HTMLOUT.= " <tbody><tr>
               <td class='text-center'><img src='{$INSTALLER09['pic_base_url']}caticons/{$CURUSER['categorie_icon']}/" . htmlsafechars($requestarr["cat_pic"]) . "' alt='" . htmlsafechars($requestarr["cat_name"]) . "' title='" . htmlsafechars($requestarr["cat_name"]) . "' /></td>
                <td class='text-left'><a href=\"{$INSTALLER09['baseurl']}/requests.php?action=request_details&amp;id=" . (int)$requestarr['request_id'] . "&amp;hit=1\" >{$torrname}</a></td>
		<td class='text-center'>" . get_date($requestarr['added'], 'LONG') . "</td>
        	<td class='text-center'>" . number_format($requestarr['comments']) . "</td>  
        	<td class='text-center'>yes: " . number_format($requestarr['vote_yes_count']) . "<br />
        				 no: " . number_format($requestarr['vote_no_count']) . "</td> 
        	<td class='text-center'>" . print_user_stuff($requestarr) . "</td>
		<td class='text-center'>" . $request_f . "</td>
</tr></tbody>";
        }
        $HTMLOUT.= "</table></div>";
    }
 
else {
     //== If there are no requests
        if (empty($requests)) $HTMLOUT.= "<tbody><tr><td class='text-left' colspan='5'>No Requests Found</td></tr></tbody></table></div>";
}
}
//==End
$HTMLOUT.= "</div>";
//== Offers
$HTMLOUT.="<div class='panel panel-default'>
	<div class='panel-heading'>
		<label class='text-left'>Offers</label>
	</div>
	<div class='panel-body'>";
$offers = array();
if (($offers = $mc1->get_value('offers_')) === false) {
    $res = sql_query("SELECT o.id AS offer_id, o.offer_name, o.category, o.comments, o.added, o.filled_torrent_id, o.vote_yes_count, o.vote_no_count, o.status, u.id, u.username, u.warned, u.suspended, u.enabled, u.donor, u.class, u.leechwarn, u.chatpost, u.pirate, u.king FROM offers AS o LEFT JOIN users AS u ON o.offered_by_user_id = u.id WHERE filled_torrent_id = 0 ORDER BY added DESC LIMIT {$INSTALLER09['offers']['off_limit']}") or sqlerr(__FILE__, __LINE__);
    if (mysqli_num_rows($res)) {
        while ($offer = mysqli_fetch_assoc($res)) $offers[] = $offer;
        $mc1->cache_value('offers_', $offers, $INSTALLER09['expires']['off_limit']);
    }
}
if (count($offers) > 0) {
    $HTMLOUT.= "<table class='table table-striped table-bordered'>";
    $HTMLOUT.= " <thead><tr>
                <th class='col-md-1 text-left'><b>Category</b></th>
                <th class='col-md-5 text-left'><b>Title</b></th>
	        <th class='col-md-1 text-center'><b>Added</b></th>
        	<th class='col-md-1 text-center''>Comm</th>  
        	<th class='col-md-1 text-center''>Votes</th>
        	<th class='col-md-1 text-center''>Offered</th>
                <th class='col-md-1 text-center''>Status</th>
                </tr></thead>\n";
    if ($offers) {
        foreach ($offers as $offerarr) {
            $torrname = htmlsafechars($offerarr['offer_name']);
            $offerarr['cat_name'] = htmlsafechars($change[$offerarr['category']]['name']);
	    $offerarr['cat_pic'] = htmlsafechars($change[$offerarr['category']]['image']);
 	    $status = ($offerarr['status'] == 'approved' ? '<span style="color: limegreen;font-weight: bold;">Approved!</span>' : ($offerarr['status'] == 'pending' ? '<span style="color: skyblue;font-weight: bold;">Pending...</span>' : '<span style="color: red;font-weight: bold;">denied</span>'));
             if (strlen($torrname) > 50) $torrname = substr($torrname, 0, 50) . "...";
            $HTMLOUT.= " <tbody><tr>
               <td class='text-center'><img src='{$INSTALLER09['pic_base_url']}caticons/{$CURUSER['categorie_icon']}/" . htmlsafechars($offerarr["cat_pic"]) . "' alt='" . htmlsafechars($offerarr["cat_name"]) . "' title='" . htmlsafechars($offerarr["cat_name"]) . "' /></td>
                <td class='text-left'><a href=\"{$INSTALLER09['baseurl']}/offers.php?action=offer_details&amp;id=" . (int)$offerarr['offer_id'] . "&amp;hit=1\" >{$torrname}</a></td>
		<td class='text-center'>" . get_date( $offerarr['added'], 'LONG') . "</td>
        	<td class='text-center'>" . number_format( $offerarr['comments']) . "</td>  
        	<td class='text-center'>yes: " . number_format( $offerarr['vote_yes_count']) . "<br />
        				 no: " . number_format( $offerarr['vote_no_count']) . "</td> 
        	<td class='text-center'>" . print_user_stuff($offerarr) . "</td>
		<td class='text-center'>" . $status . "</td>
</tr></tbody>";
        }
        $HTMLOUT.= "</table></div>";
    }
 
else {
   //== If there are no offers
        if (empty($offers)) $HTMLOUT.= "<tbody><tr><td class='text-left' colspan='5'>No Offers Found</td></tr></tbody></table></div>";
}
}
//==End
$HTMLOUT.= "</div></div></div>";
// End Class
// End File
