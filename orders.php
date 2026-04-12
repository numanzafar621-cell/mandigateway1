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
    <title>Orders</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
    <h2>My Orders</h2>
    <table class="table table-bordered">
        <thead>
            <tr><th>Order ID</th><th>Customer</th><th>Phone</th><th>Total</th><th>Status</th></tr>
        </thead>
        <tbody>
            <!-- Orders yahan PHP se show honge (abhi empty table hai, baad mein complete kar sakte hain) -->
        </tbody>
    </table>
</body>
</html>