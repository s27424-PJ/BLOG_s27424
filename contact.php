<?php
session_start();
echo "<center>";
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "blog";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $message = $_POST['message'];

    $sql = "INSERT INTO Contact (Name, Email, Message) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $name, $email, $message);

    if ($stmt->execute()) {
        $success = "Wysłano!";
    } else {
        $error = "Błąd";
    }

    $stmt->close();
}

$conn->close();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Kontakt</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <header>
        <h1>Kontakt</h1>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="add_post.php">Dodaj wpis</a></li>
                <li><a href="edit_post.php">Edytuj wpis</a></li>
                <li><a href="delete_post.php">Usuń wpis</a></li>
                <li><a href="login.php">Login</a></li>
                <li><a href="register.php">Rejestracja</a></li>
                <li><a href="logout.php">Wyloguj</a></li>
                <li><a href="contact.php">Kontakt</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <h2>Send a Message</h2>
        <?php if (isset($success)) echo "<p style='color: green;'>$success</p>"; ?>
        <?php if (isset($error)) echo "<p style='color: red;'>$error</p>"; ?>
        <form method="POST" action="contact.php">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required><br>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required><br>
            <label for="message">Message:</label>
            <textarea id="message" name="message" required></textarea><br>
            <input type="submit" value="Send Message">
        </form>
    </main>
</body>
</html>
