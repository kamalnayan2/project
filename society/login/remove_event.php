<?php
include_once "../partials/db_connect.php";

// Get the JSON input
$data = json_decode(file_get_contents("php://input"), true);
$id = $data['id'];

// Remove the event
$sql = "DELETE FROM events WHERE id=$1";
$result = pg_query_params($conn, $sql, array($id));

$response = [];
if ($result) {
    $response['success'] = true;
} else {
    $response['success'] = false;
}

pg_close($conn);
echo json_encode($response);
?>