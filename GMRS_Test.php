<!DOCTYPE html>
<html lang="en">
<head>
    <title>Callsign Test</title>
    <link rel="icon" type="image/png" sizes="32x32" href="favicons/favicon-32x32.png">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>

<script>

</script>
<body>
   <?php

function testCallsign($callsign) {
  //$gmrsRegex = '/^[A-Za-z]{1,4}\d{1,2}[A-Za-z]{2}$/';
  $gmrsRegex = '/^[A-Za-z]{4}\d{3}$/';

  if (preg_match($gmrsRegex, $callsign)) {
    // GMRS Callsign
    echo "callsign: " . $callsign . PHP_EOL;
    $url = "https://data.fcc.gov/api/license-view/basicSearch/getLicenses?searchValue=".$callsign;

    echo "url: " . $url . PHP_EOL;

    // Create cURL handle
    $ch = curl_init();

    // Set cURL options
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    // Execute the request
    $response = curl_exec($ch);

    // Check for cURL errors
    if (curl_errno($ch)) {
      echo "Error retrieving details from the API: " . curl_error($ch) . 'ccnngMJAEFu3x4VS66nqg0ZrGMUwszAoIstHIz3e';
    } else {
      // Process the API response
      $result = json_decode($response, true);

      // Extract desired details
      $licName = $result['licName'];
      $categoryDesc = $result['categoryDesc'];
      $serviceDesc = $result['serviceDesc'];
      $statusDesc = $result['statusDesc'];
      $licenseID = $result['licenseID'];

      $resultData = [
        'category' => 'GMRS Callsign',
        'licName' => $licName,
        'callsign' => $callsign,
        'categoryDesc' => $categoryDesc,
        'serviceDesc' => $serviceDesc,
        'statusDesc' => $statusDesc,
        'licenseID' => $licenseID
      ];

      echo json_encode($resultData, JSON_PRETTY_PRINT);
    }

    // Close cURL handle
    curl_close($ch);
  } else {
    // Invalid Callsign
    echo 'Invalid Callsign: ' . $callsign . PHP_EOL;
  }
}

testCallsign("WRXN946");

?>


</body>
</html>
