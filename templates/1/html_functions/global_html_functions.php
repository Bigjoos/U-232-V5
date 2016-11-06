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
 ///// global, table tr, td, and div classes for blocks
function begin_main_div()
{
    return "<div class='panel panel-default'>";
}
function begin_head_div()
{
    return "<div class='panel-heading'>";
}
function end_head_div()
{
    return "</div>";
}
function begin_head_label($x)
{
    return "<label for='checkbox_4' class='text-left'>";
}
function end_head_label()
{
    return "</label>";
}
function begin_body_div($x)
{
    return "<div class='panel-body'>";
}
function end_body_div()
{
    return "</div>";
}
function end_div()
{
    return "</div>";
}
function begin_main_table()
{
    return "<table class='table table-hover'>"; 
}
/// end golbal global, table tr, td, and div classes for blocks

?>