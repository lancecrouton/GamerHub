<?php
session_start();
?>
<?php
include('head.php');
include('DB.php');
?>

<head>
    <title>Gamer Hub - Create Category</title>
    <link href="css/global.css" rel="stylesheet">
</head>

<div class="breadcrumbs">
    <a href="index.php">Home</a>
    <span class="separator">/</span>
    <a href="adminPage.php">Admin Page</a>
    <span class="separator">/</span>
    <span>Create Category</span>
</div>

<?php
if (isset($_POST['submit'])) {
    $categoryName = $_POST['categoryName'];


    $query = "INSERT INTO categories (categoryName) VALUES ('$categoryName')";
    $result = mysqli_query($conn, $query);

    header('Location: adminPage.php');
    exit;
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Create Category</title>
</head>

<body>
    <section class="categoryBody">
        <header>
            <h1>Create Category</h1>
        </header>
        <main>
            <section class="postBody">
                <form method="post">
                    <label for="categoryName">Category Name:</label>
                    <input type="text" id="categoryName" name="categoryName" required aria-describedby="categoryNameError">
                    <br><br>
                    <span id="categoryNameError" style="display:none;color:red;">Please enter a category name.</span>
                    <input type="submit" name="submit" value="Create Category">
                </form>
            </section>
    </section>
    </main>
    <footer>
        <a id="backButton" href="index.php">Back</a>
    </footer>
</body>


</html>
<?php
include 'foot.php';
?>