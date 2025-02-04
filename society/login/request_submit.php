<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Database connection parameters
    include "../partials/db_connect.php";
    // Get the issue description and sanitize it
    $issueDescription = trim($_POST['issueDescription']);
    if (empty($issueDescription)) {
        die("Issue description is required.");
    }

    // Handle file upload
    $imagePath = null;
    if (isset($_FILES['imageUpload']) && $_FILES['imageUpload']['error'] == UPLOAD_ERR_OK) {
        $targetDir = "uploads/"; // Directory to save uploaded images
        $fileName = basename($_FILES['imageUpload']['name']);
        $imagePath = $targetDir . $fileName;

        // Validate file type (e.g., allow only JPEG and PNG)
        $fileType = strtolower(pathinfo($imagePath, PATHINFO_EXTENSION));
        $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
        if (!in_array($fileType, $allowedTypes)) {
            die("Sorry, only JPG, JPEG, PNG & GIF files are allowed.");
        }

        // Move the uploaded file to the target directory
        if (!move_uploaded_file($_FILES['imageUpload']['tmp_name'], $imagePath)) {
            die("Sorry, there was an error uploading your file.");
        }
    }

    // Prepare and execute the insert statement
    $sql = "INSERT INTO issues (issue_description, image_path) VALUES ($1, $2)";
    $result = pg_query_params($conn, $sql, array($issueDescription, $imagePath));

    if ($result) {
        echo "New record created successfully";
    } else {
        echo "Error: " . pg_last_error($conn);
    }

    // Close the connection
    pg_close($conn);
}
?>