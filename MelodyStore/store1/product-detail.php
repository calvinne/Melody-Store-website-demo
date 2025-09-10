<?php include 'includes/header.php'; ?>
<?php include 'includes/db.php'; ?>

<?php
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: products.php");
    exit();
}

$product_id = mysqli_real_escape_string($conn, $_GET['id']);
$query = "SELECT p.*, c.name as category_name FROM products p 
          LEFT JOIN categories c ON p.category_id = c.id 
          WHERE p.id = $product_id";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) == 0) {
    echo '<div class="alert alert-danger">Product not found.</div>';
    include 'includes/footer.php';
    exit();
}

$product = mysqli_fetch_assoc($result);

// USE THE IMAGE FROM DATABASE - SIMPLE CHANGE!
$image_path = "img/products/" . $product['image'];
?>

<div class="row">
    <div class="col-md-6">
        <img src="<?php echo $image_path; ?>" 
             class="img-fluid rounded" alt="<?php echo $product['name']; ?>">
    </div>
    <div class="col-md-6">
        <h2><?php echo $product['name']; ?></h2>
        <p class="text-muted">Category: <?php echo $product['category_name']; ?></p>
        <p class="h3 text-primary">RM <?php echo number_format($product['price'], 2); ?></p>
        
        <div class="mb-3">
            <p><?php echo $product['description']; ?></p>
        </div>
        
        <div class="mb-3">
            <p><strong>Availability:</strong> 
                <?php echo $product['stock'] > 0 ? 'In Stock (' . $product['stock'] . ' available)' : 'Out of Stock'; ?>
            </p>
        </div>
        
        <?php if (isset($_SESSION['user_id'])): ?>
            <div class="d-flex gap-2 mb-3">
                <div class="input-group" style="width: 120px;">
                    <button class="btn btn-outline-secondary decrement">-</button>
                    <input type="number" class="form-control text-center" value="1" min="1" max="<?php echo $product['stock']; ?>" id="quantity">
                    <button class="btn btn-outline-secondary increment">+</button>
                </div>
                <button class="btn btn-primary flex-grow-1 add-to-cart" data-id="<?php echo $product['id']; ?>">
                    <i class="fas fa-shopping-cart"></i> Add to Cart
                </button>
            </div>
            <button class="btn btn-outline-danger w-100 add-to-wishlist" data-id="<?php echo $product['id']; ?>">
                <i class="fas fa-heart"></i> Add to Wishlist
            </button>
        <?php else: ?>
            <div class="alert alert-info">
                Please <a href="login.php">login</a> to add items to your cart or wishlist.
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Related Products -->
<div class="mt-5">
    <h3>Related Products</h3>
    <div class="row">
        <?php
        $related_query = "SELECT * FROM products 
                         WHERE category_id = {$product['category_id']} AND id != {$product['id']} 
                         LIMIT 4";
        $related_result = mysqli_query($conn, $related_query);
        
        while ($related = mysqli_fetch_assoc($related_result)) {
            // USE THE IMAGE FROM DATABASE FOR RELATED PRODUCTS TOO
            $related_image_path = "img/products/" . $related['image'];
            
            echo '
            <div class="col-md-3 mb-4">
                <div class="card h-100">
                    <img src="' . $related_image_path . '" 
                         class="card-img-top" alt="' . $related['name'] . '"
                         style="height: 200px; object-fit: cover;">
                    <div class="card-body">
                        <h5 class="card-title">' . $related['name'] . '</h5>
                        <p class="card-text">' . substr($related['description'], 0, 60) . '...</p>
                        <p class="fw-bold">RM ' . number_format($related['price'], 2) . '</p>
                        <a href="product-detail.php?id=' . $related['id'] . '" class="btn btn-sm btn-primary">View Details</a>
                    </div>
                </div>
            </div>';
        }
        ?>
    </div>
</div>

<?php include 'includes/footer.php'; ?>