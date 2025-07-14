<?php
session_start();

// The OTP stored on the server (In a real application, this should be dynamically generated and sent to the user via email).
$correct_otp = '1234';

// Flag to track OTP verification status
$otp_verified = false;

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the OTP entered by the user
    $entered_otp = $_POST['otp1'] . $_POST['otp2'] . $_POST['otp3'] . $_POST['otp4'];

    // Check if the entered OTP matches the correct OTP
    if ($entered_otp === $correct_otp) {
        // OTP is correct, set verification flag and redirect to password update page
        $_SESSION['otp_verified'] = true;
        header("Location: update-password.php");
        exit;
    } else {
        // OTP is incorrect, show error message
        $_SESSION['otp_verified'] = false;
        $error_message = 'Invalid OTP. Please try again.';
    }
}

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

    <style>
        .form {
            display: flex;
            flex-direction: column;
            width: 100%;
            justify-content: space-around;
            align-items: center;
        }

        .otp-container {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            max-width: 100%;
            /* Maximum width to fit smaller screens */
            width: 400px;
            /* Default width for larger screens */
            flex-wrap: wrap;
            /* Allows input fields to wrap on smaller screens */
            justify-content: center;
        }

        .otp-input {
            width: 50px;
            height: 50px;
            text-align: center;
            font-size: 24px;
            border: 2px solid #ccc;
            border-radius: 5px;
            transition: border-color 0.2s ease;
        }

        .otp-input:focus {
            border-color: #0084fd;
            outline: none;
        }

        /* Media Query for smaller screens */
        @media (max-width: 500px) {
            .otp-input {
                width: 40px;
                height: 40px;
                font-size: 20px;
            }

            .otp-container {
                max-width: 90%;
            }
        }
    </style>
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
                                        <h3>OTP Sent to Your Email</h3>
                                        <p>We have sent an OTP to your email address. Please check your inbox and enter
                                            the OTP below to continue.</p>
                                    </div>

                                    <!-- Show error message if OTP is incorrect -->
                                    <?php if (isset($error_message)): ?>
                                        <div class="alert alert-danger">
                                            <?php echo $error_message; ?>
                                        </div>
                                    <?php endif; ?>

                                    <!-- OTP Verification Form -->
                                    <form action="otp-verification.php" method="POST" class="form">
                                        <div class="otp-container">
                                            <input type="text" class="otp-input" maxlength="1" id="otp-1" name="otp1"
                                                oninput="moveFocus(event, 2)" onkeydown="moveBack(event, 1)">
                                            <input type="text" class="otp-input" maxlength="1" id="otp-2" name="otp2"
                                                oninput="moveFocus(event, 3)" onkeydown="moveBack(event, 2)">
                                            <input type="text" class="otp-input" maxlength="1" id="otp-3" name="otp3"
                                                oninput="moveFocus(event, 4)" onkeydown="moveBack(event, 3)">
                                            <input type="text" class="otp-input" maxlength="1" id="otp-4" name="otp4"
                                                oninput="moveFocus(event, 5)" onkeydown="moveBack(event, 4)">
                                        </div>
                                        <div class="mb-3">
                                            <button class="btn btn-primary-gradient w-200 center" type="submit"
                                                style="margin-top:2vh;">Submit</button>
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

    <script>
        function moveFocus(event, nextInputIndex) {
            const currentInput = event.target;
            const nextInput = document.getElementById(`otp-${nextInputIndex}`);
            if (currentInput.value.length === 1 && nextInput) {
                nextInput.focus();
            }
        }

        function moveBack(event, prevInputIndex) {
            if (event.key === 'Backspace') {
                const currentInput = event.target;
                if (currentInput.value === '') {
                    const prevInput = document.getElementById(`otp-${prevInputIndex}`);
                    if (prevInput) {
                        prevInput.focus();
                    }
                }
            }
        }
    </script>

</body>


</html>