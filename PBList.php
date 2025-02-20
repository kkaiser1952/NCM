
<?php
ini_set('display_errors',1); 
	error_reporting (E_ALL ^ E_NOTICE);

    require_once "dbConnectDtls.php";  // Access to MySQL
    
    $netID = strip_tags($_POST["newPB"]); // The one we are coping rows to
    
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
   
   // n1 is the new net
   // n2 is the old net
   foreach($db_found->query("
		SELECT DISTINCT n1.netID, n1.activity, n1.netcall, n2.netcall as originalNetcall
			FROM NetLog n1
			LEFT JOIN NetLog n2 ON n2.netID = $netID AND n2.row_number = 1
			WHERE n1.pb = 1
			AND n1.netID <> $netID
			AND n1.netcall = n2.netcall
			AND n1.row_number = 1
			AND n1.logdate >= CURRENT_TIMESTAMP - INTERVAL '35' DAY
			ORDER BY n1.netID DESC
	") as $net ) {
		echo "<option value='$net[netID]'>$net[netID] $net[activity] </option>";
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
