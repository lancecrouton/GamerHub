<?php
session_start();
?>
<?php
include('head.php');
?>
<!DOCTYPE html>
<html>

<head>
  <title>Gamer Hub - Comments</title>
  <link href="css/global.css" rel="stylesheet">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>


<div class="breadcrumbs">
  <a href="index.php">Home</a>
  <span class="separator">/</span>
  <span>Comments</span>
</div>

<?php

include('DB.php');
$postId = $_GET['postId'];


$sql = "SELECT * FROM posts WHERE postId=$postId";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  $post = $result->fetch_assoc();
} else {
  echo "Post not found";
  exit;
}

$sql = "SELECT * FROM comments WHERE postId=$postId";
$result = $conn->query($sql);

$comments = [];

if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    $commentId = $row['id'];

    $sql = "SELECT * FROM commentreplies WHERE commentId=$commentId";
    $replyResult = $conn->query($sql);

    $replies = [];

    if ($replyResult->num_rows > 0) {
      while ($replyRow = $replyResult->fetch_assoc()) {
        $replies[] = $replyRow;
      }
    }

    $row['replies'] = $replies;

    $comments[] = $row;
  }
}
?>

<!DOCTYPE html>
<html>

<head>
  <title>Comments</title>
</head>

<body>
  <section class="commentBody">
    <h1>Comments</h1>
    <h2><?php echo $post['postContents'] ?></h2>
    <p>Posted by <?php echo $post['username'] ?> on <?php echo $post['dateCreated'] ?></p>
    <?php foreach ($comments as $comment) : ?>
      <hr>
      <p><strong><?php echo $comment['author'] ?>:</strong> <?php echo $comment['content'] ?></p>
      <p>Posted on <?php echo $comment['dateCreated'] ?></p>
      <form method="post" action="add_reply.php">
        <input type="hidden" name="postId" value="<?php echo $postId ?>">
        <input type="hidden" name="commentId" value="<?php echo $comment['id'] ?>">
        <input type="hidden" name="author" id="author" value="<?php echo $_SESSION['username'] ?>">
        <br>
        <label for="reply">Reply:</label>
        <textarea name="reply" id="reply" required></textarea>
        <br>
        <input type="submit" value="Post Reply">
        <br>
      </form>
      <?php if (!empty($comment['replies'])) : ?>
        <label class="viewReply" for="show_replies_<?php echo $comment['id'] ?>">View replies</label>
        <input type="checkbox" id="show_replies_<?php echo $comment['id'] ?>" style="display:none;">
        <div class="replies" style="display:none;">
          <p><em>Replies:</em></p>
          <?php foreach ($comment['replies'] as $reply) : ?>
            <p><strong><?php echo $reply['author'] ?>:</strong> <?php echo $reply['content'] ?></p>
            <p>Posted on <?php echo $reply['dateCreated'] ?></p>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>
    <?php endforeach; ?>

    <script>
      $(document).ready(function() {
        $("input[type='checkbox']").change(function() {
          if ($(this).is(":checked")) {
            $(this).siblings(".replies").slideDown(400);
          } else {
            $(this).siblings(".replies").slideUp(400);
          }
        });
      });
    </script>


    <main>
      <hr>
      <h1>Add a Comment</h1>

      <form method="post" action="add_comment.php">
        <input type="hidden" name="postId" value="<?php echo $postId ?>">
        <input type="hidden" name="commentId" value="<?php echo $comment['id'] ?>">
        <input type="hidden" name="author" id="author" value="<?php echo $_SESSION['username'] ?>">

        <label for="comment">Comment:</label>
        <textarea name="comment" id="comment" required></textarea>
        <br>
        <input type="submit" value="Post Comment">
      </form>
  </section>
  <footer>
    <a id="backButton" href="index.php">Back</a>
  </footer>
  </main>

</body>

</html>

<?php
include 'foot.php';
?>