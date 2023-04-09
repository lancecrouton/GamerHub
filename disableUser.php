<?php
session_start();
include('head.php');
include('DB.php');
?>

<head>
  <title>Gamer Hub - Disable/Enable User</title>
  <link href="css/global.css" rel="stylesheet">
</head>

<div class="breadcrumbs">
  <a href="index.php">Home</a>
  <span class="separator">/</span>
  <a href="adminPage.php">Admin Page</a>
  <span class="separator">/</span>
  <span>Disable/Enable User</span>
</div>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $username = $_POST['username'];
  $isDisabled = intval($_POST['isDisabled']);

  $sql = "UPDATE accounts SET isDisabled = ? WHERE username = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("is", $isDisabled, $username);
  $stmt->execute();

  if ($stmt->affected_rows > 0) {
    echo "User has been updated";
  } else {
    echo "No user updated";
  }

  $stmt->close();
  $conn->close();
}
?>

<!DOCTYPE html>
<html>

<head>
  <title>Gamer Hub - Disable/Enable User</title>
  <link href="css/global.css" rel="stylesheet">
</head>

<body>
  <div class="disableUserBox">
    <h1>Disable/Enable User</h1>
    <form method="POST">
      <label for="username">User Name:</label>
      <input type="text" id="username" name="username" placeholder="Enter User Name">
      <label for="isDisabled">Is Disabled?</label>
      <select id="isDisabled" name="isDisabled">
        <option value="0">No</option>
        <option value="1">Yes</option>
      </select>
      <button type="submit">Update User</button>
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