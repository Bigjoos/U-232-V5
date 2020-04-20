function checkbox()
 {
    for(i=0; i<document.forms[0].elements.length; i++){
	if(document.forms[0].elements[i].type == 'checkbox' && document.forms[0].elements[i].name.indexOf('id') > -1)
	{
	   var state = document.forms[0].elements[i].checked;
	   document.forms[0].elements[i].checked = state ? false : true ;
	}
      }
    }
