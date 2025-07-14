<?php
	// Including the database connection file
	require(__DIR__ ."/./connection.inc.php");

	//ProductTable creation
// 	try {
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

	// try {
	//     $stmt = $connection->prepare("INSERT INTO ProductTable 
	//     (ProductName, ProductShortDescription, ProductCategories, ProductAvailability, ProductRating, ProductPrice, ProductImage)
	//     VALUES (?, ?, ?, ?, ?, ?, ?)");

	//     $name = 'Product 4';
	//     $desc = 'Short description of Product 4';
	//     $category = 'Category 1';
	//     $available = true;
	//     $rating = 4.9;
	//     $price = 49.99;
	//     $imagesJson = json_encode([
	//         './assets/lupicad/FemaleProducts/1.png',
	//         './assets/lupicad/FemaleProducts/1.1.png'
	//     ]);

	//     $stmt->bind_param("sssidds", $name, $desc, $category, $available, $rating, $price, $imagesJson);
	//     $stmt->execute();

	//     echo "<script>console.log('✅ Product inserted successfully');</script>";
	//     $stmt->close();

	// } catch (mysqli_sql_exception $e) {
	//     $msg = addslashes($e->getMessage());
	//     echo "<script>console.log('❌ MySQL Error: $msg');</script>";
	// }


	//ProductDetailsTable creation
// 	try {
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


	// inserting data into ProductDetailsTable


	// try {
	// 	$stmt = $connection->prepare("INSERT INTO ProductDetailsTable 
	// 	(ProductID, SubTitle, ProductDescription, Quantity, SKU, PackSize, UnitCount, Country, Discount, Directions, Storage, Administration, Warning, Precaution)
	// 	VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
	
	// 	// Sample data for insertion
	// 	$productID = 2; // Make sure this matches an existing ProductID in ProductTable
	// 	$subtitle = 'hulk (10 Caps)';
	// 	$description = 'Sperm Ultra Iron Man Capsule is a powerful supplement designed to enhance stamina, vitality, and overall well-being...';
	// 	$quantity = 100;
	// 	$sku = 'SKU2023-02-0057';
	// 	$packSize = '300g';
	// 	$unitCount = '300ml';
	// 	$country = 'Indian';
	// 	$discount = 20;
	// 	$directions = 'Take one capsule daily with warm milk or water after a meal.';
	// 	$storage = 'Store in a cool, dry place away from sunlight.';
	// 	$administration = 'Swallow the capsule whole. Do not crush or chew.';
	// 	$warning = 'Not for use by individuals under 18 years of age.';
	// 	$precaution = 'Consult a doctor if you have any pre-existing medical conditions.';
	

	// 	// Use correct types: i = int, s = string, d = double
	// 	$stmt->bind_param("ississssisssss", 
	// 		$productID, $subtitle, $description, $quantity, $sku,
	// 		$packSize, $unitCount, $country, $discount, $directions,
	// 		$storage, $administration, $warning, $precaution
	// 	);
	
	// 	$stmt->execute();
	
	// 	echo "<script>console.log('✅ Product Details inserted successfully');</script>";
	// 	$stmt->close();
	
	// } catch (mysqli_sql_exception $e) {
	// 	$msg = addslashes($e->getMessage());
	// 	echo "<script>console.log('❌ MySQL Error: $msg');</script>";
	// }
	
?>