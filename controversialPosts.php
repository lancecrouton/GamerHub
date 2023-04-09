<?php
session_start();
?>
<?php
include('DB.php');
include('head.php');
?>
<script>
    function addLike(postId) {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                alert(this.responseText);
            }
        }
        xmlhttp.open("GET", "addlike.php?q=" + postId, true);
        xmlhttp.send();
    }
</script>

<head>
    <title>Gamer Hub - Controversial Posts</title>
    <link href="css/global.css" rel="stylesheet">
</head>


<div class="breadcrumbs">
    <a href="index.php">Home</a>
    <span class="separator">/</span>
    <span>Controversial Posts</span>
</div>

<?php
$sql = "SELECT posts.*, COUNT(comments.postId) AS commentCount, accounts.img
FROM posts
LEFT JOIN comments ON posts.postId = comments.postId
LEFT JOIN accounts ON posts.username = accounts.username
GROUP BY posts.postId, posts.postContents, posts.categoryId, posts.username, posts.dateCreated, posts.likeCount, posts.likes, accounts.img
ORDER BY commentCount DESC
LIMIT 10";
$stmt = $conn->prepare($sql);
$stmt->execute();
$results = $stmt->get_result();


while ($row = $results->fetch_assoc()) {
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
    echo "<p>Comment count: " . $row['commentCount'] . "</p>";
    if (isset($_SESSION['username'])) {
        echo '<a href="#" onclick="addLike(' . $postId . ')">
        <div class="likeButton">
        <div class="heartBg">
          <div class="heartIcon"></div>
          </div>
        <div class="likeAmount">Like</div>
        
      </div>
        
        </a>';
    }
    echo '</article>';
}




mysqli_close($conn);
?>
<footer>
    <a id="backButton" href="index.php">Back</a>
</footer>

</html>
<?php
include 'foot.php';
$conn->close();
?>