<!doctype html>

<?php

	ini_set('display_errors',1); 
	error_reporting (E_ALL ^ E_NOTICE);

    require_once "dbConnectDtls.php";
    
    $q = intval( $_GET["NetID"] ); //  $q = 2686;
    
// https://gist.github.com/apocratus/936404/8032b001a5f5ea3cdda0501399fc69b94bb30184#file-export_csv-php			
                
            // create var to be filled with export data
            $csv_export = '';
            
            // query to get data from database
        $sql = ("SELECT * 
                    FROM NetLog
                   WHERE netID = 2514 
                ");
        
					
    foreach($db_found->query($sql) as $row) {
            $csv_export.= '"'.$row[mysql_field_name($query,$i)].'",';
    }
    	
              $csv_export.= '
            ';	
            
            
            // Export the data and prompt a csv file for download
            header("Content-type: text/x-csv");
            header("Content-Disposition: attachment; filename=".$csv_filename."");
            echo($csv_export);
    	       	
    	       
    
           
?>


