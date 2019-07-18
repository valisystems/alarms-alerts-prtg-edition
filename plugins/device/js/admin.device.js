$(document).ready(function(){
	// Create form
	$(".configButton").click(function(){
		var postData =  {
                        "id":$(this).data('id'),
                        "DeviceID": $(this).data('deviceid'),
                        "BaseName":$(this).data('basename'),
                        "type":$(this).data('devicetype')
                    };
		$.ajax({
				type: 'POST',
				datatype:'json',
				data: postData,
				url: '/admin/index.php?p=device&sp=ajax&ssp=cform',
				success: function(data) {
					doModal('Device Configuration', data);
				},
				error:function(msg){
					alert('ERROR');
				}
		});

	});

});


// bootstrap model
function doModal(heading, formContent) {
    html =  '<div id="form-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="confirm-modal" aria-hidden="true">';
    html += '<div class="modal-dialog modal-lg">';
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
      	var $form = $( this );

        url = $form.attr( 'action' );
		var data = getFormData($form);
		$.ajax({
			type: 'POST',
			datatype:'json',
			url: url,
			data: JSON.stringify(data),
			success: function(msg) {
				//console.log(data);
			   	alert('Request process successfully.');
			   	$('#form-modal').remove();
			   	location.reload();
			},
			error:function(msg){
				alert('ERROR');
			}
		});

    });

}

function getFormData($form)
{
	var unindexed_arr = $form.serializeArray();
	var indexed_arr = {};

	$.map(unindexed_arr, function(n, i){
		indexed_arr[n['name']] = n['value'];
	});
	return indexed_arr;
}
