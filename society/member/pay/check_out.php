<?php
session_start();
if (!isset($_SESSION['razorpay_order_id'])) {
    die("Order ID not found.");
}

$order_id = $_SESSION['razorpay_order_id'];
$amount = $_SESSION['amount'];
$maintenance_id = $_SESSION['maintenance_id'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
</head>
<body>
    <script>
        var options = {
            "key": "rzp_test_5DRM9K9ZYvhm14", // Enter the Key ID generated from the Dashboard
            "amount": <?= $amount ?>, // Amount is in currency subunits. Default is in paise.
            "currency": "INR",
            "name": "VIJAY PRATAP",
            "description": "Maintenance Payment",
            "order_id": "<?= $order_id ?>", // Pass the `id` obtained in the previous step
            "handler": function (response) {
                // Handle the response here
                var xhr = new XMLHttpRequest();
                xhr.open("POST", "save_transaction.php", true);
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                
                // Prepare the data to be sent
                var data = "order_id=" + encodeURIComponent(response.razorpay_order_id) +
                           "&payment_id=" + encodeURIComponent(response.razorpay_payment_id) +
                           "&amount=" + encodeURIComponent(<?= $amount ?>) +
                           "&maintenance_id=" + encodeURIComponent(<?= $maintenance_id ?>);
                
                xhr.send(data);
                xhr.onload = function() {
                    alert(xhr.responseText);
                    window.location.href = "index.php"; // Redirect after processing
                };
            },
            "theme": {
                "color": "#F37254"
            }
        };

        var rzp1 = new Razorpay(options);
        rzp1.open();
    </script>
</body>
</html>