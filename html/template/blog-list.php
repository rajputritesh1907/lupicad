<?php
require_once(__DIR__ . "/backend/connection.inc.php");
require_once(__DIR__ . "/backend/function.inc.php");

session_start();

$user_id = $_SESSION['user_id'] ?? null;

// Fetch blogs from the database
try {
	$result = $connection->query("SELECT * FROM blogs ORDER BY created_at DESC");

	if (!$result) {
		throw new Exception("Error fetching blogs: " . $connection->error);
	}

	$blogs = $result->fetch_all(MYSQLI_ASSOC); // Fetch all blogs as an associative array
} catch (Exception $e) {
	$blogs = null; // Set blogs to null if there's an error
	$error_message = $e->getMessage(); // Capture the error message
}
?>
<!DOCTYPE html>

<html lang="en"> 

<head>

	<meta charset="utf-8">

	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Lupicad | Blog List</title>

	<!-- Favicon -->
	<link rel="shortcut icon" href="assets/lupicad/logo.svg" type="image/x-icon">

	<!-- Apple Touch Icon -->
	<link rel="apple-touch-icon" sizes="180x180" href="assets/img/apple-touch-icon.png">

	<!-- Theme Settings Js -->
	<script src="assets/js/theme-script.js" type="4b716ade7c335c7b34c45bb7-text/javascript"></script>

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
								<li class="breadcrumb-item"><a href="index.php"><i class="isax isax-home-15"></i></a>
								</li>
								<li class="breadcrumb-item">Blogs</li>
								<li class="breadcrumb-item active">Blog List</li>
							</ol>
							<h2 class="breadcrumb-title">Blog List</h2>
						</nav>
					</div>
				</div>
			</div>

			<!-- /Breadcrumb -->

			<!-- Page Content -->
			<div class="content">
				<div class="container">

					<div class="row">

						<div class="col-lg-8 col-md-12">
							<?php if (isset($error_message)): ?>
								<!-- Show error message -->
								<div class="alert alert-danger">
									<strong>Error:</strong> <?= htmlspecialchars($error_message) ?>
								</div>
							<?php elseif (empty($blogs)): ?>
								<!-- Show "No blogs available" message -->
								<div class="alert alert-warning">
									<strong>No Blogs Available:</strong> There are currently no blogs to display.
								</div>
							<?php else: ?>
								<!-- Show blogs -->
								<?php foreach ($blogs as $row): ?>
									<ul>
										<li>
											<div class="blog" >
												<div class="blog-image" style="height:75vh;" >
													<a href="blog-details.php?id=<?= htmlspecialchars($row['id']) ?>">
														<img alt="blog-image" src="uploads/<?= htmlspecialchars($row['image']) ?>" class="img-fluid" style="height:80vh !important;" >
													</a>
													<span class="badge badge-cyan category-slug"><?= htmlspecialchars($row['healthcategory']) ?></span>
												</div>
												<div class="blog-content">
													<ul class="entry-meta meta-item">
														<li>
															<div class="post-author">
																<a href="javascript:void(0);">
																	<span><?= htmlspecialchars($row['blogername']) ?></span>
																</a>
															</div>
														</li>
														<li><i class="isax isax-calendar-1 me-1"></i><?= date("d M Y", strtotime($row['created_at'])) ?></li>
													</ul>
													<h3 class="blog-title">
														<a href="blog-details.php?id=<?= htmlspecialchars($row['id']) ?>"><?= htmlspecialchars($row['heading']) ?></a>
													</h3>
													<p class="mb-0"><?= nl2br(htmlspecialchars($row['paragraph2'])) ?></p>
												</div>
											</div>
										</li>
									</ul>
								<?php endforeach; ?>
							<?php endif; ?>
						</div>

						<!-- Blog Sidebar -->
						<div class="col-lg-4 col-md-12 sidebar-right theiaStickySidebar">

							<!-- Search -->
							<!--<div class="card search-widget">-->
							<!--	<div class="card-body">-->
							<!--		<form class="search-form">-->
							<!--			<div class="input-group">-->
							<!--				<input type="text" placeholder="Search..." class="form-control">-->
							<!--				<button type="submit" class="btn btn-primary"><i class="isax isax-search-normal"></i></button>-->
							<!--			</div>-->
							<!--		</form>-->
							<!--	</div>-->
							<!--</div>-->
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
									    <?php foreach ($blogs as $row): ?>
										<li>
											<div class="post-thumb">
												<a href="blog-details.php?id=<?= htmlspecialchars($row['id']) ?>">
													<img class="img-fluid" src="uploads/<?= htmlspecialchars($row['image']) ?>" alt="<?= htmlspecialchars($row['blogername']) ?>">
												</a>
											</div>
											<div class="post-info">
												<p><?= date("d M Y", strtotime($row['created_at'])) ?></p>
												<h4>
												   <a href="blog-details.php?id=<?= htmlspecialchars($row['id']) ?>"><?= htmlspecialchars($row['heading']) ?></a>
												</h4>
											</div>
										</li> 
									<?php endforeach; ?>
									
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
	<script src="assets/js/jquery-3.7.1.min.js" type="4b716ade7c335c7b34c45bb7-text/javascript"></script>

	<!-- Bootstrap Core JS -->
	<script src="assets/js/bootstrap.bundle.min.js" type="4b716ade7c335c7b34c45bb7-text/javascript"></script>

	<!-- Sticky Sidebar JS -->
	<script src="assets/plugins/theia-sticky-sidebar/ResizeSensor.js"
		type="4b716ade7c335c7b34c45bb7-text/javascript"></script>
	<script src="assets/plugins/theia-sticky-sidebar/theia-sticky-sidebar.js"
		type="4b716ade7c335c7b34c45bb7-text/javascript"></script>

	<!-- Custom JS -->
	<script src="assets/js/script.js" type="4b716ade7c335c7b34c45bb7-text/javascript"></script>

	<script src="../../cdn-cgi/scripts/7d0fa10a/cloudflare-static/rocket-loader.min.js"
		data-cf-settings="4b716ade7c335c7b34c45bb7-|49" defer></script>
	<script defer
		src="https://static.cloudflareinsights.com/beacon.min.js/vcd15cbe7772f49c399c6a5babf22c1241717689176015"
		integrity="sha512-ZpsOmlRQV6y907TI0dKBHq9Md29nnaEIPlkf84rnaERnq6zvWvPUqr2ft8M1aS28oN72PdrCzSjY4U6VaAw1EQ=="
		data-cf-beacon='{"rayId":"926c480b4cda91a3","version":"2025.1.0","serverTiming":{"name":{"cfExtPri":true,"cfL4":true,"cfSpeedBrain":true,"cfCacheStatus":true}},"token":"3ca157e612a14eccbb30cf6db6691c29","b":1}'
		crossorigin="anonymous"></script>
</body>

</html>