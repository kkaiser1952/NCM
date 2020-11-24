<!DOCTYPE html>
<html>
    <head>
	<meta charset="utf-8">
		<title>Ham Radio Maidenhead Grid Square Locator Geocoding with Google Maps by HA8TKS</title>
		<meta name="description" content="Ham Radio Maidenhead Grid Square Locator with Google Maps QTH locator QRA HA8TKS" />
		<script type="text/javascript" src="../jquery/jquery.js"></script>
		<script type="text/javascript" src="../js/ham_geocoding.js"></script>
        <script type="text/javascript" src="https://maps.google.com/maps/api/js"></script>
		<link rel="stylesheet" href="../css/hamgeocoding.css" />
	<script type="text/javascript">

		var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-53598745-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ?  'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>	
		
    </head>
    
		<body onload="init()">
		<div class="container">
				
				
				<div  class="fent">
					<div class="label3">Grid square:</div>
						<input class="input2" id="locator_klick" name="lockatt" maxlength="6" type=text  />
					<div class="label3">Locality: </div>
					<input class="input1"  id="locality" name="lockatt_locality" type=text /> 
					<div class="label3">Country: </div>
					<!--<input class="input1"  id="country" name="lockatt_country" size="30" />-->
					<div class="input1"  id="country" name="lockatt_country" size="30" />&nbsp;</div>
					<div class="clear"></div>	
				</div>
					<input class="link_button" id="dxcluster_list_button" type="button" value="Goto HA8TKS dxcluster list" />
					<div class="messages">Enter 6 character grid square or Enter locality or Click on the map!</div>
					<input class="link_button" id="dxcluster_map_button" type="button" value="Goto HA8TKS dxcluster map" />
				<div id='map_canvas' style=' width: 1025px; height: 500px; '></div>	
				<div class="gps">
	                <div class="label4">&nbsp;© 2014 by <a href="http://www.ha8tks.hu">HA8TKS</a></div>
					<div class="label2">Latitude: </div><div class="latlng" id="lngDeg">&nbsp;</div>
					<div class="label2">Longitude: </div><div class="latlng" id="latDeg">&nbsp;</div>
					<div class="label2">Maidenhead locator or QTH grid square: </div>
					<div  class="latlng" id="locator">&nbsp;</div>
					<div><input class="clear_button" id="clear_button" type="button" value="clear all field and show world map" />  </div>
					<div class="clear"></div>	
				</div>
	   </div>
     </body>
</html>