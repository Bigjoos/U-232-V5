<?php
//==Connectable and port shit
if ($user['paranoia'] < 1 || $CURUSER['id'] == $id || $CURUSER['class'] >= UC_STAFF) {
        $What_Cache = (XBT_TRACKER == true ? 'port_data_xbt_' : 'port_data_' );
    if (($port_data = $mc1->get_value($What_Cache . $id)) === false) {
        if(XBT_TRACKER == true) {
        $q1 = sql_query('SELECT `connectable`, `peer_id` FROM `xbt_files_users` WHERE uid = ' . sqlesc($id) . ' LIMIT 1') or sqlerr(__FILE__, __LINE__);
        } else {
        $q1 = sql_query('SELECT connectable, port,agent FROM peers WHERE userid = ' . sqlesc($id) . ' LIMIT 1') or sqlerr(__FILE__, __LINE__);
        }
        $port_data = mysqli_fetch_row($q1);
        $mc1->cache_value('port_data_' . $id, $port_data, $INSTALLER09['expires']['port_data']);
    }
    if ($port_data > 0) {
        $connect = $port_data[0];
        $port = (XBT_TRACKER == true ? '' : $port_data[1]);
        $Ident_Client = (XBT_TRACKER == true ? $port_data['1'] : $port_data[2]);
        $XBT_or_PHP = (XBT_TRACKER == true ? '1' : 'yes');
        if ($connect == $XBT_or_PHP) {
            $connectable = "<img src='{$INSTALLER09['pic_base_url']}tick.png' alt='{$lang['userdetails_yes']}' title='{$lang['userdetails_conn_sort']}' style='border:none;padding:2px;' /><font color='green'><b>{$lang['userdetails_yes']}</b></font>";
        } else {
            $connectable = "<img src='{$INSTALLER09['pic_base_url']}cross.png' alt='{$lang['userdetails_no']}' title='{$lang['userdetails_conn_staff']}' style='border:none;padding:2px;' /><font color='red'><b>{$lang['userdetails_no']}</b></font>";
        }
    } else {
        $connectable = "<font color='orange'><b>{$lang['userdetails_unknown']}</b></font>";
    }
    $HTMLOUT.= "<tr><td class='rowhead'>{$lang['userdetails_connectable']}</td><td align='left'>" . $connectable . "</td></tr>";
    if (!empty($port)) $HTMLOUT.= "<tr><td class='rowhead'>{$lang['userdetails_port']}</td><td class='tablea' align='left'>" . htmlsafechars($port) . "</td></tr>
    <tr><td class='rowhead'>{$lang['userdetails_client']}</td><td class='tablea' align='left'>" . htmlsafechars($Ident_Client) . "</td></tr>";
}
//==End
// End Class
// End File
