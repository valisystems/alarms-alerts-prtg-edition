var purchased = new Array();
var totalprice = 0;
var displayprice = 0;
var getOption = 0;
var getOption2 = 0;
var old_shipping_coast = 0;
var old_payment_coast = 0;
var old_option_price = 0;
var old_option_price1 = 0;
var old_option_price2 = 0;

$(document).ready(function() {

if (jakWeb.jak_msg_shop3 == "loadcart") {

	$.ajax({
	type: "POST",
	url: jakWeb.jak_url + 'plugins/ecommerce/ajax/loadcart.php',
	data: "id=1",
	dataType: 'json',
		beforeSend: function(x){$('#basket-loader').css('visibility','visible');}, 
		success: function(data){
			
			$('#basket-loader').css('visibility','hidden');
			
			$.each(data, function(i,msg){
			
			if(parseInt(msg.status) != 1) {
			
				return false;
			
			} else {
			
				var check=false;
				var cnt = false;
				
				for(var i=0; i<purchased.length;i++) {
					
					if(purchased[i].id == msg.id) {
						
						check = true;
						cnt = purchased[i].cnt;
						
						break;
					}
				}
				
				if(!cnt)
				
					$('#item-list').append(msg.txt);
					
				if(!check) {
				
					purchased.push({id:msg.id,cnt:1,price:msg.price});
					
					$('#'+msg.id+'_count').html("1");
					
				} else {
					
					purchased[i].cnt++;
					
					$('#'+msg.id+'_count').html(purchased[i].cnt);
					
				}
				
				// Drag Items to trash
				$(".product-inbasket").draggable({
					
					containment: 'document',
					opacity: 0.6,
					revert: 'invalid',
					helper: 'clone',
					zIndex: 1002
					
				});
				
				totalprice += parseFloat(msg.price);
				
				update_total();
	
				}
			});
		}
	});
	
	} else {
		totalprice = parseFloat($("#total-amount").html());
	}

	$('.product-info').bind("click", function() {
	
	        var idp = $(this).data('id');
	        var titlep = $(this).text();
	        
	        $.ajax({ 
	            url: jakWeb.jak_url + 'plugins/ecommerce/ajax/tips.php',
	            type: 'POST', // POST or GET
	            data: "id="+idp, // Data to pass along with your request
	            dataType: 'json',
	            success: function(data){
	          		
	          		$('#JAKModalLabel').html(data.title);
	          		$('#JAKModal').on('show.bs.modal', function () {
	          		  	$('#JAKModal .modal-body').html(data.content);
	          		});
	          		$('#JAKModal').on('hidden.bs.modal', function() {
	          			$('#JAKModal .modal-body').html("");
	          		});
	          		$('#JAKModal').modal({show:true});
	          		
	            }
	         });
	        return false;
	    });
	
	// Drop stuff into trash
	$("#trashcontainer").droppable({
	
		drop:function(e, ui) {
			
			var param = $(ui.draggable).attr('id');
			param = param.replace("pib_", "");
			itemremove(param);
		}
	
	});
	
	// Drag items to shopping cart
	$(".shop-product").draggable({
	
	appendTo: "body",
	opacity: 0.6,
	helper: 'clone',
	zIndex: 1002
		
	});

	$("#shopping-cart").droppable({
		
		hoverClass: "hover",
		activeClass: "hover",
		tolerance: 'pointer',
		drop:function(e, ui) {
			
			var param = $(ui.draggable).attr('id');
			param = param.replace("p_", "");
			addlist(param);
		}
	
	});
	
	$("a#trash").click(function(e) {
		e.preventDefault();
		emptyCart();	
	});
	
	$("#show-shipping").click(function() {
		
		$("#shipping-form").toggle();
	
	});
	
	$('#shipping-option').change(function() {
		
	  	var shipping_coast = $(this).val().split(':#:');
	  	
	  	$('#show-handling, #show-delivery').fadeIn();
	  	
	  	$('#shipping-handling').html((Math.round(shipping_coast[0]*100)/100).toFixed(2));
	  	$("#shipping-currency").show();
	  	
	  	$('#shipping-time').html(shipping_coast[1]);
	  	
	  	$('#shipping-remove').remove();
	  	
	  	if (old_shipping_coast) totalprice -= old_shipping_coast;
	
	  	totalprice += parseFloat(shipping_coast[0]);
	  	
	  	update_total();
	  	
	  	old_shipping_coast = shipping_coast[0];
	});
	
	$('input[name=payment_option]').change(function() {
		
	  	var payment_coast = $(this).val().split(':#:');
	  	
	  	if (old_payment_coast) totalprice -= old_payment_coast;
	  	
	  	var new_payment_coast = ((totalprice / 100) * payment_coast[0]).toFixed(2);
	
	  	totalprice += parseFloat(new_payment_coast);
	  	
	  	update_total();
	  	
	  	old_payment_coast = new_payment_coast;
	});
	
	$('#country-tax').change(function(){
	     var country_id = $(this).val();
	     
	     if (jakWeb.jak_country == country_id) {
	     
	     	$("#show-tax").fadeIn();
	     } else {
	     	
	     	$("#show-tax").fadeOut();
	     
	     }
	});
	
	$('.product-option').change(function() {
	
		var poption_price = $(this).val().split('::');
		var param = $(this).attr('id');
		var param = param.replace("po_", "");
		var old_option_price = $("#pop_"+param).val();
		var product_price = $(".pprice_"+param).text();
		
		changeProductOption(poption_price, param, product_price, old_option_price, '');
	  	
	});
	
	$('.product-option1').change(function() {
	
		var poption_price = $(this).val().split('::');
		var param = $(this).attr('id');
		var param = param.replace("po1_", "");
		var old_option_price = $("#pop1_"+param).val();
		var product_price = $(".pprice_"+param).text();
		
		changeProductOption(poption_price, param, product_price, old_option_price, 1);
	  	
	});
	
	$('.product-option2').change(function() {
		
	  	var poption_price = $(this).val().split('::');
	  	var param = $(this).attr('id');
	  	var param = param.replace("po2_", "");
	  	var old_option_price = $("#pop2_"+param).val();
	  	var product_price = $(".pprice_"+param).text();
	  	
	  	changeProductOption(poption_price, param, product_price, old_option_price, 2);
	  	
	});
	
	//on click event
	$("#jak_checkC").click(function(e){
		e.preventDefault();
		jakCheckShopCoupon();
	});
	
});

function changeProductOption(value, id, currentprice, oldprice, selectid)
{
	
	currentprice = parseFloat(currentprice);
	
	if (oldprice) currentprice -= oldprice;
	
	if (value[1]) { 
		
		currentprice += parseFloat(value[1]);
		$("#pop"+selectid+"_"+id).val(parseFloat(value[1]));
		
	} else {
		$("#pop"+selectid+"_"+id).val("");
	}
	
	currentprice = currentprice.toFixed(2);
	
	$(".pprice_"+id).html(currentprice);

}

function addlist(param)
{		

	getOption = $("#po_"+param).val();
	getOption1 = $("#po1_"+param).val();
	getOption2 = $("#po2_"+param).val();
	
	sdata = "id="+param+"&popt="+getOption+"&popt1="+getOption1+"&popt2="+getOption2;
	
	$.ajax({
	type: "POST",
	url: jakWeb.jak_url + 'plugins/ecommerce/ajax/addtocart.php',
	data: sdata,
	dataType: 'json',
	beforeSend: function(x){$('#basket-loader').css('visibility','visible');},
	success: function(msg){
		
		$('#basket-loader').css('visibility','hidden');
		
		if(parseInt(msg.status)!=1)
		{
			return false;
		
		} else {
		
			var check=false;
			var cnt = false;
			
			for(var i=0; i<purchased.length;i++) {
				
				if(purchased[i].id == msg.id) {
					
					check = true;
					cnt = purchased[i].cnt;
					
					break;
				}
			}
			
			if(!cnt)
			
				$('#item-list').append(msg.txt);
				
			if(!check) {
			
				purchased.push({id:msg.id,cnt:1,price:msg.price});
				
				$('#'+msg.id+'_count').html("1");
				
			} else {
				
				purchased[i].cnt++;
				
				$('#'+msg.id+'_count').html(purchased[i].cnt);
				
			}
			
			// Drag Items to trash
			$(".product-inbasket").draggable({
				
				containment: 'document',
				opacity: 0.6,
				revert: 'invalid',
				helper: 'clone',
				zIndex: 1002
				
			});
			
			$.notify({
				icon: 'fa fa-cart-plus',
				message: msg.title
			},{
				type: 'success'
			});
			
			totalprice += parseFloat(msg.price);
			
			update_total();

		}
	
	}
	});
}

function findpos(id)
{
	for(var i=0; i<purchased.length;i++)
	{
		if(purchased[i].id == id)
			return i;
	}
	
	return false;
}

function itemremove(id)
{
	var i = findpos(id);
	cid = id.replace("pib_", "");
	
	$.ajax({
	type: "POST",
	url: jakWeb.jak_url + 'plugins/ecommerce/ajax/removefromcart.php',
	data: "id="+cid,
	dataType: 'json',
	beforeSend: function(x){$('#basket-loader').css('visibility','visible');},
	success: function(msg){
		
		$('#basket-loader').css('visibility','hidden');
		
		if(parseInt(msg.status)!=1) {
			return false;
		
		} else {
			
			totalprice -= purchased[i].price*purchased[i].cnt;
			
			purchased[i].cnt = 0;

			$('#pib_'+id).fadeOut().remove();
	
			update_total();
		}
		
	}
	});
}

function emptyCart() {

	$.ajax({
		type: "POST",
		url: jakWeb.jak_url + 'plugins/ecommerce/ajax/emptycart.php',
		data: "id=1",
		dataType: 'json',
		beforeSend: function(x){$('#basket-loader').css('visibility','visible');},
		success: function(msg){
			
			$('#basket-loader').css('visibility','hidden');
			
			if(parseInt(msg.status)!=1) {
				return false;
			
			} else {
						
				for(var i=0; i<purchased.length;i++){
					$('#pib_'+purchased[i].id).fadeOut().remove();
				}
				$('#item-list').html("");
				
				purchased = new Array();
				totalprice = 0;
				
				update_total();
			}
			
		}
		});

}

function update_total() {
	
	if(totalprice) {
		
		// Fix price if using .45
		displayprice =  (Math.round(totalprice*100)/100).toFixed(2);
	
		$("#drag-product-info").fadeOut("fast");
		$("#total-amount").html(displayprice);
		$("#total, #trash").fadeIn();
		$("#scart").hide();
		
	} else {
	
		$("#total, #scart_full, #trash").hide();
		$('#total-amount').html("");
		$('a.button').hide();
		$("#drag-product-info, #scart").fadeIn();
	}
}

function jakCheckShopCoupon(){
	
	//just for the fade effect
	var Scoupon = $('#jak_shcode').val();
	$('.statusC').hide();
	$('#cLoading').fadeIn();
	//send the post to .php
	$.ajax({
		type: "POST",
		url: jakWeb.jak_url + "plugins/ecommerce/ajax/coupon.php",
		data: "action=checkC&coupon=" + Scoupon + "&shopmsg=" + jakWeb.jak_msg_shop + "&shopmsg1=" + jakWeb.jak_msg_shop1 + "&shopmsg2=" + jakWeb.jak_msg_shop2 + "&shopmsg3=" + jakWeb.jak_msg_shop3,
		dataType: "json",
		cache: false
	}).done(function(data) {
		$('#cLoading').fadeOut();
		$('.statusC').html(data.html);
		if (data.status == 1) {
			$('#total-amount').html(data.total);
			$('#statusCT').html(data.discount);
			if (data.shipping) {
				$('#shipping-handling').html(data.shipping);
				$("#shipping-currency").hide();
			}
		}
		$('.statusC').fadeIn(500);
 	});
}