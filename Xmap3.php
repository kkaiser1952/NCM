<!DOCTYPE html>

<!-- Primary maping program, also uses poiMarkers.php, objMarkers.php and stationMarkers.php -->

<!-- ??? means I have a question about what this does -->

<?php 
	
	ini_set('display_errors',1); 
	error_reporting (E_ALL ^ E_NOTICE);

    require_once "dbConnectDtls.php";  // Access to MySQL
    require_once "GridSquare.php";
    
    
    // Value comes from an open not or prompt 
    $q = intval($_GET["NetID"]); 
    //$q = 3818; 
    $q = 4743;
    
    	       
	// Loads the programs that create the station, poi, and object markers
	require_once "stationMarkers.php";
    require_once "poiMarkers.php";    
    require_once "objMarkers2.php"; 
?>

<html lang="en">
<head>
	<title>NCM Map of Station Locations</title>

	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<link rel="shortcut icon" type="image/x-icon" href="images/favicon.png" >

     <!-- ******************************** Load LEAFLET from CDN *********************************** -->
     <link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css"
     integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ=="
     crossorigin=""/>
     
     <script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js"
         integrity="sha512-gZwIG9x3wUXg2hdXF6+rVkLF/0Vi9U8D2Ntg4Ga5I5BZpVkVxlJWbSQtXPSiUTtC0TjtGOmxa1AJPuV0CPthew=="
             crossorigin=""></script>
     <!-- ********************************* End Load LEAFLET **************************************** -->
     
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    
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
    
    <script src="https://assets.what3words.com/sdk/v3/what3words.js?key=5WHIM4GD"></script>


     
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
    
        
    <!-- What 3 Words -->
    <script src="js/control.w3w.js"></script>

    
    <!-- circleKoords is the javascript program that caluclates the number of rings and the distance between them -->
    <script src="js/circleKoords.js"></script>    
    

	<style>
		/* All CSS is in css/maps.css */
	</style>
	
</head>

<body>
    
    <!-- the map div holds the map -->
    <div id="map"></div>
    
    <!-- the stations div holds a list of the stations marked on the map -->
    <!-- Under the banner in the upper left corner -->
    <div id="stations"> 
		<b style="color:red; text-decoration: underline;">
		    <?php echo "<b>$logrow[netcall]</b><br>$stationList";?>
	</div>

    <!-- The title banner -->
    <div id="activity" class="activity">
    	<img src="images/NCM.png" alt="NCM" style="width: 35px; padding-left: 10px; padding-top: 5px;">
    	<?php echo"$netcall Net #$logrow[netID] $logrow[activity] $logrow[logdate]" ?>
    </div>
    

<!-- Everything is inside a javascript, the script closing is near the end of the page -->
<script> 
// This function can be used to connect the markers together with a line
function connectTheDots(data){
    var c = [];
    for(i in data._layers) {
        var x = data._layers[i]._latlng.lat;
        var y = data._layers[i]._latlng.lng;
        c.push([x, y]);
    }
    return c;
}

    
// Define the map
var map = L.map('map', {
	drawControl: true,
	zoom: 12
}); 
	
	var stationMarkers = [];
    var fg = new L.featureGroup();
    
  
    // Flags for use as corners markers
    const blackmarkername         = "BRKMarkers/black_flag.svg";
    const bluemarkername          = "BRKMarkers/blue_flag.svg";
    const darkgreenmarkername     = "BRKMarkers/darkgreen_flag.svg";
    const greenmarkername         = "BRKMarkers/green_flag.svg";
    const graymarkername          = "BRKMarkers/grey_flag.svg";
    const lightbluemarkername     = "BRKMarkers/lightblue_flag.svg";  
    const orangemarkername        = "BRKMarkers/orange_flag.svg";   
    const purplemarkername        = "BRKMarkers/purple_flag.svg";
    const redmarkername           = "BRKMarkers/red_flag.svg";
    const whitemarkername         = "BRKMarkers/white_flag.svg";
    const goldmarkername          = "BRKMarkers/yellow_flag.svg";
    const plummarkername          = "BRKMarkers/plum_flag.svg";
    
    // Center markers
    const manInTheMiddle_50       = "BRKMarkers/black_flag.svg";
    const blackmanInTheMiddle     = "BRKMarkers/black_man.svg";
    const bluemanInTheMiddle      = "BRKMarkers/blue_man.svg";
    const darkgreenmanInTheMiddle = "BRKMarkers/darkgreen_man.svg";
    const greymanInTheMiddle      = "BRKMarkers/grey_man.svg";
    const graymanInTheMiddle      = "BRKMarkers/grey_man.svg";
    const lightbluemanInTheMiddle = "BRKMarkers/lightblue_man.svg";
    const orangemanInTheMiddle    = "BRKMarkers/orange_man.svg";
    const pinkmanInTheMiddle      = "BRKMarkers/pink_man.svg";
    const purplemanInTheMiddle    = "BRKMarkers/purple_man.svg";
    const redmanInTheMiddle       = "BRKMarkers/red_man.svg";
    const whitemanInTheMiddle     = "BRKMarkers/white_man.svg";
    const goldmanInTheMiddle      = "BRKMarkers/yellow_man.svg";
    const plummanInTheMiddle      = "BRKMarkers/plum_man.svg";

	
	// Define the layers for the map
    const Streets = L.esri.basemapLayer('Streets').addTo(map),
          Imagery = L.esri.basemapLayer('Imagery').addTo(map),
          Topo    = L.esri.basemapLayer('Topographic').addTo(map),
          NatGeo  = L.esri.basemapLayer('NationalGeographic').addTo(map);
    
    const baseMaps = { "<span style='color: blue; font-weight: bold;'>Imagery": Imagery,
                       "<span style='color: blue; font-weight: bold;'>NatGeo": NatGeo,
                       "<span style='color: blue; font-weight: bold;'>Topo": Topo,
                       "<span style='color: blue; font-weight: bold;'>Streets": Streets               
                     };
                   
     
    L.control.mousePosition({separator:',',position:'topright',prefix:''}).addTo(map);
    
    // https://github.com/ppete2/Leaflet.PolylineMeasure
    // Position to show the control. Values: 'topright', 'topleft', 'bottomright', 'bottomleft'
    // Show imperial or metric distances. Values: 'metres', 'landmiles', 'nauticalmiles'           
    L.control.polylineMeasure ({position:'topright', unit:'landmiles', showBearings:true, clearMeasurementsOnStop: false, showClearControl: true, showUnitControl: true}).addTo (map);
    
    // Change the position of the Zoom Control to a newly created placeholder.
    map.zoomControl.setPosition('topright');
    
    // Distance scale 
    L.control.scale({position: 'bottomright'}).addTo(map);  
    
    // Define the Plus and Minus for zooming and its location
    map.scrollWheelZoom.disable();  // prevents the map from zooming with the mouse wheel
    
    // Add what3words, shows w3w in a control
    var w = new L.Control.w3w();
	    w.addTo(map);
        map.on('click', function(e) {
		console.log(e);
		w.setCoordinates(e);
	});
	
    // Adds a temp marker popup to show location of click
    var popup = L.popup();
    
    // Define a PoiIcon class for use by Points of Interest
    var PoiIconClass = L.Icon.extend({
        options: {
            iconSize: [32, 37]
        }
    });

    // Define a ObjIcon class for use by Objects from APRS or W3W
    var ObjIconClass = L.Icon.extend({
        options: {
            iconSize: [32, 37]
        }
    });
    
    // Add what3words, shows w3w in a control
    var w = new L.Control.w3w();
    	w.addTo(map);
    	map.on('click', function(e) {
    		console.log(e);
    		w.setCoordinates(e);
    	});
	
    // Adds a temp marker popup to show location of click
    //var popup = L.popup();
    function onMapClick(e) {
        popup
            .setLatLng(e.latlng)
            .setContent("You clicked the map at:<br>" + e.latlng.toString() + "<br>"  )
            .openOn(map);
    }
    
    map.on('click', onMapClick);

    // adds the lat/lon grid lines, read them on the top and on the left
    L.grid().addTo(map);  
    

    // Change the position of the Zoom Control to a newly created placeholder.
    map.zoomControl.setPosition('topright');


   // L.control.scale().addTo(map);

    var arcgisOnline = L.esri.Geocoding.arcgisOnlineProvider();


    // Create some icons from the above PoiIconClass class and one from ObjIconClass
    var firstaidicon  = new PoiIconClass({iconUrl: 'images/markers/firstaid.png'}),
        eocicon       = new PoiIconClass({iconUrl: 'images/markers/eoc.png'}),
        policeicon    = new PoiIconClass({iconUrl: 'images/markers/police.png'}),
        skywarnicon   = new PoiIconClass({iconUrl: 'images/markers/skywarn.png'}),
        fireicon      = new PoiIconClass({iconUrl: 'images/markers/fire.png'}),
        repeatericon  = new PoiIconClass({iconUrl: 'markers/repeater.png'}),
        govicon       = new PoiIconClass({iconUrl: 'markers/gov.png'}),
        
        objicon       = new ObjIconClass({iconURL: 'images/markers/marker00.png'}),          // the 00 marker
    
        blueFlagicon  = new ObjIconClass({iconUrl: 'BRKMarkers/blue_flag.svg'}),
        greenFlagicon = new ObjIconClass({iconUrl: 'BRKMarkers/green_flag.svg'});
        
    
    // These are the markers that will appear on the map
    // Bring in the station markers to appear on the map
    <?php
        echo ("$stationMarkers");   // All the checked in stations   
        echo ("$poiMarkers");       // The Points of Interest Markers
        echo ("$POIMarkerList");    // The poi Markers list
    ?>

    
    //=======================================================================
    //======================= Station Markers ===============================
    //=======================================================================
        
    var Stations = L.layerGroup([<?php echo "$callsignList"?>]);
    // WA0TJT,W0DLK,KD0NBH,KC0YT,AA0JX,AA0DV

    // Add the stationmarkers to the map
    Stations.addTo(map);
    
    // ???
    // I don't know what this does but without it the POI menu items don't show
    map.fitBounds([<?php echo "$fitBounds"?>]);

    var bounds = L.latLngBounds([<?php echo "$fitBounds"?>]);
        console.log('@371 bounds= '+JSON.stringify(bounds)); 


    // find the corners and middle of the stationmarkers
    var middle = bounds.getCenter(); // alert(middle); //LatLng(-93.20448, 38.902475)
    var padit  = bounds.pad(.075);   // add a little bit to the corner bounding box
    var sw = padit.getSouthWest();   // get the SouthWest most point
    var nw = padit.getNorthWest();
    var ne = padit.getNorthEast();
    var se = padit.getSouthEast();

    //=======================================================================
    //======================= Station Marker Corners ========================
    //=======================================================================
    // POI's do not have corner markers, however they should be restricted to 
    // display within these markers with a little wiggle room
    
    // These are the corner markers of the extended bounds of the stations
    var mk1 = new L.marker(new L.latLng( sw ),{
        icon: L.icon({iconUrl: blackmarkername , iconSize: [220,220] }),
        title:'mk1'}).addTo(map).bindPopup('MK1<br>The SW Corner<br>'+sw).openPopup();
    
    var mk2 = new L.marker(new L.latLng( nw ),{
       icon: L.icon({iconUrl: blackmarkername , iconSize: [220,220] }),
       title:'mk2'}).addTo(map).bindPopup('MK2<br>The NW Corner<br>'+nw).openPopup();
    
    var mk3 = new L.marker(new L.latLng( ne ),{
       icon: L.icon({iconUrl: blackmarkername , iconSize: [220,220] }),
       title:'mk3'}).addTo(map).bindPopup('MK3<br>The NE Corner<br>'+ne).openPopup();
    
    var mk4 = new L.marker(new L.latLng( se ),{
       icon: L.icon({iconUrl: blackmarkername , iconSize: [220,220] }),
       title:'mk4'}).addTo(map).bindPopup('MK4<br>The SE Corner<br>'+se).openPopup();
	
    // Add the temp center marker to the map here in the javascript code allows it to use the current map view,
    // When its earlier in the stack, it centers on our house becaue that is the default map location
    var mk5 = new L.marker(new L.latLng( middle ),{
        contextmenu: true, contextmenuWidth: 140, contextmenuItems: [{ 
        text: 'Click here to add mileage circles', callback: circleKoords}],   
        icon: L.icon({iconUrl: blackmanInTheMiddle , iconSize: [220,220] }),     
        title:'mk5'}).addTo(map).bindPopup('MK5<br>The Center Marker<br>'+middle).openPopup();
    
    // Definition of the 5 markers above, corners plus middle    
     var CornerList = L.layerGroup([mk1, mk2, mk3, mk4, mk5]);
     
    //======================================================================
    // ================== End Station Marker Corners =======================
    //======================================================================
    
     //=================================================================================
    //================ APRS Like Object Marker Corners and all the Objects =============
    // ======= These are Objects created by APRS or W3W from the TimeLog table =========
    //==================================================================================
    
    <?php   
           echo "$objBounds" ;
           echo "$objMiddle" ;
           echo "$objPadit";
    ?>

    // Object markers here
    <?php echo "$objMarkers"; ?>
    
    // Corner and center flags for the object markers, 5 for each callsign that has objects
    <?php echo "$cornerMarkers"; ?>
    


    // Object Marker List starts here
    <?php echo "$OBJMarkerList"; ?>

    // Add the OBJMarkerList to the map
    OBJMarkerList.addTo(map);
            
    // color wheel for the lines
    const colorwheel = ["green","blue","orange","plum","lightblue","gray","gold","black","red"];
       
    <?php echo "$uniqueCallList"; ?>
        console.log('@383 length= '+uniqueCallList.length+' uniqueCallList[1]= '+uniqueCallList[1]);
        
        console.log('@385');
    <?php echo "$allOftheKoords"; ?>
        console.log(W0DLKlatlngs);
        console.log(WA0TJTlatlngs);
        
                  
         
    for (z = 0; z < uniqueCallList.length; z++) {
            console.log('@392 value= '+uniqueCallList[z]);
            // WA0TJTlatlngs  
                            
        newKoords = uniqueCallList[z].slice(0); 
            console.log('@396 '+newKoords);  // output is correct,
            console.log(W0DLKlatlngs);
       
        newcolor = colorwheel[z]; // sets the color in the objectLine below
            console.log('@400 newcolor= '+newcolor); 
            
            
        objectLine = L.polyline(newKoords,{color: newcolor , weight: 5}).addTo(map);
             
    }   
            // Add connecting lines between the corners of the objects
           //<?php echo "$KornerList"; ?>
           //objectKornerKoords = connectTheDots(KornerList);
           //var objectKornerLine = L.polyline(objectKornerKoords,{color: newcolor, weight: 3}).addTo(map);    

    } // end for loop
    
    //====================================================================== 
    //====================== Points of Interest ============================
    //======================================================================    
    // The classList is the list of POI types.
    var classList = '<?php echo "$classList CornerL, ObjectL;"; ?>'.split(',');;
       console.log('@479 in map.php classList= '+classList);
    
    let station = {"<img src='markers/green_marker_hole.png' class='greenmarker' alt='green_marker_hole' align='middle' /><span class='biggreenmarker'> Stations</span>": Stations};

    // Each test below if satisfied creates a javascript object, each one connects the previous to the next 
    // THE FULL LIST:  Hospital ,Repeater ,EOC ,Sheriff ,SkyWarn ,Fire ,CHP ,State ,Federal ,Aviation ,Police ,class
    var y = {...station};
    var x;
    for (x of classList) {
        
        if (x == 'AviationL') {
            let Aviation = {"<img src='images/markers/aviation.png' width='32' align='middle' /> <span class='aviation'>Aviation</span>": AviationList};
            y = {...y, ...Aviation}; 
            
        }else if (x == 'CHPL') {
            let CHP = {"<img src='images/markers/police.png' width='32' height='37' align='middle' /> <span class='polmarker'>Police</span>":  SheriffList};
            y = {...y,...CHP}; 
            
        }else if (x == 'EOCL') {
            let EOC = {"<img src='images/markers/eoc.png' align='middle' /> <span class='eocmarker'>EOC</span>": EOCList};
            y = {...y, ...EOC};
            
        }else if (x == 'FederalL') {
            let Federal = {"<img src='images/markers/gov.png' width='32' height='37' align='middle' /> <span class='gov'>Fed</span>":  FederalList};
            y = {...y,...Federal};
    
            
        }else if (x == 'FireL') {
            let Fire = {"<img src='images/markers/fire.png' align='middle' /> <span class='firemarker'>Fire Station</span>": FireList};
            y = {...y, ...Fire};
            
        }else if (x == 'HospitalL') {
            let Hospital = {"<img src='images/markers/firstaid.png' align='middle' /> <span class='hosmarker'>Hospitals</span>": HospitalList};
            y = {...y, ...Hospital};
            
        }else if (x == 'PoliceL') {
            let Police = {"<img src='images/markers/police.png' width='32' height='37' align='middle' /> <span class='polmarker'>Police</span>": SheriffList};
            y = {...y, ...Police};
            
        }else if (x == 'RepeaterL') {
            let Repeater = {"<img src='images/markers/repeater.png' align='middle' /> <span class='rptmarker'>Repeaters</span>": RepeaterList};
            y = {...y, ...Repeater};
            
        }else if (x == 'SheriffL') {
            let Sheriff = {"<img src='images/markers/police.png' width='32' height='37' align='middle' /> <span class='polmarker'>Police</span>":  SheriffList};
            y = {...y,...Sheriff};
            
        }else if (x == 'SkyWarnL') {
            let SkyWarn = {"<img src='images/markers/skywarn.png' align='middle' /> <span class='skymarker'>SkyWarn</span>": SkyWarnList};
            y = {...y, ...SkyWarn};    
            
        }else if (x == 'StateL') {
            let State = {"<img src='images/markers/gov.png' width='32' height='37' align='middle' /> <span class='polmarker'>State</span>":  SheriffList};
            y = {...y,...State};
            
        }else if (x == 'ObjectL') {
            let Objects = {"<img src='images/markers/marker00.png' align='middle' /> <span class='objmrkrs'>Objects</span>": ObjectList};
            y = {...y, ...Objects}; 
            
        }else if (x == ' CornerL') {
            let Corners = {"<img src='images/markers/red_50_flag.png' align='middle' /> <span class='corners'>Corners</span>": CornerList};
            y = {...y, ...Corners};
        }}; // End of for loop
        
        // Here we add the station object with the merged y objects from above
    var overlayMaps = {...y }; 
    
    // This must stay here to properly display on the map
    L.control.layers(baseMaps, overlayMaps, {position:'bottomright', collapsed:false}).addTo(map); 
    
   $('.leaflet-control-attribution').hide()
    
    //var Name = L.control.attribution({position: 'bottomleft', prefix: '<span class="AttributionClass">WA0TJT</span>'}).addTo(map);
    

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
	    

</script>   <!-- End of javascript holding the map stuff -->


</body>
</html>
