function ShowHideMainCats(tableCount)
{
	var MainCats = document.getElementById('cats');
	var MainCatsPic = document.getElementById('pic');
	var DefCats = document.getElementById('defcats');

	if (MainCats.style.display == 'none') {
	  MainCats.style.display = 'block';
	  DefCats.style.display = 'block';
	  MainCatsPic.src = 'pic/minus.png';
	}
	else {
	  MainCats.style.display = 'none';
	  DefCats.style.display = 'none';
	  MainCatsPic.src = 'pic/plus.png';
	}
	
	for(i = 1; i <= tableCount; i++) {
		tableID = 'tabletype' + i;
		tabletype = document.getElementById(tableID);
		picID = 'pic' + i;
		picture = document.getElementById(picID);
		tabletype.style.display = 'none';
		picture.src = 'pic/plus.png';
	}
	
}


function ShowHideMainSubCats(tableNum,tableCount){
	
	//Modified http://lists.evolt.org/pipermail/javascript/2006-May/010443.html
	
	if(tableCount > 1)
	for(i = 1; i <= tableCount; i++) {
		tableID = 'tabletype' + i;
		tabletype = document.getElementById(tableID);
		picID = 'pic' + i;
		picture = document.getElementById(picID);
		
		if(i == tableNum){
			if(tabletype.style.display == 'none')
			{
			tabletype.style.display = 'block';
			picture.src = 'pic/minus.png';
		    }
			else
			{
			tabletype.style.display = 'none';
			picture.src = 'pic/plus.png';
		}
		}
		else
		{
		tabletype.style.display = 'none';
		picture.src = 'pic/plus.png';
	}

	}
}

function checkAllFields(ref,tabletype) {
	
	//Modified http://www.dustindiaz.com/check-one-check-all-javascript/
	
	checkAllID = 'checkAll' + tabletype;
    var chkAll = document.getElementById(checkAllID);
	CatsID = 'cats' + tabletype + '[]';
    var checks = document.getElementsByName(CatsID);
 
    var boxLength = checks.length;
    var allChecked = false;
    var totalChecked = 0;
    if (ref == 1) {
        if (chkAll.checked == true) {
            for (i = 0; i < boxLength; i++) {
                checks[i].checked = true;
            }
        } else {
            for (i = 0; i < boxLength; i++) {
                checks[i].checked = false;
            }
        }
    } else {
        for (i = 0; i < boxLength; i++) {
            if (checks[i].checked == true) {
                allChecked = true;
                continue;
            } else {
                allChecked = false;
                break;
            }
        }
        if (allChecked == true) {
            chkAll.checked = true;
        } else {
            chkAll.checked = false;
        }
    }
    for (j = 0; j < boxLength; j++) {
        if (checks[j].checked == true) {
            totalChecked++;
        }
    }

}

//==========================================
// Check All boxes
//==========================================
function CheckAll(fmobj) {
  for (var i=0;i<fmobj.elements.length;i++) {
    var e = fmobj.elements[i];
    if ( (e.name != 'allbox') && (e.type=='checkbox') && (!e.disabled) ) {
      e.checked = fmobj.allbox.checked;
    }
  }
}

//==========================================
// Check all or uncheck all?
//==========================================
function CheckCheckAll(fmobj) {
  var TotalBoxes = 0;
  var TotalOn = 0;
  for (var i=0;i<fmobj.elements.length;i++) {
    var e = fmobj.elements[i];
    if ((e.name != 'allbox') && (e.type=='checkbox')) {
      TotalBoxes++;
      if (e.checked) {
       TotalOn++;
      }
    }
  }
  if (TotalBoxes==TotalOn) {
    fmobj.allbox.checked=true;
  }
  else {
   fmobj.allbox.checked=false;
  }
}


function hide(){

if(document.layers){

document.appgame.visibility="hidden";
document.music.visibility="hidden";
document.other.visibility="hidden";
document.movie.visibility="hidden";

}
if(document.all){

document.all.appgame.style.visibility="hidden";
document.all.music.style.visibility="hidden";
document.all.other.style.visibility="hidden";
document.all.movie.style.visibility="hidden";

}

if(document.getElementById){

document.getElementById('Apps').style.visibility="hidden";
document.getElementById('Games').style.visibility="hidden";
document.getElementById('Movies').style.visibility="hidden";
document.getElementById('Music').style.visibility="hidden";

}
}

function whatbrowser(){
if(document.layers){
thisbrowser="NN4";
}
if(document.all){
thisbrowser="ie";
}
if(!document.all && document.getElementById){
thisbrowser="NN6";
}
}
// -->

function show(z) {

if(document.layers){

document[z].visibility="visible";
}
if(document.all){

document.all[z].style.visibility="visible";
}
if(document.getElementById){

document.getElementById([z]).style.visibility="visible";
}
}

function whatbrowser(){
if(document.layers){
thisbrowser="NN4";
}
if(document.all){
thisbrowser="ie";
}
if(!document.all && document.getElementById){
thisbrowser="NN6";
}
}
// -->
