<?php
	//date_default_timezone_set("America/Chicago");
	require_once "dbConnectDtls.php";
	
	//$s = strip_tags(substr($_GET["s"],0, 100));
	$s = $_GET["s"];
    echo "$s";
	
	$sql = ("
	        SELECT section, place
	          FROM sections
             WHERE section = '$s'  
             limit 0,1;
	        ");
	        
	        $stmt = $db_found->prepare($sql);
			    $stmt->execute();
			        if($countrows = mysql_num_rows($res) >= 1){
                        $section = $stmt->fetchColumn(0);
                    } else $section = 'Invalid';}
                    
                    echo "$section";
?>