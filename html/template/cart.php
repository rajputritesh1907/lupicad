<?php
require_once(__DIR__ . "/backend/connection.inc.php");
// session start() is already called in connection.inc.php
session_start();

if (!isset($_SESSION['user_id'])) {
	header("Location: login.php");
	exit;
}
//extreacting the product id ,Quentity and userid from the $_Get
if (isset($_GET['Quentity'])) {
	$quentity = $_GET['Quentity'];
}
if (isset($_GET['product_id'])) {
	$productId = $_GET['product_id'];
}
$userId = $_SESSION['user_id'];

//create a cart table if not exists
$sql = "CREATE TABLE IF NOT EXISTS CartProducts (
	id INT(11) AUTO_INCREMENT PRIMARY KEY,
	user_id INT(11) NOT NULL,
	product_id INT(11) NOT NULL,
	quantity INT(11) NOT NULL
)";
if ($connection->query($sql) === TRUE) {
	echo "<script>console.log('Table CartProducts created successfully');</script>";
} else {
	echo "<script>console.log('Error creating table: " . $connection->error . "');</script>";
}
//check if the product is not null and the quentity is not null
if (isset($productId) && isset($quentity)) {
	//check if the product is already in the cart
	$sql = "SELECT * FROM CartProducts WHERE user_id = '$userId' AND product_id = '$productId'";
	$result = $connection->query($sql);
	if ($result->num_rows > 0) {
		//update the quentity of the product in the cart
		$sql = "UPDATE CartProducts SET quantity = '$quentity' WHERE user_id = '$userId' AND product_id = '$productId'";
		if ($connection->query($sql) === TRUE) {
			echo "<script>console.log('Product updated successfully');</script>";
		} else {
			echo "<script>console.log('Error updating product: " . $connection->error . "');</script>";
		}
	} else {
		//insert the product in the cart
		$sql = "INSERT INTO CartProducts (user_id, product_id, quantity) VALUES ('$userId', '$productId', '$quentity')";
		if ($connection->query($sql) === TRUE) {
			echo "<script>console.log('Product added successfully');</script>";
		} else {
			echo "<script>console.log('Error adding product: " . $connection->error . "');</script>";
		}
	}
	header("Location: cart.php");
	exit;
}

//check if the deleteId is set in the url
if (isset($_GET['deleteId'])) {
	$deleteId = $_GET['deleteId'];
	//delete the product from the cart
	$sql = "DELETE FROM CartProducts WHERE user_id = '$userId' AND product_id = '$deleteId'";
	if ($connection->query($sql) === TRUE) {
		echo "<script>console.log('Product deleted successfully');</script>";
	} else {
		echo "<script>console.log('Error deleting product: " . $connection->error . "');</script>";
	}
	header("Location: cart.php");
	exit;
}
//fetching the cart products from the database and add product id value in the array
$sql = "SELECT * FROM CartProducts WHERE user_id = '$userId' ORDER BY product_id DESC";
$result = $connection->query($sql);
$cartProducts = array();
$cartProductsId['product_id'] = array();
$cartProductsId['quantity'] = array();
if ($result->num_rows > 0) {
	while ($row = $result->fetch_assoc()) {
		$cartProducts[] = $row;
		//add product id value in the array
		$cartProductsId['product_id'][] = $row['product_id'];
		$cartProductsId['quantity'][] = $row['quantity'];
	}
} else {
	echo "<script>console.log('No products found in the cart');</script>";
}
echo "<script>console.log('Cart products: " . json_encode($cartProducts) . "');</script>";
echo "<script>console.log('Cart products: " . json_encode($cartProductsId['product_id']) . "');</script>";
echo "<script>console.log('Cart products: " . json_encode($cartProductsId['quantity']) . "');</script>";
//fetching the product details from the database using the product id array

$products = array();
$productDetails = array();

if (!empty($cartProductsId['product_id'])) {
	$sql = "SELECT * FROM producttable WHERE ProductID IN (" . implode(',', $cartProductsId['product_id']) . ") ORDER BY ProductID DESC";
	$result = $connection->query($sql);
	if ($result->num_rows > 0) {
		while ($row = $result->fetch_assoc()) {
			$products[] = $row;
		}
	} else {
		echo "<script>console.log('No products found');</script>";
	}
	// echo "<script>console.log('Products: " . json_encode($products) . "');</script>";

	//fetching the product details from the database using the product id array
	$sql = "SELECT * FROM productdetailstable WHERE ProductID IN (" . implode(',', $cartProductsId['product_id']) . ") ORDER BY ProductID DESC";
	$result = $connection->query($sql);
	if ($result->num_rows > 0) {
		while ($row = $result->fetch_assoc()) {
			$productDetails[] = $row;
		}
	} else {
		echo "<script>console.log('No products found');</script>";
	}
	// echo "<script>console.log('Products: " . json_encode($productDetails) . "');</script>";
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Lupicad | Cart</title>

	<!-- Favicon -->
	<link rel="shortcut icon" href="assets/lupicad/logo.svg" type="image/x-icon">
	<!-- Apple Touch Icon -->
	<link rel="apple-touch-icon" sizes="180x180" href="assets/img/apple-touch-icon.png">

	<!-- Theme Settings Js -->
	<script src="assets/js/theme-script.js" type="text/javascript"></script>

	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="assets/css/bootstrap.min.css">

	<!-- Fontawesome CSS -->
	<link rel="stylesheet" href="assets/plugins/fontawesome/css/fontawesome.min.css">
	<link rel="stylesheet" href="assets/plugins/fontawesome/css/all.min.css">

	<!-- Iconsax CSS-->
	<link rel="stylesheet" href="assets/css/iconsax.css">

	<!-- Feathericon CSS -->
	<link rel="stylesheet" href="assets/css/feather.css">

	<!-- Fancybox CSS -->
	<link rel="stylesheet" href="assets/plugins/fancybox/jquery.fancybox.min.css">

	<!-- Main CSS -->
	<link rel="stylesheet" href="assets/css/custom.css">
	<script>
		document.addEventListener('DOMContentLoaded', function() {
			// Select all quantity input fields and buttons
			const quantityInputs = document.querySelectorAll('.input-number');
			const incrementButtons = document.querySelectorAll('.quantity-right-plus');
			const decrementButtons = document.querySelectorAll('.quantity-left-minus');

			// Add event listeners to increment buttons
			incrementButtons.forEach((button) => {
				button.addEventListener('click', function() {
					const productId = button.getAttribute('data-product-id');
					const quantityInput = document.getElementById(`quantity-${productId}`);
					let currentValue = parseInt(quantityInput.value); // Parse as integer
					if (!isNaN(currentValue) && currentValue < 25) { // Ensure it doesn't exceed 25
						let newValue = currentValue + 1; // Increment by 1
						quantityInput.value = newValue; // Update the input value
						updateQuantity(productId, newValue); // Update in the database
						//reload after 1 second
						setTimeout(function() {
							location.reload();
						}, 500);
					} else {
						alert('Maximum quantity is 25.');
					}
				});
			});

			// Add event listeners to decrement buttons
			decrementButtons.forEach((button) => {
				button.addEventListener('click', function() {
					const productId = button.getAttribute('data-product-id');
					const quantityInput = document.getElementById(`quantity-${productId}`);
					let currentValue = parseInt(quantityInput.value); // Parse as integer
					if (!isNaN(currentValue) && currentValue > 1) { // Ensure it doesn't go below 1
						let newValue = currentValue - 1; // Decrement by 1
						quantityInput.value = newValue; // Update the input value
						updateQuantity(productId, newValue); // Update in the database
						//reload after 1 second
						setTimeout(function() {
							location.reload();
						}, 500);
					} else {
						alert('Minimum quantity is 1.');
					}
				});
			});

			// Function to send AJAX request to update quantity in the database
			function updateQuantity(productId, quantity) {
				const xhr = new XMLHttpRequest();
				xhr.open('POST', './backend/Updatecart.php', true);
				xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
				xhr.onload = function() {
					if (xhr.status === 200) {
						try {
							const response = JSON.parse(xhr.responseText);
							if (response.success) {
								console.log('Quantity updated successfully!');
							} else {
								console.error('Error:', response.error);
							}
						} catch (e) {
							console.error('Invalid JSON response:', xhr.responseText);
						}
					} else {
						console.error('Failed to update quantity. Please try again.');
					}
				};
				xhr.send(`product_id=${productId}&quantity=${quantity}`);
			}
		});
	</script>


</head>

<body>
	<!-- Main Wrapper -->
	<div class="main-wrapper">

		<!-- Header -->
		<?php require_once(__DIR__ . "/components/header.php") ?>
		<!-- /Header -->

		<!-- Breadcrumb -->
		<div class="breadcrumb-bar">
			<div class="container">
				<div class="row align-items-center inner-banner">
					<div class="col-md-12 col-12 text-center">
						<nav aria-label="breadcrumb" class="page-breadcrumb">
							<ol class="breadcrumb">
								<li class="breadcrumb-item"><a href="index.php"><i class="isax isax-home-15"></i></a>
								</li>
								<li class="breadcrumb-item" aria-current="page">Product</li>
								<li class="breadcrumb-item active">Cart</li>
							</ol>
							<h2 class="breadcrumb-title">Cart</h2>
						</nav>
					</div>
				</div>
			</div>
			<div class="breadcrumb-bg">
				<img src="assets/img/bg/breadcrumb-bg-01.png" alt="img" class="breadcrumb-bg-01">
				<img src="assets/img/bg/breadcrumb-bg-02.png" alt="img" class="breadcrumb-bg-02">
				<img src="assets/img/bg/breadcrumb-icon.png" alt="img" class="breadcrumb-bg-03">
				<img src="assets/img/bg/breadcrumb-icon.png" alt="img" class="breadcrumb-bg-04">
			</div>
		</div>
		<!-- /Breadcrumb -->

		<!-- Page Content -->
		<div class="content">
			<div class="container">
				<div class="card card-table">
					<div class="card-body">
						<div class="table-responsive">
							<table class="table table-hover table-center mb-0">
								<thead>
									<tr>
										<th>Product</th>
										<th>SKU</th>
										<th>Price</th>
										<th class="text-center">Quantity</th>
										<th>Total</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									<?php if (!empty($products) && !empty($productDetails)): ?>
										<?php for ($i = 0; $i < count($cartProductsId['product_id']); $i++): ?>
											<tr>
												<td>
													<h2 class="table-avatar">
														<a href="product-description.php?id=<?= $products[$i]['ProductID'] ?>" class="avatar avatar-sm me-2">
															<img class="avatar-img" src="./uploads/<?= htmlspecialchars(json_decode($products[$i]['ProductImage'], true)[0] ?? '') ?>" alt="Product Image">
														</a>
													</h2>
													<a href="product-description.php?id=<?= $products[$i]['ProductID'] ?>"><?= htmlspecialchars($products[$i]['ProductName'] ?? '') ?></a>
												</td>
												<td><?= htmlspecialchars($productDetails[$i]['SKU'] ?? '') ?></td>
												<td><span class="woocommerce-Price-currencySymbol">₹</span><?= htmlspecialchars($products[$i]['ProductPrice'] ?? 0) ?></td>
												<td>
													<div class="custom-increment cart">
														<div class="input-group1">
															<span class="input-group-btn">
																<button type="button" class="quantity-left-minus btn btn-danger btn-number" data-type="minus" data-product-id="<?= $products[$i]['ProductID'] ?>">
																	<span><i class="fas fa-minus"></i></span>
																</button>
															</span>
															<input type="text" id="quantity-<?= $products[$i]['ProductID'] ?>" name="quantity" class="input-number" value="<?= htmlspecialchars($cartProductsId['quantity'][$i] ?? 1) ?>" readonly>
															<span class="input-group-btn">
																<button type="button" class="quantity-right-plus btn btn-success btn-number" data-type="plus" data-product-id="<?= $products[$i]['ProductID'] ?>">
																	<span><i class="fas fa-plus"></i></span>
																</button>
															</span>
														</div>
													</div>
												</td>
												<td><span class="woocommerce-Price-currencySymbol">₹</span><?= htmlspecialchars(($products[$i]['ProductPrice'] ?? 0) * ($cartProductsId['quantity'][$i] ?? 0)) ?></td>
												<td>
													<a href="cart.php?deleteId=<?= $products[$i]['ProductID'] ?>" class="btn btn-sm bg-danger-light">
														<i class="fas fa-times"></i>
													</a>
												</td>
											</tr>
										<?php endfor; ?>
									<?php else: ?>
										<tr>
											<td colspan="6" class="text-center">No products found in the cart.</td>
										</tr>
									<?php endif; ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-md-7 col-lg-8"></div>
					<div class="col-md-5 col-lg-4">
						<!-- Booking Summary -->
						<div class="card booking-card">
							<div class="card-header">
								<h4 class="card-title">Cart Total</h4>
							</div>
							<div class="card-body">
								<div class="booking-summary">
									<div class="booking-item-wrap">
										<?php
										// Calculate subtotal
										$subtotal = 0;
										for ($i = 0; $i < count($products); $i++) {
											$subtotal += ($products[$i]['ProductPrice'] ?? 0) * ($cartProductsId['quantity'][$i] ?? 0);
										}

										// Calculate tax (18% of subtotal)
										$tax = $subtotal * 0.12;

										// Calculate total
										$total = $subtotal + $tax;
										?>
										<ul class="booking-date d-block pb-0">
											<li>Subtotal <span><span class="woocommerce-Price-currencySymbol"></span>₹ <?= number_format($subtotal, 2) ?></span></li>
											<li>Shipping <span><a href="#"><strong>Free</strong></a></span></li>
										</ul>
										<ul class="booking-fee pt-4">
											<li>Tax (All Taxes Included)<span><span class="woocommerce-Price-currencySymbol"></span>₹ <?= number_format($tax, 2) ?></span></li>
										</ul>
										<div class="booking-total">
											<ul class="booking-total-list">
												<li>
													<span>Total</span>
													<span class="total-cost"><span class="woocommerce-Price-currencySymbol"></span>₹ <?= number_format($total, 2) ?></span>
												</li>
												<li>
													<div class="clinic-booking pt-4">
														<a class="btn btn-primary" href="product-checkout.php">Proceed to checkout</a>
													</div>
												</li>
											</ul>
										</div>
									</div>
								</div>
							</div>
						</div>
						<!-- /Booking Summary -->
					</div>
				</div>
			</div>
		</div>
		<!-- /Page Content -->

		<!-- Footer Section -->
		<?php require_once(__DIR__ . "/components/footer.php") ?>
		<!-- /Footer Section -->

	</div>
	<!-- /Main Wrapper -->

	<!-- Add this script to the file -->

	<!-- jQuery -->
	<script src="assets/js/jquery-3.7.1.min.js" type="text/javascript"></script>

	<!-- Bootstrap Core JS -->
	<script src="assets/js/bootstrap.bundle.min.js" type="text/javascript"></script>

	<!-- Fancybox JS -->
	<script src="assets/plugins/fancybox/jquery.fancybox.min.js" type="text/javascript"></script>

	<!-- Custom JS -->
	<script src="assets/js/script.js" type="text/javascript"></script>
</body>

</html>