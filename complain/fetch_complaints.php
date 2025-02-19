<?php
include "../partials/db_connect.php";
$query = "SELECT * FROM complain";
$result = pg_query($conn, $query);

$complaint = [];
while ($row = pg_fetch_assoc($result)) {
    $complaint[] = $row;
}

pg_close($conn);

header('Content-Type: application/json');
echo json_encode($complaint);
?>