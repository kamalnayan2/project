<?php
session_start();
$host = 'localhost';
$db = 'society';
$user = 'postgres';
$pass = 'kamal';

// Establish database connection
$conn = pg_connect("host=$host dbname=$db user=$user password=$pass");

if (!$conn) {
    die("Connection failed: " . pg_last_error());
}

// Get payment_id from the URL
$payment_id = $_GET['payment_id'] ?? null;

if ($payment_id) {
    // Fetch the specific transaction details
    $result = pg_query_params($conn, "SELECT t.order_id, t.payment_id, t.amount, t.status, m.maintenance_name, t.created_at 
                                       FROM transactions t 
                                       JOIN Maintenance m ON t.maintenance_id = m.maintenance_id 
                                       WHERE t.payment_id = $1", array($payment_id));
    $transaction = pg_fetch_assoc($result);
} else {
    die("Invalid payment ID.");
}

pg_close($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Receipt for Payment ID: <?= htmlspecialchars($transaction['payment_id']) ?></title>
    <style>
        body {
            background-color: #f8f9fa;
        }

        .container {
            margin-top: 50px;
        }

        h1 {
            margin-bottom: 30px;
        }

        .receipt-details table {
            width: 80%; /* Set the width of the table to 80% of the container */
            margin: 0 auto; /* Center the table */
        }

        th, td {
            padding: 15px; /* Add padding for better spacing */
            text-align: left; /* Align text to the left */
        }
    </style>
    <script>
        function printReceipt() {
            window.print();
        }
    </script>
</head>

<body>
    <div class="container">
        <h1 class="text-center">Receipt</h1>
        <div class="text-center mb-3">
            <button class="btn btn-success" onclick="printReceipt()">Print Receipt</button>
        </div>
        <div class="receipt-details">
            <table border="3" align="center">
                <tr>
                    <th><strong>Order ID:</strong></th>
                    <td><?= htmlspecialchars($transaction['order_id']) ?></td>
                </tr>
                <tr>
                    <th><strong>Payment ID:</strong></th>
                    <td><?= htmlspecialchars($transaction['payment_id']) ?></td>
                </tr>
                <tr>
                    <th><strong>Maintenance Name:</strong></th>
                    <td><?= htmlspecialchars($transaction['maintenance_name']) ?></td>
                </tr>
                <tr>
                    <th><strong>Amount:</strong></th>
                    <td>₹<?= htmlspecialchars(number_format($transaction['amount'], 2)) ?></td>
                </tr>
                <tr>
                    <th><strong>Status:</strong></th>
                    <td><?= htmlspecialchars($transaction['status']) ?></td>
                </tr>
                <tr>
                    <th><strong>Date:</strong></th>
                    <td><?= htmlspecialchars(date('Y-m-d H:i:s', strtotime($transaction['created_at']))) ?></td>
                </tr>
            </table>
        </div>
        <div class="text-center">
            <a href="history.php" class="btn btn-primary">Back to Payment History</a>
        </div>
    </div>
</body>

</html>