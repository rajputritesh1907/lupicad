<?php
// Start the session
session_start();
// Include database connection
require_once(__DIR__ . "/backend/connection.inc.php");

$msg = "";

// Handle password update form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get user input from the form
    $email = mysqli_real_escape_string($connection, $_POST['email']);
    $new_password = mysqli_real_escape_string($connection, $_POST['password']);
    $confirm_password = mysqli_real_escape_string($connection, $_POST['confirm_password']);

    // Validate fields
    if (empty($email) || empty($new_password) || empty($confirm_password)) {
        $msg = "All fields are required.";
    } elseif ($new_password !== $confirm_password) {
        $msg = "Passwords do not match.";
    } else {
        // SQL query to check if the email exists
        $sql = "SELECT * FROM User WHERE email = ?";
        
        // Prepare and bind the statement
        $stmt = mysqli_prepare($connection, $sql);
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        
        // Get the result
        $result = mysqli_stmt_get_result($stmt);
        
        // Check if the user exists
        if (mysqli_num_rows($result) > 0) {
            // Update the password
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
            $update_sql = "UPDATE User SET password = ? WHERE email = ?";
            $update_stmt = mysqli_prepare($connection, $update_sql);
            mysqli_stmt_bind_param($update_stmt, "ss", $hashed_password, $email);
            if (mysqli_stmt_execute($update_stmt)) {
                header("Location: login.php"); // Redirect to login page after password update
                exit();
            } else {
                $msg = "Error updating password. Please try again.";
            }
        } else {
            $msg = "Email not found.";
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
                                        <h3>Create New Password</h3>
                                        <p>Enter your new password below to update it. Make sure your new password is strong and secure.</p>
                                    </div>
                                    <form action="update-password.php" method="POST">
                                        <div class="mb-3">
                                            <label class="form-label">Email</label>
                                            <input type="email" name="email" class="form-control" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">New Password</label>
                                            <input type="password" name="password" class="form-control" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Confirm Password</label>
                                            <input class="form-control" type="password" name="confirm_password" required>
                                        </div>
                                        <div class="mb-3">
                                            <button class="btn btn-primary-gradient w-100" type="submit">Submit</button>
                                        </div>
                                        <span style="color:red;"><?=$msg?></span>
                                        <div class="account-signup">
                                            <p>Remember Password? <a href="login.php">Sign In</a></p>
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
    <script src="assets/js/jquery-3.7.1.min.js" type="fe0aca4047a02f0783a0f2b0-text/javascript"></script>

    <!-- Bootstrap Core JS -->
    <script src="assets/js/bootstrap.bundle.min.js" type="fe0aca4047a02f0783a0f2b0-text/javascript"></script>

    <!-- Mobile Input -->
    <script src="assets/plugins/intltelinput/js/intlTelInput.js"
        type="fe0aca4047a02f0783a0f2b0-text/javascript"></script>

    <!-- Custom JS -->
    <script src="assets/js/script.js" type="fe0aca4047a02f0783a0f2b0-text/javascript"></script>

    <script src="../../cdn-cgi/scripts/7d0fa10a/cloudflare-static/rocket-loader.min.js"
        data-cf-settings="fe0aca4047a02f0783a0f2b0-|49" defer></script>
    <script defer
        src="https://static.cloudflareinsights.com/beacon.min.js/vcd15cbe7772f49c399c6a5babf22c1241717689176015"
        integrity="sha512-ZpsOmlRQV6y907TI0dKBHq9Md29nnaEIPlkf84rnaERnq6zvWvPUqr2ft8M1aS28oN72PdrCzSjY4U6VaAw1EQ=="
        data-cf-beacon='{"rayId":"926c47fa9cb691a3","version":"2025.1.0","serverTiming":{"name":{"cfExtPri":true,"cfL4":true,"cfSpeedBrain":true,"cfCacheStatus":true}},"token":"3ca157e612a14eccbb30cf6db6691c29","b":1}'
        crossorigin="anonymous"></script>
</body> 
</html>