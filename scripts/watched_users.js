//=== messed with and fixed to work with TBDev oct 2009

$(function() {
	$("#form_watched").submit(function(){
      
  	  var user = $("input#id").val();
  	  var WhatAction = $("input#action").val();
  	  
  	  
  	if (user == "") {
        	$("#input_error").fadeIn();
        return false;
      }
	
	var watched_reason = $("#watched_reason").val();
	//var add_to_watched_users = $('input:checkbox:checked').val(); //=== for checkbox
	var add_to_watched_users = $('input:radio[name=add_to_watched_users]:checked').val();
	
	//=== disable button & fade in image thing
	$("#watched").hide();
	$("#desc_text").hide();
	$("#update").fadeIn();
	$("#watched_user_button").hide();

  	//=== submit the thanks
 	$.post("member_input.php", { action: WhatAction, id: user, watched: add_to_watched_users, watched_reason: watched_reason });
 	$("#update").fadeOut();
 	$("#watched").show();
 	$("#desc_text").show();
 	$("#watched_user_button").show();
 
  //=== prevent page refresh after submit
  return false;  
    });
  });

