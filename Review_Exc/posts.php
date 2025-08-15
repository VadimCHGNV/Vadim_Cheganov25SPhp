<?php
require 'auth_guard.php';
require 'db.php';

// fetch all posts
$stmt = $pdo->query("SELECT * FROM posts ORDER BY created_at DESC");
$posts = $stmt->fetchAll();
include 'header.php';
?>
<section>
  <h2>All Posts</h2>

  <?php if (!$posts): ?>
    <p>No posts yet. <a href="create_post.php">Create first one</a>.</p>
  <?php endif; ?>

  <?php foreach ($posts as $post): ?>
   
    <article class="post card">
      <div class="post-header">
        
      <h3><?= htmlspecialchars($post['title']) ?></h3>
          <small><?= htmlspecialchars($post['created_at']) ?></small>
      </div>
      
      <?php if (!empty($post['image'])): ?>
  
        <img class="post-image" src="uploads/<?= htmlspecialchars($post['image']) ?>" alt="">
      <?php endif; ?>

      <p><?= nl2br(htmlspecialchars($post['content'])) ?></p>

      <div class="actions">
        
      <a class="btn" href="edit_post.php?id=<?= (int)$post['id'] ?>">Edit</a>
        <a class="btn danger" href="delete_post.php?id=<?= (int)$post['id'] ?>" onclick="return confirm('Delete this post?')">Delete</a>
       </div>
      </article>
    <?php endforeach; ?>
</section>
<?php include 'footer.php'; ?>
