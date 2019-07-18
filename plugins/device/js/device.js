$(document).ready(function(){
	// Create form
	$(".createButton").click(function(){
		$.ajax({
				type: 'GET',
				datatype:'json',
				url: '/index.php?p=device&sp=ajax&ssp=cform',
				success: function(data) {
					doModal('Add Device', data);
				},
				error:function(msg){
					alert('ERROR');
				}
		});
	});
	// Edit form
	$(".editButton").click(function(){
        var postData =  {
                        "id":$(this).data('id'),
                        "DeviceID": $(this).data('deviceid'),
                        "BaseName":$(this).data('basename')
                    };
		$.ajax({
				type: 'POST',
				datatype:'json',
				url: '/index.php?p=device&sp=ajax&ssp=eform',
				data: postData,
				success: function(data) {
					doModal('Edit - '+ $(this).data('deviceid'), data);
				},
				error:function(msg){
					alert('ERROR');
				}
		});
	});
	// Delete button
	$(".deleteButton").click(function(){
		var data =  {
						"id":$(this).data('id'),
						"DeviceID": $(this).data('deviceid'),
						"BaseName":$(this).data('basename')
					};
		if(confirm('Are you sure you want to delete this row?'))
		{
			$.ajax({
				type: 'POST',
				datatype:'json',
				url: '/index.php?p=device&sp=ajax&ssp=del',
				data: JSON.stringify(data),
				success: function(msg) {
					//console.log(data);
				   alert(msg);
				},
				error:function(msg){
					alert(msg);
				}
			});
		$(this).parent().parent().animate({background: "#fbc7c7"}, "fast").animate({opacity:"hide"}, "slow");
		}
		return false;
	});


	// Single device
    $('.cancel-single').bootstrapSwitch({
        size:"small",
        onSwitchChange: function(e, state) {
            e.preventDefault();
            var basename = $(this).data('basename');
            var device_id = $(this).data('device');
            var alarm ;
            if (state){
                alarm = 'Alarm';
            }
            else{
                alarm = 'Normal';
            }

            $.ajax({
                type: 'POST',
                datatype:'json',
                url: '/index.php?p=device&sp=ajax&ssp=eventChange',
                data: JSON.stringify({
                    'action':'single_alarm',
                    'DeviceID':device_id,
                    'BaseName': basename,
                    'EventType':alarm
                }),
                success: function(data) {
                    alert('Event changed successfull.');
                    $('#'+basename+'-'+device_id).html(alarm); 
                },
                error:function(msg){
                    alert('ERROR');
                }
            });   
        }
    });
	
	if (window.location.hash=="#autoreload") {
        reloading=setTimeout("window.location.reload();", 15000);
        document.getElementById("reloadCB").checked=true;
    }
    var reloadBth = $('#reloadCB').bootstrapSwitch({
        onSwitchChange: function(e, state) {
            
            if (state) {
                window.location.replace("#autoreload");
                reloading=setTimeout("window.location.reload();", 15000);
            } else {
                window.location.replace("");
                clearTimeout(reloading);
            }
        }
    });

});
var reloading;


// bootstrap model
function doModal(heading, formContent) {
    html =  '<div id="form-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="confirm-modal" aria-hidden="true">';
    html += '<div class="modal-dialog">';
    html += '<div class="modal-content">';
    html += '<div class="modal-header">';
    html += '<a class="close" data-dismiss="modal">×</a>';
    html += '<h4>'+heading+'</h4>'
    html += '</div>';
    html += '<div class="modal-body">';
    html += formContent;
    html += '</div>';
    html += '<div class="modal-footer">';
    html += '<span class="btn btn-primary" data-dismiss="modal">Close</span>';
    html += '</div>';  // content
    html += '</div>';  // dialog
    html += '</div>';  // footer
    html += '</div>';  // modalWindow
    $('body').append(html);
    $("#form-modal").modal();
    $("#form-modal").modal('show');
	formsubmit();

    $('#form-modal').on('hidden.bs.modal', function (e) {
        $(this).remove();
        location.reload();
    });

}

function formsubmit()
{
	$("#formoid").submit(function(event) {

      /* stop form from submitting normally */
      event.preventDefault();

      /* get some values from elements on the page: */
      var $form = $( this ),
        url = $form.attr( 'action' );
		var data =  {
						"BaseName": $('#BaseName').val(), "DeviceType": $('#DeviceType').val(),
						"AntennaInt": $('#AntennaInt').val(), "EventType": $('#EventType').val(),
						"DeviceID": $('#DeviceID').val(), "PendantRxLevel": $('#PendantRxLevel').val(),
						"LowBattery": $('#LowBattery').val(), "TimeStamp": $('#TimeStamp').val(),
					};

		//var tmp = JSON.stringify($('.dd').nestable('serialize'));
		  // tmp value: [{"id":21,"children":[{"id":196},{"id":195},{"id":49},{"id":194}]},{"id":29,"children":[{"id":184},{"id":152}]},...]
		  $.ajax({
			type: 'POST',
			datatype:'json',
			url: url,
			data: JSON.stringify(data),
			success: function(msg) {
				//console.log(data);
			   alert(msg);
			   $('#form-modal').remove();
			   location.reload();
			},
			error:function(msg){
				alert('ERROR');
			}
		  });

    });

}

