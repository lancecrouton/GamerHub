<?php
session_start();
?>
<?php
include('head.php');
include('DB.php');

if (!isset($_SESSION["username"])) {
    header("Location: logIn.php");
    exit();
}
?>

<head>
    <title>Gamer Hub - Change Password</title>
    <link href="css/global.css" rel="stylesheet">
</head>

<div class="breadcrumbs">
    <a href="index.php">Home</a>
    <span class="separator">/</span>
    <a href="account.php">Account</a>
    <span class="separator">/</span>
    <a href="accountSettings.php">Account Settings</a>
    <span class="separator">/</span>
    <span>Change Password</span>
</div>

<?php
if (!isset($_SESSION["username"])) {
    header("Location: logIn.php");
    exit();
}

$username = $_SESSION["username"];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $password = $_POST["password"];
    $confirm_password = $_POST["confirmPassword"];

    if ($password == $confirm_password) {
        $hashed_password = md5($password);
        $sql = "UPDATE accounts SET password='$hashed_password' WHERE username='$username'";
        if ($conn->query($sql) === TRUE) {
            echo "Password updated successfully";
        } else {
            echo "Error updating password: " . $conn->error;
        }
    } else {
        echo "Password and confirm password do not match";
    }
}

?>

<head>
    <title>Gamer Hub - Change Password</title>
    <link href="css/global.css" rel="stylesheet">
</head>

<body>
    <div class="changePasswordBox">
        <h1>Change Password</h1>
        <form id="passwordUpdateForm" action="changePassword.php" method="post">
            <label for="password">New Password:</label>
            <input type="password" id="password" name="password"><br>

            <label for="confirmPassword">Confirm Password:</label>
            <input type="password" id="confirmPassword" name="confirmPassword"><br>

            <button type="submit">Update Password</button>
        </form>
    </div>
    <script type="text/javascript" src="scripts/validatePasswordUpdate.js"></script>
</body>

<footer>
    <a id="backButton" href="accountSettings.php">Back</a>
</footer>

</html>
<?php
include 'foot.php';
$conn->close();
?>