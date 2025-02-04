<?php
include "../login/database/connet_pg.php";
session_start();

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $username = $_POST['uname'];
    error_log("Username: " . $username); // Debugging statement

    $password = $_POST['passwd'];

    // Prepare the SQL statement
    $query = "SELECT * FROM admine WHERE username = $1 AND password = $2";
    $result = pg_prepare($conn, "my_query", $query);
    $result = pg_execute($conn, "my_query", array($username, $password));

    if (!$result) {
        error_log("Query failed: " . pg_last_error($conn)); // Debugging statement

        echo "An error occurred while executing the query."; 
        exit; 
    }

    $arr = pg_fetch_array($result, 0, PGSQL_NUM);
    // error_log("Query result: " . print_r($arr, true)); // Debugging statement

    
    // Check if user exists and verify password
    if ($arr) {
        // Set session variables
        $_SESSION['user_id'] = $arr[0]; // Assuming 'id' is the primary key
        header('Location: home.php'); // Redirect to home page
        exit();
    } else {
        echo "Invalid username or password.";
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
                <img src="https://raw.githubusercontent.com/hicodersofficial/glassmorphism-login-form/master/assets/illustration.png" alt="illustration" class="illustration" />
                <h1 class="opacity">ADMIN LOGIN</h1>
                <form action="adminlogin.php" method="post" >
                    <input type="text" placeholder="USERNAME" name="uname"/>
                    <input type="password" placeholder="PASSWORD" name="passwd"/>
                    <button class="opacity">SUBMIT</button>
                </form>
                <div class="register-forget opacity">
                    <a href="register/adminregister.php">REGISTER</a>
                </div>
            </div>
            <div class="circle circle-two"></div>
        </div>
        <div class="theme-btn-container"></div>
    </section>
    <script src="login.js"></script>
</body>
</html>
