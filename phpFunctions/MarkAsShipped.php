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
require "../PartsOfPage/Database.php";

// ADMIN PROTECTION
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] != 1) {
    header("Location: Log-in.php");
    exit();
}

//STATUS
if (isset($_POST['order_id'], $_POST['status'])) {
    $order_id = intval($_POST['order_id']);
    $status = mysqli_real_escape_string($db_conn, $_POST['status']);

    $sql = "UPDATE orders SET status = '$status' WHERE id = $order_id";

    if (mysqli_query($db_conn, $sql)) {
        header("Location: ../Pages/admin_dashboard.php"); 
        exit();
    } else {
        print "Error updating: " . mysqli_error($db_conn);
    }
} else {
    print "Invalid request.";
}
?>
