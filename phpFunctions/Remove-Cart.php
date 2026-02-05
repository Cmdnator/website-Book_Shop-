<?php
$session_lifetime = 8 * 60 * 60; // 8 hours

// Set PHP session cookie lifetime
session_set_cookie_params([
    'lifetime' => $session_lifetime,
    'path'     => '/',
    'httponly' => true,
    'samesite' => 'Lax'
]);
session_start();


if (isset($_GET['title'])) {
    $title = $_GET['title'];
    if (isset($_SESSION['cart'][$title])) {
        unset($_SESSION['cart'][$title]);
    }
}

header("Location: ../Pages/Cart-page.php");
exit();
?>