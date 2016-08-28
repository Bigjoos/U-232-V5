$(document).ready( function () {
  $('#status_button').click(function () {
   alert('should edit');
  });
  $('#status_button_cancel').click(function () {
   alert('Should cancel');
  });
 });
function status_count() {
 var text_limit = 140;
 var text = $('#status').val();
 if(typeof text == 'undefined')
 var text = $('#box_status').val();
 var text_length = text.length;
 if(text_length > text_limit)
  $('#status').val(text.substr(0,text_limit));
 else
  $('#status_count').html(text_limit-text_length);
}

function status_slide(){
 if($('#status_archive').is(':hidden')){
   $('#status_archive').slideDown('slow');
   $('#status_archive_click').html('-');
 } else {
   $('#status_archive').slideUp('slow');
   $('#status_archive_click').html('+');
 }
}
function status_pedit() {
  var current = $('#current_status').html();
  $('#current_holder').hide();
  $('#status').val('').val(current).focus();
  $('#status').after("<div id='status_buttons'><input type='button' onclick='status_edit()' value='Edit' /><input type='button' onclick='status_cancel()' value='Cancel' /></div>");
  status_count();
}
function status_edit() {
  var status = $('#status').val();
  $.post('ajax.status.php',{action:'edit',ss:status},function (data) {
   if(data.status) {
     $('#status_buttons').fadeOut().remove();
     $('#status').val('');
     $('#current_status').empty().html(data.msg);
     $('#current_holder').fadeIn();
     status_count();
   }else 
   alert(data.msg);
  },'json');
}
function status_showbox(text) {
  if(typeof text == 'undefined')
   var text = '';
  var status_box  = "<div id='status_box' style='display:none;'><div id='status_title' >Status update</div><div id='status_content'><textarea name='status' id='box_status' onkeyup='status_count()' cols='50' style='width:50%;'rows='4'>"+text+"</textarea><br/><div style='text-align:right;'><input type='button' value='Update' onclick='status_update()' /><input type='button' value='Cancel' onclick='status_distroy_box()'/></div></div><div id='status_tool'><div style='float:left;'>NO bbcode or html allowed</div><div style='float:right;' id='status_count'>140</div><div style='clear:both;'></div></div>";
 $('body').after(status_box);
 $("#status_box").css("top",(($(window).height()/2)-($("#status_box").height()/2)));
	$("#status_box").css("left",(($(window).width()/2)-($("#status_box").width()/2)));
 $("#status_box").fadeIn('slow');
 //status_count();
}
function status_distroy_box() {
 $('#status_box').fadeOut('slow').remove();
}
function status_update(u) {
 var status = $('#box_status').val();
 if(status.length > 0) {
  $.post('ajax.status.php',{action:'new',ss:status}, function (data) {
   if(data.status) {
    $('#status_content').empty();
    $('#status_tool').remove();
    $('#status_content').html(data.msg);
      window.setTimeout(function () { status_distroy_box() },1000);
   } else 
     alert(data.msg);
  },'json');
 }
} 
function status_cancel() {
 $('#status').val('');
 $('#status_buttons').fadeOut().remove();
 $('#current_holder').fadeIn();
 status_count();
}
function status_delete(id) {
 if(confirm('Are you sure you want to do this ?')) {
  $.post('ajax.status.php',{action:'delete',id:id}, function (data) {
   if(data.status) {
    $('#status_'+id).fadeOut();
   } else 
     alert(data.msg);
  },'json');
 }
}
