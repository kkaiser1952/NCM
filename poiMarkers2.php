<?php
    ini_set('display_errors',1); 
	error_reporting (E_ALL ^ E_NOTICE);

    require_once "dbConnectDtls.php";  // Access to MySQL

			
  // test
        $sql = (" SELECT name FROM poi WHERE tactical = '';  ");         
        
            $acronym = "";
            foreach($db_found->query($sql) as $row) {
                
                $words = explode(" ", "$row[name]");
                foreach ($words as $w) {
                $acronym .= "$w[0]";      
                }      
                
                $acronym .= "$acronym<>";
            }; // End foreach

            echo($acronym);
		    
?>