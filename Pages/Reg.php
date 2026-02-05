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
//Registration logic and error handling
$error = "";
if ($_SERVER["REQUEST_METHOD"] === "POST") {
	$username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_SPECIAL_CHARS);
	$password = $_POST["password"] ?? "";
	$email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);
	$email = filter_var($email, FILTER_VALIDATE_EMAIL);

	if (empty($username)) {
		$error = "Username is missing";
	} elseif (empty($password)) {
		$error = "Password is missing";
	} elseif (empty($email)) {
		$error = "Email is missing";
	} else {
		$sql_usname = "SELECT name FROM users WHERE name = '$username'";
		$username_db = mysqli_query($db_conn, $sql_usname);
		if (mysqli_num_rows($username_db) == 0) {
			$hash = password_hash($password, PASSWORD_DEFAULT);
			$sql = "INSERT INTO users(name, email, password) VALUES('$username', '$email', '$hash')";
			mysqli_query($db_conn, $sql);

			$user_id = mysqli_insert_id($db_conn);
 			$_SESSION['user_id'] = $user_id;
            $_SESSION['username'] = $username;

			header("Location: Catalogue-page.php");
			exit();
		} else {
			$error = "This username is already taken!";

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
	<link href="../CssOfPages/RegBody.css" rel="stylesheet">
	<title>Register</title>
</head>

<body>

	<div class="head-nav">
		<?php include("../PartsOfPage/header.php"); ?>
		<?php include("../PartsOfPage/nav.php"); ?>
	</div>
	<main>
		<div id="Reg-center">
			<h1>Register</h1>

			<div id="aboveform">
				<p>Already have account?</p><a href="Log-in.php">Log in</a>
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
					<div class="form-group">
						<label>Email</label><br>
						<input type="email" name="email"><br>
					</div>

					<input type="submit" name="btn_submit" value="Register">
				</form>
			</div>
		</div>
	</main>

	<?php include("../PartsOfPage/footer.php"); ?>
</body>

</html>
