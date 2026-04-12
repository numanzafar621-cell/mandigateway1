<?php 
include '../config.php';
if (!isset($_SESSION['user_id'])) header("Location: ../login.php");
$user_id = $_SESSION['user_id'];
?>

<!DOCTYPE html>
<html lang="ur">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Posts / Blog</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js"></script>
    <script>
        tinymce.init({ selector: '#content', height: 400, plugins: 'link image code lists', toolbar: 'undo redo | bold italic | alignleft aligncenter | bullist numlist | code' });
    </script>
</head>
<body class="p-4">
    <h2>Add New Post / Blog</h2>
    <form method="POST">
        <input type="text" name="title" class="form-control" placeholder="Post Title" required>
        <textarea id="content" name="content"></textarea>
        <button type="submit" name="save_post" class="btn btn-primary mt-3">Publish Post</button>
    </form>
</body>
</html>