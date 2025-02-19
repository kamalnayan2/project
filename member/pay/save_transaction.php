<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

include_once 'db.php';

// Log incoming POST data for debugging
file_put_contents('debug.log', print_r($_POST, true), FILE_APPEND);

// Check if the required POST parameters are set
if (!isset($_POST['order_id'], $_POST['payment_id'], $_POST['amount'], $_POST['maintenance_id'])) {
    echo json_encode(["error" => "Missing required parameters."]);
    pg_close($conn);
    exit;
}

$order_id = $_POST['order_id'];
$payment_id = $_POST['payment_id'];
$amount = floatval($_POST['amount']) / 100; // Convert back to original amount
$maintenance_id = $_POST['maintenance_id'];

// Check if maintenance_id exists
$checkQuery = "SELECT * FROM Maintenance WHERE maintenance_id = $1";
$checkResult = pg_query_params($conn, $checkQuery, [$maintenance_id]);

if (pg_num_rows($checkResult) == 0) {
    echo json_encode(["error" => "No maintenance record found with ID: $maintenance_id"]);
    pg_close($conn);
    exit;
}

// Insert transaction details
$query = "INSERT INTO transactions (order_id, payment_id, amount, status, maintenance_id) VALUES ($1, $2, $3, 'Success', $4)";
$result = pg_query_params($conn, $query, [$order_id, $payment_id, $amount, $maintenance_id]);

if ($result) {
    // Update maintenance status
    $updateQuery = "UPDATE Maintenance SET status = 'Paid' WHERE maintenance_id = $1";
    $updateResult = pg_query_params($conn, $updateQuery, [$maintenance_id]);

    if ($updateResult) {
        // Check how many rows were affected
        if (pg_affected_rows($updateResult) > 0) {
            echo json_encode(["success" => "Payment successful! Transaction ID: " . pg_last_oid($result)]);
        } else {
            echo json_encode(["error" => "No rows updated. Maintenance ID may not exist or status is already 'Paid'."]);
        }
    } else {
        // Log the error if the update fails
        echo json_encode(["error" => "Failed to update maintenance status. Error: " . pg_last_error($conn)]);
    }
} else {
    // Log the error if the insert fails
    echo json_encode(["error" => "Transaction failed. Error: " . pg_last_error($conn)]);
}

pg_close($conn);
?>