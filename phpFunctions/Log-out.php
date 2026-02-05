<?php
$session_lifetime = 8 * 60 * 60; // 8 hours

// Set PHP session cookie lifetime
ini_set('session.cookie_lifetime', $session_lifetime);
ini_set('session.gc_maxlifetime', $session_lifetime);

session_set_cookie_params($session_lifetime);
session_start();

session_unset();
session_destroy();
header("Location: ../Pages/index.php");
exit();
?>