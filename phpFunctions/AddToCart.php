<?php
$session_lifetime = 8 * 60 * 60; // 8 hours

// Set PHP session cookie lifetime
ini_set('session.cookie_lifetime', $session_lifetime);
ini_set('session.gc_maxlifetime', $session_lifetime);

session_set_cookie_params($session_lifetime);
session_start();

$title = $_POST['title'];
$price = $_POST['price'];
$image = $_POST['image'];
$author = $_POST['author'];

// Create cart if not exists
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Use title as a key to avoid duplicates
if (isset($_SESSION['cart'][$title])) {
    // Already in cart
    $_SESSION['cart'][$title]['quantity'] += 1;
} else {
    $_SESSION['cart'][$title] = [
        'title' => $title,
        'price' => $price,
        'image' => $image,
        'author' => $author,
        'quantity' => 1
    ];
}

header("Location:  ../Pages/Catalogue-page.php");
exit();
?>
