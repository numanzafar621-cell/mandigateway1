<?php 
include '../config.php';
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php"); exit();
}

$user_id = $_SESSION['user_id'];
$user = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM users WHERE id = $user_id"));
$store = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM stores WHERE user_id = $user_id"));

if ($user['status'] != 'active') {
    header("Location: verify.php"); exit();
}
?>
<!DOCTYPE html>
<html lang="ur" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - <?= htmlspecialchars($user['business_name']) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <style>
        body { background:#f8f9fa; }
        .sidebar { min-height: 100vh; background: #212529; color: white; }
        .nav-link { color: #ddd; }
        .nav-link:hover, .nav-link.active { background:#0d6efd; color:white; }
    </style>
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-3 col-lg-2 sidebar p-3">
            <h4 class="text-center mb-4">MandiGateway</h4>
            <h5 class="text-center"><?= htmlspecialchars($user['business_name']) ?></h5>
            <hr>
            <ul class="nav flex-column">
                <li><a href="index.php" class="nav-link active"><i class="fas fa-home"></i> Dashboard</a></li>
                <li><a href="products.php" class="nav-link"><i class="fas fa-box"></i> Products</a></li>
                <li><a href="categories.php" class="nav-link"><i class="fas fa-tags"></i> Categories</a></li>
                <li><a href="sliders.php" class="nav-link"><i class="fas fa-images"></i> Sliders</a></li>
                <li><a href="pages.php" class="nav-link"><i class="fas fa-file"></i> Pages</a></li>
                <li><a href="posts.php" class="nav-link"><i class="fas fa-blog"></i> Posts/Blog</a></li>
                <li><a href="orders.php" class="nav-link"><i class="fas fa-shopping-cart"></i> Orders</a></li>
                <li><a href="settings.php" class="nav-link"><i class="fas fa-cog"></i> Store Settings</a></li>
                <li><a href="verify.php" class="nav-link"><i class="fas fa-user-check"></i> Verification</a></li>
                <li><a href="logout.php" class="nav-link text-danger"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
            </ul>
        </div>

        <!-- Main Content -->
        <div class="col-md-9 col-lg-10 p-4">
            <h2>Welcome, <?= htmlspecialchars($user['full_name']) ?>!</h2>
            <div class="alert alert-success">
                Your Store Link: <strong><a href="http://<?= $store['subdomain'] ?>.<?= str_replace('http://', '', BASE_URL) ?>" target="_blank">
                    <?= $store['subdomain'] ?>.mandigateway.com
                </a></strong>
            </div>

            <div class="row mt-4">
                <div class="col-md-4"><div class="card p-3 text-center"><h5>Total Products</h5><h3>0</h3></div></div>
                <div class="col-md-4"><div class="card p-3 text-center"><h5>Orders</h5><h3>0</h3></div></div>
                <div class="col-md-4"><div class="card p-3 text-center"><h5>Visitors</h5><h3>Coming Soon</h3></div></div>
            </div>

            <a href="../store/index.php?preview=1" class="btn btn-primary mt-4" target="_blank">Preview My Store</a>
        </div>
    </div>
</div>
</body>
</html>