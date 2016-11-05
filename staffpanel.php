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
/****************************************************************\
 * Staff panel for the TBDEV source code                          *
 * -------------------------------------------------------------- *
 * An easy to config staff panel for different staff classes,     *
 * with different options for each class, like add, edit, delete  *
 * the pages and to log the actions.                              *
 * -------------------------------------------------------------- *
 *                                                                *
 * @Conversion: Bigjoos for TBDEV.NET 09                          *
 * @copyright: Alex2005                                           *
 * @package: Staff Panel                                          *
 * @category: Staff Tools                                         *
 * @version: v2 30/06/2010                                        *
 * @license: GNU General Public License                           *
 \****************************************************************/
require_once(__DIR__ . DIRECTORY_SEPARATOR . 'include' . DIRECTORY_SEPARATOR . 'bittorrent.php');
require_once(INCL_DIR . 'user_functions.php');
require_once(INCL_DIR . 'html_functions.php');
dbconn(true);
loggedinorreturn();
$HTMLOUT = '';
$lang = array_merge(load_language('global'), load_language('staff_panel'));

//== 
$staff_classes1['name'] = '';
$staff = sqlesc(UC_STAFF);
if (($staff_classes = $mc1->get_value('is_staffs_')) === false) {
    $res = sql_query("SELECT value from class_config WHERE name NOT IN ('UC_MIN', 'UC_STAFF', 'UC_MAX') AND value >= '$staff' ORDER BY value asc");
    $staff_classes = array();
    while (($row = mysqli_fetch_assoc($res))) {
        $staff_classes[] = $row['value'];
        $mc1->cache_value('is_staffs_', $staff_classes, 900); //==  test values 900 to 0 with delete keys //==
    }
}
if (!$CURUSER)
    stderr($lang['spanel_error'], $lang['spanel_access_denied']);
/**
 * Staff classes config
 *
 * UC_XYZ  : integer -> the name of the defined class
 *
 * Options for a selected class
 ** add    : boolean -> enable/disable page adding
 ** edit   : boolean -> enable/disable page editing
 ** delete : boolean -> enable/disable page deletion
 ** log    : boolean -> enable/disable the loging of the actions
 *
 * @ result $staff_classes array();
 * @ new $staff_tools array add in following format : 'delacct'         => 'delacct',
 *
 */
if ($INSTALLER09['staffpanel_online'] == 0)
    stderr($lang['spanel_information'], $lang['spanel_panel_cur_offline']);
define('IN_INSTALLER09_ADMIN', true);
require_once(CLASS_DIR . 'class_check.php');
class_check(UC_STAFF);
$action = (isset($_GET['action']) ? htmlsafechars($_GET['action']) : (isset($_POST['action']) ? htmlsafechars($_POST['action']) : NULL));
$id = (isset($_GET['id']) ? (int) $_GET['id'] : (isset($_POST['id']) ? (int) $_POST['id'] : NULL));
$class_color = (function_exists('get_user_class_color') ? true : false);
$tool = (isset($_GET['tool']) ? $_GET['tool'] : (isset($_POST['tool']) ? $_POST['tool'] : NULL));
$tool = isset($_GET['tool']) ? $_GET['tool'] : '';

//Might as well build this from the DB I think.//
$staff_tools = array(
    'bans' => 'bans',
    'adduser' => 'adduser',
    'stats' => 'stats',
    'delacct' => 'delacct',
    'testip' => 'testip',
    'usersearch' => 'usersearch',
    'mysql_overview' => 'mysql_overview',
    'mysql_stats' => 'mysql_stats',
    'shistory' => 'shistory',
    'categories' => 'categories',
    'docleanup' => 'docleanup',
    'log' => 'log',
    'news' => 'news',
    'freeleech' => 'freeleech',
    'freeusers' => 'freeusers',
    'donations' => 'donations',
    'failedlogins' => 'failedlogins',
    'cheaters' => 'cheaters',
    'flush' => 'flush',
    'themes' => 'themes',
    'editlog' => 'editlog',
    'reset' => 'reset',
    'iphistory' => 'iphistory',
    'ipsearch' => 'ipsearch',
    'ipcheck' => 'ipcheck',
    'inactive' => 'inactive',
    'snatched_torrents' => 'snatched_torrents',
    'events' => 'events',
    'bonusmanage' => 'bonusmanage',
    'floodlimit' => 'floodlimit',
    'stats_extra' => 'stats_extra',
    'polls_manager' => 'polls_manager',
    'findnotconnectable' => 'findnotconnectable',
    'namechanger' => 'namechanger',
    'backup' => 'backup',
    'pmview' => 'pmview',
    'reports' => 'reports',
    'nameblacklist' => 'nameblacklist',
    'system_view' => 'system_view',
    'datareset' => 'datareset',
    'grouppm' => 'grouppm',
    'load' => 'load',
    'allagents' => 'allagents',
    'watched_users' => 'watched_users',
    'sysoplog' => 'sysoplog',
    'forum_manage' => 'forum_manage',
    'forum_config' => 'forum_config',
    'over_forums' => 'over_forums',
    'forummanager' => 'forummanager',
    'msubforums' => 'msubforums',
    'moforums' => 'moforums',
    'member_post_history' => 'member_post_history',
    'comment_overview' => 'comment_overview',
    'reputation_ad' => 'reputation_ad',
    'reputation_settings' => 'reputation_settings',
    'mega_search' => 'mega_search',
    'shit_list' => 'shit_list',
    'acpmanage' => 'acpmanage',
    'class_config' => 'class_config',
    'warn' => 'warn',
    'leechwarn' => 'leechwarn',
    'hnrwarn' => 'hnrwarn',
    'cleanup_manager' => 'cleanup_manager',
    'view_peers' => 'view_peers',
    'uploader_info' => 'uploader_info',
    'block.settings' => 'block.settings',
    'groupmessage' => 'groupmessage',
    'paypal_settings' => 'paypal_settings',
    'staff_config' => 'staff_config',
    'site_settings' => 'site_settings',
    'user_hits' => 'user_hits',
    'op' => 'op',
    'memcache' => 'memcache',
    'invite_tree' => 'invite_tree',
    'edit_moods' => 'edit_moods',
    'mass_bonus_for_members' => 'mass_bonus_for_members',
    'deathrow' => 'deathrow',
    'hit_and_run' => 'hit_and_run',
    'hit_and_run_settings' => 'hit_and_run_settings',
    'uploadapps' => 'uploadapps',
    'modtask' => 'modtask',
    'staff_shistory' => 'staff_shistory',
    'bannedemails' => 'bannedemails',
    'cloudview' => 'cloudview',
    'rules_admin' => 'rules_admin',
    'faq_admin' => 'faq_admin',
    'referrers' => 'referrers',
	'traceroute' => 'traceroute',
    'modded_torrents' => 'modded_torrents',
    'comments' => 'comments',
    'comment_check' => 'comment_check',
    'class_promo' => 'class_promo',
    'addpre' => 'addpre'
);
if (in_array($tool, $staff_tools) and file_exists(ADMIN_DIR . $staff_tools[$tool] . '.php')) {
    require_once ADMIN_DIR . $staff_tools[$tool] . '.php';
} else {
    if ($action == 'delete' && is_valid_id($id) && $CURUSER['class'] == UC_MAX) {
        $sure = ((isset($_GET['sure']) ? $_GET['sure'] : '') == 'yes');
        $res = sql_query('SELECT av_class' . (!$sure || $CURUSER['class'] <= UC_MAX ? ', page_name' : '') . ' FROM staffpanel WHERE id = ' . sqlesc($id)) or sqlerr(__FILE__, __LINE__);
        $arr = mysqli_fetch_assoc($res);
        if ($CURUSER['class'] < $arr['av_class'])
            stderr($lang['spanel_error'], $lang['spanel_you_not_allow_del_page']);
        if (!$sure)
            stderr($lang['spanel_sanity_check'], $lang['spanel_are_you_sure_del'].': "' . htmlsafechars($arr['page_name']) . '"? '.$lang['spanel_click'].' <a href="' . $_SERVER['PHP_SELF'] . '?action=' . $action . '&amp;id=' . $id . '&amp;sure=yes">'.$lang['spanel_here'].'</a> '.$lang['spanel_to_del_it_or'].' <a href="' . $_SERVER['PHP_SELF'] . '">'.$lang['spanel_here'].'</a> '.$lang['spanel_to_go_back'].'.');
        sql_query('DELETE FROM staffpanel WHERE id = ' . sqlesc($id)) or sqlerr(__FILE__, __LINE__);
        $mc1->delete_value('is_staffs_');
        if (mysqli_affected_rows($GLOBALS["___mysqli_ston"])) {
            if ($CURUSER['class'] <= UC_MAX)
                write_log($lang['spanel_page'].' "' . htmlsafechars($arr['page_name']) . '"(' . ($class_color ? '[color=#' . get_user_class_color($arr['av_class']) . ']' : '') . get_user_class_name($arr['av_class']) . ($class_color ? '[/color]' : '') . ') '.$lang['spanel_was_del_sp_by'].' [url=' . $INSTALLER09['baseurl'] . '/userdetails.php?id=' . (int) $CURUSER['id'] . ']' . $CURUSER['username'] . '[/url](' . ($class_color ? '[color=#' . get_user_class_color($CURUSER['class']) . ']' : '') . get_user_class_name($CURUSER['class']) . ($class_color ? '[/color]' : '') . ')');
            header('Location: ' . $_SERVER['PHP_SELF']);
            exit();
        } else
            stderr($lang['spanel_error'], $lang['spanel_db_error_msg']);
    } else if (($action == 'add' && $CURUSER['class'] == UC_MAX) || ($action == 'edit' && is_valid_id($id) && $CURUSER['class'] == UC_MAX)) {
        $names = array(
            'page_name',
            'file_name',
            'description',
            'type',
            'av_class'
        );
        if ($action == 'edit') {
            $res = sql_query('SELECT ' . implode(', ', $names) . ' FROM staffpanel WHERE id = ' . sqlesc($id)) or sqlerr(__FILE__, __LINE__);
            $arr = mysqli_fetch_assoc($res);
        }
        foreach ($names as $name)
            $$name = (isset($_POST[$name]) ? $_POST[$name] : ($action == 'edit' ? $arr[$name] : ''));
        if ($action == 'edit' && $CURUSER['class'] < $av_class)
            stderr($lang['spanel_error'], $lang['spanel_cant_edit_this_pg']);
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $errors = array();
            if (empty($page_name))
                $errors[] = $lang['spanel_the_pg_name'].' '.$lang['spanel_cannot_be_empty'].'.';
            if (empty($file_name))
                $errors[] = $lang['spanel_the_filename'].' '.$lang['spanel_cannot_be_empty'].'.';
            if (empty($description))
                $errors[] = $lang['spanel_the_descr'].' '.$lang['spanel_cannot_be_empty'].'.';
            if (!in_array((int)$av_class, $staff_classes))
                $errors[] = $lang['spanel_selected_class_not_valid'];

            if (!is_file($file_name . '.php') && !empty($file_name) && !preg_match('/.php/', $file_name))
                $errors[] = $lang['spanel_inexistent_php_file'];
            if (strlen($page_name) < 4 && !empty($page_name))
                $errors[] = $lang['spanel_the_pg_name'].' '.$lang['spanel_is_too_short_min_4'].'.';
            if (strlen($page_name) > 80)
                $errors[] = $lang['spanel_the_pg_name'].' '.$lang['spanel_is_too_long'].' ('.$lang['spanel_max_80'].').';
            if (strlen($file_name) > 80)
                $errors[] = $lang['spanel_the_filename'].' '.$lang['spanel_is_too_long'].' ('.$lang['spanel_max_80'].').';
            if (strlen($description) > 100)
                $errors[] = $lang['spanel_the_descr'].' '.$lang['spanel_is_too_long'].' ('.$lang['spanel_max_100'].').';
            if (empty($errors)) {
                if ($action == 'add') {
                    $res = sql_query("INSERT INTO staffpanel (page_name, file_name, description, type, av_class, added_by, added) " . "VALUES (" . implode(", ", array_map("sqlesc", array(
                        $page_name,
                        $file_name,
                        $description,
                        $type,
                        (int) $av_class,
                        (int) $CURUSER['id'],
                        TIME_NOW
                    ))) . ")");
                    $mc1->delete_value('is_staffs_');
                    if (!$res) {
                        if (((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_errno($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_errno()) ? $___mysqli_res : false)) == 1062)
                            $errors[] = $lang['spanel_this_fname_sub'];
                        else
                            $errors[] = $lang['spanel_db_error_msg'];
                    }
                } else {
                    $res = sql_query("UPDATE staffpanel SET page_name = " . sqlesc($page_name) . ", file_name = " . sqlesc($file_name) . ", description = " . sqlesc($description) . ", type = " . sqlesc($type) . ", av_class = " . sqlesc((int) $av_class) . " WHERE id = " . sqlesc($id)) or sqlerr(__FILE__, __LINE__);
                    $mc1->delete_value('is_staffs_');
                    if (!$res)
                        $errors[] = $lang['spanel_db_error_msg'];
                }
                if (empty($errors)) {
                    if ($CURUSER['class'] <= UC_MAX)
                        write_log($lang['spanel_page'].' "' . $page_name . '"(' . ($class_color ? '[color=#' . get_user_class_color($av_class) . ']' : '') . get_user_class_name($av_class) . ($class_color ? '[/color]' : '') . ') '.$lang['spanel_in_the_sp_was'].' ' . ($action == 'add' ? 'added' : 'edited') . ' by [url=' . $INSTALLER09['baseurl'] . '/userdetails.php?id=' . $CURUSER['id'] . ']' . $CURUSER['username'] . '[/url](' . ($class_color ? '[color=#' . get_user_class_color($CURUSER['class']) . ']' : '') . get_user_class_name($CURUSER['class']) . ($class_color ? '[/color]' : '') . ')');
                    header('Location: ' . $_SERVER['PHP_SELF']);
                    exit();
                }
            }
        }
$HTMLOUT.="<div class='container'>";
        if (!empty($errors)) {
            $HTMLOUT .= stdmsg($lang['spanel_there'].' ' . (count($errors) > 1 ? 'are' : 'is') . ' ' . count($errors) . ' error' . (count($errors) > 1 ? 's' : '') . ' '.$lang['spanel_in_the_form'].'.', '<b>' . implode('<br />', $errors) . '</b>');
            $HTMLOUT .= "<br>";
        }
        $HTMLOUT .= "<form class='form-horizontal' method='post' action='{$_SERVER['PHP_SELF']}'>
    <input class='form-control' type='hidden' name='action' value='{$action}'>";
        if ($action == 'edit') {
            $HTMLOUT .= "<input class='form-control' type='hidden' name='id' value='{$id}'>";
        }
        $HTMLOUT .= "<table class='table table-striped table-bordered text-left' cellpadding='5' width='100%'>
    <tr class='colhead'>
    <td colspan='2'>
     " . ($action == 'edit' ? $lang['spanel_edit'].' "' . $page_name . '"' : $lang['spanel_add_a_new']) . ' page' . "</td>
    </tr>
    <tr>
    <td class='rowhead' width='1%'>{$lang['spanel_pg_name']}</td><td align='left'><input type='text' size='50' name='page_name' value='{$page_name}' /></td>
    </tr>
    <tr>
    <td class='rowhead'>{$lang['spanel_filename']}</td><td align='left'><input type='text' size='50' name='file_name' value='{$file_name}' /><b></b></td>
    </tr>
    <tr>
    <td class='rowhead'>{$lang['spanel_description']}</td><td align='left'><input type='text' size='50' name='description' value='{$description}' /></td>
    </tr>";   
        $types = array(
            'user',
            'settings',
            'stats',
            'other'
        );    
        $HTMLOUT .= "<tr><td class='rowhead'>{$lang['spanel_type_of_tool']}</td><td align='left'><select name='type'>";
        foreach ($types as $types) {
            $HTMLOUT .= '<option value="' . $types . '"' . ($types == $type ? ' selected="selected"' : '') . '>' . ucfirst($types) . '
</option>';
        }
        $HTMLOUT .= "</select></td></tr>";   
     $HTMLOUT .= "<tr>
    <td class='rowhead'><span style='white-space: nowrap;'>{$lang['spanel_available_for']}</span></td>
    <td align='left'>";        
        $HTMLOUT .= "<select name='av_class'>";
        $maxclass = UC_MAX;
        for ($class = UC_STAFF; $class <= $maxclass; ++$class)
            $HTMLOUT .= '<option' . ($class_color ? ' style="background-color:#' . get_user_class_color($class) . ';"' : '') . ' value="' . $class . '"' . ($class == $av_class ? ' selected="selected"' : '') . '>' . get_user_class_name($class) . '</option>';
        $HTMLOUT .= "</select></td>";  
         $HTMLOUT .= "</tr></table>  
     <table class='table table-striped table-bordered'>
     <tr>
     <td style='border:none;' align='center'><input type='submit' value='{$lang['spanel_submit']}' /></td>
     <td colspan='2' style='border:none;'>
     <form method='post' action='{$_SERVER['PHP_SELF']}'><input type='submit' value='{$lang['spanel_cancel']}' /></form>
         </td>
     </tr>
     </table></form>";
     $HTMLOUT.="</div>";
        echo stdhead($lang['spanel_header'].' :: ' . ($action == 'edit' ? ''.$lang['spanel_edit'].' "' . $page_name . '"' : $lang['spanel_add_a_new']) . ' page') . $HTMLOUT . stdfoot();
    } else {
     $HTMLOUT.="<div class='container'>";
        $HTMLOUT .= "
<h1 align='center'>{$lang['spanel_welcome']} {$CURUSER['username']} {$lang['spanel_to_the']} {$lang['spanel_header']}!</h1><br>";
        if ($CURUSER['class'] == UC_MAX) {
$HTMLOUT .= "<div class='row'><span class='label'><h2>{$lang['spanel_options']}</h2><h3><a href='staffpanel.php?action=add' title={$lang['spanel_add_a_new_pg']}>{$lang['spanel_add_a_new_pg']}</a></h3></span></div>";
          }
        $res = sql_query('SELECT staffpanel.*, users.username ' . 'FROM staffpanel ' . 'LEFT JOIN users ON users.id = staffpanel.added_by ' . 'WHERE av_class <= ' . sqlesc($CURUSER['class']) . ' ' . 'ORDER BY av_class DESC, page_name ASC') or sqlerr(__FILE__, __LINE__);
        if (mysqli_num_rows($res) > 0) {
            $db_classes = $unique_classes = $mysql_data = array();
            while ($arr = mysqli_fetch_assoc($res))
                $mysql_data[] = $arr;
            foreach ($mysql_data as $key => $value)
                $db_classes[$value['av_class']][] = $value['av_class'];
            $i = 1;
            foreach ($mysql_data as $key => $arr) {
                $end_table = (count($db_classes[$arr['av_class']]) == $i ? true : false);
                if (!in_array($arr['av_class'], $unique_classes)) {
                    $unique_classes[] = $arr['av_class'];
                    $HTMLOUT .= "<table class='table table-striped table-bordered'>
      <tr>
      <td colspan='4' align='center'>
      <h2>" . ($class_color ? '<font color="#' . get_user_class_color($arr['av_class']) . '">' : '') . get_user_class_name($arr['av_class']) . ' Panel' . ($class_color ? '</font>' : '') . "</h2>
      </td>
      </tr>
      <tr align='center'>
      <td class='colhead' align='left' width='100%'>{$lang['spanel_pg_name']}</td>
      <td class='colhead'><span style='white-space: nowrap;'>{$lang['spanel_added_by']}</span></td>
      <td class='colhead'><span style='white-space: nowrap;'>{$lang['spanel_date_added']}</span></td>";
                    if ($CURUSER['class'] == UC_MAX) {
                        $HTMLOUT .= "<td class='colhead'>{$lang['spanel_links']}</td>";
                    }
                    $HTMLOUT .= "</tr>";
                }
                $HTMLOUT .= "<tr align='center'><td align='left'><a href='" . htmlsafechars($arr['file_name']) . "' title='" . htmlsafechars($arr['page_name']) . "'>
      " . htmlsafechars($arr['page_name']) . "</a><br /><font class='small'>" . htmlsafechars($arr['description']) . "</font></td>
<td><a href='userdetails.php?id=" . (int) $arr['added_by'] . "'>" . htmlsafechars($arr['username']) . "</a></td>
      <td>
      <span style='white-space: nowrap;'>" . get_date($arr['added'], 'LONG', 0, 1) . "<br /></span>
      </td>";
                if ($CURUSER['class'] == UC_MAX) {
                    $HTMLOUT .= "<td><span style='white-space: nowrap;'>";
                    if ($CURUSER['class'] == UC_MAX) {
                        $HTMLOUT .= "<a href='staffpanel.php?action=edit&amp;id=" . (int) $arr['id'] . "' title='".$lang['spanel_edit']."'><img src='{$INSTALLER09['pic_base_url']}button_edit2.gif' height='15px' width='14px' alt='".$lang['spanel_edit']."' style='padding-right:3px' /></a>";
                    }
                    if ($CURUSER['class'] == UC_MAX) {
                        $HTMLOUT .= "<a href='staffpanel.php?action=delete&amp;id=" . (int) $arr['id'] . "' title='".$lang['spanel_delete']."'><img src='{$INSTALLER09['pic_base_url']}button_delete2.gif' height='13px' width='13px' alt='".$lang['spanel_delete']."' style='padding-left:3px' /></a>";
                    }
                    $HTMLOUT .= "</span>
            </td>";
                }
                $HTMLOUT .= "</tr>";
                $i++;
                if ($end_table) {
                    $i = 1;
                    $HTMLOUT .= "</table><br>";
                }
            }
        } else
            $HTMLOUT .= stdmsg($lang['spanel_sorry'], $lang['spanel_nothing_found']);
  $HTMLOUT.="</div>";
        echo stdhead($lang['spanel_header']) . $HTMLOUT .  stdfoot();
    }
}
?>
