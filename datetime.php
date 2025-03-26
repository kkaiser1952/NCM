<?php
/**
 * Net Control Manager (NCM) - Date and Time Display Component
 * Copyright 2015-2025 Keith Kaiser, WA0TJT
 * Contact: wa0tjt@gmail.com
 */
?>
<!-- From showDTTM() in NetManager-p2.js -->
<p class="tb1 TipBubbles initiallyHidden" style="width: 200px; margin-bottom: 40px;">
	<a class="tipimage" href="https://net-control.us/help.php#assumptions" target="_blank">Choose Your Time Zone</a>
</p>
	
<div id="dttm"> <!-- flex container -->
    <div id="dttm1">
        <input type="radio" name="tz" id="theLocal" value="theLocal" size="60" onclick="goLocal()">
        <br>
        <input type="radio" name="tz" id="theUTC" value="theUTC" onclick="goUTC()">
    </div>

    <!-- To comment this function: comment setInterval('showDTTM()', 1000); in netManager-p2.js -->
	<div id="dttm2">
	</div>  <!-- Friday, August 24, 2018 1:55:13 PM  -->
</div> <!-- end flex container -->