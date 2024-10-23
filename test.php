<?php
// First line output test
echo "Line 1: Script started\n"; flush();

// Turn on all error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);
echo "Line 2: Error reporting enabled\n"; flush();

// Test if the file exists
echo "Line 3: Checking for Geocoder.php\n"; flush();
if (file_exists('Geocoder.php')) {
    echo "Line 4: Geocoder.php found\n"; flush();
} else {
    echo "Line 4: Geocoder.php NOT found\n"; flush();
    die();
}

// Look at the file content
echo "Line 5: Reading Geocoder.php content:\n"; flush();
echo htmlspecialchars(file_get_contents('Geocoder.php')) . "\n"; flush();

// Try including without namespace
echo "Line 6: Including Geocoder.php\n"; flush();
include_once 'Geocoder.php';
echo "Line 7: Include successful\n"; flush();

// Try class_exists check
echo "Line 8: Checking if Geocoder class exists\n"; flush();
if (class_exists('What3words\Geocoder\Geocoder', false)) {
    echo "Line 9: Class exists without autoload\n"; flush();
} else {
    echo "Line 9: Class does not exist without autoload\n"; flush();
}

if (class_exists('What3words\Geocoder\Geocoder', true)) {
    echo "Line 10: Class exists with autoload\n"; flush();
} else {
    echo "Line 10: Class does not exist with autoload\n"; flush();
}

// Try explicit declaration
echo "Line 11: Attempting explicit namespace declaration\n"; flush();
try {
    echo "Line 12: Before use statement\n"; flush();
    use What3words\Geocoder\Geocoder;
    echo "Line 13: After use statement\n"; flush();
} catch (Error $e) {
    echo "Line 13 Error: " . $e->getMessage() . "\n"; flush();
}

echo "Line 14: Script reached the end\n"; flush();
?>