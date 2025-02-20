
<?php
ini_set('display_errors',1); 
	error_reporting (E_ALL ^ E_NOTICE);

    require_once "dbConnectDtls.php";  // Access to MySQL
    
	// Get values from the net we just created.
    $netID = strip_tags($_POST["newPB"]); 
	//$thisnetcall = '';
	$html = file_get_contents('php://input');
// If that doesn't work, you might need:
// $html = file_get_contents($_SERVER['PHP_SELF']);

$dom = new DOMDocument();
libxml_use_internal_errors(true); // Suppress HTML5 warnings
$dom->loadHTML($html, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
$div = $dom->getElementById('thenetcallsign');
if ($div) {
    $thisnetcall = trim($div->textContent);
} else {
    $thisnetcall = "Not found";
}
libxml_clear_errors();

   echo '
	  <div class="modal-dialog">
	    <div class="modal-content">
	    	 <div class="modal-header">
			 	<h3>Clone Selection Modal</h3>
	    	 </div> <!-- end modal-header -->
	    	 
		    	 <div class="modal-body">
		         	<select id="netcalltoclone" class="netGroup" title="Select Group" >
						<option value="0" selected="selected">Select One</option>
   ';
   
   // Changes made 2025/02/19
   foreach($db_found->query("
		SELECT DISTINCT netID, activity, netcall
		  FROM NetLog
		 WHERE pb = 1
		   AND netcall = '$thisnetcall'
		   AND netID <> $netID
		   AND row_number = 1
		   AND logdate >= CURRENT_TIMESTAMP - INTERVAL '35' DAY
		 ORDER BY netID DESC 
	") as $net ) {
		echo "<option value='$net[netcall]':' $net[netID]'>$net[netID] $net[activity] </option>";
	}	  
	    
	echo '
		         	</select>
		    	 </div> <!-- end modal-body -->
		    	 
	      <div class="modal-footer">
	        <button type="submit" class="btn btn-danger btn-default pull-left" data-dismiss="modal">
	        	<span class="glyphicon glyphicon-remove"></span> Cancel</button>  
	        		
	        <button id="selectCloneBTN" type="button" onclick="fillaclone()" >Clone Selection</button>
	      </div> <!-- end modal-footer -->
	    </div> <!-- end modal-content -->
	  </div> <!-- end modal-dialog -->
	';
?>
