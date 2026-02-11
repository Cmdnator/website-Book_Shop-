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

//Fetch data about books from DB
$query = "SELECT title, author FROM books";
$answer = mysqli_query($db_conn, $query);
$result = mysqli_fetch_assoc($answer);

$data = json_decode(file_get_contents("php://input"), true);

$title = $data['title'];
$author = $data['author'];
$price = $data['price'];
$category = $data['category'];
$cover = $data['cover'];


$checkStmt = $db_conn->prepare("SELECT id FROM books WHERE title = ? AND author = ?");
$checkStmt->bind_param("ss", $title, $author);
$checkStmt->execute();
$checkStmt->store_result();

if ($checkStmt->num_rows > 0) {
    echo "Such book already exists in catalogue";
} else {
    $stmt = $db_conn->prepare("INSERT INTO books (title, author, price, category, image_path) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $title, $author, $price, $category, $cover);

    if ($stmt->execute()) {
        echo "Book saved successfully";
    } else {
        echo "Error saving book";
    }

    $stmt->close();
}

$db_conn->close();
?>
