<?php 
include '../config.php';
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php"); exit();
}

$user = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM users WHERE id = ".$_SESSION['user_id']));
if ($user['role'] != 'admin') {
    echo "Access Denied! Only Admin Allowed.";
    exit();
}
?>
<!DOCTYPE html>
<html lang="ur">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - MandiGateway</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <style>
        body { background: #f8f9fa; }
        .sidebar { background: #212529; color: white; min-height: 100vh; }
    </style>
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-3 sidebar p-3">
            <h3 class="text-center mb-4">Admin Panel</h3>
            <hr>
            <ul class="nav flex-column">
                <li class="nav-item"><a href="index.php" class="nav-link text-white active"><i class="fas fa-home"></i> Dashboard</a></li>
                <li class="nav-item"><a href="users.php" class="nav-link text-white"><i class="fas fa-users"></i> All Users & Stores</a></li>
                <li class="nav-item"><a href="../index.php" class="nav-link text-white"><i class="fas fa-globe"></i> Visit Main Site</a></li>
                <li class="nav-item"><a href="../dashboard/logout.php" class="nav-link text-danger"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
            </ul>
        </div>

        <!-- Content -->
        <div class="col-md-9 p-4">
            <h2>Welcome Super Admin</h2>
            <div class="row mt-4">
                <div class="col-md-4">
                    <div class="card text-center p-4">
                        <h5>Total Users</h5>
                        <h2>
                            <?php 
                            $total = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as c FROM users"));
                            echo $total['c'];
                            ?>
                        </h2>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card text-center p-4">
                        <h5>Active Stores</h5>
                        <h2>
                            <?php 
                            $active = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as c FROM users WHERE status='active'"));
                            echo $active['c'];
                            ?>
                        </h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>