<?php
session_start();
?>
<?php
if (!isset($_SERVER['HTTP_REFERER'])) {
    header('location: index.php');
    exit;
}
include('DB.php');


$username = $_SESSION['username'];
$postId = $_GET['q'];

$sql = "SELECT * FROM likes WHERE postId = ? AND username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('is', $postId, $username);
$stmt->execute();
$results = $stmt->get_result();

if ($results->num_rows == 0) {
    $sql = "UPDATE posts SET likeCount = likeCount + 1 WHERE postId = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $postId);
    $stmt->execute();

    $sql = "INSERT INTO likes (postId, username) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('is', $postId, $username);
    $stmt->execute();

    $response = 'Liked';
} else {
    $response = 'Already Liked';
}

mysqli_close($conn);

echo $response;
?>