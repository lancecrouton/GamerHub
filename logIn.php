<?php
session_start();
?>
<?php
include('head.php');
?>

<head>
    <title>Gamer Hub - Log In</title>
    <link href="css/global.css" rel="stylesheet">
</head>

<div class="breadcrumbs">
    <a href="index.php">Home</a>
    <span class="separator">/</span>
    <span>Log In</span>
</div>

<!DOCTYPE html>
<html>

<head>
    <title>Gamer Hub - Login</title>
    <link href="css/global.css" rel="stylesheet">
</head>

<body>

    <?php
    include('DB.php');
    if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'POST') {


        $user = $_POST['username'];
        $pass = md5($_POST['password']);

        $stmt = $conn->prepare("SELECT * FROM accounts WHERE username=? AND password=?");
        $stmt->bind_param("ss", $user, $pass);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if ($row['isDisabled'] == 1) {
                echo '<script>alert("User Disabled")</script>';
            } else {
                $_SESSION['username'] = $user;
                header("Location: index.php");
            }
        } else {
            echo "Invalid username or password.";
        }
        mysqli_free_result($results);
        mysqli_close($conn);
    }
    ?>

    <div class="loginBox" title="Login Form">
        <h1>Login</h1>
        <form class="loginForm" method="post">
            <label for="username">Username:</label>
            <input type="text" name="username" id="username" required>
            <label for="password">Password:</label>
            <input type="password" name="password" id="password" required>
            <button type="submit" title="Login">Login</button>
        </form>
        <div class="additionalOptions" role="navigation">
            <a id="createAccount" href="createAccount.php" aria-label="Create an Account">Create an Account</a>
            <a id="recoverPassword" href="recoverPassword.php" aria-label="Recover Password">Recover Password</a>
        </div>
    </div>
</body>

</html>
<?php
include 'foot.php';
?>