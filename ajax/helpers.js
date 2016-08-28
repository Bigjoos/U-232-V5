$(function() {

	function do_update_sidebar()
		{
			
			$('.lforums,.ltorrents').fadeOut(1000,function(){
				$('.lforums,.ltorrents').empty().html("<div style='margin:0 auto;text-align:center;'><img src='http://i.imgur.com/LHLpA6r.gif'/></div>").fadeIn(1000,function(){
				$.ajax({
					type: 'post',
					url: '/ajax/auto_loaders.php',
					data: 'load=torrents',
					success: function(data) 
					{
						$('.ltorrents').fadeOut(1500,function(){
								$('.ltorrents').html(data).fadeIn(1500);});
									
					}
				});	
				
				$.ajax({type: 'post',url: '/ajax/auto_loaders.php',data: 'load=forums',success: function(datas) {$('.lforums').fadeOut(1500,function(){$('.lforums').html(datas).fadeIn(1500);});}});
			 
			});
		});

		}
		
setInterval(function() {
				do_update_sidebar();
}, 300000);
do_update_sidebar();

var hgt = $(window).height();
	$('#flyer').css('height',hgt-130+'px');
	
	$('#sidebar').bind('mousewheel DOMMouseScroll', function(e) {
    var scrollTo = 0;
    e.preventDefault();
    if (e.type == 'mousewheel') {
        scrollTo = (e.originalEvent.wheelDelta * -1);
    }
    else if (e.type == 'DOMMouseScroll') {
        scrollTo = 40 * e.originalEvent.detail;
    }
    $(this).scrollTop(scrollTo + $(this).scrollTop());
    
});
 var tt = $('#clicker');
        tt.click(function() {
			
            if ($('#flyer').hasClass('visible')) {
                $('#flyer').animate({left: -292}, 400, function() {
                      $('#flyer').removeClass('visible').css('z-index', 998);
                });
            } else {
                $('#flyer').css('z-index', 1000).animate({left: 0}, 400, function() {
                      $('#flyer').addClass('visible');
                });
            }
		return false;
	});

});

$('.ajaxform').live('submit',function(e) {
			 e.preventDefault();
			 var fos = $(this);
			 var val = fos.find("input[name='search']");
			 var res = fos.find('input.results').data('result');
			 $(res).hide().html("<div style='margin:0 auto;text-align:center;'><img src='http://i.imgur.com/LHLpA6r.gif'/></div>").fadeIn(1000);
			
		     if(val.val().length <= 0){$(res).html('Search Cannot Be empty now can it.');}
			 else
			 {
				
				$.ajax({
				type: fos.attr('method'),
				url: fos.attr('action'), 
				data: fos.serialize(), 
				success: function(data) {
				
				$(res).animate({"opacity":"0"},2000,function(){
				$(res).html(data).animate({"opacity":"1"},2000);
					});
								                        
					}
				});
			 }
		   
		 
		});

	