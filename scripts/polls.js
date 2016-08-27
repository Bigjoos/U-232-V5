var open_div='poll-box-open';
var closed_div='poll-box-closed';
var stat_div='poll-box-stat';
var main_div='poll-box-main';
var form_id='postingform';
var openobj;
var closedobj;
var formobj;
var statobj;
var mainobj;
var used_questions=0;
function poll_init_state(){
openobj=document.getElementById(open_div);
closedobj=document.getElementById(closed_div);
formobj=document.getElementById(form_id);
statobj=document.getElementById(stat_div);
mainobj=document.getElementById(main_div);
if(showfullonload){
my_show_div(openobj);
my_hide_div(closedobj);
}else{
my_show_div(closedobj);
my_hide_div(openobj);
}
poll_draw_main_box();
}

function my_hide_div(itm){
if(!itm)return;
itm.style.display="none";
}

function my_show_div(itm){
if(!itm)return;
itm.style.display="";
}

function lang_build_string(){
if(!arguments.length||!arguments){
return;}
var string=arguments[0];
for(var i=1;i<arguments.length;i++){
var match=new RegExp('<%'+i+'>','gi');
string=string.replace(match,arguments[i]);}
return string;
}

function poll_draw_main_box(){
var html='';
used_questions=0;
for(var i in poll_questions){
var qhtml='';
used_questions++;
var question=poll_questions[i];
var this_poll_multi='';
for(var x in poll_multi){
if(x==i){if(poll_multi[x]==1){
this_poll_multi="checked='checked'";
}
}
}
var inputhtml=lang_build_string(html_question_box,i,_poll_make_form_safe(question),this_poll_multi);qhtml+="\n"+inputhtml+"\n";
var choices='';
var choices_count=0;
for(
var c in poll_choices){
var votes_box;
var id=c.replace(new RegExp("^"+i+"_(\\d+)$"),"$1");
if(!isNaN(id)){

votes_box=lang_build_string(html_votes_box,i,id,poll_votes[c]);

choices_count++;
choices+="\n"+lang_build_string(html_choice_box,i,id,_poll_make_form_safe(poll_choices[c]),votes_box);}}if(choices_count<max_poll_choices){choices+=lang_build_string(html_add_choice,i);}if(choices!=''){qhtml+="\n"+lang_build_string(html_choice_wrap,choices)+"\n";}html+=lang_build_string(html_question_wrap,qhtml);}if(used_questions<max_poll_questions){html+=lang_build_string(html_question_wrap,html_add_question);}mainobj.innerHTML=html;poll_update_state();}

function poll_write_form_to_array(){
var tmp_poll_questions={};
var tmp_poll_choices={};
var tmp_poll_multi={};
for(var i in poll_questions){
try{tmp_poll_questions[i]=document.getElementById('question_'+i).value;}
catch(e){}}for(var x in poll_multi){
try{tmp_poll_multi[x]=document.getElementById('multi_'+x).checked?1:0;}
catch(e){}}for(var c in poll_choices){
try{tmp_poll_choices[c]=document.getElementById('choice_'+c).value;}
catch(e){}}poll_questions=tmp_poll_questions;poll_choices=tmp_poll_choices;poll_multi=tmp_poll_multi;
}

function poll_add_question(){
var maxid=0;
for(var i in poll_questions){
if(i>maxid){maxid=parseInt(i);}}maxid=maxid+1;poll_write_form_to_array();poll_questions[maxid]='';poll_multi[maxid]='';poll_draw_main_box();
return false;
}

function poll_add_choice(qid){var maxid=0;for(var c in poll_choices){var id=c.replace(new RegExp("^"+qid+"_(\\d+)$"),"$1");if(!isNaN(id)){if(id>maxid){maxid=parseInt(id);}}}maxid=maxid+1;poll_write_form_to_array();poll_choices[qid+'_'+maxid]='';
poll_votes[qid+'_'+maxid]=0;
poll_draw_main_box();
return false;
}

function poll_remove_choice(mainid){if(confirm(js_lang_confirm)){delete(poll_choices[mainid]);
delete(poll_votes[mainid]);
poll_write_form_to_array();
poll_draw_main_box();}
return false;
}

function poll_remove_question(mainid){if(confirm(js_lang_confirm)){delete(poll_questions[mainid]);for(var c in poll_choices){var id=c.replace(new RegExp("^"+mainid+"_(\\d+)$"),"$1");
if(!isNaN(id)){
delete(poll_choices[c]);
delete(poll_votes[c]);
}
}
poll_write_form_to_array();poll_draw_main_box();}
return false;}

function poll_update_state(){
used=max_poll_questions-used_questions;
var tmp_lang=lang_build_string(poll_stat_lang,used,max_poll_choices);
statobj.innerHTML=lang_build_string(html_stat_wrap,tmp_lang);}

function show_poll_form(){my_show_div(openobj);my_hide_div(closedobj);}

function close_poll_form(){my_show_div(closedobj);my_hide_div(openobj);}

function _poll_make_form_safe(t){t=t.replace( /'/g,'&#039;');t=t.replace( /"/g,'&quot;');return t;}
