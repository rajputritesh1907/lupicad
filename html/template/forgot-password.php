<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
// require 'vendor/autoload.php';

session_start();
require_once("backend/connection.inc.php"); // Include database connection file

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['email']) && !isset($_POST['otp_code'])) {
        // Forgot Password: Step 1 - Send OTP to the user's email
        $email = mysqli_real_escape_string($connection, $_POST['email']);
        
        // Check if email exists in the database
        $sql = "SELECT * FROM User WHERE email = ?";
        $stmt = mysqli_prepare($connection, $sql);
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        
        if (mysqli_num_rows($result) > 0) {
            // Generate OTP
            $otp = rand(100000, 999999);

            // Store OTP and email in session for verification
            $_SESSION['otp'] = $otp;
            $_SESSION['email'] = $email;

            // Send OTP to the user's email
            $mail = new PHPMailer(true);
            try {
                $mail->isSMTP();
                $mail->Host = 'smtp.example.com'; // SMTP server (e.g., smtp.gmail.com)
                $mail->SMTPAuth = true;
                $mail->Username = 'your_email@example.com'; // SMTP username
                $mail->Password = 'your_password'; // SMTP password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;

                $mail->setFrom('your_email@example.com', 'Your App');
                $mail->addAddress($email);
                $mail->isHTML(true);
                $mail->Subject = 'Your OTP Code';
                $mail->Body    = 'Your OTP code is: ' . $otp;

                $mail->send();
                echo "<script>alert('OTP sent to your email');</script>";
            } catch (Exception $e) {
                echo "<script>alert('Message could not be sent. Mailer Error: {$mail->ErrorInfo}');</script>";
            }
        } else {
            echo "<script>alert('No account found with that email');</script>";
        }

        // Close the prepared statement
        mysqli_stmt_close($stmt);
    } elseif (isset($_POST['otp_code']) && isset($_SESSION['otp'])) {
        // OTP Verification: Step 2 - Verify OTP entered by user
        $entered_otp = $_POST['otp_code'];

        if ($entered_otp == $_SESSION['otp']) {
            // OTP verified, allow password reset
            $_SESSION['otp_verified'] = true;
            echo "<script>alert('OTP verified. Please reset your password.');</script>";
        } else {
            echo "<script>alert('Invalid OTP');</script>";
        }
    } elseif (isset($_POST['new_password']) && isset($_SESSION['otp_verified'])) {
        // Step 3: Reset Password - User enters new password
        $new_password = password_hash($_POST['new_password'], PASSWORD_DEFAULT);
        
        if (isset($_SESSION['email'])) {
            $email = $_SESSION['email'];
            $sql = "UPDATE User SET password = ? WHERE email = ?";
            $stmt = mysqli_prepare($connection, $sql);
            mysqli_stmt_bind_param($stmt, "ss", $new_password, $email);
            
            if (mysqli_stmt_execute($stmt)) {
                echo "<script>alert('Password reset successfully');</script>";
                unset($_SESSION['otp_verified'], $_SESSION['otp'], $_SESSION['email']);
                header("Location: login.php");
                exit();
            } else {
                echo "<script>alert('Error resetting password');</script>";
            }
        }
    }
}

mysqli_close($connection);
?>

<!DOCTYPE html> 
<html lang="en">
	
<head>
		
		<meta charset="utf-8">
		
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		
		<!-- Favicon -->
		<title>Lupicad | Forget Password</title>
		
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
                                    <h3>Forgot Password</h3>
                                    <p>Enter your email and we will send you a link to reset your password.</p>
                                </div>

                                <!-- Forgot Password Form -->
                                <?php if (!isset($_SESSION['otp_verified'])): ?>
                                    <form action="forgot-password.php" method="POST">
                                        <div class="mb-3">
                                            <label class="form-label">Email</label>
                                            <input class="form-control" type="email" name="email" required>
                                        </div>
                                        <div class="mb-3">
                                            <button class="btn btn-primary-gradient w-100" type="submit">Submit</button>
                                        </div>
                                    </form>
                                <?php elseif (isset($_SESSION['verification_code'])): ?>
                                    <!-- OTP Verification Form -->
                                    <form action="forgot-password.php" method="POST">
                                        <div class="mb-3">
                                            <label class="form-label">Enter Verification Code</label>
                                            <input class="form-control" type="text" name="otp_code" required>
                                        </div>
                                        <div class="mb-3">
                                            <button class="btn btn-primary-gradient w-100" type="submit">Verify</button>
                                        </div>
                                    </form>
                                <?php elseif (isset($_SESSION['otp_verified'])): ?>
                                    <!-- Reset Password Form -->
                                    <form action="forgot-password.php" method="POST">
                                        <div class="mb-3">
                                            <label class="form-label">New Password</label>
                                            <input class="form-control" type="password" name="new_password" required>
                                        </div>
                                        <div class="mb-3">
                                            <button class="btn btn-primary-gradient w-100" type="submit">Reset Password</button>
                                        </div>
                                    </form>
                                <?php endif; ?>

                                <div class="account-signup">
                                    <p>Remember your password? <a href="login.php">Sign In</a></p>
                                </div>
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
		<script src="assets/js/jquery-3.7.1.min.js" type="fe0aca4047a02f0783a0f2b0-text/javascript"></script>
		
		<!-- Bootstrap Core JS -->
		<script src="assets/js/bootstrap.bundle.min.js" type="fe0aca4047a02f0783a0f2b0-text/javascript"></script>

		<!-- Mobile Input -->
		<script src="assets/plugins/intltelinput/js/intlTelInput.js" type="fe0aca4047a02f0783a0f2b0-text/javascript"></script>
		
		<!-- Custom JS -->
		<script src="assets/js/script.js" type="fe0aca4047a02f0783a0f2b0-text/javascript"></script>
		
	<script src="../../cdn-cgi/scripts/7d0fa10a/cloudflare-static/rocket-loader.min.js" data-cf-settings="fe0aca4047a02f0783a0f2b0-|49" defer></script><script defer src="https://static.cloudflareinsights.com/beacon.min.js/vcd15cbe7772f49c399c6a5babf22c1241717689176015" integrity="sha512-ZpsOmlRQV6y907TI0dKBHq9Md29nnaEIPlkf84rnaERnq6zvWvPUqr2ft8M1aS28oN72PdrCzSjY4U6VaAw1EQ==" data-cf-beacon='{"rayId":"926c47fa9cb691a3","version":"2025.1.0","serverTiming":{"name":{"cfExtPri":true,"cfL4":true,"cfSpeedBrain":true,"cfCacheStatus":true}},"token":"3ca157e612a14eccbb30cf6db6691c29","b":1}' crossorigin="anonymous"></script>
</body>

</html>