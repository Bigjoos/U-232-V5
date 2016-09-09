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
//== Requests
$HTMLOUT.="<div class='panel panel-default'>
	<div class='panel-heading'>
		<label for='checkbox_4' class='text-left'>Unfilled Requests</label>
	</div>
	<div class='panel-body'>";
$requests = array();
if (($requests = $mc1->get_value('requests_')) === false) {
    $res = sql_query("SELECT id AS request_id, request_name, category, added, filled_by_user_id FROM requests WHERE filled_by_user_id = '' ORDER BY added DESC LIMIT {$INSTALLER09['requests']['req_limit']}") or sqlerr(__FILE__, __LINE__);
    while ($request = mysqli_fetch_assoc($res)) $requests[] = $request;
    $mc1->cache_value('requests_', $requests, $INSTALLER09['expires']['req_limit']);
}
if (count($requests) > 0) {
    $HTMLOUT.= "<div class='module'><div class='badge badge-top'></div>
                <table class='table table-striped table-bordered'>";
    $HTMLOUT.= " <thead><tr>
                <th class='col-md-1 text-left'><b>Category</b></th>
                <th class='col-md-5 text-left'><b>Title</b></th></tr></thead>\n";
    if ($requests) {
        foreach ($requests as $requestarr) {
            $torrname = htmlsafechars($requestarr['request_name']);
            $requestarr['cat_name'] = htmlsafechars($change[$requestarr['category']]['name']);
	    $requestarr['cat_pic'] = htmlsafechars($change[$requestarr['category']]['image']);
            if (strlen($torrname) > 50) $torrname = substr($torrname, 0, 50) . "...";
            $HTMLOUT.= " <tbody><tr>
               <td class='text-center'><img src='{$INSTALLER09['pic_base_url']}caticons/{$CURUSER['categorie_icon']}/" . htmlsafechars($requestarr["cat_pic"]) . "' alt='" . htmlsafechars($requestarr["cat_name"]) . "' title='" . htmlsafechars($requestarr["cat_name"]) . "' /></td>
                <td class='text-left'><a href=\"{$INSTALLER09['baseurl']}/requests.php?action=request_details&amp;id=" . (int)$requestarr['request_id'] . "&amp;hit=1\" >{$torrname}</a></td>
</tr></tbody>\n";
        }
        $HTMLOUT.= "</table><br />";
    }
} 
else {
    $HTMLOUT.= "<tbody><tr><td class='text-left' colspan='5'>No Requests Found</td></tr></tbody></table><br />";
}
//==End
$HTMLOUT.= "</div></div></div>";
//== Offers
$HTMLOUT.="<div class='panel panel-default'>
	<div class='panel-heading'>
		<label for='checkbox_4' class='text-left'>Offers</label>
	</div>
	<div class='panel-body'>";
$offers = array();
if (($offers = $mc1->get_value('offers_')) === false) {
    $res = sql_query("SELECT id AS offer_id, offer_name, category, added, filled_torrent_id FROM offers WHERE filled_torrent_id = 0 ORDER BY added DESC LIMIT {$INSTALLER09['offers']['off_limit']}") or sqlerr(__FILE__, __LINE__);
    while ($offer = mysqli_fetch_assoc($res)) $offers[] = $offer;
    $mc1->cache_value('offers_', $offers, $INSTALLER09['expires']['off_limit']);
}
if (count($offers) > 0) {
    $HTMLOUT.= "<div class='module'><div class='badge badge-top'></div>
                <table class='table table-striped table-bordered'>";
    $HTMLOUT.= " <thead><tr>
                <th class='col-md-1 text-left'><b>Category</b></th>
                <th class='col-md-5 text-left'><b>Title</b></th>
                </tr></thead>\n";
    if ($offers) {
        foreach ($offers as $offerarr) {
            $torrname = htmlsafechars($offerarr['offer_name']);
            $offerarr['cat_name'] = htmlsafechars($change[$offerarr['category']]['name']);
	    $offerarr['cat_pic'] = htmlsafechars($change[$offerarr['category']]['image']);
            if (strlen($torrname) > 50) $torrname = substr($torrname, 0, 50) . "...";
            $HTMLOUT.= " <tbody><tr>
               <td class='text-center'><img src='{$INSTALLER09['pic_base_url']}caticons/{$CURUSER['categorie_icon']}/" . htmlsafechars($offerarr["cat_pic"]) . "' alt='" . htmlsafechars($offerarr["cat_name"]) . "' title='" . htmlsafechars($offerarr["cat_name"]) . "' /></td>
                <td class='text-left'><a href=\"{$INSTALLER09['baseurl']}/offers.php?action=offer_details&amp;id=" . (int)$offerarr['offer_id'] . "&amp;hit=1\" >{$torrname}</a></td>
</tr></tbody>\n";
        }
        $HTMLOUT.= "</table><br />";
    }
} 
else {
    $HTMLOUT.= "<tbody><tr><td class='text-left' colspan='5'>No Offers Found</td></tr></tbody></table><br />";
}
//==End
$HTMLOUT.= "</div></div></div>";
// End Class
// End File
