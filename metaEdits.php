<?php
	//date_default_timezone_set("America/Chicago");
	 require_once "dbConnectDtls.php";
 
//$open  = now(CONST_USER_TIMEZONE,CONST_SERVER_TIMEZONE,CONST_SERVER_DATEFORMAT);  

// End of time stuff
 
		$rawdata = file_get_contents('php://input');
		//echo("$rawdata");  //Value=Hello+World&Id=Fname%3A2751Array ( ) Hello World
		$part = (explode("&",$rawdata));
		$part2 	= explode("=",$part[1]); //echo("part2= $part2");  //ArrayArray ( [0] => Value ) Bill Brown

		$part20	= $part2[0];  // = id  the word 
		$part21 = $part2[1];  // = the id name like r2c2	
		
		$value 	= explode("=",$part[0]); //echo("val= $value");  //ArrayArray ( [0] => Value ) Hello World
		$value  = trim($value[0],"+"); //echo("$value"); // Array ( [0] => Value ) Bill Brown
		
		$value  = str_replace("+"," ",$value);
		$value  = rawurldecode($value);  //echo("$value");  //Bill Smith Array ( [0] => Value ) Bill Smith	W
		
/*		echo "rawdata: $rawdata,  ";
		//echo "0:  $part,  "; 
		echo "20: $part20,  ";
		echo "21: $part21,  ";	
		echo "value: $value";

		rawdata: value=+147.330%2B%2F151.3&id=r2c2%3A4,  
		20: id,  
		21: r2c2%3A4,  
		value: valuevalue 
*/
		
		// Edit to fix the timeout value and the timeonduty values 
		$moretogo = 0;
		

		echo str_replace("+"," ","$value");
		
		// Update the NetLog with the new information
	//	$sql = "UPDATE meta SET $column = :val WHERE recordID = :rec_id";
		
	/*	$stmt = $db_found->prepare($sql);
		$stmt->bindParam(':val', 	$value, PDO::PARAM_STR);
		$stmt->bindParam(':rec_id', $recordID, PDO::PARAM_STR);
		$stmt->execute();
	*/	
?>