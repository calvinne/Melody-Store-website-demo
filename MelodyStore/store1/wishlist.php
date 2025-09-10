<?php 
include 'includes/header.php'; 
include 'includes/db.php';
include 'includes/auth.php';

requireAuth();
?>

<h2>My Wishlist</h2>

<?php
$user_id = $_SESSION['user_id'];
$query = "SELECT w.*, p.name, p.price, p.image, p.description 
          FROM wishlist w 
          JOIN products p ON w.product_id = p.id 
          WHERE w.user_id = $user_id";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) > 0) {
    ?>
    <div class="row">
        <?php while ($item = mysqli_fetch_assoc($result)): 
            $image_path = "img/products/" . $item['image'];
        ?>
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <img src="<?php echo $image_path; ?>" 
                         class="card-img-top" alt="<?php echo $item['name']; ?>"
                         style="height: 200px; object-fit: cover;">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $item['name']; ?></h5>
                        <p class="card-text"><?php echo substr($item['description'], 0, 100); ?>...</p>
                        <p class="fw-bold">RM <?php echo number_format($item['price'], 2); ?></p>
                        <div class="d-flex justify-content-between">
                            <a href="product-detail.php?id=<?php echo $item['product_id']; ?>" class="btn btn-primary">View Details</a>
                            <a href="remove-from-wishlist.php?id=<?php echo $item['product_id']; ?>" class="btn btn-outline-danger remove-from-wishlist">
                                <i class="fas fa-trash"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
    
    <script>
    // Add confirmation for delete actions
    document.addEventListener('DOMContentLoaded', function() {
        const deleteButtons = document.querySelectorAll('.remove-from-wishlist');
        
        deleteButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                if (!confirm('Are you sure you want to remove this item from your wishlist?')) {
                    e.preventDefault();
                }
            });
        });
    });
    </script>
<?php } else { ?>
    <div class="alert alert-info">
        Your wishlist is empty. <a href="products.php">Browse products</a> to add items to your wishlist.
    </div>
<?php } ?>

<?php include 'includes/footer.php'; ?>