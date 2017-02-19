<?php
//$_NO_COMPRESS = true;
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
require_once INCL_DIR . 'torrenttable_functions_catalogue.php';
require_once INCL_DIR . 'pager_functions.php';
require_once (INCL_DIR . 'searchcloud_functions.php');
require_once (CLASS_DIR . 'class_user_options.php');
require_once (CLASS_DIR . 'class_user_options_2.php');

dbconn(false);
loggedinorreturn();

if (isset($_GET['clear_new']) && $_GET['clear_new'] == 1) {
    sql_query("UPDATE users SET last_browse=" . TIME_NOW . " WHERE id=" . sqlesc($CURUSER['id'])) or sqlerr(__FILE__, __LINE__);
    $mc1->begin_transaction('MyUser_' . $CURUSER['id']);
    $mc1->update_row(false, array(
        'last_browse' => TIME_NOW
    ));
    $mc1->commit_transaction($INSTALLER09['expires']['curuser']);
    $mc1->begin_transaction('user' . $CURUSER['id']);
    $mc1->update_row(false, array(
        'last_browse' => TIME_NOW
    ));
    $mc1->commit_transaction($INSTALLER09['expires']['user_cache']);
    header("Location: {$INSTALLER09['baseurl']}/browse_catalogue.php");
}
$stdfoot = array(
    /** include js **/
    'js' => array(
        'java_klappe',
        'wz_tooltip'
    )
);
$stdhead = array(
    /** include css **/
    'css' => array(
        /*'browse'*/
    )
);
$lang = array_merge(load_language('global') , load_language('browse'), load_language('catalogue') , load_language('torrenttable_functions'));
if (function_exists('parked')) parked();

$HTMLOUT = $searchin = $select_searchin = $where = $addparam = $new_button = $search_help_boolean = '';
$HTMLOUT .='<script type="text/javascript">
/*<![CDATA[*/
$(document).ready(function(){
    $("#help_open").click(function(){
    $("#help").slideToggle("slow", function() {
    });
    });
})
/*]]>*/
</script>';
$search_help_boolean = '<div class="panel panel-default">
    <div class="panel-heading">
<h2 class="text-center text-info">'.$lang['bool_01'].'</h2>
</div><div class="panel">
    <div class="panel-body">
 <p>   <span style="font-weight: bold;">+</span>'.$lang['bool_02'].'<br><br>
    <span style="font-weight: bold;">-</span>'.$lang['bool_03'].'<br><br>
       '.$lang['bool_04'].'<br><br>
    <span style="font-weight: bold;">*</span>'.$lang['bool_05'].'<br><br>
    <span style="font-weight: bold;">> <</span>'.$lang['bool_06'].'<br><br>
    <span style="font-weight: bold;">~</span>'.$lang['bool_07'].'<br><br>
    <span style="font-weight: bold;">" "</span>'.$lang['bool_08'].'<br><br>
    <span style="font-weight: bold;">( )</span>'.$lang['bool_09'].'
    </p> </div></div></div></div></div></div>';
$cats = genrelist();
if (isset($_GET["search"])) {
    $searchstr = sqlesc($_GET["search"]);
    $cleansearchstr = searchfield($searchstr);
    if (empty($cleansearchstr)) unset($cleansearchstr);
}
$valid_searchin = array(
    'title' => array(
        'name'
    ) ,
    'descr' => array(
        'descr'
    ) ,
    'genre' => array(
        'newgenre'
    ) ,
    'all' => array(
        'name',
        'newgenre',
        'descr'
    )
);
if (isset($_GET['searchin']) && isset($valid_searchin[$_GET['searchin']])) {
    $searchin = $valid_searchin[$_GET['searchin']];
    $select_searchin = $_GET['searchin'];
    $addparam.= sprintf('search=%s&amp;searchin=%s&amp;', $searchstr, $select_searchin);
}
if (isset($_GET['sort']) && isset($_GET['type'])) {
    $column = $ascdesc = '';
    $_valid_sort = array(
        'id',
        'name',
        'numfiles',
        'comments',
        'added',
        'size',
        'times_completed',
        'seeders',
        'leechers',
        'owner'
    );
    $column = isset($_GET['sort']) && isset($_valid_sort[(int)$_GET['sort']]) ? $_valid_sort[(int)$_GET['sort']] : $_valid_sort[0];
    switch (htmlsafechars($_GET['type'])) {
    case 'asc':
        $ascdesc = "ASC";
        $linkascdesc = "asc";
        break;

    case 'desc':
        $ascdesc = "DESC";
        $linkascdesc = "desc";
        break;

    default:
        $ascdesc = "DESC";
        $linkascdesc = "desc";
        break;
    }
    $orderby = "ORDER BY {$column} " . $ascdesc;
    $pagerlink = "sort=" . intval($_GET['sort']) . "&amp;type={$linkascdesc}&amp;";
} else {
    $orderby = "ORDER BY sticky ASC, id DESC";
    $pagerlink = "";
}
$wherea = $wherecatina = array();
if (isset($_GET["incldead"]) && $_GET["incldead"] == 1) {
    $addparam.= "incldead=1&amp;";
    if (!isset($CURUSER) || $CURUSER["class"] < UC_ADMINISTRATOR) $wherea[] = "banned != 'yes'";
} else {
    if (isset($_GET["incldead"]) && $_GET["incldead"] == 2) {
        $addparam.= "incldead=2&amp;";
        $wherea[] = "visible = 'no'";
    } else $wherea[] = "visible = 'yes'";
}
//=== added an only free torrents option \\o\o/o//
if (isset($_GET['only_free']) && $_GET['only_free'] == 1) {
    if (XBT_TRACKER == true ? $wherea[] = "freetorrent >= '1'" : $wherea[] = "free >= '1'");
    //$wherea[] = "free >= '1'";
    $addparam.= "only_free=1&amp;";
}
$category = (isset($_GET["cat"])) ? (int)$_GET["cat"] : false;
$all = isset($_GET["all"]) ? $_GET["all"] : false;
    if (!$all) {
        if (!$_GET && $CURUSER["notifs"]) {
            $all = true;
            foreach ($cats as $cat) {
                $all&= $cat['id'];
                if (strpos($CURUSER["notifs"], "[cat" . $cat['id'] . "]") !== false) {
                    if($cat['min_class'] <= $CURUSER['class']){
                        $wherecatina[] = $cat['id'];
                        $addparam.= "c{$cat['id']}=1&amp;";
                    }
                }
            }
        } elseif ($category) {
            if (!is_valid_id($category) || $cats[$category]['min_class'] >= $CURUSER['class']) stderr("{$lang['browse_error']}", "{$lang['browse_invalid_cat']}");
            $wherecatina[] = $category;
            $addparam.= "cat=$category&amp;";
        } else {
            $all = true;
            foreach ($cats as $cat) {
                $all&= isset($_GET["c{$cat['id']}"]);
                if (isset($_GET["c{$cat['id']}"])) {
                    if($cat['min_class'] <= $CURUSER['class']){
                        $wherecatina[] = $cat['id'];
                        $addparam.= "c{$cat['id']}=1&amp;";
                    }
                }
            }
        }
    }
    if ($all) {
        foreach ($cats as $cat) {
            if($cat['min_class'] <= $CURUSER['class']){
                $wherecatina[] = $cat['id'];
                $addparam.= "c{$cat['id']}=1&amp;";
            }
        }
        //$addparam = "";
    }
    if (count($wherecatina) < 1) {
        foreach ($cats as $cat) {
            if($cat['min_class'] <= $CURUSER['class']){
                $wherecatina2[] = $cat['id'];
            }
        }
        $wherea[] = 'category IN (' . join(', ', $wherecatina2) . ') ';
        //$addparam = "";
    }

if (count($wherecatina) > 1) $wherea[] = 'category IN (' . join(', ', $wherecatina) . ') ';
elseif (count($wherecatina) == 1) $wherea[] = 'category =' . $wherecatina[0];
if (isset($cleansearchstr)) {
    //== boolean search by djgrr
    if ($searchstr != '') {
        $addparam.= 'search=' . rawurlencode($searchstr) . '&amp;';
        $searchstring = str_replace(array(
            '_',
            '.',
            '-'
        ) , ' ', $searchstr);
        $s = array(
            '*',
            '?',
            '.',
            '-',
            ' '
        );
        $r = array(
            '%',
            '_',
            '_',
            '_',
            '_'
        );
        if (preg_match('/^\"(.+)\"$/i', $searchstring, $matches)) $wherea[] = '`name` LIKE ' . sqlesc('%' . str_replace($s, $r, $matches[1]) . '%');
        elseif (strpos($searchstr, '*') !== false || strpos($searchstr, '?') !== false) $wherea[] = '`name` LIKE ' . sqlesc(str_replace($s, $r, $searchstr));
        elseif (preg_match('/^[A-Za-z0-9][a-zA-Z0-9()._-]+-[A-Za-z0-9_]*[A-Za-z0-9]$/iD', $searchstr)) $wherea[] = '`name` = ' . sqlesc($searchstr);
        else $wherea[] = 'MATCH (`search_text`, `filename`, `newgenre`) AGAINST (' . sqlesc($searchstr) . ' IN BOOLEAN MODE)';
        //......
        $orderby = 'ORDER BY id DESC';
        $searcha = explode(' ', $cleansearchstr);
        //==Memcache search cloud by putyn
        searchcloud_insert($cleansearchstr);
        //==
        foreach ($searcha as $foo) {
            foreach ($searchin as $boo) $searchincrt[] = sprintf('%s LIKE \'%s\'', $boo, '%' . $foo . '%');
        }
        $wherea[] = join(' OR ', $searchincrt);
    }
}
$where = count($wherea) ? 'WHERE ' . join(' AND ', $wherea) : '';
$where_key = 'where::' . sha1($where);
if (($count = $mc1->get_value($where_key)) === false) {
    $res = sql_query("SELECT COUNT(id) FROM torrents $where") or sqlerr(__FILE__, __LINE__);
    $row = mysqli_fetch_row($res);
    $count = (int)$row[0];
    $mc1->cache_value($where_key, $count, $INSTALLER09['expires']['browse_where']);
}
$torrentsperpage = $CURUSER["torrentsperpage"];
if (!$torrentsperpage) $torrentsperpage = 16;
if ($count) {
    if ($addparam != "") {
        if ($pagerlink != "") {
            if ($addparam{strlen($addparam) - 1} != ";") { // & = &amp;
                $addparam = $addparam . "&" . $pagerlink;
            } else {
                $addparam = $addparam . $pagerlink;
            }
        }
    } else {
        $addparam = $pagerlink;
    }
    $pager = pager($torrentsperpage, $count, "browse_catalogue.php?" . $addparam);
    $query = "SELECT id, search_text, category, leechers, seeders, bump, release_group, subs, name, times_completed, size, added, poster, descr, type, free, freetorrent, silver, comments, numfiles, filename, anonymous, sticky, nuked, vip, nukereason, newgenre, description, owner, username, youtube, checked_by, IF(nfo <> '', 1, 0) as nfoav," . "IF(num_ratings < {$INSTALLER09['minvotes']}, NULL, ROUND(rating_sum / num_ratings, 1)) AS rating, url " . "FROM torrents {$where} {$orderby} {$pager['limit']}";
    $res = sql_query($query) or sqlerr(__FILE__, __LINE__);
} else {
    unset($query);
}

if (isset($cleansearchstr)) $title = "{$lang['browse_search']} $searchstr";
else $title = '';
$HTMLOUT.= "<div class='row'><div class='col-md-10 col-md-offset-2'>";
if ($CURUSER['opt1'] & user_options::VIEWSCLOUD) {
    $HTMLOUT.= "<div id='wrapper' style='width:80%;border:1px solid black;background-color:rgba(121,124,128,0.3);'>";
    //print out the tag cloud
    $HTMLOUT.= cloud() . "
    </div>";
}
$HTMLOUT.= "<br><br>
    <form  role='form' class='form-horizontal' method='get' action='browse_catalogue.php'>
    <table>
    <tr>
    <td >
    <table>
    <tr>";
$i = 0;
    foreach ($cats as $cat) {
        if($cat['min_class'] <= $CURUSER['class']){
            $HTMLOUT.= ($i && $i % $INSTALLER09['catsperrow'] == 0) ? "</tr><tr>" : "";
            $HTMLOUT.= "<td style=\"padding-bottom: 2px;padding-left: 7px\">
             <input name='c" . (int)$cat['id'] . "' class=\"styled\" type=\"checkbox\" " . (in_array($cat['id'], $wherecatina) ? "checked='checked' " : "") . "value='1' /><a class='catlink' href='browse_catalogue.php?cat=" . (int)$cat['id'] . "'> " . (($CURUSER['opt2'] & user_options_2::BROWSE_ICONS) ? "<img src='{$INSTALLER09['pic_base_url']}caticons/{$CURUSER['categorie_icon']}/" . htmlsafechars($cat['image']) . "' alt='" . htmlsafechars($cat['name']) . "' title='" . htmlsafechars($cat['name']) . "' />" : "" . htmlsafechars($cat['name']) . "") . "</a></td>\n";
            $i++;
        }
    }
$alllink = "<div></div>";
$ncats = count($cats);
$nrows = ceil($ncats / $INSTALLER09['catsperrow']);
$lastrowcols = $ncats % $INSTALLER09['catsperrow'];
if ($lastrowcols != 0) {
    if ($INSTALLER09['catsperrow'] - $lastrowcols != 1) {
        $HTMLOUT.= "<td class='bottom' rowspan='" . ($INSTALLER09['catsperrow'] - $lastrowcols - 1) . "'>&nbsp;</td>";
    }
    $HTMLOUT.= "<td>$alllink</td>\n";
}
$HTMLOUT.= "</tr>
    </table>
    </td>
    <td>
    <table>
    <tr>";
if ($ncats % $INSTALLER09['catsperrow'] == 0) {
    $HTMLOUT.= "<td>$alllink</td>\n";
}
$HTMLOUT.= "</tr>
    </table>
    </td>
    </tr>
    </table><br>";
//== clear new tag manually
if ($CURUSER['opt1'] & user_options::CLEAR_NEW_TAG_MANUALLY) {
    $new_button = "<a href='?clear_new=1'><input type='submit' value='clear new tag' class='button' /></a><br>";
} else {
    //== clear new tag automatically
    sql_query("UPDATE users SET last_browse=" . TIME_NOW . " where id=" . $CURUSER['id']);
    $mc1->begin_transaction('MyUser_' . $CURUSER['id']);
    $mc1->update_row(false, array(
        'last_browse' => TIME_NOW
    ));
    $mc1->commit_transaction($INSTALLER09['expires']['curuser']);
    $mc1->begin_transaction('user' . $CURUSER['id']);
    $mc1->update_row(false, array(
        'last_browse' => TIME_NOW
    ));
    $mc1->commit_transaction($INSTALLER09['expires']['user_cache']);
}
$HTMLOUT.= "</div></div><br>
<div class='container'>
 <div class='col-md-12'>   
<div>
<div class='col-md-4 col-md-offset-4'>
<br><a href='#myModal' class='btn btn-default btn-small' data-toggle='modal'>{$lang['search_inf_01']}</a><br><br>
<div id='myModal' class='modal fade'>
        <div class='modal-dialog'>
            <div class='modal-content'>
                <div class='modal-header'>
                    <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>".$search_help_boolean."
                </div>
            </div>
        </div>
    </div></div>
<div class='row'>
<div class='form-group'>

<!--<div class='col-md-4 input-group input-group-md text-center'><span class='input-group-addon'><i class='fa fa-search-plus'></i></span><input  class='form-control' placeholder='{$lang['search_fct_01']}' type='text' name='search' value='' /></div>-->
<div class='col-md-4'><i class='fa fa-search-plus'></i><input  class='form-control' placeholder='{$lang['search_fct_01']}' type='text' name='search' value='' /></div>";

//=== only free option :o)
$only_free =((isset($_GET['only_free'])) ? intval($_GET['only_free']) : '');
//=== checkbox for only free torrents
$only_free_box = '<input type="checkbox" name="only_free" value="1"'.(isset($_GET['only_free']) ? ' checked="checked"' : '').' />'.$lang['search_inf_02'].'';

$selected = (isset($_GET["incldead"])) ? (int)$_GET["incldead"] : "";
$deadcheck = "";
$deadcheck.= " <!--<div class='col-md-1 text-right'>in:</div><div class='col-md-2'><select class='form-control' name='incldead'>-->
in: 
<select class='form-control' name='incldead'>  
 <option value='0'>{$lang['browse_active']}</option>
    <option value='1'" . ($selected == 1 ? " selected='selected'" : "") . ">{$lang['browse_inc_dead']}</option>
    <option value='2'" . ($selected == 2 ? " selected='selected'" : "") . ">{$lang['browse_dead']}</option>
    </select><!--</div>-->";
$searchin = 'by:<select class="form-control"  name="searchin"><!--<div class="col-md-1 text-right">by:</div><div class="col-md-2"><select class="form-control"  name="searchin">-->';
foreach (array(
    'title' => 'Name',
    'descr' => 'Description',
    'genre' => 'Genre',
    'all' => 'All'
) as $k => $v) $searchin.= '<option value="' . $k . '" ' . ($select_searchin == $k ? 'selected=\'selected\'' : '') . '>' . $v . '</option>';
$searchin.= '</select><!--</div>-->';

//$HTMLOUT.= $searchin . $deadcheck . $only_free_box ;
$HTMLOUT.="<div class='col-md-3'>$searchin</div>" . "<div class='col-md-3'>$deadcheck</div>" . "<br>". $only_free_box ."</div>";

$HTMLOUT.= "</div><br><div class='col-md-2 col-md-offset-5'><input class='form-control' type='submit' value='{$lang['search_search_btn']}' class='btn btn-primary'></div>
           </form><br >";
$HTMLOUT.= "{$new_button}";
if (isset($cleansearchstr)) {
    $HTMLOUT.= "<div class='row'><div class='col-md-6 col-md-offset-4'><h2>{$lang['browse_search']} " . htmlsafechars($searchstr, ENT_QUOTES) . "</h2></div></div>\n";
}
if ($count) {
    $HTMLOUT.="<br><div class='row'><div class='col-md-3 col-md-offset-5'><div style='display:inline-block;width:10px';></div><a href='{$INSTALLER09["baseurl"]}/browse.php' class='btn btn-default btn-default'>{$lang['old_school_b']}</a></div></div><br><br>". $pager['pagertop'];
    $HTMLOUT.= "<br >";
    $HTMLOUT.= torrenttable($res);
    $HTMLOUT.= "<br >";
    $HTMLOUT.= $pager['pagerbottom'];
    $HTMLOUT.= "<br >";
    } else {
    if (isset($cleansearchstr)) {
        $HTMLOUT.= "<div class='row'><div class='col-md-6 col-md-offset-4'><h2>{$lang['browse_not_found']}</h2>";
        $HTMLOUT.= "{$lang['browse_tryagain']}</div></div>\n";
    } else {
        $HTMLOUT.= "<div class='row'><div class='col-md-6 col-md-offset-5'><h2>{$lang['browse_nothing']}</h2>\n";
        $HTMLOUT.= "{$lang['browse_sorry']}</div></div>\n";
    }
}
$HTMLOUT.= "<!--</div></div>-->";
$ip = getip();
//== Start ip logger - Melvinmeow, Mindless, pdq
$no_log_ip = ($CURUSER['perms'] & bt_options::PERMS_NO_IP);
if ($no_log_ip) {
    $ip = '127.0.0.1';
}
if (!$no_log_ip) {
    $userid = (int)$CURUSER['id'];
    $added = TIME_NOW;
    $res = sql_query("SELECT * FROM ips WHERE ip = " . sqlesc($ip) . " AND userid = " . sqlesc($userid)) or sqlerr(__FILE__, __LINE__);
    if (mysqli_num_rows($res) == 0) {
        sql_query("INSERT INTO ips (userid, ip, lastbrowse, type) VALUES (" . sqlesc($userid) . ", " . sqlesc($ip) . ", $added, 'Browse')") or sqlerr(__FILE__, __LINE__);
        $mc1->delete_value('ip_history_' . $userid);
    } else {
        sql_query("UPDATE ips SET lastbrowse = $added WHERE ip=" . sqlesc($ip) . " AND userid = " . sqlesc($userid)) or sqlerr(__FILE__, __LINE__);
        $mc1->delete_value('ip_history_' . $userid);
    }
}
//== End Ip logger
echo stdhead($title, true, $stdhead) . $HTMLOUT . stdfoot($stdfoot);
?>
