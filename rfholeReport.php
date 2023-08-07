<!doctype html>
<!-- This is the RF Hole Report report -->
<!-- 2023-08-07 -->
<!-- RF Hole  poi's are not stored by netID so i will ask for a center point to give all POI's within 25 miles of that location -->

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
    $grid = $_POST['grid'];
            
    // Prepare and bind the SQL statement to insert the data
    $stmt = $db_found->prepare("SELECT id, class, Type, name, city, latitude, longitude,
                                       grid, tactical, Notes, radius, w3w, band
                                  FROM poi
                                 WHERE class = 'rfhole'
                                   AND grid in( :grid )
                                 ORDER BY band  
                               ");
            // Bind the values to the named placeholders            
            $stmt->bindValue(':grid', $grid);

            // Execute the prepared statement
            if ($stmt->execute()) {
                // Fetch all rows as an associative array
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                
                // Perform the foreach loop to process each row
                foreach ($result as $row) {
                    // Access individual columns using keys in the $row associative array
                    $column1Value = $row['column1']; 
                    $column2Value = $row['column2']; 
                        // Do whatever you need to do with the retrieved data
                        // For example, you could echo the values or perform further operations
                        echo "Column 1: $column1Value, Column 2: $column2Value<br>";
                    } // End foreach
                } // End if stmt
                  else {
                    // Handle the case when the statement execution fails
                    echo "Error executing the statement.";
                  } // End else
} // End if $_server 
?>

   
<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Report RF-Hole POI's</title>
    <meta name="Keith Kaiser" content="Graham" />
    <link href='https://fonts.googleapis.com/css?family=Allerta' rel='stylesheet' type='text/css'>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


<style>
body {
    margin: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    font-size: 18pt;
    background-color: #f7f7f7; /* Optional: Add a background color for better visibility */
}

.container {
    width: 60%; /* Adjust the width as per your requirement */
    max-width: 1000px; /* Add a max-width for larger screens */
}

/* Center the title and instructions */
.title-container {
    text-align: center;
    font-size: 24px;
    margin-bottom: 20px;
}

.instructions {
    max-width: 100%; /* Allow instructions to take full width */
    font-size: 14pt;
    color: #5a8bff; /* Set the desired text color */
    -webkit-text-fill-color: #5a8bff; /* For Safari */
    -webkit-opacity: 1; /* For Safari */
}

/* Container for the form */
.form-container {
    text-align: left;
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
    font-weight: bold;
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
    font-size: 16pt;
    margin-right: 10px; /* Add more space between the label and checkbox */
}

/* Position the link on the right side and style it */
.list-pois-link {
    font-size: 18px;
    float: right;
    margin-top: 10px;
    color: #5a8bff;
}

/* Add some spacing between the buttons and the link */
#poiForm {
    margin-bottom: 20px;
}

/* Center the form horizontally */
.form-container {
    margin: 0 auto;
}

        
</style>

</head>
<body>
    <div class="container">
    <!-- Container for the title (left-justified) -->
    <div class="title-container">
        <h2>Welcome to the RF Hole Report Program</h2>
        <h3 id="instructions">Please fill out this form to submit the<br> grid square(s) (e.g. EM29, EM29qe) to <br>identify the location of RF Holes. <br>Seperate multiple grids with a comma.<br> Additional help can be found at;<br> <a href="https://net-control.us/help.php" target="_blank">https://net-control.us/help.php</a> </h3>
    </div>
    
    <!-- Container for the form (left-justified) -->
    <div class="form-container">
        <!-- ... -->
        <form id="poiForm" method="post">
            <label for="callsign">Enter one or more maidenhead grid square(s):</label>
            <input type="text" name="callsign" id="callsign" placeholder="(e.g., EM29, EM29qe, EM29qe78)" required>
                
            <input type="submit" id="submitBtn" value="Request Report">
            <input type="button" value="Cancel" onclick="resetForm()">
            
            <!-- Link to List All PoIs -->
            <a href="https://net-control.us/listAllPOIs.php" class="list-pois-link">List All PoI's</a>
        </form>
    </div> <!-- End of div at class="form-container" -->
</div> <!-- End of div at class="container" -->
    
<script>

</script>


<script>
    function resetForm() {
        document.getElementById("poiForm").reset();
    }

    $(document).ready(function() {
        $('#poiForm').submit(function(e) {
            e.preventDefault();
            $.ajax({
                url: 'RF-HoleReport.php',
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