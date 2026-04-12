<?php 
include 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$business_name = $_SESSION['business_name'] ?? 'Your Store';
?>

<!DOCTYPE html>
<html lang="ur" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome - MandiGateway</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', sans-serif;
            color: white;
        }
        .loader-box {
            text-align: center;
        }
        .brand {
            font-size: 42px;
            font-weight: bold;
            margin-bottom: 10px;
            animation: fadeIn 1.5s;
        }
        .spinner {
            width: 60px;
            height: 60px;
            border: 5px solid rgba(255,255,255,0.3);
            border-top: 5px solid white;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin: 20px auto;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
    </style>
</head>
<body>
    <div class="loader-box">
        <div class="brand">MandiGateway</div>
        <h4>Welcome, <?= htmlspecialchars($business_name) ?>!</h4>
        <p>Setting up your professional store...</p>
        <div class="spinner"></div>
        <small>Almost there...</small>
    </div>

    <script>
        // 3 سیکنڈ بعد ڈیش بورڈ پر جائیں
        setTimeout(() => {
            window.location.href = "dashboard/index.php";
        }, 2800);
    </script>
</body>
</html>