$(document).ready(function(){

	// Edit form
	$(".getVideo").click(function(){
        var postData =  {
                        "video_url":$(this).data('video'),
                        "size":"903x455"
                    };
		$.ajax({
				type: 'POST',
				datatype:'json',
				url: '/index.php?p=device&sp=cam',
				data: postData,
				success: function(data) {
					doModal('Video', data);
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

    $('#form-modal').on('hidden.bs.modal', function (e) {
        $(this).remove();
    });

}

function videoRequest()
{
	$.ajax({
				type: 'GET',
				url: camHost,
				headers:{
						'Authorization':"Basic " + auth ,
						"Accept" : "multipart/x-mixed-replace,image/*"
				},
				success: function(data) {
					doModal('Video - '+ $(this).data('name'), data);
				},
				error:function(msg){
					alert(msg);
				}
		});
}
