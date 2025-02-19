<?php
session_start();
include 'db.php';
$m_id=$_SESSION['member_id'];
$result = pg_query($conn, "SELECT * FROM Maintenance WHERE status = 'Pending' and member_id=$m_id");
$maintenanceRecords = pg_fetch_all($result);

pg_close($conn);

echo json_encode($maintenanceRecords);
?>