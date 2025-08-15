<?php
require 'auth_guard.php';
include 'header.php';

// fetch external posts 
 
$posts = @file_get_contents('https://jsonplaceholder.typicode.com/posts');

$list = [];
if ($posts !== false) {
    $decoded = json_decode($posts, true);
  
    if (is_array($decoded)) {
        $list = array_slice($decoded, 0, 5); // first five
      }
      }
?>
<section>
  <h2>external Posts (first 5)</h2>
  <?php if (!$list): ?>
    <div class="alert error">could not fetch external posts.</div>
  <?php else: ?>
      <?php foreach ($list as $p): ?>
      
      <article class="post card">
     
      <h3>#<?= (int)$p['id'] ?> — <?= htmlspecialchars($p['title']) ?></h3>
     
      <p><?= nl2br(htmlspecialchars($p['body'])) ?></p>
     
    </article>
    <?php endforeach; ?>
   <?php endif; ?>
</section>
<?php include 'footer.php'; ?>
