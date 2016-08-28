//=== to use this script...
//  make sure to name the form "checkme"
// and call like so:
// <form action="" name=checkme onSubmit="return ValidateForm(this,'nameofthing')">
// in a while loop...
// <input type=checkbox name="nameofthing[]" value='.$arr['id'].' />
// and finally...
// <a href="javascript:SetChecked(1,'nameofthing[]')"> select all</a> - <a class=altlink href="javascript:SetChecked(0,'nameofthing[]')">un-select all</a>
// <input class=btn type=submit value="enter"></form>
//=== handy for selecting many checkboxes :)

var form='checkme'

function SetChecked(val,chkName) {
dml=document.forms[form];
len = dml.elements.length;
var i=0;
for( i=0 ; i<len ; i++) {
if (dml.elements[i].name==chkName) {
dml.elements[i].checked=val;
}
}
}