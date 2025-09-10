<?php 
include 'includes/header.php'; 
include 'includes/db.php';
include 'includes/auth.php';

requireAuth();

$user_id = $_SESSION['user_id'];
$query = "SELECT * FROM users WHERE id = $user_id";
$result = mysqli_query($conn, $query);
$user = mysqli_fetch_assoc($result);

// Handle profile update
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    
    $update_query = "UPDATE users SET name = '$name', email = '$email', 
                    phone = '$phone', address = '$address' WHERE id = $user_id";
    
    if (mysqli_query($conn, $update_query)) {
        $_SESSION['user_name'] = $name;
        $success = "Profile updated successfully!";
        
        // Refresh user data
        $result = mysqli_query($conn, $query);
        $user = mysqli_fetch_assoc($result);
    } else {
        $error = "Error updating profile: " . mysqli_error($conn);
    }
}
?>

<div class="row">
    <div class="col-md-4">
        <div class="card">
            <div class="card-body text-center">
                <img src="https://ui-avatars.com/api/?name=<?php echo urlencode($user['name']); ?>&size=200&background=random" 
                     alt="Profile" class="rounded-circle mb-3" width="150">
                <h4><?php echo $user['name']; ?></h4>
                <p class="text-muted">Member since <?php echo date('F Y', strtotime($user['created_at'])); ?></p>
            </div>
        </div>
    </div>
    
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5>Profile Information</h5>
            </div>
            <div class="card-body">
                <?php if (isset($success)): ?>
                    <div class="alert alert-success"><?php echo $success; ?></div>
                <?php endif; ?>
                
                <?php if (isset($error)): ?>
                    <div class="alert alert-danger"><?php echo $error; ?></div>
                <?php endif; ?>
                
                <form method="POST" action="">
                    <div class="mb-3">
                        <label for="name" class="form-label">Full Name</label>
                        <input type="text" class="form-control" id="name" name="name" 
                               value="<?php echo $user['name']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email Address</label>
                        <input type="email" class="form-control" id="email" name="email" 
                               value="<?php echo $user['email']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">Phone Number</label>
                        <input type="tel" class="form-control" id="phone" name="phone" 
                               value="<?php echo $user['phone']; ?>">
                    </div>
                    <div class="mb-3">
                        <label for="address" class="form-label">Address</label>
                        <textarea class="form-control" id="address" name="address" rows="3"><?php echo $user['address']; ?></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Update Profile</button>
                </form>
            </div>
        </div>
        
        <div class="card mt-4">
            <div class="card-header">
                <h5>Order History</h5>
            </div>
            <div class="card-body">
                <?php
                $order_query = "SELECT * FROM orders WHERE user_id = $user_id ORDER BY created_at DESC LIMIT 5";
                $order_result = mysqli_query($conn, $order_query);
                
                if (mysqli_num_rows($order_result) > 0) {
                    while ($order = mysqli_fetch_assoc($order_result)) {
                        echo '
                        <div class="d-flex justify-content-between border-bottom pb-2 mb-2">
                            <div>
                                <strong>Order #' . $order['id'] . '</strong>
                                <p class="mb-0">' . date('M j, Y', strtotime($order['created_at'])) . '</p>
                            </div>
                            <div class="text-end">
                                <p class="mb-0">RM ' . number_format($order['total_amount'], 2) . '</p>
                                <span class="badge bg-info">' . ucfirst($order['status']) . '</span>
                            </div>
                        </div>';
                    }
                } else {
                    echo '<p class="text-muted">You have no orders yet.</p>';
                }
                ?>
                <div class="text-center mt-3">
                    <a href="orders.php" class="btn btn-sm btn-outline-primary">View All Orders</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>