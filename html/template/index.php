<?php
require_once(__DIR__ . "/backend/connection.inc.php");

if (session_status() === PHP_SESSION_NONE) {
	session_start();
}

// $user_id = $_SESSION['user_id'];

?>
<?php
$faqs = [
    [
        "question" => "What is Lupicad Healthcare?",
        "answer" => "Lupicad Healthcare is a healthcare-focused company committed to improving lives through innovative, reliable, and accessible health products and services. We specialize in <strong>Unani & ayurveda, wellness solutions</strong>."
    ],
    [
        "question" => "Where is Lupicad Healthcare located?",
        "answer" => "Our headquarters are located in Delhi. We also operate through a network of partners and distributors globally. Visit our Contact page for specific location details."
    ],
    [
        "question" => "How can I get in touch with Lupicad Healthcare?",
        "answer" => "You can reach us through our Contact Us page, via email at [email address], or by calling our customer support line at +91-97183 88999."
    ],
    [
        "question" => "What kind of products does Lupicad Healthcare offer?",
        "answer" => "We offer a wide range of healthcare solutions, including wellness supplements, diagnostic kits, medical devices, etc. For a detailed list, contact us on +91-9718388999."
    ],
    [
        "question" => "Are Lupicad products safe and certified?",
        "answer" => "Yes. All our products are developed in compliance with national and international regulatory standards. We ensure rigorous quality control and testing processes to guarantee safety and efficacy."
    ]
];
?>

<!DOCTYPE html>
<html lang="en">

<head>

	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Lupicad</title>

	<!-- Favicon -->
	<link rel="shortcut icon" href="assets/lupicad/logo.svg" type="image/x-icon">
	<link rel="stylesheet" href="https://unpkg.com/@iconscout/unicons/css/line.css">

	<!-- Apple Touch Icon -->
	<link rel="apple-touch-icon" sizes="180x180" href="assets/img/apple-touch-icon.png">

	<!-- Theme Settings Js -->
	<script src="assets/js/theme-script.js" type="290daf7fcf744922b4c3c7cf-text/javascript"></script>

	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="assets/css/bootstrap.min.css">

	<link rel="stylesheet" href="assets/css/animate.css">

	<!-- Fontawesome CSS -->
	<link rel="stylesheet" href="assets/plugins/fontawesome/css/fontawesome.min.css">
	<link rel="stylesheet" href="assets/plugins/fontawesome/css/all.min.css">

	<!-- Iconsax CSS-->
	<link rel="stylesheet" href="assets/css/iconsax.css">

	<!-- Feathericon CSS -->
	<link rel="stylesheet" href="assets/css/feather.css">

	<!-- Datepicker CSS -->
	<link rel="stylesheet" href="assets/css/bootstrap-datetimepicker.min.css">

	<!-- Owl Carousel CSS -->
	<link rel="stylesheet" href="assets/css/owl.carousel.min.css">

	<!-- Animation CSS -->
	<link rel="stylesheet" href="assets/css/aos.css">

	<!-- select CSS -->
	<link rel="stylesheet" href="assets/plugins/select2/css/select2.min.css">

	<!-- Main CSS -->
	<link rel="stylesheet" href="assets/css/custom.css">

	<!-- Slick Slider CSS -->
	<link rel="stylesheet" type="text/css"
		href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css" />
	<link rel="stylesheet" type="text/css"
		href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.min.css" />

	<!-- Slick Slider JS -->
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
	<script type="text/javascript"
		src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>
		<script src="https://cdn.tailwindcss.com"></script>

	<!-- Inline CSS for Styling -->
	<style>
		/* my css */
	.curved-section {
      border-radius: 100% 100% 100% 100% / 30%;
      padding-top: 4rem;
      padding-bottom: 4rem;
      position: relative;
    }

    .curved-section::before {
      content: "";
      position: absolute;
      top: -100%;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: #31c5e2;
      border-radius: 100% 100% 0 0 / 30%;
      z-index: -1;
    }
	.container-box {
  padding-left: 1rem;
  padding-right: 1rem;
}
@media (min-width: 768px) {
  .container-box {
    padding-left: 2rem;
    padding-right: 2rem;
  }
}
@media (min-width: 1200px) {
  .container-box {
    padding-left: 3rem;
    padding-right: 3rem;
  }
}
		
		.image-slider {
			width: 100%;
			margin: 0 auto;
		}
		.slider-container {
			width: 100%;
		}
		.slider-container img {
			width: 100%;
			object-fit: cover;
		}
		.gallery-section {
		  padding: 40px 0;
		}
		.gallery-row {
		  display: flex;
		  flex-wrap: wrap;
		  justify-content: center;
		}
		.gallery-item img {
		  border-radius: 8px;
		  transition: transform 0.2s;
		  box-shadow: 0 2px 8px rgba(0,0,0,0.08);
		  width: 100%;
		  height: auto;
		}
		.gallery-item img:hover {
		  transform: scale(1.05);
		}
		@media (max-width: 767.98px) {
		  .gallery-row {
			flex-direction: column;
			align-items: center;
		  }
		}
	</style>

</head>

<body>

	<!-- Main Wrapper -->
	<div class="main-wrapper">
		<!-- Header -->
		<?php require_once(__DIR__ . "/components/header.php") ?>

		<!-- /Header -->

		<!-- Home Banner -->
		<section class="banner-section banner-sec-one">
			<!-- Image Slider Container -->
			<div class="image-slider" style="width: 100%; margin: 0 auto; overflow: hidden;">
				<div class="slider-container">
				<div><img src="assets/lupicad/iconslupicad/LupucatHeroBannner.jpg" alt="patient-image" style="width: 100%; object-fit: cover;"></div>
				<!-- <div><img src="assets/lupicad/iconslupicad/womenProductsBanner.jpg" alt="patient-image" style="width: 100%; object-fit: cover;"></div> -->
			  <div><img src="assets/lupicad/iconslupicad/banner.jpg" alt="patient-image" style="width: 100%; object-fit: cover;"></div>  
					<div><img src="assets/lupicad/2banner.png" alt="patient-image" style="width: 100%; object-fit: cover;"></div>  
					<!-- <div><img src="assets/lupicad/3banner.png" alt="patient-image" style="width: 100%; object-fit: cover;"></div> -->
				</div>
			</div>
			</section>

			<!-- my try -->
			<div class="relative overflow-hidden bg-[#31c5e2] curved-section z-0 px-4 py-10">
  <div class="flex flex-col md:flex-row justify-center items-center gap-4 md:gap-6">

    <!-- Image Card 1 -->
    <div class="w-full md:w-1/3">
      <img src="assets/lupicad/offercard/3.png" alt="Image 3" class="rounded w-full object-cover" />
    </div>

    <!-- Image Card 2 -->
    <div class="w-full md:w-1/3">
      <img src="assets/lupicad/offercard/1.png" alt="Image 2" class="rounded w-full object-cover" />
    </div>

    <!-- Image Card 3 -->
    <div class="w-full md:w-1/3">
      <img src="assets/lupicad/offercard/2.png" alt="Image 1" class="rounded w-full object-cover" />
    </div>

  </div>
</div>
		<!-- try -->




            <!-- <section style="margin: 20px 0px; display: flex; flex-direction: row; gap: 20px; background: linear-gradient(90deg, #007cf0 0%, #00dfd8 100%);">
			<center><img src="assets/lupicad/fg.png" style="width: 90%" alt="Badges"></center> 
		</section> -->
			<!-- Optional Background -->
			
		 <section class="services-section aos" data-aos="fade-up" style="background: linear-gradient(90deg, #FFC03E 0%, #ff8d62 100%) !important;">
			<div class="horizontal-slide d-flex" data-direction="right" data-speed="fast">
				<div class="slide-list d-flex gap-4">
					<div class="services-slide">
						<h6><a href="javascript:void(0);">FREE SHIPPING</a></h6>
					</div>
					<div class="services-slide">
						<h6><a href="javascript:void(0);">SECURED PAYMENT</a></h6>
					</div>
					<div class="services-slide">
						<h6><a href="javascript:void(0);">MEDICINE & SUPPLIES</a></h6>
					</div>
					<div class="services-slide">
						<h6><a href="javascript:void(0);">LAB TESTING</a></h6>
					</div>
					<div class="services-slide">
						<h6><a href="javascript:void(0);">COD AVAILABLE</a></h6>
					</div>
					<div class="services-slide">
							<h6><a href="javascript:void(0);">Home Care Services</a></h6>
						</div>
				</div>
			</div>
		</section>
        <section class="speciality-section">
			<div class="container-box">
				<div class="section-header sec-header-one text-center aos" data-aos="fade-up">
					<h2>Medicine and Category</h2>
				</div>
				<div class="owl-carousel spciality-slider aos" data-aos="fade-">
					
					<div class="spaciality-item" onclick="location.href='product-all.php'">
						<div class="spaciality-img">
							<img src="assets/lupicad/iconslupicad/men.png" alt="img">
						</div>
						<h6><a href="product-all.php">Male Health</a></h6>
					</div>
					<div class="spaciality-item" onclick="location.href='product-all.php'">
						<div class="spaciality-img">
							<img src="assets/lupicad/iconslupicad/Hair.png" alt="img">
						</div>
						<h6><a href="product-all.php">Hair Care</a></h6>
					</div>
					<div class="spaciality-item" onclick="location.href='product-all.php'">
						<div class="spaciality-img">
							<img src="assets/lupicad/iconslupicad/pain.png" alt="img">
						</div>
						<h6><a href="product-all.php">Body & Joint Pain</a></h6>
					</div>

					<div class="spaciality-item" onclick="location.href='product-all.php'">
						<div class="spaciality-img">
							<img src="assets/lupicad/iconslupicad/skin.png" alt="img">
						</div>
						<h6><a href="product-all.php">Skin Care</a></h6>
					</div>
					<div class="spaciality-item" onclick="location.href='product-all.php'">
						<div class="spaciality-img">
							<img src="assets/lupicad/iconslupicad/women.png" alt="img">
						</div>
						<h6><a href="product-all.php">Female Health</a></h6>
					</div>
					<div class="spaciality-item" onclick="location.href='product-all.php'">
						<div class="spaciality-img">
							<img src="assets/lupicad/iconslupicad/cough.png" alt="img">
						</div>
						<h6><a href="product-all.php">Breathing Problem</a></h6>
					</div>

					<div class="spaciality-item" onclick="location.href='product-all.php'">
						<div class="spaciality-img">
							<img src="assets/lupicad/iconslupicad/headache.png" alt="img">
						</div>
						<h6><a href="product-all.php">Headache & magrain</a></h6>
					</div>
					<div class="spaciality-item" onclick="location.href='product-all.php'">
						<div class="spaciality-img">
							<img src="assets/lupicad/iconslupicad/immunity.png" alt="img"></a>
						</div>
						<h6><a href="product-all.php">Immunity & hygiene</a></h6>
					</div>
					
				</div> 
			</div>
		</section>
			
	
		<!-- /Home Banner -->

		<!-- List -->
		
		<!-- /List -->

		<!-- Banner Section -->

		<!-- my -->






		<!-- myend -->
		<!-- <section style="margin: 20px 0px; display: flex; flex-direction: row; align-items: center; gap: 32px; width: 100%;  border-radius: 16px; box-shadow: 0 2px 16px rgba(0,0,0,0.07); padding: 20px 0px;">
			<div style="width: 40%; display: flex; flex-direction: column; align-items: center; justify-content: center;">
				<img src="assets/lupicad/50.png" style="width: 50%;" alt="Badge">
				
			</div>
			<div style="width: 70%;  display: flex; align-items: center; flex-direction: column; justify-content: flex-start; gap: 2vw; flex-wrap: wrap;">
			<div style="margin-top:  16px; color: #fff; font-size: 3rem; font-weight: 700; text-align: center; text-shadow: 0 2px 8px rgba(0,0,0,0.12); letter-spacing: 1px; width: 100%; color: black;">
				The world is landing on manufacture
			</div>
				<div style="display: flex; flex-direction: row; align-items:center;   justify-content: center; gap: 3%; flex-3">
				<img src="assets/lupicad/1icon.png" style="width: 6vw;" alt="Badge 1">
				<img src="assets/lupicad/2icon.png" style="width: 6vw;" alt="Badge 2">
				<img src="assets/lupicad/3icon.jpeg" style="width: 6vw;" alt="Badge 3"> 
				<img src="assets/lupicad/4icon.png" style="width: 6vw;" alt="Badge 3"> 
				<img src="assets/lupicad/5icon.png" style="width: 6vw;" alt="Badge 5">
				<img src="assets/lupicad/6icon.png" style="width: 6vw;" alt="Badge 6">
				</div>
			</div>
		</section> -->
		<!-- /Banner Section -->

		<!-- Speciality Section -->
		
		<!-- /Speciality Section -->
		<!-- Product Showcase Section -->
		<?php require_once(__DIR__ . "/components/indexProductSection.php") ?>
		<!-- /Doctor Section -->

		<!-- Work Section -->

		<!-- /Work Section -->

		<!-- Services Section -->
		<!--<section class="services-section aos" data-aos="fade-up" style="background: linear-gradient(90deg, #FFC03E 0%, #ff8d62 100%) !important;">-->
		<!--	<div class="horizontal-slide d-flex" data-direction="right" data-speed="fast">-->
		<!--		<div class="slide-list d-flex gap-4">-->
		<!--			<div class="services-slide">-->
		<!--				<h6><a href="javascript:void(0);">FREE SHIPPING</a></h6>-->
		<!--			</div>-->
		<!--			<div class="services-slide">-->
		<!--				<h6><a href="javascript:void(0);">SECURED PAYMENT</a></h6>-->
		<!--			</div>-->
		<!--			<div class="services-slide">-->
		<!--				<h6><a href="javascript:void(0);">MEDICINE & SUPPLIES</a></h6>-->
		<!--			</div>-->
		<!--			<div class="services-slide">-->
		<!--				<h6><a href="javascript:void(0);">LAB TESTING</a></h6>-->
		<!--			</div>-->
		<!--			<div class="services-slide">-->
		<!--				<h6><a href="javascript:void(0);">COD AVAILABLE</a></h6>-->
		<!--			</div>-->
					<!-- <div class="services-slide">
							<h6><a href="javascript:void(0);">Home Care Services</a></h6>-->
		<!--				</div> --> 
		<!--		</div>-->
		<!--	</div>-->
		<!--</section>-->
		<!-- /Services Section -->

		<!-- Reasons Section -->

		<!-- /Reasons Section -->

		<!-- Bookus Section -->

		<!-- /Bookus Section -->

		<!-- 50years -->
		 <section class="bg-white pt-4">
  <img src="assets/lupicad/50yearBanner.png" alt="50 Years of Trust" class="w-full h-auto object-cover" />
</section>
		 <!-- end -->

		<!-- Testimonial Section -->
		<section class="article-section">
			<div class="container-box">
				<div class="section-header sec-header-one text-center aos" data-aos="fade-up">
					<span class="badge badge-primary">Testimonials</span>
					<h2>15k Users Trust Lupicad Worldwide</h2>
				</div> 
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
							<p>The team was very helpful and responsive. They guided me well, and the products worked as
								promised.</p>
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
							<p>The product quality is excellent and delivers visible results. I feel more confident and
								healthier than ever.</p>
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
							<p>The expert guidance helped me find the right solution. The consultation was smooth,
								private, and very informative.</p>
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
							<p>I was hesitant at first, but the products are completely safe and effective. Great
								experience overall!</p>
							<div class="d-flex align-items-center">
								<a href="javascript:void(0);" class="avatar avatar-lg">
									<img src="assets/lupicad/NoProfileImg.jpg" class="rounded-circle"
										style="border:2px solid rgba(0, 0, 0, 0.5) ;" alt="img">
								</a>
								<div class="ms-2">
									<h6 class="mb-1"><a href="javascript:void(0);">Neha Reddy</a></h6>
									<p class="fs-14 mb-0">Karnataka</p>
								</div>
							</div>
						</div>
					</div>
				</div> 
				<div class="testimonial-counter">
					<div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-5 row-gap-4">
						<div class="counter-item text-center aos" data-aos="fade-up">
							<h6 class="display-6"><span class="count-digit">250</span>+</h6>
							<p>Product Available</p>
						</div>
						<div class="counter-item text-center aos" data-aos="fade-up"">
								<h6 class=" display-6 secondary-count"><span class="count-digit">18</span> L+</h6>
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

			</div>
		</section>
		<!-- /Testimonial Section -->


		<!-- Banner Section -->
		<!--<section style="margin: 20px 0px;">-->
		<!--	<img src="assets/lupicad/IndexLastBannerImg.jpeg" alt="">-->
		<!--</section>-->
		<section class="px-4 py-6">
			<div class="section-header sec-header-one text-center aos" data-aos="fade-up">
					<!-- <span class="badge badge-primary">Testimonials</span> -->
					<h2>Today's Top Picks</h2>
				</div>
			<div class="flex flex-wrap -mx-2">
				<!-- Image Item -->
				<div class="w-full sm:w-1/2 md:w-1/3 lg:w-1/5 px-2 mb-4">
					<div class="overflow-hidden">
						<img src="assets/lupicad/smalllupicad/Frame 12.png" alt="Banner 1"
							class="w-full h-auto object-contain aspect-[2/1] transition-opacity duration-300" loading="lazy">
					</div>
				</div>

				<div class="w-full sm:w-1/2 md:w-1/3 lg:w-1/5 px-2 mb-4">
					<div class="overflow-hidden">
						<img src="assets/lupicad/smalllupicad/Frame 3.png" alt="Banner 2"
							class="w-full h-auto object-contain aspect-[2/1] transition-opacity duration-300" loading="lazy">
					</div>
				</div>

				<div class="w-full sm:w-1/2 md:w-1/3 lg:w-1/5 px-2 mb-4">
					<div class="overflow-hidden">
						<img src="assets/lupicad/smalllupicad/Frame 4.png" alt="Banner 3"
							class="w-full h-auto object-contain aspect-[2/1] transition-opacity duration-300" loading="lazy">
					</div>
				</div>

				<div class="w-full sm:w-1/2 md:w-1/3 lg:w-1/5 px-2 mb-4">
					<div class="overflow-hidden">
						<img src="assets/lupicad/smalllupicad/Frame 5.png" alt="Banner 4"
							class="w-full h-auto object-contain aspect-[2/1] transition-opacity duration-300" loading="lazy">
					</div>
				</div>

				<div class="w-full sm:w-1/2 md:w-1/3 lg:w-1/5 px-2 mb-4">
					<div class="overflow-hidden">
						<img src="assets/lupicad/smalllupicad/Frame 6.png" alt="Banner 5"
							class="w-full h-auto object-contain aspect-[2/1] transition-opacity duration-300" loading="lazy">
					</div>
				</div>
				<div class="w-full sm:w-1/2 md:w-1/3 lg:w-1/5 px-2 mb-4">
					<div class="overflow-hidden  ">
						<img src="assets/lupicad/smalllupicad/Frame 7.png" alt="Banner 5"
							class="w-full h-auto object-contain aspect-[2/1] transition-opacity duration-300" loading="lazy">
					</div>
				</div>
				<div class="w-full sm:w-1/2 md:w-1/3 lg:w-1/5 px-2 mb-4">
					<div class="overflow-hidden">
						<img src="assets/lupicad/smalllupicad/Frame 8.png" alt="Banner 5"
							class="w-full h-auto object-contain aspect-[2/1] transition-opacity duration-300" loading="lazy">
					</div>
				</div>
				<div class="w-full sm:w-1/2 md:w-1/3 lg:w-1/5 px-2 mb-4">
					<div class="overflow-hidden">
						<img src="assets/lupicad/smalllupicad/Frame 9.png" alt="Banner 5"
							class="w-full h-auto object-contain aspect-[2/1] transition-opacity duration-300" loading="lazy">
					</div>
				</div>
				<div class="w-full sm:w-1/2 md:w-1/3 lg:w-1/5 px-2 mb-4">
					<div class="overflow-hidden">
						<img src="assets/lupicad/smalllupicad/Frame 10.png" alt="Banner 5"
							class="w-full h-auto object-contain aspect-[2/1] transition-opacity duration-300" loading="lazy">
					</div>
				</div>
				<div class="w-full sm:w-1/2 md:w-1/3 lg:w-1/5 px-2 mb-4">
					<div class="overflow-hidden">
						<img src="assets/lupicad/smalllupicad/Frame 11.png" alt="Banner 5"
							class="w-full h-auto object-contain aspect-[2/1] transition-opacity duration-300" loading="lazy">
					</div>
				</div>
			</div>
		</section>
		<!-- /Banner Section -->

		<!-- FAQ Section -->

		
<section class="w-full py-12 bg-gradient-to-br from-blue-50 via-white to-blue-100">
  <div class="container-box">
    <h2 class="text-3xl font-extrabold text-center text-blue-900 mb-8 ">Your Questions are Answered</h2>
    <div id="faq-accordion" class="space-y-4">
      <?php foreach ($faqs as $faq): ?>
        <div class="bg-white rounded-xl   overflow-hidden">
          <button type="button" class="faq-toggle w-full flex items-center gap-3 py-4 px-6 text-left text-lg font-semibold focus:outline-none group hover:bg-blue-50 transition">
            <span class="h-8 w-1.5 bg-blue-500 rounded-full mr-2"></span>
            <span class="flex-1"><?= $faq['question'] ?></span>
            <span class="faq-icon transition-transform duration-300 text-3xl font-semibold text-blue-500 group-hover:text-blue-700">+</span>
          </button>
          <div class="faq-content px-8 text-gray-600 overflow-hidden max-h-0 transition-all duration-500 ease-in-out">
            <p class="text-left text-base py-4">
              <?= $faq['answer'] ?>
            </p>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
  <script>
    const toggles = document.querySelectorAll('.faq-toggle');
    toggles.forEach(toggle => {
      toggle.addEventListener('click', () => {
        const content = toggle.nextElementSibling;
        const icon = toggle.querySelector('.faq-icon');
        const isOpen = content.style.maxHeight && content.style.maxHeight !== '0px';
        // Close all first
        document.querySelectorAll('.faq-content').forEach(c => {
          c.style.maxHeight = null;
        });
        document.querySelectorAll('.faq-icon').forEach(i => {
          i.textContent = '+';
          i.classList.remove('rotate-135');
        });
        // Then toggle selected one
        if (!isOpen) {
          content.style.maxHeight = content.scrollHeight + 'px';
          icon.textContent = '–';
          icon.classList.add('rotate-135');
        }
      });
    });
  </script>
</section>



		<!-- App Section -->

		<!-- /App Section -->

		<!-- Article Section -->
		<section class="article-section">
			<div class="container-box">
				<div class="section-header sec-header-one text-center aos" data-aos="fade-up">
					<span class="badge badge-primary">Recent Blogs</span>
					<h2>Stay Updated With Our Latest Blog</h2>
				</div>
				<div class="row g-4">
					<div class="col-lg-6">
						<div class="article-item aos" data-aos="fade-up">
							<div class="article-img">
								<a href="blog-details.php">
									<img src="assets/lupicad/IndexBlog/Relationship.png" class="img-fluid" alt="img">
								</a>

							</div>
							<div class="article-info">
								<span class="badge badge-cyan mb-2">Relationship</span>
								<h6 class="mb-2"><a href="blog-details.php">The Power of Intimacy in a Relationship</a>
								</h6>
								<p>Intimacy is the foundation of a strong and lasting relationship. It goes beyond
									physical closeness and encompasses emotional, mental, and even spiritual connections
									between partners. In today's fast-paced world, nurturing intimacy can sometimes take
									a backseat, but prioritizing it is essential for a fulfilling and harmonious bond.

								</p>
							</div>
						</div>
					</div>
					<div class="col-lg-6">
						<div class="article-item aos" data-aos="fade-up">
							<div class="article-img">
								<a href="blog-details.php">
									<img src="assets/lupicad/IndexBlog/Health.png" class="img-fluid" alt="img">
								</a>

							</div>
							<div class="article-info">
								<span class="badge badge-cyan mb-2">Health</span>
								<h6 class="mb-2"><a href="blog-details.php">The Power of a Healthy Lifestyle 
									</a></h6>
								<p>Maintaining good health is essential for a happy and fulfilling life. A healthy
									lifestyle not only improves physical well-being but also boosts mental and emotional
									health. In today's busy world, prioritizing health can sometimes be challenging, but
									small, consistent efforts can make a significant impact.</p>
							</div>
						</div>
					</div>
					<div class="col-lg-6">
						<div class="article-item aos" data-aos="fade-up">
							<div class="article-img">
								<a href="blog-details.php">
									<img src="assets/lupicad/IndexBlog/Immunity.png" class="img-fluid" alt="img">
								</a>

							</div>
							<div class="article-info">
								<span class="badge badge-cyan mb-2">Immunity</span>
								<h6 class="mb-2"><a href="blog-details.php">Boosting Immunity for a Healthier Life</a>
								</h6>
								<p>A strong immune system is the body's natural defense against illnesses, infections,
									and diseases. Maintaining good immunity requires a combination of healthy lifestyle
									choices, proper nutrition, and positive daily habits. In today's world, where
									exposure to viruses and bacteria is common, prioritizing immunity is more important
									than ever.</p>
							</div>
						</div>
					</div>
					<div class="col-lg-6">
						<div class="article-item aos" data-aos="fade-up">
							<div class="article-img">
								<a href="blog-details.php">
									<img src="assets/lupicad/IndexBlog/Stamina.png" class="img-fluid" alt="img">
								</a>

							</div>
							<div class="article-info">
								<span class="badge badge-cyan mb-2">Stamina</span>
								<h6 class="mb-2"><a href="blog-details.php">Enhancing Performance and Intimacy</a></h6>
								<p>A fulfilling and intimate relationship is built on trust, communication, and
									emotional connection. Physical intimacy plays a vital role in strengthening the bond
									between partners, creating a deeper sense of closeness and passion. Prioritizing a
									healthy and satisfying love life contributes to overall relationship happiness and
									well-being.</p>
							</div>
						</div>
					</div>
				</div>
				<div class="text-center load-item aos" data-aos="fade-up">
					<a href="blog-list.php" class="btn btn-dark">View All <i
							class="isax isax-arrow-right-3 ms-2"></i></a>
				</div>
			</div>
		</section>
		<!-- <div class="list-section">
			<div class="container-box">
				<div class="list-card card mb-0">
					<div class="card-body">
						<div
							class="d-flex align-items-center justify-content-center justify-content-xl-between flex-wrap gap-4 list-wraps">
							 <a href="booking.php" class="list-item aos" data-aos="fade-up">
									<div class="list-icon bg-secondary">
										<img src="assets/img/icons/list-icon-01.svg" alt="img">
									</div>
									<h6> ORDER TRACKING</h6>
								</a>  
							<a href="javascript:void(0)" class="list-item aos" data-aos="fade-up">
								<div class="list-icon bg-pink"> 
									<i class="fa-solid fa-truck-fast"></i>
								</div>
								<h6>FREE SHIPPING</h6>
							</a>
							<a href="javascript:void(0)" class="list-item aos" data-aos="fade-up">
								<div class="list-icon bg-cyan"> 
									<i class="fa-solid fa-credit-card"></i>
								</div>
								<h6>SECURED PAYMENT</h6>
							</a>
							<a href="javascript:void(0)" class="list-item aos" data-aos="fade-up">
								<div class="list-icon bg-purple"> 
									<i class="fa-solid fa-syringe"></i>
								</div>
								<h6>MEDICINE & SUPPLIES</h6>
							</a>
							<a href="javascript:void(0)" class="list-item aos" data-aos="fade-up">
								<div class="list-icon bg-orange"> 
									<i class="fa-solid fa-flask"></i>
								</div>
								<h6>LAB TESTING</h6>
							</a>
							<a href="javascript:void(0)" class="list-item aos" data-aos="fade-up">
								<div class="list-icon bg-teal">
									<i class="fa-solid fa-truck-ramp-box"></i> 
								</div>
								<h6>COD AVAILABLE</h6>
							</a>
						</div>
					</div>
				</div>
			</div>
		</div> -->
		<!-- /Article Section -->
		<section class="work-section" style="background: linear-gradient(90deg, #f8fafc 0%, #e0f7fa 100%); padding: 60px 0;">
  <div class="container-box">
    <div class="row mb-5">
      <div class="col-12">
        <div class="section-header-one aos text-start" data-aos="fade-up">
          <h5 style="color: #00796b; font-weight: 600;">How it Works</h5>
          <h2 class="section-title" style="font-size: 2.2rem; font-weight: 700; margin-bottom: 0;">4 easy steps to get your solution</h2>
        </div>
      </div>
    </div>
    <div class="row justify-content-center align-items-stretch g-4">
     <div class="col-md-6 col-lg-3">
  <div class="work-step-card h-100 text-center p-4 shadow-sm bg-white rounded-4 aos" data-aos="fade-up" style="transition: box-shadow 0.2s;">
    <div class="step-circle mb-3 mx-auto" style="width: 56px; height: 56px; background: #007cf0; color: #fff; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; font-weight: 700; box-shadow: 0 2px 8px rgba(0,0,0,0.08);">1</div>
    
    <!-- Flex container for icon and heading -->
    <div style="display: flex; align-items: center; justify-content: center; gap: 8px; margin-bottom: 12px;">
      <img src="assets/lupicad/IndexIcon/1.png" alt="search-doctor-icon" style="width: 24px; height: 24px;">
      <h5 style="font-weight: 600; margin: 0;">Search Medicine</h5>
    </div>

    <p style="font-size: 1rem; color: #555;">Search for the medicine you need based on its name, category, or usage.</p>
  </div>
</div>
     <div class="col-md-6 col-lg-3">
  <div class="work-step-card h-100 text-center p-4 shadow-sm bg-white rounded-4 aos" data-aos="fade-up" style="transition: box-shadow 0.2s;">
    <div class="step-circle mb-3 mx-auto" style="width: 56px; height: 56px; background: #00dfd8; color: #fff; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; font-weight: 700; box-shadow: 0 2px 8px rgba(0,0,0,0.08);">2</div>

    <div style="display: flex; align-items: center; justify-content: center; gap: 8px; margin-bottom: 12px;">
      <img src="assets/lupicad/IndexIcon/2.png" alt="doctor-profile-icon" style="width: 24px; height: 24px;">
      <h5 style="font-weight: 600; margin: 0;">Check Medicine Details</h5>
    </div>

    <p style="font-size: 1rem; color: #555;">Explore detailed information about the medicine, including its dosage, side effects, and reviews.</p>
  </div>
</div>
      <div class="col-md-6 col-lg-3">
  <div class="work-step-card h-100 text-center p-4 shadow-sm bg-white rounded-4 aos" data-aos="fade-up" style="transition: box-shadow 0.2s;">
    <div class="step-circle mb-3 mx-auto" style="width: 56px; height: 56px; background: #ffc03e; color: #fff; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; font-weight: 700; box-shadow: 0 2px 8px rgba(0,0,0,0.08);">3</div>

    <div style="display: flex; align-items: center; justify-content: center; gap: 8px; margin-bottom: 12px;">
      <img src="assets/lupicad/IndexIcon/3.png" alt="calendar-icon" style="width: 24px; height: 24px;">
      <h5 style="font-weight: 600; margin: 0;">Add to Cart</h5>
    </div>

    <p style="font-size: 1rem; color: #555;">Once you've found the right medicine, add it to your cart and proceed to checkout.</p>
  </div>
</div>

     <div class="col-md-6 col-lg-3">
  <div class="work-step-card h-100 text-center p-4 shadow-sm bg-white rounded-4 aos" data-aos="fade-up" style="transition: box-shadow 0.2s;">
    <div class="step-circle mb-3 mx-auto" style="width: 56px; height: 56px; background: #ff8d62; color: #fff; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; font-weight: 700; box-shadow: 0 2px 8px rgba(0,0,0,0.08);">4</div>

    <div style="display: flex; align-items: center; justify-content: center; gap: 8px; margin-bottom: 12px;">
      <img src="assets/lupicad/IndexIcon/4.png" alt="solution-icon" style="width: 24px; height: 24px;">
      <h5 style="font-weight: 600; margin: 0;">Get Your Medicine Delivered</h5>
    </div>

    <p style="font-size: 1rem; color: #555;">Complete your order and have your medicine delivered to your doorstep with ease.</p>
  </div>
</div>

    </div>
  </div>
</section>

		<!-- Info Section -->
		<section class="info-section">
			<div class="container-box">
				<div class="contact-info" style="background: linear-gradient(90deg, #003406 0%, #229e1f 100%) !important;">
					<div class="d-lg-flex align-items-center justify-content-between w-100 gap-4">
						<div class="mb-4 mb-lg-0 aos" data-aos="fade-up">
							<h6 class="display-6 text-white">Working for Your Better Health.</h6>
						</div>
						<div class="d-sm-flex align-items-center justify-content-lg-end gap-4 aos" data-aos="fade-up">
							<div class="con-info d-flex align-items-center mb-3 mb-sm-0">
								<span class="con-icon">
									<i class="isax isax-headphone"></i>
								</span>
								<div class="ms-2">
									<p class="text-white mb-1">Customer Support</p>
									<p class="text-white fw-medium mb-0"><a href="callto:+91 9718388999"
											style="color: white;">+91 9718388999</a></p>
								</div>
							</div>
							<div class="con-info d-flex align-items-center">
								<span class="con-icon">
									<i class="isax isax-message-2"></i>
								</span>
								<div class="ms-2">
									<p class="text-white mb-1">Drop Us an Email</p>
									<p class="text-white fw-medium mb-0"><a href="mailto:info@lupicad.com"
											style="color:white;"
											data-cfemail="8de4e3ebe2bcbfb8bbcde8f5ece0fde1e8a3eee2e0">info@lupicad.com</a>
									</p>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section> 
		<section class="partners-section">
			<div class="container-box">
				<div class="row">
					<div class="col-md-12">
						<div class="section-header-one text-center aos" data-aos="fade-up">
							<h2 class="section-title">Our Certificates</h2>
						</div>
					</div>
				</div>
				<div class="partners-info aos" data-aos="fade-up">
					<ul class="owl-carousel partners-slider d-flex">
						<li>
							<a href="javascript:void(0);">
								<img class="img-fluid" src="assets/lupicad/CERTIFICATES/1.png" alt="partners">
							</a>
						</li>
						<li>
							<a href="javascript:void(0);">
								<img class="img-fluid" src="assets/lupicad/CERTIFICATES/2.png" alt="partners">
							</a>
						</li>
						<li>
							<a href="javascript:void(0);">
								<img class="img-fluid" src="assets/lupicad/CERTIFICATES/3.png" alt="partners">
							</a>
						</li>
						<li>
							<a href="javascript:void(0);">
								<img class="img-fluid" src="assets/lupicad/CERTIFICATES/4.png" alt="partners">
							</a>
						</li>
						<li>
							<a href="javascript:void(0);">
								<img class="img-fluid" src="assets/lupicad/CERTIFICATES/5.png" alt="partners">
							</a>
						</li>
						<li>
							<a href="javascript:void(0);">
								<img class="img-fluid" src="assets/lupicad/CERTIFICATES/6.png" alt="partners">
							</a>
						</li>
 
					</ul>
				</div>
			</div>
		</section>
		<!-- /Info Section -->

		<!-- Footer Section -->
		<?php require_once(__DIR__ . "/components/footer.php") ?>

		<!-- /Footer Section -->

		<!-- Cursor -->
	
		<!-- /Cursor -->

	</div>
	<!-- /Main Wrapper -->

	<!-- jQuery -->
	<script data-cfasync="false" src="../../cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>
	<script src="assets/js/jquery-3.7.1.min.js" type="290daf7fcf744922b4c3c7cf-text/javascript"></script>

	<!-- Bootstrap Bundle JS -->
	<script src="assets/js/bootstrap.bundle.min.js" type="290daf7fcf744922b4c3c7cf-text/javascript"></script>

	<!-- Feather Icon JS -->
	<script src="assets/js/feather.min.js" type="290daf7fcf744922b4c3c7cf-text/javascript"></script>

	<!-- select JS -->
	<script src="assets/plugins/select2/js/select2.min.js" type="290daf7fcf744922b4c3c7cf-text/javascript"></script>

	<!-- Datepicker JS -->
	<script src="assets/js/moment.min.js" type="290daf7fcf744922b4c3c7cf-text/javascript"></script>
	<script src="assets/js/bootstrap-datetimepicker.min.js" type="290daf7fcf744922b4c3c7cf-text/javascript"></script>

	<!-- Owl Carousel JS -->
	<script src="assets/js/owl.carousel.min.js" type="290daf7fcf744922b4c3c7cf-text/javascript"></script>

	<!-- Counter JS -->
	<script src="assets/js/counter.js" type="290daf7fcf744922b4c3c7cf-text/javascript"></script>

	<!-- Animation JS -->
	<script src="assets/js/aos.js" type="290daf7fcf744922b4c3c7cf-text/javascript"></script>

	<!-- Custom JS -->
	<script src="assets/js/script.js" type="290daf7fcf744922b4c3c7cf-text/javascript"></script>

	<script src="../../cdn-cgi/scripts/7d0fa10a/cloudflare-static/rocket-loader.min.js"
		data-cf-settings="290daf7fcf744922b4c3c7cf-|49" defer></script>
	<script defer
		src="https://static.cloudflareinsights.com/beacon.min.js/vcd15cbe7772f49c399c6a5babf22c1241717689176015"
		integrity="sha512-ZpsOmlRQV6y907TI0dKBHq9Md29nnaEIPlkf84rnaERnq6zvWvPUqr2ft8M1aS28oN72PdrCzSjY4U6VaAw1EQ=="
		data-cf-beacon='{"rayId":"926c475fd88591a3","version":"2025.1.0","serverTiming":{"name":{"cfExtPri":true,"cfL4":true,"cfSpeedBrain":true,"cfCacheStatus":true}},"token":"3ca157e612a14eccbb30cf6db6691c29","b":1}'
		crossorigin="anonymous"></script>

	<script type="text/javascript">
		$(document).ready(function() {
			// Initialize Slick Slider
			$('.image-slider .slider-container').slick({
				autoplay: true, // Auto slide images
				autoplaySpeed: 3000, // Slide interval in milliseconds (3 seconds)
				dots: false, // Show navigation dots
				arrows: false, // Disable left/right arrows
				infinite: true, // Enable infinite loop
				speed: 500, // Transition speed (500ms)
				fade: false, // Disable fade effect (slide effect instead)
				pauseOnHover: true // Pause auto-sliding when hovering over the slider
			});
		});
	</script>

	<script>
		document.querySelectorAll('.product-title').forEach(function(el) {
			const maxLength = 30;
			const originalText = el.textContent.trim();
			if (originalText.length > maxLength) {
				el.textContent = originalText.slice(0, maxLength) + '...';
			}
		});
	</script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/js/lightbox.min.js"></script>
</body>
</html>