<?php
include "..//partials/db_connect.php"; // Include the database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if the required parameters are set
    if (isset($_POST['complainid']) && isset($_POST['status'])) {
        $complainid = $_POST['complainid'];
        $status = $_POST['status'];

        // Prepare the SQL query to update the status
        $query = "UPDATE complain SET status = $1 WHERE complainid = $2";
        $result = pg_query_params($conn, $query, array($status, $complainid));

        // Check if the update was successful
        if ($result) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => pg_last_error($conn)]);
        }
    } else {
        echo json_encode(['success' => false, 'error' => 'Missing parameters']);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid request method']);
}

pg_close($conn);
?>