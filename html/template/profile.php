<?php
require_once(__DIR__ . "/backend/connection.inc.php");
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch user profile
$stmt = $connection->prepare("SELECT * FROM user WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();

$error = "";
$success = "";

// ---------- PROFILE UPDATE FORM ----------
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['update_profile'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $dob = $_POST['dob'];
    $mobile = $_POST['mobile'];
    $address = $_POST['address'];
    $bio = $_POST['bio'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $zip = $_POST['zip'];
    $country = $_POST['country'];

    // Handle image upload
    if (!is_dir('./uploads/users')) {
        mkdir('./uploads/users', 0777, true);
    }
    $imagePath = null;
    if (!empty($_FILES['profile_image']['name'])) {
        $file_name = basename($_FILES['profile_image']['name']);
        $target_dir = "./uploads/users/";
        $target_file = $target_dir . time() . "_" . $file_name;

        if (move_uploaded_file($_FILES["profile_image"]["tmp_name"], $target_file)) {
            $imagePath = $target_file;
        }
    } else {
        // Keep the existing image
        $getImage = $connection->prepare("SELECT profile_image FROM user WHERE id = ?");
        $getImage->bind_param("i", $user_id);
        $getImage->execute();
        $result = $getImage->get_result();
        $row = $result->fetch_assoc();
        $imagePath = $row['profile_image'];
        $getImage->close();
    }

    // Format DOB
    $dob = date('Y-m-d', strtotime(mysqli_real_escape_string($connection, $dob)));

    $stmt = $connection->prepare("UPDATE user SET name=?, email=?, dob=?, mobile=?, address=?, bio=?, city=?, state=?, zip=?, country=?, profile_image=? WHERE id=?");
    $stmt->bind_param("sssssssssssi", $name, $email, $dob, $mobile, $address, $bio, $city, $state, $zip, $country, $imagePath, $user_id);

    if ($stmt->execute()) {
        $success = "Profile updated successfully.";
    } else {
        $error = "Failed to update profile.";
    }

    $stmt->close();
    header("Location: profile.php");
    exit();
}

$userProfile = $user;


// --------------------------------- order history ------------------------------------------//
// Fetch order history
$stmt = $connection->prepare("SELECT * FROM orders WHERE user_id = ? ORDER BY order_date DESC");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$orderHistory = [];
while ($row = $result->fetch_assoc()) {
    $orderHistory[] = $row;
}
$stmt->close();
// ---------------------------------/order history ------------------------------------------//

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupicad | User Profile</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="assets/lupicad/logo.svg" type="image/x-icon">
    <!-- Apple Touch Icon -->
    <link rel="apple-touch-icon" sizes="180x180" href="assets/img/apple-touch-icon.png">

    <!-- Theme Settings Js -->
    <script src="assets/js/theme-script.js" type="text/javascript"></script>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">

    <!-- Fontawesome CSS -->
    <link rel="stylesheet" href="assets/plugins/fontawesome/css/fontawesome.min.css">
    <link rel="stylesheet" href="assets/plugins/fontawesome/css/all.min.css">

    <!-- Iconsax CSS-->
    <link rel="stylesheet" href="assets/css/iconsax.css">

    <!-- Feathericon CSS -->
    <link rel="stylesheet" href="assets/css/feather.css">

    <!-- Fancybox CSS -->
    <link rel="stylesheet" href="assets/plugins/fancybox/jquery.fancybox.min.css">

    <!-- Main CSS -->
    <link rel="stylesheet" href="assets/css/custom.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#changePasswordBtn').on('click', function (e) {
                e.preventDefault();
    
                // Serialize form data
                var formData = $('#changePasswordForm').serialize();
    
                // Clear any previous error messages
                $('#passwordError').remove();
    
                $.ajax({
                    url: './backend/UserProfileUpdate.php', // The PHP file to handle the request
                    type: 'POST',
                    data: formData,
                    success: function (response) {
                        console.log(response); // Debug the raw response
                        try {
                            // Parse the response if it's a string
                            if (typeof response === 'string') {
                                response = JSON.parse(response);
                            }
    
                            if (response.success) {
                                showToast('Password changed successfully', 'success'); // Show success message
                                $('#changePasswordForm')[0].reset(); // Reset the form
                            } else {
                                // Display error message above the "Old Password" input box
                                var errorHtml = '<div id="passwordError" class="alert alert-danger">' + response.error + '</div>';
                                $('input[name="old_password"]').before(errorHtml);
                            }
                        } catch (e) {
                            console.error('Invalid JSON response:', response);
                            showToast('An unexpected error occurred', 'danger');
                        }
                    },
                    error: function (xhr, status, error) {
                        // Handle error response
                        console.error('An error occurred:', xhr.responseText);
                        showToast('An unexpected error occurred', 'danger');
                    }
                });
            });
        });
    </script>
</head>
 
<body>
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
                                <li class="breadcrumb-item active">User Profile</li>
                            </ol>
                            <h2 class="breadcrumb-title">User Profile</h2>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Breadcrumb -->

        <!-- Profile Section -->
        <div>

        </div>
        <div class="row mx-auto my-2 px-md-5 px-lg-10">
            <div class="col-md-12">
                <div class="profile-header">
                    <div class="row align-items-center">
                        <div class="col-auto profile-image">
                            <a href="#">
                                <?php if (isset($userProfile['profile_image']) && !empty($userProfile['profile_image'])): ?>
                                    <img class="rounded-circle" alt="User Image" style="height: 90px; width:90px ;margin:auto" src="<?= htmlspecialchars($userProfile['profile_image']) ?>">
                                <?php else: ?>
                                    <div class="btn btn-md btn-primary-gradient d-inline-flex align-items-center rounded-pill "
                                        style="padding: .65rem 1.9rem;font-size: 3rem;">
                                        <?php echo strtoupper(substr((htmlspecialchars($userProfile['name'])), 0, 1)); ?>
                                    </div>
                                <?php endif; ?>
                            </a>
                        </div>
                        <div class="col ml-md-n2 profile-user-info">
                            <h4 class="user-name mb-0"><?= htmlspecialchars($userProfile['name']) ?></h4>
                            <h6 class="text-muted"><?= htmlspecialchars($userProfile['email']) ?></h6>
                            <div class="user-Location"><i class="fa-solid fa-location-dot"></i> <?= htmlspecialchars($userProfile['address']) ?></div>
                            <div class="about-text"><?= htmlspecialchars($userProfile['bio']) ?></div>
                        </div>
                    </div>
                </div>
                <div class="profile-menu" style="margin:2% 0;">
                    <ul class="nav nav-tabs nav-tabs-solid">
                        <li class="nav-item">
                            <a class="nav-link active" data-bs-toggle="tab" href="#per_details_tab">About</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#password_tab">Password</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#order_history_tab">Order History</a>
                        </li>
                    </ul>
                </div>
                <div class="tab-content profile-tab-cont">

                    <!-- Personal Details Tab -->
                    <div class="tab-pane fade show active" id="per_details_tab">
                        <!-- Personal Details -->
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title d-flex justify-content-between">
                                            <span>Personal Details</span>
                                            <a class="edit-link" data-bs-toggle="modal" href="#edit_personal_details">
                                                <i class="fa fa-edit me-1"></i>Edit</a>
                                        </h5>
                                        <div class="row">
                                            <p class="col-sm-2 text-muted">Name</p>
                                            <p class="col-sm-10"><?= htmlspecialchars($userProfile['name']) ?></p>
                                        </div>
                                        <div class="row">
                                            <p class="col-sm-2 text-muted">Date of Birth</p>
                                            <p class="col-sm-10"><?= htmlspecialchars(date('d-m-Y', strtotime($userProfile['dob']))) ?></p>
                                        </div>
                                        <div class="row">
                                            <p class="col-sm-2 text-muted">Email ID</p>
                                            <p class="col-sm-10"><?= htmlspecialchars($userProfile['email']) ?></p>
                                        </div>
                                        <div class="row">
                                            <p class="col-sm-2 text-muted">Mobile</p>
                                            <p class="col-sm-10"><?= htmlspecialchars($userProfile['mobile']) ?></p>
                                        </div>
                                        <div class="row">
                                            <p class="col-sm-2 text-muted">Address</p>
                                            <p class="col-sm-10 mb-0">
                                                <?= htmlspecialchars($userProfile['address']) ?>, <?= htmlspecialchars($userProfile['state']) ?>, <?= htmlspecialchars($userProfile['zip']) ?>, <?= htmlspecialchars($userProfile['country']) ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <!-- Edit Details Modal -->
                                <div class="modal fade" id="edit_personal_details" aria-hidden="true" role="dialog">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Edit Personal Details</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form method="POST" action="" enctype="multipart/form-data">
                                                    <div class="row">
                                                        <div class="col-md-6 mb-3">
                                                            <label for="name" class="form-label">Name</label>
                                                            <input type="text" class="form-control" id="name" name="name" value="<?= htmlspecialchars($userProfile['name']) ?>" required>
                                                        </div>
                                                        <div class="col-md-6 mb-3">
                                                            <label for="email" class="form-label">Email</label>
                                                            <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($userProfile['email']) ?>" required>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6 mb-3">
                                                            <label for="dob" class="form-label">Date of Birth</label>
                                                            <input type="date" class="form-control" id="dob" name="dob"
                                                                value="<?= htmlspecialchars($userProfile['dob']) ?>"
                                                                min="<?= date('Y-m-d', strtotime('-120 years')) ?>"
                                                                max="<?= date('Y-m-d', strtotime('-15 years')) ?>"
                                                                required>
                                                        </div>
                                                        <div class="col-md-6 mb-3">
                                                            <label for="mobile" class="form-label">Mobile</label>
                                                            <input type="text" class="form-control" id="mobile" name="mobile" value="<?= htmlspecialchars($userProfile['mobile']) ?>" required>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6 mb-3">
                                                            <label for="address" class="form-label">Address</label>
                                                            <textarea class="form-control" id="address" name="address" rows="2" required><?= htmlspecialchars($userProfile['address']) ?></textarea>
                                                        </div>
                                                        <div class="col-md-6 mb-3">
                                                            <label for="bio" class="form-label">Bio</label>
                                                            <textarea class="form-control" id="bio" name="bio" rows="2"><?= htmlspecialchars($userProfile['bio']) ?></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6 mb-3">
                                                            <label for="city" class="form-label">City</label>
                                                            <input type="text" class="form-control" id="city" name="city" value="<?= htmlspecialchars($userProfile['city']) ?>" required>
                                                        </div>
                                                        <div class="col-md-6 mb-3">
                                                            <label for="state" class="form-label">State</label>
                                                            <input type="text" class="form-control" id="state" name="state" value="<?= htmlspecialchars($userProfile['state']) ?>" required>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6 mb-3">
                                                            <label for="zip" class="form-label">ZIP Code</label>
                                                            <input type="text" class="form-control" id="zip" name="zip" value="<?= htmlspecialchars($userProfile['zip']) ?>" required>
                                                        </div>
                                                        <div class="col-md-6 mb-3">
                                                            <label for="country" class="form-label">Country</label>
                                                            <input type="text" class="form-control" id="country" name="country" value="<?= htmlspecialchars($userProfile['country']) ?>" required>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12 mb-3">
                                                            <label for="profile_image" class="form-label">Profile Image</label>
                                                            <input type="file" class="form-control" id="profile_image" name="profile_image">
                                                            <?php if (!empty($userProfile['profile_image'])): ?>
                                                                <img src="<?= htmlspecialchars($userProfile['profile_image']) ?>" alt="Profile Image" class="img-thumbnail mt-2" style="width: 100px;">
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>
                                                    <button type="submit" name="update_profile" class="btn btn-primary w-100">Save Changes</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Password Change Tab -->
                    <div id="password_tab" class="tab-pane fade">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Change Password</h5>
                                <?php if (!empty($error)): ?>
                                    <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
                                <?php elseif (!empty($success)): ?>
                                    <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
                                <?php endif; ?>
                                <form id="changePasswordForm">
                                    <input type="hidden" name="change_password" value="1">
                                    <div class="mb-3">
                                        <label class="mb-2">Old Password</label>
                                        <input type="password" class="form-control" name="old_password" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="mb-2">New Password</label>
                                        <input type="password" class="form-control" name="new_password" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="mb-2">Confirm Password</label>
                                        <input type="password" class="form-control" name="confirm_password" required>
                                    </div>
                                    <button type="button" id="changePasswordBtn" class="btn btn-primary">Save Changes</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- /Password Change Tab -->
                    <!-- Order History Tab -->
                    <div id="order_history_tab" class="tab-pane fade">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Order History</h5>
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Order ID</th>
                                                <th><center>Date</center></th>
                                                <th><center>Payment Method</center></th>
                                                <th>Subtotal</th>
                                                <th>Tax</th>
                                                <th>Total</th>
                                                <th>Status</th>
                                                <th><center>Payment Id</center></th>
                                                <!-- <th>Actions</th> -->
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (empty($orderHistory)){ ?>
                                                <tr>
                                                    <td colspan="8" class="text-center">No orders found.</td>
                                                </tr>
                                            <?php }else{ ?>
                                            <?php foreach ($orderHistory as $order): ?>
                                                <tr>
                                                    <td><?= htmlspecialchars($order['id']) ?></td>
                                                    <td><center><?= htmlspecialchars(date('d-m-Y', strtotime($order['order_date']))) ?></center></td>
                                                    <td><center><?= htmlspecialchars($order['payment_method']) ?></center></td>
                                                    <td>₹<?= htmlspecialchars(number_format($order['subtotal'], 2)) ?></td>
                                                    <td>₹<?= htmlspecialchars(number_format($order['tax'], 2)) ?></td>
                                                    <td>₹<?= htmlspecialchars(number_format($order['total_amount'], 2)) ?></td>
                                                    <td><span class="badge bg-success"><?= htmlspecialchars($order['status']) ?></span></td>
                                                    <td><center><?= !empty($order['paymentId']) ? htmlspecialchars($order['paymentId']): '-' ?></center></td>
                                                    <!-- <td><a href="#" class="btn btn-primary">View</a></td> -->
                                                </tr>
                                            <?php endforeach; }?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Bootstrap Core JS -->
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery -->
    <script data-cfasync="false" src="../../../cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>
    <script src="assets/js/jquery-3.7.1.min.js" type="f2cc1f2a26701a08f9623835-text/javascript"></script>

    <!-- Bootstrap Core JS -->
    <script src="assets/js/bootstrap.bundle.min.js" type="f2cc1f2a26701a08f9623835-text/javascript"></script>

    <!-- Slimscroll JS -->
    <script src="assets/plugins/slimscroll/jquery.slimscroll.min.js"
        type="f2cc1f2a26701a08f9623835-text/javascript"></script>

    <!-- Bootstrap Datetimepicker JS -->
    <script src="assets/js/moment.min.js" type="f2cc1f2a26701a08f9623835-text/javascript"></script>
    <script src="assets/js/bootstrap-datetimepicker.min.js" type="f2cc1f2a26701a08f9623835-text/javascript"></script>

    <!-- Custom JS -->
    <script src="assets/js/script.js" type="f2cc1f2a26701a08f9623835-text/javascript"></script>

    <script src="../../../cdn-cgi/scripts/7d0fa10a/cloudflare-static/rocket-loader.min.js"
        data-cf-settings="f2cc1f2a26701a08f9623835-|49" defer></script>
    <script defer
        src="https://static.cloudflareinsights.com/beacon.min.js/vcd15cbe7772f49c399c6a5babf22c1241717689176015"
        integrity="sha512-ZpsOmlRQV6y907TI0dKBHq9Md29nnaEIPlkf84rnaERnq6zvWvPUqr2ft8M1aS28oN72PdrCzSjY4U6VaAw1EQ=="
        data-cf-beacon='{"rayId":"926c555aaef8546b","version":"2025.1.0","serverTiming":{"name":{"cfExtPri":true,"cfL4":true,"cfSpeedBrain":true,"cfCacheStatus":true}},"token":"3ca157e612a14eccbb30cf6db6691c29","b":1}'
        crossorigin="anonymous"></script>
</body>

</html>