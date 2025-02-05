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


// Fetch user profile information for editing
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
    <title>Edit Profile</title>
    <style>
        body {
            background-color: #f8f9fa;
        }
        .edit-profile-container {
            margin-top: 50px;
            padding: 20px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>

<body>
    <div class="container edit-profile-container">
        <h1 class="text-center">Edit Profile</h1>
        <form method="post" action="update_profile.php">
            <div class="form-group">
                <label for="mname">Name</label>
                <input type="text" class="form-control" id="mname" name="mname" value="<?= htmlspecialchars($userProfile['name']) ?>" required>
            </div>
            <div class="form-group">
                <label for="phone">Phone</label>
                <input type="text" class="form-control" id="phone" name="phone" value="<?= htmlspecialchars($userProfile['mobileno']) ?>" required>
            </div>
            <div class="form-group">
                <label for="address">Address</label>
                <textarea class="form-control" id="address" name="address" required><?= htmlspecialchars($userProfile['flatno']) ?></textarea>
            </div>
            <input type="hidden" name="mid" value="<?= htmlspecialchars($userProfile['memberid']) ?>">
            <button type="submit" class="btn btn-primary btn-block">Update Profile</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>