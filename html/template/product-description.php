<?php

require_once(__DIR__ . "/backend/connection.inc.php");
require_once(__DIR__ . "/backend/ProductTable.inc.php");

if (isset($_GET['id']) && !empty($_GET['id'])) {
	$productId = intval($_GET['id']);
	$stmt = $connection->prepare("SELECT * FROM producttable WHERE ProductID = ?");
	$stmt->bind_param("i", $productId);
	$stmt->execute();
	$result = $stmt->get_result();

	if ($result->num_rows > 0) {
		$product = $result->fetch_assoc();
		// You can now use the product details in your HTML
		$productImages = json_decode($product['ProductImage'], true);

		// Ensure the decoding was successful and the array is not empty
		if (is_array($productImages) && count($productImages) > 0) {
			$mainImage = $productImages[0];
			$hoverImage = isset($productImages[1]) ? $productImages[1] : $productImages[0];
		} else {
			$mainImage = 'default-image.jpg';
			$hoverImage = 'default-image.jpg';
		}
		// echo "<script>console.log(" . json_encode(['mainImage' => $mainImage, 'hoverImage' => $hoverImage]) . ");</script>";
	} else {
		// echo "<script>console.log('No product found with ID: $productId');</script>";
	}

	$stmt->close();

	//fatching product details from ProductDetailsTable based on the product ID
	$stmt = $connection->prepare("SELECT * FROM productdetailstable WHERE ProductID = ?");
	$stmt->bind_param("i", $productId);
	$stmt->execute();
	$result = $stmt->get_result();
	if ($result->num_rows > 0) {
		$productDetails = $result->fetch_assoc();
		// echo "<script>console.log(" . json_encode($productDetails) . ");</script>";
	} else {
		// echo "<script>console.log('No product details found with ID: $productId');</script>";
		header("Location: product-all.php?error=noProductfound");
	}
	$stmt->close();
	// echo "<script>console.log(" . json_encode($productDetails['ProductDescription']) . ")</script>";
} else {
	// Redirect to allproduct.php if 'id' is not provided
	header("Location: product-all.php?error=invalidProductId");
	exit;
}
?>

<!-------------------------------------------------------- review ------------------------------------------------------->

<?php
// Start session to store reviews temporarily
session_start();

require_once(__DIR__ . "/backend/connection.inc.php");
require_once(__DIR__ . "/backend/ProductTable.inc.php");

try {
	$stmt = $connection->prepare("CREATE TABLE IF NOT EXISTS productreviews (
		ReviewID INT AUTO_INCREMENT PRIMARY KEY,
		UserID INT NOT NULL,
		UserName VARCHAR(255) NOT NULL,
		ProductID INT NOT NULL,
		StarRating INT NOT NULL,
		Title VARCHAR(255) NOT NULL,
		created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
		ReviewText TEXT NOT NULL,
		FOREIGN KEY (ProductID) REFERENCES producttable(ProductID) ON DELETE CASCADE,
		FOREIGN KEY (UserID) REFERENCES User(id) ON DELETE CASCADE
	)");
	$stmt->execute();
	$stmt->close();
	// echo "<script>console.log('ProductReviewsTable created successfully');</script>";
} catch (Exception $e) {
	// echo "<script>console.error('Error creating table: " . json_encode($e->getMessage()) . "');</script>";
}

$stmt = $connection->prepare("SELECT * FROM productreviews WHERE ProductID = ?");
$stmt->bind_param("i", $productId);
$stmt->execute();
$result = $stmt->get_result();
$reviews = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();
// echo "<script>console.log(" . json_encode($reviews) . ");</script>";


// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$star = $_POST['star'] ?? 0;
	$title = $_POST['title'] ?? '';
	$message = $_POST['message'] ?? '';
	$UserId = $_SESSION['user_id'] ?? null;
	if (!$UserId) {
		// echo "<script>alert('Please login to submit a review.');</script>";
	}

	//fatch usename form user table
	$stmt = $connection->prepare("SELECT name FROM user WHERE id = ?");
	$stmt->bind_param("i", $UserId);
	$stmt->execute();
	$result = $stmt->get_result();
	if ($result->num_rows > 0) {
		$user = $result->fetch_assoc();
		$userName = $user['name']; // Get the 'name' field
		// echo "<script>console.log('UserName = " . addslashes($userName) . "');</script>";
	} else {
		// echo "<script>console.log('No user found with ID: " . $UserId . "');</script>";
	}
	$stmt->close();

	try {
		// Check if the user has already submitted a review for this product
		$stmt = $connection->prepare("SELECT * FROM productreviews WHERE UserID = ? AND ProductID = ?");
		$stmt->bind_param("ii", $UserId, $productId);
		$stmt->execute();
		$result = $stmt->get_result();

		if ($result->num_rows > 0) {
			// echo "<script>alert('You have already submitted a review for this product.');</script>";
			echo "<script>showToast('You have already submitted a review for this product.','success');</script>";

			$stmt->close();
		} else {
			$stmt->close();
			// Insert the review into the ProductReviews table
			$stmt = $connection->prepare("INSERT INTO productreviews (UserID, UserName, ProductID, StarRating, Title, ReviewText) VALUES (?, ?, ?, ?, ?, ?)");
			$stmt->bind_param("isiiss", $UserId, $userName, $productId, $star, $title, $message);
			$stmt->execute();
			$stmt->close();
		}
	} catch (Exception $e) {
		echo "<script>alert('Error submitting review. Please try again later.');</script>";
		echo "<script>console.error('Error: " . json_encode($e->getMessage()) . "');</script>";
	}

	//rest form after submit
	$star = 0;
	$title = '';
	$message = '';
	// Redirect to the same page to see the new review
	// header("Location: product-description.php?id=" . $productId);
	//refresh the page to see the new review
	header('refresh:1; url=product-description.php?id=' . $productId);
	exit;
}
?>


<!DOCTYPE html>
<html lang="en">

<!-- Mirrored from doccure.dreamstechnologies.com/html/template/product-descriptionphp by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 27 Mar 2025 05:01:30 GMT -->

<head>

	<meta charset="utf-8">

	<meta name="viewport" content="width=device-width, initial-scale=1.0"> 
	<title>Lupicad | Product Description</title>

	<!-- Favicon -->
	<link rel="shortcut icon" href="assets/lupicad/logo.svg" type="image/x-icon">

	<!-- Apple Touch Icon -->
	<link rel="apple-touch-icon" sizes="180x180" href="assets/img/apple-touch-icon.png">

	<!-- Theme Settings Js -->
	<script src="assets/js/theme-script.js" type="d84c1cf35bcde7b0ac3da1bf-text/javascript"></script>

	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="assets/css/bootstrap.min.css">


	<!-- Fontawesome CSS -->
	<link rel="stylesheet" href="assets/plugins/fontawesome/css/fontawesome.min.css">
	<link rel="stylesheet" href="assets/plugins/fontawesome/css/all.min.css">
	<link rel="stylesheet" href="assets/css/animate.css">
	<!-- Iconsax CSS-->
	<link rel="stylesheet" href="assets/css/iconsax.css">
	<!-- <link rel="stylesheet" href="assets/css/owl.carousel.min.css"> -->

	<!-- Feathericon CSS -->
	<link rel="stylesheet" href="assets/css/feather.css">

	<!-- Datetimepicker CSS -->
	<link rel="stylesheet" href="assets/css/bootstrap-datetimepicker.min.css">

	<!-- Select2 CSS -->
	<link rel="stylesheet" href="assets/plugins/select2/css/select2.min.css">

	<!-- Fancybox CSS -->
	<link rel="stylesheet" href="assets/plugins/fancybox/jquery.fancybox.min.css">

	<!-- Main CSS -->
	<link rel="stylesheet" href="assets/css/custom.css">
	<script>
		document.addEventListener('DOMContentLoaded', function() {
			// Select the quantity input and buttons by their unique IDs
			const quantityInput = document.getElementById('quantity-input');
			const incrementButton = document.getElementById('quantity-right-plus');
			const decrementButton = document.getElementById('quantity-left-minus');

			// Increment quantity function
			function incrementQuantity() {
				let currentValue = parseFloat(quantityInput.value); // Parse as float
				if (!isNaN(currentValue) && currentValue < 25) { // Ensure it doesn't exceed 25
					let newValue = currentValue + 0.5; // Increment by 0.5
					quantityInput.value = formatQuantity(newValue); // Format the value
				}
			}

			// Decrement quantity function
			function decrementQuantity() {
				let currentValue = parseFloat(quantityInput.value); // Parse as float
				if (!isNaN(currentValue) && currentValue > 1) { // Ensure it doesn't go below 0.5
					let newValue = currentValue - 0.5; // Decrement by 0.5
					quantityInput.value = formatQuantity(newValue); // Format the value
				}
			}

			// Format quantity to remove ".0" for whole numbers
			function formatQuantity(value) {
				return value % 1 === 0 ? value.toFixed(0) : value.toFixed(1); // Remove ".0" for whole numbers
			}

			// Add event listeners to the buttons
			incrementButton.addEventListener('click', incrementQuantity);
			decrementButton.addEventListener('click', decrementQuantity);
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
								<li class="breadcrumb-item"><a href="indexphp"><i class="isax isax-home-15"></i></a>
								</li>
								<li class="breadcrumb-item" aria-current="page">Product</li>
								<li class="breadcrumb-item active">Product Description</li>
							</ol>
							<h2 class="breadcrumb-title">Product Description</h2>
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

					<div class="col-md-7 col-lg-9 col-xl-9">
						<!-- Doctor Widget -->
						<div class="card">
							<div class="card-body product-description">
								<div class="doctor-widget">
									<div class="doc-info-left" style="display: flex; justify-content: center; align-items: center; width:100%;">
										<div class="doctor-img1">
											<img src="./uploads/<?= $mainImage ?>" class="img-fluid"
												alt="product Image">
										</div>
										<div class="doc-info-cont product-cont" style="width:100%;">
											<h4 class="doc-name mb-2"><?= $product['ProductName'] ?></h4>
											<p><?= $product['ProductShortDescription'] ?></p> 
										</div>
									</div>

								</div>

							</div>
						</div>
						<!-- /Doctor Widget -->

						<!-- Doctor Details Tab -->
						<div class="card">
							<div class="card-body pt-0">

								<!-- Tab Menu -->
								<h3 class="pt-4">Product Details</h3>
								<hr>
								<!-- /Tab Menu -->

								<!-- Tab Content -->
								<div class="tab-content pt-3">

									<!-- Overview Content -->
									<div role="tabpanel" id="doc_overview" class="tab-pane fade show active">
										<div class="row">
											<div class="col-md-9"> 
												<!-- /Awards Details --> 
												<!-- About Details -->
												<div class="widget about-widget">
													<h4 class="widget-title">Directions for use</h4>
													<p><?= $productDetails['Directions'] ?></p>
												</div>
												<!-- /About Details -->
																								<!-- About Details -->
												<div class="widget about-widget">
													<h4 class="widget-title">Description</h4>
													<p><?= $productDetails['ProductDescription'] ?></p>
												</div>
												<!-- /About Details -->

												<!-- About Details -->
												<div class="widget about-widget">
													<h4 class="widget-title">Storage</h4>
													<p><?= $productDetails['Storage'] ?></p>
												</div>
												<!-- /About Details -->
												<!-- About Details -->
												<div class="widget about-widget">
													<h4 class="widget-title">Administration Instructions</h4>
													<p><?= $productDetails['Administration'] ?></p>
												</div>
												<!-- /About Details -->

												<!-- About Details -->
												<div class="widget about-widget">
													<h4 class="widget-title">Warning</h4>
													<p><?= $productDetails['Warning'] ?></p>
												</div>
												<!-- /About Details -->
												<!-- About Details -->
												<div class="widget about-widget mb-0">
													<h4 class="widget-title">Precaution</h4>
													<p><?= $productDetails['Precaution'] ?></p>
												</div>
												<!-- /About Details -->
											</div>
										</div>
									</div>

									<!-- /Overview Content -->

								</div>
							</div>
						</div>
						<!-- /Doctor Details Tab -->
						<section class="article-section">
							<div class="container">
								<div class="section-header sec-header-one text-center aos" data-aos="fade-up">
									<h2>Reviews</h2>
								</div>

								<!-- Testimonial Slider -->
								<div class="owl-carousel testimonials-slider aos" data-aos="fade-up">
									<?php if (empty($reviews)) { ?>
										<div class="card shadow-none mb-0">
											<div class="card-body">
												<p>No reviews available for this product.</p>
											</div>
										</div>
									<?php } else { ?>
										<?php foreach ($reviews as $review) { ?>
											<div key="<?= $review['UserID'] ?>" class="card shadow-none mb-0">
												<div class="card-body">
													<div class="d-flex align-items-center mb-4">
														<div class="rating d-flex">
															<?php for ($i = 0; $i < 5; $i++) { ?>
																<?php if ($i < $review['StarRating']) { ?>
																	<i class="fa-solid fa-star filled me-1" style="color:orange"></i>
																<?php } else { ?>
																	<i class="fa-solid fa-star" style="color:gray"></i>
																<?php } ?>
															<?php } ?>
														</div>
														<span>
															<img src="assets/img/icons/quote-icon.svg" alt="img">
														</span>
													</div>
													<h6 class="fs-16 fw-medium mb-2"><?= $review['Title'] ?></h6>
													<p><?= $review['ReviewText'] ?></p>
													<div class="d-flex align-items-center">
														<a href="javascript:void(0);" class="avatar avatar-lg">
															<img src="assets/img/patients/patient22.jpg" class="rounded-circle" alt="img">
														</a>
														<div class="ms-2">
															<h6 class="mb-1"><a href="javascript:void(0);"><?= $review['UserName'] ?></a></h6>
															<p class="fs-14 mb-0"> Gujarat</p>
														</div>
													</div>
												</div>
											</div>
										<?php } ?>
									<?php } ?>
								</div>
								<!-- /Testimonial Slider -->
							</div>
						</section>
					</div>

					<div class="col-md-5 col-lg-3 col-xl-3 theiaStickySidebar">

						<!-- Right Details -->
						<div class="card search-filter">
							<div class="card-body">
								<div class="clini-infos mt-0">
									<h2>
										<span class="woocommerce-Price-currencySymbol">₹</span><?= number_format($product['ProductPrice'], 0) ?>&nbsp;
										<s class="text-lg strike">(₹<?= number_format($product['ProductPrice'] / (1 - ($productDetails['Discount'] / 100)), 0) ?>)</s>
										<span class="text-lg text-success"><b><?= number_format($productDetails['Discount'], 2) ?>% off</b></span>
									</h2>
								</div>
								<span class="badge badge-primary">In stock</span>
								<div class="custom-increment pt-4">
									<div class="input-group1">
										<span class="input-group-btn float-start">
											<button type="button" id="quantity-left-minus" class="quantity-left-minus btn btn-danger btn-number" data-type="minus">
												<span><i class="fas fa-minus"></i></span>
											</button>
										</span>
										<input type="text" id="quantity-input" name="quantity" class="input-number" value="1" min="1" max="20" step="0.5" readonly>
										<span class="input-group-btn float-end">
											<button type="button" id="quantity-right-plus" class="quantity-right-plus btn btn-success btn-number" data-type="plus">
												<span><i class="fas fa-plus"></i></span>
											</button>
										</span>
									</div>
								</div>
								<div class="clinic-details mt-4">
									<div class="clinic-booking">
										<a class="btn btn-primary" id="add-to-cart-btn" href="./cart.php?product_id=<?= $product['ProductID'] ?>">Add To Cart</a>
									</div>
								</div>
								<div class="card flex-fill mt-4 mb-0">
									<ul class="list-group list-group-flush">
										<li class="list-group-item text-gray-6">SKU <span
												class="float-end"><?= $productDetails['SKU'] ?></span></li>
										<li class="list-group-item text-gray-6">Pack Size <span
												class="float-end"><?= $productDetails['PackSize'] ?></span></li>
										<li class="list-group-item text-gray-6">Unit Count <span
												class="float-end"><?= $productDetails['UnitCount'] ?></span></li>
										<li class="list-group-item text-gray-6">Country <span
												class="float-end"><?= $productDetails['Country'] ?></span></li>
									</ul>
								</div>
							</div>
						</div>
						<div class="card search-filter">
							<div class="card-body">
								<div class="card flex-fill mt-0 mb-0">
									<ul class="list-group list-group-flush benifits-col">
										<li class="list-group-item d-flex align-items-center">
											<div>
												<i class="fas fa-shipping-fast"></i>
											</div>
											<div>
												Free Shipping<br><span class="text-sm">For orders from <span class="woocommerce-Price-currencySymbol">₹</span>650</span>
											</div>
										</li>
										<li class="list-group-item d-flex align-items-center">
											<div>
												<i class="far fa-question-circle"></i>
											</div>
											<div>
												Support 24/7<br><span class="text-sm">Call us anytime</span>
											</div>
										</li>
										<li class="list-group-item d-flex align-items-center">
											<div>
												<i class="fas fa-hands"></i>
											</div>
											<div>
												100% Safety<br><span class="text-sm">Only secure payments</span>
											</div>
										</li>
										<li class="list-group-item d-flex align-items-center">
											<div>
												<i class="fas fa-tag"></i>
											</div>
											<div>
												Hot Offers<br><span class="text-sm">Discounts up to 90%</span>
											</div>
										</li>
									</ul>
								</div>
							</div>
						</div>
						<!-- /Right Details -->

						<div class="card contact-form-card w-100">
							<div class="card-body">

								<form method="post" class="review-form">
									<label>Star Rating:</label>
									<div class="star-rating" style="display: flex; justify-content: center; align-items: center; transform: translateY(15px); scale: 1.5;">
										<?php for ($i = 5; $i >= 1; $i--): ?>
											<input type="radio" id="star-<?= $i ?>" name="star" value="<?= $i ?>">
											<label for="star-<?= $i ?>" title="<?= $i ?> stars"><i class="fa-solid fa-star filled me-1"></i></label>
										<?php endfor; ?>
									</div>
									<br><br>

									<div class="col-md-12">
										<div class="mb-3">
											<label class="form-label">Title</label>
											<input type="text" class="form-control" name="title" required>
										</div>
									</div>



									<div class="col-md-12">
										<div class="mb-3">
											<label class="form-label">Message</label>
											<textarea class="form-control" name="message" rows="6" required></textarea>
										</div>
									</div>

									<div class="col-md-12">
										<div class="mb-3" style="display: flex;justify-content: center;align-items: center;">
											<button class="btn btn-primary" type="submit">Submit Review</button>
										</div>
									</div>


								</form>

								<!-- <form action="#" method="post">
									<h2>Add review</h2>
									<div class="row">

                                       


										<div class="col-md-12">
											<div class="mb-3">
												<label class="form-label">Title</label>
												<input type="text" class="form-control">
											</div>
										</div>



										<div class="col-md-12">
											<div class="mb-3">
												<label class="form-label">Message</label>
												<textarea class="form-control" rows="6"></textarea>
											</div>
										</div>
										<div class="col-md-12">
											<div class="form-group-btn mb-0">
												<button type="submit" class="btn btn-primary-gradient">Send Message</button>
											</div>
										</div>
									</div>
								</form> -->
							</div>
						</div>
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

	<!-- Voice Call Modal -->
	<div class="modal fade call-modal" id="voice_call">
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content">
				<div class="modal-body">
					<!-- Outgoing Call -->
					<div class="call-box incoming-box">
						<div class="call-wrapper">
							<div class="call-inner">
								<div class="call-user">
									<img alt="User Image" src="assets/img/doctors/doctor-thumb-02.jpg"
										class="call-avatar">
									<h4>Dr. Darren Elder</h4>
									<span>Connecting...</span>
								</div>
								<div class="call-items">
									<a href="javascript:void(0);" class="btn call-item call-end" data-bs-dismiss="modal"
										aria-label="Close"><i class="material-icons">call_end</i></a>
									<a href="voice-callphp" class="btn call-item call-start"><i
											class="material-icons">call</i></a>
								</div>
							</div>
						</div>
					</div>
					<!-- Outgoing Call -->

				</div>
			</div>
		</div>
	</div>
	<!-- /Voice Call Modal -->

	<!-- Video Call Modal -->
	<div class="modal fade call-modal" id="video_call">
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content">
				<div class="modal-body">

					<!-- Incoming Call -->
					<div class="call-box incoming-box">
						<div class="call-wrapper">
							<div class="call-inner">
								<div class="call-user">
									<img class="call-avatar" src="assets/img/doctors/doctor-thumb-02.jpg"
										alt="User Image">
									<h4>Dr. Darren Elder</h4>
									<span>Calling ...</span>
								</div>
								<div class="call-items">
									<a href="javascript:void(0);" class="btn call-item call-end" data-bs-dismiss="modal"
										aria-label="Close"><i class="material-icons">call_end</i></a>
									<a href="video-callphp" class="btn call-item call-start"><i
											class="material-icons">videocam</i></a>
								</div>
							</div>
						</div>
					</div>
					<!-- /Incoming Call -->

				</div>
			</div>
		</div>
	</div>
	<!-- Video Call Modal -->

	<script>
		document.addEventListener('DOMContentLoaded', function() {
			const quantityInput = document.getElementById('quantity-input');
			const addToCartButton = document.getElementById('add-to-cart-btn');

			// Update the href of the "Add To Cart" button when clicked
			addToCartButton.addEventListener('click', function(event) {
				const quantity = quantityInput.value; // Get the current quantity value
				const productId = <?= $product['ProductID'] ?>; // Get the product ID from PHP
				addToCartButton.href = `./cart.php?product_id=${productId}&Quentity=${quantity}`;
			});
		});
	</script>

	<!-- jQuery -->
	<script src="assets/js/jquery-3.7.1.min.js" type="d84c1cf35bcde7b0ac3da1bf-text/javascript"></script>

	<!-- Bootstrap Core JS -->
	<script src="assets/js/bootstrap.bundle.min.js" type="d84c1cf35bcde7b0ac3da1bf-text/javascript"></script>

	<!-- Sticky Sidebar JS -->
	<script src="assets/plugins/theia-sticky-sidebar/ResizeSensor.js"
		type="d84c1cf35bcde7b0ac3da1bf-text/javascript"></script>
	<script src="assets/plugins/theia-sticky-sidebar/theia-sticky-sidebar.js"
		type="d84c1cf35bcde7b0ac3da1bf-text/javascript"></script>

	<!-- Select2 JS -->
	<script src="assets/plugins/select2/js/select2.min.js" type="d84c1cf35bcde7b0ac3da1bf-text/javascript"></script>

	<!-- Datetimepicker JS -->
	<script src="assets/js/moment.min.js" type="d84c1cf35bcde7b0ac3da1bf-text/javascript"></script>
	<script src="assets/js/bootstrap-datetimepicker.min.js" type="d84c1cf35bcde7b0ac3da1bf-text/javascript"></script>

	<!-- Fancybox JS -->
	<script src="assets/plugins/fancybox/jquery.fancybox.min.js"
		type="d84c1cf35bcde7b0ac3da1bf-text/javascript"></script>

	<!-- Custom JS -->
	<script src="assets/js/script.js" type="d84c1cf35bcde7b0ac3da1bf-text/javascript"></script>

	<script src="../../cdn-cgi/scripts/7d0fa10a/cloudflare-static/rocket-loader.min.js"
		data-cf-settings="d84c1cf35bcde7b0ac3da1bf-|49" defer></script>
	<script defer
		src="https://static.cloudflareinsights.com/beacon.min.js/vcd15cbe7772f49c399c6a5babf22c1241717689176015"
		integrity="sha512-ZpsOmlRQV6y907TI0dKBHq9Md29nnaEIPlkf84rnaERnq6zvWvPUqr2ft8M1aS28oN72PdrCzSjY4U6VaAw1EQ=="
		data-cf-beacon='{"rayId":"926c47e02b6891a3","version":"2025.1.0","serverTiming":{"name":{"cfExtPri":true,"cfL4":true,"cfSpeedBrain":true,"cfCacheStatus":true}},"token":"3ca157e612a14eccbb30cf6db6691c29","b":1}'
		crossorigin="anonymous"></script>


	<script>
		let currentIndex = 0;

		function showNextImage() {
			const images = document.querySelectorAll('.slider-image');
			const totalImages = images.length;

			currentIndex = (currentIndex + 1) % totalImages; // Loop to first image
			document.querySelector('.slider-container').style.transform = `translateX(-${currentIndex * 100}%)`;
		}

		function showPreviousImage() {
			const images = document.querySelectorAll('.slider-image');
			const totalImages = images.length;

			currentIndex = (currentIndex - 1 + totalImages) % totalImages; // Loop to last image
			document.querySelector('.slider-container').style.transform = `translateX(-${currentIndex * 100}%)`;
		}

		setInterval(showNextImage, 3000); // Change image every 3 seconds
	</script>
</body>

<!-- Mirrored from doccure.dreamstechnologies.com/html/template/product-descriptionphp by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 27 Mar 2025 05:01:30 GMT -->

</html>