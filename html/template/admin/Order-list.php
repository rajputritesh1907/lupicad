<?php
// filepath: c:\xampp\htdocs\lupi-back\html\template\admin\Order-list.php

// Including the database connection file
require(__DIR__ . "/../backend/connection.inc.php");

session_start();

$stmt = $connection->prepare("SELECT * FROM orders WHERE status IN ('pending', 'paid') ORDER BY order_date ASC");
$stmt->execute();
$result = $stmt->get_result();
$ordersInfo = [];
while ($row = $result->fetch_assoc()) {
    $ordersInfo[] = $row;
}
$stmt->close();


$stmt = $connection->prepare("SELECT * FROM orderitems WHERE order_id = ?");
$stmt->bind_param("i", $orderId);
$stmt->execute();
$result = $stmt->get_result();
$orderItems = [];
while ($row = $result->fetch_assoc()) {
    $orderItems[] = $row;
}
$stmt->close();
 
echo "<script>console.log('Order Items: " . json_encode($orderItems) . "');</script>";

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupicad | Admin-Order List</title>

    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="../assets/lupicad/logo.svg">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">

    <!-- Fontawesome CSS -->
    <link rel="stylesheet" href="assets/plugins/fontawesome/css/fontawesome.min.css">
    <link rel="stylesheet" href="assets/plugins/fontawesome/css/all.min.css">

    <!-- Feathericon CSS -->
    <link rel="stylesheet" href="assets/css/feathericon.min.css">

    <!-- Datatables CSS -->
    <link rel="stylesheet" href="assets/plugins/datatables/datatables.min.css">

    <!-- Main CSS -->
    <link rel="stylesheet" href="assets/css/custom.css">

    
</head>

<body>

    <!-- Main Wrapper -->
    <div class="main-wrapper">

    <!-- Header -->
    <?php require(__DIR__ . "/components/header.inc.php"); ?>
    <!-- /Header -->

    <!-- Sidebar -->
    <?php require(__DIR__ . "/components/Sidebar.inc.php"); ?>
    <!-- /Sidebar --> 
        <!-- Page Wrapper -->
        <div class="page-wrapper">
            <div class="content container-fluid">

                <!-- Page Header -->
                <div class="page-header">
                    <div class="row">
                        <div class="col-sm-12">
                            <h3 class="page-title">List of Orders</h3>
                        </div>
                    </div>
                </div>
                <!-- /Page Header -->

                <div class="row">
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="datatable table table-hover table-center mb-0">
                                        <thead>
                                            <tr>
                                                <th>Order ID</th>
                                                <th>Order Date</th>
                                                <th>Payment Method</th>
                                                <th>Payment ID</th>
                                                <th>Status</th>
                                                <th>Total Amount</th>
                                                <th>Action</th>
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
                                                        <?php if (htmlspecialchars($order['status']) == 'Pending'): ?>
                                                            <td><span class="badge bg-warning text-dark"><?= htmlspecialchars($order['status']); ?></span></td>
                                                        <?php else: ?>
                                                            <td><span class="badge bg-success"><?= htmlspecialchars($order['status']); ?></span></td>
                                                        <?php endif; ?>
                                                        <td>₹<?= number_format($order['total_amount'], 2); ?></td>
                                                        <td>
                                                            <div class="actions">
                                                            <a class="btn btn-sm bg-danger-light" data-bs-toggle="modal" href="#view_modal" onclick="fetchOrderDetails('<?= $order['id'] ?>')">
                                                                    <i class="fe fe-eye"></i> View
                                                                </a>
                                                            </div>
                                                        </td>
                                                    </tr> 

                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <!-- /Page Wrapper -->

    </div>
    <div class="modal fade" id="view_modal" aria-hidden="true" role="dialog">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-body">
            <div class="form-content p-2">
              <h4 class="modal-title">Order Details</h4>
              
              <table class="table table-center mb-0">
				<thead>
					<tr>
						<th>Product</th>
						<th class="text-end">Quantity</th>
					</tr> 
				</thead>
				<tbody> 
				</tbody>
			  </table>
              <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                Close
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- /Delete Modal -->
  </div>
    <!-- /Main Wrapper -->

    
    <!-- jQuery -->
<script src="assets/js/jquery-3.7.1.min.js"></script>

<!-- Bootstrap Core JS -->
<script src="assets/js/bootstrap.bundle.min.js"></script>

<!-- Slimscroll JS -->
<script src="assets/plugins/slimscroll/jquery.slimscroll.min.js"></script>

<!-- Datatables JS -->
<script src="assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="assets/plugins/datatables/datatables.min.js"></script>

<!-- Custom JS -->
<script src="assets/js/script.js"></script>

<!-- ✅ Place your custom fetchOrderDetails() script AFTER all imports -->
<script>
    function fetchOrderDetails(orderId) {
        $.ajax({
            url: 'https://lupicad.com/lupi-back-main/html/template/backend/orderdetailsfatch.php',
            type: 'GET',
            data: { order_id: orderId },
            success: function(response) {
                const tbody = $('#view_modal table tbody');
                tbody.empty();
                
                if (response.error) {
                   tbody.append(`<tr><td colspan="2" class="text-center text-danger">${response.error}</td></tr>`);

                    return;
                }

                if (response.length === 0) {
                    tbody.append('<tr><td colspan="2" class="text-center">No items found for this order.</td></tr>');
                    return;
                }

                response.forEach(function(item) {
                    tbody.append(`
                        <tr>
                            <td>${item.product_name || 'Unknown Product'}</td>
                            <td class="text-end">${item.quantity}</td>
                        </tr>
                    `);
                });
            },
            error: function(xhr, status, error) {
                const tbody = $('#view_modal table tbody');
                tbody.empty();
                tbody.append(`<tr><td colspan="2" class="text-center text-danger">Error loading order details. Please try again.</td></tr>`);
                console.error('Error fetching order details:', error);
            }
        });
    }
</script>


</body>

</html>