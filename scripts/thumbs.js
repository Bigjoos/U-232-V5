function ThumbsUp(id) {
	var url = 'ajax_thumbsup.php?id=' + escape(id);
	try {
		request = new ActiveXObject('Msxml2.XMLHTTP');
	} catch (e) {
				try {
					request = new ActiveXObject('Microsoft.XMLHTTP');
					} catch (e2) {
						request = false;
								}
				}

if (!request && typeof XMLHttpRequest != 'undefined') {
request = new XMLHttpRequest();
}
	request.open('GET', url, true);
	global_content = id;
	request.onreadystatechange = gom;
	request.send(null);
}
function gom() {
  if (request.readyState == 4) {
	  if (request.status == 200) {
		var response = request.responseText;
		document.getElementById('thumbsup').innerHTML = response;
	  }
  }
}
