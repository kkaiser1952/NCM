<?php
require_once( 'config.php' );
?>

<!DOCTYPE html >
<html>
  <head>
  	<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
	<title>Net Station Locations</title>
     <link rel="stylesheet" type="text/css" href="css/NCMstyle.css">
     
     <style>
	     .labels {
			  color: red;
			  font-weight: bold;
			/*  background-color: white;
			 */ font-family: "Lucida Grande", "Arial", sans-serif;
			  font-size: 12pt;
			  text-align: center;
			/*  width: 40px;
			*/  white-space: nowrap;
			pointer-events: none;
			opacity: 1;
	     }
	     .line{
		    width: 100%;
		    padding: 3px;
		    border-bottom: 2px solid #fc0d19;
    	}
     </style>
            
    <script src = "https://maps.googleapis.com/maps/api/js?key=<?php echo $_GOOGLE_MAPS_API_KEY; ?>&v=3.exp&libraries=geometry,places&ext=.js"></script>
    
    <script src = "https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    
    <script src = "https://cdn.rawgit.com/googlemaps/v3-utility-library/master/markerwithlabel/src/markerwithlabel.js"></script>

    
<script type="text/javascript">
    var map;
    var markers = [];
    
    var infoWindow;
    var locationSelect;
    var mapCenter = {lat: 39.260052, lng: -94.588887};
    
function load() {
    var mapOptions = {
    	center: mapCenter,
    	zoom: 11,
    	mapTypeId: 'roadmap',
    	mapTypeControlOptions: {style: google.maps.MapTypeControlStyle.DROPDOWN_MENU}
    };
    
	 map = new google.maps.Map(document.getElementById("map"),mapOptions);
      
      // This will call addMarker() to the location clicked (its a pain in the ass).
  /*      map.addListener('click', function(event) {
        	addMarker(event.latLng);
        });
   */     
        addMarker(mapCenter);
      
      infoWindow = new google.maps.InfoWindow();

      locationSelect = document.getElementById("locationSelect");
      locationSelect.onchange = function() {
        var markerNum = locationSelect.options[locationSelect.selectedIndex].value;
        if (markerNum != "none"){
          google.maps.event.trigger(markers[markerNum], 'click');
        }
        
      }; // End of locationSelect.onchange function
}  // End of load function 
   
function pinSymbol(color) {
  return {
    path: 'M 0,0 C -2,-20 -10,-22 -10,-30 A 10,10 0 1,1 10,-30 C 10,-22 2,-20 0,0 z',
    fillColor: color,
    fillOpacity: 1,
    strokeColor: '#000',
    strokeWeight: 2,
    scale: 2
  };
}
   
function moveToLocation(lat, lng) {
   	var mapCenter = new google.maps.LatLng(lat, lng);
   	map.panTo(mapCenter);
}
   
   
   var image1 = {
	   url: "images/newMarkers/google-maps-icon-blank-4-hi.png",
	   scaledSize: new google.maps.Size(50,50) // scaled size
   };
   var image2 = {
	   url: "images/newMarkers/map-marker-2-xxl.png"
	   ,scaledSize: new google.maps.Size(80,80) // scaled size
   };
   var DFTimage = {
	   url: "images/newMarkers/squareFilledHolePointer.png"
	   ,scaledSize: new google.maps.Size(70,70) // scaled size
   };
   var firstaid = {
	   url: "images/markers/firstaid.png"
	   ,scaledSize: new google.maps.Size(50,50) // scaled size
   };
   var middleMan = {
	   url: "images/newMarkers/manInTheMiddle.png"
	   ,scaledSize: new google.maps.Size(75,75) // scaled size
   };
   
 
   
function addMarker(location) {
	var marker = new MarkerWithLabel({
		position: location,
		map: map,
		labelContent: "",
		labelClass: "labels", 					// the CSS class for the label
		labelAnchor: new google.maps.Point(18, 66),
		labelInBackground: false,
		icon: middleMan
	}); // End marker definition
	
	id = marker.__gm_id;
	//mapCenter = location;
	markers.push(marker);
	markers[id] = marker;
	
	google.maps.event.addListener(marker, "rightclick", function(point) {id=this.__gm_id; delMarker(id) });
} // End addMarker function
   
   var delMarker = function(id) {
   		marker = markers(id);
   		marker.setMap(null);
   }
   
   // Sets the map on all markers in the array
   function setMapOnAll(map) {
   		for (var i = 0; i < markers.length; i++) {
   			markers[i].setMap(map);
   		}
   }
   function setMapOnPOI(map) {
   		for (var id = 80; id < 100; id++) {
   			markers[id].setMap(map);
   		}
   }

   
   // Removes the markers from the map, but keeps them in the array
   function clearMarkers() {
   		setMapOnAll(null);
   }
   
   // Shows all the markers in the array
   function showMarkers() {
   		//setMapOnAll(map); was only this until 2017-07-01 
   		
   		 //Removing old markers from the Map,if they are exist
   		// https://stackoverflow.com/questions/11641770/google-maps-v3-duplicate-markers-using-an-array-to-manage-markers-but-still-ge
    if(g.currentMarkers && g.currentMarkers.length !== 0){            
        $.each(g.currentMarkers, function(i,item){
            item.setMap(null);
        });
    }
    g.currentMarkers = []; // setting up my marker array
    $.each(g.markersCollection, function(i,item){ 
           var expectedPosition = new google.maps.LatLng(item.lat, item.lng);
           //No need to add marker on the Map if it will not visible on viewport, 
           //so we check the position, before adding 
           if(g.map.getBounds().contains(expectedPosition)){
                g.currentMarkers.push(new google.maps.Marker({ 
                    position : expectedPosition ,
                    label: 'it happend'
                }) );
           }
    });
   }
   
   function showPOIMarkers() {
	  setMapOnPOI(map);
   }
   
   // Deletes all markers in the array
   function deleteMarkers() {
   		clearMarkers();
   		markers = [];
   }

   //var x = 0;
   
   function mapByNetID(str) {
	   var netID = str; //alert(netID);
	   		//document.getElementById('thenetid').value = netID;
   		if (document.getElementById('thenetid').value == '') {netID=0};
   		//var x = netID
   		//alert(netID);
   			searchLocations(netID);
	}

   function searchLocations(x) {
	  var netID = x;
	  //alert("in searchLocations= " + netID);
	  var inputKoords = document.getElementById("coordsInput").value;
	  
     	if (inputKoords != ''){
     		var address = document.getElementById("coordsInput").value;
     	}else{
     		var address = document.getElementById("addressInput").value;
     	} 
     	
     if (address === "All Stations"){
	     //alert('now in All Stations Loop netID= '+netID); This works
	     
    	address = "39.260, -94.588";
    	
    	//document.getElementById('radiusSelect').value = 15;
    	var geocoder = new google.maps.Geocoder();
	     geocoder.geocode({address: address}, function(results, status) {
	       if (status == google.maps.GeocoderStatus.OK) {
	       var koords = results[0].geometry.location; 
	       
	       //alert(koords);
	       document.getElementById("coordsInput").value = "39.2601, -94.5888";	       	
	        searchLocationsNear(results[0].geometry.location,netID);
	       } else {
	         alert(address + ' not found');
	       }
	     });   	
     }else {
	     var geocoder = new google.maps.Geocoder();
	     geocoder.geocode({address: address}, function(results, status) {
	       if (status == google.maps.GeocoderStatus.OK) {
	       var koords = results[0].geometry.location;
	       
	       document.getElementById("coordsInput").value = "39.2601, -94.5888";
	       	
	        searchLocationsNear(results[0].geometry.location,netID);
	        
	       } else {
	         alert(address + ' not found');
	       }
	     });
     }// end of else
   } // end searchlocations


   function clearLocations() {
     infoWindow.close();
     for (var i = 0; i < markers.length; i++) {
       markers[i].setMap(null);
     }
     markers.length = 0;

     locationSelect.innerHTML = "";
     var option = document.createElement("option");
     option.value = "none";
     option.innerHTML = "See all results:";
     locationSelect.appendChild(option);
   }
   


function searchLocationsNear(center,netID) {
	   
   //alert(netID);
     clearLocations();  
     
     var radius = document.getElementById('radiusSelect').value;
    
    // 2017-06-16   call getNCMXML2 to test new functionality
     var searchUrl = "getNCMXML.php?lat=" + center.lat() + "&lng=" + center.lng() + "&dist=" + radius + 
    	"&netID=" + netID ; 	
	
	// Use this to find center of displayed stations; https://stackoverflow.com/questions/10634199/find-center-of-multiple-locations-in-google-maps
	// https://stackoverflow.com/questions/19304574/center-set-zoom-of-map-to-cover-all-visible-markers
     
    downloadUrl(searchUrl, function(data) {
	  //  alert(searchUrl);  
	      // getNCMXML2.php?lat=39.2600683&lng=-94.58902999999998&dist=15&netID=260
       var xml = parseXml(data);
       var markerNodes = xml.documentElement.getElementsByTagName("marker");
       
       var markers = [];
       var bound = new google.maps.LatLngBounds();
       
	   for (i = 0; i < markers.length; i++) {
	   		bound.extend( markers[i].getPosition());
	   } 
	   
	   map.fitBounds(bound);
      
	   for (var i = 0; i < markerNodes.length; i++) {
	
         var Fname = markerNodes[i].getAttribute("Fname");
         var address = markerNodes[i].getAttribute("address");
         var distance = parseFloat(markerNodes[i].getAttribute("distance"));
         
         // 9/15/2016: The id value is used to pull the correct marker but the markers are only two digit names 
         // to make the three digit id only two digits I remove the first number... usually a zero
		 var id = markerNodes[i].getAttribute("ID"); 
		/* 	if (Number(id) < 100 ) { 
		 		var id = id.substring(1, 3); 
		 	}
		 	if (Number(id) >= 100) {//alert(id);
			 	};  */
		 var tt			= markerNodes[i].getAttribute("tt");  //alert("tt= "+tt);
		 var callsign 	= markerNodes[i].getAttribute("callsign");
		 var Lname 		= markerNodes[i].getAttribute("Lname");
		 var grid 		= markerNodes[i].getAttribute("grid");
		 var lat  		= markerNodes[i].getAttribute("lat");
		 var lng  		= markerNodes[i].getAttribute("lng");
		 var tactical 	= markerNodes[i].getAttribute("tactical"); 
		 var email  	= markerNodes[i].getAttribute("email");  
		 var creds  	= markerNodes[i].getAttribute("creds");   
		 var netID  	= markerNodes[i].getAttribute("netID");
		 
         
        var latlng = new google.maps.LatLng(
          parseFloat(markerNodes[i].getAttribute("lat")),
          parseFloat(markerNodes[i].getAttribute("lng")));

         createOption(tt, callsign, Fname, distance, i);
         createMarker(latlng, tt, Fname, Lname, grid, lat, lng, callsign, email, tactical, distance, creds, netID);
         bound.extend(latlng);
       }
       map.fitBounds(bound);
       
       locationSelect.style.visibility = "visible";
       locationSelect.onchange = function() {
         var markerNum = locationSelect.options[locationSelect.selectedIndex].value;
         google.maps.event.trigger(markers[markerNum], 'click');
       };
      });
    }

// This appears inside the marker
    function createMarker(latlng, tt, Fname, Lname, grid, lat, lng, callsign, email, tactical, distance, creds, netID, type) {
	   // alert("id= "+id);
      var html = "<div style='color: darkred; font-weight: bold;'>#" + tt + " Tact: " + tactical + "<br>" + "Call: "+callsign+ "</div><div class='line'></div> <div style='color: darkblue;'>" + 
      				Fname + "<br/>Grid: "  + grid +
          		   "<br/>" + lat +", "+ lng + 
          			 "<br/>" + distance + " Miles from 152 &amp; 169 hiways" + "<div class='line'></div>" + 		 
          			 creds + "<br>" +
          			 '<a href="' + email + '">' + email + "</a></div>" 
          			 ;
         
// https://stackoverflow.com/questions/32467212/google-maps-marker-label-with-multiple-characters/32468461#32468461

	if (Lname == 'Hospital') {
		var dfltIcon = {
			url: "images/markers/hospital-building.png"
			,scaledSize: new google.maps.Size(40,40) // scaled size 110 is the width, 70 the height
		};
		var dfltContent = '';
	} else {
		var dfltIcon = {
			url: "images/newMarkers/squareFilledHolePointer.png"
			,scaledSize: new google.maps.Size(110,70) // scaled size 110 is the width, 70 the height
		};
		var dfltContent = tactical;
	}
	
	if (tactical == 'NWS') {
		var dfltIcon = {
			url: "images/newMarkers/nws_logo.png"
			,scaledSize: new google.maps.Size(40,40) // scaled size 110 is the width, 70 the height
		};
		var dfltContent = '';
	};
	
	if (tactical == 'POI') {
		var dfltIcon = {
			url: "images/markers/blue_50_flag.png"
			,scaledSize: new google.maps.Size(50,50) // scaled size 110 is the width, 70 the height
		};
		var dfltContent = '';
	}
	if (tactical.substring(0,3) == 'EOC') {
		var dfltIcon = {
			url: "images/markers/kcnares_50.png"
			,scaledSize: new google.maps.Size(40,40) // scaled size 110 is the width, 70 the height
		};
		var dfltContent = '';
	}
	if (tactical == 'NRAD') {
		var dfltIcon = {
			url: "images/markers/firstaid.png"
			,scaledSize: new google.maps.Size(40,40) // scaled size 110 is the width, 70 the height
		};
		var dfltContent = '';
	}
	

      var marker = new MarkerWithLabel({
        map: map,
        position: latlng,
        labelSytle: {opacity:0},
        draggable: true,
        raiseOnDrag: true,
        labelContent: dfltContent,
        labelClass: "labels",
        labelInBackground: false,
        labelAnchor: new google.maps.Point(38, 55),                //(25, 55), for long labels
        icon: dfltIcon, 
	    marker: MarkerWithLabel
      });

      google.maps.event.addListener(marker, 'click', function() {
        infoWindow.setContent(html);
        infoWindow.open(map, marker);
        //https://github.com/googlemaps/v3-utility-library/issues/24
        marker.setZIndex(hoverOffset);
        hoverOffset += 2;
      });
       
      markers.push(marker);
      
      google.maps.event.addListener(map, 'mousemove', function(evt){
	      document.getElementById('koords').innerHTML = "Mouse at: " + evt.latLng.lat().toFixed(3) + ', ' + evt.latLng.lng().toFixed(3) + '  Grid: EM29..';
	  });
    } // end createMarker
    
    function rotateMarker(degree){
     $('img[src="images/newMarkers/squareFilledHolePointer.png"]').css({
         'transform': 'rotate('+degree+'deg)'
     });
}

    function createOption(id, callsign, Fname, distance, num) {
      var option = document.createElement("option");
      option.value = num;
      option.innerHTML = id + " -- " + callsign +  " -- " + Fname + " (" + distance.toFixed(1) + " miles)";
      locationSelect.appendChild(option);
    }

    function downloadUrl(url, callback) {
      var request = window.ActiveXObject ?
          new ActiveXObject('Microsoft.XMLHTTP') :
          new XMLHttpRequest;

      request.onreadystatechange = function() {
        if (request.readyState == 4) {
          request.onreadystatechange = doNothing;
          callback(request.responseText, request.status);
        }
      };
//alert(url);
      request.open('GET', url, true);
      request.send(null);
    }

    function parseXml(str) {
      if (window.ActiveXObject) {
        var doc = new ActiveXObject('Microsoft.XMLDOM');
        doc.loadXML(str);
        return doc;
      } else if (window.DOMParser) {
        return (new DOMParser).parseFromString(str, 'text/xml');
      }
    }

    function doNothing() {}

    //]]>
     google.maps.event.addDomListener(window, 'load', load);
    // var geocoder = new google.maps.Geocoder(); from line 122
    
    $(document).ready(function() {

    $("#reset_state").click(function() {
      
      map.fitBounds(bound);
    })
  });
  
  </script>
  </head>

  <body>
  
  <div id="header">
	  <b style:"padding-top:3px; font-size=105%;">Find all the stations by:</b><br />
     
	  Enter a Net Number and Press Enter:
	  	<input type="text" id="thenetid" size="5" value="" onchange="mapByNetID(this.value)" /> 
	  	
<!--	  	<input type="text" id="thenetid" size="5" value="275" onClick="mapByNetID(this.value)" /> -->
	  Or enter an address here: 
	  	<input type="text" id="addressInput" size="20" value="All Stations" onkeydown="if (event.keycode == 13) { searchLocations(); return false; }" /><br />
	  	
	  Or a Lat/Lng here (ex. 39.2601, -94.5888):
	  	<input type="text" id="coordsInput" size="15"/>
	  	
	  Select Search Radius:
	  	<select id="radiusSelect">
		  <option value="1">1mi</option>
	      <option value="3">3mi</option>
	      <option value="5">5mi</option>
	      <option value="10">10mi</option>
	      <option value="12">12mi</option>
	      <option value="15">15mi</option>
	      <option value="20">20mi</option>
	      <option value="25">25mi</option>
	      <option value="30" selected>30mi</option>
	      <option value="50">50mi</option>
	      <option value="100">100mi</option>
	      <option value="200">200mi</option>
	      <option value="1000">1000</option>

      	</select>

	  <input type="button" onclick="searchLocations()" value="All Points"/>
<!--	  <input type="button" id="reset_state" value="re-position" />  look for the function -->
	  <input type="button" id="resetBTN" onclick="javascript:location.reload(true)" value="Reset"/>
  </div> <!-- end header div -->
  
  <div id="panel" style="width: 100%;">
  	<select id="locationSelect"></select>
  	<div id="koords" style="margin-right: 300px;"></div>
  	<div id="mrkrCntl">
 		<input onclick="clearMarkers();" type="button" value="Hide Markers">
  		<input onclick="showMarkers();" type="button" value="Show All Markers">
  		<input onclick="showPOIMarkers();" type="button" value="Show POI Markers"> 
  		<input onclick="deleteMarkers();" type="button" value="Delete Markers">

  	</div>
  </div> <!-- end panel div -->
  
  	<div id ="wrapper"> <!-- All things related to the map -->
  	<div id="map"></div>
<!--  <div id="koords"></div> --> <!-- to show coords of mouse -->
  
  <div id="mapbottom"> <!-- holds the demo-icons at bottom -->
  
  <div id="flags">
  		 <img src="images/markers/kcnares_50.png" alt="EOC" width="50" align="middle" /> EOC's 
    	 <img src="images/markers/hospital-building.png" alt="HOSPITAL" width="50" align="middle" /> Hospitals
    	 <img src="images/markers/blue_50_flag.png" alt="POI" width="28" height="50" align="middle" /> POI's
  </span></div></div>
  
  </body>
</html>
