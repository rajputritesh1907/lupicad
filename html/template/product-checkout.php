<?php
require(__DIR__ . "/backend/connection.inc.php");

// Start the session to get the user ID
session_start();
$subtotal = 0; // Initialize subtotal variable

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
	header("Location: login.php"); // Redirect to login page if not logged in
	exit();
}

$userId = $_SESSION['user_id'];


// Fetch cart products for the logged-in user
$sql = "SELECT * FROM CartProducts WHERE user_id = '$userId'";
$result = $connection->query($sql);

$cartProducts = [];
if ($result->num_rows > 0) {
	while ($row = $result->fetch_assoc()) {
		$cartProducts[] = $row;
	}
}
// Redirect to cart.php if the cart is empty
if (empty($cartProducts)) {
	header("Location: Product-all.php");
	exit();
}
// Fetch product details for the products in the cart
$productDetails = [];
if (!empty($cartProducts)) {
	$productIds = array_column($cartProducts, 'product_id');
	$sql = "SELECT ProductID, ProductName, ProductPrice FROM producttable WHERE ProductID IN (" . implode(',', $productIds) . ")";
	$result = $connection->query($sql);

	if ($result->num_rows > 0) {
		while ($row = $result->fetch_assoc()) {
			$productDetails[] = $row;
		}
	}
}

// Fetch user details from the database
$sql = "SELECT name, email, phone, address, city, state, zip, country FROM user WHERE id = ?";
$stmt = $connection->prepare($sql);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
$userDetails = $result->fetch_assoc();
$stmt->close();


?>

<!DOCTYPE html>
<html lang="en">


<head>

	<meta charset="utf-8">

	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	

	<title>Lupicad | Checkout</title>

	<!-- Favicon -->
	<link rel="shortcut icon" href="assets/lupicad/logo.svg" type="image/x-icon">

	<!-- Apple Touch Icon -->
	<link rel="apple-touch-icon" sizes="180x180" href="assets/img/apple-touch-icon.png">

	<!-- Theme Settings Js -->
	<script src="assets/js/theme-script.js" type="7f718c45e80fc5485fab0457-text/javascript"></script>

	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="assets/css/bootstrap.min.css">

	<!-- Fontawesome CSS -->
	<link rel="stylesheet" href="assets/plugins/fontawesome/css/fontawesome.min.css">
	<link rel="stylesheet" href="assets/plugins/fontawesome/css/all.min.css">

	<!-- Iconsax CSS-->
	<link rel="stylesheet" href="assets/css/iconsax.css">

	<!-- Feathericon CSS -->
	<link rel="stylesheet" href="assets/css/feather.css">

	<!-- Main CSS -->
	<link rel="stylesheet" href="assets/css/custom.css">
	<script>
		function togglePaymentMethod() {
			const onlinePayment = document.getElementById("onlinePayment");
			const payOnDelivery = document.getElementById("payOnDelivery");
			const onlinePaymentSection = document.getElementById("onlinePaymentSection");
			const payOnDeliverySection = document.getElementById("payOnDeliverySection");

			if (onlinePayment.checked) {
				onlinePaymentSection.style.display = "block"; // Show online payment button
				payOnDeliverySection.style.display = "none"; // Hide pay on delivery button
			} else if (payOnDelivery.checked) {
				onlinePaymentSection.style.display = "none"; // Hide online payment button
				payOnDeliverySection.style.display = "block"; // Show pay on delivery button
			}
		}

		// Trigger the toggle function on page load to ensure the default state is applied
		document.addEventListener("DOMContentLoaded", togglePaymentMethod);

		function toggleShippingAddress() {
			const checkbox = document.getElementById("terms_accept");
			const newShippingAddress = document.getElementById("newShippingAddress");
			const currentAddress = document.getElementById("currentAddress");

			if (checkbox.checked) {
				newShippingAddress.style.display = "block"; // Show the new shipping address input
				currentAddress.style.display = "none"; // Hide the current address
			} else {
				newShippingAddress.style.display = "none"; // Hide the new shipping address input
				currentAddress.style.display = "block"; // Show the current address
			}
		}

		function validateTermsAndProceed(event, paymentType) {
			event.preventDefault(); // Prevent default button action

			// Retrieve form elements
			const termsCheckbox = document.getElementById("terms_accept1");
			const firstName = document.querySelector("input[name='first_name']").value.trim();
			const lastName = document.querySelector("input[name='last_name']").value.trim();
			const email = document.querySelector("input[name='email']").value.trim();
			const phone = document.querySelector("input[name='phone']").value.trim();
			const newShippingAddress = document.querySelector("textarea[name='new_shipping_address']").value.trim();
			const currentAddress = document.getElementById("currentAddress").innerText.trim();
			const useNewAddress = document.getElementById("terms_accept").checked;
			const deliveryMassage = document.querySelector("textarea[name='deliveryMassage']").value.trim(); // Optional value
			const subtotal = document.getElementById("subtotalAmount").innerText.replace(/[^0-9.]/g, ""); // Get the subtotal amount
			const tax = subtotal * 0.12; // Calculate tax (12% of subtotal)
			const totalAmount = document.getElementById("totoalPayablePrice").innerText.replace(/[^0-9.]/g, ""); // Get the total amount
			const totalAmountInPaise = parseFloat(totalAmount) * 100; // Convert to paise

			// Validate Terms & Conditions checkbox
			if (!termsCheckbox.checked) {
				showToast("Please accept the Terms & Conditions to proceed.",'danger');
				return false;
			}

			// Validate required fields
			if (!firstName || !lastName || !email || !phone) {
				showToast("Please fill in all required fields: First Name, Last Name, Email, and Phone.",'danger');
				return false;
			}
			if (!paymentType) {
				showToast("Please select a payment method.",'danger');
				return false;
			}
			if (!totalAmount || totalAmount === 0) {
				showToast("totalAmount is not available. Please check your cart.",'danger');
				return false;
			}

			// Validate email format
			const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
			if (!emailRegex.test(email)) {
				showToast("Please enter a valid email address.",'danger');
				return false;
			}

			// Validate phone number format (basic validation for numeric values)
			const phoneRegex = /^[0-9]{10}$/;
			if (!phoneRegex.test(phone)) {
				showToast("Please enter a valid 10-digit phone number.",'danger');
				return false;
			}

			// Determine the shipping address
			const shippingAddress = useNewAddress ? newShippingAddress : currentAddress;

			if (useNewAddress && !newShippingAddress) {
				showToast("Please provide a new shipping address.",'danger');
				return false;
			}

			// Prepare form data
			const formData = {
				first_name: firstName,
				last_name: lastName,
				email: email,
				phone: phone,
				shipping_address: shippingAddress,
				delivery_message: deliveryMassage, // Include optional delivery message
				payment_method: paymentType,
				total_amount: totalAmount, // Use the total amount in paise
				subtotal: subtotal,
				tax: tax, // Include tax amount
			};

			// Add product IDs and quantities to the form data
			const cartProducts = [];
			const productRows = document.querySelectorAll("table tbody tr");
			productRows.forEach(row => {
				const productId = row.getAttribute("data-product-id");
				const quantity = row.getAttribute("data-quantity");
				cartProducts.push({
					product_id: productId,
					quantity: quantity
				});
			});

			// Append cart products to the form data
			formData.cart_products = cartProducts;

			// console.log("Form Data:", formData); 
			
			// Debugging: Log the form data
			// Send the form data to the server using AJAX (or any other method)
			// Example using fetch API (you can replace this with your own AJAX implementation)
			// Create a new XMLHttpRequest object
			const xhr = new XMLHttpRequest();

			// Configure it: POST-request for the URL
			xhr.open("POST", "https://lupicad.com/lupi-back-main/html/template/backend/processOrder.php", true);
			xhr.setRequestHeader("Content-Type", "application/json");

			// Define what happens on successful data submission
			xhr.onload = function() {
				if (xhr.status === 200) {
					try {
						const response = JSON.parse(xhr.responseText);
						if (response.success) {
							// alert("Order placed successfully! Order ID: " + response.order_id);
							// showToast("Order placed successfully!",'success');
							if (paymentType === "online") {
								// Proceed with Razorpay payment
								openRazorpay(event, formData, response.order_id); // Call Razorpay payment function
							} else {
								// Handle COD payment
								// alert("Your order has been placed successfully. Please pay on delivery.");
								showToast("Your order has been placed successfully.",'success');
								// Optionally, redirect to a thank you page or order confirmation page
								window.location.href = "thankyou.php?orderId=" + response.order_id + "&paymentType=Cod"; // Redirect to thank you page
							}
						} else {
							// alert("Error placing order: " + response.message + $response.error);
							showToast("Error placing order",'danger');
						}
					} catch (error) {
						// console.error("Error parsing response:", error);
						// console.error("Raw Response:", xhr.responseText); // Log the raw response for debugging
						// alert("An unexpected error occurred. Please try again.");
						showToast("An unexpected error occurred. Please try again.",'danger');
					}
				} else {
					// alert("Failed to place the order. Server returned status: " + xhr.status);
					showToast("Failed to place the order.",'danger');
				}
			};

			// Define what happens in case of an error
			xhr.onerror = function() {
				console.error("Request failed.");
				// alert("An error occurred while placing the order. Please try again.");
				showToast("An error occurred while placing the order. Please try again.",'danger');
			};

			// Send the request with the form data
			xhr.send(JSON.stringify(formData));
		}
	</script>
	<script>
		function openRazorpay(event, formData, orderId) {
			event.preventDefault(); // Prevent default form submission

			// Extract the total payable price from the span
			const totalPayablePrice = document.getElementById("totoalPayablePrice").innerText;
			const amountInPaise = parseFloat(totalPayablePrice.replace(/[^0-9.]/g, "")) * 100; // Convert to paise

			const options = {
				key: "rzp_live_iZZhD63jOXBQZP", // Replace with your Razorpay Key ID
				amount: amountInPaise, // Amount in paise
				currency: "INR",
				name: "Lupicad", // Your business name
				description: "Order Payment",
				image: "assets/lupicad/logo.svg", // Your logo URL
				handler: function(response) {
					console.log("Payment Response:", response);
					if (response.razorpay_payment_id) {
						// alert("Payment Successful! Payment ID: " + response.razorpay_payment_id);
						// Verify payment with Razorpay
						verifyPayment(response.razorpay_payment_id, orderId); // Call the verifyPayment function
					} else {
						// alert("Oops! Something went wrong. Please try again.");
						showToast("Oops! Something went wrong. Please try again.",'danger');
						updateOrderStatus(orderId, "failed");
					}
				},
				prefill: {
					name: formData.first_name + " " + formData.last_name,
					email: formData.email,
					contact: formData.phone
				},
				theme: {
					color: "#3399cc" // Customize the popup color
				},
				modal: {
					ondismiss: function() {
						// alert("Payment Window closed . Please try again.");
						showToast("Payment Window closed . Please try again.",'danger');
						updateOrderStatus(orderId, "failed");
					}
				}
			};

			const rzp = new Razorpay(options);
			rzp.open();
		}

		function verifyPayment(paymentId, orderId) {
			// Show a loading message while verifying
			// alert("Verifying payment...");
			showToast("Verifying payment...",'success');
			// Prepare the data to send to the server
			const verificationData = {
				payment_id: paymentId
			};

			// Use AJAX to send the data to the server for verification
			const xhr = new XMLHttpRequest();
			xhr.open("POST", "./backend/verifyPayment.php", true); // Server-side proxy endpoint
			xhr.setRequestHeader("Content-Type", "application/json");

			xhr.onload = function() {
				if (xhr.status === 200) {
					try {
						const response = JSON.parse(xhr.responseText);
						if (response.success) {
							// alert("Payment verified successfully!");
							showToast("Payment verified successfully!",'success');
							updateOrderStatus(orderId, "Paid");
							// Redirect to the thank you page
							window.location.href = "thankyou.php?orderId=" + orderId + "&paymentType=online"+ "&paymentId=" + paymentId; // Redirect to thank you page
						} else {
							// alert("Payment verification failed: " + response.message + response.error);
							showToast("Payment verification failed: " + response.message,'danger');
							updateOrderStatus(orderId, "failed");
						}
					} catch (error) {
						console.error("Error parsing server response:", error);
						// alert("An unexpected error occurred during payment verification.");
						showToast("An unexpected error occurred during payment verification.",'danger');
						updateOrderStatus(orderId, "failed");
					}
				} else {
					// alert("Failed to verify payment. Server returned status: " + xhr.status);
					showToast("Failed to verify payment",'danger');
					updateOrderStatus(orderId, "failed");
				}
			};

			xhr.onerror = function() {
				console.error("Request failed.");
				// alert("An error occurred while verifying the payment. Please try again.");
				showToast("An error occurred while verifying the payment. Please try again.",'danger');
				updateOrderStatus(orderId, "failed");
			};

			// Send the request with the verification data
			xhr.send(JSON.stringify(verificationData));
		}

		function updateOrderStatus(orderId, status) {
			// Prepare the data to send to the server
			const statusData = {
				order_id: orderId,
				status: status
			};

			// Use AJAX to send the status update to the server
			const xhr = new XMLHttpRequest();
			xhr.open("POST", "./backend/updateOrderStatus.php", true); // Server-side endpoint to update order status
			xhr.setRequestHeader("Content-Type", "application/json");

			xhr.onload = function() {
				if (xhr.status === 200) {
					console.log("Order status updated successfully:", xhr.responseText);
				} else {
					console.error("Failed to update order status. Server returned status:", xhr.status);
				}
			};

			xhr.onerror = function() {
				console.error("Request failed while updating order status.");
			};

			// Send the request with the status data
			xhr.send(JSON.stringify(statusData));
		}
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
								<li class="breadcrumb-item"><a href="index.php"><i class="isax isax-home-15"></i></a></li>
								<li class="breadcrumb-item" aria-current="page">Product</li>
								<li class="breadcrumb-item active">Checkout</li>
							</ol>
							<h2 class="breadcrumb-title">Checkout</h2>
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

				<div class="row">
					<div class="col-md-6 col-lg-7">
						<div class="card">
							<div class="card-header">
								<h3 class="card-title">Billing details</h3>
							</div>
							<div class="card-body">

								<!-- Checkout Form -->
								<form action="">

									<!-- Personal Information -->
									<div class="info-widget">
										<h4 class="card-title">Personal Information</h4>
										<div class="row">
											<div class="col-md-6 col-sm-12">
												<div class="mb-3 card-label">
													<label class="mb-2">First Name</label>
													<input class="form-control" type="text" name="first_name" value="<?php echo htmlspecialchars(explode(' ', $userDetails['name'])[0]); ?>" required>
												</div>
											</div>
											<div class="col-md-6 col-sm-12">
												<div class="mb-3 card-label">
													<label class="mb-2">Last Name</label>
													<input class="form-control" type="text" name="last_name" value="<?php echo htmlspecialchars(explode(' ', $userDetails['name'])[1] ?? ''); ?>" required>
												</div>
											</div>
											<div class="col-md-6 col-sm-12">
												<div class="mb-3 card-label">
													<label class="mb-2">Email</label>
													<input class="form-control" type="email" name="email" value="<?php echo htmlspecialchars($userDetails['email']); ?>" required>
												</div>
											</div>
											<div class="col-md-6 col-sm-12">
												<div class="mb-3 card-label">
													<label class="mb-2">Phone</label>
													<input class="form-control" type="text" name="phone" value="<?php echo htmlspecialchars($userDetails['phone']); ?>" required>
												</div>
											</div>
										</div>
									</div>
									<!-- /Personal Information -->

									<!-- Shipping Details -->
									<div class="info-widget">
										<h4 class="card-title">Shipping Details</h4>
										<div id="currentAddress">
											<p>
												<?php echo htmlspecialchars($userDetails['address'] . ', ' . $userDetails['city'] . ', ' . $userDetails['state'] . ', ' . $userDetails['zip']); ?>
											</p>
										</div>
										<div class="terms-accept">
											<div class="custom-checkbox">
												<input type="checkbox" id="terms_accept" onclick="toggleShippingAddress()">
												<label for="terms_accept">Ship to a different address?</label>
											</div>
										</div>
										<div id="newShippingAddress" style="display: none;">
											<label class="ps-0 ms-0 mb-2">New Shipping Address</label>
											<textarea rows="5" class="form-control" name="new_shipping_address" placeholder="Enter your new shipping address"></textarea>
										</div>
										<div class="mb-3 card-label">
											<label class="ps-0 ms-0 mb-2">Order notes (Optional)</label>
											<textarea rows="5" class="form-control" name="deliveryMassage"></textarea>
										</div>
									</div>
									<!-- /Shipping Details -->

									<div class="payment-widget">


										<!-- Payment Methods -->
										<div class="payment-widget">
											<h4 class="card-title">Payment Method</h4>

											<!-- Online Payment -->
											<div class="payment-list">
												<label class="payment-radio">
													<input type="radio" name="payment_method" value="online" id="onlinePayment" onclick="togglePaymentMethod()" required checked>
													<span class="checkmark"></span>
													Online Payment
												</label>
											</div>

											<!-- Pay on Delivery -->
											<div class="payment-list">
												<label class="payment-radio">
													<input type="radio" name="payment_method" value="cod" id="payOnDelivery" onclick="togglePaymentMethod()" required>
													<span class="checkmark"></span>
													Cash on Delivery
												</label>
											</div>

											<!-- Terms Accept -->
											<div class="terms-accept">
												<div class="custom-checkbox">
													<input type="checkbox" id="terms_accept1">
													<label for="terms_accept1">I have read and accept <a href="terms-condition.php">Terms &amp; Conditions</a></label>
												</div>
											</div>
											<!-- /Terms Accept -->

											<!-- Online Payment Button -->
											<div id="onlinePaymentSection">
												<div class="submit-section mt-4">
													<button type="button" class="btn btn-primary submit-btn" onclick="validateTermsAndProceed(event, 'online')">Pay Online</button>
												</div>
											</div>

											<!-- Pay on Delivery Button -->
											<div id="payOnDeliverySection" style="display: none;">
												<div class="submit-section mt-4">
													<button type="button" class="btn btn-primary submit-btn" onclick="validateTermsAndProceed(event, 'cod')">Confirm Order</button>
												</div>
											</div>
										</div>
										<!-- /Payment Methods -->

									</div>
								</form>
								<!-- /Checkout Form -->

							</div>
						</div>

					</div>

					<div class="col-md-6 col-lg-5 theiaStickySidebar">

						<!-- Booking Summary -->
						<div class="card booking-card">
							<div class="card-header">
								<h3 class="card-title">Your Order</h3>
							</div>
							<div class="card-body">
								<div class="table-responsive">
									<table class="table table-center mb-0">
										<thead>
											<tr>
												<th>Product</th>
												<th class="text-end">Total</th>
											</tr>
										</thead>
										<tbody>
											<?php
											$subtotal = 0; // Reset subtotal
											foreach ($cartProducts as $cartProduct) {
												foreach ($productDetails as $product) {
													if ($cartProduct['product_id'] == $product['ProductID']) {
														$productName = htmlspecialchars($product['ProductName']);
														$productPrice = $product['ProductPrice']; // Use the correct column name
														$quantity = $cartProduct['quantity'];
														$totalPrice = $productPrice * $quantity;
														$subtotal += $totalPrice;
														echo "<tr data-product-id='{$product['ProductID']}' data-quantity='{$quantity}'>
																<td>{$productName} (x{$quantity})</td>
																<td class='text-end'><span class='woocommerce-Price-currencySymbol'>₹</span>{$totalPrice}</td>
															</tr>";
													}
												}
											}
											?>
										</tbody>
									</table>
								</div>
								<div class="booking-summary pt-5">
									<div class="booking-item-wrap">
										<ul class="booking-date d-block pb-0">
											<li>Subtotal<span class="woocommerce-Price-currencySymbol" id='subtotalAmount'>₹<?php echo $subtotal; ?></span></li>
											<li>Shipping <span class="woocommerce-Price-currencySymbol">Free Shipping</span></li>
										</ul>
										<ul class="booking-fee">
											<li>Tax (All Taxes are Included)<span class="woocommerce-Price-currencySymbol">₹<?php echo round($subtotal * 0.12, 2); ?></span></li>
										</ul>
										<div class="booking-total">
											<ul class="booking-total-list">
												<li>
													<span>Total &nbsp;&nbsp;₹</span>
													<span id="totoalPayablePrice" class="woocommerce-Price-currencySymbol"><?php echo $subtotal + round($subtotal * 0.12, 2); ?></span>
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

	<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
	<!-- jQuery -->
	<script src="assets/js/jquery-3.7.1.min.js" type="7f718c45e80fc5485fab0457-text/javascript"></script>

	<!-- Bootstrap Core JS -->
	<script src="assets/js/bootstrap.bundle.min.js" type="7f718c45e80fc5485fab0457-text/javascript"></script>

	<!-- Sticky Sidebar JS -->
	<script src="assets/plugins/theia-sticky-sidebar/ResizeSensor.js" type="7f718c45e80fc5485fab0457-text/javascript"></script>
	<script src="assets/plugins/theia-sticky-sidebar/theia-sticky-sidebar.js" type="7f718c45e80fc5485fab0457-text/javascript"></script>

	<!-- Custom JS -->
	<script src="assets/js/script.js" type="7f718c45e80fc5485fab0457-text/javascript"></script>

	<script src="../../cdn-cgi/scripts/7d0fa10a/cloudflare-static/rocket-loader.min.js" data-cf-settings="7f718c45e80fc5485fab0457-|49" defer></script>
	<script defer src="https://static.cloudflareinsights.com/beacon.min.js/vcd15cbe7772f49c399c6a5babf22c1241717689176015" integrity="sha512-ZpsOmlRQV6y907TI0dKBHq9Md29nnaEIPlkf84rnaERnq6zvWvPUqr2ft8M1aS28oN72PdrCzSjY4U6VaAw1EQ==" data-cf-beacon='{"rayId":"926c47e2ce3691a3","version":"2025.1.0","serverTiming":{"name":{"cfExtPri":true,"cfL4":true,"cfSpeedBrain":true,"cfCacheStatus":true}},"token":"3ca157e612a14eccbb30cf6db6691c29","b":1}' crossorigin="anonymous"></script>
</body>


</html>