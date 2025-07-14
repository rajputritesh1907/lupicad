<?php
require_once(__DIR__ . "/../backend/connection.inc.php");
// require(__DIR__ . "/../backend/ProductTable.inc.php");
session_start(); // Make sure session is started

// if (!isset($_SESSION['admin_id'])) {
//   header("Location: adminlogin.php");
//   exit();
// }

$ProductReviews = mysqli_query($connection, "SELECT * FROM productreviews");

if ($ProductReviews) {
  $products = [];
  while ($row = mysqli_fetch_assoc($ProductReviews)) {
    $products[] = $row;
  }
  echo "<script>console.log(" . json_encode($products) . ");</script>";
} else {
  echo "<script>console.log('Error fetching ProductTable: " . mysqli_error($connection) . "');</script>";
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $Productname = $_POST['ProductName'];
  $UserID = $_POST['UserID'];
  $UserName = $_POST['UserName'];
  $ProductID = $_POST['ProductID'];
  $StarRating = $_POST['StarRating'];
  $Title = $_POST['Title'];
  $ReviewText = $_POST['ReviewText'];
  echo "<script>console.log(" . json_encode($_POST) . ");</script>";
}

$deleteId = isset($_GET['deleteId']) ? intval($_GET['deleteId']) : null;

if ($deleteId !== null) {
  $stmt = $connection->prepare("DELETE FROM productreviews WHERE ReviewID = ?");
  $stmt->bind_param("i", $deleteId);
  if ($stmt->execute()) {
    echo "<script>alert('Review deleted successfully!');</script>";
  } else {
    echo "<script>alert('Error deleting review: " . $stmt->error . "');</script>";
  }
  $stmt->close();
  header("Location: reviews.php");
  exit();
}

$userQuery = "SELECT id, name, profile_image FROM user";
$userResult = mysqli_query($connection, $userQuery);

$users = [];

if ($userResult) {
    while ($user = mysqli_fetch_assoc($userResult)) {
        $users[$user['id']] = $user; // Index by user id
    }
}

// Fetch reviews
$ProductReviews = mysqli_query($connection, "SELECT * FROM productreviews");
$products = [];

if ($ProductReviews) {
  while ($row = mysqli_fetch_assoc($ProductReviews)) {
    $products[] = $row;
  }
} else {
  echo "<script>console.log('Error fetching product reviews: " . mysqli_error($connection) . "');</script>";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>lupicad | Reviews Page</title>

  <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="../assets/lupicad/logo.svg">


  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="assets/css/bootstrap.min.css" />

  <!-- Fontawesome CSS -->
  <link rel="stylesheet" href="assets/plugins/fontawesome/css/fontawesome.min.css" />
  <link rel="stylesheet" href="assets/plugins/fontawesome/css/all.min.css" />

  <!-- Feathericon CSS -->
  <link rel="stylesheet" href="assets/css/feathericon.min.css" />

  <!-- Datatables CSS -->
  <link rel="stylesheet" href="assets/plugins/datatables/datatables.min.css" />

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


    <!-- Page Wrapper -->
    <div class="page-wrapper">
      <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
          <div class="row">
            <div class="col-sm-12">
              <h3 class="page-title">Reviews</h3>
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
                        <th>Name</th>
                        <th>Ratings</th>
                        <th>Description</th>
                        <th>Date</th>
                        <th>Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach ($products as $product): ?>
                      <?php 
    $userId = $product['UserID']; 
    $userData = isset($users[$userId]) ? $users[$userId] : null; 
  ?>
                        <tr>
                          <td>
                            <h2 class="table-avatar">
                           <?php if ($userData && empty($userData['profile_image'])): ?>
    <div class="rounded-circle btn-primary-gradient" style="background-color:rgba(27, 89, 144, 0.85); margin-right:5px; font-size:x-large; color:white; width:40px; height:40px; display:flex; justify-content:center; align-items:center;">
        <?= strtoupper(substr(htmlspecialchars($userData['name']), 0, 1)) ?>
    </div>
<?php elseif ($userData && !empty($userData['profile_image'])): ?>
    <a href="#" class="avatar avatar-sm me-2">
        <img class="avatar-img rounded-circle" src="../<?= htmlspecialchars($userData['profile_image']) ?>" alt="User Image">
    </a>
<?php else: ?>
    <div class="btn btn-md btn-primary-gradient d-inline-flex align-items-center rounded-pill" style="padding: 0.5rem 0.8rem;">
        U
    </div>
<?php endif; ?>

<a href="profilephp"><?= htmlspecialchars($product['UserName']) ?></a>
                            </h2>
                          </td>
                          <td>
                            <?php for ($i = 1; $i <= 5; $i++): ?>
                              <i
                                class="fe fe-star<?= $i <= $product['StarRating'] ? ' text-warning' : '-o text-secondary' ?>"></i>
                            <?php endfor; ?>
                          </td>
                          <td><?= htmlspecialchars($product['ReviewText']) ?></td>
                          <td>
                            <?php if (!empty($product['created_at'])): ?>
                              <?= date('j M Y', strtotime($product['created_at'])) ?><br />
                              <small><?= date('h.i A', strtotime($product['created_at'])) ?></small>
                            <?php else: ?>
                              N/A
                            <?php endif; ?>
                          </td>

                          <td>
                            <div class="actions">
                              <a class="btn btn-sm bg-danger-light" data-bs-toggle="modal" href="#delete_modal" data-id="<?= $product['ReviewID'] ?>">
                                <i class="fe fe-trash"></i> Delete
                              </a>
                            </div>
                          </td>
                        </tr>
                      <?php endforeach; ?>
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
            <div class="form-content p-2 text-center">
              <h4 class="modal-title">Delete Review</h4>
              <p class="mb-4">Are you sure you want to delete this review?</p>
              <div class="d-flex justify-content-center">
                <a id="confirmDelete" href="#" class="btn btn-primary me-2">Yes, Delete</a>
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- /Delete Modal -->
  </div>
  <!-- /Main Wrapper -->

  <!-- jQuery -->
  <script src="assets/js/jquery-3.7.1.min.js"></script>

  <!-- Bootstrap Core JS -->
  <script src="assets/js/bootstrap.bundle.min.js"></script>

  <!-- Slimscroll JS -->
  <script src="assets/plugins/slimscroll/jquery.slimscroll.min.js"></script>

  <!-- Datatables JS -->
  <script src="assets/plugins/datatables/jquery.dataTables.min.js"></script>
  <script src="assets/plugins/datatables/datatables.min.js"></script>

  <!-- Custom JS -->
  <script src="assets/js/script.js"></script>

  <script>
    const deleteModal = document.getElementById('delete_modal');
    deleteModal.addEventListener('show.bs.modal', function (event) {
      const button = event.relatedTarget;
      const reviewId = button.getAttribute('data-id');
      const confirmBtn = deleteModal.querySelector('#confirmDelete');
      confirmBtn.href = `reviews.php?deleteId=${reviewId}`;
    });

    // Initialize DataTable
    $(document).ready(function() {
      $('.datatable').DataTable({
        "order": [[3, "desc"]], // Sort by date column by default
        "pageLength": 10,
        "language": {
          "paginate": {
            "previous": "<i class='fas fa-chevron-left'></i>",
            "next": "<i class='fas fa-chevron-right'></i>"
          }
        }
      });
    });
  </script>

  <script src="../../../cdn-cgi/scripts/7d0fa10a/cloudflare-static/rocket-loader.min.js"
    data-cf-settings="239eaae59be9b7155c9e36a9-|49" defer></script>
  <script defer src="https://static.cloudflareinsights.com/beacon.min.js/vcd15cbe7772f49c399c6a5babf22c1241717689176015"
    integrity="sha512-ZpsOmlRQV6y907TI0dKBHq9Md29nnaEIPlkf84rnaERnq6zvWvPUqr2ft8M1aS28oN72PdrCzSjY4U6VaAw1EQ=="
    data-cf-beacon='{"rayId":"926c556719bc59c3","version":"2025.3.0","serverTiming":{"name":{"cfExtPri":true,"cfL4":true,"cfSpeedBrain":true,"cfCacheStatus":true}},"token":"3ca157e612a14eccbb30cf6db6691c29","b":1}'
    crossorigin="anonymous"></script>
</body>
</html>