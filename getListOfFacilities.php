<?php 
// getListOfFacilities.php
// This query gets and formats the selection criteria for the facility column 
// Its called by CellEdityFunctions.js

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once "dbConnectDtls.php";

	$recordID   = $_GET['recordID'];	
	
	//$recordID = 134912;
	
	$sql = "SELECT netcall FROM NetLog WHERE recordID = $recordID LIMIT 0,1";
	    //echo "first sql: $sql <br>";
	    //echo "<script>console.log('first SQL: $sql');</script>";
	    $stmt = $db_found->prepare($sql);
		$stmt -> execute();
		$groupcall = $stmt->fetchColumn(0);
		
		//echo "1st group call: $groupcall <br>";
		//echo "<script>console.log('group call: $groupcall');</script>";
		
    $sql2 = "SELECT facility FROM ncm.facility WHERE groupcall = '$groupcall'";
        $listarray = array();
        foreach ($db_found->query($sql2) as $row) {
            $listarray[$row['facility']] = $row['facility'];
        }

// Send JSON response
header('Content-Type: application/json');
echo json_encode($listarray);

?>
		