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

$result = pg_query($conn, "SELECT * FROM Maintenance WHERE status = 'Pending'");
$maintenanceRecords = pg_fetch_all($result) ?: [];

pg_close($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Maintenance Payment</title>
</head>
<style>
    body {
        background-color:  #BDCE6FFF;
    }
</style>

<body>
    <div class="container mt-5">
        <h1 class="text-center">Pay Maintenance Fee</h1>

        <form method="post" action="paymant.php">
            <div class="form-group">
                <label for="maintenance">Select Maintenance:</label>
                <select id="maintenance" name="maintenance_id" class="form-control" required>
                    <option value="">Select Maintenance</option>
                    <?php foreach ($maintenanceRecords as $record): ?>
                        <option value="<?= $record['maintenance_id'] ?>" data-price="<?= $record['amount'] ?>">
                            <?= htmlspecialchars($record['member_id']) ?> - ₹<?= $record['amount'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <input type="hidden" id="amount" name="amount" value="">

            <button type="submit" class="btn btn-primary btn-block">Pay Now</button>
        </form>
    </div>
    <div class="text-center">
            <a href="..//login/home.php" class="btn btn-primary">Back to Home</a>
        </div>

    <script>
        document.getElementById('maintenance').addEventListener('change', function () {
            let selectedOption = this.options[this.selectedIndex];
            document.getElementById('amount').value = selectedOption.getAttribute('data-price');
        });
    </script>
</body>

</html>