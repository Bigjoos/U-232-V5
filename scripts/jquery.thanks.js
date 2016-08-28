//made by putyn
function show_thanks(tid) {
	var holder = $('#thanks_holder');
		holder.html('Loading ...').fadeIn('slow');
		$.post('thanks.php',{action:'list',ajax:1,'torrentid':tid}, function (r) {
		
		if(r.status) {
			if(!r.hadTh)
				r.list += "<br/><input type=\"button\" value=\"Say thanks\" onclick=\"say_thanks("+tid+")\" id=\"thanks_button\" />";
			holder.empty().html(r.list);
		}
	},'json');
}

function say_thanks(tid) {
	$('#thanks_button').attr('value','Please wait...').attr('disabled','disabled');
	var holder = $('#thanks_holder');
	$.post('thanks.php',{action:'add',ajax:1,'torrentid':tid}, function(r) 
	
	{
		location.reload(true);
		if(r.status)
		
			holder.empty().html(r.list);
			
		else 
			alert(r.err);
	}, 'json');	
	
}