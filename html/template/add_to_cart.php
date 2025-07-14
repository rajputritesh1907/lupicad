<?php
// Include database connection
require(__DIR__ . "/backend/connection.inc.php");
require(__DIR__ . "/backend/function.inc.php");
 
session_start(); 
$user_id = $_SESSION['user_id']; // User's ID from the session
$product_id = isset($_GET['product_id']) ? $_GET['product_id'] : null;

if ($product_id) {
    // Check if the user's cart already contains products
    $query = "SELECT cartproducts FROM user WHERE id = ?";
    $stmt = mysqli_prepare($connection, $query);
    if (!$stmt) {
        die('SQL Error: ' . mysqli_error($connection));
    }

    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute(statement: $stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);

    if (!$row) {
        echo "Error: User not found.";
        exit();
    }

    // If user already has products in the cart, append the new product
    if ($row['cartProducts']) {
        $cartProducts = json_decode($row['cartProducts'], true);
        if ($cartProducts === null) {
            echo "Error: Cart data corrupted.";
            exit();
        }
        
        // Check if product is already in cart
        if (!in_array($product_id, $cartProducts)) {
            $cartProducts[] = $product_id; // Add the new product ID
            $updatedCart = json_encode($cartProducts);
            
            // Update the cart in the database
            $updateQuery = "UPDATE user SET cartproducts = ? WHERE id = ?";
            $updateStmt = mysqli_prepare($connection, $updateQuery);
            if (!$updateStmt) {
                die('SQL Error: ' . mysqli_error($connection));
            }
            mysqli_stmt_bind_param($updateStmt, "si", $updatedCart, $user_id);
            if (mysqli_stmt_execute($updateStmt)) {
                echo "<script>alert('Product added to cart successfully!');</script>";
            } else {
                echo "<script>alert('Error updating cart!');</script>";
            }
            mysqli_stmt_close($updateStmt);
        } else {
            echo "<script>alert('This product is already in your cart!');</script>";
        }
    } else {
        // If no products in the cart, create a new cart with this product
        $cartProducts = [$product_id];
        $updatedCart = json_encode($cartProducts);
        
        // Insert the product into the cart
        $updateQuery = "UPDATE user SET cartProducts = ? WHERE id = ?";
        $updateStmt = mysqli_prepare($connection, $updateQuery);
        if (!$updateStmt) {
            die('SQL Error: ' . mysqli_error($connection));
        }
        
        mysqli_stmt_bind_param($updateStmt, "si", $updatedCart, $user_id);
        if (mysqli_stmt_execute($updateStmt)) {
            echo "<script>alert('Product added to cart successfully!');</script>";
        } else {
            echo "<script>alert('Error updating cart!');</script>";
        }
        
        mysqli_stmt_close($updateStmt);
    }

    mysqli_stmt_close($stmt);
} else {
    echo "<script>alert('Invalid product ID!');</script>";
}

//fatching cartProducts form User table based on the user ID with try and catch block

try {
    $query = "SELECT cartProducts FROM user WHERE id =?";
    $stmt = $connection->prepare($query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if (!$row) {
        echo "Error: User not found.";
        exit();
    }

    $cartProducts = json_decode($row['cartProducts'], true);
    if ($cartProducts === null) {
        echo "Error: Cart data corrupted.";
        exit();
    }

    echo json_encode($cartProducts[0]);

} catch (Exception $e) {
    echo "Error: ". $e->getMessage();
}

mysqli_close($connection);

?>
