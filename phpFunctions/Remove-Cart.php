<?php
$session_lifetime = 8 * 60 * 60; // 8 hours

// Set PHP session cookie lifetime
ini_set('session.cookie_lifetime', $session_lifetime);
ini_set('session.gc_maxlifetime', $session_lifetime);

session_set_cookie_params($session_lifetime);
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