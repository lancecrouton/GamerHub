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
$username = $_POST['username'];

$check_query = "SELECT * FROM likes WHERE postId = ? AND username = ?";
$check_stmt = $conn->prepare($check_query);
$check_stmt->bind_param("is", $postId, $username);
$check_stmt->execute();
$check_result = $check_stmt->get_result();

if ($check_result->num_rows > 0) {
    echo json_encode(array('status' => 'error', 'message' => 'You have already liked this post.'));
} else {
    $insert_query = "INSERT INTO likes (postId, username) VALUES (?, ?)";
    $insert_stmt = $conn->prepare($insert_query);
    $insert_stmt->bind_param("is", $postId, $username);

    if ($insert_stmt->execute()) {
        $update_query = "UPDATE posts SET likeCount = likeCount + 1 WHERE postId = ?";
        $update_stmt = $conn->prepare($update_query);
        $update_stmt->bind_param("i", $postId);
        $update_stmt->execute();

        $count_query = "SELECT likeCount FROM posts WHERE postId = ?";
        $count_stmt = $conn->prepare($count_query);
        $count_stmt->bind_param("i", $postId);
        $count_stmt->execute();
        $count_result = $count_stmt->get_result();
        $likeCount = $count_result->fetch_assoc()['likeCount'];

        echo json_encode(array('status' => 'success', 'message' => 'Post liked.', 'likeCount' => $likeCount));
    } else {
        echo json_encode(array('status' => 'error', 'message' => 'Error liking post.'));
    }
}

$insert_stmt->close();
$check_stmt->close();
$count_stmt->close();
$update_stmt->close();
mysqli_close($conn);
?>
