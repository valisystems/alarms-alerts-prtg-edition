/*===============================================*\
|| ############################################# ||
|| # JAKWEB.CH                                 # ||
|| # ----------------------------------------- # ||
|| # Copyright 2016 JAKWEB All Rights Reserved # ||
|| ############################################# ||
\*===============================================*/

window.tinymce.dom.Event.domLoaded = true;

 tinymce.init({
     selector: "textarea.userpost",
     theme: "modern",
     width: "100%",
     language: jakWeb.jak_lang,
     plugins: [
          "autolink lists emoticons paste clientcode"
    ],
    content_css: "../css/stylesheet.css, ../css/editorcustom.css",
    toolbar: "undo redo | bold italic | bullist numlist clientcode | emoticons",
    menubar: false,
    statusbar: false,
    image_advtab: true,
    convert_urls: false,
    relative_urls : false,
    remove_script_host : true,
    entity_encoding : "raw",
    document_base_url : "/",
    valid_elements: "*[*]"
  });