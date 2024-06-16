<?php
session_start();
setcookie('login_time', time(), time() + (86400 * 30), "/");
$_SESSION['username'] = $row['guest'];
$_SESSION['UserType'] = $row['guest'];



header("Location: login.php");
exit();
?>
