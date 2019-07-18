 window.onload = function(){

         function getVideoContent() {
             var metaI = document.createElement('meta');
              metaI.httpEquiv = "X-UA-Compatible";
              metaI.content = "IE=edge";
             //document.getElementsByTagName('head')[0].appendChild(metaI);

         var metas = document.getElementsByTagName('meta');

           var prevEL1 = metas[0];
             prevEL1 = prevEL1.previousElementSibling;
             var par = document.getElementsByTagName('head')[0] || document.documentElement;

             par.insertBefore(metaI,(par.hasChildNodes())
                 ? par.childNodes[0]
                 : null);


           return "";
       }

     //getVideoContent();

     function globalEval(data) {
	      
		   data = data.replace(/^\s*|\s*$/g, "");
		     if (data) {
			 
			   var head = document.getElementsByTagName("head")[0] || document.documentElement;
			 
			    script = document.createElement("script");
			    script.type = "text/javascript";
				script.text = data;
				head.appendChild(script);
				head.removeChild(script);
			 }
	  
	       }


              var previous = [],
                  streams = [],
                  user_params = [],
                  iframes = [];

             var scripts = document.getElementsByTagName("script");
				  for (var i= 0; i<scripts.length; i++) {
			   
				  if (scripts[i].type =="devline-server/ip-cameras") {
					   globalEval(scripts[i].innerHTML);

                         var prev = scripts[i];
                          previous.push(prev.previousElementSibling);
                          streams.push(stream_params);

					 }
			   
				  }


                   for (var i=0; i<streams.length; i++) {


                        var str_input = streams[i];
                        var re_ui = /([^=,\.]*)=("[^"]*"|[^,"]*)/g;
                        var match;

                        var user_p = {

                            ip  : null,
                            port : null,
                            camera : null,
                            fps : null,
                            resolution : null,
                            quality : null,
                            user: null,
                            passwd : null,
                            ptz : "",
                            sound : "",
                            logo : "",
							id : i

                        };


                        while (( match = re_ui.exec(str_input)) !== null)
                        {
                            user_p[match[1]] = match[2];
                        }

                        // геттеры и сеттеры возможно для пресетов

                        Object.defineProperties(user_p, {
                            "getRes": { get: function () { return this.resolution;  } },
                            "setRes": { set: function (val) { this.resolution = val;  } }

                        });

                         Object.preventExtensions(user_p);
                         user_params.push(user_p);


                         var ifrm = document.createElement("IFRAME");
                         ifrm.setAttribute("src", "http://"+user_params[i].ip+":"+user_params[i].port+"/html5/player.html");
                         ifrm.setAttribute("id", "iframe"+i);
                         ifrm.setAttribute("webkitallowfullscreen", "true");
                         ifrm.setAttribute("mozallowfullscreen", "true");
                         ifrm.setAttribute("allowfullscreen", "true");
                         ifrm.setAttribute("frameborder", "0");

                         ifrm.style.width = parseInt(user_params[i].resolution.split("x")[0])+0+"px";
                         ifrm.style.height = parseInt(user_params[i].resolution.split("x")[1])+0+"px";
                         ifrm.style.scrolling ="no";

                          iframes.push(ifrm);
                            previous[i].parentNode.appendChild(iframes[i]);

                        }



					
			   function send() {

                   var windows = [];

                   for (var i=0;i<previous.length;i++){

                       windows.push(document.getElementById("iframe"+i).contentWindow);

                       windows[i].postMessage(
                        streams[i],
                        "http://"+user_params[i].ip+":"+user_params[i].port // target domain
                       );

                     }

					return false;
              }
     
             var tID1 = setTimeout(send,2000);
             //clearTimeout(tID1);


   
             //dynamic load js+css
          function loadjscssfile(filename, filetype){
             if (filetype=="js"){ //if filename is a external JavaScript file
              var fileref=document.createElement('script')
              fileref.setAttribute("type","text/javascript")
              fileref.setAttribute("src", filename)
             }
             else if (filetype=="css"){ //if filename is an external CSS file
              var fileref=document.createElement("link")
              fileref.setAttribute("rel", "stylesheet")
              fileref.setAttribute("type", "text/css")
              fileref.setAttribute("href", filename)
             }
             if (typeof fileref!="undefined")
              document.getElementsByTagName("head")[0].appendChild(fileref)
            }

		//loadjscssfile("myscript.js", "js") 		
		//loadjscssfile("http://localhost/html2/css/devline.css", "css") 


 };