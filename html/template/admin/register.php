<?php

require(__DIR__ . "/../backend/connection.inc.php");

$msg = "";
// check url has adminlogin.php?lupicad=Admin&dev=Abhijeet&Access=true&AccessId=LupicadNew123 these values or redirct to loginpage
if (!isset($_GET['lupicad']) || $_GET['lupicad'] !== "Admin" || !isset($_GET['dev']) || $_GET['dev'] !== "Abhijeet" || !isset($_GET['Access']) || $_GET['Access'] !== "true" || !isset($_GET['AccessId']) || $_GET['AccessId'] !== "LupicadNew123") {
    header("Location: adminlogin.php");
    exit();
}


// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize user input
    $name = mysqli_real_escape_string($connection, $_POST['name']);
    $email = mysqli_real_escape_string($connection, $_POST['email']);
    $password = mysqli_real_escape_string($connection, $_POST['password']);
    $confirmpassword = mysqli_real_escape_string($connection, $_POST['confirmpassword']);

    // Validate input
    if (empty($name) || empty($email) || empty($password) || empty($confirmpassword)) {
        $msg = "All fields are required";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $msg = "Invalid email format";
    } elseif (strlen($password) < 8) {
        $msg = "Password must be at least 8 characters long";
    } elseif ($password !== $confirmpassword) {
        $msg = "Passwords do not match";
    } else {
        // Check if email already exists
        $check_email_sql = "SELECT * FROM admins WHERE email = ?";
        $stmt = mysqli_prepare($connection, $check_email_sql);
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($result) > 0) {
            $msg = "Email already registered!";
        } else {
            // Hash password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Insert new admin (only basic fields at registration)
            $sql = "INSERT INTO admins (name, email, password) VALUES (?, ?, ?)";
            $stmt = mysqli_prepare($connection, $sql);
            mysqli_stmt_bind_param($stmt, "sss", $name, $email, $hashed_password);

            if (mysqli_stmt_execute($stmt)) {
                echo "<script>alert('Registration successful!');</script>";
                header("Location: adminlogin.php");
                exit();
            } else {
                $msg = "Error: " . mysqli_error($connection);
            }

            mysqli_stmt_close($stmt);
        }
    }
}

mysqli_close($connection);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Register</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="image/x-icon" href="../assets/lupicad/logo.svg">

    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/plugins/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="assets/css/custom.css">
</head>
<body>

<div class="main-wrapper login-body">
    <div class="login-wrapper">
        <div class="container">
            <div class="loginbox">
                <div class="login-left">
                    <img class="img-fluid" src="assets/img/logo1.png" alt="Logo">
                </div>
                <div class="login-right">
                    <div class="login-right-wrap">
                        <h1>Register</h1>
                        <p class="account-subtitle">Access to our dashboard</p>

                        <!-- Registration Form -->
                        <form method="POST" action="">
                            <div class="mb-3">
                            
                                <input class="form-control" type="text" name="name" placeholder="Full Name" required>
                            </div>
                            <div class="mb-3">
                              
                                <input class="form-control" type="email" name="email" placeholder="Email Address" required>
                            </div>
                            <div class="mb-3">
                              
                                <input class="form-control" type="password" name="password" placeholder="Password" required>
                             
    
   
                            </div>
                            <div class="mb-3">
                               
                                <input class="form-control" type="password" name="confirmpassword" placeholder="Confirm Password" required>
                            </div>
                            <div class="mb-0">
                                <button class="btn btn-primary w-100" type="submit">Register</button>
                            </div>
                        </form>
                        <!-- /Registration Form -->

                        <div class="login-or">
                            <span class="or-line"></span>
                            <span class="span-or">or</span>
                        </div>

                        <!-- Social Login -->
                        <div class="social-login">
                            <span>Register with</span>
                            <a href="#" class="facebook"><i class="fab fa-facebook-f"></i></a>
                            <a href="#" class="google"><i class="fab fa-google"></i></a>
                        </div>
                        <!-- /Social Login -->

                        <div class="text-center dont-have">Already have an account? <a href="adminlogin.php">Login</a></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- JS Scripts -->
<script src="assets/js/jquery-3.7.1.min.js"></script>
<script src="assets/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/script.js"></script>
</body>
</html>