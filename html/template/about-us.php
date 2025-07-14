<?php
require_once(__DIR__ . "/backend/connection.inc.php");
// require_once(__DIR__ . "/backend/function.inc.php");
session_start();

$user_id = $_SESSION['user_id'] ?? null;


?>

<!DOCTYPE html>
<html lang="en">
	 
<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1" >

			<title>Lupicad |about Us </title>
		
		<!-- Favicon -->
		<link rel="shortcut icon" href="assets/lupicad/logo.svg" type="image/x-icon">

		<!-- Apple Touch Icon -->
		<link rel="apple-touch-icon" sizes="180x180" href="assets/img/apple-touch-icon.png">

		<!-- Theme Settings Js -->
		<script src="assets/js/theme-script.js" type="f1e57f881d3225449f69d6f2-text/javascript"></script>

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
								<li class="breadcrumb-item active">About Us</li>
							</ol>
							<h2 class="breadcrumb-title">About Us</h2>
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

		<!-- About Us -->
		<section class="about-section">
			<div class="container">
				<div class="row align-items-center">
					<div class="col-lg-6 col-md-12">
						<div class="about-img-info">
							<div class="row">
								<div class="col-md-6">
									<div class="about-inner-img">
										<div class="about-img">
											<img src="./assets/lupicad/products/2.png" class="img-fluid" alt="about-image">
										</div>
										<div class="about-img">
											<img src="./assets/lupicad/allproducts/4.png" class="img-fluid" alt="about-image">
										</div>
									</div>
								</div>
								<div class="col-md-6">
									<div class="about-inner-img">
										<div class="about-box" style="background-color: #194519 !important;">
											<h4>Over 15+ Years Experience</h4>
										</div>
										<div class="about-img">
											<img src="./assets/lupicad/products/6.png " class="img-fluid" style="transform:scaleY(0.9); box-shadow:0px 0px 8px 1px rgba(0,0,0,0.050);" alt="about-image">
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-6 col-md-12">
						<div class="section-inner-header about-inner-header">
							<h6>About Our Company</h6>
							<h2>We Always Ensure the Best Solutions for Your Intimate Well-Being</h2>
						</div>
						<div class="about-content">
							<div class="about-content-details">
								<p>At Lupicad, we specialize in providing effective solutions for various sexual health concerns across all genders. Our carefully formulated products help address conditions such as erectile dysfunction (ED), premature ejaculation (PE), low libido, vaginal dryness, hormonal imbalances, and other intimacy-related challenges. Whether you seek to enhance performance, restore confidence, or improve overall sexual wellness, our products are designed to support your journey toward a healthier and more satisfying intimate life.

									We prioritize safety, privacy, and effectiveness, offering only trusted, high-quality remedies that promote long-term well-being. Because your sexual health matters, and a fulfilling intimate life leads to greater happiness and confidence.</p>
							</div>
							<div class="about-contact">
								<div class="about-contact-icon">
									<span><i class="isax isax-call-calling5"></i></span>
								</div>
								<div class="about-contact-text">
									<p>Any Queries?</p>
									<h4>+91 8744997776</h4>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
		<!-- /About Us -->

		<!-- Why Choose Us -->
		<section class="why-choose-section">
			<div class="container">
				<div class="row">
					<div class="col-md-12">
						<div class="section-inner-header text-center">
							<h2>Why Choose Us</h2>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-3 col-md-6 d-flex">
						<div class="card why-choose-card w-100">
							<div class="card-body">
								<div class="why-choose-icon">
									<span style="background-color: #009f2f;"><img src="assets/img/icons/choose-01.svg" alt="choose-image"></span>
								</div>
								<div class="why-choose-content">
									<h4>Experienced and Trusted Specialists</h4>
									<p>We collaborate with skilled and knowledgeable professionals dedicated to providing expert care and reliable wellness solutions.</p>
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-3 col-md-6 d-flex">
						<div class="card why-choose-card w-100">
							<div class="card-body">
								<div class="why-choose-icon">
									<span style="background-color: #009f2f;"><img src="assets/img/icons/choose-02.svg" alt="choose-image"></span>
								</div>
								<div class="why-choose-content">
									<h4>Round-the-Clock Support</h4>
									<p>Get access to expert care anytime with our 24/7 service. Whether day or night, we’re here to assist you whenever you need.</p>
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-3 col-md-6 d-flex">
						<div class="card why-choose-card w-100">
							<div class="card-body">
								<div class="why-choose-icon">
									<span style="background-color: #009f2f;"><img src="assets/img/icons/choose-04.svg" alt="choose-image"></span>
								</div>
								<div class="why-choose-content">
									<h4>Reliable & Certified Lab Services</h4>
									<p>We work with trusted and accredited labs to ensure accurate results, prioritizing your health with top-quality diagnostic services.</p>
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-3 col-md-6 d-flex">
						<div class="card why-choose-card w-100">
							<div class="card-body">
								<div class="why-choose-icon">
									<span style="background-color: #009f2f;"><img src="assets/img/icons/choose-03.svg" alt="choose-image"></span>
								</div>
								<div class="why-choose-content">
									<h4>Premium Quality Products</h4>
									<p>We are committed to offering top-quality products made with safe and effective ingredients, ensuring the best care for your wellness needs.</p>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
		<!-- /Why Choose Us -->

		<!-- Banner Section -->
		<section style="margin: 20px 0px;">
			<img src="assets/lupicad/IndexLastBannerImg.jpeg" alt="Banner">
		</section>
		<!-- /Banner Section -->
		
		<!-- Doctors Section -->
		<section class="doctors-section professional-section">
			<div class="container">
				<div class="row">
					<div class="col-md-12">
						<div class="section-inner-header text-center">
							<h2>Best Products</h2>
						</div>
					</div>
				</div>

				<div class="row">

					<!-- Doctor Item -->
					<div class="col-lg-3 col-md-6 d-flex">
						<div class="card">
							<div class="card-img card-img-hover">
								<div class="image-container">
									<a href="product-description.php"><img src="./assets/lupicad/MaleProducts/4.2.png" id="img-1" alt="product image"></a>
									<a href="product-description.php"><img src="./assets/lupicad/MaleProducts/4.png" id="img-2" alt="product image"></a>
								</div>
								<div class="grid-overlay-item d-flex align-items-center justify-content-between">
									<span class="badge bg-orange"><i class="fa-solid fa-star me-1"></i>5.0</span>
									<a href="javascript:void(0)" class="fav-icon" style="box-shadow:0px 0px 5px -1px rgba(0, 0, 0, 0.35) ;">
										<i class="fa fa-heart"></i>
									</a>
								</div>
							</div>
							<div class="card-body p-0">
								<div class="d-flex active-bar align-items-center justify-content-between p-3">
									<a href="javascript:void(0)" class="text-indigo fw-medium fs-14">General Product</a>
									<span class="badge bg-success-light d-inline-flex align-items-center">
										<i class="fa-solid fa-circle fs-5 me-1"></i>
										Available
									</span>
								</div>
								<div class="p-3 pt-0">
									<div class="doctor-info-detail mb-3 pb-3">
										<h3 class="mb-1"><a href="product-all.php">Lupicad Gond Shiyh General Health – (60 Caps)</a></h3>
										<p>Gives strength to your bones Maintain men’s reproductive health</p>
									</div>
									<div class="d-flex align-items-center justify-content-between">
										<div>
											
											
											<h3 class="text-orange"><span class="woocommerce-Price-currencySymbol">₹</span>650</h3>
										</div>
										<a href="product-description.php" class="BuyNowBtn d-inline-flex align-items-center rounded-pill" style="background-color: #e88800 !important;">
											<i class="isax isax-calendar-1 me-2"></i>
											Buy Now
										</a>
										<a href="cart.php" class="cart-icon"><i class="fas fa-shopping-cart"></i></a>

									</div>
								</div>
							</div>
						</div>	
					</div>
					<!-- /Doctor Item -->

					<!-- Doctor Item -->
					<div class="col-lg-3 col-md-6 d-flex">
						<div class="card">
							<div class="card-img card-img-hover">
								<div class="image-container">
									<a href="product-description.php"><img src="./assets/lupicad/MaleProducts/1.2.png" id="img-1" alt="product image"></a>
									<a href="product-description.php"><img src="./assets/lupicad/MaleProducts/1.png" id="img-2" alt="product image"></a>
								</div>
								<div class="grid-overlay-item d-flex align-items-center justify-content-between">
									<span class="badge bg-orange"><i class="fa-solid fa-star me-1"></i>5.0</span>
									<a href="javascript:void(0)" class="fav-icon" style="box-shadow:0px 0px 5px -1px rgba(0, 0, 0, 0.35) ;">
										<i class="fa fa-heart"></i>
									</a>
								</div>
							</div>
							<div class="card-body p-0">
								<div class="d-flex active-bar align-items-center justify-content-between p-3">
									<a href="javascript:void(0)" class="text-indigo fw-medium fs-14">Male Product</a>
									<span class="badge bg-success-light d-inline-flex align-items-center">
										<i class="fa-solid fa-circle fs-5 me-1"></i>
										Available
									</span>
								</div>
								<div class="p-3 pt-0">
									<div class="doctor-info-detail mb-3 pb-3">
										<h3 class="mb-1"><a href="product-all.php">Lupicad Sperm Ultra Capsule for Man Health – (60 Caps)</a></h3>
										<p>Beneficial in increasing the sperm count </p>
									</div>
									<div class="d-flex align-items-center justify-content-between">
										<div>
											
											
											<h3 class="text-orange"><span class="woocommerce-Price-currencySymbol">₹</span>4,999.00</h3>
										</div>
										<a href="product-description.php" class="BuyNowBtn d-inline-flex align-items-center rounded-pill" style="background-color: #2c4119 !important;">
											<i class="isax isax-calendar-1 me-2"></i>
											Buy Now
										</a>
										<a href="cart.php" class="cart-icon"><i class="fas fa-shopping-cart"></i></a>

									</div>
								</div>
							</div>
						</div>
					</div>
					<!-- /Doctor Item -->
					<!-- Doctor Item -->
					<div class="col-lg-3 col-md-6 d-flex">
						<div class="card">
							<div class="card-img card-img-hover">
								<div class="image-container">
									<a href="product-description.php"><img src="./assets/lupicad/MaleProducts/3.2.png" id="img-1" alt="product image"></a>
									<a href="product-description.php"><img src="./assets/lupicad/MaleProducts/3.png" id="img-2" alt="product image"></a>
								</div>
								<div class="grid-overlay-item d-flex align-items-center justify-content-between">
									<span class="badge bg-orange"><i class="fa-solid fa-star me-1"></i>5.0</span>
									<a href="javascript:void(0)" class="fav-icon" style="box-shadow:0px 0px 5px -1px rgba(0, 0, 0, 0.35) ;">
										<i class="fa fa-heart"></i>
									</a>
								</div>
							</div>
							<div class="card-body p-0">
								<div class="d-flex active-bar align-items-center justify-content-between p-3">
									<a href="javascript:void(0)" class="text-indigo fw-medium fs-14">Male Product</a>
									<span class="badge bg-success-light d-inline-flex align-items-center">
										<i class="fa-solid fa-circle fs-5 me-1"></i>
										Available
									</span>
								</div>
								<div class="p-3 pt-0">
									<div class="doctor-info-detail mb-3 pb-3">
										<h3 class="mb-1"><a href="product-all.php">Lupicad Peni King Capsule For Male Health – (60 Caps)</a></h3>
										<p>Makes good erection & timing Better confidence in bad</p>
									</div>
									<div class="d-flex align-items-center justify-content-between">
										<div>
											
											
											<h3 class="text-orange"><span class="woocommerce-Price-currencySymbol">₹</span>1,350.00</h3>
										</div>
										<a href="product-description.php" class="BuyNowBtn d-inline-flex align-items-center rounded-pill" style="background-color: #3a3a38 !important;">
											<i class="isax isax-calendar-1 me-2"></i>
											Buy Now
										</a>
										<a href="cart.php" class="cart-icon"><i class="fas fa-shopping-cart"></i></a>

									</div>
								</div>
							</div>
						</div>	
					</div>
					<!-- /Doctor Item -->
					<!-- Doctor Item -->
					<div class="col-lg-3 col-md-6 d-flex">
						<div class="card">
							<div class="card-img card-img-hover">
								<div class="image-container">
									<a href="product-description.php"><img src="./assets/lupicad/GeneralProducts/5.png" id="img-1" alt="product image"></a>
									<a href="product-description.php"><img src="./assets/lupicad/GeneralProducts/5.1.png" id="img-2" alt="product image"></a>
								</div>
								<div class="grid-overlay-item d-flex align-items-center justify-content-between">
									<span class="badge bg-orange"><i class="fa-solid fa-star me-1"></i>5.0</span>
									<a href="javascript:void(0)" class="fav-icon" style="box-shadow:0px 0px 5px -1px rgba(0, 0, 0, 0.35) ;">
										<i class="fa fa-heart"></i>
									</a>
								</div>
							</div>
							<div class="card-body p-0">
								<div class="d-flex active-bar align-items-center justify-content-between p-3">
									<a href="javascript:void(0)" class="text-indigo fw-medium fs-14">General Product</a>
									<span class="badge bg-success-light d-inline-flex align-items-center">
										<i class="fa-solid fa-circle fs-5 me-1"></i>
										Available
									</span>
								</div>
								<div class="p-3 pt-0">
									<div class="doctor-info-detail mb-3 pb-3">
										<h3 class="mb-1"><a href="product-all.php">Lupicad Joint Care Capsule For General Health – (60 Caps)</a></h3>
										<p>High efficacy in minimum dosage Useful in joint pain</p>
									</div>
									<div class="d-flex align-items-center justify-content-between">
										<div>
											
											
											<h3 class="text-orange"><span class="woocommerce-Price-currencySymbol">₹</span>1,299.00</h3>
										</div>
										<a href="product-description.php" class="BuyNowBtn d-inline-flex align-items-center rounded-pill" style="background-color: #194519!important;">
											<i class="isax isax-calendar-1 me-2"></i>
											Buy Now
										</a>
										<a href="cart.php" class="cart-icon"><i class="fas fa-shopping-cart"></i></a>

									</div>
								</div>
							</div>
						</div>		
					</div>
					<!-- /Doctor Item -->

				</div>
			</div>
		</section>
		<!-- /Doctors Section -->
		<!-- Testimonial Section -->
		<section class="article-section">
			<div class="container">
				<div class="section-header sec-header-one text-center aos" data-aos="fade-up">
					<span class="badge badge-primary">Testimonials</span>
					<h2>15k Users Trust Lupicad Worldwide</h2>
				</div>

				<!-- Testimonial Slider -->
				<div class="owl-carousel testimonials-slider aos" data-aos="fade-up">
					<div class="card shadow-none mb-0">
						<div class="card-body">
							<div class="d-flex align-items-center mb-4">
								<div class="rating d-flex">
									<i class="fa-solid fa-star filled me-1"></i>
									<i class="fa-solid fa-star filled me-1"></i>
									<i class="fa-solid fa-star filled me-1"></i>
									<i class="fa-solid fa-star filled me-1"></i>
									<i class="fa-solid fa-star filled"></i>
								</div>
								<span>
									<img src="assets/img/icons/quote-icon.svg" alt="img">
								</span>
							</div>
							<h6 class="fs-16 fw-medium mb-2">Great Customer Support</h6>
							<p>The team was very helpful and responsive. They guided me well, and the products worked as promised.</p>
							<div class="d-flex align-items-center">
								<a href="javascript:void(0);" class="avatar avatar-lg">
									<img src="assets/img/patients/patient22.jpg" class="rounded-circle" alt="img">
								</a>
								<div class="ms-2">
									<h6 class="mb-1"><a href="javascript:void(0);">Amit Patel</a></h6>
									<p class="fs-14 mb-0"> Gujarat</p>
								</div>
							</div>
						</div>
					</div>
					<div class="card shadow-none mb-0">
						<div class="card-body">
							<div class="d-flex align-items-center mb-4">
								<div class="rating d-flex">
									<i class="fa-solid fa-star filled me-1"></i>
									<i class="fa-solid fa-star filled me-1"></i>
									<i class="fa-solid fa-star filled me-1"></i>
									<i class="fa-solid fa-star filled me-1"></i>
									<i class="fa-solid fa-star filled"></i>
								</div>
								<span>
									<img src="assets/img/icons/quote-icon.svg" alt="img">
								</span>
							</div>
							<h6 class="fs-16 fw-medium mb-2">Highly Effective Products</h6>
							<p>The product quality is excellent and delivers visible results. I feel more confident and healthier than ever.</p>
							<div class="d-flex align-items-center">
								<a href="javascript:void(0);" class="avatar avatar-lg">
									<img src="assets/img/patients/patient21.jpg" class="rounded-circle" alt="img">
								</a>
								<div class="ms-2">
									<h6 class="mb-1"><a href="javascript:void(0);">Rajesh Verma</a></h6>
									<p class="fs-14 mb-0">Maharashtra</p>
								</div>
							</div>
						</div>
					</div>
					<div class="card shadow-none mb-0">
						<div class="card-body">
							<div class="d-flex align-items-center mb-4">
								<div class="rating d-flex">
									<i class="fa-solid fa-star filled me-1"></i>
									<i class="fa-solid fa-star filled me-1"></i>
									<i class="fa-solid fa-star filled me-1"></i>
									<i class="fa-solid fa-star filled me-1"></i>
									<i class="fa-solid fa-star filled"></i>
								</div>
								<span>
									<img src="assets/img/icons/quote-icon.svg" alt="img">
								</span>
							</div>
							<h6 class="fs-16 fw-medium mb-2">Professional Consultation</h6>
							<p>The expert guidance helped me find the right solution. The consultation was smooth, private, and very informative.</p>
							<div class="d-flex align-items-center">
								<a href="javascript:void(0);" class="avatar avatar-lg">
									<img src="assets/img/patients/patient.jpg" class="rounded-circle" alt="img">
								</a>
								<div class="ms-2">
									<h6 class="mb-1"><a href="javascript:void(0);"> Priya Sharma</a></h6>
									<p class="fs-14 mb-0">Delhi</p>
								</div>
							</div>
						</div>
					</div>
					<div class="card shadow-none mb-0">
						<div class="card-body">
							<div class="d-flex align-items-center mb-4">
								<div class="rating d-flex">
									<i class="fa-solid fa-star filled me-1"></i>
									<i class="fa-solid fa-star filled me-1"></i>
									<i class="fa-solid fa-star filled me-1"></i>
									<i class="fa-solid fa-star filled me-1"></i>
									<i class="fa-solid fa-star filled"></i>
								</div>
								<span>
									<img src="assets/img/icons/quote-icon.svg" alt="img">
								</span>
							</div>
							<h6 class="fs-16 fw-medium mb-2">Trusted & Safe</h6>
							<p>I was hesitant at first, but the products are completely safe and effective. Great experience overall!</p>
							<div class="d-flex align-items-center">
								<a href="javascript:void(0);" class="avatar avatar-lg">
									<img src="assets/lupicad/NoProfileImg.jpg" class="rounded-circle" style="border:2px solid rgba(0, 0, 0, 0.5) ;" alt="img">
								</a>
								<div class="ms-2">
									<h6 class="mb-1"><a href="javascript:void(0);">Neha Reddy</a></h6>
									<p class="fs-14 mb-0">Karnataka</p>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- /Testimonial Slider -->

				<!-- Counter -->
				<div class="testimonial-counter">
					<div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-5 row-gap-4">
						<div class="counter-item text-center aos" data-aos="fade-up">
							<h6 class="display-6"><span class="count-digit">250</span>+</h6>
							<p>Product Available</p>
						</div>
						<div class="counter-item text-center aos" data-aos="fade-up"">
							<h6 class="display-6 secondary-count"><span class="count-digit">18</span> L+</h6>
							<p>Satisfied Customers</p>
						</div>
						<div class="counter-item text-center aos" data-aos="fade-up">
							<h6 class="display-6 purple-count"><span class="count-digit">8</span>K</h6>
							<p>Product Sell Per week</p>
						</div>
						<div class="counter-item text-center aos" data-aos="fade-up">
							<h6 class="display-6 pink-count"><span class="count-digit">47</span>+</h6>
							<p>sexologist Doctors</p>
						</div>
						<div class="counter-item text-center  aos" data-aos="fade-up">
							<h6 class="display-6 warning-count"><span class="count-digit">317</span>+</h6>
							<p>Lab Tests Available</p>
						</div>
					</div>
				</div>
				<!-- /Counter -->

			</div>
		</section>
		<!-- /Testimonial Section -->


		<!-- Way Section -->
		<section class="way-section">
			<div class="container" >
				<div class="way-bg"  style="background-color: #00461d !important;">
					<div class="way-shapes-img">
						<div class="way-shapes-left">
							<img src="assets/img/shape-06.png" alt="shape-image">
						</div>
						<div class="way-shapes-right">
							<img src="assets/img/shape-07.png" alt="shape-image">
						</div>
					</div>
					<div class="row align-items-end">
						<div class="col-lg-7 col-md-12">
							<div class="section-inner-header way-inner-header mb-0">
								<h2>Start Your Journey to Better Health with Lupicad</h2>
								<p>Take the first step towards improved well-being with Lupicad’s personalized and accessible wellness solutions designed just for you.</p>
								<a href="contact-us.php" class="btn btn-primary ">Contact With Us</a>
							</div>
						</div>
						<div class="col-lg-5 col-md-12">
							<div class="way-img">
								<img src="assets/lupicad/About/AboutColorBoxSectionImg.png" class="img-fluid" alt="doctor-way-image">
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
		<!-- /Way Choose Us -->


		<!-- FAQ Section -->
		<section class="faq-section faq-section-inner">
			<div class="container">
				<div class="row">
					<div class="col-md-12">
						<div class="section-inner-header text-center">
							<h6>Get Your Answer</h6>
							<h2>Frequently Asked Questions</h2>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-10 mx-auto">
						<div class="faq-info aos" data-aos="fade-up">
							<div class="accordion" id="faq-details">
	
								<!-- FAQ Item -->
								<div class="accordion-item">
									<h2 class="accordion-header" id="headingOne">
										<a href="javascript:void(0);" class="accordion-button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
											What is Lupicad Healthcare?
										</a>
									</h2>
									<div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#faq-details">
										<div class="accordion-body">
											<div class="accordion-content">
												<p>	Lupicad Healthcare is a healthcare-focused company committed to improving lives through innovative, reliable, and accessible health products and services. We specialize in [Unani & ayurveda, wellness solutions].</p>
											</div> 
										</div>   
									</div>
								</div>
								<!-- /FAQ Item -->
	
								<!-- FAQ Item -->
								<div class="accordion-item">
									<h2 class="accordion-header" id="headingTwo">
										<a href="javascript:void(0);" class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
											Where is Lupicad Healthcare located?
										
										</a>
									</h2>
									<div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#faq-details">
										<div class="accordion-body">
											<div class="accordion-content">
												<p>	Our headquarters are located in Delhi. We also operate through a network of partners and distributors globally. Visit our Contact page for specific location details.</p>
											</div>
										</div>
									</div>
								</div>
								<!-- /FAQ Item -->
	
								<!-- FAQ Item -->
								<div class="accordion-item">
									<h2 class="accordion-header" id="headingThree">
										<a href="javascript:void(0);" class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
											How can I get in touch with Lupicad Healthcare? 
										</a>
									</h2>
									<div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#faq-details">
										<div class="accordion-body">
											<div class="accordion-content">
												<p>	You can reach us through our Contact Us page, via email at [email address], or by calling our customer support line at +91-97183 88999.</p>
											</div>
										</div>
									</div>
								</div>
								<!-- /FAQ Item -->
	
								<!-- FAQ Item -->
								<div class="accordion-item">
									<h2 class="accordion-header" id="headingFour">
										<a href="javascript:void(0);" class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
											What kind of products does Lupicad Healthcare offer?
											
										</a>
									</h2>
									<div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#faq-details">
										<div class="accordion-body">
											<div class="accordion-content">
												<p>We offer a wide range of healthcare solutions, including wellness supplements, diagnostic kits, medical devices, etc.]. For a detailed list, contact us on +91-9718388999.</p>
											</div>
										</div>
									</div>
								</div>
								<!-- /FAQ Item -->
	
								<!-- FAQ Item -->
								<div class="accordion-item">
									<h2 class="accordion-header" id="headingFive">
										<a href="javascript:void(0);" class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
											Are Lupicad products safe and certified?

										</a>
									</h2>
									<div id="collapseFive" class="accordion-collapse collapse" aria-labelledby="headingFive" data-bs-parent="#faq-details">
										<div class="accordion-body">
											<div class="accordion-content">
												<p>Yes. All our products are developed in compliance with national and international regulatory standards. We ensure rigorous quality control and testing processes to guarantee safety and efficacy.</p>
											</div>
										</div>
									</div>
								</div>
								<!-- /FAQ Item -->
								<div class="accordion-item">
									<h2 class="accordion-header" id="headingSix">
										<a href="javascript:void(0);" class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
											Where can I purchase Lupicad Healthcare products?

										</a>
									</h2>
									<div id="collapseSix" class="accordion-collapse collapse" aria-labelledby="headingSix" data-bs-parent="#faq-details">
										<div class="accordion-body">
											<div class="accordion-content">
												<p>Lupicad products are available through licensed medical stores, authorized distributors, and select online platforms. You can also contact us directly for distributor or B2B inquiries.</p>
											</div>
										</div>
									</div>
								</div>
								<!-- /FAQ Item -->
                                <div class="accordion-item">
									<h2 class="accordion-header" id="headingSeven">
										<a href="javascript:void(0);" class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#collapseSeven" aria-expanded="false" aria-controls="collapseSeven">
											How can I request product samples or detailed clinical data?

										</a>
									</h2>
									<div id="collapseSeven" class="accordion-collapse collapse" aria-labelledby="headingSeven" data-bs-parent="#faq-details">
										<div class="accordion-body">
											<div class="accordion-content">
												<p>Healthcare professionals can contact our medical affairs team via info@lupicad.com and Call Support +91-9718388999 to get consultation.</p>
											</div>
										</div>
									</div>
								</div>
								<!-- /FAQ Item -->
								<div class="accordion-item">
									<h2 class="accordion-header" id="headingEight">
										<a href="javascript:void(0);" class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#collapseEight" aria-expanded="false" aria-controls="collapseEight">
											Can I partner with Lupicad Healthcare as a distributor or consultant?

										</a>
									</h2>
									<div id="collapseEight" class="accordion-collapse collapse" aria-labelledby="headingEight" data-bs-parent="#faq-details">
										<div class="accordion-body">
											<div class="accordion-content">
												<p>Yes, we welcome partnerships with qualified distributors, consultants, and healthcare institutions. Please visit our Partnerships section or reach out via the Contact Us form.</p>
											</div>
										</div>
									</div>
								</div>
								<!-- /FAQ Item -->
								 <div class="accordion-item">
									<h2 class="accordion-header" id="headingNine">
										<a href="javascript:void(0);" class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#collapseNine" aria-expanded="false" aria-controls="collapseNine">
											How can I track my order or shipment?

										</a>
									</h2>
									<div id="collapseNine" class="accordion-collapse collapse" aria-labelledby="headingNine" data-bs-parent="#faq-details">
										<div class="accordion-body">
											<div class="accordion-content">
												<p>If you've placed an order directly through Lupicad, tracking details will be provided via email or through your customer account. For third-party sales, please contact the point of purchase.</p>
											</div>
										</div>
									</div>
								</div>
								<!-- /FAQ Item -->
								 <div class="accordion-item">
									<h2 class="accordion-header" id="headingTen">
										<a href="javascript:void(0);" class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#collapseTen" aria-expanded="false" aria-controls="collapseTen">
											What should I do if I experience a product issue or side effect? 
										</a>
									</h2>
									<div id="collapseTen" class="accordion-collapse collapse" aria-labelledby="headingTen" data-bs-parent="#faq-details">
										<div class="accordion-body">
											<div class="accordion-content">
												<p>Please stop using the product and contact our product and packaging team immediately at info@lupicad.com. In case of a medical emergency, seek immediate professional help.</p>
											</div>
										</div>
									</div>
								</div>
								<!-- /FAQ Item -->
								<div class="accordion-item">
									<h2 class="accordion-header" id="headingTen">
										<a href="javascript:void(0);" class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#collapseEle" aria-expanded="false" aria-controls="collapseEle">
											How can I apply for a job at Lupicad Healthcare?

										</a>
									</h2>
									<div id="collapseEle" class="accordion-collapse collapse" aria-labelledby="headingEle" data-bs-parent="#faq-details">
										<div class="accordion-body">
											<div class="accordion-content">
												<p>Visit our Careers page to view current job openings and submit your application online. We are always looking for passionate individuals to join our team.</p>
											</div>
										</div>
									</div>
								</div>
								<!-- /FAQ Item -->
								<div class="accordion-item">
									<h2 class="accordion-header" id="headingTvl">
										<a href="javascript:void(0);" class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#collapseTvl" aria-expanded="false" aria-controls="collapseTvl">
											Do you offer internships or training programs?
										</a>
									</h2>
									<div id="collapseTvl" class="accordion-collapse collapse" aria-labelledby="headingTvl" data-bs-parent="#faq-details">
										<div class="accordion-body">
											<div class="accordion-content">
												<p>Yes, we offer internships, training, and development programs for students and young professionals. Keep an eye on our Careers section for announcements.</p>
											</div>
										</div>
									</div>
								</div>
								<!-- /FAQ Item -->
								<div class="accordion-item">
									<h2 class="accordion-header" id="headingTre">
										<a href="javascript:void(0);" class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#collapseTre" aria-expanded="false" aria-controls="collapseTre">
											How do I stay updated with Lupicad Healthcare news and developments?
										</a>
									</h2>
									<div id="collapseTre" class="accordion-collapse collapse" aria-labelledby="headingTre" data-bs-parent="#faq-details">
										<div class="accordion-body">
											<div class="accordion-content">
												<p>Subscribe to our newsletter or follow us on social media platforms like LinkedIn, Facebook, and Twitter for the latest updates.</p>
											</div>
										</div>
									</div>
								</div>
								<!-- /FAQ Item -->
																<div class="accordion-item">
									<h2 class="accordion-header" id="headingFor">
										<a href="javascript:void(0);" class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#collapseFor" aria-expanded="false" aria-controls="collapseFor">
											Is Lupicad involved in CSR or community health initiatives?

										</a>
									</h2>
									<div id="collapseFor" class="accordion-collapse collapse" aria-labelledby="headingFor" data-bs-parent="#faq-details">
										<div class="accordion-body">
											<div class="accordion-content">
												<p>Yes, we actively participate in healthcare outreach, education, and social responsibility programs. Visit our CSR page to learn more.</p>
											</div>
										</div>
									</div>
								</div>
								<!-- /FAQ Item -->
											
							</div>
						</div>

					</div>
				</div>
			</div>
		</section>
		<!-- /FAQ Section -->

		<!-- Footer Section -->
		<?php require_once(__DIR__ . "/components/footer.php") ?>
		<!-- /Footer Section -->

		<!-- Cursor -->
		<div class="mouse-cursor cursor-outer"></div>
		<div class="mouse-cursor cursor-inner"></div>
		<!-- /Cursor -->

	</div>
	<!-- /Main Wrapper -->

	<!-- jQuery -->
	<script src="assets/js/jquery-3.7.1.min.js" type="f1e57f881d3225449f69d6f2-text/javascript"></script>

	<!-- Bootstrap Bundle JS -->
	<script src="assets/js/bootstrap.bundle.min.js" type="f1e57f881d3225449f69d6f2-text/javascript"></script>

	<!-- Feather Icon JS -->
	<script src="assets/js/feather.min.js" type="f1e57f881d3225449f69d6f2-text/javascript"></script>

	<!-- Slick JS -->
	<script src="assets/js/slick.js" type="f1e57f881d3225449f69d6f2-text/javascript"></script>

	<!-- Counter JS -->
	<script src="assets/js/counter.js" type="f1e57f881d3225449f69d6f2-text/javascript"></script>

	<!-- Custom JS -->
	<script src="assets/js/script.js" type="f1e57f881d3225449f69d6f2-text/javascript"></script>

<script src="../../cdn-cgi/scripts/7d0fa10a/cloudflare-static/rocket-loader.min.js" data-cf-settings="f1e57f881d3225449f69d6f2-|49" defer></script><script defer src="https://static.cloudflareinsights.com/beacon.min.js/vcd15cbe7772f49c399c6a5babf22c1241717689176015" integrity="sha512-ZpsOmlRQV6y907TI0dKBHq9Md29nnaEIPlkf84rnaERnq6zvWvPUqr2ft8M1aS28oN72PdrCzSjY4U6VaAw1EQ==" data-cf-beacon='{"rayId":"926c47e72ced59d6","version":"2025.1.0","serverTiming":{"name":{"cfExtPri":true,"cfL4":true,"cfSpeedBrain":true,"cfCacheStatus":true}},"token":"3ca157e612a14eccbb30cf6db6691c29","b":1}' crossorigin="anonymous"></script>
</body>


<!-- Mirrored from doccure.dreamstechnologies.com/html/template/about-us.php by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 27 Mar 2025 05:01:33 GMT -->
</html>