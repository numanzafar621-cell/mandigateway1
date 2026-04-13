<?php
include 'config.php';

// ID چیک کریں
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id == 0) {
    die("Invalid product ID.");
}

// صرف ایکٹو پروڈکٹ نکالیں (status = 1)
$query = "SELECT * FROM products WHERE id = $id AND status = 1";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) == 0) {
    die("Product not found or inactive.");
}

$product = mysqli_fetch_assoc($result);
?>
<!DOCTYPE html>
<html lang="ur">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($product['name']) ?> - Product Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <a href="index.php" class="btn btn-secondary mb-3">← Back to Home</a>
        <div class="card">
            <div class="row g-0">
                <div class="col-md-6">
                    <?php if(!empty($product['image'])): ?>
                        <img src="uploads/<?= $product['image'] ?>" class="img-fluid rounded-start" style="max-height: 400px; width: 100%; object-fit: contain;">
                    <?php else: ?>
                        <div class="bg-secondary text-white d-flex align-items-center justify-content-center" style="height: 300px;">
                            No Image Available
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <div class="card-body">
                        <h2 class="card-title"><?= htmlspecialchars($product['name']) ?></h2>
                        <p class="card-text"><?= nl2br(htmlspecialchars($product['description'])) ?></p>
                        <p class="card-text fw-bold fs-3 text-primary">$<?= number_format($product['price'], 2) ?></p>
                        <p class="card-text">
                            <small class="text-muted">Category ID: <?= $product['category_id'] ?></small><br>
                            <small class="text-muted">Posted on: <?= $product['created_at'] ?></small>
                        </p>
                        <button class="btn btn-success btn-lg">Buy Now</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>pp
