<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include database connection parameters
include "../partials/db_connect.php";

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the request ID and new status from the POST data
    $requestId = $_POST['requestId'];
    $status = trim($_POST['status']);

    // Validate the input
    if (empty($status)) {
        echo json_encode(['success' => false, 'error' => 'Status cannot be empty.']);
        exit;
    }

    // Check database connection
    if (!$conn) {
        echo json_encode(['success' => false, 'error' => 'Database connection failed.']);
        exit;
    }

    // Prepare the SQL statement to update the status
    $sql = "UPDATE requests SET status = $1 WHERE id = $2";
    $result = pg_query_params($conn, $sql, array($status, $requestId));

    // Check if the update was successful
    if ($result) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => pg_last_error($conn)]);
    }

    // Close the database connection
    pg_close($conn);
} else {
    // If the request method is not POST, return an error
    echo json_encode(['success' => false, 'error' => 'Invalid request method.']);
}
?>