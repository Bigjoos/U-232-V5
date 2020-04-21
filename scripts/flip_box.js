//==============//
// will open and close a <div> and change an image on click
// how to use:
//
// <a name=$x id=$x></a> <img onclick="javascript:flipBox('".$arr['id']."')" src='pic/panel_on.gif' name='b_".$arr['id']."' style='vertical-align:middle;' />&nbsp;<a class=altlink href="#$x" onclick="javascript:flipBox('".$arr['id']."')" src='pic/panel_on.gif' name='b_".$arr['id']."'> LINK TEXT HERE</a>
// <div align='left' id='box_".$arr['id']."' style='display:none'><p> CONTENT </p></div>
// 
// 
// 
//==============//

function flipBox(who) {
var tmp;
if (document.images['b_' + who].src.indexOf('_on') == -1) {
tmp = document.images['b_' + who].src.replace('_off', '_on');
document.getElementById('box_' + who).style.display = 'none';
document.images['b_' + who].src = tmp;
} else {
tmp = document.images['b_' + who].src.replace('_on', '_off');
document.getElementById('box_' + who).style.display = 'block';
document.images['b_' + who].src = tmp;
}
}