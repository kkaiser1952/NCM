
<?php
ini_set('display_errors',1); 
	error_reporting (E_ALL ^ E_NOTICE);

    require_once "dbConnectDtls.php";  // Access to MySQL
    
    $netID = intval($_POST["q"]); 
    
    if($netID) {
        $sql = ("
    		UPDATE NetLog SET pb = 1
    		 WHERE netID = $netID
    	");
	
            $db_found->exec($sql);
	};
	
	?>