<?php 
include '../config.php';
if (!isset($_SESSION['user_id'])) header("Location: ../login.php");
$user_id = $_SESSION['user_id'];

if (isset($_POST['add_category'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $slug = strtolower(preg_replace('/[^a-z0-9]+/', '-', $name));
    
    mysqli_query($conn, "INSERT INTO categories (user_id, name, slug) VALUES ($user_id, '$name', '$slug')");
    echo "<div class='alert alert-success'>Category Added Successfully!</div>";
}
?>

<!DOCTYPE html>
<html lang="ur">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categories - Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
    <h2>Manage Categories</h2>
    
    <form method="POST" class="mb-5">
        <div class="input-group">
            <input type="text" name="name" class="form-control" placeholder="Category Name (e.g. Vegetables, Fruits)" required>
            <button type="submit" name="add_category" class="btn btn-primary">Add Category</button>
        </div>
    </form>

    <h4>Existing Categories</h4>
    <table class="table table-bordered">
        <thead>
            <tr><th>ID</th><th>Category Name</th><th>Slug</th><th>Action</th></tr>
        </thead>
        <tbody>
            <?php
            $result = mysqli_query($conn, "SELECT * FROM categories WHERE user_id = $user_id");
            while($row = mysqli_fetch_assoc($result)) {
                echo "<tr>
                    <td>{$row['id']}</td>
                    <td>".htmlspecialchars($row['name'])."</td>
                    <td>".htmlspecialchars($row['slug'])."</td>
                    <td><button class='btn btn-sm btn-danger'>Delete</button></td>
                </tr>";
            }
            ?>
        </tbody>
    </table>
</body>
</html>