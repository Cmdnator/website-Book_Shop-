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

//session confirmation
if (!isset($_SESSION['user_id'])) {
    header("Location: Log-in.php");
    exit();
}	
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<link href="../PartsOfPage/PartsOfPage.css" rel="stylesheet">
	<link href="../CssOfPages/main.css" rel="stylesheet">
    <link href="../CssOfPages/Add_Book.css" rel="stylesheet">
	<title>Add Book</title>
</head>

<body>
	<div class="head-nav">
		<?php include("../PartsOfPage/header.php"); ?>
		<?php include("../PartsOfPage/nav.php"); ?>
	</div>
	<main>
    
    <div class="title">
        <h2>Adding New Book To Catalogue</h2>
    </div>

 <div class="dashboard-card">
    <form class="submitISBN">
        <input type="text" id="isbn" placeholder="Enter Book's ISBN" required>
        <button type="submit" id="fetchBook">Fetch Book Info</button>
    </form>
</div>

<div class="bookCover">
    <div class="book-image">
        <img src="" id="coverImg" alt="Book Cover" />
    </div>
    <div class="book-info">
        <input type="text" id="title" name="title" placeholder="Book Title">
        <input type="text" id="author" name="author" placeholder="Author Name">
        <input type="number" id="price" name="price" placeholder="Price">
    </div>
</div>

	</main>

    <?php include("../PartsOfPage/footer.php"); ?>
    <script src = "../JS/addToCatalogue.js"></script>
</body>
</html>