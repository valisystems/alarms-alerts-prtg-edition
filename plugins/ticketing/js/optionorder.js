/*===============================================*\
|| ############################################# ||
|| # JAKWEB.CH                                 # ||
|| # ----------------------------------------- # ||
|| # Copyright 2016 JAKWEB All Rights Reserved # ||
|| ############################################# ||
\*===============================================*/

$(document).ready( function () {

	$(".jak_cat_move").sortable({
		axis		: 'y',				// Only vertical movements allowed
		containment	: 'document',			// Constrained by the window
		placeholder: "ui-state-highlight",
		update		: function(){		// The function is called after the todos are rearranged
		
			// The toArray method returns an array with the ids of the todos
			var arr = $(".jak_cat_move").sortable('toArray');
			
			
			// Striping the todo- prefix of the ids:
			
			arr = $.map(arr,function(val,key){
				return val.replace('opt-','');
			});
			
			// Saving with AJAX
			$.post('../plugins/ticketing/optionorder.php',{id:1,positions:arr},
				function(data) {
				     if (data == 1) {
				     	$(".jakcat").animate({backgroundColor: '#c9ffc9'}, 100).animate({backgroundColor: '#F9F9F9'}, 1000);
				     } else {
				     	$(".jakcat").animate({backgroundColor: '#ffc9c9'}, 100).animate({backgroundColor: '#F9F9F9'}, 1000);
				     }
			});
		},
		
		/* Opera fix: */
		stop: function(e,ui) {
			ui.item.css({'top':'0','left':'0'});
		}
	});
});