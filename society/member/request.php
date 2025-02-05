<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php'); 
    exit();
}
        // Display message after form submission
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Database connection parameters
            include "../partials/db_connect.php";
            // Get the issue description and sanitize it
            $issueDescription = trim($_POST['issueDescription']);
            if (empty($issueDescription)) {
                echo "<div class='alert alert-danger'>Issue description is required.</div>";
            } else {
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
                        echo "<div class='alert alert-danger'>Sorry, only JPG, JPEG, PNG & GIF files are allowed.</div>";
                    } else {
                        // Move the uploaded file to the target directory
                        if (!move_uploaded_file($_FILES['imageUpload']['tmp_name'], $imagePath)) {
                            echo "<div class='alert alert-danger'>Sorry, there was an error uploading your file.</div>";
                        }
                    }
                }

                // Prepare and execute the insert statement
                $sql = "INSERT INTO requests (description, image_path) VALUES ($1, $2)";
                $result = pg_query_params($conn, $sql, array($issueDescription, $imagePath));

                if ($result) {
                    echo "<div class='alert alert-success'>New request submitted successfully.</div>";
                } else {
                    echo "<div class='alert alert-danger'>Error: " . pg_last_error($conn) . "</div>";
                }
            }

            // Close the connection
            pg_close($conn);
        }
        ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Maintenance Request Form</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<?php require "_nav.php";?>
    <div class="container mt-5">
        <h1 class="text-center">Maintenance Request Form</h1>
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="issueDescription">Description of Issue:</label>
                <textarea id="issueDescription" name="issueDescription" class="form-control" rows="4" required></textarea>
            </div>

            <div class="form-group">
                <label for="imageUpload">Upload Image:</label>
                <input type="file" id="imageUpload" name="imageUpload" class="form-control-file" accept="image/*">
            </div>

            <button type="submit" class="btn btn-primary">Submit Request</button>
        </form>

        <h2 class="mt-5">Request Status</h2>
        <div id="requestStatus">
            <ul class="list-group">
                <?php
                // Fetch and display requests
                include "../partials/db_connect.php";
                $id=$_SESSION['user_id'];
                $result = pg_query($conn, "SELECT * FROM requests where member_id=$id ORDER BY created_at DESC");
                while ($row = pg_fetch_assoc($result)) {
                    echo "<li class='list-group-item'>{$row['description']} - Status: {$row['status']}</li>";
                }
                pg_close($conn);
                ?>
            </ul>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>