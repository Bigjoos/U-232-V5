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
//== Member staff notes/flush torrents/watched user by snuggles
require_once (__DIR__ . DIRECTORY_SEPARATOR . 'include' . DIRECTORY_SEPARATOR . 'bittorrent.php');
require_once INCL_DIR . 'user_functions.php';
dbconn(false);
loggedinorreturn();
//=== get action posted so we know what to do :P
$posted_action = (isset($_POST['action']) ? htmlsafechars($_POST['action']) : (isset($_GET['action']) ? htmlsafechars($_GET['action']) : ''));
//=== add all possible actions here and check them to be sure they are ok
$valid_actions = array(
    'flush_torrents',
    'staff_notes',
    'watched_user'
);
$action = (in_array($posted_action, $valid_actions) ? $posted_action : '');
if ($action == '') {
    //=== redirect to index if they try to access the page directly ... perhaps add some hacker dork thingie here as well...
    header('Location: index.php');
} else {
    //=== add all new actions to this case switch thingie
    switch ($action) {
    case 'flush_torrents':
        $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
        //== if it's the member flushing
        if ($id == $CURUSER['id']) {
            //=== catch any missed snatched stuff thingies to stop ghost leechers from getting peers (if the peers they have drop off)
            sql_query('UPDATE snatched SET seeder=\'no\' WHERE userid = ' . sqlesc($CURUSER['id']));
            //=== flush dem torrents!!! \o/
            sql_query('DELETE FROM peers WHERE userid = ' . sqlesc($CURUSER['id']));
            $number_of_torrents_flushed = mysqli_affected_rows();
            //=== add it to the log
            sql_query('INSERT INTO `sitelog` (`id`, `added`, `txt`) VALUES (NULL , ' . TIME_NOW . ', ' . sqlesc('<a class="altlink" href="userdetails.php?id=' . $CURUSER['id'] . '">' . $CURUSER['username'] . '</a> flushed <b>' . $number_of_torrents_flushed . '</b> torrents.') . ')');
        }
        //=== if it's staff flushing for a member
        elseif ($id !== $CURUSER['id'] && $CURUSER['class'] >= UC_STAFF) {
            //=== it's a staff...
            $res_get_info = sql_query('SELECT username FROM users WHERE id=' . sqlesc($id));
            $user_get_info = mysqli_fetch_assoc($res_get_info);
            //=== catch any missed snatched stuff thingies to stop ghost leechers from getting peers (if the peers they have drop off)
            sql_query('UPDATE snatched SET seeder=\'no\' WHERE userid = ' . sqlesc($id));
            //=== flush dem torrents!!! \o/
            sql_query('DELETE FROM peers WHERE userid = ' . sqlesc($id));
            $number_of_torrents_flushed = mysqli_affected_rows();
            //=== add it to the log
            sql_query('INSERT INTO `sitelog` (`id`, `added`, `txt`) VALUES (NULL , ' . TIME_NOW . ', ' . sqlesc('<b>Staff Flush</b> <a class="altlink" href="userdetails.php?id=' . $CURUSER['id'] . '">' . $CURUSER['username'] . '</a> flushed <b>' . $number_of_torrents_flushed . '</b> torrents for <a class="altlink" href="userdetails.php?id=' . $id . '">' . $user_get_info['username'] . '</a>.') . ')');
        }
        break;

    case 'staff_notes':
        if ($CURUSER['class'] < UC_STAFF) {
            stderr('Error', 'How did you get here?');
        }
        $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
        $posted_notes = isset($_POST['new_staff_note']) ? htmlsafechars($_POST['new_staff_note']) : '';
        //=== make sure they are staff, not editing their own and playing nice :P
        $staff_notes_res = sql_query('SELECT staff_notes, class, username FROM users WHERE id=' . sqlesc($id)) or sqlerr(__FILE__, __LINE__);
        $staff_notes_arr = mysqli_fetch_assoc($staff_notes_res);
        if ($id !== $CURUSER['id'] && $CURUSER['class'] > $staff_notes_arr['class']) {
            //=== add / edit staff_notes
            sql_query('UPDATE users SET staff_notes = ' . sqlesc($posted_notes) . ' WHERE id =' . sqlesc($id)) or sqlerr(__FILE__, __LINE__);
            $mc1->begin_transaction('user' . $id);
            $mc1->update_row(false, array(
                'staff_notes' => $posted_notes
            ));
            $mc1->commit_transaction($INSTALLER09['expires']['user_cache']);
            //=== add it to the log
            write_log('<b>' . $CURUSER['username'] . '</b> edited member <a href="userdetails.php?id=' . $id . '" title="go to ' . htmlsafechars($staff_notes_arr['username']) . (substr($staff_notes_arr['username'], -1) == 's' ? '\'' : '\'s') . ' staff notes"><b>' . htmlsafechars($staff_notes_arr['username']) . (substr($staff_notes_arr['username'], -1) == 's' ? '\'' : '\'s') . '</b></a> staff notes. Changes made:<br />Was:<br />' . htmlsafechars($staff_notes_arr['staff_notes']) . '<br />is now:<br />' . htmlsafechars($_POST['new_staff_note']) . '');
        }
        header('Location: userdetails.php?id=' . $id . '&sn=1');
        break;

    case 'watched_user':
        if ($CURUSER['class'] < UC_STAFF) {
            stderr('Error', 'How did you get here?');
        }
        $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
        $posted = isset($_POST['watched_reason']) ? htmlsafechars($_POST['watched_reason']) : '';
        //=== make sure they are staff, not editing their own and playing nice :P
        $watched_res = sql_query('SELECT watched_user, watched_user_reason, class, username FROM users WHERE id=' . sqlesc($id)) or sqlerr(__FILE__, __LINE__);
        $watched_arr = mysqli_fetch_assoc($watched_res);
        if ($id !== $CURUSER['id'] || $CURUSER['class'] < $watched_arr['class']) {
            //=== add / remove from watched users
            if (isset($_POST['add_to_watched_users']) && $_POST['add_to_watched_users'] == 'yes' && $watched_arr['watched_user'] == 0) {
                //=== set them to watched user
                sql_query('UPDATE users SET watched_user = ' . TIME_NOW . ' WHERE id = ' . sqlesc($id)) or sqlerr(__FILE__, __LINE__);
                $mc1->begin_transaction('MyUser_' . $id);
                $mc1->update_row(false, array(
                    'watched_user' => TIME_NOW
                ));
                $mc1->commit_transaction($INSTALLER09['expires']['curuser']);
                $mc1->begin_transaction('user' . $id);
                $mc1->update_row(false, array(
                    'watched_user' => TIME_NOW
                ));
                $mc1->commit_transaction($INSTALLER09['expires']['user_cache']);
                //=== add it to the log
                write_log('<b>' . $CURUSER['username'] . '</b> added member <a href="userdetails.php?id=' . $id . '" title="go to ' . htmlsafechars($watched_arr['username']) . (substr($watched_arr['username'], -1) == 's' ? '\'' : '\'s') . ' page">' . htmlsafechars($watched_arr['username']) . '</a> to watched users.');
            }
            if (isset($_POST['add_to_watched_users']) && $_POST['add_to_watched_users'] == 'no' && $watched_arr['watched_user'] > 0) {
                //=== remove them from watched users
                sql_query('UPDATE users SET watched_user = 0 WHERE id = ' . sqlesc($id)) or sqlerr(__FILE__, __LINE__);
                $mc1->begin_transaction('MyUser_' . $id);
                $mc1->update_row(false, array(
                    'watched_user' => 0
                ));
                $mc1->commit_transaction($INSTALLER09['expires']['curuser']);
                $mc1->begin_transaction('user' . $id);
                $mc1->update_row(false, array(
                    'watched_user' => 0
                ));
                $mc1->commit_transaction($INSTALLER09['expires']['user_cache']);
                //=== add it to the log
                write_log('<b>' . $CURUSER['username'] . '</b> removed member <a href="userdetails.php?id=' . $id . '" title="go to ' . htmlsafechars($watched_arr['username']) . (substr($watched_arr['username'], -1) == 's' ? '\'' : '\'s') . ' page">' . htmlsafechars($watched_arr['username']) . '</a> from watched users. <br />' . htmlsafechars($watched_arr['username']) . ' had been on the list since ' . get_date($watched_arr['watched_user'], '') . '.', $CURUSER['id']);
            }
            //=== only change if different
            if ($_POST['watched_reason'] !== $watched_arr['watched_user_reason']) {
                //=== edit watched users text
                sql_query('UPDATE users SET watched_user_reason = ' . sqlesc($posted) . ' WHERE id = ' . sqlesc($id)) or sqlerr(__FILE__, __LINE__);
                $mc1->begin_transaction('user' . $id);
                $mc1->update_row(false, array(
                    'watched_user_reason' => $posted
                ));
                $mc1->commit_transaction($INSTALLER09['expires']['user_cache']);
                //=== add it to the log
                write_log('<b>' . $CURUSER['username'] . '</b> changed watched user text for: <a href="userdetails.php?id=' . $id . '" title="go to ' . htmlsafechars($watched_arr['username']) . (substr($watched_arr['username'], -1) == 's' ? '\'' : '\'s') . ' page">' . htmlsafechars($watched_arr['username']) . '</a>  Changes made:<br />Text was:<br />' . htmlsafechars($watched_arr['watched_user_reason']) . '<br />Is now:<br />' . htmlsafechars($_POST['watched_reason']) . '');
            }
        }
        header('Location: userdetails.php?id=' . $id . '&wu=1');
        break;
    } //=== end switch
    
} //=== end of else (no action)

?>
