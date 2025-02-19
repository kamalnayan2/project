<?php
$host = "localhost";
$dbname = "society";
$user = "postgres";
$password = "kamal";

$conn = pg_connect("host=$host dbname=$dbname user=$user password=$password");
if (!$conn) {
  die("Error in connection: " . pg_last_error());
}

?>