<!DOCTYPE html>

<!-- IDEA: Create ability to draw lines from one marker to all other markers show bearing and distance.
    http://embed.plnkr.co/2XSeS1/
-->


<!-- Primary maping program, also uses poimarkers.php and stationmarkers.php -->

<?php
	
	ini_set('display_errors',1); 
	error_reporting (E_ALL ^ E_NOTICE);

    require_once "dbConnectDtls.php";  // Access to MySQL
    require_once "GridSquare.php";
    
    
    $q = $_GET["NetID"]; 
   // $q = 2896;
	
	
	// An attempt to find the corners of the given points so the POIs can be inhibited outside that range 
	// These values would work in conjunction with the poiMarkers.php to write the where clause to limit output
	$sql = (" SELECT MIN(latitude)  as minLat,
	                 MAX(latitude)  as maxLat,
	                 MIN(longitude) as minLng,
	                 MAX(longitude) as maxLng
	            FROM NetLog
	           WHERE netID = $q      
	      ");
	   foreach($db_found->query($sql) as $rowCorners) {
    	   $minLat = $rowCorners[minLat]-0.25;
    	   $maxLat = $rowCorners[maxLat]+0.25;
    	   $minLng = $rowCorners[minLng]+0.25;
    	   $maxLng = $rowCorners[maxLng]-0.25;
    	  // $poly2 = " $maxLng $maxLat , $minLng $maxLat , $minLng $minLat , $maxLng $minLat , $maxLng $maxLat ";
    	   $poly = " $maxLat $maxLng  , $maxLat $minLng  , $minLat $minLng  , $minLat $maxLng  , $maxLat $maxLng  ";
	   };	  
	   	   
       
       // This var is used to find the lanlngBounds and hence determine the center of the important area of the map
 //                      NorthWest              NorthEast           SouthEast            SouthWest         same as first
       $cntPoints = "[[$maxLat, $maxLng], [$maxLat, $minLng ], [$minLat, $minLng ], [$minLat, $maxLng ], [$maxLat, $maxLng]]";  
                
    
	// This var is used in the SQL in poiMarkers.php to limit the markers to those in the area of stationMarkers  
	// Some day when MySQL is updated to at least 5.6, change MBRContains to ST_Containes
    $whereClause = "WHERE MBRContains(GeomFromText('POLYGON(( $poly ))'),latlng)";
    //$whereClause = "WHERE ST_CONTAINS(GeomFromText('POLYGON(( $poly ))'), GeomFromText('POINT(latlng))')";
    
    //   echo "<br>$whereClause"; 
      // WHERE MBRContains(GeomFromText('POLYGON(( -95.483417 39.6197989 , -94.103285 39.6197989 , -94.103285 38.673154 , -95.483417 38.673154 , -95.483417 39.6197989 ))'),latlng)
    	       
	// Gets all the stations logged into the net
	require_once "stationMarkers.php";
    require_once "poiMarkers.php";      
    
?>

<html lang="en">
<head>
	<!-- https://esri.github.io/esri-leaflet/tutorials/create-your-first-app.html -->
	<title>NCM Map of Station Locations</title>

	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	
	<link rel="shortcut icon" type="image/x-icon" href="images/favicon-32x32.png" >
	<!--
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> 
    -->
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
     
     <!-- ******************************** Added Functionality *************************************** -->
    <link rel="stylesheet" href="css/leaflet_numbered_markers.css" />
    <link rel="stylesheet" href="css/L.Grid.css" />   
    <link rel="stylesheet" href="css/L.Control.MousePosition.css" />
    <link rel="stylesheet" href="css/control.w3w.css" />
    
    <link rel="stylesheet" href="https://ppete2.github.io/Leaflet.PolylineMeasure/Leaflet.PolylineMeasure.css" />
    <link rel="stylesheet" type="text/css" href="css/maps.css">  
    <link rel="stylesheet" type="text/css" href="css/leaflet/leaflet.contextmenu.min.css">
    
    <script src="js/leaflet_numbered_markers.js"></script>
    <script src="js/L.Grid.js"></script>                    <!-- https://github.com/jieter/Leaflet.Grid -->
    <script src="js/L.Control.MousePosition.js"></script>   <!-- https://github.com/ardhi/Leaflet.MousePosition -->
    <script src="js/hamgridsquare.js"></script>
    
 <!--<script src="https://cdnjs.cloudflare.com/ajax/libs/OverlappingMarkerSpiderfier-Leaflet/0.2.6/oms.min.js"></script>-->
    <script src="js/control.w3w.js"></script>
    <script src="https://ppete2.github.io/Leaflet.PolylineMeasure/Leaflet.PolylineMeasure.js"></script>
    
    <script src="js/leaflet/leaflet.contextmenu.min.js"></script>
    
    <!-- Allows for rotating markers when more than one at the same place -->
    <script src="js/leaflet.rotatedMarker.js"></script>
    
     <!-- Adds grid lines marked with the gridsquare on the map -->
     <!-- https://gitlab.com/IvanSanchez/leaflet.maidenhead/-/blob/master/README.md -->
     <!--<script src="https://unpkg.com/leaflet.maidenhead@1.0.0/src/maidenhead.js"></script>-->
    
    <script src="https://cdn.jsdelivr.net/npm/leaflet-geometryutil@0.9.1/src/leaflet.geometryutil.min.js"></script>
    
    <!-- https://github.com/Turfjs/turf -->
    <!-- The use of transformScale from below may allow the groth of the polygon better than gussing like i do now. -->
    <!-- See https://stackoverflow.com/questions/61860963/how-to-enlarge-a-leaflet-polygon-box-by-5 -->
    <script src="https://cdn.jsdelivr.net/npm/@turf/turf@5/turf.min.js"></script>
    

	<style>
		/* All CSS is in css/maps.css */
		.cc {
    		font-weight: bold;
    		color: red;
		}
		
		element.style  {
    		width: 60px !important;
        }
		
	</style>
	
</head>

<body>
    
    <!-- the map div holds the map -->
    <div id="map"></div>
    
    <!-- the stations div holds a list of the stations marked on the map -->
    <div id="stations"> 
		<b style="color:red; text-decoration: underline;"><?php echo "$logrow[netcall]
    		</b><br>$stationList";?>
	</div>

    <!-- The title banner -->
    <div id="activity" class="activity">
    	<img src="images/NCM.png" alt="NCM" style="width: 35px; padding-left: 10px; padding-top: 5px;">
    	<?php echo"$netcall Net #$logrow[netID] $logrow[activity] $logrow[logdate]" ?>
    </div>
    
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script>
    
 // If you click on the 'Show Cross Rodads' in a popup
 // Not yet implemented
$(document).ready(function() {
    $('#map').on('click', '.cc', function() {
        $(".cc").html('Coming Soon');
        alert('This feature is coming soon ');
    });
}); 
    
    var stationMarkers = [];
    var fg = new L.featureGroup();
    
// These are the markers that will appear on the map
<?php
    echo ("$stationMarkers");   // All the checked in stations  
    echo ("$poiMarkers");       // The Points of Interest Markers
    echo ("$POIMarkerList");    // The poi Markers list
    echo ("$callsList");        // echo "$callsList";
?>

// Define a PoiIcon class
var PoiIconClass = L.Icon.extend({
    options: {
        iconSize: [32, 37]
    }
});

// Create five icons from the above PoiIconClass class
var firstaidicon = new PoiIconClass({iconUrl: 'images/markers/firstaid.png'}),
    eocicon = new PoiIconClass({iconUrl: 'images/markers/eoc.png'}),
    policeicon = new PoiIconClass({iconUrl: 'images/markers/police.png'}),
    skywarnicon = new PoiIconClass({iconUrl: 'images/markers/skywarn.png'}),
    fireicon = new PoiIconClass({iconUrl: 'images/markers/fire.png'}),
    repeatericon = new PoiIconClass({iconUrl: 'markers/repeater.png'}),
    blueFlagicon = new PoiIconClass({iconUrl: 'images/markers/blue_50_flag.png'});

var Stations = L.layerGroup([<?php echo "$callsignList"?>]);

    // Define the map
    const map = L.map('map', {
    	drawControl: true,
		zoom: 12
	}); 
	
// Define the layers for the map
var Streets = L.esri.basemapLayer('Streets').addTo(map),
    Imagery = L.esri.basemapLayer('Imagery').addTo(map),
    NatGeo  = L.esri.basemapLayer('NationalGeographic').addTo(map);
var baseMaps = { "<span style='color: blue; font-weight: bold;'>Imagery": Imagery,
                 "<span style='color: blue; font-weight: bold;'>NatGeo": NatGeo,
                 "<span style='color: blue; font-weight: bold;'>Streets": Streets                 
               };
      
// The overlay markers to show by default                 
Stations.addTo(map);

// Temp markers to mark the corners of the viewable map, uncomment to use
	<?php echo "$cornerMarkers";  ?>	

var bounds = L.latLngBounds(<?php echo "$fitBounds" ?>); 
var middle = bounds.getCenter(); // alert(middle); //LatLng(-93.20448, 38.902475)
var padit  = bounds.pad(.075);   // add a little bit to the corner bounding box
var sw = padit.getSouthWest();   // get the SouthWest most point
var nw = padit.getNorthWest();
var ne = padit.getNorthEast();
var se = padit.getSouthEast();

var redmarkername = "images/markers/red_50_flag.png";
var bluemarkername = "images/markers/blue_50_flag.png";

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

// From poiMarkers.php
//var listfrompioMarkers = '<?php echo "$classList"; ?>'; 
//var classList = listfrompioMarkers.split(",");
var classList = '<?php echo "$classList CornerL"; ?>'.split(','); //alert(classList); // EOCL,FireL,HospitalL,RepeaterL,SheriffL,SkyWarnL,

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
    }else if (x == ' CornerL') {
        let Corners = {"<img src='images/markers/red_50_flag.png' align='middle' /> <span class='corners'>Corners</span>":
            CornerList};
        y = {...y, ...Corners};
    }}; 
    
// Here we add the station object with the merged y objects from above
var overlayMaps = {...y };  //alert(JSON.stringify(overlayMaps));

//console.log(overlayMaps);

// Set the center point of the map based on the coordinates
map.fitBounds(<?php echo "$fitBounds" ?>, {
  pad: 0.5
});

L.control.layers(baseMaps, overlayMaps, {position:'bottomright', collapsed:false}).addTo(map);


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
     
      // Same as above but does NOT includes a mi for miles box or other measures
  //  L.control.scale ({maxWidth:240, metric:false, imperial:true, position: 'bottomleft'}).addTo (map);
   //         L.control.polylineMeasure ({position:'topright', unit:'landmiles', showBearings:false, clearMeasurementsOnStop: false, showClearControl: true, showUnitControl: false}).addTo (map);

// To use the getCenter() of latLngBounds you need to set a var = to it, then define it in another var
//var bounds = L.latLngBounds(<?php echo "$cntPoints" ?>); 
//var middle = bounds.getCenter();
//var sw = bounds.getSouthWest();       
//var E  = bounds.getEast();  
//var tBBS = bounds.toBBoxString();
//alert('tBBS: '+tBBS);                   // 38.8183241,-95.433417,39.5697989,-94.259896
//alert('E: '+E);                         // 39.5697989
//alert('sw: '+sw);                       // LatLng(-95.433417, 38.818324)
//alert('middle: '+middle);               // LatLng(-94.846656, 39.194062)
//alert('Map middle: '+map.getCenter());  // LatLng(39.194424, -94.846656)


var circfeqcnt = 0; // Sets a variable to count how many times the circleKoords() function is called
function circleKoords(e) {
   circfeqcnt = circfeqcnt + 1; //alert(circfeqcnt);
    
   if (circfeqcnt <= 1) { var circolor  = 'blue';  }
   else if (circfeqcnt == 2) { var circolor  = 'red'; }
   else if (circfeqcnt == 3) { var circolor  = 'green'; }
   else if (circfeqcnt == 4) { var circolor  = 'yellow'; }
   else if (circfeqcnt > 4) { var circolor  = 'purple'; }
   
   var myJSON = JSON.stringify(e.latlng); 
   //alert("myJSON "+myJSON); 
   
   var LatLng = e.latlng;
   var lat = e.latlng["lat"]; 
   var lng = e.latlng["lng"]; 
   
   var i; var j;
   var r = 1609.34;  // in meters = 1 mile, 4,828.03 meters in 3 miles
   
   //https://jsfiddle.net/3u09g2mf/2/   
   //https://gis.stackexchange.com/questions/240169/leaflet-onclick-add-remove-circles
   var group1 = L.featureGroup(); // Allows us to group the circles for easy removal
   
   var circleOptions = {
       color: circolor,
       fillOpacity: 0.005 ,
       fillColor: '#69e'
   }  
   
   var milesbetween = 0; 
   var numberofrings = 0;  
   
   
   // This routine sets a default number of miles between circles and the number of circles
   // Based on the number of circles selected and marker that was clicked it calculates 
   // the distance to the furthest corner and returns an appropriate number of circles
   // to draw to reach it, auto magically.
   // Variable mbc is the default number of miles between circles.
   // Variable nor is the calculated number of cirles. Based on the furthest corner from the clicked marker.
   var mbc = 5; // Overall default for miles between circles
      
      // Calculate distance from clicked marker to each of the corner markers
   var nor = Math.max( LatLng.distanceTo( se ), LatLng.distanceTo( ne ), 
                       LatLng.distanceTo( nw ), LatLng.distanceTo( sw ))/1609.34;
            // Set the new calculated distance between markers, 5 is the default mbc
        if (nor >= 50) {mbc = 25;}
        else if (nor <= 10) {mbc = 2;}
        else {mbc = 5;}
      
   var milesbetween = prompt("How many miles between circles?", mbc);
   		if (milesbetween <= 0) {milesbetween = 1;} 
   		//if (milesbetween > 0 && milesbetween <= 10) {milesbetween = 2;}
   		
   var nor = nor/milesbetween;
   
   var numberofrings = prompt("How many circles do you want to see?", Math.round(nor));
   		if (numberofrings <= 0) {numberofrings = 5;}	
   		
    
   angle1 = 90;  // mileage boxes going East
   angle2 = 270; // mileage boxes going West
   angle3 = 0;   // degree markers
   
     
   // The actual circles are created here at the var Cname =
   for (i=0 ; i < numberofrings; i++ ) {
         var Cname = 'circle'+i; 
            r = (r * i) + r; 
            r = r*milesbetween; //alert(Cname r);
         var Cname = L.circle([lat, lng], r, circleOptions);
            Cname.addTo(group1); 
          map.addLayer(group1);
         //90° from top
                  // angle1, angle2 puts the mileage markers on the lines p_c1 and p_c2
         angle1 = angle1 + 10;
         angle2 = angle2 + 10;
         
            // i is the number of rings, depending how many have been requested the delta between bears
            // will be adjusted from 15 degrees at the 2nd circle to 5 degrees at the furthest.
            if ( i === 0  ) { //alert(numberofrings);
                for (j=0; j < 360; j+=15) {
                    // j in the icon definition is the degrees 
                    var p_c0 = L.GeometryUtil.destination(L.latLng([lat, lng]),angle3,r);
                    var icon = L.divIcon({ className: 'deg-marger', html: j , iconSize: [40,null] });
                    var marker0 = L.marker(p_c0, { title: 'degrees', icon: icon});
                        marker0.addTo(map);
                            angle3 = angle3 + 15;
                }
            }   else if ( i === 5 ) {
                    for (j=0; j < 360; j+=10) {
                    // j in the icon definition is the degrees 
                    var p_c0 = L.GeometryUtil.destination(L.latLng([lat, lng]),angle3,r);
                    var icon = L.divIcon({ className: 'deg-marger', html: j , iconSize: [40,null] });
                    var marker0 = L.marker(p_c0, { title: 'degrees', icon: icon});
                        marker0.addTo(map);
                            angle3 = angle3 + 10;
                }         
            }   else if ( i === numberofrings-1 ) {
                    for (j=0; j < 360; j+=5) {
                    // j in the icon definition is the degrees 
                    var p_c0 = L.GeometryUtil.destination(L.latLng([lat, lng]),angle3,r);
                    var icon = L.divIcon({ className: 'deg-marger', html: j , iconSize: [40,null] });
                    var marker0 = L.marker(p_c0, { title: 'degrees', icon: icon});
                        marker0.addTo(map);
                            angle3 = angle3 + 5;
                } // End for loop         
            } // end of else if
        
         var p_c1 = L.GeometryUtil.destination(L.latLng([lat, lng]),angle1,r);
         var p_c2 = L.GeometryUtil.destination(L.latLng([lat, lng]),angle2,r);
         //var inMiles = (toFixed(0)/1609.34)*.5;
         var inMiles = Math.round(r.toFixed(0)/1609.34);
         var inKM = Math.round(r.toFixed(0)/1000);
         // Put mile markers on the circles
         
         var icon = L.divIcon({ className: 'dist-marker-'+circolor, html: inMiles+' Mi <br> '+inKM+' Km', iconSize: [60, null] });
         
         var marker = L.marker(p_c1, { title: inMiles+'Miles', icon: icon});
         var marker2 = L.marker(p_c2, { title: inMiles+'Miles', icon: icon});
      
         //$(".dist-marker").css("color", circolor);
         marker.addTo(map);
         marker2.addTo(map);
         //$(".dist-marker").css("color", circolor);
         
        // reset r so r calculation above works for each 1 mile step 
        r = 1609.34;     
    }
    
    // This part allows us to delete the circles by simply clicking anywhere in the circles.
    group1.on('click', function() {
        if(map.hasLayer(group1)) {map.removeLayer(group1);}
    });
} // end circleKoords function


// Change the position of the Zoom Control to a newly created placeholder.
map.zoomControl.setPosition('topright');

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
	    

</script>

</body>
</html>