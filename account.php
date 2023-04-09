<?php
session_start();
?>
<?php
include('head.php');
include('DB.php');
?>

<head>
    <title>Gamer Hub - Account</title>
    <link href="css/global.css" rel="stylesheet">
</head>

<div class="breadcrumbs">
    <a href="index.php">Home</a>
    <span class="separator">/</span>
    <span>Account</span>
</div>
<?php
if (!isset($_SESSION["username"])) {
    header("Location: logIn.php");
    exit();
}

$username = $_SESSION["username"];

$stmt = $conn->prepare("SELECT username, email, img FROM accounts WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $username = $row["username"];
        $email = $row["email"];
        $img = $row["img"];

        echo "<div class='profile'>";
        echo "<h2>Username: $username</h2>";
        echo "<p>Email: $email</p>";
        echo "<img src='uploads/$img' alt='Profile picture'> <br>";
        echo "<a href=accountSettings.php>Account Settings</a><br><br>";
        echo '<a id="postHistory" href=postHistory.php>Post History</a><br><br>';
        echo '<a id="commentHistory" href=commentHistory.php>Comment History</a><br><br>';
        echo "</div>";
    }
} else {
    echo "User not found";
}

$stmt->close();
$conn->close();
?>

<a id='backButton' href='index.php'>Back</a>
<?php
include 'foot.php';
?>