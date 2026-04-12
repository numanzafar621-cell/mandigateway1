<?php 
include '../config.php';
if (!isset($_SESSION['user_id'])) header("Location: ../login.php");
$user_id = $_SESSION['user_id'];

$store = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM stores WHERE user_id = $user_id"));

if (isset($_POST['save_settings'])) {
    $whatsapp = mysqli_real_escape_string($conn, $_POST['whatsapp_number']);
    $position = mysqli_real_escape_string($conn, $_POST['whatsapp_position']);
    $color = mysqli_real_escape_string($conn, $_POST['header_color']);
    $banner = mysqli_real_escape_string($conn, $_POST['banner_text']);
    
    mysqli_query($conn, "UPDATE stores SET whatsapp_number='$whatsapp', whatsapp_position='$position', 
                         header_color='$color', banner_text='$banner' WHERE user_id=$user_id");
    echo "<div class='alert alert-success'>Settings Saved!</div>";
}
?>
<!DOCTYPE html>
<html lang="ur">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Store Settings</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
    <h2>Store Settings</h2>
    <form method="POST">
        <div class="mb-3">
            <label>WhatsApp Number</label>
            <input type="text" name="whatsapp_number" class="form-control" value="<?= htmlspecialchars($store['whatsapp_number']) ?>" placeholder="03001234567">
        </div>
        <div class="mb-3">
            <label>WhatsApp Button Position</label>
            <select name="whatsapp_position" class="form-control">
                <option value="floating" <?= $store['whatsapp_position']=='floating'?'selected':'' ?>>Floating (Right Bottom)</option>
                <option value="below_product" <?= $store['whatsapp_position']=='below_product'?'selected':'' ?>>Below Product</option>
                <option value="above_product" <?= $store['whatsapp_position']=='above_product'?'selected':'' ?>>Above Product</option>
            </select>
        </div>
        <div class="mb-3">
            <label>Header Color</label>
            <input type="color" name="header_color" value="<?= $store['header_color'] ?>" class="form-control form-control-color">
        </div>
        <div class="mb-3">
            <label>Banner Text</label>
            <input type="text" name="banner_text" class="form-control" value="<?= htmlspecialchars($store['banner_text']) ?>">
        </div>
        <button type="submit" name="save_settings" class="btn btn-primary">Save Settings</button>
    </form>
</body>
</html>