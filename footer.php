<?php
/**
 * footer.php - Page footer, modals, and JavaScript includes
 */
?>
	</div> <!-- End id netchoice -->
	
	<!-- https://jquerymodal.com -->
	<div id="#cc" class="modal" style="display:none;">	
		<p>&copy; Copyright 2015-2025, by Keith D. Kaiser, WA0TJT <br> Last Update: <span id="lastup">2024-11-09</span></p>
		<p>Questions, problems, concerns? ....send them to: 
			<a href="mailto:wa0tjt@gmail.com?subject=NCM">Keith D. Kaiser</a><br>
			Or click <a href="help.php" target="_blank" rel="noopener">here for a detailed Help page. </a></p>
			
	    <p> In order to succeed, you must know what you are doing, like what you are doing, and believe in what you are doing. -- Will Rogers
		</p>
		<p><a href="#" rel="modal:close">Close</a></p>
	</div> <!-- End id cc -->
	
	<!-- End of id lli -->
	<div id="lli" class="modal-dialog" style="display:none; "></div> 	
	<div id="pbl" class=" modal hidden"></div> <!-- End of id ppl, Holds the list of pre-built nets created in PBList.php -->
	
	<div id="gcomm" class="gcomm hidden">gcomm</div>
	
	<div id="testEmail" class="testEmail hidden"></div>
	
	<div id="hideme" class="hidden stuff"></div>
	
	<button onclick="topFunction()" id="myBtn" title="Go to top">Top</button>

<!-- *********************  JAVASCRIPT LIBRARIES ********************** -->    
    <!-- UPDATED: 2024-04-27 -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- UPDATED: 2024-04-27 -->
    <script src="https://code.jquery.com/ui/1.13.0/jquery-ui.min.js"></script>

    <!-- Updated: 2024-04-27 -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.2/jquery.modal.min.js"></script>

    <!-- v1.0.7 -->
    <script src="js/jquery.freezeheader.js"></script>    

    <!-- v3.3.2 -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>    
    
    <!-- v1.12.4 2024-11-09 -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/js/bootstrap-select.min.js"></script>    
                
    <!-- Bootstrap multiselect -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/1.1.0/js/bootstrap-multiselect.min.js"></script>
        
    <!-- Jeditable for inline editing -->
    <script src="js/jquery.jeditable.js"></script>

    <!-- Sortable.js for column reordering -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.14.0/Sortable.min.js"></script>

    <!-- Other utility scripts -->
    <script src="js/sortTable.js"></script>                                     
    <script src="js/hamgridsquare.js"></script>                            
    <script src="js/jquery.countdownTimer.js"></script>
    <script src="js/w3data.js"></script>
    
    <!-- Your application scripts -->
    <script src="js/NetManager.js"></script>     
    <script src="js/NetManager-p2.js"></script>    
    <script src="js/NetManager-p3.js"></script>
    <script src="js/NetManager-W3W-APRS.js"></script>    
    
    <script src="js/cookieManagement.js"></script>      
    <script src="js/newNet.js"></script>
    <script src="js/checkIn.js"></script> 
    
    <script src="generateJsWithDefinitions.php"></script>
    <script>
    window.tableStructure = <?php echo isset($tableStructure) ? $tableStructure : 'null'; ?>;
    </script>
    
    <!-- Column management scripts -->
    <script src="js/showActivities.js"></script>
    <script src="js/CellEditFunctions.js"></script>     
    <script src="js/grid.js"></script>
    <script src="js/gridtokoords.js"></script>
    
    <script src="js/addNewCallsignRow.js"></script>
    <script src="js/handleSSE.js"></script>
    <script src="js/sendSseMessage.js"></script>
    <script src="js/addToNet.js"></script>

    <!-- Error handling -->
    <script>
    window.onerror = function(message, source, lineno, colno, error) {
        console.error('Caught error:', message, 'at', source, lineno, colno);
        console.error('Error object:', error);
        return true;
    };
    </script>
    
    <!-- MutationObserver for table changes -->
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const observer = new MutationObserver((mutations) => {
            mutations.forEach((mutation) => {
                if (mutation.type === 'childList' && mutation.addedNodes.length > 0) {
                    const addedTable = Array.from(mutation.addedNodes).find(node => node.tagName === 'TABLE');
                    if (addedTable) {
                        console.log('Table added to DOM. Applying column management.');
                        if (typeof initializeSortable === 'function') {
                            initializeSortable(addedTable);
                        } else {
                            console.error('initializeSortable function not found when table was added.');
                        }
                    }
                }
            });
        });
        // Start observing the actLog div
        const actLog = document.getElementById('actLog');
        if (actLog) {
            observer.observe(actLog, { childList: true, subtree: true });
        } else {
            console.error('actLog div not found');
        }
    });
    </script>

    <!-- Column management CSS and JS -->
    <link rel="stylesheet" type="text/css" href="css/column-management.css">
    <script src="js/column-management.js"></script>
    <script src="js/column-reordering.js"></script>

    <!-- New column management scripts -->
    <script src="js/storage-management.js"></script>
    <script src="js/column-sidebar.js"></script>
    <script src="js/profile-management.js"></script>
    <script src="js/profile-ui.js"></script>
    <script src="js/column-integration.js"></script>
    <link rel="stylesheet" type="text/css" href="css/profile-css.css">

    <?php
    // Uncomment the following line to log included files
     require_once "log_included_files.php";
    ?>
</body>
</html>