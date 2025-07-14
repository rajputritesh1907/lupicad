<?php
// Start the session
session_start();
// Include database connection
require_once(__DIR__ . "/backend/connection.inc.php");

$msg =" ";
// Handle login form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get user input from the form
    $email = mysqli_real_escape_string($connection, $_POST['email']);
    $password = mysqli_real_escape_string($connection, $_POST['password']);

    // Validate fields
    if (empty($email) || empty($password)) {
        echo "<script>alert('Both email and password are required');</script>";
    } else {
        // SQL query to check if the user exists
        $sql = "SELECT * FROM user WHERE email = ?";
        
        // Prepare and bind the statement
        $stmt = mysqli_prepare($connection, $sql);
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        
        // Get the result
        $result = mysqli_stmt_get_result($stmt);
        
        // Check if a user was found
        if (mysqli_num_rows($result) > 0) {
            $user = mysqli_fetch_assoc($result);
            
            // Verify the password
            if (password_verify($password, $user['password'])) {
                // Set session variables (user_id)
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_email'] = $user['email'];
                header("Location: index.php");  // You can change the destination to your preferred page
                exit();
            } else {
                // echo "<script>alert('Incorrect password');</script>";
				$msg ="Incorrect password or Email Id";
            }
        } else {
            // echo "<script>alert('No user found with that email');</script>";
			$msg ="Incorrect password or Email Id";
        }

        // Close the prepared statement
        mysqli_stmt_close($stmt);
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
		
		<title>Lupicad</title>
		
		<!-- Favicon -->
		<link rel="shortcut icon" href="assets/lupicad/logo.svg" type="image/x-icon">

		<!-- Apple Touch Icon -->
		<link rel="apple-touch-icon" sizes="180x180" href="assets/img/apple-touch-icon.png">

		<!-- Theme Settings Js -->
		<script src="assets/js/theme-script.js" type="5fa5e073e2f695d3703679b4-text/javascript"></script>
		
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
	<body class="account-page">

		<!-- Main Wrapper -->
		<div class="main-wrapper">
		
			<!-- Header -->
			<?php require_once(__DIR__ . "/components/header.php"); ?>
			<!-- /Header -->
			
			<!-- Page Content -->
			<div class="content">
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
										<div class="login-header">
											<h3>Login</h3>
										</div>
										<form method="POST" action="login.php">
										    <div class="mb-3">
										        <label class="form-label">E-mail</label>
										        <input type="email" class="form-control" name="email" required>
										    </div>
										    <div class="mb-3">
										        <div class="form-group-flex">
										            <label class="form-label">Password</label>
										            <a href="forgot-password.php" class="forgot-link">Forgot password?</a>
										        </div>
										        <div class="pass-group">
										            <input type="password" class="form-control pass-input" name="password" required>
										            <span class="feather-eye-off toggle-password"></span>
										        </div>
										    </div>
										    <div class="mb-3 form-check-box">
										        <div class="form-group-flex">
										            <div class="form-check mb-0">
										                <input class="form-check-input" type="checkbox" id="remember" checked>
										                <label class="form-check-label" for="remember">
										                    Remember Me  
										                </label>
										            </div>                                                
										            <div class="form-check mb-0">
										                <input class="form-check-input" type="checkbox" id="remember1">
										                <label class="form-check-label" for="remember1">
										                    Login OTP  
										                </label>
										            </div>
										        </div>
										    </div>
										    <div class="mb-3">
										        <button class="btn btn-primary-gradient w-100" type="submit">  Sign in</button>
										    </div>
											<span style="color:red;"><?=$msg?></span>
										    <div class="login-or">
										        <span class="or-line"></span>
										        <span class="span-or">or</span>
										    </div>
										    <div class="social-login-btn">
										        <a href="javascript:void(0);" class="btn w-100">
										            <img src="assets/img/icons/google-icon.svg" alt="google-icon">Sign in With Google
										        </a>
										        <a href="javascript:void(0);" class="btn w-100">
										            <img src="assets/img/icons/facebook-icon.svg" alt="fb-icon">Sign in With Facebook
										        </a>
										    </div>
										    <div class="account-signup">
										        <p>Don't have an account? <a href="register.php">Sign up</a></p>
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
		<script src="assets/js/jquery-3.7.1.min.js" type="5fa5e073e2f695d3703679b4-text/javascript"></script>
		
		<!-- Bootstrap Core JS -->
		<script src="assets/js/bootstrap.bundle.min.js" type="5fa5e073e2f695d3703679b4-text/javascript"></script>
		
		<!-- Custom JS -->
		<script src="assets/js/script.js" type="5fa5e073e2f695d3703679b4-text/javascript"></script>
		
	<script src="../../cdn-cgi/scripts/7d0fa10a/cloudflare-static/rocket-loader.min.js" data-cf-settings="5fa5e073e2f695d3703679b4-|49" defer></script><script defer src="https://static.cloudflareinsights.com/beacon.min.js/vcd15cbe7772f49c399c6a5babf22c1241717689176015" integrity="sha512-ZpsOmlRQV6y907TI0dKBHq9Md29nnaEIPlkf84rnaERnq6zvWvPUqr2ft8M1aS28oN72PdrCzSjY4U6VaAw1EQ==" data-cf-beacon='{"rayId":"926c4810f90359d6","version":"2025.1.0","serverTiming":{"name":{"cfExtPri":true,"cfL4":true,"cfSpeedBrain":true,"cfCacheStatus":true}},"token":"3ca157e612a14eccbb30cf6db6691c29","b":1}' crossorigin="anonymous"></script>
</body>
</html>