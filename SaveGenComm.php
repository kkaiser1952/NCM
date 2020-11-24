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
		
		
        //echo("$rawdata");  
		// 2428=genComments&call=Testing+of+input+to+general+commentsTesting of input to general comments
		// 2428=genComments&value=still+trying+to+resolve+the+final+issues&from_prompt=wa0tjtstill trying to resolve the final issues&from_prompt
		
		$part    = (explode("=",$rawdata)); 
		$netID   = $part[0];  //echo("$netID");  // 2428Testing of input to general comments
		
		$part1	 = $part[1];  //echo("$part1"); // genComments&call. Testing of input to general comments
		    
		$part2   = $part[2];  //echo("part2: $part2");  // Testing+of+input+to+general+comments Testing of ....
		$part3   = $part[3];  //echo("part3: $part3");
		   
        $WRU      = strtoupper($part3);
		$comment  = str_replace("+"," ",$part2);
		$comment = encodeURIComponent($comment);   // this escapes things like the ampersand (&) 
		$comment  = rawurldecode("$WRU: $comment");
		
		$comparts = explode("&",$comment);
        //$comment = $comparts[0];
		
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

