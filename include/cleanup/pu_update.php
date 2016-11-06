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
    //== Updated promote power users
    /*
    WANT TO CHANGE THIS.  LOOK FOR CLASS'S UNDER VIP OR A SET GROUP THE ADMIN CAN SELECT, THEN FOREACH?? THROUGH THEM, OPTIONS CAN BE SET BY ADMINS ON WHEN PEOPLE GET PROMOTED TO THE NEXT CLASS
    NEED
    RATIO
    TIME ON SITE (MAXDT)
    UPLOADED AMOUNT ($LIMIT)
    */
    //Get promotion rules from DB//
    $pconf = sql_query('SELECT * FROM class_promo ORDER BY id ASC ') or sqlerr(__FILE__, __LINE__);
    while ($ac = mysqli_fetch_assoc($pconf)) {
        $class_config[$ac['name']]['id']        = $ac['id'];
        $class_config[$ac['name']]['name']      = $ac['name'];
        $class_config[$ac['name']]['min_ratio'] = $ac['min_ratio'];
        $class_config[$ac['name']]['uploaded']  = $ac['uploaded'];
        $class_config[$ac['name']]['time']      = $ac['time'];
        $class_config[$ac['name']]['low_ratio'] = $ac['low_ratio'];
        // Set rules to easier to handle vars//
        $limit                                  = $class_config[$ac['name']]['uploaded'] * 1024 * 1024 * 1024;
        $minratio                               = $class_config[$ac['name']]['min_ratio'];
        $maxdt                                  = (TIME_NOW - 86400 * $class_config[$ac['name']]['time']);
        //Get the class value we are working on
        //AND Set the next class value to + 1
        $class_value                            = $class_config[$ac['name']]['name'];
        $res1                                   = sql_query("SELECT * from class_config WHERE value = '$class_value' ");
        while ($arr1 = mysqli_fetch_assoc($res1)) {
            //Changed for testing
            // As we are working on the class name which is being promoted to, we need to -1 from it, to get the class the users are currently in
            //  i.e UC_POWER_USER = 1, but we are promoting UC_USER = 0 to POWER_USER.
            $class_name = $arr1['classname'];
            $prev_class = $class_value - 1;
            /*
            $class = $arr1['value'];
            $next_class = $class + 1;
            */
        }
        // Get the class name and value of the previous class //
        $res2 = sql_query("SELECT * from class_config WHERE value = '$prev_class' ");
        while ($arr2 = mysqli_fetch_assoc($res2)) {
            $prev_class_name = $arr2['classname'];
        }
        //Search for users to be updated//
        $res = sql_query("SELECT id, uploaded, downloaded, invites, modcomment FROM users WHERE class = '$prev_class'  AND uploaded >= $limit AND uploaded / downloaded >= $minratio AND enabled='yes' AND added < $maxdt") or sqlerr(__FILE__, __LINE__);
        $msgs_buffer = $users_buffer = array();
        if (mysqli_num_rows($res) > 0) {
            
            $subject = "Class Promotion";
            $msg     = "Congratulations, you have been promoted to [b]" . $class_name . "[/b]. :)\n You get one extra invite.\n";
            while ($arr = mysqli_fetch_assoc($res)) {
                $ratio             = number_format($arr['uploaded'] / $arr['downloaded'], 3);
                $modcomment        = $arr['modcomment'];
                $userid            = $arr['id'];
                $modcomment        = get_date(TIME_NOW, 'DATE', 1) . " - Promoted to " . $class_name . " by System (UL=" . mksize($arr['uploaded']) . ", DL=" . mksize($arr['downloaded']) . ", R=" . $ratio . ").\n" . $modcomment;
                $modcom            = sqlesc($modcomment);
                $msgs_buffer[]     = '(0,' . $userid . ', ' . TIME_NOW . ', ' . sqlesc($msg) . ', ' . sqlesc($subject) . ')';
                $users_buffer[]    = '(' . $userid . ', ' . $class_value . ', 1, ' . $modcom . ')';
                $update['invites'] = ($arr['invites'] + 1);
                $mc1->begin_transaction('user' . $userid);
                $mc1->update_row(false, array(
                    'class' => $class_value,
                    'invites' => $update['invites']
                ));
                $mc1->commit_transaction($INSTALLER09['expires']['user_cache']);
                $mc1->begin_transaction('user_stats_' . $userid);
                $mc1->update_row(false, array(
                    'modcomment' => $modcomment
                ));
                $mc1->commit_transaction($INSTALLER09['expires']['user_stats']);
                $mc1->begin_transaction('MyUser_' . $userid);
                $mc1->update_row(false, array(
                    'class' => $class_value,
                    'invites' => $update['invites']
                ));
                $mc1->commit_transaction($INSTALLER09['expires']['curuser']);
                $mc1->delete_value('inbox_new_' . $userid);
                $mc1->delete_value('inbox_new_sb_' . $userid);
            }
            $count = count($users_buffer);
            if ($count > 0) {
                sql_query("INSERT INTO messages (sender,receiver,added,msg,subject) VALUES " . implode(', ', $msgs_buffer)) or sqlerr(__FILE__, __LINE__);
                sql_query("INSERT INTO users (id, class, invites, modcomment) VALUES " . implode(', ', $users_buffer) . " ON DUPLICATE key UPDATE class=values(class), invites = invites+values(invites), modcomment=values(modcomment)") or sqlerr(__FILE__, __LINE__);
                write_log("Cleanup: Promoted " . $count . " member(s) from " . $prev_class_name . " to " . $class_name . "");
                status_change($userid); //== For Retros announcement mod
            }
            unset($users_buffer, $msgs_buffer, $update, $count);
            
        }
        //==
        if ($queries > 0)
            write_log("$class_name Updates -------------------- Power User Updates Clean Complete using $queries queries--------------------");
        if (false !== mysqli_affected_rows($GLOBALS["___mysqli_ston"])) {
            $data['clean_desc'] = mysqli_affected_rows($GLOBALS["___mysqli_ston"]) . " items deleted/updated";
        }
        if ($data['clean_log']) {
            cleanup_log($data);
        }
    }
}
?> 
