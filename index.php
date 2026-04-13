<?php 
include 'config.php'; 
$store = getCurrentStore();

if ($store) {
    // User ka store chal raha hai
    include 'store/index.php';
    exit();
}
?>
<!DOCTYPE html>
<html lang="ur">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MandiGateway - Apna Store Banaye</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { font-family: 'Segoe UI', sans-serif; }
        .hero { background: linear-gradient(135deg, #0d6efd, #6610f2); color: white; padding: 120px 0; }
    </style>
</head>
<body>
<div class="hero text-center">
    <h1 class="display-3">MandiGateway</h1>
    <p class="lead">Apna Business Online Karo – Free Store Banaye</p>
    <a href="signup.php" class="btn btn-light btn-lg">Abhi Store Banaye</a>
</div>

<div class="container mt-5">
    <h2 class="text-center">Featured Stores</h2>
    <!-- Yahan latest active stores/products show kar sakte ho -->
</div>
</body>
</html>