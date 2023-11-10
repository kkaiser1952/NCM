<?php
	// This program is used by the net_by_number() function to help produce a browse only net on screen
	// Written 2020-09-03 by WA0TJT
	
	ini_set('display_errors',1); 
	error_reporting (E_ALL ^ E_NOTICE);

    require_once "dbConnectDtls.php";
    
    $q = $_GET['q'];  //echo "q is $q";
    //$q = 10005; 

	/* Added the class stuff on 2018-1-17 */
       $sql = ("
	    SELECT CONCAT(netcall,' ',activity,' for: ', DATE_FORMAT(logdate,'%Y-%m-%d')) as activity
          FROM NetLog 
         WHERE netID = :netId
           AND LOGDATE <> 0
         LIMIT 1
        ");
        
        $stmt = $db_found->prepare($sql);
        $stmt->bindParam(':netId', $q, PDO::PARAM_INT);
        $stmt->execute();
        
            $ts = $stmt->fetchColumn();  
                echo "$ts";        
?>