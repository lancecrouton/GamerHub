<?php
session_start();
?>
<?php
include('head.php');
include("DB.php");


if (isset($_SESSION['username'])) {
	$username = $_SESSION['username'];

	$stmt = $conn->prepare("SELECT isAdmin FROM accounts WHERE username=?");
	$stmt->bind_param("s", $username);
	$stmt->execute();
	$result = $stmt->get_result();

	if ($result->num_rows > 0) {
		while ($row = $result->fetch_assoc()) {
			$isAdmin = $row["isAdmin"];
			$_SESSION['isAdmin'] = $isAdmin;
		}
	}

	if ($isAdmin === 1) {
?>

		<!DOCTYPE html>
		<html>

		<head>
			<title>Gamer Hub</title>
			<link href="css/home.css" rel="stylesheet">
			<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
			<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
		</head>


		<div class="categoryHome">
			<h3>Categories</h3>
			<ul>
				<?php
				$query = "SELECT * FROM categories";
				$stmt = $conn->prepare($query);
				$stmt->execute();
				$result = $stmt->get_result();
				while ($row = $result->fetch_assoc()) {
					$categoryId = $row['categoryId'];
					$categoryName = $row['categoryName'];
					echo "<li><a href='category.php?categoryId=$categoryId'>$categoryName</a></li>";
				}
				?>
			</ul>
		</div>


		<body>
			<header>
				<form id="searchbar">
					<input type="search" id="query" placeholder="Search">
					<button type="submit" class="searchbarButton">
						<i class="material-icons">search</i>
					</button>
				</form>
			</header>

			<div class="feed">
				<div id="post-container"></div>

				<div class="sidebar">
					<div>
						<a id="logOut" href='logOut.php'>Log Out</a>
					</div>
					<div>
						<a id="adminPage" href=adminPage.php>Admin Page</a>
					</div>
					<div>
						<a id="account" href=account.php>Account</a>
					</div>
					<div>
						<a id="createPost" href=createPost.php>Create Post</a>
					</div>
					<div>
						<a id="likedPosts" href=likedPosts.php>Most Liked Posts</a>
					</div>
					<div>
						<a id="controversialPosts" href=controversialPosts.php>Controversial Posts</a>
					</div>
				</div>
			</div>

			<script>
				const form = document.getElementById('searchbar');
				const postContainer = document.getElementById('post-container');
				let intervalId;

				form.addEventListener('submit', (event) => {
					event.preventDefault();

					const query = document.getElementById('query').value;
					if (query.trim() === '') {
						updatePosts();
						intervalId = setInterval(updatePosts, 2000);
					} else {
						clearInterval(intervalId);
						const xhr = new XMLHttpRequest();
						const url = `search.php?query=${query}`;
						xhr.open('GET', url, true);
						xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
						xhr.onreadystatechange = function() {
							if (this.readyState === 4 && this.status === 200) {
								postContainer.innerHTML = this.responseText;
							}
						};
						xhr.send();
					}
				});

				function updatePosts() {
					var previousData = postContainer.innerHTML;
					$.ajax({
						type: "GET",
						url: "getPosts.php",
						success: function(data) {
							if (data !== previousData) {
								postContainer.innerHTML = data;
								alert("New posts retrieved!");
							}
						}
					});
				}

				intervalId = setInterval(updatePosts, 2000);
			</script>



		</body>

		</html>

		<?php
		include 'foot.php';
		?>

	<?php
	} else {
	?>

		<!DOCTYPE html>
		<html>

		<head>
			<title>Gamer Hub</title>
			<link href="css/home.css" rel="stylesheet">
			<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
			<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
		</head>

		<div class="categoryHome">
			<h3>Categories</h3>
			<ul>
				<?php
				$query = "SELECT * FROM categories";
				$stmt = $conn->prepare($query);
				$stmt->execute();
				$result = $stmt->get_result();
				while ($row = $result->fetch_assoc()) {
					$categoryId = $row['categoryId'];
					$categoryName = $row['categoryName'];
					echo "<li><a href='category.php?categoryId=$categoryId'>$categoryName</a></li>";
				}
				?>
			</ul>
		</div>

		<body>
			<header>
				<form id="searchbar">
					<input type="search" id="query" placeholder="Search">
					<button type="submit" class="searchbarButton">
						<i class="material-icons">search</i>
					</button>
				</form>
			</header>

			<div class="feed">
				<div id="post-container"></div>

				<div class="sidebar">
					<div>
						<a id="logOut" href='logOut.php'>Log Out</a>
					</div>
					<div>
						<a id="account" href=account.php>Account</a>
					</div>
					<div>
						<a id="createPost" href=createPost.php>Create Post</a>
					</div>
					<div>
						<a id="likedPosts" href=likedPosts.php>Most Liked Posts</a>
					</div>
					<div>
						<a id="controversialPosts" href=controversialPosts.php>Controversial Posts</a>
					</div>
				</div>
			</div>

			<script>
				const form = document.getElementById('searchbar');
				const postContainer = document.getElementById('post-container');
				let intervalId;

				form.addEventListener('submit', (event) => {
					event.preventDefault();

					const query = document.getElementById('query').value;
					if (query.trim() === '') {
						updatePosts();
						intervalId = setInterval(updatePosts, 2000);
					} else {
						clearInterval(intervalId);
						const xhr = new XMLHttpRequest();
						const url = `search.php?query=${query}`;
						xhr.open('GET', url, true);
						xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
						xhr.onreadystatechange = function() {
							if (this.readyState === 4 && this.status === 200) {
								postContainer.innerHTML = this.responseText;
							}
						};
						xhr.send();
					}
				});

				function updatePosts() {
					var previousData = postContainer.innerHTML;
					$.ajax({
						type: "GET",
						url: "getPosts.php",
						success: function(data) {
							if (data !== previousData) {
								postContainer.innerHTML = data;
								alert("New posts retrieved!");
							}
						}
					});
				}

				intervalId = setInterval(updatePosts, 2000);
			</script>

		</body>

		</html>

		<?php
		include 'foot.php';
		?>

	<?php
	}
} else {
	?>
	<!DOCTYPE html>
	<html>

	<head>
		<title>Gamer Hub</title>
		<link href="css/home.css" rel="stylesheet">
		<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
		<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	</head>

	<div class="categoryHome">
		<h3>Categories</h3>
		<ul>
			<?php
			$query = "SELECT * FROM categories";
			$stmt = $conn->prepare($query);
			$stmt->execute();
			$result = $stmt->get_result();
			while ($row = $result->fetch_assoc()) {
				$categoryId = $row['categoryId'];
				$categoryName = $row['categoryName'];
				echo "<li><a href='category.php?categoryId=$categoryId'>$categoryName</a></li>";
			}
			?>
		</ul>
	</div>

	<body>
		<header>
			<form id="searchbar">
				<input type="search" id="query" placeholder="Search">
				<button type="submit" class="searchbarButton">
					<i class="material-icons">search</i>
				</button>
			</form>
		</header>

		<div class="feed">
			<div id="post-container"></div>

			<div class="sidebar">
				<div>
					<a id="logIn" href='logIn.php'>Log In</a>
				</div>
				<div>
					<a id="likedPosts" href=likedPosts.php>Most Liked Posts</a>
				</div>
				<div>
					<a id="controversialPosts" href=controversialPosts.php>Controversial Posts</a>
				</div>
			</div>
		</div>

		<script>
			const form = document.getElementById('searchbar');
			const postContainer = document.getElementById('post-container');
			let intervalId;

			form.addEventListener('submit', (event) => {
				event.preventDefault();

				const query = document.getElementById('query').value;
				if (query.trim() === '') {
					updatePosts();
					intervalId = setInterval(updatePosts, 2000);
				} else {
					clearInterval(intervalId);
					const xhr = new XMLHttpRequest();
					const url = `search.php?query=${query}`;
					xhr.open('GET', url, true);
					xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
					xhr.onreadystatechange = function() {
						if (this.readyState === 4 && this.status === 200) {
							postContainer.innerHTML = this.responseText;
						}
					};
					xhr.send();
				}
			});

			function updatePosts() {
				var previousData = postContainer.innerHTML;
				$.ajax({
					type: "GET",
					url: "getPosts.php",
					success: function(data) {
						if (data !== previousData) {
							postContainer.innerHTML = data;
							alert("New posts retrieved!");
						}
					}
				});
			}

			intervalId = setInterval(updatePosts, 2000);
		</script>

	</body>

	</html>

	<?php
	include 'foot.php';
	?>

<?php
}
?>

<?php
if (isset($_SESSION['username'])) {
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
<?php
}

?>