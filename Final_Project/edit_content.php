<?php
// start session and include configuration
session_start();
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/auth.php';
requireLogin();

$content_id = $_GET['id'] ?? 0;
$errors = [];
$content = [];

// fetch content data
$stmt = $db->prepare("SELECT id, title, body, user_id FROM content WHERE id = ?");
$stmt->bind_param("i", $content_id);
      $stmt->execute();
 $result = $stmt->get_result(); 
  $content = $result->fetch_assoc(); 

if (!$content || !isContentOwner($content_id))
     {
      $_SESSION['error'] = 'Content not found or unauthorized';
        header('Location: about.php');
          exit;
       }

// handling form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
    $title = trim($_POST['title']);
      $body = trim($_POST['body']);
    
    if (empty($title)) $errors[] = 'Title is required';
      if (empty($body)) $errors[] = 'Content is required';
    
    if (empty($errors)) 
        {
          $stmt = $db->prepare("UPDATE content SET title = ?, body = ? WHERE id = ?");
             $stmt->bind_param("ssi", $title, $body, $content_id);
        if ($stmt->execute()) {
            header('Location: about.php');
            exit;
        } 
        else {
            $errors[] = 'Update failed: ' . $db->error; }
          }
        }
?>

<!-- htm; structure for editing content -->
<?php include 'includes/header.php'; ?>

<main class="container my-4">
    <section>
         <h1>Edit Content</h1>
          <?php if (!empty($errors)): ?>
              <div class="alert alert-danger">
                <?php foreach ($errors as $error): ?>
                    <p>
                        <?php echo htmlspecialchars($error); ?>
                    </p>
                 <?php endforeach; ?>
               </div>
        <?php endif; ?>
            <form method="POST">
            <div class="mb-3">
                     <label for="title" class="form-label">Title</label>
                        <input type="text" class="form-control" id="title" name="title" 
                             value="<?php echo htmlspecialchars($content['title']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="body" class="form-label">Content</label>
                 <textarea class="form-control" id="body" name="body" rows="10" required><?php 
                    echo htmlspecialchars($content['body']); ?></textarea>
             </div>
       
             <button type="submit" name="update" class="btn btn-primary">Update</button>
       
            <a href="about.php" class="btn btn-secondary">Cancel</a>
            </form>
               </section>
  </main>

<?php include 'includes/footer.php'; ?>