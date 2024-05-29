<!doctype html>
<?php
    /* updateStationLocations.php
        This program looks for a change of latitude and longitude based on geocoding the fcc address and comparing it to the stored lat/lon values in the stations table */
    /* Written: 2021-11-03 */
    
    ini_set('display_errors',1); 
	error_reporting (E_ALL ^ E_NOTICE);

    require_once "dbConnectDtls.php";
    require_once "geocode.php";     /* added 2017-09-03 */
    require_once "GridSquare.php";  /* added 2017-09-03 */
    
    //$netID = intval( $_GET["NetID"] ); 
    //$cs = strtoupper('KC1TVI');  // does not return address1
    $cs = 'ac6dn';
 
/*   
st = stations table
nl = NetLog table
fcc = fcc_amateur.en table
hp = HPD table
tl = TimeLog table
*/   
   
$sql = ("
    SELECT st.callsign  as st_callsign,
	       st.latitude  as st_latitude, 
	       st.longitude as st_longitude,
	       st.grid      as st_grid,
	       st.county    as st_county,
	       st.state     as st_state,
	       st.Home      as st_home,
	       st.fccid     as st_fccid,
	       st.comment   as st_comment,
           fcc.callsign as fcc_callsign,
           fcc.address1, 
           fcc.city, 
           fcc.state, 
           fcc.zip,
           fcc.fccid,
           CONCAT_WS(' ', fcc.address1, fcc.city, fcc.state, fcc.zip) AS address
      FROM ncm.stations st
          ,fcc_amateur.en fcc
     WHERE st.callsign = '$cs'
       AND st.callsign = fcc.callsign;
       AND LEFT(st.callsign, 1) IN('a','k','n','w')
");           

    foreach($db_found->query($sql) as $row) {      
        $fcc_callsign   = $row[fcc_callsign];
        $st_callsign    = $row[st_callsign];
        $state          = $row[state];
        $address        = $row[address];
        $fccid          = $row[fccid];
        $zip            = $row[zip];
        
        $koords         = geocode("$address");
         // Array ( [0] => 46.906975 [1] => -92.489501 [2] => St. Louis [3] => MN ) 
				$latitude  = $koords[0];  //echo "<br>lat= $latitude";
				$longitude = $koords[1];  //echo " lon= $longitude";
				$county	   = $koords[2];
				$new_state = $koords[3];
				
        $gridd 	   = gridsquare($latitude, $longitude);
        $grid      = "$gridd[0]$gridd[1]$gridd[2]$gridd[3]$gridd[4]$gridd[5]";	
        $home      = "$latitude,$longitude,$grid,$county,$state";
        
        $updated   = 'Updated by updateStationLocation.php on '.NOW();
    
    
    // Old values
    
        echo "  
        <style>
        
        table, p {
          font-family: arial, sans-serif;
          font-weight: bold;
          font-size: larger;
          border-collapse: collapse;
          width: 50%;
        }
        
        td, th {
          border: 1px solid #dddddd;
          text-align: left;
          padding: 8px;
        }
        
        tr:nth-child(even) {
          background-color: #dddddd;
        }
        </style>
        
        
        <h2>FOR: $cs  The original values vs. new values are:</h2>
                <table>
                <tr><th>Variable</th><th>old</th><th>new</th></tr>
                <tr>
                <td>  latitude</td><td> $row[st_latitude]</td><td>     $latitude</td>
                <tr>
                <td>  longitude</td><td> $row[st_longitude]</td><td>      $longitude</td>             
                <tr>
                <td>  grid</td><td> $row[st_grid]   </td><td>            $grid</td>
                <tr>
                <td>  county</td><td> $row[st_county]   </td><td>        $county</td>
                <tr>
                <td>  state</td><td> $row[st_state]  </td><td>           $state</td>
                <tr>
                <td>  home</td><td> $row[st_home]    </td><td>           $home</td>
                <tr>
                <td>  fccid</td><td> $row[st_fccid]     </td><td>        $fccid</td>
                <tr>
                <td>  comment</td><td> $row[st_comment]   </td><td>      $updated</td>
                </table>
                
                <br><br><br>
             ";
    } // end of foreach
    
    // removed latlng 2023-12-22
    $sql = "UPDATE stations SET
                latitude  = '$latitude'
               ,longitude = '$longitude'
               ,grid      = '$grid'
               ,county    = '$county'
               ,state     = '$state'
               ,home      = '$home'
               ,fccid     = '$fccid'
               ,zip       = '$zip'
               ,dttm      = CURRENT_TIMESTAMP
               ,comment   = '$updated'
              Where callsign = '$cs';
	       ";	      
	       
	       
    echo "<p>Copy the below SQL to phpMyAdmin to run</p>";
	   
    echo "<p>$sql</p>";
    
	//   $stmt2 = $db_found->prepare($sql);
	//   $stmt2 -> execute();
        
?>