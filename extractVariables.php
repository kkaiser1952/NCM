
<?php
function extractVariables($string) {
    $variables = explode('&', $string);
    $extractedVariables = [];

    foreach ($variables as $index => $variable) {
    $extractedVariables["variable" . ($index + 1)] = trim($variable);
}

    //var_dump($extractedVariables);
    return $extractedVariables;
}

?>