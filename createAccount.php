<?php
include('head.php');
?>

<head>
	<title>Gamer Hub - Account Creation</title>
	<link href="css/global.css" rel="stylesheet">
</head>

<body>
	<?php
	include('DB.php');
	if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
		$username = $_POST['username'];
		$password = $_POST['password'];
		$email = $_POST['email'];
		$img = $_FILES['img']['name'];
		$img_tmp = $_FILES['img']['tmp_name'];
		$isAdmin = 0;
		$isDisabled = 0;

		$stmt = $conn->prepare("SELECT * FROM accounts WHERE username=?");
		$stmt->bind_param("s", $username);
		$stmt->execute();
		$result = $stmt->get_result();

		if ($result->num_rows > 0) {
			echo "Username already exists";
		} else if (strlen($password) < 8) {
			echo "Password must be at least 8 characters long";
		} else if (!preg_match("#[0-9]+#", $password)) {
			echo "Password must contain at least one number";
		} else if (!preg_match("#[a-zA-Z]+#", $password)) {
			echo "Password must contain at least one letter";
		} else {
			$hashedPassword = md5($password);
			$sql = "INSERT INTO accounts (username, email, password, img, isAdmin, isDisabled) VALUES ('$username', '$email', '$hashedPassword', '$img', '$isAdmin', '$isDisabled')";

			if ($conn->query($sql) === TRUE) {
				$target_dir = "uploads/";
				$target_file = $target_dir . basename($img);
				move_uploaded_file($img_tmp, $target_file);
				header("Location: index.php");
				exit();
			} else {
				echo "Error: " . $sql . "<br>" . $conn->error;
			}

			$conn->close();
		}
	}
	?>
	<div class="accountCreationBox">
		<h1>Account Creation</h1>
		<form id="accountCreationForm" action="createAccount.php" method="post" enctype="multipart/form-data">
			<label for="username">Username:</label>
			<input type="text" id="username" name="username" required><br>

			<span id="passwordHelp" role="alert" aria-live="assertive">Your password must be at least 8 characters long and include both letters and numbers.</span><br>

			<label for="password">Password:</label>
			<input type="password" id="password" name="password" aria-describedby="passwordHelp" autocomplete="new-password" required><br>

			<label for="confirmPassword">Confirm Password:</label>
			<input type="password" id="confirmPassword" name="confirmPassword" required><br>

			<label for="email">Email:</label>
			<input type="email" id="email" name="email" required><br>

			<label for="img">Select image:</label>
			<input type="file" accept=".jpeg,.jpg,.png,.gif" id="img" name="img" accept="image/*" title="Accepted file types: JPG, PNG"><br>

			<button type="submit">Create Account</button>
		</form>
	</div>
	<script type="text/javascript" src="scripts/validateAccountCreation.js"></script>
</body>

<footer>
	<a id="backButton" href="logIn.php">Back</a>
</footer>

</html>

<?php
include 'foot.php';
?>