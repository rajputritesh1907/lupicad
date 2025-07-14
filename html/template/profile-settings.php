<!DOCTYPE html> 
<html lang="en">
	
<head>
		
		<meta charset="utf-8">
	
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		
		<title>Lupicad |  Profile</title>
		
		<!-- Favicon -->
		<link rel="shortcut icon" href="assets/lupicad/logo.svg" type="image/x-icon">

		<!-- Apple Touch Icon -->
		<link rel="apple-touch-icon" sizes="180x180" href="assets/img/apple-touch-icon.png">

		<!-- Theme Settings Js -->
		<script src="assets/js/theme-script.js" type="845b8f721cd6a6b6f33c994e-text/javascript"></script>
		
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
									<li class="breadcrumb-item" aria-current="page">Patient</li>
									<li class="breadcrumb-item active">Settings</li>
								</ol>
								<h2 class="breadcrumb-title">Settings</h2>
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
					
						<div class="col-lg-4 col-xl-3 theiaStickySidebar">
							
							<!-- Profile Sidebar -->
							<div class="profile-sidebar patient-sidebar profile-sidebar-new">
								<div class="widget-profile pro-widget-content">
									<div class="profile-info-widget">
										<a href="profile-settings.php" class="booking-doc-img">
											<img src="assets/img/doctors-dashboard/profile-06.jpg" alt="User Image">
										</a>
										<div class="profile-det-info">
											<h3><a href="profile-settings.php">Hendrita Hayes</a></h3>
											<div class="patient-details">
												<h5 class="mb-0">Patient ID : PT254654</h5>
											</div>
											<span>Female <i class="fa-solid fa-circle"></i> 32 years 03 Months</span>
										</div>
									</div>
								</div>
								<div class="dashboard-widget">
									<nav class="dashboard-menu">
										<ul>
											<li>
												<a href="patient-dashboard.php">
													<i class="isax isax-category-2"></i>
													<span>Dashboard</span>
												</a>
											</li>
											<li>
												<a href="patient-appointments.php">
													<i class="isax isax-calendar-1"></i>
													<span>My Appointments</span>
												</a>
											</li>
											<li>
												<a href="favourites.php">
													<i class="isax isax-star-1"></i>
													<span>Favourites</span>
												</a>
											</li>
											<li>
												<a href="dependent.php">
													<i class="isax isax-user-octagon"></i>
													<span>Dependants</span>
												</a>
											</li>
											<li>
												<a href="medical-records.php">
													<i class="isax isax-note-21"></i>
													<span>Medical Records</span>
												</a>
											</li>
											<li>
												<a href="patient-accounts.php">
													<i class="isax isax-wallet-2"></i>
													<span>Wallet</span>
												</a>
											</li>
											<li>
												<a href="patient-invoices.php">
													<i class="isax isax-document-text"></i>
													<span>Invoices</span>
												</a>
											</li>																																			
											<li>
												<a href="chat.php">
													<i class="isax isax-messages-1"></i>
													<span>Message</span>
													<small class="unread-msg">7</small>
												</a>
											</li>
											<li>
												<a href="medical-details.php">
													<i class="isax isax-note-1"></i>
													<span>Vitals</span>
												</a>
											</li>
											<li class="active">
												<a href="profile-settings.php">
													<i class="isax isax-setting-2"></i>
													<span>Settings</span>
												</a>
											</li>
											<li>
												<a href="login.php">
													<i class="isax isax-logout"></i>
													<span>Logout</span>
												</a>
											</li>
										</ul>
									</nav>
								</div>
							</div>
							<!-- /Profile Sidebar -->						
							
						</div>
						
						<div class="col-lg-8 col-xl-9">
							<nav class="settings-tab mb-1">
								<ul class="nav nav-tabs-bottom" role="tablist">
									 <li class="nav-item" role="presentation">
										<a class="nav-link active" href="profile-settings.php">Profile</a>
									 </li>
									 <li class="nav-item" role="presentation">
										<a class="nav-link" href="change-password.php">Change Password</a>
									 </li>
									 <li class="nav-item" role="presentation">
										 <a class="nav-link" href="two-factor-authentication.php">2 Factor Authentication</a>
									 </li>
									 <li class="nav-item" role="presentation">
										 <a class="nav-link" href="delete-account.php">Delete Account</a>
									 </li>
								</ul>
							</nav>
							<div class="card">
								<div class="card-body">
									<div class="border-bottom pb-3 mb-3">
										<h5>Profile Settings</h5>
									</div>
									<form action="https://doccure.dreamstechnologies.com/html/template/profile-settings.php">
										<div class="setting-card">
											<label class="form-label mb-2">Profile Photo</label>
											<div class="change-avatar img-upload">
												<div class="profile-img">
													<i class="fa-solid fa-file-image"></i>
												</div>
												<div class="upload-img">
													<div class="imgs-load d-flex align-items-center">
														<div class="change-photo">
															Upload New 
															<input type="file" class="upload">
														</div>
														<a href="#" class="upload-remove">Remove</a>
													</div>
													<p>Your Image should Below 4 MB, Accepted format jpg,png,svg</p>
												</div>			
											</div>			
										</div>
										<div class="setting-title">
											<h6>Information</h6>
										</div>
										<div class="setting-card">
											<div class="row">
												<div class="col-lg-4 col-md-6">
													<div class="mb-3">
														<label class="form-label">First Name <span class="text-danger">*</span></label>
														<input type="text" class="form-control">
													</div>
												</div>
												<div class="col-lg-4 col-md-6">
													<div class="mb-3">
														<label class="form-label">Last Name <span class="text-danger">*</span></label>
														<input type="text" class="form-control">
													</div>
												</div>
												<div class="col-lg-4 col-md-6">
													<div class="mb-3">
														<label class="form-label">Date of Birth <span class="text-danger">*</span></label>
														<div class="form-icon">
															<input type="text" class="form-control datetimepicker" placeholder="dd/mm/yyyy">
															<span class="icon"><i class="isax isax-calendar-1"></i></span>
														</div>
													</div>
												</div>
												<div class="col-lg-4 col-md-6">
													<div class="mb-3">
														<label class="form-label">Phone Number <span class="text-danger">*</span></label>
														<input type="text" class="form-control">
													</div>
												</div>
												<div class="col-lg-4 col-md-6">
													<div class="mb-3">
														<label class="form-label">Email Address <span class="text-danger">*</span></label>
														<input type="email" class="form-control">
													</div>
												</div>
												<div class="col-lg-4 col-md-6">
													<div class="mb-3">
														<label class="form-label">Blood Group <span class="text-danger">*</span></label>
														<select class="select">
															<option>Select</option>
															<option>B+ve</option>
															<option>AB+ve</option>
															<option>B-ve</option>
															<option>O+ve</option>
															<option>O-ve</option>
														</select>
													</div>
												</div>
											</div>
										</div>
										<div class="setting-title">
											<h6>Address</h6>
										</div>
										<div class="setting-card">
											<div class="row">
												<div class="col-lg-12">
													<div class="mb-3">
														<label class="form-label">Address <span class="text-danger">*</span></label>
														<input type="text" class="form-control">
													</div>
												</div>
												<div class="col-md-6">
													<div class="mb-3">
														<label class="form-label">City <span class="text-danger">*</span></label>
														<input type="text" class="form-control">
													</div>
												</div>
												<div class="col-md-6">
													<div class="mb-3">
														<label class="form-label">State <span class="text-danger">*</span></label>
														<input type="text" class="form-control">
													</div>
												</div>
												<div class="col-md-6">
													<div class="mb-3">
														<label class="form-label">Country <span class="text-danger">*</span></label>
														<input type="text" class="form-control">
													</div>
												</div>
												<div class="col-md-6">
													<div class="mb-3">
														<label class="form-label">Pincode <span class="text-danger">*</span></label>
														<input type="text" class="form-control">
													</div>
												</div>
											</div>
										</div>
										<div class="modal-btn text-end">
											<a href="#" class="btn btn-md btn-light rounded-pill">Cancel</a>
											<button type="submit" class="btn btn-md btn-primary-gradient rounded-pill">Save Changes</button>
										</div>
									</form>
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
	  
		<!-- jQuery -->
		<script src="assets/js/jquery-3.7.1.min.js" type="845b8f721cd6a6b6f33c994e-text/javascript"></script>
		
		<!-- Bootstrap Core JS -->
		<script src="assets/js/bootstrap.bundle.min.js" type="845b8f721cd6a6b6f33c994e-text/javascript"></script>
		
		<!-- Select2 JS -->
		<script src="assets/plugins/select2/js/select2.min.js" type="845b8f721cd6a6b6f33c994e-text/javascript"></script>
		
		<!-- Datetimepicker JS -->
		<script src="assets/js/moment.min.js" type="845b8f721cd6a6b6f33c994e-text/javascript"></script>
		<script src="assets/js/bootstrap-datetimepicker.min.js" type="845b8f721cd6a6b6f33c994e-text/javascript"></script>
		
		<!-- Sticky Sidebar JS -->
        <script src="assets/plugins/theia-sticky-sidebar/ResizeSensor.js" type="845b8f721cd6a6b6f33c994e-text/javascript"></script>
        <script src="assets/plugins/theia-sticky-sidebar/theia-sticky-sidebar.js" type="845b8f721cd6a6b6f33c994e-text/javascript"></script>
		
		<!-- Custom JS -->
		<script src="assets/js/script.js" type="845b8f721cd6a6b6f33c994e-text/javascript"></script>
		
	<script src="../../cdn-cgi/scripts/7d0fa10a/cloudflare-static/rocket-loader.min.js" data-cf-settings="845b8f721cd6a6b6f33c994e-|49" defer></script><script defer src="https://static.cloudflareinsights.com/beacon.min.js/vcd15cbe7772f49c399c6a5babf22c1241717689176015" integrity="sha512-ZpsOmlRQV6y907TI0dKBHq9Md29nnaEIPlkf84rnaERnq6zvWvPUqr2ft8M1aS28oN72PdrCzSjY4U6VaAw1EQ==" data-cf-beacon='{"rayId":"926c47d94be791a3","version":"2025.1.0","serverTiming":{"name":{"cfExtPri":true,"cfL4":true,"cfSpeedBrain":true,"cfCacheStatus":true}},"token":"3ca157e612a14eccbb30cf6db6691c29","b":1}' crossorigin="anonymous"></script>
</body>

</html>