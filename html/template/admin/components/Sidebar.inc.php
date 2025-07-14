
<!-- Sidebar -->
<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">
            <ul id="sidebar-nav">
                <li class="menu-title">
                    <span>Main</span>
                </li>
                <li>
                    <a href="profile.php"><i class="fe fe-user-plus"></i> <span>Profile</span></a>
                </li>
                <li>
                    <a href="Dashboard.php"><i class="fe fe-home"></i> <span>Dashboard</span></a>
                </li>
                <li>
                    <a href="Order-list.php"><i class="fas fa-shopping-cart" style="scale: 0.78; transform:translateX(-5px)"></i> <span>Orders</span></a>
                </li>
                <li>
                    <a href="Product-list.php"><i class="fe fe-user-plus"></i> <span>Products</span></a>
                </li>
                <li>
                    <a href="reviews.php"><i class="fe fe-star-o"></i> <span>Reviews</span></a>
                </li>
                <li>
                    <a href="blog-edit.php"><i class="fe fe-document"></i><span>Blogs</span></a>
                </li>
                <li>
                    <a href="contactUs-list.php"><i class="fe fe-mail"></i> <span>Contact Us</span></a>
                </li>
            </ul>
        </div>
    </div>
</div>

<script>
    // Get all sidebar links
    const sidebarLinks = document.querySelectorAll('#sidebar-nav a');

    // Automatically set the active link based on the current page URL
    const currentPage = window.location.pathname.split('/').pop(); // Get the current page filename
    sidebarLinks.forEach(link => {
        if (link.getAttribute('href') === currentPage) {
            link.parentElement.classList.add('active');
        }
    });

    // Add click event listener to each link for dynamic active class
    sidebarLinks.forEach(link => {
        link.addEventListener('click', function () {
            // Remove 'active' class from all links
            sidebarLinks.forEach(link => link.parentElement.classList.remove('active'));

            // Add 'active' class to the clicked link's parent <li>
            this.parentElement.classList.add('active');
        });
    });
</script>