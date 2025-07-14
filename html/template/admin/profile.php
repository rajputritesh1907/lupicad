<?php
require_once(__DIR__ . "/../backend/connection.inc.php");
session_start();

// if (!isset($_SESSION['admin_id'])) {
// 	header("Location: login.php");
// 	exit();
// }`

$admin_id = $_SESSION['admin_id'];

// Fetch admin profile
$stmt = $connection->prepare("SELECT * FROM admins WHERE id = ?");
$stmt->bind_param("i", $admin_id);
$stmt->execute();
$result = $stmt->get_result();
$admin = $result->fetch_assoc();
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
	} else {
		// Keep the existing image
		$getImage = $connection->prepare("SELECT profile_image FROM admins WHERE id = ?");
		$getImage->bind_param("i", $admin_id);
		$getImage->execute();
		$result = $getImage->get_result();
		$row = $result->fetch_assoc();
		$imagePath = $row['profile_image'];
		$getImage->close();
	}

	// Format DOB
	$dob = date('Y-m-d', strtotime(mysqli_real_escape_string($connection, $dob)));

	$stmt = $connection->prepare("UPDATE admins SET name=?, email=?, dob=?, mobile=?, address=?, bio=?, city=?, state=?, zip=?, country=?, profile_image=? WHERE id=?");
	$stmt->bind_param("sssssssssssi", $name, $email, $dob, $mobile, $address, $bio, $city, $state, $zip, $country, $imagePath, $admin_id);

	if ($stmt->execute()) {
		$success = "Profile updated successfully.";
	} else {
		$error = "Failed to update profile.";
	}

	$stmt->close();
	header("Location: profile.php");
	exit();
}

$error = "";
$success = "";

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['change_password'])) {
	$old = trim($_POST['old_password'] ?? '');
	$new = trim($_POST['new_password'] ?? '');
	$confirm = trim($_POST['confirm_password'] ?? '');

	if (empty($old) || empty($new) || empty($confirm)) {
		$error = "All fields are required.";
	} else {
		$getPassword = $connection->prepare("SELECT password FROM admins WHERE id = ?");
		$getPassword->bind_param("i", $admin_id);
		$getPassword->execute();
		$result = $getPassword->get_result();
		$data = $result->fetch_assoc();
		$getPassword->close();

		if (!$data || !password_verify($old, $data['password'])) {
			$error = "Old password is incorrect.";
		} elseif ($new !== $confirm) {
			$error = "New passwords do not match.";
		} else {
			$newHashed = password_hash($new, PASSWORD_DEFAULT);
			$update = $connection->prepare("UPDATE admins SET password = ? WHERE id = ?");
			$update->bind_param("si", $newHashed, $admin_id);

			if ($update->execute()) {
				$success = "Password changed successfully.";
			} else {
				$error = "Something went wrong. Please try again.";
			}

			$update->close();
		}
	}
}
$adminProfile = $admin;

// $admin_id = $_SESSION['admin_id'];
// $error = $success = "";

// // Fetch profile data
// $adminProfileQuery = mysqli_query($connection, "SELECT * FROM admins WHERE admin_id = ?");
// $adminProfile = $adminProfileQuery->fetch_assoc();

// // Handle profile update
// if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['update_profile'])) {
//     // Fetch the values from the form
//     $name    = $_POST['name'];
//     $email   = $_POST['email'];
//     $dob     = $_POST['dob'];
//     $mobile  = $_POST['mobile'];
//     $address = $_POST['address'];
//     $bio     = $_POST['bio'];
//     $city    = $_POST['city'];
//     $state   = $_POST['state'];
//     $zip     = $_POST['zip'];
//     $country = $_POST['country'];

//     // Handle image upload
//     if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] === 0) {
//         $imageName = time() . '_' . basename($_FILES['profile_image']['name']);
//         $imagePath = "uploads/" . $imageName;
//         move_uploaded_file($_FILES['profile_image']['tmp_name'], $imagePath);
//     } else {
//         // Keep old image if no new one uploaded
//         $getImage = mysqli_query($connection, "SELECT profile_image FROM admins WHERE id = $admin_id");
//         $data = $getImage->fetch_assoc();
//         $imagePath = $data['profile_image'];
//     }

//     // Update the profile
// $update = mysqli_query($connection, "UPDATE admins SET name='$name', email='$email', dob='$dob', mobile='$mobile', address='$address', bio='$bio', city='$city', state='$state', zip='$zip', country='$country', profile_image='$imagePath' WHERE id = $admin_id");
// mysqli_stmt_bind_param($stmt, "sssssssssssi", $email,$name, $address, $mobile, $bio, $dob, $city, $state, $zip, $country, $imagePath, $admin_id);

//     if ($update) {
//         $success = "Profile updated successfully.";
//         // Refresh profile data
//         $adminProfileQuery = mysqli_query($connection, "SELECT * FROM admins WHERE id = $admin_id");
//         $adminProfile = $adminProfileQuery->fetch_assoc();
//     } else {
//         $error = "Something went wrong. Please try again.";
//     }
// }

// Handle password change
?>


<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Lupicad | Admin Profile</title>

	<!-- Favicon -->
	<link rel="shortcut icon" type="image/x-icon" href="../assets/lupicad/logo.svg">

	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="assets/css/bootstrap.min.css">

	<!-- Fontawesome CSS -->
	<link rel="stylesheet" href="assets/plugins/fontawesome/css/fontawesome.min.css">
	<link rel="stylesheet" href="assets/plugins/fontawesome/css/all.min.css">

	<!-- Feathericon CSS -->
	<link rel="stylesheet" href="assets/css/feathericon.min.css">

	<!-- Bootstrap Datetimepicker CSS -->
	<link rel="stylesheet" href="assets/css/bootstrap-datetimepicker.min.css">

	<!-- Main CSS -->
	<link rel="stylesheet" href="assets/css/custom.css">

</head>

<body>

	<!-- Main Wrapper -->
	<div class="main-wrapper">

		<!-- Header -->
		<?php require_once(__DIR__ . "/components/header.inc.php") ?>

		<!-- /Header -->
		<!-- Sidebar -->
		<?php require_once(__DIR__ . "/components/Sidebar.inc.php") ?>


		<!-- /Sidebar -->

		<!-- Page Wrapper -->
		<div class="page-wrapper">
			<div class="content container-fluid">

				<!-- Page Header -->
				<div class="page-header">
					<div class="row">
						<div class="col">
							<h3 class="page-title">Profile</h3>
						</div>
					</div>
				</div>
				<!-- /Page Header -->

				<div class="row">
					<div class="col-md-12">
						<div class="profile-header">
							<div class="row align-items-center">
								<div class="col-auto profile-image">
									<a href="#">
										<?php if (!empty($adminProfile['profile_image'])): ?>
											<img class="rounded-circle" alt="User Image" src="<?= htmlspecialchars($adminProfile['profile_image']) ?>" width="100" height="100">
										<?php else: ?>
											<div class="rounded-circle" style="background-color:rgba(27, 89, 144, 0.85);font-size:2rem;color:white;width:100px;height:100px;display:flex;justify-content:center;align-items:center;">
												<?= isset($adminProfile['name']) ? strtoupper(substr(htmlspecialchars($adminProfile['name']), 0, 1)) : "U"; ?>
											</div>
										<?php endif; ?>
									</a>
								</div>
								<div class="col ml-md-n2 profile-user-info">
									<h4 class="user-name mb-0">
										<?= isset($adminProfile['name']) ? htmlspecialchars($adminProfile['name']) : ""; ?>
									</h4>
									<h6 class="text-muted">
										<?= isset($adminProfile['email']) ? htmlspecialchars($adminProfile['email']) : ""; ?>
									</h6>
									<div class="user-Location"><i class="fa-solid fa-location-dot"></i>
										<?= $adminProfile['address'] ?></div>
									<div class="about-text"><?= $adminProfile['bio'] ?></div>
								</div>
								<!-- <div class="col-auto profile-btn">
										
										<a href="#" class="btn btn-primary">
											Edit
										</a>
									</div> -->
							</div>
						</div>
						<div class="profile-menu">
							<ul class="nav nav-tabs nav-tabs-solid">
								<li class="nav-item">
									<a class="nav-link active" data-bs-toggle="tab" href="#per_details_tab">About</a>
								</li>
								<li class="nav-item">
									<a class="nav-link" data-bs-toggle="tab" href="#password_tab">Password</a>
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
													<a class="edit-link" data-bs-toggle="modal"
														href="#edit_personal_details">
														<i class="fa fa-edit me-1"></i>Edit</a>
												</h5>
												<div class="row">
													<p class="col-sm-2 text-muted">Name</p>
													<p class="col-sm-10"><?= $adminProfile['name']; ?></p>
												</div>
												<div class="row">
													<p class="col-sm-2 text-muted">Date of Birth</p>
													<p class="col-sm-10"><?= $adminProfile['dob']; ?></p>
												</div>
												<div class="row">
													<p class="col-sm-2 text-muted">Email ID</p>
													<p class="col-sm-10"><?= $adminProfile['email']; ?></p>
												</div>
												<div class="row">
													<p class="col-sm-2 text-muted">Mobile</p>
													<p class="col-sm-10"><?= $adminProfile['mobile']; ?></p>
												</div>
												<div class="row">
													<p class="col-sm-2 text-muted">Address</p>
													<p class="col-sm-10 mb-0">
														<?= $adminProfile['address']; ?>, <?= $adminProfile['state']; ?>, <?= $adminProfile['zip']; ?>, <?= $adminProfile['country']; ?>
														<br>
												</div>
											</div>
										</div>

										<!-- Edit Details Modal -->
										<div class="modal fade" id="edit_personal_details" aria-hidden="true"
											role="dialog">
											<div class="modal-dialog modal-dialog-centered" role="document">
												<div class="modal-content">
													<div class="modal-header">
														<h5 class="modal-title">Personal Details</h5>
														<button type="button" class="btn-close" data-bs-dismiss="modal"
															aria-label="Close"></button>
													</div>
													<div class="modal-body">
														<form method="POST" action="" enctype="multipart/form-data">
															<input type="hidden" name="update_profile" value="1">

															<div class="row">
																<div class="col-12 col-sm-6">
																	<div class="mb-3">
																		<label class="mb-2">First Name</label>
																		<input type="text" class="form-control"
																			name="name"
																			value="<?= $adminProfile['name']; ?>">
																	</div>
																</div>
																<div class="col-12 col-sm-6">
																	<div class="mb-3">
																		<label class="mb-2">Date of Birth</label>
																		<div class="cal-icon">
																			<input type="text"
																				class="form-control datetimepicker"
																				name="dob"
																				value="<?= $adminProfile['dob']; ?>">

																		</div>
																	</div>
																</div>
																<div class="col-12 col-sm-6">
																	<div class="mb-3">
																		<label class="mb-2">Email ID</label>
																		<input type="email" class="form-control"
																			name="email"
																			value="<?= $adminProfile['email']; ?>">
																	</div>
																</div>
																<div class="col-12 col-sm-6">
																	<div class="mb-3">
																		<label class="mb-2">Mobile</label>
																		<input type="text" class="form-control"
																			name="mobile"
																			value="<?= $adminProfile['mobile']; ?>">
																	</div>
																</div>
																<div class="col-12">
																	<h5 class="form-title"><span>Address</span></h5>
																</div>
																<div class="col-12">
																	<div class="mb-3">
																		<label class="mb-2">Address</label>
																		<input type="text" class="form-control"
																			name="address"
																			value="<?= $adminProfile['address']; ?>">
																	</div>
																</div>
																<div class="col-12 col-sm-6">
																	<div class="mb-3">
																		<label class="mb-2">City</label>
																		<input type="text" class="form-control"
																			name="city"
																			value="<?= $adminProfile['city']; ?>">
																	</div>
																</div>
																<div class="col-12 col-sm-6">
																	<div class="mb-3">
																		<label class="mb-2">State</label>
																		<input type="text" class="form-control"
																			name="state"
																			value="<?= $adminProfile['state']; ?>">
																	</div>
																</div>
																<div class="col-12 col-sm-6">
																	<div class="mb-3">
																		<label class="mb-2">Zip Code</label>
																		<input type="text" class="form-control"
																			name="zip"
																			value="<?= $adminProfile['zip']; ?>">
																	</div>
																</div>
																<div class="col-12 col-sm-6">
																	<div class="mb-3">
																		<label class="mb-2">Country</label>
																		<input type="text" class="form-control"
																			name="country"
																			value="<?= $adminProfile['country']; ?>">
																	</div>
																</div>
																<div class="col-12 col-sm-6">
																	<div class="mb-3">
																		<label>Bio</label>
																		<textarea class="form-control" name="bio"
																			rows="3"><?= $admin['bio'] ?? '' ?></textarea>
																	</div>
																</div>
																<div class="col-12 col-sm-6">
																	<label>
																		Upload Profile
																		Image</label><br>
																	<?php if (!empty($admin['profile_image'])): ?>
																		<img src="<?= $admin['profile_image'] ?>"
																			alt="Profile Image" width="100"
																			class="mb-2"><br>
																	<?php endif; ?>
																	<input class="form-control" type="file"
																		name="profile_image">
																</div>
															</div>
															<button type="submit" class="btn btn-primary w-100">
																Save
															</button>
														</form>
													</div>
												</div>
											</div>
										</div>

									</div>


								</div>

							</div>
							<div id="password_tab" class="tab-pane fade">

								<div class="card">
									<div class="card-body">
										<h5 class="card-title">Change Password</h5>

										<?php if (!empty($error)): ?>
											<div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
										<?php elseif (!empty($success)): ?>
											<div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
										<?php endif; ?>

										<div class="row">
											<div class="col-md-10 col-lg-6">
												<form method="POST">
													<input type="hidden" name="change_password" value="1">
													<div class="mb-3">
														<label class="mb-2">Old Password</label>
														<input type="password" class="form-control" name="old_password"
															required>
													</div>
													<div class="mb-3">
														<label class="mb-2">New Password</label>
														<input type="password" class="form-control" name="new_password"
															required>
													</div>
													<div class="mb-3">
														<label class="mb-2">Confirm Password</label>
														<input type="password" class="form-control"
															name="confirm_password" required>
													</div>
													<button class="btn btn-primary" type="submit">Save Changes</button>
												</form>
											</div>
										</div>
									</div>
								</div>
							</div>
							<!-- /Change Password Tab -->

						</div>
					</div>
				</div>

			</div>
		</div>
		<!-- /Page Wrapper -->

	</div>
	<!-- /Main Wrapper -->

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