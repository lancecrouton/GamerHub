<?php
session_start();
?>
<?php
include('head.php');

include('DB.php');
?>

<head>
    <title>Gamer Hub - Recover Password</title>
    <link href="css/global.css" rel="stylesheet">
</head>


<?php
if (isset($_POST['email'])) {

    $email = $_POST['email'];
    $query = "SELECT * FROM accounts WHERE email = '$email'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        $new_password = generate_password();
        $hashedPassword = md5($new_password);

        $query = "UPDATE accounts SET password = '$hashedPassword' WHERE username = '{$user['username']}'";
        $conn->query($query);

        $_SESSION['new_password'] = $new_password;
    } else {
        echo "<p>Email not found.</p>";
    }
}

function generate_password()
{
    $characters = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    $password = "";
    for ($i = 0; $i < 10; $i++) {
        $password .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $password;
}

?>

<!DOCTYPE html>
<html>

<head>
    <title>Password Recovery</title>
    <link href="css/global.css" rel="stylesheet">
</head>

<body>
    <div class="passwordBox">
        <h1>Password Recovery</h1>
        <p>Enter your email and your correct password will be sent</p>
        <form action="send.php" name="emailForm" method="POST">
            <label for="email">Email Address:</label>
            <input type="email" id="email" name="email" placeholder="Enter email address">
            <button type="submit" name="send">Send</button>
        </form>
    </div>
</body>

</html>

<footer>
    <a id="backButton" href="logIn.php">Back</a>
</footer>

<?php
include 'foot.php';
?>