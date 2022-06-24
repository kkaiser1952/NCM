<?php
include( 'wx.php' );

$geo = getGeoIP();
$lat = $geo->lat;
$lon = $geo->lon;

print_r( getOpenWX() );


?>
