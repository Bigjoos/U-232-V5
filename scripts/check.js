function checkit() {
wantusername = document.getElementById('wantusername').value;
var url = '../namecheck.php?wantusername=' + escape(wantusername);
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
global_content = wantusername;
request.onreadystatechange = check;
request.send(null);
}

function check() {
if (request.readyState == 4) {
if (request.status == 200) {
var response = request.responseText;		
document.getElementById("namecheck").innerHTML = response;
if(response.substring(0,20) == "<font color='#cc0000'>")
document.reform.submitt.disabled = true;
else if(response.substring(0,20) == "<font color='#33cc33'>")
document.reform.submitt.disabled = false;
}
}
}
