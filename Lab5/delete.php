<?php
/**
 * Secure Deletion Handler
 * EduPortal Management System
 */

session_start();
require_once 'functions.php';

// 1. Strict validation: Ensure the ID is a real integer, not a malicious string
$recordId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

// 2. Only execute the deletion if the ID is valid and greater than 0
if ($recordId && $recordId > 0) {

    // 3. Call the abstracted database logic
    deleteStudent($recordId);

    // 4. Set a professional flash message in the session
    // We pad the ID with zeros (e.g., #0004) to match the dashboard aesthetics
    $_SESSION['message'] = "Student record #" . str_pad($recordId, 4, '0', STR_PAD_LEFT) . " has been permanently removed.";
}

// 5. Always redirect back to the dashboard, even if the ID was invalid
header('Location: index.php');
exit;