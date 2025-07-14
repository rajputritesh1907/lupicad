<?php
require(__DIR__ . '/../backend/connection.inc.php');

// If session is not started then start the session
if (session_status() === PHP_SESSION_NONE) {
	session_start();
}

$user_id = $_SESSION['user_id'] ?? null;
$user_name = '';

if ($user_id) {
	$sql = "SELECT name FROM user WHERE id = ?";
	$stmt = $connection->prepare($sql);
	$stmt->bind_param("i", $user_id);
	$stmt->execute();
	$result = $stmt->get_result();

	if ($row = $result->fetch_assoc()) {
		$user_name = $row['name'];
	}
}

if ($user_id) {
	echo "<script>console.log('user is login');</script>";
} else {
	echo "<script>console.log('not login');</script>";
}

// fatch cart product from user table
// $sqlTable = "SELECT cartProducts FROM user WHERE id = ?";
// $stmt = $connection->prepare($sqlTable);
// $stmt->bind_param("i", $user_id);
// $stmt->execute();
// $result = $stmt->get_result();
// $cartProducts = '';
// if ($row = $result->fetch_assoc()) {
// 	$cartProducts = $row['cartProducts'];
// }


// echo "<script>console.log('Cart Products: " . $cartProducts . "');</script>";
if (isset($_GET['query'])) {
    $search = '%' . $connection->real_escape_string($_GET['query']) . '%';

    $sql = "SELECT id, ProductName FROM product WHERE ProductName LIKE ? LIMIT 10";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("s", $search);
    $stmt->execute();
    $result = $stmt->get_result();

    $products = [];
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }

    echo json_encode($products);
    exit;
}


?>


<header class="header header-custom header-fixed inner-header relative">
	<div class="container">
		<nav class="navbar navbar-expand-lg header-nav">
			<div class="navbar-header">
				<a id="mobile_btn" href="javascript:void(0);">
					<span class="bar-icon">
						<span></span>
						<span></span>
						<span></span>
					</span>
				</a>
				<a href="index.php" class="navbar-brand logo">
					<img src="assets/img/LupicadResizedLogo.svg" class="img-fluid" alt="Logo">
				</a>
			</div>
			<div class="header-menu">
				<div class="main-menu-wrapper">
					<div class="menu-header">
						<a href="index.php" class="menu-logo">
							<img src="assets/img/LupicadResizedLogo.svg" class="img-fluid" alt="Logo">
						</a>
						<a id="menu_close" class="menu-close" href="javascript:void(0);">
							<i class="fas fa-times"></i>
						</a>
					</div>
					<ul class="main-nav">
						<li class="has-submenu megamenu ">
							<a href="index.php">Home <i class=""></i></a>
						</li>
						<li><a href="about-us.php">About Us</a></li>
						<li class="has-submenu">
							<a href="product-all.php">Products<i class="fas fa-chevron-down"></i></a>
							<ul class="submenu">
								<li><a href="product-all.php?filter=male">Male Health
									</a></li>
								<li><a href="product-all.php?filter=female">Female Health</a></li>
								<li class="has-submenu">
									<a href="product-all.php">General Health</a>
									<ul class="submenu inner-submenu">
										<li><a href="product-all.php?filter=Hygiene">Immunity & Hygiene</a></li>
										<li><a href="product-all.php?filter=Breathing">Breathing Problem</a></li>
										<li><a href="product-all.php?filter=Body">Body & Joint Pain</a></li>
										<li><a href="product-all.php?filter=Headache">Headache & Migrain </a></li>
										<li><a href="product-all.php?filter=Hair">Hair Care </a></li>
										<li><a href="product-all.php?filter=Skin">Skin Care</a></li>
									</ul>
								</li>

							</ul>
						</li>

						<li><a href="blog-list.php">Our Blog</a></li>
						<li><a href="contact-us.php">Contact Us</a></li>

						<li class="d-block d-sm-none"><a href="contact-us.php">Wishlist</a></li>
						<li class="d-block d-sm-none"><a href="contact-us.php">Cart</a></li>
						<?php if (!$user_id): ?>
							<li class="d-block d-sm-none"><a href="login.php"><i class="isax isax-lock-1 me-1"></i>Login</a></li>
							<li class="d-block d-sm-none"><a href="register.php"><i class="isax isax-user-tick me-1"></i>Signup</a></li>
						<?php else: ?>
							<li class="d-block d-sm-none"><a class="dropdown-item" href="logout.php">Logout</a></li>
						<?php endif; ?>
					</ul>
				</div>

				<ul class="nav header-navbar-rht">
					<li class="header-theme noti-nav">

						<a href="wishlist.php" id="" class="theme-toggle activate">
							<i class="fa fa-heart" style="color: brown;"></i>
						</a>
					</li>



					<!-- Cart -->
					<li class="nav-item dropdown noti-nav view-cart-header me-3 pe-0">
						<a href="cart.php" id=""
							class="dropdown-toggle nav-link active-dot active-dot-purple p-0 position-relative">
							<i class="isax isax-shopping-cart"></i>
						</a>
					</li>
					<!-- /Cart -->
					<li>
						<?php if ($user_id): ?>
					<li class="nav-item dropdown has-arrow">
						<a href="#" class="dropdown-toggle nav-link" data-bs-toggle="dropdown">
							<span class="user-img">
								<?php if (!empty($userProfile['profile_image'])): ?>
									<img class="rounded-circle" alt="User Image" style="height: 40px; width: 40px; border:1px solid rgba(51, 51, 51, 0.27) !important" src="<?= htmlspecialchars($userProfile['profile_image']) ?>">
								<?php else: ?>
									<div class="btn btn-md btn-primary-gradient d-inline-flex align-items-center rounded-pill"
										style="padding: 0.5rem 0.8rem;">
										<?php echo strtoupper(substr($user_name, 0, 1)); ?>
									</div>
								<?php endif; ?>
							</span>
						</a>
						<div class="dropdown-menu">
							<div class="user-header">
								<span class="user-img">
									<?php if (!empty($userProfile['profile_image'])): ?>
										<img class="rounded-circle" alt="User Image" style="height: 40px; width: 40px; border:1px solid rgba(51, 51, 51, 0.27) !important" src="<?= htmlspecialchars($userProfile['profile_image']) ?>">
									<?php else: ?>
										<div class="btn btn-md btn-primary-gradient d-inline-flex align-items-center rounded-pill"
											style="padding: 0.5rem 0.8rem;">
											<?php echo strtoupper(substr($user_name, 0, 1)); ?>
										</div>
									<?php endif; ?>
								</span>
								<div class="user-text">
									<h6><?php echo strtoupper(substr($user_name, 0)); ?>
									</h6>
									<p class="text-muted mb-0">User</p>
								</div>
							</div>
							<a class="dropdown-item" href="profile.php">My Profile</a>
							<a class="dropdown-item" href="logout.php">Logout</a>

						</div>
					</li>
				<?php else: ?>
					<a href="login.php"
						class="btn btn-md btn-primary-gradient d-inline-flex align-items-center rounded-pill">
						<i class="isax isax-lock-1 me-1"></i>Login
					</a>
				<?php endif; ?>
				</li>
				<?php if (!$user_id): ?>
					<li>
						<a href="register.php"
							class="btn btn-md btn-dark d-inline-flex align-items-center rounded-pill">
							<i class="isax isax-user-tick me-1"></i>Register
						</a>
					</li>
				<?php endif; ?>
				</ul>
			</div>
		</nav>
	</div>
			<div class="mouse-cursor cursor-outer">
		</div>
		<div class="mouse-cursor cursor-inner">
		</div>
	<style>
		.toast {
			visibility: hidden;
			min-width: 250px;
			background-color: #333;
			color: #fff;
			text-align: center;
			border-radius: 5px;
			padding: 16px;
			position: fixed;
			z-index: 1000;
			left: 50%;
			top: 20px;
			transform: translate(-50%, -50%) scale(0.9);
			/* Start slightly smaller */
			font-size: 17px;
			opacity: 0;
			transition: opacity 0.5s ease, transform 0.5s ease;
			/* Smooth transition for opacity and scale */
		}

		.toast.show {
			visibility: visible;
			opacity: 1;
			transform: translate(-50%, 0) scale(1);
			/* Move to the correct position and scale to normal size */
		}
	</style>
	<script>
		function showToast(message, type = "success") {
			// Define colors for different types
			const colors = {
				success: "#28a745", // Green for success
				danger: "#dc3545" // Red for danger
			};

			// Create the toast element
			const toast = document.createElement("div");
			toast.className = "toast";
			toast.style.backgroundColor = colors[type] || "#333"; // Default to dark gray if type is unknown
			toast.innerText = message;

			// Append the toast to the body
			document.body.appendChild(toast);

			// Show the toast
			setTimeout(() => {
				toast.classList.add("show");
			}, 100);

			// Hide the toast after 3 seconds
			setTimeout(() => {
				toast.classList.remove("show");
				setTimeout(() => {
					toast.remove();
				}, 500); // Wait for the animation to complete before removing
			}, 3000);
		}
	</script>
	<script>
  function searchProducts(query) {
    if (query.length < 2) {
      document.getElementById("searchResults").innerHTML = "";
      return;
    }

    fetch('backend/search-products.php?query=' + encodeURIComponent(query))
      .then(response => response.json())
      .then(data => {
        let resultsList = document.getElementById("searchResults");
        resultsList.innerHTML = '';

        if (data.length === 0) {
          resultsList.innerHTML = '<li class="list-group-item">No products found</li>';
        } else {
          data.forEach(product => {
            let li = document.createElement("li");
            li.className = "list-group-item";
            li.innerHTML = `<a href="product-description.php?id=${product.id}">${product.ProductName}</a>`;
            resultsList.appendChild(li);
          });
        }
      })
      .catch(error => {
        console.error('Search error:', error);
      });
  }
  
  
  
</script>

<!-- Inline CSS for Styling -->
	<style>
		.image-slider {
			width: 100%;
			margin: 0 auto;
		}

		.slider-container {
			width: 100%;
		}

		.slider-container img {
			width: 100%;
			object-fit: cover;
		} 

		/* Cursor Media Query */
		/*@media (max-width: 735px) {*/
		/*	.mouse-cursor {*/
		/*		display: none !important;*/
		/*	}*/
			
		/*	* {*/
		/*		cursor: auto !important;*/
		/*	}*/
			
		/*	a, button, .cursor-pointer, [role="button"] {*/
		/*		cursor: pointer !important;*/
		/*	}*/
		/*}*/

		/*@media (min-width: 736px) {*/
		/*	body:hover {*/
		/*		cursor: none;*/
		/*	}*/
		/*}*/
	</style>

</header>