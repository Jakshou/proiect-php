<?php
session_start();
include('server/connection.php');
require 'paypal_config.php'; // Ensure this includes the autoloader for PayPal SDK

use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;

// Check if payment ID and Payer ID are set
if (isset($_GET['paymentId'], $_GET['PayerID'])) {
    $paymentId = $_GET['paymentId'];
    $payerId = $_GET['PayerID'];

    // Fetch the payment object from PayPal
    try {
        $payment = Payment::get($paymentId, $apiContext);

        // Execute payment (capture)
        $execution = new PaymentExecution();
        $execution->setPayerId($payerId);
        $payment->execute($execution, $apiContext);

        // Update order status in database (if applicable)
$order_id = $_SESSION['order_id'];
$query = "UPDATE orders SET order_status = 'platita' WHERE order_id = '$order_id'";
$result = mysqli_query($conn, $query);
if (!$result) {
    error_log("Failed to update order status: " . mysqli_error($conn));
}


        // Redirect to a page indicating successful payment
        header('Location: plata.php?order_status=platita');
        exit;
    } catch (Exception $e) {
        // Handle payment capture errors
        error_log("Payment execution failed: " . $e->getMessage());

        // Redirect to a page indicating payment failure
        header('Location: plata.php?order_status=error');
        exit;
    }
} else {
    // Redirect to index.php if payment ID or Payer ID is not set
    header('Location: index.php');
    exit;
}
?>
