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
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link href="../PartsOfPage/PartsOfPage.css" rel="stylesheet">
    <link href="../CssOfPages/faq.css" rel="stylesheet">
    <title>Careers - Join Our Team</title>
</head>

<body>
    <div class="head-nav">
        <?php include("../PartsOfPage/header.php"); ?>
        <?php include("../PartsOfPage/nav.php"); ?>
    </div>

    <main>
    <section class="faq-hero">
        <h1>Frequently Asked Questions</h1>
        <p>Find answers to the most common questions about our bookstore, orders, and services.</p>
    </section>

    <section class="faq-container">

        <div class="faq-item">
            <h3>📚 How can I order a book?</h3>
            <p>You can browse our catalog, add items to your cart, and proceed to checkout. It’s quick and simple!</p>
        </div>

        <div class="faq-item">
            <h3>🚚 How long does delivery take?</h3>
            <p>Standard delivery usually takes 2–5 business days. International shipping may take longer.</p>
        </div>

        <div class="faq-item">
            <h3>💳 What payment methods do you accept?</h3>
            <p>We accept credit cards, PayPal, and bank transfers depending on your region.</p>
        </div>

        <div class="faq-item">
            <h3>🔄 Can I return or exchange a book?</h3>
            <p>Yes! Books can be returned within 14 days as long as they are in original condition.</p>
        </div>

        <div class="faq-item">
            <h3>📦 My book arrived damaged. What do I do?</h3>
            <p>Please contact our support team and provide pictures of the damaged item. We will replace it for free.</p>
        </div>

        <div class="faq-item">
            <h3>📝 Do I need an account to place an order?</h3>
            <p>No, you can checkout as a guest. However, creating an account lets you track orders and save favorites.</p>
        </div>

        <div class="faq-item">
            <h3>🌍 Do you ship internationally?</h3>
            <p>Yes, we ship to most countries. Shipping fees vary by region.</p>
        </div>

        <div class="faq-item">
            <h3>📕 Do you sell used or rare books?</h3>
            <p>Yes! We have a special section for rare and collectible books. Availability varies.</p>
        </div>

    </section>

</main>

    <?php include("../PartsOfPage/footer.php"); ?>

</body>

</html>