//=== messed with and fixed to work with TBDev oct 2010ish

$(function() {
	$("#form").submit(function(){

  	  var id = $("input#id").val();
  	  var WhatAction = $("input#action2").val();      

  	  //=== flush torrents
  	 if (WhatAction == "flush_torrents") {
  	  
  	if (id == "") {
        	$("#flush_error").fadeIn();
        	$("#flush_button").hide();
        return false;
      }


	//=== disable button & fade in image thing
	$("#flush").fadeOut();
	$("#flush_button").hide();

  	//=== submit the thanks
 	$.post("member_input.php", { action: "flush_torrents", id: id });
 	$("#success").show();
 	
 	} //=== end flush
 
  //=== prevent page refresh after submit
  return false;
    });
  });
 