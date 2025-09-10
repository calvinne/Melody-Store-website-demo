<?php
include 'includes/db.php';
include 'includes/auth.php';

requireAuth();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['quantity'])) {
    $user_id = $_SESSION['user_id'];
    
    foreach ($_POST['quantity'] as $product_id => $quantity) {
        $product_id = intval($product_id);
        $quantity = intval($quantity);
        
        // Update quantity in cart
        $query = "UPDATE cart SET quantity = $quantity 
                  WHERE user_id = $user_id AND product_id = $product_id";
        mysqli_query($conn, $query);
    }
    
    header("Location: cart.php");
    exit();
}
?>