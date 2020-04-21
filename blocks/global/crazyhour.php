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
 */
if (XBT_TRACKER == false and $INSTALLER09['crazy_hour'] == true) {
    function crazyhour()
    {
        global $CURUSER, $INSTALLER09, $cache, $lang;
        $htmlout = $cz = '';
        $crazy_hour = (TIME_NOW + 3600);
        if (($crazyhour['crazyhour'] = $cache->get('crazyhour')) === false) {
            $crazyhour['crazyhour_sql'] = sql_query('SELECT var, amount FROM freeleech WHERE type = "crazyhour"') or sqlerr(__FILE__, __LINE__);
            $crazyhour['crazyhour'] = [];
            if (mysqli_num_rows($crazyhour['crazyhour_sql']) !== 0) {
                $crazyhour['crazyhour'] = mysqli_fetch_assoc($crazyhour['crazyhour_sql']);
            } else {
                $crazyhour['crazyhour']['var'] = mt_rand(TIME_NOW, (TIME_NOW + 86400));
                $crazyhour['crazyhour']['amount'] = 0;
                sql_query('UPDATE freeleech SET var = ' . $crazyhour['crazyhour']['var'] . ', amount = ' . $crazyhour['crazyhour']['amount'] . '
WHERE type = "crazyhour"') or sqlerr(__FILE__, __LINE__);
            }
            $cache->set('crazyhour', $crazyhour['crazyhour'], 0);
        }
        $cimg = '<img src="' . $INSTALLER09['pic_base_url'] . 'cat_free.gif" alt="FREE!" />';
        if ($crazyhour['crazyhour']['var'] < TIME_NOW) { // if crazyhour over
            $cz_lock = $cache->set('crazyhour_lock', 1, 10);
            if ($cz_lock !== false) {
                $crazyhour['crazyhour_new'] = mktime(23, 59, 59, date('m'), date('d'), date('y'));
                $crazyhour['crazyhour']['var'] = mt_rand($crazyhour['crazyhour_new'], ($crazyhour['crazyhour_new'] + 86400));
                $crazyhour['crazyhour']['amount'] = 0;
                $crazyhour['remaining'] = ($crazyhour['crazyhour']['var'] - TIME_NOW);
                sql_query('UPDATE freeleech SET var = ' . $crazyhour['crazyhour']['var'] . ', amount = ' . $crazyhour['crazyhour']['amount'] . '
WHERE type = "crazyhour"') or sqlerr(__FILE__, __LINE__);
                $cache->set('crazyhour', $crazyhour['crazyhour'], 0);
                write_log('Next [color=#FFCC00][b]Crazyhour[/b][/color] is at ' . get_date($crazyhour['crazyhour']['var'] + ($CURUSER['time_offset'] - 3600), 'LONG') . '');
                $text = 'Next [color=orange][b]Crazyhour[/b][/color] is at ' . get_date($crazyhour['crazyhour']['var'] + ($CURUSER['time_offset'] - 3600), 'LONG');
                $text_parsed = '<b class="btn btn-success btn-sm">Next <span style="font-weight:bold;color:orange;">Crazyhour</span> is at ' . get_date($crazyhour['crazyhour']['var'] + ($CURUSER['time_offset'] - 3600), 'LONG');
                sql_query('INSERT INTO shoutbox (userid, date, text, text_parsed) ' . '
VALUES (2, ' . TIME_NOW . ', ' . sqlesc($text) . ', ' . sqlesc($text_parsed) . ')') or sqlerr(__FILE__, __LINE__);
                $cache->delete('shoutbox_');
            }
        } elseif (($crazyhour['crazyhour']['var'] < $crazy_hour) && ($crazyhour['crazyhour']['var'] >= TIME_NOW)) { // if crazyhour
            if ($crazyhour['crazyhour']['amount'] !== 1) {
                $crazyhour['crazyhour']['amount'] = 1;
                $cz_lock = $cache->set('crazyhour_lock', 1, 10);
                if ($cz_lock !== false) {
                    sql_query('UPDATE freeleech SET amount = ' . $crazyhour['crazyhour']['amount'] . '
WHERE type = "crazyhour"') or sqlerr(__FILE__, __LINE__);
                    $cache->set('crazyhour', $crazyhour['crazyhour'], 0);
                    write_log('w00t! It\'s [color=#FFCC00][b]Crazyhour[/b][/color]!');
                    $text = 'w00t! It\'s [color=orange][b]Crazyhour[/b][/color] :w00t:';
                    $text_parsed = 'w00t! It\'s <span style="font-weight:bold;color:orange;">Crazyhour</span> <img src="pic/smilies/w00t.gif" alt=":w00t:" />';
                    sql_query('INSERT INTO shoutbox (userid, date, text, text_parsed) ' . 'VALUES (2, ' . TIME_NOW . ', ' . sqlesc($text) . ', ' . sqlesc($text_parsed) . ')') or sqlerr(__FILE__, __LINE__);
                    $cache->delete('shoutbox_');
                }
            }
            $crazyhour['remaining'] = ($crazyhour['crazyhour']['var'] - TIME_NOW);
            $crazytitle = $lang['gl_crazy_title'];
            $crazymessage = $lang['gl_crazy_message'] . ' <b> ' . $lang['gl_crazy_message1'] . '</b> ' . $lang['gl_crazy_message2'] . ' <strong> ' . $lang['gl_crazy_message3'] . '</strong>!';
            $htmlout.= '<li>
<a class="sa-tooltip" href="#"><b class="btn btn-success btn-sm">' . $lang['gl_crazy_on'] . '<span class="custom info alert alert-success text-left">
' . $crazytitle . '...<br />' . $crazymessage . ' <br /> ' . ' ' . $lang['gl_crazy_ends'] . ' ' . mkprettytime($crazyhour['remaining']) . '&nbsp;' . $lang['gl_crazy_at'] . ' ' . get_date($crazyhour['crazyhour']['var'], 'LONG') . '</span></b></a></li>';
            return $htmlout;
        }
        $htmlout.= '<li>
<a class="sa-tooltip" href="#"><b class="btn btn-info btn-sm">' . $lang['gl_crazy_'] . '</b>
<span class="custom info alert alert-info">
' . $lang['gl_crazy_message4'] . '&nbsp;' . $lang['gl_crazy_message5'] . '<br /> ' . '' . $lang['gl_crazy_message6'] . ' ' . mkprettytime($crazyhour['crazyhour']['var'] - 3600 - TIME_NOW) . '&nbsp;' . $lang['gl_crazy_at'] . ' ' . get_date($crazyhour['crazyhour']['var'] + ($CURUSER['time_offset'] - 3600), 'LONG') . '</span></a></li>';
        return $htmlout;
    }
    $htmlout.= crazyhour();
}
// End Class
// End File
