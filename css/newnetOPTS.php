<!doctype html>

<?php
/*****************************************************************************************************************
 This is the PHP that creates the dropdowns used to select a new net
 How this works...
 1) Click on 'Start a new net'
 2) Select Group by Call, this list is built by MySQL/Ajax in index.php
 3) This causes the 'Select Net Type' and 'Select the Frequency' fields to populate with the defualt value
 4) These dropdowns are also populated via MySQL/Ajax by the below code
 5) They use the MySQL table called NetKind, which for all practical purposes is actually three tables.
 6) The id is NON NULL/Auto_Increment, dflt_kind & dflt_freq are not, each is edited by hand
*****************************************************************************************************************/
	
	ini_set('display_errors',1); 
	error_reporting (E_ALL ^ E_NOTICE);

    require_once "dbConnectDtls.php";
    
    // The PHP to create the first dropdown for group/call selection is in index.php
     
// When a selection is chosen, this script executes
if(!empty($_POST["call_id"])) {
	$bothID = $_POST["call_id"]; //echo "$newid"; // 31:31:18:RSKC
	$callID = (explode(":",$bothID)[0]);
	$kindID = (explode(":",$bothID)[1]);
	$freqID = (explode(":",$bothID)[2]);
	
	//echo "cid=$callID kid=$kindID freq=$freqID";
	
	$rowNumber = 0;

	// Fetch all net kind data i.e. (2m voice net)
	$sql = "SELECT id, 
				   dflt_kind, dflt_freq, kindofnet
			  FROM `NetKind` 
			 WHERE kindofnet <> ''
			 ORDER BY kindofnet, id, FIELD(dflt_kind, $callID) DESC, dflt_kind
		   ";

    $rowno = 1;
	echo ("<option value='7:18'>Name Your Own Kind</option> ");
	foreach($db_found->query($sql) as $row) {
    $mod = $rowno % 4;  // row number devided by 4 
		$rowNumber = $rowNumber + 1;

    if ($mod == '') { echo "<option value='' disabled>=========================</option>";}
			if($rowNumber > 0) {
					
				if($row[id] == $kindID  ) {
					echo "<option value='$row[id]:$row[dflt_freq]' selected>$row[kindofnet] Net</option>";
				} else {
				  	echo ("<option value='$row[id]:$row[dflt_freq]'>$row[kindofnet] Net</option>");
				}
			}
    $rowno = $rowno + 1;
	}
 // Fetch all the frequency data
}else if(!empty($_POST["kind_id"])) {
	//Read the POST data kind_id from index.php when building a new net
	$bothID = $_POST["kind_id"]; //echo "bothID";
	
	//colnCnt counts the number of colons in the POST kind_id data, put there by index.php during start a new net.
	//colnCnt is either 2 (both kindID and freqID) get a default setting, this is the first time a call is selected
	//OR if colnCnt is 1 then a new type was selected, I use colnCnt as a switch to build the net type dropdwon
	//Three colons never happen...
	$colnCnt = substr_count("$bothID",":");  //echo "colnCnt= $colnCnt";
	
	$callID = (explode(":",$bothID)[0]);
	$kindID = (explode(":",$bothID)[1]);
	$freqID = (explode(":",$bothID)[2]);
	
	$rowNumber = 0;
	
	$sql = "SELECT id, freq, dflt_freq
			  FROM `NetKind` 
			 WHERE freq <> ''
			 ORDER BY freq, id, FIELD(dflt_freq, $callID) DESC, id
		   ";
			 
	$rowno = 1;
	echo ("<option value='7:18'>Name Your Own Frequency</option>");
	foreach($db_found->query($sql) as $row) {
    	$mod = $rowno % 4;  // row number devided by 4 
		$rowNumber = $rowNumber + 1;
		
		
		if ($mod == '') { echo "<option value='' disabled>=========================</option>";}
			if($rowNumber > 0) {
				
				if ($colnCnt == 1) {
					echo "<option value='$row[id]:$row[dflt_freq]' selected>Choose a Frequency</option>";
						$colnCnt = $colnCnt + 1; // needed to prevent the list from duplicating
				}else
				if($row[id] == $freqID AND $colnCnt <> 1 ) {
					echo "<option value='$row[id]:$row[dflt_freq]' selected>$row[freq]</option>";
				} else {
				  	echo ("<option value='$row[id]:$row[dflt_freq]'>$row[freq]</option>");
				} 
			}
        $rowno = $rowno + 1;
	}
}

?>