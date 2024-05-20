<!DOCTYPE html>
<html>
<head>
    <title>Strona główna</title>
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
    session_start();
    echo "<center>";

    if ($_SESSION['UserType'] !== 'administrator' && $_SESSION['UserType'] !== 'autor_bloga') {
        echo "Nie masz uprawnień do dodawania wpisów.";
        exit();
    }
    ?>

    <h2 style="text-align: center;">Dodaj nowy wpis</h2>
     <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post" enctype="multipart/form-data">
        <label for="title">Tytuł:</label><br>
        <input type="text" id="title" name="title" required><br><br>
        
        <label for="content">Treść (minimum 50 znaków):</label><br>
        <textarea id="content" name="content" rows="4" cols="50" minlength="50" required></textarea><br><br>
        
        <label for="image">Obrazek:</label><br>
        <input type="file" id="image" name="image"><br><br>
        
        <input type="submit" value="Dodaj wpis">
    </form>

    <?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "blog";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $title = $_POST['title'];
        $content = $_POST['content'];
        $image = null;

        if (strlen($content) < 50) {
            echo "Treść wpisu musi zawierać co najmniej 50 znaków.";
            exit();
        }
        
        if ($_FILES['image']['size'] > 0) {
            $image = $_FILES['image']['name'];
            $image_tmp = $_FILES['image']['tmp_name'];
            move_uploaded_file($image_tmp, "images/" . $image);
        }
      
        $userID = $_SESSION['user_id'];

        $sql = "INSERT INTO Posts (UserID, Title, Content, Image) VALUES ('$userID', '$title', '$content', '$image')";

        if ($conn->query($sql) === TRUE) {
            echo "Wpis został dodany pomyślnie!";
        } else {
            echo "Błąd podczas dodawania wpisu: " . $conn->error;
        }
    }

    $conn->close();
    ?>
</body>
</html>
