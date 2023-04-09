<?php
session_start();
?>
<?php
include('head.php');

if (!isset($_SESSION["username"]) || $_SESSION['isAdmin'] != 1) {
  header("Location: logIn.php");
  exit();
}
?>

<head>
  <title>Gamer Hub - Manage Posts</title>
  <link href="css/global.css" rel="stylesheet">
</head>

<div class="breadcrumbs">
  <a href="index.php">Home</a>
  <span class="separator">/</span>
  <a href="adminPage.php">Admin Page</a>
  <span class="separator">/</span>
  <span>Manage Posts</span>
</div>

<?php
include('DB.php');

if (isset($_POST['submit'])) {
  $postId = $_POST['postId'];

  if ($_POST['action'] == 'delete') {
    $sql = "DELETE FROM posts WHERE postId=$postId";
    if ($conn->query($sql) === TRUE) {
      echo "Post deleted successfully.";
    } else {
      echo "Error deleting post: " . $conn->error;
    }
  } else if ($_POST['action'] == 'edit') {
    $postContents = $_POST['postContents'];
    $sql = "UPDATE posts SET postContents='$postContents' WHERE postId=$postId";
    if ($conn->query($sql) === TRUE) {
      echo "Post updated successfully.";
    } else {
      echo "Error updating post: " . $conn->error;
    }
  }
}

$sql = "SELECT * FROM posts";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>

<head>
  <title>Edit/Delete Posts</title>
</head>

<body>
  <h1 class="managePostsTitle">Edit/Delete Posts</h1>

  <?php
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      echo "<form class='managePostBox' method='post'>";
      echo "Post ID: " . $row["postId"] . "<br>";
      echo "Category ID: " . $row["categoryId"] . "<br>";
      echo "Username: " . $row["username"] . "<br>";
      echo "Date Created: " . $row["dateCreated"] . "<br>";
      echo "Post Contents: <br>";
      echo "<textarea name='postContents'>" . $row["postContents"] . "</textarea><br>";
      echo "<input type='hidden' name='postId' value='" . $row["postId"] . "'>";
      echo "<input type='hidden' name='submit' value='1'>";
      echo "<button type='submit' name='action' value='edit'>Edit</button>";
      echo "<button type='submit' name='action' value='delete'>Delete</button>";
      echo "</form><hr>";
    }
  } else {
    echo "No posts found.";
  }
  ?>
  <style>
    <?php
    include 'css/global.css';
    ?>
  </style>
</body>

<footer>
  <a id="backButton" href="adminPage.php">Back</a>
</footer>

</html>

<?php
include 'foot.php';
?>