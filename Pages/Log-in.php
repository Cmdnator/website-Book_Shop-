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
?>
<?php
//Log in logic and error handling
$error = "";
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_SPECIAL_CHARS);
    $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_SPECIAL_CHARS);

    if (empty($username)) {
          $error = "Username is missing";
    } elseif (empty($password)) {
          $error = "Password is missing";
    } else {

        $sql = "SELECT * FROM users WHERE name = '$username'";
        $result = mysqli_query($db_conn, $sql);

        if (mysqli_num_rows($result) == 1) {
            $row = mysqli_fetch_assoc($result);
            if (password_verify($password, $row['password'])) {

                $_SESSION['user_id'] = $row['id'];
                $_SESSION['username'] = $row['name'];
                $_SESSION['is_admin'] = $row['is_admin'];  // <-- for admin

        		header("Location: Catalogue-page.php");
                exit();

            } 
            else {
            $error = "Invalid username or password";            }
        } 
        else {
              $error = "User not found";
        }
    }
}
mysqli_close($db_conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link href="../PartsOfPage/PartsOfPage.css" rel="stylesheet">
    <link href="../CssOfPages/LogBody.css" rel="stylesheet">
    <title>Log In</title>
</head>
<body>
<div class="head-nav">
    <?php include("../PartsOfPage/header.php"); ?>
    <?php include("../PartsOfPage/nav.php"); ?>
</div>
<main>
    <div id="log-in-centered">
        <h1>Log In</h1>


        <div id="aboveform">
            <p>Don't have account?</p><a href="Reg.php">Register</a>
        </div>

        <div id="form">
              <?php if (!empty($error)) : ?>
            <div style="background-color:#ffe0e0;
                        color:#b30000;
                        padding:10px 15px;
                        margin-bottom:15px;
                        font-size:0.9rem;
                        border-radius: 5px;">
        <?php print htmlspecialchars($error); ?></div>
        <?php endif; ?>
            <form action="<?php print htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
                <div class="form-group">
                    <label>Username</label><br>
                    <input type="text" name="username"><br>
                </div>
                <div class="form-group">
                    <label>Password</label><br>
                    <input type="password" name="password"><br>
                </div>
                <input type="submit" name="btn_submit" value="Log In">
            </form>
        </div>
    </div>
</main>
<?php include("../PartsOfPage/footer.php"); ?>

</body>

</html>

