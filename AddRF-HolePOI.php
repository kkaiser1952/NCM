<!-- This program is used to add a RF-Hole style POI to the poi table -->
<!-- Written: 2023=07-30 by WA0TJT -->

<!-- ///slap.rider.steer -->

<?php
ini_set('display_errors', 1);
error_reporting(E_ALL ^ E_NOTICE);

require_once "dbConnectDtls.php";
require_once "ENV_SETUP.php";      // API's
require_once "GridSquare.php";

$w3wApiKey = getenv('w3wapikey');


// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the values from the form submission
    $callsign = strtoupper($_POST['callsign']); // Convert callsign to uppercase
    $radius   = $_POST['radius']; // This is in miles, .05, .1, 1.0, 2.5, etc
    $w3w      = $_POST['w3w']; // Entered as the primary value of a location
    $type     = $_POST['type']; // Meant to be the severity of the RF Hole ... K0 to K4
    $band     = $_POST['band'];
    
    // Convert the w3w value into latitude and longitude with this W3W API
    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => "https://api.what3words.com/v3/convert-to-coordinates?key=$w3wApiKey&words=$w3w",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
        echo "cURL Error #:" . $err;
    } else {
        $w3wLL = json_decode($response, true);
        
        // Print the ARRAY created above in something easy to read
        // print_r($w3wLL);

        // Check if latitude and longitude are present
        if (isset($w3wLL['coordinates'])) {
            $latitude = $w3wLL['coordinates']['lat'];
            $longitude = $w3wLL['coordinates']['lng'];
            
            // Use explode to split the string by comma and get the first part
            $parts = explode(',', $w3wLL['nearestPlace']);
            
            // Trim any leading or trailing whitespace from the first part
            $city = trim($parts[0]);
            $country = $w3wLL['country'];
            
            $grid   = gridsquare($latitude, $longitude);   

            // Prepare and bind the SQL statement to insert the data
            $stmt = $db_found->prepare("INSERT INTO poi (callsign, radius, w3w, type, name, tactical, Notes, latitude, longitude, city, country, grid, class) VALUES (:callsign, :radius, :w3w, :type, :name, :tactical, :notes, :latitude, :longitude, :city, :country, :grid, :class, :band)");

            // Bind the values to the named placeholders
            $stmt->bindValue(':callsign', $callsign);
            $stmt->bindValue(':radius', $radius);
            $stmt->bindValue(':w3w', $w3w);
            $stmt->bindValue(':type', $type);
            $stmt->bindValue(':latitude', $latitude);
            $stmt->bindValue(':longitude', $longitude);
            $stmt->bindValue(':city', $city);
            $stmt->bindValue(':country', $country);
            $stmt->bindValue(':grid', $grid);
            $stmt->bindValue(':class', 'RF-Hole');
            $stmt->bindValue(':band', $band);

            // Set the current date (date only) in the 'Notes' column
            $currentDate = date('Y-m-d');
            $notes = isset($_POST['notes']) ? $_POST['notes'] : '';
            $notesWithDate = "Created: " . $currentDate . ' -- ' . $notes;

            // Get the latest ID from the table 'poi'
            $query = "SELECT id FROM poi ORDER BY id DESC LIMIT 1";
            $result = $db_found->query($query);
            if ($result && $result->rowCount() > 0) {
                $latestIdRow = $result->fetch(PDO::FETCH_ASSOC);
                $tacticalId = $latestIdRow['id'] + 1;
            } else {
                // If no rows are present, start with ID = 1
                $tacticalId = 1;
            }

            // Calculate and bind the 'tactical' column value (e.g., "RF-HoleK1 535")
            $namePrefix     = "RF-HoleK1"; // Change this if you want a different prefix
            $tacticalPrefix = "RFH";
            $tactical       = $tacticalPrefix . '-' . $tacticalId;
                $stmt->bindValue(':tactical', $tactical);

            $name           = $namePrefix . ' ' . $tacticalId;
                $stmt->bindValue(':name', $name);

            // Bind the 'Notes' column value
                $stmt->bindValue(':notes', $notesWithDate);

            // Execute the prepared statement
            if ($stmt->execute()) {
                // Retrieve the entire record by querying the database
                $lastInsertId = $db_found->lastInsertId();
                $query        = "SELECT * FROM poi WHERE id = " . $lastInsertId;
                $result       = $db_found->query($query);

                if ($result && $result->rowCount() > 0) {
                    $row = $result->fetch(PDO::FETCH_ASSOC);
                    echo json_encode($row); // Return the inserted record's data as JSON
                } else {
                    echo "Error: Latitude or Longitude not found from What3Words API.";
                }
            } else {
                echo "Error: " . $stmt->errorInfo()[2];
            }
        } else {
            echo "Error: Latitude or Longitude not found from What3Words API.";
        }
    }

    exit; // End the script here, no need to execute the remaining code.
}
?>
   
<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Add RF-Hole POI</title>
    <meta name="Keith Kaiser" content="Graham" />
    <!--  <link rel="stylesheet" type="text/css" media="all" href="css/ics214.css"> -->
    <link href='https://fonts.googleapis.com/css?family=Allerta' rel='stylesheet' type='text/css'>

    <style>
        body {
            font-size: 16pt;
        }

        /* Container for the title */
        .title-container {
            text-align: left;
        }

        /* Container for the form */
        .form-container {
            max-width: 300px;
            margin: 0 auto;
            text-align: left;
            margin-left: 20px;
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        input[type="text"],
        select {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            font-size: inherit;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
            width: 100%;
            font-size: inherit;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }
        
        /* Style the select element */
        select[name="type"] {
          font-size: 16pt; /* Adjust the font size as per your requirement */
        }
        
        /* Style the options within the dropdown */
        select[name="type"] option {
          font-size: 16pt; /* Adjust the font size as per your requirement */
        }
        
        /* CSS to horizontally align checkboxes and match style with select */
        .checkbox-container {
            display: inline-block;
            margin-right: 20px;
        }
    
        .checkbox-container input[type="checkbox"] {
            margin-right: 12px;
        }
    
        .checkbox-container label {
            font-size: 16px;
            margin-right: 10px; /* Add more space between the label and checkbox */
        }
        
    </style>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

</head>
<body>
    <!-- Container for the title (left-justified) -->
    <div class="title-container">
        <h1>Add A RF-Hole POI Entry</h1>
    </div>
    
    <!-- Container for the form (left-justified) -->
    <div class="form-container">
        <!-- ... -->
        <form id="poiForm" method="post">
            <label for="callsign">Your Callsign:</label>
            <input type="text" name="callsign" required><br>
        
            <label for="radius">Radius in miles, (.1 or .01, 1.2 etc):</label>
            <input type="text" name="radius" required><br>
        
            <label for="w3w">What3Words:</label>
            <input type="text" name="w3w" required><br>
        
            <label for="type">Severity Type:</label>
            <select name="type" required>
                <option value="" disabled>Click to choose</option>
                <option value="K1">K0 - No Copy</option>
                <option value="K1">K1 - Very Poor Copy</option>
                <option value="K2">K2 - Noisy, Poor Copy</option>
                <option value="K3">K3 - Noisy, Copyable</option>
                <option value="K4">K4 - Variable</option>
            </select><br><br>
            
            <label for="bands">Select Tested Bands:</label>
            <div class="checkbox-container">
                <input type="checkbox" name="band[]" id="vhf" value="VHF" checked>
                <label for="vhf">VHF</label>
            </div>
            <div class="checkbox-container">
                <input type="checkbox" name="band[]" id="uhf" value="UHF">
                <label for="uhf">UHF</label>
            </div>
            <div class="checkbox-container">
                <input type="checkbox" nname="band[]" id="hf" value="HF">
                <label for="hf">HF</label>
            </div>
            <br><br>
        
            <label for="notes">Notes:</label>
            <input type="text" name="notes" id="infield" placeholder="Enter your notes here..." required><br>

        
            <input type="submit" value="Add Entry">
            <input type="button" value="Cancel" onclick="resetForm()">
        </form>
    </div> <!-- End of div at class="form-container" -->

<script>
    function resetForm() {
        document.getElementById("poiForm").reset();
    }

    $(document).ready(function() {
        $('#poiForm').submit(function(e) {
            e.preventDefault();
            $.ajax({
                url: 'AddRF-HolePOI.php',
                method: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    alert(response);
                    resetForm(); // Reset the form after successful submission
                }
            });
        });
    });
</script>
<script>
  // Get the input element
  const inputElement = document.getElementById('infield');

  // Add a click event listener to the input field
  inputElement.addEventListener('click', function() {
    // Clear the value when clicked
    inputElement.value = '';
  });
</script>

</body>
</html>
