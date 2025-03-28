<?php
// simple_activity_log.php
header('Content-Type: text/html');
echo "<div style='background-color:#ffff99; padding:5px; border:1px solid #ccc;'>";
echo "Activity log refreshed at: " . date('Y-m-d H:i:s') . "<br>";
echo "Net ID: " . (isset($_GET['q']) ? $_GET['q'] : 'none') . "<br>";
echo "This is a test update to verify SSE is working";
echo "</div>";
?> 