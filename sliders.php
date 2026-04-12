<?php 
include '../config.php';
if (!isset($_SESSION['user_id'])) header("Location: ../login.php");
$user_id = $_SESSION['user_id'];

if (isset($_POST['add_slider'])) {
    $text = mysqli_real_escape_string($conn, $_POST['text']);
    $target = "../uploads/" . time() . "_" . basename($_FILES['image']['name']);
    move_uploaded_file($_FILES['image']['tmp_name'], $target);
    
    mysqli_query($conn, "INSERT INTO sliders (user_id, image, text) VALUES ($user_id, '$target', '$text')");
    echo "<div class='alert alert-success'>Slider Added!</div>";
}
?>
<!DOCTYPE html>
<html lang="ur">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sliders / Banners</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
    <h2>Manage Home Sliders</h2>
    
    <form method="POST" enctype="multipart/form-data">
        <input type="file" name="image" class="form-control" required>
        <input type="text" name="text" class="form-control mt-2" placeholder="Slider Text (optional)">
        <button type="submit" name="add_slider" class="btn btn-primary mt-3">Add Slider</button>
    </form>

    <h4 class="mt-5">Existing Sliders</h4>
    <div class="row">
        <?php
        $result = mysqli_query($conn, "SELECT * FROM sliders WHERE user_id = $user_id ORDER BY position");
        while($row = mysqli_fetch_assoc($result)) {
            echo "<div class='col-md-4 mb-3'>
                    <img src='../".htmlspecialchars($row['image'])."' class='img-fluid'>
                    <p>".htmlspecialchars($row['text'])."</p>
                  </div>";
        }
        ?>
    </div>
</body>
</html>