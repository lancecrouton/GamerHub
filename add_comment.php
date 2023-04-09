<?php
session_start();
?>
<?php
if (!isset($_SERVER['HTTP_REFERER'])) {
    header('location: index.php');
    exit;
}
include('DB.php');

$postId = $_POST['postId'];
$author = $_POST['author'];
$comment = $_POST['comment'];

$sql = "INSERT INTO comments (postId, author, content) VALUES ($postId, '$author', '$comment')";
$conn->query($sql);

header("Location: comments.php?postId=$postId");
exit;
?>
