<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: adminlogin.php');
    exit();
}

// Include database connection
include "../partials/db_connect.php";

// Query to get total members
$checkQuery = "SELECT * FROM member";
$result = pg_query($conn, $checkQuery);
$rows = pg_num_rows($result);

$complainQuery = "SELECT * FROM complain WHERE status='Pending'";
$cResult = pg_query($conn, $complainQuery);
$cRows = pg_num_rows($cResult);

$requestQuery = "SELECT * FROM requests WHERE status='Pending'";
$rResult = pg_query($conn, $requestQuery);
$rRows = pg_num_rows($rResult);

// Query to get upcoming events
$eventQuery = "SELECT event_name, event_date, event_time, location, description 
                FROM Events 
                WHERE event_date >= CURRENT_DATE 
                ORDER BY event_date, event_time";
$eventResult = pg_query($conn, $eventQuery);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .mt-3 {
            margin-top: 12px;
        }

        .event-card {
            margin-bottom: 20px;
        }

        .nav {
            margin-bottom: 50px;
        }
    </style>
</head>

<body>
    <div class="nav">
        <?php require '../partials/_nav.php'; ?>
    </div>

    <div class="mt-10">
        <div class="container-fluid">
            <!-- Main Content Area -->
            <div class="main-content">
                <h2 class="text-center">Admin Dashboard</h2>
                <div class="row">
                    <div class="col-md-6">
                        <div class="card text-white bg-primary mb-3">
                            <div class="card-header">Total Members</div>
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $rows; ?></h5>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card text-white bg-warning mb-3">
                            <div class="card-header">Pending Requests</div>
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $rRows+$cRows; ?></h5>
                            </div>
                        </div>
                    </div>
                </div>

                <h3 class="text-center">Quick Actions</h3>
                <div class="row">
                    <div class="col-md-6">
                        <a href="../member/add.php" class="btn btn-success btn-lg btn-block">Add Member</a>
                    </div>
                    <div class="col-md-6">
                        <a href="create_event.php" class="btn btn-info btn-lg btn-block">Create Event</a>
                    </div>
                </div>

                <!-- Upcoming Events Section -->
                <div class="container mt-5">

                    <h3 class="text-center mt-6">Upcoming Events</h3>
                    <div class="row">
                        <?php if ($eventResult && pg_num_rows($eventResult) > 0): ?>
                            <?php while ($event = pg_fetch_assoc($eventResult)): ?>
                                <div class="row-lg">
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
        </div>
    </div>
    

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>