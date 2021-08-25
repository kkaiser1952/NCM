<?php		
			require_once "dbConnectDtls.php";	

			/* This query pulls the list of all open nets */
			echo("<h3>The following nets are currently open;</h3>");
			echo("<ul>");
			
			$sql = $db_found->prepare("SELECT netID, activity, logdate, frequency, netcall, GROUP_CONCAT(DISTINCT netID)
					   FROM NetLog
					  WHERE netID <> '0'
					    and logclosedtime IS NULL
                        and netcall <> 'TE0ST'
                        and logdate >= (NOW() - INTERVAL 50 DAY)
					  GROUP BY netID
					  ORDER BY netID ?");
						  
                                   
                $sql->EXECUTE(array("desc"));
                
                $user = $sql->fetchAll();
                
                if ($user !== false) {
	                	 echo "<li>Net# $ON[netID] $ON[netcall] Opened: $ON[logdate]</li>" ; 
	                } else {
		                echo "<li>There are no open nets</li>";}
	                }
                                   
			 
			echo("</ul>");
		?>