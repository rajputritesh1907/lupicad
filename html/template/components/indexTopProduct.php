<?php
function getTopSmallProductLink($category)
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

function lightenColor($hexColor, $percent) {
    // Remove # if present
    $hexColor = ltrim($hexColor, '#');
    
    // Convert hex to RGB
    $r = hexdec(substr($hexColor, 0, 2));
    $g = hexdec(substr($hexColor, 2, 2));
    $b = hexdec(substr($hexColor, 4, 2));
    
    // Lighten by moving towards white (255)
    $r = $r + ($percent / 100) * (255 - $r);
    $g = $g + ($percent / 100) * (255 - $g);
    $b = $b + ($percent / 100) * (255 - $b);
    
    // Ensure values don't exceed 255
    $r = min(255, round($r));
    $g = min(255, round($g));
    $b = min(255, round($b));
    
    // Convert back to hex
    return sprintf("#%02x%02x%02x", $r, $g, $b);
}

$SmallProducts = [
    [
        "img1" => "./assets/lupicad/GeneralProducts/4.png",
        "category" => "General Product",
        "name" => "Flaxeseed Gokshura ",
        "link" => getTopSmallProductLink("General Product"),
        "bg_color" => "#194519"
    ],
    [
        "img1" => "./assets/lupicad/GeneralProducts/1.png",
        "category" => "General Product",
        "name" => "Ashwagandha",
        "link" => getTopSmallProductLink("General Product"),
        "bg_color" => "#477c66"
    ],
    [
        "img1" => "./assets/lupicad/GeneralProducts/2.png",
        "category" => "General Product",
        "name" => "Guduchi",
        "link" => getTopSmallProductLink("General Product"),
        "bg_color" => "#559b23"
    ],
    [
        "img1" => "./assets/lupicad/GeneralProducts/3.png",
        "category" => "General Product",
        "name" => "Olive Oil Softgel",
        "link" => getTopSmallProductLink("General Product"),
        "bg_color" => "#c08d2a"
    ],
    [
        "img1" => "./assets/lupicad/GeneralProducts/10.png",
        "category" => "General Product",
        "name" => "Moringa",
        "link" => getTopSmallProductLink("General Product"),
        "bg_color" => "#14b23a"
    ],
    [
        "img1" => "./assets/lupicad/GeneralProducts/6.png",
        "category" => "General Product",
        "name" => "Breathe Free",
        "link" => getTopSmallProductLink("General Product"),
        "bg_color" => "#ff595d"
    ],
    [
        "img1" => "./assets/lupicad/GeneralProducts/7.png",
        "category" => "General Product",
        "name" => "Fengureek",
        "link" => getTopSmallProductLink("General Product"),
        "bg_color" => "#104c27"
    ],
    [
        "img1" => "./assets/lupicad/GeneralProducts/8.png",
        "category" => "General Product",
        "name" => "Cold & Cough Syrup",
        "link" => getTopSmallProductLink("General Product"),
        "bg_color" => "#d3a02e"
    ],
    [
        "img1" => "./assets/lupicad/GeneralProducts/9.png",
        "category" => "General Product",
        "name" => "Diabo Lac",
        "link" => getTopSmallProductLink("General Product"),
        "bg_color" => "#3a8a54"
    ],
    // Fertility Supports (Male/Female)
    [
        "img1" => "./assets/lupicad/FemaleProducts/1.png",
        "category" => "Female Product",
        "name" => "B-Cute",
        "link" => getTopSmallProductLink("Female Product"),
        "bg_color" => "#ff595d"
    ],
    [
        "img1" => "./assets/lupicad/MaleProducts/1.2.png",
        "category" => "Male Product",
        "name" => "Sperm Ultra",
        "link" => getTopSmallProductLink("Male Product"),
        "bg_color" => "#2c4119"
    ],
    [
        "img1" => "./assets/lupicad/MaleProducts/3.2.png",
        "category" => "Male Product",
        "name" => "Peni King",
        "link" => getTopSmallProductLink("Male Product"),
        "bg_color" => "#3a3a38"
    ],
    [
        "img1" => "./assets/lupicad/FemaleProducts/2.png",
        "category" => "Female Product",
        "name" => "Gyano Medic",
        "link" => getTopSmallProductLink("Female Product"),
        "bg_color" => "#e42896"
    ],
    [
        "img1" => "./assets/lupicad/FemaleProducts/3.png",
        "category" => "Female Product",
        "name" => "Pcos Care",
        "link" => getTopSmallProductLink("Female Product"),
        "bg_color" => "#ca437d"
    ],
    [
        "img1" => "./assets/lupicad/FemaleProducts/5.2.png",
        "category" => "Female Product",
        "name" => "Big-B-Plus",
        "link" => getTopSmallProductLink("Female Product"),
        "bg_color" => "#f8ba12"
    ],
    [
        "img1" => "./assets/lupicad/FemaleProducts/4.png",
        "category" => "Female Product",
        "name" => "She Pure",
        "link" => getTopSmallProductLink("Female Product"),
        "bg_color" => "#a365b4"
    ],
    [
        "img1" => "./assets/lupicad/MaleProducts/2.2.png",
        "category" => "Male Product",
        "name" => "Man Fuel",
        "link" => getTopSmallProductLink("Male Product"),
        "bg_color" => "#0f0f11"
    ],
    [
        "img1" => "./assets/lupicad/FemaleProducts/6.png",
        "category" => "Female Product",
        "name" => "Miss VV Cream Ayurvedic",
        "link" => getTopSmallProductLink("Female Product"),
        "bg_color" => "#d2003e"
    ],
];
?>


<section style="width:100%; padding: 20px 0; margin: 0; background: transparent; position: relative;">
    <div class="container" style="position:absolute;top: 40px; left: 0; width: 100%; padding: 20px 0;z-index: 5;">
        <div class="product-carousel-wrapper" style="position: relative; overflow: hidden; margin: 15px 0;">
            <div class="product-carousel" style="display: flex; gap: 15px; overflow-x: auto; scroll-behavior: smooth; padding: 10px 0; scrollbar-width: none; -ms-overflow-style: none;">
                <?php foreach ($SmallProducts as $product): ?>
                <div class="product-item" style="flex: 0 0 auto; min-width: 150px;">
                    <div class="product-card" style="background: <?php echo lightenColor($product['bg_color'], 70); ?>; border-radius: 8px; padding: 15px; text-align: center; cursor: pointer; transition: transform 0.3s ease, box-shadow 0.3s ease; height: 180px; display: flex; flex-direction: column; justify-content: space-between;" onclick="location.href='<?php echo $product['link']; ?>'" onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 8px 20px rgba(0,0,0,0.15)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none';">
                        <div class="product-image" style="flex: 1; display: flex; align-items: center; justify-content: center;">
                            <img src="<?php echo $product['img1']; ?>" alt="<?php echo $product['name']; ?>" style="width: 110px; height: 110px; object-fit: contain; border-radius: 50%;">
                        </div>
                        <div class="product-info" style="margin-top: 10px;">
                            <h5 style="margin: 0; font-size: 12px; line-height:1.4;"><a href="<?php echo $product['link']; ?>" style="color: #333; text-decoration: none; font-weight: 500;" onmouseover="this.style.color='#007bff';" onmouseout="this.style.color='#333';"><?php echo $product['name']; ?></a></h5>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <div class="carousel-nav" style="position: absolute; top: 50%; transform: translateY(-50%); width: 100%; display: flex; justify-content: space-between; pointer-events: none;">
                <button class="nav-btn prev-btn" onclick="scrollCarousel(-1)" style="background: rgba(0,0,0,0.5); color: white; border: none; width: 40px; height: 40px; border-radius: 50%; cursor: pointer; font-size: 18px; pointer-events: auto; transition: background 0.3s ease;" onmouseover="this.style.background='rgba(0,0,0,0.8)';" onmouseout="this.style.background='rgba(0,0,0,0.5)';">&#8249;</button>
                <button class="nav-btn next-btn" onclick="scrollCarousel(1)" style="background: rgba(0,0,0,0.5); color: white; border: none; width: 40px; height: 40px; border-radius: 50%; cursor: pointer; font-size: 18px; pointer-events: auto; transition: background 0.3s ease;" onmouseover="this.style.background='rgba(0,0,0,0.8)';" onmouseout="this.style.background='rgba(0,0,0,0.5)';">&#8250;</button>
            </div>
        </div>
    </div>
</section>

<script>
function scrollCarousel(direction) {
    const carousel = document.querySelector('.product-carousel');
    const scrollAmount = 200;
    
    if (direction === 1) {
        carousel.scrollLeft += scrollAmount;
    } else {
        carousel.scrollLeft -= scrollAmount;
    }
}

// Auto-scroll functionality (optional)
let autoScrollInterval;

function startAutoScroll() {
    autoScrollInterval = setInterval(() => {
        const carousel = document.querySelector('.product-carousel');
        if (carousel.scrollLeft >= carousel.scrollWidth - carousel.clientWidth) {
            carousel.scrollLeft = 0;
        } else {
            carousel.scrollLeft += 200;
        }
    }, 3000);
}

function stopAutoScroll() {
    clearInterval(autoScrollInterval);
}

// Initialize carousel
document.addEventListener('DOMContentLoaded', function() {
    const carousel = document.querySelector('.product-carousel');
    
    // Start auto-scroll
    startAutoScroll();
    
    // Pause auto-scroll on hover
    carousel.addEventListener('mouseenter', stopAutoScroll);
    carousel.addEventListener('mouseleave', startAutoScroll);
});
</script>