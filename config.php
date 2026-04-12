<?php
// config.php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database Configuration
$host     = "localhost";
$dbname   = "mandigateway_db";
$username = "root";           // اپنی hosting کے مطابق تبدیل کریں
$password = "";               // اپنی hosting کے مطابق تبدیل کریں

$conn = mysqli_connect($host, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Important Constants
define('BASE_URL', 'http://localhost/mandigateway/');  // Live server پر تبدیل کریں
define('UPLOAD_DIR', 'uploads/');

// Create uploads folder if not exists
if (!is_dir(UPLOAD_DIR)) {
    mkdir(UPLOAD_DIR, 0777, true);
}

// Function to detect subdomain (Store)
function getCurrentStore() {
    global $conn;
    $host = $_SERVER['HTTP_HOST'];
    $parts = explode('.', $host);
    
    if (count($parts) >= 3) {
        $subdomain = $parts[0];
        $query = "SELECT s.*, u.* FROM stores s 
                  JOIN users u ON s.user_id = u.id 
                  WHERE s.subdomain = '$subdomain' AND u.status = 'active'";
        $result = mysqli_query($conn, $query);
        if (mysqli_num_rows($result) > 0) {
            return mysqli_fetch_assoc($result);
        }
    }
    return false; // Main website
}
?>