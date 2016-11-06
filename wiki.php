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
require_once (INCL_DIR . 'html_functions.php');
require_once (INCL_DIR . 'bbcode_functions.php');
dbconn();
loggedinorreturn();
$lang = array_merge(load_language('global'), load_language('wiki'));
//$stdhead = array(/** include js **/'js' => array(''));
$stdhead = array(
    /** include css **/
    'css' => array(
        'wiki'
    )
);
$HTMLOUT = "";
global $CURUSER;
function newmsg($heading = '', $text = '', $div = 'success', $htmlstrip = false)
{
    if ($htmlstrip) {
        $heading = htmlsafechars(trim($heading));
        $text = htmlsafechars(trim($text));
    }
    $htmlout = '';
    $htmlout.= "<table class=\"table table-bordered\"><tr><td class=\"embedded\">\n";
    $htmlout.= "<div class=\"row\"><div class=\"col-md-12\">" . ($heading ? "<b>$heading</b><br />" : "") . "$text</div></div></td></tr></table>\n";
    return $htmlout;
}
function newerr($heading = '', $text = '', $die = true, $div = 'error', $htmlstrip = false)
{
    $htmlout = '';
    $htmlout.= newmsg($heading, $text, $div, $htmlstrip);
    echo stdhead() . $htmlout . stdfoot();
    if ($die) die;
}
function datetimetransform($input)
{
    $todayh = getdate($input);
    if ($todayh["seconds"] < 10) {
        $todayh["seconds"] = "0" . $todayh["seconds"] . "";
    }
    if ($todayh["minutes"] < 10) {
        $todayh["minutes"] = "0" . $todayh["minutes"] . "";
    }
    if ($todayh["hours"] < 10) {
        $todayh["hours"] = "0" . $todayh["hours"] . "";
    }
    if ($todayh["mday"] < 10) {
        $todayh["mday"] = "0" . $todayh["mday"] . "";
    }
    if ($todayh["mon"] < 10) {
        $todayh["mon"] = "0" . $todayh["mon"] . "";
    }
    $sec = $todayh['seconds'];
    $min = $todayh['minutes'];
    $hours = $todayh['hours'];
    $d = $todayh['mday'];
    $m = $todayh['mon'];
    $y = $todayh['year'];
    $input = "$d-$m-$y $hours:$min:$sec";
    return $input;
}
function navmenu()
{
	global $lang;
$ret = '<div class="row"><div class="col-md-10 col-md-offset-2 "><a href="wiki.php">' . $lang['wiki_index'] . '</a> - <a href="wiki.php?action=add">' . $lang['wiki_add'] . '</a><form action="wiki.php" method="post">';
   
$ret.= "\n" . '<a href="wiki.php?action=sort&amp;letter=a">A</a>';
    for ($i = 0; $i < 25; $i++) {
        $ret.= "\n- " . '<a href="wiki.php?action=sort&amp;letter=' . chr($i + 98) . '">' . chr($i + 66) . '</a>';
    }
    $ret.= "\n" . '<input type="text" name="article" /> <input type="submit" value="' . $lang['wiki_search'] . '" name="wiki" /></form></div></div>';
    return $ret;
}
function articlereplace($input)
{
    $input = str_replace(" ", "+", $input);
    return $input;
}
function wikisearch($input)
{
	global $lang;
    return str_replace(array(
        "%",
        "_"
    ) , array(
        "\\%",
        "\\_"
    ) , ((isset($GLOBALS["___mysqli_ston"]) && is_object($GLOBALS["___mysqli_ston"])) ? mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $input) : ((trigger_error($lang['wiki_error'], E_USER_ERROR)) ? "" : "")));
}
function wikireplace($input)
{
    return preg_replace(array(
        '/\[\[(.+?)\]\]/i',
        '/\=\=\ (.+?)\ \=\=/i'
    ) , array(
        '<a href="wiki.php?action=article&name=$1">$1</a>',
        '<div id="$1" style="border-bottom: 1px solid grey; font-weight: bold; width: 100%; font-size: 14px;">$1</div>'
    ) , $input);
}
function wikimenu()
{
	global $lang;
    $res2 = sql_query("SELECT name FROM wiki ORDER BY id DESC LIMIT 1");
    $latest = mysqli_fetch_assoc($res2);
    $latestarticle = articlereplace(htmlsafechars($latest["name"]));
    $ret = "<div id=\"wiki-content-right\">
					<div id=\"details\">
						<ul>
							<li><b>{$lang['wiki_permissions']}</b></li></ul>
							{$lang['wiki_read_user']}<br />
							{$lang['wiki_write_user']}<br />
							{$lang['wiki_edit_staff']}
							<ul><li><b>{$lang['wiki_latest_article']}</b></li></ul>
							<a href=\"wiki.php?action=article&amp;name=$latestarticle\">" . htmlsafechars($latest['name']) . "</a>
					</div>
				</div>
		";
    return $ret;
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["article-add"])) {
        $name = htmlsafechars($_POST["article-name"]);
        $body = htmlsafechars($_POST["article-body"]);
        sql_query("INSERT INTO `wiki` ( `name` , `body` , `userid`, `time` )
VALUES (" . sqlesc($name) . ", " . sqlesc($body) . ", " . sqlesc($CURUSER["id"]) . ", '" . TIME_NOW . "')") or sqlerr(__FILE__, __LINE__);
        $HTMLOUT.= "<meta http-equiv=\"refresh\" content=\"0; url=wiki.php?action=article&name=" . htmlsafechars($_POST["article-name"]) . "\">";
    }
    if (isset($_POST["article-edit"])) {
        $id = (int)$_POST["article-id"];
        $name = htmlsafechars($_POST["article-name"]);
        $body = htmlsafechars($_POST["article-body"]);
        sql_query("UPDATE wiki SET name = " . sqlesc($name) . ", body =" . sqlesc($body) . ", lastedit = '" . TIME_NOW . "', lastedituser =" . sqlesc($CURUSER["id"]) . " WHERE id = " . sqlesc($id));
        $HTMLOUT.= "<meta http-equiv=\"refresh\" content=\"0; url=wiki.php?action=article&name=" . htmlsafechars($_POST["article-name"]) . "\">";
    }
    if (isset($_POST["wiki"])) {
        $wikisearch = articlereplace(htmlsafechars($_POST["article"]));
        $HTMLOUT.= "<meta http-equiv=\"refresh\" content=\"0; url=wiki.php?action=article&name=$wikisearch\">";
    }
}
//$HTMLOUT.= begin_main_frame();
$HTMLOUT.= "<div class='row'><div class='col-md-12 '><div class='panel panel-default'><div class='panel-heading'>";

$HTMLOUT.= "<div class='row'><div class=col-md-12'><span><img src='images/global.design/wiki.png' alt='' title='{$lang['wiki_title']}'>{$lang['wiki_title']}</span></div></div><div class='global_text'><br>";


if (isset($_GET["action"])) {
    $action = htmlsafechars($_GET["action"]);
    if (isset($_GET["name"])) {
        $mode = "name";
        $name = htmlsafechars($_GET["name"]);
    }
    if (isset($_GET["id"])) {
        $mode = "id";
        $id = (int)$_GET["id"];
        if (!is_valid_id($id)) die();
    }
    if (isset($_GET["letter"])) $letter = htmlsafechars($_GET["letter"]);
} else {
    $action = "article";
    $mode = "name";
    $name = "index";
}
if ($action == "article") {
    $res = sql_query("SELECT * FROM wiki WHERE $mode = '" . ($mode == "name" ? "$name" : "$id") . "'");
    if (mysqli_num_rows($res) == 1) {
        $HTMLOUT.= navmenu();
        $edit = '';
        $HTMLOUT.= "
        <div id=\"wiki-container\">
  <div id=\"wiki-row\">";
        while ($wiki = mysqli_fetch_array($res)) {
            if ($wiki['lastedit']) {
                $check = sql_query("SELECT username FROM users WHERE id = " . sqlesc($wiki['lastedituser']));
                $checkit = mysqli_fetch_assoc($check);
                $edit = "<i>Last Updated by: <a href=\"userdetails.php?id=" . (int)$wiki['userid'] . "\">" . htmlsafechars($checkit['username']) . "</a> - " . datetimetransform($wiki['lastedit']) . "</i>";
            }
            $check = sql_query("SELECT username FROM users WHERE id =" . sqlesc($wiki['userid']));
            $author = mysqli_fetch_assoc($check);
            $HTMLOUT.= "
				<div id=\"wiki-content-left\" align=\"right\">
					<div id=\"name\"><b><a href=\"wiki.php?action=article&amp;name=" . htmlsafechars($wiki['name']) . "\">" . htmlsafechars($wiki['name']) . "</a></b></div>
					<div id=\"content\">" . ($wiki['userid'] > 0 ? "<i>{$lang['wiki_added_by_art']}<a href=\"userdetails.php?id=" . (int)$wiki['userid'] . "\"><b>" . htmlsafechars($author['username']) . "</b></a></i><br /><br />" : "") . wikireplace(format_comment($wiki["body"])) . "";
            $HTMLOUT.= "<div align=\"right\">" . ($edit ? "$edit" : "") . ($CURUSER['class'] >= UC_STAFF || $CURUSER["id"] == $wiki["userid"] ? " - <a href=\"wiki.php?action=edit&amp;id=" . (int)$wiki['id'] . "\">{$lang['wiki_edit']}</a>" : "") . "</div>";
            $HTMLOUT.= "</div></div>";
        }
        $HTMLOUT.= wikimenu();
        $HTMLOUT.= "</div>";
        $HTMLOUT.= "</div>";
    } else {
        $search = sql_query("SELECT * FROM wiki WHERE name LIKE '%" . wikisearch($name) . "%'");
        if (mysqli_num_rows($search) > 0) {
            $HTMLOUT.= "Search results for: <b>" . htmlsafechars($name) . "</b>";
            while ($wiki = mysqli_fetch_array($search)) {
                if ($wiki["userid"] !== 0) $wikiname = mysqli_fetch_assoc(sql_query("SELECT username FROM users WHERE id =" . sqlesc($wiki['userid'])));
 $HTMLOUT.= "<div class=\"wiki-search\">
	<b><a href=\"wiki.php?action=article&amp;name=" . articlereplace(htmlsafechars($wiki["name"])) . "\">" . htmlsafechars($wiki['name']) . "</a></b>{$lang['wiki_added_by']}<a href=\"userdetails.php?id=" . (int)$wiki['userid'] . "\">" . htmlsafechars($wikiname['username']) . "</a></div>";
            }
        } else {
            $HTMLOUT.= newerr($lang['wiki_error'], $lang['wiki_no_art_found']);
        }
    }
}
$wiki = 0;
if ($action == "add") {
    $HTMLOUT.= navmenu();
    $HTMLOUT.= "<div id=\"wiki-container\"><div id=\"wiki-row\">";
    $HTMLOUT.= "<div id=\"wiki-content-left\">
					<form method=\"post\" action=\"wiki.php\">
					<div><input type=\"text\" name=\"article-name\" id=\"name\" /></div>
					<div id=\"content-add\"><textarea name=\"article-body\" rows=\"70\" cols=\"90\" id=\"body\">" . htmlsafechars($wiki['body']) . "</textarea>
					<div align=\"center\"><input type=\"submit\" name=\"article-add\" value=\"{$lang['wiki_ok']}\" /></div>
	</div></form></div>";
    $HTMLOUT.= wikimenu();
    $HTMLOUT.= "</div>";
    $HTMLOUT.= "</div><br>";
}
if ($action == "edit") {
    $res = sql_query("SELECT * FROM wiki WHERE id = " . sqlesc($id));
    $rescheck = sql_query("SELECT userid FROM wiki WHERE id =" . sqlesc($id));
    $wikicheck = mysqli_fetch_assoc($rescheck);
    if (($CURUSER['class'] >= UC_STAFF) OR ($CURUSER["id"] == $wikicheck["userid"])) {
        $HTMLOUT.= navmenu();
        $HTMLOUT.= "<div id=\"wiki-container\">
  <div id=\"wiki-row\">";
        while ($wiki = mysqli_fetch_array($res)) {
            $HTMLOUT.= "
				<div id=\"wiki-content-left\" align=\"right\">
					<form method=\"post\" action=\"wiki.php\">
					<div><input type=\"hidden\" name=\"article-id\" value=\"" . (int)$wiki['id'] . "\" />
					<input type=\"text\" name=\"article-name\" id=\"name\" value=\"" . htmlsafechars($wiki['name']) . "\" /></div>
					<div id=\"content-add\"><table class=\"table table bordered\"><tr><td><textarea name=\"article-body\" rows=\"70\" cols=\"10\" id=\"body\">" . htmlsafechars($wiki['body']) . "</textarea>
					<div align=\"center\"><input type=\"submit\" name=\"article-edit\" value=\"{$lang['wiki_edit']}\" /></div></td></tr></table>";
            $HTMLOUT.= "</div></form></div>";
        }
        $HTMLOUT.= wikimenu();
        $HTMLOUT.= "</div>";
        $HTMLOUT.= "</div><br>";
    } else $HTMLOUT.= newerr($lang['wiki_error'], $lang['wiki_access_denied']);
}
if ($action == "sort") {
    $sortres = sql_query("SELECT * FROM wiki WHERE name LIKE '$letter%' ORDER BY name");
    if (mysqli_num_rows($sortres) > 0) {
        $HTMLOUT.= navmenu();
        $HTMLOUT.= "{$lang['wiki_art_found_starting']}<b>" . htmlsafechars($letter) . "</b>";
        while ($wiki = mysqli_fetch_array($sortres)) {
            if ($wiki["userid"] !== 0) $wikiname = mysqli_fetch_assoc(sql_query("SELECT username FROM users WHERE id = " . sqlesc($wiki['userid'])));
            $HTMLOUT.= "
				<div class=\"wiki-search\">
					<b><a href=\"wiki.php?action=article&amp;name=" . articlereplace(htmlsafechars($wiki["name"])) . "\">" . htmlsafechars($wiki['name']) . "</a></b>{$lang['wiki_added_by1']}<a href=\"userdetails.php?id=" . (int)$wiki['userid'] . "\">" . htmlsafechars($wikiname['username']) . "</a></div>";
        }
    } else {
        $HTMLOUT.= navmenu();
        $HTMLOUT.= newerr($lang['wiki_error'], "{$lang['wiki_no_art_found_starting']}<b>$letter</b> found.");
    }
}
$HTMLOUT.= "</div>";
$HTMLOUT.= "</div></div></div></div><br>";
echo stdhead($lang['wiki_title'], true, $stdhead) . $HTMLOUT . stdfoot();
?>
