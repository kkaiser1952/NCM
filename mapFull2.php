
<!DOCTYPE html>

<!-- Primary maping program, also uses poiMarkers.php, objMarkers.php and stationMarkers.php -->

<!-- Development using objlayer3818.php instead of objMarkers3818.php -->


<html lang="en">
<head>
	<title>NCM Map of Station Locations</title>

	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	
	<link rel="shortcut icon" type="image/x-icon" href="images/favicon-32x32.png" >

     <!-- ******************************** Load LEAFLET from CDN *********************************** -->
     <link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css"
     integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ=="
     crossorigin=""/>
     
     <script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js"
         integrity="sha512-gZwIG9x3wUXg2hdXF6+rVkLF/0Vi9U8D2Ntg4Ga5I5BZpVkVxlJWbSQtXPSiUTtC0TjtGOmxa1AJPuV0CPthew=="
             crossorigin=""></script>
     <!-- ********************************* End Load LEAFLET **************************************** -->
     
     <!-- ******************************** Load ESRI LEAFLET from CDN ******************************* -->
     <script src="https://unpkg.com/esri-leaflet@2.2.4/dist/esri-leaflet.js"
    integrity="sha512-tyPum7h2h36X52O2gz+Pe8z/3l+Y9S1yEUscbVs5r5aEY5dFmP1WWRY/WLLElnFHa+k1JBQZSCDGwEAnm2IxAQ=="
    crossorigin=""></script>
    
    <!-- Load Esri Leaflet Geocoder from CDN -->
	<link rel="stylesheet" href="https://unpkg.com/esri-leaflet-geocoder@2.2.14/dist/esri-leaflet-geocoder.css"
    integrity="sha512-v5YmWLm8KqAAmg5808pETiccEohtt8rPVMGQ1jA6jqkWVydV5Cuz3nJ9fQ7ittSxvuqsvI9RSGfVoKPaAJZ/AQ=="
    crossorigin="">
    
    <script src="https://unpkg.com/esri-leaflet-geocoder@2.2.14/dist/esri-leaflet-geocoder.js"
    integrity="sha512-uK5jVwR81KVTGe8KpJa1QIN4n60TsSV8+DPbL5wWlYQvb0/nYNgSOg9dZG6ViQhwx/gaMszuWllTemL+K+IXjg=="
    crossorigin=""></script>     
    <!-- ******************************** End ESRI LEAFLET ***************************************** -->
     
     <!-- ******************************** Style Sheets *************************************** -->
    <link rel="stylesheet" href="css/leaflet_numbered_markers.css" />
    <link rel="stylesheet" href="css/L.Grid.css" />   
    <link rel="stylesheet" href="css/L.Control.MousePosition.css" />
    <link rel="stylesheet" href="css/control.w3w.css" />
    
    <link rel="stylesheet" href="https://ppete2.github.io/Leaflet.PolylineMeasure/Leaflet.PolylineMeasure.css" />
    <link rel="stylesheet" type="text/css" href="css/maps.css">  
    <link rel="stylesheet" type="text/css" href="css/leaflet/leaflet.contextmenu.min.css">
    
    <!-- Various additional Leaflet javascripts -->
    <script src="js/leaflet_numbered_markers.js"></script>
    <script src="js/L.Grid.js"></script>                    <!-- https://github.com/jieter/Leaflet.Grid -->
    <script src="js/L.Control.MousePosition.js"></script>   <!-- https://github.com/ardhi/Leaflet.MousePosition -->
    <script src="js/hamgridsquare.js"></script>
    <script src="https://ppete2.github.io/Leaflet.PolylineMeasure/Leaflet.PolylineMeasure.js"></script>  
    <script src="js/leaflet/leaflet.contextmenu.min.js"></script>
    <!-- Allows for rotating markers when more than one at the same place -->
    <script src="js/leaflet.rotatedMarker.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/leaflet-geometryutil@0.9.1/src/leaflet.geometryutil.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@turf/turf@5/turf.min.js"></script>
    
    <!-- What 3 Words -->
    <script src="js/control.w3w.js"></script>
    
    <!-- circleKoords is the javascript program that caluclates the number of rings and the distance between them -->
    <script src="js/circleKoords3818.js"></script>
    

	<style>
		/* All CSS is in css/maps.css */
		.cc {  /* used for the comment */
		    display: inline-block;
		    text-transform: lowercase;
    		font-weight: bold;
    		color: red;
    		font-size: larger;
		}
		.cc:first-letter {
    		text-transform: uppercase;
		}
		
		.bb {
    		font-weight: bold;
    		color: blue;
    		font-size: larger;
		}
		
		element.style  {
    		width: 60px !important;
        }
        
        .gg {
            font-weight: bold;
            color: green;
            font-size: larger;
        }
        
        .xx {
            font-wight: bold;
            font-size: x-large;
        }
        
        .objmarker {
            color: green;
            font-size: x-large;
        }
        
        .number-icon {
            background-image: url("images/number-marker-icon.png");
            text-align:center;
            color:White;    
        }
        
        .leaflet-control {
            background: transparent;
            border: solid black;
        }
        
        .leaflet-control-zoom {
           
        }
        
		
	</style>
	
</head>

<body>
    
    <!-- the map div holds the map -->
    <div id="map"></div>
    
    <!-- the stations div holds a list of the stations marked on the map -->
    <div id="stations"> 
		<b style="color:red; text-decoration: underline;">TE0ST
    		</b><br><a class='rowno' id='marker_1' href='#'>1 WA0TJT</a><br><a class='rowno' id='marker_2' href='#'>2 W0DLK</a><br><a class='rowno' id='marker_3' href='#'>3 KD0NBH</a><br><a class='rowno' id='marker_4' href='#'>4 KC0YT</a><br><a class='rowno' id='marker_5' href='#'>5 AA0JX</a><br><a class='rowno' id='marker_6' href='#'>6 AA0DV</a><br>	</div>

    <!-- The title banner -->
    <div id="activity" class="activity">
    	<img src="images/NCM.png" alt="NCM" style="width: 35px; padding-left: 10px; padding-top: 5px;">
    	TE0ST Net #3818 For Testing Only Testing new Object Map     </div>
    

<!-- Everything is inside a javascript, closing is near the end of the page -->
<script> 
    
    // Define the map
    const map = L.map('map', {
    	drawControl: true,
		zoom: 12
	}); 
	
	// Define the layers for the map
    var Streets = L.esri.basemapLayer('Streets').addTo(map),
        Imagery = L.esri.basemapLayer('Imagery').addTo(map),
        Topo    = L.esri.basemapLayer('Topographic').addTo(map),
        NatGeo  = L.esri.basemapLayer('NationalGeographic').addTo(map);
    
    var baseMaps = { "<span style='color: blue; font-weight: bold;'>Imagery": Imagery,
                     "<span style='color: blue; font-weight: bold;'>NatGeo": NatGeo,
                     "<span style='color: blue; font-weight: bold;'>Topo": Topo,
                     "<span style='color: blue; font-weight: bold;'>Streets": Streets               
                   };
	
	// The overlay markers to show by default                 
    Stations.addTo(map);

    $OBJlayer.addTo(map);

    
// These are the markers that will appear on the map

			var WA0TJT = new L.marker(new L.LatLng(39.2028965,-94.602876),{ 
			    rotationAngle: 0,
			    rotationOrigin: 'bottom',
    			contextmenu: true,
			    contextmenuWidth: 140,
			    contextmenuItems: [{ text: 'Click here to add mileage circles', callback: circleKoords}],  
			                 
				icon: new L.NumberedGreenDivIcon({number: '1' }),
				title:`marker_1` }).addTo(fg).bindPopup(`
				<div class='cc'>1<br><b>WA0TJT</b><br> ID: #0013<br>Keith Kaiser<br>Platte  Co., MO Dist: A<br>39.2028965, -94.602876<br>EM29QE<br><a href='https://what3words.com/guiding.confusion.towards?maptype=osm' target='_blank'>///guiding.confusion.towards</a></div><br><br>
				
				
				<div class='cc'> <a href='http://www.findu.com/cgi-bin/map-near.cgi?lat=39.2028965&lon=-94.602876&cnt=10' target='_blank'>Nearby APRS stations</a></div><br><br>
                
                
                `).openPopup();
				
				$(`WA0TJT`._icon).addClass(`greenmrkr`); 
                stationMarkers.push(WA0TJT);
				
			var W0DLK = new L.marker(new L.LatLng(39.2028965,-94.602876),{ 
			    rotationAngle: 45,
			    rotationOrigin: 'bottom',
    			contextmenu: true,
			    contextmenuWidth: 140,
			    contextmenuItems: [{ text: 'Click here to add mileage circles', callback: circleKoords}],  
			                 
				icon: new L.NumberedGreenDivIcon({number: '2' }),
				title:`marker_2` }).addTo(fg).bindPopup(`
				<div class='cc'>2<br><b>W0DLK</b><br> ID: #0023<br>Deb Kaiser<br>Platte  Co., MO Dist: A<br>39.2028965, -94.602876<br>EM29QE<br><a href='https://what3words.com/guiding.confusion.towards?maptype=osm' target='_blank'>///guiding.confusion.towards</a></div><br><br>
				
				
				<div class='cc'> <a href='http://www.findu.com/cgi-bin/map-near.cgi?lat=39.2028965&lon=-94.602876&cnt=10' target='_blank'>Nearby APRS stations</a></div><br><br>
                
                
                `).openPopup();
				
				$(`W0DLK`._icon).addClass(`greenmrkr`); 
                stationMarkers.push(W0DLK);
				
			var KD0NBH = new L.marker(new L.LatLng(39.204385,-94.606862),{ 
			    rotationAngle: 0,
			    rotationOrigin: 'bottom',
    			contextmenu: true,
			    contextmenuWidth: 140,
			    contextmenuItems: [{ text: 'Click here to add mileage circles', callback: circleKoords}],  
			                 
				icon: new L.NumberedGreenDivIcon({number: '3' }),
				title:`marker_3` }).addTo(fg).bindPopup(`
				<div class='cc'>3<br><b>KD0NBH</b><br> ID: #1812<br>John Britton<br>Clay Co., MO Dist: A<br>39.204385, -94.606862<br>EM29QE<br><a href='https://what3words.com/craving.since.duchess?maptype=osm' target='_blank'>///craving.since.duchess</a></div><br><br>
				
				
				<div class='cc'> <a href='http://www.findu.com/cgi-bin/map-near.cgi?lat=39.204385&lon=-94.606862&cnt=10' target='_blank'>Nearby APRS stations</a></div><br><br>
                
                
                `).openPopup();
				
				$(`KD0NBH`._icon).addClass(`greenmrkr`); 
                stationMarkers.push(KD0NBH);
				
			var KC0YT = new L.marker(new L.LatLng(39.2002636,-94.641221),{ 
			    rotationAngle: 0,
			    rotationOrigin: 'bottom',
    			contextmenu: true,
			    contextmenuWidth: 140,
			    contextmenuItems: [{ text: 'Click here to add mileage circles', callback: circleKoords}],  
			                 
				icon: new L.NumberedDivIcon({number: '4' }),
				title:`marker_4` }).addTo(fg).bindPopup(`
				<div class='cc'>4<br><b>KC0YT</b><br> ID: #0050<br>Charlotte Hoverder<br>Platte Co., MO Dist: A<br>39.2002636, -94.641221<br>EM29QE<br><a href='https://what3words.com/divider.hooking.altering?maptype=osm' target='_blank'>///divider.hooking.altering</a></div><br><br>
				
				
				<div class='cc'> <a href='http://www.findu.com/cgi-bin/map-near.cgi?lat=39.2002636&lon=-94.641221&cnt=10' target='_blank'>Nearby APRS stations</a></div><br><br>
                
                
                `).openPopup();
				
				$(`KC0YT`._icon).addClass(`bluemrkr`); 
                stationMarkers.push(KC0YT);
				
			var AA0JX = new L.marker(new L.LatLng(39.2232199,-94.568932),{ 
			    rotationAngle: 0,
			    rotationOrigin: 'bottom',
    			contextmenu: true,
			    contextmenuWidth: 140,
			    contextmenuItems: [{ text: 'Click here to add mileage circles', callback: circleKoords}],  
			                 
				icon: new L.NumberedGreenDivIcon({number: '5' }),
				title:`marker_5` }).addTo(fg).bindPopup(`
				<div class='cc'>5<br><b>AA0JX</b><br> ID: #0270<br>Mike Mc Donald<br>Clay Co., MO Dist: A<br>39.2232199, -94.568932<br>EM29RF<br><a href='https://what3words.com/begins.theme.locals?maptype=osm' target='_blank'>///begins.theme.locals</a></div><br><br>
				
				
				<div class='cc'> <a href='http://www.findu.com/cgi-bin/map-near.cgi?lat=39.2232199&lon=-94.568932&cnt=10' target='_blank'>Nearby APRS stations</a></div><br><br>
                
                
                `).openPopup();
				
				$(`AA0JX`._icon).addClass(`greenmrkr`); 
                stationMarkers.push(AA0JX);
				
			var AA0DV = new L.marker(new L.LatLng(39.2628465,-94.569978),{ 
			    rotationAngle: 0,
			    rotationOrigin: 'bottom',
    			contextmenu: true,
			    contextmenuWidth: 140,
			    contextmenuItems: [{ text: 'Click here to add mileage circles', callback: circleKoords}],  
			                 
				icon: new L.NumberedGreenDivIcon({number: '6' }),
				title:`marker_6` }).addTo(fg).bindPopup(`
				<div class='cc'>6<br><b>AA0DV</b><br> ID: #0003<br> Jenkins<br>Clay Co., MO Dist: A<br>39.2628465, -94.569978<br>EM29RG<br><a href='https://what3words.com/thankfully.sweetened.remains?maptype=osm' target='_blank'>///thankfully.sweetened.remains</a></div><br><br>
				
				
				<div class='cc'> <a href='http://www.findu.com/cgi-bin/map-near.cgi?lat=39.2628465&lon=-94.569978&cnt=10' target='_blank'>Nearby APRS stations</a></div><br><br>
                
                
                `).openPopup();
				
				$(`AA0DV`._icon).addClass(`greenmrkr`); 
                stationMarkers.push(AA0DV);
			;

         
            var W0KCN4 = new L.marker(new L.LatLng(39.3721733,-94.780929),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/eoc.png`, iconSize: [32, 34]}),
                        title:`marker_E2`}).addTo(fg).bindPopup(`W0KCN4<br>Northland ARES Platte Co. EOC<br><br>Platte City, MO<br><b style='color:red;'></b><br>39.3721733, -94.780929,  0 Ft.<br>EM29OI`).openPopup();                        
 
                        $(`EOC`._icon).addClass(`eocmrkr`);
            var W0KCN3 = new L.marker(new L.LatLng(39.2859182,-94.667236),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/eoc.png`, iconSize: [32, 34]}),
                        title:`marker_E3`}).addTo(fg).bindPopup(`W0KCN3<br>Northland ARES Platte Co. Resource Center<br><br>Kansas City, MO<br><b style='color:red;'></b><br>39.2859182, -94.667236,  0 Ft.<br>EM29PG`).openPopup();                        
 
                        $(`EOC`._icon).addClass(`eocmrkr`);
            var W0KCN15 = new L.marker(new L.LatLng(39.363954,-94.584749),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/eoc.png`, iconSize: [32, 34]}),
                        title:`marker_E4`}).addTo(fg).bindPopup(`W0KCN15<br>Northland ARES Clay Co. Fire Station #2<br>6569 N Prospect Ave<br>Smithville, MO<br><b style='color:red;'></b><br>39.363954, -94.584749,  0 Ft.<br>EM29QI`).openPopup();                        
 
                        $(`EOC`._icon).addClass(`eocmrkr`);
            var NARESEOC = new L.marker(new L.LatLng(39.245231,-94.41976),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/eoc.png`, iconSize: [32, 34]}),
                        title:`marker_E5`}).addTo(fg).bindPopup(`NARESEOC<br>Clay County Sheriff & KCNARES EOC<br><br>Liberty, MO<br><b style='color:red;'></b><br>39.245231, -94.41976,  0 Ft.<br>EM29SF`).openPopup();                        
 
                        $(`EOC`._icon).addClass(`eocmrkr`);
           
            var KCMOFS44 = new L.marker(new L.LatLng(39.246423046000075,-94.66588993499994),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/fire.png`, iconSize: [32, 34]}),
                        title:`marker_F1`}).addTo(fg).bindPopup(`KCMOFS44<br>KCMO Fire Station No. 44<br>7511 NW Barry Rd<br>Kansas City, MO<br><b style='color:red;'></b><br>39.246423046000075, -94.66588993499994,  0 Ft.<br>EM29QF`).openPopup();                        
 
                        $(`Fire`._icon).addClass(`firemrkr`);
                       var KCMOFS36 = new L.marker(new L.LatLng(38.947990154000024,-94.58198512499996),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/fire.png`, iconSize: [32, 34]}),
                        title:`marker_F3`}).addTo(fg).bindPopup(`KCMOFS36<br>KCMO Fire Station No. 36<br>9903 Holmes Rd<br>Kansas City, MO<br><b style='color:red;'></b><br>38.947990154000024, -94.58198512499996,  0 Ft.<br>EM28RW`).openPopup();                        
 
                        $(`Fire`._icon).addClass(`firemrkr`);
            var CARROLFD = new L.marker(new L.LatLng(39.364764,-93.482455),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/fire.png`, iconSize: [32, 34]}),
                        title:`marker_F4`}).addTo(fg).bindPopup(`CARROLFD<br>Carrollton Fire Department<br>710 Harvest Hills Dr<br>Carroll, MO 64633<br><b style='color:red;'></b><br>39.364764, -93.482455,  0 Ft.<br>EM39GI`).openPopup();                        
 
                        $(`Fire`._icon).addClass(`firemrkr`);
            var KCMOFS37 = new L.marker(new L.LatLng(38.98838295400003,-94.59471418799995),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/fire.png`, iconSize: [32, 34]}),
                        title:`marker_F5`}).addTo(fg).bindPopup(`KCMOFS37<br>KCMO Fire Station No. 37<br>7708 Wornall Rd<br>Kansas City, MO<br><b style='color:red;'></b><br>38.98838295400003, -94.59471418799995,  0 Ft.<br>EM28QX`).openPopup();                        
 
                        $(`Fire`._icon).addClass(`firemrkr`);
            var RVRSFD = new L.marker(new L.LatLng(39.17579,-94.615947),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/fire.png`, iconSize: [32, 34]}),
                        title:`marker_F6`}).addTo(fg).bindPopup(`RVRSFD<br>   Riverside City Fire Department<br> 2990 NW Vivion Rd<br> 	   Riverside MO 64150<br><b style='color:red;'></b><br>39.17579, -94.615947,  0 Ft.<br>EM29QE`).openPopup();                        
 
                        $(`Fire`._icon).addClass(`firemrkr`);
            var KCMOFS14 = new L.marker(new L.LatLng(39.24420365000003,-94.52101456199995),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/fire.png`, iconSize: [32, 34]}),
                        title:`marker_F7`}).addTo(fg).bindPopup(`KCMOFS14<br>KCMO Fire Station No. 14<br>8300 N Brighton Ave<br>Kansas City, MO<br><b style='color:red;'></b><br>39.24420365000003, -94.52101456199995,  0 Ft.<br>EM29RF`).openPopup();                        
 
                        $(`Fire`._icon).addClass(`firemrkr`);
            var KCMOFS38 = new L.marker(new L.LatLng(39.24114461900007,-94.57637879999999),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/fire.png`, iconSize: [32, 34]}),
                        title:`marker_F8`}).addTo(fg).bindPopup(`KCMOFS38<br>KCMO Fire Station No. 38<br>8100 N Oak Tfwy<br>Kansas City, MO<br><b style='color:red;'></b><br>39.24114461900007, -94.57637879999999,  0 Ft.<br>EM29RF`).openPopup();                        
 
                        $(`Fire`._icon).addClass(`firemrkr`);
            var KCMOFS39 = new L.marker(new L.LatLng(39.037389129000076,-94.44871189199995),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/fire.png`, iconSize: [32, 34]}),
                        title:`marker_F9`}).addTo(fg).bindPopup(`KCMOFS39<br>KCMO Fire Station No. 39<br>11100 E 47th St<br>Kansas City, MO<br><b style='color:red;'></b><br>39.037389129000076, -94.44871189199995,  0 Ft.<br>EM29SA`).openPopup();                        
 
                        $(`Fire`._icon).addClass(`firemrkr`);
            var KCMOFS40 = new L.marker(new L.LatLng(39.18825564000008,-94.57705538299996),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/fire.png`, iconSize: [32, 34]}),
                        title:`marker_F10`}).addTo(fg).bindPopup(`KCMOFS40<br>KCMO Fire Station No. 40<br>5200 N Oak Tfwy<br>Kansas City, MO<br><b style='color:red;'></b><br>39.18825564000008, -94.57705538299996,  0 Ft.<br>EM29RE`).openPopup();                        
 
                        $(`Fire`._icon).addClass(`firemrkr`);
            var KCMOFS41 = new L.marker(new L.LatLng(38.956671338000035,-94.52135318999996),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/fire.png`, iconSize: [32, 34]}),
                        title:`marker_F11`}).addTo(fg).bindPopup(`KCMOFS41<br>KCMO Fire Station No. 41<br>9300 Hillcrest Rd<br>Kansas City, MO<br><b style='color:red;'></b><br>38.956671338000035, -94.52135318999996,  0 Ft.<br>EM28RW`).openPopup();                        
 
                        $(`Fire`._icon).addClass(`firemrkr`);
            var KCMOFS42 = new L.marker(new L.LatLng(38.924447272000066,-94.51993356699995),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/fire.png`, iconSize: [32, 34]}),
                        title:`marker_F12`}).addTo(fg).bindPopup(`KCMOFS42<br>KCMO Fire Station No. 42<br>6006 E Red Bridge Rd<br>Kansas City, MO<br><b style='color:red;'></b><br>38.924447272000066, -94.51993356699995,  0 Ft.<br>EM28RW`).openPopup();                        
 
                        $(`Fire`._icon).addClass(`firemrkr`);
            var KCMOFS47 = new L.marker(new L.LatLng(39.14034793800005,-94.52048369499994),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/fire.png`, iconSize: [32, 34]}),
                        title:`marker_F13`}).addTo(fg).bindPopup(`KCMOFS47<br>KCMO Fire Station No. 47<br>5130 Deramus Ave<br>Kansas City, MO<br><b style='color:red;'></b><br>39.14034793800005, -94.52048369499994,  0 Ft.<br>EM29RD`).openPopup();                        
 
                        $(`Fire`._icon).addClass(`firemrkr`);
            var KCMOFS43 = new L.marker(new L.LatLng(38.96734958800005,-94.43185910999995),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/fire.png`, iconSize: [32, 34]}),
                        title:`marker_F14`}).addTo(fg).bindPopup(`KCMOFS43<br>KCMO Fire Station No. 43<br>12900 E M 350 Hwy<br>Kansas City, MO<br><b style='color:red;'></b><br>38.96734958800005, -94.43185910999995,  0 Ft.<br>EM28SX`).openPopup();                        
 
                        $(`Fire`._icon).addClass(`firemrkr`);
            var KCMOFS45 = new L.marker(new L.LatLng(38.89023597400006,-94.58854005199998),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/fire.png`, iconSize: [32, 34]}),
                        title:`marker_F15`}).addTo(fg).bindPopup(`KCMOFS45<br>KCMO Fire Station No. 45<br>500 E 131st St<br>Kansas City, MO<br><b style='color:red;'></b><br>38.89023597400006, -94.58854005199998,  0 Ft.<br>EM28QV`).openPopup();                        
 
                        $(`Fire`._icon).addClass(`firemrkr`);
            var KCMOFS35 = new L.marker(new L.LatLng(39.04105321900005,-94.54716372899998),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/fire.png`, iconSize: [32, 34]}),
                        title:`marker_F16`}).addTo(fg).bindPopup(`KCMOFS35<br>KCMO Fire Station No. 35<br>3200 Emanuel Cleaver II Blvd<br>Kansas City, MO<br><b style='color:red;'></b><br>39.04105321900005, -94.54716372899998,  0 Ft.<br>EM29RA`).openPopup();                        
 
                        $(`Fire`._icon).addClass(`firemrkr`);
            var KCMOFS34 = new L.marker(new L.LatLng(39.18216645700005,-94.52198633599994),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/fire.png`, iconSize: [32, 34]}),
                        title:`marker_F17`}).addTo(fg).bindPopup(`KCMOFS34<br>KCMO Fire Station No. 34<br>4836 N Brighton Ave<br>Kansas City, MO<br><b style='color:red;'></b><br>39.18216645700005, -94.52198633599994,  0 Ft.<br>EM29RE`).openPopup();                        
 
                        $(`Fire`._icon).addClass(`firemrkr`);
            var KCMOFS33 = new L.marker(new L.LatLng(39.00341036400005,-94.49917701399994),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/fire.png`, iconSize: [32, 34]}),
                        title:`marker_F18`}).addTo(fg).bindPopup(`KCMOFS33<br>KCMO Fire Station No. 33<br>7504 E 67th St<br>Kansas City, MO<br><b style='color:red;'></b><br>39.00341036400005, -94.49917701399994,  0 Ft.<br>EM29SA`).openPopup();                        
 
                        $(`Fire`._icon).addClass(`firemrkr`);
            var KCMOFS16 = new L.marker(new L.LatLng(39.29508854300008,-94.68790113199998),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/fire.png`, iconSize: [32, 34]}),
                        title:`marker_F19`}).addTo(fg).bindPopup(`KCMOFS16<br>KCMO Fire Station No. 16<br>9205 NW 112th St<br>Kansas City, MO<br><b style='color:red;'></b><br>39.29508854300008, -94.68790113199998,  0 Ft.<br>EM29PH`).openPopup();                        
 
                        $(`Fire`._icon).addClass(`firemrkr`);
            var KCMOFS10 = new L.marker(new L.LatLng(39.10270070000007,-94.56220495299999),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/fire.png`, iconSize: [32, 34]}),
                        title:`marker_F20`}).addTo(fg).bindPopup(`KCMOFS10<br>KCMO Fire Station No. 10<br>1505 E 9th St<br>Kansas City, MO<br><b style='color:red;'></b><br>39.10270070000007, -94.56220495299999,  0 Ft.<br>EM29RC`).openPopup();                        
 
                        $(`Fire`._icon).addClass(`firemrkr`);
            var KCMOFS8 = new L.marker(new L.LatLng(39.09503169800007,-94.57740912999998),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/fire.png`, iconSize: [32, 34]}),
                        title:`marker_F21`}).addTo(fg).bindPopup(`KCMOFS8<br>KCMO Fire Station No. 8<br>1517 Locust St<br>Kansas City, MO<br><b style='color:red;'></b><br>39.09503169800007, -94.57740912999998,  0 Ft.<br>EM29RC`).openPopup();                        
 
                        $(`Fire`._icon).addClass(`firemrkr`);
            var KCMOFS7 = new L.marker(new L.LatLng(39.088027072000045,-94.59222542099997),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/fire.png`, iconSize: [32, 34]}),
                        title:`marker_F22`}).addTo(fg).bindPopup(`KCMOFS7<br>KCMO Fire Station No. 7<br>616 West Pennway St<br>Kansas City, MO<br><b style='color:red;'></b><br>39.088027072000045, -94.59222542099997,  0 Ft.<br>EM29QC`).openPopup();                        
 
                        $(`Fire`._icon).addClass(`firemrkr`);
            var KCMOFS6 = new L.marker(new L.LatLng(39.164872338000066,-94.54946718099995),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/fire.png`, iconSize: [32, 34]}),
                        title:`marker_F23`}).addTo(fg).bindPopup(`KCMOFS6<br>KCMO Fire Station No. 6<br>2600 NE Parvin Rd<br>Kansas City, MO<br><b style='color:red;'></b><br>39.164872338000066, -94.54946718099995,  0 Ft.<br>EM29RD`).openPopup();                        
 
                        $(`Fire`._icon).addClass(`firemrkr`);
            var KCMOFS5 = new L.marker(new L.LatLng(39.29465245500006,-94.72458748899999),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/fire.png`, iconSize: [32, 34]}),
                        title:`marker_F24`}).addTo(fg).bindPopup(`KCMOFS5<br>KCMO Fire Station No. 5<br>173 N Ottawa Ave<br>Kansas City, MO<br><b style='color:red;'></b><br>39.29465245500006, -94.72458748899999,  0 Ft.<br>EM29PH`).openPopup();                        
 
                        $(`Fire`._icon).addClass(`firemrkr`);
            var KCMOFS4 = new L.marker(new L.LatLng(39.21082648400005,-94.62698133999999),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/fire.png`, iconSize: [32, 34]}),
                        title:`marker_F25`}).addTo(fg).bindPopup(`KCMOFS4<br>KCMO Fire Station No. 4<br>4000 NW 64th St<br>Kansas City, MO<br><b style='color:red;'></b><br>39.21082648400005, -94.62698133999999,  0 Ft.<br>EM29QF`).openPopup();                        
 
                        $(`Fire`._icon).addClass(`firemrkr`);
            var KCMOFS3 = new L.marker(new L.LatLng(39.29502746500003,-94.57483520999995),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/fire.png`, iconSize: [32, 34]}),
                        title:`marker_F26`}).addTo(fg).bindPopup(`KCMOFS3<br>KCMO Fire Station No. 3<br>11101 N Oak St<br>Kansas City, MO<br><b style='color:red;'></b><br>39.29502746500003, -94.57483520999995,  0 Ft.<br>EM29RH`).openPopup();                        
 
                        $(`Fire`._icon).addClass(`firemrkr`);
            var KCMOFS17 = new L.marker(new L.LatLng(39.06448674100005,-94.56659040899996),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/fire.png`, iconSize: [32, 34]}),
                        title:`marker_F27`}).addTo(fg).bindPopup(`KCMOFS17<br>KCMO Fire Station No. 17<br>3401 Paseo<br>Kansas City, MO<br><b style='color:red;'></b><br>39.06448674100005, -94.56659040899996,  0 Ft.<br>EM29RB`).openPopup();                        
 
                        $(`Fire`._icon).addClass(`firemrkr`);
            var KCMOFS18 = new L.marker(new L.LatLng(39.068426627000065,-94.54306673199994),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/fire.png`, iconSize: [32, 34]}),
                        title:`marker_F28`}).addTo(fg).bindPopup(`KCMOFS18<br>KCMO Fire Station No. 18<br>3211 Indiana Ave<br>Kansas City, MO<br><b style='color:red;'></b><br>39.068426627000065, -94.54306673199994,  0 Ft.<br>EM29RB`).openPopup();                        
 
                        $(`Fire`._icon).addClass(`firemrkr`);
            var KCMOFS30 = new L.marker(new L.LatLng(38.98954598500006,-94.55777761299998),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/fire.png`, iconSize: [32, 34]}),
                        title:`marker_F29`}).addTo(fg).bindPopup(`KCMOFS30<br>KCMO Fire Station No. 30<br>7534 Prospect Ave<br>Kansas City, MO<br><b style='color:red;'></b><br>38.98954598500006, -94.55777761299998,  0 Ft.<br>EM28RX`).openPopup();                        
 
                        $(`Fire`._icon).addClass(`firemrkr`);
            var KCMOFS29 = new L.marker(new L.LatLng(39.01353614300007,-94.56910049699997),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/fire.png`, iconSize: [32, 34]}),
                        title:`marker_F30`}).addTo(fg).bindPopup(`KCMOFS29<br>KCMO Fire Station No. 29<br>1414 E 63rd St<br>Kansas City, MO<br><b style='color:red;'></b><br>39.01353614300007, -94.56910049699997,  0 Ft.<br>EM29RA`).openPopup();                        
 
                        $(`Fire`._icon).addClass(`firemrkr`);
            var KCMOFS28 = new L.marker(new L.LatLng(38.92612585100005,-94.57996235599995),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/fire.png`, iconSize: [32, 34]}),
                        title:`marker_F31`}).addTo(fg).bindPopup(`KCMOFS28<br>KCMO Fire Station No. 28<br>930 Red Bridge Rd<br>Kansas City, MO<br><b style='color:red;'></b><br>38.92612585100005, -94.57996235599995,  0 Ft.<br>EM28RW`).openPopup();                        
 
                        $(`Fire`._icon).addClass(`firemrkr`);
            var KCMOFS27 = new L.marker(new L.LatLng(39.09423963200004,-94.50519189199997),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/fire.png`, iconSize: [32, 34]}),
                        title:`marker_F32`}).addTo(fg).bindPopup(`KCMOFS27<br>KCMO Fire Station No. 27<br>6600 E Truman Rd<br>Kansas City, MO<br><b style='color:red;'></b><br>39.09423963200004, -94.50519189199997,  0 Ft.<br>EM29RC`).openPopup();                        
 
                        $(`Fire`._icon).addClass(`firemrkr`);
            var KCMOFS25 = new L.marker(new L.LatLng(39.10791790600007,-94.57838314599996),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/fire.png`, iconSize: [32, 34]}),
                        title:`marker_F33`}).addTo(fg).bindPopup(`KCMOFS25<br>KCMO Fire Station No. 25<br>401 E Missouri Ave<br>Kansas City, MO<br><b style='color:red;'></b><br>39.10791790600007, -94.57838314599996,  0 Ft.<br>EM29RC`).openPopup();                        
 
                        $(`Fire`._icon).addClass(`firemrkr`);
            var KCMOFS24 = new L.marker(new L.LatLng(39.08534478900003,-94.51940024199996),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/fire.png`, iconSize: [32, 34]}),
                        title:`marker_F34`}).addTo(fg).bindPopup(`KCMOFS24<br>KCMO Fire Station No. 24<br>2039 Hardesty Ave<br>Kansas City, MO<br><b style='color:red;'></b><br>39.08534478900003, -94.51940024199996,  0 Ft.<br>EM29RC`).openPopup();                        
 
                        $(`Fire`._icon).addClass(`firemrkr`);
            var KCMOFS23 = new L.marker(new L.LatLng(39.10519819800004,-94.52673633999996),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/fire.png`, iconSize: [32, 34]}),
                        title:`marker_F35`}).addTo(fg).bindPopup(`KCMOFS23<br>KCMO Fire Station No. 23<br>4777 Independence Ave<br>Kansas City, MO<br><b style='color:red;'></b><br>39.10519819800004, -94.52673633999996,  0 Ft.<br>EM29RC`).openPopup();                        
 
                        $(`Fire`._icon).addClass(`firemrkr`);
            var KCMOFS19 = new L.marker(new L.LatLng(39.04970557900003,-94.59317453799997),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/fire.png`, iconSize: [32, 34]}),
                        title:`marker_F36`}).addTo(fg).bindPopup(`KCMOFS19<br>KCMO Fire Station No. 19<br>550 W 43rd St<br>Kansas City, MO<br><b style='color:red;'></b><br>39.04970557900003, -94.59317453799997,  0 Ft.<br>EM29QB`).openPopup();                        
 
                        $(`Fire`._icon).addClass(`firemrkr`);
            var KCMOFS1 = new L.marker(new L.LatLng(38.84544806200006,-94.55557100699997),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/fire.png`, iconSize: [32, 34]}),
                        title:`marker_F37`}).addTo(fg).bindPopup(`KCMOFS1<br>KCMO Fire Station No. 1<br>15480 Hangar Rd<br>Kansas City, MO<br><b style='color:red;'></b><br>38.84544806200006, -94.55557100699997,  0 Ft.<br>EM28RU`).openPopup();                        
 
                        $(`Fire`._icon).addClass(`firemrkr`);
            
            var GNSVFS1 = new L.marker(new L.LatLng(34.290941,-83.826461),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/fire.png`, iconSize: [32, 34]}),
                        title:`marker_F78`}).addTo(fg).bindPopup(`GNSVFS1<br>Gainesville Fire Station 1<br>725 Pine St, <br>Gainesville, GA 30501<br><b style='color:red;'></b><br>34.290941, -83.826461,  0 Ft.<br>EM84CG`).openPopup();                        
 
                        $(`Fire`._icon).addClass(`firemrkr`);
            var TFESS12 = new L.marker(new L.LatLng(28.589587,-80.831269),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/fire.png`, iconSize: [32, 34]}),
                        title:`marker_F79`}).addTo(fg).bindPopup(`TFESS12<br>Titusville Fire & Emergency Services Station 12<br>2400 Harrison Street<br>Titusville, FL 32780<br><b style='color:red;'></b><br>28.589587, -80.831269,  0 Ft.<br>EL98OO`).openPopup();                        
 
                        $(`Fire`._icon).addClass(`firemrkr`);
            var BRVRCOFR29 = new L.marker(new L.LatLng(28.431189,-80.805377),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/fire.png`, iconSize: [32, 34]}),
                        title:`marker_F80`}).addTo(fg).bindPopup(`BRVRCOFR29<br>Brevard County Fire Rescue Station 29<br>3950 Canaveral Groves Blvd<br>Cocoa, FL 32926<br><b style='color:red;'></b><br>28.431189, -80.805377,  0 Ft.<br>EL98OK`).openPopup();                        
 
                        $(`Fire`._icon).addClass(`firemrkr`);
            var RVRSDEFD = new L.marker(new L.LatLng(39.175757,-94.616012),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/fire.png`, iconSize: [32, 34]}),
                        title:`marker_F81`}).addTo(fg).bindPopup(`RVRSDEFD<br>Riverside, MO City Fire Department<br>2990 NW Vivion Rd. <br>Riverside, MO 64150<br><b style='color:red;'></b><br>39.175757, -94.616012,  0 Ft.<br>EM29QE`).openPopup();                        
 
                        $(`Fire`._icon).addClass(`firemrkr`);
                        var STJOHN = new L.marker(new L.LatLng(39.2822,-94.9058),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/firstaid.png`, iconSize: [32, 34]}),
                        title:`marker_H1`}).addTo(fg).bindPopup(`STJOHN<br>Saint John Hospital<br><br><br><b style='color:red;'></b><br>39.2822, -94.9058,  0 Ft.<br>EM29NG`).openPopup();                        
 
                        $(`Hospital`._icon).addClass(`hosmrkr`);
            var STJOMC = new L.marker(new L.LatLng(38.9362,-94.6037),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/firstaid.png`, iconSize: [32, 34]}),
                        title:`marker_H2`}).addTo(fg).bindPopup(`STJOMC<br>Saint Joseph Medical Center<br>1000 Carondelet Dr<br>Kansas City, MO 64114-4865<br><b style='color:red;'></b><br>38.9362, -94.6037,  0 Ft.<br>EM28QW`).openPopup();                        
 
                        $(`Hospital`._icon).addClass(`hosmrkr`);
            var STLEAS = new L.marker(new L.LatLng(38.9415,-94.3813),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/firstaid.png`, iconSize: [32, 34]}),
                        title:`marker_H3`}).addTo(fg).bindPopup(`STLEAS<br>Saint Lukes East-Lee's Summit<br>100 N.E. Saint Luke's Blvd<br>Lees Summit, MO 64086-5998<br><b style='color:red;'></b><br>38.9415, -94.3813,  0 Ft.<br>EM28TW`).openPopup();                        
 
                        $(`Hospital`._icon).addClass(`hosmrkr`);
            var STLPLZ = new L.marker(new L.LatLng(39.477,-94.5895),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/firstaid.png`, iconSize: [32, 34]}),
                        title:`marker_H4`}).addTo(fg).bindPopup(`STLPLZ<br>Saint Lukes Hospital Plaza<br>4401 Wornall Road<br>Kansas City, MO 64111<br><b style='color:red;'></b><br>39.477, -94.5895,  0 Ft.<br>EM29QL`).openPopup();                        
 
                        $(`Hospital`._icon).addClass(`hosmrkr`);
            var RMCBKS = new L.marker(new L.LatLng(39.8,-94.5778),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/firstaid.png`, iconSize: [32, 34]}),
                        title:`marker_H5`}).addTo(fg).bindPopup(`RMCBKS<br>Research Medical Center- Brookside<br>6601 Rockhill Rd<br>Kansas City, MO 64131-2767<br><b style='color:red;'></b><br>39.8, -94.5778,  0 Ft.<br>EM29RT`).openPopup();                        
 
                        $(`Hospital`._icon).addClass(`hosmrkr`);
            var RESRCH = new L.marker(new L.LatLng(39.167,-94.6682),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/firstaid.png`, iconSize: [32, 34]}),
                        title:`marker_H6`}).addTo(fg).bindPopup(`RESRCH<br>Research Medical Center<br>2316 E. Meyer Blvd<br>Kansas City, MO 64132<br><b style='color:red;'></b><br>39.167, -94.6682,  0 Ft.<br>EM29PE`).openPopup();                        
 
                        $(`Hospital`._icon).addClass(`hosmrkr`);
            var RAYCO = new L.marker(new L.LatLng(39.2587,-93.9543),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/firstaid.png`, iconSize: [32, 34]}),
                        title:`marker_H7`}).addTo(fg).bindPopup(`RAYCO<br>RAY COUNTY HOSPITAL<br>904 WOLLARD BLVD<br>RICHMOND, MO 64085<br><b style='color:red;'></b><br>39.2587, -93.9543,  0 Ft.<br>EM39AG`).openPopup();                        
 
                        $(`Hospital`._icon).addClass(`hosmrkr`);
            var PMC = new L.marker(new L.LatLng(39.127,-94.7865),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/firstaid.png`, iconSize: [32, 34]}),
                        title:`marker_H8`}).addTo(fg).bindPopup(`PMC<br>Providence Medical Center<br>8929 Parallel Parkway<br>Kansas City, KS 66212-1689<br><b style='color:red;'></b><br>39.127, -94.7865,  0 Ft.<br>EM29OD`).openPopup();                        
 
                        $(`Hospital`._icon).addClass(`hosmrkr`);
            var OPR = new L.marker(new L.LatLng(39.9372,-94.7262),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/firstaid.png`, iconSize: [32, 34]}),
                        title:`marker_H9`}).addTo(fg).bindPopup(`OPR<br>Overland Park RMC<br>10500 QuivIra Rd<br>Overland Park, KS 66215<br><b style='color:red;'></b><br>39.9372, -94.7262,  0 Ft.<br>EM29PW`).openPopup();                        
 
                        $(`Hospital`._icon).addClass(`hosmrkr`);
            var OMC = new L.marker(new L.LatLng(38.853,-94.8235),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/firstaid.png`, iconSize: [32, 34]}),
                        title:`marker_H10`}).addTo(fg).bindPopup(`OMC<br>Olathe Medical Center, Inc.<br>20333 W 151 st<br>Olathe KS 66061<br><b style='color:red;'></b><br>38.853, -94.8235,  0 Ft.<br>EM28OU`).openPopup();                        
 
                        $(`Hospital`._icon).addClass(`hosmrkr`);
            var NORKC = new L.marker(new L.LatLng(39.1495,-94.5513),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/firstaid.png`, iconSize: [32, 34]}),
                        title:`marker_H11`}).addTo(fg).bindPopup(`NORKC<br>North Kansas City Hospital<br>2800 Clay Edwards Dr<br>North Kansas City, MO 64116<br><b style='color:red;'></b><br>39.1495, -94.5513,  0 Ft.<br>EM29RD`).openPopup();                        
 
                        $(`Hospital`._icon).addClass(`hosmrkr`);
            var MENORA = new L.marker(new L.LatLng(38.9107,-94.6512),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/firstaid.png`, iconSize: [32, 34]}),
                        title:`marker_H12`}).addTo(fg).bindPopup(`MENORA<br>Menorah Medical Center<br>5721 west 119th st<br>Overland Park, KS 66209<br><b style='color:red;'></b><br>38.9107, -94.6512,  0 Ft.<br>EM28QV`).openPopup();                        
 
                        $(`Hospital`._icon).addClass(`hosmrkr`);
            var LMH = new L.marker(new L.LatLng(38.979225,-95.248259),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/firstaid.png`, iconSize: [32, 34]}),
                        title:`marker_H13`}).addTo(fg).bindPopup(`LMH<br>Lawrence Memorial Hospital<br>"325 Maine Street"<br> "Lawrence, Kansas 66044"<br><b style='color:red;'>ACT staffs this location in emergencies </b><br>38.979225, -95.248259,  0 Ft.<br>EM28JX`).openPopup();                        
 
                        $(`Hospital`._icon).addClass(`hosmrkr`);
            var STLSMI = new L.marker(new L.LatLng(39.3758,-94.5807),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/firstaid.png`, iconSize: [32, 34]}),
                        title:`marker_H14`}).addTo(fg).bindPopup(`STLSMI<br>Saint Lukes Smithville Campus<br>601 south 169 Highway<br>Smithville, MO 64089<br><b style='color:red;'></b><br>39.3758, -94.5807,  0 Ft.<br>EM29RJ`).openPopup();                        
 
                        $(`Hospital`._icon).addClass(`hosmrkr`);
           
            var PETTIS = new L.marker(new L.LatLng(38.6973,-93.2163),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/firstaid.png`, iconSize: [32, 34]}),
                        title:`marker_H20`}).addTo(fg).bindPopup(`PETTIS<br>PETTIS Co Health Dept<br>911 E 16th st<br>SEDALIA, MO 65301<br><b style='color:red;'></b><br>38.6973, -93.2163,  0 Ft.<br>EM38JQ`).openPopup();                        
 
                        $(`Hospital`._icon).addClass(`hosmrkr`);
            var WEMO = new L.marker(new L.LatLng(38.7667,-93.7217),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/firstaid.png`, iconSize: [32, 34]}),
                        title:`marker_H21`}).addTo(fg).bindPopup(`WEMO<br>WESTERN MISSOURI MEDICAL CENTER<br>403 BURKARTH RD<br>WARRENSBURG, MO 64093<br><b style='color:red;'></b><br>38.7667, -93.7217,  0 Ft.<br>EM38DS`).openPopup();                        
 
                        $(`Hospital`._icon).addClass(`hosmrkr`);
       
            var TRUHH = new L.marker(new L.LatLng(39.853,-94.5737),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/firstaid.png`, iconSize: [32, 34]}),
                        title:`marker_H23`}).addTo(fg).bindPopup(`TRUHH<br>Truman Medical Center-Hospital Hill<br>2055 Holmes<br>Kansas City, MO 64108-2621<br><b style='color:red;'></b><br>39.853, -94.5737,  0 Ft.<br>EM29RU`).openPopup();                        
 
                        $(`Hospital`._icon).addClass(`hosmrkr`);
            var TRLKWD = new L.marker(new L.LatLng(38.9745,-94.3915),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/firstaid.png`, iconSize: [32, 34]}),
                        title:`marker_H24`}).addTo(fg).bindPopup(`TRLKWD<br>Truman Lakewood<br><br><br><b style='color:red;'></b><br>38.9745, -94.3915,  0 Ft.<br>EM28TX`).openPopup();                        
 
                        $(`Hospital`._icon).addClass(`hosmrkr`);
            var STM = new L.marker(new L.LatLng(39.263,-94.2627),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/firstaid.png`, iconSize: [32, 34]}),
                        title:`marker_H25`}).addTo(fg).bindPopup(`STM<br>Saint Marys Medical Center<br>201 NW R D Mize Rd<br>Blue Springs, MO 64014<br><b style='color:red;'></b><br>39.263, -94.2627,  0 Ft.<br>EM29UG`).openPopup();                        
 
                        $(`Hospital`._icon).addClass(`hosmrkr`);
            var STLUSO = new L.marker(new L.LatLng(38.904,-94.6682),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/firstaid.png`, iconSize: [32, 34]}),
                        title:`marker_H26`}).addTo(fg).bindPopup(`STLUSO<br>Saint Lukes South Hospital<br>12300 Metcalf Ave<br>Overland Park, KS 66213<br><b style='color:red;'></b><br>38.904, -94.6682,  0 Ft.<br>EM28PV`).openPopup();                        
 
                        $(`Hospital`._icon).addClass(`hosmrkr`);
            var STLUBR = new L.marker(new L.LatLng(39.2482,-94.6487),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/firstaid.png`, iconSize: [32, 34]}),
                        title:`marker_H27`}).addTo(fg).bindPopup(`STLUBR<br>Saint Lukes Barry Road Campus<br>5830 Northwest Barry Rd<br>Kansas City, MO 64154-2778<br><b style='color:red;'></b><br>39.2482, -94.6487,  0 Ft.<br>EM29QF`).openPopup();                        
 
                        $(`Hospital`._icon).addClass(`hosmrkr`);
            var LSMED = new L.marker(new L.LatLng(38.9035,-94.3327),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/firstaid.png`, iconSize: [32, 34]}),
                        title:`marker_H28`}).addTo(fg).bindPopup(`LSMED<br>Lee's Summit Medical Center<br>2100 SE Blue Pkwy<br>Lee's Summit, MO 64081-1497<br><b style='color:red;'></b><br>38.9035, -94.3327,  0 Ft.<br>EM28UV`).openPopup();                        
 
                        $(`Hospital`._icon).addClass(`hosmrkr`);
            var LRHC = new L.marker(new L.LatLng(39.1893,-93.8768),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/firstaid.png`, iconSize: [32, 34]}),
                        title:`marker_H29`}).addTo(fg).bindPopup(`LRHC<br>LAFAYETTE REGIONAL HEALTH CENTER<br>1500 STATE<br>LEXINGTON, MO 64067<br><b style='color:red;'></b><br>39.1893, -93.8768,  0 Ft.<br>EM39BE`).openPopup();                        
 
                        $(`Hospital`._icon).addClass(`hosmrkr`);
            var LRHC = new L.marker(new L.LatLng(39.1732,-93.8748),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/firstaid.png`, iconSize: [32, 34]}),
                        title:`marker_H30`}).addTo(fg).bindPopup(`LRHC<br>LAFAYETTE CO HEALTH DEPT<br>547 South 13 Highway<br>Lexington, MO 64067<br><b style='color:red;'></b><br>39.1732, -93.8748,  0 Ft.<br>EM39BE`).openPopup();                        
 
                        $(`Hospital`._icon).addClass(`hosmrkr`);
            var CMHS = new L.marker(new L.LatLng(38.9302,-94.6613),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/firstaid.png`, iconSize: [32, 34]}),
                        title:`marker_H31`}).addTo(fg).bindPopup(`CMHS<br>Childrens Mercy Hospital South<br>5808 W 110th<br>Leawood, KS 66211<br><b style='color:red;'></b><br>38.9302, -94.6613,  0 Ft.<br>EM28QW`).openPopup();                        
 
                        $(`Hospital`._icon).addClass(`hosmrkr`);
            var W0CPT = new L.marker(new L.LatLng(39.5,-94.3483),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/firstaid.png`, iconSize: [32, 34]}),
                        title:`marker_H32`}).addTo(fg).bindPopup(`W0CPT<br>Centerpoint Medical Center<br>19600 East 39th St<br>Independence Mo 64057<br><b style='color:red;'></b><br>39.5, -94.3483,  0 Ft.<br>EM29TL`).openPopup();                        
 
                        $(`Hospital`._icon).addClass(`hosmrkr`);
            var CMH = new L.marker(new L.LatLng(39.852,-943.74),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/firstaid.png`, iconSize: [32, 34]}),
                        title:`marker_H33`}).addTo(fg).bindPopup(`CMH<br>Childrens Mercy Hospital<br>2401 Gillham Road<br>Kansas City, MO 64108<br><b style='color:red;'></b><br>39.852, -943.74,  0 Ft.<br>M9U`).openPopup();                        
 
                        $(`Hospital`._icon).addClass(`hosmrkr`);
            var SMMC = new L.marker(new L.LatLng(38.9955,-94.6908),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/firstaid.png`, iconSize: [32, 34]}),
                        title:`marker_H34`}).addTo(fg).bindPopup(`SMMC<br>Shawnee Mission Medical Center<br>9100 W. 74th St<br>Shawnee Mission, KS 66204-4004<br><b style='color:red;'></b><br>38.9955, -94.6908,  0 Ft.<br>EM28PX`).openPopup();                        
 
                        $(`Hospital`._icon).addClass(`hosmrkr`);
            var CARROL = new L.marker(new L.LatLng(39.3762,-93.494),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/firstaid.png`, iconSize: [32, 34]}),
                        title:`marker_H35`}).addTo(fg).bindPopup(`CARROL<br>CARROLL COUNTY HOSPITAL<br>1502 N JEFFERSON<br>CAROLLTON, MO 64633<br><b style='color:red;'></b><br>39.3762, -93.494,  0 Ft.<br>EM39GJ`).openPopup();                        
 
                        $(`Hospital`._icon).addClass(`hosmrkr`);
            var BRMC = new L.marker(new L.LatLng(38.8158,-94.5033),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/firstaid.png`, iconSize: [32, 34]}),
                        title:`marker_H36`}).addTo(fg).bindPopup(`BRMC<br>Research Belton Hospital<br>17065 S 71 Hwy<br>Belton, MO 64012<br><b style='color:red;'></b><br>38.8158, -94.5033,  0 Ft.<br>EM28RT`).openPopup();                        
 
                        $(`Hospital`._icon).addClass(`hosmrkr`);
            var CASS = new L.marker(new L.LatLng(38.6645,-94.3725),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/firstaid.png`, iconSize: [32, 34]}),
                        title:`marker_H37`}).addTo(fg).bindPopup(`CASS<br>Cass Medical Center<br>1800 East Mechanic Street<br>Harrisonville, MO 64701-2017<br><b style='color:red;'></b><br>38.6645, -94.3725,  0 Ft.<br>EM28TP`).openPopup();                        
 
                        $(`Hospital`._icon).addClass(`hosmrkr`);
            var BOTHWL = new L.marker(new L.LatLng(38.6993,-93.2208),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/firstaid.png`, iconSize: [32, 34]}),
                        title:`marker_H38`}).addTo(fg).bindPopup(`BOTHWL<br>BOTHWELL REGIONAL HEALTH CENTER<br>601 E 14TH ST<br>SEDALIA, MO 65301<br><b style='color:red;'></b><br>38.6993, -93.2208,  0 Ft.<br>EM38JQ`).openPopup();                        
 
                        $(`Hospital`._icon).addClass(`hosmrkr`);
            var BATES = new L.marker(new L.LatLng(38.2498,-94.3432),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/firstaid.png`, iconSize: [32, 34]}),
                        title:`marker_H39`}).addTo(fg).bindPopup(`BATES<br>BATES COUNTY HOSPITAL<br>615 West Nursery St<br>Butler, Mo. 64730<br><b style='color:red;'></b><br>38.2498, -94.3432,  0 Ft.<br>EM28TF`).openPopup();                        
 
                        $(`Hospital`._icon).addClass(`hosmrkr`);
            var CUSHNG = new L.marker(new L.LatLng(39.3072,-94.9185),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/firstaid.png`, iconSize: [32, 34]}),
                        title:`marker_H40`}).addTo(fg).bindPopup(`CUSHNG<br>Cushing Memorial Hospital<br>711 Marshall St<br>Leavenworth, KS 66048<br><b style='color:red;'></b><br>39.3072, -94.9185,  0 Ft.<br>EM29MH`).openPopup();                        
 
                        $(`Hospital`._icon).addClass(`hosmrkr`);
            var DCEC = new L.marker(new L.LatLng(39.862,-94.576),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/firstaid.png`, iconSize: [32, 34]}),
                        title:`marker_H41`}).addTo(fg).bindPopup(`DCEC<br>Metro Regional Healthcare Coord. Ctr<br>610 E 22nd St.<br>Kansas City, MO<br><b style='color:red;'></b><br>39.862, -94.576,  0 Ft.<br>EM29RU`).openPopup();                        
 
                        $(`Hospital`._icon).addClass(`hosmrkr`);
            var KU0MED = new L.marker(new L.LatLng(39.557,-94.6102),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/firstaid.png`, iconSize: [32, 34]}),
                        title:`marker_H42`}).addTo(fg).bindPopup(`KU0MED<br>University of Kansas Hospital<br>3901 Rainbow Blvd Mail Stop 3004<br>Kansas City, KS 66160-7200<br><b style='color:red;'></b><br>39.557, -94.6102,  0 Ft.<br>EM29QN`).openPopup();                        
 
                        $(`Hospital`._icon).addClass(`hosmrkr`);
            var KCVA = new L.marker(new L.LatLng(39.672,-94.5282),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/firstaid.png`, iconSize: [32, 34]}),
                        title:`marker_H43`}).addTo(fg).bindPopup(`KCVA<br>Veterans Affairs Medical Center<br>4801 E Linwood Blvd<br>Kansas City, MO 64128-2295<br><b style='color:red;'></b><br>39.672, -94.5282,  0 Ft.<br>EM29RQ`).openPopup();                        
 
                        $(`Hospital`._icon).addClass(`hosmrkr`);
            var KC0CBC = new L.marker(new L.LatLng(39.537,-94.5865),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/firstaid.png`, iconSize: [32, 34]}),
                        title:`marker_H44`}).addTo(fg).bindPopup(`KC0CBC<br>Kansas City Blood Bank<br>4240 Main St<br>KC MO<br><b style='color:red;'></b><br>39.537, -94.5865,  0 Ft.<br>EM29QM`).openPopup();                        
 
                        $(`Hospital`._icon).addClass(`hosmrkr`);
            var LIBRTY = new L.marker(new L.LatLng(39.274,-94.4233),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/firstaid.png`, iconSize: [32, 34]}),
                        title:`marker_H45`}).addTo(fg).bindPopup(`LIBRTY<br>Liberty Hospital<br>2525 Glen Hendren<br>Liberty, MO 64068<br><b style='color:red;'></b><br>39.274, -94.4233,  0 Ft.<br>EM29SG`).openPopup();                        
 
                        $(`Hospital`._icon).addClass(`hosmrkr`);
            var I70 = new L.marker(new L.LatLng(38.9783,-93.4162),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/firstaid.png`, iconSize: [32, 34]}),
                        title:`marker_H46`}).addTo(fg).bindPopup(`I70<br>I-70 MEDICAL CENTER<br>105 HOSPITAL DR<br>SWEET SPRINGS, MO 65351<br><b style='color:red;'></b><br>38.9783, -93.4162,  0 Ft.<br>EM38HX`).openPopup();                        
 
                        $(`Hospital`._icon).addClass(`hosmrkr`);
            var GVMH = new L.marker(new L.LatLng(38.3892,-93.7702),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/firstaid.png`, iconSize: [32, 34]}),
                        title:`marker_H47`}).addTo(fg).bindPopup(`GVMH<br>GOLDEN VALLEY MEMORIAL HOSPITAL<br>1600 NORTH 2ND ST<br>CLINTON, MO 64735<br><b style='color:red;'></b><br>38.3892, -93.7702,  0 Ft.<br>EM38CJ`).openPopup();                        
 
                        $(`Hospital`._icon).addClass(`hosmrkr`);
            var FITZ = new L.marker(new L.LatLng(39.928,-93.2143),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/firstaid.png`, iconSize: [32, 34]}),
                        title:`marker_H48`}).addTo(fg).bindPopup(`FITZ<br>FITZGIBBON HOSPITAL<br>2305 S HWY 65<br>MARSHALL, MO 65340<br><b style='color:red;'></b><br>39.928, -93.2143,  0 Ft.<br>EM39JW`).openPopup();                        
 
                        $(`Hospital`._icon).addClass(`hosmrkr`);
            var EXSPR = new L.marker(new L.LatLng(39.3568,-94.237),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/firstaid.png`, iconSize: [32, 34]}),
                        title:`marker_H49`}).addTo(fg).bindPopup(`EXSPR<br>Excelsior Springs Medical Center<br>1700 Rainbow Boulevard<br>Excelsior Springs, MO 64024-1190<br><b style='color:red;'></b><br>39.3568, -94.237,  0 Ft.<br>EM29VI`).openPopup();                        
 
                        $(`Hospital`._icon).addClass(`hosmrkr`);
            var KINDRD = new L.marker(new L.LatLng(38.968,-94.5745),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/firstaid.png`, iconSize: [32, 34]}),
                        title:`marker_H50`}).addTo(fg).bindPopup(`KINDRD<br>Kindred Hospital Kansas City<br>8701 Troost Ave<br>Kansas City, MO 64131-2767<br><b style='color:red;'></b><br>38.968, -94.5745,  0 Ft.<br>EM28RX`).openPopup();                        
 
                        $(`Hospital`._icon).addClass(`hosmrkr`);
                        var KCRHCV = new L.marker(new L.LatLng(38.8648222,-94.7789944),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `markers/repeater.png`, iconSize: [32, 34]}),
                        title:`marker_R1`}).addTo(fg).bindPopup(`KCRHCV<br>Kansas City Room Host, #28952<br>444.400MHz
<br>Olathe, KS<br><b style='color:red;'>Hosts the Kansas City Room #28952</b><br>38.8648222, -94.7789944,  0 Ft.<br>EM28OU`).openPopup();                        
 
                        $(`Repeater`._icon).addClass(`rptmrkr`);
            var KCRMED = new L.marker(new L.LatLng(39.0562778,-94.6095),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `markers/repeater.png`, iconSize: [32, 34]}),
                        title:`marker_R2`}).addTo(fg).bindPopup(`KCRMED<br>Kansas City Room, Ku0MED<br>KU Medical Center 442.325+MHz
<br>Kansas City, KS<br><b style='color:red;'>Jerry Dixon KCØKW</b><br>39.0562778, -94.6095,  0 Ft.<br>EM29QB`).openPopup();                        
 
                        $(`Repeater`._icon).addClass(`rptmrkr`);
            var SAXRPTR = new L.marker(new L.LatLng(39.3641,-93.48071),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `markers/repeater.png`, iconSize: [32, 34]}),
                        title:`marker_R3`}).addTo(fg).bindPopup(`SAXRPTR<br>N0SAX<br>710 Harvest Hills Dr<br>Carroll, MO 64633<br><b style='color:red;'></b><br>39.3641, -93.48071,  0 Ft.<br>EM39GI`).openPopup();                        
 
                        $(`Repeater`._icon).addClass(`rptmrkr`);
            var KCRQFJ = new L.marker(new L.LatLng(39.2731222,-94.6629583),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `markers/repeater.png`, iconSize: [32, 34]}),
                        title:`marker_R4`}).addTo(fg).bindPopup(`KCRQFJ<br>Kansas City Room, WA0QFJ<br>Tiffany Springs 444.550+MHz
<br>Kansas City, MO<br><b style='color:red;'>PCARG Club Repeater</b><br>39.2731222, -94.6629583,  0 Ft.<br>EM29QG`).openPopup();                        
 
                        $(`Repeater`._icon).addClass(`rptmrkr`);
            var KCRHAM3 = new L.marker(new L.LatLng(39.0922333,-94.9453528),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `markers/repeater.png`, iconSize: [32, 34]}),
                        title:`marker_R5`}).addTo(fg).bindPopup(`KCRHAM3<br>Kansas City Room, K0HAM<br>Basehor 145.390-MHz
<br>Basehor, KS<br><b style='color:red;'>Jerry Dixon KCØKW</b><br>39.0922333, -94.9453528,  0 Ft.<br>EM29MC`).openPopup();                        
 
                        $(`Repeater`._icon).addClass(`rptmrkr`);
            var DCARC = new L.marker(new L.LatLng(38.896175,-95.174838),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `markers/repeater.png`, iconSize: [32, 34]}),
                        title:`marker_R6`}).addTo(fg).bindPopup(`DCARC<br>Douglas County Amateur Radio Club<br><br>"Lawrence, KS"<br><b style='color:red;'>146.76- 88.5 Narrow band 2.5KHz UFN</b><br>38.896175, -95.174838,  0 Ft.<br>EM28JV`).openPopup();                        
 
                        $(`Repeater`._icon).addClass(`rptmrkr`);
            var KCRHAM2 = new L.marker(new L.LatLng(38.9084722,-94.4548056),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `markers/repeater.png`, iconSize: [32, 34]}),
                        title:`marker_R7`}).addTo(fg).bindPopup(`KCRHAM2<br>Kansas City Room, K0HAM<br>Longview MCC 147.315+MHz
<br>Lee's Summit, MO<br><b style='color:red;'>Jerry Dixon KCØKW</b><br>38.9084722, -94.4548056,  0 Ft.<br>EM28SV`).openPopup();                        
 
                        $(`Repeater`._icon).addClass(`rptmrkr`);
            var KCRROO = new L.marker(new L.LatLng(39.2819722,-94.9058889),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `markers/repeater.png`, iconSize: [32, 34]}),
                        title:`marker_R8`}).addTo(fg).bindPopup(`KCRROO<br>Kansas City Room, W0ROO<br>Leavenworth 444.800+MHz
<br>Leavenworth, KS<br><b style='color:red;'>Leavenworth club repeater</b><br>39.2819722, -94.9058889,  0 Ft.<br>EM29NG`).openPopup();                        
 
                        $(`Repeater`._icon).addClass(`rptmrkr`);
            var KCRWW = new L.marker(new L.LatLng(39.0465806,-94.5874444),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `markers/repeater.png`, iconSize: [32, 34]}),
                        title:`marker_R9`}).addTo(fg).bindPopup(`KCRWW<br>Kansas City Room, N0WW<br>The Plaza 443.275+MHz
<br>Kansas City, MO<br><b style='color:red;'>Keith Little NØWW</b><br>39.0465806, -94.5874444,  0 Ft.<br>EM29QB`).openPopup();                        
 
                        $(`Repeater`._icon).addClass(`rptmrkr`);
            var KCRKW2 = new L.marker(new L.LatLng(38.5861611,-94.6204139),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `markers/repeater.png`, iconSize: [32, 34]}),
                        title:`marker_R10`}).addTo(fg).bindPopup(`KCRKW2<br>Kansas City Room, K0HAM<br>145.410-MHz
<br>Louisburg, KS<br><b style='color:red;'>Jerry Dixon KCØKW</b><br>38.5861611, -94.6204139,  0 Ft.<br>EM28QO`).openPopup();                        
 
                        $(`Repeater`._icon).addClass(`rptmrkr`);
            var KCRJCRAC2 = new L.marker(new L.LatLng(38.9252611,-94.6553389),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `markers/repeater.png`, iconSize: [32, 34]}),
                        title:`marker_R11`}).addTo(fg).bindPopup(`KCRJCRAC2<br>Kansas City Room, W0ERH<br>443.725+MHz
<br>Black & Veatch, KS<br><b style='color:red;'>JCRAC club repeater</b><br>38.9252611, -94.6553389,  0 Ft.<br>EM28QW`).openPopup();                        
 
                        $(`Repeater`._icon).addClass(`rptmrkr`);
            var KCRJCRAC1 = new L.marker(new L.LatLng(39.0106639,-94.7212972),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `markers/repeater.png`, iconSize: [32, 34]}),
                        title:`marker_R12`}).addTo(fg).bindPopup(`KCRJCRAC1<br>Kansas City Room, W0ERH<br>442.600+MHz
<br>Shawnee, KS<br><b style='color:red;'>JCRAC club repeater</b><br>39.0106639, -94.7212972,  0 Ft.<br>EM29PA`).openPopup();                        
 
                        $(`Repeater`._icon).addClass(`rptmrkr`);
            var KCRKW1 = new L.marker(new L.LatLng(38.9879167,-94.67075),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `markers/repeater.png`, iconSize: [32, 34]}),
                        title:`marker_R13`}).addTo(fg).bindPopup(`KCRKW1<br>Kansas City Room, K0HAM<br>146.910-MHz



<br>Overland Park, KS<br><b style='color:red;'>Jerry Dixon KCØKW</b><br>38.9879167, -94.67075,  0 Ft.<br>EM28PX`).openPopup();                        
 
                        $(`Repeater`._icon).addClass(`rptmrkr`);
            var KCRHAM4 = new L.marker(new L.LatLng(39.2611111,-95.6558333),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `markers/repeater.png`, iconSize: [32, 34]}),
                        title:`marker_R14`}).addTo(fg).bindPopup(`KCRHAM4<br>Kansas City Room, K0HAM<br>Hoyt Kansas 444.725MHz
<br>Hoyt, KS<br><b style='color:red;'>Jerry Dixon KCØKW</b><br>39.2611111, -95.6558333,  0 Ft.<br>EM29EG`).openPopup();                        
 
                        $(`Repeater`._icon).addClass(`rptmrkr`);
            
    
var AviationList = L.layerGroup([, ]);var CHPList = L.layerGroup([, , ]);var EOCList = L.layerGroup([, W0KCN4, W0KCN3, W0KCN15, NARESEOC]);var FederalList = L.layerGroup([, , , ]);var FireList = L.layerGroup([KCMOFS44, , KCMOFS36, CARROLFD, KCMOFS37, RVRSFD, KCMOFS14, KCMOFS38, KCMOFS39, KCMOFS40, KCMOFS41, KCMOFS42, KCMOFS47, KCMOFS43, KCMOFS45, KCMOFS35, KCMOFS34, KCMOFS33, KCMOFS16, KCMOFS10, KCMOFS8, KCMOFS7, KCMOFS6, KCMOFS5, KCMOFS4, KCMOFS3, KCMOFS17, KCMOFS18, KCMOFS30, KCMOFS29, KCMOFS28, KCMOFS27, KCMOFS25, KCMOFS24, KCMOFS23, KCMOFS19, KCMOFS1, , , , , , , , , , , , , , , , , , , , , , , , , , , , , , , , , , , , , , , , , GNSVFS1, TFESS12, BRVRCOFR29, RVRSDEFD, ]);var HospitalList = L.layerGroup([STJOHN, STJOMC, STLEAS, STLPLZ, RMCBKS, RESRCH, RAYCO, PMC, OPR, OMC, NORKC, MENORA, LMH, STLSMI, , , , , , PETTIS, WEMO, , TRUHH, TRLKWD, STM, STLUSO, STLUBR, LSMED, LRHC, LRHC, CMHS, W0CPT, CMH, SMMC, CARROL, BRMC, CASS, BOTHWL, BATES, CUSHNG, DCEC, KU0MED, KCVA, KC0CBC, LIBRTY, I70, GVMH, FITZ, EXSPR, KINDRD]);var PoliceList = L.layerGroup([, , , , , , , , ]);var RepeaterList = L.layerGroup([KCRHCV, KCRMED, SAXRPTR, KCRQFJ, KCRHAM3, DCARC, KCRHAM2, KCRROO, KCRWW, KCRKW2, KCRJCRAC2, KCRJCRAC1, KCRKW1, KCRHAM4, "Humboldt County Cou, "Rogers Peak", "Humboldt Hill", "Horse Mt.", "Mount Pierce", "Rainbow Ridge", WA0KHP, WA0QFJ, KCRCNC, "Shelter Cove", "Pratt Mt.", ACT, "Sugar Pine Mountain]);var SheriffList = L.layerGroup([NRTPD, FPD93721, , , , RVRSPD, COMOPD, PKVLPD, LKWKPD, GSTNPD, NKCPD, CCSHERIFF, KCNPPD, PLTCTYPD]);var SkyWarnList = L.layerGroup([C7, C9, C8, C11, C12, , C10, XSPRINGS, C6, C5, P2, P8, P7, SWSKOL, P1, WATKINSMILL, Non291Hwy, LecRestStop, HWY291on210, P6, CTEAUELV, P9, P10, P11, SUNNYSIDE, BROADWAY, P5, C4, C3, P4, C2, P3, C1, P13, P12, TANEY210]);var StateList = L.layerGroup([, , , , , , , , , , ]);var KD0NBH67898 = L.marker([39.20646,-94.605575]).bindPopup('LOC&#916:W3W:OBJ: undergoing.arrival.hobble -> Cross Roads: NW 62nd St &amp; N Harden Ct (39.20646,-94.605575) Black Chevy');var KD0NBH67898 = L.marker([39.206272,-94.60481]).bindPopup('LOC&#916:W3W:OBJ: converter.admitting.shovels -> Cross Roads: N Harden Ct &amp; NW 62nd St (39.206272,-94.60481)  White Ford');var KD0NBH67898 = L.marker([39.205679,-94.605854]).bindPopup('LOC&#916:W3W:OBJ: mincing.starring.engineering -> Cross Roads: NW 62nd St &amp; N Harden Ct (39.205679,-94.605854) Green Toyota');var KD0NBH67898 = L.marker([39.205544,-94.60714]).bindPopup('LOC&#916:W3W:OBJ: fussed.westerner.ratty -> Cross Roads: NW 62nd St &amp; N Evans Ave (39.205544,-94.60714) Red Honda');var KD0NBH67898 = L.marker([39.205032,-94.606201]).bindPopup('LOC&#916:W3W:OBJ: falsely.help.delight -> Cross Roads: N Evans Ave &amp; NW 62nd St (39.205032,-94.606201) Black Chevy Truck');var KD0NBH67898 = L.marker([39.204385,-94.606862]).bindPopup('LOC&#916:W3W:OBJ: craving.since.duchess -> Cross Roads: NW 62nd St &amp; N Evans Ave (39.204385,-94.606862) White Chevy Truck');var W0DLK60749 = L.marker([39.198159,-94.601576]).bindPopup('LOC&#916:W3W:OBJ: spray.shudder.opting -> Cross Roads: N Ames Ave &amp; NW 57 Ct (39.198159,-94.601576) yellow door');var W0DLK60749 = L.marker([39.197539,-94.602375]).bindPopup('LOC&#916:W3W:OBJ: bogus.daunted.overlapping -> Cross Roads: N Ames Ave &amp; 56th (39.197539,-94.602375) door is missing');var W0DLK60749 = L.marker([39.198779,-94.601541]).bindPopup('LOC&#916:W3W:OBJ: trill.photons.pills -> Cross Roads: N Ames Ave &amp; NW 57 Ct (39.198779,-94.601541) purple door');var W0DLK60749 = L.marker([39.200908,-94.601471]).bindPopup('LOC&#916:W3W:OBJ: posters.sheep.pretty -> Cross Roads: N Ames Ave &amp; NW 59 St (39.200908,-94.601471) who know?');var W0DLK60749 = L.marker([39.200639,-94.601471]).bindPopup('LOC&#916:W3W:OBJ: evolves.shorthand.doorway -> Cross Roads: N Ames Ave &amp; NW 59 St (39.200639,-94.601471) red door');var W0DLK60749 = L.marker([39.200477,-94.601471]).bindPopup('LOC&#916:W3W:OBJ: strawberry.aunts.frocks -> Cross Roads: N Ames Ave &amp; NW 59 St (39.200477,-94.601471) green door');var W0DLK60749 = L.marker([39.19948,-94.601471]).bindPopup('LOC&#916:W3W:OBJ: enjoys.gallery.served -> Cross Roads: N Ames Ave &amp; NW 58 Ct (39.19948,-94.601471) pink door');var W0DLK60749 = L.marker([39.201636,-94.601749]).bindPopup('LOC&#916:W3W:OBJ: dished.relaxation.marked -> Cross Roads: N Ames Ave &amp; NW 59 St (39.201636,-94.601749) white door');var W0DLK60749 = L.marker([39.202418,-94.601923]).bindPopup('LOC&#916:W3W:OBJ: sufferings.shifters.truffles -> Cross Roads: NW 60th Ct &amp; N Ames Ave (39.202418,-94.601923) blue door');var W0DLK60749 = L.marker([39.202579,-94.60241]).bindPopup('LOC&#916:W3W:OBJ: typhoon.barrage.knots -> Cross Roads: N Ames Ave &amp; NW 60th Ct (39.202579,-94.60241) green door');var W0DLK60749 = L.marker([39.202876,-94.602445]).bindPopup('LOC&#916:W3W:OBJ: mathematics.seasonal.eaters -> Cross Roads: N Ames Ave &amp; NW 60th Ct (39.202876,-94.602445) red door');var W0DLK60749 = L.marker([39.202903,-94.602897]).bindPopup('LOC&#916:W3W:OBJ: easily.hardest.ended -> Cross Roads: N Ames Ave &amp; NW 60th Ct (39.202903,-94.602897) across the street from home');var W0DLK60749 = L.marker([39.197647,-94.602689]).bindPopup('LOC&#916:W3W:OBJ: confirm.backer.ministries -> Cross Roads: N Ames Ave &amp; 56th (39.197647,-94.602689) get the time');var W0DLK60749 = L.marker([39.197782,-94.602167]).bindPopup('LOC&#916:W3W:OBJ: collateral.tomorrow.flop -> Cross Roads: N Ames Ave &amp; 56th (39.197782,-94.602167) flop my ass');var W0DLK60749 = L.marker([39.197917,-94.601923]).bindPopup('LOC&#916:W3W:OBJ: vindicated.hygiene.doing -> Cross Roads: N Ames Ave &amp; 56th (39.197917,-94.601923) pink door');var W0DLK60749 = L.marker([39.19851,-94.601784]).bindPopup('LOC&#916:W3W:OBJ: scorching.hygiene.spurned -> Cross Roads: NW 57 Ct &amp; N Ames Ave (39.19851,-94.601784) blue door');var W0DLK60749 = L.marker([39.199022,-94.601715]).bindPopup('LOC&#916:W3W:OBJ: puts.available.folder -> Cross Roads: N Ames Ave &amp; NW 57 Ct (39.199022,-94.601715) pole in road');var W0DLK60749 = L.marker([39.199534,-94.601715]).bindPopup('LOC&#916:W3W:OBJ: buckets.tumblers.rehearsing -> Cross Roads: NW 58 Ct &amp; N Ames Ave (39.199534,-94.601715) tree in driveway');var W0DLK60749 = L.marker([39.200127,-94.601715]).bindPopup('LOC&#916:W3W:OBJ: forecast.snack.upshot -> Cross Roads: N Ames Ave &amp; NW 58 Ct (39.200127,-94.601715) tree on roof of house');var W0DLK60749 = L.marker([39.200558,-94.601715]).bindPopup('LOC&#916:W3W:OBJ: ever.insects.monarch -> Cross Roads: N Ames Ave &amp; NW 59 St (39.200558,-94.601715) used spaces');var W0DLK60749 = L.marker([39.201474,-94.601889]).bindPopup('LOC&#916:W3W:OBJ: spinach.spaceship.scouts -> Cross Roads: N Ames Ave &amp; NW 59 St (39.201474,-94.601889) Boy Scouts in the airea');var W0DLK60749 = L.marker([39.202013,-94.602515]).bindPopup('LOC&#916:W3W:OBJ: peanuts.cafeteria.hamstrings -> Cross Roads: N Bedford Ave &amp; N Ames Ave (39.202013,-94.602515) food on the table');var WA0TJT60748 = L.marker([39.202579,-94.602515]).bindPopup('LOC&#916:W3W:OBJ: mathematics.crunched.respectful -> Cross Roads: N Ames Ave &amp; NW 60th Ct (39.202579,-94.602515) First marker');var WA0TJT60748 = L.marker([39.201879,-94.602689]).bindPopup('LOC&#916:W3W:OBJ: browser.protesting.reward -> Cross Roads: N Bedford Ave &amp; N Ames Ave (39.201879,-94.602689) Mail box');var WA0TJT60748 = L.marker([39.201582,-94.603315]).bindPopup('LOC&#916:W3W:OBJ: royals.oddly.relating -> Cross Roads: N Bedford Ave &amp; NW 59th Ct (39.201582,-94.603315) The next marker');var WA0TJT60748 = L.marker([39.201313,-94.603488]).bindPopup('LOC&#916:W3W:OBJ: invaluable.resumes.thumbnail -> Cross Roads: N Bedford Ave &amp; NW 59th Ct (39.201313,-94.603488) Marker next again');var WA0TJT60748 = L.marker([39.201097,-94.604184]).bindPopup('LOC&#916:W3W:OBJ: student.downgraded.satisfy -> Cross Roads: NW 59th Ct &amp; N Bedford Ave (39.201097,-94.604184) Holding hands');var WA0TJT60748 = L.marker([39.201286,-94.604532]).bindPopup('LOC&#916:W3W:OBJ: transmitted.reward.loners -> Cross Roads: NW 59th Ct &amp; N Bedford Ave (39.201286,-94.604532) Still on the way down');var WA0TJT60748 = L.marker([39.20169,-94.604567]).bindPopup('LOC&#916:W3W:OBJ: powerful.ongoing.rigid -> Cross Roads: NW 59th Ct &amp; N Bedford Ave (39.20169,-94.604567) Big red door');var WA0TJT60748 = L.marker([39.201366,-94.604428]).bindPopup('LOC&#916:W3W:OBJ: blinked.surcharge.lays -> Cross Roads: NW 59th Ct &amp; N Bedford Ave (39.201366,-94.604428) More walking downhill');var WA0TJT60748 = L.marker([39.201097,-94.604219]).bindPopup('LOC&#916:W3W:OBJ: bookshelf.morphing.awarded -> Cross Roads: NW 59th Ct &amp; N Bedford Ave (39.201097,-94.604219) Still holding hands');var WA0TJT60748 = L.marker([39.201016,-94.603732]).bindPopup('LOC&#916:W3W:OBJ: merchandise.trendy.dynamic -> Cross Roads: NW 59th Ct &amp; N Bedford Ave (39.201016,-94.603732) Blue door now');var WA0TJT60748 = L.marker([39.200154,-94.603697]).bindPopup('LOC&#916:W3W:OBJ: toasted.extremes.continental -> Cross Roads: Bedford &amp; N Bedford Ave (39.200154,-94.603697) Middle of the street');var WA0TJT60748 = L.marker([39.199749,-94.603975]).bindPopup('LOC&#916:W3W:OBJ: reception.nickname.tremor -> Cross Roads: NW 58th St &amp; N Bedford Ave (39.199749,-94.603975) Green door');var WA0TJT60748 = L.marker([39.199561,-94.604497]).bindPopup('LOC&#916:W3W:OBJ: powered.repelled.magically -> Cross Roads: NW 58th St &amp; N Delta Ave (39.199561,-94.604497) Dorr is missing');var WA0TJT60748 = L.marker([39.199426,-94.605019]).bindPopup('LOC&#916:W3W:OBJ: gravy.planet.discharged -> Cross Roads: NW 58th St &amp; N Delta Ave (39.199426,-94.605019) At the cross roads');var WA0TJT60748 = L.marker([39.199318,-94.604984]).bindPopup('LOC&#916:W3W:OBJ: rescuer.shrink.founder -> Cross Roads: N Delta Ave &amp; NW 58th St (39.199318,-94.604984) Red door maybe');var WA0TJT60748 = L.marker([39.199695,-94.604149]).bindPopup('LOC&#916:W3W:OBJ: spurned.formed.schoolwork -> Cross Roads: NW 58th St &amp; N Bedford Ave (39.199695,-94.604149) Red door again');var WA0TJT60748 = L.marker([39.19983,-94.603836]).bindPopup('LOC&#916:W3W:OBJ: cringe.gets.resumes -> Cross Roads: NW 58th St &amp; N Bedford Ave (39.19983,-94.603836) Telephone pole in street');var WA0TJT60748 = L.marker([39.200127,-94.603628]).bindPopup('LOC&#916:W3W:OBJ: included.dentures.wishful -> Cross Roads: N Bedford Ave &amp; Bedford (39.200127,-94.603628) Tree down in yard');var WA0TJT60748 = L.marker([39.200774,-94.603697]).bindPopup('LOC&#916:W3W:OBJ: enzymes.texts.elevates -> Cross Roads: N Bedford Ave &amp; NW 59th Ct (39.200774,-94.603697) At the mailbox again');var WA0TJT60748 = L.marker([39.201259,-94.603454]).bindPopup('LOC&#916:W3W:OBJ: deviations.barks.shapeless -> Cross Roads: N Bedford Ave &amp; NW 59th Ct (39.201259,-94.603454) Walking up the hill');var WA0TJT60748 = L.marker([39.201501,-94.603245]).bindPopup('LOC&#916:W3W:OBJ: unsuitable.manliness.plums -> Cross Roads: N Bedford Ave &amp; NW 59th Ct (39.201501,-94.603245) Pretty flowering trees');var WA0TJT60748 = L.marker([39.201825,-94.602723]).bindPopup('LOC&#916:W3W:OBJ: forthright.valid.protects -> Cross Roads: N Bedford Ave &amp; N Ames Ave (39.201825,-94.602723) Back at the corner of Ames');

// Define a PoiIcon class
var PoiIconClass = L.Icon.extend({
    options: {
        iconSize: [32, 37]
    }
});

// Define a ObjIcon class
var ObjIconClass = L.Icon.extend({
    options: {
        iconSize: [32, 37]
    }
});

// Create some icons from the above PoiIconClass class and one from ObjIconClass
var firstaidicon = new PoiIconClass({iconUrl: 'images/markers/firstaid.png'}),
    eocicon = new PoiIconClass({iconUrl: 'images/markers/eoc.png'}),
    policeicon = new PoiIconClass({iconUrl: 'images/markers/police.png'}),
    skywarnicon = new PoiIconClass({iconUrl: 'images/markers/skywarn.png'}),
    fireicon = new PoiIconClass({iconUrl: 'images/markers/fire.png'}),
    repeatericon = new PoiIconClass({iconUrl: 'markers/repeater.png'}),
    blueFlagicon = new PoiIconClass({iconUrl: 'images/markers/blue_50_flag.png'}),  // used as corners of the bounds
    
    // objects and corners map icons
    objicon = new ObjIconClass({iconURL: 'images/markers/marker00.png'}),          // the 00 marker
    greenFlagicon = new ObjIconClass({iconUrl: 'images/markers/green_50_flag.png'});  // used as corners of the bounds
    
// ===========================================================================================================================
// ================================================    STATIONS      =========================================================
// ===========================================================================================================================

var Stations = L.layerGroup([WA0TJT,W0DLK,KD0NBH,KC0YT,AA0JX,AA0DV]);


// Blue flag markers to mark the corners of the viewable stations map
	 	

// The fitBounds data comes from stationMarkers.php
var bounds = L.latLngBounds([[39.2028965,-94.602876],[39.2028965,-94.602876],[39.204385,-94.606862],[39.2002636,-94.641221],[39.2232199,-94.568932],[39.2628465,-94.569978]]); 
var middle = bounds.getCenter(); // alert(middle); //LatLng(-93.20448, 38.902475)
var padit  = bounds.pad(.075);   // add a little bit to the corner bounding box
var sw = padit.getSouthWest();   // get the SouthWest most point
var nw = padit.getNorthWest();
var ne = padit.getNorthEast();
var se = padit.getSouthEast();

var redmarkername = "images/markers/red_50_flag.png";
var bluemarkername = "images/markers/blue_50_flag.png";
// these two are used by the objects, if there are any
var greenmarkername = "images/markers/green_50_flag.png";
var manInTheMiddle_50 = "images/markers/manInTheMiddle_50.png";

    //=======================================================================
    //======================= Station Marker Corners ========================
    //=======================================================================
    // POI's do not have corner markers, however they should be restricted to 
    // display within these markers with a little wiggle room
    
    // These are the corner markers of the extended bounds of the stations
    var mk1 = new L.marker(new L.latLng( sw ),{
        icon: L.icon({iconUrl: bluemarkername , iconSize: [32,36] }),
        title:'mk1'}).addTo(map).bindPopup('MK1<br>The SW Corner<br>'+sw).openPopup();
    
    var mk2 = new L.marker(new L.latLng( nw ),{
       icon: L.icon({iconUrl: bluemarkername , iconSize: [32,36] }),
       title:'mk2'}).addTo(map).bindPopup('MK2<br>The NW Corner<br>'+nw).openPopup();
    
    var mk3 = new L.marker(new L.latLng( ne ),{
       icon: L.icon({iconUrl: bluemarkername , iconSize: [32,36] }),
       title:'mk3'}).addTo(map).bindPopup('MK3<br>The NE Corner<br>'+ne).openPopup();
    
    var mk4 = new L.marker(new L.latLng( se ),{
       icon: L.icon({iconUrl: bluemarkername , iconSize: [32,36] }),
       title:'mk4'}).addTo(map).bindPopup('MK4<br>The SE Corner<br>'+se).openPopup();
	
    // Add the temp center marker to the map here in the javascript code allows it to use the current map view,
    // When its earlier in the stack, it centers on our house becaue that is the default map location
    var mk5 = new L.marker(new L.latLng( middle ),{
        contextmenu: true, contextmenuWidth: 140, contextmenuItems: [{ 
        text: 'Click here to add mileage circles', callback: circleKoords}],   
        icon: L.icon({iconUrl: redmarkername , iconSize: [32, 36] }),     
        title:'mk5'}).addTo(map).bindPopup('MK5<br>The Center Marker<br>'+middle).openPopup();
    
    // Definition of the 5 markers above, corners plus middle    
    var CornerList = L.layerGroup([mk1, mk2, mk3, mk4, mk5]);
    //======================================================================
    // ================== End Station Marker Corners =======================
    //======================================================================
    
    
    //====================================================================== 
    //====================== Object Marker Corners =========================
    //======================================================================
    // Objects come from the TimeLog table of NCM. They represent a breadcrumb
    // like trail of W3W recorded spots by one or more stations.
        
    // These are created in the objlayer38182.php program
    var theCalls = L.layerGroup([KD0NBH,W0DLK,WA0TJT,WA0TJTCorners =  [[39.452579, -94.852515], [39.452579, -94.355019 ], [38.949318, -94.355019 ], [38.949318, -94.852515 ], [39.452579, -94.852515]];    
    console.dir('@306 theCalls= '+theCalls);
        // var theCalls =  L.layerGroup([KD0NBH,W0DLK,WA0TJT,]);

        const callOBJb = [] 
       // console.dir( '@357 callOBJb= '+JSON.stringify(callOBJb));
       
    // This is an array of the callsigns having objects
    var callsList = [var callsList = L.layerGroup([AA0DV, WA0TJT, W0DLK, KC0YT, AA0JX, KD0NBH]);
]; 
        console.dir('@361 callsList= '+callsList);
        //alert(callsList);
        
       
       var i = -1;  
    for (let val of callOBJb) {        // Steps through the list of stations with object markers
       i++;
       
       //console.log('@378 '+callsList[i]);
    
        var middle = val.getCenter();  
        var padit  = val.pad(.015);    // add a little bit to the corner bounding box
        
        // these get used in circleKoords.js 
        // but below they are used only as the padit.get....
        var Osw = padit.getSouthWest();      // get the SouthWest most point
        var Onw = padit.getNorthWest();
        var One = padit.getNorthEast();
        var Ose = padit.getSouthEast();

   
        // These are the corner markers and center of the extended bounds of the objects
        //eval('var '+callsList[i]+' = "";'); console.log(eval('var '+callsList[i]+' = "H";'));
        
        var ob1 = new L.marker(new L.latLng( padit.getSouthWest() ),{
            contextmenu: true, contextmenuWidth: 140, contextmenuItems: [{ 
            text: 'Click here to add mileage circles', callback: circleKoords}],
            icon: L.icon({iconUrl: greenmarkername , iconSize: [32,36] }),
            title:'ob1'}).addTo(map).bindPopup('OBJ:<br>'+callsList[i]+'<br>The Objects SW Corner<br>'+padit.getSouthWest()).openPopup();
        
        var ob2 = new L.marker(new L.latLng( padit.getNorthWest() ),{
            contextmenu: true, contextmenuWidth: 140, contextmenuItems: [{ 
            text: 'Click here to add mileage circles', callback: circleKoords}],
            icon: L.icon({iconUrl: greenmarkername , iconSize: [32,36] }),
            title:'ob2'}).addTo(map).bindPopup('OBJ:<br>'+callsList[i]+'<br>The Objects NW Corner<br>'+padit.getNorthWest()).openPopup();
        
        var ob3 = new L.marker(new L.latLng( padit.getNorthEast() ),{
            contextmenu: true, contextmenuWidth: 140, contextmenuItems: [{ 
            text: 'Click here to add mileage circles', callback: circleKoords}],
            icon: L.icon({iconUrl: greenmarkername , iconSize: [32,36] }),
            title:'ob3'}).addTo(map).bindPopup('OBJ:<br>'+callsList[i]+'<br>The Objects NE Corner<br>'+padit.getNorthEast()).openPopup();
        
        var ob4 = new L.marker(new L.latLng( padit.getSouthEast() ),{
            contextmenu: true, contextmenuWidth: 140, contextmenuItems: [{ 
            text: 'Click here to add mileage circles', callback: circleKoords}],
            icon: L.icon({iconUrl: greenmarkername , iconSize: [32,36] }),
            title:'ob4'}).addTo(map).bindPopup('OBJ:<br>'+callsList[i]+'<br>The Objects SE Corner<br>'+padit.getSouthEast()).openPopup();
    	
        var ob5 = new L.marker(new L.latLng( val.getCenter() ),{
            contextmenu: true, contextmenuWidth: 140, contextmenuItems: [{ 
            text: 'Click here to add mileage circles', callback: circleKoords}],   
            icon: L.icon({iconUrl: manInTheMiddle_50 , iconSize: [32, 36] }),     
            title:'ob5'}).addTo(map).bindPopup('OBJ: Middle<br>'+callsList[i]+'<br>The Objects Center Marker<br>'+val.getCenter()).openPopup();
        
        // Definition of the 5 markers above, corners plus middle    
        var ObjCornerList = L.layerGroup([ob1, ob2, ob3, ob4, ob5]);  
    } // End of for loop
      // =======================================================================
      // ================== End of Object Marker Corners =======================
      // =======================================================================
      
    
var classList = 'AviationL,CHPL,EOCL,FederalL,FireL,HospitalL,PoliceL,RepeaterL,SheriffL,SkyWarnL,StateL, CornerL, ObjectL'.split(',');
   //console.log('@419 classList= '+classList);

let station = {"<img src='markers/green_marker_hole.png' class='greenmarker' alt='green_marker_hole' align='middle' /><span class='biggreenmarker'> Stations</span>": Stations};

// Each test below if satisfied creates a javascript object, each one connects the previous to the next 
var y = {...station};
var x;
for (x of classList) {

    if (x == 'EOCL') {
        let EOC = {"<img src='images/markers/eoc.png' align='middle' /> <span class='eocmarker'>EOC</span>": EOCList};
        y = {...y, ...EOC};     
        
    }else if (x == 'FireL') {
        let Fire = {"<img src='images/markers/fire.png' align='middle' /> <span class='firemarker'>Fire Station</span>": FireList};
        y = {...y, ...Fire};
        
    }else if (x == 'HospitalL') {
        let Hospital = {"<img src='images/markers/firstaid.png' align='middle' /> <span class='hosmarker'>Hospitals</span>": HospitalList};
        y = {...y, ...Hospital};
        
    }else if (x == 'SheriffL') {
        let Sheriff = {"<img src='images/markers/police.png' width='32' height='37' align='middle' /> <span class='polmarker'>Police</span>":  SheriffList};
        y = {...y,...Sheriff};
        
    }else if (x == 'RepeaterL') {
        let Repeater = {"<img src='images/markers/repeater.png' align='middle' /> <span class='rptmarker'>Repeaters</span>": RepeaterList};
        y = {...y, ...Repeater};
        
    }else if (x == 'SkyWarnL') {
        let SkyWarn = {"<img src='images/markers/skywarn.png' align='middle' /> <span class='skymarker'>SkyWarn</span>": SkyWarnList};
        y = {...y, ...SkyWarn};           
         
    }else if (x == 'ObjectL') {
        let Objects = {"<img src='images/markers/marker00.png' align='middle' /> <span class='objmrkrs'>Objects</span>": ObjectList};
        y = {...y, ...Objects}; 
        
    }else if (x == ' CornerL') {
        let Corners = {"<img src='images/markers/red_50_flag.png' align='middle' /> <span class='corners'>Corners</span>": CornerList};
        y = {...y, ...Corners};
    }else if (x == ' CornerL') {
        let Corners = {"<img src='images/markers/red_50_flag.png' align='middle' /> <span class='corners'>Corners</span>": CornerList};
        y = {...y, ...Corners};
    }
}; // End of for loop
    
// Here we add the station object with the merged y objects from above
var overlayMaps = {...y }; 

//console.log(overlayMaps);

// Set the center point of the map based on the coordinates
map.fitBounds([[39.2028965,-94.602876],[39.2028965,-94.602876],[39.204385,-94.606862],[39.2002636,-94.641221],[39.2232199,-94.568932],[39.2628465,-94.569978]], {
  pad: 0.5
});

L.control.layers(baseMaps, overlayMaps,  {position:'bottomright', collapsed:false}).addTo(map);


// Define the Plus and Minus for zooming and its location
map.scrollWheelZoom.disable();  // prevents the map from zooming with the mouse wheel

var arcgisOnline = L.esri.Geocoding.arcgisOnlineProvider();

// Add what3words, shows w3w in a control
var w = new L.Control.w3w();
	w.addTo(map);
	map.on('click', function(e) {
		console.log(e);
		w.setCoordinates(e);
	});
	
// Adds a temp marker popup to show location of click
var popup = L.popup();
function onMapClick(e) {
    popup
        .setLatLng(e.latlng)
        .setContent("You clicked the map at:<br>" + e.latlng.toString() + "<br>"  )
        .openOn(map);
}
map.on('click', onMapClick);



// adds the lat/lon grid lines
L.grid().addTo(map);  

// Add the lat/lon mouse position 
L.control.mousePosition({separator:',',position:'topright',prefix:''}).addTo(map);

        // https://github.com/ppete2/Leaflet.PolylineMeasure
        // Position to show the control. Values: 'topright', 'topleft', 'bottomright', 'bottomleft'
        // Show imperial or metric distances. Values: 'metres', 'landmiles', 'nauticalmiles'
        
    L.control.polylineMeasure ({position:'topright', unit:'landmiles', showBearings:true, clearMeasurementsOnStop: false, showClearControl: true, showUnitControl: true}).addTo (map);




// Change the position of the Zoom Control to a newly created placeholder.
map.zoomControl.setPosition('topright');


L.control.scale().addTo(map);

// You can also put other controls in the same placeholder.
//L.control.scale({position: 'verticalcenterright'}).addTo(map);

// Set up to show markers popup	

		function markerFunction(id){
	        for (var i in stationMarkers){
	            var markerID = stationMarkers[i].options.title;
	            if (markerID == id){
	                stationMarkers[i].openPopup();
	            };
	        } // end of for loop
		} // end markerFunction 
		
	    // JQuery call to display the popup from the marker list
	    $("a").click(function(){
	        markerFunction($(this)[0].id);
	    });
	    
	    
	    function isEmpty(obj) {
    	    for(var key in obj) {
        	    if(obj.hasOwnProperty(key))
        	        return false;
    	    }
    	        return true;
	    }
	    
	    var lastLayer = null;
          map.on('contextmenu.show',(e)=>{
            console.log(e);
            lastLayer = e.relatedTarget; 
        });
	    

</script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

</body>
</html>
