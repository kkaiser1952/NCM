<!doctype html>

<?php

	ini_set('display_errors',1); 
	error_reporting (E_ALL ^ E_NOTICE);

    require_once "dbConnectDtls.php";
    
        
?>

<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Add RF-Hole POI</title>
    <meta name="Keith Kaiser" content="Graham" />
  <!--  <link rel="stylesheet" type="text/css" media="all" href="css/ics214.css"> -->
    <link href='https://fonts.googleapis.com/css?family=Allerta' rel='stylesheet' type='text/css'>
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <script>
    </script>
	    
</head>
<body>
    <h1>Add POI Entry</h1>
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
            <option value="K1">K1 - Very Poor </option>
            <option value="K2">K2 - Noisy, Poor Copy</option>
            <option value="K3">K3 - Noisy, Copyable</option>
            <option value="K4">K4 - Variable</option>
        </select><br>

        <label for="other">Other Variables:</label>
        <input type="text" name="other" required><br>

        <label for="notes">Notes:</label>
        <input type="text" name="notes" value="date added" required><br>

        <input type="submit" value="Add Entry">
    </form>
    <script>
        $(document).ready(function() {
            $('#poiForm').submit(function(e) {
                e.preventDefault();
                $.ajax({
                    url: 'add_poi.php',
                    method: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        alert(response);
                        $('#poiForm')[0].reset();
                    }
                });
            });
        });
    </script>
</body>
</html>
