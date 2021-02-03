<?php
    
    define('CONST_USER_TIMEZONE', 'America/Chicago');
    /* server timezone */
    define('CONST_SERVER_TIMEZONE', 'EDT'); /* CDT for standard time, EDT for daylight  */ 

    /* server dateformat */
    define('CONST_SERVER_DATEFORMAT', 'Y-m-d H:i:s');


function now($str_user_timezone = CONST_USER_TIMEZONE,
           $str_server_timezone = CONST_SERVER_TIMEZONE,
         $str_server_dateformat = CONST_SERVER_DATEFORMAT) {
             
             echo "$str_server_timezone";

  // set timezone to user timezone
  date_default_timezone_set($str_user_timezone);

  $date = new DateTime('now');
  $date->setTimezone(new DateTimeZone($str_server_timezone));
  $str_server_now = $date->format($str_server_dateformat);

  // return timezone to server default
  date_default_timezone_set($str_server_timezone);
  

  return $str_server_now;
}

$open  = now(CONST_USER_TIMEZONE,CONST_SERVER_TIMEZONE,CONST_SERVER_DATEFORMAT);

echo "<br>open= $open";
?>