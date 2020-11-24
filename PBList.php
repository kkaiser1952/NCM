
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
   
   foreach($db_found->query("
		SELECT DISTINCT netID, activity, netcall
		  FROM NetLog
		 WHERE pb = 1
		   AND netID <> $netID
		 ORDER BY netID DESC 
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
