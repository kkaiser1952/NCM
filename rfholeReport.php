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
                                   AND grid IN (" . implode(',', array_fill(0, count(explode(',', $grid)), '?')) . ")
                             ORDER BY band   
                               ");
    // Bind the values to the named placeholders
    $stmt->execute(explode(',', $grid));

}

function generateReportContent($data) {
    $content = "<h2>RF Hole Report</h2>";
    foreach ($data as $row) {
        $content .= "<p>ID: " . $row['id'] . "</p>";
        $content .= "<p>Class: " . $row['class'] . "</p>";
        // Add more fields as needed...
        $content .= "<hr>"; // Add a horizontal line to separate entries
    }
    return $content;
}
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
    
    <style>
        /* Modal styles here */
        .modal {
            display: block;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.8);
        }

        .modal-content {
            background-color: white;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
        }

        .close-btn {
            float: right;
            font-size: 28px;
            cursor: pointer;
        }

        .modal-header h3 {
            margin: 0;
        }

        .modal-body {
            padding-top: 20px;
            padding-bottom: 20px;
        }

        .modal-footer {
            display: flex;
            justify-content: flex-end;
            padding-top: 10px;
        }

        .modal-footer button {
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Container for the title (left-justified) -->
        <div class="title-container">
            <h2>Welcome to the RF Hole Report Program</h2>
            <h3 id="instructions">Please fill out this form to submit the<br> grid square(s) (e.g. EM29, EM29qe) to <br>identify the location of RF Holes. <br>Separate multiple grids with a comma.<br> Additional help can be found at;<br> <a href="https://net-control.us/help.php" target="_blank">https://net-control.us/help.php</a> </h3>
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
            $('#poiForm').submit(function (e) {
                e.preventDefault();
                $.ajax({
                    url: 'RF-HoleReport.php',
                    method: 'POST',
                    data: $(this).serialize(),
                    success: function (response) {
                        showModal('RF Hole Report', response);
                        resetForm(); // Reset the form after successful submission
                    },
                });
            });
        });

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
                    <div class="modal-footer">
                        <button onclick="printReport()">Print</button>
                    </div>
                </div>
            `;

            document.body.appendChild(modal);
        }

        function closeModal() {
            const modal = document.querySelector('.modal');
            document.body.removeChild(modal);
        }

        function printReport() {
            const content = document.querySelector('.modal-body').innerHTML;
            const printWindow = window.open('', '_blank');
            printWindow.document.open();
            printWindow.document.write(`<html><head><title>Print Report</title></head><body>${content}</body></html>`);
            printWindow.document.close();
            printWindow.print();
            printWindow.close();
        }
    </script>
</body>
</html>
