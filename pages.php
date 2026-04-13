<?php 
include '../config.php';
if (!isset($_SESSION['user_id'])) header("Location: ../login.php");
$user_id = $_SESSION['user_id'];

// صفحہ محفوظ کرنے کا عمل
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['save_page'])) {
    $title = trim($_POST['title']);
    $slug = trim($_POST['slug']);
    $content = $_POST['content'];
    
    // slug کو صاف کریں (صرف حروف، اعداد اور ڈیش)
    $slug = preg_replace('/[^a-z0-9-]/', '-', strtolower($slug));
    $slug = preg_replace('/-+/', '-', $slug);
    $slug = trim($slug, '-');
    
    if (!empty($title) && !empty($slug)) {
        // چیک کریں کہ slug پہلے سے موجود تو نہیں
        $check = $conn->prepare("SELECT id FROM pages WHERE slug = ?");
        $check->bind_param("s", $slug);
        $check->execute();
        $check->store_result();
        if ($check->num_rows > 0) {
            $error = "اس slug کے ساتھ ایک صفحہ پہلے سے موجود ہے۔";
        } else {
            $stmt = $conn->prepare("INSERT INTO pages (title, slug, content) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $title, $slug, $content);
            if ($stmt->execute()) {
                $success = "صفحہ کامیابی سے شائع ہو گیا۔";
            } else {
                $error = "ڈیٹابیس میں خرابی: " . $conn->error;
            }
        }
    } else {
        $error = "عنوان اور URL ضروری ہیں۔";
    }
}

// تمام صفحات حاصل کریں
$pages_result = $conn->query("SELECT id, title, slug, created_at FROM pages ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="ur">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pages - Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- TinyMCE CDN with your API Key -->
    <script src="https://cdn.tiny.cloud/1/tly0fhhrzhrjjcsvbk27vdmzaycv39pg4hya50g0k2y2pc6g/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
        tinymce.init({
            selector: '#content',
            height: 500,
            plugins: 'link image lists table code',
            toolbar: 'undo redo | blocks | bold italic | alignleft aligncenter alignright | bullist numlist | link image | code',
            menubar: 'file edit view insert format table tools',
            // مزید ترتیبات اگر چاہیں
            branding: false,
            promotion: false
        });
    </script>
</head>
<body class="p-4">
    <div class="container">
        <h2>Manage Pages (About, Contact, Custom)</h2>
        
        <?php if(isset($success)): ?>
            <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
        <?php endif; ?>
        <?php if(isset($error)): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        
        <form method="POST">
            <div class="mb-3">
                <label>Page Title</label>
                <input type="text" name="title" class="form-control" placeholder="Page Title (e.g. About Us)" required>
            </div>
            <div class="mb-3">
                <label>URL Slug</label>
                <input type="text" name="slug" class="form-control" placeholder="URL Slug (e.g. about-us)" required>
                <small class="text-muted">صرف چھوٹے حروف، اعداد اور ڈیش استعمال کریں۔</small>
            </div>
            <div class="mb-3">
                <label>Page Content</label>
                <textarea id="content" name="content"></textarea>
            </div>
            <button type="submit" name="save_page" class="btn btn-primary">Save Page</button>
        </form>

        <!-- Saved Pages List -->
        <h4 class="mt-5">Existing Pages</h4>
        <table class="table table-bordered">
            <thead>
                <tr><th>ID</th><th>Title</th><th>Slug</th><th>Created</th><th>Actions</th></tr>
            </thead>
            <tbody>
                <?php while($page = $pages_result->fetch_assoc()): ?>
                <tr>
                    <td><?= $page['id'] ?></td>
                    <td><?= htmlspecialchars($page['title']) ?></td>
                    <td><?= htmlspecialchars($page['slug']) ?></td>
                    <td><?= $page['created_at'] ?></td>
                    <td>
                        <a href="edit_page.php?id=<?= $page['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                        <a href="delete_page.php?id=<?= $page['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete this page?')">Delete</a>
                    </td>
                </tr>
                <?php endwhile; ?>
                <?php if($pages_result->num_rows == 0): ?>
                <tr><td colspan="5" class="text-center">No pages yet.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
