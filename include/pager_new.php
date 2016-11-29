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
//=== new pager... count is total number, perpage is duh!, url is whatever it's goint too \o <=== and that's me waving to pdq, just saying "hi there"
function pager_new($count, $perpage, $page, $url, $page_link = false)
{
    global $INSTALLER09;
    $pages = floor($count / $perpage);
    if ($pages * $perpage < $count) ++$pages;
    //=== lets make php happy
    $page_num = '';
    $page = ($page < 1 ? 1 : $page);
    $page = ($page > $pages ? $pages : $page);
    //=== lets add the ... if too many pages
    switch (true) {
    case ($pages < 11):
        for ($i = 1; $i <= $pages; ++$i) {
            $page_num.= ($i == $page ? ' ' . $i . ' ' : ' <a class="altlink" href="' . $url . '&amp;page=' . $i . $page_link . '">' . $i . '</a> ');
        }
        break;
    case ($page < 5 || $page > ($pages - 3)):
        for ($i = 1; $i < 5; ++$i) {
            $page_num.= ($i == $page ? ' ' . $i . ' ' : ' <a class="altlink" href="' . $url . '&amp;page=' . $i . $page_link . '">' . $i . '</a> ');
        }
        $page_num.= ' ... ';
        $math = round($pages / 2);
        for ($i = ($math - 1); $i <= ($math + 1); ++$i) {
            $page_num.= ' <a class="altlink" href="' . $url . '&amp;page=' . $i . $page_link . '">' . $i . '</a> ';
        }
        $page_num.= ' ... ';
        for ($i = ($pages - 2); $i <= $pages; ++$i) {
            $page_num.= ($i == $page ? ' ' . $i . ' ' : ' <a class="altlink" href="' . $url . '&amp;page=' . $i . $page_link . '">' . $i . '</a> ');
        }
        break;
    case ($page > 4 && $page < ($pages - 2)):
        for ($i = 1; $i < 5; ++$i) {
            $page_num.= ' <a class="altlink" href="' . $url . '&amp;page=' . $i . $page_link . '">' . $i . '</a> ';
        }
        $page_num.= ' ... ';
        for ($i = ($page - 1); $i <= ($page + 1); ++$i) {
            $page_num.= ($i == $page ? ' ' . $i . ' ' : ' <a class="altlink" href="' . $url . '&amp;page=' . $i . $page_link . '">' . $i . '</a> ');
        }
        $page_num.= ' ... ';
        for ($i = ($pages - 2); $i <= $pages; ++$i) {
            $page_num.= ' <a class="altlink" href="' . $url . '&amp;page=' . $i . $page_link . '">' . $i . '</a> ';
        }
        break;
    }
    $menu = ($page == 1 ? ' <div style="text-align: center; font-weight: bold;"><img src="'.$INSTALLER09['pic_base_url'].'arrow_prev.gif" alt="&lt;&lt;" /> Prev' : '<div style="text-align: center; font-weight: bold;"><a class="altlink" href="' . $url . '&amp;page=' . ($page - 1) . $page_link . '"><img src="'.$INSTALLER09['pic_base_url'].'arrow_prev.gif" alt="&lt;&lt;" /> Prev</a>') . '&nbsp;&nbsp;&nbsp;' . $page_num . '&nbsp;&nbsp;&nbsp;' . ($page == $pages ? 'Next <img src="'.$INSTALLER09['pic_base_url'].'arrow_next.gif" alt="&gt;&gt;" /></div> ' : ' <a class="altlink" href="' . $url . '&amp;page=' . ($page + 1) . $page_link . '">Next <img src="'.$INSTALLER09['pic_base_url'].'arrow_next.gif" alt="&gt;&gt;" /></a></div>');
    $offset = ($page * $perpage) - $perpage;
    $LIMIT = ($count > 0 ? "LIMIT $offset,$perpage" : '');
    return array(
        $menu,
        $LIMIT
    );
} //=== end pager function
?>
