<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['UserType'] != 'autor_bloga') {
    header('Location: login.php');
    exit;
}
echo "<center>";

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "blog";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql_messages = "SELECT * FROM Contact ORDER BY DateAdded DESC";
$result_messages = $conn->query($sql_messages);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Wiadomości</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <header>
        <h1>Wiadomości od użytkowników</h1>
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
                <li><a href="messages.php">Wiadomości</a></li>
            </ul>
        </nav>
    </header>

    <main>
    <?php
    if ($result_messages->num_rows > 0) {
        echo "<table border='1'>";
        echo "<tr><th>ID</th><th>Name</th><th>Email</th><th>Message</th><th>Date Added</th></tr>";
        while ($row = $result_messages->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['ID'] . "</td>";
            echo "<td>" . $row['Name'] . "</td>";
            echo "<td>" . $row['Email'] . "</td>";
            echo "<td>" . $row['Message'] . "</td>";
            echo "<td>" . $row['DateAdded'] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "Brak wiadomości.";
    }

    $conn->close();
    ?>
    </main>
</body>
</html>
