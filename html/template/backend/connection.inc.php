<?php
// Database connection settings
// Update these values with your database credentials
$DBHost = "localhost"; // Database host
$DBUsername = "root"; // Database username
$DBPassword = ""; // Database password
$DBName = "u208454902_Lupicad"; // Database name

// Database connection file
$connection = mysqli_connect($DBHost, $DBUsername, $DBPassword);
if (!$connection) {
    $errorMessage = "Connection failed: " . mysqli_connect_error();
    // echo "<script>console.error(" . json_encode($errorMessage) . ");</script>";
    exit;
}
// create database if it doesn't exist
$sql = "CREATE DATABASE IF NOT EXISTS $DBName";
if (mysqli_query($connection, $sql)) {
    // echo "<script>console.log('Database created successfully');</script>";
} else {
    $errorMessage = "Error creating database: " . mysqli_error($connection);
    // echo "<script>console.error(" . json_encode($errorMessage) . ");</script>";
}
// select the database
if (!mysqli_select_db($connection, $DBName)) {
    $errorMessage = "Database selection failed: " . mysqli_error($connection);
    // echo "<script>console.error(" . json_encode($errorMessage) . ");</script>";
    exit;
}

// // -------------------------------------------------------------------------------//

// // Create table if not exists with extended fields
// $table_check_sql = "CREATE TABLE IF NOT EXISTS Admins (
//     id INT AUTO_INCREMENT PRIMARY KEY,
//     name VARCHAR(100) NOT NULL,
//     email VARCHAR(255) NOT NULL ,
//     password VARCHAR(255) NOT NULL,
//     address TEXT,
//     city VARCHAR(100),
//     state VARCHAR(100),
//     zip VARCHAR(10),
//     country VARCHAR(100),
//     mobile VARCHAR(20),
//     bio TEXT,
//     dob DATE,
//     profile_image VARCHAR(255),
//     profile_completed TINYINT(1) DEFAULT 0
// );";

// // Execute the table creation query
// if (!mysqli_query($connection, $table_check_sql)) {
//     echo "<script>console.error('Error creating table: " . mysqli_error($connection) . "');</script>";
// }

// // -------------------------------------------------------------------------------//

// // Handle table creation (check if the table exists)
// $table_check_sql = "CREATE TABLE IF NOT EXISTS User (
//     id INT AUTO_INCREMENT PRIMARY KEY,
//     name VARCHAR(100) NOT NULL,
//     phone VARCHAR(15) NOT NULL,
//     email VARCHAR(255) NOT NULL UNIQUE,
//     password VARCHAR(255) NOT NULL,
//     address TEXT,
//     city VARCHAR(100),
//     state VARCHAR(100),
//     zip VARCHAR(10),
//     country VARCHAR(100),
//     mobile VARCHAR(20),
//     bio TEXT,
//     dob DATE,
//     profile_image VARCHAR(255),
// 	wishList TEXT DEFAULT '',
// 	created_at DATETIME DEFAULT CURRENT_TIMESTAMP
// )";

// // Execute the table creation query
// if (!mysqli_query($connection, $table_check_sql)) {
//     echo "<script>console.error('Error creating table: " . mysqli_error($connection) . "');</script>";
// }

// // -------------------------------------------------------------------------------//

// // Create table if not exists
// $createTableSQL = "CREATE TABLE IF NOT EXISTS blogs (
//     id INT AUTO_INCREMENT PRIMARY KEY,
//     heading VARCHAR(255) NOT NULL,
//     healthcategory VARCHAR(255) NOT NULL,
//     image VARCHAR(255) NOT NULL, 
//     blogername VARCHAR(255) NOT NULL,
//     publish_date DATE NOT NULL,
//     paragraph1 TEXT NOT NULL,
//     paragraph2 TEXT NOT NULL,
//     tags VARCHAR(255) NOT NULL,
//     created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
// )";
// if (!mysqli_query($connection, $createTableSQL)) {
//     echo "<script>console.error('Error creating table: " . mysqli_error($connection) . "');</script>";
// }
// // -------------------------------------------------------------------------------//
// $createTableSQL ="CREATE TABLE IF NOT EXISTS Orders (
//     id VARCHAR(20) PRIMARY KEY,
//     user_id INT NOT NULL,
//     first_name VARCHAR(100) NOT NULL,
//     last_name VARCHAR(100) NOT NULL,
//     email VARCHAR(255) NOT NULL,
//     phone VARCHAR(15) NOT NULL,
//     shipping_address TEXT NOT NULL,
//     delivery_message TEXT,
//     payment_method VARCHAR(50) NOT NULL,
//     total_amount DECIMAL(10, 2) NOT NULL,
//     subtotal DECIMAL(10, 2) NOT NULL,
//     tax DECIMAL(10, 2) NOT NULL,
//     order_date DATETIME DEFAULT CURRENT_TIMESTAMP, 
//     status VARCHAR(50) DEFAULT 'Pending',
//     paymentId VARCHAR(30) NOT NULL,
//     FOREIGN KEY (user_id) REFERENCES User(id) ON DELETE CASCADE
// );";
// if (!mysqli_query($connection, $createTableSQL)) {
//     echo "<script>console.error('Error creating table: " . mysqli_error($connection) . "');</script>";
// }

// // -------------------------------------------------------------------------------//
// try {
// 		$ProductTable= mysqli_query($connection, "create table if not exists ProductTable(
// 			ProductID int auto_increment primary key,
// 			ProductName varchar(100) not null,
// 			ProductShortDescription varchar(500) not null,
// 			ProductCategories varchar(50) not null,
// 			ProductAvailability boolean default true,
// 			ProductRating float not null,
// 			ProductPrice float not null,
// 			ProductImage TEXT not null
// 		)"); 
// 		echo "<script>console.log('ProductTable created successfully');</script>";
// 	} catch (Exception $e) {
// 		echo "<script>console.log(" . json_encode($e->getMessage()) . ");</script>";
// 		exit;
// 	} 

// 	mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

// //---------------------------------------------------------------------------//

//     try {
// 		$ProductDetailsTable = mysqli_query($connection, "CREATE TABLE IF NOT EXISTS ProductDetailsTable (
// 		        ProductID INT PRIMARY KEY,
// 		        SubTitle VARCHAR(255),
// 		        ProductDescription TEXT NOT NULL,
// 		        Quantity INT,
// 		        SKU VARCHAR(50),
// 		        PackSize VARCHAR(50),
// 		        UnitCount VARCHAR(50),
// 		        Country VARCHAR(50) DEFAULT 'India',
// 		        Discount int DEFAULT 0,
// 		        Directions TEXT,
// 		        Storage TEXT,
// 		        Administration TEXT,
// 		        Warning TEXT,
// 		        Precaution TEXT,
// 		        FOREIGN KEY (ProductID) REFERENCES ProductTable(ProductID) ON DELETE CASCADE
// 		    )
// 		");

// 		echo "<script>console.log('ProductDetailsTable created successfully');</script>";
// 	} catch (Exception $e) {
// 		echo "<script>console.log(" . json_encode($e->getMessage()) . ");</script>";
// 		exit;
// 	}

// // -------------------------------------------------------------------------------//
//     $sql = "CREATE TABLE IF NOT EXISTS CartProducts (
// 	id INT(11) AUTO_INCREMENT PRIMARY KEY,
// 	user_id INT(11) NOT NULL,
// 	product_id INT(11) NOT NULL,
// 	quantity INT(11) NOT NULL
// )";
// if ($connection->query($sql) === TRUE) {
// 	echo "<script>console.log('Table CartProducts created successfully');</script>";
// } else {
// 	echo "<script>console.log('Error creating table: " . $connection->error . "');</script>";
// }

// // -------------------------------------------------------------------------------//

// $createTableSQL = "CREATE TABLE IF NOT EXISTS OrderItems (
//     id INT AUTO_INCREMENT PRIMARY KEY,
//     order_id VARCHAR(20) NOT NULL,
//     product_id INT NOT NULL,
//     quantity INT NOT NULL,
//     FOREIGN KEY (order_id) REFERENCES Orders(id) ON DELETE CASCADE,
//     FOREIGN KEY (product_id) REFERENCES ProductTable(ProductID) ON DELETE CASCADE
// );";
// // Execute the table creation query
// if (!mysqli_query($connection, $createTableSQL)) {
//     echo "<script>console.error('Error creating table: " . mysqli_error($connection) . "');</script>";
// }
// // -------------------------------------------------------------------------------//

// try {
// 	$stmt = $connection->prepare("CREATE TABLE IF NOT EXISTS ProductReviews (
// 		ReviewID INT AUTO_INCREMENT PRIMARY KEY,
// 		UserID INT NOT NULL,
// 		UserName VARCHAR(255) NOT NULL,
// 		ProductID INT NOT NULL,
// 		StarRating INT NOT NULL,
// 		Title VARCHAR(255) NOT NULL,
// 		created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
// 		ReviewText TEXT NOT NULL,
// 		FOREIGN KEY (ProductID) REFERENCES ProductTable(ProductID) ON DELETE CASCADE,
// 		FOREIGN KEY (UserID) REFERENCES User(id) ON DELETE CASCADE
// 	)");
// 	$stmt->execute();
// 	$stmt->close();
// 	// echo "<script>console.log('ProductReviewsTable created successfully');</script>";
// } catch (Exception $e) {
// 	// echo "<script>console.error('Error creating table: " . json_encode($e->getMessage()) . "');</script>";
// }

// // -------------------------------------------------------------------------------//
// // Create table if it doesn't exist
// $table_contactus_sql = "CREATE TABLE IF NOT EXISTS ContactUsForm (
//     id INT AUTO_INCREMENT PRIMARY KEY,
//     name VARCHAR(100) NOT NULL,
//     phone VARCHAR(15) NOT NULL,
//     email VARCHAR(255) NOT NULL ,
//     services VARCHAR(255) NOT NULL,
//     message TEXT NOT NULL
// )";

// if (!mysqli_query($connection, $table_contactus_sql)) {
//     echo "<script>console.error('Error creating table: " . mysqli_error($connection) . "');</script>";
// }