<?php
    // This program selects from the DB/NetLog table all the data needed to create the marker points on a map ;
			ini_set('display_errors',1); 
			error_reporting (E_ALL ^ E_NOTICE);
			
			require_once "dbConnectDtls.php";
			
			$maxlat = 30.202;
			
			if (!$db_found) {
                die("Database connection failed: " . mysqli_connect_error());
            }
			
			// maxlat is calculated in map.php
			// Eventualy update to bounds for America vs rest of the world
                if ($maxlat >= 50) 
                    {$whereClause = "where latitude > 50";}
                else
                    {$whereClause = "where latitude < 50";}
                ;
			
            //$whereClause = "where latitude < 50";
            //$whereClause = "where latitude < 50";
          /*  $whereClause = "where (latitude > $minlat and latitude < $maxlat) 
                            and (longitude > $minlon and longitude < $maxlon)";
			*/
			
			    $whereClause = '';
    $dupCalls = "";	
    $sql = ("SELECT
                tactical, latitude, COUNT(latitude)
               FROM poi
              $whereClause  

              GROUP BY latitude
              HAVING COUNT(latitude) > 1
            ");
    echo "$sql";
    foreach($db_found->query($sql) as $duperow) {
            $dupCalls .= "$duperow[tactical],";
        };
		echo "<br>$dupCalls<br>";
		
		$POIMarkerList = "";
    $listofMarkers = "";
    $classList = "";  // The rest come from the poi table
    
        // This is the list needed for overlaymaps
        $sql = ("SELECT 
                    GROUP_CONCAT( DISTINCT CONCAT(class,'L') SEPARATOR ',') AS class
                   FROM poi

              $whereClause
                  GROUP BY class
                  ORDER BY class  
                ");
    echo "<br>$sql<br>";
    foreach($db_found->query($sql) as $row) {
                $classList .= "$row[class],";
            }
            
            //$classList .= "$classList,ObjectL,";
            $classList = "$classList";
            
            echo "<br>$classList<br>";
?>

