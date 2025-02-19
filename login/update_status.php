<?php
// Database connection parameters
include "../partials/db_connect.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $requestId = $_POST['requestId'];
    $status = trim($_POST['status']);

    if (empty($status)) {
        echo json_encode(['success' => false, 'error' => 'Status cannot be empty.']);
        exit;
    }

    // Prepare and execute the update statement
    $sql = "UPDATE requests SET status = $1 WHERE id = $2";
    $result = pg_query_params($conn, $sql, array($status, $requestId));

    if ($result) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => pg_last_error($conn)]);
    }
}

// Close the connection
pg_close($conn);
?>