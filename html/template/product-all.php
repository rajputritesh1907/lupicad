<?php
// Including the database connection file
require_once(__DIR__ . "/backend/ProductTable.inc.php");
require_once(__DIR__ . "/backend/connection.inc.php");
session_start();

$user_id = $_SESSION['user_id'] ?? null;

// Fetch wishlist from the user
if ($user_id) {
	$wishlistQuery = mysqli_query($connection, "SELECT wishlist FROM user WHERE id = $user_id");
} else {
	$wishlistQuery = false;
}

// Decode the wishlist JSON string into a PHP array
if ($wishlistQuery) {	
	$wishlist = mysqli_fetch_assoc($wishlistQuery);
	$wishlistProduct = json_decode($wishlist['wishlist'], true); // Decode JSON into an array
	// echo "<script>console.log('". json_encode($wishlistProduct). "');</script>";
} else {
	$wishlistProduct = []; // Default to an empty array if no wishlist is found
}

// Fetch all products
$filter = isset($_GET['filter']) ? $_GET['filter'] : '';
if (!empty($filter)) {
	$stmt = $connection->prepare("SELECT * FROM producttable WHERE ProductCategories = ? AND ProductAvailability = 1");
	$stmt->bind_param("s", $filter);
	$stmt->execute();
	$ProductTable = $stmt->get_result();
} else {
	$ProductTable = mysqli_query($connection, "SELECT * FROM producttable WHERE ProductAvailability = 1");
}

// Process the results
if ($ProductTable) {
	$products = [];
	while ($row = mysqli_fetch_assoc($ProductTable)) {
		$products[] = $row;
	}
	$allProducts = json_encode(array_map(function ($product) {
		return $product['ProductID'];
	}, $products));
} else {
	$allProducts = json_encode([]); // Default to an empty array if no products are found
}

// Decode $allProducts into an array
$allProducts = json_decode($allProducts, true);

// Get uncommon product IDs
$onlyInAll = array_diff($allProducts ?? [], $wishlistProduct ?? []);
// echo "<script>console.log('onlyInAll:". json_encode($onlyInAll). "');</script>";

//fatch data from productdetailsTable
$ProductDetailsTable = mysqli_query($connection, "SELECT * FROM productdetailstable");
if ($ProductDetailsTable) {
    $productsDetails = [];
    while ($row = mysqli_fetch_assoc($ProductDetailsTable)) {
        $productsDetails[] = $row;
    }
    // echo "<script>console.log('productsDetails: " . json_encode($productsDetails[0]['Quantity'], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP) . "');</script>";
} else {
    $productsDetails = []; // Default to an empty array if no products are found
}
// echo "<script>console.log('productsDetails:". json_encode($productsDetails). "');</script>";
?>


<!DOCTYPE html>
<html lang="en">

<head>

	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Lupicad | Product</title>

	<!-- Favicon -->
	<link rel="shortcut icon" href="assets/lupicad/logo.svg" type="image/x-icon">

	<!-- Apple Touch Icon -->
	<link rel="apple-touch-icon" sizes="180x180" href="assets/img/apple-touch-icon.png">

	<!-- Theme Settings Js -->
	<script src="assets/js/theme-script.js" type="3bafbe4753ecb41c5bac6514-text/javascript"></script>

	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="assets/css/bootstrap.min.css">

	<!-- Fontawesome CSS -->
	<link rel="stylesheet" href="assets/plugins/fontawesome/css/fontawesome.min.css">
	<link rel="stylesheet" href="assets/plugins/fontawesome/css/all.min.css">

	<!-- Iconsax CSS-->
	<link rel="stylesheet" href="assets/css/iconsax.css">

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
		// Function to add product to wishlist
		function addToWishlist(productId) {
			// Send the product ID to the server using AJAX
			$.ajax({
				url: 'wishlist.php', // The backend PHP script to handle the wishlist logic
				type: 'POST',
				data: {
					product_id: productId // Pass the product ID as a query parameter
				},
				success: function(response) {
					console.log(response); // Log the response from the server (success/failure)
					// alert('Product added to wishlist successfully!');
					// Show a toast message
					showToast('Product added to wishlist successfully!', 'success');
					//refresh the page to see the changes after 2 seconds
					setTimeout(function() {
						location.reload();
					}, 800);
				},
				error: function(xhr, status, error) {
					console.error("There was an error adding the product to the wishlist:", error);
					// Show a toast message
					showToast('Failed to add product to wishlist', 'danger');
				}
			});
		}

		// Function to remove product from wishlist
		function deleteToWishlist(productId) {
			// Send the product ID to the server using AJAX
			$.ajax({
				url: 'wishlist.php', // The backend PHP script to handle the wishlist logic
				type: 'POST',
				data: {
					deleteId: productId // Pass the product ID as a query parameter
				},
				success: function(response) {
					console.log(response); // Log the response from the server (success/failure)
					// Show a toast message
					showToast('Product removed from wishlist successfully!', 'success');
					//refresh the page to see the changes after 2 seconds
					setTimeout(function() {
						location.reload();
					}, 800);
				},
				error: function(xhr, status, error) {
					console.error("There was an error removing the product from the wishlist:", error);
					// alert('Failed to remove product from wishlist');
					// Show a toast message
					showToast('Failed to remove product from wishlist', 'danger');
				}
			});
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
								<li class="breadcrumb-item">
									<a href="index.php">
										<i class="isax isax-home-15">
										</i>
									</a>
								</li>
								<li class="breadcrumb-item" aria-current="page">Home</li>
								<li class="breadcrumb-item active">Product</li>
							</ol>
							<h2 class="breadcrumb-title">Product</h2>
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
					<div class="col-md-4 col-lg-3 col-xl-3 theiaStickySidebar">

						<!-- Search Filter -->
						<div class="card search-filter">
							<div class="card-header">
								<h4 class="card-title mb-0">Filter</h4>
							</div>
							<div class="card-body">
								<!-- <div class="filter-widget">
									<div class="cal-icon">
										<input type="text" class="form-control datetimepicker" placeholder="Select Date">
									</div>			
								</div> -->
								<div class="filter-widget">
									<h4>Categories</h4>
									<form action="">
										<div>
											<label class="custom_check">
												<input type="checkbox" name="filter" value="Hygiene">
												<span class="checkmark"></span> Immunity & Hygiene
											</label>
										</div>
										<div>
											<label class="custom_check">
												<input type="checkbox" name="filter" value="Skin">
												<span class="checkmark"></span> Skin Care
											</label>
										</div>
										<div>
											<label class="custom_check">
												<input type="checkbox" name="filter" value="Hair">
												<span class="checkmark"></span> Hair Care
											</label>
										</div>
										<div>
											<label class="custom_check">
												<input type="checkbox" name="filter" value="male">
												<span class="checkmark"></span> Men's Care
											</label>
										</div>
										<div>
											<label class="custom_check">
												<input type="checkbox" name="filter" value="female">
												<span class="checkmark"></span> Women's Care
											</label>
										</div>
										<div>
											<label class="custom_check">
												<input type="checkbox" name="filter" value="Breathing">
												<span class="checkmark"></span> Breathing Problem
											</label>
										</div>
										<div>
											<label class="custom_check">
												<input type="checkbox" name="filter" value="Body">
												<span class="checkmark"></span>Body & Joint Pain
											</label>
										</div>
										<div>
											<label class="custom_check">
												<input type="checkbox" name="filter" value="Headache">
												<span class="checkmark"></span>Headache & Migrain
											</label>
										</div>
								</div>
								<div class="btn-search">
									<button type="submit" class="btn w-100">Search</button>
								</div>
							</div>
							</form>
						</div>
						<!-- /Search Filter -->

					</div>

					<div class="	col-md-8 col-lg-9 col-xl-9">

						<div class="row align-items-center pb-3">
							<div class="col-md-4 col-12 d-md-block d-none custom-short-by">
								<h3 class="title pharmacy-title fs-24 mb-2">Lupicad</h3>
								<p class="doc-location mb-2 text-ellipse pharmacy-location"><i
										class="isax isax-location5 me-1"></i> Delhi </p>
								<!-- <span class="sort-title"> </span> -->
							</div>
							<div class="col-md-8 col-12 d-md-block d-none custom-short-by">
								<!-- <div class="sort-by pb-3">
									<span class="sort-title" style="color: black;">Sort by</span>
									<span class="sortby-fliter">
										<select class="form-select">
											<option>Select</option>
											<option class="sorting">Rating</option>
											<option class="sorting">Popular</option>
											<option class="sorting">Latest</option>
											<option class="sorting">Free</option>
										</select>
									</span>
								</div>
							</div> -->
						</div>

						<div class="row">


							<?php

							for ($i = 0; $i < count($products); $i++) {
								$product = $products[$i];
								$productImages = json_decode($product['ProductImage'], true);

								// Ensure the decoding was successful and the array is not empty
								if (is_array($productImages) && count($productImages) > 0) {
									$mainImage = $productImages[0];
									$hoverImage = isset($productImages[1]) ? $productImages[1] : $productImages[0];
								} else {
									$mainImage = 'default-image.jpg';
									$hoverImage = 'default-image.jpg';
								}

								//make a foreachloop to compose the $product['ProductID'] between $ProductTable and $wishlistQuery and consol the left product_id
								echo "<script>console.log('" . $product['ProductID'] . "');</script>";

							?>
								<div class="col-sm-6 col-xs-6 col-md-6 col-lg-3 col-xl-3 product-custom d-flex">
									<div class="card" style="width:100%;">
										<div class="card-img card-img-hover">
											<div class="image-container">
												<a href="product-description.php?id=<?= $product['ProductID'] ?>">
													<center><img src="./uploads/<?= $mainImage ?>" id="img-1" alt="product image" style="width:auto; height:180px !important;"></center>
												</a>
												<a href="product-description.php?id=<?= $product['ProductID'] ?>">
													<img src="./uploads/<?= $hoverImage ?>" id="img-2" alt="product image" style="width:100%; height:180px !important" ;>
												</a>
											</div>
											<div
												class="grid-overlay-item d-flex align-items-center justify-content-between">
												<span class="badge bg-orange" style="opacity: 0;"><i
														class="fa-solid fa-star me-1"></i><?= $product['ProductRating'] ?>
												</span>

												<a href="javascript:void(0)"
													class="fav-icon"
													style="box-shadow:0px 0px 5px -1px rgba(0, 0, 0, 0.35) ;"
												<?php if (!in_array($product['ProductID'], $onlyInAll)) { ?>
													onclick="deleteToWishlist(<?= $product['ProductID'] ?>)">
													<i class="fa fa-heart" style="color: #fc3340 !important;"></i>
												<?php } else { ?>
													onclick="addToWishlist(<?= $product['ProductID'] ?>)">
													<i class="fa fa-heart"></i>
												<?php } ?>
												</a>
											</div>
										</div>
										<div class="card-body p-0">
											<div class="d-flex active-bar align-items-center justify-content-between p-3">
												<a href="javascript:void(0)"
													class="text-indigo fw-medium fs-14"><?= $product['ProductCategories'] ?></a>

												<span class="badge d-inline-flex align-items-center hidden-sm"
													style="color: white;font-size:10px !important;background-color: <?= $productsDetails[$i]['Quantity'] ? 'green' : 'red' ?>; ">
													<i class="fa-solid fa-circle fs-5 me-1"></i>
													<?= $productsDetails[$i]['Quantity'] ? 'Available' : 'Out of Stock' ?>
												</span>
											</div>
											<div class="p-3 pt-0">
												<div class=" mb-1 pb-1">
													<h6 class="mb-1">
														<a
															href="product-description.php?id=<?= $product['ProductID'] ?>"><?= $product['ProductName'] ?></a>
												</h6>
												</div>
												<div class="d-flex align-items-center justify-content-between">
													<div>
														<h3 class="text-orange">
															<span
																class="woocommerce-Price-currencySymbol">₹</span><?= $product['ProductPrice'] ?>
														</h3>
													</div>
													<a href="./cart.php?product_id=<?= $product['ProductID'] ?>&Quentity=1"
														class="cart-icon">
														<i class="fas fa-shopping-cart"></i>
													</a>
												</div>
												<div>
													<center>
														<a href="product-description.php?id=<?= $product['ProductID'] ?>"
														class="btn btn-md btn-dark d-inline-flex align-items-center rounded-pill"
														style="background-color: #d3a02e !important; border: none;font-size:14px!important; margin-top: 10px;">
														<center>Buy Now</center> 
													</a>
													</center>
												</div>
											</div>
										</div>
									</div>
								</div>
							<?php
							}
							?>


						</div>
						<div class="col-md-12 text-center">
							<a href="#" class="btn book-btn1 mb-4">Load More</a>
						</div>
					</div>
				</div>
			</div>
		</div>


		<!-- Footer Section -->
		<?php require_once(__DIR__ . "/components/footer.php") ?>
		<!-- /Footer Section -->

	</div>
	<!-- /Main Wrapper -->

	<!-- jQuery -->
	<script src="assets/js/jquery-3.7.1.min.js" type="3bafbe4753ecb41c5bac6514-text/javascript"></script>

	<!-- Bootstrap Core JS -->
	<script src="assets/js/bootstrap.bundle.min.js" type="3bafbe4753ecb41c5bac6514-text/javascript"></script>

	<!-- Sticky Sidebar JS -->
	<script src="assets/plugins/theia-sticky-sidebar/ResizeSensor.js"
		type="3bafbe4753ecb41c5bac6514-text/javascript"></script>
	<script src="assets/plugins/theia-sticky-sidebar/theia-sticky-sidebar.js"
		type="3bafbe4753ecb41c5bac6514-text/javascript"></script>

	<!-- Select2 JS -->
	<script src="assets/plugins/select2/js/select2.min.js" type="3bafbe4753ecb41c5bac6514-text/javascript"></script>

	<!-- Datetimepicker JS -->
	<script src="assets/js/moment.min.js" type="3bafbe4753ecb41c5bac6514-text/javascript"></script>
	<script src="assets/js/bootstrap-datetimepicker.min.js" type="3bafbe4753ecb41c5bac6514-text/javascript"></script>

	<!-- Fancybox JS -->
	<script src="assets/plugins/fancybox/jquery.fancybox.min.js"
		type="3bafbe4753ecb41c5bac6514-text/javascript"></script>

	<!-- Custom JS -->
	<script src="assets/js/script.js" type="3bafbe4753ecb41c5bac6514-text/javascript"></script>

	<script src="../../cdn-cgi/scripts/7d0fa10a/cloudflare-static/rocket-loader.min.js"
		data-cf-settings="3bafbe4753ecb41c5bac6514-|49" defer></script>
	<script defer
		src="https://static.cloudflareinsights.com/beacon.min.js/vcd15cbe7772f49c399c6a5babf22c1241717689176015"
		integrity="sha512-ZpsOmlRQV6y907TI0dKBHq9Md29nnaEIPlkf84rnaERnq6zvWvPUqr2ft8M1aS28oN72PdrCzSjY4U6VaAw1EQ=="
		data-cf-beacon='{"rayId":"926c47deddc159d6","version":"2025.1.0","serverTiming":{"name":{"cfExtPri":true,"cfL4":true,"cfSpeedBrain":true,"cfCacheStatus":true}},"token":"3ca157e612a14eccbb30cf6db6691c29","b":1}'
		crossorigin="anonymous"></script>
</body>

</html>