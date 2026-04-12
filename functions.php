<?php
// includes/functions.php
function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

function getUserData($user_id) {
    global $conn;
    $q = mysqli_query($conn, "SELECT * FROM users WHERE id = $user_id");
    return mysqli_fetch_assoc($q);
}

function uploadImage($file) {
    $target_dir = "../uploads/";
    $new_name = time() . "_" . basename($file["name"]);
    $target_file = $target_dir . $new_name;
    if (move_uploaded_file($file["tmp_name"], $target_file)) {
        return "uploads/" . $new_name;
    }
    return "";
}
?>