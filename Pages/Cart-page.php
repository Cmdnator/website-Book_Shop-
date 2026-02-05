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

if (!isset($_SESSION['user_id'])) {
    header("Location: Log-in.php");
    exit();
}

//Update-Quantity
if (isset($_POST['index']) && isset($_POST['quantity'])) {
    $index = $_POST['index'];
    $quantity = max(1, intval($_POST['quantity'])); 

    $_SESSION['cart'][$index]['quantity'] = $quantity;
}

$cart = $_SESSION['cart'] ?? [];

$total = 0;
foreach ($cart as $item) {
    $total += $item['price'] * $item['quantity'];
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Your Cart</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../PartsOfPage/PartsOfPage.css" rel="stylesheet">
    <link rel="stylesheet" href="../CssOfPages/cart.css">
</head>
<body>
    <div class="head-nav">
        <?php include("../PartsOfPage/header.php"); ?>
        <?php include("../PartsOfPage/nav.php"); ?>
    </div>
<main>
<h1 class="hero">Your Cart</h1>

<?php if (empty($cart)) : ?>
    <p class="hero">Your cart is empty.</p>  
<?php else : ?>

        <h2 class="cart-total">
            Total: $<?php print number_format($total, 2); ?>
        </h2>

    <table border="10" cellpadding="8">
        <tr>
            <th>Image</th>
            <th>Title</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Action</th>
        </tr>

        <?php 
        foreach ($cart as $index => $item) : ?>
            <tr>
                <td><img src="<?php print htmlspecialchars($item['image'], ENT_QUOTES) ?>" width="120"></td>
                <td>
                <?php print $item['title']; ?>
                    <br>
                    <span class="author-text">by <?php print $item['author']; ?></span>
                </td>
                <td>$<?php print $item['price'] ?></td>
                <td>
                <form action="<?php print htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
                    <input type="hidden" name="index" value="<?php print $index; ?>">

                    <input 
                        type="number"
                        name="quantity"
                        min="1"
                        max="25"
                        value="<?php print $item['quantity']; ?>"
                        class="qty-input"
                        onchange="this.form.submit()"
                    >
                </form>
            </td>
                <td>
                    <a href="../phpFunctions/Remove-Cart.php?title=<?php print urlencode($index) ?>">Remove</a>
                </td>
            </tr>
        <?php endforeach;?>
    </table>
    <div class="cart-buttons">
    <a href="../Catalogue-page.php" class="cart-btn back">⬅ Back to Shopping</a>
    <a href="../BillingInfo-page.php" class="cart-btn checkout">Proceed to Checkout →</a>
</div>
<?php endif; ?>
</main>
    <?php include("../PartsOfPage/footer.php"); ?>
</body>
</html>
