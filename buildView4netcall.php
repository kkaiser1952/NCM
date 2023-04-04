<?php
/*
How I want hints to work:
When a new net is started, NCM will check to see if a VIEW for that netcall exists. If it does NOT, it will create one. The name of the VIEW will be the same as the netcall value.

When a callsign, first name or last name or partial of any 3 consecutive characters is entered into CS1, NCM will check the VIEW for this information.

If the callsign is NOT in the VIEW then the information will be looked for in the broader stations table. 

If NCM still can’t find the callsign, then the FCC or foreign data base will be used to create the entry for the stations table and add the same to the net in use.

If no callsign is found in the FCC or foreign DB it will be added to the NET with the error ’No Valid Callsign’.
*/

require_once "dbConnectDtls.php";
	
	$dbname = 'ncm';
	$viewnm = 'CREW2273'; 
	
	// Check if the view already exists
    $sql_check = "SELECT COUNT(*) as count FROM information_schema.views WHERE table_schema = '$dbname' AND table_name = '$viewnm'";
    $stmt_check = $conn->prepare($sql_check);
    $stmt_check->execute();
    $result_check = $stmt_check->fetch(PDO::FETCH_ASSOC);

    // Create the SQL statement to create the view if it doesn't exist
    if ($result_check['count'] == 0) {
        $sql_create = 
            "CREATE VIEW $viewnm AS
                SELECT DISTINCT st.callsign, st.Fname, 
            	    st.Lname, st.email, st.tactical, 
            	    st.latitude, st.longitude, st.grid, 
                        st.county, 	 st.state, 	   st.city, 
                        st.district, st.creds, 	   st.country, 
                        CONCAT(st.Fname, ' ', st.Lname, ' --> ', st.state, '--', st.county, '--', st.district) AS name
                  FROM ncm.stations st
                  JOIN ncm.NetLog nl ON st.callsign = nl.callsign
                 WHERE nl.netcall = '$viewnm'
                   AND nl.callsign NOT LIKE '%NONHAM%'
                   AND nl.callsign NOT LIKE '%EMCOMM%'
                   AND nl.logdate >= DATE_SUB(CURRENT_DATE(), INTERVAL 6 MONTH)
                   AND nl.logdate < CURRENT_DATE()  
            ";
            
            try {
                // Prepare the statement
                $stmt_create = $conn->prepare($sql_create);
            
                // Execute the statement
                $stmt_create->execute();
            
                // Deallocate the statement
                $stmt_create = null;
            
              } catch(PDOException $e) {
                echo "Error: " . $e->getMessage();
              }
    } // End if($result_check...      

?>
