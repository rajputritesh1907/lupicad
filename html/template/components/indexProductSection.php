<?php
function getProductLink($category)
{
    $category = strtolower($category ?? '');
    if (strpos($category, 'male') !== false) {
        return 'product-all.php?filter=male';
    } elseif (strpos($category, 'female') !== false) {
        return 'product-all.php?filter=female';
    } else {
        return 'product-all.php';
    }
}

$products = [
    [
        "img1" => "./assets/lupicad/GeneralProducts/4.png",
        "img2" => "./assets/lupicad/GeneralProducts/4.1.png",
        "category" => "General Product",
        "name" => "Flaxeseed Gokshura Capsule for General Health – (60 Caps)",
        "price" => "899",
        "old_price" => "1099",
        "weight" => "60 Caps",
        "discount" => "18", // percent
        "link" => getProductLink("General Product"),
        "btn_color" => "#194519"
    ],
    [
        "img1" => "./assets/lupicad/GeneralProducts/1.png",
        "img2" => "./assets/lupicad/GeneralProducts/1.1.png",
        "category" => "General Product",
        "name" => "Lupicad Ashwagandha for General Health – (60 Caps)",
        "price" => "1,499",
        "old_price" => "1,699",
        "weight" => "60 Caps",
        "discount" => "12",
        "link" => getProductLink("General Product"),
        "btn_color" => "#477c66"
    ],
    [
        "img1" => "./assets/lupicad/GeneralProducts/2.png",
        "img2" => "./assets/lupicad/GeneralProducts/2.1.png",
        "category" => "General Product",
        "name" => "Lupicad Guduchi Capsule For General Health – (60 Caps)",
        "price" => "650",
        "old_price" => "799",
        "weight" => "60 Caps",
        "discount" => "10",
        "link" => getProductLink("General Product"),
        "btn_color" => "#559b23"
    ],
    [
        "img1" => "./assets/lupicad/GeneralProducts/3.png",
        "img2" => "./assets/lupicad/GeneralProducts/3.1.png",
        "category" => "General Product",
        "name" => "Lupicad Olive Oil Softgel Capsule For General Health- (60 Caps)",
        "price" => "1,299",
        "old_price" => "1,499",
        "weight" => "60 Caps",
        "discount" => "13",
        "link" => getProductLink("General Product"),
        "btn_color" => "#c08d2a"
    ],
    [
        "img1" => "./assets/lupicad/GeneralProducts/10.png",
        "img2" => "./assets/lupicad/GeneralProducts/10.1.png",
        "category" => "General Product",
        "name" => "Lupicad Moringa Capsule for General Health – (60 Caps)",
        "price" => "999",
        "old_price" => "1,199",
        "weight" => "60 Caps",
        "discount" => "17",
        "link" => getProductLink("General Product"),
        "btn_color" => "#14b23a"
    ],
    [
        "img1" => "./assets/lupicad/GeneralProducts/6.png",
        "img2" => "./assets/lupicad/GeneralProducts/6.1.png",
        "category" => "General Product",
        "name" => "Breathe Free For General Health – (60 Caps)",
        "price" => "1,299",
        "old_price" => "1,499",
        "weight" => "60 Caps",
        "discount" => "13",
        "link" => getProductLink("General Product"),
        "btn_color" => "#ff595d"
    ],
    [
        "img1" => "./assets/lupicad/GeneralProducts/7.png",
        "img2" => "./assets/lupicad/GeneralProducts/7.1.png",
        "category" => "General Product",
        "name" => "Fengureek Capsule for Ganeral Health – (60 Caps)",
        "price" => "799",
        "old_price" => "899",
        "weight" => "60 Caps",
        "discount" => "11",
        "link" => getProductLink("General Product"),
        "btn_color" => "#104c27"
    ],
    [
        "img1" => "./assets/lupicad/GeneralProducts/8.png",
        "img2" => "./assets/lupicad/GeneralProducts/8.1.png",
        "category" => "General Product",
        "name" => "Cold & Cough Syrup General Health – (180ml)",
        "price" => "185",
        "old_price" => "210",
        "weight" => "180ml",
        "discount" => "12",
        "link" => getProductLink("General Product"),
        "btn_color" => "#d3a02e"
    ],
    [
        "img1" => "./assets/lupicad/GeneralProducts/9.png",
        "img2" => "./assets/lupicad/GeneralProducts/9.1.png",
        "category" => "General Product",
        "name" => "Lupicad Diabo Lac Capsule General Health – (60 Caps)",
        "price" => "899",
        "old_price" => "1,099",
        "weight" => "60 Caps",
        "discount" => "18",
        "link" => getProductLink("General Product"),
        "btn_color" => "#3a8a54"
    ],
    // Fertility Supports (Male/Female)
    [
        "img1" => "./assets/lupicad/FemaleProducts/1.png",
        "img2" => "./assets/lupicad/FemaleProducts/1.1.png",
        "category" => "Female Product",
        "name" => "Lupicad B-Cute Capsule For Female Health - (30 Caps)",
        "price" => "1,299",
        "old_price" => "1,499",
        "weight" => "30 Caps",
        "discount" => "13",
        "link" => getProductLink("Female Product"),
        "btn_color" => "#ff595d"
    ],
    [
        "img1" => "./assets/lupicad/MaleProducts/1.2.png",
        "img2" => "./assets/lupicad/MaleProducts/1.png",
        "category" => "Male Product",
        "name" => "Lupicad Sperm Ultra Capsule For Male Health – (60 Caps)",
        "price" => "4,999",
        "old_price" => "5,499",
        "weight" => "60 Caps",
        "discount" => "9",
        "link" => getProductLink("Male Product"),
        "btn_color" => "#2c4119"
    ],
    [
        "img1" => "./assets/lupicad/MaleProducts/3.2.png",
        "img2" => "./assets/lupicad/MaleProducts/3.png",
        "category" => "Male Product",
        "name" => "Lupicad Peni King Capsule For Male Health – (60 Caps)",
        "price" => "1,350",
        "old_price" => "1,499",
        "weight" => "60 Caps",
        "discount" => "10",
        "link" => getProductLink("Male Product"),
        "btn_color" => "#3a3a38"
    ],
    [
        "img1" => "./assets/lupicad/FemaleProducts/2.png",
        "img2" => "./assets/lupicad/FemaleProducts/2.1.png",
        "category" => "Female Product",
        "name" => "Lupicad Gyano Medic Capsule for Female Health – (60 Caps)",
        "price" => "1,499",
        "old_price" => "1,699",
        "weight" => "60 Caps",
        "discount" => "12",
        "link" => getProductLink("Female Product"),
        "btn_color" => "#e42896"
    ],
    [
        "img1" => "./assets/lupicad/FemaleProducts/3.png",
        "img2" => "./assets/lupicad/FemaleProducts/3.1.png",
        "category" => "Female Product",
        "name" => "Lupicad Pcos Care Capsule Female Health – (60 Caps)",
        "price" => "1,399",
        "old_price" => "1,599",
        "weight" => "60 Caps",
        "discount" => "13",
        "link" => getProductLink("Female Product"),
        "btn_color" => "#ca437d"
    ],
    [
        "img1" => "./assets/lupicad/FemaleProducts/5.2.png",
        "img2" => "./assets/lupicad/FemaleProducts/5.3.png",
        "category" => "Female Product",
        "name" => "Lupicad Big-B-Plus Capsule for Female Health – (30 Caps)",
        "price" => "1,199",
        "old_price" => "1,399",
        "weight" => "30 Caps",
        "discount" => "14",
        "link" => getProductLink("Female Product"),
        "btn_color" => "#f8ba12"
    ],
    [
        "img1" => "./assets/lupicad/FemaleProducts/4.png",
        "img2" => "./assets/lupicad/FemaleProducts/4.1.png",
        "category" => "Female Product",
        "name" => "Lupicad She Pure Capsule For Female Health – (60 Caps)",
        "price" => "1,499",
        "old_price" => "1,699",
        "weight" => "60 Caps",
        "discount" => "12",
        "link" => getProductLink("Female Product"),
        "btn_color" => "#a365b4"
    ],
    [
        "img1" => "./assets/lupicad/MaleProducts/2.2.png",
        "img2" => "./assets/lupicad/MaleProducts/2.png",
        "category" => "Male Product",
        "name" => "Man Fuel Capsule (10 Caps)",
        "price" => "1,499",
        "old_price" => "1,699",
        "weight" => "10 Caps",
        "discount" => "12",
        "link" => getProductLink("Male Product"),
        "btn_color" => "#0f0f11"
    ],
    [
        "img1" => "./assets/lupicad/FemaleProducts/6.png",
        "img2" => "./assets/lupicad/FemaleProducts/6.1.png",
        "category" => "Female Product",
        "name" => "Lupicad Miss VV Cream Ayurvedic Beneficial In Female Health – (20gm)",
        "price" => "1,699",
        "old_price" => "1,899",
        "weight" => "20gm",
        "discount" => "11",
        "link" => getProductLink("Female Product"),
        "btn_color" => "#d2003e"
    ],
];
?>
<style>
    .carousel {
  display: flex;
  overflow-x: auto;
  gap: 16px;
  padding-bottom: 12px;
  scrollbar-width: none; /* Firefox */
  -ms-overflow-style: none; /* IE and Edge */
}
.carousel::-webkit-scrollbar {
  display: none; /* Chrome, Safari, Opera */
}
.supplement-card {
  width: 220px;
  background: #fff;
  border-radius: 8px;
  box-shadow: 0 1px 8px #0001;
  padding: 16px;
  position: relative;
  flex: 0 0 auto;
  display: flex;
  flex-direction: column;
  align-items: flex-start;
}
.discount-badge {
  position: absolute;
  top: 10px; left: 10px;
  background: orange; color: #fff;
  padding: 4px 12px;
  font-size: 16px; font-weight: 700;
  border-radius: 4px;
}
.product-image {
  width: 100%;
  height: 130px;
  display: flex;
  align-items: center;
  justify-content: center;
  margin-bottom: 10px;
}
.product-image img {
  max-width: 100%;
  max-height: 130px;
  object-fit: contain;
}
.product-title {
  font-size: 18px;
  font-weight: 700;
  margin-bottom: 6px;
  max-height: 48px;
  overflow: hidden;
}
.product-weight {
  font-size: 15px;
  color: #888; margin-bottom: 5px;
}
.price-row {
  display: flex; gap: 10px;
  font-size: 20px;
  margin-bottom: 8px;
}
.price-new {
  font-weight: 700; color: #252525;
}
.price-old {
  text-decoration: line-through; color: #c1c1c1;
  font-size: 16px;
}
.add-btn {
  position: absolute; right: 16px; bottom: 16px;
  border: none; background: #fff; box-shadow: 0 0 2px #999;
  border-radius: 50%; width: 38px; height: 38px;
  font-weight: 700; font-size: 24px;
  cursor: pointer;
}
</style>
<?php


// Split products into two arrays: General Products and Others
$general_products = [];
$other_products = [];
foreach ($products as $product) {
    if (isset($product['category']) && strtolower($product['category']) === 'general product') {
        $general_products[] = $product;
    } else {
        $other_products[] = $product;
    }
}
?>


 
<section style=" ">
    <!-- General Products Section -->
    <section>
        <div class="container">
            <div class="section-header sec-header-one text-center aos" data-aos="fade-up">
                <span class="badge badge-primary">Categories</span>
                <h2>General Health</h2>
            </div>
            <div class="carousel">
<?php foreach ($general_products as $product): ?>
  <div class="supplement-card">
    <?php if (!empty($product['discount'])): ?>
      <div class="discount-badge"><?= htmlspecialchars($product['discount']) ?>% OFF</div>
    <?php endif; ?>
    <div class="product-image">
      <img src="<?= htmlspecialchars($product['img1']) ?>" alt="<?= htmlspecialchars($product['name']) ?>">
    </div>
    <div class="product-title"><?= htmlspecialchars($product['name']) ?></div>
    <?php if (!empty($product['weight'])): ?>
      <div class="product-weight"><?= htmlspecialchars($product['weight']) ?></div>
    <?php endif; ?>
    <div class="price-row">
      <span class="price-new">₹<?= htmlspecialchars($product['price']) ?></span>
      <?php if (!empty($product['old_price'])): ?>
        <span class="price-old">₹<?= htmlspecialchars($product['old_price']) ?></span>
      <?php endif; ?>
    </div>
    <button class="add-btn">+</button>
  </div>
<?php endforeach; ?>
</div>
        </div>
    </section>

    <!-- Other Products Section -->
    <section style="margin-top:clamp(20px,5vw,40px);">
        <div class="container">
            <div class="section-header sec-header-one text-center aos" data-aos="fade-up"> 
            </div>
            <div class="doctors-slider owl-carousel aos" data-aos="fade-up" style="min-height: 350px;height: 65%; max-height: 420px;">
                <?php foreach ($other_products as $product): ?>
                    <div class="mb-4" style="width: 100%;">
                        <div class="product-custom d-flex" style="height:100% !important;">
                            <div class="card">
                                <div class="card-img card-img-hover">
                                    <div class="image-container">
                                        <a href="<?= $product['link'] ?>">
                                            <center><img src="<?= $product['img1'] ?>" id="img-1" alt="product image" style="width:auto;height:100%"></center>
                                        </a>
                                        <a href="<?= $product['link'] ?>"><img src="<?= $product['img2'] ?>" id="img-2" alt="product image"></a>
                                    </div>
                                </div>
                                <div class="card-body p-0">
                                    <div class="d-flex active-bar align-items-center justify-content-between p-3">
                                        <a href="javascript:void(0)" class="text-indigo fw-medium fs-14"><?= htmlspecialchars($product['category']) ?></a>
                                    </div>
                                    <div class="p-3 pt-0">
                                        <div class="pb-1">
                                            <p class="mb-1 product-titl"><b><a href="product-all.php"><?= htmlspecialchars($product['name']) ?></a></b></p>
                                        </div>
                                        <div class="d-flex align-items-center justify-content-between">
                                            <div>
                                                <h3 class="text-orange"><span class="woocommerce-Price-currencySymbol">₹</span><?= htmlspecialchars($product['price']) ?></h3>
                                            </div>
                                            <a href="<?= $product['link'] ?>" class="BuyNowBtn d-inline-flex align-items-center rounded-pill"
                                                style="background-color: <?= $product['btn_color'] ?> !important;margin-top: 10px; font-size: 10px;">
                                                Buy Now
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
</section>