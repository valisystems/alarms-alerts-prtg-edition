$(document).ready(function(){
	
	// Edit form
	$(".url_button").click(function(e){
		e.preventDefault();
		var type = $(this).data("type");
		if($(this).data("type2"))
		{
			doModal('URL', generateUrl(formValues(), type, $(this).data("type2")));
		}
		else
		{
			doModal('URL', generateUrl(formValues(), type, $(this).data("type2")));
		}
		
	});
	
});

function generateUrl(data, func, ext_setting)
{
	var url;
	switch(func)
	{
		case 'make_call':
			url = data.address + "/ivr/PbxAPI.aspx?func=make_call&from=" + data.from + "&to=" + data.to + "&pin=" + data.pin;
		break;
		case 'upd_ext':
			switch(ext_setting)
			{
				case 'enable_extension':
					url = data.address + "/ivr/PbxAPI.aspx?func=upd_ext&extnum=" + data.from + "&pwd=" + data.pin + "&disable=0";
				break;
				
				case 'disable_extension':
					url = data.address + "/ivr/PbxAPI.aspx?func=upd_ext&extnum=" + data.from + "&pwd=" + data.pin + "&disable=1";
				break;
				
				case 'enable_external_calls':
					url = data.address + "/ivr/PbxAPI.aspx?func=upd_ext&extnum=" + data.from + "&pwd=" + data.pin + "&disable_external=0";
				break;
				
				case 'disable_external_calls':
					url = data.address + "/ivr/PbxAPI.aspx?func=upd_ext&extnum=" + data.from + "&pwd=" + data.pin + "&disable_external=1";
				break;
				
				case 'enable_recording':
					url = data.address + "/ivr/PbxAPI.aspx?func=upd_ext&extnum=" + data.from + "&pwd=" + data.pin + "&record_calls=1";
				break;
				
				case 'disable_recording':
					url = data.address + "/ivr/PbxAPI.aspx?func=upd_ext&extnum=" + data.from + "&pwd=" + data.pin + "&record_calls=0";
				break;
				
			}
			
		break;
	}
	//window.open(url);
	return url;
}

function formValues()
{
  var fields = {};
  fields['address'] = $("input[name='address']").val();
  fields['from'] = $("input[name='from']").val();
  fields['pin'] = $("input[name='pin']").val();
  fields['to'] = $("input[name='to']").val();
  fields['pbxpass'] = $("input[name='pbxpass']").val();
  return fields;
}


// bootstrap model
function doModal(heading, formContent) {
    html =  '<div id="edit-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="confirm-modal" aria-hidden="true">';
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
    $("#edit-modal").modal();
    $("#edit-modal").modal('show');

    $('#edit-modal').on('hidden.bs.modal', function (e) {
        $(this).remove();
    });

}

