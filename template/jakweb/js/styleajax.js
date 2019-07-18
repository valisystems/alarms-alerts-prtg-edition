/*===============================================*\
|| ############################################# ||
|| # JAKWEB.CH                                 # ||
|| # ----------------------------------------- # ||
|| # Copyright 2016 JAKWEB All Rights Reserved # ||
|| ############################################# ||
\*===============================================*/

$(document).ready(function(){
	/* The following code is executed once the DOM is loaded */
	
	/* This flag will prevent multiple comment submits: */
	var working = false;
	
	/* Listening for the submit event of the form: */
	$('.jak-style').submit(function(e){

 		e.preventDefault();
		if(working) return false;
		
		working = true;
		var jakform = $(this);
		var formURL = jakform.attr("action");
		var button = $(this).find('.jak-submit');
		$(this).find('.form-group').removeClass("has-error");
		$(this).find('.form-group').removeClass("has-success");
		
		$(button).html(jakWeb.jak_submitwait);
		
		// Now this is ajax
		var data = $(this).serializeArray(); // convert form to array
		data.push({name: "jakajax", value: "yes"});
		
		/* Sending the form fileds to any post request: */
		$.post(formURL, $.param(data), function(msg) {
			
			working = false;
			$(button).html(jakWeb.jak_submit);
			
			if(msg.status) {
			
				$(jakform).find('.jak-stylety').fadeIn(1000).html(msg.html).delay(3000).fadeOut();
				
				
			}
		}, 'json');

	});
	
});