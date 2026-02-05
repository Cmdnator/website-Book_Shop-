<?php
$session_lifetime = 8 * 60 * 60; // 8 hours

// Set PHP session cookie lifetime
ini_set('session.cookie_lifetime', $session_lifetime);
ini_set('session.gc_maxlifetime', $session_lifetime);

session_set_cookie_params($session_lifetime);
session_start();

require_once("../PartsOfPage/Database.php");

$success = false;
$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullname = mysqli_real_escape_string($db_conn, $_POST['fullname']);
    $address  = mysqli_real_escape_string($db_conn, $_POST['address']);
    $email    = mysqli_real_escape_string($db_conn, $_POST['email']);
    $phone    = mysqli_real_escape_string($db_conn, $_POST['phone']);
    $city     = mysqli_real_escape_string($db_conn, $_POST['city']);
    $postal   = mysqli_real_escape_string($db_conn, $_POST['postal']);
    $country  = mysqli_real_escape_string($db_conn, $_POST['country']);

    //Books in order info
    $cart_json = isset($_SESSION['cart']) ? mysqli_real_escape_string($db_conn, json_encode($_SESSION['cart'])) : '';

    $sql_req = "INSERT INTO orders(full_name, address, email, phone, city, postal_code, country, cart_items) 
                VALUES ('$fullname', '$address', '$email', '$phone', '$city', '$postal', '$country', '$cart_json')";

    if (mysqli_query($db_conn, $sql_req)) {
    $success = true;
    // Clear the cart
        if (isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
    } 
}

mysqli_close($db_conn);
?>


<!DOCTYPE html>
<html>
<head>
    <title>Billing Information</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../PartsOfPage/PartsOfPage.css" rel="stylesheet">
    <link href="../CssOfPages/Bill.info.css" rel="stylesheet">
</head>

<body>
<div class="head-nav">
    <?php include("../PartsOfPage/header.php"); ?>
    <?php include("../PartsOfPage/nav.php"); ?>
</div>

<main>
        <div class="billing-card">
            <?php if ($success): ?>
            <div style="
                background:#e9ffe9;
                border:1px solid #b9e7b9;
                color:#2f7f2f;
                padding:18px 22px;
                margin-bottom:20px;
                font-size:1rem;
                border-radius:8px;
                text-align:center; ">
            <h2 style="margin:0 0 8px 0;">Order placed successfully!</h2>
            <a href='Catalogue-page.php' class='billing-back' style="color:#2f7f2f;"> ⬅ Back to Catalogue</a>
            </div>
        <?php else: ?>
            <h2>Billing Information</h2>

        <form class="billing-form" action="<?php print htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">

        <div class="billing-field">
            <label>Full Name</label>
            <input type="text" name="fullname" required>
        </div>

        <div class="billing-field">
            <label>Email</label>
            <input type="email" name="email" required>
        </div>

        <div class="billing-field">
            <label>Phone Number</label>
            <input type="text" name="phone" required>
        </div>

        <div class="billing-field">
            <label>Country</label>
            <input type="text" name="country" required>
        </div>

        <div class="billing-field full">
            <label>Address</label>
            <input type="text" name="address" required>
        </div>

        <div class="billing-field">
            <label>City</label>
            <input type="text" name="city"required>
        </div>

        <div class="billing-field">
            <label>Postal Code</label>
            <input type="text" name="postal" required>
        </div>

        <button class="billing-submit">Place Order</button>
    </form>
        <a href="Cart-page.php" class="billing-back">⬅ Back to Cart</a>
    </div>
    <?php endif; ?>
</main>

<?php include("../PartsOfPage/footer.php"); ?>
</body>
</html>
