

/*
		CREATED BY STILL-A-PUNK 
		ONLY FOR THE USE OF U-232 SOURCE CODE USERS

		PLEASE NOTE THAT YOU DO NOT HAVE TO PAY FOR THIS CODE
		IT IS AND WILL ALWAYS BE FREE
*/
		var options = {
							'what'     :   'res',                                                            // your result display element
							'script'   :   '/ajax.suggest.php',                                                  // your php script
							'delay'    :   '1500',                                                               // wait for 1.5 seconds before searching 
							'loader'   :   'http://u-232.servebeer.com/pic/pwait.gif',                                     // the loading gif used
							'error'    :   'Nothing Found. Sorry!',                                              // error msg if nothing found
							
							additional : {		
										       'color'  :  'green',                                             // color of the links
												limit   :   10,                                                   // limit suggested torrents
												order   :   0                                                    // order by what?
							             }
		              };
					  
					  
// ---------------------------------------------- DONOT EDIT BELOW THIS LINE-------------------------------------------------------------------------------					  
$(document).ready(function(){
$.fn.search = function(data){
var ele = $(this);var timer = 0; 
$(this).bind('keyup input paste',function(){if(!(ele.val().length)){return false;}
$('.'+data.what).html('<img src="'+data.loader+'">').show();
clearTimeout (timer);timer = setTimeout(function()
{$.ajax({url: data.script,data: ele.serialize()+'&'+$.param(data.additional),
                type: 'POST',success: function(out) {
				$('.'+data.what).slideUp(500,function(){
						if(out){$('.'+data.what).html(out);}else{$('.'+data.what).html(data.error);}
						$('.'+data.what).slideDown(1000);
});}})},data.delay);});}});
