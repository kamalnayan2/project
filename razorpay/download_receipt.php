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
            padding: 20px;
            border: 1px solid #dee2e6;
            border-radius: 5px;
            background-color: #ffffff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            margin-bottom: 30px;
            color: #343a40;
        }

        .receipt-details {
            margin: 20px 0; /* Add margin for spacing */
        }

        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 0.9em;
            color: #6c757d;
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
            <table class="table table-bordered">
                <thead class="thead-light">
                    <tr>
                        <th scope="col">Description</th>
                        <th scope="col">Details</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><strong>Order ID:</strong></td>
                        <td><?= htmlspecialchars($transaction['order_id']) ?></td>
                    </tr>
                    <tr>
                        <td><strong>Payment ID:</strong></td>
                        <td><?= htmlspecialchars($transaction['payment_id']) ?></td>
                    </tr>
                    <tr>
                        <td><strong>Maintenance Name:</strong></td>
                        <td><?= htmlspecialchars($transaction['maintenance_name']) ?></td>
                    </tr>
                    <tr>
                        <td><strong>Amount:</strong></td>
                        <td>₹<?= htmlspecialchars(number_format($transaction['amount'], 2)) ?></td>
                    </tr>
                    <tr>
                        <td><strong>Status:</strong></td>
                        <td><?= htmlspecialchars($transaction['status']) ?></td>
                    </tr>
                    <tr>
                        <td><strong>Date:</strong></td>
                        <td><?= htmlspecialchars(date('Y-m-d H:i:s', strtotime($transaction['created_at']))) ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="text-center">
            <a href="history.php" class="btn btn-primary">Back to Payment History</a>
        </div>
        <div class="footer">
            <p>Thank you for your payment!</p>
            <p>&copy; <?= date('Y') ?> Society Management</p>
        </div>
    </div>
</body>

</html>