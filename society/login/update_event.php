<?php
include_once "../partials/db_connect.php";

// Get the JSON input
$data = json_decode(file_get_contents("php://input"), true);
$id = $data['id'];
$title = $data['title'];
$description = $data['description'];

// Update the event
$sql = "UPDATE events SET title=$1, description=$2 WHERE id=$3";
$result = pg_query_params($conn, $sql, array($title, $description, $id));

$response = [];
if ($result) {
    $response['success'] = true;
} else {
    $response['success'] = false;
}

pg_close($conn);
echo json_encode($response);
?>