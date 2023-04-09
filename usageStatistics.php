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
  <title>Gamer Hub - Usage Statistics</title>
  <link href="css/global.css" rel="stylesheet">
</head>

<div class="breadcrumbs">
  <a href="index.php">Home</a>
  <span class="separator">/</span>
  <span>Usage Statistics</span>
</div>

<!DOCTYPE html>
<html>

<head>
  <title>Gamer Hub - Usage Statistics</title>
  <link href="css/global.css" rel="stylesheet">
</head>

<body>
  <div class="adminPageBox">
    <h1>Usage Statistics<h1>
        <a id="categoryStatistics" href="categoryStatistics.php">Category Statistics</a>
        <a id="userStatistics" href="userStatistics.php">User Statistics</a>
        <a id="postStatistics" href="postStatistics.php">Post Statistics</a>
        <a id="trendingStatistics" href="trendingStatistics.php">Trending Statistics</a>
  </div>
</body>

<footer>
  <a id="backButton" href="adminPage.php">Back</a>
</footer>

</html>
<?php
include 'foot.php';
?>