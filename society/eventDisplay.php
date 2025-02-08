<?php
include_once 'partials/db_connect.php';
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
    <title>Dynamic Events Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .btn-custom {
            background-color: #ffcc00; /* Custom background color */
            color: #fff; /* Custom text color */
            border: none; /* Remove border */
        }
        .btn-custom:hover {
            background-color: #e6b800; /* Darker shade on hover */
        }
    </style>
</head>
<div class="container mt-5">
<h3 class="text-center mt-6">Upcoming Events</h3>
                <div class="row">
                    <?php if ($eventResult && pg_num_rows($eventResult) > 0): ?>
                        <?php while ($event = pg_fetch_assoc($eventResult)): ?>
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>