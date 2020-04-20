<?php
/**
 * |--------------------------------------------------------------------------|
 * |   https://github.com/Bigjoos/                                            |
 * |--------------------------------------------------------------------------|
 * |   Licence Info: WTFPL                                                    |
 * |--------------------------------------------------------------------------|
 * |   Copyright (C) 2010 U-232 V5                                            |
 * |--------------------------------------------------------------------------|
 * |   A bittorrent tracker source based on TBDev.net/tbsource/bytemonsoon.   |
 * |--------------------------------------------------------------------------|
 * |   Project Leaders: Mindless, Autotron, whocares, Swizzles.               |
 * |--------------------------------------------------------------------------|
 * _   _   _   _   _     _   _   _   _   _   _     _   _   _   _
 * / \ / \ / \ / \ / \   / \ / \ / \ / \ / \ / \   / \ / \ / \ / \
 * ( U | - | 2 | 3 | 2 )-( S | o | u | r | c | e )-( C | o | d | e )
 * \_/ \_/ \_/ \_/ \_/   \_/ \_/ \_/ \_/ \_/ \_/   \_/ \_/ \_/ \_/
 *
 * @param mixed $id
 * @param mixed $what
 */
//putyn's rate mod
function getRate($id, $what)
{
    global $CURUSER, $mc1;
    if ($id == 0 || !in_array($what, [
        'topic',
        'torrent'
    ])) {
        return;
    }
    //== lets memcache $what fucker
    $keys['rating'] = 'rating_' . $what . '_' . $id . '_' . $CURUSER['id'];
    if (($rating_cache = $mc1->get_value($keys['rating'])) === false) {
        $qy = sql_query("SELECT sum(r.rating) as sum, count(r.rating) as count, r2.id as rated, r2.rating  FROM rating as r LEFT JOIN rating as r2 ON (r2." . $what . " = " . sqlesc($id) . " AND r2.user = " . sqlesc($CURUSER["id"]) . ") WHERE r." . $what . " = " . sqlesc($id) . " GROUP BY r." . $what) or sqlerr(__FILE__, __LINE__);
        $rating_cache = mysqli_fetch_assoc($qy);
        $mc1->cache_value($keys['rating'], $rating_cache, 0);
    }
    //== lets memcache $count fucker
    $keys['rating_count'] = 'rating_count_' . $what . '_' . $id . '_' . $CURUSER['id'];
    if (($completecount = $mc1->get_value($keys['rating_count'])) === false) {
        $completeres = sql_query("SELECT * FROM " . (XBT_TRACKER == true ? "xbt_files_users" : "snatched") . " WHERE " . (XBT_TRACKER == true ? "completedtime !=0" : "complete_date !=0") . " AND " . (XBT_TRACKER == true ? "uid" : "userid") . " = " . $CURUSER['id'] . " AND " . (XBT_TRACKER == true ? "fid" : "torrentid") . " = " . $id);
        $completecount = mysqli_num_rows($completeres);
        $mc1->cache_value($keys['rating_count'], $completecount, 180);
    }
    // outputs
    $p = ($rating_cache["count"] > 0 ? round((($rating_cache["sum"] / $rating_cache["count"]) * 20), 2) : 0);
    if ($rating_cache["rated"]) {
        $rate = "<ul class=\"star-rating\" title=\"You rated this " . $what . " " . htmlsafechars($rating_cache["rating"]) . " star" . (htmlsafechars($rating_cache["rating"]) > 1 ? "s" : "") . "\"><li style=\"width: " . $p . "%;\" class=\"current-rating\">.</li></ul>";
    } elseif ($what == 'torrent' && $completecount == 0) {
        $rate = "<ul class=\"star-rating\" title=\"You must download this " . $what . " in order to rate it.\"><li style=\"width: " . $p . "%;\" class=\"current-rating\">.</li></ul>";
    } else {
        $i = 1;
        $rate = "<ul class=\"star-rating\"><li style=\"width: " . $p . "%;\" class=\"current-rating\">.</li>";
        foreach ([
            "one-star",
            "two-stars",
            "three-stars",
            "four-stars",
            "five-stars"
        ] as $star) {
            $rate.= "<li><a href=\"rating.php?id=" . (int) $id . "&amp;rate=" . $i . "&amp;ref=" . urlencode($_SERVER["REQUEST_URI"]) . "&amp;what=" . $what . "\" class=\"" . $star . "\" onclick=\"do_rate(" . $i . "," . $id . ",'" . $what . "'); return false\" title=\"" . $i . " star" . ($i > 1 ? "s" : "") . " out of 5\" >$i</a></li>";
            $i++;
        }
        $rate.= "</ul>";
    }
    switch ($what) {
    case "torrent":
        $return = "<div id=\"rate_" . $id . "\">" . $rate . "</div>";
        break;
    case "topic":
        $return = "<div id=\"rate_" . $id . "\">" . $rate . "</div>";
        break;
    }
    return $return;
}
function showRate($rate_sum, $rate_count)
{
    $p = ($rate_count > 0 ? round((($rate_sum / $rate_count) * 20), 2) : 0);
    return "<ul class=\"star-rating\"><li style=\"width: " . $p . "%;\" class=\"current-rating\" >.</li></ul>";
}
//end putyn's rate mode
