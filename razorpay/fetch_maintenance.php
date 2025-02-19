<?php
session_start();
$host = 'localhost';
$db = 'society';
$user = 'postgres';
$pass = 'kamal';

$conn = pg_connect("host=$host dbname=$db user=$user password=$pass");

if (!$conn) {
    die("Connection failed: " . pg_last_error());
}

$result = pg_query($conn, "SELECT * FROM Maintenance WHERE Status = 'Pending'");
$maintenanceRecords = pg_fetch_all($result);

pg_close($conn);

echo json_encode($maintenanceRecords);
?>