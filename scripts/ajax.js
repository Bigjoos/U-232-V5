var temppeers = '';
function hidepeers()
{
  document.getElementById("nopeerlist").innerHTML = '<a href="javascript:peerlist(<?php echo $id; ?>, 1);" class="sublink">[See full list]</a>';
  document.getElementById("peerlist").innerHTML = temppeers;
}
function peerlist(id, what) {
  temppeers = document.getElementById("peerlist").innerHTML;
  document.getElementById("peerlist").innerHTML = '<img src="pic/loading.gif" width="16" height="16">';
  document.getElementById("nopeerlist").innerHTML = '<a href=\"javascript:hidepeers();\">[Hide list]</a>';
	var url = 'ajax_peerlist.php?id=' + escape(id);
	try {
		request = new ActiveXObject("Msxml2.XMLHTTP");
	} catch (e) {
				try {
					request = new ActiveXObject("Microsoft.XMLHTTP");
					} catch (e2) {
						request = false;
								}
				}
if (!request && typeof XMLHttpRequest != 'undefined') {
  request = new XMLHttpRequest();
}
	request.open("GET", url, true);
	global_content = what;
	request.onreadystatechange = peersgo;
	request.send(null);
}
function peersgo() {
  if (request.readyState == 4) {
	  if (request.status == 200) {
		var response = request.responseText;
		var peerbox = document.getElementById("peerlist");
			fetch(peerbox);
      peerbox.innerHTML = response;
      if(global_content == 1)
      document.location.href = '#seeders';
      else
      document.location.href = '#leechers';
	  }
  }
}


var tmpfiler = '';

function hidefile()
{
  document.getElementById("hidefile").innerHTML = '<a href="javascript:filelist();" class="sublink">[See full list]</a>';
  document.getElementById("filelist").innerHTML = tmpfiler ;
}

function filelist() {

  tmpfiler = document.getElementById("filelist").innerHTML;
  document.getElementById("filelist").innerHTML = '<img src="pic/loading.gif" width="16" height="16">';
  document.getElementById("hidefile").innerHTML = '<a href=\"javascript:hidefile();\">[Hide list]</a>';
	var url = 'ajax_filelist.php?id=' + escape(<?php echo $id; ?>);
	try {
		request = new ActiveXObject("Msxml2.XMLHTTP");
	} catch (e) {
				try {
					request = new ActiveXObject("Microsoft.XMLHTTP");
					} catch (e2) {
						request = false;
								}
				}

if (!request && typeof XMLHttpRequest != 'undefined') {
  request = new XMLHttpRequest();
}
	request.open("GET", url, true);
	//global_content = id;
	request.onreadystatechange = filego;
	request.send(null);
}

function filego() {
  if (request.readyState == 4) {
	  if (request.status == 200) {
	  var filelist = document.getElementById("filelist");
	  fetch(filelist);
		var response = request.responseText;
      filelist.innerHTML = response;
	  }
  }
}

var url = window.location.href;
var pos = url.indexOf('#seeders');
var pos2 = url.indexOf('#leechers');
if(pos > -1)
{
peerlist(<?php echo $id; ?>, 1);
}
else if(pos2 > -1)
{
peerlist(<?php echo $id; ?>, 2);
}
//ajax peers fadebox 
var kvar = 100;
var object;
function fetch(obj)
{
  obj.style.opacity = kvar/100;
  obj.style.filter = 'alpha(opacity = ' + kvar + ')';
  kvar = 0;
  object = obj;
  startFade();
}
function startFade()
{
  object.style.opacity = kvar/100;
  object.style.filter = 'alpha(opacity = ' + kvar + ')';  
  kvar += 5;
  if(kvar < 95)
    setTimeout("startFade()", 15);
}
//end ajax peers fadebox