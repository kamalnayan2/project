<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php'); 
    exit();
}

include 'db_connect.php'; // Ensure this file connects to your database

// Fetch member data (example queries)
$member_id = $_SESSION['user_id']; // Example member ID

// Query to fetch recent maintenance requests
$requests_query = "SELECT * FROM requests WHERE member_id = $member_id ";
$requests_result = pg_query($conn, $requests_query);

// Check for errors in the query
if (!$requests_result) {
    die("Error in SQL query: " . pg_last_error());
}

// Query to fetch upcoming events
$events_query = "SELECT * FROM events WHERE event_date >= CURRENT_DATE ORDER BY event_date ASC";
$events_result = pg_query($conn, $events_query);

// Check for errors in the events query
if (!$events_result) {
    die("Error in SQL query: " . pg_last_error());
}
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
        .content {
            padding: 20px;
        }
    </style>
</head>
<body>
    <div>
        <?php require "_nav.php"; ?>
    </div>
    <h2 class="text-center" style="margin-top: 2em;">Overview of Member Activities</h2>

    <div class="mt-4 text-center">
        <h5>Quick Actions</h5>
        <a href="request.php" class="btn btn-primary">Submit Request</a>
        <a href="pay/index.php" class="btn btn-success">Maintenance Pay</a>
    </div>

    
    <div class="container" style=" align-items: center;">
        <h4 class="text-center">Recent Maintenance Requests</h4>
        <ul class="list-group text-center">
            <?php 
            if (pg_num_rows($requests_result) > 0) {
                while ($row = pg_fetch_assoc($requests_result)) { ?>
                    <li class="list-group-item" style="margin-top: 10px; width:75%;">
                        <?php echo htmlspecialchars($row['description']); ?> - <?php echo htmlspecialchars($row['created_at']); ?>
                    </li>
                <?php } 
            } else { ?>
                <li class="list-group-item">No recent maintenance requests found.</li>
            <?php } ?>
        </ul>
    </div>

    <div class="container mt-5">
<h3 class="text-center mt-6">Upcoming Events</h3>
                <div class="row">
                    <?php if ($events_result && pg_num_rows($events_result) > 0): ?>
                        <?php while ($event = pg_fetch_assoc($events_result)): ?>
                            <div class="row-lg" style="margin-top: 30px;">
                                <div class="card event-card">
                                    <div class="card-body">
                                        <h5 class="card-title"><?php echo htmlspecialchars($event['event_name']); ?></h5>
                                        <h6 class="card-subtitle mb-2 text-muted center">
                                            <?php echo date('F j, Y', strtotime($event['event_date'])) . ' at ' . date('g:i A', strtotime($event['event_time'])); ?>
                                        </h6>
                                        <p class="card-text"><?php echo htmlspecialchars($event['description']); ?></p>
                                        <p class="card-text"><small class="text-muted">Location: <?php echo htmlspecialchars($event['location']); ?></small></p>
                                    </div>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <div class="col-12">
                            <div class="alert alert-info text-center">No upcoming events found.</div>
                        </div>
                    <?php endif; ?>
                </div>
        </div>
</div>



    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>