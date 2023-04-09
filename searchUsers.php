<?php
session_start();
?>
<?php
include('head.php');
include('DB.php');

if (!isset($_SESSION["username"]) || $_SESSION['isAdmin'] != 1) {
  header("Location: logIn.php");
  exit();
}
?>

<head>
  <title>Gamer Hub - Search Users</title>
  <link href="css/global.css" rel="stylesheet">
</head>

<div class="breadcrumbs">
  <a href="index.php">Home</a>
  <span class="separator">/</span>
  <a href="adminPage.php">Admin Page</a>
  <span class="separator">/</span>
  <span>Search Users</span>
</div>
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $email = $_POST['email'];
  $username = $_POST['username'];
  $postId = $_POST['postId'];

  $sql = "SELECT accounts.*, posts.* FROM accounts LEFT JOIN posts ON accounts.username = posts.username WHERE 1=1";
  $params = array();

  if (!empty($email)) {
    $sql .= " AND accounts.email = ?";
    $params[] = $email;
  }
  if (!empty($username)) {
    $sql .= " AND accounts.username LIKE ?";
    $params[] = "%$username%";
  }
  if (!empty($postId)) {
    $sql .= " AND posts.postId = ?";
    $params[] = $postId;
  }

  $stmt = $conn->prepare($sql);

  if (!empty($params)) {
    $types = str_repeat("s", count($params));
    $stmt->bind_param($types, ...$params);
  }

  $stmt->execute();

  $result = $stmt->get_result();

  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      $username = htmlspecialchars($row["username"]);
      $email = htmlspecialchars($row["email"]);
      $img = htmlspecialchars($row["img"]);
      $isDisabled = $row["isDisabled"];

      echo "<div class='profile'>";
      echo "<h2>Username: $username</h2>";
      echo "<p>Email: $email</p>";
      echo "<p>Disabled(1)/Enabled(0): $isDisabled</p>";
      echo "<img id='userImage' src='uploads/$img'>";
      echo "</div>";
    }
  } else {
    echo "User not found";
  }

  $stmt->close();
  $conn->close();
}
?>

<!DOCTYPE html>
<html>

<head>
  <title>Gamer Hub - Search User</title>
  <link href="css/global.css" rel="stylesheet">
</head>

<body>
  <div class="searchUsersBox">
    <h1>User Search</h1>
    <form method="POST">
      <label for="email">Search User by Email</label>
      <input type="email" id="email" name="email" placeholder="janeDoe@gmail.com">
      <button type="submit">Search by Email</button>
    </form>
    <form method="POST">
      <label for="username">Search User by Username</label>
      <input type="text" id="username" name="username" placeholder="Jane Doe">
      <button type="submit">Search by Username</button>
    </form>
    <form method="POST">
      <label for="postId">Search User by Post Id</label>
      <input type="text" id="postId" name="postId" placeholder="123">
      <button type="submit">Search by Post Id</button>
    </form>
  </div>
</body>

<footer>
  <a id="backButton" href="adminPage.php">Back</a>
</footer>

</html>

<?php
include 'foot.php';
?>