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

$post_id = $_GET['post_id'];

$sql_current_post = "SELECT * FROM Posts WHERE PostID = $post_id";
$result_current_post = $conn->query($sql_current_post);
$row_current_post = $result_current_post->fetch_assoc();

$sql_prev_post_id = "SELECT PostID FROM Posts WHERE PostID < $post_id ORDER BY PostID DESC LIMIT 1";
$sql_next_post_id = "SELECT PostID FROM Posts WHERE PostID > $post_id ORDER BY PostID ASC LIMIT 1";

$result_prev_post_id = $conn->query($sql_prev_post_id);
$result_next_post_id = $conn->query($sql_next_post_id);

$row_prev_post_id = $result_prev_post_id->fetch_assoc();
$row_next_post_id = $result_next_post_id->fetch_assoc();

$prev_post_id = isset($row_prev_post_id['PostID']) ? $row_prev_post_id['PostID'] : null;
$next_post_id = isset($row_next_post_id['PostID']) ? $row_next_post_id['PostID'] : null;

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_comment'])) {
    $comment_text = $_POST['comment_text'];
    $username = $_SESSION['username'] ?? 'guest';

    $sql_insert_comment = "INSERT INTO Comments (PostID, CommentText, DateAdded, Username) VALUES ('$post_id', '$comment_text', NOW(), '$username')";

    if ($conn->query($sql_insert_comment) === TRUE) {
        header('Location: ' . $_SERVER['PHP_SELF'] . '?post_id=' . $post_id);
        exit;
    } else {
        echo "Błąd: " . $sql_insert_comment . "<br>" . $conn->error;
    }
}
echo "<center>";
$sql_comments = "SELECT Comments.*, Users.Avatar FROM Comments INNER JOIN Users ON Comments.Username = Users.Username WHERE Comments.PostID = $post_id ORDER BY Comments.DateAdded DESC";
$result_comments = $conn->query($sql_comments);

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <title>Full Post</title>
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
        </ul>
    </nav>
</header>
    
<h2><?php echo $row_current_post['Title']; ?></h2>
<p><?php echo chunk_split($row_current_post['Content'], 100, "<br>"); ?></p>

<?php if (!empty($row_current_post['Image'])):?>
    <img src="images/<?php echo $row_current_post['Image']; ?>" width="500px" height="500px">
<?php endif; ?>
<?php echo "<br>"; if ($prev_post_id !== null): ?>
    <a style="font-size:24px;color:red; margin-right: 20px;" href="full_post.php?post_id=<?php echo $prev_post_id; ?>">Previous</a>
<?php endif; ?>

<?php if ($next_post_id !== null): ?>
    <a style="font-size:24px;color:red;" href="full_post.php?post_id=<?php echo $next_post_id; ?>">Next</a>
<?php endif; ?>


<h3>Komentarze:</h3>
<?php if ($result_comments->num_rows > 0): ?>
    <?php while ($row_comment = $result_comments->fetch_assoc()): ?>
        <div class="comment">
            <img src="<?php echo $row_comment['Avatar']; ?>" alt="Avatar" width="50" height="50">
            <p>Komentarz dodany <?php echo $row_comment['DateAdded']; ?> przez <?php echo $row_comment['Username']; ?>: <?php echo $row_comment['CommentText']; ?></p>
        </div>
    <?php endwhile; ?>
<?php else: ?>
    <p>Brak komentarzy.</p>
<?php endif; ?>

<h3>Dodaj komentarz:</h3>
<form method="POST" action="">
    <textarea name="comment_text" required></textarea><br>
    <input type="submit" name="add_comment" value="Dodaj komentarz">
</form>
</body>
</html>
