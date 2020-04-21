// set up the emoticon stuff
		$(document).ready(function()	{

			// hide custom and staff
			$("#box_1").hide();
			$("#box_2").hide();
			$("#box_3").hide();
			$("#box_4").hide();
			
			$("#box_1").fadeIn("slow");

				// show hide for all
				$("a#smilies").click(function(){
				$("#box_1").show("slow");
				$("#box_2").hide();
				$("#box_3").hide();
				$("#box_4").hide();
				});

				$("a#custom").click(function(){
				$("#box_1").hide();
				$("#box_2").show("slow");
				$("#box_3").hide();
				$("#box_4").hide();
				});

				$("a#staff").click(function(){
				$("#box_1").hide();
				$("#box_2").hide();
				$("#box_3").show("slow");
				$("#box_4").hide();
				});

				$("a#tags").click(function(){
				$("#box_1").hide();
				$("#box_2").hide();
				$("#box_3").hide();
				$("#box_4").show("slow");
				})

	// Add editor
	$("#markItUp").markItUp(mySettings);

	// add smilies	
	$(".emoticons").click(function() {
 		$.markItUp( { 	openWith:$(this).attr("title")}
				);
 		return false;
	});
	
	// add more options
	$("#tool_open").click(function(){
	$("#tools").slideToggle("slow", function() {
	});
	$("#tool_open").hide();
	$("#tool_close").show();
	});
	
	$("#tool_close").click(function(){
	$("#tools").slideToggle("slow", function() {
	});
	
	$("#tool_close").hide();
	$("#tool_open").show();

	});

	// add attachments
	$("#more").click(function(){
	$("#attach_more").slideToggle("slow", function() {
	});
	});
	});