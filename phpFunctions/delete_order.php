<?php
$session_lifetime = 8 * 60 * 60; // 8 hours

// Set PHP session cookie lifetime
session_set_cookie_params([
    'lifetime' => $session_lifetime,
    'expires'  => time() + $session_lifetime,
    'path'     => '/',
    'httponly' => true,
    'samesite' => 'Lax'
]);
session_start();

require_once("../PartsOfPage/Database.php");

// ADMIN PROTECTION
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] != 1) {
    header("Location: Log-in.php");
    exit();
}

//delete logic
if (!isset($_POST['order_id'])) {
    die("Order ID not received.");
}

$order_id = intval($_POST['order_id']);

$sql = "DELETE FROM orders WHERE id = $order_id";
mysqli_query($db_conn, $sql);

header("Location: ../Pages/admin_dashboard.php"); 
exit();
?>