<?php
// Redirect to login if not authenticated
function requireAuth() {
    if (!isset($_SESSION['user_id'])) {
        header("Location: login.php");
        exit();
    }
}

// Redirect to home if already authenticated
function redirectIfAuthenticated() {
    if (isset($_SESSION['user_id'])) {
        header("Location: index.php");
        exit();
    }
}
?>