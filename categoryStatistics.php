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
    <span>Category Statistics</span>
</div>
<?php
$query = "SELECT categoryName FROM categories";
$result = mysqli_query($conn, $query);
$categoryNames = array();

while ($row = mysqli_fetch_assoc($result)) {
    $categoryNames[] = $row['categoryName'];
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Usage Statistics - Number of Posts by Category</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js"></script>
    <link href="css/global.css" rel="stylesheet">

</head>

<body>
    <section class="statBody">
        <h1>Usage Statistics - Number of Posts by Category</h1>

        <form method="post">
            <label for="categoryFilter">Filter by category:</label>
            <select id="categoryFilter" name="categoryFilter">
                <option value="All">All</option>
                <?php foreach ($categoryNames as $category) { ?>
                    <option value="<?php echo $category; ?>"><?php echo $category; ?></option>
                <?php } ?>
            </select>
            <button type="submit">Filter</button>
        </form>

        <canvas id="postChart" width="400" height="400"></canvas>

        <?php
        $categoryFilter = isset($_POST['categoryFilter']) ? $_POST['categoryFilter'] : 'All';

        $query = "SELECT categories.categoryName, COUNT(posts.postId) AS postCount
              FROM categories
              INNER JOIN posts ON categories.categoryId = posts.categoryId ";

        if ($categoryFilter != 'All') {
            $query .= "WHERE categories.categoryName = '$categoryFilter' ";
        }

        $query .= "GROUP BY categories.categoryId";

        $result = mysqli_query($conn, $query);

        $categoryNames = array();
        $postCounts = array();

        while ($row = mysqli_fetch_assoc($result)) {
            $categoryNames[] = $row['categoryName'];
            $postCounts[] = $row['postCount'];
        }

        mysqli_close($conn);
        ?>

        <script>
            var ctx = document.getElementById('postChart').getContext('2d');
            var chart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: <?php echo json_encode($categoryNames); ?>,
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