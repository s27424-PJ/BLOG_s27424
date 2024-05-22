<?php
session_start();


if (!isset($_SESSION['username'])) {
    $_SESSION['username'] = "guest";
    $_SESSION['UserType'] = "guest"; 
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "blog";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_comment'])) {
    $post_id = $_POST['post_id'];
    $comment_text = $_POST['comment_text'];
    $username = $_SESSION['username'];

    $sql_insert_comment = "INSERT INTO Comments (PostID, CommentText, DateAdded, Username) VALUES ('$post_id', '$comment_text', NOW(), '$username')";

    if ($conn->query($sql_insert_comment) === TRUE) {
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit;
    } else {
        echo "Błąd: " . $sql_insert_comment . "<br>" . $conn->error;
    }
}

$sql_posts = "SELECT * FROM Posts ORDER BY DatePublished DESC";
$result_posts = $conn->query($sql_posts);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Strona główna</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <style>
        .posts-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
        }
        .post-container {
            width: 30%;
            background-color: #fff;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .comment {
            display: flex;
            align-items: center;
            margin-top: 10px;
        }
        .comment img {
            margin-right: 10px;
            border-radius: 50%;
        }
    </style>
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
                <li><a href="contact.php">Kontakt</a></li>
                <?php if ($_SESSION['UserType'] == 'autor_bloga') { ?>
                    <li><a href="messages.php">Wiadomości</a></li>
                <?php } ?>
            </ul>
        </nav>
    </header>

    <main>
    <?php
    if ($result_posts->num_rows > 0) {
        echo '<div class="posts-container">';
        while ($row_post = $result_posts->fetch_assoc()) {
            echo "<div class='post-container'>";
            echo "<center>";
            echo "<h2>Tytuł: " . $row_post['Title'] . "</h2>";
            $short_content = substr($row_post['Content'], 0, strpos($row_post['Content'], '.') + 20) . " <span" . $row_post['PostID'] . "'>....więcej w opisie.....</span>";
            echo "<p>Treść: " . $short_content . "</p>";
            if (!empty($row_post['Image'])) {
                echo "<img width='200px' height='200px' src='images/" . $row_post['Image'] . "' alt='Obrazek wpisu'>";
            }
            echo "<p>Data publikacji wpisu: " . $row_post['DatePublished'] . "</p>";
            echo "<a style='font-size:20px;color:red;' href='full_post.php?post_id=" . $row_post['PostID'] . "'>Więcej</a>";
            $post_id = $row_post['PostID'];
            $sql_comments = "SELECT Comments.*, Users.Avatar FROM Comments INNER JOIN Users ON Comments.Username = Users.Username WHERE Comments.PostID = $post_id ORDER BY Comments.DateAdded DESC";
            $result_comments = $conn->query($sql_comments);

            if ($result_comments->num_rows > 0) {
                echo "<h3>Komentarze:</h3>";
                while ($row_comment = $result_comments->fetch_assoc()) {
                    echo "<div class='comment'>";
                    echo "<img src='" . $row_comment['Avatar'] . "' alt='Avatar' width='50' height='50'>";
                    echo "<p>Komentarz dodany " . $row_comment['DateAdded'] . " przez " . $row_comment['Username'] . ":<br> " . $row_comment['CommentText'] . "</p>";
                    echo "</div>";
                }
            } else {
                echo "</br><b>Brak komentarzy.</b>";
            }

            echo "<h3>Dodaj komentarz:</h3>";
            echo "<form method='POST' action=''>
                    <input type='hidden' name='post_id' value='" . $post_id . "'>
                    <textarea name='comment_text' required></textarea><br>
                    <input type='submit' name='add_comment' value='Dodaj komentarz'>
                  </form>";
            echo "</div>";
        }
        echo "</div>";
    } else {
        echo "Brak wpisów.";
    }

    $conn->close();
    ?>
    </main>
</body>
</html>
