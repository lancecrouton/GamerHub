<?php
session_start();
?>
<?php
include('head.php');
?>

<!DOCTYPE html>
<html>

<head>
  <title>Gamer Hub - Create Post</title>
  <link href="css/global.css" rel="stylesheet">
</head>

<body>
  <?php
  include('DB.php');
  if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
    $postContents = mysqli_real_escape_string($conn, $_POST['postContent']);
    $username = $_SESSION['username'];

    if (isset($_POST['category']) && $_POST['category'] != '') {
      $categoryId = mysqli_real_escape_string($conn, $_POST['category']);
    } else {
      $categoryId = null;
    }


    $query = "SELECT MAX(postId) as maxPostId FROM posts";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    $postId = $row['maxPostId'] + 1;
    $dateCreated = date("Y-m-d H:i:s");
    $query = "INSERT INTO posts (postId, postContents, categoryId, username, dateCreated) VALUES ('$postId', '$postContents', '$categoryId', '$username', '$dateCreated')";
    $result = mysqli_query($conn, $query);

    if ($result) {
      echo "Post created successfully!";
      header("Location: index.php");
    } else {
      echo "Error: " . mysqli_error($conn);
    }
  }

  $query = "SELECT categoryName, categoryId FROM categories";
  $result = mysqli_query($conn, $query);
  $categories = array();
  while ($row = mysqli_fetch_assoc($result)) {
    $categories[] = $row;
  }
  mysqli_close($conn);
  ?>
  <section class="postBody">
    <form method="post" action="createPost.php">
      <label for="postContent">Create Post:</label><br>
      <textarea id="postContent" name="postContent" required></textarea><br>

      <label for="category">Select Category:</label><br>
      <select id="category" name="category" required>
        <option value="">--Select a Category--</option>
        <?php foreach ($categories as $category) : ?>
          <option value="<?= $category['categoryId'] ?>"><?= $category['categoryName'] ?></option>
        <?php endforeach; ?>
      </select><br>

      <button type="submit">Submit</button>
    </form>
  </section>

  <footer>
    <a id="backButton" href="index.php">Back</a>
  </footer>
  </main>
</body>

</html>


<?php
include 'foot.php';
?>