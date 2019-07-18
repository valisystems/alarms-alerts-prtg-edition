$(document).ready(function(){

    // Edit form
    $(".flashCode").click(function(e){
        e.preventDefault();
        var camid = $(this).data("camid");
        doModal('Flash Code',  flashCodeForm());
        $("#btnFlashForm").click(function(e){
             flashFormSubmit(cam_credentials, camid, "#flash_form");
        });

    });

    $(".htmlCode").click(function(e){
        e.preventDefault();
        var camid = $(this).data("camid");
        doModal('Flash Code',  htmlCodeForm());
        $("#btnHtmlForm").click(function(e){
             htmlFormSubmit(cam_credentials, camid, "#html_form");
        });
    });

});


function flashFormSubmit(credentials, camid, formid)
{
    $(formid).submit(function(event) {
      event.preventDefault();
      var data =  {
                        "name": $('#camname').val(), "fps": $('#fps').val(),"quality": $('#quality').val(),
                        "autoplay": $('#autoplay').is(":checked") ? "true" : "false", "sound": $('#sound').is(":checked") ? "true" : "false"
                  };
      if(data.name.length == 0) {data.name = 'name';}
      if(data.fps.length == 0) {data.fps = '8';}
      if(data.quality.length == 0) {data.quality = '60';}

      var string_code = flashCode(credentials.server.replace('http://', ''), credentials.port.replace(':', ''), credentials.username, credentials.password, camid, data);
      $("#code").text(string_code);
   });
}

function flashCodeForm(){
    var flashForm = "<form class='form-horizontal' id='flash_form' >";
    flashForm += "<div class='form-group'>"+
                    "<label class='col-md-2 control-label'>Name</label>"+
                    "<div class='col-md-4'>"+
                        "<input class='form-control input-md' type='text' name='camname' id='camname' />"+
                    "</div>"+
                 "</div>";
    flashForm += "<div class='form-group'>"+
                    "<label class='col-md-2 control-label'>FPS</label>"+
                    "<div class='col-md-4'>"+
                        "<input class='form-control input-md' type='text' name='fps' id='fps' />"+
                    "</div>"+
                 "</div>";
    flashForm += "<div class='form-group'>"+
                    "<label class='col-md-2 control-label'>Quality</label>"+
                    "<div class='col-md-4'>"+
                        "<input class='form-control input-md' type='text' name='quality' id='quality' />"+
                    "</div>"+
                 "</div>";
    flashForm += "<div class='form-group'>"+
                    "<div class='col-md-1 col-md-offset-2'>"+
                        "<div class='checkbox'>"+
                            "<label><input type='checkbox' name='autoplay' id='autoplay' /> Autoplay </label>"+
                        "</div>"+
                    "</div>"+
                 "</div>";
    flashForm += "<div class='form-group'>"+
                    "<div class='col-md-1 col-md-offset-2'>"+
                        "<div class='checkbox'>"+
                            "<label><input type='checkbox' name='sound' id='sound' /> Sound </label>"+
                        "</div>"+
                    "</div>"+
                 "</div>";
    flashForm += "<div class='form-group'>"+
                    "<div class='col-md-1 col-md-offset-2'>"+
                            "<button id='btnFlashForm' type='submit' class='btn btn-default'>Get Code</button>"+
                    "</div>"+
                 "</div>";
    flashForm += "</form>";
    flashForm += "<textarea id='code' name='code' style='width: 625px; height: 250px;' ></textarea>";
    return flashForm;
}

function flashCode(server, port, username, password, camid, options){

    // Flash code
    var flash_code = '<script type="text/javascript" src="http://www.devline.ru/js/swfobject.js"></script>';
    flash_code += '<script type="text/javascript">';
    flash_code += 'var flashvars={ip:"'+server+'",port:' + port +',login:"'+username+'",pass:"'+password+'",uriCamera:"/cameras/'+camid+'",quality:'+options.quality+',fps:'+options.fps+',sound:'+options.sound+',name:"'+options.name+'",playOnStart:'+options.autoplay+',ptz:false,logo:true,lang:"en"};';
    flash_code += 'var params={menu:"false",scale:"noScale",allowFullscreen:"true",allowScriptAccess:"always",bgcolor:"#ffffff"};';
    flash_code += 'var attributes={id:"devline_771"};';
    flash_code += 'swfobject.embedSWF("http://www.devline.ru/miniflash7.swf","devline_771","640","480","11.2.0","http://www.devline.ru/expressInstall.swf",flashvars,params,attributes);';
    flash_code += '</script>';
    flash_code += '<div id="devline_771"></div>';
    return flash_code;
}


// HTML code
function htmlFormSubmit(credentials, camid, formid)
{
    $(formid).submit(function(event) {
      event.preventDefault();
      var data =  {
                        "quality": $('#quality').val(),
                        "autoplay": $('#autoplay').is(":checked") ? "true" : "false",
                        "sound": $('#sound').is(":checked") ? "true" : "false"
                  };
      if(data.quality.length == 0) {data.quality = '60';}
      //htmlcode function
      var string_code = htmlCode(credentials.server.replace('http://', ''), credentials.port.replace(':', ''), credentials.username, credentials.password, camid, data);
      $("#code").text(string_code);
   });
}

function htmlCodeForm(){

    var htmlForm = "<form class='form-horizontal' id='html_form' >";

    htmlForm += "<div class='form-group'>"+
                    "<label class='col-md-2 control-label'>Quality</label>"+
                    "<div class='col-md-4'>"+
                        "<input class='form-control input-md' type='text' name='quality' id='quality' />"+
                    "</div>"+
                 "</div>";
    htmlForm += "<div class='form-group'>"+
                    "<div class='col-md-1 col-md-offset-2'>"+
                        "<div class='checkbox'>"+
                            "<label><input type='checkbox' name='autoplay' id='autoplay' /> Autoplay </label>"+
                        "</div>"+
                    "</div>"+
                 "</div>";
    htmlForm += "<div class='form-group'>"+
                    "<div class='col-md-1 col-md-offset-2'>"+
                            "<button id='btnHtmlForm' type='submit' class='btn btn-default'>Get Code</button>"+
                    "</div>"+
                 "</div>";
    htmlForm += "</form>";
    htmlForm += "<textarea id='code' name='code' style='width: 625px; height: 250px;' ></textarea>";
    return htmlForm;
}

function htmlCode(server, port, username, password, camid, options)
{
    // Html code
    var html_code = '<script type="text/javascript" src="http://' + server + ':' + port +'/html5/js/generator.js"></script>';
    html_code += '<script type="devline-server/ip-cameras">';

    html_code += 'var stream_params = "ip=' + server + ',port='+port+',camera='+camid+',quality='+options.quality+',autoplay='+options.autoplay+',resolution=640x480,user='+username+',passwd='+password+',id='+camid+'"';
    html_code += '</script>';

    return html_code;
}

// bootstrap model
function doModal(heading, formContent) {
    html =  '<div id="edit-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="confirm-modal" aria-hidden="true">';
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
    $("#edit-modal").modal();
    $("#edit-modal").modal('show');

    $('#edit-modal').on('hidden.bs.modal', function (e) {
        $(this).remove();
    });
}

