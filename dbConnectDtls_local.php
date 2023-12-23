<?php
	/**
 * This is in /Applications/MAMP/htdocs 
 * Modified on 2020-02-29 to use UTC instead of central time zone
 * Converts current time for given timezone (considering DST)
 *  to 14-digit UTC timestamp (YYYYMMDDHHMMSS)
 *
 * DateTime requires PHP >= 5.2
 *
 * @param $str_user_timezone
 * @param string $str_server_timezone
 * @param string $str_server_dateformat
 * @return string
 */
 
    $hamcallpw = 'tjt0aw52';  // used by getDXstationInfo.php for hamcall
 
/*	define('CONST_USER_TIMEZONE', 'America/Chicago'); */ /* change to UTC */
	define('CONST_USER_TIMEZONE', 'UTC');
	/* server timezone */
/*	define('CONST_SERVER_TIMEZONE', 'CDT'); */ /* CDT for standard time, EDT for daylight  */ /* Change to UTC */
    define('CONST_SERVER_TIMEZONE', 'UTC');
    
	/* server dateformat */
	define('CONST_SERVER_DATEFORMAT', 'Y-m-d H:i:s');
	
	


function now($str_user_timezone = CONST_USER_TIMEZONE,
           $str_server_timezone = CONST_SERVER_TIMEZONE,
         $str_server_dateformat = CONST_SERVER_DATEFORMAT) {
 
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

$strHostName = "localhost";
$strUserName = "ncm";
$strPassword = "CvN9qLGMFxrMLOBh";
$strDbName = "ncm";

//mysqldump -u ncm -p --compatible=mysql40 --default-character-set=utf8 --hex-blob --skip-triggers ncm > dump.sql



//mysql_set_charset('utf8');

try {
	$db_found = new PDO("mysql:host=$strHostName;port=3306;dbname=$strDbName;charset=utf8", $strUserName, $strPassword, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
    // set the PDO error mode to exception
    $db_found->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
  // mysql_query("SET time_zone = 'America/Chicago'");
	//echo "Connected successfull    ";
	}
catch(PDOException $e) {
	echo "Connection failed: " . $e->getMessage();
}

?>