<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generate Maintenance Bill</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h2>Generate Maintenance Bill</h2>
        <form action="generate_bill.php" method="POST">
            <div class="form-group">
                <label for="maintenanceName">Maintenance Name</label>
                <input type="text" class="form-control" id="maintenanceName" name="maintenanceName" required>
            </div>

            <h4>Select Members:</h4>
            <div id="memberList">
                <?php
                // Database connection parameters
                $host = "localhost";
                $dbname = "society";
                $user = "postgres";
                $password = "kamal";

                $conn = pg_connect("host=$host dbname=$dbname user=$user password=$password");
                if (!$conn) {
                    die("Error in connection: " . pg_last_error());
                }

                // Fetch members from the database
                $result = pg_query($conn, "SELECT memberid, area FROM member");
                if ($result) {
                    while ($row = pg_fetch_assoc($result)) {
                        echo '<div class="form-check">';
                        echo '<input class="form-check-input" type="checkbox" name="memberIds[]" value="' . htmlspecialchars($row['memberid']) . '" id="member_' . htmlspecialchars($row['memberid']) . '">';
                        echo '<label class="form-check-label" for="member_' . htmlspecialchars($row['memberid']) . '">';
                        echo 'Member ID: ' . htmlspecialchars($row['memberid']) . ' - Area: ' . htmlspecialchars($row['area']) . ' sq ft';
                        echo '</label>';
                        echo '</div>';
                    }
                } else {
                    echo "<div class='alert alert-danger'>Error fetching members: " . pg_last_error() . "</div>";
                }

                pg_close($conn);
                ?>
            </div>

            <button type="submit" class="btn btn-primary mt-3">Generate Bills</button>
        </form>

        <div id="result" class="mt-3">
            <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['memberIds'])) {
                // Database connection parameters
                $conn = pg_connect("host=$host dbname=$dbname user=$user password=$password");
                if (!$conn) {
                    die("Error in connection: " . pg_last_error());
                }

                // Get form data
                $maintenanceName = $_POST['maintenanceName'];
                $memberIds = $_POST['memberIds'];
                $results = [];

                foreach ($memberIds as $memberId) {
                    // Fetch area from member table
                    $selectQuery = "SELECT area FROM member WHERE memberid = $1";
                    $selectResult = pg_query_params($conn, $selectQuery, array($memberId));

                    if ($selectResult) {
                        $area = pg_fetch_result($selectResult, 0, 'area');
                        $amount = $area * 1; // 1 Rs per sq ft

                        // Prepare and execute the insert statement
                        $insertQuery = "INSERT INTO Maintenance (member_id, maintenance_name, amount) VALUES ($1, $2, $3) RETURNING maintenance_id";
                        $insertResult = pg_query_params($conn, $insertQuery, array($memberId, $maintenanceName, $amount));

                        if ($insertResult) {
                            $maintenanceId = pg_fetch_result($insertResult, 0, 'maintenance_id');
                            $results[] = "<div class='alert alert-success'>Bill generated successfully for Member ID: $memberId! Amount: Rs $amount. Maintenance ID: $maintenanceId</div>";
                        } else {
                            $results[] = "<div class='alert alert-danger'>Error generating bill for Member ID: $memberId: " . pg_last_error() . "</div>";
                        }
                    } else {
                        $results[] = "<div class='alert alert-danger'>Error fetching area for Member ID: $memberId: " . pg_last_error() . "</div>";
                    }
                }

                // Display results
                foreach ($results as $result) {
                    echo $result;
                }

                // Close the database connection
                pg_close($conn);
            }
            ?>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>