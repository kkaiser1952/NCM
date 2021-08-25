<?php
	
	 require_once "dbConnectDtls.php";
	 
	 $str = $_POST["q"]; //echo "$str";
	 
	 //$str = "3:2:19";   //echo "$str<br>";

	 $dflts = explode(":",$str); //print_r($dflts);
	 	$id 	  = $dflts[0]; // echo "id = $id";
	 	$dfltkind = $dflts[1];
	 	$dfltfreq = $dflts[2];
	 	
/*	 $sql = $db_found->prepare("
	 		 SELECT `call`, org, contact_call, contact_name, contact_email, org_web,
					row1, row2, row3, row4, row5, row6
			   FROM NetKind
			  WHERE id = '$id'
			  LIMIT 1 
			 ");
*/
			 
			 $sql = $db_found->prepare("
					  SELECT t1.call, t1.org, t1.contact_call, t1.contact_name, t1.contact_email, t1.org_web, 
					  		 t1.row1, t1.row2, t1.row3, t1.row4, t1.row5, t1.row6, t1.dflt_kind, t2.kindofnet, 
					  		 t1.dflt_freq, t3.freq

						FROM `NetKind` t1 
							INNER JOIN `NetKind` t2 
								ON t2.id = t1.dflt_kind 
						    INNER JOIN `NetKind` t3 
						    	ON t3.id = t1.dflt_freq 
						    	
						WHERE t1.id = $id
						  AND t1.call <> '' 
						  AND t1.call <> 'TE0ST' 
						  AND t2.kindofnet NOT LIKE '%Name Your Own%' 
						  AND t2.freq NOT LIKE '%Name Your Own%' ");
			//echo "$sql";
					  
	 $sql->execute();
	 $result = $sql->fetch();
	
	 	$callsign 	   = $result[call]; 
		$org 	  	   = $result[org];
		$contact_call  = $result[contact_call];
		$contact_name  = $result[contact_name];
		$contact_email = $result[contact_email];
		$org_web  	   = $result[org_web];
		$row1		   = $result[row1];
		$row2		   = $result[row2];
		$row3		   = $result[row3];
		$row4		   = $result[row4];
		$row5		   = $result[row5];
		$row6		   = $result[row6];
		$d_kind		   = $result[dflt_kind];
		$kind		   = $result[kindofnet];
		$d_freq		   = $result[dflt_freq];
		$freq		   = $result[freq];
		
		$returnarray = array($callsign,$org,$contact_call,$contact_name,$contact_email,$org_web,$row1,$row2,$row3,$row4,$row5,$row6,$d_kind,$kind,$d_freq,$freq);
		echo implode("|",$returnarray);

?>