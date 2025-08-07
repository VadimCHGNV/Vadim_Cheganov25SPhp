<?php
  // start session and include configuration
  session_start();
  require_once __DIR__ . '/includes/config.php';

  // fetch latest content for display
  $stmt = $db->prepare("SELECT id, title, body FROM content ORDER BY created_at DESC LIMIT 3");
  $stmt->execute();
  $contents = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
  ?>

  <!-- html structure  for home page -->
  <?php include 'includes/header.php'; ?>

  <main class="container my-4">
      <section>
                  <!-- welcome message -->
          <h1 class="text-center mb-4">Welcome to Final Project</h1>
          <?php if (!empty($contents)): ?>
                <?php foreach ($contents as $content): ?>
                  
                    <div class="card mb-3">
                   
                    <div class="card-header">
                  
                      <h2><?php echo htmlspecialchars($content['title']); ?></h2>
                  
                    </div>
                  
                       <div class="card-body">
                  
                    <p class="card-text"><?php echo nl2br(htmlspecialchars($content['body'])); ?></p>
                  
                </div>
                    </div>
                <?php endforeach; ?>
          <?php else: ?>
               <p class="text-muted">No content available.</p>
            <?php endif; ?>
            <div class="text-center">
                   <a href="content.php" class="btn btn-primary">View All Posts</a>
            </div>
        </section>
    </main>

     <?php include 'includes/footer.php'; ?>