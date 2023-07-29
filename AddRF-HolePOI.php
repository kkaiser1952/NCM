<!doctype html>

<?php
ini_set('display_errors', 1);
error_reporting(E_ALL ^ E_NOTICE);

require_once "dbConnectDtls.php";

// Initialize variables
$callsign = $radius = $w3w = $type = $notes = "";

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Get the values from the form submission
    $callsign = $_POST['callsign'];
    $radius = $_POST['radius'];
    $w3w = $_POST['w3w'];
    $type = $_POST['type'];
    $notes = $_POST['notes'];

    // Set hard-coded values
    $class = 'RF-Hole';
    $Notes = 'date added';

    // Generate the 'name' value by concatenating 'RF-HoleK' with the last inserted ID
    $name = 'RF-HoleK' . $conn->lastInsertId();

    // Prepare and execute the SQL statement to insert the data
    $stmt = $conn->prepare("INSERT INTO poi (callsign, radius, w3w, type, class, Notes, name) VALUES (:callsign, :radius, :w3w, :type, :class, :Notes, :name)");
    $stmt->bindParam(":callsign", $callsign);
    $stmt->bindParam(":radius", $radius);
    $stmt->bindParam(":w3w", $w3w);
    $stmt->bindParam(":type", $type);
    $stmt->bindParam(":class", $class);
    $stmt->bindParam(":Notes", $Notes);
    $stmt->bindParam(":name", $name);

    // Execute the prepared statement
    if ($stmt->execute()) {
        // Retrieve the entire record by querying the database
        $query = "SELECT * FROM poi WHERE id = :id";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(":id", $conn->lastInsertId());
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        echo json_encode($row); // Return the inserted record's data as JSON
    } else {
        echo "Error: Failed to insert data";
    }
    exit; // End the script here, no need to execute the remaining code.
}
?>
<!-- Rest of the HTML code as before -->
     

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
    </style>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
    </script>

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
    <label for="callsign">Callsign:</label>
    <input type="text" name="callsign" required><br>

    <label for="radius">Radius:</label>
    <input type="text" name="radius" required><br>

    <label for="w3w">What3Words:</label>
    <input type="text" name="w3w" required><br>

    <label for="type">Type:</label>
    <select name="type" required>
        <option value="K1">K0 - No Copy</option>
        <option value="K1">K1 - Very Poor</option>
        <option value="K2">K2 - Noisy, Poor Copy</option>
        <option value="K3">K3 - Noisy, Copyable</option>
        <option value="K4">K4 - Variable</option>
    </select><br>

    <label for="notes">Notes:</label>
    <input type="text" name="notes" value="date added" required><br>

    <input type="submit" value="Add Entry">
    <input type="button" value="Cancel" onclick="resetForm()">
</form>

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
<!-- ... -->

</body>
</html>
