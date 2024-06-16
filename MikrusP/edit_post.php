<!DOCTYPE html>
<html>
<head>
    <title>Strona główna</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <?php
    $username = $_SESSION['username'] ?? 'guest';
   ?>
    <header>
        <h1>Blog</h1>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="add_post.php">Dodaj wpis</a></li>
                <li><a href="edit_post.php">Edytuj wpis</a></li>
                <li><a href="delete_post.php">Usuń wpis</a></li>
                <li><a href="logout.php">Wyloguj</a></li>
                <li><a href="contact.php">Kontakt</a></li>
            </ul>
        </nav>
    </header>

    <?php
    echo "<center>";
    session_start();
    if (!isset($_SESSION['username'])) {
        echo "Nie masz uprawnień do edycji wpisów.";
        exit();
    }
    if ($_SESSION['UserType'] !== 'administrator' && $_SESSION['UserType'] !== 'autor_bloga') {
        echo "Nie masz uprawnień do edycji wpisów.";
        exit();
    }

    $servername = "frog01.mikr.us";
    $username = "f12229";
    $password = "nwWjIhe9D0";
    $dbname = "db_f12229";
    
    
    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $postID = $_POST['post_id'];
        $title = $_POST['title'];
        $content = $_POST['content'];

        if (empty($title) || empty($content) || strlen($content) < 50) {
            echo "Tytuł nie może być pusty, a treść musi zawierać przynajmniej 50 znaków.";
            exit();
        }

        $image = null;
        if ($_FILES['image']['size'] > 0) {
            $image = $_FILES['image']['name'];
            $image_tmp = $_FILES['image']['tmp_name'];
            move_uploaded_file($image_tmp, "images/" . $image);
        }

        $userID = $_SESSION['user_id'];
        $sql_check_owner = "SELECT * FROM posts";
        $result_check_owner = $conn->query($sql_check_owner);

        if ($result_check_owner->num_rows > 0) {

            $sql_update = "UPDATE posts SET Title='$title', Content='$content', Image='$image' WHERE PostID='$postID'";
            if ($conn->query($sql_update) === TRUE) {
                echo "Wpis został zaktualizowany pomyślnie!";
            } else {
                echo "Błąd podczas aktualizacji wpisu: " . $conn->error;
            }
        } else {

            echo "Nie masz uprawnień do edycji tego wpisu.";
        }
    }


    $userID = $_SESSION['user_id'];
    $sql_posts = "SELECT PostID, Title FROM posts";
    $result_posts = $conn->query($sql_posts);
    ?>


    <h2 style="text-align: center;">Edytuj wpis</h2>
    <form action="<?php $_SERVER["PHP_SELF"]; ?>" method="post" enctype="multipart/form-data">
        <label for="post_id">Wybierz wpis do edycji:</label><br>
        <select id="post_id" name="post_id">
            <?php
            if ($result_posts->num_rows > 0) {
                while ($row = $result_posts->fetch_assoc()) {
                    echo "<option value='" . $row['PostID'] . "'>" . $row['Title'] . "</option>";
                }
            }
            ?>
        </select><br><br>

        <label for="title">Nowy tytuł:</label><br>
        <input type="text" id="title" name="title" required><br><br>

        <label for="content">Nowa treść:</label><br>
        <textarea id="content" name="content" rows="4" cols="50" required minlength="50"></textarea><br><br>

        <label for="image">Nowy obrazek:</label><br>
        <input type="file" id="image" name="image"><br><br>

        <input type="submit" value="Zapisz zmiany">
    </form
>
</body>
</html>

<?php
$conn->close();
?>
