<?php
session_start();
include_once 'db.php';

// Get the member ID from the session
$member_id = $_SESSION['member_id']; // Assuming member_id is the member ID

// Fetch transaction history for the specific member ID
$result = pg_query($conn, "SELECT t.order_id, t.payment_id, t.amount, t.status, m.maintenance_name, t.created_at 
                            FROM transactions t 
                            JOIN Maintenance m ON t.maintenance_id = m.maintenance_id 
                            WHERE m.member_id = $member_id
                            ORDER BY t.created_at DESC");
$transactions = pg_fetch_all($result) ?: [];

pg_close($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Payment History</title>
    <style>
        .container {
            margin-top: 100px;
        }
        h1 {
            margin-bottom: 30px;
        }
        table {
            margin-top: 20px;
        }
    </style>
</head>

<body style="background-color: #BDCE6FFF;">
<div>
    <?php require '../_nav.php'; ?>
</div>    

    <div class="container">
        <h1 class="text-center">Payment History</h1>
        <div class="text-center mb-3">
            <button class="btn btn-success" onclick="window.print()">Print Receipts</button>
        </div>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Payment ID</th>
                    <th>Maintenance Name</th>
                    <th>Amount (₹)</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th>Receipt</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($transactions)): ?>
                    <tr>
                        <td colspan="7" class="text-center">No transactions found.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($transactions as $transaction): ?>
                        <tr>
                            <td><?= htmlspecialchars($transaction['order_id']) ?></td>
                            <td><?= htmlspecialchars($transaction['payment_id']) ?></td>
                            <td><?= htmlspecialchars($transaction['maintenance_name']) ?></td>
                            <td><?= htmlspecialchars(number_format($transaction['amount'], 2)) ?></td>
                            <td><?= htmlspecialchars($transaction['status']) ?></td>
                            <td><?= htmlspecialchars(date('Y-m-d H:i:s', strtotime($transaction['created_at']))) ?></td>
                            <td>
                                <a href="receipt.php?payment_id=<?= urlencode($transaction['payment_id']) ?>" class="btn btn-info">View Receipt</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>

</html>