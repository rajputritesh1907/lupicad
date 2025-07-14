<?php
$heading = $_POST['heading'] ?? '';
$healthcategory = $_POST['healthcategory'] ?? '';
$blogername = $_POST['blogername'] ?? '';
$para1 = $_POST['paragraph1'] ?? '';
$para2 = $_POST['paragraph2'] ?? '';
$tags = $_POST['tags'] ?? '';

// Image upload
$imageName = $_FILES['image']['name'] ?? '';
$imageTmp = $_FILES['image']['tmp_name'] ?? '';
$imagePath = "../uploads/" . basename($imageName);

if ($imageTmp != '') {
    move_uploaded_file($imageTmp, $imagePath);
}


// DB connection
require_once(__DIR__ . "../backend/connection.inc.php");
require_once(__DIR__ . "../backend/function.inc.php");

// Error check for DB connection
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

// Prepared statement for safe insert
$stmt = $connection->prepare("INSERT INTO blogs (heading, healthcategory, image, blogername, paragraph1, paragraph2, tags) 
                        VALUES (?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("sssssss", $heading, $healthcategory, $imagePath, $blogername, $para1, $para2, $tags);
$stmt->execute();

// Redirect to blog detail page
header("Location: blog-details.php?id=" . $connection->insert_id);
exit;
?>
