<!DOCTYPE html>
<html lang="en">
	

<head>

		<meta charset="UTF-8">
		
		<title>Lupicad | Payment</title>
		
		<!-- Favicon -->
		<link rel="shortcut icon" href="assets/lupicad/logo.svg" type="image/x-icon">

		<!-- Apple Touch Icon -->
		<link rel="apple-touch-icon" sizes="180x180" href="assets/img/apple-touch-icon.png">
		
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
			
			<!-- Page Content -->
			<div class="doctor-content">
				<div class="container">

					<!-- Payment -->
					<div class="row">
						<div class="col-md-12">
							<div class="back-link">
								<a href="consultation.php"><i class="fa-solid fa-arrow-left-long"></i> Back</a>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-8 col-md-12">
							<div class="paitent-header">
								<h4 class="paitent-title">Payment</h4>
							</div>
							<div class="booking-header">
								<h4 class="booking-title">Payments Methods</h4>
							</div>
							<div class="payments-form">
								<form action="https://doccure.dreamstechnologies.com/html/template/booking-success-one.php">
									<div class="payment-mb-3">
										<div class="mb-3">
											<label class="custom_radio">
												<input type="radio" name="payment" checked="">
												<span class="checkmark"></span> Debit or Credit Card
											</label>
										</div>
										<div class="mb-3 card-label">
											<label class="mb-2">Name on Card</label>
											<input type="text" class="form-control" placeholder="John Smith">
										</div>
										<div class="mb-3 card-label">
											<label class="mb-2">Card Number</label>
											<input type="text" class="form-control" placeholder="xxxx-xxxx-xxxx-xxxx">
										</div>
										<div class="row">
											<div class="col-md-4">
												<div class="mb-3 card-label">
													<label class="mb-2">Expiry Month</label>
													<input type="text" class="form-control" placeholder="MM">
												</div>
											</div>
											<div class="col-md-4">
												<div class="mb-3 card-label">
													<label class="mb-2">Expiry Year</label>
													<input type="text" class="form-control" placeholder="YYYY">
												</div>
											</div>
											<div class="col-md-4">
												<div class="mb-3 card-label">
													<label class="mb-2">CVV</label>
													<input type="text" class="form-control" placeholder="****">
												</div>
											</div>
										</div>
									</div>
									<div class="payment-mb-3">
										<div class="mb-3">
											<label class="custom_radio">
												<input type="radio" name="payment">
												<span class="checkmark"></span> Paypal
											</label>
										</div>
										<div class="mb-3">
											<label class="custom_radio">
												<input type="radio" name="payment">
												<span class="checkmark"></span> Cash on Visit
											</label>
										</div>
										<div class="mb-3">
											<label class="custom_radio">
												<input type="radio" name="payment">
												<span class="checkmark"></span> Bank Transfer
											</label>
										</div>
										<div class="mb-3">
											<label class="custom_radio">
												<input type="radio" name="payment">
												<span class="checkmark"></span> UPI
											</label>
										</div>
									</div>
									<div class="mb-3 mb-0">
										<div class="booking-btn">
											<button type="submit" class="btn btn-primary prime-btn justify-content-center align-items-center">
												Next <i class="feather-arrow-right-circle"></i>
											</button>
										</div>
									</div>
								</form>
							</div>
						</div>
						<div class="col-lg-4 col-md-12">
							<div class="booking-header">
								<h4 class="booking-title">Booking Summary</h4>
							</div>
							<div class="card booking-card">
								<div class="card-body booking-card-body">
									<div class="booking-doctor-details">
										<div class="booking-doctor-left">
											<div class="booking-doctor-img">
												<a href="doctor-profile.php">
													<img src="assets/img/doctors/doctor-02.jpg" alt="John Doe">
												</a>
											</div>
											<div class="booking-doctor-info">
												<h4><a href="doctor-profile.php">Dr. John Doe</a></h4>
												<p>MBBS, Dentist</p>
											</div>
										</div>
										<div class="booking-doctor-right">
											<p>
												<i class="fas fa-circle-check"></i>
												<a href="doctor-profile-settings.php">Edit</a>
											</p>
										</div>
									</div>
								</div>
							</div>
							<div class="card booking-card">
								<div class="card-body booking-card-body booking-list-body">
									<div class="booking-list">
										<div class="booking-date-list">
											<ul>
												<li>Booking Date: <span>Sun, 30 Aug 2023</span></li>
												<li>Booking Time: <span>10.00AM to 11:00AM</span></li>
											</ul>
										</div>
										<div class="booking-doctor-right">
											<p>
												<a href="booking.php">Edit</a>
											</p>
										</div>
									</div>
									<div class="booking-list">
										<div class="booking-date-list">
											<ul>
												<li>Consultation Type: <span><i class="feather-video"></i> Video Consulting</span></li>
											</ul>
										</div>
										<div class="booking-doctor-right">
											<p>
												<a href="consultation.php">Edit</a>
											</p>
										</div>
									</div>
								</div>
							</div>
							<div class="card booking-card">
								<div class="card-body booking-card-body booking-list-body">
									<div class="booking-list">
										<div class="booking-date-list consultation-date-list">
											<ul>
												<li>Consultation Fee: <span>$150.00</span></li>
												<li>Booking Fee: <span>$8.00</span></li>
												<li>Tax: <span>$5.00</span></li>
												<li><span class="total-amount"></span>Total <span>$163.00</span></li>
											</ul>
										</div>
									</div>
								</div>
							</div>
							<div class="booking-btn proceed-btn">
								<a href="booking-success-one.php" class="btn btn-primary prime-btn">
									Proceed to Pay $163.00
								</a>
							</div>
						</div>
					</div>
					<!-- /Payment -->

				</div>
			</div>		
			<!-- /Page Content -->

			<!-- Cursor -->
			<div class="mouse-cursor cursor-outer"></div>
			<div class="mouse-cursor cursor-inner"></div>
			<!-- /Cursor -->	

		</div>		
		<!-- /Main Wrapper -->
	
		<!-- jQuery -->
		<script src="assets/js/jquery-3.7.1.min.js" type="e0015ae97a9b7e1acf0bce80-text/javascript"></script>
		
		<!-- Bootstrap Bundle JS -->
		<script src="assets/js/bootstrap.bundle.min.js" type="e0015ae97a9b7e1acf0bce80-text/javascript"></script>
		
		<!-- Feather Icon JS -->
		<script src="assets/js/feather.min.js" type="e0015ae97a9b7e1acf0bce80-text/javascript"></script>

		<!-- Custom JS -->
		<script src="assets/js/script.js" type="e0015ae97a9b7e1acf0bce80-text/javascript"></script>
	
	<script src="../../cdn-cgi/scripts/7d0fa10a/cloudflare-static/rocket-loader.min.js" data-cf-settings="e0015ae97a9b7e1acf0bce80-|49" defer></script><script defer src="https://static.cloudflareinsights.com/beacon.min.js/vcd15cbe7772f49c399c6a5babf22c1241717689176015" integrity="sha512-ZpsOmlRQV6y907TI0dKBHq9Md29nnaEIPlkf84rnaERnq6zvWvPUqr2ft8M1aS28oN72PdrCzSjY4U6VaAw1EQ==" data-cf-beacon='{"rayId":"926c51bebe315489","version":"2025.1.0","serverTiming":{"name":{"cfExtPri":true,"cfL4":true,"cfSpeedBrain":true,"cfCacheStatus":true}},"token":"3ca157e612a14eccbb30cf6db6691c29","b":1}' crossorigin="anonymous"></script>
</body>


</html>