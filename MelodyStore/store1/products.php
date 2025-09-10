<?php include 'includes/header.php'; ?>
<?php include 'includes/db.php'; ?>

<div class="row">
    <div class="col-md-3">
        <!-- Sidebar with categories -->
        <div class="card mb-4">
            <div class="card-header">
                <h5>Categories</h5>
            </div>
            <div class="list-group list-group-flush">
                <?php
                $cat_query = "SELECT * FROM categories";
                $cat_result = mysqli_query($conn, $cat_query);
                
                while ($cat = mysqli_fetch_assoc($cat_result)) {
                    $active = (isset($_GET['category']) && $_GET['category'] == $cat['id']) ? 'active' : '';
                    echo '<a href="products.php?category=' . $cat['id'] . '" class="list-group-item list-group-item-action ' . $active . '">' . $cat['name'] . '</a>';
                }
                ?>
            </div>
        </div>
    </div>
    
    <div class="col-md-9">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Our Products</h2>
            <div>
                <select class="form-select" id="sortProducts">
                    <option value="name_asc">Name (A-Z)</option>
                    <option value="name_desc">Name (Z-A)</option>
                    <option value="price_asc">Price (Low to High)</option>
                    <option value="price_desc">Price (High to Low)</option>
                </select>
            </div>
        </div>
        
        <div class="row">
            <?php
            // Build query based on filters
            $query = "SELECT p.*, c.name as category_name FROM products p 
                     LEFT JOIN categories c ON p.category_id = c.id WHERE 1=1";
            
            if (isset($_GET['category']) && !empty($_GET['category'])) {
                $category_id = mysqli_real_escape_string($conn, $_GET['category']);
                $query .= " AND p.category_id = $category_id";
            }
            
            if (isset($_GET['search']) && !empty($_GET['search'])) {
                $search = mysqli_real_escape_string($conn, $_GET['search']);
                $query .= " AND (p.name LIKE '%$search%' OR p.description LIKE '%$search%')";
            }
            
            // Add sorting
            $sort = isset($_GET['sort']) ? $_GET['sort'] : 'name_asc';
            switch ($sort) {
                case 'name_desc':
                    $query .= " ORDER BY p.name DESC";
                    break;
                case 'price_asc':
                    $query .= " ORDER BY p.price ASC";
                    break;
                case 'price_desc':
                    $query .= " ORDER BY p.price DESC";
                    break;
                default:
                    $query .= " ORDER BY p.name ASC";
            }
            
            $result = mysqli_query($conn, $query);
            
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    // USE THE IMAGE FROM DATABASE - SIMPLE CHANGE!
                    $image_path = "img/products/" . $row['image'];
                    
                    echo '
                    <div class="col-md-4 mb-4">
                        <div class="card h-100 product-card">
                            <img src="' . $image_path . '" 
                                 class="card-img-top" alt="' . $row['name'] . '"
                                 style="height: 200px; object-fit: cover;">
                            <div class="card-body">
                                <h5 class="card-title">' . $row['name'] . '</h5>
                                <p class="text-muted">' . $row['category_name'] . '</p>
                                <p class="card-text">' . substr($row['description'], 0, 100) . '...</p>
                                <p class="fw-bold">RM ' . number_format($row['price'], 2) . '</p>
                                <div class="d-flex justify-content-between">
                                    <a href="product-detail.php?id=' . $row['id'] . '" class="btn btn-primary">View Details</a>
                                    ' . (isset($_SESSION['user_id']) ? 
                                    '<button class="btn btn-outline-secondary add-to-cart" data-id="' . $row['id'] . '">
                                        <i class="fas fa-shopping-cart"></i>
                                    </button>' : '') . '
                                </div>
                            </div>
                        </div>
                    </div>';
                }
            } else {
                echo '<div class="col-12"><div class="alert alert-info">No products found.</div></div>';
            }
            ?>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>