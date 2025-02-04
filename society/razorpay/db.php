<?php
$host = 'localhost'; // Your database host
$db = 'society'; // Your database name
$user = 'postgres'; // Your database username
$pass = 'kamal'; // Your database password

// Connect to PostgreSQL database
$conn = pg_connect("host=$host dbname=$db user=$user password=$pass");

if (!$conn) {
    die("Connection failed: " . pg_last_error());
}
?>