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
    set_time_limit(1200);
    ignore_user_abort(1);
    include (CACHE_DIR.'hit_and_run_settings.php');
    if ($INSTALLER09['hnr_online'] == 1){
    //===09 hnr by sir_snugglebunny
    $secs = $INSTALLER09['caindays'] * 86400;
    $hnr = TIME_NOW - $secs;
    $res = sql_query('SELECT id FROM snatched WHERE hit_and_run <> \'0\' AND hit_and_run < '.sqlesc($hnr)) or sqlerr(__FILE__, __LINE__);
    while ($arr = mysqli_fetch_assoc($res)) {
        sql_query('UPDATE snatched SET mark_of_cain = \'yes\' WHERE id='.sqlesc($arr['id'])) or sqlerr(__FILE__, __LINE__);
    }
    //=== hit and run... disable Downloading rights if they have 3 marks of cain
    $res_fuckers = sql_query('SELECT COUNT(*) AS poop, snatched.userid, users.username, users.modcomment, users.hit_and_run_total, users.downloadpos FROM snatched LEFT JOIN users ON snatched.userid = users.id WHERE snatched.mark_of_cain = \'yes\' AND users.hnrwarn = \'no\' AND users.immunity = \'0\' GROUP BY snatched.userid') or sqlerr(__FILE__, __LINE__);
    while ($arr_fuckers = mysqli_fetch_assoc($res_fuckers)) {
        if ($arr_fuckers['poop'] > $INSTALLER09['cainallowed'] && $arr_fuckers['downloadpos'] == 1) {
            //=== set them to no DLs
            $subject = sqlesc('Download disabled by System');
            $msg = sqlesc("Sorry ".htmlsafechars($arr_fuckers['username']).",\n Because you have ".$INSTALLER09['cainallowed']." or more torrents that have not been seeded to either a 1:1 ratio, or for the expected seeding time, your downloading rights have been disabled by the Auto system !\nTo get your Downloading rights back is simple,\n just start seeding the torrents in your profile [ click your username, then click your [url=".$INSTALLER09['baseurl']."/userdetails.php?id=".(int)$arr_fuckers['userid']."&completed=1]Completed Torrents[/url] link to see what needs seeding ] and your downloading rights will be turned back on by the Auto system after the next clean-time [ updates 4 times per hour ].\n\nDownloads are disabled after a member has three or more torrents that have not been seeded to either a 1 to 1 ratio, OR for the required seed time [ please see the [url=".$INSTALLER09['baseurl']."/faq.php]FAQ[/url] or [url=".$INSTALLER09['baseurl']."/rules.php]Site Rules[/url] for more info ]\n\nIf this message has been in error, or you feel there is a good reason for it, please feel free to PM a staff member with your concerns.\n\n we will do our best to fix this situation.\n\nBest of luck!\n ".$INSTALLER09['site_name']." staff.\n");
            $modcomment = $arr_fuckers['modcomment'];
            $modcomment = get_date(TIME_NOW, 'DATE', 1)." - Download rights removed for H and R - AutoSystem.\n".$modcomment;
            $modcom = sqlesc($modcomment);
            $_pms[] = '(0,'.sqlesc($arr_fuckers['userid']).','.sqlesc(TIME_NOW).','.$msg.','.$subject.',0)';
            $_users[] = '('.sqlesc($arr_fuckers['userid']).','.sqlesc($arr_fuckers['poop']).',0, \'yes\','.$modcom.')';
            if(count($_pms) > 0)
	         sql_query("INSERT INTO messages (sender, receiver, added, msg, subject, poster) VALUES ".implode(',',$_pms)) or sqlerr(__FILE__, __LINE__);	
	         if(count($_users) > 0)
	         sql_query("INSERT INTO users(id,hit_and_run_total,downloadpos,hnrwarn,modcomment) VALUES ".implode(',',$_users)." ON DUPLICATE key UPDATE hit_and_run_total=hit_and_run_total+values(hit_and_run_total),downloadpos=values(downloadpos),hnrwarn=values(hnrwarn),modcomment=values(modcomment)") or sqlerr(__FILE__, __LINE__);
	         unset($_pms,$_users);
            $update['hit_and_run_total'] = ($arr_fuckers['hit_and_run_total'] + $arr_fuckers['poop']);
            $mc1->begin_transaction('user'.$arr_fuckers['userid']);
            $mc1->update_row(false, array(
                'hit_and_run_total' => $update['hit_and_run_total'],
                'downloadpos' => 0,
                'hnrwarn' => 'yes'
            ));
            $mc1->commit_transaction($INSTALLER09['expires']['user_cache']);
            $mc1->begin_transaction('user_stats_'.$arr_fuckers['userid']);
            $mc1->update_row(false, array(
                'modcomment' => $modcomment
            ));
            $mc1->commit_transaction($INSTALLER09['expires']['user_stats']);
            $mc1->begin_transaction('userstats_'.$arr_fuckers['userid']);
            $mc1->update_row(false, array(
                'modcomment' => $modcomment
            ));
            $mc1->commit_transaction($INSTALLER09['expires']['user_stats']);
            $mc1->begin_transaction('MyUser_'.$arr_fuckers['userid']);
            $mc1->update_row(false, array(
                'hit_and_run_total' => $update['hit_and_run_total'],
                'downloadpos' => 0,
                'hnrwarn' => 'yes'
            ));
            $mc1->commit_transaction($INSTALLER09['expires']['curuser']);
            $mc1->delete_value('inbox_new_'.$arr_fuckers['userid']);
            $mc1->delete_value('inbox_new_sb_'.$arr_fuckers['userid']);
        }
    }
    //=== hit and run... turn their DLs back on if they start seeding again
    $res_good_boy = sql_query('SELECT id, username, modcomment FROM users WHERE hnrwarn = \'yes\' AND downloadpos = \'0\'') or sqlerr(__FILE__, __LINE__);
    while ($arr_good_boy = mysqli_fetch_assoc($res_good_boy)) {
        $res_count = sql_query('SELECT COUNT(*) FROM snatched WHERE userid = '.sqlesc($arr_good_boy['id']).' AND mark_of_cain = \'yes\'') or sqlerr(__FILE__, __LINE__);
        $arr_count = mysqli_fetch_row($res_count);
        if ($arr_count[0] < $INSTALLER09['cainallowed']) {
            //=== set them to yes DLs
            $subject = sqlesc('Download restored by System');
            $msg = sqlesc("Hi " . htmlsafechars($arr_good_boy['username']) . ",\n Congratulations ! Because you have seeded the torrents that needed seeding, your downloading rights have been restored by the Auto System !\n\nhave fun !\n " . $INSTALLER09['site_name'] . " staff.\n");
            $modcomment = $arr_good_boy['modcomment'];
            $modcomment = get_date(TIME_NOW, 'DATE', 1) . " - Download rights restored from H and R - AutoSystem.\n" . $modcomment;
            $modcom = sqlesc($modcomment);
            $_pms[] = '(0,'.sqlesc($arr_good_boy['id']).','.sqlesc(TIME_NOW).','.$msg.','.$subject.',0)';
		      $_users[] = '('.sqlesc($arr_good_boy['id']).',1,\'no\','.$modcom.')';
            if(count($_pms) > 0)
	         sql_query("INSERT INTO messages (sender, receiver, added, msg, subject, poster) VALUES ".implode(',',$_pms)) or sqlerr(__FILE__, __LINE__);	
	         if(count($_users) > 0)
	         sql_query("INSERT INTO users(id,downloadpos,hnrwarn,modcomment) VALUES ".implode(',',$_users)." ON DUPLICATE key UPDATE downloadpos=values(downloadpos),hnrwarn=values(hnrwarn),modcomment=values(modcomment)") or sqlerr(__FILE__, __LINE__);
	         unset($_pms,$_users);
            $mc1->begin_transaction('user' . $arr_good_boy['id']);
            $mc1->update_row(false, array(
                'downloadpos' => 1,
                'hnrwarn' => 'no'
            ));
            $mc1->commit_transaction($INSTALLER09['expires']['user_cache']);
            $mc1->begin_transaction('user_stats' . $arr_good_boy['id']);
            $mc1->update_row(false, array(
                'modcomment' => $modcomment
            ));
            $mc1->commit_transaction($INSTALLER09['expires']['user_stats']);
            $mc1->begin_transaction('userstats_' . $arr_good_boy['id']);
            $mc1->update_row(false, array(
                'modcomment' => $modcomment
            ));
            $mc1->commit_transaction($INSTALLER09['expires']['user_stats']);
            $mc1->begin_transaction('MyUser_' . $arr_good_boy['id']);
            $mc1->update_row(false, array(
                'downloadpos' => 1,
                'hnrwarn' => 'no'
            ));
            $mc1->commit_transaction($INSTALLER09['expires']['curuser']);
            $mc1->delete_value('inbox_new_' . $arr_good_boy['id']);
            $mc1->delete_value('inbox_new_sb_' . $arr_good_boy['id']);
        }
    }
    //==End
    if ($queries > 0) write_log("Hit And Run Clean -------------------- Hit And Run Complete using $queries queries--------------------");
    if (false !== mysqli_affected_rows($GLOBALS["___mysqli_ston"])) {
        $data['clean_desc'] = mysqli_affected_rows($GLOBALS["___mysqli_ston"]) . " items deleted/updated";
    }
    if ($data['clean_log']) {
        cleanup_log($data);
    }
}
}
?>
