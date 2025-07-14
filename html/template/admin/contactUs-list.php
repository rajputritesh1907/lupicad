<?php
// Including the database connection file
require(__DIR__ . "/../backend/connection.inc.php");

session_start();

// Fetching the data from the contactusform table
$stmt = $connection->prepare("SELECT * FROM contactusform ORDER BY id DESC");
$stmt->execute();
$result = $stmt->get_result();
$contactsInfo = [];
while ($row = $result->fetch_assoc()) {
    $contactsInfo[] = $row;
}
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupicad | Admin-Contact Us List</title>

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
                            <h3 class="page-title">Contact Us Messages</h3>
                        </div>
                    </div>
                </div>
                <!-- /Page Header -->

                <div class="row">
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="datatable table table-hover table-center mb-0" style="width:100%;">
                                        <thead>
                                            <tr>
                                                <th style="text-align:center;">ID</th>
                                                <th style="text-align:center;">Name</th>
                                                <th style="text-align:center;">Phone</th>
                                                <th style="text-align:center;">Email</th>
                                                <th style="text-align:center;">Category</th>
                                                <th style="text-align:center;">Message</th>
                                                <th style="text-align:center;">Date & Time</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (empty($contactsInfo)): ?>
                                                <tr>
                                                    <td colspan="7" class="text-center">No messages found.</td>
                                                </tr>
                                            <?php else: ?>
                                                <?php foreach ($contactsInfo as $contact): ?>
                                                    <tr>
                                                        <td style="text-align:center;"><?= htmlspecialchars($contact['id']); ?></td>
                                                        <td style="text-align:center;"><?= htmlspecialchars($contact['name']); ?></td>
                                                        <td style="text-align:center;"><?= htmlspecialchars($contact['phone']); ?></td>
                                                        <td style="text-align:center;"><?= htmlspecialchars($contact['email']); ?></td>
                                                        <td style="text-align:center;">
                                                            <?php if (strtolower($contact['category']) == 'issue'): ?>
                                                                <span class="badge bg-warning text-dark"><?= htmlspecialchars($contact['category']); ?></span>
                                                            <?php else: ?>
                                                                <span class="badge bg-success"><?= htmlspecialchars($contact['category']); ?></span>
                                                            <?php endif; ?>
                                                        </td>
                                                        <td style="text-align:center;"><?= nl2br(htmlspecialchars($contact['message'])); ?></td>
                                                        <td style="text-align:center;">
                                                            <?php
                                                            $dt = strtotime($contact['created_at']);
                                                            echo date('d M Y', $dt);
                                                            ?>
                                                            <br>
                                                            <small><?= date('g:i A', $dt); ?></small>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
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

</body>

</html>