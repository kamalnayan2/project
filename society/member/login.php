<?php
include "../login/database/connet_pg.php";
session_start();

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $mobile = $_POST['mob'];
    $password = $_POST['passwd'];

    // Debugging statements
    error_log("Mobile: " . $mobile); // Log the mobile number
    error_log("Password: " . $password); // Log the password (consider removing this in production)

    // Prepare the SQL statement
    $query = "SELECT * FROM member WHERE mobileno = $1";
    $result = pg_prepare($conn, "my_query", $query);
    $result = pg_execute($conn, "my_query", array($mobile));

    if (!$result) {
        error_log("Query failed: " . pg_last_error($conn)); // Debugging statement
        echo "An error occurred while executing the query."; 
        exit; 
    }

    $arr = pg_fetch_array($result, 0, PGSQL_ASSOC);

    // Check if user exists
    if ($arr) {
        // Assuming the password is stored in plain text (not recommended)
        // If the password is hashed, use password_verify() instead
        if ($arr['password'] === $password) {
            // Set session variables
            $_SESSION['user_id'] = $arr['memberid']; // Assuming 'memberid' is the primary key
            header("Location: dashboard.php"); // Redirect to home page
            exit();
        } else {
            echo "Invalid password.";
        }
    } else {
        echo "Invalid mobile number.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Login</title>
    <link rel="stylesheet" href="login.css">
</head>
<body>
    <section class="container">
        <div class="login-container">
            <div class="circle circle-one"></div>
            <div class="form-container">
                <h1 class="opacity">USER LOGIN</h1>
                <form action="login.php" method="post">
                    <input type="text" placeholder="MOBILE NUMBER" name="mob" required />
                    <input type="password" placeholder="PASSWORD" name="passwd" required />
                    <button class="opacity">SUBMIT</button>
                </form>
                <div class="register-forget opacity">
                    <a href="add.php">REGISTER</a>
                    <a href="reset_password.php">FORGOT PASSWORD</a>
                </div>
            </div>
            <div class="circle circle-two"></div>
        </div>
        
        <div class="theme-btn-container"></div>
    </section>
    <script src="login.js"></script>
</body>
</html>