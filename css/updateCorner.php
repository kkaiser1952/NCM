<?php
	
	ini_set('display_errors',1); 
	error_reporting (E_ALL ^ E_NOTICE);

    require_once "dbConnectDtls.php";
    
    $id   = $_POST["id"]; 
    $row1 = $_POST["row1"];
    $row2 = $_POST["row2"];
    $row3 = $_POST["row3"];
    $row4 = $_POST["row4"];
    $row5 = $_POST["row5"];
    $row6 = $_POST["row6"];
    $name = $_POST["name"];
    $call  = $_POST["call"];
    $email = $_POST["email"];
    
    echo("@19 in updateCorner.php id= $id<br>row6= $row6");
    
    echo("<br>@20 in updateCorner.php email= $email");

// sets the time on duty value and sets status to 1 which is closed.
$sql = "UPDATE NetKind
		   SET row1 = '$row1',
		   	   row2 = '$row2',
		   	   row3 = '$row3',
		   	   row4 = '$row4',
		   	   row5 = '$row5',
		   	   row6 = '$row6',
		   	   contact_call  = UPPER('$call'),
		   	   contact_name  = '$name',
		   	   contact_email = '$email'
		 WHERE id = $id";
	//echo("$sql");
	
	$stmt = $db_found->prepare($sql);
		if (!$stmt) {
			echo "\nPDO::errorInfo():\n";
			print_r($dbh->errorInfo());
		}
	$stmt -> execute();
	
?>