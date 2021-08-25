<?php
    // 2020-11-20 KK ==> Collects all the email address from the net
    error_reporting( 0 );
	//date_default_timezone_set("America/Chicago");
	require_once "dbConnectDtls.php";    
	
	$q = intval($_GET['netID']); 	
	//$q = 3155;
	
        $sql = ("SELECT GROUP_CONCAT(DISTINCT email SEPARATOR ', ') 
                  FROM `NetLog` 
                 WHERE netID = $q
                   AND email <> ''
                 LIMIT 0,1
                ");
        
            $stmt = $db_found->prepare($sql);
            $stmt -> execute();
            $netEmails = $stmt->fetchColumn(0);
  		
          // the htmlspecialchars(urldecode() stuff is so characters after the ampersand are still returned
          echo (htmlspecialchars(urldecode("$netEmails")));
?>