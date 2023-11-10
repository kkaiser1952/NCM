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
 require_once "geocode.php";    


$rawdata = file_get_contents('php://input'); //echo("$rawdata");  // value=Doug&id=Fname%3A0013
	$part   = explode("&",$rawdata);  //print_r($part);
    $part0 	= explode("=",$part[0]); //print_r($part0); // Array ( [0] => value [1] => +Doug+ )
        $value = trim($part0[1],"+"); //echo("value: $value"); // part1: Doug
        
    $part00 = explode("=",$part[1]); //print_r($part00); // Array ( [0] => id [1] => Fname%3A0013 )
    $part01 = explode("%3A",$part00[1]); //print_r($part01[0]);  // Array ( [0] => Fname [1] => 0013 )
        $column = $part01[0]; //echo("<br>field: $column");
        $id = $part01[1]; //echo("<br>id: $id");
    		  

if ( $column == 'tactical' ) {
    $value = strtoupper("$value");
} else if  ( $column == 'Fname' ) {
    $value = ucwords("$value");
} else if  ( $column == 'Lname' ) {
    $value = ucwords("$value");
} else if  ( $column == 'latitude' ) {
    
} else if  ( $column == 'longitude' ) {
    
} else if  ( $column == 'grid' ) {
    
} else if  ( $column == 'county' ) {
    $value = strtoupper("$value");
} else if  ( $column == 'state' ) {
    $value = strtoupper("$value");  
} else if  ( $column == 'district' ) {
    
} else if  ( $column == 'email' ) {
    $value = strtolower("$value");
} else if  ( $column == 'phone' ) {
    
} else if  ( $column == 'creds' ) {
    
} // end else if loop

/*

$gridd 	   = gridsquare($latitude, $longitude);
        //print_r($gridd);
    $grid      = "$gridd[0]$gridd[1]$gridd[2]$gridd[3]$gridd[4]$gridd[5]";
    
    
     latlng = GeomFromText(CONCAT('POINT (', latitude, ' ', longitude, ')'))
*/

$sql = "UPDATE stations SET
            $column = '$value'
         WHERE ID = $id  
";

//echo("$sql");

$stmt = $db_found->prepare($sql);
$stmt->execute();

echo("$value");

// delete any errant rows caused by a no fcc entry
$sql = "DELETE FROM stations WHERE ID = 0";

$stmt = $db_found->prepare($sql);
$stmt->execute();

		    
?>
	
	
