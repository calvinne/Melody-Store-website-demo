<?php
session_start();
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = $_POST['action'];
    $response = [];
    
    if (!isset($_SESSION['user_id'])) {
        $response['success'] = false;
        $response['message'] = 'Please login to add items to wishlist';
        echo json_encode($response);
        exit();
    }
    
    $user_id = $_SESSION['user_id'];
    
    switch ($action) {
        case 'add_to_wishlist':
            $product_id = mysqli_real_escape_string($conn, $_POST['product_id']);
            
            // Check if product already in wishlist
            $check_query = "SELECT * FROM wishlist WHERE user_id = $user_id AND product_id = $product_id";
            $check_result = mysqli_query($conn, $check_query);
            
            if (mysqli_num_rows($check_result) > 0) {
                $response['success'] = false;
                $response['message'] = 'Product already in wishlist';
            } else {
                // Add to wishlist
                $insert_query = "INSERT INTO wishlist (user_id, product_id) 
                                VALUES ($user_id, $product_id)";
                if (mysqli_query($conn, $insert_query)) {
                    $response['success'] = true;
                } else {
                    $response['success'] = false;
                    $response['message'] = 'Database error';
                }
            }
            break;
            
        default:
            $response['success'] = false;
            $response['message'] = 'Invalid action';
    }
    
    echo json_encode($response);
}
?>