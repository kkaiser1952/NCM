<?php
// getGenCommentsReplacement.php
// Written: 2024-11-19
// Checks on loading an exsisting net if it has any generl comments to add to the genComm field.

require_once "dbConnectDtls.php";

function getExistingComments($netID) {
    global $db_found;
    
    try {
        // Validate netID
        $netID = filter_var($netID, FILTER_VALIDATE_INT);
        if (!$netID || $netID <= 0) {
            return '';
        }

        // Use prepared statement for security
        $stmt = $db_found->prepare("
            SELECT comment 
            FROM TimeLog 
            WHERE callsign = 'GENCOMM'
            AND netID = :netID
            ORDER BY uniqueID DESC
            LIMIT 1
        ");

        $stmt->execute([':netID' => $netID]);
        
        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            return htmlspecialchars(urldecode($row['comment']), ENT_QUOTES, 'UTF-8');
        }
        
        return ''; // Return empty if no comment found
        
    } catch (PDOException $e) {
        error_log("Database Error in getExistingComments: " . $e->getMessage());
        return ''; // Return empty on error
    }
}
?>