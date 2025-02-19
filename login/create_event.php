<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Database connection parameters
    include '../login/database/connet_pg.php';

    // Get form data
    $eventName = $_POST['eventName'];
    $eventDate = $_POST['eventDate'];
    $eventTime = $_POST['eventTime'];
    $eventLocation = $_POST['eventLocation'];
    $eventDescription = $_POST['eventDescription'];
    $notes = $_POST['notes'];

    // Prepare and execute the insert statement
    $insertQuery = "INSERT INTO Events (event_name, event_date, event_time, location, description, notes) VALUES ($1, $2, $3, $4, $5, $6)";
    $insertResult = pg_query_params($conn, $insertQuery, array($eventName, $eventDate, $eventTime, $eventLocation, $eventDescription, $notes));

    if ($insertResult) {
        echo "<div class='alert alert-success mt-3'>Event created successfully!</div>";
    } else {
        echo "<div class='alert alert-danger mt-3'>Error creating event: " . pg_last_error() . "</div>";
    }

    // Close the database connection
    pg_close($conn);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Event</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .container {
            margin-top: 50px;
        }

        h2 {
            margin-bottom: 30px;
        }
        body{
            background-color: #BDCE6FFF;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2 class="text-center">Create Event</h2>
        <form action="create_event.php" method="POST">
            <div class="form-group">
                <label for="eventName">Event Name</label>
                <input type="text" class="form-control" id="eventName" name="eventName" required>
            </div>
            <div class="form-group">
                <label for="eventDate">Event Date</label>
                <input type="date" class="form-control" id="eventDate" name="eventDate" required>
            </div>
            <div class="form-group">
                <label for="eventTime">Event Time</label>
                <input type="time" class="form-control" id="eventTime" name="eventTime" required>
            </div>
            <div class="form-group">
                <label for="eventLocation">Location</label>
                <input type="text" class="form-control" id="eventLocation" name="eventLocation" required>
            </div>
            <div class="form-group">
                <label for="eventDescription">Description</label>
                <textarea class="form-control" id="eventDescription" name="eventDescription" rows="3" required></textarea>
            </div>
            <div class="form-group">
                <label for="notes">Additional Notes</label>
                <textarea class="form-control" id="notes" name="notes" rows="3"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Create Event</button>
        </form>
        <div class="text-center">
            <a href="home.php" class="btn btn-primary">Back to Home</a>
        </div>

    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>