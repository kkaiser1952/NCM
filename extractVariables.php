
<?php
function extractVariables($string) {
    $variables = explode('&', $string);
    $extractedVariables = [];

    foreach ($variables as $index => $variable) {
    $extractedVariables["variable" . ($index + 1)] = trim($variable);
}

    return $extractedVariables;
}

/*
$string = "LOC&#916:APRS OBJ::wa0tjt-1 & 1 Driveway & Keith and Deb from KCMO & ///mice.beak.glimmer & N Ames Ave & NW 60th Ct & 39.20283,-94.60267";

$result = extractVariables($string);

// Output the extracted variables
foreach ($result as $name => $variable) {
echo $name . ": " . $variable . "<br>";
}

*/

/*
    variable1: LOC
    variable2: #916:APRS OBJ::wa0tjt-1
    variable3: 1 Driveway
    variable4: Keith and Deb from KCMO
    variable5: ///mice.beak.glimmer
    variable6: N Ames Ave
    variable7: NW 60th Ct
    variable8: 39.20283,-94.60267
*?

?>
