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
  <title>Gamer Hub - Admin Page</title>
  <link href="css/global.css" rel="stylesheet">
</head>

<div class="breadcrumbs">
  <a href="index.php">Home</a>
  <span class="separator">/</span>
  <span>Admin Page</span>
</div>

<!DOCTYPE html>
<html>

<head>
  <title>Gamer Hub - Admin Page</title>
  <link href="css/global.css" rel="stylesheet">
</head>

<body>
  <div class="adminPageBox">
    <h1>Admin Page<h1>
        <a id="searchUsers" href="searchUsers.php">Search Users</a>
        <a id="disableUsers" href="disableUser.php">Disable/Enable Users</a>
        <a id="managePosts" href="managePosts.php">Manage Posts</a>
        <a id="createCategory" href="createCategory.php">Create Category</a>
        <a id="usageStatistics" href="usageStatistics.php">Usage Statistics</a>
  </div>
</body>

<footer>
  <a id="backButton" href="index.php">Back</a>
</footer>

</html>
<?php
include 'foot.php';
?>