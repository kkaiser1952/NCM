<?php
/**
 * Net Control Manager (NCM) - Weather Display Component
 * Copyright 2015-2025 Keith Kaiser, WA0TJT
 * Contact: wa0tjt@gmail.com
 */
?>
<p class="tb1 TipBubbles initiallyHidden" style="left: 100px; width: 450px;  margin-bottom: 30px;">
    <a class="tipimage" href="https://net-control.us/help.php#assumptions" target="_blank">Clickable Weather Report based on your IP Address</a>
</p>
<div class="weather-place">
    <img src="images/US-NWS-Logo.png" alt="US-NWS-Logo" width="50" height="50" onclick="newWX()">

    <a href="https://www.weather.gov" class="theWX" target="_blank" rel="noopener">
        <!-- CurrentWX() was developed by Jeremy Geeo, KD0EAV Found in wx.php -->
        <?php echo getOpenWX(); ?>   <!-- from wx.php -->
    </a>  
</div> <!-- End of class: weather-place -->