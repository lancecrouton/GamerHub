<?php
session_start();
?>
<?php
if (!isset($_SERVER['HTTP_REFERER'])) {
    header('location: index.php');
    exit;
}
include('DB.php');

if (isset($_GET['query'])) {
    $query = '%' . mysqli_real_escape_string($conn, $_GET['query']) . '%';

    $stmt = $conn->prepare("SELECT posts.*, categories.categoryName, accounts.img FROM posts JOIN categories ON posts.categoryId = categories.categoryId JOIN accounts ON posts.username = accounts.username WHERE postContents LIKE ?");
    $stmt->bind_param("s", $query);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $postContents = $row['postContents'];
        $username = $row['username'];
        $dateCreated = $row['dateCreated'];
        $categoryName = $row['categoryName'];
        $postId = $row['postId'];
        $img = $row['img'];
        $likes = $row['likeCount'];

        echo '<article class="post" data-post-id="' . $postId . '">';
        echo '<a href="comments.php?postId=' . $postId . '">';
        echo '<h2>' . $postContents . '</h2>';
        echo '</a>';
        echo '<figure>';
        echo '<img id="profilePicture" width="100px" src="' . "uploads/" . $img . '" alt="Profile Picture">';
        echo '</figure>';
        echo '<p class="post-meta">';
        echo 'Posted by <strong>' . $username . '</strong> in <strong>' . $categoryName . '</strong> on <time>' . $dateCreated . '</time>';
        if ($likes > 1) {
            echo ', ' . $likes . ' people liked this post';
        }
        if ($likes == 1) {
            echo ', ' . $likes . ' person liked this post';
        }
        echo '</p>';
        if (isset($_SESSION['username'])) {
            echo '<a href="#" onclick="addLike(' . $postId . ')">Like</a>';
        }
        echo '</article>';
    }

    $stmt->close();
}

mysqli_close($conn);
