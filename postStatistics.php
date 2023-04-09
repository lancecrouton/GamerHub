<?php
session_start();
?>
<?php
include('DB.php');
include('head.php');
?>
<div class="breadcrumbs">
	<a href="index.php">Home</a>
	<span class="separator">/</span>
	<a href="usageStatistics.php">Usage Statistics</a>
	<span class="separator">/</span>
	<span>Post Statistics</span>
</div>
<?php
if (!isset($_SESSION["username"]) || $_SESSION['isAdmin'] != 1) {
	header("Location: logIn.php");
	exit();
}
?>

<!DOCTYPE html>
<html>

<head>
	<title>Usage Statistics - Number of Posts by User</title>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js"></script>
	<link href="css/global.css" rel="stylesheet">

</head>

<body>
	<section class="statBody">
		<h1>Usage Statistics - Number of Posts by User</h1>

		<form method="get">
			<label for="dateFilter">Filter by Date Created:</label>
			<input type="date" id="dateFilter" name="dateFilter">
			<input type="submit" value="Filter">
		</form>

		<canvas id="postChart" width="400" height="400"></canvas>

		<?php
		$filter = "";
		if (isset($_GET['dateFilter'])) {
			$dateFilter = $_GET['dateFilter'];
			$filter = " WHERE DATE(dateCreated) = '$dateFilter'";
		}

		$query = "SELECT username, COUNT(postId) AS postCount
			  FROM posts" . $filter . "
			  GROUP BY username";

		$result = mysqli_query($conn, $query);

		$usernames = array();
		$postCounts = array();

		while ($row = mysqli_fetch_assoc($result)) {
			$usernames[] = $row['username'];
			$postCounts[] = $row['postCount'];
		}

		mysqli_close($conn);
		?>

		<script>
			var ctx = document.getElementById('postChart').getContext('2d');
			var chart = new Chart(ctx, {
				type: 'bar',
				data: {
					labels: <?php echo json_encode($usernames); ?>,
					datasets: [{
						label: 'Number of Posts',
						data: <?php echo json_encode($postCounts); ?>,
						backgroundColor: 'white',
						borderColor: 'rgba(54, 162, 235, 1)',
						borderWidth: 1
					}]

				},
				options: {
					scales: {
						yAxes: [{
							ticks: {
								beginAtZero: true
							}
						}]
					}
				}
			});
		</script>
	</section>
</body>
<footer>
	<a id="backButton" href="usageStatistics.php">Back</a>
</footer>

</html>

<?php
include 'foot.php';
?>