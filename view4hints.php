<?php
// This program creates a View from NetLog of calls that have logged into the new net in the past 4 months
require_once "dbConnectDtls.php";

	$q = $_GET['q'];

        $sql = "CREATE VIEW CONCAT('ncm.hint','$q') AS 
                SELECT DISTINCT (callsign), CONCAT(Fname,' ',Lname,' --> ',state,'--',county) AS name
                  FROM NetLog
                WHERE netcall = '$q'
                  AND logdate > DATE_SUB(now(), INTERVAL 4 MONTH)
        ;	  	
?>