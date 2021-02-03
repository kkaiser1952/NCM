<!doctype html>
<!-- https://developers.google.com/chart/interactive/docs/basic_load_libs -->
<!-- YouTube:  https://www.youtube.com/watch?v=mKOz5fZ8HV0 -->
<?php

			ini_set('display_errors',1); 
			error_reporting (E_ALL ^ E_NOTICE);
		
		    require_once "dbConnectDtls.php";
		    
	// Count number of logged station by day of the week 	    
    $sql = "SELECT DAYOFWEEK(logdate) as dow,
                   COUNT(logdate) as ldCnt	
              FROM `NetLog`
             WHERE netID <> 0
               AND logdate <> 0
             GROUP BY DAYOFWEEK(logdate)
           ";
		    
		    
?>

