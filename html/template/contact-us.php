<?php
require_once(__DIR__ . "/backend/connection.inc.php");
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
	$name = trim($_POST['name'] ?? '');
	$email = trim($_POST['email'] ?? '');
	$phone = trim($_POST['phone'] ?? '');
	$category = trim($_POST['category'] ?? '');
	$message = trim($_POST['message'] ?? '');

	// Simple validation
	if ($name && $email && $phone && $category && $message) {
		$stmt = $connection->prepare("INSERT INTO contactusform (name, email, phone, category, message, created_at) VALUES (?, ?, ?, ?, ?, NOW())");
		$stmt->bind_param("sssss", $name, $email, $phone, $category, $message);
		if ($stmt->execute()) {
			echo "<script>showToast('Message sent successfully','success');</script>";
		} else {
			echo "<script>showToast('Failed to send your message. Please try again.','danger');</script>";
		}
		$stmt->close();
	} else {
		echo "<script>showToast('Please fill all fields.','danger');</script>";
	}
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">

	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Lupicad | Contact Us</title>

	<!-- Favicon -->
	<link rel="shortcut icon" href="assets/lupicad/logo.svg" type="image/x-icon">
	<!-- Apple Touch Icon -->
	<link rel="apple-touch-icon" sizes="180x180" href="assets/img/apple-touch-icon.png">

	<!-- Theme Settings Js -->
	<script src="assets/js/theme-script.js" type="755ddedf643f8644d468771a-text/javascript"></script>

	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="assets/css/bootstrap.min.css">

	<!-- Fontawesome CSS -->
	<link rel="stylesheet" href="assets/plugins/fontawesome/css/fontawesome.min.css">
	<link rel="stylesheet" href="assets/plugins/fontawesome/css/all.min.css">

	<!-- Iconsax CSS-->
	<link rel="stylesheet" href="assets/css/iconsax.css">

	<!-- Feathericon CSS -->
	<link rel="stylesheet" href="assets/css/feather.css">

	<!-- Daterangepikcer CSS -->
	<link rel="stylesheet" href="assets/plugins/daterangepicker/daterangepicker.css">

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
								<li class="breadcrumb-item active">Contact Us</li>
							</ol>
							<h2 class="breadcrumb-title">Contact Us</h2>
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

		<!-- Contact Us -->
		<section class="contact-section">
			<div class="container">
				<div class="row">
					<div class="col-lg-5 col-md-12">
						<div class="section-inner-header contact-inner-header">
							<h6>Get in touch</h6>
							<h2>Have Any Question?</h2>
						</div>
						<div class="card contact-card">
							<div class="card-body">
								<div class="contact-icon">
									<i class="isax isax-location5"></i>
								</div>
								<div class="contact-details">
									<h4>Address</h4>
									<p>Central Delhi, Delhi 110002, Delhi, India</p>
								</div>
							</div>
						</div>
						<div class="card contact-card">
							<div class="card-body">
								<div class="contact-icon">
									<i class="isax isax-call5"></i>
								</div>
								<div class="contact-details">
									<h4>Phone Number</h4>
									<a href="tel:+918744997776">
										<p>+91 8744997776</p>
									</a>
								</div>
							</div>
						</div>
						<div class="card contact-card">
							<div class="card-body">
								<div class="contact-icon">
									<i class="isax isax-sms5"></i>
								</div>
								<div class="contact-details">
									<h4>Email Address</h4>
									<p><a class="__cf_email__" href="mailto:digiwebpower@gmail.com">digiwebpower@gmail.com</a></p>
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-7 col-md-12 d-flex">
						<div class="card contact-form-card w-100">
							<div class="card-body">
								<form action="" method="POST" id="contactForm">
									<div class="row">
										<div class="col-md-6">
											<div class="mb-3">
												<label class="form-label">Name</label>
												<input type="text" name="name" class="form-control" required>
											</div>
										</div>
										<div class="col-md-6">
											<div class="mb-3">
												<label class="form-label">Email</label>
												<input type="email" name="email" class="form-control" required>
											</div>
										</div>
										<div class="col-md-6">
											<div class="mb-3">
												<label class="form-label">Phone Number</label>
												<input type="text" name="phone" class="form-control" required>
											</div>
										</div>
										<div class="col-md-6">
											<div class="mb-3">
												<label class="form-label">Category</label>
												<select name="category" class="form-control" required>
													<option value="">Select</option>
													<option value="Issue">Issue</option>
													<option value="Query">Query</option>
												</select>
											</div>
										</div>
										<div class="col-md-12">
											<div class="mb-3">
												<label class="form-label">Message</label>
												<textarea class="form-control" name="message" rows="6" required></textarea>
											</div>
										</div>
										<div class="col-md-12">
											<div class="form-group-btn mb-0">
												<button type="submit" class="btn btn-primary-gradient" name="submit">Send Message</button>
											</div>
										</div>
									</div>
								</form>

							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
		<!-- /Contact Us -->

		<!-- Contact Map -->
		<div class="contact-map d-flex">
			<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d18199.2374904444!2d77.23065983562483!3d28.64071953284198!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x390ce32b7a826101%3A0xe498753a23c80124!2sNew%20Delhi%2C%20Delhi%20110002!5e0!3m2!1sen!2sin!4v1743234168045!5m2!1sen!2sin" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
		</div>
		<!-- /Contact Map -->

		<!-- Footer Section -->
		<?php require_once(__DIR__ . "/components/footer.php") ?>
		<!-- /Footer Section -->

	</div>
	<!-- /Main Wrapper -->

	<!-- jQuery -->
	<script data-cfasync="false" src="../../cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>
	<script src="assets/js/jquery-3.7.1.min.js" type="755ddedf643f8644d468771a-text/javascript"></script>

	<!-- Bootstrap Core JS -->
	<script src="assets/js/bootstrap.bundle.min.js" type="755ddedf643f8644d468771a-text/javascript"></script>

	<!-- Daterangepikcer JS -->
	<script src="assets/js/moment.min.js" type="755ddedf643f8644d468771a-text/javascript"></script>
	<script src="assets/plugins/daterangepicker/daterangepicker.js" type="755ddedf643f8644d468771a-text/javascript"></script>

	<!-- Custom JS -->
	<script src="assets/js/script.js" type="755ddedf643f8644d468771a-text/javascript"></script>

	<script src="../../cdn-cgi/scripts/7d0fa10a/cloudflare-static/rocket-loader.min.js" data-cf-settings="755ddedf643f8644d468771a-|49" defer></script>
	<script defer src="https://static.cloudflareinsights.com/beacon.min.js/vcd15cbe7772f49c399c6a5babf22c1241717689176015" integrity="sha512-ZpsOmlRQV6y907TI0dKBHq9Md29nnaEIPlkf84rnaERnq6zvWvPUqr2ft8M1aS28oN72PdrCzSjY4U6VaAw1EQ==" data-cf-beacon='{"rayId":"926c47e87dd459d6","version":"2025.1.0","serverTiming":{"name":{"cfExtPri":true,"cfL4":true,"cfSpeedBrain":true,"cfCacheStatus":true}},"token":"3ca157e612a14eccbb30cf6db6691c29","b":1}' crossorigin="anonymous"></script>
</body>

</html>