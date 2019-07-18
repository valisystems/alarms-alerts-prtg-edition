/*===============================================*\
|| ############################################# ||
|| # JAKWEB.CH                                 # ||
|| # ----------------------------------------- # ||
|| # Copyright 2016 JAKWEB All Rights Reserved # ||
|| ############################################# ||
\*===============================================*/

(function($) { 

$.fn.saveClicks = function() { 
    $(this).bind('mousedown.heatmap', function(evt) {
    
    	var request;
    	
    	if(typeof request !== 'undefined')
    	        request.abort();
    	
    	var request = $.ajax({
    	  url: jakWeb.jak_url + 'include/ajax/heatmap.php',
    	  type: "POST",
    	  data: "id=1&x="+evt.pageX+"&y="+evt.pageY+"&l="+jakWeb.jak_heatmap,
    	  dataType: "html",
    	  timeout: 3000,
    	  cache: false
    	});
    	 
    }); 
}; 

$.fn.stopSaveClicks = function() { 
     $(this).unbind('mousedown.heatmap'); 
}; 

$.displayClicks = function(settings) {
    
    var request;
    	
    if(typeof request !== 'undefined')
   		request.abort();
    	        
   	$('<div id="heatmap-overlay"></div>').appendTo('body');
   	$('<div id="heatmap-loading"></div>').appendTo('body');
    
    var request = $.ajax({
      url: jakWeb.jak_url + 'include/ajax/heatmap.php',
      type: "GET",
      data: "id=1&l="+jakWeb.jak_heatmap,
      dataType: "html",
      timeout: 3000,
      cache: false
    });
    	
    request.done(function(html) {
    	$(html).appendTo('body');     
    	$('#heatmap-loading').remove();
    });
    
}; 
 
$.removeClicks = function() { 
    $('#heatmap-overlay').remove();
    $('#heatmap-container').remove();
}; 
         
})(jQuery); 