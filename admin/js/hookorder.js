/*===============================================*\
|| ############################################# ||
|| # JAKWEB.CH                                 # ||
|| # ----------------------------------------- # ||
|| # Copyright 2016 JAKWEB All Rights Reserved # ||
|| ############################################# ||
\*===============================================*/

$(document).ready( function () {

	$(".jak_hooks_move").sortable({
		axis		: 'y',				// Only vertical movements allowed
		containment	: 'document',			// Constrained by the window
		placeholder: "ui-state-highlight",
		update		: function(){		// The function is called after the todos are rearranged
		
			// The toArray method returns an array with the ids of the todos
			var arr = $(".jak_hooks_move").sortable('toArray');
			
			
			// Striping the todo- prefix of the ids:
			
			arr = $.map(arr,function(val,key){
				return val.replace('hook-','');
			});
			
			// Saving with AJAX
			$.post('ajax/hookorder.php',{id:1,positions:arr},
				function(data) {
				     if (data == 1) {
				     	$(".jakhooks").animate({backgroundColor: '#c9ffc9'}, 100).animate({backgroundColor: '#F9F9F9'}, 1000);
				     } else {
				     	$(".jakhooks").animate({backgroundColor: '#ffc9c9'}, 100).animate({backgroundColor: '#F9F9F9'}, 1000);
				     }
			});
		},
		
		/* Opera fix: */
		stop: function(e,ui) {
			ui.item.css({'top':'0','left':'0'});
		}
	});
});