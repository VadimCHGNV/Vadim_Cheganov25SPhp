<?php
require 'auth_guard.php';
require 'db.php';

$id = (int)($_GET['id'] ?? 0);
if ($id <= 0) { header("Location: posts.php"); exit; }

// fetch existing post
$stmt = $pdo->prepare("SELECT * FROM posts WHERE id = ?");
  $stmt->execute([$id]);
  $post = $stmt->fetch();
   if (!$post) { die("Post not found."); }

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
     $title = trim($_POST['title'] ?? '');
      $content = trim($_POST['content'] ?? '');
      $imageName = $post['image']; 

    if ($title === '' || $content === '') {
        $error = "Title and Content are required.";
    } 
    else {
        if (!empty($_FILES['image']['name'])) {
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
                  $newName = time() . '_' . bin2hex(random_bytes(4)) . '.' . $ext;
                  $target = __DIR__ . "/uploads/" . $newName;
                if (!move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
                   $error = "Failed to upload image.";
                 } 
                 else {
                    $imageName = $newName;
                  }
            }
        }

        if ($error === "") {
             $stmt = $pdo->prepare("UPDATE posts SET title = ?, content = ?, image = ? WHERE id = ?");
             $stmt->execute([$title, $content, $imageName, $id]);
              header("Location: posts.php");
             exit;
        }
    }
}

include 'header.php';
?>
<section class="card">
  <h2>Edit Post</h2>
  
    <?php if ($error): ?><div class="alert error"><?= htmlspecialchars($error) ?></div><?php endif; ?>
  
    <form method="post" enctype="multipart/form-data" class="form">
    <label>Title
     
    <input type="text" name="title" value="<?= htmlspecialchars($post['title']) ?>" required>
    
    </label>
    <label>Content
        <textarea name="content" rows="6" required><?= htmlspecialchars($post['content']) ?></textarea>
    </label>
       <label>Replace Image (optional)
        <input type="file" name="image" accept="image/*">
    </label>
    <?php if ($post['image']): ?>
      <div class="thumb-wrap">
    
         <img class="thumb" src="uploads/<?= htmlspecialchars($post['image']) ?>" alt="">
       
    </div>
    <?php endif; ?>
     <button type="submit">Update</button>
    </form>
</section>
<?php include 'footer.php'; ?>
