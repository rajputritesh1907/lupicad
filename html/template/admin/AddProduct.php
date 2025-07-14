<?php
require(__DIR__ . "/../backend/connection.inc.php");
require(__DIR__ . "/../backend/ProductTable.inc.php");

//check url have product id like this AddProduct.php?ProductId=1

session_start();

if (isset($_GET['ProductId'])) {
    $ProductId = $_GET['ProductId'];

    // Prepare the SQL statement to fetch the data from the ProductTable and ProductDetailsTable
    $stmt = $connection->prepare("SELECT * FROM producttable WHERE ProductID = ?");
    $stmt->bind_param("i", $ProductId);
    $stmt->execute();
    $result = $stmt->get_result();
    $product = $result->fetch_assoc();
    $stmt->close();

    // Prepare the SQL statement to fetch the data from the ProductDetailsTable
    $stmt = $connection->prepare("SELECT * FROM productdetailstable WHERE ProductID = ?");
    $stmt->bind_param("i", $ProductId);
    $stmt->execute();
    $result = $stmt->get_result();
    $productDetails = $result->fetch_assoc();
    $stmt->close();

    // if form is submmited then update the product data in the database
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

        if (empty($ProductImage['name'][0])) {
            // If no new image is uploaded, keep the existing image
            // $stmt = $connection->prepare("SELECT ProductImage FROM ProductTable WHERE ProductID = ?");
            // $stmt->bind_param("i", $ProductId);
            // $stmt->execute();
            // $result = $stmt->get_result();
            // $existingProduct = $result->fetch_assoc();
            // $ProductImageJson = $existingProduct['ProductImage'];
            // $stmt->close();

            // Update the product data in the database without changing the image
            $stmt = $connection->prepare("UPDATE producttable SET ProductName = ?, ProductShortDescription = ?, ProductCategories = ?, ProductPrice = ?, ProductAvailability = ?, ProductRating = ? WHERE ProductID = ?");
            $stmt->bind_param("sssdidi", $Productname, $ProductShortDescription, $ProductCategories, $ProductPrice, $ProductAvailability, $ProductRating, $ProductId);
            $stmt->execute();
            $stmt->close();
        } else {
            // Directory to store uploaded images
            $uploadDir = "../uploads/";
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true); // Create the directory with write permissions
            }

            // Initialize the array to store uploaded image filenames
            $ProductImagePaths = [];

            // Loop through the uploaded files and save them to the server
            foreach ($ProductImage['tmp_name'] as $key => $tmp_name) {
                if (!empty($tmp_name)) {
                    $imageName = uniqid("IMG-", true) . "." . pathinfo($ProductImage['name'][$key], PATHINFO_EXTENSION);
                    $imagePath = $uploadDir . $imageName; // Full path for moving the file

                    // Move the uploaded file to the destination directory
                    if (move_uploaded_file($tmp_name, $imagePath)) {
                        $ProductImagePaths[] = $imageName; // Store only the filename
                    } else {
                        echo "<script>console.log('❌ Error uploading image: " . $ProductImage['name'][$key] . "');</script>";
                    }
                }
                // Convert the array of filenames to JSON
                if (!empty($ProductImagePaths)) {
                    $ProductImageJson = json_encode($ProductImagePaths);
                } else {
                    $ProductImageJson = $product['ProductImage']; // Fallback to existing images if no new images are uploaded
                }
                echo "<script>console.log('ProductImageJson: " . addslashes($ProductImageJson) . "');</script>";
            }

            // Update the product data in the database
            $stmt = $connection->prepare("UPDATE producttable SET ProductName = ?, ProductShortDescription = ?, ProductCategories = ?, ProductPrice = ?, ProductAvailability = ?, ProductRating = ?, ProductImage = ? WHERE ProductID = ?");
            $stmt->bind_param("sssdidsi", $Productname, $ProductShortDescription, $ProductCategories, $ProductPrice, $ProductAvailability, $ProductRating, $ProductImageJson, $ProductId);
            $stmt->execute();
            $stmt->close();
        }


        // Update the product details data in the database
        $stmt = $connection->prepare("UPDATE productdetailstable SET SubTitle = ?, Quantity = ?, SKU = ?,PackSize = ?, UnitCount = ?, Country = ?, Discount = ?, ProductDescription = ?, Directions = ?, Storage = ?, Administration = ?, Warning = ?, Precaution = ? WHERE ProductID = ?");
        $stmt->bind_param("sissssissssssi", $ProductSubTitle, $ProductQuantity, $ProductSKU, $ProductPackSize, $ProductUnitCount, $ProductCountry, $ProductDiscount, $ProductDescription, $ProductDirections, $ProductStorage, $ProductAdministration, $ProductWarning, $ProductPrecaution, $ProductId);

        //check if the product is updated successfully
        $stmt->execute();
        if ($stmt->affected_rows > 0) {
            echo "<script>console.log('Product updated successfully.');</script>";
        } else {
            echo "<script>console.log('No changes were made to the product.');</script>";
        }

        $stmt->close();

        header("Location: ./Product-list.php");
        exit();
    }
} else {
    echo "<script>console.log('Product ID not found.');</script>";
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupicad | Admin-Add Products</title>

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
    <style>
        /* form textarea will increase to 200px */
        textarea.form-control {
            transition: all 0.3s ease-in-out;
            resize: none;
        }

        /* form textarea will increase to 200px on focus */
        textarea.form-control:focus {
            height: 200px;
            resize: none;
        }

        /* form textarea will increase to 200px on click  */
        textarea.form-control:active {
            height: 200px;
            resize: none;
        }
    </style>

</head>

<body>

    <!-- Header -->
    <?php require(__DIR__ . "/components/header.inc.php") ?>
    <!-- /Header -->


    <div class="container mt-5 mb-5">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h3 class="mb-0">Add Product</h3>
            </div>
            <div class="card-body">
                <form action="<?= (isset($_GET['ProductId'])) ? './AddProduct.php?ProductId=' . $ProductId : './Product-list.php' ?>" method="POST" enctype="multipart/form-data">

                    <!-- ProductTable Fields -->
                    <h4 class="mb-4">Product Information</h4>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="ProductName" class="form-label">Product Name:</label>
                            <input type="text" id="ProductName" name="ProductName" class="form-control" value="<?= isset($product['ProductName']) ? htmlspecialchars($product['ProductName']) : '' ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label for="filter" class="form-label">Select Category:</label>
                            <select id="filter" name="filter" class="form-select">
                                <option value="" disabled <?= !isset($product['ProductCategories']) ? 'selected' : '' ?>>Choose a category</option>
                                <option value="Hygiene" <?= isset($product['ProductCategories']) && $product['ProductCategories'] == 'Hygiene' ? 'selected' : '' ?>>Immunity & Hygiene</option>
                                <option value="Skin" <?= isset($product['ProductCategories']) && $product['ProductCategories'] == 'Skin' ? 'selected' : '' ?>>Skin Care</option>
                                <option value="Hair" <?= isset($product['ProductCategories']) && $product['ProductCategories'] == 'Hair' ? 'selected' : '' ?>>Hair Care</option>
                                <option value="male" <?= isset($product['ProductCategories']) && $product['ProductCategories'] == 'male' ? 'selected' : '' ?>>Men's Care</option>
                                <option value="female" <?= isset($product['ProductCategories']) && $product['ProductCategories'] == 'female' ? 'selected' : '' ?>>Women's Care</option>
                                <option value="Breathing" <?= isset($product['ProductCategories']) && $product['ProductCategories'] == 'Breathing' ? 'selected' : '' ?>>Breathing Problem</option>
                                <option value="Body" <?= isset($product['ProductCategories']) && $product['ProductCategories'] == 'Body' ? 'selected' : '' ?>>Body & Joint Pain</option>
                                <option value="Headache" <?= isset($product['ProductCategories']) && $product['ProductCategories'] == 'Headache' ? 'selected' : '' ?>>Headache & Migraine</option>
                                <option value="General" <?= isset($product['ProductCategories']) && $product['ProductCategories'] == 'General' ? 'selected' : '' ?>>General Health</option>
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="ProductPrice" class="form-label">Price:</label>
                            <input type="number" id="ProductPrice" name="ProductPrice" class="form-control" min='0' value="<?= isset($product['ProductPrice']) ? htmlspecialchars($product['ProductPrice']) : '' ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label for="ProductImage" class="form-label">Product Image:</label>
                            <input type="file" id="ProductImage" name="ProductImage[]" class="form-control" accept="image/*" multiple <?= isset($product['ProductImage']) ? '' : 'required' ?>>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="ProductShortDescription" class="form-label">Short Description:</label>
                        <textarea id="ProductShortDescription" name="ProductShortDescription" class="form-control" rows="3" required><?= isset($product['ProductShortDescription']) ? htmlspecialchars($product['ProductShortDescription']) : '' ?></textarea>
                    </div>

                    <!-- ProductDetailsTable Fields -->
                    <h4 class="mb-4">Product Details</h4>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="SubTitle" class="form-label">Sub Title:</label>
                            <input type="text" id="SubTitle" name="SubTitle" value="<?= isset($productDetails['SubTitle']) ? $productDetails['SubTitle'] : '' ?>" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label for="Quantity" class="form-label">Quantity:</label>
                            <input type="number" id="Quantity" name="Quantity" class="form-control" min="0" value="<?= isset($productDetails['Quantity']) ? $productDetails['Quantity'] : '1' ?>" max="100" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="SKU" class="form-label">SKU:</label>
                            <input type="text" id="SKU" name="SKU" value="<?= isset($productDetails['SKU']) ? $productDetails['SKU'] : '' ?>" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label for="PackSize" class="form-label">Pack Size:</label>
                            <input type="text" id="PackSize" name="PackSize" value="<?= isset($productDetails['PackSize']) ? $productDetails['PackSize'] : '' ?>" class="form-control">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="UnitCount" class="form-label">Unit Count/weight :</label>
                            <input type="text" id="UnitCount" name="UnitCount" value="<?= isset($productDetails['UnitCount']) ? $productDetails['UnitCount'] : '' ?>" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label for="Country" class="form-label">Country:</label>
                            <input type="text" id="Country" name="     " value="<?= isset($productDetails['Country']) ? $productDetails['Country'] : 'India' ?>" class="form-control">
                        </div>
                    </div>

                    <div class=" mb-3">
                        <label for="Discount" class="form-label">Discount (%):</label>
                        <input type="number" id="Discount" name="Discount" class="form-control" value="<?= isset($productDetails['Discount']) ? $productDetails['Discount'] : '0' ?>" min="0" max="100">
                    </div>
                    <div class="mb-3">
                        <label for="ProductDescription" class="form-label">Description:</label>
                        <textarea id="ProductDescription" name="ProductDescription" class="form-control" rows="3" required><?= isset($productDetails['ProductDescription']) ? $productDetails['ProductDescription'] : '' ?></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="Directions" class="form-label">Directions:</label>
                        <textarea id="Directions" name="Directions" class="form-control" rows="3"><?= isset($productDetails['Directions']) ? $productDetails['Directions'] : '' ?></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="Storage" class="form-label">Storage:</label>
                        <textarea id="Storage" name="Storage" class="form-control" rows="3"><?= isset($productDetails['Storage']) ? $productDetails['Storage'] : '' ?></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="Administration" class="form-label">Administration:</label>
                        <textarea id="Administration" name="Administration" class="form-control" rows="3"><?= isset($productDetails['Administration']) ? $productDetails['Administration'] : '' ?></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="Warning" class="form-label">Warning:</label>
                        <textarea id="Warning" name="Warning" class="form-control" rows="3"><?= isset($productDetails['Warning']) ? $productDetails['Warning'] : '' ?></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="Precaution" class="form-label">Precaution:</label>
                        <textarea id="Precaution" name="Precaution" class="form-control" rows="3"><?= isset($productDetails['Precaution']) ? $productDetails['Precaution'] : '' ?></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Submit</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="assets/js/bootstrap.bundle.min.js"></script>
</body>

</html>