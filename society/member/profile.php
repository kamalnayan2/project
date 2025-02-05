<?php
session_start();
$host = 'localhost';
$db = 'society';
$user = 'postgres';
$pass = 'kamal';

$conn = pg_connect("host=$host dbname=$db user=$user password=$pass");

if (!$conn) {
    die("Connection failed: " . pg_last_error());
}

$mid = $_SESSION['user_id'] ?? null; // Ensure mid is set
if ($mid === null) {
    die("User  not logged in.");
}

// Fetch user profile information
$result = pg_prepare($conn, "fetch_user", "SELECT * FROM member WHERE memberid = $1");
$result = pg_execute($conn, "fetch_user", array($mid));

if (!$result) {
    die("Error fetching user profile: " . pg_last_error());
}

$userProfile = pg_fetch_assoc($result);
pg_close($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Member Profile</title>
    <style>
        body {
            background-color: #f8f9fa;
        }
        .profile-container {
            margin-top: 50px;
            padding: 20px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>

<body>
<?php require "_nav.php";?>
    <div class="container profile-container">
        <h1 class="text-center">Member Profile</h1>
        <div class="row">
            <div class="col-md-6">
                <h4>Personal Information</h4>
                <p><strong>Name:</strong> <?= htmlspecialchars($userProfile['name']) ?></p>
                <p><strong>Phone:</strong> <?= htmlspecialchars($userProfile['mobileno']) ?></p>
                <p><strong>Address:</strong> <?= htmlspecialchars($userProfile['flatno']) ?></p>
            </div>
            <div class="col-md-6">
                <h4>Account Information</h4>
                <p><strong>Member ID:</strong> <?= htmlspecialchars($userProfile['memberid']) ?></p>
                <p><strong>Password:</strong> <em>(hidden for security)</em></p>
            </div>
        </div>
        <div class="text-center mt-4">
            <a href="edit_profile.php" class="btn btn-primary">Edit Profile</a>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>