<?php
session_start();
?>
<!DOCTYPE html>
<html>

<head>
    <title>Gamer Hub - Comment History</title>
    <link href="css/global.css" rel="stylesheet">
</head>

<div class="breadcrumbs">
    <a href="index.php">Home</a>
    <span class="separator">/</span>
    <a href="account.php">Account</a>
    <span class="separator">/</span>
    <span>Comment History</span>
</div>

<body>
    <?php

    include('DB.php');
    include('head.php');
    if (!isset($_SESSION['username'])) {
        header('Location: login.php');
        exit();
    }

    $username = $_SESSION['username'];

    $query = "SELECT * FROM comments WHERE author = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    $rows = array();
    while ($row = $result->fetch_assoc()) {
        $rows[] = $row;
    }
    ?>

    <div class="container">
        <h1>Comment History</h1>
        <p>Here are all the comments you've posted on the website:</p>

        <table>
            <thead>
                <tr>
                    <th>Post ID</th>
                    <th>Comment</th>
                    <th>Date Created</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($rows as $row) { ?>
                    <tr>
                        <td><?php echo $row['postId']; ?></td>
                        <td><?php echo $row['content']; ?></td>
                        <td><?php echo $row['dateCreated']; ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

        <footer>
            <a id="backButton" href="account.php">Back</a>
        </footer>
    </div>

    <?php
    include 'foot.php';
    ?>
</body>

</html>