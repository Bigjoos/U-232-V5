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
//== Requests
$HTMLOUT.= "
   <fieldset class='header'><legend>Unfilled Requests</legend></fieldset>
   <div class='container-fluid'>";
$requests = array();
if (($requests = $mc1->get_value('requests_')) === false) {
    $res = sql_query("SELECT r.id AS request_id, r.request_name, r.category, r.added, r.filled_by_user_id,  c.id AS cat_id, c.name AS cat_name, c.image AS cat_image FROM requests AS r LEFT JOIN categories AS c ON r.category = c.id WHERE r.filled_by_user_id = '' ORDER BY r.added DESC  LIMIT 10") or sqlerr(__FILE__, __LINE__);
    while ($request = mysqli_fetch_assoc($res)) $requests[] = $request;
    $mc1->cache_value('requests_', $requests, 60);
}
if (count($requests) > 0) {
    $HTMLOUT.= "<div class='module'><div class='badge badge-top'></div>
                <table class='table table-bordered'>";
    $HTMLOUT.= " <thead><tr>
                <th class='span5'><b>Title</b></th>
                <th class='span1'>Category</th>\n";
    if ($requests) {
        foreach ($requests as $requestarr) {
            $torrname = htmlsafechars($requestarr['request_name']);
            $catname = htmlsafechars($requestarr['cat_name']);
            if (strlen($torrname) > 50) $torrname = substr($torrname, 0, 50) . "...";
            $HTMLOUT.= " <tbody><tr>
                <td class='span5'><a href=\"{$INSTALLER09['baseurl']}/requests.php?action=request_details&amp;id=" . (int)$requestarr['request_id'] . "&amp;hit=1\" >{$torrname}</a></td>
<td class='span1'>" . $catname . "</td>
</tr></tbody>\n";
        }
        $HTMLOUT.= "</table></div><br />";
    }
} 
else {
    $HTMLOUT.= "<tbody><tr><td  colspan='5'>No Requests Found</td></tr></tbody></table></div><br />";
}
//==End
// End Class
// End File
