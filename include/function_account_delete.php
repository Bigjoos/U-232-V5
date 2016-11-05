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
//== Account delete function by Laffin
function account_delete($userid)
{
        $secs = 350 * 86400;
        $maxclass = UC_STAFF;
        $references = array(
		"id" => array("users","usersachiev","likes"), // Do Not move this line
		"userid" => array("blackjack","blocks","bookmarks","casino","coins","freeslots","friends","happyhour","happylog","ips","peers","pmboxes","reputation","shoutbox","snatched","uploadapp","user_blocks","ustatus","userhits","usercomments"
			),
                "uid" => array("xbt_files_users","thankyou"),
                "user_id" => array("poll_voters","posts","topics","subscriptions","read_posts"),
		"friendid" => array(
			"friends"
			),
		);
    $ctr = 1;
    foreach($references as $field => $tablelist)
    {
        foreach($tablelist as $table)
        {
            $tables[] = $tc = "t{$ctr}";
            $joins[] = ($ctr == 1) ? "users as {$tc}":"LEFT JOIN {$table} as {$tc} on t1.id={$tc}.{$field}";
            $ctr++;
        }
    }
    return 'DELETE '. implode(', ',$tables) . " FROM " . implode(' ',$joins) . " WHERE t1.id='".sqlesc($userid)."' AND t1.class < '".sqlesc($maxclass)."';";
}
?>
