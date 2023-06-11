<?php 
// getListOfFacilities.php
// This query gets and formats the selection criteria for the facility column 
// Its called by CellEdityFunctions.js

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once "dbConnectDtls.php";

	//$recordID   = $_GET['recordID'];	
	
	$recordID = 134912;
	
	$sql = "SELECT netcall FROM NetLog WHERE recordID = $recordID LIMIT 0,1;";
	//echo "first sql: $sql <br>";
	    $stmt = $db_found->prepare($sql);
		$stmt -> execute();
		$groupcall = $stmt->fetchColumn(0);
		
		//echo "group call: $groupcall <br>";
	 
	$sql = "SELECT `facility`
			  FROM ncm.facility
			 WHERE groupcall = '$groupcall';
		   ";
	//echo "$sql<br><br>";
        //$list = "{\" \":\" \","; // add a blank to the list
        $list = "{";
        $listarray = array();
	  	foreach($db_found->query($sql) as $row) {
		//++$num_rows;    /* "Traffic":"Traffic" */
		   // $list .= "$row[facility],";
		   // $listarray[] = $row;
		    $list .= "\"$row[facility]\":\"$row[facility]\",";
        } // end foreach
		    
		    $list = $list.'}';
		    echo "$list";
?>
		