<?php
	//date_default_timezone_set("America/Chicago");
	 require_once "dbConnectDtls.php";
	 require_once "getRealIpAddr.php";
	 
	 function encodeURIComponent($str) {
            $revert = array('%21'=>'!', '%2A'=>'*', '%27'=>"'", '%28'=>'(', '%29'=>')');
            return strtr(rawurlencode($str), $revert);
        }
 	
 	
 	 // echos using 'Testing of input to general comments' as the input text
		$rawdata = file_get_contents('php://input');
		
		
       // echo("$rawdata");  
        //3329=genComments&value=looking+for+the+ampler+problem&=wa0tjtWA0TJT: looking for the ampler problem&

		
		$part    = (explode("=",$rawdata)); 
		$netID   = $part[0];  //echo("$netID");  // returns the netID
		$part1	 = $part[1];  //echo("$part1"); // returns genComments&value    
		$part2   = $part[2];  //echo("part2: $part2");  // part2: Test+No.+3+of+amper&WA0TJT: Test No. 3 of amper&	
		$part3   = $part[3];  //echo("part3: $part3");    // part3: wa0tjtWA0TJT: Test No. 4 of amper&
		   
        $WRU      = strtoupper($part3);
		$comment  = str_replace("+"," ",$part2);
		$comment = encodeURIComponent($comment);   // this escapes things like the ampersand (&) 
		$comment  = rawurldecode("$WRU: $comment");
		$comment = str_replace("&"," ",$comment);
		$comment  = rawurldecode("$comment");
		
		$ipaddress = getRealIpAddr();
							
		// Insert the new general comment into the TimeLog table 
	
			$sql = "INSERT INTO TimeLog (callsign, netID,    comment,    timestamp, ipaddress) 
								VALUES ('GENCOMM', '$netID', '$comment', '$open', '$ipaddress')";
			
			$db_found->exec($sql);
		
		// the htmlspecialchars(urldecode() stuff is so characters after the ampersand are still returned
		// this is the immediate return when you enter anything into this field
		echo str_replace("+"," ",htmlspecialchars(urldecode("$comment")));
		//echo (htmlspecialchars(urldecode("$comment")));
?>

