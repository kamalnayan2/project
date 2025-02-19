<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php'); 
    exit();
}
include 'db_connect.php';
// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $mid = $_POST['mid'];
    $mname = $_POST['mname'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];

    // Prepare the SQL statement to update the member's profile
    $result = pg_prepare($conn, "update_member", "UPDATE member SET name = $1, mobileno = $2, flatno = $3 WHERE memberid = $4");
    $result = pg_execute($conn, "update_member", array($mname, $phone, $address, $mid));

    // Check if the update was successful
    if ($result) {
        // Redirect to the profile page with a success message
        header("Location: profile.php?success=Profile updated successfully");
        exit();
    } else {
        // Handle error
        die("Error updating profile: " . pg_last_error());
    }
}

// Close the database connection
pg_close($conn);
?>