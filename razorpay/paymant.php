<?php
session_start();
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['maintenance_id'])) {
    die(json_encode(["error" => "Invalid request."]));
}

$amount = floatval($_POST['amount']) * 100; // Convert to paise
$maintenance_id = $_POST['maintenance_id'];

$apiKey = 'rzp_test_nG6hRXPQ1pJ9wE';
$apiSecret = 'Na7RrAzPpZ8lOGxzwgiz7dNe';

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://api.razorpay.com/v1/orders");
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_USERPWD, "$apiKey:$apiSecret");
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([
    'amount' => $amount,
    'currency' => 'INR',
    'payment_capture' => 1
]));
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
curl_setopt($ch, CURLOPT_CAINFO, "C:\cacert\cacert.pem"); // Specify the path to the cacert.pem file

$response = curl_exec($ch);
if (curl_errno($ch)) {
    $error_msg = curl_error($ch);
    echo json_encode(["error" => "cURL error: " . $error_msg]);
} else {
    $orderData = json_decode($response, true);
    if (isset($orderData['id'])) {
        // Order created successfully
        $_SESSION['razorpay_order_id'] = $orderData['id'];
        $_SESSION['amount'] = $amount;
        $_SESSION['maintenance_id'] = $maintenance_id;
        header("Location: check_out.php");
        exit;
    } else {
        echo json_encode(["error" => "Error creating Razorpay order: " . json_encode($orderData)]);
    }
}
curl_close($ch);
?>