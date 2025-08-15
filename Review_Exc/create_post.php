<?php
require 'auth_guard.php';
require 'db.php';

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $content = trim($_POST['content'] ?? '');
    $imageName = null;

    if ($title === '' || $content === '') {
         $error = "Title and Content are required.";
      }

    // validation and uploading image
    if ($error === "" && !empty($_FILES['image']['name'])) {
        $allowed = ['image/jpeg' => 'jpg', 'image/png' => 'png', 'image/gif' => 'gif'];
          $type = mime_content_type($_FILES['image']['tmp_name']);
          $size = (int)$_FILES['image']['size'];

        if (!isset($allowed[$type])) {
            $error = "Invalid image type. Use JPG, PNG, or GIF.";
        } 
             elseif ($size > 2 * 1024 * 1024) {
                $error = "Image is too large (max 2MB).";
        } 
           else {
              $ext = $allowed[$type];
              $imageName = time() . '_' . bin2hex(random_bytes(4)) . '.' . $ext;
                 $target = __DIR__ . "/uploads/" . $imageName;
                if (!move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
                      $error = "Failed to upload image.";
                  }
        }
    }

    // importn in db
    if ($error === "") {
        $stmt = $pdo->prepare("INSERT INTO posts (title, content, image) VALUES (?, ?, ?)");
        $stmt->execute([$title, $content, $imageName]);
        header("Location: posts.php");
        exit;
    }
}

include 'header.php';
?>
<section class="card">
  <h2>Create Post</h2>
  <?php if ($error): ?><div class="alert error"><?= htmlspecialchars($error) ?></div><?php endif; ?>
  
    <form method="post" enctype="multipart/form-data" class="form">
    
  <label>Title
      <input type="text" name="title" required>
    </label>
    <label>Content
        <textarea name="content" rows="6" required></textarea>
    </label>
   
    <label>Image (optional)
       <input type="file" name="image" accept="image/*">
     </label>
      <button type="submit">Save</button>
    
    </form>
</section>
<?php include 'footer.php'; ?>