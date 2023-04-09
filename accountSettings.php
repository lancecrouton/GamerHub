<?php
session_start();
?>
<?php
include('head.php');

if (!isset($_SESSION["username"])) {
	header("Location: logIn.php");
	exit();
}

?>

<head>
	<title>Gamer Hub - Account Settings</title>
	<link href="css/global.css" rel="stylesheet">
</head>

<div class="breadcrumbs">
	<a href="index.php">Home</a>
	<span class="separator">/</span>
	<a href="account.php">Account</a>
	<span class="separator">/</span>
	<span>Account Settings</span>
</div>


<head>
	<title>Gamer Hub - Account Update</title>
	<link href="css/global.css" rel="stylesheet">
</head>



<body>
	<?php
	include('DB.php');
	$username = $_SESSION["username"];
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {

		$email = $_POST['email'];

		if (!empty($_FILES['img']['name'])) {

			$img = $_FILES['img']['name'];
			$img_tmp = $_FILES['img']['tmp_name'];

			$sql = "UPDATE accounts SET email='$email', img='$img' WHERE username='$username'";
		} else {
			$sql = "UPDATE accounts SET email='$email' WHERE username='$username'";
		}
		if ($conn->query($sql) === TRUE) {
			$target_dir = "uploads/";
			$target_file = $target_dir . basename($img);
			move_uploaded_file($img_tmp, $target_file);
			header("Location: account.php");
			exit();
		} else {
			echo "Error: " . $sql . "<br>" . $conn->error;
		}

		$conn->close();
	}



	$stmt = $conn->prepare("SELECT username, email, img FROM accounts WHERE username = ?");
	$stmt->bind_param("s", $username);
	$stmt->execute();
	$result = $stmt->get_result();

	if ($result->num_rows > 0) {
		while ($row = $result->fetch_assoc()) {
			$username = $row["username"];
			$email = $row["email"];
			$img = $row["img"];
		}
	} else {
	}

	$stmt->close();
	$conn->close();
	?>

	<div class="accountUpdateBox">
		<h1>Account Update</h1>
		<form id="accountUpdateForm" action="accountSettings.php" method="post" enctype="multipart/form-data">

			<label for="email">Email:</label>
			<input type="email" id="email" name="email" value="<?php echo $email; ?>" required aria-describedby="email-description">

			<p id="email-description">Please enter your email address.</p>

			<label for="img">Select image:</label>
			<input type="file" accept=".jpeg,.jpg,.png,.gif" id="img" name="img" accept="image/*" aria-describedby="img-description">

			<p id="img-description">Please select an image to upload.</p>

			<a href="changePassword.php">Change Password<a>

					<button type="submit">Update Account</button>
		</form>
	</div>

</body>

<footer>
	<a id="backButton" href="account.php">Back</a>
</footer>

</html>

<?php
include 'foot.php';
?>