<?php
session_start();


$_SESSION['username'] = $row['guest'];
$_SESSION['UserType'] = $row['guest'];



header("Location: login.php");
exit();
?>
