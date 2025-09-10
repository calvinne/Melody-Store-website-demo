<?php
session_start();
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = $_POST['action'];
    $response = [];
    
    if (!isset($_SESSION['user_id'])) {
        $response['success'] = false;
        $response['message'] = 'Please login to add items to cart';
        echo json_encode($response);
        exit();
    }
    
    $user_id = $_SESSION['user_id'];
    
    switch ($action) {
        case 'add_to_cart':
            $product_id = mysqli_real_escape_string($conn, $_POST['product_id']);
            $quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 1;
            
            // Check if product already in cart
            $check_query = "SELECT * FROM cart WHERE user_id = $user_id AND product_id = $product_id";
            $check_result = mysqli_query($conn, $check_query);
            
            if (mysqli_num_rows($check_result) > 0) {
                // Update quantity
                $update_query = "UPDATE cart SET quantity = quantity + $quantity 
                                WHERE user_id = $user_id AND product_id = $product_id";
                mysqli_query($conn, $update_query);
            } else {
                // Add new item
                $insert_query = "INSERT INTO cart (user_id, product_id, quantity) 
                                VALUES ($user_id, $product_id, $quantity)";
                mysqli_query($conn, $insert_query);
            }
            
            // Get cart count
            $count_query = "SELECT SUM(quantity) as count FROM cart WHERE user_id = $user_id";
            $count_result = mysqli_query($conn, $count_query);
            $count_data = mysqli_fetch_assoc($count_result);
            
            $response['success'] = true;
            $response['cart_count'] = $count_data['count'] ? $count_data['count'] : 0;
            break;
            
        default:
            $response['success'] = false;
            $response['message'] = 'Invalid action';
    }
    
    echo json_encode($response);
}
?>