CREATE TABLE pages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    slug VARCHAR(255) UNIQUE NOT NULL,
    content LONGTEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
ALTER TABLE products ADD COLUMN status TINYINT(1) DEFAULT 0 COMMENT '0=pending, 1=active, 2=rejected';

<?php
include '../includes/config.php';
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit;
}

// گیٹ وے کی معلومات اپڈیٹ کرنا
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_gateway'])) {
    $gateway = $_POST['gateway_name'];
    $is_active = isset($_POST['is_active']) ? 1 : 0;
    $sandbox_mode = isset($_POST['sandbox_mode']) ? 1 : 0;
    $merchant_id = $_POST['merchant_id'];
    $merchant_password = $_POST['merchant_password'];
    $integrity_salt = $_POST['integrity_salt'];
    $api_key = $_POST['api_key'];
    $secret_key = $_POST['secret_key'];
    $public_key = $_POST['public_key'];
    $return_url = $_POST['return_url'];
    
    $stmt = $pdo->prepare("UPDATE payment_gateways SET 
        is_active = ?, sandbox_mode = ?, merchant_id = ?, 
        merchant_password = ?, integrity_salt = ?, api_key = ?, 
        secret_key = ?, public_key = ?, return_url = ? 
        WHERE gateway_name = ?");
    $stmt->execute([$is_active, $sandbox_mode, $merchant_id, 
        $merchant_password, $integrity_salt, $api_key, 
        $secret_key, $public_key, $return_url, $gateway]);
    $success = "Gateway updated successfully!";
}

// تمام گیٹ ویز حاصل کریں
$gateways = $pdo->query("SELECT * FROM payment_gateways")->fetchAll();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Payment Gateways - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <h2>Payment Gateway Settings</h2>
    <?php if(isset($success)): ?>
        <div class="alert alert-success"><?= $success ?></div>
    <?php endif; ?>
    
    <div class="row">
        <?php foreach($gateways as $gw): ?>
        <div class="col-md-4 mb-4">
            <div class="card">
                <div class="card-header">
                    <strong><?= ucfirst($gw['gateway_name']) ?></strong>
                    <span class="badge <?= $gw['is_active'] ? 'bg-success' : 'bg-secondary' ?> float-end">
                        <?= $gw['is_active'] ? 'Active' : 'Inactive' ?>
                    </span>
                </div>
                <div class="card-body">
                    <form method="post">
                        <input type="hidden" name="gateway_name" value="<?= $gw['gateway_name'] ?>">
                        <div class="form-check form-switch mb-2">
                            <input class="form-check-input" type="checkbox" name="is_active" <?= $gw['is_active'] ? 'checked' : '' ?>>
                            <label>Enable Gateway</label>
                        </div>
                        <div class="form-check form-switch mb-2">
                            <input class="form-check-input" type="checkbox" name="sandbox_mode" <?= $gw['sandbox_mode'] ? 'checked' : '' ?>>
                            <label>Sandbox Mode (Test)</label>
                        </div>
                        <?php if($gw['gateway_name'] == 'jazzcash'): ?>
                        <div class="mb-2"><input type="text" name="merchant_id" class="form-control" placeholder="Merchant ID" value="<?= htmlspecialchars($gw['merchant_id']) ?>"></div>
                        <div class="mb-2"><input type="text" name="merchant_password" class="form-control" placeholder="Merchant Password" value="<?= htmlspecialchars($gw['merchant_password']) ?>"></div>
                        <div class="mb-2"><input type="text" name="integrity_salt" class="form-control" placeholder="Integrity Salt" value="<?= htmlspecialchars($gw['integrity_salt']) ?>"></div>
                        <?php elseif($gw['gateway_name'] == 'easypaisa'): ?>
                        <div class="mb-2"><input type="text" name="api_key" class="form-control" placeholder="API Key / Store ID" value="<?= htmlspecialchars($gw['api_key']) ?>"></div>
                        <div class="mb-2"><input type="text" name="secret_key" class="form-control" placeholder="Secret Key / Hash Key" value="<?= htmlspecialchars($gw['secret_key']) ?>"></div>
                        <?php elseif($gw['gateway_name'] == 'stripe'): ?>
                        <div class="mb-2"><input type="text" name="public_key" class="form-control" placeholder="Publishable Key" value="<?= htmlspecialchars($gw['public_key']) ?>"></div>
                        <div class="mb-2"><input type="text" name="secret_key" class="form-control" placeholder="Secret Key" value="<?= htmlspecialchars($gw['secret_key']) ?>"></div>
                        <?php endif; ?>
                        <div class="mb-2"><input type="text" name="return_url" class="form-control" placeholder="Return/Callback URL" value="<?= htmlspecialchars($gw['return_url']) ?>"></div>
                        <button type="submit" name="update_gateway" class="btn btn-primary btn-sm">Save Settings</button>
                    </form>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    
    <h3 class="mt-5">All Transactions</h3>
    <table class="table table-bordered">
        <thead>
            <tr><th>ID</th><th>User</th><th>Gateway</th><th>Transaction ID</th><th>Amount</th><th>Status</th><th>Date</th></tr>
        </thead>
        <tbody>
            <?php
            $trans = $pdo->query("SELECT t.*, u.username FROM transactions t 
                                 JOIN users u ON t.user_id = u.id 
                                 ORDER BY t.id DESC")->fetchAll();
            foreach($trans as $tr): ?>
            <tr>
                <td><?= $tr['id'] ?></td>
                <td><?= htmlspecialchars($tr['username']) ?></td>
                <td><?= $tr['gateway_name'] ?></td>
                <td><?= $tr['transaction_id'] ?></td>
                <td>$<?= $tr['amount'] ?></td>
                <td><span class="badge bg-<?= $tr['status'] == 'success' ? 'success' : ($tr['status'] == 'pending' ? 'warning' : 'danger') ?>">
                    <?= $tr['status'] ?>
                </span></td>
                <td><?= $tr['created_at'] ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
</body>
</html>
                
CREATE DATABASE mandigateway_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE mandigateway_db;

-- Users Table
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    business_name VARCHAR(255) NOT NULL,
    full_name VARCHAR(255) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    cnic_front VARCHAR(500),
    cnic_back VARCHAR(500),
    address TEXT,
    google_map TEXT,
    status ENUM('pending','active','suspended') DEFAULT 'pending',
    role ENUM('user','admin') DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Stores Table (har user ka alag store settings)
CREATE TABLE stores (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT UNIQUE,
    subdomain VARCHAR(100) UNIQUE NOT NULL,
    logo VARCHAR(500) DEFAULT 'logo.png',
    header_color VARCHAR(7) DEFAULT '#0d6efd',
    banner_text VARCHAR(255) DEFAULT 'Welcome to my store!',
    whatsapp_number VARCHAR(20),
    whatsapp_position ENUM('floating','below_product','above_product') DEFAULT 'floating',
    theme VARCHAR(20) DEFAULT 'modern',
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Categories (har user ke apne)
CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    name VARCHAR(255) NOT NULL,
    slug VARCHAR(255) UNIQUE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Products
CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    category_id INT,
    title VARCHAR(255) NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    description TEXT,
    image VARCHAR(500),
    status ENUM('active','inactive') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (category_id) REFERENCES categories(id)
);

-- Pages (About, Contact etc.)
CREATE TABLE pages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    title VARCHAR(255) NOT NULL,
    slug VARCHAR(255) UNIQUE,
    content LONGTEXT,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Sliders / Banners
CREATE TABLE sliders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    image VARCHAR(500),
    text VARCHAR(255),
    position INT DEFAULT 0,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Orders
CREATE TABLE orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    store_user_id INT,g
    customer_name VARCHAR(255),
    customer_phone VARCHAR(20),
    customer_address TEXT,
    total DECIMAL(10,2),
    payment_method ENUM('cod','jazzcash','easypaisa') DEFAULT 'cod',
    status ENUM('pending','processing','completed','cancelled') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (store_user_id) REFERENCES users(id)
);

-- Order Items
CREATE TABLE order_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT,
    product_id INT,
    quantity INT,
    price DECIMAL(10,2),
    FOREIGN KEY (order_id) REFERENCES orders(id),
    FOREIGN KEY (product_id) REFERENCES products(id)
);

-- Reviews
CREATE TABLE reviews (
    id INT AUTO_INCREMENT PRIMARY KEY,
    product_id INT,
    customer_name VARCHAR(255),
    rating TINYINT CHECK (rating BETWEEN 1 AND 5),
    comment TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (product_id) REFERENCES products(id)
);

-- Admin default user (email: admin@mandigateway.com, password: admin123)
INSERT INTO users (business_name, full_name, phone, email, password, status, role) 
VALUES ('MandiGateway', 'Super Admin', '03001234567', 'admin@mandigateway.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'active', 'admin');
