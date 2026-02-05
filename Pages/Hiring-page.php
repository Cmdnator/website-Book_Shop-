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
    <link href="../CssOfPages/hiring.css" rel="stylesheet">
    <title>Careers - Join Our Team</title>
</head>

<body>
    <div class="head-nav">
        <?php include("../PartsOfPage/header.php"); ?>
        <?php include("../PartsOfPage/nav.php"); ?>
    </div>

    <main>
        <!-- Hero Section -->
        <section class="hero">
            <h1>Join Our Team</h1>
            <p>We’re always looking for passionate people who love books and customer service.</p>
        </section>

         <h2>Why Work With Us?</h2>
        <!-- Why Work With Us Section -->
        <section class="why-work-with-us">
            <div class="why-card">
                <h3>Great Team</h3>
                <p>Collaborate with passionate colleagues in a supportive environment.</p>
            </div>
            <div class="why-card">
                <h3>Career Growth</h3>
                <p>Opportunities to develop your skills and grow within the company.</p>
            </div>
            <div class="why-card">
                <h3>Flexible Hours</h3>
                <p>Balance work and life with our flexible scheduling options.</p>
            </div>
        </section>

        <!-- JOB APPLICATION FORM -->
        <section class="job-listing-form">
            <h3>Apply for a Position</h3>
          <form action="https://formspree.io/f/mjkljlpa" method="POST">
            <label for="name">Full Name</label>
            <input type="text" id="name" name="name" required>

            <label for="phone">Phone number</label>
            <input type="tel" id="phone" name="phone" required placeholder="+48-123-456-789">

            <label for="email">Email Address</label>
            <input type="email" id="email" name="email" required>

            <label for="position">Position Applying For</label>
            <select id="position" name="position" required>
                <option value="">Select a position</option>
                <option value="sales">Sales</option>
                <option value="developer">Developer</option>
                <option value="support">Customer Support</option>
            </select>

            <label for="resume">Resume / Message</label>
            <textarea id="resume" name="resume" placeholder="Write a brief message about yourself..."></textarea>

            <button type="submit">Submit Application</button>
        </form>
        </section>
    </main>

    <?php include("../PartsOfPage/footer.php"); ?>

</body>

</html>