<?php 
	move this to javascript
    
    $koords = $_GET['koords']; 
    
    $koords = "39.202:-94.602";
    
    $koords = explode(":",$koords);
    
    $lat = $koords[0];
    $lon = $koords[1];
    
   // echo("$koords, $lat, $lon");
    
    window.open("https://www.qrz.com/hamgrid?lat=$lat&lon=$lon");

    /* https://www.qrz.com/hamgrid?lat=37.867910&lon=-93.269082 */

?>