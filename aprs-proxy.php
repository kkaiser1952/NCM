<?php
  $callssid = $_GET["callssid"];
  $url = "https://api.aprs.fi/api/get?name=" . $callssid . "&what=loc&apikey=5275.AYRjLwAFgx6ud&format=json";
  $data = file_get_contents($url);
  header('Content-Type: application/json');
  header('Access-Control-Allow-Origin: *');
  echo $data;
?>
