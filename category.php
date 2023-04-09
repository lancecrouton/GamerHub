<?php
session_start();
?>
<?php
include('DB.php');
include('head.php');
?>



<head>
    <title>Gamer Hub - Categories</title>
    <link href="css/global.css" rel="stylesheet">
    <script>
        const likeButton = document.querySelector('.likeButton');
        const heartIcon = document.querySelector('.heartIcon');

        likeButton.addEventListener('click', () => {
            heartIcon.classList.toggle('clicked');
        });
    </script>
</head>

<div class="breadcrumbs">
    <a href="index.php">Home</a>
    <span class="separator">/</span>
    <span>Categories</span>
</div>

<?php
if (isset($_GET['categoryId'])) {
    $categoryId = $_GET['categoryId'];

    $stmt = $conn->prepare("SELECT categoryName FROM categories WHERE categoryId=?");
    $stmt->bind_param("i", $categoryId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $categoryName = $row["categoryName"];
        }
    }
}

$query = "SELECT posts.postContents, posts.username, posts.dateCreated, posts.likeCount, categories.categoryName, posts.postId, accounts.img
FROM posts JOIN categories ON posts.categoryId = categories.categoryId 
JOIN accounts ON posts.username = accounts.username
WHERE categories.categoryId = ? ORDER BY dateCreated DESC";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $categoryId);
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

$stmt->close();
mysqli_close($conn);
?>
<footer>
    <a id="backButton" href="index.php">Back</a>
</footer>
<?php
include('foot.php');
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