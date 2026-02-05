<?php
$session_lifetime = 8 * 60 * 60; // 8 hours

// Set PHP session cookie lifetime
ini_set('session.cookie_lifetime', $session_lifetime);
ini_set('session.gc_maxlifetime', $session_lifetime);

session_set_cookie_params($session_lifetime);
session_start();

require "../PartsOfPage/Database.php";

// ADMIN CHECK
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] != 1) {
    header("Location: Log-in.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // Customer info
    $full_name   = mysqli_real_escape_string($db_conn, $_POST['full_name']);
    $email       = mysqli_real_escape_string($db_conn, $_POST['email']);
    $phone       = mysqli_real_escape_string($db_conn, $_POST['phone']);
    $address     = mysqli_real_escape_string($db_conn, $_POST['address']);
    $city        = mysqli_real_escape_string($db_conn, $_POST['city']);
    $postal_code = mysqli_real_escape_string($db_conn, $_POST['postal_code']);
    $country     = mysqli_real_escape_string($db_conn, $_POST['country']);

    // book info
    $title    = mysqli_real_escape_string($db_conn, $_POST['title']);
    $price    = floatval($_POST['price']);
    $author   = mysqli_real_escape_string($db_conn, $_POST['author']);
    $quantity = intval($_POST['quantity']);

    // Create JSON array of items
    $cart_items = [
        [
            "title"    => $title,
            "price"    => $price,
            "author"   => $author,
            "quantity" => $quantity
        ]
    ];
    $cart_json = mysqli_real_escape_string($db_conn, json_encode($cart_items));

    // Insert into database
    $sql = " INSERT INTO orders
            (full_name, email, phone, address, city, postal_code, country, cart_items)
            VALUES
            ('$full_name', '$email', '$phone', '$address', '$city', '$postal_code', '$country', '$cart_json')";

    if (mysqli_query($db_conn, $sql)) {
        header("Location: ../Pages/admin_dashboard.php?created=1");
        exit();
    }
}
?>
