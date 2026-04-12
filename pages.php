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
    <title>Pages - Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- TinyMCE CDN -->
    <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
        tinymce.init({
            selector: '#content',
            height: 500,
            plugins: 'link image lists table code',
            toolbar: 'undo redo | blocks | bold italic | alignleft aligncenter alignright | bullist numlist | link image | code',
            menubar: 'file edit view insert format table tools'
        });
    </script>
</head>
<body class="p-4">
    <h2>Manage Pages (About, Contact, Custom)</h2>
    
    <form method="POST">
        <input type="text" name="title" class="form-control" placeholder="Page Title (e.g. About Us)" required>
        <input type="text" name="slug" class="form-control mt-2" placeholder="URL Slug (about-us)" required>
        <textarea id="content" name="content"></textarea>
        <button type="submit" name="save_page" class="btn btn-primary mt-3">Save Page</button>
    </form>

    <!-- Saved Pages List -->
    <h4 class="mt-5">Existing Pages</h4>
    <table class="table">
        <!-- PHP code se pages list aaegi -->
    </table>
</body>
</html>