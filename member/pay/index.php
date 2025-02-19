<?php
session_start();
if (!isset($_SESSION['member_id'])) {
    header('Location: ../login.php'); 
}

include_once 'db.php';

$m_id=$_SESSION['member_id'];
echo $m_id;
$result = pg_query($conn, "SELECT * FROM Maintenance WHERE status = 'Pending' and member_id=$m_id");
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

<body>
    <?php require '../_nav.php'; ?>
    <div class="container mt-5">
        <h1 class="text-center">Pay Maintenance Fee</h1>

        <form method="post" action="paymant.php">
            <div class="form-group">
                <label for="maintenance">Select Maintenance:</label>
                <select id="maintenance" name="maintenance_id" class="form-control" required>
                    <option value="">Select Maintenance</option>
                    <?php foreach ($maintenanceRecords as $record): ?>
                        <option value="<?= $record['maintenance_id'] ?>" data-price="<?= $record['amount'] ?>">
                            <?= htmlspecialchars($record['maintenance_name']) ?> - ₹<?= $record['amount'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <input type="hidden" id="amount" name="amount" value="">

            <button type="submit" class="btn btn-primary btn-block">Pay Now</button>
        </form>
    </div>

    <script>
        document.getElementById('maintenance').addEventListener('change', function () {
            let selectedOption = this.options[this.selectedIndex];
            document.getElementById('amount').value = selectedOption.getAttribute('data-price');
        });
    </script>
</body>

</html>