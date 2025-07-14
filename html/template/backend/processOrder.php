<?php
require(__DIR__ . "/connection.inc.php");
session_start();

header('Content-Type: application/json'); // Ensure the response is JSON

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        if (!isset($_SESSION['user_id'])) {
            echo json_encode(['success' => false, 'message' => 'User not logged in.']);
            exit();
        }

        $userId = $_SESSION['user_id'];
        $data = json_decode(file_get_contents('php://input'), true);

        if (empty($data['first_name']) || empty($data['last_name']) || empty($data['email']) || empty($data['phone']) || empty($data['shipping_address']) || empty($data['payment_method']) || empty($data['cart_products'])) {
            echo json_encode(['success' => false, 'message' => 'Invalid request. Missing required fields.']);
            exit();
        }

        // Extract form data
        $firstName = $data['first_name'] ?? '';
        $lastName = $data['last_name'] ?? '';
        $email = $data['email'] ?? '';
        $phone = $data['phone'] ?? '';
        $shippingAddress = $data['shipping_address'] ?? '';
        $deliveryMessage = $data['delivery_message'] ?? ''; // Optional
        $paymentMethod = $data['payment_method'] ?? '';
        $totalAmount = $data['total_amount'] ?? 0;
        $subtotal = $data['subtotal'] ?? 0;
        $tax = $data['tax'] ?? 0;
        $cartProducts = $data['cart_products'] ?? [];

        // Validate required fields
        if (empty($firstName) || empty($lastName) || empty($email) || empty($phone) || empty($shippingAddress) || empty($paymentMethod) || empty($cartProducts)) {
            echo json_encode(['success' => false, 'message' => 'Invalid request. Missing required fields.']);
            exit();
        }

        date_default_timezone_set('Asia/Kolkata');
        $year = date('y'); // Last two digits of the year
        $month = date('m'); // Two-digit month
        $day = date('d'); // Two-digit day
        $hour = date('H'); // Two-digit hour
        $userIdPart = str_pad(substr($userId, -2), 2, '0', STR_PAD_LEFT); // Last two digits of user ID
        $productCount = str_pad(count($cartProducts), 2, '0', STR_PAD_LEFT); // Two-digit product count
        $uniqueNumber = str_pad(mt_rand(1, 9999), 4, '0', STR_PAD_LEFT); // Four-digit random number

        $orderId = "{$year}{$userIdPart}-{$month}{$day}-{$productCount}{$hour}-{$uniqueNumber}";
        // Insert order into Orders table
        $sql = "INSERT INTO orders (id,user_id, first_name, last_name, email, phone, shipping_address, delivery_message, payment_method, total_amount, subtotal, tax) 
            VALUES (?,?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $connection->prepare($sql);
        $stmt->bind_param("sisssssssdid",$orderId,$userId, $firstName, $lastName, $email, $phone, $shippingAddress, $deliveryMessage, $paymentMethod, $totalAmount, $subtotal, $tax);

        if ($stmt->execute()) {
            // Check if the order was successfully inserted
            if ($stmt->affected_rows === 0) {
                echo json_encode(['success' => false, 'message' => 'Failed to insert order into Orders table.']);
                exit();
            }
        
            // Insert order items into OrderItems table
            foreach ($cartProducts as $product) {
                $productId = $product['product_id'];
                $quantity = $product['quantity'];
        
                $sql = "INSERT INTO orderitems (order_id, product_id, quantity) VALUES (?, ?, ?)";
                $itemStmt = $connection->prepare($sql);
                $itemStmt->bind_param("sii", $orderId, $productId, $quantity);
        
                if (!$itemStmt->execute()) {
                    echo json_encode(['success' => false, 'message' => 'Failed to insert order item.', 'error' => $itemStmt->error]);
                    exit();
                }
            }
        
            echo json_encode(['success' => true, 'message' => 'Order placed successfully.', 'order_id' => $orderId]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to insert order.', 'error' => $stmt->error]);
            exit();
        }
    } catch (Exception $e) {
        // Log the error and return a JSON response
        error_log($e->getMessage());
        echo json_encode(['success' => false, 'message' => 'An unexpected error occurred.', 'error' => $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
