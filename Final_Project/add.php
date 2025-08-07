<?php
// start session and include configuration
session_start();
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/auth.php';
requireLogin();

$title = $body = '';
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
      $body = trim($_POST['body']);

    // validating inputs
    if (empty($title)) $errors[] = 'Title is required';
     if (empty($body)) $errors[] = 'Body is required';

    // Insert content if no errors
    if (empty($errors)) {
         $stmt = $db->prepare("INSERT INTO content (title, body, user_id) VALUES (?, ?, ?)");
           $stmt->bind_param("ssi", $title, $body, $_SESSION['user_id']);
         if ($stmt->execute()) 
            {
              header("Location: about.php");
              exit;
         } 
            else {
               $errors[] = 'Failed to add content: ' . $db->error;
        }
          }
   }
?>

<!-- html structure for adding content -->
<?php include 'includes/header.php'; ?>

<main class="container my-4">
    <section>
        <h1>Add New Content</h1>
        <?php if (!empty($errors)): ?>
                 <div class="alert alert-danger">
                     <?php foreach ($errors as $error): ?>
                     <p><?php echo htmlspecialchars($error); ?></p>
                  <?php endforeach; ?>
                  </div>
                <?php endif; ?>
        <form method="post" class="card p-4">
            <div class="mb-3">
                <label class="form-label">Title</label>
        
                <input type="text" name="title" class="form-control" value="<?php echo htmlspecialchars($title); ?>" required>
         
            </div>
         
            <div class="mb-3">
                  <label class="form-label">Body</label>
                   <textarea name="body" class="form-control" rows="10" required><?php echo htmlspecialchars($body); ?></textarea>
            </div>
             <button type="submit" class="btn btn-primary">Submit</button>
               <a href="about.php" class="btn btn-secondary">Cancel</a>
        </form>
      </section>
</main>

<?php include 'includes/footer.php'; ?>