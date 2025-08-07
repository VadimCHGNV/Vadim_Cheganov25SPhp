<?php
// start session and include configuration
session_start();
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/auth.php';

// Fetch all content for display
 $stmt = $db->prepare("SELECT id, title, body, user_id FROM content ORDER BY created_at DESC");
 $stmt->execute();
 $contents = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
   ?>

<!-- html structure for content page -->
<?php include 'includes/header.php'; ?>

<main class="container my-4">
    <section>
        <!-- content section -->
        <h1 class="text-center mb-4">Our Content</h1>
        <?php if (isLoggedIn()): ?>
            <div class="text-center mb-4">
                <a href="add.php" class="btn btn-primary">Add New Post</a>
            </div>
        <?php endif; ?>
        <!-- content disply -->
       <section class="content-grid">
    <?php if (!empty($contents)): ?>
        <?php foreach ($contents as $content): ?>
            <div class="card card-content">
                 <div class="card-header">
                  
                <h2><?php echo htmlspecialchars($content['title']); ?></h2>
                
            </div>
                <div class="card-body">
                    <p class="card-text"><?php echo nl2br(htmlspecialchars($content['body'])); ?></p>
              
                    <?php if (isLoggedIn() && isContentOwner($content['id'])): ?>
              
                        <a href="edit_content.php?id=<?php echo $content['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
              
                           <a href="delete_content.php?id=<?php echo $content['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</a>
                     <?php endif; ?>
                        </div>
                </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="card card-content text-center">
       
        <p class="text-muted">No content available.</p>
       
    </div>
   
    <?php endif; ?>
</section>
</main>

<?php include 'includes/footer.php'; ?>