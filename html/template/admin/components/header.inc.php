<?php
require_once(__DIR__ . "/../../backend/connection.inc.php");
require_once(__DIR__ . "/../../backend/function.inc.php");

// session_start();

if (!isset($_SESSION['admin_id'])) {
    header("Location: http://localhost/lupi-back/html/template/admin/adminlogin.php");
    exit();
}

$admin_id = $_SESSION['admin_id'];

//set session value in the new session variable

$query = "SELECT name, profile_image FROM admins WHERE id = $admin_id";
$result = mysqli_query($connection, $query);

if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $name = $row['name'];
    $image = $row['profile_image'];

    // Process the fetched data as needed
    // For example, display the name and image
    // echo "Name: " . $name . "<br>";
    // echo "Image: <img src='" . $image . "' alt='Admin Image'><br>";


    echo "<script>console.log('Welcome, " . $name . "');</script>";
} else {
    echo "No records found";
}

mysqli_close($connection);
?>

<div class="header">

    <!-- Logo -->
    <div class="header-left" style="margin-right:3vh;">
        <a href="../index.php" class="logo">
            <img src="../assets/img/LupicadResizedLogo.svg" alt="Logo">
        </a>
        <a href="../index.php" class="logo logo-small">
            <img src="../assets/img/LupicadResizedLogo.svg" alt="Logo" width="30" height="30">
        </a>
    </div>
    <!-- /Logo -->

    <a href="javascript:void(0);" id="toggle_btn">
        <i class="fe fe-text-align-left"></i>
    </a>

    

    <!-- Mobile Menu Toggle -->
    <a class="mobile_btn" id="mobile_btn">
        <i class="fa fa-bars"></i>
    </a>
    <!-- /Mobile Menu Toggle -->

    <!-- Header Right Menu -->
    <ul class="nav user-menu">

        <!-- Notifications -->
        <!-- <li class="nav-item dropdown noti-dropdown">
            <a href="#" class="dropdown-toggle nav-link" data-bs-toggle="dropdown">
                <i class="fe fe-bell"></i> <span class="badge rounded-pill">3</span>
            </a>
            <div class="dropdown-menu notifications">
                <div class="topnav-dropdown-header">
                    <span class="notification-title">Notifications</span>
                    <a href="javascript:void(0)" class="clear-noti"> Clear All </a>
                </div>
                <div class="noti-content">
                    <ul class="notification-list">
                        <li class="notification-message">
                            <a href="#">
                                <div class="notify-block d-flex">
                                    <span class="avatar avatar-sm flex-shrink-0">
                                        <img class="avatar-img rounded-circle" alt="User Image"
                                            src="assets/img/doctors/doctor-thumb-01.jpg">
                                    </span>
                                    <div class="media-body flex-grow-1">
                                        <p class="noti-details"><span class="noti-title">Dr. Ruby Perrin</span> Schedule
                                            <span class="noti-title">her appointment</span>
                                        </p>
                                        <p class="noti-time"><span class="notification-time">4 mins ago</span></p>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="notification-message">
                            <a href="#">
                                <div class="notify-block d-flex">
                                    <span class="avatar avatar-sm flex-shrink-0">
                                        <img class="avatar-img rounded-circle" alt="User Image"
                                            src="assets/img/patients/patient1.jpg">
                                    </span>
                                    <div class="media-body flex-grow-1">
                                        <p class="noti-details"><span class="noti-title">Charlene Reed</span> has booked
                                            her appointment to <span class="noti-title">Dr. Ruby Perrin</span></p>
                                        <p class="noti-time"><span class="notification-time">6 mins ago</span></p>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="notification-message">
                            <a href="#">
                                <div class="notify-block d-flex">
                                    <span class="avatar avatar-sm flex-shrink-0">
                                        <img class="avatar-img rounded-circle" alt="User Image"
                                            src="assets/img/patients/patient2.jpg">
                                    </span>
                                    <div class="media-body flex-grow-1">
                                        <p class="noti-details"><span class="noti-title">Travis Trimble</span> sent a
                                            amount of $210 for his <span class="noti-title">appointment</span></p>
                                        <p class="noti-time"><span class="notification-time">8 mins ago</span></p>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="notification-message">
                            <a href="#">
                                <div class="notify-block d-flex">
                                    <span class="avatar avatar-sm flex-shrink-0">
                                        <img class="avatar-img rounded-circle" alt="User Image"
                                            src="assets/img/patients/patient3.jpg">
                                    </span>
                                    <div class="media-body flex-grow-1">
                                        <p class="noti-details"><span class="noti-title">Carl Kelly</span> send a
                                            message <span class="noti-title"> to his doctor</span></p>
                                        <p class="noti-time"><span class="notification-time">12 mins ago</span></p>
                                    </div>
                                </div>
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="topnav-dropdown-footer">
                    <a href="#">View all Notifications</a>
                </div>
            </div>
        </li> -->
        <!-- /Notifications -->

        <!-- User Menu -->
        <li class="nav-item dropdown has-arrow">
            <a href="#" class="dropdown-toggle nav-link" data-bs-toggle="dropdown">
                <?php if (isset($image)) { ?>
                    <span class="user-img"><img class="rounded-circle" src="<?= $image ?>" width="40" height="40" alt="Ryan Taylor"></span>
                <?php } else { ?>
                    <span class="user-img">
                        <div class="rounded-circle" style="background-color:rgba(27, 89, 144, 0.85);font-size:x-large;color:white;width:40px;height:40px;overflow:hidden;display:flex;justify-content:center;align-items:center"><?= isset($name) ? strtoupper(substr(htmlspecialchars($name), 0, 1)) : "U"; ?></div>
                    </span>
                <?php } ?>
            </a>
            <div class="dropdown-menu">
                <div class="user-header">
                    <div class="avatar avatar-sm">
                        <?php if (isset($image)) { ?>
                            <img class="rounded-circle" alt="User Image" src="<?= $image ?>">
                        <?php } else { ?>
                            <span class="user-img">
                                <div class="rounded-circle" style="background-color:rgba(27, 89, 144, 0.85);font-size:x-large;color:white;width:40px;height:40;display:flex;justify-content:center;align-items:center"><?= isset($name) ? strtoupper(substr(htmlspecialchars($name), 0, 1)) : "U"; ?></div>
                            </span>
                        <?php } ?>
                    </div>
                    <div class="user-text">
                        <h6><? $name ?>
                            <?= isset($name) ? htmlspecialchars($name) : "User"; ?>
                        </h6>
                        <p class="text-muted mb-0">Administrator</p>
                    </div>
                </div>
                <a class="dropdown-item" href="profile.php">My Profile</a>
                <a class="dropdown-item" href="logout.php">Logout</a>

            </div>
        </li>
        <!-- /User Menu -->

    </ul>
    <!-- /Header Right Menu -->

</div>