<?php
session_start();
include('head.php');

?>
<!DOCTYPE html>
<html>
<head>
    <title>Gamer Hub - Comment History</title>
	<link href="css/global.css" rel="stylesheet">
</head>
<body>

<div class="breadcrumbs">
    <a href="index.php">Home</a>
    <span class="separator">/</span>
    <a href="account.php">Account</a>
    <span class="separator">/</span>
    <span>Post History</span>
</div>

    <?php

    

    include('DB.php');
    if (!isset($_SESSION['username'])) {
        header('Location: login.php');
        exit();
    }

    $username = $_SESSION['username'];

    $query = "SELECT * FROM posts WHERE username = ?";
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
        <h1>Post History</h1>
        <p>Here are all the posts you've posted on the website:</p>

        <table>
            <thead>
                <tr>
                    <th>Post ID</th>
                    <th>Post</th>
                    <th>Date Created</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($rows as $row) { ?>
                    <tr>
                        
                    <td><?php echo '<a href="comments.php?postId=' . $row['postId'] . '">' . $row['postId'] . '</a>';?></td>
                        <td><?php echo $row['postContents']; ?></td>
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