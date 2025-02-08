<?php
session_start();
if (!isset($_GET['order_id']) || !isset($_GET['payment_id'])) {
    die("Invalid request.");
}

$order_id = $_GET['order_id'];
$payment_id = $_GET['payment_id'];
$amount = $_SESSION['amount']; // Assuming you have stored the amount in the session
$maintenance_id = $_SESSION['maintenance_id']; // Assuming you have stored the maintenance ID in the session
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        .receipt {
            border: 1px solid #ccc;
            padding: 20px;
            border-radius: 5px;
            max-width: 600px;
        }
        h2 {
            text-align: center;
        }
        .details {
            margin: 10px 0;
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
    <div class="receipt">
        <h2>Payment Receipt</h2>
        <div class="text-center mb-3">
            <button class="btn btn-success" onclick="printReceipt()">Print Receipt</button>
        </div>
        <div class="receipt-details">
            <table border="3" align="center">
                <tr>
                    <th><strong>Order ID:</strong></th>
                    <td> <?= htmlspecialchars($order_id) ?> </td>
                </tr>
                <tr>
                    <th><strong>Payment ID:</strong></th>
                    <td><?= htmlspecialchars($payment_id) ?></td>
                </tr>
                <tr>
                    <th><strong>Maintenance ID:</strong></th>
                    <td> <?= htmlspecialchars($maintenance_id) ?></td>
                </tr>
                <tr>
                    <th><strong>Amount:</strong></th>
                    <td>₹<?= htmlspecialchars($amount/100) ?></td>
                </tr>
                <tr>
                    <th><strong>Status:</strong></th>
                    <td>Paid</td>
                </tr>
                <tr>
                    <th><strong>Date:</strong></th>
                    <td><?= date('Y-m-d H:i:s') ?></td>
                </tr>
            </table>
        </div>
        <p>Thank you for your payment!</p>
        <a href="index.php" class="btn btn-primary">Go back to Home</a>
    </div>
</body>
</html>