<?php
require_once(__DIR__ . "/backend/ProductTable.inc.php");
require_once(__DIR__ . "/backend/connection.inc.php");
require_once(__DIR__ . "/backend/function.inc.php");

session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$product_id = $_POST['product_id'] ?? null;
$deleteId = $_POST['deleteId'] ?? null;


// Add product to wishlist
if ($product_id) {
    $checkProductQuery = "SELECT COUNT(*) FROM producttable WHERE ProductID = ?";
    $stmt = mysqli_prepare($connection, $checkProductQuery);
    if (!$stmt)
        die('SQL Error: ' . mysqli_error($connection));
    mysqli_stmt_bind_param($stmt, "i", $product_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $productCount);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);

    if ($productCount == 0) {
        echo "<script>console.log('Invalid product ID!');</script>";
        exit();
    }

    $query = "SELECT wishList FROM user WHERE id = ?";
    $stmt = mysqli_prepare($connection, $query);
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);

    if (!$row) {
        echo "Error: User not found.";
        exit();
    }

    $wishList = $row['wishList'] ? json_decode($row['wishList'], true) : [];
    if (!in_array($product_id, $wishList)) {
        $wishList[] = $product_id;
        $updatedWishList = json_encode($wishList);
        $stmt = mysqli_prepare($connection, "UPDATE user SET wishList = ? WHERE id = ?");
        mysqli_stmt_bind_param($stmt, "si", $updatedWishList, $user_id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        echo "<script>console.log('Product added to wishlist successfully!');</script>";
    } else {
        echo "<script>console.log('This product is already in your wishlist!');</script>";
    }
}

// Get wishlist
$query = "SELECT wishList FROM user WHERE id = ?";
$stmt = $connection->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$stmt->close();

$wishList = $row ? json_decode($row['wishList'], true) : [];

$wishListDetails = [];
$wishListProducts = [];

if (!empty($wishList)) {
    foreach ($wishList as $productId) {
        $stmt = $connection->prepare("SELECT * FROM producttable WHERE ProductID = ?");
        $stmt->bind_param("i", $productId);
        $stmt->execute();
        $result = $stmt->get_result();
        $product = $result->fetch_assoc();
        $wishListProducts[] = $product;
        $stmt->close();

        $stmt = $connection->prepare("SELECT * FROM productdetailstable WHERE ProductID = ?");
        $stmt->bind_param("i", $productId);
        $stmt->execute();
        $result = $stmt->get_result();
        $details = $result->fetch_assoc();
        $wishListDetails[] = $details;
        $stmt->close();
    }
}
// Delete product from wishlist
if ($deleteId !== null) {
    $wishList = array_values(array_filter($wishList, fn($id) => $id != $deleteId));
    $stmt = $connection->prepare("UPDATE user SET wishList = ? WHERE id = ?");
    $stmt->bind_param("si", json_encode($wishList), $user_id);
    $stmt->execute();
    $stmt->close();
    header("Location: wishlist.php");
    exit();
}

mysqli_close($connection);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description"
        content="The responsive professional Doccure template offers many features, like scheduling appointments with  top doctors, clinics, and hospitals via voice, video call & chat.">
    <meta name="keywords"
        content="practo clone, doccure, doctor appointment, Practo clone html template, doctor booking template">
    <meta name="author" content="Practo Clone HTML Template - Doctor Booking Template">
    <meta property="og:url" content="https://doccure.dreamstechnologies.com/html/">
    <meta property="og:type" content="website">
    <meta property="og:title" content="Doctors Appointment HTML Website Templates | Doccure">
    <meta property="og:description"
        content="The responsive professional Doccure template offers many features, like scheduling appointments with  top doctors, clinics, and hospitals via voice, video call & chat.">
    <meta property="og:image" content="assets/img/preview-banner.jpg">
    <meta name="twitter:card" content="summary_large_image">
    <meta property="twitter:domain" content="https://doccure.dreamstechnologies.com/html/">
    <meta property="twitter:url" content="https://doccure.dreamstechnologies.com/html/">
    <meta name="twitter:title" content="Doctors Appointment HTML Website Templates | Doccure">
    <meta name="twitter:description"
        content="The responsive professional Doccure template offers many features, like scheduling appointments with  top doctors, clinics, and hospitals via voice, video call & chat.">
    <meta name="twitter:image" content="assets/img/preview-banner.jpg">
    <title>Lupicad | Wishlist</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="assets/lupicad/logo.svg" type="image/x-icon">
    <!-- Apple Touch Icon -->
    <link rel="apple-touch-icon" sizes="180x180" href="assets/img/apple-touch-icon.png">

    <!-- Theme Settings Js -->
    <script src="assets/js/theme-script.js" type="c849e038eaf1cb3c8081b3ca-text/javascript"></script>

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
    <script>
        function deleteToWishlist(productId) {
            $.ajax({
                type: "POST",
                url: "wishlist.php",
                data: {
                    deleteId: productId
                },
                success: function(response) {
					showToast('Product removed from wishlist successfully!', 'success');
                    //reload the page after 2seconds to show the toast message then refresh the page
                    setTimeout(function() {
                        location.reload();
                    }, 800);
                },
                error: function(xhr, status, error) {
                    console.error("Error deleting product from wishlist:", error);
                    showToast('Error deleting product from wishlist', 'danger');
                }
            });
        }
    </script>
</head>

<body>

    <!-- Main Wrapper -->
    <div class="main-wrapper">

        <!-- Header -->
        <?php require_once(__DIR__ . "/components/header.php"); ?>
        <!-- /Header -->

        <!-- Breadcrumb -->
        <div class="breadcrumb-bar">
            <div class="container">
                <div class="row align-items-center inner-banner">
                    <div class="col-md-12 col-12 text-center">
                        <nav aria-label="breadcrumb" class="page-breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="index.html"><i class="isax isax-home-15">
                                        </i>
                                    </a>
                                </li>
                                <li class="breadcrumb-item" aria-current="page">Home</li>
                                <li class="breadcrumb-item active">Wishlist</li>
                            </ol>
                            <h2 class="breadcrumb-title">Wishlist</h2>
                        </nav>
                    </div>
                </div>
            </div>
        </div>

        <!-- Page Content -->
        <div class="content" style="padding-top: 0;">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <?php if (empty($wishListDetails)): ?>
                            <p class="text-center fs-4 my-5">Your wishlist is empty.</p>
                        <?php else: ?>
                            <div class="wishlist-container">
                                <div class="row g-4">
                                    <?php for ($i = 0; $i < count($wishListDetails); $i++):
                                        $product = $wishListProducts[$i];
                                        $details = $wishListDetails[$i];
                                        $productImages = json_decode($product['ProductImage'], true);
                                        if (is_array($productImages) && count($productImages) > 0) {
                                            $mainImage = $productImages[0];
                                            $hoverImage = isset($productImages[1]) ? $productImages[1] : $productImages[0];
                                        } else {
                                            $mainImage = 'default-image.jpg';
                                            $hoverImage = 'default-image.jpg';
                                        }
                                    ?>
                                        <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                                            <div class="card h-100">
                                                <div class="card-img card-img-hover">
                                                    <div class="image-container" style="display: flex; justify-content: center; align-items: center;">
												
													<img src="./uploads/<?= $mainImage ?>" id="img-1" alt="product image" style="width: 100%; height:80% !important;">
												</a>
												
													<img src="./uploads/<?= $hoverImage ?>" id="img-2" alt="product image" style="width: 100%; height:60% !important" ;>
												</a>
											</div>
                                                </div>
                                                <div class="grid-overlay-item d-flex align-items-center justify-content-between">
                                                    <div></div>
                                                    <a href="javascript:void(0)" class="fav-icon"
                                                        onclick="deleteToWishlist(<?= $product['ProductID'] ?>)"
                                                        style="box-shadow:0px 0px 5px -1px rgba(0, 0, 0, 0.35);">
                                                        <i class="fas fa-heart" style="color:#fc3340 !important;"></i>
                                                    </a>
                                                </div>
                                                <div class="card-body p-0">
                                                    <div class="d-flex active-bar align-items-center justify-content-between p-3">
                                                        <a href="javascript:void(0)"
                                                            class="text-indigo fw-medium fs-14"><?= $product['ProductCategories'] ?></a>
                                                        <span class="badge d-inline-flex align-items-center"
                                                            style="color: white; background-color: <?= $product['ProductAvailability'] ? 'green' : 'red' ?>;">
                                                            <i class="fa-solid fa-circle fs-5 me-1"></i>
                                                            <?= $product['ProductAvailability'] ? 'Available' : 'Out of Stock' ?>
                                                        </span>
                                                    </div>
                                                    <div class="p-3 pt-0">
                                                        <div class="doctor-info-detail mb-3">
                                                            <h3 class="mb-1 product-title">
                                                                <a href="product-description.php?id=<?= $product['ProductID'] ?>"
                                                                   class="text-truncate d-block"><?= $product['ProductName'] ?></a>
                                                            </h3>
                                                             
                                                        </div>
                                                        <div class="d-flex align-items-center justify-content-between">
                                                            <div>
                                                                <h3 class="text-orange mb-0">
                                                                    <span class="woocommerce-Price-currencySymbol">₹</span><?= $product['ProductPrice'] ?>
                                                                </h3>
                                                            </div>
                                                             <a href="./cart.php?product_id=<?= $product['ProductID'] ?>"
                                                                    class="cart-icon">
                                                                    <i class="fas fa-shopping-cart"></i>
                                                                </a>
                                                            
                                                        </div>
                                                        <div class="d-flex align-items-center gap-2">
                                                                <a href="product-description.php?id=<?= $product['ProductID'] ?>"
                                                                    class="btn btn-sm btn-dark d-inline-flex align-items-center rounded-pill"
                                                                    style="background-color: #d3a02e !important; border: none;">
                                                                    <i class="isax isax-calendar-1 me-1"></i>
                                                                    Buy Now
                                                                </a>
                                                               
                                                            </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endfor; ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- /Main Wrapper -->
    <script src="assets/js/jquery-3.7.1.min.js" type="3bafbe4753ecb41c5bac6514-text/javascript"></script>

    <!-- Bootstrap Core JS -->
    <script src="assets/js/bootstrap.bundle.min.js" type="3bafbe4753ecb41c5bac6514-text/javascript"></script>

    <!-- Sticky Sidebar JS -->
    <script src="assets/plugins/theia-sticky-sidebar/ResizeSensor.js"
        type="3bafbe4753ecb41c5bac6514-text/javascript"></script>
    <script src="assets/plugins/theia-sticky-sidebar/theia-sticky-sidebar.js"
        type="3bafbe4753ecb41c5bac6514-text/javascript"></script>

    <!-- Select2 JS -->
    <script src="assets/plugins/select2/js/select2.min.js" type="3bafbe4753ecb41c5bac6514-text/javascript"></script>

    <!-- Datetimepicker JS -->
    <script src="assets/js/moment.min.js" type="3bafbe4753ecb41c5bac6514-text/javascript"></script>
    <script src="assets/js/bootstrap-datetimepicker.min.js" type="3bafbe4753ecb41c5bac6514-text/javascript"></script>

    <!-- Fancybox JS -->
    <script src="assets/plugins/fancybox/jquery.fancybox.min.js"
        type="3bafbe4753ecb41c5bac6514-text/javascript"></script>

    <!-- Custom JS -->
    <script src="assets/js/script.js" type="3bafbe4753ecb41c5bac6514-text/javascript"></script>

    <script src="../../cdn-cgi/scripts/7d0fa10a/cloudflare-static/rocket-loader.min.js"
        data-cf-settings="3bafbe4753ecb41c5bac6514-|49" defer></script>
    <script defer
        src="https://static.cloudflareinsights.com/beacon.min.js/vcd15cbe7772f49c399c6a5babf22c1241717689176015"
        integrity="sha512-ZpsOmlRQV6y907TI0dKBHq9Md29nnaEIPlkf84rnaERnq6zvWvPUqr2ft8M1aS28oN72PdrCzSjY4U6VaAw1EQ=="
        data-cf-beacon='{"rayId":"926c47deddc159d6","version":"2025.1.0","serverTiming":{"name":{"cfExtPri":true,"cfL4":true,"cfSpeedBrain":true,"cfCacheStatus":true}},"token":"3ca157e612a14eccbb30cf6db6691c29","b":1}'
        crossorigin="anonymous">
    </script>

    <script src="assets/js/jquery-3.7.1.min.js"></script>
    <script src="assets/js/bootstrap.bundle.min.js"></script>
</body>

</html>

<style>
.card {
    /* transition: transform 0.3s ease, box-shadow 0.3s ease; */
    border: none;
    box-shadow: 0 0 15px rgba(0,0,0,0.1);
}

 

.product-title a {
    color: #333;
    text-decoration: none;
    font-size: 1.1rem;
    font-weight: 600;
    line-height: 1.4;
}

.product-desc {
    font-size: 0.9rem;
    color: #666;
    margin-bottom: 1rem;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    text-overflow: ellipsis;
}

.cart-icon {
    width: 35px;
    height: 35px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    background: #f8f9fa;
    border-radius: 50%;
    color: #333;
    /* transition: all 0.3s ease; */
}

 

@media (max-width: 767px) {
    .product-title a {
        font-size: 1rem;
    }
    
    .product-desc {
        font-size: 0.85rem;
    }
    
    .text-orange {
        font-size: 1.1rem;
    }
    
    .btn-sm {
        font-size: 0.8rem;
        padding: 0.25rem 0.5rem;
    }
}

@media (min-width: 768px) and (max-width: 991px) {
    .product-title a {
        font-size: 0.95rem;
    }
    
    .product-desc {
        font-size: 0.8rem;
    }
    
    .text-orange {
        font-size: 1rem;
    }
    
    .btn-sm {
        font-size: 0.75rem;
        padding: 0.2rem 0.4rem;
    }
}

.row.g-4 {
    margin-right: -12px;
    margin-left: -12px;
}

.row.g-4 > [class*="col-"] {
    padding-right: 12px;
    padding-left: 12px;
}
</style>