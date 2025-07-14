<?php
// Include database connection
require_once(__DIR__ . "/backend/connection.inc.php");
require_once(__DIR__ . "/backend/function.inc.php");

$msg = " ";

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get user input from the form
    $name = mysqli_real_escape_string($connection, $_POST['name']);
    $phone = mysqli_real_escape_string($connection, $_POST['phone']);
    $email = mysqli_real_escape_string($connection, $_POST['email']);
    $password = mysqli_real_escape_string($connection, $_POST['password']);


	// $name = mysqli_real_escape_string($connection, get_safe_value($_POST['name']));
    // $phone = mysqli_real_escape_string($connection, get_safe_value($_POST['phone']));
    // $email = mysqli_real_escape_string($connection, get_safe_value($_POST['email']));
    // $password = mysqli_real_escape_string($connection, get_safe_value($_POST['password']));

    // Validate fields on the server-side
    if (empty($name) || empty($phone) || empty($email) || empty($password)) {
        $msg = "All fields are required";
    } else {
        // Validate email format
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $msg = "Invalid email format";
        }

        // Validate phone number (optional, depending on your phone format)
        $phonePattern = "/^[0-9]{10}$/"; // Adjust pattern based on your phone format
        if (!preg_match($phonePattern, $phone)) {
            $msg = "Invalid phone number";
        }

        // Validate password (optional, minimum length)
        if (strlen($password) < 8) {
            $msg = "Password must be at least 8 characters long"; 
        }

        // If all validations pass, proceed with checking for duplicate email
        if (filter_var($email, FILTER_VALIDATE_EMAIL) && preg_match($phonePattern, $phone) && strlen($password) >= 8) {

            // Check if email already exists in the database
            $check_email_sql = "SELECT * FROM user WHERE email = ?";
            $stmt = mysqli_prepare($connection, $check_email_sql);
            mysqli_stmt_bind_param($stmt, "s", $email);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            // If email already exists, show an error message
            if (mysqli_num_rows($result) > 0) {
                $msg = "Email already registered!";
            } else {
                // Hash the password for security
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                // SQL query to insert data into the database (use prepared statements for security)
                $sql = "INSERT INTO user (name, phone, email, password) VALUES (?, ?, ?, ?)";

                // Prepare and bind the statement
                $stmt = mysqli_prepare($connection, $sql);
                mysqli_stmt_bind_param($stmt, "ssss", $name, $phone, $email, $hashed_password);

                if (mysqli_stmt_execute($stmt)) {
                    echo "<script>alert('Registration successful!');</script>";
                    header("Location: login.php");
                    exit();
                } else {
                    $msg = "Error: " . mysqli_error($connection);
                }

                // Close the prepared statement
                mysqli_stmt_close($stmt);
            }
        }
    }
}

// Close connection
mysqli_close($connection);
?>






<!DOCTYPE html>
<html lang="en"> 

<head>

	<meta charset="utf-8">

	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description"
		content="The responsive professional Doccure template offers many features, like scheduling appointments with  top doctors, clinics, and hospitals via voice, video call & chat.">
	<meta name="keywords"
		content="practo clone, doccure, doctor appointment, Practo clone html template, doctor booking template">
	<meta name="author" content="Practo Clone HTML Template - Doctor Booking Template">
	<meta property="og:url" content="https://doccure.dreamstechnologies.com/html/">
	<meta property="og:type" content="website">
	<meta property="og:title" content="Doctors Appointment HTML Website Templates | Doccure">
	<meta property="og:description"
		content="The responsive professional Doccure template offers many features, like scheduling appointments with  top doctors, clinics, and hospitals via voice, video call & chat.">
	<meta property="og:image" content="assets/img/preview-banner.jpg">
	<meta name="twitter:card" content="summary_large_image">
	<meta property="twitter:domain" content="https://doccure.dreamstechnologies.com/html/">
	<meta property="twitter:url" content="https://doccure.dreamstechnologies.com/html/">
	<meta name="twitter:title" content="Doctors Appointment HTML Website Templates | Doccure">
	<meta name="twitter:description"
		content="The responsive professional Doccure template offers many features, like scheduling appointments with  top doctors, clinics, and hospitals via voice, video call & chat.">
	<meta name="twitter:image" content="assets/img/preview-banner.jpg">
	<title>Lupicad | Register</title>

	<!-- Favicon -->
	<link rel="shortcut icon" href="assets/lupicad/logo.svg" type="image/x-icon">
	<!-- Apple Touch Icon -->
	<link rel="apple-touch-icon" sizes="180x180" href="assets/img/apple-touch-icon.png">

	<!-- Theme Settings Js -->
	<script src="assets/js/theme-script.js" type="690690418a06c8a5b2e00d14-text/javascript"></script>

	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="assets/css/bootstrap.min.css">

	<!-- Fontawesome CSS -->
	<link rel="stylesheet" href="assets/plugins/fontawesome/css/fontawesome.min.css">
	<link rel="stylesheet" href="assets/plugins/fontawesome/css/all.min.css">

	<!-- Iconsax CSS-->
	<link rel="stylesheet" href="assets/css/iconsax.css">

	<!-- Feathericon CSS -->
	<link rel="stylesheet" href="assets/css/feather.css">

	<!-- Mobile CSS-->
	<link rel="stylesheet" href="assets/plugins/intltelinput/css/intlTelInput.css">
	<link rel="stylesheet" href="assets/plugins/intltelinput/css/demo.css">

	<!-- Main CSS -->
	<link rel="stylesheet" href="assets/css/custom.css">

</head>

<body class="account-page">
	
	<!-- Main Wrapper -->
	<div class="main-wrapper">

		<!-- Header -->
		<?php require_once(__DIR__ . "/components/header.php") ?>
		<!-- /Header -->

		<!-- Page Content -->
		<div class="content">
			<?php require_once(__DIR__ . "/components/header.php"); ?>
			<div class="container-fluid">

				<div class="row">
					<div class="col-md-8 offset-md-2">

						<!-- Login Tab Content -->
						<div class="account-content">
							<div class="row align-items-center justify-content-center">
								<div class="col-md-7 col-lg-6 login-left">
									<img src="assets/img/login-banner.png" class="img-fluid" alt="Doccure Login">
								</div>
								<div class="col-md-12 col-lg-6 login-right">
									<div class="login-header ">
										<h3> Register Now <a href="doctor-register.php"></a></h3>
									</div>
									<form method="POST" action="" name="registerForm" onsubmit="return validateForm()">
										<div class="mb-3">
											<label class="form-label">Name</label>
											<input type="text" name="name" class="form-control" required>
										</div>
										<div class="mb-3">
											<label class="form-label">Phone</label>
											<input type="text" name="phone" class="form-control" required>
										</div>
										<div class="mb-3">
											<label class="form-label">Email</label>
											<input type="email" name="email" class="form-control" required>
										</div>
										<div class="mb-3">
											<label class="form-label">Create Password</label>
											<input type="password" name="password" class="form-control" required>
										</div>
										<div class="mb-3">
											<button class="btn btn-primary-gradient w-100" type="submit">Sign
												Up</button>
										</div>
										<span style="color:red;"><?= $msg ?></span>
										<div class="login-or">
											<span class="or-line"></span>
											<span class="span-or">or</span>
										</div>
										<div class="social-login-btn">
											<a href="javascript:void(0);" class="btn w-100">
												<img src="assets/img/icons/google-icon.svg" alt="google-icon">Sign in
												With Google
											</a>
											<a href="javascript:void(0);" class="btn w-100">
												<img src="assets/img/icons/facebook-icon.svg" alt="fb-icon">Sign in With
												Facebook
											</a>
										</div>
										<div class="account-signup">
											<p>Already have account? <a href="login.php">Sign In</a></p>
										</div>
									</form>

								</div>
							</div>
						</div>
						<!-- /Login Tab Content -->

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
	<script src="assets/js/jquery-3.7.1.min.js" type="690690418a06c8a5b2e00d14-text/javascript"></script>

	<!-- Bootstrap Core JS -->
	<script src="assets/js/bootstrap.bundle.min.js" type="690690418a06c8a5b2e00d14-text/javascript"></script>

	<!-- Mobile Input -->
	<script src="assets/plugins/intltelinput/js/intlTelInput.js"
		type="690690418a06c8a5b2e00d14-text/javascript"></script>

	<!-- Custom JS -->
	<script src="assets/js/script.js" type="690690418a06c8a5b2e00d14-text/javascript"></script>

	<script src="../../cdn-cgi/scripts/7d0fa10a/cloudflare-static/rocket-loader.min.js"
		data-cf-settings="690690418a06c8a5b2e00d14-|49" defer></script>
	<script defer
		src="https://static.cloudflareinsights.com/beacon.min.js/vcd15cbe7772f49c399c6a5babf22c1241717689176015"
		integrity="sha512-ZpsOmlRQV6y907TI0dKBHq9Md29nnaEIPlkf84rnaERnq6zvWvPUqr2ft8M1aS28oN72PdrCzSjY4U6VaAw1EQ=="
		data-cf-beacon='{"rayId":"926c48123bd791a3","version":"2025.1.0","serverTiming":{"name":{"cfExtPri":true,"cfL4":true,"cfSpeedBrain":true,"cfCacheStatus":true}},"token":"3ca157e612a14eccbb30cf6db6691c29","b":1}'
		crossorigin="anonymous"></script>

	<!-- <script type="text/javascript">
		function validateForm() {
			// Get form elements
			var name = document.forms["registerForm"]["name"].value;
			var phone = document.forms["registerForm"]["phone"].value;
			var email = document.forms["registerForm"]["email"].value;
			var password = document.forms["registerForm"]["password"].value;

			// Validate name (not empty)
			if (name == "") {
				alert("Name must be filled out.");
				return false;
			}

			// Validate phone (should contain numbers and be valid length)
			var phonePattern = /^[0-9]{10}$/; // Adjust based on your phone number format
			if (!phone.match(phonePattern)) {
				alert("Please enter a valid phone number.");
				return false;
			}

			// Validate email (basic email format)
			var emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
			if (!email.match(emailPattern)) {
				alert("Please enter a valid email address.");
				return false;
			}

			// Validate password (length and strength check)
			if (password.length < 8) {
				alert("Password must be at least 8 characters long.");
				return false;
			}

			return true;
		}
	</script> -->
</body> 

</html>
