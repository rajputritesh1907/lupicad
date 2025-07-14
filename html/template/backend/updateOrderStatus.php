<?php
header('Content-Type: application/json');
require(__DIR__ . "/connection.inc.php");

try {
    $data = json_decode(file_get_contents('php://input'), true);
    $orderId = $data['order_id'];
    $status = $data['status'];

    // Update the order status in the database
    $sql = "UPDATE Orders SET status = ? WHERE id = ?";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("ss", $status, $orderId);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Order status updated successfully.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to update order status.']);
    }

    $stmt->close();
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'An error occurred.', 'error' => $e->getMessage()]);
}
?>