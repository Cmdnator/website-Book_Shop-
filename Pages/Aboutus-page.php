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
	<link href="../CssOfPages/aboutus.css" rel="stylesheet">
	<title>About us</title>
</head>

<body>
	<div class="head-nav">
		<?php include("../PartsOfPage/header.php"); ?>
		<?php include("../PartsOfPage/nav.php"); ?>
	</div>
	 <main>
        <h1>About Us</h1>
        <p class="intro">
            Welcome to Your Book Paradise, where your love for reading meets convenience and discovery.
        </p>

        <!-- Our Story Section -->
        <section class="section">
            <img src="../images/BookStoreInterior.jpg" alt="Our Bookstore">
            <div class="text">
                <h2>Our Story</h2>
                <p>
                    Your Book Paradise was founded with the goal of making books accessible to everyone, everywhere.
                    From timeless classics to the latest bestsellers, we curate an extensive collection to satisfy every reader's curiosity.
                </p>
                <p>
                    Our mission is to inspire, educate, and entertain by connecting readers with the stories they love.
                    With a passion for literature and a focus on customer satisfaction, we strive to make every visit to our online store an enjoyable experience.
                </p>
            </div>
        </section>

        <!-- Our Mission Section -->
        <section class="section">
            <div class="text">
                <h2>Our Mission</h2>
                <p>
                    We aim to simplify the search for books with smart recommendations, intuitive filters, and personalized suggestions.
                    Our team works tirelessly to ensure you find exactly what you are looking for quickly and effortlessly.
                </p>
                <p>
                    Whether you are a casual reader, a student, or a passionate bibliophile, we are dedicated to enriching your reading journey.
                </p>
            </div>
            <img src="../images/PersonWithBook.jpg" alt="Our Mission">
        </section>

        <!-- Our Team Section -->
        <h2>Meet Our Team</h2>
        <div class="team">
            <div class="team-member">
                <h3>Marian Nychai</h3>
                <p>Founder & CEO</p>
            </div>
        </div>
    </main>

	<?php include("../PartsOfPage/footer.php"); ?>

</body>

</html>