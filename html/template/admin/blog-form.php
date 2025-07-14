<?php
require_once(__DIR__ . "/../backend/connection.inc.php");

require_once(__DIR__ . "/../backend/function.inc.php");
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}


if (isset($_GET['BlogId']) && !empty($_GET['BlogId'])) {
  // Fetch blog data for editing
  $BlogId = $_GET['BlogId'];
  $sql = "SELECT * FROM blogs WHERE id = ?";
  $stmt = $connection->prepare($sql);
  $stmt->bind_param("i", $BlogId);
  $stmt->execute();
  $result = $stmt->get_result();
  $blogData = $result->fetch_assoc();
  $stmt->close();
  // echo "<script>console.log('Blog Data: " . json_encode($blogData) . "');</script>";

  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    $heading = $_POST['heading'];
    $healthcategory = $_POST['healthcategory'];
    $blogername = $_POST['blogername'];
    $publish_date = !empty($_POST['date']) ? $_POST['date'] : date("Y-m-d");
    $paragraph1 = $_POST['paragraph1'];
    $paragraph2 = $_POST['paragraph2'];
    $tags = $_POST['tags'];
    $image_name = $_FILES['image']['name'];
    $image_tmp = $_FILES['image']['tmp_name'];

    // echo "<script>console.log('Image Name: " . json_encode($image_name) . "');</script>";

    if (!empty($_FILES['image']['name'])) {
      // A new image is uploaded
      $image_name = $_FILES['image']['name'];
      $image_name  = uniqid() . "_" . basename($image_name); // Ensure unique name
      $image_tmp = $_FILES['image']['tmp_name'];

      // Ensure the uploads/blogs directory exists
      if (!file_exists("../uploads/blogs")) {
        mkdir("../uploads/blogs", 0777, true);
      }

      $image_path = "../uploads/blogs/" . basename($image_name);

      if (move_uploaded_file($image_tmp, $image_path)) {
        $sql = "UPDATE blogs SET heading=?, healthcategory=?, image=?, blogername=?, publish_date=?, paragraph1=?, paragraph2=?, tags=? WHERE id=?";
        $stmt = $connection->prepare($sql);
        $stmt->bind_param("ssssssssi", $heading, $healthcategory, $image_path, $blogername, $publish_date, $paragraph1, $paragraph2, $tags, $BlogId);

        if ($stmt->execute()) {
          //delete the old image if it exists
          if (file_exists($blogData['image'])) {
            unlink($blogData['image']);
          }
          // echo "<script>console.log('Blog updated successfully!');</script>";
        } else {
          // echo "<script>console.log('Update unsuccessful');</script>";
        }
      } else {
        // echo "<p style='color:red;'> Failed to upload image.</p>";
      }
    } else {
      // No new image is uploaded, keep the existing image
      $sql = "UPDATE blogs SET heading=?, healthcategory=?, blogername=?, publish_date=?, paragraph1=?, paragraph2=?, tags=? WHERE id=?";
      $stmt = $connection->prepare($sql);
      $stmt->bind_param("sssssssi", $heading, $healthcategory, $blogername, $publish_date, $paragraph1, $paragraph2, $tags, $BlogId);
    }
    if ($stmt->execute()) {
      // echo "<script>console.log('Blog updated successfully!');</script>";
    } else {
      // echo "<script>console.log('update unsucessfull');</script>";
    }
    $stmt->close();
    $connection->close();
    header("Location: blog-edit.php");
    exit();
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<!-- Mirrored from doccure.dreamstechnologies.com/html/template/admin/reviewsphp by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 27 Mar 2025 05:03:00 GMT -->

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta
    name="description"
    content="The responsive professional Doccure template offers many features, like scheduling appointments with  top doctors, clinics, and hospitals via voice, video call & chat." />
  <meta
    name="keywords"
    content="practo clone, doccure, doctor appointment, Practo clone html template, doctor booking template" />
  <meta
    name="author"
    content="Practo Clone HTML Template - Doctor Booking Template" />
  <meta
    property="og:url"
    content="https://doccure.dreamstechnologies.com/html/" />
  <meta property="og:type" content="website" />
  <meta
    property="og:title"
    content="Doctors Appointment HTML Website Templates | Doccure" />
  <meta
    property="og:description"
    content="The responsive professional Doccure template offers many features, like scheduling appointments with  top doctors, clinics, and hospitals via voice, video call & chat." />
  <meta property="og:image" content="assets/img/preview-bannerphp" />
  <meta name="twitter:card" content="summary_large_image" />
  <meta
    property="twitter:domain"
    content="https://doccure.dreamstechnologies.com/html/" />
  <meta
    property="twitter:url"
    content="https://doccure.dreamstechnologies.com/html/" />
  <meta
    name="twitter:title"
    content="Doctors Appointment HTML Website Templates | Doccure" />
  <meta
    name="twitter:description"
    content="The responsive professional Doccure template offers many features, like scheduling appointments with  top doctors, clinics, and hospitals via voice, video call & chat." />
  <meta name="twitter:image" content="assets/img/preview-bannerphp" />
  <title>Doccure - Reviews Page</title>

  <!-- Favicon -->
  <link rel="shortcut icon" type="image/x-icon" href="../assets/lupicad/logo.svg">


  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="assets/css/bootstrap.min.css" />

  <!-- Fontawesome CSS -->
  <link
    rel="stylesheet"
    href="assets/plugins/fontawesome/css/fontawesome.min.css" />
  <link rel="stylesheet" href="assets/plugins/fontawesome/css/all.min.css" />

  <!-- Feathericon CSS -->
  <link rel="stylesheet" href="assets/css/feathericon.min.css" />

  <!-- Datatables CSS -->
  <link
    rel="stylesheet"
    href="assets/plugins/datatables/datatables.min.css" />

  <!-- Main CSS -->
  <link rel="stylesheet" href="assets/css/custom.css" />




</head>

<body>
  <!-- Main Wrapper -->
  <div class="main-wrapper">

    <!-- Header -->
    <?php require(__DIR__ . "/components/header.inc.php"); ?>
    <!-- /Header -->

    <!-- Sidebar -->
    <?php require(__DIR__ . "/components/Sidebar.inc.php"); ?>
    <!-- /Sidebar -->
    <style>
      /* form textarea will increase to 200px */
      textarea.form-control {
        transition: all 0.3s ease-in-out;
        resize: none;
        height: 100px;
      }

      /* form textarea will increase to 200px on focus */
      textarea.form-control:focus {
        height: 220px;
        resize: none;
      }

      /* form textarea will increase to 200px on click  */
      textarea.form-control:active {
        height: 220px;
        resize: none;
      }
    </style>


    <!-- Page Wrapper -->
    <!-- Page Wrapper -->
    <div class="page-wrapper py-5">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-md-10 col-lg-8">

            <div class="bg-white shadow rounded p-4">

              <!-- Blog Image -->
              <div class="text-center mb-4">
                <img src="assets/img/blog-banner1.png" alt="Blog Banner" class="img-fluid" style="max-height: 250px;">
              </div>

              <!-- Heading -->
              <div class="text-center mb-4">
                <h2 class="text-2xl font-bold text-dark">Submit Your Blog</h2>
                <p class="text-muted">Share your voice with the world!</p>
              </div>

              <!-- Blog Form -->
              <form action="<?= isset($_GET['BlogId']) ? 'blog-form.php?BlogId=' . $BlogId : 'blog-edit.php' ?>" method="POST" enctype="multipart/form-data" class="space-y-4">
                <div class="form-group">
                  <label>Blog Heading</label>
                  <input type="text" name="heading" value="<?= isset($blogData['heading']) ? htmlspecialchars($blogData['heading']) : '' ?>" class="form-control" required>
                </div>

                <div class="form-group">
                  <label>Health Category</label>
                  <input type="text" name="healthcategory" value="<?= isset($blogData['healthcategory']) ? htmlspecialchars($blogData['healthcategory']) : '' ?>" class="form-control" required>
                </div>

                <div class="form-group">
                  <label>Blogger Name</label>
                  <input type="text" name="blogername" value="<?= isset($blogData['blogername']) ? htmlspecialchars($blogData['blogername']) : '' ?>" class="form-control" required>
                </div>

                <div class="form-group">
                  <label>Image Upload</label>
                  <input type="file" name="image" accept="image/*" class="form-control" <?= isset($blogData['image']) ? '' : 'required' ?>>
                </div>

                <div class="form-group">
                  <label>Content Paragraph 1</label>
                  <textarea name="paragraph1" rows="4" class="form-control" required><?= isset($blogData['paragraph1']) ? htmlspecialchars($blogData['paragraph1']) : '' ?></textarea>
                </div>

                <div class="form-group">
                  <label>Content Paragraph 2</label>
                  <textarea name="paragraph2" rows="4" class="form-control" required><?= isset($blogData['paragraph2']) ? htmlspecialchars($blogData['paragraph2']) : '' ?></textarea>
                </div>

                <div class="form-group">
                  <label>Tags (comma-separated)</label>
                  <input type="text" name="tags" value="<?= isset($blogData['tags']) ? htmlspecialchars($blogData['tags']) : '' ?>" class="form-control" required>
                </div>

                <div class="text-center">
                  <button type="submit" class="btn btn-primary w-100">Submit Blog</button>
                </div>
              </form>

            </div>

          </div>
        </div>
      </div>
    </div>
    <!-- End Page Wrapper -->


    <!-- Page Header -->



    <!-- Mirrored from Lupicad.dreamstechnologies.com/html/template/admin/reviewsphp by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 27 Mar 2025 05:03:00 GMT -->


</html>