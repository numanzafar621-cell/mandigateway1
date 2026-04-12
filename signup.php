<?php 
include 'config.php';

if (isset($_POST['signup'])) {
    $business_name = mysqli_real_escape_string($conn, trim($_POST['business_name']));
    $full_name     = mysqli_real_escape_string($conn, trim($_POST['full_name']));
    $phone         = mysqli_real_escape_string($conn, trim($_POST['phone']));
    $email         = mysqli_real_escape_string($conn, trim($_POST['email']));
    $password      = password_hash($_POST['password'], PASSWORD_DEFAULT);
    
    // Create subdomain slug
    $subdomain = strtolower(preg_replace('/[^a-z0-9]+/', '', $business_name));

    $check = mysqli_query($conn, "SELECT id FROM users WHERE email = '$email'");
    
    if (mysqli_num_rows($check) > 0) {
        $error = "This email is already registered!";
    } else {
        $sql = "INSERT INTO users (business_name, full_name, phone, email, password) 
                VALUES ('$business_name', '$full_name', '$phone', '$email', '$password')";
        
        if (mysqli_query($conn, $sql)) {
            $user_id = mysqli_insert_id($conn);
            
            // Create store entry
            mysqli_query($conn, "INSERT INTO stores (user_id, subdomain) VALUES ($user_id, '$subdomain')");
            
            // Set session
            $_SESSION['user_id'] = $user_id;
            $_SESSION['business_name'] = $business_name;
            $_SESSION['email'] = $email;
            
            header("Location: loading.php");
            exit();
        } else {
            $error = "Signup failed! Please try again.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="ur" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - MandiGateway</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
        }
        .signup-card {
            border-radius: 20px;
            box-shadow: 0 15px 40px rgba(0,0,0,0.2);
        }
    </style>
</head>
<body>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8">
            <div class="card signup-card p-5">
                <h2 class="text-center mb-4 text-primary">Create Your Store</h2>
                
                <?php if(isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>

                <form method="POST">
                    <div class="mb-3">
                        <label class="form-label">Business Name <small>(This will be your subdomain)</small></label>
                        <input type="text" name="business_name" class="form-control" placeholder="e.g. AlMadinaMart" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Full Name</label>
                        <input type="text" name="full_name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Phone Number (WhatsApp)</label>
                        <input type="text" name="phone" class="form-control" placeholder="03001234567" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email Address</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    
                    <button type="submit" name="signup" class="btn btn-primary w-100 btn-lg">Create My Store Now</button>
                </form>
                
                <p class="text-center mt-4">
                    Already have an account? <a href="login.php">Login Here</a>
                </p>
            </div>
        </div>
    </div>
</div>
</body>
</html>