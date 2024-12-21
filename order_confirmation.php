<?php
session_start();
require_once 'db.php';

// Prevent browser cache
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

// Check if order is placed
if (!isset($_SESSION['order_id'])) {
    header("Location: index.php");  // Redirect to homepage if no order
    exit;
}

// Get the order details
$order_id = $_SESSION['order_id'];
$stmt = $conn->prepare("SELECT * FROM orders WHERE id = ?");
$stmt->bind_param("i", $order_id);
$stmt->execute();
$result = $stmt->get_result();
$order = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="index.php">FOODZIE</a>
        </div>
    </nav>

    <div class="container mt-5">
        <h2 class="text-center">Order Confirmation</h2>
        <div class="alert alert-success">
            <h4>Thank you for your order!</h4>
            <p>Your order ID is <strong>#<?= $order['id'] ?></strong></p>
            <p>Total Amount: <strong>₱<?= number_format($order['total_price'], 2) ?></strong></p>
            <p>Your order will be processed and shipped to your address soon.</p>
        </div>
        <div class="text-center">
            <a href="index.php" class="btn btn-primary">Back to Home</a>
        </div>
    </div>
</body>
</html>
