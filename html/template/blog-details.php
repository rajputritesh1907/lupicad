<?php
require_once(__DIR__ . "/backend/connection.inc.php");

session_start();
$user_id = $_SESSION['user_id'] ?? null;

try {
	if (isset($_GET['id'])) {
		$id = $_GET['id'];
		// Fetch the blog details from the database
		$sql = "SELECT * FROM blogs WHERE id = ?";
		$stmt = $connection->prepare($sql);
		$stmt->bind_param("i", $id);
		$stmt->execute();
		$result = $stmt->get_result();
		if ($result->num_rows > 0) {
			$blog = $result->fetch_assoc();
		} else {
			throw new Exception("Blog not found");
		}
	} else {
		throw new Exception("ID not provided");
	}
} catch (Exception $e) {
	echo "<script>console.error('Error: " . $e->getMessage() . "');</script>";
}


?>
<!DOCTYPE html>
<html lang="en">
 

<head>

	<meta charset="utf-8">

	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<title>Lupicad | Blog Details</title>

	<!-- Favicon -->
	<link rel="shortcut icon" href="assets/lupicad/logo.svg" type="image/x-icon">

	<!-- Apple Touch Icon -->
	<link rel="apple-touch-icon" sizes="180x180" href="assets/img/apple-touch-icon.png">

	<!-- Theme Settings Js -->
	<script src="assets/js/theme-script.js" type="12f7ea3de72baecd62d5da7d-text/javascript"></script>

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
								<li class="breadcrumb-item">Blogs</li>
								<li class="breadcrumb-item active">Blog Details</li>
							</ol>
							<h2 class="breadcrumb-title">Blog Details</h2>
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
					<div class="col-lg-8 col-md-12">
						<div class="blog-view">
							<?php if (!empty($blog)): ?>
								<h3 class="mb-3"><?= htmlspecialchars($blog['heading']) ?></h3>

								<div class="blog blog-single-post">
									<div class="blog-image">
										<a href="javascript:void(0);">
											<img alt="blog-image" src="uploads/<?= htmlspecialchars($blog['image']) ?>" class="img-fluid">
										</a>
									</div>

									<div class="blog-info d-md-flex align-items-center justify-content-between flex-wrap">
										<div class="post-left">
											<ul>
												<li><span class="badge badge-dark fs-14 fw-medium"><?= htmlspecialchars($blog['healthcategory']) ?></span></li>
												<li><i class="isax isax-calendar"></i> <?= date('F j, Y', strtotime($blog['created_at'])) ?></li>
											</ul>
										</div>
									</div>

									<div class="blog-content">
										<p><?= nl2br(htmlspecialchars($blog['paragraph1'])) ?></p>
										<p class="content-block"><?= nl2br(htmlspecialchars($blog['paragraph2'])) ?></p>
									</div>
								</div>

								<h4 class="mb-3">Tags</h4>
								<?php
								$tags = explode(',', $blog['tags']);
								foreach ($tags as $tag) {
									echo '<a href="javascript:void(0);" class="badge badge-dark fs-14 fw-medium ">' . htmlspecialchars(trim($tag)) . '</a> ';
								}
								?>
							<?php else: ?>
								<div class="alert alert-warning">
									<strong>Blog is not available.</strong>
								</div>
							<?php endif; ?> 
						</div>
					</div>

					<!-- Blog Sidebar -->
					<div class="col-lg-4 col-md-12 sidebar-right theiaStickySidebar">

						<!-- Search -->
						<div class="card search-widget">
							<div class="card-body">
								<form class="search-form">
									<div class="input-group">
										<input type="text" placeholder="Search..." class="form-control">
										<button type="submit" class="btn btn-primary"><i class="isax isax-search-normal"></i></button>
									</div>
								</form>
							</div>
						</div>
						<!-- /Search -->

						<!-- Categories -->
						<div class="card category-widget">
							<div class="card-body">
								<h5 class="mb-3">Categories</h5>
								<ul class="categories">
									<li><a href="#">Men Health<span>(9)</span></a></li>
									<li><a href="#">Female Health<span>(7)</span></a></li>
									<li><a href="#">Health Tips <span>(5)</span></a></li>
									<li><a href="#">Medical Research <span>(11)</span></a></li>
									<li><a href="#">Hair Care<span>(21)</span></a></li>
									<li><a href="#">Skin Care<span>(14)</span></a></li>
									<li><a href="#">Body & Joint Pain<span>(4)</span></a></li>
									<li><a href="#">Breathing Problem<span>(9)</span></a></li>
								</ul>
							</div>
						</div>
						<!-- /Categories -->

						<!-- Latest Posts -->
						<div class="card post-widget">
							<div class="card-body">
								<h5 class="mb-3">Latest News</h5>
								<ul class="latest-posts">
									<li>
										<div class="post-thumb">
											<a href="blog-details.php">
												<img class="img-fluid" src="assets/img/blog/blog-thumb-11.jpg" alt="blog-image">
											</a>
										</div>
										<div class="post-info">
											<p>March 5, 2025</p>
											<h4>
												<a href="blog-details.php">Customer Success Stories: Real Transformations</a>
											</h4>
										</div>
									</li>
									<li>
										<div class="post-thumb">
											<a href="blog-details.php">
												<img class="img-fluid" src="assets/lupicad/1.png" alt="blog-image">
											</a>
										</div>
										<div class="post-info">
											<p>15 Nov 2024</p>
											<h4>
												<a href="blog-details.php">New Research on Wellness and Vitality</a>
											</h4>
										</div>
									</li>
									<li>
										<div class="post-thumb">
											<a href="blog-details.php">
												<img class="img-fluid" src="assets/img/blog/blog-thumb-13.jpg" alt="blog-image">
											</a>
										</div>
										<div class="post-info">
											<p>March 25, 2025</p>
											<h4>
												<a href="blog-details.php">Lupicad Launches New Wellness Formula</a>
											</h4>
										</div>
									</li>
									<li>
										<div class="post-thumb">
											<a href="blog-details.php">
												<img class="img-fluid" src="assets/img/blog/blog-thumb-14.jpg" alt="blog-image">
											</a>
										</div>
										<div class="post-info">
											<p>17 Dec 2024</p>
											<h4>
												<a href="blog-details.php">Top Preventive Health Measures Everyone Should Take</a>
											</h4>
										</div>
									</li>
								</ul>
							</div>
						</div>
						<!-- /Latest Posts -->

						<!-- Tags -->
						<div class="card tags-widget">
							<div class="card-body">
								<h5 class="mb-3">Tags</h5>
								<ul class="tags">
									<li><a href="#" class="tag">Sexual Wellness</a></li>
									<li><a href="#" class="tag">Men's Health</a></li>
									<li><a href="#" class="tag">Intimacy Care</a></li>
									<li><a href="#" class="tag">Performance Boost</a></li>
									<li><a href="#" class="tag">Natural Remedies</a></li>
									<li><a href="#" class="tag">Hormonal Balance</a></li>
									<li><a href="#" class="tag">Self-Care</a></li>
									<li><a href="#" class="tag">Relationship Wellness</a></li>
									<li><a href="#" class="tag">Vitality</a></li>
								</ul>
							</div>
						</div>
						<!-- /Tags -->


					</div>
					<!-- /Blog Sidebar -->

				</div>
			</div>

		</div>
		<!-- /Page Content -->

		<!-- Footer Section -->
		<?php require_once(__DIR__ . "/components/footer.php") ?>
		<!-- /Footer Section -->

	</div>
	<!-- /Main Wrapper -->

	<!-- jQuery -->
	<script src="assets/js/jquery-3.7.1.min.js" type="12f7ea3de72baecd62d5da7d-text/javascript"></script>

	<!-- Bootstrap Core JS -->
	<script src="assets/js/bootstrap.bundle.min.js" type="12f7ea3de72baecd62d5da7d-text/javascript"></script>

	<!-- Sticky Sidebar JS -->
	<script src="assets/plugins/theia-sticky-sidebar/ResizeSensor.js" type="12f7ea3de72baecd62d5da7d-text/javascript"></script>
	<script src="assets/plugins/theia-sticky-sidebar/theia-sticky-sidebar.js" type="12f7ea3de72baecd62d5da7d-text/javascript"></script>

	<!-- Custom JS -->
	<script src="assets/js/script.js" type="12f7ea3de72baecd62d5da7d-text/javascript"></script>

	<script src="../../cdn-cgi/scripts/7d0fa10a/cloudflare-static/rocket-loader.min.js" data-cf-settings="12f7ea3de72baecd62d5da7d-|49" defer></script>
	<script defer src="https://static.cloudflareinsights.com/beacon.min.js/vcd15cbe7772f49c399c6a5babf22c1241717689176015" integrity="sha512-ZpsOmlRQV6y907TI0dKBHq9Md29nnaEIPlkf84rnaERnq6zvWvPUqr2ft8M1aS28oN72PdrCzSjY4U6VaAw1EQ==" data-cf-beacon='{"rayId":"926c47c00ace91a3","version":"2025.1.0","serverTiming":{"name":{"cfExtPri":true,"cfL4":true,"cfSpeedBrain":true,"cfCacheStatus":true}},"token":"3ca157e612a14eccbb30cf6db6691c29","b":1}' crossorigin="anonymous"></script>
</body>
 

</html>