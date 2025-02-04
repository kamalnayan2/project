<?php
// session_start();

// // Check if the user is logged in
// if (!isset($_SESSION['user_id'])) {
//     header('Location: adminlogin.php'); 
//     exit();
// }
// dashboard.php
include 'db_connect.php';

// Fetch member data (example queries)
$member_id = 1; // Example member ID
$requests_query = "SELECT * FROM requests WHERE member_id = $member_id ORDER BY created_at DESC LIMIT 5";
$events_query = "SELECT * FROM events WHERE event_date >= CURRENT_DATE ORDER BY event_date ASC ";

$requests_result = pg_query($conn, $requests_query);
$events_result = pg_query($conn, $events_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Member Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .sidebar {
            height: 100vh;
            background-color: #f8f9fa;
        }
        .sidebar a {
            padding: 15px;
            text-decoration: none;
            color: #333;
        }
        .sidebar a:hover {
            background-color: #ddd;
        }
        .content {
            padding: 20px;
            flex-grow: 1;
        }
        welcome-message {
            opacity: 0;
            animation: fadeIn 2s forwards;
            margin-bottom: 20px;
        }

        @keyframes fadeIn{to {
                opacity: 1;
            }}
    </style>
</head>
<body>
        <?php require "_nav.php";?>
        
        <div class="content">
        <h2 class="text-center">Overview of Member Activities</h2>
            <h5 class="text-center">Recent Maintenance Requests</h5>
            <ul class="list-group">
                <?php while ($row = pg_fetch_assoc($requests_result)) { ?>
                    <li class="list-group-item"><?php echo $row['description']; ?> - <?php echo $row['created_at']; ?></li>
                <?php } ?>
            </ul>
        </div>

<div class="">
    <h5 class="mt-4 text-center">Upcoming Events</h5>
    <ul class="list-group">
        <?php while ($row = pg_fetch_assoc($events_result)) { ?>
            <li class="list-group-item"><?php echo $row['event_name']; ?> - <?php echo $row['event_date']; ?></li>
            <?php } ?>
        </ul>
    </div>

            <div class="mt-4 text-center">
                <h5>Quick Actions</h5>
                <a href="#" class="btn btn-primary">Submit Request</a>
                <a href="#" class="btn btn-success">Maintenance Pay</a>
            </div>
        </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>