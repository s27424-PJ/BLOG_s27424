<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <title>Strona główna</title>
</head>
<body>
    <header>
        <h1>Blog</h1>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <?php 
                session_start();
                if (
                    (isset($_SESSION['UserType']) && ($_SESSION['UserType'] == 'autor_bloga' || $_SESSION['UserType'] == 'administrator')) &&
                    (isset($_SESSION['username']) && $_SESSION['username'] != 'guest')
                ) { 
                ?>
                    <li><a href="add_post.php">Dodaj wpis</a></li>
                    <li><a href="edit_post.php">Edytuj wpis</a></li>
                    <li><a href="delete_post.php">Usuń wpis</a></li>
                <?php } ?>
                <li><a href="login.php">Login</a></li>
                <li><a href="register.php">Rejestracja</a></li>
                <li><a href="logout.php">Wyloguj</a></li>
                <li><a href="contact.php">Kontakt</a></li>
            </ul>
        </nav>
        <div class="user-info" style="position: absolute; top: 10px; right: 10px;">
            <?php
            if (isset($_SESSION['username'])) {
                echo "<p>Zalogowany jako: " . $_SESSION['username'] . "</p>";
            } else {
                echo "Zalogowano jako: guest";
            }

         
            ?>
        </div>
    </header>

<?php
$servername = "frog01.mikr.us";
$username = "f12229";
$password = "nwWjIhe9D0";
$dbname = "db_f12229";




$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "<center>";

function login($username, $password, $conn) {
    $username = $conn->real_escape_string($username); 
    $sql = "SELECT * FROM users WHERE Username='$username'";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['Password'])) {
            $_SESSION['user_id'] = $row['UserID'];
            $_SESSION['username'] = $row['Username'];
            $_SESSION['UserType'] = $row['UserType']; 
            
            setcookie('login_time', time(), time() + (86400 * 30), "/");

            echo "Zalogowano pomyślnie!";
           
            header("Location: index.php");
            
        } else {
            echo "Nieprawidłowe hasło.";
        }
    } else {
        echo "Użytkownik o podanej nazwie nie istnieje.";
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $passwordHash = password_hash($password, PASSWORD_DEFAULT);
    login($username, $password, $conn);
}

$conn->close();
?>

    <h2 style="text-align: center;">Logowanie</h2>
    <form method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
        <label for="username">Nazwa użytkownika:</label><br>
        <input type="text" id="username" name="username"><br>
        <label for="password">Hasło:</label><br>
        <input type="password" id="password" name="password"><br><br>
        <input type="submit" value="Zaloguj">
    </form>
   
</body>
</html>
