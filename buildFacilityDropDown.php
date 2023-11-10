<!doctype html>
<html>
<head>
    
<style>
.hidden {
    visibility: hidden;
    width: 0px;
    height: 0px;
    display:none;
}
textarea {
    font-size: 16pt;
}
#facility {
    font-size: 16pt;
}
</style>

<body style="padding-left: 25px">
    <br><br><br>
 <!--   <form > -->
        <label for=facility> Click to see list of all choices:<br></label>
          <select name="facility" id="facility" onchange="getOption(this)" autofocus >
            <optgroup label="Click to see list of all choices"></optgroup>
              <option value="x">Click to see list of all choices</option>
              <option value="0">Create a new facility</option>
              <option value="43">Checkins with no assignment</option>
            <optgroup label="KCHEART Hospitals">

<?php
// function to geocode address, it will return false if unable to geocode address
require_once "dbConnectDtls.php";

// Get the group call
//$netGC = strip_tags($_POST["q"]);
$netGC = strip_tags($_POST["q"]);
$netGC = 'kcheart';
$netID = 6130;
$recordID = 92615;
  

	$sql0 = "SET GLOBAL group_concat_max_len=2048";
	mysql_query($sql0);
	
	// select the needed information from the facility table	   
    $sql = "SELECT id, facility, latitude, longitude
              FROM facility
             WHERE groupcall = '$netGC' 
           ";
		   
    //echo ("$sql <br><br>");    
          
    	foreach($db_found->query($sql) as $row) {
        	$stationcount++;
        	
        	    echo "<option value='$row[id],$row[facility],$row[latitude],$row[longitude]'>$row[facility]</option>";
        	
	    } // end foreach
?>

            </optgroup>
                <optgroup label='Optional Selections'>
                <option value='0'>Create a new facility</option>
          </select>
          
          <br><br>
          
          <!-- When get the new name it will also be added to the facilitiy table -->
          <div class='newFacilityDiv hidden'>
              <label for=newFacilityName> Enter the new facility name here:<br></label>
              <textarea name = 'newFacilityName' rows='1' cols='50'></textarea>
              <br><br>
              <label for=newFacilityCoords> Enter the What3Words as these.three.words or lat/lon as 39.4589, -94.3434. <br>If values unknow leave blank:<br></label>
              <textarea name = 'newFacilityCoords' rows='1' cols='50'></textarea>
          </div>
          
 <!--   </form> -->
    
<script>
    // This function handles the click of the facility field in NCM
    function getOption(el) {
        // need to break out all the values 
        const elArray = el.value.split(",");
        const idSelected = elArray[0];
        const facility   = elArray[1];
        const latitude   = elArray[2];
        const longitude  = elArray[3];
        
        //console.log("@89 0: "+idSelected+" 1: "+facility+" 2: "+latitude+" 3: "+longitude);
        //alert ("idSelected= "+idSelected);
        //console.log("@91 selected value of idSelected= "+idSelected);
        
        if (idSelected == 0) {
            //console.log("@94 selected value was 0, new facility being created & added to the table");
            $(".newFacilityDiv").removeClass("hidden");
        } // End of idSelected = 0 (create a new facility)
        
        // Checkins with no assignment
        else if (idSelected == 43) {
            //console.log("@100 selected value of idSelected= "+idSelected);
            $(".newFacilityDiv").addClass("hidden");
        }
        // Checkins with an assignment
        else {
            //console.log('@105 value selected was '+idSelected);
            $(".newFacilityDiv").addClass("hidden");
        }
    } // End of function getOption()
</script>

    <!-- jquery updated from 3.4.1 to 3.5.1 on 2020-09-10 -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<!-- My javascript -->	
	<script src="js/NetManager.js"></script>        <!-- NCM Primary Javascrip 2018-1-18 -->
	
</body>
</html>
