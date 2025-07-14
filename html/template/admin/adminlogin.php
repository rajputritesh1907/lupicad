<?php
session_start();
require(__DIR__ . "/../backend/connection.inc.php");

$msg = "";

if(isset($_GET['logout']) && $_GET['logout'] == "true") {
    // Clear session variables
    $_SESSION = array();

    // Destroy the session
    session_destroy();

    // Prevent browser from going back
    echo "<script>window.history.replaceState({}, '', window.location.pathname);</script>";
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = mysqli_real_escape_string($connection, $_POST['email']);
    $password = mysqli_real_escape_string($connection, $_POST['password']);

    if (empty($email) || empty($password)) {
        echo "<script>alert('Both email and password are required');</script>";
    } else {
        $sql = "SELECT * FROM admins WHERE email = ?";
        $stmt = mysqli_prepare($connection, $sql);
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($result) > 0) {
            $admin = mysqli_fetch_assoc($result);

            if (password_verify($password, $admin['password'])) {
                $_SESSION['admin_id'] = $admin['id'];
                $_SESSION['admin_email'] = $admin['email'];

                // Check if profile fields are filled
                $isProfileComplete = !empty($admin['name']) && 
									 !empty($admin['email']) && 
                                     !empty($admin['address']) && 
                                     !empty($admin['city']) && 
                                     !empty($admin['state']) && 
                                     !empty($admin['country']) &&
                                     !empty($admin['mobile']) &&
                                     !empty($admin['bio']) &&
                                     !empty($admin['dob']) &&
                                     !empty($admin['profile_image']);

                // Redirect accordingly
                if ($isProfileComplete) {
                    header("Location: profile.php");
                } else {
                    header("Location: admin-about.php");
                }
                exit();
            } else {
                $msg = "Incorrect password or Email ID";
            }
        } else {
            $msg = "Incorrect password or Email ID";
        }

        mysqli_stmt_close($stmt);
    }
}

mysqli_close($connection);
?>


<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">	
        <title>Lupicad - Login</title>
		
		<!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="../assets/lupicad/logo.svg">


		<!-- Bootstrap CSS -->
        <link rel="stylesheet" href="assets/css/bootstrap.min.css">
		
		<!-- Fontawesome CSS -->
		<link rel="stylesheet" href="assets/plugins/fontawesome/css/fontawesome.min.css">
		<link rel="stylesheet" href="assets/plugins/fontawesome/css/all.min.css">
		
		<!-- Main CSS -->
        <link rel="stylesheet" href="assets/css/custom.css">
		<script>
			window.history.replaceState({}, '', window.location.pathname);
        </script>
        
    </head>
    <body>
	
		<!-- Main Wrapper -->
        <div class="main-wrapper login-body">
            <div class="login-wrapper">
            	<div class="container">
                	<div class="loginbox">
                    	<div class="login-left">
							<img class="img-fluid" src="assets/img/logo1.png" alt="Logo">
                        </div>
                        <div class="login-right">
							<div class="login-right-wrap">
								<h1>Login</h1>
								<p class="account-subtitle">Access to our dashboard</p>
								
								<!-- Form -->
								<form method="POST" action="">
									<div class="mb-3">
										<input class="form-control" name="email" type="text" placeholder="Email">
									</div>
									<div class="mb-3">
										<input class="form-control" type="password" name="password" placeholder="Password">
									</div>
									<div class="mb-3">
										<button class="btn btn-primary w-100" type="submit">Login</button>
										<p style="color:red"><?= $msg?></p>
									</div>
								</form>
								<!-- /Form -->
								
								<div class="text-center forgotpass"><a href="forgot-password.php">Forgot Password?</a></div>
								<div class="login-or">
									<span class="or-line"></span>
									<span class="span-or">or</span>
								</div>
								  
								<!-- Social Login -->
								<div class="social-login">
									<span>Login with</span>
									<a href="#" class="facebook"><i class="fa-brands fa-facebook-f"></i></a><a href="#" class="google"><i class="fa-brands fa-google"></i></a>
								</div>
								<!-- /Social Login -->
								
								<div class="text-center dont-have">Don’t have an account? <a href="register.php">Register</a></div>
							</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
		<!-- /Main Wrapper -->

		
		<!-- jQuery -->
        <script src="assets/js/jquery-3.7.1.min.js"></script>
		
		<!-- Bootstrap Core JS -->
        <script src="assets/js/bootstrap.bundle.min.js"></script>
		
		<!-- Custom JS -->
		<script src="assets/js/script.js"></script>
		
    <script src="../../../cdn-cgi/scripts/7d0fa10a/cloudflare-static/rocket-loader.min.js" data-cf-settings="01fb6f4731c7107d53eee18e-|49" defer></script><script defer src="https://static.cloudflareinsights.com/beacon.min.js/vcd15cbe7772f49c399c6a5babf22c1241717689176015" integrity="sha512-ZpsOmlRQV6y907TI0dKBHq9Md29nnaEIPlkf84rnaERnq6zvWvPUqr2ft8M1aS28oN72PdrCzSjY4U6VaAw1EQ==" data-cf-beacon='{"rayId":"926c55606d89546b","version":"2025.1.0","serverTiming":{"name":{"cfExtPri":true,"cfL4":true,"cfSpeedBrain":true,"cfCacheStatus":true}},"token":"3ca157e612a14eccbb30cf6db6691c29","b":1}' crossorigin="anonymous"></script>
</body>
</html>