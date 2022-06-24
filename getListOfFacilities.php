<?php 
// getListOfFacilities.php
// This query gets and formats the selection criteria for the facility column 
// Its called by CellEdityFunctions.js
require_once "dbConnectDtls.php";

	$recordID   = $_GET['recordID'];	
	
	//$recordID = 93882;
	
	$sql = "SELECT netcall FROM NetLog WHERE recordID = $recordID LIMIT 0,1";
	//echo "$sql";
	    $stmt = $db_found->prepare($sql);
		$stmt -> execute();
		$groupcall = $stmt->fetchColumn(0);
		
		//echo "$groupcall";
	 
	$sql = "SELECT facility
			  FROM `facility`
			 WHERE groupcall = '$groupcall'
		   ";
	//echo "$sql<br><br>";
        $list = "{\" \":\" \","; // add a blank to the list
        $listarray = array();
	  	foreach($db_found->query($sql) as $row) {
		++$num_rows;    /* "Traffic":"Traffic" */
		   // $list .= "$row[facility],";
		   // $listarray[] = $row;
		    $list .= "\"$row[facility]\":\"$row[facility]\",";
        } // end foreach
		    
		    $list = $list.'}';
		    echo "$list";
?>
		