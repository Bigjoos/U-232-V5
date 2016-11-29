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
function pager($rpp, $count, $href, $opts = array()) // thx yuna or whoever wrote it
{
    $pages = ceil($count / $rpp);
    if (!isset($opts["lastpagedefault"])) $pagedefault = 0;
    else {
        $pagedefault = floor(($count - 1) / $rpp);
        if ($pagedefault < 0) $pagedefault = 0;
    }
    if (isset($_GET["page"])) {
        $page = 0 + $_GET["page"];
        if ($page < 0) $page = $pagedefault;
    } else $page = $pagedefault;
    $pager = "<td style=\"center\" class=\"pager\">Page:</td><td class=\"pagebr\">&nbsp;</td>";
    $mp = $pages - 1;
    $as = "<b>&#171;</b>";
    if ($page >= 1) {
        $pager.= "<td  style=\"center\" class=\"pager\">";
        $pager.= "<a href=\"{$href}page=" . ($page - 1) . "\" style=\"text-decoration: none;\">$as</a>";
        $pager.= "</td><td  style=\"center\" class=\"pagebr\">&nbsp;</td>";
    }
    $as = "<b>&#187;</b>";
    $pager2 = $bregs = '';
    if ($page < $mp && $mp >= 0) {
        $pager2.= "<td  style=\"center\" class=\"pager\">";
        $pager2.= "<a href=\"{$href}page=" . ($page + 1) . "\" style=\"text-decoration: none;\">$as</a>";
        $pager2.= "</td>$bregs";
    } else $pager2.= $bregs;
    if ($count) {
        $pagerarr = array();
        $dotted = 0;
        $dotspace = 3;
        $dotend = $pages - $dotspace;
        $curdotend = $page - $dotspace;
        $curdotstart = $page + $dotspace;
        for ($i = 0; $i < $pages; $i++) {
            if (($i >= $dotspace && $i <= $curdotend) || ($i >= $curdotstart && $i < $dotend)) {
                if (!$dotted) $pagerarr[] = "<td  style=\"center\" class=\"pager\">...</td><td  style=\"center\" class=\"pagebr\">&nbsp;</td>";
                $dotted = 1;
                continue;
            }
            $dotted = 0;
            $start = $i * $rpp + 1;
            $end = $start + $rpp - 1;
            if ($end > $count) $end = $count;
            $text = $i + 1;
            if ($i != $page) $pagerarr[] = "<td  style=\"center\" class=\"pager\"><a title=\"$start&nbsp;-&nbsp;$end\" href=\"{$href}page=$i\" style=\"text-decoration: none;\"><b>$text</b></a></td><td  style=\"center\" class=\"pagebr\">&nbsp;</td>";
            else $pagerarr[] = "<td  style=\"center\" class=\"highlight\"><b>$text</b></td><td style=\"center\" class=\"pagebr\">&nbsp;</td>";
        }
        $pagerstr = join("", $pagerarr);
        $pagertop = "<table style=\"center\" class=\"main\"><tr>$pager $pagerstr $pager2</tr></table>\n";
        $pagerbottom = "<div style=\"center\">Overall $count items in " . ($i) . " page" . ($i > 1 ? '\'s' : '') . ", showing $rpp per page.</div><br /><table style=\"center\" class=\"main\"><tr>$pager $pagerstr $pager2</tr></table>\n";
    } else {
        $pagertop = $pager;
        $pagerbottom = $pagertop;
    }
    $start = $page * $rpp;
    return array(
        'pagertop' => $pagertop,
        'pagerbottom' => $pagerbottom,
        'limit' => "LIMIT $start,$rpp"
    );
}
function pager_rep($data)
{
    $pager = array(
        'pages' => 0,
        'page_span' => '',
        'start' => '',
        'end' => ''
    );
    $section = $data['span'] = isset($data['span']) ? $data['span'] : 2;
    $parameter = isset($data['parameter']) ? $data['parameter'] : 'page';
    $mini = isset($data['mini']) ? 'mini' : '';
    if ($data['count'] > 0) {
        $pager['pages'] = ceil($data['count'] / $data['perpage']);
    }
    $pager['pages'] = $pager['pages'] ? $pager['pages'] : 1;
    $pager['total_page'] = $pager['pages'];
    $pager['current_page'] = $data['start_value'] > 0 ? ($data['start_value'] / $data['perpage']) + 1 : 1;
    $previous_link = "";
    $next_link = "";
    if ($pager['current_page'] > 1) {
        $start = $data['start_value'] - $data['perpage'];
        $previous_link = "<a href='{$data['url']}&amp;$parameter=$start' title='Previous'><span class='{$mini}pagelink'>&lt;</span></a>";
    }
    if ($pager['current_page'] < $pager['pages']) {
        $start = $data['start_value'] + $data['perpage'];
        $next_link = "&nbsp;<a href='{$data['url']}&amp;$parameter=$start' title='Next'><span class='{$mini}pagelink'>&gt;</span></a>";
    }
    if ($pager['pages'] > 1) {
        if (isset($data['mini'])) {
            $pager['first_page'] = "<img src='{$INSTALLER09['pic_base_url']}multipage.gif' alt='' title='' />";
        } else {
            $pager['first_page'] = "<span style='background: #F0F5FA; border: 1px solid #072A66;padding: 1px 3px 1px 3px;'>{$pager['pages']} Pages</span>&nbsp;";
        }
        for ($i = 0; $i <= $pager['pages'] - 1; ++$i) {
            $RealNo = $i * $data['perpage'];
            $PageNo = $i + 1;
            if ($RealNo == $data['start_value']) {
                $pager['page_span'].= $mini ? "&nbsp;<a href='{$data['url']}&amp;$parameter={$RealNo}' title='$PageNo'><span  class='{$mini}pagelink'>$PageNo</span></a>" : "&nbsp;<span class='pagecurrent'>{$PageNo}</span>";
            } else {
                if ($PageNo < ($pager['current_page'] - $section)) {
                    $pager['start'] = "<a href='{$data['url']}' title='Goto First'><span class='{$mini}pagelinklast'>&laquo;</span></a>&nbsp;";
                    continue;
                }
                if ($PageNo > ($pager['current_page'] + $section)) {
                    $pager['end'] = "&nbsp;<a href='{$data['url']}&amp;$parameter=" . (($pager['pages'] - 1) * $data['perpage']) . "' title='Go To Last'><span class='{$mini}pagelinklast'>&raquo;</span></a>&nbsp;";
                    break;
                }
                $pager['page_span'].= "&nbsp;<a href='{$data['url']}&amp;$parameter={$RealNo}' title='$PageNo'><span  class='{$mini}pagelink'>$PageNo</span></a>";
            }
        }
        $float = $mini ? '' : ' fleft';
        $pager['return'] = "<div class='pager{$float}'>{$pager['first_page']}{$pager['start']}{$previous_link}{$pager['page_span']}{$next_link}{$pager['end']}
			</div>";
    } else {
        $pager['return'] = '';
    }
    return $pager['return'];
}
?>