 <?php
     // Get the IP address of the person making the changes.
    require_once "getRealIpAddr.php";
	
	function str_replace_first($search, $replace, $subject) {
		$pos = strpos($subject, $search);
			if ($pos !== false) {
				return substr_replace($subject, $replace, $pos, strlen($search));
			}
			return $subject;
	}
	
	// credentials and grid calculator
	 require_once "dbConnectDtls.php";
	 require_once "GridSquare.php";
 
		$rawdata = file_get_contents('php://input');
		echo("$rawdata");  
?>
	