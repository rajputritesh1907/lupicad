<?php

use Razorpay\Api\Order;

require_once(__DIR__ . "/../backend/connection.inc.php");
require(__DIR__ . "/../backend/ProductTable.inc.php");

session_start(); // Make sure session is started

if (!isset($_SESSION['admin_id'])) {
    header("Location: adminlogin.php");
    exit();
}

$ProductTable = mysqli_query($connection, "SELECT * FROM producttable");

// Process the results
if ($ProductTable) {
    $products = [];
    while ($row = mysqli_fetch_assoc($ProductTable)) {
        $products[] = $row;
    }
    echo "<script>console.log(" . json_encode($products) . ");</script>";
} else {
    echo "<script>console.log('Error fetching ProductTable: " . mysqli_error($connection) . "');</script>";
}

// Handle form data on POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Main Product fields
    $Productname = $_POST['ProductName'];
    $ProductShortDescription = $_POST['ProductShortDescription'];
    $ProductCategories = $_POST['filter'];
    $ProductPrice = $_POST['ProductPrice'];
    $ProductAvailability = true;
    $ProductRating = 4.5;
    $ProductImage = $_FILES['ProductImage'];

    // ProductDetailsTable fields
    $ProductSubTitle = $_POST['SubTitle'];
    $ProductQuantity = $_POST['Quantity'];
    $ProductSKU = $_POST['SKU'];
    $ProductPackSize = $_POST['PackSize'];
    $ProductUnitCount = $_POST['UnitCount'];
    $ProductCountry = $_POST['Country'];
    $ProductDiscount = $_POST['Discount'];
    $ProductDescription = $_POST['ProductDescription'];
    $ProductDirections = $_POST['Directions'];
    $ProductStorage = $_POST['Storage'];
    $ProductAdministration = $_POST['Administration'];
    $ProductWarning = $_POST['Warning'];
    $ProductPrecaution = $_POST['Precaution'];
    echo "<script>console.log(" . json_encode($_POST) . ");</script>";
}


//Retrieve all users from the user table
$userQuery = "SELECT id AS user_id, name, phone, created_at,profile_image FROM user";
$userResult = $connection->query($userQuery);

$users = [];
while ($row = $userResult->fetch_assoc()) {
    $users[] = $row; // Use user_id as the key for easy matching
}
echo "<script>console.log(" . json_encode($users) . ");</script>";

//Retrieve the total amount spent by each user from the orders table:
$orderQuery = "SELECT user_id, COALESCE(SUM(total_amount), 0) AS total_amount FROM orders GROUP BY user_id";
$orderResult = $connection->query($orderQuery);

$UserTotalPurchase = [];
while ($row = $orderResult->fetch_assoc()) {
    $UserTotalPurchase[] = $row; // Use user_id as the key for easy matching
}
echo "<script>console.log(" . json_encode($UserTotalPurchase) . ");</script>";

// Handle form data on POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Main Product fields
    $username = $_POST['name'];
    $userPhone = $_POST['phone'];
    $ProductPrice = $_POST['created_at'];
    echo "<script>console.log(" . json_encode($_POST) . ");</script>";
}
// Get total number of products
$productSql = "SELECT COUNT(*) as total FROM producttable";
$productResult = $connection->query($productSql);
$productRow = $productResult->fetch_assoc();
$totalProducts = $productRow['total'];

// Get total number of users
$userSql = "SELECT COUNT(*) as total FROM user";
$userResult = $connection->query($userSql);
$userRow = $userResult->fetch_assoc();
$totalUsers = $userRow['total'];

//Get total number of Orders which status is pending or paid
$orderSql = "SELECT COUNT(*) as total FROM orders WHERE status IN ('pending', 'paid')";
$orderResult = $connection->query($orderSql);
$orderRow = $orderResult->fetch_assoc();
$totalOrders = $orderRow['total'];
// Get total Amount of all orders which status is pending or paid
$orderSql = "SELECT SUM(total_amount) as total FROM orders WHERE status IN ('pending', 'paid')";
$orderResult = $connection->query($orderSql);
$orderRow = $orderResult->fetch_assoc();
$totalAmount = $orderRow['total'];


// --------------------------------- Order Details ------------------------------------------//

$stmt = $connection->prepare("SELECT * FROM orders WHERE status IN ('pending', 'paid') ORDER BY order_date DESC");
$stmt->execute();
$result = $stmt->get_result();
$ordersInfo = [];
while ($row = $result->fetch_assoc()) {
    $ordersInfo[] = $row;
}
if (empty($ordersInfo)) {
    // echo "<script>console.log('error');</script>";
} else {
    // echo "<script>console.log(" . json_encode($ordersInfo) . ");</script>";
}
$stmt->close();
// ---------------------------------/Order Details ------------------------------------------//

//fatch user wise orders total Amount
$stmt = $connection->prepare("SELECT user_id, SUM(total_amount) as total_amount FROM orders GROUP BY user_id");
$stmt->execute();
$result = $stmt->get_result();
$userOrders = [];
while ($row = $result->fetch_assoc()) {
    $userOrders[] = $row;
}


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupicad | Admin- Dashboard</title>

    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="../assets/lupicad/logo.svg">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">

    <!-- Fontawesome CSS -->
    <link rel="stylesheet" href="assets/plugins/fontawesome/css/fontawesome.min.css">
    <link rel="stylesheet" href="assets/plugins/fontawesome/css/all.min.css">

    <!-- Feathericon CSS -->
    <link rel="stylesheet" href="assets/css/feathericon.min.css">

    <link rel="stylesheet" href="assets/plugins/morris/morris.css">

    <!-- Main CSS -->
    <link rel="stylesheet" href="assets/css/custom.css">

</head>

<body>
     <div class="main-wrapper">
         <?php require(__DIR__ . "/components/header.inc.php") ?>
    <!-- hearder -->


    <!-- /Sidebar -->
    <?php require(__DIR__ . "/components/Sidebar.inc.php") ?>
    <!-- /Sidebar -->
    <div class="page-wrapper">

        <div class="content container-fluid">

            <!-- Page Header -->
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-12">
                        <h3 class="page-title">Welcome Admin!</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- /Page Header -->

            <div class="row">
                <div class="col-xl-3 col-sm-6 col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="dash-widget-header">
                                <span class="dash-widget-icon text-primary border-primary">
                                    <i class="fe fe-users"></i>
                                </span>
                                <div class="dash-count">
                                    <h3><?= $totalUsers ?? 0 ?></h3>
                                </div>
                            </div>
                            <div class="dash-widget-info">
                                <h6 class="text-muted">User</h6>
                                <div class="progress progress-sm">
                                    <div class="progress-bar bg-primary w-50"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6 col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="dash-widget-header">
                                <span class="dash-widget-icon text-success">
                                    <i class="fe fe-credit-card"></i>
                                </span>
                                <div class="dash-count">
                                    <h3><?= $totalProducts ?? 0 ?></h3>
                                </div>
                            </div>
                            <div class="dash-widget-info">

                                <h6 class="text-muted">Number of Product</h6>
                                <div class="progress progress-sm">
                                    <div class="progress-bar bg-success w-50"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6 col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="dash-widget-header">
                                <span class="dash-widget-icon text-danger border-danger">
                                    <i class="fe fe-cart"></i>
                                </span>
                                <div class="dash-count">
                                    <h3><?= $totalOrders ?? 0 ?></h3>
                                </div>
                            </div>
                            <div class="dash-widget-info">

                                <h6 class="text-muted">Orders</h6>
                                <div class="progress progress-sm">
                                    <div class="progress-bar bg-danger w-50"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6 col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="dash-widget-header">
                                <span class="dash-widget-icon text-warning border-warning">
                                    <i class="fe fe-money"></i>
                                </span>
                                <div class="dash-count">
                                    <h3>₹<?= $totalAmount ??'0.00' ?></h3>
                                </div>
                            </div>
                            <div class="dash-widget-info">

                                <h6 class="text-muted">Revenue</h6>
                                <div class="progress progress-sm">
                                    <div class="progress-bar bg-warning w-50"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 d-flex">

                    
                    <!-- Product List -->
                    <div class="card card-table flex-fill">
                        <div class="card-header">
                            <h4 class="card-title">Product List</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive" style="max-height: 350px; overflow-y: auto;">
                                <table class="table table-hover table-center mb-0">
                                    <thead>
                                        <tr>
                                            <th>Product Name</th>
                                            <th>Speciality</th>
                                            <th>Earned</th>
                                            <th>Reviews</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($products as $product) {
                                            $productImages = json_decode($product['ProductImage'], true);
                                            $mainImage = (is_array($productImages) && count($productImages) > 0) ? $productImages[0] : 'default-image.jpg';
                                        ?>
                                            <tr>
                                                <td>
                                                    <h2 class="table-avatar">
                                                        <a href="#" class="avatar avatar-sm me-2">
                                                            <img class="avatar-img rounded-circle"
                                                                src="../uploads/<?php echo htmlspecialchars($mainImage); ?>"
                                                                alt="Product Image">
                                                        </a>
                                                        <a href="#"><?php echo htmlspecialchars($product['ProductName']); ?></a>
                                                    </h2>
                                                </td>
                                                <td><?php echo htmlspecialchars($product['ProductCategories']); ?></td>
                                                <td>₹<?php echo number_format($product['ProductPrice'], 2); ?></td>
                                                <td>
                                                    <?php
                                                    $stars = floor($product['ProductRating']);
                                                    for ($i = 0; $i < 5; $i++) {
                                                        if ($i < $stars) {
                                                            echo '<i class="fe fe-star text-warning"></i>';
                                                        } else {
                                                            echo '<i class="fe fe-star-o text-secondary"></i>';
                                                        }
                                                    }
                                                    ?>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- /Product List -->

                </div>
                <div class="col-md-6 d-flex">

                    <!-- Users List -->
                    <div class="card  card-table flex-fill">
                        <div class="card-header">
                            <h4 class="card-title">Users List</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive"  style="max-height: 350px; overflow-y: auto;">
                                <table class="table table-hover table-center mb-0">
                                    <thead>
                                        <tr>
                                            <th>User Name</th>
                                            <th>Phone</th>
                                            <th>Last Visit</th>
                                            <th>Total Purchases</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (empty($users)): ?>
                                            <tr>
                                                <td colspan="4" class="text-center">No users found.</td>
                                            </tr>
                                        <?php else: ?>
                                            <?php for ($j = 0; $j < count($users); $j++): ?>
                                                <tr>
                                                    <td>
                                                    <h2 class="table-avatar">
                                                        <?php if(isset($users[$j]['profile_image']) && empty($users[$j]['profile_image']) ){ ?>
                                                            <div class="rounded-circle" style="background-color:rgba(27, 89, 144, 0.85);margin-right:5px ;font-size:x-large;color:white;width:40px;height:40;display:flex;justify-content:center;align-items:center"><?= isset($users[$j]['name']) ? strtoupper(substr(htmlspecialchars($users[$j]['name']), 0, 1)) : "U"; ?></div>
                                                        <?php } else { ?>
                                                        <a href="#" class="avatar avatar-sm me-2">
                                                            <img class="avatar-img rounded-circle"
                                                                src="../<?= $users[$j]['profile_image']; ?>" alt="User Image">
                                                        </a>
                                                        <?php } ?>  
                                                        <a
                                                            href="#"><?= htmlspecialchars($users[$j]['name'] ?? 'N/A'); ?>
                                                        </a>
                                                    </h2>
                                                        
                                                    </td>
                                                    <td><?= htmlspecialchars($users[$j]['phone'] ?? 'N/A'); ?></td>
                                                    <td><?= isset($users[$j]['created_at']) ? date('d M Y', strtotime($users[$j]['created_at'])) : 'N/A'; ?><span class="text-primary d-block">
                                                            <?= date('h:i A', strtotime($users[$j]['created_at'])); ?>
                                                        </span></td>
                                                    <?php
                                                    $found = false; // Flag to check if a match is found
                                                    for ($i = 0; $i < count($UserTotalPurchase); $i++):
                                                        if ($users[$j]['user_id'] == $UserTotalPurchase[$i]['user_id']):
                                                            $found = true;
                                                    ?>
                                                            <td>₹<?= number_format($UserTotalPurchase[$i]['total_amount'], 2); ?></td>
                                                    <?php
                                                            break; // Exit the loop once a match is found
                                                        endif;
                                                    endfor;
                                                    if (!$found): // If no match is found, display ₹0.00
                                                    ?>
                                                        <td>₹0.00</td>
                                                    <?php endif; ?>
                                                </tr>
                                            <?php endfor; ?>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- /Users List -->

                </div>
            </div>
            <div class="row">
                <div class="col-md-12">

                    <!-- Order List -->
                    <div class="card card-table">
                        <div class="card-header">
                            <h4 class="card-title">Order List</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive"  style="max-height: 350px; overflow-y: auto;">
                                <table class="table table-hover table-center mb-0">
                                    <thead>
                                        <tr>
                                            <th>Order ID</th>
                                            <th>Date</th>
                                            <th><center>Payment Method</center></th>
                                            <th><center>Payment ID</center></th>
                                            <th>Status</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (empty($ordersInfo)): ?>
                                            <tr>
                                                <td colspan="6" class="text-center">No orders found.</td>
                                            </tr>
                                        <?php else: ?>
                                            <?php foreach ($ordersInfo as $order): ?>
                                                <tr>
                                                    <td><?= htmlspecialchars($order['id']); ?></td>
                                                    <td>
                                                        <?= date('d M Y', strtotime($order['order_date'])); ?>
                                                        <span class="text-primary d-block">
                                                            <?= date('h:i A', strtotime($order['order_date'])); ?>
                                                        </span>
                                                    </td>
                                                    <td><center><?= htmlspecialchars($order['payment_method']); ?></center></td>
                                                    <td><center><?= !empty($order['paymentId']) ? htmlspecialchars($order['paymentId']) : 'N/A'; ?></center></td>
                                                    <?php if(htmlspecialchars($order['status']) == 'Pending') :?>
                                                    <td><span class="badge bg-success" style="background-color:darkorange !important;"><?= htmlspecialchars($order['status']); ?></span></td>
                                                    <?php else: ?>
                                                    <td><span class="badge bg-success" ><?= htmlspecialchars($order['status']); ?></span></td>
                                                    <?php endif; ?>
                                                    <td>₹<?= number_format($order['total_amount'], 2); ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- /Order List -->

                </div>
            </div>

        </div>
    </div>

     </div>
    <!-- hearder -->
    
    <script src="assets/js/jquery-3.7.1.min.js" type="db336879ea1e282ee367dea6-text/javascript"></script>

    <!-- Bootstrap Core JS -->
    <script src="assets/js/bootstrap.bundle.min.js" type="db336879ea1e282ee367dea6-text/javascript"></script>

    <!-- Slimscroll JS -->
    <script src="assets/plugins/slimscroll/jquery.slimscroll.min.js"
        type="db336879ea1e282ee367dea6-text/javascript"></script>

    <script src="assets/plugins/raphael/raphael.min.js" type="db336879ea1e282ee367dea6-text/javascript"></script>
    <script src="assets/plugins/morris/morris.min.js" type="db336879ea1e282ee367dea6-text/javascript"></script>
    <script src="assets/js/chart.morris.js" type="db336879ea1e282ee367dea6-text/javascript"></script>

    <!-- Custom JS -->
    <script src="assets/js/script.js" type="db336879ea1e282ee367dea6-text/javascript"></script>

    <script src="../../../cdn-cgi/scripts/7d0fa10a/cloudflare-static/rocket-loader.min.js"
        data-cf-settings="db336879ea1e282ee367dea6-|49" defer></script>
    <script defer
        src="https://static.cloudflareinsights.com/beacon.min.js/vcd15cbe7772f49c399c6a5babf22c1241717689176015"
        integrity="sha512-ZpsOmlRQV6y907TI0dKBHq9Md29nnaEIPlkf84rnaERnq6zvWvPUqr2ft8M1aS28oN72PdrCzSjY4U6VaAw1EQ=="
        data-cf-beacon='{"rayId":"926c480de82191a3","version":"2025.1.0","serverTiming":{"name":{"cfExtPri":true,"cfL4":true,"cfSpeedBrain":true,"cfCacheStatus":true}},"token":"3ca157e612a14eccbb30cf6db6691c29","b":1}'
        crossorigin="anonymous"></script>
</body>

</html>