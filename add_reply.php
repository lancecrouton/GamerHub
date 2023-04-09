<?php
session_start();
?>
<?php
if (!isset($_SERVER['HTTP_REFERER'])) {
    header('location: index.php');
    exit;
}
include('DB.php');

$commentId = $_POST['commentId'];
$author = $_POST['author'];
$reply = $_POST['reply'];

$postId = $_POST['postId']; // Define postId here
$sql = "INSERT INTO commentreplies (commentId, author, content) VALUES ($commentId, '$author', '$reply')";
$conn->query($sql);

header("Location: comments.php?postId=$postId");
exit;

?>
