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
dbconn(true);
loggedinorreturn();
$HTMLOUT = '';
$HTMLOUT .='
<script src="./scripts/prefixfree.js"></script>
<style type="text/css">
 /* Make it a marquee */
.marquee {
    #width: 450px;
    margin: 0 auto;
    overflow: hidden;
    white-space: nowrap;
    box-sizing: border-box;
    animation: marquee 85s linear infinite;
color: white;
}
.marquee:hover {
    animation-play-state: paused
}
/* Make it move */
@keyframes marquee {
    0%   { text-indent: 110% }
    100% { text-indent: -400% }
}
/*Correction for iphone 6*/
@media only screen 
and (min-device-width : 375px) 
and (max-device-width : 667px) { 
@keyframes marquee {
    0%   { text-indent: 0% }
    100% { text-indent: -400% }
}
.marquee {
    margin-left:50%;margin-right:0;}

}
/* Make it pretty */
.microsoft {
    padding-left: 1.5em;
    position: relative;
    font: 16px "Segoe UI", Tahoma, Helvetica, Sans-Serif;
}
/* ::before was :before before ::before was ::before - kthx */
.microsoft:before, .microsoft::before {
    z-index: 2;
    content: "";
    position: absolute;
    top: -1em; left: -1em;
    width: .5em; height: .5em;

}
.microsoft:after, .microsoft::after {
    z-index: 1;
    content: "";
    position: absolute;
    top: 0; left: 0;
    width: 2em; height: 2em;
}
/* Style the links */
.vanity {
    color: #333;
    text-align: center;
    font: .75em "Segoe UI", Tahoma, Helvetica, Sans-Serif;
}
.vanity a, .microsoft a {
    color: #1570A6;
    transition: color .5s;
    text-decoration: none;
}
.vanity a:hover, .microsoft a:hover {
    color: #F65314;
}
/* Style toggle button */
.toggle {
	display: block;
    margin: 2em auto;
}  </style>
<body onload="ajax(page,\'scriptoutput\')"></script>
<div style = "width: 98%;margin: 0 auto;">
<p class="microsoft marquee">
<span id="scriptoutput"></span>
</p></div>
<script type="text/javascript">
// Set the variable for the dynamic content page below
var page = "auto_shout_scroll_get.php";
function ajax(url,target)
{
// native XMLHttpRequest object
document.getElementById(target).innerHTML = "";
if (window.XMLHttpRequest) {
req = new XMLHttpRequest();
req.onreadystatechange = function() {ajaxDone(target);};
req.open("GET", url, true);
req.send(null);
// IE/Windows ActiveX version
} else if (window.ActiveXObject) {
req = new ActiveXObject("Microsoft.XMLHTTP");
if (req) {
req.onreadystatechange = function() {ajaxDone(target);};
req.open("GET", url, true);
req.send();
}
}
setTimeout("ajax(page,\'scriptoutput\')", 85000);
}
function ajaxDone(target) {
// only if req is "loaded"
if (req.readyState == 4) {
// only if "OK"
if (req.status == 200 || req.status == 304) {
results = req.responseText;
document.getElementById(target).innerHTML = results;
} else {
document.getElementById(target).innerHTML="ajax error:\n" +
req.statusText;
}
}
}
</script>';

echo $HTMLOUT;

?>
