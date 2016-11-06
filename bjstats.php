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
require_once(__DIR__ . DIRECTORY_SEPARATOR . 'include' . DIRECTORY_SEPARATOR . 'bittorrent.php');
require_once(INCL_DIR . 'user_functions.php');
require_once(INCL_DIR . 'html_functions.php');
dbconn(false);
loggedinorreturn();
$lang = array_merge(load_language('global'), load_language('blackjack'));
if ($CURUSER['class'] < UC_POWER_USER) {
    stderr($lang['bj_sorry'], $lang['bj_you_must_be_pu']);
    exit;
}
function bjtable($res, $frame_caption)
{
    global $lang, $CURUSER;
    $htmlout = '';
    $htmlout .= begin_frame($frame_caption, true);
    $htmlout .= begin_table();
    $htmlout .= "<tr>
    <td class='colhead'>Rank</td>
    <td class='colhead' align='left'>{$lang['bj_user']}</td>
    <td class='colhead' align='right'>{$lang['bj_wins']}</td>
    <td class='colhead' align='right'>{$lang['bj_losses']}</td>
    <td class='colhead' align='right'>{$lang['bj_games']}</td>
    <td class='colhead' align='right'>{$lang['bj_percentage']}</td>
    <td class='colhead' align='right'>{$lang['bj_win_loss']}</td>
    </tr>";
    $num = 0;
    while ($a = mysqli_fetch_assoc($res)) {
        ++$num;
        //==Calculate Win %
        $win_perc = number_format(($a['wins'] / $a['games']) * 100, 1);
        //==Add a user's +/- statistic
        $plus_minus = $a['wins'] - $a['losses'];
        if ($plus_minus >= 0) {
            $plus_minus = mksize(($a['wins'] - $a['losses']) * 100 * 1024 * 1024);
        } else {
            $plus_minus = "-";
            $plus_minus .= mksize(($a['losses'] - $a['wins']) * 100 * 1024 * 1024);
        }
        $htmlout .= "<tr><td>$num</td><td align='left'>" . "<b><a href='userdetails.php?id=" . (int)$a['id'] . "'>" . htmlsafechars($a['username']) . "</a></b></td>" . "<td align='right'>" . number_format($a['wins'], 0) . "</td>" . "<td align='right'>" . number_format($a['losses'], 0) . "</td>" . "<td align='right'>" . number_format($a['games'], 0) . "</td>" . "<td align='right'>$win_perc</td>" . "<td align='right'>$plus_minus</td>" . "</tr>\n";
    }
    $htmlout .= end_table();
    $htmlout .= end_frame();
    return $htmlout;
}
$HTMLOUT = '';
$mingames = 10;
$HTMLOUT .= "<br />";
$res = sql_query("SELECT id, username, bjwins AS wins, bjlosses AS losses, bjwins + bjlosses AS games FROM users WHERE bjwins + bjlosses > ".sqlesc($mingames)." ORDER BY games DESC LIMIT 10") or sqlerr(__FILE__, __LINE__);
$HTMLOUT .= bjtable($res, "{$lang['bj_most']} {$lang['bj_games_played']}", "Users");
$HTMLOUT .= "<br /><br />";
//==Highest Win %
$res = sql_query("SELECT id, username, bjwins AS wins, bjlosses AS losses, bjwins + bjlosses AS games, bjwins / (bjwins + bjlosses) AS winperc FROM users WHERE bjwins + bjlosses > ".sqlesc($mingames)." ORDER BY winperc DESC LIMIT 10") or sqlerr(__FILE__, __LINE__);
$HTMLOUT .= bjtable($res, "{$lang['bj_highest_win_per']}", "Users");
$HTMLOUT .= "<br /><br />";
//==Highest Win %
$res = sql_query("SELECT id, username, bjwins AS wins, bjlosses AS losses, bjwins + bjlosses AS games, bjwins - bjlosses AS winnings FROM users WHERE bjwins + bjlosses > ".sqlesc($mingames)." ORDER BY winnings DESC LIMIT 10") or sqlerr(__FILE__, __LINE__);
$HTMLOUT .= bjtable($res, "{$lang['bj_most_credit_won']}", "Users");
$HTMLOUT .= "<br /><br />";
$res = sql_query("SELECT id, username, bjwins AS wins, bjlosses AS losses, bjwins + bjlosses AS games, bjlosses - bjwins AS losings FROM users WHERE bjwins + bjlosses > ".sqlesc($mingames)." ORDER BY losings DESC LIMIT 10") or sqlerr(__FILE__, __LINE__);
$HTMLOUT .= bjtable($res, "{$lang['bj_most_credit_loss']}", "Users");
$HTMLOUT .= "<br /><br />";
echo stdhead($lang['bj_blackjack_stats']) . $HTMLOUT . stdfoot();
?>
