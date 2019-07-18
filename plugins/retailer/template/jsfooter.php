<?php if ($page == JAK_PLUGIN_VAR_RETAILER) { ?>
<script src="https://maps.googleapis.com/maps/api/js?v=3<?php if (!empty($jkv["retailermapkey"])) echo '&key='.$jkv["retailermapkey"];?>"></script>
<script type="text/javascript" src="<?php echo BASE_URL;?>plugins/retailer/js/cookies.js"></script>

<?php if ($page1 != 'r') { ?>

<script type="text/javascript">   
//<![CDATA[

	var side_bar_html = "";

    var customIcons = {
      black: {
        icon: '<?php echo BASE_URL;?>plugins/retailer/img/marker/flag_black.png'
      },
      blue: {
        icon: '<?php echo BASE_URL;?>plugins/retailer/img/marker/flag_blue.png'
      },
      gold: {
        icon: '<?php echo BASE_URL;?>plugins/retailer/img/marker/flag_gold.png'
      },
      green: {
        icon: '<?php echo BASE_URL;?>plugins/retailer/img/marker/flag_green.png'
      },
      magenta: {
        icon: '<?php echo BASE_URL;?>plugins/retailer/img/marker/flag_magenta.png'
      },
      orange: {
        icon: '<?php echo BASE_URL;?>plugins/retailer/img/marker/flag_orange.png'
      },
      pink: {
        icon: '<?php echo BASE_URL;?>plugins/retailer/img/marker/flag_pink.png'
      },
      purple: {
        icon: '<?php echo BASE_URL;?>plugins/retailer/img/marker/flag_purple.png'
      },
      red: {
        icon: '<?php echo BASE_URL;?>plugins/retailer/img/marker/flag_red.png'
      },
      turquoise: {
        icon: '<?php echo BASE_URL;?>plugins/retailer/img/marker/flag_turquoise.png'
      },
      white: {
        icon: '<?php echo BASE_URL;?>plugins/retailer/img/marker/flag_white.png'
      },
      yellow: {
        icon: '<?php echo BASE_URL;?>plugins/retailer/img/marker/flag_yellow.png'
      }
    };
    
    var gmarkers = [];
    
    // This function picks up the click and opens the corresponding info window
    function myclick(i) {
      google.maps.event.trigger(gmarkers[i], "click");
    }

    function loadmap() {
      var map = new google.maps.Map(document.getElementById("map_canvas"), {
      	scrollwheel: false,
        center: new google.maps.LatLng(<?php echo $jkv["retailerlat"];?>, <?php echo $jkv["retailerlng"];?>),
        zoom: <?php echo $jkv["retailerzoom"];?>,
        mapTypeId: google.maps.MapTypeId.<?php echo $jkv["retailermapstyle"];?>
      });
      var infoWindow = new google.maps.InfoWindow;

      // Change this depending on the name of your PHP file
      downloadUrl("<?php echo BASE_URL;?>plugins/retailer/loadmap.php?url=<?php echo JAK_PLUGIN_VAR_RETAILER;?>&eurl=<?php echo $jkv["retailerurl"];?>&catid=<?php echo $page2;?>", function(data) {
        var xml = data.responseXML;
        var markers = xml.documentElement.getElementsByTagName("marker");
        for (var i = 0; i < markers.length; i++) {
          var name = markers[i].getAttribute("name");
          var address = markers[i].getAttribute("address");
          var urla = markers[i].getAttribute("url");
          var previmg = markers[i].getAttribute("previmg");
          var type = markers[i].getAttribute("color");
          var point = new google.maps.LatLng(
              parseFloat(markers[i].getAttribute("lat")),
              parseFloat(markers[i].getAttribute("lng")));
          var html = '<div class="row"><div class="col-xs-4"><img src="' + previmg + '" alt="preview" width="80"></div><div class="col-xs-8"><b>' + name + '</b> <br>' + address + ' <br><a href="' + urla + '"><?php echo $tlre['retailer']['g8'];?></a></div></div>';
          var icon = customIcons[type] || {};
          var marker = new google.maps.Marker({
            map: map,
            position: point,
            icon: icon.icon,
            shadow: '<?php echo BASE_URL;?>plugins/retailer/img/marker/flag_shadow.png'
          });
          // save the info we need to use later for the side_bar
          gmarkers.push(marker);
          side_bar_html += '<a class="list-group-item rlinklist" href="javascript:myclick(' + (gmarkers.length-1) + ')">' + name + '<\/a>';
          bindInfoWindow(marker, map, infoWindow, html);
        }
        	document.getElementById("retailer_list").innerHTML = side_bar_html;
      });
    }

    function bindInfoWindow(marker, map, infoWindow, html) {
      google.maps.event.addListener(marker, 'click', function() {
        infoWindow.setContent(html);
        infoWindow.open(map, marker);
      });
    }

    function downloadUrl(url, callback) {
      var request = window.ActiveXObject ?
          new ActiveXObject('Microsoft.XMLHTTP') :
          new XMLHttpRequest;

      request.onreadystatechange = function() {
        if (request.readyState == 4) {
          request.onreadystatechange = doNothing;
          callback(request, request.status);
        }
      };

      request.open('GET', url, true);
      request.send(null);
    }

    function doNothing() {}

    //]]>
  
  $(document).ready(function() {
  	loadmap();
  });
  
//]]>
</script>

<?php } if ($page1 == 'r') { ?>

<script type="text/javascript">

		function showMap(skipHTML5){
		
			if ($.cookie("usrlat")) {
			
				showMapAndRoute({
				  "lat": $.cookie("usrlat"), 
				  "lng": $.cookie("usrlng")
				});
			
			} else {
		 
			if (!skipHTML5 && navigator.geolocation) {
			  // HTML5 GeoLocation
			  function getLocation(position) {
			  
			  // Write some cookies with the last position
			  $.cookie('usrlat', position.coords.latitude, { expires: 1, path: '<?php echo JAK_COOKIE_PATH;?>' });
			  $.cookie('usrlng', position.coords.longitude, { expires: 1, path: '<?php echo JAK_COOKIE_PATH;?>' });
			  	
				showMapAndRoute({
				  "lat": position.coords.latitude, 
				  "lng": position.coords.longitude
				});
			  }
			  navigator.geolocation.getCurrentPosition(getLocation, error, {enableHighAccuracy:true});
			} else {
				// HTML5 geo location failed, just show the map
			  showMapOnly();
			}
		}
	}

		function showMapAndRoute(l) {
		
			var rendererOptions = {
				    draggable: true
				  };
			var map = null;
			var directionsDisplay = new google.maps.DirectionsRenderer(rendererOptions);
			var directionsService = new google.maps.DirectionsService();
			var destinationName = "<?php echo $RETAILER_ADDRESS_MAP;?>";	//our destination. Set yours!
			
		   var latlng = new google.maps.LatLng(l.lat,l.lng);
		   var myOptions = {
			  zoom: 12,
			  scrollwheel: false,
			  mapTypeId: google.maps.MapTypeId.<?php echo $jkv["retailermapstyle"];?>
			};
			
			var map = new google.maps.Map(document.getElementById("canvas_map"), myOptions);
			directionsDisplay.setMap(map);
			directionsDisplay.setPanel(document.getElementById("directionsPanel"));

			 var request = {
				origin: l.lat + ',' + l.lng ,
				destination: destinationName,
				travelMode: google.maps.DirectionsTravelMode.DRIVING
			  };
			  directionsService = new google.maps.DirectionsService();
			  directionsService.route(request, function(result, status) {
				if (status == google.maps.DirectionsStatus.OK) {
				  directionsDisplay.setDirections(result);
				}
			  });	  
		}
			 
		function error(e)
		{
			switch(e.code) 
			{
				case e.TIMEOUT:
					alert ('Timeout');
					break;
				case e.POSITION_UNAVAILABLE:
					alert ('Position unavailable');
					break;
				case e.PERMISSION_DENIED:
					showMapOnly();
					break;
				case e.UNKNOWN_ERROR:
					alert ('Unknown error');
					break;
			}
			
			//try to get location using Google Geocoder
			showMap(true);			
		}
		
		function showMapOnly() {
		  	var myLatlng = new google.maps.LatLng(<?php echo $RETAILER_LAT;?>, <?php echo $RETAILER_LNG;?>);
			var mapOptions = {
			    center: myLatlng,
			    scrollwheel: false,
			    zoom: 14,
			    mapTypeId: google.maps.MapTypeId.<?php echo $jkv["retailermapstyle"];?>
			  }
			  
		  	// Create a map object and specify the DOM element for display.
		  	var map = new google.maps.Map(document.getElementById('canvas_map'), mapOptions);
		
		 	 // Create a marker and set its position.
			 var marker = new google.maps.Marker({
			    map: map,
			    position: myLatlng,
			    title: '<?php echo addslashes($PAGE_TITLE);?>',
			    clickable: true,
			    icon: '<?php echo BASE_URL;?>plugins/retailer/img/marker/flag_red.png',
			    shadow: '<?php echo BASE_URL;?>plugins/retailer/img/marker/flag_shadow.png'
			 });
		  
		  	// Creating an InfowWindow          
		  	var infowindow = new google.maps.InfoWindow({
		  	content: '<div class="row"><div class="col-xs-3"><img src="<?php echo $RETAILER_IMG;?>" alt="preview" width="80"></div><div class="col-xs-9"><strong><?php echo addslashes($PAGE_TITLE);?></strong><br><?php echo addslashes($RETAILER_ADDRESS);?></div></div>'
		  	});
		  	
		  marker.addListener('click', function() {
		      infowindow.open(map, marker);
		    });
		}

$(document).ready(function() {
	
	loadedmap = false;
	
	if (!loadedmap) {
	
	  <?php if ($jkv["retailerlocation"]) { ?>
		showMap();
	  	$("#showDirection").fadeIn();
	  	loadedmap = true;
	  <?php } else { ?>
	  	showMapOnly();
	  	loadedmap = true;
	  <?php } ?>
	  
	  $("#canvas_map").fadeIn();
	  
	 }
	 
	 <?php if ($jkv["retailerlocation"]) { ?>
	 $("#showDirection").fadeIn();
	 <?php } ?>
	
	$("#showMap").click(function(e) {
		e.preventDefault();
		$("#canvas_map").toggle();
	});
	
	$("#showDirection").click(function(e) {
		e.preventDefault();
		$(".directions").slideToggle();
	
	});
});
	
</script>

<?php } } ?>