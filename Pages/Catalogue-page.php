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
require_once("../PartsOfPage/Database.php");

$search = $_GET['search'] ?? '';
$category = $_GET['category'] ?? '';

$search_sql = '';
$category_sql = '';

//Search query
if ($search !== '') {
    $search = mysqli_real_escape_string($db_conn, $search);
    $search_sql = " AND (title LIKE '%$search%' OR author LIKE '%$search%' OR category LIKE '%$search%')";
}

//Filter by category
switch($category) {
    case 'fiction':
    case 'fantasy':
    case 'romance':
    case 'history':
    case 'science':
        $category = mysqli_real_escape_string($db_conn, $category);
        $category_sql = " AND category='$category'";
        break;
    default:
        $category_sql = '';
}
//Sends query
$query = "SELECT * FROM books WHERE 1 $search_sql $category_sql";
$result = mysqli_query($db_conn, $query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Catalogue</title>
    <link href="../PartsOfPage/PartsOfPage.css" rel="stylesheet">
    <link rel="stylesheet" href="../CssOfPages/catalogue.css">
</head>

<body>

    <div class="head-nav">
        <?php include("../PartsOfPage/header.php"); ?>
        <?php include("../PartsOfPage/nav.php"); ?>
    </div>



    <main>

        <!-- Search + Filter Section -->
        <section class="catalogue-controls">
           <form method="GET" class="catalogue-form">
            <input type="submit" value="Search" class="btn-search">
            <input type="text" name="search" class="search-box" placeholder="Search books..."
                value="<?php print $_GET['search'] ?? ''; ?>">

            <select name="category" class="category-filter">
                <option value="">All Categories</option>
                <option value="fiction" <?php if(($_GET['category'] ?? '') == 'fiction') print 'selected'; ?>>Fiction</option>
                <option value="fantasy" <?php if(($_GET['category'] ?? '') == 'fantasy') print 'selected'; ?>>Fantasy</option>
                <option value="romance" <?php if(($_GET['category'] ?? '') == 'romance') print 'selected'; ?>>Romance</option>
                <option value="history" <?php if(($_GET['category'] ?? '') == 'history') print 'selected'; ?>>History</option>
                <option value="science" <?php if(($_GET['category'] ?? '') == 'science') print 'selected'; ?>>Science</option>
            </select>
        </form>
        </section>

        <!-- Book Catalogue Grid -->
        <section class="book-grid">

            <?php while ($row = mysqli_fetch_assoc($result)): ?>

                <div class="book-card">
                    <img src="../<?php print $row['image_path']; ?>">

                    <h3><?php print $row['title']; ?></h3>
                    <p class="author">by <?php print $row['author']; ?></p>
                    <p class="price">$<?php print $row['price']; ?></p>

                    <form action="../phpFunctions/AddToCart.php" method="POST">
                        <input type="hidden" name="title" value="<?= $row['title'] ?>">
                        <input type="hidden" name="price" value="<?= $row['price'] ?>">
                        <input type="hidden" name="author" value="<?= $row['author'] ?>">
                        <input type="hidden" name="image" value="<?= $row['image_path'] ?>">
                        <button type="submit" class="btn">Add to Cart</button>
                    </form>

                </div>
            <?php endwhile; ?>
        </section>
    </main>
    <?php include("../PartsOfPage/footer.php"); ?>
</body>

</html>

<?php mysqli_close($db_conn); ?>