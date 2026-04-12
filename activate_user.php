<?php 
include '../config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php"); 
    exit();
}

// چیک کریں کہ لاگ ان کرنے والا Admin ہے
$admin = mysqli_fetch_assoc(mysqli_query($conn, "SELECT role FROM users WHERE id = ".$_SESSION['user_id']));
if ($admin['role'] != 'admin') {
    die("Access Denied! Only Admin can activate users.");
}

if (isset($_GET['id'])) {
    $user_id = intval($_GET['id']);
    
    $result = mysqli_query($conn, "UPDATE users SET status = 'active' WHERE id = $user_id");
    
    if ($result) {
        echo "<div class='alert alert-success text-center mt-5'>✅ User Activated Successfully!</div>";
        echo "<div class='text-center mt-3'><a href='users.php' class='btn btn-primary'>Back to All Users</a></div>";
    } else {
        echo "<div class='alert alert-danger text-center mt-5'>Error Occurred!</div>";
    }
} else {
    echo "<div class='alert alert-danger text-center mt-5'>Invalid Request!</div>";
}
?>