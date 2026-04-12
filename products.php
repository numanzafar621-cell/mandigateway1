<?php 
include '../config.php';
if (!isset($_SESSION['user_id'])) header("Location: ../login.php");
$user_id = $_SESSION['user_id'];

if (isset($_POST['add_product'])) {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $price = floatval($_POST['price']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $category_id = intval($_POST['category_id']);
    
    $image = "";
    if ($_FILES['image']['name']) {
        $target = "../uploads/" . time() . "_" . basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], $target);
        $image = $target;
    }
    
    mysqli_query($conn, "INSERT INTO products (user_id, category_id, title, price, description, image) 
                        VALUES ($user_id, $category_id, '$title', $price, '$description', '$image')");
    echo "<div class='alert alert-success'>Product Added!</div>";
}
?>

<!DOCTYPE html>
<html lang="ur">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products - Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
    <h2>My Products</h2>
    
    <form method="POST" enctype="multipart/form-data" class="mb-5">
        <div class="row">
            <div class="col-md-6"><input type="text" name="title" class="form-control" placeholder="Product Title" required></div>
            <div class="col-md-3"><input type="number" name="price" class="form-control" placeholder="Price" required></div>
            <div class="col-md-3">
                <select name="category_id" class="form-control">
                    <!-- Categories yahan dynamically aaengi -->
                </select>
            </div>
        </div>
        <textarea name="description" class="form-control mt-3" placeholder="Description"></textarea>
        <input type="file" name="image" class="form-control mt-3">
        <button type="submit" name="add_product" class="btn btn-primary mt-3">Add Product</button>
    </form>

    <!-- Products List -->
    <table class="table table-bordered">
        <thead><tr><th>Image</th><th>Title</th><th>Price</th><th>Action</th></tr></thead>
        <tbody>
            <?php
            $result = mysqli_query($conn, "SELECT * FROM products WHERE user_id = $user_id");
            while($row = mysqli_fetch_assoc($result)) {
                echo "<tr>
                    <td><img src='../".htmlspecialchars($row['image'])."' width='60'></td>
                    <td>".htmlspecialchars($row['title'])."</td>
                    <td>Rs. ".$row['price']."</td>
                    <td><a href='#' class='btn btn-sm btn-danger'>Delete</a></td>
                </tr>";
            }
            ?>
        </tbody>
    </table>
</body>
</html>