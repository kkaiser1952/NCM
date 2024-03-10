<!doctype html>
<!-- This is the RF Hole Report report -->
<!-- 2023-08-07 -->
<!-- RF Hole  poi's are not stored by netID so i will ask for grid square locations -->

<?php
ini_set('display_errors', 1);
error_reporting(E_ALL ^ E_NOTICE);

require_once "dbConnectDtls.php";

//$grid = "em29oi,em29te";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the values from the form submission
    $grid = $_POST['grid'];
    
    //var_dump($_POST); returned: //array(1) { ["grid"]=> string(13) "em29oi,em29te" }

    // Prepare and bind the SQL statement to insert the data
    $sql = "
        SELECT id, class, Type, name, city, latitude, longitude,
               grid, tactical, Notes, radius, w3w, band
        FROM poi
        WHERE class = 'rfhole'
        AND grid IN (" . implode(',', array_fill(0, count(explode(',', $grid)), '?')) . ")
        ORDER BY band
    ";
    
    //echo "SQL Query: $sql"; // Print the SQL query for debugging

    // Prepare the statement
    $stmt = $db_found->prepare($sql);

    // Bind the values to the named placeholders
    $gridValues = explode(',', $grid);
    foreach ($gridValues as $index => $value) {
        $stmt->bindValue($index + 1, $value);
    }

    // Execute the statement
    if (!$stmt->execute()) {
        echo "SQL Error: " . $stmt->errorInfo()[2]; // Display the error message
    }
    
} // End if server
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Report RF-Hole POI's</title>
    <meta name="Keith Kaiser" content="Graham" />
    <link href='https://fonts.googleapis.com/css?family=Allerta' rel='stylesheet' type='text/css'>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- ******************************** Style Sheets *************************************** -->
    <link rel="stylesheet" href="css/rfpoi.css" /> 

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
            <label for="grid">Enter one or more maidenhead grid square(s), comma-separated:</label>
            <input type="text" name="grid" id="grid" placeholder="(e.g., EM29, EM29qe, EM29qe78)" required>

            <input type="submit" id="submitBtn" value="Request Report">
            <input type="button" value="Cancel" onclick="resetForm()">

            <!-- Link to List All PoIs -->
            <a href="https://net-control.us/listAllPOIs.php" class="list-pois-link">List All PoI's</a>
        </form>
    </div> <!-- End of div at class="form-container" -->
</div> <!-- End of div at class="container" -->

<script>
    function resetForm() {
        document.getElementById("poiForm").reset();
    }
    
$(document).ready(function () {
    // Define the function to generate report content
    function generateReportContent(data) {
        let content = "<h2>RF Hole Report</h2>";
        data.forEach(row => {
            content += "<p>ID: " + row['id'] + "</p>";
            content += "<p>Class: " + row['class'] + "</p>";
            // Add more fields as needed...
            content += "<hr>"; // Add a horizontal line to separate entries
        });
        return content;
    }
    
    $('#poiForm').submit(function (e) {
        e.preventDefault();
        $.ajax({
            url: window.location.href,
            method: 'POST',
            data: $(this).serialize(),
            dataType: 'json', // Set the data type to HTML
            success: function (response) {
                const reportContent = generateReportContent(response);
                showModal('RF Hole Report', reportContent);
                resetForm(); // Reset the form after successful submission
            },
            error: function (xhr, status, error) {
                console.error(error); // Log the error details to the browser console
                alert("An error occurred while fetching the report.");
            }
        }); // End ajax
    }); // End poiform
}); // End document


function showModal(title, content) {
    const modal = document.createElement('div');
    modal.classList.add('modal');

    modal.innerHTML = `
    <div class="modal-content">
        <span class="close-btn" onclick="closeModal()">&times;</span>
        <div class="modal-header">
            <h3>${title}</h3>
        </div>
        <div class="modal-body">
            ${content}
        </div>
    </div>
`;

    document.body.appendChild(modal);
} // End function showModal

function closeModal() {
    const modal = document.querySelector('.modal');
    document.body.removeChild(modal);
} // END function closeModal

function printReport() {
    const content = document.querySelector('.modal-body').innerHTML;
    const printWindow = window.open('', '_blank');
    printWindow.document.open();
    printWindow.document.write(`<html><head><title>Print Report</title></head><body>${content}</body></html>`);
    printWindow.document.close();
    printWindow.print();
    printWindow.close();
} // End function printReport

</script>

<script>
  // Get the input element
  const inputElement = document.getElementById('grid');

  // Add a keydown event listener to prevent form submission on Enter key
  inputElement.addEventListener('keydown', function(event) {
        if (event.key === 'Enter') {
            event.preventDefault();
            // Optionally, you can trigger your AJAX request here
        }
  });



</script>
</body>
</html>