function SmileIT(smile,form,text){
document.forms[form].elements[text].value = document.forms[form].elements[text].value+" "+smile+" ";
document.forms[form].elements[text].focus();
}
function PopMoreSmiles(form,name) {
link='moresmiles.php?form='+form+'&text='+name
newWin=window.open(link,'moresmile','height=500,width=450,resizable=no,scrollbars=1');
if (window.focus) {newWin.focus()}
}
function PopCustomSmiles(form,name) {
link='moresmilies_custom.php?form='+form+'&text='+name
newWin=window.open(link,'moresmilecustom','height=600,width=400,resizable=yes,scrollbars=1');
if (window.focus) {newWin.focus()}
}
function PopStaffSmiles(form,name) {
link='staff_smilies.php?form='+form+'&text='+name
newWin=window.open(link,'staffsmile','height=600,width=600,resizable=yes,scrollbars=1');
if (window.focus) {newWin.focus()}
}
function popUp(URL) {
day = new Date();
id = day.getTime();
eval("page" + id + " = window.open(URL, '" + id + "', 'toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=1,width=740,height=380,left = 340,top = 280');");
}

function mysubmit() {
if($("input[type='text'][name='shbox_text']").val().length == 0){alert("Shout cannot be empty");exit();}
setTimeout('document.shbox.reset()',100);

}

function staff_mysubmit() {
if($("input[type='text'][name='staff_shbox_text']").val().length == 0){alert("Shout cannot be empty");exit();}
setTimeout('document.staff_shbox.reset()',100);

}

function confirm_delete()
{
   if(confirm('Are you sure you want to do this ?'))
   {
     if(confirm('Are you 100% sure ?'))
	 {
		alert("Your are sure!");
		self.location.href='./shoutbox.php?delall';
	 }
   }
}
function private_reply(to,form,text) { 
	document.forms[form].elements[text].value='/private '+to+' ';
	document.forms[form].elements[text].focus();
}
