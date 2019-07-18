$(document).ready(function(){

    // Edit form
    $(".generateUrl").click(function(){
        var urltype = $(this).data('type');
        var input_fields = [];
        $(this).parent('td').find('input').each(function(){
            input_fields[$(this).attr('name')] = $(this).val();
        });


        if(urltype == 'single_alarm')
        {
            url = 'http://'+window.location.host + '/index.php?p=device&sp=upd_event&action=single_alarm&basename='+input_fields['basename']+'&device='+input_fields['device'];
            doModal('Alert - URL', url);
        }        

        if(urltype == 'alert')
        {
            url = 'http://'+window.location.host + '/index.php?p=device&sp=alert&acc='+input_fields['acc']+'&dest='+input_fields['dest'];
            doModal('Alert - URL', url);
        }

        if( urltype == 'call')
        {
            var src = '';
            if(input_fields['src'])
            {
                src = "&src="+input_fields['src'];
            }
            url = 'http://'+window.location.host + '/index.php?p=device&sp=call&dest='+input_fields['dest']+src;
            doModal('Call - URL', url);
        }

        if( urltype == 'pbxcall')
        {
            var src = '';
            if(input_fields['src'])
            {
                src = "&src="+input_fields['src'];
            }
            url = input_fields['pbx_url'] + input_fields['pbx_uri'] + input_fields['dest'] + src;
            url += "<br/><h3>Url Encoded</h3>";
            url += input_fields['pbx_url']+ encodeURIComponent(input_fields['pbx_uri'] + input_fields['dest'] + src);
            doModal('PBX call - URL', url);
        }

        if( urltype == 'detailedCallUrl')
        {
            var src = '';
            if(input_fields['src'])
            {
                src = "&src="+input_fields['src'];
            }
            url = input_fields['pbx_url']+ "user=" + input_fields['ext'] +"&auth="+input_fields['ext']+":"+input_fields['ext_pass']+"&connect=true&dest="+input_fields['dest']+src;
            url += "<br/><h3>Url Encoded</h3>";
            url += input_fields['pbx_url']+ encodeURIComponent("user=" + input_fields['ext'] +"&auth="+input_fields['ext']+":"+input_fields['ext_pass']+"&connect=true&dest="+input_fields['dest']+src);
            doModal('PBX call - URL', url);
        }

        if(urltype =='camurl')
        {
            url = 'http://'+window.location.host + '/index.php?p=device&sp=cam';
            if(input_fields['cam_number'])
            {
                url += '&ssp='+input_fields['cam_number'];
            }
            doModal('Camera URL - URL', url);
        }
        //console.log(input_fields);
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

function copyToClipboard(element) {
    var $temp = $("<input>");
    $("body").append($temp);
    $temp.val($(element).text()).select();
    document.execCommand("copy");
    $temp.remove();
}


