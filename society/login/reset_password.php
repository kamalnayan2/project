<?php
session_start();
include "../login/database/connet_pg.php";

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $user = $_POST['userna'];
    $mobile = $_POST['mob'];
    $new_password = $_POST['new_passwd'];
    $confirm_password = $_POST['confirm_passwd'];

    // Check if the mobile number and member ID exist in the database
    $query = "SELECT * FROM admine WHERE username = $1 AND mobileno = $2";
    $result = pg_prepare($conn, "check_member", $query);
    $result = pg_execute($conn, "check_member", array($user, $mobile));

    if (!$result) {
        echo "An error occurred while executing the query.";
        exit;
    }

    $user = pg_fetch_assoc($result);
    
    if ($user) {
        // Check if the new password and confirm password match
        if ($new_password === $confirm_password) {
            // Update the password in the database
            $query = "UPDATE admine  SET password = $1 WHERE id = $2";
            $result = pg_prepare($conn, "update_password", $query);
            $result = pg_execute($conn, "update_password", array($new_password, $member_id));

            if ($result) {
                echo "Your password has been updated successfully.";
                header("Location: adminlogin.php"); // Redirect to login page
                exit();
            } else {
                echo "An error occurred while updating the password.";
            }
        } else {
            echo "Passwords do not match.";
        }
    } else {
        echo "username or mobile number not found.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link rel="stylesheet" href="login.css">
    <style>
    body {
            font-family: Arial, sans-serif;
            background-color: #CDD49EFF;
            margin: 0;
            padding: 0;
        }

        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .login-container {
            background: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(25, 0, 253, 1);
            width: 600px;
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        button {
            width: 100%;
            padding: 10px;
            background-color: #5cb85c;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #4cae4c;
        }

        .session-message {
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
            text-align: center;
        }

        .session-message.success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .session-message.error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .register-forget {
            text-align: center;
            margin-top: 10px;
        }

        .register-forget a {
            color: #007bff;
            text-decoration: none;
        }

        .register-forget a:hover {
            text-decoration: underline;
        }
    </style>
 
</head>
<body>
    <section class="container">
        <div class="login-container">
            <h1 class="opacity">RESET PASSWORD</h1>
            <form action="" method="post">
                <input type="text" placeholder="USERNAME" name="userna" required />
                <input type="text" placeholder="MOBILE NUMBER" name="mob" required />
                <input type="password" placeholder="NEW PASSWORD" name="new_passwd" required />
                <input type="password" placeholder="CONFIRM PASSWORD" name="confirm_passwd" required />
                <button class="opacity">SUBMIT</button>
            </form>
            <div class="register-forget opacity">
                <a href="adminlogin.php">BACK TO LOGIN</a>
            </div>
        </div>
    </section>
    <script src="login.js"></script>
</body>
</html>