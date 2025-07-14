<?php
header('Content-Type: application/json');

require 'razorpay-php/Razorpay.php'; // Include Razorpay PHP SDK
use Razorpay\Api\Api;

try {
    $data = json_decode(file_get_contents('php://input'), true);
    $paymentId = $data['payment_id'];

    // Log the received payment ID
    error_log("Received Payment ID: " . $paymentId);

    // Initialize Razorpay API
    $api = new Api('rzp_live_iZZhD63jOXBQZP', 'G4FWoV57w320tVnb96a99'); // Replace with your Razorpay Key ID and Secret Key

    // Fetch payment details
    $payment = $api->payment->fetch($paymentId);

    // Log the payment details
    error_log("Payment Details: " . json_encode($payment));

    // Check if the payment is captured
    if ($payment->status === 'captured') {
        echo json_encode(['success' => true, 'message' => 'Payment verified successfully.']);
    } elseif ($payment->status === 'authorized') {
        // Capture the payment
        $payment->capture(['amount' => $payment->amount]); // Amount in the smallest currency unit (e.g., paise for INR)
        echo json_encode(['success' => true, 'message' => 'Payment authorized and successfully captured.']);
    } elseif ($payment->status === 'failed') {
        echo json_encode(['success' => false, 'message' => 'Payment failed.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Payment is in an unknown state.', 'status' => $payment->status]);
    }
} catch (Exception $e) {
    error_log("Exception: " . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'An error occurred.', 'error' => $e->getMessage()]);
}
?>