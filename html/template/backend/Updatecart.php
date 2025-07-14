<?php
header('Content-Type: application/json');

// Validate input
if (!isset($_POST['product_id']) || !isset($_POST['quantity'])) {
    echo json_encode(['error' => 'Invalid product ID or quantity']);
    exit;
}

$product_id = intval($_POST['product_id']);
$quantity = floatval($_POST['quantity']);

// Validate product ID and quantity
if ($product_id <= 0 || $quantity <= 0) {
    echo json_encode(['error' => 'Invalid product ID or quantity']);
    exit;
}

// Database connection
require_once(__DIR__ . "/connection.inc.php");

// Update the cart
$sql = "UPDATE CartProducts SET quantity = ? WHERE product_id = ?";
$stmt = $connection->prepare($sql);
$stmt->bind_param("di", $quantity, $product_id);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Quantity updated successfully']);
} else {
    echo json_encode(['error' => 'Failed to update quantity']);
}
$stmt->close();
header("Location: cart.php");
exit;
$connection->close();
?>