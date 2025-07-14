<?php
session_start();
require(__DIR__ . "/../backend/connection.inc.php");

// Redirect if not logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: adminlogin.php");
    exit();
}

$msg = "";
$admin_id = $_SESSION['admin_id'];

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
       $address = mysqli_real_escape_string($connection, $_POST['address']);
    $mobile = mysqli_real_escape_string($connection, $_POST['mobile']);
    $bio = mysqli_real_escape_string($connection, $_POST['bio']);
    $dob = mysqli_real_escape_string($connection, $_POST['dob']);
    $city = mysqli_real_escape_string($connection, $_POST['city']);
    $state = mysqli_real_escape_string($connection, $_POST['state']);
    $zip = mysqli_real_escape_string($connection, $_POST['zip']);
    $country = mysqli_real_escape_string($connection, $_POST['country']);
    
   //create folder Admins in ../uploads/ if not exists
   if (!is_dir('../uploads/admins')) {
        mkdir('../uploads/admins', 0777, true);
    }
    $imagePath = null;
    if (!empty($_FILES['profile_image']['name'])) {
        $file_name = basename($_FILES['profile_image']['name']);

        $target_dir = "../uploads/admins/";
        $target_file = $target_dir . time() . "_" . $file_name;

        if (move_uploaded_file($_FILES["profile_image"]["tmp_name"], $target_file)) {
            $imagePath = $target_file;
        }
    }

    $dob = mysqli_real_escape_string($connection, $_POST['dob']);
    $dob = date('Y-m-d', strtotime($dob));

    $sql = "UPDATE admins SET address=?, mobile=?, bio=?, dob=STR_TO_DATE(?,'%Y-%m-%d'), city=?, state=?, zip=?, country=?, profile_image=? WHERE id=?";
    $stmt = mysqli_prepare($connection, $sql);
    mysqli_stmt_bind_param($stmt, "sssssssssi", $address, $mobile, $bio, $dob, $city, $state, $zip, $country, $imagePath, $admin_id);

    if (mysqli_stmt_execute($stmt)) {
        $msg = "Profile updated successfully!";
        mysqli_stmt_close($stmt);
        // Redirect to dashboard after two seconds
        header("refresh:1;url=Dashboard.php");
    } else {
        $msg = "Failed to update profile.";
        mysqli_stmt_close($stmt);
    }
}

$result = mysqli_query($connection, "SELECT * FROM admins WHERE id = $admin_id");
$admin = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Admin - About</title>
    <link rel="shortcut icon" type="image/x-icon" href="../assets/lupicad/logo.svg">
    <meta name="viewport" content="width=device-width, initial-scale=1">
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
                    <div class="container mt-5">
                        <h2>Admin Deatils</h2>
                        <?php if ($msg): ?>
                            <div class="alert alert-info"><?= $msg ?></div>
                        <?php endif; ?>
                        <form method="POST" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label>Mobile Number</label>
                                <input class="form-control" required type="text" name="mobile"
                                    value="<?= $admin['mobile'] ?? '' ?>" required>
                            </div>

                            <div class="mb-3">
                                <label>Date of Birth</label>
                                <input class="form-control" required type="date" name="dob" value="<?= $admin['dob'] ?? '' ?>"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label>Bio</label>
                                <textarea class="form-control" required name="bio" rows="3"><?= $admin['bio'] ?? '' ?></textarea>
                            </div>
                            <div class="row">
                                
                                <div class="col-12">
                                    <h5 class="form-title"><span>Address</span></h5>
                                </div>
                                <div class="mb-3">
                                    <label>Address</label>
                                    <textarea class="form-control" required name="address"
                                        required><?= $admin['address'] ?? '' ?></textarea>
                                </div>
                                <div class="col-12 col-sm-6">
                                    <div class="mb-3">
                                        <label class="mb-2">City</label>
                                        <input type="text" class="form-control" required name="city" value="<?= $admin['city'] ?? '' ?>"
                                        required>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6">
                                    <div class="mb-3">
                                        <label class="mb-2">State</label>
                                        <input type="text" class="form-control" required name="state"
                                        value="<?= $admin['state'] ?? '' ?>" required>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6">
                                    <div class="mb-3">
                                        <label class="mb-2">Zip Code</label>
                                        <input type="text" class="form-control" required name="zip" value="<?= $admin['zip'] ?? '' ?>"
                                        required>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6">
                                    <div class="mb-3">
                                        <label class="mb-2">Country</label>
                                        <input type="text" class="form-control" required name="country"
                                        value="<?= $admin['country'] ?? '' ?>" required>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label>Upload Profile Image</label><br>
                                <?php if (!empty($admin['profile_image'])): ?>
                                    <img src="<?= $admin['profile_image'] ?>" alt="Profile Image" width="100"
                                        class="mb-2"><br>
                                <?php endif; ?>
                                <input class="form-control" required type="file" name="profile_image">
                            </div>
                            <button class="btn btn-primary" href="profile.php">Save</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="assets/js/jquery-3.7.1.min.js"></script>
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/script.js"></script>
</body>

</html>