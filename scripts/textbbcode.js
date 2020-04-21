//made by putyn@tbdev.net lastupdate 28/12/2009

function wrap(v, r, e) {
  var r = r ? r : "";
  var v = v ? v : "";
  var e = e ? e : "";

  var obj = document.getElementById(textBBcode);

  if (document.selection) {
    var str = document.selection.createRange().text;
    obj.focus();
    var sel = document.selection.createRange();
    sel.text = "[" + v + (e ? "=" + e : "") + "]" + (r ? r : str) + "[/" + v + "]";
  } else {
    var len = obj.value.length;
    var start = obj.selectionStart;
    var end = obj.selectionEnd;
    var sel = obj.value.substring(start, end);
    obj.value = obj.value.substring(0, start) + "[" + v + (e ? "=" + e : "") + "]" + (r ? r : sel) + "[/" + v + "]" + obj.value.substring(end, len);
    obj.selectionEnd = start + v.length + e.length + sel.length + r.length + v.length + 5;

  }
  obj.focus();
}

function clink() {
  var linkTitle;
  var linkAddr;

  linkAddr = prompt("Please enter the full URL", "http://");
  if (linkAddr && linkAddr != "http://") linkTitle = prompt("Please enter the title", " ");

  if (linkAddr && linkTitle) wrap('url', linkTitle, linkAddr);

}

function cimage() {
  var link;
  link = prompt("Please enter the full URL for your image\nOnly .png, .jpg, .gif images", "http://");
  var re_text = /\.jpg|\.gif|\.png|\.jpeg/i;
  if (re_text.test(link) == false && link != "http://" && link) {
    alert("Image not allowed only .jpg .gif .png .jpeg");
    link = prompt("Please enter the full URL for your image\nOnly .png, .jpg, .gif images", "http://");
  }
  if (link != "http://" && link) wrap('img', link, '');

}

function tag(v) {
  wrap(v, '', '');
}

function mail() {
  var email = "";
  email = prompt("Plese enter the email addres", " ");
  var filter = /^[\w.-]+@([\w.-]+\.)+[a-z]{2,6}$/i;
  if (!filter.test(email) && email.length > 1) {
    alert("Please provide a valid email address");
    email = prompt("Plese enter the email addres", " ");
  }
  if (email.length > 1) wrap('mail', email, '');
}

function text(to) {
  var obj = document.getElementById(textBBcode);

  if (document.selection) {
    var str = document.selection.createRange().text;
    obj.focus();
    var sel = document.selection.createRange();
    sel.text = (to == 'up' ? str.toUpperCase() : str.toLowerCase())
  } else {
    var len = obj.value.length;
    var start = obj.selectionStart;
    var end = obj.selectionEnd;
    var sel = obj.value.substring(start, end);
    obj.value = obj.value.substring(0, start) + (to == 'up' ? sel.toUpperCase() : sel.toLowerCase()) + obj.value.substring(end, len);
  }
  obj.focus();

}

function fonts(w) {
  var fmin = 12;
  var fmax = 24;
  var obj = document.getElementById(textBBcode);
  var size = obj.style.fontSize;
  size = (parseInt(size));
  var nsize;
  if (w == 'up' && (size + 1 < fmax)) nsize = (size + 1) + "px";
  if (w == 'down' && (size - 1 > fmin)) nsize = (size - 1) + "px";

  obj.style.fontSize = nsize;
  obj.focus();
}

function font(w, f) {
  if (w == 'color') f = "#" + f;

  var obj = document.getElementById(textBBcode);

  if (document.selection) {
    var str = document.selection.createRange().text;
    obj.focus();
    var sel = document.selection.createRange();
    sel.text = "[" + w + "=" + f + "]" + str + "[/" + w + "]";
  } else {
    var len = obj.value.length;
    var start = obj.selectionStart;
    var end = obj.selectionEnd;
    var sel = obj.value.substring(start, end);
    obj.value = obj.value.substring(0, start) + "[" + w + "=" + f + "]" + sel + "[/" + w + "]" + obj.value.substring(end, len);
    obj.selectionEnd = start + w.length + (1 + f.length) + sel.length + w.length + 5;
  }
  if (w != "color") document.getElementById("font" + w).selectedIndex = 0;
  obj.focus();
}

function em(f) {
  var obj = document.getElementById(textBBcode);

  if (document.selection) {
    var str = document.selection.createRange().text;
    obj.focus();
    var sel = document.selection.createRange();
    sel.text = f;
  } else {
    var len = obj.value.length;
    var start = obj.selectionStart;
    var end = obj.selectionEnd;
    var sel = obj.value.substring(start, end);
    obj.value = obj.value.substring(0, start) + f + obj.value.substring(end, len);
    obj.selectionEnd = start + f.length;
  }
  obj.focus();
}
document.onmousemove = MouseUpdate;
var hX;
var hY;

function chover(obj, act) {
  var color = obj.style.backgroundColor;
  var obj2 = document.getElementById("hover_pick");

  if (act == "show") {
    obj2.style.left = hX + "px";
    obj2.style.top = hY + "px";
    obj2.style.backgroundColor = color;
    obj2.style.display = "block";
  } else obj2.style.display = "none";

}
isBuild = false;

function colorpicker() {
  if (!isBuild) {
    var myColors = new Array('000000', '000033', '000066', '000099', '0000CC', '0000FF', '003300', '003333', '003366', '003399', '0033CC', '0033FF', '006600', '006633', '006666', '006699', '0066CC', '0066FF', '009900', '009933', '009966', '009999', '0099CC', '0099FF', '00CC00', '00CC33', '00CC66', '00CC99', '00CCCC', '00CCFF', '00FF00', '00FF33', '00FF66', '00FF99', '00FFCC', '00FFFF', '330000', '330033', '330066', '330099', '3300CC', '3300FF', '333300', '333333', '333366', '333399', '3333CC', '3333FF', '336600', '336633', '336666', '336699', '3366CC', '3366FF', '339900', '339933', '339966', '339999', '3399CC', '3399FF', '33CC00', '33CC33', '33CC66', '33CC99', '33CCCC', '33CCFF', '33FF00', '33FF33', '33FF66', '33FF99', '33FFCC', '33FFFF', '660000', '660033', '660066', '660099', '6600CC', '6600FF', '663300', '663333', '663366', '663399', '6633CC', '6633FF', '666600', '666633', '666666', '666699', '6666CC', '6666FF', '669900', '669933', '669966', '669999', '6699CC', '6699FF', '66CC00', '66CC33', '66CC66', '66CC99', '66CCCC', '66CCFF', '66FF00', '66FF33', '66FF66', '66FF99', '66FFCC', '66FFFF', '990000', '990033', '990066', '990099', '9900CC', '9900FF', '993300', '993333', '993366', '993399', '9933CC', '9933FF', '996600', '996633', '996666', '996699', '9966CC', '9966FF', '999900', '999933', '999966', '999999', '9999CC', '9999FF', '99CC00', '99CC33', '99CC66', '99CC99', '99CCCC', '99CCFF', '99FF00', '99FF33', '99FF66', '99FF99', '99FFCC', '99FFFF', 'CC0000', 'CC0033', 'CC0066', 'CC0099', 'CC00CC', 'CC00FF', 'CC3300', 'CC3333', 'CC3366', 'CC3399', 'CC33CC', 'CC33FF', 'CC6600', 'CC6633', 'CC6666', 'CC6699', 'CC66CC', 'CC66FF', 'CC9900', 'CC9933', 'CC9966', 'CC9999', 'CC99CC', 'CC99FF', 'CCCC00', 'CCCC33', 'CCCC66', 'CCCC99', 'CCCCCC', 'CCCCFF', 'CCFF00', 'CCFF33', 'CCFF66', 'CCFF99', 'CCFFCC', 'CCFFFF', 'FF0000', 'FF0033', 'FF0066', 'FF0099', 'FF00CC', 'FF00FF', 'FF3300', 'FF3333', 'FF3366', 'FF3399', 'FF33CC', 'FF33FF', 'FF6600', 'FF6633', 'FF6666', 'FF6699', 'FF66CC', 'FF66FF', 'FF9900', 'FF9933', 'FF9966', 'FF9999', 'FF99CC', 'FF99FF', 'FFCC00', 'FFCC33', 'FFCC66', 'FFCC99', 'FFCCCC', 'FFCCFF', 'FFFF00', 'FFFF33', 'FFFF66', 'FFFF99', 'FFFFCC', 'FFFFFF');
    var pickerBody = '';

    pickerBody += "<table class=\"color_pick\" id=\"color_pick\" border=\"1\" cellspacing=\"2\" cellpadding=\"0\" style=\"position:static; display:none;\"><tr>";
    for (i = 0; i < myColors.length; i++) {

      if (i % 12 == 0 && i != 0) pickerBody += "<\/tr><tr>";
      pickerBody += "<td onclick=\"font('color','" + myColors[i] + "');colorpicker();\" onmouseover=\"chover(this,'show');\" onmouseout=\"chover(this,'back');\" style=\"background:#" + myColors[i] + ";\"></td>"

    }
    pickerBody += "<\/tr><\/table>";
    document.getElementById('pickerholder').innerHTML = pickerBody;
    isBuild = true;
  }
  var obj = document.getElementById("color_pick");

  if (obj.style.display == "block") obj.style.display = "none";
  else {
    obj.style.left = hX + "px";
    obj.style.top = hY + "px";
    obj.style.display = "block";
  }
}
//function to capture the mouse cords
// http://www.howtocreate.co.uk/tutorials/javascript/eventinf


function MouseUpdate(e) {
  var mouse = MouseXY(e);
  hX = 5 + mouse[0];
  hY = 5 + mouse[1];
}

function MouseXY(e) {
  if (!e) {
    if (window.event) {
      //Internet Explorer
      e = window.event;
    } else {
      //total failure, we have no way of referencing the event
      return;
    }
  }
  if (typeof(e.pageX) == 'number') {
    //most browsers
    var xcoord = e.pageX;
    var ycoord = e.pageY;
  } else if (typeof(e.clientX) == 'number') {
    //Internet Explorer and older browsers
    //other browsers provide this, but follow the pageX/Y branch
    var xcoord = e.clientX;
    var ycoord = e.clientY;
    var badOldBrowser = (window.navigator.userAgent.indexOf('Opera') + 1) || (window.ScriptEngine && ScriptEngine().indexOf('InScript') + 1) || (navigator.vendor == 'KDE');
    if (!badOldBrowser) {
      if (document.body && (document.body.scrollLeft || document.body.scrollTop)) {
        //IE 4, 5 & 6 (in non-standards compliant mode)
        xcoord += document.body.scrollLeft;
        ycoord += document.body.scrollTop;
      } else if (document.documentElement && (document.documentElement.scrollLeft || document.documentElement.scrollTop)) {
        //IE 6 (in standards compliant mode)
        xcoord += document.documentElement.scrollLeft;
        ycoord += document.documentElement.scrollTop;
      }
    }
  } else {
    //total failure, we have no way of obtaining the mouse coordinates
    return;
  }
  return [xcoord, ycoord];
}
