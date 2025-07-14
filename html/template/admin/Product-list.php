<?php
// Including the database connection file
require(__DIR__ . "/../backend/connection.inc.php");
require(__DIR__ . "/../backend/ProductTable.inc.php");

session_start();

// fatching the data from ProductTable
$ProductTable = mysqli_query($connection, "SELECT * FROM producttable");

// Process the results
if ($ProductTable) {
	$products = [];
	while ($row = mysqli_fetch_assoc($ProductTable)) {
		$products[] = $row; // Add each row to the products array
	}

	// Log the products array to the console
	// echo "<script>console.log(" . json_encode($products) . ");</script>";
} else {

	//  echo "<script>console.log('Error fetching ProductTable: " . mysqli_error($connection) . "');</script>";
}


$deleteId = null;
//if request method is POST, then insert the data into the ProductTable and ProductDetailsTable
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

	// ProductTable Fields
	$Productname = $_POST['ProductName'];
	$ProductShortDescription = $_POST['ProductShortDescription'];
	$ProductCategories = $_POST['filter'];
	$ProductPrice = $_POST['ProductPrice'];
	$ProductAvailability = true;
	$ProductRating = 4.5; // Default rating, you can change this as needed
	$ProductImage = $_FILES['ProductImage'];
	$ProductImageArray = [];

	// ProductDetailsTable Fields
	$ProductSubTitle = $_POST['SubTitle'];
	$ProductQuantity = $_POST['Quantity'];
	$ProductSKU = $_POST['SKU'];
	$ProductPackSize = $_POST['PackSize'];
	$ProductUnitCount = $_POST['UnitCount'];
	$ProductCountry = $_POST['Country'];
	$ProductDiscount = $_POST['Discount'];
	$ProductDescription = $_POST['ProductDescription'];
	$ProductDirections = $_POST['Directions'];
	$ProductStorage = $_POST['Storage'];
	$ProductAdministration = $_POST['Administration'];
	$ProductWarning = $_POST['Warning'];
	$ProductPrecaution = $_POST['Precaution'];


	$uploadDir = "../uploads/";
	if (!is_dir($uploadDir)) {
		mkdir($uploadDir, 0777, true); // Create the directory with write permissions
	}

	$ProductImagePaths = []; 
	foreach ($ProductImage['tmp_name'] as $key => $tmp_name) {
		if (!empty($tmp_name)) {
			$imageName = uniqid("IMG-", true) . "." . pathinfo($ProductImage['name'][$key], PATHINFO_EXTENSION);
			$imagePath = $uploadDir . $imageName; // Full path for moving the file

			// Move the uploaded file to the destination directory
			if (move_uploaded_file($tmp_name, $imagePath)) {
				$ProductImagePaths[] = $imageName; // Store only the filename
			} else {
				// echo "<script>console.log('❌ Error uploading image: " . $ProductImage['name'][$key] . "');</script>";
			}
		}
	}
	$ProductImageJson = json_encode($ProductImagePaths);


	// Prepare the SQL statement to insert the data into the ProductTable
	$stmt = $connection->prepare("INSERT INTO ProductTable (ProductName, ProductShortDescription, ProductCategories, ProductAvailability, ProductRating, ProductPrice, ProductImage) VALUES (?, ?, ?, ?, ?, ?, ?)");
	$stmt->bind_param("sssidds", $Productname, $ProductShortDescription, $ProductCategories, $ProductAvailability, $ProductRating, $ProductPrice, $ProductImageJson);

	if ($stmt->execute()) {
		// echo "<script>console.log('✅ Form submitted successfully');</script>";
	} else {
		// echo "<script>console.log('❌ Error: " . $stmt->error . "');</script>";
	}
	$stmt->close();

	// Get the last inserted ProductID
	$ProductID = $connection->insert_id;
	// Prepare the SQL statement to insert the data into the ProductDetailsTable
	$stmt = $connection->prepare("INSERT INTO ProductDetailsTable (ProductID, SubTitle, Quantity, SKU, PackSize, UnitCount, Country, Discount, ProductDescription, Directions, Storage, Administration, Warning, Precaution)
    VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
	$stmt->bind_param("isissssissssss", $ProductID, $ProductSubTitle, $ProductQuantity, $ProductSKU, $ProductPackSize, $ProductUnitCount, $ProductCountry, $ProductDiscount, $ProductDescription, $ProductDirections, $ProductStorage, $ProductAdministration, $ProductWarning, $ProductPrecaution);
	if ($stmt->execute()) {
		// echo "<script>console.log('✅ Form submitted successfully');</script>";
	} else {
		// echo "<script>console.log('❌ Error: " . $stmt->error . "');</script>";
	}
	$stmt->close();

	header("Location: Product-list.php");
	exit;
} elseif ($_SERVER['REQUEST_METHOD'] == 'GET') {
	if (isset($_GET['deleteId'])) {
		$deleteId = $_GET['deleteId'];
		//delete the image from the server which is moved into the uploads folder
		// Fetch the image path from the database before deleting the record
		$stmt = $connection->prepare("SELECT ProductImage FROM ProductTable WHERE ProductID = ?");
		$stmt->bind_param("i", $deleteId);
		$stmt->execute();
		$stmt->bind_result($imagePathJson);
		$stmt->fetch();
		$stmt->close();
		$imagePaths = json_decode($imagePathJson, true);
		if (is_array($imagePaths)) {
			foreach ($imagePaths as $imagePath) {
				//delete the name of the image from the uploads folder
				$imagePath = "../uploads/" . $imagePath;
				if (file_exists($imagePath)) {
					if (unlink($imagePath)) {
						// echo "<script>console.log('✅ Image deleted successfully: " . $imagePath . "');</script>";
					} else {
						// echo "<script>console.log('❌ Error deleting image: " . $imagePath . "');</script>";
					}
				} else {
					// echo "<script>console.log('❌ Image not found: " . $imagePath . "');</script>";
				}
			}
		}	

		// Prepare the SQL statement to delete the product from ProductTable
		$stmt = $connection->prepare("DELETE FROM producttable WHERE ProductID = ?");
		$stmt->bind_param("i", $deleteId);
		if ($stmt->execute()) {
			// echo "<script>console.log('✅ Product deleted successfully');</script>";
		} else {
			// echo "<script>console.log('❌ Error: " . $stmt->error . "');</script>";
		}
		$stmt->close();

		header("Location: Product-list.php");
		exit;
	} elseif (isset($_GET['ProductId']) && isset($_GET['status'])) {
		$productId = $_GET['ProductId'];
		$status = $_GET['status'];

		// Prepare the SQL statement to update the product status in ProductTable
		$stmt = $connection->prepare("UPDATE producttable SET ProductAvailability = ? WHERE ProductID = ?");
		$stmt->bind_param("ii", $status, $productId);
		if ($stmt->execute()) {
			// echo "<script>console.log('✅ Product status updated successfully');</script>";
		} else {
			// echo "<script>console.log('❌ Error: " . $stmt->error . "');</script>";
		}
		$stmt->close();

		header("Location: Product-list.php");
		exit;
	} else {
		// echo "<script>console.log('❌ No product ID or status provided for update');</script>";
	}
} else {
	// echo "<script>console.log('❌ Invalid request method');</script>";
}


?>


<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Lupicad | Admin-Product List</title>

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
							<h3 class="page-title">List of Products</h3>
						</div>
						<div>
							<a href="AddProduct.php" class="btn btn-primary float-end" style="background-color:3D90D7;">Add Product</a>
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
												<th>Product Name</th>
												<th>Category</th>
												<th>Pricing</th>
												<th>Description</th>
												<!-- <th>Quantity</th> -->
												<th>Options</th>
												<th>Status</th>
											</tr>
										</thead>
										<tbody>
											<?php
											foreach ($products as $product) {
												// Decode the ProductImage JSON string into a PHP array
												$productImages = json_decode($product['ProductImage'], true);

												// Ensure the decoding was successful and the array is not empty
												if (is_array($productImages) && count($productImages) > 0) {
													$mainImage = $productImages[0];
													$hoverImage = isset($productImages[1]) ? $productImages[1] : $productImages[0];
												} else {
													$mainImage = 'default-image.jpg';
													$hoverImage = 'default-image.jpg';
												}
												// echo "<script>console.log(" . json_encode(['mainImage' => $mainImage, 'hoverImage' => $hoverImage]) . ");</script>";
											?>
												<tr>
													<td>
														<h2 class="table-avatar">
															<a href="#" class="avatar avatar-sm me-2"><img class="avatar-img rounded-circle" src="../uploads/<?= $mainImage ?>" alt="product Image"></a>
															<a href="#"><?= mb_strimwidth($product['ProductName'], 0, 20, '...') ?></a>
														</h2>
													</td>
													<td><?= $product['ProductCategories'] ?></td>

													<td>₹<?= $product['ProductPrice'] ?></td>
													<td><?= mb_strimwidth($product['ProductShortDescription'], 0, 50, '...') ?></td>

													<td>
														<div>
															<a class="btn btn-sm bg-success-light" data-bs-toggle="modal" onclick="window.location.href='AddProduct.php?ProductId=<?= $product['ProductID'] ?>'">
																<i class="fe fe-pencil"></i>&nbsp;&nbsp;Edit &nbsp;&nbsp;&nbsp;
															</a>
															<a data-bs-toggle="modal" href="#delete_modal" onclick="setDeleteId(<?= $product['ProductID'] ?>)" class="btn btn-sm bg-danger-light" style="margin-top: 5px;">
																<i class="fe fe-trash"></i> Delete
															</a>
														</div>
													</td>
													<td>
														<div class="status-toggle">
															<input type="checkbox" name="ProductStatus" id="status_<?= $product['ProductID'] ?>" onclick="ischecked(<?= $product['ProductID'] ?>)" class="check" <?= $product['ProductAvailability'] == 1 ? 'checked' : '' ?>>
															<label for="status_<?= $product['ProductID'] ?>" class="checktoggle">checkbox</label>
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
		function setDeleteId(productId) {
			// Update the delete button's href with the product ID
			const deleteButton = document.querySelector('#delete_modal .btn-danger a');
			deleteButton.href = `Product-list.php?deleteId=${productId}`;
		}

		const Ischeckbox = document.querySelector('.status-toggle input[type="checkbox"] .check');
		//get the value of the checkbox
		const checkboxValue = Ischeckbox.checked ? 1 : 0;
		console.log(checkboxValue);

		function ischecked(productId) {
			const checkbox = document.getElementById(`status_${productId}`);
			const checkboxValue = checkbox.checked ? 1 : 0;
			console.log(checkboxValue);
			//redirect after 1 second dalay
			setTimeout(() => {
				window.location.href = `Product-list.php?ProductId=${productId}&status=${checkboxValue}`;
			}, 1000);
		}
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