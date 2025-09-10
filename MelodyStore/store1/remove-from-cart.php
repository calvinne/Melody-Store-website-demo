<?php
session_start();
include 'includes/db.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['id'])) {
    $user_id = $_SESSION['user_id'];
    $product_id = intval($_GET['id']);
    
    // Remove item from cart
    $query = "DELETE FROM cart WHERE user_id = $user_id AND product_id = $product_id";
    mysqli_query($conn, $query);
}

header("Location: cart.php");
exit();
?>