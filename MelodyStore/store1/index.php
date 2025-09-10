<?php include 'includes/header.php'; ?>
<?php include 'includes/db.php'; ?>

<!-- Hero Section -->
<section class="hero bg-primary text-white py-5 mb-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h1 class="display-4 fw-bold">Find Your Perfect Instrument</h1>
                <p class="lead">Discover a wide range of high-quality musical instruments for beginners and professionals alike.</p>
                <a href="products.php" class="btn btn-light btn-lg">Shop Now</a>
            </div>
            <div class="col-md-6">
                <!-- Use your own hero image -->
                <video class="img-fluid rounded" controls autoplay muted loop>
                    <source src="video2.mp4" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
            </div>
        </div>
    </div>
</section>

<!-- Featured Products -->
<section class="featured-products mb-5">
    <div class="container">
        <h2 class="text-center mb-4">Featured Products</h2>
        <div class="row">
            <?php
            $query = "SELECT * FROM products WHERE featured = 1 LIMIT 3";
            $result = mysqli_query($conn, $query);
            
            while ($row = mysqli_fetch_assoc($result)) {
                // USE DATABASE IMAGE HERE TOO
                $image_path = "img/products/" . $row['image'];
                
                echo '
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <img src="' . $image_path . '" 
                             class="card-img-top" alt="' . $row['name'] . '"
                             style="height: 200px; object-fit: cover;">
                        <div class="card-body">
                            <h5 class="card-title">' . $row['name'] . '</h5>
                            <p class="card-text">' . substr($row['description'], 0, 100) . '...</p>
                            <p class="fw-bold">RM ' . number_format($row['price'], 2) . '</p>
                            <a href="product-detail.php?id=' . $row['id'] . '" class="btn btn-primary">View Details</a>
                        </div>
                    </div>
                </div>';
            }
            ?>
        </div>
        <div class="text-center mt-4">
            <a href="products.php" class="btn btn-outline-primary">View All Products</a>
        </div>
    </div>
</section>

<!-- Categories Section -->
<!-- Categories Section -->
<section class="categories mb-5">
    <div class="container">
        <h2 class="text-center mb-4">Browse by Category</h2>
        <div class="row">
            <?php
            $query = "SELECT * FROM categories LIMIT 6";
            $result = mysqli_query($conn, $query);
            
            while ($row = mysqli_fetch_assoc($result)) {
                  $icon = 'uploads/icons/default.png';

    // Choose icon based on category id or name
    switch ($row['id']) {
        case 1: $icon = 'uploads/guitar.jpg'; break;       // Guitars
        case 2: $icon = 'uploads/piano.jpg'; break;        // Keyboards
        case 3: $icon = 'uploads/drums.jpg'; break;        // Drums
        case 4: $icon = 'uploads/saxophone.jpg'; break;    // Wind Instruments
        case 5: $icon = 'uploads/violin.jpg'; break;       // Strings
        case 6: $icon = 'uploads/accessories.jpg'; break;  // Accessories
    }


                echo '
                <div class="col-md-4 col-sm-6 mb-4">
                    <div class="card category-card">
                        <div class="card-body text-center">
                                <img src="' . $icon . '" 
                                 alt="' . htmlspecialchars($row['name']) . '" 
                                 width="60" height="60" class="mb-3">
                            <h5 class="card-title">' . htmlspecialchars($row['name']) . '</h5>
                            <p class="card-text">' . substr($row['description'], 0, 80) . '...</p>
                            <a href="products.php?category=' . $row['id'] . '" class="btn btn-sm btn-outline-primary">Explore</a>
                        </div>
                    </div>
                </div>';
            }
            ?>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>