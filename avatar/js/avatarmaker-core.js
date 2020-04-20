function update() {
		
		var user = $('#user').val();
		var bColor = $('#bColor').val();
		var fColor = $('#fColor').val();
		var bgColor = $('#bgColor').val();
		var smile = $('#smile').val();
		var pack = $('#pack').val();
		var font = $('#font').val();
		var showuser = $('#suser').is(':checked') == 1 ? 1 : 0;
		var line = new Array(3);
		var drp = new Array(3);
		for(i=1;i<=3;i++)
		{
			 line[i] = $("#line"+i).val();
			  drp[i] = $("#drp"+i).val();
		}	
		$(".loader").fadeIn();
		$.post('save.php',{user:user,bColor:bColor,bgColor:bgColor,fColor:fColor,smile:smile,pack:pack,font:font,line1:line[1],line2:line[2],line3:line[3],drp1:drp[1],drp2:drp[2],drp3:drp[3],showuser:showuser}, function (r) {
			if(r == 1) {
				$("#preview").attr('src','avatar.php?user='+user+'&r='+Math.random());
				get_drp(true);
				$("#preview").bind("load",function () {
					$(".loader").fadeOut();
				});
			}
		});
	}
	function get_vars() {
		var user = $('#user').val();
		$.post('save.php',{action:'load',user:user},function(r) {
			 $('#bColor').val(r.bColor);
			 $('#fColor').val(r.fontColor);
			 $('#bgColor').val(r.bgColor);
			 $('#smile').val(r.smile);	
			 $('#font').val(r.font);
			 $('#pack').val(r.pack);
		},'json');
	}
	function get_drp(firstrun){
		var user = $('#user').val();
		var foo = firstrun == true ? 1 : 0;
		var drp1 = 0+parseInt($('#drp1').val());
		var drp2 = 0+parseInt($('#drp2').val());
		var drp3 = 0+parseInt($('#drp3').val());
		$.post("drp.php",{user:user,firstrun:foo,drp1:drp1,drp2:drp2,drp3:drp3}, function (r) {
			$('#drp1').empty().append(r.op1)
			$('#drp2').empty().append(r.op2)
			$('#drp3').empty().append(r.op3)
			$('#line1').empty().val(r.line1)
			$('#line2').empty().val(r.line2)
			$('#line3').empty().val(r.line3)
			if(r.showuser == 1)
				$('#suser').attr('checked','checked');
			else 
				$('#suser').removeAttr('checked');
		}, 'json');
	}
	function change_label(id,value){
		var labels = new Array(5);
		labels[1] = 'Posts';
		labels[2] = 'Download & Upload';
		labels[3] = 'Irc idle';
		labels[4] = 'Reputation';
		labels[5] = 'Geo';
		labels[6] = 'Comments';
		labels[7] = 'Browser';
		labels[8] = 'Profile hits';
		labels[9] = 'Online';
			$('#'+id).val(labels[value]);
	}