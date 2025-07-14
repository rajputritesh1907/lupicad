<?php
// Start output buffering
ob_start();

// Including the database connection file
require(__DIR__ . "/../backend/connection.inc.php");

// Clear any previous output
ob_clean();

// Set headers for JSON response
header('Content-Type: application/json');

if (!isset($_GET['order_id'])) {
    echo json_encode(['error' => 'Order ID is required']);
    exit;
}

$orderId = $_GET['order_id'];

// Prepare the SQL statement to get order items with product names
$stmt = $connection->prepare("
    SELECT * FROM orderitems WHERE order_id = ?
");

$stmt->bind_param("s", $orderId);
$stmt->execute();
$result = $stmt->get_result();

$orderItems = [];
while ($row = $result->fetch_assoc()) {
    $orderItems[] = $row;    
}

$stmt->close();

//fatch product name according to product id using loop and insert in orderitems table
foreach ($orderItems as &$item) {
    $productId = $item['product_id'];
    $stmt = $connection->prepare("SELECT ProductName FROM producttable WHERE ProductId = ?");
    $stmt->bind_param("i", $productId);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $item['product_name'] = $row ? $row['ProductName'] : 'Unknown Product';
    $stmt->close();
}
unset($item); // break the reference

// Ensure no other output has been sent
while (ob_get_level()) {
    ob_end_clean();
}

// Send JSON response
header('Content-Type: application/json');
echo json_encode($orderItems);