<?php	
require_once "dbConnectDtls.php";

$netID = intval($_GET['q']);
    
$sql = "UPDATE NetLog 
		   SET tactical = ''
		 WHERE netID = $netID  ";
		 
    echo $sql;

$stmt = $db_found->prepare($sql);
//$stmt->execute();
			
?>