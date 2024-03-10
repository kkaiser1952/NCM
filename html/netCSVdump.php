<?php
	// netCVSdump.php is used to create an automatically downloaded CSV file of any net or the open net
	// The click point is at the bottom of any open net, called "Export CSV"
	// Partial source:
	// Written 2020-09-06 by WA0TJT
	
// https://net-control.us/netCSVdump.php   From an open net
// https://net-control.us/netCSVdump.php?netID=2825   For any net
	
	ini_set('display_errors',1); 
	error_reporting (E_ALL ^ E_NOTICE);

    require_once "dbConnectDtls.php";
    
    //$q = $_GET['q'];  //echo "q is $q";
    $q = intval( $_GET["netID"] );
    //$q = 2807;
    
    // get the date the net was started to use as part of the output file name
    $sql = $db_found->prepare("SELECT MIN(DATE(logdate)) FROM NetLog WHERE netID = '$q' limit 1" );
    	$sql->execute();
    	$ts = $sql->fetchColumn();
    	       
    // Now lets go get the Time Line data
    // get the data 
	$sql = "SELECT netID, subNetOfID, netcall, activity, min(logdate) as logopentime, logclosedtime
	          FROM NetLog 
	         WHERE netID = $q
	         limit 0,1
           ";
           
        $statement = $db_found->prepare($sql);
 
        //Executre our SQL query.
        $statement->execute();
         
        //Fetch all of the rows from our MySQL table.
        $rows = $statement->fetchAll(PDO::FETCH_ASSOC);
        
        //Get the column names.
        $columnNames = array();
        if(!empty($rows)){
            //We only need to loop through the first row of our result
            //in order to collate the column names.
            $firstRow = $rows[0];
            foreach($firstRow as $colName => $val){
                $columnNames[] = $colName;
            }
        }
        
        $filename = "NCM_Log$q-" . $ts . ".csv";
        
        //Set the Content-Type and Content-Disposition headers to force the download.
        header('Content-Type: text/csv; charset-utf-8');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
         
        //Open up a file pointer
        $fp = fopen('php://output', 'w');
        
        //Start off by writing the column names to the file.
        fputcsv($fp, $columnNames);
        
        //Then, loop through the rows and write them to the CSV file.
        foreach ($rows as $row) {
            fputcsv($fp, $row);
        }
        
  
    fputcsv($fp, []);
    fputcsv($fp, ['Net Log']);
    
    fclose($fp);
    
    ob_start();
    
    // get the data 
	$sql = "SELECT recordID, ID, active, callsign, tactical, Fname, Lname, firstLogin, netcontrol as role,
	               grid, latitude, longitude, county, state, district, email, phone, creds, tt, cat, home, Band,
	               traffic, Mode, logdate, timeout, timeonduty, comments
	          FROM NetLog 
	         WHERE netID = $q
	         ORDER BY recordID
           ";
           
        $statement = $db_found->prepare($sql);
 
        //Executre our SQL query.
        $statement->execute();
         
        //Fetch all of the rows from our MySQL table.
        $rows = $statement->fetchAll(PDO::FETCH_ASSOC);
        
        //Get the column names.
        $columnNames = array();
        if(!empty($rows)){
            //We only need to loop through the first row of our result
            //in order to collate the column names.
            $firstRow = $rows[0];
            foreach($firstRow as $colName => $val){
                $columnNames[] = $colName;
            }
        }
        
        //$filename = "NetLog$q-" . date('Y-m-d') . ".csv";
        
        //Set the Content-Type and Content-Disposition headers to force the download.
        //header('Content-Type: application/excel');
        //header('Content-Disposition: attachment; filename="' . $filename . '"');
         
        //Open up a file pointer
        $fp = fopen('php://output', 'w');
        
        //Start off by writing the column names to the file.
        fputcsv($fp, $columnNames);
        
        //Then, loop through the rows and write them to the CSV file.
        foreach ($rows as $row) {
            fputcsv($fp, $row);
        }
         
  
    fputcsv($fp, []);
    fputcsv($fp, ['Time Lline']);
    
    fclose($fp);
    
    ob_start();
    
    
    // Now lets go get the Time Line data
    // get the data 
	$sql = "SELECT timestamp, recordID, ID, netID, callsign, comment
	          FROM TimeLog 
	         WHERE netID = $q
	         ORDER BY timestamp
           ";
           
        $statement = $db_found->prepare($sql);
 
        //Executre our SQL query.
        $statement->execute();
         
        //Fetch all of the rows from our MySQL table.
        $rows = $statement->fetchAll(PDO::FETCH_ASSOC);
        
        //Get the column names.
        $columnNames = array();
        if(!empty($rows)){
            //We only need to loop through the first row of our result
            //in order to collate the column names.
            $firstRow = $rows[0];
            foreach($firstRow as $colName => $val){
                $columnNames[] = $colName;
            }
        }
        
        //$filename2 = "TimeLog$q-" . date('Y-m-d') . ".csv";
        
        //Set the Content-Type and Content-Disposition headers to force the download.
        //header('Content-Type: application/excel');
        //header('Content-Disposition: attachment; filename="' . $filename2 . '"');
         
        //Open up a file pointer
        $fp = fopen('php://output', 'w');
        
        //Start off by writing the column names to the file.
        fputcsv($fp, $columnNames);
        
        //Then, loop through the rows and write them to the CSV file.
        foreach ($rows as $row) {
            fputcsv($fp, $row);
        }
         
    fclose($fp);
     
?>