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

require_once("../PartsOfPage/Database.php");

// Get JSON data from JS
$data = json_decode(file_get_contents("php://input"), true);

$title = $data['title'];
$author = $data['author'];
$price = $data['price'];
$category = $data['category'];
$cover = $data['cover'];

// Prepared statement
$stmt = $db_conn->prepare("INSERT INTO books (title, author, price, category, image_path) VALUES ( ?, ?, ?, ?, ?)");
$stmt->bind_param("sssss", $title, $author, $price, $category, $cover);

if ($stmt->execute()) {
    echo "Book saved successfully";
} else {
    echo "Error saving book";
}

$stmt->close();
$db_conn->close();
?>
