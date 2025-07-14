<?php 
// Fetch form data
$heading = $_POST['heading'];
$healthcategory = $_POST['healthcategory'];
$blogername = $_POST['blogername'];
$para1 = $_POST['paragraph1'];
$para2 = $_POST['paragraph2'];
$tags = $_POST['tags'];

// Handle image upload
$imageName = $_FILES['image']['name'];
$imageTmp = $_FILES['image']['tmp_name'];
$imagePath = "../uploads/" . basename($imageName);

// Check if upload directory exists, if not, create it
if (!file_exists('../uploads')) {
    mkdir('../uploads', 0777, true);
}

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
        header("Location: ../blog-list.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
} else {
    echo "<p style='color:red;'>Failed to upload image.</p>";
}
?>
