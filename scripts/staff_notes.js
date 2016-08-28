//=== messed with and fixed to work with TBDev oct 2010ish

$(function() {
	$("#form").submit(function(){
      
  	  var id = $("input#id").val();
  	  var WhatAction = $("input#action").val();
  	  alert(id + WhatAction);
  	  
  	 //=== staff_notes
  	 if (WhatAction == "staff_notes") {
  	 
  	 var new_staff_note = $("#new_staff_note").val();
  	 
  	 alert(new_staff_note);
  	  
  	if (id == "") {
        	$("#input_error").fadeIn();
        return false;
      }


	//=== disable button & fade in image thing
	$("#new_staff_note").hide();
	$("#update").fadeIn();
	$("#staff_notes_button").hide();

  	//=== submit the note
 	$.post("member_input.php", { action: "staff_notes", id: id, notes: new_staff_note });
 	$("#update").fadeOut();
 	$("#new_staff_note").show();
 	$("#staff_notes_button").show();
 	
 	} //=== staff_notes
  	  
  	  
  	  
  	  
  //=== prevent page refresh after submit
  return false;
    });
  });