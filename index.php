<?php 
include '../config.php';

$store = getCurrentStore();
if (!$store) {
    echo "<h1 class='text-center mt-5'>Store Not Found!</h1>";
    exit();
}

$user_id = $store['user_id'];

// Search Functionality
$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';
$where = $search ? " AND (title LIKE '%$search%' OR description LIKE '%$search%')" : '';

$products_query = "SELECT * FROM products WHERE user_id = $user_id AND status='active' $where ORDER BY created_at DESC";
$products = mysqli_query($conn, $products_query);
?>

<!DOCTYPE html>
<html lang="ur" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($store['business_name']) ?> - MandiGateway</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, sans-serif;
            background: #f8f9fa;
        }
        .header {
            background: <?= $store['header_color'] ?> !important;
            color: white;
            padding: 20px 0;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
        .product-card {
            border: none;
            border-radius: 16px;
            overflow: hidden;
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        }
        .product-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.15);
        }
        .product-img {
            height: 220px;
            object-fit: cover;
        }
        .whatsapp-float {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background: #25D366;
            color: white;
            width: 65px;
            height: 65px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 30px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.3);
            z-index: 999;
            text-decoration: none;
        }
        .search-box {
            max-width: 600px;
            margin: 20px auto;
        }
    </style>
</head>
<body>

    <!-- Header -->
    <header class="header text-center">
        <div class="container">
            <h2 class="mb-1"><?= htmlspecialchars($store['business_name']) ?></h2>
            <p class="mb-0"><?= htmlspecialchars($store['banner_text']) ?></p>
        </div>
    </header>

    <div class="container mt-4">

        <!-- Search Bar -->
        <form method="GET" class="search-box">
            <div class="input-group">
                <input type="text" name="search" class="form-control form-control-lg" 
                       placeholder="Search products..." value="<?= htmlspecialchars($search) ?>">
                <button type="submit" class="btn btn-primary btn-lg">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </form>

        <h4 class="mb-4">Our Products (<?= mysqli_num_rows($products) ?>)</h4>

        <div class="row">
            <?php 
            if (mysqli_num_rows($products) > 0) {
                while($p = mysqli_fetch_assoc($products)) { 
            ?>
                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                    <div class="card product-card h-100">
                        <?php if($p['image']): ?>
                            <img src="../<?= htmlspecialchars($p['image']) ?>" class="card-img-top product-img" alt="<?= htmlspecialchars($p['title']) ?>">
                        <?php else: ?>
                            <img src="../uploads/no-image.png" class="card-img-top product-img" alt="No Image">
                        <?php endif; ?>
                        
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title"><?= htmlspecialchars($p['title']) ?></h5>
                            <h6 class="text-success fw-bold">Rs. <?= number_format($p['price']) ?></h6>
                            <p class="card-text text-muted small flex-grow-1">
                                <?= substr(strip_tags($p['description']), 0, 85) ?>...
                            </p>
                            
                            <div class="mt-auto">
                                <a href="cart.php?add=<?= $p['id'] ?>" class="btn btn-primary w-100 mb-2">
                                    <i class="fas fa-cart-plus"></i> Add to Cart
                                </a>
                                <a href="https://wa.me/<?= $store['whatsapp_number'] ?>?text=Hello,%20I%20want%20to%20buy:%20<?= urlencode($p['title']) ?>%20(Rs.%20<?= $p['price'] ?>)" 
                                   class="btn btn-success w-100" target="_blank">
                                    <i class="fab fa-whatsapp"></i> Order on WhatsApp
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php 
                }
            } else {
                echo "<div class='col-12 text-center'><h5>No products found.</h5></div>";
            }
            ?>
        </div>
    </div>

    <!-- Floating WhatsApp Button -->
    <?php if(!empty($store['whatsapp_number'])): ?>
        <a href="https://wa.me/<?= $store['whatsapp_number'] ?>" class="whatsapp-float" target="_blank" title="Chat on WhatsApp">
            <i class="fab fa-whatsapp"></i>
        </a>
    <?php endif; ?>

    <!-- Footer -->
    <footer class="bg-dark text-white text-center py-4 mt-5">
        <div class="container">
            <p class="mb-0">&copy; <?= date("Y") ?> <?= htmlspecialchars($store['business_name']) ?> - Powered by MandiGateway</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>