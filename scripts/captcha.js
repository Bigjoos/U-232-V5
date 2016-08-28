// CREATING THE REQUEST

function createRequestObject()
{
	try
	{
		xmlhttp = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject("Microsoft.XMLHTTP");
	}
	catch(e)
	{
		alert('Sorry, but your browser doesn\'t support XMLHttpRequest.');
	}
	return xmlhttp;
}

var http = createRequestObject();
var sess = createRequestObject();

// IMAGE REFRESHING

function refreshimg()
{
	var url = 'captcha/image_req.php';
	dorefresh(url, displayimg);
}

function dorefresh(url, callback)
{
	sess.open('POST', 'newsession.php', true);
	sess.send(null);
	http.open('POST', url, true);
	http.onreadystatechange = displayimg;
	http.send(null);
}

function displayimg()
{
	if(http.readyState == 4)
	{
		var showimage = http.responseText;
		document.getElementById('captchaimage').innerHTML = showimage;
	}
}

// SUBMISSION

function check()
{
	var submission = document.getElementById('captcha').value;
	var url = 'captcha/process.php?captcha=' + submission;
	docheck(url, displaycheck);
}

function docheck(url, callback)
{
	http.open('GET', url, true);
	http.onreadystatechange = displaycheck;
	http.send(null);
}

function displaycheck()
{
	if(http.readyState == 4)
	{
		var showcheck = http.responseText;
		if(showcheck == '1')
		{
			document.getElementById('captcha').style.border = '1px solid #49c24f';
			document.getElementById('captcha').style.background = '#bcffbf';
		}
		if(showcheck == '0')
		{
			document.getElementById('captcha').style.border = '1px solid #c24949';
			document.getElementById('captcha').style.background = '#ffbcbc';

		}
	}
}