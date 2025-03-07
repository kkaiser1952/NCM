<?php
/**
 * page-header.php - Top section of the page including logo and weather info
 */
?>
<header>
<!-- Upper left corner of opening page -->
<div class="openingImages">
    <!-- NCM and Net Control Manager images at top left of page -->
    <img id="smtitle" src="images/NCM.png" alt="NCM" >
    <img id="pgtitle2" src="images/NCM3.png" alt="NCM2" >
    
    <span id="version">
        <!-- V2 work in progress -->
    	<a href="https://groups.io/g/NCM" target="_blank">V2 About</a> 
    </span> <!-- End of id version -->
    
</div> <!-- End class openingImages -->
</header>

<!-- To hold the netID current value -->
<!-- Values supplied by ....     -->
<input type='hidden' id='currentNetID' value=''>

<div id="dttm"> <!-- flex container -->
    <div id="dttm1">
        <input type="radio" name="tz" id="theLocal" value="theLocal" size = "60" onclick="goLocal()">
        <br>
        <input type="radio" name="tz" id="theUTC" value="theUTC" onclick="goUTC()" >
    </div>

    <!-- To comment this function: comment setInterval('showDTTM()', 1000); in netManager-p2.js -->
	<div id="dttm2">
	</div>  
</div> <!-- end flex container -->


<div class="weather-place">
    <img src="images/US-NWS-Logo.png" alt="US-NWS-Logo" width="50" height="50" onclick="newWX()">
    <a href="https://www.weather.gov" class="theWX" target="_blank" rel="noopener">
        <?php
        if ($weatherData !== false) {
            echo "{$weatherData['location']}: {$weatherData['description']}, " .
                 "{$weatherData['temperature']}F, wind: {$weatherData['windDirection']} @ " .
                 "{$weatherData['windSpeed']}, humidity: {$weatherData['humidity']}%";
        } else {
            echo "Weather information unavailable";
        }
        ?>
    </a>
</div> <!-- End of class: weather-place -->