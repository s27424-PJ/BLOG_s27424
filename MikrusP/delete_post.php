<!DOCTYPE html>
<html>
<head>
    <title>Strona główna</title>
    <link rel="stylesheet" type="text/css" href="styles.css">

</head>
<body>
    <header>
        <h1 >Blog</h1>
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
session_start();
echo"<center>";
if (!isset($_SESSION['username'])) {
    echo "Nie masz uprawnień do usuwania wpisów.";
    exit();
}

if ($_SESSION['UserType'] !== 'administrator' && $_SESSION['UserType'] !== 'autor_bloga') {
    echo "Nie masz uprawnień do usuwania wpisów.";
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

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['post_id'])) {
    $postID = $_POST['post_id'];
    
    $sql_delete = "DELETE FROM posts WHERE PostID='$postID'";
    if ($conn->query($sql_delete) === TRUE) {
        echo "Wpis został usunięty pomyślnie!";
    } else {
        echo "Błąd podczas usuwania wpisu: " . $conn->error;
    }
}
$sql_posts = "SELECT PostID, Title FROM posts";
$result_posts = $conn->query($sql_posts);
?>


    <h2 style="text-align: center;"> Usuń wpis</h2>
    <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post">
        <label for="post_id">Wybierz wpis do usunięcia:</label><br>
        <select id="post_id" name="post_id">
            <?php
            if ($result_posts->num_rows > 0) {
                while ($row = $result_posts->fetch_assoc()) {
                    echo "<option value='" . $row['PostID'] . "'>" . $row['Title'] . "</option>";
                }
            }
            ?>
        </select><br><br>
        
        <input type="submit" value="Usuń wpis">
    </form>
</body>
</html>

<?php
$conn->close();
?>
