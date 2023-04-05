<?php
	//colColorAssign.php Written: 2019-04-04
	// This PHP is used in getactivities.php and checkIn.php to assign row colors by column

    // These background color assignments are in something of a priority direction
    // The most important are on the bottom so they don't get over written by some less imporon the top.
    // Sombody missing is primary importnat, followed by any of the control operators
    // Any one who has left the net should also be important to know   			
    
    if (in_array($row['Mode'], $digimodes )) {
    	    $brbCols = 'bgcolor="#fbc1ab"';
    		$digitalKey = 1; 
    }
 /*   if (in_array($row[Mode], $mobilemode )) {
    	    //$brbCols = 'bgcolor="#fbc1ab"';
    		//$digitalKey = 1;
    } */

    
    if (in_array($row['active'], $statmodes )) {
    	    $brbCols = 'bgcolor="#cacaca"';
    		//$brbKey = 1;
    }
    if (in_array($row['traffic'], $netTypes )) {
    	    $brbCols = 'bgcolor="#ff9cc2"';
    		$digitalKey = 1;
    	}
    if ($row['active'] == 'MISSING') {
    	//$brbCols = 'bgcolor="red"';
    	$important1 = 'bgcolor="red"';
    		$prioritykey = 1;
    		$f = '<font color="black">';
    }

    if ($row['traffic'] == 'STANDBY' | $row['traffic'] == 'Priority' | $row['traffic'] == 'Routine' | $row['traffic'] == 'Welfare' | $row['traffic'] == 'Question' | $row['traffic'] == 'Announcement' | $row['traffic'] == 'Comment' | $row['traffic'] == 'Bulletin' | $row['traffic'] == 'Traffic' ) {
    	    $important2 = 'bgcolor="#ff9cc2"';
    		$trafficKey = 1;
    	}
    if ($row['traffic'] == 'Emergency') {
    	//$brbCols = 'bgcolor="red"';
    	$important2 = 'bgcolor="red"';
    		$prioritykey = 1;
    		$f = '<font color="black">';
    }
    if ($row['active'] == "BRB") {
    	$brbCols = 'bgcolor="#d783ff"';
    		$brbKey = 1;
    }
    
    if ($row['active'] == "OUT" | $row['active'] == 'In-Out') {
    	$brbCols = 'bgcolor="#cdd3bc"';
    		$logoutKey = 1;
    }
    
    if (in_array($row['netcontrol'], $os)) {
    	$brbCols = 'bgcolor="#bae5fc"';
    	    $f = '<font color="black">';
    } 			
    
    // First Log In
    if ($row['firstLogIn'] == 1) {
    	$newCall = 'bgcolor="#ffdb2b"';
    		$fliKey = 1;
    } 
    
    if ($row['comments'] == 'First Log In') {
    	$timeline = 'bgcolor="#ffdb2b"';
    	// no fliKey definition needed here
    } 
    
    if ($row['comments'] == "No FCC Record" OR $row['comments'] == "This is a dupe") {
    	$badCols = 'bgcolor="pink"';
    		$redKey = 1;
    } 
    
    if ($row['comments'] == "Not a Valid W3W entry<br>Please re-enter.") {
    	$badCols = 'bgcolor="pink"';
    		$redKey = 1;
    } 
    
    if (in_array($row['Mode'], $digimodes )) {
    	    $modCols = 'bgcolor="#fbc1ab"';
    		$digitalKey = 1; 
    }
    
    if ($row['delta'] == "Y" ) {
        $cs1Cols = 'bgcolor="#fbac23"';
        $cs1Key = 1;
    }
?>