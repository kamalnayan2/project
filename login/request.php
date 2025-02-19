<?php
// Display message after form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Database connection parameters
    include "../partials/db_connect.php";
    include_once "../member/";
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
    <style>
        body {

            background-color: #BDCE6FFF;
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <h2 class="mt-5">Request Status</h2>
        <div id="requestStatus" style="background-color: #D98422FF;">
            <table class="table table-striped" id="complaintsTable">
                <thead>
                    <tr>
                        <th>Request ID</th>
                        <th>Description</th>
                        <th>Image</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Fetch and display requests
                    include "../partials/db_connect.php";
                    $result = pg_query($conn, "SELECT * FROM requests ORDER BY created_at DESC");
                    while ($row = pg_fetch_assoc($result)) {
                        $path=$row['image_path'];
                        echo "<tr>
                                <td>{$row['id']}</td>
                                <td>{$row['description']}</td>
                                <td>
                                <img src='../member/$path' alt='Image' style='width: 200px;'>
                                </td>
                                <td>{$row['status']}</td>
                                <td>
                                    <button class='btn btn-primary' onclick='updateStatus({$row['id']})'>Update Status</button>
                                </td>
                              </tr>";
                    }
                    pg_close($conn);
                    ?>
                </tbody>
            </table>
            <div class="text-center">
                <a href="..//login/home.php" class="btn btn-primary">Back to Home</a>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        function updateStatus(requestId) {
            const newStatus = prompt("Enter new status:");
            if (newStatus) {
                $.ajax({
                    url: 'update_status.php',
                    method: 'POST',
                    data: {
                        requestId: requestId,
                        status: newStatus
                    },
                    success: function(response) {
                        console.log(response); // Log the response
                        if (response.success) {
                            alert('Error updating status: ' + response.error);
                        } else {
                            alert('Status updated successfully!');
                            location.reload(); // Refresh the page to see the updated status
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText); // Log the error response
                        alert('Error updating status: ' + error);
                    }
                });
            }
        }
    </script>
</body>
</html>