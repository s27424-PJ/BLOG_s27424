<!DOCTYPE html>
<html>
<head>
    <title>Rejestracja</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
<header>
    <h1>Blog</h1>
    <nav>
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="add_post.php">Dodaj wpis</a></li>
            <li><a href="edit_post.php">Edytuj wpis</a></li>
            <li><a href="delete_post.php">Usuń wpis</a></li>
            <li><a href="login.php">Login</a></li>
            <li><a href="register.php">Rejestracja</a></li>
            <li><a href="logout.php">Wyloguj</a></li>
        </ul>
    </nav>
</header>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "blog";

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    echo"<center>";
    $username = $conn->real_escape_string($_POST['username']);
    $password = $_POST['password'];

    $avatar = $_FILES['avatar']['name'];
    $tempAvatar = $_FILES['avatar']['tmp_name'];

    if (strlen($password) < 8 || !preg_match("/[A-Z]/", $password) || !preg_match("/[a-z]/", $password) || !preg_match("/[0-9]/", $password) || !preg_match("/[\W]/", $password)) {
        echo "Hasło musi mieć co najmniej 8 znaków, zawierać co najmniej jedną wielką literę, jedną małą literę, jedną cyfrę i jeden znak specjalny.";
    } else {
        $sql_check_user = "SELECT * FROM Users WHERE Username='$username'";
        $result_check_user = $conn->query($sql_check_user);
        
        if ($result_check_user->num_rows > 0) {
            echo "Nazwa użytkownika już istnieje. Wybierz inną nazwę.";
        } else {
            $avatarPath = "avatars/" . $username . "_" . $avatar;
            move_uploaded_file($tempAvatar, $avatarPath);

            $passwordHash = password_hash($password, PASSWORD_DEFAULT);
            $userType = "użytkownik"; 

            $sql = "INSERT INTO Users (Username, Password, Avatar, UserType) VALUES ('$username', '$passwordHash', '$avatarPath', '$userType')";
            if ($conn->query($sql) === TRUE) {
                echo "Rejestracja przebiegła pomyślnie!";
            } else {
                echo "Błąd podczas rejestracji: " . $conn->error;
            }
        }
    }

    $conn->close();
}
?>


<h2 style="text-align: center;">Rejestracja</h2>
<form method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>" enctype="multipart/form-data">
    <label for="username">Nazwa użytkownika:</label><br>
    <input type="text" id="username" name="username" required><br>
    <label for="password">Hasło:</label><br>
    <input type="password" id="password" name="password" required><br>
    <label for="avatar">Wybierz avatar:</label><br>
    <input type="file" id="avatar" name="avatar" accept="image/*" required><br><br>
    <input type="submit" value="Zarejestruj">
</form>
</body>
</html>
