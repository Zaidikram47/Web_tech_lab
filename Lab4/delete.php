<?php
/**
 * Record Deletion Handler
 * EduPortal Management System
 */

require_once 'db.php';

// 1. Strict input validation instead of basic $_GET casting
$recordId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

// 2. Terminate immediately if the ID is missing, malicious, or zero
if (!$recordId || $recordId <= 0) {
    header('Location: index.php');
    exit;
}

try {
    $db = getPDO();

    // 3. Prepare the deletion query with a LIMIT 1 safety catch
    // This ensures that even if something goes catastrophically wrong, 
    // it is impossible to accidentally wipe the entire table.
    $deleteQuery = "DELETE FROM `students` WHERE `id` = :id LIMIT 1";

    $statement = $db->prepare($deleteQuery);

    // 4. Execute using named parameters instead of generic question marks
    $statement->execute([':id' => $recordId]);

    // 5. Redirect back to the dashboard with a subtle success flag in the URL
    header('Location: index.php?action=deleted');
    exit;

} catch (PDOException $e) {
    // If the database connection fails or the table is locked, 
    // fail gracefully rather than printing a raw SQL error to the browser.
    header('Location: index.php?action=error');
    exit;
}