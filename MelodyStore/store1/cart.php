<?php 
include 'includes/header.php'; 
include 'includes/db.php';
include 'includes/auth.php';

requireAuth();
?>

<h2>Shopping Cart</h2>

<?php
$user_id = $_SESSION['user_id'];
$query = "SELECT c.*, p.name, p.price, p.image, p.stock 
          FROM cart c 
          JOIN products p ON c.product_id = p.id 
          WHERE c.user_id = $user_id";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) > 0) {
    $total = 0;
    ?>
    <form id="cart-form" method="post" action="update-cart.php">
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <?php while ($item = mysqli_fetch_assoc($result)): 
                        $item_total = $item['price'] * $item['quantity'];
                        $total += $item_total;
                        $image_path = "img/products/" . $item['image'];
                    ?>
                        <div class="cart-item d-flex align-items-center mb-3 pb-3 border-bottom">
                            <div class="flex-shrink-0">
                                <img src="<?php echo $image_path; ?>" 
                                     alt="<?php echo $item['name']; ?>" width="80" class="img-fluid rounded">
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h5><?php echo $item['name']; ?></h5>
                                <p class="mb-0">RM <?php echo number_format($item['price'], 2); ?></p>
                            </div>
                            <div class="quantity-control input-group ms-3" style="width: 120px;">
                                <button type="button" class="btn btn-outline-secondary minus-btn" data-id="<?php echo $item['product_id']; ?>">-</button>
                                <input type="number" name="quantity[<?php echo $item['product_id']; ?>]" 
                                       class="form-control text-center quantity-input" 
                                       value="<?php echo $item['quantity']; ?>" 
                                       min="1" max="<?php echo $item['stock']; ?>"
                                       data-price="<?php echo $item['price']; ?>"
                                       data-id="<?php echo $item['product_id']; ?>">
                                <button type="button" class="btn btn-outline-secondary plus-btn" data-id="<?php echo $item['product_id']; ?>">+</button>
                            </div>
                            <div class="ms-3">
                                <h5 class="item-total" data-id="<?php echo $item['product_id']; ?>">
                                    RM <?php echo number_format($item_total, 2); ?>
                                </h5>
                            </div>
                            <div class="ms-3">
                                <a href="remove-from-cart.php?id=<?php echo $item['product_id']; ?>" class="btn btn-danger btn-sm remove-from-cart">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5>Order Summary</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-2">
                        <span>Subtotal:</span>
                        <span id="subtotal">RM <?php echo number_format($total, 2); ?></span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Shipping:</span>
                        <span>RM 10.00</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Tax (6%):</span>
                        <span id="tax">RM <?php echo number_format($total * 0.06, 2); ?></span>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between mb-3">
                        <strong>Total:</strong>
                        <strong id="grand-total">RM <?php echo number_format($total + 10 + ($total * 0.06), 2); ?></strong>
                    </div>
                    <button type="submit" class="btn btn-secondary w-100 mb-2">Update Cart</button>
                    <a href="checkout.php" class="btn btn-primary w-100">Proceed to Checkout</a>
                </div>
            </div>
        </div>
    </div>
    </form>
    
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Plus button functionality
        document.querySelectorAll('.plus-btn').forEach(button => {
            button.addEventListener('click', function() {
                const productId = this.getAttribute('data-id');
                const input = document.querySelector(`.quantity-input[data-id="${productId}"]`);
                const max = parseInt(input.getAttribute('max'));
                
                if (input.value < max) {
                    input.value = parseInt(input.value) + 1;
                    updateItemTotal(productId);
                    updateOrderSummary();
                }
            });
        });
        
        // Minus button functionality
        document.querySelectorAll('.minus-btn').forEach(button => {
            button.addEventListener('click', function() {
                const productId = this.getAttribute('data-id');
                const input = document.querySelector(`.quantity-input[data-id="${productId}"]`);
                
                if (input.value > 1) {
                    input.value = parseInt(input.value) - 1;
                    updateItemTotal(productId);
                    updateOrderSummary();
                }
            });
        });
        
        // Input change functionality
        document.querySelectorAll('.quantity-input').forEach(input => {
            input.addEventListener('change', function() {
                const productId = this.getAttribute('data-id');
                const max = parseInt(this.getAttribute('max'));
                const min = parseInt(this.getAttribute('min'));
                
                if (this.value > max) this.value = max;
                if (this.value < min) this.value = min;
                
                updateItemTotal(productId);
                updateOrderSummary();
            });
        });
        
        // Update individual item total
        function updateItemTotal(productId) {
            const input = document.querySelector(`.quantity-input[data-id="${productId}"]`);
            const price = parseFloat(input.getAttribute('data-price'));
            const quantity = parseInt(input.value);
            const total = price * quantity;
            
            document.querySelector(`.item-total[data-id="${productId}"]`).textContent = 
                'RM ' + total.toFixed(2);
        }
        
        // Update order summary
        function updateOrderSummary() {
            let subtotal = 0;
            
            document.querySelectorAll('.quantity-input').forEach(input => {
                const price = parseFloat(input.getAttribute('data-price'));
                const quantity = parseInt(input.value);
                subtotal += price * quantity;
            });
            
            const tax = subtotal * 0.06;
            const grandTotal = subtotal + 10 + tax;
            
            document.getElementById('subtotal').textContent = 'RM ' + subtotal.toFixed(2);
            document.getElementById('tax').textContent = 'RM ' + tax.toFixed(2);
            document.getElementById('grand-total').textContent = 'RM ' + grandTotal.toFixed(2);
        }
    });
    </script>
<?php } else { ?>
    <div class="alert alert-info">
        Your cart is empty. <a href="products.php">Browse products</a> to add items.
    </div>
<?php } ?>

<?php include 'includes/footer.php'; ?>