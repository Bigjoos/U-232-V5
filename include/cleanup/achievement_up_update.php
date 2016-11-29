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
function docleanup($data)
{
    global $INSTALLER09, $queries, $mc1;
    set_time_limit(0);
    ignore_user_abort(1);
    // *Updated* Upload Achievements Mod by MelvinMeow
    $res = sql_query("SELECT users.id, users.numuploads, usersachiev.ul FROM users LEFT JOIN usersachiev ON users.id = usersachiev.id WHERE enabled = 'yes' AND numuploads >= '1'") or sqlerr(__FILE__, __LINE__);
    $msg_buffer = $usersachiev_buffer = $achievements_buffer = array();
    if (mysqli_num_rows($res) > 0) {
        $dt = TIME_NOW;
        $subject = sqlesc("New Achievement Earned!");
        $points = rand(1, 3);
        while ($arr = mysqli_fetch_assoc($res)) {
            $uploads = (int)$arr['numuploads'];
            $ul = (int)$arr['ul'];
            if ($uploads >= 1 && $ul == 0) {
                $msg = sqlesc("Congratulations, you have just earned the [b]Uploader LVL1[/b] achievement. :) [img]".$INSTALLER09['baseurl']."/pic/achievements/ul1.png[/img]");
                $msgs_buffer[] = '(0,' . $arr['id'] . ',' . TIME_NOW . ', ' . sqlesc($msg) . ', ' . sqlesc($subject) . ')';
                $achievements_buffer[] = '(' . $arr['id'] . ', ' . TIME_NOW . ', \'Uploader LVL1\', \'ul1.png\' , \'Uploaded at least 1 torrent to the site.\')';
                $usersachiev_buffer[] = '(' . $arr['id'] . ',1, ' . $points . ')';
                $mc1->delete_value('inbox_new_' . $arr['id']);
                $mc1->delete_value('inbox_new_sb_' . $arr['id']);
                $mc1->delete_value('user_achievement_points_' . $arr['id']);
                $var1 = 'ul';
            }
            if ($uploads >= 50 && $ul == 1) {
                $msg = sqlesc("Congratulations, you have just earned the [b]Uploader LVL2[/b] achievement. :) [img]".$INSTALLER09['baseurl']."/pic/achievements/ul2.png[/img]");
                $msgs_buffer[] = '(0,' . $arr['id'] . ',' . TIME_NOW . ', ' . sqlesc($msg) . ', ' . sqlesc($subject) . ')';
                $achievements_buffer[] = '(' . $arr['id'] . ', ' . TIME_NOW . ', \'Uploader LVL2\', \'ul2.png\' , \'Uploaded at least 50 torrents to the site.\')';
                $usersachiev_buffer[] = '(' . $arr['id'] . ',2, ' . $points . ')';
                $mc1->delete_value('inbox_new_' . $arr['id']);
                $mc1->delete_value('inbox_new_sb_' . $arr['id']);
                $mc1->delete_value('user_achievement_points_' . $arr['id']);
                $var1 = 'ul';
            }
            if ($uploads >= 100 && $ul == 2) {
                $msg = sqlesc("Congratulations, you have just earned the [b]Uploader LVL3[/b] achievement. :) [img]".$INSTALLER09['baseurl']."/pic/achievements/ul3.png[/img]");
                $msgs_buffer[] = '(0,' . $arr['id'] . ',' . TIME_NOW . ', ' . sqlesc($msg) . ', ' . sqlesc($subject) . ')';
                $achievements_buffer[] = '(' . $arr['id'] . ', ' . TIME_NOW . ', \'Uploader LVL3\', \'ul3.png\' , \'Uploaded at least 100 torrents to the site.\')';
                $usersachiev_buffer[] = '(' . $arr['id'] . ',3, ' . $points . ')';
                $mc1->delete_value('inbox_new_' . $arr['id']);
                $mc1->delete_value('inbox_new_sb_' . $arr['id']);
                $mc1->delete_value('user_achievement_points_' . $arr['id']);
                $var1 = 'ul';
            }
            if ($uploads >= 200 && $ul == 3) {
                $msg = sqlesc("Congratulations, you have just earned the [b]Uploader LVL4[/b] achievement. :) [img]".$INSTALLER09['baseurl']."/pic/achievements/ul4.png[/img]");
                $msgs_buffer[] = '(0,' . $arr['id'] . ',' . TIME_NOW . ', ' . sqlesc($msg) . ', ' . sqlesc($subject) . ')';
                $achievements_buffer[] = '(' . $arr['id'] . ', ' . TIME_NOW . ', \'Uploader LVL4\', \'ul4.png\' , \'Uploaded at least 200 torrents to the site.\')';
                $usersachiev_buffer[] = '(' . $arr['id'] . ',4, ' . $points . ')';
                $mc1->delete_value('inbox_new_' . $arr['id']);
                $mc1->delete_value('inbox_new_sb_' . $arr['id']);
                $mc1->delete_value('user_achievement_points_' . $arr['id']);
                $var1 = 'ul';
            }
            if ($uploads >= 300 && $ul == 4) {
                $msg = sqlesc("Congratulations, you have just earned the [b]Uploader LVL5[/b] achievement. :) [img]".$INSTALLER09['baseurl']."/pic/achievements/ul5.png[/img]");
                $msgs_buffer[] = '(0,' . $arr['id'] . ',' . TIME_NOW . ', ' . sqlesc($msg) . ', ' . sqlesc($subject) . ')';
                $achievements_buffer[] = '(' . $arr['id'] . ', ' . TIME_NOW . ', \'Uploader LVL5\', \'ul5.png\' , \'Uploaded at least 300 torrents to the site.\')';
                $usersachiev_buffer[] = '(' . $arr['id'] . ',5, ' . $points . ')';
                $mc1->delete_value('inbox_new_' . $arr['id']);
                $mc1->delete_value('inbox_new_sb_' . $arr['id']);
                $mc1->delete_value('user_achievement_points_' . $arr['id']);
                $var1 = 'ul';
            }
            if ($uploads >= 500 && $ul == 5) {
                $msg = sqlesc("Congratulations, you have just earned the [b]Uploader LVL6[/b] achievement. :) [img]".$INSTALLER09['baseurl']."/pic/achievements/ul6.png[/img]");
                $msgs_buffer[] = '(0,' . $arr['id'] . ',' . TIME_NOW . ', ' . sqlesc($msg) . ', ' . sqlesc($subject) . ')';
                $achievements_buffer[] = '(' . $arr['id'] . ', ' . TIME_NOW . ', \'Uploader LVL6\', \'ul6.png\' , \'Uploaded at least 500 torrents to the site.\')';
                $usersachiev_buffer[] = '(' . $arr['id'] . ',6, ' . $points . ')';
                $mc1->delete_value('inbox_new_' . $arr['id']);
                $mc1->delete_value('inbox_new_sb_' . $arr['id']);
                $mc1->delete_value('user_achievement_points_' . $arr['id']);
                $var1 = 'ul';
            }
            if ($uploads >= 800 && $ul == 6) {
                $msg = sqlesc("Congratulations, you have just earned the [b]Uploader LVL7[/b] achievement. :) [img]".$INSTALLER09['baseurl']."/pic/achievements/ul7.png[/img]");
                $msgs_buffer[] = '(0,' . $arr['id'] . ',' . TIME_NOW . ', ' . sqlesc($msg) . ', ' . sqlesc($subject) . ')';
                $achievements_buffer[] = '(' . $arr['id'] . ', ' . TIME_NOW . ', \'Uploader LVL7\', \'ul7.png\' , \'Uploaded at least 800 torrents to the site.\')';
                $usersachiev_buffer[] = '(' . $arr['id'] . ',7, ' . $points . ')';
                $mc1->delete_value('inbox_new_' . $arr['id']);
                $mc1->delete_value('inbox_new_sb_' . $arr['id']);
                $mc1->delete_value('user_achievement_points_' . $arr['id']);
                $var1 = 'ul';
            }
            if ($uploads >= 1000 && $ul == 7) {
                $msg = sqlesc("Congratulations, you have just earned the [b]Uploader LVL8[/b] achievement. :) [img]".$INSTALLER09['baseurl']."/pic/achievements/ul8.png[/img]");
                $msgs_buffer[] = '(0,' . $arr['id'] . ',' . TIME_NOW . ', ' . sqlesc($msg) . ', ' . sqlesc($subject) . ')';
                $achievements_buffer[] = '(' . $arr['id'] . ', ' . TIME_NOW . ', \'Uploader LVL8\', \'ul8.png\' , \'Uploaded at least 1000 torrents to the site.\')';
                $usersachiev_buffer[] = '(' . $arr['id'] . ',8, ' . $points . ')';
                $mc1->delete_value('inbox_new_' . $arr['id']);
                $mc1->delete_value('inbox_new_sb_' . $arr['id']);
                $mc1->delete_value('user_achievement_points_' . $arr['id']);
                $var1 = 'ul';
            }
            if ($uploads >= 1500 && $ul == 8) {
                $msg = sqlesc("Congratulations, you have just earned the [b]Uploader LVL9[/b] achievement. :) [img]".$INSTALLER09['baseurl']."/pic/achievements/ul9.png[/img]");
                $msgs_buffer[] = '(0,' . $arr['id'] . ',' . TIME_NOW . ', ' . sqlesc($msg) . ', ' . sqlesc($subject) . ')';
                $achievements_buffer[] = '(' . $arr['id'] . ', ' . TIME_NOW . ', \'Uploader LVL9\', \'ul9.png\' , \'Uploaded at least 1500 torrents to the site.\')';
                $usersachiev_buffer[] = '(' . $arr['id'] . ',9, ' . $points . ')';
                $mc1->delete_value('inbox_new_' . $arr['id']);
                $mc1->delete_value('inbox_new_sb_' . $arr['id']);
                $mc1->delete_value('user_achievement_points_' . $arr['id']);
                $var1 = 'ul';
            }
            if ($uploads >= 2000 && $ul == 9) {
                $msg = sqlesc("Congratulations, you have just earned the [b]Uploader LVL10[/b] achievement. :) [img]".$INSTALLER09['baseurl']."/pic/achievements/ul10.png[/img]");
                $msgs_buffer[] = '(0,' . $arr['id'] . ',' . TIME_NOW . ', ' . sqlesc($msg) . ', ' . sqlesc($subject) . ')';
                $achievements_buffer[] = '(' . $arr['id'] . ', ' . TIME_NOW . ', \'Uploader LVL10\', \'ul10.png\' , \'Uploaded at least 2000 torrents to the site.\')';
                $usersachiev_buffer[] = '(' . $arr['id'] . ',10, ' . $points . ')';
                $mc1->delete_value('inbox_new_' . $arr['id']);
                $mc1->delete_value('inbox_new_sb_' . $arr['id']);
                $mc1->delete_value('user_achievement_points_' . $arr['id']);
                $var1 = 'ul';
            }
        }
        $count = count($achievements_buffer);
        if ($count > 0) {
            sql_query("INSERT INTO messages (sender,receiver,added,msg,subject) VALUES " . implode(', ', $msgs_buffer)) or sqlerr(__FILE__, __LINE__);
            sql_query("INSERT INTO achievements (userid, date, achievement, icon, description) VALUES " . implode(', ', $achievements_buffer) . " ON DUPLICATE key UPDATE date=values(date),achievement=values(achievement),icon=values(icon),description=values(description)") or sqlerr(__FILE__, __LINE__);
            sql_query("INSERT INTO usersachiev (id, $var1, achpoints) VALUES " . implode(', ', $usersachiev_buffer) . " ON DUPLICATE key UPDATE $var1=values($var1), achpoints=achpoints+values(achpoints)") or sqlerr(__FILE__, __LINE__);
            if ($queries > 0) write_log("Achievements Cleanup: Achievements Uploader Completed using $queries queries. Uploader Achievements awarded to - " . $count . " Member(s)");
        }
        unset($usersachiev_buffer, $achievements_buffer, $msgs_buffer, $count);
    }
    if (false !== mysqli_affected_rows($GLOBALS["___mysqli_ston"])) {
        $data['clean_desc'] = mysqli_affected_rows($GLOBALS["___mysqli_ston"]) . " items updated";
    }
    if ($data['clean_log']) {
        cleanup_log($data);
    }
}

?>
