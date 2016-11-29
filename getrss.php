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
require_once (__DIR__ . DIRECTORY_SEPARATOR . 'include' . DIRECTORY_SEPARATOR . 'bittorrent.php');
require_once (INCL_DIR . 'user_functions.php');
dbconn();
loggedinorreturn();
$lang = array_merge(load_language('global') , load_language('getrss'));
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    function mkint($x)
    {
        return (int)$x;
    }
    $cats = isset($_POST['cats']) ? array_map('mkint', $_POST['cats']) : array();
    if (count($cats) == 0) stderr($lang['getrss_error'], $lang['getrss_nocat']);
    $feed = isset($_POST['feed']) && $_POST['feed'] == 'dl' ? 'dl' : 'web';
    $rsslink = $INSTALLER09['baseurl'] . '/rss.php?cats=' . join(',', $cats) . ($feed == 'dl' ? '&amp;type=dl' : '') . '&amp;torrent_pass=' . $CURUSER['torrent_pass'];
    $HTMLOUT = "<div align=\"center\"><h2>{$lang['getrss_result']}</h2><br/>
		<input type=\"text\" size=\"120\" readonly=\"readonly\" value=\"{$rsslink}\" onclick=\"select()\" />
	</div>";
    echo (stdhead($lang['getrss_head2']) . $HTMLOUT . stdfoot());
} else {
    $HTMLOUT = <<<HTML
<form action="{$_SERVER['PHP_SELF']}" method="post">
<table class="table table-bordered">
<tr>
	<td colspan="2" align="center" class="colhead">{$lang['getrss_title']}</td>
</tr>
<tr>
	<td align="right" valign="top">{$lang['getrss_cat']}</td><td align="left" width="100%">
HTML;
    $q1 = sql_query('SELECT id, name, image FROM categories ORDER BY id') or sqlerr(__FILE__, __LINE__);
    $i = 0;
    while ($a = mysqli_fetch_assoc($q1)) {
        if ($i % 5 == 0 && $i > 0) $HTMLOUT.= "<br/>";
        $HTMLOUT.= "<label for=\"cat_" . (int)$a['id'] . "\">
      <img src=\"{$INSTALLER09['pic_base_url']}caticons/{$CURUSER['categorie_icon']}/" . htmlsafechars($a['image']) . "\" alt=\"" . htmlsafechars($a['name']) . "\" title=\"" . htmlsafechars($a['name']) . "\" />
     <input type=\"checkbox\" name=\"cats[]\" id=\"cat_" . (int)$a['id'] . "\" value=\"" . (int)$a['id'] . "\" /></label>\n";
        $i++;
    }
    $HTMLOUT.= <<<HTML
</td>
</tr>
<tr>
	<td align="right">{$lang['getrss_feed']}</td><td align="left"><input type="radio" checked="checked" name="feed" id="std" value="web"/><label for="std">{$lang['getrss_web']}</label><br/><input type="radio" name="feed" id="dl" value="dl"/><label for="dl">{$lang['getrss_dl']}</label></td>
 </tr>
 <tr><td colspan="2" align="center"><input type="submit" value="{$lang['getrss_btn']}" /></td></tr>
</table>
</form>
HTML;
    echo (stdhead($lang['getrss_head2']) . $HTMLOUT . stdfoot());
}
?>
