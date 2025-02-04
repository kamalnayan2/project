<?php
include_once "../partials/db_connect.php";
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $memberid = $_POST['memberid'];
    $complaindescription = $_POST['complaindescription'];
    $date = date('Y-m-d'); // Get the current date

    // Insert the complaint into the database
    $query = "INSERT INTO complain (memberid, complaindescription, date) VALUES ($1, $2, $3)";
    $result = pg_query_params($conn, $query, array($memberid, $complaindescription, $date));

    if ($result) {
        echo "<div class='container mt-5'><h2>Complaint submitted successfully!</h2><a href='submit_complaint.php' class='btn btn-primary'>Submit Another Complaint</a></div>";
    } else {
        echo "<div class='container mt-5'><h2>Error submitting complaint: " . pg_last_error($conn) . "</h2><a href='submit_complaint.php' class='btn btn-danger'>Go Back</a></div>";
    }
}

pg_close($conn);
?>