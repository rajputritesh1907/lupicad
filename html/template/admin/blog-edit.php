<?php
// Including the database connection file
require(__DIR__ . "/../backend/connection.inc.php");

if (session_status() === PHP_SESSION_NONE) {
	session_start();
}

$deleteId = null;
// Fetching the data from blogs table

$blogTable = mysqli_query($connection, "SELECT * FROM blogs");

// Process the results

if ($blogTable) {
	$blogs = [];
	while ($row = mysqli_fetch_assoc($blogTable)) {
		$blogs[] = $row; // Add each row to the blogs array
	}
} else {
	// echo "No blog data found.";
}

// Log the blogs array to the console

// echo "<script>console.log(" . json_encode($blogs) . ");</script>";


//--------------------------------------------------------------------------------------------------//

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	// Fetch form data
	$heading = $_POST['heading'];
	$healthcategory = $_POST['healthcategory'];
	$blogername = $_POST['blogername'];
	$para1 = $_POST['paragraph1'];
	$para2 = $_POST['paragraph2'];
	$tags = $_POST['tags'];

	// Handle image upload
	$imageName = $_FILES['image']['name'];
	$image_name  = uniqid() . "_" . basename($image_name); // Ensure unique name
	$imageTmp = $_FILES['image']['tmp_name'];

	// Ensure the uploads/blogs directory exists
	if (!file_exists("../uploads/blogs")) {
		mkdir("../uploads/blogs", 0777, true);
	}

	$imagePath = "../uploads/blogs" . basename($imageName);

	if (move_uploaded_file($imageTmp, $imagePath)) {
		// DB connection
		require_once(__DIR__ . "/../backend/connection.inc.php");
		require_once(__DIR__ . "/../backend/function.inc.php");

		// Set publish date or use current date if not provided
		$publish_date = !empty($_POST['date']) ? $_POST['date'] : date("Y-m-d");

		// Prepared statement
		$sql = "INSERT INTO blogs (heading, healthcategory, image, blogername, publish_date, paragraph1, paragraph2, tags)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
		$stmt = $connection->prepare($sql);
		$stmt->bind_param("ssssssss", $heading, $healthcategory, $imagePath, $blogername, $publish_date, $para1, $para2, $tags);

		// Execute and redirect to blog detail page
		if ($stmt->execute()) {
			$inserted_id = $connection->insert_id;
			header("Location: blog-edit.php");
			exit();
		} else {
			// echo "Error: " . $stmt->error;
		}
	} else {
		// echo "<p style='color:red;'>Failed to upload image.</p>";
	}
}

//--------------------------------------------------------------------------------------------------//

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_GET['deleteId'])) {
        $deleteId = $_GET['deleteId'];

        // Fetch the image path from the database before deleting the record
        $stmt = $connection->prepare("SELECT image FROM blogs WHERE id = ?");
        $stmt->bind_param("i", $deleteId);
        $stmt->execute();
        $stmt->bind_result($imagePathJson);
        $stmt->fetch();
        $stmt->close();

        $imagePaths = json_decode($imagePathJson, true);
        if (is_array($imagePaths)) {
            foreach ($imagePaths as $imagePath) {
                $imagePath = "../uploads/" . $imagePath;
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
            }
        }

        // Prepare the SQL statement to delete the blog
        $stmt = $connection->prepare("DELETE FROM blogs WHERE id = ?");
        $stmt->bind_param("i", $deleteId);
        if ($stmt->execute()) {
            // Redirect to the same page to refresh the list of blogs
            header("Location: blog-edit.php");
            exit(); // Stop further script execution
        } else {
            // echo "<script>console.log('❌ Error: " . $stmt->error . "');</script>";
        }
        $stmt->close();
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Lupicad | Admin-Blog List</title>

	<!-- Favicon -->
	<link rel="shortcut icon" type="image/x-icon" href="../assets/lupicad/logo.svg">

	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="assets/css/bootstrap.min.css">

	<!-- Fontawesome CSS -->
	<link rel="stylesheet" href="assets/plugins/fontawesome/css/fontawesome.min.css">
	<link rel="stylesheet" href="assets/plugins/fontawesome/css/all.min.css">

	<!-- Feathericon CSS -->
	<link rel="stylesheet" href="assets/css/feathericon.min.css">

	<!-- Datatables CSS -->
	<link rel="stylesheet" href="assets/plugins/datatables/datatables.min.css">

	<!-- Main CSS -->
	<link rel="stylesheet" href="assets/css/custom.css">

</head>

<body>

	<!-- Main Wrapper -->
	<div class="main-wrapper">

		<!-- Header -->
		<?php require(__DIR__ . "/components/header.inc.php") ?>
		<!-- /Header -->

		<!-- Sidebar -->
		<?php require(__DIR__ . "/components/Sidebar.inc.php") ?>
		<!-- /Sidebar -->

		<!-- Page Wrapper -->
		<div class="page-wrapper">
			<div class="content container-fluid">

				<!-- Page Header -->
				<div class="page-header">
					<div class="row">
						<div class="col-sm-12">
							<h3 class="page-title">List of Blogs</h3>
						</div>
						<div>
							<a href="blog-form.php" class="btn btn-primary float-end" style="background-color:3D90D7;">Add Blogs</a>
						</div>
					</div>
				</div>
				<!-- /Page Header -->

				<div class="row">
					<div class="col-sm-12">
						<div class="card">
							<div class="card-body">
								<div class="table-responsive">
									<table class="datatable table table-hover table-center mb-0">
										<thead>
											<tr>
												<th>blog category</th>
												<th>name</th>
												<th>heading</th>
												<th>paragraph</th>
												<!-- <th>Quantity</th> -->
												<th>Options</th>
											</tr>
										</thead>
										<tbody>
											<?php
											foreach ($blogs as $blog) {
											?>
												<tr>
													<td>
														<h2 class="table-avatar">
															<a href="#" class="avatar avatar-sm me-2"><img class="avatar-img rounded-circle" src="<?= $blog['image'] ?>" alt="product Image"></a>
															<a href="#"><?= mb_strimwidth($blog['healthcategory'], 0, 20, '...') ?></a>
														</h2>
													</td>
													<!-- after 50 latter the show ... like structure to limit its display length -->

													<td><?= mb_strimwidth($blog['blogername'], 0,30, '...') ?></td>
													<td><?= mb_strimwidth($blog['heading'], 0, 30, '...')?></td>
													<td><?= mb_strimwidth($blog['paragraph1'], 0, 50, '...') ?></td>

													<td>
														<div>
															<a class="btn btn-sm bg-success-light" data-bs-toggle="modal" onclick="window.location.href='blog-form.php?BlogId=<?= $blog['id'] ?>'">
																<i class="fe fe-pencil"></i>&nbsp;&nbsp;Edit &nbsp;&nbsp;&nbsp;
															</a>
															<a data-bs-toggle="modal" href="#delete_modal" onclick="setDeleteId(<?= $blog['id'] ?>)" class="btn btn-sm bg-danger-light" style="margin-top: 5px;">
																<i class="fe fe-trash"></i> Delete
															</a>
														</div>
													</td>
												</tr>
											<?php
											}
											?>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>

			</div>
		</div>
		<!-- /Page Wrapper -->

		<!-- Delete Modal -->
		<div class="modal fade" id="delete_modal" aria-hidden="true" role="dialog">
			<div class="modal-dialog modal-dialog-centered" role="document">
				<div class="modal-content">
					<div class="modal-body">
						<div class="form-content p-2">
							<h4 class="modal-title">Delete</h4>
							<p class="mb-4">Are you sure want to delete?</p>
							<button type="button" class="btn btn-danger"><a href="#" style="color: white;">Yes , Delete</a></button>&nbsp;&nbsp;
							<button type="button" class="btn btn-primary" data-bs-dismiss="modal">Cancel</button>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- /Delete Modal -->

	</div>
	<!-- /Main Wrapper -->

	<script>
		function setDeleteId(BlogId) {
			// Update the delete button's href with the product ID
			const deleteButton = document.querySelector('#delete_modal .btn-danger a');
			deleteButton.href = `blog-edit.php?deleteId=${BlogId}`;
		}

		// const Ischeckbox = document.querySelector('.status-toggle input[type="checkbox"] .check');
		// //get the value of the checkbox
		// const checkboxValue = Ischeckbox.checked ? 1 : 0;
		// console.log(checkboxValue);

		// function ischecked(productId) {
		// 	const checkbox = document.getElementById(`status_${productId}`);
		// 	const checkboxValue = checkbox.checked ? 1 : 0;
		// 	console.log(checkboxValue);
		// 	//redirect after 1 second dalay
		// 	setTimeout(() => {
		// 		window.location.href = `Product-list.php?ProductId=${productId}&status=${checkboxValue}`;
		// 	}, 1000);
		// }
	</script>

	<!-- jQuery -->
	<script src="assets/js/jquery-3.7.1.min.js" type="d6521f990fb2a4f5301b3a16-text/javascript"></script>

	<!-- Bootstrap Core JS -->
	<script src="assets/js/bootstrap.bundle.min.js" type="d6521f990fb2a4f5301b3a16-text/javascript"></script>

	<!-- Slimscroll JS -->
	<script src="assets/plugins/slimscroll/jquery.slimscroll.min.js" type="d6521f990fb2a4f5301b3a16-text/javascript"></script>

	<!-- Datatables JS -->
	<script src="assets/plugins/datatables/jquery.dataTables.min.js" type="d6521f990fb2a4f5301b3a16-text/javascript"></script>
	<script src="assets/plugins/datatables/datatables.min.js" type="d6521f990fb2a4f5301b3a16-text/javascript"></script>

	<!-- Custom JS -->
	<script src="assets/js/script.js" type="d6521f990fb2a4f5301b3a16-text/javascript"></script>

	<script src="../../../cdn-cgi/scripts/7d0fa10a/cloudflare-static/rocket-loader.min.js" data-cf-settings="d6521f990fb2a4f5301b3a16-|49" defer></script>
	<script defer src="https://static.cloudflareinsights.com/beacon.min.js/vcd15cbe7772f49c399c6a5babf22c1241717689176015" integrity="sha512-ZpsOmlRQV6y907TI0dKBHq9Md29nnaEIPlkf84rnaERnq6zvWvPUqr2ft8M1aS28oN72PdrCzSjY4U6VaAw1EQ==" data-cf-beacon='{"rayId":"926c55647f0b59c3","version":"2025.3.0","serverTiming":{"name":{"cfExtPri":true,"cfL4":true,"cfSpeedBrain":true,"cfCacheStatus":true}},"token":"3ca157e612a14eccbb30cf6db6691c29","b":1}' crossorigin="anonymous"></script>
</body>
</html>