<?php
include_once 'partials/db_connect.php';
$que="select * from events";
$result = pg_query($conn,$que);
$event=pg_fetch_assoc($result);

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
    <h1 class="text-center mb-4">Upcoming Events</h1>
    <div class="row" id="event-container">
    <?php
        // Loop through events and display them
        foreach ($event as $index => $event) {
            // Create a new row every 3 events
            if ($index % 3 === 0) {
                echo '<div class="row mb-4">';
            }

            // Create a card for each event
            echo '<div class="col-md-4">';
            echo '<div class="card">';
            echo '<div class="card-body">';
            echo '<h5 class="card-title">' . htmlspecialchars($event['title']) . '</h5>';
            echo '<p class="card-text"><strong>Date:</strong> ' . htmlspecialchars($event['event_date']) . '</p>';
            echo '<p class="card-text"><strong>Time:</strong> ' . htmlspecialchars($event['event_time']) . '</p>';
            echo '<p class="card-text"><strong>Location:</strong> ' . htmlspecialchars($event['location']) . '</p>';
            echo '<p class="card-text">' . htmlspecialchars($event['description']) . '</p>';
            echo '</div></div></div>';

            // Close the row after every 3 events
            if ($index % 3 === 2 || $index === count($events) - 1) {
                echo '</div>'; // Close the row
            }
        }
        ?>
        </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>