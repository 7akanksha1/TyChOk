<?php
session_start();
if (!isset($_SESSION['user'])) {
    echo "<script>alert('Please login to add items to cart.'); window.location.href='index.php';</script>";
    exit();
}

// cart logic here
$product_id = $_GET['id'] ?? null;

if ($product_id) {
    // Simulate a cart using session
    $_SESSION['cart'][] = $product_id;
    echo "<script>alert('Product added to cart!'); window.location.href='products.php';</script>";
} else {
    echo "No product selected.";
}
?>
