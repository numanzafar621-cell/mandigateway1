<?php 
include 'config.php'; 

if (isset($_POST['login'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $pass = $_POST['password'];
    
    $q = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
    if ($row = mysqli_fetch_assoc($q)) {
        if (password_verify($pass, $row['password'])) {
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['email'] = $row['email'];
            $_SESSION['business_name'] = $row['business_name'];
            
            // Agar active hai to dashboard, warna loading
            if ($row['status'] == 'active') {
                header("Location: dashboard/index.php");
            } else {
                header("Location: loading.php");
            }
            exit();
        } else {
            $error = "Wrong password!";
        }
    } else {
        $error = "Email not found!";
    }
}
?>
<!DOCTYPE html>
<html lang="ur" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - MandiGateway</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 100vh; }
        .card { border-radius: 20px; box-shadow: 0 15px 35px rgba(0,0,0,0.2); }
    </style>
</head>
<body class="d-flex align-items-center">
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card p-5">
                <h2 class="text-center mb-4 text-primary">Welcome Back!</h2>
                <?php if(isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
                <form method="POST">
                    <div class="mb-3">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <button type="submit" name="login" class="btn btn-primary w-100">Login to Dashboard</button>
                </form>
                <p class="text-center mt-3">New here? <a href="signup.php">Create Store</a></p>
            </div>
        </div>
    </div>
</div>
</body>
</html>