<?php 
include 'includes/header.php'; 
include 'includes/db.php';
include 'includes/auth.php';

requireAuth();

// Get cart items and total
$user_id = $_SESSION['user_id'];
$query = "SELECT c.*, p.name, p.price, p.image 
          FROM cart c 
          JOIN products p ON c.product_id = p.id 
          WHERE c.user_id = $user_id";
$result = mysqli_query($conn, $query);

$total = 0;
$items = [];
while ($item = mysqli_fetch_assoc($result)) {
    $item_total = $item['price'] * $item['quantity'];
    $total += $item_total;
    $items[] = $item;
}

$shipping = 10.00;
$tax = $total * 0.06;
$grand_total = $total + $shipping + $tax;
?>

<div class="row">
    <div class="col-md-8">
        <div class="card mb-4">
            <div class="card-header">
                <h4>Order Summary</h4>
            </div>
            <div class="card-body">
                <?php foreach ($items as $item): ?>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <h6><?php echo $item['name']; ?></h6>
                            <small>Quantity: <?php echo $item['quantity']; ?></small>
                        </div>
                        <div>RM <?php echo number_format($item['price'] * $item['quantity'], 2); ?></div>
                    </div>
                <?php endforeach; ?>
                
                <hr>
                <div class="d-flex justify-content-between">
                    <div>Subtotal:</div>
                    <div>RM <?php echo number_format($total, 2); ?></div>
                </div>
                <div class="d-flex justify-content-between">
                    <div>Shipping:</div>
                    <div>RM <?php echo number_format($shipping, 2); ?></div>
                </div>
                <div class="d-flex justify-content-between">
                    <div>Tax (6%):</div>
                    <div>RM <?php echo number_format($tax, 2); ?></div>
                </div>
                <hr>
                <div class="d-flex justify-content-between fw-bold">
                    <div>Total:</div>
                    <div>RM <?php echo number_format($grand_total, 2); ?></div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h4>Payment Method</h4>
            </div>
            <div class="card-body">
                <div class="form-check mb-3">
                    <input class="form-check-input" type="radio" name="paymentMethod" id="visa" value="visa" checked>
                    <label class="form-check-label" for="visa">
                        <i class="fab fa-cc-visa fa-2x me-2"></i> Credit/Debit Card
                    </label>
                </div>
                
                <div class="form-check mb-3">
                    <input class="form-check-input" type="radio" name="paymentMethod" id="ewallet" value="ewallet">
                    <label class="form-check-label" for="ewallet">
                        <i class="fas fa-mobile-alt fa-2x me-2"></i> E-Wallet
                    </label>
                </div>
                
                <div class="form-check mb-3">
                    <input class="form-check-input" type="radio" name="paymentMethod" id="cod" value="cod">
                    <label class="form-check-label" for="cod">
                        <i class="fas fa-money-bill-wave fa-2x me-2"></i> Cash on Delivery
                    </label>
                </div>
                
                <button id="pay-now" class="btn btn-primary w-100 mt-3">Pay Now</button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('pay-now').addEventListener('click', function() {
        const paymentMethod = document.querySelector('input[name="paymentMethod"]:checked').value;
        let message = '';
        
        switch(paymentMethod) {
            case 'visa':
                message = 'Payment successful! Thank you for your purchase with Visa.';
                break;
            case 'ewallet':
                message = 'Payment successful! Thank you for using E-Wallet.';
                break;
            case 'cod':
                message = 'Order placed successfully! Please prepare cash on delivery.';
                break;
        }
        
        // Show success message
        alert(message);
        
        // Redirect to home page after payment
        setTimeout(function() {
            window.location.href = 'index.php';
        }, 1500);
    });
});
</script>

<?php include 'includes/footer.php'; ?>