<?php 
include '../config.php';
if (!isset($_SESSION['user_id'])) header("Location: ../login.php");

$user = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM users WHERE id = ".$_SESSION['user_id']));
if ($user['role'] != 'admin') { die("Access Denied"); }

if (isset($_GET['activate'])) {
    $id = intval($_GET['activate']);
    mysqli_query($conn, "UPDATE users SET status='active' WHERE id=$id");
    echo "<div class='alert alert-success'>User Activated Successfully!</div>";
}

if (isset($_GET['suspend'])) {
    $id = intval($_GET['suspend']);
    mysqli_query($conn, "UPDATE users SET status='suspended' WHERE id=$id");
    echo "<div class='alert alert-warning'>User Suspended!</div>";
}
?>
<!DOCTYPE html>
<html lang="ur">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Users - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
    <h2>All Users & Stores</h2>
    <table class="table table-bordered table-hover">
        <thead class="table-dark">
            <tr>
                <th>Business Name</th>
                <th>Full Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Subdomain</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $result = mysqli_query($conn, "SELECT u.*, s.subdomain FROM users u LEFT JOIN stores s ON u.id = s.user_id ORDER BY u.id DESC");
            while($row = mysqli_fetch_assoc($result)) {
                $status_color = $row['status'] == 'active' ? 'success' : ($row['status'] == 'pending' ? 'warning' : 'danger');
                echo "<tr>
                    <td>".htmlspecialchars($row['business_name'])."</td>
                    <td>".htmlspecialchars($row['full_name'])."</td>
                    <td>".htmlspecialchars($row['email'])."</td>
                    <td>".$row['phone']."</td>
                    <td><strong>".$row['subdomain'].".mandigateway.com</strong></td>
                    <td><span class='badge bg-".$status_color."'>".$row['status']."</span></td>
                    <td>
                        <a href='?activate=".$row['id']."' class='btn btn-sm btn-success'>Activate</a>
                        <a href='?suspend=".$row['id']."' class='btn btn-sm btn-warning'>Suspend</a>
                        <a href='../dashboard/index.php' class='btn btn-sm btn-info' target='_blank'>View Dashboard</a>
                    </td>
                </tr>";
            }
            ?>
        </tbody>
    </table>
</body>
</html>